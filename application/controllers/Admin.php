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

    public function Router()
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

    public function Pemilik()
    {
        $data['title'] = 'Edit Pemilik';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['pemilik'] = $this->db->get('pemilik')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar2', $data);
        $this->load->view('admin/Pemilik', $data);
        $this->load->view('templates/footer');
    }

    public function insertPemilik()
    {
        $data['title'] = 'Add Pemilik';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['pemilik'] = $this->db->get('pemilik')->result_array();

        $this->form_validation->set_rules('mac_address', 'Mac Address', 'required|trim|is_unique[pemilik.mac_address]', [
            'is_unique' => 'Mac Address is already registered!'
        ]);
        $this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'required|trim|min_length[3]', [
            'min_length' => 'Name too short!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar2', $data);
            $this->load->view('admin/Pemilik', $data);
            $this->load->view('templates/footer');
        } else {
            $jenis_id = $this->input->post('jenis_id');
            if ($jenis_id == 1) {
                $jenis = 'Laptop';
            } elseif ($jenis_id == 2) {
                $jenis = 'Handphone';
            } elseif ($jenis_id == 3) {
                $jenis = 'PC';
            } elseif ($jenis_id == 4) {
                $jenis = 'Lainnya';
            }

            $this->db->insert(
                'pemilik',
                [
                    'nama_pemilik' => $this->input->post('nama_pemilik'),
                    'mac_address' => $this->input->post('mac_address'),
                    'jenis' => $jenis,
                    'jenis_id' => $jenis_id,
                    'date_created' => date('Y-m-d H:i:s')
                ]
            );

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
                    New Pemilik Added
                    </div>'
            );
            redirect('admin/Pemilik');
        }
    }

    public function updatePemilik()
    {
        $data['title'] = 'Edit Pemilik';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['pemilik'] = $this->db->get('pemilik')->result_array();

        $this->form_validation->set_rules(
            'mac-address',
            'Mac Address',
            'required|trim|callback_check_mac_address',
            [
                'is_unique' => 'Mac Address is already registered!',
                'check_mac_address' => 'Mac Address is already registered!'
            ]
        );
        $this->form_validation->set_rules('nama-pemilik', 'Nama Pemilik', 'required|trim|min_length[3]', [
            'min_length' => 'Name too short!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar2', $data);
            $this->load->view('Admin/Pemilik', $data);
            $this->load->view('templates/footer');
        } else {
            $jenis_id = $this->input->post('jenis_id');
            $jenis = '';

            if ($jenis_id == 1) {
                $jenis = 'Laptop';
            } elseif ($jenis_id == 2) {
                $jenis = 'Handphone';
            } elseif ($jenis_id == 3) {
                $jenis = 'PC';
            } elseif ($jenis_id == 4) {
                $jenis = 'Lainnya';
            }

            $user_id = $this->input->post('user_id');
            $nama_pemilik = $this->input->post('nama-pemilik');
            $mac_address = $this->input->post('mac-address');

            $data = [
                'nama_pemilik' => $nama_pemilik,
                'mac_address' => $mac_address,
                'jenis' => $jenis,
                'jenis_id' => $jenis_id
            ];

            if (!empty($nama_pemilik)) {
                $data['nama_pemilik'] = $nama_pemilik;
            }

            if (!empty($mac_address)) {
                $data['mac_address'] = $mac_address;
            }

            if (!empty($jenis_id)) {
                $data['jenis_id'] = $jenis_id;
            }

            $this->db->where('id', $user_id);
            $this->db->update('pemilik', $data);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
                    Data Pemilik Updated
                </div>'
            );
            redirect('Admin/Pemilik');
        }
    }

    public function check_mac_address($mac_address)
    {
        $user_id = $this->input->post('user_id');
        $existingUser = $this->db->get_where('pemilik', ['mac_address' => $mac_address])->row_array();

        if ($existingUser && $existingUser['id'] != $user_id) {
            return FALSE; // MAC address sudah terdaftar oleh pengguna lain
        }
        return TRUE; // MAC address tersedia atau tidak diganti
    }

    public function deletePemilik($user_id)
    {
        $this->db->where('id', $user_id);
        $this->db->delete('pemilik');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
            Data Pemilik Deleted
        </div>'
        );
        redirect('Admin/Pemilik');
    }

    public function Ruangan()
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

    public function leases()
    {
        $data['title'] = 'Connect to Mikrotik';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/leases', $data);
        $this->load->view('templates/footer');
    }
}
