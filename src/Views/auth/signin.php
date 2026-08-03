<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="brand-icon-wrapper rounded-3 d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-box-arrow-in-right fs-3 text-white"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-1">Welcome Back</h2>
                        <p class="text-muted">Sign in to access your to-do lists and tasks.</p>
                    </div>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= htmlspecialchars($success); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form action="/signin" method="POST" class="needs-validation" novalidate>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="name@example.com" value="<?= htmlspecialchars($old['email'] ?? ''); ?>" required>
                            <label for="email"><i class="bi bi-envelope me-2"></i>Email Address</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Password" required>
                            <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold text-uppercase tracking-wider shadow-sm nav-btn-primary mb-3">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                        </button>
                        <div class="text-center">
                            <p class="mb-0 text-muted">Don't have an account yet? <a href="/signup" class="text-primary fw-semibold text-decoration-none">Sign Up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
