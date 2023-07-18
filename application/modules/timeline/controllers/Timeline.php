<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timeline extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isLogin();
        $this->load->model("timeline_model");
        $this->lang->load(strtolower('timeline'), $this->session->userdata('site_lang'));
        $this->user_id =isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:'';
        $this->user_type = isset($this->session->get_userdata()['user_details'][0]->user_type)?$this->session->get_userdata()['user_details'][0]->user_type:'';
    }

    /* load timeline view */

    function index() {

        if($this->input->post()) {
            $images = $this->uploadImages();
            $data_arr = array(
                "created_by"  => $this->user_id,
                "created_at"  => date('Y-m-d H:i:s'),
                "description" => $this->input->post('post'),
                "files"       => json_encode($images),
                "share_with"  => $this->input->post('share_with'),
                "deleted"     => 0
            );
            $instId = $this->timeline_model->insertRow('ia_posts', $data_arr);
            $perm = $this->timeline_model->getDataBy('ia_permission', $this->input->post('share_with'), 'id');
            $user_type_name = $perm[0]->user_type;
            $uids = $this->timeline_model->getDataBy('ia_users', $user_type_name, 'user_type');
            foreach ($uids as $uidkey => $uidvalue) {
                if($this->user_id != $uidvalue->ia_users_id) {
                    $noti = array(
                            "user_id" => $uidvalue->ia_users_id,
                            "post_id" => $instId
                    );
                    $this->timeline_model->insertRow('ia_post_notification', $noti);
                }
            }
            $art_msg['msg'] = 'Post added successfully'; 
            $art_msg['type'] = 'success'; 
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url().'timeline');
        } else {
            $data['u_data'] = $this->timeline_model->getDataBy('ia_users', $this->user_id, 'ia_users_id');
            $sql = "SELECT `id`,`user_type` FROM `ia_permission` WHERE `user_type` != 'admin'";
            $data['u_type'] = $this->timeline_model->getQrResult($sql);
            $this->load->view("include/header");
            $this->load->view("index",$data);
            $this->load->view("include/footer");
        }
    }


    public function getPosts() {
        $offset = $this->input->post('offset');
        $limit = $this->input->post('limit');
        $data['u_data'] = $this->timeline_model->getDataBy('ia_users', $this->user_id, 'ia_users_id');
        $data['posts'] = $this->timeline_model->getPosts($offset, $limit);       
        $data['obj'] = $this;
        echo $this->load->view('post_html', $data, 1);
        exit;

        //echo '<pre>';print_r($posts); die; 
    }

    public function setReadPost($post_id) {

        $this->timeline_model->setReadPost($post_id);
    }

    public function uploadImages() {
        $images = array();
        if(isset($_FILES['post_files']) && $_FILES['post_files']['error'][0] == 0) {
            $cnt                     = count($_FILES['post_files']['name']);
            $config['upload_path']   = 'assets/images';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = 5000;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            for ($i=0; $i < $cnt ; $i++) { 
                $f_name                        = str_replace(' ', '_', $_FILES['post_files']['name'][$i]);
                $f_name                        = strtolower($f_name);
                $f_name                        = 'timeline_'.$f_name;
                $_FILES['mkaFile']['name']     = $f_name;
                $_FILES['mkaFile']['type']     = $_FILES['post_files']['type'][$i];
                $_FILES['mkaFile']['tmp_name'] = $_FILES['post_files']['tmp_name'][$i];
                $_FILES['mkaFile']['error']    = $_FILES['post_files']['error'][$i];
                $_FILES['mkaFile']['size']     = $_FILES['post_files']['size'][$i];
                if($this->upload->do_upload('mkaFile')) {
                    $images[] = $f_name;
                }
            }
        }
        return $images;
    }


    public function comment() {
        $data_arr = array(
                "post_id"    => $this->input->post('post_id'),
                "comment"    => $this->input->post('comment'),
                "createdate" => date('Y-m-d H:i:s'),
                "created_by" => $this->user_id
            );
        $this->timeline_model->insertRow('ia_post_comments', $data_arr);
        echo 1;
        exit;
    }


    public function commentCount($post_id) {
        return $this->timeline_model->commentCount($post_id);
    }

    public function getComments() {
        $html = '';
        $cpmment = $this->timeline_model->getDataBy('ia_post_comments', $this->input->post('post_id'), 'post_id');
        if(is_array($cpmment) && !empty($cpmment)) {

            foreach ($cpmment as $comkey => $comvalue) {
                $act_cl = '';
                if($comvalue->created_by == $this->user_id) {
                    $act_cl = 'mka-active';
                }
                $user = $this->timeline_model->getDataBy('ia_users', $comvalue->created_by, 'ia_users_id');
                $html .= '<li class="list-group-item '.$act_cl.'">';
                $html .= '<div class="row">';
                $html .= '<div class="col-md-1">';
                $html .= '<img src="'.iaBase().'/assets/images/'.$user[0]->profile_pic.'" class="img-circle img-responsive" alt="">';
                $html .= '</div>';
                $html .= '<div class="col-md-11">';
                $html .= '<p><strong>'.$user[0]->name.'</strong></p>';
                $html .= '<span class="comm-time">'.date('d.m.Y H:i:s', strtotime($comvalue->createdate)).'</span>';
                $html .= '<p>'.$comvalue->comment.'</p>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</li>';
            }
        }
        echo $html;
        die;
    }


    public function deletePost() {
        $res = 0;
        if($this->input->post('post_id')) {
            $data = array('deleted' => 1);
            $this->timeline_model->updateRow('ia_posts', 'id', $this->input->post('post_id'), $data);
            $res = 1;
        }
        echo $res;
        exit;
    }

    public function checkPostCount() {
        $where = '';
        if($this->user_type != 'admin') {
            $per = $this->timeline_model->getDataBy('ia_permission', $this->user_type, 'user_type');
            if(isset($per[0]->id)){
                $where = " AND `p`.`share_with` = '".$per[0]->id."'";
            }
        }

        $qry = "SELECT count('*') AS `cnt`  FROM `ia_posts` AS `p` WHERE `p`.`deleted` = '0' ".$where;
        $r = $this->timeline_model->getQrResult($qry);
        $res = 0;
        if(isset($r[0]->cnt)) {
            $res = $r[0]->cnt;
        }
        echo $res;
        die;
    }

}
