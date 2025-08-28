<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main class="pt-4">
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="fw-bold">Month End - <?= date('F'); ?></h1>
                    <span class="text-muted"><?= date('F j, Y'); ?></span>
                </div>
                <hr>

                <form method="get" class="row g-2 mb-4">
                    <div class="col-md-4">
                        <select name="bank_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- All Banks --</option>
                            <?php foreach ($banks as $b): ?>
                                <option value="<?= $b->id ?>" <?= $b->id == $selected_bank_id ? 'selected' : '' ?>>
                                    <?= $b->bank ?> (<?= $b->account_number ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="month" name="month" class="form-control"
                            value="<?= isset($monthnum) ? $year . '-' . str_pad($monthnum, 2, '0', STR_PAD_LEFT) : date('Y-m') ?>"
                            onchange="this.form.submit()">
                    </div>
                </form>


                <?php foreach ($all_data as $data): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header bg-secondary text-white fw-bold">
                            <?= $data['bank']->bank ?> (<?= $data['bank']->account_number ?>)
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-3">
                                <div class="col-md-3">
                                    <div class="p-3 bg-light border rounded text-center">
                                        <small>Opening Balance</small>
                                        <div class="fw-bold"><?= number_format($data['opening_balance'], 2) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3 bg-light border rounded text-center">
                                        <small>Total Incomes</small>
                                        <div class="text-success fw-bold"><?= number_format($data['month_incomes'], 2) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3 bg-light border rounded text-center">
                                        <small>Total Expenses</small>
                                        <div class="text-danger fw-bold"><?= number_format($data['month_expenses'], 2) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3 bg-light border rounded text-center">
                                        <small>Profit</small>
                                        <div class="<?= $data['profit'] >= 0 ? 'text-success' : 'text-danger' ?> fw-bold"><?= number_format($data['profit'], 2) ?></div>
                                    </div>
                                </div>
                            </div>

                            <table id="transactionsTable_<?= $data['bank']->id ?>" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['transactions'] as $t): ?>
                                        <tr>
                                            <td><?= $t->date ?></td>
                                            <td><?= $t->type ?></td>
                                            <td><?= number_format($t->amount, 2) ?></td>
                                            <td><?= $t->comment ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white fw-bold">Cash in Hand</div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <div class="p-3 bg-light border rounded text-center">
                                    <small>Opening Balance</small>
                                    <div class="fw-bold"><?= number_format($cash['opening_balance'], 2) ?></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-light border rounded text-center">
                                    <small>Total Incomes</small>
                                    <div class="text-success fw-bold"><?= number_format($cash['month_incomes'], 2) ?></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-light border rounded text-center">
                                    <small>Total Expenses</small>
                                    <div class="text-danger fw-bold"><?= number_format($cash['month_expenses'], 2) ?></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-light border rounded text-center">
                                    <small>Profit</small>
                                    <div class="<?= $cash['profit'] >= 0 ? 'text-success' : 'text-danger' ?> fw-bold"><?= number_format($cash['profit'], 2) ?></div>
                                </div>
                            </div>
                        </div>

                        <table id="cashTable" class="table table-striped table-bordered nowrap" style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cash['transactions'] as $t): ?>
                                    <tr>
                                        <td><?= $t->date ?></td>
                                        <td><?= $t->type ?></td>
                                        <td><?= number_format($t->amount, 2) ?></td>
                                        <td><?= $t->comment ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
        <?php include(APPPATH . 'views/components/footer.php'); ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        <?php foreach ($all_data as $data): ?>
            $('#transactionsTable_<?= $data['bank']->id ?>').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                pageLength: 10
            });
        <?php endforeach; ?>

        $('#cashTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            lengthChange: true,
            pageLength: 10
        });
    });
</script>