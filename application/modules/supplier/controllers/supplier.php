<?php

if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');

class Supplier extends MX_Controller
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
        $supplier_id = $this->uri->segment(4);
        if (is_numeric($supplier_id) && $supplier_id != 0) {
            $data['news'] = $this->_get_invoice_list($supplier_id);
        }
        $data['view_file'] = 'invoice_list';
        $this->load->module('template');
        $this->template->admin($data);
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
        $supplier_id = $this->uri->segment(4);
        $where['id'] = $supplier_id;
        if (is_numeric($supplier_id) && $supplier_id != 0) {
            $data['news'] = $this->_get_by_arr_id($where)->result_array();
        }
        $data['view_file'] = 'transaction';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function transaction_list() {
        $supplier_id = $this->uri->segment(4);
        if (is_numeric($supplier_id) && $supplier_id != 0) {
            $data['news'] = $this->_get_transaction_list($supplier_id);
        }
        $data['view_file'] = 'transaction_list';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_transaction() {
        $data['depositer_id'] = $this->input->post('id');
        $data['depositer_name'] = $this->input->post('name');
        $data['depositer_type'] = 'supplier';
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
        Modules::run('purchase_invoice/_update_supplier_amount',$data['depositer_id'],$data2,$data['org_id']);

        $this->session->set_flashdata('message', 'supplier'.' '.DATA_SAVED);                                        
        $this->session->set_flashdata('status', 'success');
        
        redirect(ADMIN_BASE_URL . 'supplier');
    }
    

    function _get_data_from_db($update_id) {
        $where['supplier.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['name'] = $row->name;
            $data['city'] = $row->city;
            $data['comments'] = $row->comments;
            $data['company_name'] = $row->company_name;
            $data['phone'] = $row->phone;
            $data['total'] = $row->total;
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
        $data['city'] = $this->input->post('city');
        $data['phone'] = $this->input->post('phone');
        $data['company_name'] = $this->input->post('company_name');
        $data['total'] = $this->input->post('total');
        $data['paid'] = $this->input->post('paid');
        $data['remaining'] = $data['total'] - $data['paid'];
        $data['comments'] = $this->input->post('comments');
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
            $this->session->set_flashdata('message', 'supplier'.' '.DATA_SAVED);										
	        $this->session->set_flashdata('status', 'success');
        
        redirect(ADMIN_BASE_URL . 'supplier');
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
        $this->session->set_flashdata('message', 'supplier published successfully.');
        redirect(ADMIN_BASE_URL . 'program/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'supplier un-published successfully.');
        redirect(ADMIN_BASE_URL . 'program/manage/' . '');
    }

    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == PUBLISHED){
            $status = UN_PUBLISHED;
        }
        else{
            $status = PUBLISHED;
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
        $this->load->model('mdl_supplier');
        $this->mdl_supplier->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_supplier');
        $this->mdl_supplier->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_supplier');
        $query = $this->mdl_supplier->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->_get_by_arr_id($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->_insert($data);
    }

    function _insert_transaction($data) {
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->_insert_transaction($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_supplier');
        $this->mdl_supplier->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_supplier');
        $this->mdl_supplier->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_supplier');
        $this->mdl_supplier->_delete($arr_col, $org_id);
    }

    function _get_by_arr_id_supplier($org_id){
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->_get_by_arr_id_supplier($org_id);
    }

    function _get_invoice_list($supplier_id) {
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->_get_invoice_list($supplier_id);
    }

    function _get_product_list($invoice_id) {
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->_get_product_list($invoice_id);
    }

    function _get_transaction_list($supplier_id) {
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->_get_transaction_list($supplier_id);
    }
}