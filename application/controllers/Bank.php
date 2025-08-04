<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Bank extends CI_Controller {

    public function add()
    {
        $this->load->view('pages/addbank');
    }

}
