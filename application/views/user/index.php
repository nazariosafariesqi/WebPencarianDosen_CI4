<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8 ml-4">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card mb-4" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-fluid rounded-start" style="margin: 10px;">
            </div>
            <div class="col-md-8 d-flex align-items-center">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['name']; ?></h5>
                    <p class="card-text"><?= $user['email']; ?></p>
                    <p class="card-text"><small class="text-body-secondary"><?= $user['role'] ?> Since <?= date('d F Y', strtotime($user['date_created'])); ?></small></p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End of Main Content -->