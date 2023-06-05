<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserManage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['title'] = 'User Management';

        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $config['base_url'] = base_url('UserManage/index'); // URL base halaman
        $config['total_rows'] = $this->db->count_all('user'); // Jumlah total data yang akan dipaginasi
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
        $this->db->order_by('name', 'asc');

        $data['offset'] = $offset;
        $data['users'] = $this->db->get('user')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbarUserManage', $data);
        $this->load->view('userManage/index', $data);
        $this->load->view('templates/footer');
    }

    public function SearchUser()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $keyword = $this->input->get('keyword');

        if ($keyword) {
            $this->session->set_userdata('search_keyword', $keyword);
        } else {
            $keyword = $this->session->userdata('search_keyword');
        }

        $config['base_url'] = base_url('Admin/SearchUser'); // URL base halaman
        $config['total_rows'] = $this->db->like('name', $keyword)
            ->or_like('email', $keyword)
            ->or_like('role', $keyword)
            ->count_all_results('user'); // Jumlah total data yang akan dipaginasi
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
            ->like('name', $keyword)
            ->or_like('email', $keyword)
            ->or_like('role', $keyword)
            ->group_end();
        $this->db->order_by('name', 'asc');

        $data['users'] = $this->db->get('user')->result_array();
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword'] = $keyword;
        $data['offset'] = $offset;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbarUserManage', $data);
        $this->load->view('userManage/index', $data);
        $this->load->view('templates/footer');
    }

    public function insert()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['users'] = $this->db->get('user')->result_array();

        $config['base_url'] = base_url('UserManage/index'); // URL base halaman
        $config['total_rows'] = $this->db->count_all('user'); // Jumlah total data yang akan dipaginasi
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

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already been registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'min_length' => 'Password too short!'
        ]);

        $data['offset'] = $offset;

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbarUserManage', $data);
            $this->load->view('userManage/index', $data);
            $this->load->view('templates/footer');
        } else {
            $role_id = $this->input->post('role_id');
            if ($role_id == 1) {
                $role = 'Administrator';
            } elseif ($role_id == 2) {
                $role = 'Member';
            }

            $this->db->insert(
                'user',
                [
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'role' => $role,
                    'image' => 'default2.jpg',
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'role_id' => $role_id,
                    'is_active' => '1',
                    'date_created' => date('Y-m-d H:i:s')
                ]
            );

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
                    New User Added
                    </div>'
            );
            redirect('userManage/index');
        }
    }

    public  function update()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['users'] = $this->db->get('user')->result_array();

        $this->form_validation->set_rules('name-edit', 'Name', 'required|trim');
        $this->form_validation->set_rules('email-edit', 'Email', 'required|trim|valid_email|callback_check_email', [
            'is_unique' => 'This email has already been registered!',
            'check_email' => 'This email has already been registered!'
        ]);
        $this->form_validation->set_rules('password1', 'New Password', 'trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Re-type Password', 'trim|matches[password1]');

        $data['offset'] = $offset;

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbarUserManage', $data);
            $this->load->view('userManage/index', $data);
            $this->load->view('templates/footer');
        } else {
            $user_id = $this->input->post('user_id');
            $name = $this->input->post('name-edit');
            $email = $this->input->post('email-edit');
            $password = $this->input->post('password2');

            $data = [
                'name' => $name,
                'email' => $email
            ];

            if (!empty($email)) {
                $data['email'] = $email;
            }

            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $this->db->where('id', $user_id)
                ->update('user', $data);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
                    User Data Updated
                </div>'
            );
            redirect('userManage/index');
        }
    }

    public function check_email($email)
    {
        $user_id = $this->input->post('user_id');
        $existingUser = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($existingUser && $existingUser['id'] != $user_id) {
            return FALSE; // email sudah terdaftar oleh pengguna lain
        }
        return TRUE; // email tersedia atau tidak diganti
    }

    public function delete()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['users'] = $this->db->get('user')->result_array();
        $data['offset'] = $offset;

        $user_id = $this->input->post('user_id');

        $this->db->where('id', $user_id)
            ->delete('user');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
            User Data Deleted
        </div>'
        );

        redirect('userManage/index');
    }
}
