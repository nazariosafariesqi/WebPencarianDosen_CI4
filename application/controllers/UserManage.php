<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserManage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['user'] = $this->db->get('user')->result();
        $data['user_role'] = $this->db->get('user_role')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar2', $data);
        $this->load->view('userManage/index', $data);
        $this->load->view('templates/footer');
    }
}
