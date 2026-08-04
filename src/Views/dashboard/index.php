<div class="container-fluid px-4 px-lg-5 py-4">
    <div id="alertContainer" class="mb-4"></div>
    <div class="card border-0 shadow-sm rounded-4 text-white mb-4 p-4 position-relative overflow-hidden" style="background: var(--primary-gradient) !important;">
        <div class="d-flex justify-content-between align-items-center position-relative z-1">
            <div>
                <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-bold mb-2">Personal Workspace</span>
                <h1 class="display-5 fw-bold mb-1">Welcome back, <?= htmlspecialchars($user['name']); ?>!</h1>
                <p class="mb-0 text-white-50 fs-5"><i class="bi bi-envelope me-2"></i><?= htmlspecialchars($user['email']); ?></p>
            </div>
            <div class="d-none d-md-block text-end">
                <button class="btn btn-light btn-lg rounded-pill px-4 fw-bold shadow-sm text-primary" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                    <i class="bi bi-plus-circle-fill me-2"></i> Add New Task
                </button>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-primary-subtle text-primary rounded-3">
                        <i class="bi bi-list-task fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold fs-7">Total Tasks</h6>
                        <h3 id="metricTotal" class="fw-bold mb-0 text-dark"><?= $metrics['total'] ?? 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-warning-subtle text-warning rounded-3">
                        <i class="bi bi-clock-history fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold fs-7">Pending</h6>
                        <h3 id="metricPending" class="fw-bold mb-0 text-dark"><?= $metrics['pending'] ?? 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-info-subtle text-info rounded-3">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold fs-7">In Progress</h6>
                        <h3 id="metricInProgress" class="fw-bold mb-0 text-dark"><?= $metrics['in_progress'] ?? 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-success-subtle text-success rounded-3">
                        <i class="bi bi-check-circle fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold fs-7">Completed</h6>
                        <h3 id="metricCompleted" class="fw-bold mb-0 text-dark"><?= $metrics['completed'] ?? 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-text me-2 text-primary"></i> My Tasks</h4>

            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                <select id="taskFilterSelect" class="form-select rounded-pill filter-select-input filter-select-all text-nowrap" style="min-width: 150px; font-weight: 600;">
                    <option value="all" class="filter-option-all" selected>All Tasks</option>
                    <option value="pending" class="filter-option-pending">Pending</option>
                    <option value="in_progress" class="filter-option-in_progress">In Progress</option>
                    <option value="completed" class="filter-option-completed">Completed</option>
                </select>

                <button class="btn btn-primary rounded-pill px-4 py-2 fw-semibold text-nowrap flex-shrink-0 shadow-sm" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Task
                </button>
            </div>
        </div>
        <?php if (empty($tasks)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-check2-circle display-1 text-primary opacity-50 mb-3 d-block"></i>
                <h5 class="fw-bold text-dark">No tasks created yet</h5>
                <p class="mb-3">Save your task with our task button to start organizing your routine!</p>
                <button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                    <i class="bi bi-plus-circle me-1"></i> Create First Task
                </button>
            </div>
        <?php else: ?>
            <div id="taskListContainer" class="d-flex flex-column gap-3">
                <?php foreach ($tasks as $task): ?>
                    <div id="task-card-<?= $task['id']; ?>" 
                         class="task-card-item card border border-light-subtle rounded-3 p-3 transition-all status-<?= htmlspecialchars($task['status']); ?>" 
                         data-status="<?= htmlspecialchars($task['status']); ?>">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <h5 class="fw-bold text-dark mb-0"><?= htmlspecialchars($task['title']); ?></h5>
                                    
                                    <?php 
                                        $priorityBadge = match($task['priority']) {
                                            'high' => ['class' => 'priority-badge-high', 'icon' => 'text-danger'],
                                            'low' => ['class' => 'priority-badge-low', 'icon' => 'text-secondary'],
                                            default => ['class' => 'priority-badge-medium', 'icon' => 'text-warning-emphasis'],
                                        };
                                    ?>
                                    <span class="badge border rounded-pill px-2 py-1 fs-7 <?= $priorityBadge['class']; ?>">
                                        <i class="bi bi-flag-fill <?= $priorityBadge['icon']; ?> me-1"></i><?= ucfirst(htmlspecialchars($task['priority'])); ?>
                                    </span>
                                </div>
                                
                                <?php if (!empty($task['description'])): ?>
                                    <p class="text-muted mb-2 fs-6"><?= htmlspecialchars($task['description']); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($task['due_date'])): ?>
                                    <small class="text-muted"><i class="bi bi-calendar-event me-1"></i> Due: <?= htmlspecialchars($task['due_date']); ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <select class="form-select form-select-sm rounded-pill task-status-select" data-task-id="<?= $task['id']; ?>" style="min-width: 140px;">
                                    <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                </select>

                                <button class="btn btn-sm btn-outline-primary rounded-circle edit-task-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editTaskModal"
                                        data-task-id="<?= $task['id']; ?>"
                                        data-task-title="<?= htmlspecialchars($task['title']); ?>"
                                        data-task-description="<?= htmlspecialchars($task['description'] ?? ''); ?>"
                                        data-task-priority="<?= htmlspecialchars($task['priority']); ?>"
                                        data-task-status="<?= htmlspecialchars($task['status']); ?>"
                                        data-task-due-date="<?= htmlspecialchars($task['due_date'] ?? ''); ?>"
                                        title="Edit Task">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>

                                <button class="btn btn-sm btn-outline-danger rounded-circle delete-task-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteTaskModal"
                                        data-task-id="<?= $task['id']; ?>"
                                        title="Delete Task">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="newTaskModalLabel"><i class="bi bi-plus-circle me-2 text-primary"></i> Create Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createTaskForm">
                <div class="modal-body py-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="create_title" name="title" placeholder="Task Title" required>
                        <label for="create_title">Task Title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control rounded-3" id="create_description" name="description" placeholder="Description" style="height: 100px;"></textarea>
                        <label for="create_description">Description (Optional)</label>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select rounded-3 priority-select-input" id="create_priority" name="priority">
                                    <option value="low" class="priority-option-low">Low</option>
                                    <option value="medium" class="priority-option-medium" selected>Medium</option>
                                    <option value="high" class="priority-option-high">High</option>
                                </select>
                                <label for="create_priority">Priority</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control rounded-3" id="create_due_date" name="due_date">
                                <label for="create_due_date">Due Date</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Save Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="editTaskModalLabel"><i class="bi bi-pencil-square me-2 text-primary"></i> Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTaskForm">
                <input type="hidden" id="edit_task_id" name="task_id">
                <div class="modal-body py-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="edit_title" name="title" placeholder="Task Title" required>
                        <label for="edit_title">Task Title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control rounded-3" id="edit_description" name="description" placeholder="Description" style="height: 100px;"></textarea>
                        <label for="edit_description">Description (Optional)</label>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select class="form-select rounded-3 priority-select-input" id="edit_priority" name="priority">
                                    <option value="low" class="priority-option-low">Low</option>
                                    <option value="medium" class="priority-option-medium">Medium</option>
                                    <option value="high" class="priority-option-high">High</option>
                                </select>
                                <label for="edit_priority">Priority</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select class="form-select rounded-3" id="edit_status" name="status">
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                                <label for="edit_status">Status</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control rounded-3" id="edit_due_date" name="due_date">
                                <label for="edit_due_date">Due Date</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="bi bi-save me-1"></i> Update Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-danger" id="deleteTaskModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 text-muted">
                Are you sure you want to delete this task? This action cannot be undone.
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger rounded-pill px-4 fw-bold">
                    <i class="bi bi-trash-fill me-1"></i> Delete Task
                </button>
            </div>
        </div>
    </div>
</div>
<script src="/assets/js/tasks.js"></script>
