<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mainexpense extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mainexpense_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['mexpenses'] = $this->Mainexpense_model->get_all();
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('pages/mainexpenses', $data);
    }

    public function add_or_update()
    {
        $this->form_validation->set_rules('expense_name', 'Expense Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="text-white">', '</div>'));
            redirect('Mainexpense');
        }

        $id = $this->input->post('record_id');
        $expense_name = $this->input->post('expense_name');
        $comment = $this->input->post('comment');
        $user_id = $this->session->userdata('user_id');

        $data = [
            'main_expense_name' => $expense_name,
            'comment' => $comment,
            'tbl_user_id' => $user_id,
            'status' => 1 
        ];

        if ($id) {
            $this->Mainexpense_model->update($id, $data);
            $this->session->set_flashdata('success', 'Record updated successfully.');
        } else {
            $this->Mainexpense_model->insert($data);
            $this->session->set_flashdata('success', 'Record added successfully.');
        }

        redirect('Mainexpense');
    }


    public function get_by_id($id)
    {
        $data = $this->Mainexpense_model->get_by_id($id);
        echo json_encode($data);
    }

    public function delete($id)
    {
        $data['status'] = 0;
        $this->Mainexpense_model->delete($id, $data);
        $this->session->set_flashdata('success', 'Record deleted successfully.');
        redirect('Mainexpense');
    }
}
