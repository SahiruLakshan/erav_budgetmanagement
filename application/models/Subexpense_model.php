<?php
class Subexpense_model extends CI_Model
{
    public function get_all() {
        $this->db->select('sub_expense_types.*, main_expense_types.main_expense_name');
        $this->db->from('sub_expense_types');
        $this->db->join('main_expense_types', 'sub_expense_types.tbl_main_expense_types_id = main_expense_types.id', 'left');
        $this->db->order_by('sub_expense_types.id', 'DESC');
        $this->db->where('sub_expense_types.status', '1'); 
        return $this->db->get()->result_array();
    }

    public function insert($data) {
        return $this->db->insert('sub_expense_types', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('sub_expense_types', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('sub_expense_types', ['id' => $id])->row_array();
    }

    public function delete($id, $data) {
        return $this->db->where('id', $id)->update('sub_expense_types', $data);
    }
}
