<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transactions extends CI_Controller
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

    public function transactions()
    {
        $user_id = $this->input->get('user_id');

        $data['users'] = $this->User->get_all_users();
        $data['transactions'] = $this->Transaction_model->get_all_transactions($user_id);
        $data['totals'] = $this->Transaction_model->get_totals($user_id);

        $this->load->view('pages/admin/transactions', $data);
    }
}
