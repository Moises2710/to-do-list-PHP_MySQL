<header class="shadow-sm border-bottom sticky-top custom-header">
    <nav class="navbar navbar-expand-lg container-fluid px-4 h-100">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="d-flex align-items-center">
                <?php if (isset($isAppLayout) && $isAppLayout): ?>
                    <div class="d-flex align-items-center gap-2">
                        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-primary brand-title mb-0" href="/dashboard">
                            <span class="brand-icon-wrapper rounded-3 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                <i class="bi bi-check2-square text-white fs-5"></i>
                            </span>
                            <span class="fs-5 brand-text">Coronado To do List</span>
                        </a>
                    </div>
                <?php else: ?>
                    <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-primary brand-title" href="/">
                        <span class="brand-icon-wrapper rounded-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-check2-square fs-4 text-white"></i>
                        </span>
                        <span class="fs-4 brand-text">Coronado To do List</span>
                    </a>
                <?php endif; ?>
            </div>
            <div class="d-flex align-items-center gap-3 ms-auto">
                <?php if (isset($isAppLayout) && $isAppLayout): ?>
                    <div class="d-flex align-items-center gap-2 px-3 py-1 bg-light rounded-pill border">
                        <i class="bi bi-person-circle text-primary fs-5"></i>
                        <span class="fw-semibold text-dark"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                    </div>
                    <a href="/logout" class="btn btn-outline-danger px-3 rounded-pill fw-semibold shadow-sm">
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
