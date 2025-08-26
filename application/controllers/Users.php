<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->model('User');

        if ($this->session->userdata('user_id') != 1) {
            redirect('no_access');
        }
    }

    public function details()
    {
        $data['users'] = $this->User->get_all_users();

        $this->load->view('pages/admin/users', $data);
    }

    public function delete($id) {
        if ($this->User->delete_user($id)) {
            $this->session->set_flashdata('success', 'User deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user.');
        }
        redirect('Users/details');
    }
}
