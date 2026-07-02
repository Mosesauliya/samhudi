<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    // ---------------- Users ----------------

    public function get_by_email($email)
    {
        return $this->db->where('email', $email)->get($this->table)->row();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function email_exists($email)
    {
        return $this->db->where('email', $email)->count_all_results($this->table) > 0;
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // ---------------- OTP (table otp_codes) ----------------

    public function save_otp($user_id, $otp_code, $expired_at)
    {
        // OTP lama yang belum kepake dianggap gugur begitu ada OTP baru
        $this->db->where('user_id', $user_id)
                  ->where('is_used', 0)
                  ->update('otp_codes', ['is_used' => 1]);

        return $this->db->insert('otp_codes', [
            'user_id'    => $user_id,
            'otp_code'   => $otp_code,
            'expired_at' => $expired_at,
        ]);
    }

    public function verify_otp($user_id, $otp_code)
    {
        $row = $this->db->where('user_id', $user_id)
                         ->where('otp_code', $otp_code)
                         ->where('is_used', 0)
                         ->order_by('id', 'DESC')
                         ->get('otp_codes')
                         ->row();

        if (!$row) {
            return ['status' => false, 'message' => 'Kode OTP salah atau sudah dipakai.'];
        }

        if (strtotime($row->expired_at) < time()) {
            return ['status' => false, 'message' => 'OTP sudah kadaluarsa, minta kirim ulang.'];
        }

        $this->db->where('id', $row->id)->update('otp_codes', ['is_used' => 1]);
        $this->update($user_id, ['is_verified' => 1]);

        return ['status' => true, 'message' => 'Verifikasi berhasil.'];
    }

    // ---------------- Password Reset (table password_resets, pake user_id) ----------------

    public function save_reset_token($user_id, $token, $expired_at)
    {
        // token lama yang belum kepake dianggap gugur
        $this->db->where('user_id', $user_id)
                  ->where('used', 0)
                  ->update('password_resets', ['used' => 1]);

        return $this->db->insert('password_resets', [
            'user_id'    => $user_id,
            'token'      => $token,
            'expired_at' => $expired_at,
        ]);
    }

    public function get_valid_reset($token)
    {
        return $this->db->where('token', $token)
                         ->where('used', 0)
                         ->where('expired_at >=', date('Y-m-d H:i:s'))
                         ->get('password_resets')
                         ->row();
    }

    public function mark_reset_used($token)
    {
        return $this->db->where('token', $token)->update('password_resets', ['used' => 1]);
    }

    public function update_password($user_id, $hashed_password)
    {
        return $this->update($user_id, ['password' => $hashed_password]);
    }
}
