<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-white bg-gradient">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">

            <div class="text-center mb-4">
                <i class="bi bi-person-circle fs-1 text-dark"></i>
                <h4 class="mt-2">SIGN IN</h4>
            </div>
            <form method="post" action="<?= base_url('Auth/login') ?>">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="signinEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="signinPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <a href="Auth/request_password_reset" class="text-secondary">Change Your Password</a>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-dark">Sign In</button>
                </div><br>

                <p>Don't have an account?<a href="Auth/signup" class="text-secondary"> Sign Up</a></p>
            </form>
        </div>
    </div>
</body>

</html>