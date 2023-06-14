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
                    <option value="Monday">Senin</option>
                    <option value="Tuesday">Selasa</option>
                    <option value="Wednesday">Rabu</option>
                    <option value="Thursday">Kamis</option>
                    <option value="Friday">Jumat</option>
                    <option value="Saturday">Sabtu</option>
                    <option value="Sunday">Minggu</option>
                </select>
            </div>
            <div class="form-group ml-2">
                <input type="text" value="<?= isset($keyword) ? $keyword : '' ?>" name="keyword" autofocus autocomplete="off" class="form-control bg-grey border small" style="width: 800px;" placeholder="Cari Nama Dosen" aria-label="Search" aria-describedby="basic-addon2">
            </div>
            <div class="form-group">
                <input class="btn btn-info ml-2" type="submit" name="search" value="Search">
            </div>
        </form>
    </div>
</div>
</div>