<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main class="pt-4">
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="fw-bold">Month End Closing- <?= date('F'); ?></h1>
                    <span class="text-muted"><?= date('F j, Y'); ?></span>
                </div>
                <hr>

                <div class="container mt-4">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('Monthend/close') ?>" method="post" class="form-inline mb-3">
                        <div class="form-group mb-2">
                            <label>Select Bank:</label>
                            <select name="bank_id" class="form-control ml-2">
                                <option value="">Cash in Hand</option>
                                <?php foreach ($banks as $bank): ?>
                                    <option value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-dark ml-3">Month End</button>
                    </form>

                    <table class="table table-bordered w-100" id="dataTable">
                        <thead>
                            <tr>
                                <th>Month-Year</th>
                                <th>Bank</th>
                                <th>Opening</th>
                                <th>Income</th>
                                <th>Expense</th>
                                <th>Closing</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($closings)): ?>
                                <?php foreach ($closings as $row): ?>
                                    <tr>
                                        <td><?= $row->month ?? '' ?>-<?= $row->year ?? '' ?></td>
                                        <td><?= $row->bank_name ?? "Cash in Hand" ?></td>
                                        <td><?= $row->opening_balance ?? 0 ?></td>
                                        <td><?= $row->total_income ?? 0 ?></td>
                                        <td><?= $row->total_expense ?? 0 ?></td>
                                        <td><?= $row->closing_balance ?? 0 ?></td>
                                        <td>
                                            <?php if ($row->status == 1): ?>
                                                <a href="<?= base_url('Monthend/cancel/' . $row->id) ?>" class="btn btn-sm btn-danger">Cancel</a>
                                            <?php else: ?>
                                                <span class="text-muted">Cancelled</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No Records Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </main>
        <?php include(APPPATH . 'views/components/footer.php'); ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            scrollX: true,
            destroy: true
        });
    });
</script>