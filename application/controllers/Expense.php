<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Expense extends CI_Controller {

    public function main()
    {
        $this->load->view('pages/mainexpenses');
    }

    public function sub()
    {
        $this->load->view('pages/subexpenses');
    }

    public function addexpense()
    {
        $this->load->view('pages/addexpense');
    }
}
