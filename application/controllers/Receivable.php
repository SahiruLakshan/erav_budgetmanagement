<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Receivable extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PR_model');

        if (!$this->session->userdata('user_id')) {
            redirect('/');
        }
    }

    public function incomes()
    {
        $data['incomes'] = $this->PR_model->get_remaining_incomes();

        $this->load->view('pages/receivable', $data);
    }

    public function mark_completed($type, $id)
    {
        $this->output->set_content_type('application/json');

        $updated = $this->PR_model->mark_completed($type, $id);

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Record updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error updating record.']);
        }
    }
}
