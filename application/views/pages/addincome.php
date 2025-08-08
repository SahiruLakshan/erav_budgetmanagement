<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                    <h1 class="fw-bold">Daily Incomes</h1>
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
                                <span>Add Daily Income</span>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('Income/submit'); ?>" method="post">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="main_income" class="form-label fw-semibold">Main Income Type <span class="text-danger">*</span></label>
                                            <select name="main_income" id="main_income" class="form-select" required>
                                                <option value="">Select Main Income Type</option>
                                                <option value="1">Salary</option>
                                                <option value="2">Business</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="sub_income" class="form-label fw-semibold">Sub Income Type <span class="text-danger">*</span></label>
                                            <select name="sub_income" id="sub_income" class="form-select" required>
                                                <option value="">Select Sub Income Type</option>
                                                <option value="1">Job</option>
                                                <option value="2">Freelance</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="date" class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                                            <input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="amount" class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter income amount" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="sub_income" class="form-label fw-semibold">Select Bank (If you get money to bank)<span class="text-danger">*</span></label>
                                            <select name="bank" id="bank" class="form-select" required>
                                                <option value="">Select Payment Type</option>
                                                <option value="1">To BOC Bank</option>
                                                <option value="1">To Sampath Bank</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="sub_income" class="form-label fw-semibold">Get Money in Hand (Select If you get money to hand)<span class="text-danger">*</span></label><br>
                                            <input type="checkbox" name="get_money_in_hand" id="get_money_in_hand" class="form-check-input" value="1">
                                        </div>

                                        <div class="col-md-12">
                                            <label for="comment" class="form-label fw-semibold">Comment</label>
                                            <textarea name="comment" class="form-control" id="" placeholder="Optional note"></textarea>
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
                                <span>Daily Income Entries</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dailyIncomeTable" class="table w-100 table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Main Income</th>
                                                <th>Sub Income</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Recived To</th>
                                                <th>Comment</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($incomes as $income): ?>
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
