<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Mdl_report extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function _get_org($org_id){
        $table = 'users';
        $this->db->where('id',$org_id);
        return $this->db->get($table);
    }

    function _get_sale_invoice($data){
        $table = 'sale_invoice';
        $this->db->where('date >=',$data['from']);
        $this->db->where('date <=',$data['to']);
        $this->db->where('org_id',$data['org_id']);
        return $this->db->get($table);
    }

    function _get_purchase_invoice($data){
        $table = 'purchase_invoice';
        $this->db->where('date >=',$data['from']);
        $this->db->where('date <=',$data['to']);
        $this->db->where('org_id',$data['org_id']);
        return $this->db->get($table);
    }

    function _get_stock_return($data){
        $table = 'stock_return';
        $this->db->where('date >=',$data['from']);
        $this->db->where('date <=',$data['to']);
        $this->db->where('org_id',$data['org_id']);
        return $this->db->get($table);
    }

    function _get_expense($data){
        $table = 'expense';
        $this->db->where('date >=',$data['from']);
        $this->db->where('date <=',$data['to']);
        $this->db->where('org_id',$data['org_id']);
        return $this->db->get($table);
    }

    function _get_sale_invoice_report($data) {
        if ($data['type'] == 'customer') {
            $this->db->from('sale_invoice');
            // $this->db->join("sale_invoice_product", "sale_invoice_product.sale_invoice_id = sale_invoice.id", "full");
            $this->db->where('customer_id', $data['account_id']);
            $this->db->where('org_id', $data['org_id']);
            $this->db->where('date >=',$data['from_date']);
            $this->db->where('date <=',$data['to_date']);
        }

        elseif ($data['type'] == 'supplier') {
            $this->db->from('purchase_invoice');
            // $this->db->join("purchase_invoice_product", "purchase_invoice_product.purchase_invoice_id = purchase_invoice.id", "full");
            $this->db->where('supplier_id', $data['account_id']);
            $this->db->where('org_id', $data['org_id']);
            $this->db->where('date >=',$data['from_date']);
            $this->db->where('date <=',$data['to_date']);
        }
        return $this->db->get();
    }

    function _get_transaction_report($data){
        $table = 'account_transaction';
        $this->db->select('*,amount remaining');
        $this->db->where('date >=',$data['from_date']);
        $this->db->where('date <=',$data['to_date']);
        $this->db->where('org_id',$data['org_id']);
        $this->db->where('account_from_id',$data['account_id']);
        $this->db->or_where('account_to_id',$data['account_id']);
        return $this->db->get($table);
    }

    function _get_product_report($data){
        $this->db->from('sale_invoice');
        $this->db->join("sale_invoice_product", "sale_invoice_product.sale_invoice_id = sale_invoice.id AND sale_invoice_product.product_id = ".$data['product_id'] , "full");
        $this->db->where('sale_invoice.org_id', $data['org_id']);
        $this->db->where('sale_invoice.date >=',$data['from_date']);
        $this->db->where('sale_invoice.date <=',$data['to_date']);
        return $this->db->get();
    }

    function _get_overall_report($data){
        $table = 'sale_invoice';
        $this->db->where('org_id', $data['org_id']);
        $this->db->where('date >=',$data['from_date']);
        $this->db->where('date <=',$data['to_date']);
        return $this->db->get($table);
    }
}