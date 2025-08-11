<?php
class Mainincome_model extends CI_Model
{

    private $table = 'main_income_types';

    public function get_all() {
        return $this->db->order_by('id', 'DESC')->where('status', '1')->where('tbl_user_id', $this->session->userdata('user_id'))->get($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function delete($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }
}
