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

                <div class="row g-4">
                    <div class="col-12">
                        <div class="card shadow border-0">
                            <div class="card-header bg-secondary text-white d-flex align-items-center">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                <span>Add Daily Income</span>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('dailyincome/add'); ?>" method="post">
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
                                            <label for="sub_income" class="form-label fw-semibold">Income Recived<span class="text-danger">*</span></label>
                                            <select name="sub_income" id="sub_income" class="form-select" required>
                                                <option value="">Select Payment Type</option>
                                                <option value="1">To BOC Bank</option>
                                                <option value="1">To Sampath Bank</option>
                                                <option value="2">Get Money in Hand</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
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
