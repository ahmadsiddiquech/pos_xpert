<?php

if ( ! defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Test extends MX_Controller
{

    function __construct() {
        parent::__construct();
        Modules::run('site_security/is_login');
    }

    function index() {
        $this->manage();
    }

    function manage() {
        $data['news'] = $this->_get('test_lab.id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function create() {
        $update_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        
        $unit = Modules::run('unit/_get_by_arr_id_unit',$org_id)->result_array();
        $category = Modules::run('category/_get_by_arr_id_category',$org_id)->result_array();
       
        $data['unit'] = $unit;
        $data['category'] = $category;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['test_code'] = $row->test_code;
            $data['name'] = $row->name;
            $data['category_id'] = $row->category_id;
            $data['category_name'] = $row->category_name;
            $data['unit_id'] = $row->unit_id;
            $data['unit_name'] = $row->unit_name;
            $data['male_value'] = $row->male_value;
            $data['female_value'] = $row->female_value;
            $data['child_value'] = $row->child_value;
            $data['delivery_time'] = $row->delivery_time;
            $data['charges'] = $row->charges;
            $data['sample'] = $row->sample;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }

    function _get_data_from_post() {
        $category = $this->input->post('category');
        if(isset($category) && !empty($category)){
            $catData = explode(",",$category);
            $data['category_id'] = $catData[0];
            $data['category_name'] = $catData[1];
        }
        $unit = $this->input->post('unit');
        if(isset($unit) && !empty($unit)){
            $unitData = explode(",",$unit);
            $data['unit_id'] = $unitData[0];
            $data['unit_name'] = $unitData[1];
        }
        $data['name'] = $this->input->post('name');
        $data['test_code'] = $this->input->post('test_code');
        $data['male_value'] = $this->input->post('male_value');
        $data['female_value'] = $this->input->post('female_value');
        $data['child_value'] = $this->input->post('child_value');
        $data['delivery_time'] = $this->input->post('delivery_time');
        $data['charges'] = $this->input->post('charges');
        $data['sample'] = $this->input->post('sample');

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
            else {
                $test_id = $this->_insert($data);
            }
            $this->session->set_flashdata('message', 'test'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'test');
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
        $this->session->set_flashdata('message', 'Post published successfully.');
        redirect(ADMIN_BASE_URL . 'test/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'test/manage/' . '');
    }

    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == PUBLISHED)
            $status = UN_PUBLISHED;
        else
            $status = PUBLISHED;
        $data = array('status' => $status);
        $status = $this->_update_id($id, $data);
        echo $status;
    }

    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }

    function _set_publish($arr_col) {
        $this->load->model('mdl_test');
        $this->mdl_test->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_test');
        $this->mdl_test->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_test');
        $query = $this->mdl_test->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($where) {
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_by_arr_id($where);
    }

    function _insert($data){
        $this->load->model('mdl_test');
        return $this->mdl_test->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_test');
        $this->mdl_test->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_test');
        $this->mdl_test->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_test');
        $this->mdl_test->_delete($arr_col, $org_id);
    }

    function _get_by_arr_id_test($org_id){
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_by_arr_id_test($org_id);
    }
}