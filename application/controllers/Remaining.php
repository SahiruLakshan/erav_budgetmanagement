<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Remaining extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Remaining_model');
    }

    public function index()
    {
        $data['incomes'] = $this->Remaining_model->get_remaining_incomes();
        $data['expenses'] = $this->Remaining_model->get_remaining_expenses();

        $this->load->view('pages/remaining', $data);
    }

    public function mark_completed($type, $id)
{
    // Disable CI debug output for this request
    $this->output->set_content_type('application/json');

    $updated = $this->Remaining_model->mark_completed($type, $id);

    if ($updated) {
        echo json_encode(['status' => 'success', 'message' => 'Record updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating record.']);
    }
}


}
