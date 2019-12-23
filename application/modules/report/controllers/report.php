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
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
        }
        else {
            $data['news'] = $this->_get_data_from_post();
        }
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function print_report() {
        $report_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['invoice'] = $this->_get_report_data($report_id,$org_id)->result_array();
        $this->load->view('report_print',$data);
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
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        $data['invoice'] = $this->_get_report($data)->result_array();
        $data['from'] = $data['from'];
        $data['to'] = $data['to'];
        $this->load->view('invoice_list_print',$data);
    }

    function insert_product($report_id,$return_type,$org_id){
        $sale_product = $this->input->post('purchase_product');
        $sale_qty = $this->input->post('purchase_qty');
        $sale_amount = $this->input->post('purchase_amount');
        $counter = 0;
        foreach ($sale_product as $key => $value) {
            $data = array();
            unset($data); 
            $data = array();
            $sale_product2=explode(',', $sale_product[$counter]);
            $sale_product_id = $sale_product2[0];

            $where['id'] = $sale_product_id;
            $arr_product = Modules::run('product/_get_by_arr_id',$where)->result_array();
            if (isset($arr_product) && !empty($arr_product)) {
                foreach ($arr_product as $key => $value1) {
                    $data['report_id'] = $report_id;
                    $data['product_id'] = $value1['id'];
                    $data['product_name'] = $value1['name'];
                    $data['p_c_id'] = $value1['p_c_id'];
                    $data['p_c_name'] = $value1['p_c_name'];
                    $data['s_c_id'] = $value1['s_c_id'];
                    $data['s_c_name'] = $value1['s_c_name'];
                    $data['price'] = $value1['purchase_price'];
                    $data['qty'] = $sale_qty[$counter];
                    $data['amount'] = $sale_amount[$counter];
                    $data['org_id'] = $org_id;

                    if ($return_type == 'Supplier') {
                        $data2['stock'] = $value1['stock'] - $sale_qty[$counter];
                        $rows = $this->_update_product_stock($data2,$org_id,$value1['id']);   
                    }
                    elseif ($return_type == 'Customer') {
                        $data2['stock'] = $value1['stock'] + $sale_qty[$counter];
                        $rows = $this->_update_product_stock($data2,$org_id,$value1['id']);
                    }
                }
            }
            if(!empty($data)){
                $this->_insert_product($data);
            }
            $counter++; 
        }

    }

    //=============AJAX FUNCTIONS==============

    function add_product(){
        $product = $this->input->post('product');
        $qty = $this->input->post('qty');
        $totalIn = $this->input->post('total_pay');
        if(isset($product) && !empty($product)){
            $productData = explode(",",$product);
            $product_id = $productData[0];
            $purchase_price = $productData[2];
        }
        $where['id'] = $product_id;
        $arr_product = Modules::run('product/_get_by_arr_id',$where)->result_array();
        $html='';
        if (isset($arr_product) && !empty($arr_product)) {
            foreach ($arr_product as $key => $value) {
                $html.='<tr>';
                $html.='<td><input style="text-align: center;" class="form-control" readonly type="text" name="purchase_product[]" value="'.$value['id'].','.$value['name'].' - '.$value['p_c_name'].'"></td>';
                $html.='<td><input style="text-align: center;" class="form-control" readonly type="text" name="purchase_price[]" value='.$value['purchase_price'].'></td>';
                $html.='<td><input style="text-align: center;" class="form-control" type="number" readonly name="purchase_qty[]" value='.$qty.'></td>';
                $html.='<td><input style="text-align: center;" class="form-control" readonly type="number" name="purchase_amount[]" value='.$qty*$value['purchase_price'].'></td>';
                $html.='<td><a class="btn delete" onclick="delete_row(this)" amount='.$qty*$value['purchase_price'].'><i class="fa fa-remove"  title="Delete Item"></i></a></td>';
                $html.='</tr>';
            }
            $total = $totalIn + ($qty*$purchase_price);
        }
        $result_array = [$html,$total];
        echo json_encode($result_array);
    }

    function get_returnee(){
        $return_type = $this->input->post('return_type');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        if ($return_type == 'Supplier') {
            $returnee = Modules::run('supplier/_get_by_arr_id_supplier',$org_id)->result_array();
        }
        elseif ($return_type == 'Customer') {
            $returnee = Modules::run('customer/_get_by_arr_id_customer',$org_id)->result_array();
        }

        $html='';
        foreach ($returnee as $key => $value) {
            $html.='<option value="'.$value['id'].','.$value['name'].'">'.$value['name'].'</option>';
        }
        echo $html;
    }

    //==============AJAX FUNCTIONS END==================

    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->_delete($delete_id, $org_id);
    }

    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }

    function _get($order_by) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get($order_by);
    }

    function _get_by_arr_id($update_id) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_by_arr_id($update_id);
    }

    function _get_data_from_db_test($update_id) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_data_from_db_test($update_id);
    }

    function _insert_product($data){
        $this->load->model('mdl_report');
        return $this->mdl_report->_insert_product($data);
    }

    function _insert_report($data){
        $this->load->model('mdl_report');
        return $this->mdl_report->_insert_report($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_report');
        $this->mdl_report->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_report');
        $this->mdl_report->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_report');
        $this->mdl_report->_delete($arr_col, $org_id);
    }

    function _get_report_data($report_id,$org_id) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_report_data($report_id,$org_id);
    }

    function _update_product_stock($data2,$org_id,$product_id){
        $this->load->model('mdl_report');
        return $this->mdl_report->_update_product_stock($data2,$org_id,$product_id);
    }

    function _update_supplier_amount($supplier_id,$amount,$org_id){
        $this->load->model('mdl_report');
        return $this->mdl_report->_update_supplier_amount($supplier_id,$amount,$org_id);
    }

    function _update_customer_amount($customer_id,$amount,$org_id){
        $this->load->model('mdl_report');
        return $this->mdl_report->_update_customer_amount($customer_id,$amount,$org_id);
    }

    function _get_report($data) {
        $this->load->model('mdl_report');
        return $this->mdl_report->_get_report($data);
    }
}