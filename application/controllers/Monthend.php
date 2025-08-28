<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monthend extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Monthend_model');
        $this->load->database();
        $this->load->helper('url');
    }

    public function monthly_status()
    {
        $user_id = $this->session->userdata('user_id');

        $bank_id = $this->input->get('bank_id');

        $month_input = $this->input->get('month') ?? date('Y-m');
        list($year, $monthnum) = explode('-', $month_input);

        $banks = $this->Monthend_model->get_banks($user_id);

        if ($bank_id) {
            $bank_obj = $this->Monthend_model->get_bank($bank_id, $user_id);
            $banks_to_show = $bank_obj ? [$bank_obj] : [];
        } else {
            $banks_to_show = $banks;
        }

        $all_data = [];
        foreach ($banks_to_show as $bank) {
            $prev_incomes = $this->Monthend_model->get_previous_incomes($bank->id, $monthnum, $year, $user_id);
            $prev_expenses = $this->Monthend_model->get_previous_expenses($bank->id, $monthnum, $year, $user_id);
            $month_incomes = $this->Monthend_model->get_month_incomes($bank->id, $monthnum, $year, $user_id);
            $month_expenses = $this->Monthend_model->get_month_expenses($bank->id, $monthnum, $year, $user_id);
            $transactions = $this->Monthend_model->get_month_transactions($bank->id, $monthnum, $year, $user_id);

            $opening_balance = $bank->open_balance + ($prev_incomes - $prev_expenses);
            $profit = $month_incomes - $month_expenses;
            $closing_balance = $opening_balance + $profit;

            $all_data[] = [
                'bank' => $bank,
                'opening_balance' => $opening_balance,
                'month_incomes' => $month_incomes,
                'month_expenses' => $month_expenses,
                'profit' => $profit,
                'closing_balance' => $closing_balance,
                'transactions' => $transactions
            ];
        }

        $cash_prev_incomes = $this->Monthend_model->get_previous_incomes(null, $monthnum, $year, $user_id);
        $cash_prev_expenses = $this->Monthend_model->get_previous_expenses(null, $monthnum, $year, $user_id);
        $cash_month_incomes = $this->Monthend_model->get_month_incomes(null, $monthnum, $year, $user_id);
        $cash_month_expenses = $this->Monthend_model->get_month_expenses(null, $monthnum, $year, $user_id);
        $cash_opening = $cash_prev_incomes - $cash_prev_expenses;
        $cash_profit = $cash_month_incomes - $cash_month_expenses;
        $cash_closing = $cash_opening + $cash_profit;
        $cash_transactions = $this->Monthend_model->get_month_transactions(null, $monthnum, $year, $user_id);

        $data = [
            'banks' => $banks,
            'all_data' => $all_data,
            'cash' => [
                'opening_balance' => $cash_opening,
                'month_incomes' => $cash_month_incomes,
                'month_expenses' => $cash_month_expenses,
                'profit' => $cash_profit,
                'closing_balance' => $cash_closing,
                'transactions' => $cash_transactions
            ],
            'selected_bank_id' => $bank_id,
            'monthnum' => $monthnum,
            'year' => $year
        ];

        $this->load->view('pages/monthend', $data);
    }

    public function transactions_json($bank_id, $month, $year)
    {
        $user_id = $this->session->userdata('user_id');
        $transactions = $this->Monthend_model->get_month_transactions($bank_id, $month, $year, $user_id);
        echo json_encode(["data" => $transactions]);
    }
}
