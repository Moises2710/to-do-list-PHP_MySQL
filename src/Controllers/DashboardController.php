<?php

namespace App\Controllers;

use App\Models\Task;

class DashboardController
{
    /**
     * Render User Dashboard
     * 
     * @return void
     */
    public function index(): void
    {
        // Authentication Guard
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_error'] = "You must be signed in to access the dashboard.";
            header('Location: /signin');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];
        $pageTitle = "Dashboard - To do List";

        $user = [
            'id' => $userId,
            'name' => $_SESSION['user_name'] ?? 'User',
            'email' => $_SESSION['user_email'] ?? '',
        ];

        // Fetch user tasks & metrics
        $tasks = Task::getByUserId($userId);
        $metrics = Task::getMetrics($userId);

        ob_start();
        require __DIR__ . '/../Views/dashboard/index.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layouts/app.php';
    }
}
