<?php defined("BASEPATH") OR exit("No direct script access allowed");
class Events extends CI_Controller {
  	function __construct() {
	    parent::__construct();
	    $this->load->model("Events_model"); 

		isLogin(); 
		$this->user_id =isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:1;
		$this->userName =isset($this->session->get_userdata()['user_details'][0]->name)?$this->session->get_userdata()['user_details'][0]->name:'';

        $this->load->helper('language');
        $this->lang->load('events',$this->session->userdata('site_lang'));
        $this->checkEnableStatus();
		
  	}


  	//load calendar view
    public function index($encrypted_event_id="") {
        $view_data['encrypted_event_id'] = $encrypted_event_id;
        $this->load->view("include/header");
		$this->load->view("index",$view_data);
		$this->load->view("include/footer"); 

    }

    public function canShareEvents() {
        return get_array_value($this->login_user->permissions, "disable_event_sharing") == "1" ? false : true;
    }

    //show add/edit event modal form
    public function modalForm() {
        $event_id = $this->input->post('encrypted_event_id');
        $model_info = $this->Events_model->getOne($event_id);

        $model_info->start_date = $model_info->start_date ? $model_info->start_date : $this->input->post('start_date');
        $model_info->end_date = $model_info->end_date ? $model_info->end_date : $this->input->post('end_date');
        if (($model_info->start_time == '')&&($this->input->post('start_time') == "")) {
            $model_info->start_time = 0;
        } else {
            $model_info->start_time = $model_info->start_time ? $model_info->start_time : $this->input->post('start_time');
        }
        if (($model_info->end_time == '')&&($this->input->post('end_time') == "")) {
            $model_info->end_time = 0;
        } else {
            $model_info->end_time = $model_info->end_time ? $model_info->end_time : $this->input->post('end_time');
        }

        $view_data['client_id'] = $this->input->post('client_id');

        $view_data['model_info'] = $model_info;
        $view_data['time_format_24_hours'] = true;

        //prepare label suggestion dropdown
        $labels = explode(",", $this->Events_model->getLabelSuggestions());
        $label_suggestions = array();
        foreach ($labels as $label) {
            if ($label && !in_array($label, $label_suggestions)) {
                $label_suggestions[] = $label;
            }
        }
        if (!count($label_suggestions)) {
            $label_suggestions = array("0" => "");
        }
        $view_data['label_suggestions'] = $label_suggestions;
        
        $this->load->view('events/modal_form', $view_data);
    }

    //save an event
    public function save() {
        $id = $this->input->post('id');
        //convert to 24hrs time format
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');

        $data = array(
            "title" => $this->input->post('title'),
            "description" => $this->input->post('description'),
            "start_date" => $this->input->post('start_date'),
            "end_date" => $this->input->post('end_date'),
            "start_time" => $start_time,
            "end_time" => $end_time,
            "location" => $this->input->post('location'),
            "labels" => $this->input->post('labels'),
            "color" => $this->input->post('color'),
            "created_by" => $this->user_id
        );

        $save_id = $this->Events_model->save($data, $id);
        if ($save_id) {
        	echo json_encode(array("success" => true, 'message' => lang('record_saved')));	
            
        } else {
             echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    //delete/undo an event
    public function delete() {

        $id = $this->input->post('encrypted_event_id'); //to make is secure we'll use the encrypted id
        //only admin can delete other team members events
        //non-admin team members can delete only their own events
        if ($id) {
            $event_info = $this->Events_model->getOne($id);
            if ($event_info->created_by != $this->user_id) {
                redirect("forbidden");
            }
        }


        if ($this->Events_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => lang('event_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
        }
    }

    //get calendar event
    public function calendarEvents($client_id = 0) {
        $options = array("user_id" => $this->user_id);
        $list_data = $this->Events_model->getDetails($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_makeCalendarEvent($data);
        }
        echo json_encode($result);
    }

    //prepare calendar event
    public function _makeCalendarEvent($data) {
        // print_r($data);die();
        return array(
            "title" => $data->title,
            "icon" => "fa-at",
            "start" => $data->start_date . " " . $data->start_time,
            "end" => $data->end_date . " " . $data->end_time,
            "encrypted_event_id" => $data->id,
            "backgroundColor" => $data->color,
            "borderColor" => $data->color,
        );
    }

    //view an evnet
    public function view() {
        $event_id = $this->input->post('id');
        $model_info = $this->Events_model->getDetails(array("id" => $event_id))->row();
        if ($event_id && $model_info->id) {
            $view_data['encrypted_event_id'] = $event_id; //to make is secure we'll use the encrypted id 
            $view_data['editable'] = $this->input->post('editable');
            $view_data['model_info'] = $model_info;
            $view_data['event_icon'] = 'fa-at';
            $event_labels = "";
            if ($model_info->labels) {
                $labels = explode(",", $model_info->labels);
                foreach ($labels as $label) {
                    $event_labels.="<span class='label large' style='background-color:$model_info->color;' title='Label'>" . $label . "</span> ";
                }
            }

            $view_data['labels'] = $event_labels;

            $this->load->view('events/view', $view_data);
        } else {
            show_404();
        }
    }

	    /**
	 * decode the id which made by encode_id()
	 * 
	 * @param string $id
	 * @param string $salt
	 * @return decoded value
	 */

    public function decodeId($id, $salt) {
        $id = str_replace("_", "+", $id);
        $id = str_replace("~", "=", $id);
        $id = str_replace("-", "/", $id);

        if ($id && strpos($id, $salt) != false) {
            return str_replace($salt, "", $id);
        }else{
            return "";
        }
    }

    public function checkEnableStatus()
    {
        $res = checkEnableStatus('events');
        if (empty($res)) {
            $art_msg['msg'] = lang('extension_is_not_activate');
            $art_msg['type'] = 'warning';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url());
        }
    }
}
?>