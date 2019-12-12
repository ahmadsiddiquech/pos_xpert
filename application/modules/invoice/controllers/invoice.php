<?php
if ( ! defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Invoice extends MX_Controller
{

    function __construct() {
        parent::__construct();
        Modules::run('site_security/is_login');
    }

    function index() {
        $this->create();
    }

    function manage() {
        $data['news'] = $this->_get('invoice.id desc');
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
        $category = Modules::run('category/_get_by_arr_id_category',$org_id)->result_array();
        // print_r($category);exit();

        $data['category'] = $category;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function report() {
        $update_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
            $data['test'] = $this->_get_data_from_db_test($update_id)->result_array();
        }
        $data['update_id'] = $update_id;
        $data['view_file'] = 'report';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function update_result () {
        $test_id = $this->input->post('test_id');
        $result_value = $this->input->post('result_value');
        $this->load->model('mdl_invoice');
        $check = $this->mdl_invoice->update_result($test_id,$result_value);

        if($check == true){
            echo "true";
        }
        else{
            echo "false";
        }
    }

    function print_invoice() {
        $invoice_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['invoice'] = $this->_get_invoice_data($invoice_id,$org_id)->result_array();
        $this->load->view('invoice_print',$data);
    }

    function print_invoice_on_save($invoice_id) {
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['invoice'] = $this->_get_invoice_data($invoice_id,$org_id)->result_array();
        $this->load->view('invoice_print',$data);
    }
 
    function _get_data_from_db($update_id) {
        $query = $this->_get_by_arr_id($update_id);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['test_id'] = $row->test_id;
            $data['category_id'] = $row->category_id;
            $data['test_name'] = $row->test_name;
            $data['category_name'] = $row->category_name;
            $data['date_time'] = $row->date_time;
            $data['status'] = $row->status;
            $data['delivery_date'] = $row->delivery_date;
            $data['remarks'] = $row->remarks;
            $data['referred_by'] = $row->referred_by;
            $data['total_pay'] = $row->total_pay;
            $data['discount'] = $row->discount;
            $data['net_amount'] = $row->net_amount;
            $data['paid_amount'] = $row->paid_amount;
            $data['remaining'] = $row->remaining;
            $data['p_id'] = $row->p_id;
            $data['name'] = $row->name;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }

    function _get_data_from_post() {
        $data['name'] = $this->input->post('name');
        $data['father_name'] = $this->input->post('father_name');
        $data['age'] = $this->input->post('age');
        $data['gender'] = $this->input->post('gender');
        $data['mobile'] = $this->input->post('mobile');
        $data['cnic'] = $this->input->post('cnic');
        $data['address'] = $this->input->post('address');

        $data['referred_by'] = $this->input->post('referred_by');
        $data['delivery_date'] = $this->input->post('delivery_date');
        $data['status'] = $this->input->post('status');
        $data['total_payment'] = $this->input->post('total_payment');
        $data['discount'] = $this->input->post('discount');
        $data['net_amount'] = $this->input->post('net_amount');
        $data['paid_amount'] = $this->input->post('paid_amount');
        $data['remaining'] = $this->input->post('remaining');


        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;
    }

    function _get_data_from_post_patient() {
        $data['name'] = $this->input->post('name');
        $data['father_name'] = $this->input->post('father_name');
        $data['age'] = $this->input->post('age');
        $data['gender'] = $this->input->post('gender');
        $data['mobile'] = $this->input->post('mobile');
        $data['cnic'] = $this->input->post('cnic');
        $data['address'] = $this->input->post('address');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;
    }

    function _get_data_from_post_test(){
        $data['name'] = $this->input->post('name');
        $data['date_time'] = date('Y-m-d');
        $data['referred_by'] = $this->input->post('referred_by');
        $data['delivery_date'] = $this->input->post('delivery_date');
        $data['status'] = $this->input->post('status');
        $data['total_pay'] = $this->input->post('total_pay');
        $data['discount'] = $this->input->post('discount');
        $data['net_amount'] = $this->input->post('net_amount');
        $data['paid_amount'] = $this->input->post('paid_amount');
        $data['remaining'] = $this->input->post('remaining');

        $test = $this->input->post('testArray');
        $test2=explode(',', $test[0]);
        $data['test_id'] = $test2[0];
        $data['test_name'] = $test2[1];

        $category = $this->input->post('catArray');
        $category2=explode(',', $category[0]);
        $data['category_id'] = $category2[0];
        $data['category_name'] = $category2[1];

        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;
    }

    function submit() {
        $update_id = $this->uri->segment(4);
        $dataPatient = $this->_get_data_from_post_patient();
        $dataTest = $this->_get_data_from_post_test();

        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        if ($update_id != 0) {
            $id = $this->_update($update_id,$org_id,$data);
        }
        else {
            $patient_id = $this->_insert_pateint($dataPatient);
            $dataTest['p_id'] = $patient_id;
            $invoice_id = $this->_insert($dataTest);
            $test_id = $this->insert_test($invoice_id,$org_id);
            $this->print_invoice_on_save($invoice_id);
        }
        // $this->session->set_flashdata('message', 'invoice'.' '.DATA_SAVED);
        // $this->session->set_flashdata('status', 'success');
        
        // redirect(ADMIN_BASE_URL . 'invoice');
    }

    function insert_test($invoice_id,$org_id){
        $test = $this->input->post('testArray');
        $counter = 0;
        foreach ($test as $key => $value) {
            $data = array();
            unset($data); 
            $data = array();
            $test2=explode(',', $test[$counter]);
            $test_id = $test2[0];

            $where['id'] = $test_id;
            $arr_test = Modules::run('test/_get_by_arr_id',$where)->result_array();
            if (isset($arr_test) && !empty($arr_test)) {
                foreach ($arr_test as $key => $value1) {
                    $data['invoice_id'] = $invoice_id;
                    $data['test_id'] = $value1['id'];
                    $data['test_code'] = $value1['test_code'];
                    $data['test_name'] = $value1['name'];
                    $data['category_id'] = $value1['category_id'];
                    $data['category_name'] = $value1['category_name'];
                    $data['unit_id'] = $value1['unit_id'];
                    $data['unit_name'] = $value1['unit_name'];
                    $data['male_value'] = $value1['male_value'];
                    $data['female_value'] = $value1['female_value'];
                    $data['child_value'] = $value1['child_value'];
                    $data['delivery_time'] = $value1['delivery_time'];
                    $data['charges'] = $value1['charges'];
                    $data['org_id'] = $org_id;
                }
            }
            if(!empty($data)){
                $this->_insert_test($data);
            }
            $counter++; 
        }

    }

    //=============AJAX FUNCTIONS==============

    function get_test(){
        $category = $this->input->post('category');
        if(isset($category) && !empty($category)){
            $catData = explode(",",$category);
            $category_id = $catData[0];
        }
        $where['category_id'] = $category_id;
        $arr_test = Modules::run('test/_get_by_arr_id',$where)->result_array();
        $html='';
        $html.='<option value="">Select</option>';
        foreach ($arr_test as $key => $value) {
            $html.='<option value='.$value['id'].','.$value['name'].','.$value['charges'].'>'.$value['name'].'</option>';
        }
        echo $html;
    }

    function add_test(){
        $test = $this->input->post('test');
        $totalIn = $this->input->post('total_pay');
        if(isset($test) && !empty($test)){
            $testData = explode(",",$test);
            $test_id = $testData[0];
            $charges = $testData[2];
        }
        $where['id'] = $test_id;
        $arr_test = Modules::run('test/_get_by_arr_id',$where)->result_array();
        $html='';
        if (isset($arr_test) && !empty($arr_test)) {
            foreach ($arr_test as $key => $value) {
                $html.='<tr>';
                $html.='<td><input style="text-align: center;" class="form-control" readonly type="text" name="catArray[]" value='.$value['category_id'].','.$value['category_name'].'></td>';
                $html.='<td><input style="text-align: center;" class="form-control" readonly type="text" name="testArray[]" value='.$value['id'].','.$value['name'].'></td>';
                $html.='<td><input style="text-align: center;" class="form-control" readonly type="number" name="chargesArray[]" value='.$value['charges'].'></td>';
                $html.='</tr>';
            }
        }
        $total = $totalIn + $charges;
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
        $this->load->model('mdl_invoice');
        return $this->mdl_invoice->_get($order_by);
    }

    function _get_by_arr_id($update_id) {
        $this->load->model('mdl_invoice');
        return $this->mdl_invoice->_get_by_arr_id($update_id);
    }

    function _get_data_from_db_test($update_id) {
        $this->load->model('mdl_invoice');
        return $this->mdl_invoice->_get_data_from_db_test($update_id);
    }

    function _insert($data){
        $this->load->model('mdl_invoice');
        return $this->mdl_invoice->_insert($data);
    }

    function _insert_test($data){
        $this->load->model('mdl_invoice');
        return $this->mdl_invoice->_insert_test($data);
    }

    function _insert_pateint($data){
        $this->load->model('mdl_invoice');
        return $this->mdl_invoice->_insert_pateint($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_invoice');
        $this->mdl_invoice->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_invoice');
        $this->mdl_invoice->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_invoice');
        $this->mdl_invoice->_delete($arr_col, $org_id);
    }

    function _get_invoice_data($invoice_id,$org_id) {
        $this->load->model('mdl_invoice');
        return $this->mdl_invoice->_get_invoice_data($invoice_id,$org_id);
    }
}