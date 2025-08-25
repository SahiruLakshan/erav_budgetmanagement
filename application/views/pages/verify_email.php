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

            <a href="<?= base_url('Auth') ?>" class="btn btn-sm btn-secondary mb-3" style="width:80px">
                <i class="bi bi-arrow-left-short"></i> Back
            </a>

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
                    <input type="email" class="form-control"
                        name="email"
                        value="<?= $this->session->userdata('verify_email'); ?>"
                        required
                        <?= $this->session->userdata('verification_code') ? 'readonly' : '' ?>>
                </div>

                <?php if ($this->session->userdata('verification_code')): ?>
                    <div class="mb-3" id="otpSection">
                        <label class="form-label">Verification Code</label>
                        <div class="d-flex gap-2 justify-content-center">
                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                <input type="text"
                                    class="form-control text-center otp-input"
                                    maxlength="1"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    style="width: 38px; font-size: 1.5rem;">
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="code" id="code_full">
                        <small class="text-muted">Enter the 8-digit verification code sent to your email.</small>
                    </div>
                <?php endif; ?>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-dark">
                        <?= $this->session->userdata('verification_code') ? 'Verify Email' : 'Send Verification Code' ?>
                    </button>
                </div>
            </form>

        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputs = document.querySelectorAll(".otp-input");
        const hiddenInput = document.getElementById("code_full");

        if (inputs.length) {
            inputs.forEach((input, index) => {
                input.addEventListener("input", () => {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    collectCode();
                });

                input.addEventListener("keydown", (e) => {
                    if (e.key === "Backspace" && input.value === "" && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });

            function collectCode() {
                let code = "";
                inputs.forEach(i => code += i.value);
                hiddenInput.value = code;
            }
        }
    });
</script>

</html>