<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Mdl_invoice extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "invoice";
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

    function _get_data_from_db_test($update_id){
        $table = 'test_invoice';
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->db->order_by('id','DESC');
        $this->db->where('invoice_id',$update_id);
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

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_test($data) {
        $table = 'test_invoice';
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_pateint($data) {
        $table = 'patient';
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

    function _get_invoice_data($invoice_id,$org_id){
        $this->db->select('users.*,invoice.*,test_invoice.*,patient.*');
        $this->db->from('invoice');
        $this->db->join("test_invoice", "test_invoice.invoice_id = invoice.id", "full");
        $this->db->join("users", "users.id = invoice.org_id", "full");
        $this->db->join("patient", "patient.id = invoice.p_id", "full");
        $this->db->where('invoice.id', $invoice_id);
        $this->db->where('invoice.org_id', $org_id);
        return $this->db->get();
    }
}