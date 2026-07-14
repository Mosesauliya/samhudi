<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['families'] = [
            ['img' => 'family1.png', 'label' => 'Keluarga (a)', 'rot' => -10],
            ['img' => 'family2.png', 'label' => 'Keluarga (b)', 'rot' => 10],
            ['img' => 'family3.png', 'label' => 'Keluarga (c)', 'rot' => -5],
            ['img' => 'family4.png', 'label' => 'Keluarga (d)', 'rot' => 8],
            ['img' => 'family5.png', 'label' => 'Keluarga (e)', 'rot' => -13],
            ['img' => 'family6.png', 'label' => 'Keluarga (f)', 'rot' => 7],
            ['img' => 'family7.png', 'label' => 'Keluarga (g)', 'rot' => -4],
        ];

        // Ambil berita dari database (status publish, urutkan terbaru, maksimal 5 untuk layout grid)
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(5);
        $data['news_items'] = $this->db->get_where('news', ['status' => 'publish'])->result_array();

        $this->load->view('templates/header');
        $this->load->view('partials/navbar');
        $this->load->view('home/hero');
        $this->load->view('home/carousel', ['families' => $data['families']]);
        $this->load->view('home/sambutan');
        $this->load->view('home/intro');
        $this->load->view('home/berita', ['news_items' => $data['news_items']]);
        $this->load->view('templates/footer');
    }
}