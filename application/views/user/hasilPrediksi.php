<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg-12 ml-4">
        <form action="<?= base_url('Prediksi/HasilPrediksi'); ?>" method="POST" class="form-inline mb-4">
            <div class="form-group">
                <select class="form-control" name="selectedDay">
                    <option value="Senin" <?= $selectedDay == 'Senin' ? 'selected' : '' ?>>Senin</option>
                    <option value="Selasa" <?= $selectedDay == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
                    <option value="Rabu" <?= $selectedDay == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
                    <option value="Kamis" <?= $selectedDay == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
                    <option value="Jumat" <?= $selectedDay == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
                    <option value="Sabtu" <?= $selectedDay == 'Sabtu' ? 'selected' : '' ?>>Sabtu</option>
                    <option value="Minggu" <?= $selectedDay == 'Minggu' ? 'selected' : '' ?>>Minggu</option>
                </select>
            </div>
            <div class="form-group ml-2">
                <input type="text" value="<?= isset($keyword) ? $keyword : '' ?>" name="keyword" autofocus autocomplete="off" class="form-control bg-grey border small" style="width: 800px;" placeholder="Cari Nama Dosen" aria-label="Search" aria-describedby="basic-addon2">
            </div>
            <div class="form-group">
                <input class="btn btn-info ml-2" type="submit" name="search" value="Search">
            </div>
        </form>
        <?php if ($no_data) : ?>
            <p>Tidak ada data</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Hari</th>
                            <th scope="col">Nama Pemilik</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Last Seen</th>
                            <th scope="col">Nama Ruang</th>
                            <th scope="col">Lantai</th>
                            <th scope="col">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leases as $index => $result) : ?>
                            <tr>
                                <td><?= $selectedDay ?></td>
                                <td><?= $result['nama_pemilik'] ?></td>
                                <td><?= $result['jenis'] ?></td>
                                <td><?= $result['last_seen'] ?></td>
                                <td><?= $result['nama_ruang'] ?></td>
                                <td><?= $result['lantai'] ?></td>
                                <td><?= $result['waktu_ambil'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>