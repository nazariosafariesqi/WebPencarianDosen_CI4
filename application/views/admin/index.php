<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

</div>

<div class="col">
    <?php
    require('api.php');

    // Koneksi database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "wpd";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    } else {
        echo "Koneksi database berhasil & ";
    }

    $API = new RouterOSAPI();

    if ($API->connect('192.168.88.1', 'nazario', 'nazario')) {
        $API->debug = true;
        echo "Koneksi Mikrotik Sukses ";
    } else {
        echo "Tidak Bisa Koneksi ke Mikrotik ";
        echo $API->error_str;
    }
    ?>
</div>

</div>
<!-- End of Main Content -->