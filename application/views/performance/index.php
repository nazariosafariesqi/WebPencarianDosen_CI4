<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Lama Eksekusi</th>
                        <th scope="col">Jumlah Data</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = $offset + 1; ?>
                    <?php foreach ($eksekusi as $e) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $e['lama_eksekusi']; ?></td>
                            <td><?= $e['jumlah_data']; ?></td>
                            <td><?= $e['waktu']; ?></td>
                        </tr>
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