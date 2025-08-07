<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subexpense extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Subexpense_model');
        $this->load->model('Mainexpense_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['mexpenses'] = $this->Mainexpense_model->get_all();
        $data['sexpenses'] = $this->Subexpense_model->get_all(); 
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('pages/subexpenses', $data);
    }

    public function add_or_update()
    {
        $this->form_validation->set_rules('main_expense_id', 'Mainexpense', 'required');
        $this->form_validation->set_rules('sub_expense_name', 'Subexpense', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="text-white">', '</div>'));
            redirect('subexpense');
        }

        $id = $this->input->post('record_id');
        $sub_expense_name = $this->input->post('sub_expense_name');
        $main_expense_id = $this->input->post('main_expense_id');
        $comment = $this->input->post('comment');
        $user_id = $this->session->userdata('user_id');

        $data = [
            'sub_expense_name' => $sub_expense_name,
            'tbl_main_expense_types_id' => $main_expense_id,
            'comment' => $comment,
            'tbl_user_id' => $user_id,
            'status' => 1
        ];

        if ($id) {
            $this->Subexpense_model->update($id, $data);
            $this->session->set_flashdata('success', 'Record updated successfully.');
        } else {
            $this->Subexpense_model->insert($data);
            $this->session->set_flashdata('success', 'Record added successfully.');
        }

        redirect('subexpense');
    }


    public function get_by_id($id)
    {
        $data = $this->Subexpense_model->get_by_id($id);
        echo json_encode($data);
    }

    public function delete($id)
    {
        $data['status'] = 0; 
        $this->Subexpense_model->delete($id, $data);
        $this->session->set_flashdata('success', 'Record deleted successfully.');
        redirect('subexpense');
    }
}
