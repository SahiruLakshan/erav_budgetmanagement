<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function index()
    {

        $this->load->view('pages/signin');
    }

    // public function signup()
    // {
    //     $this->load->view('pages/signup');
    // }

    public function register_user()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|max_length[100]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[255]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        $this->form_validation->set_message('is_unique', 'This {field} is already registered.');
        $this->form_validation->set_message('matches', 'Password and Confirm Password do not match.');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('validation_errors', validation_errors());
            redirect('Auth/signup');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            );

            if ($this->User->insert_user($data)) {
                $this->session->set_flashdata('success', 'Registration successful! You can now sign in.');
                redirect('Auth');
            } else {
                $this->session->set_flashdata('error', 'There was an error registering your account. Please try again.');
                redirect('Auth/signup');
            }
        }
    }

    public function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->User->get_user_by_email($email);

        if ($user && password_verify($password, $user['password'])) {
            $this->session->set_userdata('user_id', $user['id']);
            $this->session->set_userdata('user_name', $user['name']);
            redirect('Dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid email or password.');
            redirect('Auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        $this->session->sess_destroy();
        redirect('Auth');
    }
}
