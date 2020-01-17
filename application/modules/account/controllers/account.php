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

    function bank_deposit() {
        $account = $this->_get('id desc')->result_array();
        $customer = Modules::run('customer/_get','id desc')->result_array();
        $supplier = Modules::run('supplier/_get','id desc')->result_array();
        $all = array_merge($account,$customer,$supplier);
        $data['account'] = $all;
        $data['view_file'] = 'bank_deposit';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_bank_deposit() {
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
        $data['transaction_type'] ='BD';
        $data['ref_no'] = $this->input->post('ref_no');
        $data['from_comment'] = $this->input->post('from_comment');
        $data['to_comment'] = $this->input->post('to_comment');
        $data['date'] = $this->input->post('date');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        $this->_insert_transaction($data);

        if ($type_from == 'Cash-in-hand' || $type_from == 'Loan' || $type_from == 'Asset' || $type_from == 'Bank') {
            $account = $this->_get_account($data['account_from_id'],$type_from)->result_array();
            $cash['opening_balance'] = $account[0]['opening_balance'] - $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_from,$cash);
        }
        elseif ($type_from == 'customer') {
            $where['id'] = $data['account_from_id'];
            $customer = Modules::run('customer/_get_by_arr_id',$where)->result_array();

            $data2['remaining'] = $customer[0]['remaining'] - $data['amount'];
            $data2['paid'] = $customer[0]['paid'] + $data['amount'];
            Modules::run('sale_invoice/_update_customer_amount',$data['account_from_id'],$data2,$data['org_id']);
        }

        if ($type_to == 'Cash-in-hand' || $type_to == 'Bank') {
            $account = $this->_get_account($data['account_to_id'],$type_to)->result_array();
            $cash['opening_balance'] = $account[0]['opening_balance'] + $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_to,$cash);
        }
        elseif ($type_to == 'Salary' || $type_to == 'Loan' || $type_to == 'Asset') {
            $account = $this->_get_account($data['account_to_id'],$type_to)->result_array();
            $cash['paid'] = $account[0]['paid'] + $data['amount'];
            $cash['remaining'] = $account[0]['remaining'] - $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_to,$cash);
        }
        elseif ($type_to == 'supplier') {
            $where['id'] = $data['account_to_id'];
            $supplier = Modules::run('supplier/_get_by_arr_id',$where)->result_array();

            $data2['remaining'] = $supplier[0]['remaining'] - $data['amount'];
            $data2['paid'] = $supplier[0]['paid'] + $data['amount'];

            Modules::run('purchase_invoice/_update_supplier_amount',$data['account_to_id'],$data2,$data['org_id']);
        }

        $this->session->set_flashdata('message', 'account'.' '.DATA_SAVED);                 
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'account/bank_deposit');
    }

    function  bank_recieved() {
        $account = $this->_get('id desc')->result_array();
        $customer = Modules::run('customer/_get','id desc')->result_array();
        $supplier = Modules::run('supplier/_get','id desc')->result_array();
        $all = array_merge($account,$customer,$supplier);
        $data['account'] = $all;
        $data['view_file'] = 'bank_recieved';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_bank_recieved() {
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
        $data['transaction_type'] ='BR';
        $data['ref_no'] = $this->input->post('ref_no');
        $data['from_comment'] = $this->input->post('from_comment');
        $data['to_comment'] = $this->input->post('to_comment');
        $data['date'] = $this->input->post('date');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        $this->_insert_transaction($data);

        if ($type_from == 'Cash-in-hand' || $type_from == 'Loan' || $type_from == 'Asset' || $type_from == 'Bank') {
            $account = $this->_get_account($data['account_from_id'],$type_from)->result_array();
            $cash['opening_balance'] = $account[0]['opening_balance'] - $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_from,$cash);
        }
        elseif ($type_from == 'customer') {
            $where['id'] = $data['account_from_id'];
            $customer = Modules::run('customer/_get_by_arr_id',$where)->result_array();

            $data2['remaining'] = $customer[0]['remaining'] - $data['amount'];
            $data2['paid'] = $customer[0]['paid'] + $data['amount'];
            Modules::run('sale_invoice/_update_customer_amount',$data['account_from_id'],$data2,$data['org_id']);
        }

        if ($type_to == 'Cash-in-hand' || $type_to == 'Bank') {
            $account = $this->_get_account($data['account_to_id'],$type_to)->result_array();
            $cash['opening_balance'] = $account[0]['opening_balance'] + $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_to,$cash);
        }
        elseif ($type_to == 'Salary' || $type_to == 'Loan' || $type_to == 'Asset') {
            $account = $this->_get_account($data['account_to_id'],$type_to)->result_array();
            $cash['paid'] = $account[0]['paid'] + $data['amount'];
            $cash['remaining'] = $account[0]['remaining'] - $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_to,$cash);
        }
        elseif ($type_to == 'supplier') {
            $where['id'] = $data['account_to_id'];
            $supplier = Modules::run('supplier/_get_by_arr_id',$where)->result_array();

            $data2['remaining'] = $supplier[0]['remaining'] - $data['amount'];
            $data2['paid'] = $supplier[0]['paid'] + $data['amount'];

            Modules::run('purchase_invoice/_update_supplier_amount',$data['account_to_id'],$data2,$data['org_id']);
        }

        $this->session->set_flashdata('message', 'account'.' '.DATA_SAVED);                 
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'account/bank_recieved');
    }

    function journal_voucher() {
        $account = $this->_get('id desc')->result_array();
        $customer = Modules::run('customer/_get','id desc')->result_array();
        $supplier = Modules::run('supplier/_get','id desc')->result_array();
        $all = array_merge($account,$customer,$supplier);
        $data['account'] = $all;
        $data['view_file'] = 'journal_voucher';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_journal_voucher() {
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
        $data['transaction_type'] ='JV';
        $data['from_comment'] = $this->input->post('from_comment');
        $data['to_comment'] = $this->input->post('to_comment');
        $data['date'] = $this->input->post('date');
        $data['ref_no'] = $this->input->post('ref_no');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        $this->_insert_transaction($data);

        if ($type_from == 'Cash-in-hand' || $type_from == 'Loan' || $type_from == 'Asset' || $type_from == 'Bank') {
            $account = $this->_get_account($data['account_from_id'],$type_from)->result_array();
            $cash['opening_balance'] = $account[0]['opening_balance'] - $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_from,$cash);
        }
        elseif ($type_from == 'customer') {
            $where['id'] = $data['account_from_id'];
            $customer = Modules::run('customer/_get_by_arr_id',$where)->result_array();

            $data2['remaining'] = $customer[0]['remaining'] - $data['amount'];
            $data2['paid'] = $customer[0]['paid'] + $data['amount'];
            Modules::run('sale_invoice/_update_customer_amount',$data['account_from_id'],$data2,$data['org_id']);
        }

        if ($type_to == 'Cash-in-hand' || $type_to == 'Bank') {
            $account = $this->_get_account($data['account_to_id'],$type_to)->result_array();
            $cash['opening_balance'] = $account[0]['opening_balance'] + $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_to,$cash);
        }
        elseif ($type_to == 'Salary' || $type_to == 'Loan' || $type_to == 'Asset') {
            $account = $this->_get_account($data['account_to_id'],$type_to)->result_array();
            $cash['paid'] = $account[0]['paid'] + $data['amount'];
            $cash['remaining'] = $account[0]['remaining'] - $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_to,$cash);
        }
        elseif ($type_to == 'supplier') {
            $where['id'] = $data['account_to_id'];
            $supplier = Modules::run('supplier/_get_by_arr_id',$where)->result_array();

            $data2['remaining'] = $supplier[0]['remaining'] - $data['amount'];
            $data2['paid'] = $supplier[0]['paid'] + $data['amount'];

            Modules::run('purchase_invoice/_update_supplier_amount',$data['account_to_id'],$data2,$data['org_id']);
        }

        $this->session->set_flashdata('message', 'account'.' '.DATA_SAVED);                 
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'account/journal_voucher');
    }

    function cash_payment() {
        $account = $this->_get('id desc')->result_array();
        $customer = Modules::run('customer/_get','id desc')->result_array();
        $supplier = Modules::run('supplier/_get','id desc')->result_array();
        $all = array_merge($account,$customer,$supplier);
        $data['account'] = $all;
        $data['view_file'] = 'cash_payment';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_cash_payment() {
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
        $data['transaction_type'] ='CP';
        $data['comment'] = $this->input->post('comment');
        $data['ref_no'] = $this->input->post('ref_no');
        $data['date'] = date('Y-m-d');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        $this->_insert_transaction($data);

        if ($type_from == 'Cash-in-hand' || $type_from == 'Loan' || $type_from == 'Asset' || $type_from == 'Bank') {
            $account = $this->_get_account($data['account_from_id'],$type_from)->result_array();
            $cash['opening_balance'] = $account[0]['opening_balance'] - $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_from,$cash);
        }
        elseif ($type_from == 'customer') {
            $where['id'] = $data['account_from_id'];
            $customer = Modules::run('customer/_get_by_arr_id',$where)->result_array();

            $data2['remaining'] = $customer[0]['remaining'] - $data['amount'];
            $data2['paid'] = $customer[0]['paid'] + $data['amount'];
            Modules::run('sale_invoice/_update_customer_amount',$data['account_from_id'],$data2,$data['org_id']);
        }

        if ($type_to == 'Cash-in-hand' || $type_to == 'Bank') {
            $account = $this->_get_account($data['account_to_id'],$type_to)->result_array();
            $cash['opening_balance'] = $account[0]['opening_balance'] + $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_to,$cash);
        }
        elseif ($type_to == 'Salary' || $type_to == 'Loan' || $type_to == 'Asset') {
            $account = $this->_get_account($data['account_to_id'],$type_to)->result_array();
            $cash['paid'] = $account[0]['paid'] + $data['amount'];
            $cash['remaining'] = $account[0]['remaining'] - $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_to,$cash);
        }
        elseif ($type_to == 'supplier') {
            $where['id'] = $data['account_to_id'];
            $supplier = Modules::run('supplier/_get_by_arr_id',$where)->result_array();

            $data2['remaining'] = $supplier[0]['remaining'] - $data['amount'];
            $data2['paid'] = $supplier[0]['paid'] + $data['amount'];

            Modules::run('purchase_invoice/_update_supplier_amount',$data['account_to_id'],$data2,$data['org_id']);
        }

        $this->session->set_flashdata('message', 'account'.' '.DATA_SAVED);                 
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'account/cash_payment');
    }

    function cash_recieved() {
        $account = $this->_get('id desc')->result_array();
        $customer = Modules::run('customer/_get','id desc')->result_array();
        $supplier = Modules::run('supplier/_get','id desc')->result_array();
        $all = array_merge($account,$customer,$supplier);
        $data['account'] = $all;
        $data['view_file'] = 'cash_recieved';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_cash_recieved() {
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
        $data['transaction_type'] ='CR';
        $data['comment'] = $this->input->post('comment');
        $data['ref_no'] = $this->input->post('ref_no');
        $data['date'] = date('Y-m-d');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        $this->_insert_transaction($data);

        if ($type_from == 'Cash-in-hand' || $type_from == 'Loan' || $type_from == 'Asset' || $type_from == 'Bank') {
            $account = $this->_get_account($data['account_from_id'],$type_from)->result_array();
            $cash['opening_balance'] = $account[0]['opening_balance'] - $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_from,$cash);
        }
        elseif ($type_from == 'customer') {
            $where['id'] = $data['account_from_id'];
            $customer = Modules::run('customer/_get_by_arr_id',$where)->result_array();

            $data2['remaining'] = $customer[0]['remaining'] - $data['amount'];
            $data2['paid'] = $customer[0]['paid'] + $data['amount'];
            Modules::run('sale_invoice/_update_customer_amount',$data['account_from_id'],$data2,$data['org_id']);
        }

        if ($type_to == 'Cash-in-hand' || $type_to == 'Bank') {
            $account = $this->_get_account($data['account_to_id'],$type_to)->result_array();
            $cash['opening_balance'] = $account[0]['opening_balance'] + $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_to,$cash);
        }
        elseif ($type_to == 'Salary' || $type_to == 'Loan' || $type_to == 'Asset') {
            $account = $this->_get_account($data['account_to_id'],$type_to)->result_array();
            $cash['paid'] = $account[0]['paid'] + $data['amount'];
            $cash['remaining'] = $account[0]['remaining'] - $data['amount'];
            $this->_update_account_balance($account[0]['id'],$type_to,$cash);
        }
        elseif ($type_to == 'supplier') {
            $where['id'] = $data['account_to_id'];
            $supplier = Modules::run('supplier/_get_by_arr_id',$where)->result_array();

            $data2['remaining'] = $supplier[0]['remaining'] - $data['amount'];
            $data2['paid'] = $supplier[0]['paid'] + $data['amount'];

            Modules::run('purchase_invoice/_update_supplier_amount',$data['account_to_id'],$data2,$data['org_id']);
        }

        $this->session->set_flashdata('message', 'account'.' '.DATA_SAVED);                 
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'account/cash_recieved');
    }

    function transaction_list() {
        $data['news'] = $this->_get_transaction_list();
        $data['view_file'] = 'transaction_list';
        $this->load->module('template');
        $this->template->admin($data);
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
        $data['remaining'] = $data['opening_balance'] - $data['paid'];
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

    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->_delete($delete_id, $org_id);
    }
    

///////////////////////////     HELPER FUNCTIONS    ////////////////////

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_account');
        $this->mdl_account->_delete($arr_col, $org_id);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_account');
        $this->mdl_account->_update($arr_col, $org_id, $data);
    }

    function _get($order_by) {
        $this->load->model('mdl_account');
        return $this->mdl_account->_get($order_by);
    }

    function _get_for_cash_recieved($order_by){
        $this->load->model('mdl_account');
        return $this->mdl_account->_get_for_cash_recieved($order_by);
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

    function _update_account_balance($id,$type,$data){
        $this->load->model('mdl_account');
        return $this->mdl_account->_update_account_balance($id,$type,$data);
    }

    function _get_account($id,$type){
        $this->load->model('mdl_account');
        return $this->mdl_account->_get_account($id,$type);
    }
}