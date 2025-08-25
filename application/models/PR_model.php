<?php

class PR_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_remaining_incomes()
    {
        $user_id = $this->session->userdata('user_id');

        return $this->db
            ->select('
            incomes.id,
            incomes.date,
            incomes.amount,
            incomes.comment,
            incomes.completed,
            incomes.due_date,
            main_income_types.income_name,
            sub_income_types.sub_income_name
        ')
            ->select('CASE WHEN incomes.to_hand = 1 THEN "Hand" ELSE banks.bank END as received_to', FALSE) // 👈 FALSE disables auto-escaping
            ->from('incomes')
            ->join('main_income_types', 'main_income_types.id = incomes.tbl_main_income_types_id', 'left')
            ->join('sub_income_types', 'sub_income_types.id = incomes.tbl_sub_income_types_id', 'left')
            ->join('banks', 'banks.id = incomes.tbl_banks_id', 'left')
            ->where('incomes.completed', 'No')
            ->where('incomes.tbl_user_id', $user_id)
            ->where('incomes.status', 1)
            ->get()
            ->result_array();
    }

    public function get_remaining_expenses()
    {
        $user_id = $this->session->userdata('user_id');

        return $this->db
            ->select('
            expenses.id,
            expenses.date,
            expenses.amount,
            expenses.comment,
            expenses.completed,
            expenses.due_date,
            main_expense_types.main_expense_name,
            sub_expense_types.sub_expense_name,
            CASE WHEN expenses.from_hand = 1 THEN "Hand" ELSE banks.bank END as expense_from
        ', FALSE)
            ->from('expenses')
            ->join('main_expense_types', 'main_expense_types.id = expenses.tbl_main_expense_types_id', 'left')
            ->join('sub_expense_types', 'sub_expense_types.id = expenses.tbl_sub_expense_types_id', 'left')
            ->join('banks', 'banks.id = expenses.tbl_banks_id', 'left')
            ->where('expenses.completed', 'No')
            ->where('expenses.tbl_user_id', $user_id)
            ->where('expenses.status', 1)
            ->get()
            ->result_array();
    }

    public function mark_completed($type, $id)
    {
        $table = ($type === 'income') ? 'incomes' : 'expenses';

        return $this->db
            ->where('id', $id)
            ->update($table, [
                'date' => date('Y-m-d'),
                'completed' => 'Yes',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}
