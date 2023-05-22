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
    $routerIPs = array('192.168.88.1'); // Daftar IP router

    foreach ($routerIPs as $routerIP) {
        if ($API->connect($routerIP, 'nazario', 'nazario')) {
            echo "Koneksi ke Mikrotik ($routerIP) sukses" . "<br>";

            // Mengambil IP address
            $API->write('/ip/address/print');
            $ipAddresses = $API->read();

            echo "IP Address:";
            foreach ($ipAddresses as $address) {
                echo $address['address'];
            }

            // Mengambil DHCP leases
            $API->write('/ip/dhcp-server/lease/print');
            $leases = $API->read();

            echo "<br> DHCP Leases = ";
            foreach ($leases as $lease) {
                //var_dump($lease);
                echo " <br> IP: " . $lease['address'] . "<br> MAC: " . $lease['mac-address']
                    . "<br> Active Host Name: " . $lease['host-name']
                    . "<br> Time Expires: " . $lease['expires-after']
                    . "<br> LastSeen: " . $lease['last-seen'];
            }

            $API->disconnect();
        } else {
            echo "Tidak bisa terhubung ke Mikrotik ($routerIP)";
            echo $API->error_str;
        }
    }

    //$API = new RouterOSAPI();

    //if ($API->connect('192.168.88.1', 'nazario', 'nazario')) {
    //    $API->debug = true;
    //    echo "Koneksi Mikrotik Sukses ";
    //} else {
    //    echo "Tidak Bisa Koneksi ke Mikrotik ";
    //    echo $API->error_str;
    //}

    // Mengambil MAC address
    //$API->write('/interface/ethernet/print');
    //$ethernetInterfaces = $API->read();

    //echo "MAC Address:" . PHP_EOL;
    //foreach ($ethernetInterfaces as $interface) {
    //    echo "- " . $interface['mac-address'] . PHP_EOL;
    //}
    ?>
</div>

</div>
<!-- End of Main Content -->