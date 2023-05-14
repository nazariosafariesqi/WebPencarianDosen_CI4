<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserManage extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('userManage/index', $data);
        $this->load->view('templates/footer');
    }
}
