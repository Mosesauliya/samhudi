<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Linkedin_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_jobs()
    {
        $this->db->select('*');
        $this->db->from('job_listings');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_job_by_id($id)
    {
        return $this->db->where('id', $id)->get('job_listings')->row();
    }

    public function create_job($data)
    {
        return $this->db->insert('job_listings', $data);
    }

    public function get_open_to_work_users()
    {
        $this->db->select('id, full_name, avatar, open_to_work, work_role, is_fresh_graduate');
        $this->db->from('users');
        $this->db->where('open_to_work', 1);
        return $this->db->get()->result();
    }
}
