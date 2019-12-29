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

    function _get_report($data) {
        if ($data['return_type'] == 'Customer') {
             $this->db->select('users.*,sale_invoice.*,customer.*,sale_invoice.status pay_status,sale_invoice.remaining cash_remaining,sale_invoice.id invoice_id');
            $this->db->from('sale_invoice');
            $this->db->order_by('sale_invoice.id', 'DESC');
            $this->db->join("customer", "customer.id = sale_invoice.customer_id", "full");
            $this->db->join("users", "users.id = sale_invoice.org_id", "full");
            $this->db->where('sale_invoice.customer_id', $data['return_id']);
            $this->db->where('sale_invoice.org_id', $data['org_id']);
            $this->db->where('sale_invoice.date >=',$data['from']);
            $this->db->where('sale_invoice.date <=',$data['to']);
        }

        elseif ($data['return_type'] == 'Supplier') {
            $this->db->select('users.*,purchase_invoice.*,supplier.*,purchase_invoice.status pay_status,purchase_invoice.remaining cash_remaining,purchase_invoice.id invoice_id');
            $this->db->from('purchase_invoice');
            $this->db->order_by('purchase_invoice.id', 'DESC');
            $this->db->join("supplier", "supplier.id = purchase_invoice.supplier_id", "full");
            $this->db->join("users", "users.id = purchase_invoice.org_id", "full");
            $this->db->where('purchase_invoice.supplier_id', $data['return_id']);
            $this->db->where('purchase_invoice.org_id', $data['org_id']);
            $this->db->where('purchase_invoice.date >=',$data['from']);
            $this->db->where('purchase_invoice.date <=',$data['to']);
        }
        return $this->db->get();
    }
}