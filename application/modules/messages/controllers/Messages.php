<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Messages extends CI_Controller {

    function __construct() {
        parent::__construct();
        if(true==1){
            isLogin(); 
            $this->user_id = isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:'1';
        }else{  
            $this->user_id = 1;
        }

        $this->load->model("Messages_model"); 
        $this->load->helper("../modules/messages/helpers/app_files_helper");
        $this->load->helper('../modules/messages/helpers/general_helper');
        $this->load->helper('../modules/messages/helpers/date_time_helper');
        $this->load->library('Encrypt');
        $this->lang->load('messages', $this->session->userdata('site_lang'));

        $this->checkEnableStatus();
    }

    public function index() {
        redirect(base_url(). "messages/inbox");
    }

   public function checkEnableStatus()
    {
        $res = checkEnableStatus('messages');
        if (empty($res)) {
            $art_msg['msg'] = lang('extension_is_not_activate');
            $art_msg['type'] = 'warning';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url());
        }
    }

        /* show new message modal */

        public function getModal() {
            $users= $this->Messages_model->getUsers();
            $data['users_dropdown2'] = $users;

            $data['users_dropdown'] = array("" => "-");

            foreach ($users as $user) {
                $data['users_dropdown'][$user->ia_users_id] = $user->name;
            }
                echo $this->load->view('add_update', $data, true);
            exit;
        }

    /* show new message modal */

    function modalForm($user_id = 0) {
        /*
         * team members can send message to all team members
         * clients can only send message to team members (as defined on Client settings)
         * team members can send message to clients (as defined on Client settings)
         */
        $client_message_users = get_setting("client_message_users");
        if ($this->login_user->user_type === "staff") {
            //user is team member
            $client_message_users_array = explode(",", $client_message_users);
            if (in_array($this->login_user->id, $client_message_users_array)) {
                //user can send message to clients
                $users = $this->Users_model->get_team_members_and_clients("", "", $this->login_user->id)->result();
            } else {
                //user can send message only to team members
                $users = $this->Users_model->get_team_members_and_clients("staff", "", $this->login_user->id)->result();
            }
        } else {
            //user is a client contact
            if ($client_message_users) {
                $users = $this->Users_model->get_team_members_and_clients("staff", $client_message_users)->result();
            } else {
                //client can't send message to any team members
                redirect("forbidden");
            }
        }


        $view_data['users_dropdown'] = array("" => "-");
        if ($user_id) {
            $view_data['message_user_info'] = $this->Users_model->getOne($user_id);
        } else {
            foreach ($users as $user) {
                $client_tag = "";
                if ($user->user_type === "client") {
                    $client_tag = "  - " . lang("client") . ": " . $user->company_name . "";
                }
                $view_data['users_dropdown'][$user->id] = $user->first_name . " " . $user->last_name . $client_tag;
            }
            /// $view_data['users_dropdown'] = array("" => "-") + $this->Users_model->get_dropdown_list(array("first_name", "last_name"), "id", array("user_type" => "staff", "id !=" => $this->login_user->id));
        }

        $this->load->view('messages/modalForm', $view_data);
    }

    /* show inbox */

    function inbox($auto_select_index = "") {
        $view_data['mode'] = "inbox";
        $view_data['auto_select_index'] = $auto_select_index;
        $this->load->view("include/header");      
        $this->load->view("index",$view_data);
        $this->load->view("include/footer");
    }

    /* show sent items */

    function sentItems($auto_select_index = "") {
        $view_data['mode'] = "sent_items";
        $view_data['auto_select_index'] = $auto_select_index;
        $this->load->view("include/header");
        $this->load->view("index",$view_data);
        $this->load->view("include/footer");
    }

 
    /* list of messages, prepared for datatable  */

    function listData($mode = "inbox") {
        if ($mode !== "inbox") {
            $mode = "sent_items";
        }
        $options = array("user_id" => $this->user_id, "mode" => $mode);
        $list_data = $this->Messages_model->getList($options)->result();

        $result = array();

        foreach ($list_data as $data) {
            $result[] = $this->_makeRow($data, $mode);
        }

        echo json_encode(array("data" => $result));
    }

    /* return a message details */

    function view($encrypted_id = 0, $mode = "", $reply = 0) {
        $message_id = decode_id($encrypted_id, "message_id");
        check_required_hidden_fields(array($message_id));

        $message_mode = $mode;
        if ($reply == 1 && $mode == "inbox") {
            $message_mode = "sent_items";
        } else if ($reply == 1 && $mode == "sent_items") {
            $message_mode = "inbox";
        }

        $options = array("id" => $message_id, "user_id" => $this->user_id, "mode" => $message_mode);
        $view_data["message_info"] = $this->Messages_model->getDetails($options)->row();

        //change message status to read
        $this->Messages_model->setMessageStatusAsRead($view_data["message_info"]->id, $this->user_id);

        $replies_options = array("message_id" => $message_id, "user_id" => $this->user_id);
        $view_data["replies"] = $this->Messages_model->getDetails($replies_options)->result();

        $view_data["encrypted_message_id"] = $encrypted_id;
        $view_data["mode"] = $mode;
        $view_data["is_reply"] = $reply;
        echo json_encode(array("success" => true, "data" => $this->load->view("messages/view", $view_data, true), "test" => $options));
    }

    /* prepare a row of message list table */

    private function _makeRow($data, $mode = "") {
        $image_url = get_avatar($data->user_image);
        $created_at = format_to_relative_time($data->created_at);
        $encrypted_id = encode_id($data->main_message_id, "message_id");
        $label = "";
        $reply = "";
        $status = "";
        $attachment_icon = "";
        $subject = $data->subject;
        if ($mode == "inbox") {
            $status = $data->status;
        }
        if ($data->reply_subject) {
            $label = " <label class='label label-success inline-block'>" . lang('reply') . "</label>";
            $reply = "1";
            $subject = $data->reply_subject;
        }

        if ($data->files && count(unserialize($data->files))) {
            $attachment_icon = "<i class='fa fa-paperclip font-16 mr15'></i>";
        }

        $message = "<div class='pull-left message-row $status' data-id='$encrypted_id' data-index='$data->main_message_id' data-reply='$reply'><div class='media-left'>
                        <span class='avatar avatar-xs'>
                            <img src='$image_url' />
                        </span>
                    </div>
                    <div class='media-body'>
                        <div class='media-heading'>
                            <strong> $data->user_name</strong>
                                  <span class='text-off pull-right'>$attachment_icon $created_at</span>
                        </div>
                        $label $subject
                    </div></div>
                  
                ";
        return array(
            $message,
            $data->created_at,
            $status
        );
    }

    /* send new message */

    function sendMessage() {

        $target_path = "files/timeline_files/";
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "message");


        $message_data = array(
            "from_user_id" => $this->user_id,
            "to_user_id" => $this->input->post('to_user_id'),
            "subject" => $this->input->post('subject'),
            "message" => $this->input->post('message'),
            "created_at" => get_current_utc_time(),
            "files" => $files_data,
            "deleted_by_users" => "",
        );

        $save_id = $this->Messages_model->insertRow('ia_messages', $message_data);

        if ($save_id) {
            //log_notification("new_message_sent", array("actual_message_id" => $save_id));
            //echo json_encode(array("success" => true, 'message' => 'Message Sent'));

            $art_msg['msg'] = lang('your_messge_has_been_sent_successfully'); 
            $art_msg['type'] = 'success'; 
            $this->session->set_userdata('alert_msg', $art_msg);

        } else {
            //echo json_encode(array("success" => false, 'message' => 'Error occurred'));
            $art_msg['msg'] = lang('error_occurred'); 
            $art_msg['type'] = 'warning'; 
            $this->session->set_userdata('alert_msg', $art_msg);
        }
            redirect(base_url(). "messages/inbox");

    }

    /* reply to an existing message */

    function reply() {
        $encrypted_message_id = $this->input->post('message_id');
        $message_id = decode_id($encrypted_message_id, "message_id");
        check_required_hidden_fields(array($message_id));

        $message_info = $this->Messages_model->getOne($message_id);
        if ($message_info->id) {
            //check, where we have to send this message
            $to_user_id = 0;
            if ($message_info->from_user_id === $this->user_id) {
                $to_user_id = $message_info->to_user_id;
            } else {
                $to_user_id = $message_info->from_user_id;
            }

            $target_path = "files/timeline_files/";
            $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "message");

            $message_data = array(
                "from_user_id" => $this->user_id,
                "to_user_id" => $to_user_id,
                "message_id" => $message_id,
                "subject" => "",
                "message" => $this->input->post('reply_message'),
                "created_at" => get_current_utc_time(),
                "files" => $files_data,
                "deleted_by_users" => "",
            );


            $save_id = $this->Messages_model->save($message_data);

            if ($save_id) {
                 //log_notification("message_reply_sent", array("actual_message_id" => $save_id, "parent_message_id" => $message_id));
                //clear the delete status, if the mail deleted
                $this->Messages_model->clearDeletedStatus($message_id);

                $options = array("id" => $save_id, "user_id" => $this->user_id);
                $view_data['reply_info'] = $this->Messages_model->getDetails($options)->row();
            //echo '<pre>'; print_r($view_data);die;
                echo json_encode(array("success" => true, 'message' => lang('the_message_has_been_sent').'.', 'data' => $this->load->view("messages/reply_row", $view_data, true)));
                return;
            }
        }
        echo json_encode(array("success" => false, 'message' => 'error_occurred'));
    }

    /* prepare notifications */

    function getNotifications() {
        $notifiations = $this->Messages_model->getNotifications($this->login_user->id, $this->login_user->message_checked_at);
        $view_data['notifications'] = $notifiations->result();
        echo json_encode(array("success" => true, 'total_notifications' => $notifiations->num_rows(), 'notification_list' => $this->load->view("messages/notifications", $view_data, true)));
    }

    function updateNotificationCheckingStatus() {
        $now = get_current_utc_time();
        $user_data = array("message_checked_at" => $now);
        $this->Users_model->save($user_data, $this->login_user->id);
    }

    /* upload a file */

    function uploadFile() {
        upload_file_to_temp();
    }

    /* check valid file for message */

    function validateMessageFile() {
        return validate_post_file($this->input->post("file_name"));
    }

    /* download files by zip */

    function downloadMessageFiles($encrypted_id = "") {
        $message_id = decode_id($encrypted_id, "message_id");
        check_required_hidden_fields(array($message_id));


        $files = $this->Messages_model->getOne($message_id)->files;
        $timeline_file_path = "files/timeline_files/";
        download_app_files($timeline_file_path, $files);
    }

    function deleteMyMessages($id = 0) {

        if (!$id) {
            exit();
        }

        $this->Messages_model->deleteMessagesForUser($id, $this->user_id);
    }
}