<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mainincome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mainincome_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['mincomes'] = $this->Mainincome_model->get_all();
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('pages/mainincome', $data);
    }

    public function add_or_update()
    {
        $this->form_validation->set_rules('income_name', 'Income Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="text-white">', '</div>'));
            redirect('Mainincome');
        }

        $id = $this->input->post('record_id');
        $income_name = $this->input->post('income_name');
        $comment = $this->input->post('comment');
        $user_id = $this->session->userdata('user_id');

        $data = [
            'income_name' => $income_name,
            'comment' => $comment,
            'tbl_user_id' => $user_id,
            'status' => 1 
        ];

        if ($id) {
            $this->Mainincome_model->update($id, $data);
            $this->session->set_flashdata('success', 'Record updated successfully.');
        } else {
            $this->Mainincome_model->insert($data);
            $this->session->set_flashdata('success', 'Record added successfully.');
        }

        redirect('Mainincome');
    }


    public function get_by_id($id)
    {
        $data = $this->Mainincome_model->get_by_id($id);
        echo json_encode($data);
    }

    public function delete($id)
    {
        $data['status'] = 0;
        $this->Mainincome_model->delete($id, $data);
        $this->session->set_flashdata('success', 'Record deleted successfully.');
        redirect('Mainincome');
    }
}
