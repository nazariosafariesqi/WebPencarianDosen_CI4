<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <a href="<?= base_url('admin/leases') ?>" type="button" class="btn btn-success mb-3">Connect Mikrotik</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Ip Address</th>
                        <th scope="col">Mac Address</th>
                        <th scope="col">Host Name</th>
                        <th scope="col">Expires</th>
                        <th scope="col">Last Seen</th>
                        <th scope="col">Waktu Ambil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($leases as $l) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $l['ip_address']; ?></td>
                            <td><?= $l['mac_address']; ?></td>
                            <td><?= $l['active_host_name']; ?></td>
                            <td><?= $l['time_expires']; ?></td>
                            <td><?= $l['last_seen']; ?></td>
                            <td><?= $l['waktu_ambil']; ?></td>
                        </tr>
                        <?php $i++ ?>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->