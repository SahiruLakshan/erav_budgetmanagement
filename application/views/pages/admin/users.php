<?php include(APPPATH . 'views/components/header.php'); ?>
<?php include(APPPATH . 'views/components/navbar.php'); ?>

<div id="layoutSidenav">
    <?php include(APPPATH . 'views/components/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">
                <h1 class="fw-bold">User Details</h1><hr>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php elseif ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <div class="container mt-4">
                    <table id="usersTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $row): ?>
                                <tr>
                                    <td><?= $row->id ?></td>
                                    <td><?= $row->name ?></td>
                                    <td><?= $row->email ?></td>
                                    <td><?= $row->created_at ?></td>
                                    <!-- <td>
                                        <a href="<?= site_url('users/delete/'.$row->id) ?>" 
                                           onclick="return confirm('Are you sure you want to delete this user?')"
                                           class="btn btn-danger btn-sm">
                                           <i class="fas fa-trash"></i>
                                        </a>
                                    </td> -->
                                </tr>
                            <?php endforeach; ?>
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
        $('#usersTable').DataTable({
            "pageLength": 10,
            "ordering": true,
            "searching": true,
            "lengthChange": true
        });
    });
</script>
