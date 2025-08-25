<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row_array();
    }

    public function update_password_by_email($email, $new_password)
    {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $this->db->where('email', $email);
        $this->db->update('users', ['password' => $hashed_password]);

        return ($this->db->affected_rows() > 0); 
    }

    public function get_all_users() {
        return $this->db->get('users')->result();
    }
}

