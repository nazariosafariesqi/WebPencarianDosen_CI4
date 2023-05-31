<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['title'] = 'Dashboard Leases Admin';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $config['base_url'] = base_url('admin/index'); // URL base halaman
        $config['total_rows'] = $this->db->count_all('leases'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 7; // Jumlah data per halaman
        $config['uri_segment'] = 3; // URI segment yang menyimpan nomor halaman
        $config['num_links'] = 1; // Jumlah link pagination yang ditampilkan di sekitar halaman aktif
        $config['use_page_numbers'] = TRUE; // Menggunakan nomor halaman bukan offset

        //style
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $limit = $config['per_page'];
        $offset = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) * $config['per_page'] : 0;
        $this->db->limit($limit, $offset);
        $data['leases'] = $this->db->get('leases')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar2', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function Search()
    {
        $data['title'] = 'Dashboard Leases Admin';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $keyword = $this->input->get('keyword');

        if ($keyword) {
            $this->session->set_userdata('search_keyword', $keyword);
        } else {
            $keyword = $this->session->userdata('search_keyword');
        }

        $config['base_url'] = base_url('admin/search'); // URL base halaman
        $config['total_rows'] = $this->db->like('ip_address', $keyword)
            ->or_like('mac_address', $keyword)
            ->or_like('active_host_name', $keyword)
            ->or_like('time_expires', $keyword)
            ->or_like('last_seen', $keyword)
            ->or_like('waktu_ambil', $keyword)
            ->count_all_results('leases'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 7; // Jumlah data per halaman
        $config['uri_segment'] = 3; // URI segment yang menyimpan nomor halaman
        $config['num_links'] = 1; // Jumlah link pagination yang ditampilkan di sekitar halaman aktif
        $config['use_page_numbers'] = TRUE; // Menggunakan nomor halaman bukan offset

        //style
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $limit = $config['per_page'];
        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 1;
        $offset = ($page - 1) * $limit;

        $this->db->limit($limit, $offset);
        $this->db->group_start()
            ->like('ip_address', $keyword)
            ->or_like('mac_address', $keyword)
            ->or_like('active_host_name', $keyword)
            ->or_like('time_expires', $keyword)
            ->or_like('last_seen', $keyword)
            ->or_like('waktu_ambil', $keyword)
            ->group_end();

        $data['leases'] = $this->db->get('leases')->result_array();
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword'] = $keyword;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar2', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
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
