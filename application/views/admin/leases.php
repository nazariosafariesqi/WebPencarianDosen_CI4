<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8 ml-4">
            <?php
            require('api.php');

            // Koneksi database
            $servername = "127.0.0.1";
            $username = "root";
            $password = "nazario123";
            $dbname = "wpd";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Koneksi database gagal: " . $conn->connect_error . "<br>");
            } else {
                echo "Koneksi database berhasil <br>";
            }

            $API = new RouterOSAPI();
            $query = $conn->query("SELECT ip_address FROM router");
            $routerIPs = array();
            $success = true; // Inisialisasi flag

            while ($row = $query->fetch_assoc()) {
                $routerIPs[] = $row['ip_address'];
            }

            foreach ($routerIPs as $routerIP) {
                if ($API->connect($routerIP, 'nazario', 'n4z4r10')) {
                    echo "<br>Koneksi ke Mikrotik ($routerIP) sukses";

                    // Mengambil IP address
                    $API->write('/ip/address/print');
                    $ipAddresses = $API->read();

                    //echo "IP Address: ";
                    foreach ($ipAddresses as $address) {
                        $ipAddress = $address['address'];
                    }

                    // Mengambil DHCP leases
                    $API->write('/ip/dhcp-server/lease/print');
                    $leases = $API->read();

                    //echo "<br>DHCP Leases:";
                    foreach ($leases as $lease) {
                        //var_dump($lease);
                        if (isset($lease['address'])) {
                            $ipAddress = $lease['address'];
                        }

                        if (isset($lease['mac-address'])) {
                            $macAddress = $lease['mac-address'];
                        }

                        if (isset($lease['host-name'])) {
                            $activeHostName = $lease['host-name'];
                        }

                        if (isset($lease['expires-after'])) {
                            $timeExpires = $lease['expires-after'];
                        }

                        if (isset($lease['last-seen'])) {
                            $lastSeen = $lease['last-seen'];
                        }

                        $existingData = $conn->query("SELECT * FROM leases WHERE waktu_ambil = CURDATE() AND ip_address = '$ipAddress' AND last_seen = '$lastSeen' AND time_expires = '$timeExpires'");

                        if ($existingData->num_rows > 0) {
                            // Jika data dengan waktu dan IP address yang sama sudah ada, abaikan dan tidak perlu memasukkan data baru
                            echo "Data dengan waktu dan IP address yang sama sudah ada dalam database.";
                        } else {
                            // Jika data dengan waktu dan IP address yang sama belum ada, masukkan data baru
                            $sqlInsert = "INSERT INTO leases (ip_address, mac_address, active_host_name, time_expires, last_seen)
                        VALUES ('$ipAddress', '$macAddress', '$activeHostName', '$timeExpires', '$lastSeen')";

                            if ($conn->query($sqlInsert) !== TRUE) {
                                $success = false;
                                echo "Terjadi kesalahan saat memasukkan data ke dalam database: " . $conn->error;
                            }
                        }
                    }
                    $API->disconnect();
                } else {
                    echo "<br>Tidak bisa terhubung ke Mikrotik ($routerIP) ";
                    echo $API->error_str;
                    $success = false;
                    continue; // Melanjutkan iterasi ke router berikutnya jika koneksi gagal
                }
            }
            if ($success) {
                echo "<br><br>Proses selesai. Data berhasil dimasukkan ke dalam database.";
            }
            ?>
            <br><br><br><br>
            <div class="row">
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-success mb-3">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>
</div>