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
        $config['per_page'] = 10; // Jumlah data per halaman
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
        $this->db->order_by('waktu_ambil', 'desc');
        $data['leases'] = $this->db->get('leases')->result_array();
        $data['offset'] = $offset;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar2', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footerAdmin');
    }

    public function cekKoneksi()
    {
        $data['title'] = 'Dashboard Leases Admin';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar2', $data);
        $this->load->view('admin/cekKoneksi', $data);
        $this->load->view('templates/footerAdmin');
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
        $config['per_page'] = 10; // Jumlah data per halaman
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
        $this->db->order_by('waktu_ambil', 'desc');

        $data['leases'] = $this->db->get('leases')->result_array();
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword'] = $keyword;
        $data['offset'] = $offset;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar2', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footerAdmin');
    }

    public function Router()
    {
        $data['title'] = 'Edit Router';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $config['base_url'] = base_url('admin/Router'); // URL base halaman
        $config['total_rows'] = $this->db->count_all('router'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 10; // Jumlah data per halaman
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
        $this->db->order_by('nama_router', 'asc');

        $data['router'] = $this->db->get('router')->result_array();
        $data['offset'] = $offset;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbarRouter', $data);
        $this->load->view('admin/editRouter', $data);
        $this->load->view('templates/footerAdmin');
    }

    public function SearchRouter()
    {
        $data['title'] = 'Edit Router';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $keyword = $this->input->get('keyword');

        if ($keyword) {
            $this->session->set_userdata('search_keyword', $keyword);
        } else {
            $keyword = $this->session->userdata('search_keyword');
        }

        $config['base_url'] = base_url('Admin/SearchRouter'); // URL base halaman
        $config['total_rows'] = $this->db->like('ip_address', $keyword)
            ->or_like('nama_router', $keyword)
            ->count_all_results('router'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 10; // Jumlah data per halaman
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
            ->or_like('nama_router', $keyword)
            ->group_end();
        $this->db->order_by('nama_router', 'asc');

        $data['router'] = $this->db->get('router')->result_array();
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword'] = $keyword;
        $data['offset'] = $offset;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbarRouter', $data);
        $this->load->view('admin/editRouter', $data);
        $this->load->view('templates/footerAdmin');
    }


    public function insertRouter()
    {
        $data['title'] = 'Edit Router';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $config['base_url'] = base_url('admin/Router'); // URL base halaman
        $config['total_rows'] = $this->db->count_all('router'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 10; // Jumlah data per halaman
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

        $data['router'] = $this->db->get('router')->result_array();
        $data['offset'] = $offset;

        $this->form_validation->set_rules('ip_address', 'IP Address', 'required|trim|is_unique[router.ip_address]|min_length[7]', [
            'min_length' => 'Format IP Address tidak sesuai',
            'is_unique' => 'IP Address is Already Registered!'
        ]);
        $this->form_validation->set_rules('nama_router', 'Nama Router', 'required|trim|min_length[3]', [
            'min_length' => 'Nama Router too short!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbarRouter', $data);
            $this->load->view('admin/editRouter', $data);
            $this->load->view('templates/footerAdmin');
        } else {

            $this->db->insert(
                'router',
                [
                    'ip_address' => $this->input->post('ip_address'),
                    'nama_router' => $this->input->post('nama_router')
                ]
            );

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
                    Router Baru Added
                    </div>'
            );
            redirect('Admin/Router');
        }
    }

    public function updateRouter()
    {
        $data['title'] = 'Edit Router';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['router'] = $this->db->get('router')->result_array();

        $this->form_validation->set_rules('ip-edit', 'IP Address', 'required|trim|callback_check_ip|min_length[7]', [
            'min_length' => 'Format IP Address tidak sesuai',
            'check_ip' => 'IP Address is Already Registered!'
        ]);
        $this->form_validation->set_rules('nama-router', 'Nama Router', 'required|trim|min_length[3]', [
            'min_length' => 'Nama Router too short!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbarRouter', $data);
            $this->load->view('admin/editRouter', $data);
            $this->load->view('templates/footerAdmin');
        } else {
            $user_id = $this->input->post('user_id');
            $ip_address = $this->input->post('ip-edit');
            $nama_router = $this->input->post('nama-router');

            $data = [
                'nama_router' => $nama_router,
                'ip_address' => $ip_address
            ];

            if (!empty($nama_router)) {
                $data['nama_router'] = $nama_router;
            }

            if (!empty($ip_address)) {
                $data['ip_address'] = $ip_address;
            }

            $this->db->where('id', $user_id);
            $this->db->update('router', $data);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
                    Data Router Updated
                </div>'
            );
            redirect('Admin/Router');
        }
    }
    public function check_ip($ip_address)
    {
        $user_id = $this->input->post('user_id');
        $existingUser = $this->db->get_where('router', ['ip_address' => $ip_address])->row_array();

        if ($existingUser && $existingUser['id'] != $user_id) {
            return FALSE;
        }
        return TRUE;
    }

    public function deleteRouter()
    {
        $user_id = $this->input->post('user_id');
        $this->db->where('id', $user_id);
        $this->db->delete('router');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
            Router Deleted
        </div>'
        );
        redirect('admin/router');
    }


    public function Ruangan()
    {
        $data['title'] = 'Edit Ruangan';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $config['base_url'] = base_url('admin/Ruangan'); // URL base halaman
        $config['total_rows'] = $this->db->count_all('ruangan'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 10; // Jumlah data per halaman
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
        $this->db->order_by('lantai', 'asc');

        $data['ruangan'] = $this->db->get('ruangan')->result_array();
        $data['offset'] = $offset;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbarRuangan', $data);
        $this->load->view('admin/editRuangan', $data);
        $this->load->view('templates/footerAdmin');
    }

    public function SearchRuangan()
    {
        $data['title'] = 'Edit Ruangan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $keyword = $this->input->get('keyword');

        if ($keyword) {
            $this->session->set_userdata('search_keyword', $keyword);
        } else {
            $keyword = $this->session->userdata('search_keyword');
        }

        $config['base_url'] = base_url('Admin/Ruangan'); // URL base halaman
        $config['total_rows'] = $this->db->like('no_ruang', $keyword)
            ->or_like('nama_ruang', $keyword)
            ->or_like('gateway', $keyword)
            ->or_like('lantai', $keyword)
            ->count_all_results('ruangan'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 10; // Jumlah data per halaman
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
            ->like('no_ruang', $keyword)
            ->or_like('nama_ruang', $keyword)
            ->or_like('gateway', $keyword)
            ->or_like('lantai', $keyword)
            ->group_end();
        $this->db->order_by('lantai', 'asc');

        $data['ruangan'] = $this->db->get('ruangan')->result_array();
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword'] = $keyword;
        $data['offset'] = $offset;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbarRuangan', $data);
        $this->load->view('admin/editRuangan', $data);
        $this->load->view('templates/footerAdmin');
    }

    public function insertRuangan()
    {
        $data['title'] = 'Add Pemilik';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $config['base_url'] = base_url('Admin/Ruangan'); // URL base halaman
        $config['total_rows'] = $this->db->count_all('ruangan'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 10; // Jumlah data per halaman
        $config['uri_segment'] = 3; // URI segment yang menyimpan nomor halaman
        $config['num_links'] = 1; // Jumlah link pagination yang ditampilkan di sekitar halaman aktif
        $config['use_page_numbers'] = TRUE;

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
        $data['offset'] = $offset;

        $data['ruangan'] = $this->db->get('ruangan')->result_array();

        $this->form_validation->set_rules('no_ruang', 'Nomor Ruang', 'required|trim|is_unique[ruangan.no_ruang]', [
            'is_unique' => 'Nomor Ruang is Already Registered!'
        ]);
        $this->form_validation->set_rules('nama_ruang', 'Nama Ruang', 'required|trim|min_length[3]', [
            'min_length' => 'Nama Ruang too short!'
        ]);
        $this->form_validation->set_rules('gateway', 'Gateway', 'required|trim|min_length[7]|is_unique[ruangan.gateway]', [
            'min_length' => 'Format Gateway tidak sesuai',
            'is_unique' => 'Gateway is Already Registered!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbarRuangan', $data);
            $this->load->view('admin/editRuangan', $data);
            $this->load->view('templates/footerAdmin');
        } else {

            $this->db->insert(
                'ruangan',
                [
                    'no_ruang' => $this->input->post('no_ruang'),
                    'nama_ruang' => $this->input->post('nama_ruang'),
                    'gateway' => $this->input->post('gateway'),
                    'lantai' => $this->input->post('lantai')
                ]
            );

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
                    Ruangan Baru Added
                    </div>'
            );
            redirect('Admin/Ruangan');
        }
    }

    public function updateRuangan()
    {
        $data['title'] = 'Edit Ruangan';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['ruangan'] = $this->db->get('ruangan')->result_array();

        $this->form_validation->set_rules('no-ruang', 'Nomor Ruang', 'required|trim|callback_check_no_ruang', [
            'check_no_ruang' => 'Nomor Ruang is already registered!'
        ]);
        $this->form_validation->set_rules('nama-ruang', 'Nama Ruang', 'required|trim|min_length[3]', [
            'min_length' => 'Nama Ruang too short!'
        ]);

        //$this->form_validation->set_rules('gateway-edit', 'Gateway', 'required|trim|min_length[7]|callback_check_gateway', [
        //    'min_length' => 'Format Gateway tidak sesuai',
        //    'check_gateway' => 'Gateway is already registered!'
        //]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbarRuangan', $data);
            $this->load->view('admin/editRuangan', $data);
            $this->load->view('templates/footerAdmin');
        } else {
            $user_id = $this->input->post('user_id');
            $no_ruang = $this->input->post('no-ruang');
            $nama_ruang = $this->input->post('nama-ruang');
            $gateway = $this->input->post('gateway-edit');
            $lantai = $this->input->post('lantai');

            $data = [
                'nama_ruang' => $nama_ruang,
                'no_ruang' => $no_ruang,
                'gateway' => $gateway,
                'lantai' => $lantai
            ];

            if (!empty($nama_ruang)) {
                $data['nama_ruang'] = $nama_ruang;
            }

            if (!empty($no_ruang)) {
                $data['no_ruang'] = $no_ruang;
            }

            if (!empty($gateway)) {
                $data['gateway'] = $gateway;
            }

            $this->db->where('id', $user_id);
            $this->db->update('ruangan', $data);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
                    Data Ruangan Updated
                </div>'
            );
            redirect('admin/ruangan');
        }
    }
    public function check_no_ruang($no_ruang)
    {
        $user_id = $this->input->post('user_id');
        $existingUser = $this->db->get_where('ruangan', ['no_ruang' => $no_ruang])->row_array();

        if ($existingUser && $existingUser['id'] != $user_id) {
            return FALSE;
        }
        return TRUE;
    }

    //public function check_gateway($gateway)
    //{
    //    $user_id = $this->input->post('user_id');
    //   $existingUser = $this->db->get_where('ruangan', ['gateway' => $gateway])->row_array();

    //    if ($existingUser && $existingUser['id'] != $user_id) {
    //        return FALSE;
    //    }
    //    return TRUE;
    //}

    public function deleteRuangan()
    {
        $user_id = $this->input->post('user_id');
        $this->db->where('id', $user_id);
        $this->db->delete('ruangan');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
            Ruangan Deleted
        </div>'
        );
        redirect('Admin/Ruangan');
    }

    public function Pemilik()
    {
        $data['title'] = 'Edit Pemilik';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $config['base_url'] = base_url('admin/Pemilik'); // URL base halaman
        $config['total_rows'] = $this->db->count_all('pemilik'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 10; // Jumlah data per halaman
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
        $this->db->order_by('date_created', 'desc');

        $data['pemilik'] = $this->db->get('pemilik')->result_array();
        $data['offset'] = $offset;
        $data['leases'] = $this->db->get('leases')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbarPemilik', $data);
        $this->load->view('admin/Pemilik', $data);
        $this->load->view('templates/footerAdmin');
    }

    public function SearchPemilik()
    {
        $data['title'] = 'Edit Pemilik';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $keyword = $this->input->get('keyword');

        if ($keyword) {
            $this->session->set_userdata('search_keyword', $keyword);
        } else {
            $keyword = $this->session->userdata('search_keyword');
        }

        $config['base_url'] = base_url('Admin/Pemilik'); // URL base halaman
        $config['total_rows'] = $this->db->like('mac_address', $keyword)
            ->or_like('nama_pemilik', $keyword)
            ->or_like('jenis', $keyword)
            ->count_all_results('pemilik'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 10; // Jumlah data per halaman
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
            ->like('mac_address', $keyword)
            ->or_like('nama_pemilik', $keyword)
            ->or_like('jenis', $keyword)
            ->group_end();
        $this->db->order_by('nama_pemilik', 'asc');

        $data['pemilik'] = $this->db->get('pemilik')->result_array();
        $data['pagination'] = $this->pagination->create_links();
        $data['offset'] = $offset;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbarPemilik', $data);
        $this->load->view('admin/Pemilik', $data);
        $this->load->view('templates/footerAdmin');
    }

    public function insertPemilik()
    {
        $data['title'] = 'Add Pemilik';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $config['base_url'] = base_url('Admin/Pemilik'); // URL base halaman
        $config['total_rows'] = $this->db->count_all('pemilik'); // Jumlah total data yang akan dipaginasi
        $config['per_page'] = 10; // Jumlah data per halaman
        $config['uri_segment'] = 3; // URI segment yang menyimpan nomor halaman
        $config['num_links'] = 1; // Jumlah link pagination yang ditampilkan di sekitar halaman aktif
        $config['use_page_numbers'] = TRUE;

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
        $data['offset'] = $offset;

        $this->form_validation->set_rules('mac_address', 'Mac Address', 'required|trim|is_unique[pemilik.mac_address]', [
            'is_unique' => 'Mac Address is already registered!'
        ]);
        $this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'required|trim|min_length[3]', [
            'min_length' => 'Name too short!'
        ]);

        if ($this->form_validation->run() == FALSE) {

            $data['pemilik'] = $this->db->get('pemilik')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbarPemilik', $data);
            $this->load->view('admin/Pemilik', $data);
            $this->load->view('templates/footerAdmin');
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

        $this->form_validation->set_rules(
            'mac-address',
            'Mac Address',
            'required|trim|callback_check_mac_address',
            [
                'check_mac_address' => 'Mac Address is already registered!'
            ]
        );
        $this->form_validation->set_rules('nama-pemilik', 'Nama Pemilik', 'required|trim|min_length[3]', [
            'min_length' => 'Name too short!'
        ]);

        if ($this->form_validation->run() == FALSE) {

            $data['pemilik'] = $this->db->get('pemilik')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbarPemilik', $data);
            $this->load->view('Admin/Pemilik', $data);
            $this->load->view('templates/footerAdmin');
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

    public function deletePemilik()
    {
        $user_id = $this->input->post('user_id');

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

    public function leases()
    {
        $data['title'] = 'Connect to Mikrotik';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar2', $data);
        $this->load->view('admin/leases', $data);
        $this->load->view('templates/footerAdmin');
    }
}
