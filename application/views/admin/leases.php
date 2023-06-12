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
            $password = "";
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
            $leasesData = array();
            $ipAddress = '';
            $macAddress = '';
            $activeHostName = '';
            $timeExpires = '';
            $lastSeen = '';
            $success = true; // Inisialisasi flag

            while ($row = $query->fetch_assoc()) {
                $routerIPs[] = $row['ip_address'];
            }

            foreach ($routerIPs as $routerIP) {
                if ($API->connect($routerIP, 'nazario', 'n4z4r10')) {
                    echo "<br>Koneksi ke Mikrotik ($routerIP) sukses" . "<br>";

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

                        $leasesData[] = array(
                            'ip_address' => $ipAddress,
                            'mac_address' => $macAddress,
                            'active_host_name' => $activeHostName,
                            'time_expires' => $timeExpires,
                            'last_seen' => $lastSeen
                        );
                    }

                    // Memasukkan data ke dalam database
                    foreach ($leasesData as $leaseData) {
                        $ipAddress = $leaseData['ip_address'];
                        $macAddress = $leaseData['mac_address'];
                        $activeHostName = $leaseData['active_host_name'];
                        $timeExpires = $leaseData['time_expires'];
                        $lastSeen = $leaseData['last_seen'];

                        $sql = "INSERT INTO leases (ip_address, mac_address, active_host_name, time_expires, last_seen)
                                VALUES ('$ipAddress', '$macAddress', '$activeHostName', '$timeExpires', '$lastSeen')";

                        if ($conn->query($sql) !== TRUE) {
                            $success = false; // Set flag menjadi false jika terjadi kesalahan saat memasukkan data ke dalam database
                            echo "Terjadi kesalahan saat memasukkan data ke dalam database: " . $conn->error;
                            break; // Berhenti loop jika terjadi kesalahan
                        }
                    }

                    if ($success) {
                        echo "Data berhasil dimasukkan ke dalam database";
                    }
                    $API->disconnect();
                } else {
                    echo " Tidak bisa terhubung ke Mikrotik ($routerIP)";
                    echo $API->error_str;
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
</div>