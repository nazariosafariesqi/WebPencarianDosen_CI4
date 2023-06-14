<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

</div>
<!-- /.container-fluid -->
<div class="row">
    <div class="col-lg ml-2 p-4">
        <form action="<?= base_url('User/hasilSearch'); ?>" method="GET" class="form-inline mb-4">
            <div class="form-group">
                <input type="text" value="<?= isset($keyword) ? $keyword : '' ?>" name="keyword" autofocus autocomplete="off" class="form-control bg-grey border small" style="width: 800px;" placeholder="Cari Nama Dosen" aria-label="Search" aria-describedby="basic-addon2">
            </div>
            <div class="input-group-append">
                <input class="btn btn-info ml-2" type="submit" name="search" value="Search"></input>
            </div>
        </form>
    </div>
</div>
</div>
<!-- End of Main Content -->