<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->db->order_by('created_at', 'DESC');
        $data['news_items'] = $this->db->get_where('news', ['status' => 'publish'])->result_array();

        $this->load->view('templates/header');
        $this->load->view('partials/navbar');
        $this->load->view('berita/index', $data);
        $this->load->view('templates/footer');
    }
}
