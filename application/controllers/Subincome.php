<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subincome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Subincome_model');
        $this->load->model('Mainincome_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['mincomes'] = $this->Mainincome_model->get_all();
        $data['sincomes'] = $this->Subincome_model->get_all(); 
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('pages/subincome', $data);
    }

    public function add_or_update()
    {
        $this->form_validation->set_rules('main_income_id', 'Mainincome', 'required');
        $this->form_validation->set_rules('sub_income_name', 'Subincome', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="text-white">', '</div>'));
            redirect('Subincome');
        }

        $id = $this->input->post('record_id');
        $sub_income_name = $this->input->post('sub_income_name');
        $main_income_id = $this->input->post('main_income_id');
        $comment = $this->input->post('comment');
        $user_id = $this->session->userdata('user_id');

        $data = [
            'sub_income_name' => $sub_income_name,
            'tbl_main_income_types_id' => $main_income_id,
            'comment' => $comment,
            'tbl_user_id' => $user_id,
            'status' => 1
        ];

        if ($id) {
            $this->Subincome_model->update($id, $data);
            $this->session->set_flashdata('success', 'Record updated successfully.');
        } else {
            $this->Subincome_model->insert($data);
            $this->session->set_flashdata('success', 'Record added successfully.');
        }

        redirect('Subincome');
    }


    public function get_by_id($id)
    {
        $data = $this->Subincome_model->get_by_id($id);
        echo json_encode($data);
    }

    public function delete($id)
    {
        $data['status'] = 0; 
        $this->Subincome_model->delete($id, $data);
        $this->session->set_flashdata('success', 'Record deleted successfully.');
        redirect('Subincome');
    }
}
