<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">
                <h1 class="fw-bold">Transactions</h1><hr>

                <form method="get" class="row mb-3">
                    <div class="col-md-4">
                        <select name="user_id" class="form-control" onchange="this.form.submit()">
                            <option value="">-- All Users --</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user->id ?>"
                                    <?= (isset($_GET['user_id']) && $_GET['user_id'] == $user->id) ? 'selected' : '' ?>>
                                    <?= $user->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>

                <div class="container mt-4">

                    <table id="transactionsTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Main Type</th>
                                <th>Sub Type</th>
                                <th>Amount</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Payment Info</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $row): ?>
                                <tr>
                                    <td><?= $row->type ?></td>
                                    <td><?= $row->date ?></td>
                                    <td><?= $row->main_type ?></td>
                                    <td><?= $row->sub_type ?></td>
                                    <td><?= number_format($row->amount, 2) ?></td>
                                    <td><?= $row->comment ?></td>
                                    <td>
                                        <?php if ($row->status_text == "Active"): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $row->payment_info ?></td>
                                    <td><?= $row->created_at ?></td>
                                    <td><?= $row->updated_at ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <h5>Summary</h5>
                        <p><strong>Total Income:</strong> <?= number_format($totals['income'], 2) ?></p>
                        <p><strong>Total Expenses:</strong> <?= number_format($totals['expense'], 2) ?></p>
                        <!-- <p><strong>Balance:</strong> <?= number_format($totals['balance'], 2) ?></p> -->
                    </div>
                </div>
            </div>

        </main>
        <?php include(APPPATH . 'views/components/footer.php'); ?>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#transactionsTable').DataTable({
            "pageLength": 10,
            "ordering": true,
            "searching": true,
            "lengthChange": true
        });
    });
</script>