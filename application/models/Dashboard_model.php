<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_balances()
    {
        $banks = $this->db->get('banks')->result_array();
        $total_bank_balance = 0;

        foreach ($banks as &$bank) {
            $income_sum = $this->db
                ->select_sum('amount')
                ->where('tbl_banks_id', $bank['id'])
                ->where('to_hand', 0)
                ->get('incomes')
                ->row()->amount ?? 0;

            $expense_sum = $this->db
                ->select_sum('amount')
                ->where('tbl_banks_id', $bank['id'])
                ->where('from_hand', 0)
                ->get('expenses')
                ->row()->amount ?? 0;

            $bank['calculated_balance'] = ($bank['open_balance'] ?? 0) + ($income_sum ?? 0) - ($expense_sum ?? 0);

            $total_bank_balance += $bank['calculated_balance'];
        }

        $income_hand = $this->db
            ->select_sum('amount')
            ->where('to_hand', 1)
            ->get('incomes')
            ->row()->amount ?? 0;

        $expense_hand = $this->db
            ->select_sum('amount')
            ->where('from_hand', 1)
            ->get('expenses')
            ->row()->amount ?? 0;

        $cash_in_hand = ($income_hand ?? 0) - ($expense_hand ?? 0);

        $total_balance = $total_bank_balance + $cash_in_hand;

        return [
            'banks'          => $banks,
            'total_balance'  => $total_balance,
            'cash_in_hand'   => $cash_in_hand
        ];
    }

    public function get_recent_transactions($limit = 20)
    {
        $incomes = $this->db
            ->select("
            incomes.date,
            incomes.amount,
            'income' as type,
            incomes.comment,
            incomes.to_hand as hand,
            incomes.tbl_banks_id,
            banks.bank as bank_name,
            main_income.income_name as main_name,
            sub_income.sub_income_name as sub_name
        ")
            ->from('incomes')
            ->join('banks', 'banks.id = incomes.tbl_banks_id', 'left')
            ->join('main_income_types as main_income', 'main_income.id = incomes.tbl_main_income_types_id AND main_income.status = 1', 'left')
            ->join('sub_income_types as sub_income', 'sub_income.id = incomes.tbl_sub_income_types_id AND sub_income.status = 1', 'left')
            ->where('incomes.status', 1)
            ->where('incomes.tbl_user_id', $this->session->userdata('user_id'))
            ->get()->result_array();

        $expenses = $this->db
            ->select("
            expenses.date,
            expenses.amount,
            'expense' as type,
            expenses.comment,
            expenses.from_hand as hand,
            expenses.tbl_banks_id,
            banks.bank as bank_name,
            main_expense.main_expense_name as main_name,
            sub_expense.sub_expense_name as sub_name
        ")
            ->from('expenses')
            ->join('banks', 'banks.id = expenses.tbl_banks_id', 'left')
            ->join('main_expense_types as main_expense', 'main_expense.id = expenses.tbl_main_expense_types_id AND main_expense.status = 1', 'left')
            ->join('sub_expense_types as sub_expense', 'sub_expense.id = expenses.tbl_sub_expense_types_id AND sub_expense.status = 1', 'left')
            ->where('expenses.status', 1)
            ->where('expenses.tbl_user_id', $this->session->userdata('user_id'))
            ->get()->result_array();

        $transactions = array_merge($incomes, $expenses);

        usort($transactions, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return array_slice($transactions, 0, $limit);
    }

    public function get_monthly_incomes_expenses()
    {
        $month = date('m');
        $year = date('Y');

        $incomes = $this->db->select("DATE(date) as day, SUM(amount) as total")
            ->from('incomes')
            ->where('MONTH(date)', $month)
            ->where('YEAR(date)', $year)
            ->group_by('DATE(date)')
            ->get()->result_array();

        $expenses = $this->db->select("DATE(date) as day, SUM(amount) as total")
            ->from('expenses')
            ->where('MONTH(date)', $month)
            ->where('YEAR(date)', $year)
            ->group_by('DATE(date)')
            ->get()->result_array();

        return [
            'incomes' => $incomes,
            'expenses' => $expenses
        ];
    }

    public function get_yearly_monthly_profit()
    {
        $year = date('Y');

        $incomes = $this->db->select("MONTH(date) as month, SUM(amount) as total")
            ->from('incomes')
            ->where('YEAR(date)', $year)
            ->group_by('MONTH(date)')
            ->get()->result_array();

        $expenses = $this->db->select("MONTH(date) as month, SUM(amount) as total")
            ->from('expenses')
            ->where('YEAR(date)', $year)
            ->group_by('MONTH(date)')
            ->get()->result_array();

        $income_map = [];
        foreach ($incomes as $row) {
            $income_map[$row['month']] = $row['total'];
        }

        $expense_map = [];
        foreach ($expenses as $row) {
            $expense_map[$row['month']] = $row['total'];
        }

        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $income = isset($income_map[$m]) ? $income_map[$m] : 0;
            $expense = isset($expense_map[$m]) ? $expense_map[$m] : 0;
            $profit = $income - $expense;
            $data[] = [
                'month' => date("F", mktime(0, 0, 0, $m, 1)),
                'profit' => $profit
            ];
        }

        return $data;
    }
}
