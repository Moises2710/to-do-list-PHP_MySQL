<?php

namespace App\Controllers;

use App\Models\Task;

class TaskController
{

    /**
     * Create a new task (POST /tasks)
     * 
     * @return void
     */
    public function store(): void
    {
        $userId = $this->requireAuth();

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $priority = $_POST['priority'] ?? 'medium';
        $dueDate = $_POST['due_date'] ?? null;

        if (empty($title)) {
            $this->jsonResponse(false, 'Task title is required.', [], 400);
        }

        if (!in_array($priority, ['low', 'medium', 'high'])) {
            $priority = 'medium';
        }

        $dueDateValue = !empty($dueDate) ? $dueDate : null;

        try {
            $taskId = Task::create([
                'user_id' => $userId,
                'title' => $title,
                'description' => $description,
                'priority' => $priority,
                'status' => 'pending',
                'due_date' => $dueDateValue,
            ]);

            $task = Task::find($taskId);
            $metrics = Task::getMetrics($userId);

            $this->jsonResponse(true, 'Task created successfully!', ['task' => $task, 'metrics' => $metrics]);
        } catch (\Exception $e) {
            $this->jsonResponse(false, 'Failed to create task: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Update task status (POST /tasks/update-status)
     *
     * @return void
     */
    public function updateStatus(): void
    {
        $userId = $this->requireAuth();

        $taskId = (int) ($_POST['task_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if (!$taskId || !in_array($status, ['pending', 'in_progress', 'completed'])) {
            $this->jsonResponse(false, 'Invalid task status payload.', [], 400);
        }

        if (!Task::ownsTask($userId, $taskId)) {
            $this->jsonResponse(false, 'Permission denied.', [], 403);
        }

        try {
            Task::update($taskId, ['status' => $status]);
            $task = Task::find($taskId);
            $metrics = Task::getMetrics($userId);

            $this->jsonResponse(true, 'Task status updated.', ['task' => $task, 'metrics' => $metrics]);
        } catch (\Exception $e) {
            $this->jsonResponse(false, 'Failed to update task status.', [], 500);
        }
    }

    /**
     * Edit task details (POST /tasks/edit)
     *
     * @return void
     */
    public function update(): void
    {
        $userId = $this->requireAuth();

        $taskId = (int) ($_POST['task_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $priority = $_POST['priority'] ?? 'medium';
        $status = $_POST['status'] ?? 'pending';
        $dueDate = $_POST['due_date'] ?? null;

        if (!$taskId || empty($title)) {
            $this->jsonResponse(false, 'Task ID and Title are required.', [], 400);
        }

        if (!Task::ownsTask($userId, $taskId)) {
            $this->jsonResponse(false, 'Permission denied.', [], 403);
        }

        if (!in_array($priority, ['low', 'medium', 'high'])) {
            $priority = 'medium';
        }

        if (!in_array($status, ['pending', 'in_progress', 'completed'])) {
            $status = 'pending';
        }

        $dueDateValue = !empty($dueDate) ? $dueDate : null;

        try {
            Task::update($taskId, [
                'title' => $title,
                'description' => $description,
                'priority' => $priority,
                'status' => $status,
                'due_date' => $dueDateValue,
            ]);

            $task = Task::find($taskId);
            $metrics = Task::getMetrics($userId);

            $this->jsonResponse(true, 'Task updated successfully!', ['task' => $task, 'metrics' => $metrics]);
        } catch (\Exception $e) {
            $this->jsonResponse(false, 'Failed to update task.', [], 500);
        }
    }

    /**
     * Delete task (POST /tasks/delete)
     *
     * @return void
     */
    public function delete(): void
    {
        $userId = $this->requireAuth();

        $taskId = (int) ($_POST['task_id'] ?? 0);

        if (!$taskId) {
            $this->jsonResponse(false, 'Invalid task ID.', [], 400);
        }

        if (!Task::ownsTask($userId, $taskId)) {
            $this->jsonResponse(false, 'Permission denied.', [], 403);
        }

        try {
            Task::delete($taskId);
            $metrics = Task::getMetrics($userId);

            $this->jsonResponse(true, 'Task deleted successfully.', ['metrics' => $metrics]);
        } catch (\Exception $e) {
            $this->jsonResponse(false, 'Failed to delete task.', [], 500);
        }
    }

    /**
     * Send a JSON response and terminate
     * 
     * @return void
     */
    private function jsonResponse(bool $success, string $message = '', array $data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
        exit;
    }

    /**
     * Ensure user is authenticated
     * 
     * @return int
     */
    private function requireAuth(): int
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(false, 'Unauthorized. Please sign in.', [], 401);
        }
        return (int) $_SESSION['user_id'];
    }
}
