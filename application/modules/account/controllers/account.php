<?php

if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');

class Account extends MX_Controller
{

    function __construct() {
        parent::__construct();
        Modules::run('site_security/is_login');
    }

    function index() {
        $this->manage();
    }

    function manage() {
        $data['news'] = $this->_get('id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function create() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function chart_of_account() {
        $account = $this->_get('id desc');
        $customer = Modules::run('customer/_get','id desc');
        $supplier = Modules::run('supplier/_get','id desc');
        $data['news'] = $account;
        $data['customer'] = $customer;
        $data['supplier'] = $supplier;
        $data['view_file'] = 'chart_of_account';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function transaction() {
        $account = $this->_get('id desc')->result_array();
        $data['account'] = $account;
        $data['view_file'] = 'transaction';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function transaction_list() {
        $data['news'] = $this->_get_transaction_list();
        $data['view_file'] = 'transaction_list';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_transaction() {
        $account_from = $this->input->post('account_from');
        if (isset($account_from) && !empty($account_from)) {
            $account_from2=explode(',', $account_from);
            $data['account_from_id'] = $account_from2[0];
            $data['account_from_name'] = $account_from2[1];
            $type_from = $account_from2[2];
        }

        $account_to = $this->input->post('account_to');
        if (isset($account_to) && !empty($account_to)) {
            $account_to2=explode(',', $account_to);
            $data['account_to_id'] = $account_to2[0];
            $data['account_to_name'] = $account_to2[1];
            $type_to = $account_to2[2];
        }
        $data['amount'] = $this->input->post('amount');
        $data['comment'] = $this->input->post('comment');
        $data['ref_no'] = $this->input->post('ref_no');
        $data['date'] = date('Y-m-d');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        $this->_insert_transaction($data);

        if ($type_from == 'Cash-in-hand') {
            $cash_in_hand = $this->_get_cash_in_hand()->result_array();
            $cash['opening_balance'] = $cash_in_hand[0]['opening_balance'] - $data['amount'];
            $this->_update_cash_in_hand($cash);
        }
        elseif ($type_from == 'Bank') {
            $cash = $this->_get_account_balance($type_to)->result_array();
            $cash['paid'] = $cash[0]['paid'] + $data['amount'];
            $cash['remaining'] = $cash[0]['remaining'] - $data['amount'];
            $this->_update_cash($type_from,$data);
        }
        elseif ($type_from == 'Loan') {
            $cash = $this->_get_account_balance($type_to)->result_array();
            $cash['paid'] = $cash[0]['opening_balance'] - $data['amount'];
            $this->_update_cash($type_from,$data);
        }
        if ($type_to == 'Cash-in-hand') {
            $cash_in_hand = $this->_get_cash_in_hand()->result_array();
            $cash['opening_balance'] = $cash_in_hand[0]['opening_balance'] + $data['amount'];
            $this->_update_cash_in_hand($cash);
        }
        elseif ($type_to == 'Bank') {
            $cash = $this->_get_account_balance($type_to)->result_array();
            $cash['opening_balance'] = $cash[0]['opening_balance'] + $data['amount'];
            $cash['remaining'] = $cash[0]['remaining'] + $data['amount'];
            $this->_update_cash($type_from,$data);
        }
        elseif ($type_to == 'Salary') {
            $cash = $this->_get_account_balance($type_to)->result_array();
            $cash['paid'] = $cash[0]['paid'] + $data['amount'];
            $this->_update_cash($type_from,$data);
        }
        elseif ($type_to == 'Loan') {
            $cash = $this->_get_account_balance($type_to)->result_array();
            $cash['opening_balance'] = $cash[0]['opening_balance'] + $data['amount'];
            $this->_update_cash($type_from,$data);
        }

        $this->session->set_flashdata('message', 'account'.' '.DATA_SAVED);                 
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'account/transaction');
    }
    

    function _get_data_from_db($update_id) {
        $where['account.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['name'] = $row->name;
            $data['comment'] = $row->comment;
            $data['opening_balance'] = $row->opening_balance;
            $data['paid'] = $row->paid;
            $data['remaining'] = $row->remaining;
            $data['type'] = $row->type;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $data['name'] = $this->input->post('name');
        $data['type'] = $this->input->post('type');
        $data['opening_balance'] = $this->input->post('opening_balance');
        $data['date'] = date('Y-m-d');
        $data['paid'] = $this->input->post('paid');
        $data['remaining'] = $this->input->post('remaining');
        $data['comment'] = $this->input->post('comment');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;

    }

    function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        $user_data = $this->session->userdata('user_data');

        if ($update_id != 0) {
            $id = $this->_update($update_id,$user_data['user_id'], $data);
        }
        else
        {
            $id = $this->_insert($data);
        }
            $this->session->set_flashdata('message', 'account'.' '.DATA_SAVED);
	        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'account');
    }

    function check_cash_in_hand(){
    $type = $this->input->post('type');
    $query = $this->_check_cash_in_hand($type);
    if ($query->num_rows() > 0){
        echo '1';
    }
    else{
        echo '0';
    }
    }
    

///////////////////////////     HELPER FUNCTIONS    ////////////////////

    

    function _get($order_by) {
        $this->load->model('mdl_account');
        return $this->mdl_account->_get($order_by);
    }

    function _get_chart_of_account($order_by){
        $this->load->model('mdl_account');
        return $this->mdl_account->_get_chart_of_account($order_by);
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_account');
        return $this->mdl_account->_get_by_arr_id($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_account');
        return $this->mdl_account->_insert($data);
    }

    function _insert_transaction($data) {
        $this->load->model('mdl_account');
        return $this->mdl_account->_insert_transaction($data);
    }

    function _get_transaction_list() {
        $this->load->model('mdl_account');
        return $this->mdl_account->_get_transaction_list();
    }

    function _check_cash_in_hand($type){
        $this->load->model('mdl_account');
        return $this->mdl_account->_check_cash_in_hand($type);
    }

    function _update_cash_in_hand($data) {
        $this->load->model('mdl_account');
        return $this->mdl_account->_update_cash_in_hand($data);
    }

    function _update_cash($type,$data) {
        $this->load->model('mdl_account');
        return $this->mdl_account->_update_cash($type,$data);
    }

    function _get_cash_in_hand() {
        $this->load->model('mdl_account');
        return $this->mdl_account->_get_cash_in_hand();
    }

    function _get_account_balance($type){
        $this->load->model('mdl_account');
        return $this->mdl_account->_get_account_balance($type);
    }
}