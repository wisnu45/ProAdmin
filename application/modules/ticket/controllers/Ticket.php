<?php
defined("BASEPATH") or exit("No direct script access allowed");
class Ticket extends CI_Controller {
  	function __construct() {
	    parent::__construct();
	    $this->load->model("Ticket_model"); 
	    $this->lang->load('ticket', $this->session->userdata('site_lang'));
	    //echo $this->uri->segment(2); die;
		if($this->uri->segment(2) != 'recurring'){
			
			$this->user_id =isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:'1';
		}else{ 	
			$this->user_id = 1;
		}

		$this->checkEnableStatus();
  	}
  	/**
      * This function is used to view page
      */
  	public function index() { 
  		if(CheckPermission("ticket", "all_read,own_read")){
  			$con = '';
			$data["view_data"]= $this->Ticket_model->getData($con);
			
			if($con == '') {

				$this->load->view("include/header");
  			
			}
			$data["obj"] = $this;
			
			$this->load->view("index",$data);
			
			if($con == '') {
				
				$this->load->view("include/footer");
			}
		} else {
			$art_msg['msg'] = lang('you_do_not_have_permission_to_access'); 
			$art_msg['type'] = 'warning'; 
			$this->session->set_userdata('alert_msg', $art_msg);
            redirect( base_url().'user/profile', 'refresh');
		}
		
  	}

