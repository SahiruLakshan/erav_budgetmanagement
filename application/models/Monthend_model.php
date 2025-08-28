<?php
class Monthend_model extends CI_Model
{
    public function get_banks($user_id)
    {
        return $this->db->where('tbl_user_id', $user_id)
            ->where('status', 1)
            ->get('banks')->result();
    }

    public function get_bank($bank_id = null, $user_id)
    {
        $this->db->where('tbl_user_id', $user_id)->where('status', 1);
        if ($bank_id) $this->db->where('id', $bank_id);
        return $this->db->get('banks')->row();
    }

    public function get_previous_incomes($bank_id, $month, $year, $user_id)
    {
        $this->db->select_sum('amount')
            ->where('tbl_user_id', $user_id)
            ->where('date <', "$year-$month-01")
            ->where('status', 1);
        if ($bank_id) $this->db->where('tbl_banks_id', $bank_id);
        else $this->db->where('tbl_banks_id IS NULL', null, false);
        return $this->db->get('incomes')->row()->amount ?? 0;
    }

    public function get_previous_expenses($bank_id, $month, $year, $user_id)
    {
        $this->db->select_sum('amount')
            ->where('tbl_user_id', $user_id)
            ->where('date <', "$year-$month-01")
            ->where('status', 1);
        if ($bank_id) $this->db->where('tbl_banks_id', $bank_id);
        else $this->db->where('tbl_banks_id IS NULL', null, false);
        return $this->db->get('expenses')->row()->amount ?? 0;
    }

    public function get_month_incomes($bank_id, $month, $year, $user_id)
    {
        $this->db->select_sum('amount')
            ->where('tbl_user_id', $user_id)
            ->where("DATE_FORMAT(date,'%Y-%m') = '$year-$month'")
            ->where('status', 1);
        if ($bank_id) $this->db->where('tbl_banks_id', $bank_id);
        else $this->db->where('tbl_banks_id IS NULL', null, false);
        return $this->db->get('incomes')->row()->amount ?? 0;
    }

    public function get_month_expenses($bank_id, $month, $year, $user_id)
    {
        $this->db->select_sum('amount')
            ->where('tbl_user_id', $user_id)
            ->where("DATE_FORMAT(date,'%Y-%m') = '$year-$month'")
            ->where('status', 1);
        if ($bank_id) $this->db->where('tbl_banks_id', $bank_id);
        else $this->db->where('tbl_banks_id IS NULL', null, false);
        return $this->db->get('expenses')->row()->amount ?? 0;
    }

    public function get_month_transactions($bank_id, $month, $year, $user_id)
    {
        $bank_filter = $bank_id ? "tbl_banks_id = $bank_id" : "tbl_banks_id IS NULL";
        return $this->db->query("
        SELECT id, date, amount, 'Income' AS type, comment
        FROM incomes
        WHERE tbl_user_id = $user_id AND $bank_filter AND DATE_FORMAT(date,'%Y-%m') = '$year-$month' AND status = 1
        UNION ALL
        SELECT id, date, amount, 'Expense' AS type, comment
        FROM expenses
        WHERE tbl_user_id = $user_id AND $bank_filter AND DATE_FORMAT(date,'%Y-%m') = '$year-$month' AND status = 1
        ORDER BY date ASC
    ")->result();
    }
}
