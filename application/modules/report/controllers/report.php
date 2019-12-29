<?php
if ( ! defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Report extends MX_Controller
{

    function __construct() {
        parent::__construct();
        Modules::run('site_security/is_login');
    }

    function index() {
        $this->create();
    }

    function manage() {
        $data['news'] = $this->_get('stock_return.id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function create() {
        $update_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['news'] = $this->_get_data_from_post();
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function full_report() {
        $update_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['news'] = $this->_get_data_from_post();
        $data['update_id'] = $update_id;
        $data['view_file'] = 'full_report';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function print_report() {
        $report_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['invoice'] = $this->_get_report_data($report_id,$org_id)->result_array();
        $this->load->view('print_report',$data);
    }

    function income_statement() {
        $update_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['news'] = $this->_get_data_from_post();
        $data['update_id'] = $update_id;
        $data['view_file'] = 'income_statement';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function print_income_statement() {
        $report_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['invoice'] = $this->_get_report_data($report_id,$org_id)->result_array();
        $this->load->view('print_income_statement',$data);
    }
 
    function _get_data_from_db($update_id) {
        $query = $this->_get_by_arr_id($update_id);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['ref_no'] = $row->ref_no;
            $data['change'] = $row->change;
            $data['cash_received'] = $row->cash_received;
            $data['remaining'] = $row->remaining;
            $data['grand_total'] = $row->grand_total;
            $data['total_payable'] = $row->total_payable;
            $data['discount'] = $row->discount;
            $data['date'] = $row->date;
            $data['supplier_name'] = $row->supplier_name;
            $data['supplier_id'] = $row->supplier_id;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }

    function _get_data_from_post() {
        $returnee = $this->input->post('returnee');
        if (isset($returnee) && !empty($returnee)) {
            $returnee2=explode(',', $returnee);
            $data['return_id'] = $returnee2[0];
            $data['return_name'] = $returnee2[1];
        }
        $data['from'] = $this->input->post('from');
        $data['to'] = $this->input->post('to');
        $data['return_type'] = $this->input->post('return_type');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;
    }

    function submit() {
        $data = $this->_get_data_from_post();
        $data['invoice'] = $this->_get_report($data)->result_array();
        $data['from'] = $data['from'];
        $data['to'] = $data['to'];
        $this->load->view('invoice_list_print',$data);
    }

    function submit_full_report() {
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        $data['from'] = $this->input->post('from');
        $data['to'] = $this->input->post('to');
        $data['org'] = $this->_get_org($data['org_id'])->result_array();

        $data['sale_invoice'] = $this->_get_sale_invoice($data)->result_array();

        $data['purchase_invoice'] = $this->_get_purchase_invoice($data)->result_array();
        
        $data['expense'] = $this->_get_expense($data)->result_array();
        
        $data['stock_return'] = $this->_get_stock_return($data)->result_array();
        
        $this->load->view('full_report_print',$data);
    }

    function submit_income_statement() {
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        $data['month'] = $this->input->post('month');
        $data['from'] = $data['month'].'-01';
        $data['to'] = $data['month'].'-31';

        $data['org'] = $this->_get_org($data['org_id'])->result_array();

        $data['sale_invoice'] = $this->_get_sale_invoice($data)->result_array();

        $data['purchase_invoice'] = $this->_get_purchase_invoice($data)->result_array();
        
        $data['expense'] = $this->_get_expense($data)->result_array();
        
        $data['stock_return'] = $this->_get_stock_return($data)->result_array();
        
        $this->load->view('income_statement_print',$data);
    }

    function _get($order_by) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get($order_by);
    }

    function _get_by_arr_id($update_id) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_by_arr_id($update_id);
    }

    function _get_report_data($report_id,$org_id) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_report_data($report_id,$org_id);
    }

    function _get_report($data) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_report($data);
    }

    function _get_org($org_id) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_org($org_id);
    }

    function _get_sale_invoice($data) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_sale_invoice($data);
    }

    function _get_purchase_invoice($data) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_purchase_invoice($data);
    }

    function _get_stock_return($data) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_stock_return($data);
    }

    function _get_expense($data) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_expense($data);
    }
}