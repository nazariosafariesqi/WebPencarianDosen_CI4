<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class="row">
        <div class="col-lg">
            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newPemilikModal">Add Pemilik</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nomor Ruang</th>
                        <th scope="col">Nama Ruang</th>
                        <th scope="col">Gateway</th>
                        <th scope="col">Lantai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($ruangan as $r) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $r['no_ruang']; ?></td>
                            <td><?= $r['nama_ruang']; ?></td>
                            <td><?= $r['gateway']; ?></td>
                            <td><?= $r['lantai']; ?></td>
                            <td>
                                <a href="" class="badge badge-success" id="edit-pemilik" data-id="<?= $p['id']; ?>" data-mac="<?= $p['mac_address']; ?>" data-jenis="<?= $p['jenis']; ?>" data-pemilik="<?= $p['nama_pemilik']; ?>" data-toggle="modal" data-target="#editPemilikModal">Edit</a>
                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deletePemilikModal"> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>