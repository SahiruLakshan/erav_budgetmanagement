<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-white bg-gradient">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="card shadow-lg p-4" style="width:100%; max-width:400px;">
                <h4 class="text-center mb-3">Reset Password</h4>
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('Auth/request_password_reset') ?>">
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">Send Code</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>