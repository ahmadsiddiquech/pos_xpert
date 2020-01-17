<?php

if ( ! defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Product extends MX_Controller
{

    function __construct() {
        parent::__construct();
        Modules::run('site_security/is_login');
    }

    function index() {
        $this->manage();
    }

    function manage() {
        $data['news'] = $this->_get('product.id desc');
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
        $category = Modules::run('category/_get_by_arr_id_category',$org_id)->result_array();
        $supplier = Modules::run('supplier/_get_by_arr_id_supplier',$org_id)->result_array();

        $data['supplier'] = $supplier;
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
            $data['name'] = $row->name;
            $data['supplier_id'] = $row->supplier_id;
            $data['supplier_name'] = $row->supplier_name;
            $data['p_c_id'] = $row->p_c_id;
            $data['p_c_name'] = $row->p_c_name;
            $data['s_c_id'] = $row->s_c_id;
            $data['s_c_name'] = $row->s_c_name;
            $data['barcode'] = $row->barcode;
            $data['remarks'] = $row->remarks;
            $data['sale_price'] = $row->sale_price;
            $data['purchase_price'] = $row->purchase_price;
            $data['sale_discount'] = $row->sale_discount;
            $data['stock'] = $row->stock;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }

    function _get_data_from_post() {
        $parent_category = $this->input->post('parent_category_chosen');
        if(isset($parent_category) && !empty($parent_category)){
            $p_c_data = explode(",",$parent_category);
            $data['p_c_id'] = $p_c_data[0];
            $data['p_c_name'] = $p_c_data[1];
        }
        $sub_category = $this->input->post('sub_category');
        if(isset($sub_category) && !empty($sub_category)){
            $s_c_data = explode(",",$sub_category);
            $data['s_c_id'] = $s_c_data[0];
            $data['s_c_name'] = $s_c_data[1];
        }
        $supplier = $this->input->post('supplier');
        if(isset($supplier) && !empty($supplier)){
            $supplier_data = explode(",",$supplier);
            $data['supplier_id'] = $supplier_data[0];
            $data['supplier_name'] = $supplier_data[1];
        }
        $data['name'] = $this->input->post('name');
        $data['remarks'] = $this->input->post('remarks');
        $data['barcode'] = $this->input->post('barcode');
        $data['sale_discount'] = $this->input->post('sale_discount');
        $data['sale_price'] = $this->input->post('sale_price');
        $data['purchase_price'] = $this->input->post('purchase_price');
        $data['stock'] = $this->input->post('stock');

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
            $this->session->set_flashdata('message', 'product'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'product');
    }

//=============AJAX FUNCTIONS==============

    function get_sub_category(){
        $parent_category = $this->input->post('parent_category');
        if(isset($parent_category) && !empty($parent_category)){
            $p_c_data = explode(",",$parent_category);
            $category_id = $p_c_data[0];
        }
        $where['p_c_id'] = $category_id;
        $arr_p_c = Modules::run('sub_category/_get_by_arr_id',$where)->result_array();
        $html='';
        $html.='<option value="">Select</option>';
        foreach ($arr_p_c as $key => $value) {
            $html.='<option value="'.$value['id'].','.$value['name'].'">'.$value['name'].'</option>';
        }
        echo $html;
    }

//================AJAX FUNCTIONS END===============

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
        redirect(ADMIN_BASE_URL . 'product/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'product/manage/' . '');
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
        $this->load->model('mdl_product');
        $this->mdl_product->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_product');
        $this->mdl_product->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_product');
        return $this->mdl_product->_get($order_by);
    }

    function _get_by_arr_id($where) {
        $this->load->model('mdl_product');
        return $this->mdl_product->_get_by_arr_id($where);
    }

    function _insert($data){
        $this->load->model('mdl_product');
        return $this->mdl_product->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_product');
        $this->mdl_product->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_product');
        $this->mdl_product->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_product');
        $this->mdl_product->_delete($arr_col, $org_id);
    }

    function _get_by_arr_id_product($org_id){
        $this->load->model('mdl_product');
        return $this->mdl_product->_get_by_arr_id_product($org_id);
    }
}