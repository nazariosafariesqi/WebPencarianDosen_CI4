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
                    <option value="Monday" <?= $selectedDay == 'Monday' ? 'selected' : '' ?>>Senin</option>
                    <option value="Tuesday" <?= $selectedDay == 'Tuesday' ? 'selected' : '' ?>>Selasa</option>
                    <option value="Wednesday" <?= $selectedDay == 'Wednesday' ? 'selected' : '' ?>>Rabu</option>
                    <option value="Thursday" <?= $selectedDay == 'Thursday' ? 'selected' : '' ?>>Kamis</option>
                    <option value="Friday" <?= $selectedDay == 'Friday' ? 'selected' : '' ?>>Jumat</option>
                    <option value="Saturday" <?= $selectedDay == 'Saturday' ? 'selected' : '' ?>>Sabtu</option>
                    <option value="Sunday" <?= $selectedDay == 'Sunday' ? 'selected' : '' ?>>Minggu</option>
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
                            <th scope="col">Day</th>
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
                                <th><?= $selectedDay ?></th>
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