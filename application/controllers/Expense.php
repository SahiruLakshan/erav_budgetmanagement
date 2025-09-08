<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Expense extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Expense_model');
        $this->load->model('Mainexpense_model');
        $this->load->model('Subexpense_model');
        $this->load->model('Bank_model');
        $this->load->library('form_validation');

        if (!$this->session->userdata('user_id')) {
            redirect('/');
        }
    }

    public function index()
    {
        $data['addedexpenses'] = $this->Expense_model->get_all();
        $data['mexpenses'] = $this->Mainexpense_model->get_all();
        $data['banks'] = $this->Bank_model->get_all();
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('pages/addexpense', $data);
    }

    public function get_sub_expense()
    {
        $main_expense_id = $this->input->post('main_expense_id');

        if ($main_expense_id) {
            $sub_expenses = $this->Subexpense_model->get_by_main_expense($main_expense_id);
            echo json_encode($sub_expenses);
        } else {
            echo json_encode([]);
        }
    }

    public function add_or_update()
    {
        $this->form_validation->set_rules('main_expense', 'Main Expense', 'required');
        $this->form_validation->set_rules('sub_expense', 'Sub Expense', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('bank', 'Bank');
        $this->form_validation->set_rules('spend_money_from_hand', 'Spend Money From Hand');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="text-white">', '</div>'));
            redirect('Expense');
        }

        $id = $this->input->post('record_id');
        $main_expense = $this->input->post('main_expense');
        $sub_expense = $this->input->post('sub_expense');
        $date = $this->input->post('date');
        $amount = $this->input->post('amount');
        $bank = !empty($this->input->post('bank')) ? $this->input->post('bank') : null;
        $spend_money_from_hand = !empty($this->input->post('spend_money_from_hand')) ? 1 : 0;
        $comment = $this->input->post('comment');
        $completed = $this->input->post('completed');
        $due_date = $this->input->post('due_date');
        $user_id = $this->session->userdata('user_id');

        $now = date('Y-m-d H:i:s'); 

        $data = [
            'tbl_main_expense_types_id' => $main_expense,
            'tbl_sub_expense_types_id' => $sub_expense,
            'date' => $date,
            'amount' => $amount,
            'tbl_banks_id' => $bank,
            'from_hand' => $spend_money_from_hand,
            'comment' => $comment,
            'completed' => $completed,
            'due_date' => $due_date,
            'tbl_user_id' => $user_id,
            'status' => 1
        ];

        if ($id) {
            $data['updated_at'] = $now;
            $this->Expense_model->update($id, $data);
            $this->session->set_flashdata('success', 'Record updated successfully.');
        } else {
            $data['created_at'] = $now;
            $data['updated_at'] = $now;
            $this->Expense_model->insert($data);
            $this->session->set_flashdata('success', 'Record added successfully.');
        }

        redirect('Expense');
    }


    public function get_by_id($id)
    {
        $data = $this->Expense_model->get_by_id($id);
        echo json_encode($data);
    }

    public function delete($id)
    {
        $data['status'] = 0;
        $this->Expense_model->delete($id, $data);
        $this->session->set_flashdata('success', 'Record deleted successfully.');
        redirect('Expense');
    }
}
