<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-11">
            <?= form_error('ip_address', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('nama_router', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= form_error('nama-router', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('ip-edit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRouterModal">Add Router</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Router</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = $offset + 1; ?>
                    <?php foreach ($router as $ro) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $ro['nama_router']; ?></td>
                            <td><?= $ro['ip_address']; ?></td>
                            <td>
                                <a href="" class="badge badge-success" id="edit-router" data-id="<?= $ro['id']; ?>" data-nama="<?= $ro['nama_router']; ?>" data-ip="<?= $ro['ip_address']; ?>" data-toggle="modal" data-target="#editRouterModal">Edit</a>
                                <a href="" class="badge badge-danger" data-toggle="modal" id="btn-delete" data-delete="<?= $ro['id']; ?>" data-target="#deleteRouterModal"> Delete</a>
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

<!-- Modal Add Router -->
<div class="modal fade" id="newRouterModal" tabindex="-1" role="dialog" aria-labelledby="newRouterModalLabel" data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRouterModalLabel">Add Router</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/insertRouter'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_router">Nama Router</label>
                        <input type="text" class="form-control" id="nama_router" name="nama_router" placeholder="Enter Nama Router">
                    </div>
                    <div class="form-group">
                        <label for="ip_address">IP Address</label>
                        <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="Enter IP Address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add-router" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit / Update -->
<div class="modal fade" id="editRouterModal" tabindex="-1" role="dialog" aria-labelledby="editRouterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRouterModalLabel">Edit Ruangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/updateRouter'); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="nama-router">Nama Router</label>
                        <input type="text" class="form-control" id="nama-router" name="nama-router" placeholder="Enter Nama Router">
                    </div>
                    <div class="form-group">
                        <label for="ip-edit">IP Address</label>
                        <input type="text" class="form-control" id="ip-edit" name="ip-edit" placeholder="Enter IP Address">
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
<div class="modal fade" id="deleteRouterModal" tabindex="-1" role="dialog" aria-labelledby="deleteRouterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRouterModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/deleteRouter'); ?>" method="POST">
                <div class="modal-body">
                    <p>Are you sure you want to delete Router ?</p>
                    <input type="hidden" name="user_id" id="user_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit" name="delete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>