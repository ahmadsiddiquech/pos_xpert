<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Mdl_report extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "stock_return";
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

    function _get_report($data) {
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];

        if ($data['return_type'] == 'Customer') {
             $this->db->select('users.*,sale_invoice.*,customer.*,sale_invoice.status pay_status,sale_invoice.remaining cash_remaining,sale_invoice.id invoice_id');
            $this->db->from('sale_invoice');
            $this->db->order_by('sale_invoice.id', 'DESC');
            $this->db->join("customer", "customer.id = sale_invoice.customer_id", "full");
            $this->db->join("users", "users.id = sale_invoice.org_id", "full");
            $this->db->where('sale_invoice.customer_id', $data['return_id']);
            $this->db->where('sale_invoice.org_id', $org_id);
            $this->db->where('sale_invoice.date >=',$data['from']);
            $this->db->where('sale_invoice.date <=',$data['to']);
        }
        elseif ($data['return_type'] == 'Supplier') {
            $this->db->select('users.*,purchase_invoice.*,supplier.*,purchase_invoice.status pay_status,purchase_invoice.remaining cash_remaining,purchase_invoice.id invoice_id');
            $this->db->from('purchase_invoice');
            $this->db->join("supplier", "supplier.id = purchase_invoice.supplier_id", "full");
            $this->db->join("users", "users.id = purchase_invoice.org_id", "full");
            $this->db->where('purchase_invoice.supplier_id', $data['return_id']);
            $this->db->where('purchase_invoice.org_id', $org_id);
            $this->db->where('purchase_invoice.date >=',$data['from']);
            $this->db->where('purchase_invoice.date <=',$data['to']);
        }
        return $this->db->get();
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

    function _insert_stock_return($data) {
        $table = 'stock_return';
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_product($data) {
        $table = 'stock_return_product';
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

    function _get_stock_return_data($stock_return_id,$org_id){
        $this->db->select('users.*,stock_return.*,stock_return_product.*,supplier.*,stock_return.status pay_status,stock_return.remaining cash_remaining');
        $this->db->from('stock_return');
        $this->db->join("stock_return_product", "stock_return_product.stock_return_id = stock_return.id", "full");
        $this->db->join("supplier", "supplier.id = stock_return.supplier_id", "full");
        $this->db->join("users", "users.id = stock_return.org_id", "full");
        $this->db->where('stock_return.id', $stock_return_id);
        $this->db->where('stock_return.org_id', $org_id);
        return $this->db->get();
    }
}