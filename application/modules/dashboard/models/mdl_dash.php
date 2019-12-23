<?php
if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');

class Mdl_dash extends CI_Model {
    function __construct() {
        parent::__construct();
    }

// function _get_income($startDate,$endDate,$org_id){
//     $this->db->select('customer.paid');
//     $this->db->from('voucher_record');
//     $this->db->join("voucher_data", "voucher_data.voucher_id = voucher_record.id", "full");
//     $this->db->where('voucher_record.org_id', $org_id);
//     $this->db->where('voucher_record.issue_date >=', $startDate);
//     $this->db->where('voucher_record.issue_date <=', $endDate);
//     return $this->db->get();
// }

function _get_expense($startDate,$endDate,$org_id){
    $table = 'expense';
    $this->db->where('date >=', $startDate);
    $this->db->where('date <=', $endDate);
    $this->db->where('org_id',$org_id);
    return $this->db->get($table);
}

function _get_total_customer($org_id){
    $table = 'customer';
    $this->db->where('status', '1');
    $this->db->where('org_id',$org_id);
    return $this->db->get($table);
}


function _get_total_supplier($org_id){
	$table = 'supplier';
    $this->db->where('status', '1');
    $this->db->where('org_id',$org_id);
    return $this->db->get($table);
}

function _get_total_invoice($org_id){
    $table = 'sale_invoice';
    $this->db->where('org_id',$org_id);
    return $this->db->get($table);
}

function _get_total_product($org_id){
	$table = 'product';
    $this->db->where('status', '1');
    $this->db->where('org_id',$org_id);
    return $this->db->get($table);
}

}