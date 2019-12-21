<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_customer extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "customer";
        return $table;
    }

    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->db->where($arr_col);
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _get_by_arr_id_customer($org_id) {
        $table = $this->get_table();
        $this->db->where('status','1');
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _get($order_by) {
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->where('org_id',$org_id);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_invoice_list($customer_id) {
        $table = 'sale_invoice';
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->db->order_by('id','DESC');
        $this->db->where('customer_id',$customer_id);
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _get_product_list($invoice_id) {
        $table = 'sale_invoice_product';
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->db->order_by('id','DESC');
        $this->db->where('sale_invoice_id',$invoice_id);
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_transaction($data) {
        $table = 'transaction';
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _update($arr_col, $org_id, $data) {
        $table = $this->get_table();
        $this->db->where('id',$arr_col);
        $this->db->where('org_id',$org_id);
        $this->db->update($table, $data);
    }

    function _update_id($id, $data) {
        $table = $this->get_table();
        $this->db->where('id',$id);
        $this->db->update($table, $data);
    }

    function _delete($arr_col, $org_id) {       
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $role_id = $user_data['role_id'];
        $this->db->where('id', $arr_col);
        $this->db->where('org_id',$org_id);
        $this->db->delete($table);
    }

    function _set_publish($where) {
        $table = $this->get_table();
        $set_publish['status'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_publish);
    }

    function _set_unpublish($where) {
        $table = $this->get_table();
        $set_un_publish['status'] = 0;
        $this->db->where($where);
        $this->db->update($table, $set_un_publish);
    }

    function _get_transaction_list($customer_id) {
        $table = 'transaction';
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->db->order_by('id','DESC');
        $this->db->where('depositer_id',$customer_id);
        $this->db->where('depositer_type','customer');
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _get_invoice_list_print($customer_id,$org_id){
        $this->db->select('users.*,sale_invoice.*,customer.*,sale_invoice.status pay_status,sale_invoice.remaining cash_remaining,sale_invoice.id sale_invoice_id');
        $this->db->from('sale_invoice');
        $this->db->join("customer", "customer.id = sale_invoice.customer_id", "full");
        $this->db->join("users", "users.id = sale_invoice.org_id", "full");
        $this->db->where('sale_invoice.customer_id', $customer_id);
        $this->db->where('sale_invoice.org_id', $org_id);
        return $this->db->get();
    }
}