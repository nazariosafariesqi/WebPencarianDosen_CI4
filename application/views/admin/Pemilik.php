<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class="row">
        <div class="col-lg">
            <?= form_error('nama_pemilik', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('mac_address', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newPemilikModal">Add Pemilik</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Pemilik</th>
                        <th scope="col">Mac Address</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($pemilik as $p) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $p['nama_pemilik']; ?></td>
                            <td><?= $p['mac_address']; ?></td>
                            <td><?= $p['jenis']; ?></td>
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

<!-- Modal Add New Pemilik -->
<div class="modal fade" id="newPemilikModal" tabindex="-1" role="dialog" aria-labelledby="newPemilikModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPemilikModalLabel">Add Pemilik Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/insertPemilik'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_pemilik">Nama Pemilik</label>
                        <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="mac_address">Mac Address</label>
                        <input type="text" class="form-control" id="mac_address" name="mac_address" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="jenis_id">Jenis</label>
                        <select class="form-control w-26" id="jenis_id" name="jenis_id">
                            <option value="1">Laptop</option>
                            <option value="2">Handphone</option>
                            <option value="3">PC</option>
                            <option value="4">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit / Update -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('UserManage/update'); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name-edit" name="name-edit" placeholder="Edit name" id="user_id" data-id="<?= $u['name'] ?>;">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email-edit" name="email-edit" aria-describedby="emailHelp" placeholder="Edit email" id="user_id" data-id="<?= $u['email'] ?>;">
                    </div>
                    <div class="password">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password1" name="password1" placeholder="New password">
                    </div>
                    <div class="password">
                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Re-type password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Pemilik-->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="<?= base_url('UserManage/delete/' . $u['id']); ?>">Delete</a>
            </div>
        </div>
    </div>
</div>