<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="brand-icon-wrapper rounded-3 d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-person-plus-fill fs-3 text-white"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-1">Create Account</h2>
                        <p class="text-muted">Join Coronado To do List and organize your daily life.</p>
                    </div>

                    <!-- Flash Error Alert -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="/signup" method="POST" class="needs-validation" novalidate>
                        <!-- Name Field -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="John Doe" value="<?= htmlspecialchars($old['name'] ?? ''); ?>" required>
                            <label for="name"><i class="bi bi-person me-2"></i>Full Name</label>
                        </div>

                        <!-- Email Field -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="name@example.com" value="<?= htmlspecialchars($old['email'] ?? ''); ?>" required>
                            <label for="email"><i class="bi bi-envelope me-2"></i>Email Address</label>
                        </div>

                        <!-- Password Field -->
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Password" required>
                            <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control rounded-3" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                            <label for="confirm_password"><i class="bi bi-shield-lock me-2"></i>Confirm Password</label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold text-uppercase tracking-wider shadow-sm nav-btn-primary mb-3">
                            <i class="bi bi-check-lg me-1"></i> Register Account
                        </button>

                        <div class="text-center">
                            <p class="mb-0 text-muted">Already have an account? <a href="/signin" class="text-primary fw-semibold text-decoration-none">Sign In</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
