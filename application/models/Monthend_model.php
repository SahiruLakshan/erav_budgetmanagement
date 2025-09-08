<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monthend_model extends CI_Model
{

    public function create_monthend($data)
    {
        $this->db->insert('monthend_closings', $data);
        return $this->db->insert_id();
    }

    public function get_monthend($user_id, $bank_id, $month, $year)
    {
        $this->db->where('tbl_user_id', $user_id);
        if ($bank_id !== null) {
            $this->db->where('tbl_bank_id', $bank_id);
        } else {
            $this->db->where('tbl_bank_id IS NULL', null, false);
        }
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $this->db->where('status', 1);
        return $this->db->get('monthend_closings')->row();
    }

    public function get_last_month_closing($user_id, $bank_id)
    {
        $this->db->where('tbl_user_id', $user_id);
        if ($bank_id !== null) {
            $this->db->where('tbl_bank_id', $bank_id);
        } else {
            $this->db->where('tbl_bank_id IS NULL', null, false);
        }
        $this->db->where('status', 1);
        $this->db->order_by('year DESC, month DESC');
        $this->db->limit(1);
        return $this->db->get('monthend_closings')->row();
    }

    public function get_month_incomes($user_id, $bank_id, $month, $year)
    {
        $this->db->select_sum('amount');
        $this->db->where('tbl_user_id', $user_id);
        if ($bank_id !== null) {
            $this->db->where('tbl_banks_id', $bank_id);
        } else {
            $this->db->where('tbl_banks_id IS NULL', null, false);
            $this->db->or_where('to_hand', 1); 
        }
        $this->db->where('MONTH(date)', $month);
        $this->db->where('YEAR(date)', $year);
        return $this->db->get('incomes')->row()->amount ?? 0;
    }

    public function get_month_expenses($user_id, $bank_id, $month, $year)
    {
        $this->db->select_sum('amount');
        $this->db->where('tbl_user_id', $user_id);
        if ($bank_id !== null) {
            $this->db->where('tbl_banks_id', $bank_id);
        } else {
            $this->db->where('tbl_banks_id IS NULL', null, false);
            $this->db->or_where('from_hand', 1); 
        }
        $this->db->where('MONTH(date)', $month);
        $this->db->where('YEAR(date)', $year);
        return $this->db->get('expenses')->row()->amount ?? 0;
    }

    public function get_closings($user_id)
    {
        $this->db->select("mc.*, b.bank as bank_name");
        $this->db->from("monthend_closings mc");
        $this->db->join("banks b", "mc.tbl_bank_id = b.id", "left");
        $this->db->where("mc.tbl_user_id", $user_id);
        $this->db->order_by("mc.year DESC, mc.month DESC");
        return $this->db->get()->result();
    }

    public function cancel_monthend($id, $user_id)
    {
        $this->db->where("id", $id);
        $this->db->where("tbl_user_id", $user_id);
        return $this->db->update("monthend_closings", ["status" => 0]);
    }

    public function get_user_banks($user_id)
    {
        $this->db->where("tbl_user_id", $user_id);
        $this->db->where("status", 1);
        return $this->db->get("banks")->result();
    }
}
