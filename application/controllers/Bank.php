<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Bank_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['banks'] = $this->Bank_model->get_all();
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('pages/addbank', $data);
    }

    public function add_or_update()
    {
        $this->form_validation->set_rules('bank', 'Bank', 'required');
        $this->form_validation->set_rules('account_type', 'Account Type', 'required');
        $this->form_validation->set_rules('account_number', 'Account Number', 'required');
        $this->form_validation->set_rules('open_balance', 'Open Balance', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="text-white">', '</div>'));
            redirect('bank');
        }

        $id = $this->input->post('record_id');
        $bank = $this->input->post('bank');
        $account_type = $this->input->post('account_type');
        $account_number = $this->input->post('account_number');
        $open_balance = $this->input->post('open_balance');
        $comment = $this->input->post('comment');
        $user_id = $this->session->userdata('user_id');

        $data = [
            'bank' => $bank,
            'account_type' => $account_type,
            'account_number' => $account_number,
            'open_balance' => $open_balance,
            'comment' => $comment,
            'tbl_user_id' => $user_id,
            'status' => 1 
        ];

        if ($id) {
            $this->Bank_model->update($id, $data);
            $this->session->set_flashdata('success', 'Record updated successfully.');
        } else {
            $this->Bank_model->insert($data);
            $this->session->set_flashdata('success', 'Record added successfully.');
        }

        redirect('bank');
    }

    public function get_by_id($id)
    {
        $data = $this->Bank_model->get_by_id($id);
        echo json_encode($data);
    }

    public function delete($id)
    {
        $data['status'] = 0;
        $this->Bank_model->delete($id, $data);
        $this->session->set_flashdata('success', 'Record deleted successfully.');
        redirect('bank');
    }
}
