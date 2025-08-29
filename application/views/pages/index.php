<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <hr>

                <div class="row g-4 mt-3">
                    <div class="col-12 col-lg-6">
                        <div class="card shadow-lg border-0 rounded-4 h-100">
                            <div class="card-body text-center p-4">
                                <h3 class="card-title mb-3">Current Balance</h3>
                                <h1 class="display-5 text-success fw-bold">
                                    Rs. <?= number_format($opening_balance ?? 0, 2); ?>
                                </h1>
                                <p class="mt-2 text-muted">Cash in Hand: Rs. <?= number_format($cash_in_hand ?? 0, 2); ?></p>
                                <p class="mt-2 text-muted"><?= date('F j, Y'); ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <a href="<?= base_url('Monthend') ?>" class="btn btn-dark w-50">
                                    Check Month End Status
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="card shadow-lg border-0 rounded-4 h-100">
                            <div class="card-body p-4">
                                <h3 class="card-title mb-3 text-center">Bank Account Balances</h3>
                                <div class="list-group">
                                    <?php if (!empty($banks)): ?>
                                        <?php foreach ($banks as $bank): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <span><?= $bank['bank'] ?></span>
                                                <span class="fw-bold text-primary">
                                                    Rs. <?= number_format($bank['calculated_balance'] ?? 0, 2); ?>
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="list-group-item text-muted text-center">
                                            No bank accounts found.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-lg border-0 rounded-4">
                            <div class="card-body">
                                <h3 class="card-title mb-3 text-center">Transactions</h3>
                                <div class="row mb-3">
                                    <div class="col-md-3 col-sm-6">
                                        <label for="minDate" class="form-label">From Date</label>
                                        <input type="date" id="minDate" class="form-control">
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <label for="maxDate" class="form-label">To Date</label>
                                        <input type="date" id="maxDate" class="form-control">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="transactionsTable" class="table table-hover align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Account / Money in Hand</th>
                                                <th>Main Type</th>
                                                <th>Sub Type</th>
                                                <th>Amount</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($transactions)): ?>
                                                <?php foreach ($transactions as $t): ?>
                                                    <tr>
                                                        <td><?= date('Y-m-d', strtotime($t['date'])); ?></td>
                                                        <td><?= ucfirst($t['type']); ?></td>
                                                        <td>
                                                            <?php
                                                            if ($t['hand'] == 1) {
                                                                echo ($t['type'] == 'income') ? 'To Hand' : 'From Hand';
                                                            } else {
                                                                echo ($t['type'] == 'income')
                                                                    ? 'To Bank - ' . ($t['bank_name'] ?? 'Unknown')
                                                                    : 'From Bank - ' . ($t['bank_name'] ?? 'Unknown');
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $t['main_name'] ?? ''; ?></td>
                                                        <td><?= $t['sub_name'] ?? ''; ?></td>
                                                        <td class="<?= $t['type'] == 'expense' ? 'text-danger fw-bold' : 'text-success fw-bold' ?>">
                                                            <?= $t['type'] == 'expense' ? '-' : '+' ?> Rs. <?= number_format($t['amount'], 2); ?>
                                                        </td>
                                                        <td><?= $t['comment'] ?? ''; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-3">
                    <div class="col-12 col-xl-6">
                        <div class="card mb-4 h-100">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Monthly Income vs Expense
                            </div>
                            <div class="card-body">
                                <canvas id="incomeExpenseChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6">
                        <div class="card mb-4 h-100">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Profit - Monthly Overview
                            </div>
                            <div class="card-body">
                                <canvas id="profitChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include(APPPATH . 'views/components/footer.php'); ?>

        <script>
            fetch("<?= base_url('Dashboard/get_monthly_data'); ?>")
                .then(response => response.json())
                .then(data => {
                    const days = [];
                    const incomeData = [];
                    const expenseData = [];

                    const allDays = new Set();
                    data.incomes.forEach(row => allDays.add(row.day));
                    data.expenses.forEach(row => allDays.add(row.day));
                    const sortedDays = Array.from(allDays).sort();

                    sortedDays.forEach(day => {
                        days.push(day);
                        const incomeRow = data.incomes.find(r => r.day === day);
                        const expenseRow = data.expenses.find(r => r.day === day);
                        incomeData.push(incomeRow ? parseFloat(incomeRow.total) : 0);
                        expenseData.push(expenseRow ? parseFloat(expenseRow.total) : 0);
                    });

                    const ctx = document.getElementById("incomeExpenseChart").getContext("2d");
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: days,
                            datasets: [{
                                    label: "Income",
                                    data: incomeData,
                                    borderColor: "rgba(2,117,216,1)",
                                    backgroundColor: "rgba(2,117,216,0.2)",
                                    pointBackgroundColor: "rgba(2,117,216,1)",
                                    fill: true,
                                    lineTension: 0.3
                                },
                                {
                                    label: "Expense",
                                    data: expenseData,
                                    borderColor: "rgba(220,53,69,1)",
                                    backgroundColor: "rgba(220,53,69,0.2)",
                                    pointBackgroundColor: "rgba(220,53,69,1)",
                                    fill: true,
                                    lineTension: 0.3
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Date'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Amount (Rs)'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });

            fetch("<?= base_url('Dashboard/get_yearly_profit_data') ?>")
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.month);
                    const profits = data.map(item => item.profit);

                    new Chart(document.getElementById("profitChart"), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Monthly Profit (<?= date('Y') ?>)",
                                data: profits,
                                backgroundColor: profits.map(v => v >= 0 ? 'rgba(75, 192, 192, 0.6)' : 'rgba(255, 99, 132, 0.6)'),
                                borderColor: profits.map(v => v >= 0 ? 'rgba(75, 192, 192, 1)' : 'rgba(255, 99, 132, 1)'),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        </script>
        <script>
            $(document).ready(function() {
                var table = $('#transactionsTable').DataTable({
                    order: [
                        [0, "desc"]
                    ],
                    pageLength: 10,
                    columnDefs: [{
                        orderable: false,
                        targets: 6
                    }],
                    language: {
                        emptyTable: '<span class="text-danger fw-bold">⚠ No transactions found!</span>'
                    }
                });

                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    var min = $('#minDate').val();
                    var max = $('#maxDate').val();
                    var date = data[0];

                    if (!date) return false;

                    var txDate = new Date(date);

                    if (
                        (min === "" && max === "") ||
                        (min === "" && txDate <= new Date(max)) ||
                        (new Date(min) <= txDate && max === "") ||
                        (new Date(min) <= txDate && txDate <= new Date(max))
                    ) {
                        return true;
                    }
                    return false;
                });

                $('#minDate, #maxDate').on('change', function() {
                    table.draw();
                });
            });
        </script>
    </div>
</div>