<?php

// Connect to Mikrotik Router API
$API = new RouterosAPI();
$API->debug = false;
$API->connect('192.168.1.1', 'admin', 'password');

// Check if the form is submitted
if (isset($_POST['search'])) {
    // Get the search query
    $mac_address = $_POST['search'];

    // Get DHCP leases from Mikrotik Router
    $API->write('/ip/dhcp-server/lease/print', false);
    $API->write('=.proplist=.id,address,mac-address,host-name');
    $API->write('?mac-address=' . $mac_address);
    $lease = $API->read();

    // Check if the MAC address was found
    if (count($lease) > 0) {
        $lease = $lease[0];
        $name = $lease['host-name'];
        $email = "";
    } else {
        $name = "Not found";
        $email = "";
    }

    // Return the results in JSON format
    echo json_encode(array(
        'name' => $name,
        'email' => $email,
        'mac_address' => $mac_address
    ));
    exit;
}
?>
