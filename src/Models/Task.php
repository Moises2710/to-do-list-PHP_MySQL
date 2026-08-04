<?php

namespace App\Models;

use App\Core\Database;

class Task extends Model
{
    protected static string $table = 'tasks';

    /**
     * Retrieve tasks for a specific user, optionally filtered by status
     *
     * @param int $userId
     * @param string|null $status
     * @return array
     */
    public static function getByUserId(int $userId, ?string $status = null): array
    {
        $table = static::$table;
        
        if (!empty($status) && in_array($status, ['pending', 'in_progress', 'completed'])) {
            $sql = "SELECT * FROM `{$table}` WHERE `user_id` = :user_id AND `status` = :status ORDER BY `due_date` IS NULL ASC, `due_date` ASC, `id` DESC";
            $stmt = static::db()->prepare($sql);
            $stmt->execute(['user_id' => $userId, 'status' => $status]);
        } else {
            $sql = "SELECT * FROM `{$table}` WHERE `user_id` = :user_id ORDER BY `due_date` IS NULL ASC, `due_date` ASC, `id` DESC";
            $stmt = static::db()->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
        }

        return $stmt->fetchAll();
    }

    /**
     * Calculate task metrics for a user
     *
     * @param int $userId
     * @return array
     */
    public static function getMetrics(int $userId): array
    {
        $table = static::$table;
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN `status` = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN `status` = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
                    SUM(CASE WHEN `status` = 'completed' THEN 1 ELSE 0 END) as completed
                FROM `{$table}` 
                WHERE `user_id` = :user_id";

        $stmt = static::db()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $row = $stmt->fetch();

        return [
            'total' => (int) ($row['total'] ?? 0),
            'pending' => (int) ($row['pending'] ?? 0),
            'in_progress' => (int) ($row['in_progress'] ?? 0),
            'completed' => (int) ($row['completed'] ?? 0),
        ];
    }

    /**
     * Check if a task belongs to a specific user
     *
     * @param int $userId
     * @param int $taskId
     * @return bool
     */
    public static function ownsTask(int $userId, int $taskId): bool
    {
        $task = static::find($taskId);
        return $task && (int)$task['user_id'] === $userId;
    }
}
