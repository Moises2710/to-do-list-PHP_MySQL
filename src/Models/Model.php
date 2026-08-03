<?php

namespace App\Models;

use App\Core\Database;
use PDO;

abstract class Model
{
    /**
     * Database table name associated with the model.
     * Must be declared in extending child models.
     */
    protected static string $table;

    /**
     * Primary key column name.
     */
    protected static string $primaryKey = 'id';

    /**
     * Get PDO connection instance
     */
    protected static function db(): PDO
    {
        return Database::getConnection();
    }

    /**
     * Fetch all records from the table.
     *
     * @return array
     */
    public static function all(): array
    {
        $table = static::$table;
        $stmt = static::db()->query("SELECT * FROM `{$table}`");
        return $stmt->fetchAll();
    }

    /**
     * Find a single record by primary key.
     *
     * @param mixed $id
     * @return array|null
     */
    public static function find(mixed $id): ?array
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;
        
        $stmt = static::db()->prepare("SELECT * FROM `{$table}` WHERE `{$primaryKey}` = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Fetch records matching column and value condition.
     *
     * @param string $column
     * @param mixed $value
     * @param string $operator
     * @return array
     */
    public static function where(string $column, mixed $value, string $operator = '='): array
    {
        $table = static::$table;
        // Escape column identifier safely
        $columnClean = str_replace('`', '', $column);
        
        $sql = "SELECT * FROM `{$table}` WHERE `{$columnClean}` {$operator} :value";
        $stmt = static::db()->prepare($sql);
        $stmt->execute(['value' => $value]);
        
        return $stmt->fetchAll();
    }

    /**
     * Insert a new record into the table.
     *
     * @param array $data Key-value pairs matching column names.
     * @return string|int ID of the inserted record.
     */
    public static function create(array $data): string|int
    {
        $table = static::$table;
        $columns = array_keys($data);
        
        $columnList = implode(', ', array_map(fn($col) => "`" . str_replace('`', '', $col) . "`", $columns));
        $paramList = implode(', ', array_map(fn($col) => ":" . $col, $columns));

        $sql = "INSERT INTO `{$table}` ({$columnList}) VALUES ({$paramList})";
        $stmt = static::db()->prepare($sql);
        $stmt->execute($data);

        return static::db()->lastInsertId();
    }

    /**
     * Update an existing record by primary key.
     *
     * @param mixed $id
     * @param array $data Key-value pairs to update.
     * @return bool
     */
    public static function update(mixed $id, array $data): bool
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;
        
        $setClauses = [];
        $params = [':pk_id' => $id];

        foreach ($data as $column => $value) {
            $colClean = str_replace('`', '', $column);
            $setClauses[] = "`{$colClean}` = :param_{$colClean}";
            $params[":param_{$colClean}"] = $value;
        }

        $setString = implode(', ', $setClauses);
        $sql = "UPDATE `{$table}` SET {$setString} WHERE `{$primaryKey}` = :pk_id";

        $stmt = static::db()->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Delete a record by primary key.
     *
     * @param mixed $id
     * @return bool
     */
    public static function delete(mixed $id): bool
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;

        $stmt = static::db()->prepare("DELETE FROM `{$table}` WHERE `{$primaryKey}` = :id");
        return $stmt->execute(['id' => $id]);
    }
}
