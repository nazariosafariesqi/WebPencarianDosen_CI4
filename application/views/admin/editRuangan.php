<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class="row">
        <div class="col-lg">
            <?= form_error('nama_ruang', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('no_ruang', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('gateway', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= form_error('nama-ruang', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('no-ruang', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('gateway-edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRuanganModal">Add Ruangan</a>
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
                    <?php $i = $offset + 1; ?>
                    <?php foreach ($ruangan as $r) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $r['no_ruang']; ?></td>
                            <td><?= $r['nama_ruang']; ?></td>
                            <td><?= $r['gateway']; ?></td>
                            <td><?= $r['lantai']; ?></td>
                            <td>
                                <a href="" class="badge badge-success" id="edit-ruangan" data-id="<?= $r['id']; ?>" data-no="<?= $r['no_ruang']; ?>" data-ruang="<?= $r['nama_ruang']; ?>" data-gateway="<?= $r['gateway']; ?>" data-lantai="<?= $r['lantai']; ?>" data-toggle="modal" data-target="#editRuanganModal">Edit</a>
                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteRuanganModal"> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>
</div>

</div>

<!-- Modal Add Ruang -->
<div class="modal fade" id="newRuanganModal" tabindex="-1" role="dialog" aria-labelledby="newRuanganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRuanganModalLabel">Add Ruangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/insertRuangan'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_ruang">Nomor Ruang</label>
                        <input type="text" class="form-control" id="no_ruang" name="no_ruang" placeholder="Enter No Ruang">
                    </div>
                    <div class="form-group">
                        <label for="name_ruang">Nama Ruang</label>
                        <input type="text" class="form-control" id="nama_ruang" name="nama_ruang" placeholder="Enter Nama Ruang">
                    </div>
                    <div class="form-group">
                        <label for="gateway">Gateway</label>
                        <input type="text" class="form-control" id="gateway" name="gateway" placeholder="Enter Gateway Number">
                    </div>
                    <div class="form-group">
                        <label for="lantai">Lantai</label>
                        <select class="form-control w-26" id="lantai" name="lantai">
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add-ruangan" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit / Update -->
<div class="modal fade" id="editRuanganModal" tabindex="-1" role="dialog" aria-labelledby="editRuanganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRuanganModalLabel">Edit Ruangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/updateRuangan'); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="no-ruang">Nomor Ruang</label>
                        <input type="text" class="form-control" id="no-ruang" name="no-ruang" placeholder="Enter No Ruang">
                    </div>
                    <div class="form-group">
                        <label for="nama-ruang">Nama Ruang</label>
                        <input type="text" class="form-control" id="nama-ruang" name="nama-ruang" placeholder="Enter Nama Ruang">
                    </div>
                    <div class="form-group">
                        <label for="gateway-edit">Gateway</label>
                        <input type="text" class="form-control" id="gateway-edit" name="gateway-edit" placeholder="Enter Gateway Number">
                    </div>
                    <div class="form-group">
                        <label for="lantai">Lantai</label>
                        <select class="form-control w-26" id="lantai" name="lantai">
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="update-ruangan" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete User-->
<div class="modal fade" id="deleteRuanganModal" tabindex="-1" role="dialog" aria-labelledby="deleteRuanganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRuanganModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete Ruangan ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="<?= base_url('Admin/deleteRuangan/' . $r['id']); ?>">Delete</a>
            </div>
        </div>
    </div>
</div>