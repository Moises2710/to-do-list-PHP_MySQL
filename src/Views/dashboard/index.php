<div class="container py-5">
    <!-- Welcome Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 bg-primary text-white mb-4 p-4 position-relative overflow-hidden" style="background: var(--primary-gradient) !important;">
        <div class="d-flex justify-content-between align-items-center position-relative z-1">
            <div>
                <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-bold mb-2">Personal Workspace</span>
                <h1 class="display-5 fw-bold mb-1">Welcome back, <?= htmlspecialchars($user['name']); ?>!</h1>
                <p class="mb-0 text-white-50 fs-5"><i class="bi bi-envelope me-2"></i><?= htmlspecialchars($user['email']); ?></p>
            </div>
            <div class="d-none d-md-block text-end">
                <a href="#createTaskModal" class="btn btn-light btn-lg rounded-pill px-4 fw-bold shadow-sm text-primary" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                    <i class="bi bi-plus-circle-fill me-2"></i> Add New Task
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-primary-subtle text-primary rounded-3">
                        <i class="bi bi-list-task fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold fs-7">Total Tasks</h6>
                        <h3 class="fw-bold mb-0 text-dark">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-warning-subtle text-warning rounded-3">
                        <i class="bi bi-clock-history fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold fs-7">Pending</h6>
                        <h3 class="fw-bold mb-0 text-dark">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-success-subtle text-success rounded-3">
                        <i class="bi bi-check-circle fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fw-bold fs-7">Completed</h6>
                        <h3 class="fw-bold mb-0 text-dark">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Task List Container Placeholder -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-text me-2 text-primary"></i> My Tasks</h4>
            <button class="btn btn-primary rounded-pill px-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                <i class="bi bi-plus-lg me-1"></i> Save Task
            </button>
        </div>

        <div class="text-center py-5 text-muted">
            <i class="bi bi-check2-circle display-1 text-primary opacity-50 mb-3 d-block"></i>
            <h5 class="fw-bold text-dark">No tasks created yet</h5>
            <p class="mb-3">Save your task with our task button to start organizing your routine!</p>
            <button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                <i class="bi bi-plus-circle me-1"></i> Create First Task
            </button>
        </div>
    </div>
</div>

<!-- Modal Placeholder for Creating Tasks -->
<div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="newTaskModalLabel"><i class="bi bi-plus-circle me-2 text-primary"></i> Create Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p class="text-muted">Task management features will be connected to the database in the upcoming phase.</p>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
