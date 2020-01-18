<?php

if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');

class Customer extends MX_Controller
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

    function invoice_list() {
        $customer_id = $this->uri->segment(4);
        if (is_numeric($customer_id) && $customer_id != 0) {
            $data['news'] = $this->_get_invoice_list($customer_id);
        }
        $data['view_file'] = 'invoice_list';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function invoice_list_print() {
        $customer_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['invoice'] = $this->_get_invoice_list_print($customer_id,$org_id)->result_array();
        $this->load->view('invoice_list_print',$data);
    }

    function product_list() {
        $invoice_id = $this->uri->segment(4);
        if (is_numeric($invoice_id) && $invoice_id != 0) {
            $data['news'] = $this->_get_product_list($invoice_id);
        }
        $data['view_file'] = 'product_list';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function transaction() {
        $customer_id = $this->uri->segment(4);
        $where['id'] = $customer_id;
        if (is_numeric($customer_id) && $customer_id != 0) {
            $data['news'] = $this->_get_by_arr_id($where)->result_array();
        }
        $data['view_file'] = 'transaction';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function transaction_list() {
        $customer_id = $this->uri->segment(4);
        if (is_numeric($customer_id) && $customer_id != 0) {
            $data['news'] = $this->_get_transaction_list($customer_id);
        }
        $data['view_file'] = 'transaction_list';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_transaction() {
        $data['depositer_id'] = $this->input->post('id');
        $data['depositer_name'] = $this->input->post('name');
        $data['depositer_type'] = 'customer';
        $data['total'] = $this->input->post('total');
        $data['paid'] = $this->input->post('paid');
        $data['remaining'] = $this->input->post('remaining');
        $data['ref_no'] = $this->input->post('ref_no');
        $data['transaction_amount'] = $this->input->post('transaction_amount');
        $data['date'] = date('Y-m-d');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];

        $this->_insert_transaction($data);

        $data2['paid'] = $data['paid'] + $data['transaction_amount'];
        $data2['remaining'] = $data['remaining'] - $data['transaction_amount'];
        Modules::run('sale_invoice/_update_customer_amount',$data['depositer_id'],$data2,$data['org_id']);

        $cash_in_hand = Modules::run('account/_get_cash_in_hand')->result_array();
        $cash['opening_balance'] = $cash_in_hand[0]['opening_balance'] + $data['transaction_amount'];
        Modules::run('account/_update_cash_in_hand',$cash);

        $this->session->set_flashdata('message', 'customer'.' '.DATA_SAVED);                                        
        $this->session->set_flashdata('status', 'success');
        
        redirect(ADMIN_BASE_URL . 'customer');
    }
    

    function _get_data_from_db($update_id) {
        $where['customer.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['name'] = $row->name;
            $data['address'] = $row->address;
            $data['phone'] = $row->phone;
            $data['total'] = $row->total;
            $data['balance'] = $row->balance;
            $data['paid'] = $row->paid;
            $data['remaining'] = $row->remaining;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $data['name'] = $this->input->post('name');
        $data['address'] = $this->input->post('address');
        $data['phone'] = $this->input->post('phone');
        $data['total'] = $this->input->post('total');
        $data['balance'] = $this->input->post('total');
        $data['paid'] = $this->input->post('paid');
        $data['remaining'] = $data['total'] - $data['paid'];
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
            $this->session->set_flashdata('message', 'customer'.' '.DATA_SAVED);										
	        $this->session->set_flashdata('status', 'success');
        
        redirect(ADMIN_BASE_URL . 'customer');
    }

    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->_delete($delete_id, $org_id);
    }

    function set_publish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_publish($where);
        $this->session->set_flashdata('message', 'customer published successfully.');
        redirect(ADMIN_BASE_URL . 'program/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'customer un-published successfully.');
        redirect(ADMIN_BASE_URL . 'program/manage/' . '');
    }

    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == 'Paid'){
            $status = 'Un-Paid';
        }
        else{
            $status = 'Paid';
        }
        $data = array('status' => $status);
        $status = $this->_update_id($id, $data);
        echo $status;
    }

    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }

///////////////////////////     HELPER FUNCTIONS    ////////////////////

    function _set_publish($arr_col) {
        $this->load->model('mdl_customer');
        $this->mdl_customer->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_customer');
        $this->mdl_customer->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_get($order_by);
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_get_by_arr_id($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_insert($data);
    }

    function _insert_transaction($data) {
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_insert_transaction($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_customer');
        $this->mdl_customer->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_customer');
        $this->mdl_customer->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_customer');
        $this->mdl_customer->_delete($arr_col, $org_id);
    }

    function _get_by_arr_id_customer($org_id){
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_get_by_arr_id_customer($org_id);
    }

    function _get_invoice_list($customer_id) {
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_get_invoice_list($customer_id);
    }

    function _get_invoice_list_print($customer_id,$org_id) {
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_get_invoice_list_print($customer_id,$org_id);
    }

    function _get_product_list($invoice_id) {
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_get_product_list($invoice_id);
    }

    function _get_transaction_list($customer_id) {
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_get_transaction_list($customer_id);
    }
}