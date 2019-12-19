<?php
if ( ! defined('BASEPATH')){
    exit('No direct script access allowed');
}

class invoice_return extends MX_Controller
{

    function __construct() {
        parent::__construct();
        Modules::run('site_security/is_login');
    }

    function index() {
        $this->create();
    }

    function manage() {
        $data['news'] = $this->_get('invoice_return.id desc');
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
        $supplier = Modules::run('supplier/_get_by_arr_id_supplier',$org_id)->result_array();
        $product = Modules::run('product/_get_by_arr_id_product',$org_id)->result_array();

        $data['supplier'] = $supplier;
        $data['product'] = $product;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function print_invoice_return() {
        $invoice_return_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['invoice'] = $this->_get_invoice_return_data($invoice_return_id,$org_id)->result_array();
        $this->load->view('invoice_return_print',$data);
    }

    function print_invoice_on_save($invoice_return_id,$org_id) {
        $data['invoice'] = $this->_get_invoice_return_data($invoice_return_id,$org_id)->result_array();
        $this->load->view('invoice_return_print',$data);
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
        $supplier = $this->input->post('supplier');
        if (isset($supplier) && !empty($supplier)) {
            $supplier2=explode(',', $supplier);
            $data['supplier_id'] = $supplier2[0];
            $data['supplier_name'] = $supplier2[1];
        }
        $data['date'] = $this->input->post('date');
        $data['ref_no'] = $this->input->post('ref_no');
        $data['total_payable'] = $this->input->post('total_pay');
        $data['discount'] = $this->input->post('discount');
        $data['grand_total'] = $this->input->post('net_amount');
        $data['cash_received'] = $this->input->post('paid_amount');
        $data['change'] = $this->input->post('remaining');
        $data['status'] = $this->input->post('status');


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
            $invoice_return_id = $this->_insert_invoice_return($data);
            $where['id'] = $data['supplier_id'];
            $supplier = Modules::run('supplier/_get_by_arr_id',$where)->result_array();
            if ($data['status'] == 'Un-Paid') {
                $data2['remaining'] = $supplier[0]['remaining'] + $data['grand_total'];
                $data2['total'] = $supplier[0]['total'] + $data['grand_total'];
            }
            elseif ($data['status'] == 'Paid'){
                $data2['paid'] = $supplier[0]['paid'] + $data['grand_total'];
                $data2['total'] = $supplier[0]['total'] + $data['grand_total'];
            }
            $this->_update_supplier_amount($data['supplier_id'],$data2,$org_id);
            $product_invoice = $this->insert_product($invoice_return_id,$org_id);
            $this->print_invoice_on_save($invoice_return_id,$org_id);
        }
        // $this->session->set_flashdata('message', 'invoice_return'.' '.DATA_SAVED);
        // $this->session->set_flashdata('status', 'success');
        
        // redirect(ADMIN_BASE_URL . 'invoice_return');
    }

    function insert_product($invoice_return_id,$org_id){
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
                    $data['invoice_return_id'] = $invoice_return_id;
                    $data['product_id'] = $value1['id'];
                    $data['product_name'] = $value1['name'];
                    $data['p_c_id'] = $value1['p_c_id'];
                    $data['p_c_name'] = $value1['p_c_name'];
                    $data['s_c_id'] = $value1['s_c_id'];
                    $data['s_c_name'] = $value1['s_c_name'];
                    $data['sale_price'] = $value1['purchase_price'];
                    $data['qty'] = $sale_qty[$counter];
                    $data['amount'] = $sale_amount[$counter];
                    $data['org_id'] = $org_id;


                    $data2['stock'] = $value1['stock'] + $sale_qty[$counter];
                    $rows = $this->_update_product_stock($data2,$org_id,$value1['id']);
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
            if ($arr_product[0]['stock'] >= $qty) {
                foreach ($arr_product as $key => $value) {
                    $html.='<tr>';
                    $html.='<td><input style="text-align: center;" class="form-control" readonly type="text" name="purchase_product[]" value="'.$value['id'].','.$value['name'].' - '.$value['p_c_name'].'"></td>';
                    $html.='<td><input style="text-align: center;" class="form-control" readonly type="text" name="purchase_price[]" value='.$value['purchase_price'].'></td>';
                    $html.='<td><input style="text-align: center;" class="form-control" type="number" readonly name="purchase_qty[]" value='.$qty.'></td>';
                    $html.='<td><input style="text-align: center;" class="form-control" readonly type="number" name="purchase_amount[]" value='.$qty*$value['purchase_price'].'></td>';
                    $html.='</tr>';
                }
                $total = $totalIn + ($qty*$purchase_price);
            }
            else{
                $total = $totalIn;
            }
        }
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
        $this->load->model('mdl_invoice_return');
        return $this->mdl_invoice_return->_get($order_by);
    }

    function _get_by_arr_id($update_id) {
        $this->load->model('mdl_invoice_return');
        return $this->mdl_invoice_return->_get_by_arr_id($update_id);
    }

    function _get_data_from_db_test($update_id) {
        $this->load->model('mdl_invoice_return');
        return $this->mdl_invoice_return->_get_data_from_db_test($update_id);
    }

    function _insert_product($data){
        $this->load->model('mdl_invoice_return');
        return $this->mdl_invoice_return->_insert_product($data);
    }

    function _insert_invoice_return($data){
        $this->load->model('mdl_invoice_return');
        return $this->mdl_invoice_return->_insert_invoice_return($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_invoice_return');
        $this->mdl_invoice_return->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_invoice_return');
        $this->mdl_invoice_return->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_invoice_return');
        $this->mdl_invoice_return->_delete($arr_col, $org_id);
    }

    function _get_invoice_return_data($invoice_return_id,$org_id) {
        $this->load->model('mdl_invoice_return');
        return $this->mdl_invoice_return->_get_invoice_return_data($invoice_return_id,$org_id);
    }

    function _update_product_stock($data2,$org_id,$product_id){
        $this->load->model('mdl_invoice_return');
        return $this->mdl_invoice_return->_update_product_stock($data2,$org_id,$product_id);
    }

    function _update_supplier_amount($customer_id,$amount,$org_id){
        $this->load->model('mdl_invoice_return');
        return $this->mdl_invoice_return->_update_supplier_amount($customer_id,$amount,$org_id);
    }
}