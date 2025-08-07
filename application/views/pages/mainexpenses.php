<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                    <h1 class="fw-bold">Main Expenses</h1>
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
                                <span>Add Main Expense Type</span>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('mainexpense/add_or_update'); ?>" method="post">
                                    <input type="hidden" id="record_id" name="record_id">
                                    <div class="mb-3">
                                        <label for="income_name" class="form-label fw-semibold">Expense Type <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control" id="expense_name" name="expense_name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label fw-semibold">Comment</label>
                                        <textarea name="comment" class="form-control form-control" id="comment" placeholder="Optional note"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-md" id="expensesubmitBtn">
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
                                <span>Main Expense Types</span>
                            </div>
                            <div class="card-body">
                                <table id="mainexpenseTable" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 35%;">Expense</th>
                                            <th style="width: 45%;">Comment</th>
                                            <th style="width: 20%;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($mexpenses as $expense): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($expense['main_expense_name']) ?></td>
                                                <td><?= htmlspecialchars($expense['comment']) ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-warning btn-sm expenseeditBtn"
                                                        data-id="<?= $expense['id'] ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <a href="<?= base_url('mainexpense/delete/' . $expense['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this entry?')">
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

        </main>
        <?php include(APPPATH . 'views/components/footer.php'); ?>
        <script>
            $(document).ready(function() {
                $('#mainexpenseTable').DataTable();
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.expenseeditBtn').click(function() {
                    const id = $(this).data('id');
                    $.ajax({
                        url: '<?= base_url("mainexpense/get_by_id/") ?>' + id,
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#record_id').val(data.id);
                            $('#expense_name').val(data.main_expense_name);
                            $('#comment').val(data.comment);
                            $('#submitText').text('Update');
                            $('#expensesubmitBtn').removeClass('btn-success').addClass('btn-warning');
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