 public function checkEnableStatus()
    {
        $res = checkEnableStatus('ticket');
        if (empty($res)) {
            $art_msg['msg'] = lang('extension_is_not_activate');
            $art_msg['type'] = 'warning';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url());
        }
    }


  	public function view($id) {
  		$tk_data = $this->Ticket_model->getDataBy('ia_ticket', $id, 'ticket_id');
  		$comm_data = $this->Ticket_model->getDataBy('ia_ticket_comments', $id, 'ticket_id');
  		/*echo '<pre>';
  		print_r($tk_data);
  		print_r($comm_data); die;*/
  		$data['ticket_details'] = $tk_data;
  		$data['comments'] = $comm_data;
  		$data['ctr_object'] = $this;
  		$this->load->view("include/header");
  		$this->load->view("view",$data);
		$this->load->view("include/footer");
  	}

  	public function getUserDetails($id) {
  		return $this->Ticket_model->getDataBy('ia_users', $id, 'ia_users_id');

  	}

  	public function saveComment() {

  		/*error_reporting(E_ALL);
  		ini_set('display_errors', 1);*/
  		$files = array();
  		if(isset($_FILES['comm_files']['error']) && $_FILES['comm_files']['error'] == 0) {
			$filename                = str_replace(' ', '_', $_FILES['comm_files']['name']);
			$exp                     = explode('.', $filename);
			$ext                     = end($exp);
			$newname                 = strtolower($exp[0]).'_'.time().".".$ext; 
			$config['file_name']     = $newname;
			$config['upload_path']   = 'assets/images/comment/';
			$config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|jpeg|xlsx|xls|txt';
			$config['max_size']      = 3000;
	        $this->load->library('upload', $config);
	        if ( ! $this->upload->do_upload('comm_files')) {
				$error           = array('error' => json_encode($this->upload->display_errors()));
				$art_msg['msg']  = $error; 
				$art_msg['type'] = 'warning'; 
				$this->session->set_userdata('alert_msg', $art_msg);
			    redirect(base_url().'ticket');
	        }
	        $files[] = $newname;
  		}


  		$data = array(
					'created_by'  => $this->user_id,
					'created_at'  => date('Y-m-d H:i:s'),
					'description' => $this->input->post('comment'),
					'ticket_id'   => $this->input->post('ticket_id'),
					'files'       => json_encode($files),
					'deleted'     => '0'
  		);
  		$this->Ticket_model->insertRow('ia_ticket_comments', $data);
		$tk_data = $this->Ticket_model->getDataBy('ia_ticket', $this->input->post('ticket_id'), 'ticket_id');
		if($tk_data[0]->ticket_status != 'Close') {
			$this->Ticket_model->updateRow('ia_ticket', 'ticket_id', $this->input->post('ticket_id'), array('ticket_status' => 'Ongoing'));
		}

		$this->sendMailTicket($this->input->post('ticket_id'), $this->input->post('comment'));

        $art_msg['msg'] = 'Successfully action performed.'; 
		$art_msg['type'] = 'success'; 
		$this->session->set_userdata('alert_msg', $art_msg);
	    redirect(base_url(). 'ticket/view/'.$this->input->post('ticket_id'));
  	}


  	public function closeTicket(){
  		$tk_data = $this->Ticket_model->getDataBy('ia_ticket', $this->input->post('id'), 'ticket_id');
  		$users = array(
  			$tk_data[0]->user_id,
  			$tk_data[0]->ticket_client
  		);

  		$mtext = 'vient d\'ouvrir à nouveau';
  		if($this->input->post('chnageto') == 'Close') {
  			$mtext = 'clôturé';     //'Closed';
  		}
  		
  		foreach ($users as $ukey => $uvalue) {
  			$user_detail = $this->Ticket_model->getDataBy('ia_users', $uvalue, 'ia_users_id');
	  		$this->load->model('User_model');
	  		if($user_detail[0]->email != '') {
		  		$setting = settings();
		  		$sub = "Ticket #".$tk_data[0]->ticket_id." - ".$tk_data[0]->ticket_ticket_title;
		       	$email = $user_detail[0]->email;
		       	$body = $this->User_model->getTemplate('close_ticket'); 
		       	$body = $body->html;
		       	$adm_name = $this->session->get_userdata()['user_details'][0]->name;
		       	$message = '<strong>'.ucfirst($adm_name).'</strong> a '.$mtext.' le ticket.';
		       	$tmpalet_var = array(
		       		"sender_name" => '', //$setting['company_name'], //'Expence Manager Ticket',
		       		"user_name" => $user_detail[0]->name,
		       		"ticket_name" => $tk_data[0]->ticket_ticket_title,
		       		"close_message" => $message,
		       		"ticket_view_link" => base_url().'ticket/view/'.$this->input->post('id'),
		       		"direct_link" => base_url().'ticket/view/'.$this->input->post('id')
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
  		//echo '<pre>'; print_r($users); die;
  		//$time = $this->Ticket_model->getQrResult("SELECT NOW() AS `mka_time`");
  		$data_arr = array(	
  			"ticket_status" => $this->input->post('chnageto'),
  			"close_date" =>  date('Y-m-d H:i:s'), //$time[0]->mka_time,
  			"close_by" => $this->session->get_userdata()['user_details'][0]->ia_users_id
  		);
  		$this->Ticket_model->updateRow('ia_ticket', 'ticket_id', $this->input->post('id'), $data_arr);
  		echo 1;
  		exit;
  	}

  	public function getusetnamebyid($id) {
  		$ur_data = $this->Ticket_model->getDataBy('ia_users', $id, 'ia_users_id');
  		$res = '';
  		if(isset($ur_data[0]->name)) {
  			$res = $ur_data[0]->name;
  		} 
  		return $res; 
  	}

  	public function getFilterHtml($ajax = 0) {
  		//print_r($this->session->get_userdata()['user_details'][0]->user_type != 'Customer'); die;
  		$filter_coo = '';
  		if(isset($_COOKIE[strtolower('Ticket_filter')])) {
  			$filter_coo = json_decode($_COOKIE[strtolower('Ticket_filter')]);
  		}
  		$html = '';
  		if($this->session->get_userdata()['user_details'][0]->user_type == 'admin') {
	  		$html .= '<div class="col-md-3">
					<div class="form-group form-float">
						<div class="form-line">';
				$html .='<select name="ia_ticket___ticket_client___filter" class="filter-field form-control">';
					$html .='<option value="all">'.lang('all').'</option>';
			$sel = ''; if(isset($filter_coo->ia_ticket___ticket_client___filter)) { $sel = $filter_coo->ia_ticket___ticket_client___filter; }  $html .= $this->getFilterDropdownOptions('ticket_client', 'ia_users', 'name', ''.$sel.'');
			$html .= '</select>
							<label class="form-label" style="margin-top: -10px;">'.lang('client').'</label>
						</div>
					</div>
				</div>';
  		}

		$html .= '<div class="col-md-3">
				<div class="form-group form-float">
					<div class="form-line">';
			$html .='<select name="ia_ticket___ticket_status___filter" class="filter-field form-control">';
				$html .='<option value="all">'.lang('all').'</option>';
 $se = ''; if(isset($filter_coo->ia_ticket___ticket_status___filter) && $filter_coo->ia_ticket___ticket_status___filter == 'Open') { $se = 'selected'; }	$html .='<option '.$se.' value="Open">'.lang('open').'</option>';
 $se = ''; if(isset($filter_coo->ia_ticket___ticket_status___filter) && $filter_coo->ia_ticket___ticket_status___filter == 'Ongoing') { $se = 'selected'; }	$html .='<option '.$se.' value="Ongoing">Ongoing</option>';
 $se = ''; if(isset($filter_coo->ia_ticket___ticket_status___filter) && $filter_coo->ia_ticket___ticket_status___filter == 'Close') { $se = 'selected'; }	$html .='<option '.$se.' value="Close">'.lang('close').'</option>';
		$html .= '</select>
						<label class="form-label" style="margin-top: -10px;">'.lang('status').'</label>
					</div>
				</div>
			</div>
';
  		if($ajax == 1) {
  			echo $html; exit;
  		} else {
  			return $html;
  		}
  	}


  	public function getFilterDropdownOptions($field, $rel_table, $rel_col, $selected) {
  		$res = $this->Ticket_model->getFilterDropdownOptions($field, $rel_table, $rel_col);
  		$option = '';
  		if(isset($res) && is_array($res) && !empty($res)) {
  			foreach ($res as $key => $value) {
  				if($rel_table != '') {
  					if($value->$rel_col != '') {
	  					$col = $rel_table.'_id';
	  					$se = '';
	  					if($selected == $value->$col) {
	  						$se = 'selected';
	  					}
	  					$option .= '<option '.$se.' value="'.$value->$col.'">'.substr(ucfirst($value->$rel_col), 0, 30).'</option>';	
  					}
  				} else {
  					if($value->$field != '') {
	  					$se = '';
	  					if($selected == $value->$field) {
	  						$se = 'selected';
	  					}
	  					$option .= '<option '.$se.' value="'.$value->$field.'">'.substr(ucfirst($value->$field), 0, 30).'</option>';
  					}
  				}
  			}
  		}
  		return $option;
  	}
  	

  	/**
      * This function is used to Add and update data
      */
	public function addEdit() {	
		$data = $this->input->post();
		$postoldfiles = array();
		foreach ($data as $okey => $ovalue) {
    		if(strstr($okey, "wpb_old_")) {
			$postoldfiles[$okey]=$ovalue;
    		}
		}

		$newfiles = [];

	
		foreach ($_FILES as $fkey => $fvalue) {
			
			$config['upload_path'] = 'assets/images/';
			$config['upload_url'] =  base_url().'assets/images/';
			$config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
			$config['max_size'] = 5000; 

			$this->load->library('upload', $config);
			foreach($fvalue['name'] as $key => $fileInfo) {
				
				$filename = str_replace(' ', '_', $_FILES[$fkey]['name'][$key]);
				$exp = explode('.', $filename);
				$ext = end($exp);
				$newname =  strtolower($exp[0]).'_'.time().".".$ext; 

				$_FILES['mka_t']['name']     = $newname;
				$_FILES['mka_t']['type']     = $_FILES[$fkey]['type'][$key];
				$_FILES['mka_t']['tmp_name'] = $_FILES[$fkey]['tmp_name'][$key];
				$_FILES['mka_t']['error']    = $_FILES[$fkey]['error'][$key];
				$_FILES['mka_t']['size']     = $_FILES[$fkey]['size'][$key];
				if ( $this->upload->do_upload('mka_t')) {
					$newfiles[$fkey][] = $newname;
		        } else {
		        	$art_msg['msg'] = $this->upload->display_errors(); 
		        }
				
			}

			if(!empty($postoldfiles)) {

				if(!empty($postoldfiles['wpb_old_'.$fkey])){
					$oldfiles = $postoldfiles['wpb_old_'.$fkey];
				}
				else{
					$oldfiles = array();
				}
				if(!empty($newfiles[$fkey])){
					$all_files = array_merge($oldfiles,$newfiles[$fkey]);	
				}
				else{
					$all_files = $postoldfiles['wpb_old_'.$fkey];
				}
					
			}
			else{
				$all_files = isset($newfiles[$fkey])?$newfiles[$fkey]:'';
			}
			if(is_array($all_files) && !empty($all_files)) {
				$data[$fkey] = implode(',', $all_files);
			}
		}

		//echo '<pre>'; print_r($data); die;
		if(!isset($data['wpb_old_ticket_upload_document']) && !isset($data['ticket_upload_document'])) {
			$data['ticket_upload_document'] = '';
		}
		
		if($this->input->post('id')) {
			foreach ($postoldfiles as $pkey => $pvalue) {
				unset($data[$pkey]);		
			}
			unset($data['submit']);
			unset($data['save']);
			unset($data['id']);

			if(isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
                if(!empty($custom_fields)) {
                    foreach ($custom_fields as $cfkey => $cfvalue) {
                    	if(is_array($cfvalue)) {
                    		$custom_fields[$cfkey] = implode(',', $cfvalue);
                    		$cfvalue = implode(',', $cfvalue);
                    	}
                        $qr = "SELECT * FROM `cf_values` WHERE `rel_crud_id` = '".$this->input->post('id')."' AND `cf_id` = '".$cfkey."'";
                        $cf_data = $this->Ticket_model->getQrResult($qr);
                        if(is_array($cf_data) && !empty($cf_data)) {
                            $d = array(
                                        "value" => $custom_fields[$cf_data[0]->cf_id],
                                    );
                            $this->Ticket_model->updateRow('cf_values', 'cf_values_id', $cf_data[0]->cf_values_id, $d);
                        } else {
                            $d = array(
                                    "rel_crud_id" => $this->input->post('id'),
                                    "cf_id" => $cfkey,
                                    "curd" => 'ticket',
                                    "value" => $cfvalue,
                                );
                            $this->Ticket_model->insertRow('cf_values', $d);
                        }
                    }
                }
            }
			
			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue); 
				}
			}


			if ($data['repeat_every'] != '') {
                $data['recurring'] = 1;
                if ($data['repeat_every'] == 'custom') {
                    $data['repeat_every']     = $data['repeat_every_custom'];
                    $data['recurring_type']   = $data['repeat_type_custom'];
                    $data['custom_recurring'] = 1;
                } else {
                    $_temp                    = explode('-', $data['repeat_every']);
                    $data['recurring_type']   = $_temp[1];
                    $data['repeat_every']     = $_temp[0];
                    $data['custom_recurring'] = 0;
                }
            } else {
                $data['recurring'] = 0;
                $data['custom_recurring'] = 0;
            }

            if ($data['recurring_ends_on'] == '' || $data['recurring'] == 0) {
                $data['recurring_ends_on'] = NULL;
            } else {
                $data['recurring_ends_on'] = $data['recurring_ends_on'];
            }
            unset($data['repeat_type_custom']);
            unset($data['repeat_every_custom']);


			$this->Ticket_model->updateRow('ia_ticket', 'ticket_id', $this->input->post('id'), $data);
			$this->sendMailTicket($this->input->post('id'), $this->input->post('ticket_description'));
      		echo $this->input->post('id'); 
			exit;
		} else { 
			unset($data['submit']);
			unset($data['save']);
			$data['user_id']=$this->user_id;
			if(isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
            }
			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue); 
				}
			}


			if (isset($data['recurring_ends_on']) && $data['recurring_ends_on'] == '') {
			    unset($data['recurring_ends_on']);
			} else if (isset($data['recurring_ends_on']) && $data['recurring_ends_on'] != '') {
			    $data['recurring_ends_on'] = $data['recurring_ends_on'];
			}

			if (isset($data['repeat_every']) && $data['repeat_every'] != '') {
			    $data['recurring'] = 1;
			    if ($data['repeat_every'] == 'custom') {
			        $data['repeat_every']     = $data['repeat_every_custom'];
			        $data['recurring_type']   = $data['repeat_type_custom'];
			        $data['custom_recurring'] = 1;
			    } else {
			        $_temp                    = explode('-', $data['repeat_every']);
			        $data['recurring_type']   = $_temp[1];
			        $data['repeat_every']     = $_temp[0];
			        $data['custom_recurring'] = 0;
			    }
			} else {
			    $data['recurring'] = 0;
			}
			//$data['dateadded'] = date('Y-m-d H:i:s');
			unset($data['repeat_type_custom']);
			unset($data['repeat_every_custom']);

			$data['created'] = date('Y-m-d H:i:s');
			$last_id = $this->Ticket_model->insertRow('ia_ticket', $data);
			$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			if(!empty($custom_fields)) {
                foreach ($custom_fields as $cfkey => $cfvalue) {
                	if(is_array($cfvalue)) {
                		$cfvalue = implode(',', $cfvalue);
                	}
                    $d = array(
                                "rel_crud_id" => $last_id,
                                "cf_id" => $cfkey,
                                "curd" => 'ticket',
                                "value" => $cfvalue,
                            );
                    $this->Ticket_model->insertRow('cf_values', $d);
                }
            }
            $this->sendMailTicket($last_id, $this->input->post('ticket_description'));
            echo $last_id;
			exit;
			/*$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			redirect('ticket');*/
		}
	}

	public function sendMailTicket($tk_id, $comm = NULL) {
		$tk_data = $this->Ticket_model->getDataBy('ia_ticket', $tk_id, 'ticket_id');
		$u_id = $tk_data[0]->ticket_client;
		if($this->session->get_userdata()['user_details'][0]->ia_users_id == $u_id) {
			$u_id = $tk_data[0]->user_id;
		}
		if($comm == NULL) {
			$comm = $tk_data[0]->ticket_description;
		}
  		//$user_detail = $this->Ticket_model->get_email_tk($u_ud);
  		$user_detail = $this->Ticket_model->getDataBy('ia_users', $u_id, 'ia_users_id');
  		$this->load->model('User_model');
  		//print_r($user_detail); die;
  		if($user_detail[0]->email != '') {
	  		$setting = settings();
	  		$sub = "Ticket #".$tk_data[0]->ticket_id." - ".$tk_data[0]->ticket_ticket_title;
	       	$email = $user_detail[0]->email;
	       	$body = $this->User_model->getTemplate('comment'); 
	       	$body = $body->html;
	       	
	       	$tmpalet_var = array(
	       		"sender_name" => '', //$setting['company_name'], //'Expence Manager Ticket',
	       		"user_name" => $user_detail[0]->name,
	       		"ticket_name" => $tk_data[0]->ticket_ticket_title,
	       		"ticket_comment" => $comm,
	       		"ticket_view_link" => base_url().'ticket/view/'.$tk_id,
	       		"direct_link" => base_url().'ticket/view/'.$tk_id
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
	
	/**
      * This function is used to show popup for add and update
      */
	public function getModal() {
		if($this->input->post('id')){
			$data['data']= $this->Ticket_model->getDataId($this->input->post('id'));
      		
      		echo $this->load->view('add_update', $data, true);
	    } else {
	      	echo $this->load->view('add_update', '', true);
	    }
	    exit;
	}
	
	/**
      * This function is used to delete multiple records form table
      * @param : $ids is array if record id
      */
  	public function delete($ids) {
		$idsArr = explode('-', $ids);
		foreach ($idsArr as $key => $value) {
			$this->Ticket_model->deleteData($value);		
		}
		echo json_encode($idsArr); 
		exit;
		//redirect(base_url().'ticket', 'refresh');
  	}
  	/**
      * This function is used to delete single record form table
      * @param : $id is record id
      */
  	public function deleteData($id) { 
		$this->Ticket_model->deleteData($id);
		$art_msg['msg'] = lang('your_data_deleted_successfully'); 
		$art_msg['type'] = 'warning'; 
		$this->session->set_userdata('alert_msg', $art_msg);
	    redirect('ticket');
  	}
	/**
      * This function is used to create data for server side datatable
      */
  	public function ajxData(){
		$primaryKey = 'ticket_id';
		$table 		= 'ia_ticket';
		$joinQuery  =  "FROM ia_ticket LEFT JOIN  `ia_users` AS `users0` ON (`users0`.`ia_users_id` = `ia_ticket`.`ticket_client`)
";
	$columns = array();
	array_push($columns, array( 'db' => '`ia_ticket`.`ticket_id` AS `ticket_id`', 'dt' => count($columns), 'field' => 'ticket_id' 	 ));
    $cf = getCustomFields('ticket');
    if(is_array($cf) && !empty($cf)) {
        foreach ($cf as $cfkey => $cfvalue) {
            array_push($columns, array( 'db' => "cf_values_".$cfkey.".value AS cfv_".$cfkey, 'field' => "cfv_".$cfkey, 'dt' => count($columns) ));    
            $joinQuery  .=  " LEFT JOIN `cf_values` AS cf_values_".$cfkey."  ON  `ia_ticket`.`ticket_id` = `cf_values_".$cfkey."`.`rel_crud_id` AND `cf_values_".$cfkey."`.`cf_id` =  '".$cfvalue->custom_fields_id."' ";
        }
    }
	array_push($columns, array( 'db' => '`users0`.`name` AS `name`', 'dt' => count($columns), 'field' => 'name' ));
	array_push($columns, array( 'db' => '`ia_ticket`.`ticket_ticket_title` AS `ticket_ticket_title`', 'dt' => count($columns), 'field' => 'ticket_ticket_title' ));
	array_push($columns, array( 'db' => '`ia_ticket`.`ticket_ticket_type` AS `ticket_ticket_type`', 'dt' => count($columns), 'field' => 'ticket_ticket_type' ));
	array_push($columns, array( 'db' => '`ia_ticket`.`ticket_description` AS `ticket_description`', 'dt' => count($columns), 'field' => 'ticket_description' ));
	array_push($columns, array( 'db' => '`ia_ticket`.`ticket_status` AS `ticket_status`', 'dt' => count($columns), 'field' => 'ticket_status', 'formatter' => function($d, $row) {
				$clr = 'a49ae0';
				if($d == 'Open') {
					$clr = 'f77d73';
				} else if($d == 'Close') {
					$clr = '09974e';
				}
				return  '<span class="label" style="background-color:#'.$clr.' !important;">'.$d.'</span>';
				//return $d;
			} ));


			array_push($columns, array( 'db' => 'ia_ticket.ticket_id AS ticket_id', 'field' => 'ticket_id', 'dt' => count($columns), 'formatter' => function($d, $row){
				$t = '';

				if(CheckPermission('ticket', "all_update")){
				$t .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$d.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
				}else if(CheckPermission('ticket', "own_update") && (CheckPermission('ticket', "all_update")!=true)){
					$user_id =getRowByTableColomId('ticket',$d,'ticket_id');
					if($user_id->user_id==$this->user_id){
				$t .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$d.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
					}
				}

				$t .= '<a data-toggle="modal" href="'.base_url().'ticket/view/'.$d.'" class="mClass" style="cursor:pointer;" title="View Ticket"><i class="material-icons font-20">remove_red_eye</i></a>';

				if($row['ticket_upload_document'] != '') {
					$t .= '<img class="show-attach" width="25" title="Attachments" style="cursor:pointer; position:relative;top:-7px;" date-d="'.$row['ticket_upload_document'].'" src="'.iaBase().'assets/images/attach1.png">';
				}
				return $t;
			} ));
			array_push($columns, array( 'db' => '`ia_ticket`.`ticket_upload_document` AS `ticket_upload_document`', 'dt' => count($columns), 'field' => 'ticket_upload_document' ));   
		$where = '';
		$j = 0;
		if(strpos($joinQuery, 'JOIN') > 0) {
			$j = 1;
		}
		//print_r($_GET); die;
		$where = SSP::iaFilter( $_GET, $columns, $j);
		$where = SSP::column_ia_filter($_GET, $where);
		if($this->input->get('dateRange')) {
			$date = explode(' - ', $this->input->get('dateRange'));
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}
		
		if(CheckPermission($table, "all_read")){}
		else if(CheckPermission($table, "own_read") && CheckPermission($table, "all_read") != true){
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."`$table`.`user_id`=".$this->user_id." OR  ";
			$where .= "`$table`.`ticket_client`=".$this->user_id." ";
		}

	/*	if(isset($_SESSION['user_details'][0]->user_type) && $_SESSION['user_details'][0]->user_type != 'admin') {
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."`$table`.`ticket_client`=".$this->user_id." ";
		}
*/
		
		if(trim($where) == 'WHERE') {
			$where = '';
		}
		
		$group_by = "";
		$mka_hiving_va = "";
		if($mka_hiving_va != '') {
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."($mka_hiving_va)";
		}

		$limit = SSP::limit( $_GET, $columns );
		$order = SSP::iaOrder( $_GET, $columns, $j );
		$col   = SSP::pluck($columns, 'db', $j);
		if(trim($where) == 'WHERE' || trim($where) == 'WHERE ()') {
			$where = '';
		}
		//print_r($joinQuery); die;
		$query = "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." ".$joinQuery." ".$where." ".$group_by." ".$order." ".$limit." ";
		$query_without_limit = "SELECT count('*') AS c ".$joinQuery." ".$where." ";
		$res = $this->db->query($query);
		$res = $res->result_array();
		$recordsTotal = $this->db->query($query_without_limit)->row()->c;
		$res = SSP::data_output($columns, $res, $j);

		$output_arr['draw'] 			= intval( $_GET['draw'] );
		$output_arr['recordsTotal'] 	= intval( $recordsTotal );
		$output_arr['recordsFiltered'] 	= intval( $recordsTotal );
		$output_arr['data'] 			= $res;

		echo json_encode($output_arr);
  	}
  	/**
      * This function is used to filter list view data by date range
      */
  	public function getFilterdata(){
  		$where = '';
		if($this->input->post('dateRange')) {
			$date = explode(' - ', $this->input->post('dateRange'));
			$where = " DATE_FORMAT(`ticket`.`".$this->input->post('colName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`ticket`.`".$this->input->post('colName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}
		$data["view_data"]= $this->Ticket_model->getData($where);
		echo $this->load->view("tableData",$data, true);
		die;
  	}

  	public function setFilterCookie() {
  		if(!empty($this->input->post(strtolower('Ticket_filter')))) {
  			setcookie(strtolower('Ticket_filter'), json_encode($this->input->post(strtolower('Ticket_filter'))), time() + (86400 * 30 * 365), "/");
  		}
  	}


  	public function getGridInfoBoxVal() {
		$result = array();
  		if(is_array($this->input->get('request')) && !empty($this->input->get('request'))) {
  			foreach ($this->input->get('request') as $rkey => $rvalue) {
  				if(isset($rvalue['con_field']))
  				$con_field    	= json_decode(str_replace('@m@', '"', $rvalue['con_field']));
  				if(isset($rvalue['con_operator']))
  				$con_operator 	= json_decode(str_replace('@m@', '"', $rvalue['con_operator']));
  				if(isset($rvalue['con_value']))
  				$con_value    	= json_decode(str_replace('@m@', '"', $rvalue['con_value']));
  				if(isset($rvalue['relation']))
  				$relation    	= json_decode(str_replace('@m@', '"', $rvalue['relation']));
  				if(isset($rvalue['relation_table']))
  				$relation_table = json_decode(str_replace('@m@', '"', $rvalue['relation_table']));
  				if(isset($rvalue['relation_from']))
  				$relation_from  = json_decode(str_replace('@m@', '"', $rvalue['relation_from']));
  				if(isset($rvalue['relation_where']))
  				$relation_where = json_decode(str_replace('@m@', '"', $rvalue['relation_where']));
  				$where = '';
  				$join = '';

  				if(!CheckPermission($rvalue['table'], 'all_read') || !CheckPermission($rvalue['table'], 'all_update') || !CheckPermission($rvalue['table'], 'all_delete')) {
					$where = " `".$rvalue['table']."`.`user_id` = '".$this->session->get_userdata()['user_details'][0]->ia_users_id."' AND";
				}

  				if($con_field[0] != '') {
  					foreach ($con_field as $cfkey => $cfvalue) {
  						if(isset($relation[$cfkey]) && $relation[$cfkey] == 'yes') {
  							$join .= " JOIN `".$relation_table[$cfkey]."` ON `".$relation_table[$cfkey]."`.`".$relation_table[$cfkey]."_id` = `".$rvalue['table']."`.`".$relation_from[$cfkey]."` ";
  							$where .= " `".$relation_table[$cfkey]."`.`".$relation_where[$cfkey]."` ".get_operator($con_operator[$cfkey])." '".$con_value[$cfkey]."' AND";
  						} else {
  							$where .= " `".$rvalue['table']."`.`".$cfvalue."` ".get_operator($con_operator[$cfkey])." '".$con_value[$cfkey]."' AND";	
  						}
  					}
  				}

  				if(is_array($this->input->get('request_filter')) && !empty($this->input->get('request_filter'))) {
  					foreach ($this->input->get('request_filter') as $fkey => $fvalue) {
  						if($fvalue != 'all') {
	  						$fkey = explode('___', $fkey);
	  						if($fkey[2] == 'filter_date') {
	  							$date = explode(' - ', $fvalue);
	  							$where .= " DATE_FORMAT(`".$fkey[0]."`.`".$fkey[1]."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`".$fkey[0]."`.`".$fkey[1]."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' AND";
	  						} else {
	  							$where .= " `".$fkey[0]."`.`".$fkey[1]."` =  '".$fvalue."' AND";
	  						}
  						}
  					}
  				}

  				if(isset($_SESSION['user_details'][0]->user_type) && $_SESSION['user_details'][0]->user_type == 'Customer') {
					$where .= "`".$rvalue['table']."`.`ticket_client`= '".$this->user_id."' AND";
  				}

  				if(strpos($where, ' AND') > 0) {
  					$where = substr_replace($where, '', -3);
  				}


  				if($where != '') {
  					$where = 'WHERE '.$where;
  				}
  				if($rvalue['action'] == 'count') {
  					$qr = "SELECT count(*) AS 'mka_num' FROM `".$rvalue['table']."` ".$join." ".$where." ";
  				} else if($rvalue['action'] == 'sum') {
  					$qr = "SELECT SUM(`".$rvalue['sum_field']."`) AS 'mka_num' FROM `".$rvalue['table']."` ".$join." ".$where." ";
  				}

				$res = $this->Ticket_model->getQrResult($qr);
				$result[$rvalue['return_id']] = 0;
				if($res[0]->mka_num != '') {
					$result[$rvalue['return_id']] = $res[0]->mka_num;
				}
  			}
  		}
  		echo json_encode($result);
  		exit;
  	}



  	public function recurring() {
  		/*error_reporting(E_ALL);
  		ini_set('display_errors', 1);*/
        $modules = array(
                        'recurring_expenses' => 'ia_ticket',
                        /*'recurring_income' => 'income'*/
                    );
        foreach ($modules as $table) {
        $recurring_expenses = $this->Ticket_model->getDataBy($table, 1, 'recurring');
        $_renewals_ids_data = array();
        $total_renewed      = 0;
        foreach ($recurring_expenses as $expense) {
        	$expense = (array) $expense;
            if (!is_null($expense['recurring_ends_on'])) {
                if (date('Y-m-d') > date('Y-m-d', strtotime($expense['recurring_ends_on']))) {
                    continue;
                }
            }

            if($expense['ticket_status'] == 'Close') {
            	continue;
            }
			//$table_date          = 'created';
			$type                = $expense['recurring_type'];
			$repeat_every        = $expense['repeat_every'];
			$last_recurring_date = $expense['last_recurring_date'];
			$expense_date        = $expense['created'];
			$date                = new DateTime(date('Y-m-d'));
            // Check if is first recurring
            if (!$last_recurring_date) {
                $last_recurring_date = date('Y-m-d', strtotime($expense_date));
            } else {
                $last_recurring_date = date('Y-m-d', strtotime($last_recurring_date));
            }
            $calculated_date_difference = date('Y-m-d', strtotime('+' . $repeat_every . ' ' . strtoupper($type), strtotime($last_recurring_date)));
            
            if (date('Y-m-d') >= $calculated_date_difference) {

            	$tk_data = $this->Ticket_model->getDataBy('ticket', $expense['ticket_id'], 'ticket_id');
				$u_id = $tk_data[0]->ticket_client;
				if($this->session->get_userdata()['user_details'][0]->ia_users_id == $u_id) {
					$u_id = $tk_data[0]->user_id;
				}
		  		//$user_detail = $this->Ticket_model->get_email_tk($u_ud);
		  		$user_detail = $this->Ticket_model->getDataBy('ia_users', $u_id, 'ia_users_id');
		  		$this->load->model('user/User_model');
		  		if($user_detail[0]->email != '') {
			  		$setting = settings();
			  		$sub = "Ticket #".$tk_data[0]->ticket_id." - ".$tk_data[0]->ticket_ticket_title;
			       	$email = $user_detail[0]->email;
			       	$body = $this->User_model->get_template('ticket_recurring'); 
			       	$body = $body->html;
			       	
			       	$tmpalet_var = array(
							"sender_name"      => '', //$setting['company_name'], //'Expence Manager Ticket',
							"user_name"        => $user_detail[0]->name,
							"ticket_name"      => $tk_data[0]->ticket_ticket_title,
							"ticket_comment"   => '',
							"ticket_view_link" => base_url().'ticket/view/'.$expense['ticket_id'],
							"direct_link"      => base_url().'ticket/view/'.$expense['ticket_id']
			       	);
			       	foreach ($tmpalet_var as $tvkey => $tvvalue) {
		                $body = str_replace('{var_'.$tvkey.'}', $tvvalue, $body);
		            }
			  		if($setting['mail_setting'] == 'php_mailer') {
			            $this->load->library("send_mail");         
			            $emm = $this->send_mail->email($sub, $body, $email, $setting);
			            $this->Ticket_model->updateRow('ticket', 'ticket_id', $expense['ticket_id'], array('last_recurring_date' => date('Y-m-d')));
			        } else {
			            // content-type is required when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= 'From: '.$setting['EMAIL'] . "\r\n";
			            $emm = mail($email,$sub,$body,$headers);
			        }
		  		}


                // Ok we can repeat the expense now
                /*$new_expense_data = array();
                $expense_fields   = $this->db->list_fields($table);
        		$table_id = $table.'_id';
                foreach ($expense_fields as $field) {
                    if (isset($expense[$field])) {
                        // We dont need the invoiceid field
                        if ($field != $table_id && $field != 'recurring_from') {
                            $new_expense_data[$field] = $expense[$field];
                        }
                    }
                }*/

				//$new_expense_data['dateadded']           = date('Y-m-d H:i:s');
				/*$new_expense_data[$table_date]           = date('Y-m-d');
				$new_expense_data['recurring_from']      = $expense[$table_id];
				$new_expense_data['recurring_type']      = NULL;
				$new_expense_data['repeat_every']        = 0;
				$new_expense_data['recurring']           = 0;
				$new_expense_data['recurring_ends_on']   = NULL;
				$new_expense_data['custom_recurring']    = 0;
				$new_expense_data['last_recurring_date'] = NULL;*/

        
          		//print_r($new_expense_data);die;
                /*$this->db->insert($table, $new_expense_data);
                $insert_id = $this->db->insert_id();
                if ($insert_id) {
                    $total_renewed++;
                    $this->db->where($table_id, $expense[$table_id]);
                    $this->db->update($table, array(
                        'last_recurring_date' => date('Y-m-d')
                    ));          
        		}*/
    		}
		}
		}  		
 	}
}
?>