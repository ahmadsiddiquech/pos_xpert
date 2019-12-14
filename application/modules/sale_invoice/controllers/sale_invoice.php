<?php
if ( ! defined('BASEPATH')){
    exit('No direct script access allowed');
}

class sale_invoice extends MX_Controller
{

    function __construct() {
        parent::__construct();
        Modules::run('site_security/is_login');
    }

    function index() {
        $this->create();
    }

    function manage() {
        $data['news'] = $this->_get('sale_invoice.id desc');
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
        $customer = Modules::run('customer/_get_by_arr_id_customer',$org_id)->result_array();
        $product = Modules::run('product/_get_by_arr_id_product',$org_id)->result_array();

        $data['customer'] = $customer;
        $data['product'] = $product;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function print_sale_invoice() {
        $sale_invoice_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['invoice'] = $this->_get_sale_invoice_data($sale_invoice_id,$org_id)->result_array();
        $this->load->view('sale_invoice_print',$data);
    }

    function print_invoice_on_save($sale_invoice_id,$org_id) {
        $data['invoice'] = $this->_get_sale_invoice_data($sale_invoice_id,$org_id)->result_array();
        $this->load->view('sale_invoice_print',$data);
    }
 
    function _get_data_from_db($update_id) {
        $query = $this->_get_by_arr_id($update_id);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['change'] = $row->total_pay;
            $data['cash_received'] = $row->discount;
            $data['grand_total'] = $row->net_amount;
            $data['total_payable'] = $row->paid_amount;
            $data['date'] = $row->remaining;
            $data['customer_name'] = $row->p_id;
            $data['customer_id'] = $row->name;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }

    function _get_data_from_post() {
        $customer = $this->input->post('customer');
        if (isset($customer) && !empty($customer)) {
            $customer2=explode(',', $customer);
            $data['customer_id'] = $customer2[0];
            $data['customer_name'] = $customer2[1];
        }
        else{
            $data['customer_id'] = 0;
            $data['customer_name'] = 'walk-in';
        }
        $data['date'] = $this->input->post('date');
        $data['total_payable'] = $this->input->post('total_pay');
        $data['discount'] = $this->input->post('discount');
        $data['grand_total'] = $this->input->post('net_amount');
        $data['cash_received'] = $this->input->post('paid_amount');
        $data['change'] = $this->input->post('remaining');


        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;
    }

    function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        if ($update_id != 0) {
            $id = $this->_update($update_id,$org_id,$data);
        }
        else {
            $sale_invoice_id = $this->_insert_sale_invoice($data);
            $product_invoice = $this->insert_product($sale_invoice_id,$org_id);
            $this->print_invoice_on_save($sale_invoice_id,$org_id);
        }
        // $this->session->set_flashdata('message', 'sale_invoice'.' '.DATA_SAVED);
        // $this->session->set_flashdata('status', 'success');
        
        // redirect(ADMIN_BASE_URL . 'sale_invoice');
    }

    function insert_product($sale_invoice_id,$org_id){
        $sale_product = $this->input->post('sale_product');
        $sale_qty = $this->input->post('sale_qty');
        $sale_amount = $this->input->post('sale_amount');
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
                    $data['sale_invoice_id'] = $sale_invoice_id;
                    $data['product_id'] = $value1['id'];;
                    $data['product_name'] = $value1['name'];
                    $data['p_c_id'] = $value1['p_c_id'];
                    $data['p_c_name'] = $value1['p_c_name'];
                    $data['s_c_id'] = $value1['s_c_id'];
                    $data['s_c_name'] = $value1['s_c_name'];
                    $data['sale_price'] = $value1['sale_price'];
                    $data['qty'] = $sale_qty[$counter];
                    $data['amount'] = $sale_amount[$counter];
                    $data['org_id'] = $org_id;
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
            $sale_price = $productData[2];
        }
        $where['id'] = $product_id;
        $arr_product = Modules::run('product/_get_by_arr_id',$where)->result_array();
        $html='';
        if (isset($arr_product) && !empty($arr_product)) {
            foreach ($arr_product as $key => $value) {
                $html.='<tr>';
                $html.='<td><input style="text-align: center;" class="form-control" readonly type="text" name="sale_product[]" value="'.$value['id'].','.$value['name'].' - '.$value['p_c_name'].'"></td>';
                $html.='<td><input style="text-align: center;" class="form-control" readonly type="text" name="sale_price[]" value='.$value['sale_price'].'></td>';
                $html.='<td><input style="text-align: center;" class="form-control" type="number" readonly name="sale_qty[]" value='.$qty.'></td>';
                $html.='<td><input style="text-align: center;" class="form-control" readonly type="number" name="sale_amount[]" value='.$qty*$value['sale_price'].'></td>';
                $html.='</tr>';
            }
        }
        $total = $totalIn + ($qty*$sale_price);
        $result_array = [$html,$total];
        echo json_encode($result_array);
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
        $this->load->model('mdl_sale_invoice');
        return $this->mdl_sale_invoice->_get($order_by);
    }

    function _get_by_arr_id($update_id) {
        $this->load->model('mdl_sale_invoice');
        return $this->mdl_sale_invoice->_get_by_arr_id($update_id);
    }

    function _get_data_from_db_test($update_id) {
        $this->load->model('mdl_sale_invoice');
        return $this->mdl_sale_invoice->_get_data_from_db_test($update_id);
    }

    function _insert_product($data){
        $this->load->model('mdl_sale_invoice');
        return $this->mdl_sale_invoice->_insert_product($data);
    }

    function _insert_sale_invoice($data){
        $this->load->model('mdl_sale_invoice');
        return $this->mdl_sale_invoice->_insert_sale_invoice($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_sale_invoice');
        $this->mdl_sale_invoice->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_sale_invoice');
        $this->mdl_sale_invoice->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_sale_invoice');
        $this->mdl_sale_invoice->_delete($arr_col, $org_id);
    }

    function _get_sale_invoice_data($sale_invoice_id,$org_id) {
        $this->load->model('mdl_sale_invoice');
        return $this->mdl_sale_invoice->_get_sale_invoice_data($sale_invoice_id,$org_id);
    }
}