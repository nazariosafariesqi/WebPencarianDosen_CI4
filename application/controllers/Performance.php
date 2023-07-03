<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Performance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('pagination');
    }
    
    public function index(){
        $data['title'] = 'Search Performance';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $config['base_url'] = base_url('performance/index'); // URL base halaman
        $config['total_rows'] = $this->db->count_all('eksekusi'); // Jumlah total data yang akan dipaginasi
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
        $this->db->order_by('waktu', 'desc');
        $data['eksekusi'] = $this->db->get('eksekusi')->result_array();
        $data['offset'] = $offset;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar2', $data);
        $this->load->view('performance/index', $data);
        $this->load->view('templates/footerAdmin');
    }
}