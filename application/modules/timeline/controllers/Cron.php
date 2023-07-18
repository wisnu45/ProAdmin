<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("timeline_model");
        $this->lang->load(strtolower('timeline'), $this->session->userdata('site_lang'));
    }


    public function sendNotification() {
        $this->load->model('user/User_model');
        $setting = settings();
        $sql = "SELECT `user_id`,  count('post_id') AS `unreadPosts` FROM `ia_post_notification` GROUP BY `user_id`";
        $users  = $this->timeline_model->getQrResult($sql); 

        $sub = "Unread Posts Notification";
        foreach ($users as $key => $value) {
            $user_detail = $this->timeline_model->getDataBy('ia_users', $value->user_id, 'ia_users_id');
            $email = $user_detail[0]->email;
            $body = $this->User_model->get_template('undead_post_notification'); 
            $body = $body->html;
            
            $tmpalet_var = array(
                "sender_name" => '', //$setting['company_name'], //'Expence Manager Ticket',
                "user_name" => $user_detail[0]->name,
                "unread_noti" => $value->unreadPosts
            );
            foreach ($tmpalet_var as $tvkey => $tvvalue) {
                $body = str_replace('{var_'.$tvkey.'}', $tvvalue, $body);
            }
            if($setting['mail_setting'] == 'php_mailer') {
                $this->load->library("send_mail");         
                $emm = $this->send_mail->email($sub, $body, $email, $setting);
            } else {
                // content-type is required when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: '.$setting['EMAIL'] . "\r\n";
                $emm = mail($email,$sub,$body,$headers);
            }
        }
    }
}
