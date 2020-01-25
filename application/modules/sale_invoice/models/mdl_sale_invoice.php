<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Mdl_sale_invoice extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "sale_invoice";
        return $table;
    }

   function _get_by_arr_id($update_id) {
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->where('id',$update_id);
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _get($order_by) {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->db->order_by($order_by);
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

    function update_result($test_id,$result_value){
        $table = "test_invoice";
        $this->db->where('id', $test_id);
        $this->db->set('result_value',$result_value);
        $this->db->update($table);
        return $this->db->affected_rows();
    }

    function _update_product_stock($data2,$org_id,$product_id){
        $table = "product";
        $this->db->where('id', $product_id);
        $this->db->where('org_id', $org_id);
        $this->db->update($table,$data2);
        return $this->db->affected_rows();
    }

    function _update_customer_amount($customer_id,$data,$org_id){
        $table = "customer";
        $this->db->where('id', $customer_id);
        $this->db->where('org_id', $org_id);
        $this->db->update($table,$data);
        return $this->db->affected_rows();
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_sale_invoice($data) {
        $table = 'sale_invoice';
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_product($data) {
        $table = 'sale_invoice_product';
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
        $this->db->where('id', $arr_col);
        $this->db->where('org_id',$org_id);
        $this->db->delete($table);
    }

    function _get_sale_invoice_data($sale_invoice_id,$customer_id,$org_id){
        $this->db->select('users.*,sale_invoice.*,sale_invoice_product.*,sale_invoice.status pay_status,sale_invoice.remaining cash_remaining');
        $this->db->from('sale_invoice');
        $this->db->join("sale_invoice_product", "sale_invoice_product.sale_invoice_id = sale_invoice.id", "full");
        if ($customer_id != 0) {
            $this->db->join("customer", "customer.id = sale_invoice.customer_id", "full");
            $this->db->select('users.*,sale_invoice.*,sale_invoice_product.*,customer.*,sale_invoice.status pay_status,sale_invoice.remaining cash_remaining,customer.remaining cust_remaining');
        }
        $this->db->join("users", "users.id = sale_invoice.org_id", "full");
        $this->db->where('sale_invoice.id', $sale_invoice_id);
        $this->db->where('sale_invoice.org_id', $org_id);
        return $this->db->get();
    }
}