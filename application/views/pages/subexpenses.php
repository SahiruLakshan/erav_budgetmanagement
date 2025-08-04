<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                    <h1 class="fw-bold">Sub Expenses</h1>
                    <span class="text-muted"><?= date('F j, Y'); ?></span>
                </div>
                <hr class="mb-4">

                <div class="row g-4">
                    <div class="col-xl-4">
                        <div class="card shadow border-0 h-100">
                            <div class="card-header bg-secondary text-white d-flex align-items-center">
                                <i class="fas fa-plus me-2"></i>
                                <span>Add Sub Expense Type</span>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('mainincome/add'); ?>" method="post">
                                    <div class="mb-3">
                                        <label for="income_name" class="form-label fw-semibold">Main Expense Type <span class="text-danger">*</span></label>
                                        <select name="income_name" class="form-select" id="">
                                            <option value="">Select Main Expense Type</option>
                                            <option value="">Main 1</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="income_name" class="form-label fw-semibold">Sub Expense Type <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control" id="income_name" name="income_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label fw-semibold">Comment</label>
                                        <textarea name="comment" class="form-control" id="comment" placeholder="Optional note"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-md">
                                        <i class="fa-solid fa-save me-2"></i>Save
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card shadow border-0">
                            <div class="card-header bg-dark text-white d-flex align-items-center">
                                <i class="fas fa-table me-2"></i>
                                <span>Sub Expense Types</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="subIncomeTable" class="table table-hover align-middle">

                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 35%;">Main Expense</th>
                                                <th style="width: 35%;">Sub Expense</th>
                                                <th style="width: 45%;">Comment</th>
                                                <th style="width: 20%;" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Salary</td>
                                                <td>Job</td>
                                                <td>Monthly</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="<?= base_url('mainincome/edit/1'); ?>" class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <a href="<?= base_url('mainincome/delete/1'); ?>" class="btn btn-danger btn-sm" title="Delete">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Add dynamic rows here -->
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
                $('#subIncomeTable').DataTable({
                    scrollX: true
                });
            });
        </script>
    </div>
</div>