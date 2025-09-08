<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monthend extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Monthend_model');

        if (!$this->session->userdata('user_id')) {
            redirect('/');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id') ?? 1;
        $month   = date('m');
        $year    = date('Y');

        $data['banks'] = $this->Monthend_model->get_user_banks($user_id);
        $data['closings'] = $this->Monthend_model->get_closings($user_id);

        $data['cash_closed'] = $this->Monthend_model->get_monthend($user_id, null, $month, $year) ? true : false;

        $this->load->view('pages/monthend', $data);
    }

    public function close()
    {
        $user_id = $this->session->userdata('user_id') ?? 1;
        $bank_id = $this->input->post('bank_id') ?: null;
        $month   = date('m');
        $year    = date('Y');

        $exists = $this->Monthend_model->get_monthend($user_id, $bank_id, $month, $year);
        if ($exists) {
            $this->session->set_flashdata('error', 'Month already closed!');
            redirect('Monthend');
        }

        $last_closing = $this->Monthend_model->get_last_month_closing($user_id, $bank_id);
        if ($last_closing) {
            $opening_balance = $last_closing->closing_balance;
        } else {
            // First month → get from bank table or 0 for cash
            if ($bank_id) {
                $bank = $this->db->get_where('banks', ['id' => $bank_id])->row();
                $opening_balance = $bank->open_balance ?? 0;
            } else {
                $opening_balance = 0;
            }
        }

        $total_income  = $this->Monthend_model->get_month_incomes($user_id, $bank_id, $month, $year);
        $total_expense = $this->Monthend_model->get_month_expenses($user_id, $bank_id, $month, $year);
        $closing_balance = $opening_balance + $total_income - $total_expense;

        $now = date('Y-m-d H:i:s'); 

        $data = [
            "tbl_user_id"     => $user_id,
            "tbl_bank_id"     => $bank_id,
            "month"           => $month,
            "year"            => $year,
            "opening_balance" => $opening_balance,
            "total_income"    => $total_income,
            "total_expense"   => $total_expense,
            "closing_balance" => $closing_balance,
            "status"          => 1,
        ];

        $data['created_at'] = $now;
        $this->Monthend_model->create_monthend($data);
        $this->session->set_flashdata('success', 'Month closed successfully!');
        redirect('Monthend');
    }


    public function cancel($id)
    {
        $user_id = $this->session->userdata('user_id') ?? 1;
        $this->Monthend_model->cancel_monthend($id, $user_id);
        $this->session->set_flashdata('success', 'Month end cancelled!');
        redirect('Monthend');
    }
}
