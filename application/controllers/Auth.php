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
        $this->load->library('email');
    }

    public function index()
    {

        $this->load->view('pages/signin');
    }

    public function signup()
    {
        $this->load->view('pages/signup');
    }

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

    public function verify_email()
    {
        $this->load->view('pages/verify_email');
    }

    public function send_verification_code()
    {
        $email = $this->input->post('email');
        $entered_code = $this->input->post('code');

        $user = $this->User->get_user_by_email($email);
        if (!$user) {
            $this->session->set_flashdata('error', 'Email not registered.');
            redirect('Auth/verify_email');
            return;
        }

        if (empty($entered_code)) {
            $verification_code = rand(10000000, 99999999); 
            $this->session->set_userdata('verification_email', $email);
            $this->session->set_userdata('verification_code', $verification_code);

            $this->load->library('email');
            $this->email->from('teccom.srilanka@gmail.com', 'Your App Name');
            $this->email->to($email);
            $this->email->subject('Password Reset Verification Code');
            $this->email->message("Your verification code is: $verification_code");

            if ($this->email->send()) {
                $this->session->set_flashdata('success', 'Verification code sent to your registered email.');
            } else {
                $this->session->set_flashdata('error', 'Failed to send email. Try again.');
            }

            redirect('Auth/verify_email');
            return;
        }

        $session_code = $this->session->userdata('verification_code');
        $session_email = $this->session->userdata('verification_email');

        if ($entered_code == $session_code && $email == $session_email) {
            $this->session->unset_userdata('verification_code'); 
            redirect('Auth/change_password?email=' . urlencode($email));
        } else {
            $this->session->set_flashdata('error', 'Invalid verification code.');
            redirect('Auth/verify_email');
        }
    }

    public function change_password()
    {
        $email = $this->input->get('email');

        $session_email = $this->session->userdata('verification_email');
        if ($email != $session_email) {
            $this->session->set_flashdata('error', 'Unauthorized access.');
            redirect('Auth/verify_email');
        }

        $this->load->view('pages/change_password', ['email' => $email]);
    }

    public function change()
    {
        $email = $this->input->post('email');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        if (empty($new_password) || empty($confirm_password)) {
            $this->session->set_flashdata('error', 'All fields are required.');
            redirect('Auth/change_password?email=' . urlencode($email));
            return;
        }

        if ($new_password !== $confirm_password) {
            $this->session->set_flashdata('error', 'Passwords do not match.');
            redirect('Auth/change_password?email=' . urlencode($email));
            return;
        }

        if ($this->User->update_password_by_email($email, $new_password)) {
            $this->session->unset_userdata('verification_email'); 
            $this->session->set_flashdata('success', 'Password changed successfully!');
            redirect('Auth/login');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong.');
            redirect('Auth/change_password?email=' . urlencode($email));
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
