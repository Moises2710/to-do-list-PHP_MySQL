<header class="shadow-sm border-bottom sticky-top custom-header">
    <nav class="navbar navbar-expand-lg container">
        <div class="container-fluid d-flex justify-content-between align-items-center px-0">
            <!-- Left: Icon + App Name -->
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-primary brand-title" href="/">
                <span class="brand-icon-wrapper rounded-3 d-flex align-items-center justify-content-center">
                    <i class="bi bi-check2-square fs-4 text-white"></i>
                </span>
                <span class="fs-4 brand-text">Coronado To do List</span>
            </a>

            <!-- Right: Dynamic Navigation links -->
            <div class="d-flex align-items-center gap-3">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/dashboard" class="btn btn-outline-primary px-3 rounded-pill fw-semibold nav-link-custom">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                    <div class="d-flex align-items-center gap-2 px-2 py-1 bg-light rounded-pill border">
                        <i class="bi bi-person-circle text-primary fs-5 ms-1"></i>
                        <span class="fw-semibold text-dark me-1"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                    </div>
                    <a href="/logout" class="btn btn-danger px-3 rounded-pill fw-semibold shadow-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                <?php else: ?>
                    <a href="/signin" class="btn btn-outline-primary px-4 rounded-pill fw-semibold nav-link-custom">Sign In</a>
                    <a href="/signup" class="btn btn-primary px-4 rounded-pill fw-semibold shadow-sm nav-btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
