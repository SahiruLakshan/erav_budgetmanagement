<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');

        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $balances = $this->Dashboard_model->get_balances();
        $data['banks'] = $balances['banks'];
        $data['opening_balance'] = $balances['total_balance'];
        $data['cash_in_hand'] = $balances['cash_in_hand'];
        $data['transactions'] = $this->Dashboard_model->get_recent_transactions();

        $this->load->view('pages/index', $data);
    }

    public function monthly_transactions()
    {
        $data['chart_data'] = $this->Dashboard_model->get_monthly_incomes_expenses();
        $this->load->view('dashboard', $data);
    }

    public function get_monthly_data()
    {
        $result = $this->Dashboard_model->get_monthly_incomes_expenses();
        echo json_encode($result);
    }

    public function get_yearly_profit_data()
    {
        $result = $this->Dashboard_model->get_yearly_monthly_profit();
        echo json_encode($result);
    }
}
