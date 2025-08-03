<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Dashboard extends CI_Controller {

    public function index()
    {
        $this->load->view('pages/index');
    }
}
