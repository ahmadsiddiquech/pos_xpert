<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_account extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "account";
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

    function _get($order_by) {
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->where('org_id',$org_id);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_transaction_list() {
        $table = 'account_transaction';
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->db->order_by('id','DESC');
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _check_cash_in_hand($type){
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->where('type',$type);
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _insert_transaction($data) {
        $table = 'account_transaction';
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _update($arr_col, $org_id, $data) {
        $table = $this->get_table();
        $this->db->where('id',$arr_col);
        $this->db->where('org_id',$org_id);
        $this->db->update($table, $data);
    }

    function _get_cash_in_hand() {
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->where('type','Cash-in-hand');
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _get_account_balance($type){
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->where('type',$type);
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _update_cash_in_hand($data) {
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->where('type','Cash-in-hand');
        $this->db->where('org_id',$org_id);
        $this->db->update($table, $data);
    }

    function _update_cash(,$type,$data) {
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->where('type','Cash-in-hand');
        $this->db->where('org_id',$org_id);
        $this->db->update($table, $data);
    }
}