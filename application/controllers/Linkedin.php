<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Linkedin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Linkedin_model');
        $this->load->model('User_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['session', 'form_validation']);
    }

    private function require_login()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('auth/');
        }
        return $user_id;
    }

    public function index()
    {
        $user_id = $this->require_login();
        $user   = $this->User_model->get_by_id($user_id);

        $data['user'] = $user;
        $data['jobs'] = $this->Linkedin_model->get_all_jobs();
        $data['workers'] = $this->Linkedin_model->get_open_to_work_users();

        $this->load->view('templates/header');
        $this->load->view('partials/navbar');
        $this->load->view('linkedin/index', $data);
        $this->load->view('templates/footer');
    }

    public function create_job()
    {
        $user_id = $this->require_login();
        
        $this->form_validation->set_rules('company_name', 'Nama Perusahaan', 'required');
        $this->form_validation->set_rules('job_title', 'Jenis Pekerjaan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_msg', validation_errors());
            redirect('linkedin');
        } else {
            $data = [
                'user_id' => $user_id,
                'publisher_name' => $this->session->userdata('full_name'),
                'company_name' => $this->input->post('company_name'),
                'job_title' => $this->input->post('job_title'),
                'salary' => $this->input->post('salary'),
                'job_type' => $this->input->post('job_type'),
                'working_hours' => $this->input->post('working_hours'),
                'location' => $this->input->post('location'),
                'description' => $this->input->post('description')
            ];

            $this->Linkedin_model->create_job($data);
            $this->session->set_flashdata('success_msg', 'Lowongan pekerjaan berhasil ditambahkan.');
            redirect('linkedin');
        }
    }

    public function get_job_detail($id)
    {
        $job = $this->Linkedin_model->get_job_by_id($id);
        if ($job) {
            echo json_encode(['status' => 'success', 'data' => $job]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Job not found']);
        }
    }
}
