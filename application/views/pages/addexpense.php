<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                    <h1 class="fw-bold">Daily Expenses</h1>
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
                    <div class="col-12">
                        <div class="card shadow border-0">
                            <div class="card-header bg-secondary text-white d-flex align-items-center">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                <span>Add Daily Expenses</span>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('Expense/add_or_update'); ?>" method="post">
                                    <input type="hidden" id="record_id" name="record_id">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="main_income" class="form-label fw-semibold">Main Expense Type <span class="text-danger">*</span></label>
                                            <select name="main_expense" id="main_expense" class="form-select" required>
                                                <option value="">Select Main Expense Type</option>
                                                <option value="1">Shopping</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="sub_income" class="form-label fw-semibold">Sub Expense Type <span class="text-danger">*</span></label>
                                            <select name="sub_expense" id="sub_expense" class="form-select" required>
                                                <option value="">Select Sub Expense Type</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="date" class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                                            <input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="amount" class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter expense amount" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="sub_income" class="form-label fw-semibold">Select Bank (If you spend money to bank)</label>
                                            <select name="bank" id="bank" class="form-select">
                                                <option value="">Select Bank</option>
                                                <?php foreach ($banks as $bank): ?>
                                                    <option value="<?= $bank['id'] ?>"><?= $bank['bank'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="sub_income" class="form-label fw-semibold">Spend Money from Hand (Select If you spend money from hand)</label><br>
                                            <input type="checkbox" name="spend_money_from_hand" id="spend_money_from_hand" class="form-check-input" value="1">
                                        </div>

                                        <div class="col-md-12">
                                            <label for="comment" class="form-label fw-semibold">Comment</label>
                                            <textarea name="comment" class="form-control" id="comment" placeholder="Optional note"></textarea>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa-solid fa-save me-2"></i>Save Daily Income
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card shadow border-0 mt-4">
                            <div class="card-header bg-dark text-white d-flex align-items-center">
                                <i class="fas fa-table me-2"></i>
                                <span>Daily Expenses Entries</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dailyIncomeTable" class="table w-100 table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Main Expense</th>
                                                <th>Sub Expense</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Expense From</th>
                                                <th>Comment</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Salary</td>
                                                <td>Job</td>
                                                <td>2025-08-04</td>
                                                <td>5000</td>
                                                <td>Bank</td>
                                                <td>August income</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="<?= base_url('dailyincome/edit/1'); ?>" class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <a href="<?= base_url('dailyincome/delete/1'); ?>" class="btn btn-danger btn-sm" title="Delete">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- End dynamic row -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
            </div>
        </main>

        <?php include(APPPATH . 'views/components/footer.php'); ?>

        <!-- DataTable + ScrollX -->
        <script>
            $(document).ready(function () {
                $('#dailyIncomeTable').DataTable({
                    scrollX: true
                });
            });
        </script>
    </div>
</div>
