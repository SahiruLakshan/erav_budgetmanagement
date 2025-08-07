<?php
class Subincome_model extends CI_Model
{
    public function get_all() {
        $this->db->select('sub_income_types.*, main_income_types.income_name');
        $this->db->from('sub_income_types');
        $this->db->join('main_income_types', 'sub_income_types.tbl_main_income_types_id = main_income_types.id', 'left');
        $this->db->order_by('sub_income_types.id', 'DESC');
        $this->db->where('sub_income_types.status', '1'); 
        return $this->db->get()->result_array();
    }

    public function insert($data) {
        return $this->db->insert('sub_income_types', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('sub_income_types', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('sub_income_types', ['id' => $id])->row_array();
    }

    public function delete($id, $data) {
        return $this->db->where('id', $id)->update('sub_income_types', $data);
    }
}
