<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                    <h1 class="fw-bold">Remaining Incomes & Expenses</h1>
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

                <div id="ajax-alert"></div>
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card shadow border-0 mt-4">
                            <div class="card-header bg-secondary text-white d-flex align-items-center">
                                <i class="fas fa-table me-2"></i>
                                <span>Remaining Incomes</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="remainingIncomeTable" class="table w-100 table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Main Income</th>
                                                <th>Sub Income</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Recived To</th>
                                                <th>Comment</th>
                                                <th>Completed</th>
                                                <th>Due Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($incomes as $income): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($income['tbl_main_income_types_id']) ?></td>
                                                    <td><?= htmlspecialchars($income['tbl_sub_income_types_id']) ?></td>
                                                    <td><?= htmlspecialchars($income['date']) ?></td>
                                                    <td><?= htmlspecialchars($income['amount']) ?></td>
                                                    <td><?= htmlspecialchars($income['tbl_banks_id']) ?></td>
                                                    <td><?= htmlspecialchars($income['comment']) ?></td>
                                                    <td style="color:red;"><?= htmlspecialchars($income['completed']) ?></td>
                                                    <td><?= htmlspecialchars($income['due_date']) ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-success btn-sm mark-completed"
                                                            data-id="<?= $income['id'] ?>"
                                                            data-type="income">
                                                            ✅
                                                        </button>
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

                <div class="row g-4">
                    <div class="col-12">
                        <div class="card shadow border-0 mt-4">
                            <div class="card-header bg-dark text-white d-flex align-items-center">
                                <i class="fas fa-table me-2"></i>
                                <span>Remaining Expenses</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="remainingExpenseTable" class="table w-100 table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Main Expense</th>
                                                <th>Sub Expense</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Expense From</th>
                                                <th>Comment</th>
                                                <th>Completed</th>
                                                <th>Due Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($expenses as $expense): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($expense['tbl_main_expense_types_id']) ?></td>
                                                    <td><?= htmlspecialchars($expense['tbl_sub_expense_types_id']) ?></td>
                                                    <td><?= htmlspecialchars($expense['date']) ?></td>
                                                    <td><?= htmlspecialchars($expense['amount']) ?></td>
                                                    <td><?= htmlspecialchars($expense['tbl_banks_id']) ?></td>
                                                    <td><?= htmlspecialchars($expense['comment']) ?></td>
                                                    <td style="color:red;"><?= htmlspecialchars($expense['completed']) ?></td>
                                                    <td><?= htmlspecialchars($expense['due_date']) ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-success btn-sm mark-completed"
                                                            data-id="<?= $expense['id'] ?>"
                                                            data-type="expense">
                                                            ✅
                                                        </button>
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
                $('#remainingIncomeTable').DataTable({
                    scrollX: true
                });

                $('#remainingExpenseTable').DataTable({
                    scrollX: true
                });
            });
        </script>


        <script>
            $(document).on('click', '.mark-completed', function() {
                let id = $(this).data('id');
                let type = $(this).data('type');

                $.ajax({
                    url: '<?= base_url("Remaining/mark_completed/") ?>' + type + '/' + id,
                    method: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        let alertClass = (res.status === 'success') ? 'alert-success bg-success' : 'alert-danger bg-danger';
                        $('#ajax-alert').html(`
                <div class="alert ${alertClass} text-white alert-dismissible fade show mt-3" role="alert">
                    ${res.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);

                        if (res.status === 'success') {
                            $('button[data-id="' + id + '"]').closest('tr').fadeOut();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#ajax-alert').html(`
                <div class="alert alert-danger bg-danger text-white alert-dismissible fade show mt-3" role="alert">
                    AJAX error: ${error}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
                    }
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