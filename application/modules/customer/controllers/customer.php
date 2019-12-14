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
    

    function _get_data_from_db($update_id) {
        $where['customer.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['name'] = $row->name;
            $data['address'] = $row->address;
            $data['phone'] = $row->phone;
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
        $this->load->model('mdl_customer');
        $this->mdl_customer->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_customer');
        $this->mdl_customer->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_customer');
        $query = $this->mdl_customer->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_get_by_arr_id($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_customer');
        return $this->mdl_customer->_insert($data);
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
}