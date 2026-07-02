<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Forum_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
    }

    private function get_logged_user_id()
    {
        return $this->session->userdata('user_id');
    }

    public function index()
    {
        $data['forums'] = $this->Forum_model->get_all_forums();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('forum/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        if (!$this->get_logged_user_id()) {
            redirect('auth/login');
            return;
        }

        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('content', 'Isi Diskusi', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('forum/create');
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title'      => $this->input->post('title'),
                'content'    => $this->input->post('content'),
                'created_by' => $this->get_logged_user_id(),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->Forum_model->create_forum($data);
            redirect('forum');
        }
    }

    public function view($id)
    {
        $data['forum'] = $this->Forum_model->get_forum($id);

        if (!$data['forum']) {
            show_404();
        }

        $data['comments'] = $this->Forum_model->get_comments($id);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('forum/view', $data);
        $this->load->view('templates/footer');
    }

    public function comment($forum_id)
    {
        if (!$this->get_logged_user_id()) {
            redirect('auth/login');
            return;
        }

        $this->form_validation->set_rules('comment', 'Komentar', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->view($forum_id);
        } else {
            $parent_id = $this->input->post('parent_id');

            $data = [
                'forum_id'   => $forum_id,
                'user_id'    => $this->get_logged_user_id(),
                'parent_id'  => $parent_id ? $parent_id : null,
                'comment'    => $this->input->post('comment'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->Forum_model->create_comment($data);
            redirect('forum/view/' . $forum_id);
        }
    }
}