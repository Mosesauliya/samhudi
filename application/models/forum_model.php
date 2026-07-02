<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_forums()
    {
        $this->db->select('forums.*, users.full_name AS author_name');
        $this->db->from('forums');
        $this->db->join('users', 'users.id = forums.created_by', 'left');
        $this->db->order_by('forums.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_forum($id)
    {
        $this->db->select('forums.*, users.full_name AS author_name');
        $this->db->from('forums');
        $this->db->join('users', 'users.id = forums.created_by', 'left');
        $this->db->where('forums.id', $id);
        return $this->db->get()->row();
    }

    public function create_forum($data)
    {
        return $this->db->insert('forums', $data);
    }

    public function get_comments($forum_id)
    {
        $this->db->select('forum_comments.*, users.full_name AS author_name');
        $this->db->from('forum_comments');
        $this->db->join('users', 'users.id = forum_comments.user_id', 'left');
        $this->db->where('forum_comments.forum_id', $forum_id);
        $this->db->order_by('forum_comments.created_at', 'ASC');
        $rows = $this->db->get()->result();

        $comments = [];
        $children = [];

        foreach ($rows as $row) {
            if ($row->parent_id === null) {
                $comments[$row->id] = $row;
                $comments[$row->id]->replies = [];
            } else {
                $children[] = $row;
            }
        }

        foreach ($children as $child) {
            if (isset($comments[$child->parent_id])) {
                $comments[$child->parent_id]->replies[] = $child;
            }
        }

        return array_values($comments);
    }

    // Simpan komentar / reply baru
    public function create_comment($data)
    {
        return $this->db->insert('forum_comments', $data);
    }
}