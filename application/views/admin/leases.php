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

            // Start timer
            $start_time = microtime(true);

            $API = new RouterOSAPI();
            $query = $conn->query("SELECT ip_address FROM router");
            $routerIPs = array();
            $success = true; // Inisialisasi flag
            $totalData = 0; // Inisialisasi variabel untuk menyimpan jumlah data yang diambil
            $macAddresses = array(); // Array untuk melacak mac address yang sudah ada

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

                        // Memeriksa keberadaan data dalam database
                        $existingData = $conn->query("SELECT * FROM leases WHERE waktu_ambil = CURDATE() AND ip_address = '$ipAddress' AND last_seen = '$lastSeen' AND time_expires = '$timeExpires'");

                        if ($existingData->num_rows > 0) {
                            // Jika data dengan waktu dan IP address yang sama sudah ada, abaikan dan tidak perlu memasukkan data baru
                            echo "Data dengan waktu dan IP address yang sama sudah ada dalam database.";
                        } else {
                            // Jika data dengan waktu dan IP address yang sama belum ada, masukkan data baru
                            $sqlInsert = "INSERT INTO leases (ip_address, mac_address, active_host_name, time_expires, last_seen)
                    VALUES ('$ipAddress', '$macAddress', '$activeHostName', '$timeExpires', '$lastSeen')";

                            if (in_array($macAddress, $macAddresses)) {
                                // Jika mac address sudah ada dalam array, abaikan data ini
                                continue;
                            } else {
                                // Jika mac address belum ada dalam array, tambahkan ke array dan tambahkan jumlah data
                                $macAddresses[] = $macAddress;
                                $totalData++;
                            }

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

            // Stop timer
            $end_time = microtime(true);
            $execution_time = $end_time - $start_time;
            echo "<br> Lama eksekusi: " . round($execution_time, 2) . " detik";

            // Menampilkan jumlah data yang diambil berdasarkan setiap mac address
            echo "<br> Jumlah Data yang di ambil : " . $totalData . "<br><br>";

            // Memasukkan waktu eksekusi, jumlah data, tanggal, dan waktu ke dalam tabel eksekusi
            $sqlInsertExecution = "INSERT INTO eksekusi (lama_eksekusi, jumlah_data, waktu) VALUES ('$execution_time', '$totalData', NOW())";

            if ($conn->query($sqlInsertExecution) !== TRUE) {
                $success = false;
                echo "Terjadi kesalahan saat memasukkan data eksekusi ke dalam database: " . $conn->error;
            }

            // Mengambil data dari tabel eksekusi
            $sqlSelectExecution = "SELECT * FROM eksekusi ORDER BY waktu DESC LIMIT 5";
            $result = $conn->query($sqlSelectExecution);

            if ($result->num_rows > 0) {
                // Menampilkan tabel eksekusi jika terdapat data
                echo '<br><h4>Mikrotik Performance</h4>';
                echo '<table class="table">
                    <thead>
                        <tr>
                            <th>Lama Eksekusi</th>
                            <th>Jumlah Data</th>
                            <th>Tanggal Waktu</th>
                        </tr>
                    </thead>
                    <tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                        <td>' . $row['lama_eksekusi'] . ' detik</td>
                        <td>' . $row['jumlah_data'] . '</td>
                        <td>' . $row['waktu'] . '</td>
                      </tr>';
                }

                echo '</tbody>
                </table>';
            } else {
                // Menampilkan pesan jika tidak ada data dalam tabel eksekusi
                echo '<p>Tidak ada data dalam tabel eksekusi.</p>';
            }
            ?>

            <br><br>
            <div class="row">
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-success mb-3">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>
</div>