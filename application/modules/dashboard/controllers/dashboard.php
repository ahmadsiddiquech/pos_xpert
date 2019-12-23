<?php
if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');
class Dashboard extends MX_Controller
{

    function __construct() {
        parent::__construct();
        Modules::run('site_security/is_login');
    }

function index(){
        $data['view_file'] = 'home';
        $this->load->module('template');
        $config=array();
        $ci = & get_instance();

        $ci->load->library('session');
        $user_data = $ci->session->userdata('user_data');
        $data['organization'] = $user_data['user_name'];
        $data['invoice'] = $this->get_total_invoice();
        $data['supplier'] = $this->get_total_supplier();
        $data['customer'] = $this->get_total_customer();
        $data['product'] = $this->get_total_product();
        // $data['income'] = $this->get_income();
        $data['expense'] = $this->get_expense();
        $this->template->admin($data);
    }

    function get_total_invoice(){
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        return $this->_get_total_invoice($org_id)->num_rows();
    }

    function get_total_supplier(){
    	$user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        return $this->_get_total_supplier($org_id)->num_rows();
    }

    function get_total_customer(){
    	$user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        return $this->_get_total_customer($org_id)->num_rows();
    }

    function get_total_product(){
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        return $this->_get_total_product($org_id)->num_rows();
    }

    // function get_income(){
    //     date_default_timezone_set("Asia/Karachi");
    //     $year = date('Y');
    //     $sum = 0;
    //     $income = 0;
    //     $user_data = $this->session->userdata('user_data');
    //     $org_id = $user_data['user_id'];
    //     for ($i=1; $i <=12 ; $i++) { 
    //         $startDate = $year.'/'.$i.'/01';
    //         $endDate = $year.'/'.$i.'/31';
    //         $data =  $this->_get_income($startDate,$endDate,$org_id)->result_array();
    //         foreach ($data as $key => $value) {
    //             $sum = $sum + $value['paid'];
    //         }
    //         if (isset($sum) && !empty($sum)) {
    //             $income.= ', '.$sum;
    //         }
    //         else{
    //             $income.= ', 0';
    //         }
    //         $data =0;
    //         $sum = 0;
    //     }
    //     return $income;
    // }

    function get_expense(){
        date_default_timezone_set("Asia/Karachi");
        $year = date('Y');
        $sum = 0;
        $expense = 0;
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        for ($i=1; $i <=12 ; $i++) {
            $startDate = $year.'-'.$i.'-01';
            $endDate = $year.'-'.$i.'-31';
            $data =  $this->_get_expense($startDate,$endDate,$org_id)->result_array();
            foreach ($data as $key => $value) {
                $sum = $sum + $value['amount'];
            }
            if (isset($sum) && !empty($sum)) {
                $expense.= ', '.$sum;
            }
            else{
                $expense.= ', 0';
            }
            $data = 0;
            $sum = 0;
        }
        return $expense;
    }


//==========================helper=========================

    // function _get_income($startDate,$endDate,$org_id){
    //     $this->load->model('mdl_dash');
    //     return $this->mdl_dash->_get_income($startDate,$endDate,$org_id);
    // }

    function _get_expense($startDate,$endDate,$org_id){
        $this->load->model('mdl_dash');
        return $this->mdl_dash->_get_expense($startDate,$endDate,$org_id);
    }
    
    function _get_total_customer($org_id){
    	$this->load->model('mdl_dash');
    	return $this->mdl_dash->_get_total_customer($org_id);
    }

    function _get_total_supplier($org_id){
        $this->load->model('mdl_dash');
        return $this->mdl_dash->_get_total_supplier($org_id);
    }

    function _get_total_invoice($org_id){
    	$this->load->model('mdl_dash');
    	return $this->mdl_dash->_get_total_invoice($org_id);
    }

    function _get_total_product($org_id){
        $this->load->model('mdl_dash');
        return $this->mdl_dash->_get_total_product($org_id);
    }

}