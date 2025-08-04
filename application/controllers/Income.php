<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Income extends CI_Controller {

    public function main()
    {
        $this->load->view('pages/mainincome');
    }

    public function sub()
    {
        $this->load->view('pages/subincome');
    }

    public function addincome()
    {
        $this->load->view('pages/addincome');
    }
}
