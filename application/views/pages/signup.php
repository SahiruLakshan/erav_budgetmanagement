<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-white bg-gradient">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 450px;">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus-fill fs-1 text-dark"></i>
                <h4 class="mt-2">SIGN UP</h4>
            </div>
            <form method="post" action="<?= base_url('Auth/register_user') ?>">
                <?php if ($this->session->flashdata('validation_errors')): ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('validation_errors'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="signupName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?= set_value('name') ?>">
                </div>
                <div class="mb-3">
                    <label for="signupEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= set_value('email') ?>">
                </div>
                <div class="mb-3">
                    <label for="signupPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="signupConfirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-dark">Sign Up</button>
                </div>
                <p class="text-center mt-3 mb-0">
                    Already have an account? <a href="<?= base_url('auth') ?>" class="text-secondary">Sign In</a>
                </p>
            </form>
        </div>
    </div>

</body>

</html>