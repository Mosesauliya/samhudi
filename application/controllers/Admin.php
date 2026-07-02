<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Admin_model');

        // Proteksi Halaman Admin: Hanya untuk role admin atau super_admin
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
            return;
        }

        $role = $this->session->userdata('role');
        if (!in_array($role, ['admin', 'super_admin'])) {
            redirect('home'); // Anggota biasa ditendang ke homepage
            return;
        }
    }

    public function index()
    {
        $data = [
            'admin_name'    => $this->session->userdata('full_name'),
            'admin_role'    => $this->session->userdata('role'),
            'total_members' => $this->Admin_model->get_total_members(),
            'total_news'    => $this->Admin_model->get_total_news(),
            'total_forums'  => $this->Admin_model->get_total_forums(),
            'total_wills'   => $this->Admin_model->get_total_wills(),
        ];

        $this->load->view('admin/dashboard', $data);
    }
}
