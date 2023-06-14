<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg-12 ml-4">
        <form action="<?= base_url(''); ?>" method="GET" class="form-inline mb-4">
            <div class="form-group">
                <div class="input-group" id="datepicker" data-target-input="nearest">
                    <input type="text" class="form-control datepicker" data-toggle="datepicker" data-target="#datepicker" />
                    <div class="input-group-append" data-target="#datepicker" data-toggle="datepicker">

                    </div>
                </div>
            </div>
        </form>
        <form action="<?= base_url(''); ?>" method="GET" class="form-inline">
            <div class="form-group">
                <input type="text" value="<?= isset($keyword) ? $keyword : '' ?>" name="keyword" autofocus autocomplete="off" class="form-control bg-grey border small" style="width: 800px;" placeholder="Cari Nama Dosen" aria-label="Search" aria-describedby="basic-addon2">
            </div>
            <div class="input-group-append">
                <input class="btn btn-info ml-2" type="submit" name="search" value="Search">
            </div>
        </form>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<script>
    jQuery(function($) {
        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>