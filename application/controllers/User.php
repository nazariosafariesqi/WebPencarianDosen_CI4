<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function HasilSearch()
    {
        $keyword = $this->input->get('keyword');

        if (empty($keyword)) {
            $results = []; // Jika keyword kosong
        } else {
            $sql = "(SELECT p.nama_pemilik, p.jenis, l.mac_address, l.ip_address, l.last_seen, r.nama_ruang, r.lantai, DATE_FORMAT(l.waktu_ambil, '%d-%m-%Y') AS waktu_ambil
            FROM pemilik p
            JOIN leases l ON p.mac_address = l.mac_address
            JOIN ip i ON l.ip_address = i.ip_address
            JOIN ruangan r ON i.ruangan_id = r.id
            WHERE p.nama_pemilik LIKE '%" . $keyword . "%'
                
            ORDER BY l.waktu_ambil ASC, l.last_seen ASC
            LIMIT 50)";

            $results = $this->db->query($sql)->result_array();
        }

        $data['title'] = 'Cari Dosen';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['leases'] = $results;

        // Check if results are empty
        $data['no_data'] = (count($results) === 0);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/hasilSearch', $data);
        $this->load->view('templates/footer');
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function Search()
    {
        $data['title'] = 'Cari Dosen';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/search', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // cek jika ada gambar yang akan di upload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '4096';
                $config['upload_path'] = './assets/img/profile/';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];

                    if ($old_image != 'default2.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                    $data['user']['image'] = $new_image;
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
                Your profile has been updated
                </div>'
            );
            redirect('user');
        }
    }
}
