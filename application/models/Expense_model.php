<?php
class Expense_model extends CI_Model
{

    public function get_all()
    {
        $this->db->select('e.*, me.main_expense_name as main_expense_name, se.sub_expense_name as sub_expense_name,b.bank as bank_name');
        $this->db->from('expenses e');
        $this->db->join('main_expense_types me', 'e.tbl_main_expense_types_id = me.id', 'left');
        $this->db->join('sub_expense_types se', 'e.tbl_sub_expense_types_id = se.id', 'left');
        $this->db->join('banks b', 'e.tbl_banks_id = b.id', 'left');
        $this->db->order_by('e.id', 'DESC');
        $this->db->where('e.status', '1');
        $this->db->where('e.tbl_user_id', $this->session->userdata('user_id'));
        return $this->db->get()->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert('expenses', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('expenses', $data);
    }

    public function get_by_id($id)
    {
        $this->db->select('e.*, me.main_expense_name as main_expense_name, se.sub_expense_name as sub_expense_name,b.bank as bank_name');
        $this->db->from('expenses e');
        $this->db->join('main_expense_types me', 'e.tbl_main_expense_types_id = me.id', 'left');
        $this->db->join('sub_expense_types se', 'e.tbl_sub_expense_types_id = se.id', 'left');
        $this->db->join('banks b', 'e.tbl_banks_id = b.id', 'left');
        $this->db->where('e.id', $id);
        return $this->db->get()->row_array();
    }

    public function delete($id, $data)
    {
        return $this->db->where('id', $id)->update('expenses', $data);
    }
}
