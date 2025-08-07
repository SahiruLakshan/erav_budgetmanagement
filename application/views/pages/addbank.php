<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                    <h1 class="fw-bold">Bank Details</h1>
                    <span class="text-muted"><?= date('F j, Y'); ?></span>
                </div>
                <hr class="mb-4">

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success bg-success text-white alert-dismissible fade show mt-3" role="alert">
                        <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert bg-danger text-white alert-dismissible fade show mt-3" role="alert">
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row g-4">
                    <div class="col-xl-4">
                        <div class="card shadow border-0 h-100">
                            <div class="card-header bg-secondary text-white d-flex align-items-center">
                                <i class="fas fa-plus me-2"></i>
                                <span>Add Bank Accounts</span>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('bank/add_or_update'); ?>" method="post">
                                    <input type="hidden" id="record_id" name="record_id">
                                    <div class="mb-3">
                                        <label for="" class="form-label fw-semibold">Bank <span class="text-danger">*</span></label>
                                        <select name="bank" id="bank" class="form-select">
                                            <option value="">Select Bank</option>
                                            <option value="Bank of Ceylon">Bank of Ceylon (BOC)</option>
                                            <option value="Commercial Bank">Commercial Bank</option>
                                            <option value="Sampath Bank">Sampath Bank</option>
                                            <option value="HNB">HNB</option>
                                            <option value="People's Bank">People's Bank</option>
                                            <option value="NSB">NSB</option>
                                            <option value="DFCC Bank">DFCC Bank</option>
                                            <option value="Seylan Bank">Seylan Bank</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label fw-semibold">Bank Account Type<span class="text-danger">*</span></label>
                                        <select name="account_type" id="account_type" class="form-select">
                                            <option value="">Select Bank Account Type</option>
                                            <option value="Savings">Savings Account</option>
                                            <option value="Current">Current Account</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label fw-semibold">Account number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control" id="account_number" name="account_number" placeholder="Enter account number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label fw-semibold">Open Balance</label>
                                        <input type="number" class="form-control form-control" id="open_balance" name="open_balance" placeholder="0.00" step="0.01" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label fw-semibold">Comment</label>
                                        <textarea name="comment" class="form-control" id="comment" placeholder="Optional note"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-md banksubmit" id="submitBtn">
                                        <i class="fa-solid fa-save me-1"></i><span id="submitText">Save</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card shadow border-0">
                            <div class="card-header bg-dark text-white d-flex align-items-center">
                                <i class="fas fa-table me-2"></i>
                                <span>Bank Details</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="BankTable" class="table table-hover align-middle w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Bank</th>
                                                <th>Account Type</th>
                                                <th>Account Number</th>
                                                <th>Open Balance</th>
                                                <th>Comment</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($banks as $bank): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($bank['bank']) ?></td>
                                                    <td><?= htmlspecialchars($bank['account_type']) ?></td>
                                                    <td><?= htmlspecialchars($bank['account_number']) ?></td>
                                                    <td><?= htmlspecialchars($bank['open_balance']) ?></td>
                                                    <td><?= htmlspecialchars($bank['comment']) ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-warning btn-sm bankeditBtn"
                                                            data-id="<?= $bank['id'] ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <a href="<?= base_url('bank/delete/' . $bank['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this entry?')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include(APPPATH . 'views/components/footer.php'); ?>
        <script>
            $(document).ready(function() {
                $('#BankTable').DataTable({
                    scrollX: true
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.bankeditBtn').click(function() {
                    const id = $(this).data('id');
                    $.ajax({
                        url: '<?= base_url("bank/get_by_id/") ?>' + id,
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#record_id').val(data.id);
                            $('#bank').val(data.bank);
                            $('#account_type').val(data.account_type);
                            $('#account_number').val(data.account_number);
                            $('#open_balance').val(data.open_balance);
                            $('#comment').val(data.comment);
                            $('#submitText').text('Update');
                            $('#submitBtn').removeClass('btn-success').addClass('btn-warning');
                        },
                        error: function() {
                            alert('Error loading data!');
                        }
                    });
                });
            });

            setTimeout(function() {
                const alert = document.querySelector('.alert');
                if (alert) {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                }
            }, 3000);
        </script>
    </div>
</div>