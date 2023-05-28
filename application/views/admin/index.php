<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <a type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#connectModal">Connect Mikrotik</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Ip Address</th>
                        <th scope="col">Mac Address</th>
                        <th scope="col">Host Name</th>
                        <th scope="col">Expires</th>
                        <th scope="col">Last Seen</th>
                        <th scope="col">Waktu Ambil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($leases as $l) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $l['ip_address']; ?></td>
                            <td><?= $l['mac_address']; ?></td>
                            <td><?= $l['active_host_name']; ?></td>
                            <td><?= $l['time_expires']; ?></td>
                            <td><?= $l['last_seen']; ?></td>
                            <td><?= $l['waktu_ambil']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Add New User -->
<div class="modal fade" id="connectModal" tabindex="-1" role="dialog" aria-labelledby="connectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="connectModalLabel">Connect to Mikrotik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

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
                $routerIPs = array('192.168.88.1'); // Daftar IP router
                //, '192.168.73.1','192.168.60.1', '192.168.56.1'

                foreach ($routerIPs as $routerIP) {
                    if ($API->connect($routerIP, 'nazario', 'n4z4r10')) {
                        echo "Koneksi ke Mikrotik ($routerIP) sukses" . "<br>";

                        // Mengambil IP address
                        $API->write('/ip/address/print');
                        $ipAddresses = $API->read();

                        //echo "IP Address: ";
                        foreach ($ipAddresses as $address) {
                            $address['address'];
                        }

                        // Mengambil DHCP leases
                        $API->write('/ip/dhcp-server/lease/print');
                        $leases = $API->read();

                        //echo "<br>DHCP Leases:";
                        foreach ($leases as $lease) {
                            //var_dump($lease);
                            $lease['address'];

                            if (isset($lease['mac-address'])) {
                                $lease['mac-address'];
                            }

                            if (isset($lease['host-name'])) {
                                $lease['host-name'];
                            }

                            if (isset($lease['expires-after'])) {
                                $lease['expires-after'];
                            }

                            if (isset($lease['last-seen'])) {
                                $lease['last-seen'];
                            }

                            // Memasukkan data ke dalam database
                            $ipAddress = isset($lease['address']) ? $lease['address'] : '';
                            $macAddress = isset($lease['mac-address']) ? $lease['mac-address'] : '';
                            $activeHostName = isset($lease['host-name']) ? $lease['host-name'] : '';
                            $timeExpires = isset($lease['expires-after']) ? $lease['expires-after'] : '';
                            $lastSeen = isset($lease['last-seen']) ? $lease['last-seen'] : '';

                            $sql = "INSERT INTO leases (ip_address, mac_address, active_host_name, time_expires, last_seen)
                    VALUES ('$ipAddress', '$macAddress', '$activeHostName', '$timeExpires', '$lastSeen')";

                            if ($conn->query($sql) === TRUE) {
                                echo "<br>Data berhasil dimasukkan ke dalam database";
                            } else {
                                echo "<br>Terjadi kesalahan saat memasukkan data ke dalam database: " . $conn->error;
                            }
                        }
                        $API->disconnect();
                    } else {
                        echo "Tidak bisa terhubung ke Mikrotik ($routerIP)";
                        echo $API->error_str;
                    }
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>