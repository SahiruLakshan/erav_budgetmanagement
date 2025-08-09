<?php
class Income_model extends CI_Model
{

    public function get_all()
    {
        $this->db->select('i.*, m.income_name as main_income_name, s.sub_income_name as sub_income_name,b.bank as bank_name');
        $this->db->from('incomes i');
        $this->db->join('main_income_types m', 'i.tbl_main_income_types_id = m.id', 'left');
        $this->db->join('sub_income_types s', 'i.tbl_sub_income_types_id = s.id', 'left');
        $this->db->join('banks b', 'i.tbl_banks_id = b.id', 'left');
        $this->db->order_by('i.id', 'DESC');
        $this->db->where('i.status', '1');
        return $this->db->get()->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert('incomes', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('incomes', $data);
    }

    public function get_by_id($id)
    {
        $this->db->select('i.*, m.income_name as main_income_name, s.sub_income_name as sub_income_name, b.bank as bank_name');
        $this->db->from('incomes i');
        $this->db->join('main_income_types m', 'i.tbl_main_income_types_id = m.id', 'left');
        $this->db->join('sub_income_types s', 'i.tbl_sub_income_types_id = s.id', 'left');
        $this->db->join('banks b', 'i.tbl_banks_id = b.id', 'left');
        $this->db->where('i.id', $id);
        return $this->db->get()->row_array();
    }

    public function delete($id, $data)
    {
        return $this->db->where('id', $id)->update('incomes', $data);
    }
}
