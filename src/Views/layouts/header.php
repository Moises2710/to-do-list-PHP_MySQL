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
                    <div class="dropdown">
                        <button class="btn btn-light rounded-pill border px-3 py-1 d-flex align-items-center gap-2 user-avatar-btn shadow-sm" type="button" id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?>
                            </div>
                            <span class="fw-semibold text-dark fs-6 d-none d-sm-inline"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                            <i class="bi bi-chevron-down text-muted fs-7"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end rounded-4 border-0 shadow-lg p-2 mt-2 user-dropdown-menu" aria-labelledby="userMenuDropdown">
                            <li class="px-3 py-2 border-bottom mb-1">
                                <div class="fw-bold text-dark"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></div>
                                <div class="small text-muted"><?= htmlspecialchars($_SESSION['user_email'] ?? 'user@workspace.com'); ?></div>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 fw-medium d-flex align-items-center text-dark" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                    <i class="bi bi-person me-2 text-primary fs-5"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 fw-medium d-flex align-items-center text-dark" href="#" data-bs-toggle="modal" data-bs-target="#helpModal">
                                    <i class="bi bi-question-circle me-2 text-primary fs-5"></i> Help
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 fw-medium d-flex align-items-center text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right me-2 fs-5"></i> Log out
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="/signin" class="btn btn-outline-primary px-4 rounded-pill fw-semibold nav-link-custom">Sign In</a>
                    <a href="/signup" class="btn btn-primary px-4 rounded-pill fw-semibold shadow-sm nav-btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
