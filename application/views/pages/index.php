<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1><hr>
                <div class="row mt-3">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card shadow-lg border-0 rounded-4">
                                <div class="card-body text-center p-5">
                                    <h3 class="card-title mb-4">Current Balance</h3>

                                    <h1 class="display-4 text-success fw-bold">
                                        Rs. <?= number_format($opening_balance ?? 0, 2); ?>
                                    </h1>

                                    <p class="mt-3 text-muted">
                                        <?= date('F j, Y'); ?>
                                    </p>

                                    <!-- Add an action button -->
                                    <a href="#" class="btn btn-primary btn-lg mt-4">
                                        View Transactions
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Income - Monthly Overview
                            </div>
                            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Expense - Monthly Overview
                            </div>
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include(APPPATH . 'views/components/footer.php'); ?>
    </div>
</div>