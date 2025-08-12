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
                                            <label for="" class="form-label fw-semibold">Main Expense Type <span class="text-danger">*</span></label>
                                            <select name="main_expense" id="main_expense" class="form-select" required>
                                                <option value="">Select Main Expense Type</option>
                                                <?php foreach ($mexpenses as $expense): ?>
                                                <option value="<?= $expense['id'] ?>" <?= (isset($expenses) && $expenses['tbl_main_expense_types_id'] == $expense['id']) ? 'selected' : '' ?>>
                                                    <?= $expense['main_expense_name'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="" class="form-label fw-semibold">Sub Expense Type <span class="text-danger">*</span></label>
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
                                        <button id="submitBtn" type="submit" class="btn btn-success">
                                            <i class="fa-solid fa-save me-2"></i><span id="submitText">Save</span>
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
                                            <?php foreach ($addedexpenses as $expense): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($expense['main_expense_name']) ?></td>
                                                    <td><?= htmlspecialchars($expense['sub_expense_name']) ?></td>
                                                    <td><?= htmlspecialchars($expense['date']) ?></td>
                                                    <td><?= htmlspecialchars($expense['amount']) ?></td>
                                                    <td>
                                                        <?php if ($expense['tbl_banks_id']): ?>
                                                            <?= htmlspecialchars($expense['bank_name']) ?>
                                                        <?php else: ?>
                                                            <span class="text-danger">Money From Hand</span>
                                                        <?php endif; ?>
                                                    <td><?= htmlspecialchars($expense['comment']) ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-warning btn-sm editBtn"
                                                            data-id="<?= $expense['id'] ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <a href="<?= base_url('Expense/delete/' . $expense['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this entry?')">
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

        <script>
            $(document).ready(function() {
                $('#main_expense').change(function() {
                    var main_expense_id = $(this).val();

                    if (main_expense_id) {
                        $.ajax({
                            url: "<?= base_url('Expense/get_sub_expense') ?>",
                            type: "POST",
                            data: {
                                main_expense_id: main_expense_id
                            },
                            dataType: "json",
                            success: function(data) {
                                $('#sub_expense').empty().append('<option value="">Select Sub Expense Type</option>');
                                $.each(data, function(index, item) {
                                    $('#sub_expense').append('<option value="' + item.id + '">' + item.sub_expense_name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#sub_expense').empty().append('<option value="">Select Sub Income Type</option>');
                    }
                });

                $('.editBtn').click(function() {
                    const id = $(this).data('id');

                    $.ajax({
                        url: '<?= base_url("Expense/get_by_id/") ?>' + id,
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#record_id').val(data.id);
                            $('#date').val(data.date);
                            $('#amount').val(data.amount);
                            $('#comment').val(data.comment);
                            if (data.tbl_banks_id) {
                                $('#bank').val(data.tbl_banks_id);
                                $('#spend_money_from_hand').prop('checked', false);
                            } else {
                                $('#bank').val('');
                                $('#spend_money_from_hand').prop('checked', data.from_hand == 1);
                            }
                            $('#submitText').text('Update');
                            $('#submitBtn').removeClass('btn-success').addClass('btn-warning');
                            $('#main_expense').val(data.tbl_main_expense_types_id).trigger('change');

                            $.ajax({
                                url: "<?= base_url('Expense/get_sub_expense') ?>",
                                type: "POST",
                                data: {
                                    main_expense_id: data.tbl_main_expense_types_id
                                },
                                dataType: "json",
                                success: function(subData) {
                                    $('#sub_expense').empty().append('<option value="">Select Sub Expense Type</option>');
                                    $.each(subData, function(index, item) {
                                        $('#sub_expense').append('<option value="' + item.id + '">' + item.sub_expense_name + '</option>');
                                    });
                                    $('#sub_expense').val(data.tbl_sub_expense_types_id);
                                },
                                error: function() {
                                    console.log('Error loading sub expense data');
                                }
                            });
                        },
                        error: function() {
                            alert('Error loading data!');
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
            });
        </script>
    </div>
</div>
