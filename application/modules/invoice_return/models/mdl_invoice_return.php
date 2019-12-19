<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Mdl_invoice_return extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "invoice_return";
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

    function _update_supplier_amount($supplier_id,$data,$org_id){
        $table = "supplier";
        $this->db->where('id', $supplier_id);
        $this->db->where('org_id', $org_id);
        $this->db->update($table,$data);
        return $this->db->affected_rows();
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_invoice_return($data) {
        $table = 'invoice_return';
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_product($data) {
        $table = 'invoice_return_product';
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

    function _get_invoice_return_data($invoice_return_id,$org_id){
        $this->db->select('users.*,invoice_return.*,invoice_return_product.*,supplier.*,invoice_return.status pay_status');
        $this->db->from('invoice_return');
        $this->db->join("invoice_return_product", "invoice_return_product.invoice_return_id = invoice_return.id", "full");
        $this->db->join("supplier", "supplier.id = invoice_return.return_id", "full");
        $this->db->join("users", "users.id = invoice_return.org_id", "full");
        $this->db->where('invoice_return.id', $invoice_return_id);
        $this->db->where('invoice_return.org_id', $org_id);
        return $this->db->get();
    }
}