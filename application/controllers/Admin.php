<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard Leases Admin';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['leases'] = $this->db->get('leases')->result_array();
        $data['user'] = $this->db->get('user')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar2', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');

        $data['leases'] = $this->getLeasesFromDatabase(); // Mendapatkan data leases dari database
    }

    private function getLeasesFromDatabase()
    {
        // Koneksi database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "wpd";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Koneksi database gagal: " . $conn->connect_error);
        }

        // Query untuk mendapatkan data leases
        $sql = "SELECT * FROM leases";
        $result = $conn->query($sql);

        $leases = array();

        if ($result->num_rows > 0) {
            // Loop melalui hasil query dan tambahkan data leases ke array
            while ($row = $result->fetch_assoc()) {
                $leases[] = $row;
            }
        }

        $conn->close();

        return $leases;
    }

    public function editRouter()
    {
        $data['title'] = 'Edit Router';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/editRouter', $data);
        $this->load->view('templates/footer');
    }

    public function editPemilik()
    {
        $data['title'] = 'Edit Pemilik';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/editPemilik', $data);
        $this->load->view('templates/footer');
    }

    public function editRuangan()
    {
        $data['title'] = 'Edit Ruangan';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/editRuangan', $data);
        $this->load->view('templates/footer');
    }
}
