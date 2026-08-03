<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    /**
     * Render the Sign Up page
     */
    public function signUp()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }

        $pageTitle = "Sign Up - Coronado To do List";
        $error = $_SESSION['flash_error'] ?? null;
        $old = $_SESSION['flash_old'] ?? [];
        
        unset($_SESSION['flash_error'], $_SESSION['flash_old']);

        ob_start();
        require __DIR__ . '/../Views/auth/signup.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layouts/main.php';
    }

    /**
     * Handle Sign Up user creation logic
     */
    public function register()
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $_SESSION['flash_old'] = ['name' => $name, 'email' => $email];

        // Validation checks
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['flash_error'] = "All fields are required.";
            header('Location: /signup');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = "Please provide a valid email address.";
            header('Location: /signup');
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['flash_error'] = "Password must be at least 6 characters long.";
            header('Location: /signup');
            exit;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['flash_error'] = "Passwords do not match.";
            header('Location: /signup');
            exit;
        }

        try {
            // Check if user already exists
            $existingUser = User::findByEmail($email);
            if ($existingUser) {
                $_SESSION['flash_error'] = "An account with this email already exists.";
                header('Location: /signup');
                exit;
            }

            // Create user
            $userId = User::register($name, $email, $password);

            // Log user in automatically
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;

            unset($_SESSION['flash_old']);

            header('Location: /dashboard');
            exit;
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = "Database connection error: Unable to create account right now.";
            header('Location: /signup');
            exit;
        }
    }

    /**
     * Render the Sign In page
     */
    public function signIn()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }

        $pageTitle = "Sign In - Coronado To do List";
        $error = $_SESSION['flash_error'] ?? null;
        $success = $_SESSION['flash_success'] ?? null;
        $old = $_SESSION['flash_old'] ?? [];
        
        unset($_SESSION['flash_error'], $_SESSION['flash_success'], $_SESSION['flash_old']);

        ob_start();
        require __DIR__ . '/../Views/auth/signin.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layouts/main.php';
    }

    /**
     * Handle Sign In authentication
     */
    public function login()
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $_SESSION['flash_old'] = ['email' => $email];

        if (empty($email) || empty($password)) {
            $_SESSION['flash_error'] = "Please enter your email and password.";
            header('Location: /signin');
            exit;
        }

        try {
            $user = User::findByEmail($email);

            if (!$user || !User::verifyPassword($password, $user['password'])) {
                $_SESSION['flash_error'] = "Invalid email or password.";
                header('Location: /signin');
                exit;
            }

            // Authentication successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            unset($_SESSION['flash_old']);

            header('Location: /dashboard');
            exit;
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = "Database connection error: Unable to authenticate right now.";
            header('Location: /signin');
            exit;
        }
    }

    /**
     * Handle Logout
     */
    public function logout()
    {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email']);
        session_destroy();
        
        header('Location: /');
        exit;
    }
}
