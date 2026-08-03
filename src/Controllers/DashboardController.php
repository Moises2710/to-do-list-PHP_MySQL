<?php

namespace App\Controllers;

use App\Models\User;

class DashboardController
{
    /**
     * Render User Dashboard
     */
    public function index()
    {
        // Authentication Guard
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_error'] = "You must be signed in to access the dashboard.";
            header('Location: /signin');
            exit;
        }

        $pageTitle = "Dashboard - Coronado To do List";
        
        $user = [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'] ?? 'User',
            'email' => $_SESSION['user_email'] ?? '',
        ];

        ob_start();
        require __DIR__ . '/../Views/dashboard/index.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layouts/main.php';
    }
}
