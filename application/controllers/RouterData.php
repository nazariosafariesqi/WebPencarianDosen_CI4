<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RouterData extends CI_Controller
{
    function getRouterData($ipAddress, $username, $password, $command)
    {
        require('api.php');
        $API = new RouterOSAPI();

        if ($API->connect($ipAddress, $username, $password)) {
            $API->write("/" . $command . "", true);
            $read = $API->read(false);
            $data = array();
            foreach ($read as $item) {
                $data[] = $item;
            }
            $API->disconnect();
            return $data;
        } else {
            return "Failed to connect to MikroTik router.";
            echo $API->error_str;
        }

        $routerList = array(
            array("ipAddress" => "192.168.73.1", "username" => "nazario", "password" => "nazario")
            //array("ipAddress" => "192.168.1.2", "username" => "nazario", "password" => "nazario"),
            //array("ipAddress" => "192.168.1.3", "username" => "nazario", "password" => "nazario")
        );

        $routerData = array();
        foreach ($routerList as $router) {
            $ipAddress = $router["ipAddress"];
            $username = $router["username"];
            $password = $router["password"];
            $data = getRouterData($ipAddress, $username, $password, "/ip/dhcp-server/lease/print");
            $routerData[] = $data;
        }
    }
}
