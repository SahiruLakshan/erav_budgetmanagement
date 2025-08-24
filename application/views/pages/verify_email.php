<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>verify_email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-white bg-gradient">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">

            <a href="<?= base_url('Auth') ?>" class="btn btn-sm btn-secondary" style="width:80px"><i class="bi bi-arrow-left-short"></i> Back</a>

            <div class="text-center mb-4">
                <h4 class="mt-2">Verify Email</h4>
            </div>
            <form method="post" action="<?= base_url('Auth/send_verification_code') ?>">
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Registered Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Verification Code</label>
                    <input type="text" class="form-control" name="code" maxlength="8">
                    <small class="text-muted">Leave blank to receive code via email.</small>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-dark">Verify Email</button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>