<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Income extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Income_model');
        $this->load->model('Mainincome_model');
        $this->load->model('Subincome_model');
        $this->load->model('Bank_model');
        $this->load->library('form_validation');

        if (!$this->session->userdata('user_id')) {
            redirect('/');
        }
    }

    public function index()
    {
        $data['addedincomes'] = $this->Income_model->get_all();
        $data['mincomes'] = $this->Mainincome_model->get_all();
        $data['banks'] = $this->Bank_model->get_all();
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('pages/addincome', $data);
    }

    public function get_sub_income()
    {
        $main_income_id = $this->input->post('main_income_id');

        if ($main_income_id) {
            $sub_incomes = $this->Subincome_model->get_by_main_income($main_income_id);
            echo json_encode($sub_incomes);
        } else {
            echo json_encode([]);
        }
    }

    public function add_or_update()
    {
        $this->form_validation->set_rules('main_income', 'Main Income', 'required');
        $this->form_validation->set_rules('sub_income', 'Sub Income', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('bank', 'Bank');
        $this->form_validation->set_rules('get_money_in_hand', 'Get money in hand');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="text-white">', '</div>'));
            redirect('Income');
        }

        $id = $this->input->post('record_id');
        $main_income = $this->input->post('main_income');
        $sub_income = $this->input->post('sub_income');
        $date = $this->input->post('date');
        $amount = $this->input->post('amount');
        $bank = !empty($this->input->post('bank')) ? $this->input->post('bank') : null;
        $get_money_in_hand = !empty($this->input->post('get_money_in_hand')) ? 1 : 0;
        $comment = $this->input->post('comment');
        $completed = $this->input->post('completed');
        $due_date = $this->input->post('due_date');
        $user_id = $this->session->userdata('user_id');

        $data = [
            'tbl_main_income_types_id' => $main_income,
            'tbl_sub_income_types_id' => $sub_income,
            'date' => $date,
            'amount' => $amount,
            'tbl_banks_id' => $bank,
            'to_hand' => $get_money_in_hand,
            'comment' => $comment,
            'completed' => $completed,
            'due_date' => $due_date,
            'tbl_user_id' => $user_id,
            'status' => 1
        ];

        if ($id) {
            $this->Income_model->update($id, $data);
            $this->session->set_flashdata('success', 'Record updated successfully.');
        } else {
            $this->Income_model->insert($data);
            $this->session->set_flashdata('success', 'Record added successfully.');
        }

        redirect('Income');
    }

    public function get_by_id($id)
    {
        $data = $this->Income_model->get_by_id($id);
        echo json_encode($data);
    }

    public function delete($id)
    {
        $data['status'] = 0;
        $this->Income_model->delete($id, $data);
        $this->session->set_flashdata('success', 'Record deleted successfully.');
        redirect('Income');
    }
}
