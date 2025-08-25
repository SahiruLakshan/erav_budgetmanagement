<?php
class Transaction_model extends CI_Model
{
    public function get_all_transactions($user_id = null)
    {
        $this->db->select("
        'Income' as type,
        i.date,
        i.amount,
        i.comment,
        mi.income_name as main_type,
        si.sub_income_name as sub_type,
        CASE 
            WHEN i.tbl_banks_id IS NOT NULL THEN CONCAT('To Bank: ', b.bank)
            WHEN i.to_hand = 1 THEN 'To Hand'
            ELSE 'Unknown'
        END as payment_info,
        CASE WHEN i.status = 1 THEN 'Active' ELSE 'Inactive' END as status_text,
        i.created_at,
        i.updated_at
    ", false);
        $this->db->from('incomes i');
        $this->db->join('main_income_types mi', 'mi.id = i.tbl_main_income_types_id', 'left');
        $this->db->join('sub_income_types si', 'si.id = i.tbl_sub_income_types_id', 'left');
        $this->db->join('banks b', 'b.id = i.tbl_banks_id', 'left');
        if ($user_id) {
            $this->db->where('i.tbl_user_id', $user_id);
        }

        $income_query = $this->db->get_compiled_select();

        $this->db->select("
        'Expense' as type,
        e.date,
        e.amount,
        e.comment,
        me.main_expense_name as main_type,
        se.sub_expense_name as sub_type,
        CASE 
            WHEN e.tbl_banks_id IS NOT NULL THEN CONCAT('From Bank: ', b.bank)
            WHEN e.from_hand = 1 THEN 'From Hand'
            ELSE 'Unknown'
        END as payment_info,
        CASE WHEN e.status = 1 THEN 'Active' ELSE 'Inactive' END as status_text,
        e.created_at,
        e.updated_at
    ", false);
        $this->db->from('expenses e');
        $this->db->join('main_expense_types me', 'me.id = e.tbl_main_expense_types_id', 'left');
        $this->db->join('sub_expense_types se', 'se.id = e.tbl_sub_expense_types_id', 'left');
        $this->db->join('banks b', 'b.id = e.tbl_banks_id', 'left');
        if ($user_id) {
            $this->db->where('e.tbl_user_id', $user_id);
        }

        $expense_query = $this->db->get_compiled_select();

        $final_sql = "($income_query) UNION ALL ($expense_query) ORDER BY date DESC";

        return $this->db->query($final_sql)->result();
    }
    
    public function get_totals($user_id = null)
    {
        $totals = [];

        $this->db->select_sum('amount');
        $this->db->where('status', 1);
        if ($user_id) {
            $this->db->where('tbl_user_id', $user_id);
        }
        $totals['income'] = $this->db->get('incomes')->row()->amount ?? 0;

        $this->db->select_sum('amount');
        $this->db->where('status', 1);
        if ($user_id) {
            $this->db->where('tbl_user_id', $user_id);
        }
        $totals['expense'] = $this->db->get('expenses')->row()->amount ?? 0;

        $totals['balance'] = $totals['income'] - $totals['expense'];

        return $totals;
    }
}
