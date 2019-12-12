<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gallery extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');

}

    function index() {
        $this->manage();
    }

    function manage() {
        $data['news'] = $this->_get('id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function create() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function _get_data_from_db($update_id) {
        $where['gallery.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['title'] = $row->title;
            $data['description'] = $row->description;
            $data['event_date'] = $row->event_date;
            $data['image'] = $row->image;
            $data['status'] = $row->status;
        }
        if(isset($data) && !empty($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['event_date'] = $this->input->post('event_date');
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
                $itemInfo = $this->_getItemById($update_id, $org_id);
                $actual_img_old = FCPATH . 'uploads/gallery/actual_images/' . $itemInfo->image;
                $medium_img_old = FCPATH . 'uploads/gallery/medium_images/' . $itemInfo->image;
                $large_img_old = FCPATH . 'uploads/gallery/large_images/' . $itemInfo->image;
                if (isset($_FILES['news_file']['name']) && !empty($_FILES['news_file']['name'])) {
                    if (file_exists($actual_img_old))
                        unlink($actual_img_old);
                    if (file_exists($medium_img_old))
                        unlink($medium_img_old);
                    if (file_exists($large_img_old))
                        unlink($large_img_old);
                    $this->upload_image($update_id,$org_id);
                }
                $this->_update($update_id,$user_data['user_id'], $data);

            }
            else{
                $id = $this->_insert($data);
                $this->upload_image($id,$user_data['user_id']);
                $users = $this->_get_all_users($org_id)->result_array();
                if (isset($users) && !empty($users)) {
                    foreach ($users as $key => $value) {
                        if ($value['user_type'] == 'Parent') {
                            $data2['notif_for'] = 'Parent';
                        }
                        elseif ($value['user_type'] == 'Teacher') {
                            $data2['notif_for'] = 'Teacher';
                        }
                        $data2['user_id'] = $value['id'];
                        $data2['notif_title'] = $data['title'];
                        $data2['notif_description'] = $data['description'];
                        $data2['notif_type'] = 'Event';
                        $data2['notif_sub_type'] = 'Event';
                        $data2['type_id'] = $id;
                        date_default_timezone_set("Asia/Karachi");
                        $data2['notif_date'] = date('Y-m-d H:i:s');
                        $data2['org_id'] = $data['org_id'];
                        $nid = $this->_notif_insert_data($data2);
                        if (isset($value['fcm_token']) && !empty($value['fcm_token'])) {
                            $fcm_token[] = $value;
                            Modules::run('front/send_notification',$fcm_token,$nid,$data2['notif_title'],$data2['notif_description']);
                            unset($fcm_token);
                        }
                    }
                }
            }
            $this->session->set_flashdata('message', 'gallery'.' '.DATA_SAVED);
	        $this->session->set_flashdata('status', 'success');
            redirect(ADMIN_BASE_URL . 'gallery');
        }
    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $itemInfo = $this->_getItemById($delete_id, $org_id);
        $file = $itemInfo->image;
        unlink('./uploads/gallery/medium_images/' . $file);
        unlink('./uploads/gallery/large_images/' . $file);
        unlink('./uploads/gallery/actual_images/' . $file);
        $this->_delete($delete_id, $org_id);
    }

    function set_publish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_publish($where);
        $this->session->set_flashdata('message', 'Post published successfully.');
        redirect(ADMIN_BASE_URL . 'gallery/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'gallery/manage/' . '');
    }
/////////////////////////Image Upload//////////////////////////////
    function upload_image($nid,$org_id){
        $config['image_library'] = 'gd2';
        $config['upload_path'] = MAKE_ACTUAL_IMAGE_PATH;
        $config['allowed_types'] = '*';
        $config['max_size'] = '0';
        $this->load->library('upload');
        $this->upload->initialize($config);
        $files = $_FILES;
        $cpt = count($_FILES['make_image']['name']);
        for($i=0; $i<$cpt; $i++)
        {
        if ($i==0) {     
         $upload_document_file = $files['make_image']['name'][$i];
         if($upload_document_file != '')
         {
            $upload_document_file = str_replace(' ', '_', $upload_document_file);
            $file_name = 'Make_logo_'.$nid[$i].'_'.$upload_document_file;
         }
         else 
         {
            $file_name = no_images.'.'.png ;
         }
         $this->upload->do_upload('make_image');
        }
        $upload_document_file = $files['make_image']['name'][$i];
        $upload_document_file = str_replace(' ', '_', $upload_document_file);
        $file_name = 'Make_logo_'.$nid[$i].'_'.$upload_document_file;
        $_FILES['make_image']['name'] = $file_name;
        $_FILES['make_image']['type'] = $files['make_image']['type'][$i];
        $_FILES['make_image']['tmp_name'] = $files['make_image']['tmp_name'][$i];
        $_FILES['make_image']['error'] = $files['make_image']['error'][$i];
        $_FILES['make_image']['size'] = $files['make_image']['size'][$i];    
        $upload_data = $this->upload->do_upload('make_image');
        $where['make_id']=$nid[$i];
        $data['make_image'] = $file_name;
        if(isset($upload_document_file) && !empty($upload_document_file))
        $this->_update($where, $data);
        $upload_data = $this->upload->data();

        /////////////// Large  Image ////////////////
        $config['source_image'] = $upload_data['full_path'];
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = true;
        $config['width'] = 500;
        $config['height'] = 400;
        $config['new_image'] = MAKE_LARGE_IMAGE_PATH;
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();

    }
}

    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == PUBLISHED)
            $status = UN_PUBLISHED;
        else
            $status = PUBLISHED;
        $data = array('status' => $status);
        $status = $this->_update_id($id, $data);
        echo $status;
    }

    /////////////// for detail ////////////
    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }

///////////////////////////     HELPER FUNCTIONS    ////////////////////

    function _getItemById($id, $org_id) {
        $this->load->model('mdl_gallery');
        return $this->mdl_gallery->_getItemById($id, $org_id);
    }
    function _set_publish($arr_col) {
        $this->load->model('mdl_gallery');
        $this->mdl_gallery->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_gallery');
        $this->mdl_gallery->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_gallery');
        return $this->mdl_gallery->_get($order_by);
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_gallery');
        return $this->mdl_gallery->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_gallery');
        return $this->mdl_gallery->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_gallery');
        $this->mdl_gallery->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_gallery');
        $this->mdl_gallery->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_gallery');
        $this->mdl_gallery->_delete($arr_col, $org_id);
    }

    function _notif_insert_data($data2){
        $this->load->model('mdl_gallery');
        return $this->mdl_gallery->_notif_insert_data($data2);
    }

    function _get_all_users($org_id){
        $this->load->model('mdl_gallery');
        return $this->mdl_gallery->_get_all_users($org_id);
    }

    function _get_teacher_token($teacher_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_teacher_token($teacher_id,$org_id);
    }

    function _get_parent_token($parent_id,$org_id){
        $this->load->model('mdl_front');
        return $this->mdl_front->_get_parent_token($parent_id,$org_id);
    }
}