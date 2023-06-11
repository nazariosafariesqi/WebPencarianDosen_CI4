<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

</div>
<!-- /.container-fluid -->
<div class="row">
    <div class="col-lg ml-4">
        <form action="<?= base_url('User/HasilSearch'); ?>" method="GET" class="form-inline mb-4">
            <div class="form-group">
                <input type="text" value="<?= isset($keyword) ? $keyword : '' ?>" name="keyword" autofocus autocomplete="off" class="form-control bg-grey border small" style="width: 800px;" placeholder="Search Keyword" aria-label="Search" aria-describedby="basic-addon2">
            </div>
            <div class="input-group-append">
                <input class="btn btn-info ml-2" type="submit" name="search" value="Search"></input>
            </div>
        </form>
        <?php if ($no_data) : ?>
            <p>Tidak ada data</p>
        <?php else : ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Pemilik</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Last Seen</th>
                        <th scope="col">No Ruang</th>
                        <th scope="col">Nama Ruang</th>
                        <th scope="col">Lantai</th>
                        <th scope="col">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leases as $index => $result) : ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $result['nama_pemilik'] ?></td>
                            <td><?= $result['ip_address'] ?></td>
                            <td><?= $result['last_seen'] ?></td>
                            <td><?= $result['no_ruang'] ?></td>
                            <td><?= $result['nama_ruang'] ?></td>
                            <td><?= $result['lantai'] ?></td>
                            <td><?= $result['waktu_ambil'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
</div>
<!-- End of Main Content -->