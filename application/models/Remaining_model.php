<?php

class Remaining_model extends CI_Model
{
    public function get_remaining_incomes()
    {
        return $this->db
            ->where('completed', 'No')
            ->get('incomes')
            ->result_array();
    }

    public function get_remaining_expenses()
    {
        return $this->db
            ->where('completed', 'No')
            ->get('expenses')
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
