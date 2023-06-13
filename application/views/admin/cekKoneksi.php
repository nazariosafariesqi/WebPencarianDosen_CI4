<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8 ml-4">
            <?php
            require('api.php');
            // Koneksi database
            $servername = "localhost";
            $username = "root";
            $password = "nazario123";
            $dbname = "wpd";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Koneksi database gagal: " . $conn->connect_error);
            } else {
                echo "Koneksi database berhasil & ";
            }

            $API = new RouterOSAPI();
            $query = $conn->query("SELECT ip_address FROM router");
            $routerIPs = array();

            while ($row = $query->fetch_assoc()) {
                $routerIPs[] = $row['ip_address'];
            }

            $dataInserted = true; // Flag untuk menandakan apakah semua data berhasil dimasukkan ke dalam variabel

            foreach ($routerIPs as $routerIP) {
                if ($API->connect($routerIP, 'nazario', 'n4z4r10')) {
                    echo "<br>Koneksi ke Mikrotik ($routerIP) sukses" . "<br>";

                    // Mengambil IP address
                    $API->write('/ip/address/print');
                    $ipAddresses = $API->read();

                    // Mengambil DHCP leases
                    $API->write('/ip/dhcp-server/lease/print');
                    $leases = $API->read();

                    foreach ($leases as $lease) {
                        if (isset($lease['mac-address'])) {
                            echo "<br> MAC: " . $lease['mac-address'];
                        }

                        if (isset($lease['host-name'])) {
                            echo "<br> Active Host Name: " . $lease['host-name'];
                        }

                        if (isset($lease['expires-after'])) {
                            echo "<br> Time Expires: " . $lease['expires-after'];
                        }

                        if (isset($lease['last-seen'])) {
                            echo "<br> Last Seen: " . $lease['last-seen'] . "<br>";
                        }
                    }
                    $API->disconnect();
                }
            }
            ?>

            <br><br><br><br>
            <div class="row">
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-success mb-3">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>