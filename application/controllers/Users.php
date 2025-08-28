<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->model('User');

        if ($this->session->userdata('user_id') != 2) {
            redirect('no_access');
        }
    }

    public function details()
    {
        $data['users'] = $this->User->get_all_users();

        $this->load->view('pages/admin/users', $data);
    }

    public function activate($id)
    {
        $data['status'] = 1;
        $this->User->update_status($id, $data);
        $this->session->set_flashdata('success', 'Activated successfully.');
        redirect('Users/details');
    }

    public function deactivate($id)
    {
        $data['status'] = 0;
        $this->User->update_status($id, $data);
        $this->session->set_flashdata('success', 'Deactivated successfully.');
        redirect('Users/details');
    }
}
