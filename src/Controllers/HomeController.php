<?php

namespace App\Controllers;

class HomeController
{
    /**
     * Display the home page with all the tasks.
     * @return void
     */
    public function index()
    {
        $pageTitle = "Coronado To do List - Organize Your Day";

        // Output buffering to capture view
        ob_start();
        require __DIR__ . '/../Views/home/index.php';
        $content = ob_get_clean();

        // Render main page
        require __DIR__ . '/../Views/layouts/main.php';
    }
}
