<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Menghitung total user dengan role member
     */
    public function get_total_members()
    {
        return $this->db->where('role', 'member')->count_all_results('users');
    }

    /**
     * Menghitung total berita yang dipublish
     */
    public function get_total_news()
    {
        return $this->db->where('status', 'publish')->count_all_results('news');
    }

    /**
     * Menghitung total forum diskusi
     */
    public function get_total_forums()
    {
        return $this->db->count_all_results('forums');
    }

    /**
     * Menghitung total data wasiat
     */
    public function get_total_wills()
    {
        return $this->db->count_all_results('wills');
    }
}
