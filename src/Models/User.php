<?php

namespace App\Models;

class User extends Model
{
    /**
     * Associated database table
     */
    protected static string $table = 'users';

    /**
     * Find a user by their email address.
     *
     * @param string $email
     * @return array|null
     */
    public static function findByEmail(string $email): ?array
    {
        $users = static::where('email', $email);
        return !empty($users) ? $users[0] : null;
    }

    /**
     * Register a new user with password hashing.
     *
     * @param string $name
     * @param string $email
     * @param string $password Raw plain text password
     * @return string|int Inserted user ID
     */
    public static function register(string $name, string $email, string $password): string|int
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
        ]);
    }

    /**
     * Verify plain text password against stored hash.
     *
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
