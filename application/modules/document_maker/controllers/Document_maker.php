<?php defined("BASEPATH") OR exit("No direct script access allowed");
class Document_maker extends CI_Controller {
  	function __construct() {
	    parent::__construct();
	    $this->load->model("Document_maker_model"); 
	    $this->lang->load(strtolower('Document_maker'), $this->session->userdata('site_lang'));
		if($this->uri->segment(2) != 'form') {
			isLogin(); 
		}
			$this->user_id =isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:'1';

		$this->checkEnableStatus();
		
  	}

  	 public function checkEnableStatus()
    {
        $res = checkEnableStatus('document_maker');
        if (empty($res)) {
            $art_msg['msg'] = lang('extension_is_not_activate');
            $art_msg['type'] = 'warning';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url());
        }
    }
  	


  	/**
      * This function is used to view page
      */
  	public function index() {   
  		if(CheckPermission("document_maker", "all_read,own_read")){
  			
  			$con = '';
  			
			$data["view_data"] = $this->Document_maker_model->getData($con);
			
			if($con == '') {
				echo $this->load->view("include/header");				
			}
			$data["obj"] = $this;
			$this->load->view("index",$data);
			
			if($con == '') {
				$this->load->view("include/footer");
			}
		} else {
  			die('in else ');

			die('hello');
			$art_msg['msg'] = lang('you_do_not_have_permission_to_access'); 
			$art_msg['type'] = 'warning'; 
			$this->session->set_userdata('alert_msg', $art_msg);
            redirect( base_url().'user/profile', 'refresh');
		}
  	}


  	public function getFilterHtml($ajax = 0) {
  		$filter_coo = '';
  		if(isset($_COOKIE[strtolower('Document_maker_filter')])) {
  			$filter_coo = json_decode($_COOKIE[strtolower('Document_maker_filter')]);
  		}
  		$html = '			<div class="col-md-3">
				<div class="form-group form-float">
					<div class="form-line">';
			$html .='<select name="ia_document_maker___document_maker_titlea___filter" class="filter-field form-control">';
				$html .='<option value="all">'.lang('all').'</option>';
	$sel = ''; if(isset($filter_coo->ia_document_maker___document_maker_titlea___filter)) { $sel = $filter_coo->ia_document_maker___document_maker_titlea___filter; }	$html .= $this->getFilterDropdownOptions('document_maker_titlea', '', '', ''.$sel.'');
		$html .= '</select>
						<label class="form-label" style="margin-top: -10px;">'.lang('titlea').'</label>
					</div>
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group form-float">
					<div class="form-line">';
			$html .='<select name="ia_document_maker___document_maker_status___filter" class="filter-field form-control">';
				$html .='<option value="all">'.lang('all').'</option>';
 $se = ''; if(isset($filter_coo->ia_document_maker___document_maker_status___filter) && $filter_coo->ia_document_maker___document_maker_status___filter == 'Active') { $se = 'selected'; }	$html .='<option '.$se.' value="Active">'.lang('active').'</option>';
 $se = ''; if(isset($filter_coo->ia_document_maker___document_maker_status___filter) && $filter_coo->ia_document_maker___document_maker_status___filter == 'Inactive') { $se = 'selected'; }	$html .='<option '.$se.' value="Inactive">'.lang('inactive').'</option>';
		$html .= '</select>
						<label class="form-label" style="margin-top: -10px;">'.lang('status').'</label>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group form-float">
					<div class="form-line">';
			$html .='<select name="ia_document_maker___document_maker_public___filter" class="filter-field form-control">';
				$html .='<option value="all">'.lang('all').'</option>';
 $se = ''; if(isset($filter_coo->ia_document_maker___document_maker_public___filter) && $filter_coo->ia_document_maker___document_maker_public___filter == 'Yes') { $se = 'selected'; }	
 						$html .='<option '.$se.' value="Yes">'.lang('Yes').'</option>';
					 	$html .='<option '.$se.' value="No">'.lang('No').'</option>';
		$html .= '</select>
						<label class="form-label" style="margin-top: -10px;">'.lang('public').'</label>
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
  		$res = $this->Document_maker_model->getFilterDropdownOptions($field, $rel_table, $rel_col);
  		$option = '';
  		if(isset($res) && is_array($res) && !empty($res)) {
  			foreach ($res as $key => $value) {
  				if($rel_table != '') {
  					$col = $rel_table.'_id';
  					$se = '';
  					if($selected == $value->$col) {
  						$se = 'selected';
  					}
  					$option .= '<option '.$se.' value="'.$value->$col.'">'.substr(ucfirst($value->$rel_col), 30).'</option>';	
  				} else {
  					$se = '';
  					if($selected == $value->$field) {
  						$se = 'selected';
  					}
  					$option .= '<option '.$se.' value="'.$value->$field.'">'.substr(ucfirst($value->$field), 30).'</option>';
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
		foreach ($_FILES as $fkey => $fvalue) {
			foreach($fvalue['name'] as $key => $fileInfo) {
				if(!empty($_FILES[$fkey]['name'][$key])){
					$filename=$_FILES[$fkey]['name'][$key];
					$tmpname=$_FILES[$fkey]['tmp_name'][$key]; 
					$exp=explode('.', $filename);
					$ext=end($exp);
					$newname=  $exp[0].'_'.time().".".$ext; 
					$config['upload_path'] = 'assets/images/';
					$config['upload_url'] =  base_url().'assets/images/';
					$config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
					$config['max_size'] = '2000000'; 
					$config['file_name'] = $newname;
					$this->load->library('upload', $config);
					//move_uploaded_file($tmpname,"assets/images/".$newname);

					$_FILES['mka_file']['name']     = $_FILES[$fkey]['name'][$key];
					$_FILES['mka_file']['type']     = $_FILES[$fkey]['type'][$key];
					$_FILES['mka_file']['tmp_name'] = $_FILES[$fkey]['tmp_name'][$key];
					$_FILES['mka_file']['error']    = $_FILES[$fkey]['error'][$key];
					$_FILES['mka_file']['size']     = $_FILES[$fkey]['size'][$key];
					if ( $this->upload->do_upload('mka_file')) {
						$newfiles[$fkey][]=$newname;
			        }
				}
				else{
					$newfiles[$fkey]='';
			
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
				$all_files = $newfiles[$fkey];
			}
			if(is_array($all_files) && !empty($all_files)) {
				$data[$fkey] = implode(',', $all_files);
			}
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
                        $qr = "SELECT * FROM `ia_custom_fields_values` WHERE `rel_crud_id` = '".$this->input->post('id')."' AND `cf_id` = '".$cfkey."'";
                        $cf_data = $this->Document_maker_model->getQrResult($qr);
                        if(is_array($cf_data) && !empty($cf_data)) {
                            $d = array(
                                        "value" => $custom_fields[$cf_data[0]->cf_id],
                                    );
                            $this->Document_maker_model->updateRow('ia_custom_fields_values', 'ia_custom_fields_values_id', $cf_data[0]->ia_custom_fields_values_id, $d);
                        } else {
                            $d = array(
                                    "rel_crud_id" => $this->input->post('id'),
                                    "cf_id" => $cfkey,
                                    "curd" => 'document_maker',
                                    "value" => $cfvalue,
                                );
                            $this->Document_maker_model->insertRow('ia_custom_fields_values', $d);
                        }
                    }
                }
            }
			
			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue); 
				}
			}
			$this->Document_maker_model->updateRow('ia_document_maker', 'document_maker_id', $this->input->post('id'), $data);
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

			$user = $this->Document_maker_model->getDataBy('ia_users', $this->user_id, 'ia_users_id');
			$data['user_email'] = $user[0]->email;
			$last_id = $this->Document_maker_model->insertRow('ia_document_maker', $data);
			if(!empty($custom_fields)) {
                foreach ($custom_fields as $cfkey => $cfvalue) {
                	if(is_array($cfvalue)) {
                		$cfvalue = implode(',', $cfvalue);
                	}
                    $d = array(
                                "rel_crud_id" => $last_id,
                                "cf_id" => $cfkey,
                                "curd" => 'document_maker',
                                "value" => $cfvalue,
                            );
                    $this->Document_maker_model->insertRow('ia_custom_fields_values', $d);
                }
            }
            echo $last_id;
			exit;
			/*$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			redirect('document_maker');*/
		}
	}
	
	/**
      * This function is used to show popup for add and update
      */
	public function getModal() {
		if($this->input->post('id')){
			$data['data']= $this->Document_maker_model->getDataId($this->input->post('id'));
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
			$this->Document_maker_model->deleteData($value);		
		}
		echo json_encode($idsArr); 
		exit;
		//redirect(base_url().'document_maker', 'refresh');
  	}
  	/**
      * This function is used to delete single record form table
      * @param : $id is record id
      */
  	public function deleteData($id) { 
		$this->Document_maker_model->deleteData($id);
		$art_msg['msg'] = lang('your_data_deleted_successfully'); 
		$art_msg['type'] = 'warning'; 
		$this->session->set_userdata('alert_msg', $art_msg);
	    redirect('document_maker');
  	}
	/**
      * This function is used to create data for server side datatable
      */
  	public function ajxData(){
		$primaryKey = 'document_maker_id';
		$table 		= 'ia_document_maker';
		$moduleName 		= 'document_maker';
		$joinQuery  =   "FROM `ia_document_maker` ";

		$qry = $this->db->query("SELECT * FROM ia_document_maker WHERE user_id = ".$this->user_id."");
		$sql = $qry->result_array();
		// print_r($sql);die();
		$columns 	= array(
array( 'db' => 'ia_document_maker.document_maker_id AS document_maker_id', 'field' => 'document_maker_id', 'dt' => 0, 'formatter' => function($m) {
	return '<input type="checkbox" name="selData" id="mka_'.$m.'" value="'.$m.'">
					<label for="mka_'.$m.'"></label>';
} ),
array( 'db' => 'ia_document_maker.document_maker_titlea AS document_maker_titlea', 'field' => 'document_maker_titlea', 'dt' => 1, 'formatter' => function($m, $row) {
	if(CheckPermission('document_maker', "all_update")){
		return "<a href='".base_url()."document_maker/formBuider/".$row['document_maker_id']."' id='formBuilder_".$row['document_maker_id']."' data-src='".$row['document_maker_id']."' title='".lang('formBuilder')."'>".$m."</a>";
	}else if(CheckPermission('document_maker', "own_update")){
		$user_id = $this->db->query("SELECT * FROM ia_document_maker WHERE document_maker_id = ".$row['document_maker_id']."")->result_array();
		foreach ($user_id as $values) {
			if($values['user_id']==$this->user_id){
				return "<a href='".base_url()."document_maker/formBuider/".$row['document_maker_id']."' id='formBuilder_".$row['document_maker_id']."' data-src='".$row['document_maker_id']."' title='".lang('formBuilder')."'>".$m."</a>";
			} else {
				return $m;
			}
		}
	}
} ),
array( 'db' => 'ia_document_maker.document_maker_public AS document_maker_public', 'field' => 'document_maker_public', 'dt' => 2, "formatter" => function($m, $row) {
	if($m == 'Yes') {
		return "<a href='".base_url()."document_maker/form/".$row['document_maker_id']."' id='formBuilder_view_".$row['document_maker_id']."' data-src='".$row['document_maker_id']."' title='".lang('formBuilderView')."' target=\"_BLANK\">".$m." &nbsp;<i class='glyphicon glyphicon-eye-open'></i></a>";
	} else {
		return $m;
	}
} ),
array( 'db' => 'ia_document_maker.document_maker_status AS document_maker_status', 'field' => 'document_maker_status', 'dt' => 3 ),
);

			
	        $cf = getCustomFields('document_maker');

	        if(is_array($cf) && !empty($cf)) {
	            foreach ($cf as $cfkey => $cfvalue) {
	                array_push($columns, array( 'db' => "ia_custom_fields_values_".$cfkey.".value AS cfv_".$cfkey, 'field' => "cfv_".$cfkey, 'dt' => count($columns) ));    
	                $joinQuery  .=  " LEFT JOIN `ia_custom_fields_values` AS ia_custom_fields_values_".$cfkey."  ON  `ia_document_maker`.`document_maker_id` = `ia_custom_fields_values_".$cfkey."`.`rel_crud_id` AND `ia_custom_fields_values_".$cfkey."`.`cf_id` =  '".$cfvalue->custom_fields_id."' ";
	            }
	        }
			array_push($columns, array( 'db' => 'ia_document_maker.document_maker_id AS document_maker_id', 'field' => 'document_maker_id', 'dt' => count($columns) ));
		$where = '';
		$j = 0;
		if(strpos($joinQuery, 'JOIN') > 0) {
			$j = 1;
		}
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
		else if(CheckPermission($table, "own_read") && CheckPermission($table, "all_read")!=true){
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."`$table`.`user_id`=".$this->user_id." ";
		}

		

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
		$col = SSP::pluck($columns, 'db', $j);
		if(trim($where) == 'WHERE' || trim($where) == 'WHERE ()') {
			$where = '';
		}
		$query = "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." ".$joinQuery." ".$where." ".$group_by." ".$order." ".$limit." ";
		// print_r($query);die();
		$res = $this->db->query($query);
		$res = $res->result_array();
		$recordsTotal = $this->db->select("count('ia_document_maker') AS c")->get('ia_document_maker')->row()->c;

		$res = SSP::iaDataOutput($columns, $res, $j);

		$output_arr['draw'] 			= intval( $_GET['draw'] );
		$output_arr['recordsTotal'] 	= intval( $recordsTotal );
		$output_arr['recordsFiltered'] 	= intval( $recordsTotal );
		$output_arr['data'] 			= $res;
		//$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where, $group_by, $having);

		foreach ($output_arr['data'] as $key => $value) 
		{
			/*$output_arr['data'][$key][0] = '
					<input type="checkbox" name="selData" id="mka_'.$key.'" value="'.$output_arr['data'][$key][0].'">
					<label for="mka_'.$key.'"></label>';*/
				
			$key_id = @array_pop(array_keys($output_arr['data'][$key]));
			
			
			$id = $output_arr['data'][$key][$key_id];
			
			$titleView = $output_arr['data'][$key][1];
			//$publicView = $output_arr['data'][$key][2];
			$baseUrlForm = base_url()."document_maker/formBuider/$id";
			$baseUrlView = base_url()."document_maker/form/$id";
			
			//$output_arr['data'][$key][2] ='';
			$output_arr['data'][$key][$key_id] = '';

			/*$output_arr['data'][$key][2] .= "<a href='$baseUrlView' id='formBuilder_view_$id' data-src='$id' title='".lang('formBuilderView')."'>".$publicView." &nbsp;<i class='glyphicon glyphicon-eye-open'></i></a>";*/
			
			
			if(CheckPermission($moduleName, "all_update")){
			$output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
			}else if(CheckPermission($moduleName, "own_update")){
				$user_id =$this->db->select('*')->from($table)->where($moduleName."_id", $id)->get()->row();
				if($user_id->user_id==$this->user_id){
			$output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
				}
			}
			
			if(CheckPermission($moduleName, "all_delete")){
			$output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setId('.$id.', \'document_maker\')"><i class="material-icons col-red font-20">delete</i></a>';}
			else if(CheckPermission($moduleName, "own_delete")){
				$user_id =$this->db->select('*')->from($table)->where($moduleName."_id", $id)->get()->row();
				if($user_id->user_id==$this->user_id){
			$output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setId('.$id.', \'document_maker\')"><i class="material-icons col-red font-20">delete</i></a>';
				}
			}


			$output_arr['data'][$key][$key_id] .= '<a href="'.base_url().'document_maker/formdata/'.$id.'" class="mClass" style="cursor:pointer;" title="'.lang('show_data').'" ><i class="material-icons col-green font-20">remove_red_eye</i></a>';
			
		}
		echo json_encode($output_arr);
  	}
  	/**
      * This function is used to filter list view data by date range
      */
  	public function getFilterdata(){
  		$where = '';
		if($this->input->post('dateRange')) {
			$date = explode(' - ', $this->input->post('dateRange'));
			$where = " DATE_FORMAT(`document_maker`.`".$this->input->post('colName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`document_maker`.`".$this->input->post('colName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}
		$data["view_data"]= $this->Document_maker_model->getData($where);
		echo $this->load->view("tableData",$data, true);
		die;
  	}

  	public function setFilterCookie() {
  		if(!empty($this->input->post(strtolower('Document_maker_filter')))) {
  			setcookie(strtolower('Document_maker_filter'), json_encode($this->input->post(strtolower('Document_maker_filter'))), time() + (86400 * 30 * 365), "/");
  		}
  	}


  	/*public function getGridInfoBoxVal() {
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
				$res = $this->Document_maker_model->getQrResult($qr);
				$result[$rvalue['return_id']] = 0;
				if($res[0]->mka_num != '') {
					$result[$rvalue['return_id']] = $res[0]->mka_num;
				}
  			}
  		}
  		echo json_encode($result);
  		exit;
  	}*/
	
	
	
	function formBuider($id='')
	{
  		if(CheckPermission("document_maker", "all_read,own_read")){
			$con = '';
			$data['form_id']=$id;
			$data["view_data"]= $this->Document_maker_model->getDataFormField($id);
			$data["form_data"]= $this->Document_maker_model->getDataId($id);
			$this->load->view("include/header");
			$data["obj"] = $this;
			$this->load->view("formBuider",$data);
			$this->load->view("include/footer");
		} else {
			$art_msg['msg'] = lang('you_do_not_have_permission_to_access'); 
			$art_msg['type'] = 'warning'; 
			$this->session->set_userdata('alert_msg', $art_msg);
            redirect( base_url().'user/profile', 'refresh');
		}
	}
	
	/**
      * This function is used to show popup for add and update
      */
	public function getModalField() {
		$data['formBuider_id']=$this->input->post('formBuider_id');
		if($this->input->post('formBuider_id') && !empty($this->input->post('id'))){
			$data['field_type_id']=$this->input->post('id');
			$data['data']= $this->Document_maker_model->GetFieldDataId($this->input->post('id'));
      		echo $this->load->view('add_updateField', $data, true);
	    } else {
	      	echo $this->load->view('add_updateField', $data, true);
	    }
	    exit;
	}
	
	public function addEditField() {	
		//$data = $this->input->post();
		$formBuider_id = !empty($_POST['formBuider_id'])?$_POST['formBuider_id']:'';
		$data = array(
				'formBuider_id'=>!empty($_POST['formBuider_id'])?$_POST['formBuider_id']:'',
				'title'=>!empty($_POST['title'])?$_POST['title']:'',
				'placeholder'=>!empty($_POST['placeholder'])?$_POST['placeholder']:'',
				'field_type'=>!empty($_POST['field_type'])?$_POST['field_type']:'',
				'options'=>!empty($_POST['options'])?$_POST['options']:'',
				'required'=>!empty($_POST['required'])?$_POST['required']:'',
		);
		
		if($this->input->post('id')) {
			$this->Document_maker_model->updateRow('ia_document_makerfield_type', 'field_type_id', $this->input->post('id'), $data);
			echo '1';
			exit;
			/*$art_msg['msg'] = 'Your data Update Successfully..'; 
			$art_msg['type'] = 'success'; 
			$this->session->set_userdata('alert_msg', $art_msg);
            redirect( base_url()."document_maker/formBuider/$formBuider_id", 'refresh');*/
		} else { 
			
			$last_id = $this->Document_maker_model->insertRow('ia_document_makerfield_type', $data);
			echo '1';
			exit;
			/*$art_msg['msg'] = 'Your data inserted Successfully..'; 
			$art_msg['type'] = 'success'; 
			$this->session->set_userdata('alert_msg', $art_msg);
            redirect( base_url()."document_maker/formBuider/$formBuider_id", 'refresh');*/
		}
	}

/*	public function preview($id) {
		$fData = $this->Document_maker_model->getDataBy('document_maker', $id, 'document_maker_id');
		if($fData[0]->document_maker_status == 'Active') {
			$data["view_data"]= $this->Document_maker_model->getDataFormField($id);
			$data['doc_id'] = $id;
			$this->load->view("include/header");
			$this->load->view("formPreview",$data);
			$this->load->view("include/footer");
		} else {
			die('Form Not Activate...');			
		}
	}*/

	public function form($id) {
		$fData = $this->Document_maker_model->getDataBy('ia_document_maker', $id, 'document_maker_id');
		if($fData[0]->document_maker_status == 'Active') {		
			$data["view_data"]= $this->Document_maker_model->getDataFormField($id);			
			$data['doc_id'] = $id;
			$data['public'] = TRUE;
			$this->load->view("include/public_header", $data);
			$this->load->view("formPreview");
			$this->load->view("include/public_footer");
		} else {
			$data["view_data"]= $this->Document_maker_model->getDataFormField($id);			
			$data['doc_id'] = $id;
			$data['public'] = TRUE;
			$this->load->view("include/public_header", $data);
			echo "<p style='margin-top: 100px;text-align: center;'>Form Not Activate...</p>";
			$this->load->view("include/public_footer");
			// die('Form Not Activate...');
		}
	}

	public function requestDoc() {
		$post_arr = $this->input->post();
		$fData = $this->Document_maker_model->getDataBy('ia_document_maker', $this->input->post('document_id'), 'document_maker_id');

		

		$template = $fData[0]->document_template;
		$regex = '#{(.*?)}#';


		preg_match_all($regex,$template,$aMatch);
		if(isset($aMatch[0]) && is_array($aMatch[0]) && !empty($aMatch[0])) {
			foreach ($aMatch[0] as $mkey => $mvalue) {
				$template = str_replace($mvalue, strtolower($mvalue), $template);
			}
		}
		
		$fields = $this->Document_maker_model->getDataFormField($this->input->post('document_id'));
		foreach ($fields as $fkey => $fvalue) {
			$t = str_replace(' ', '_', $fvalue->title);
			if($this->input->post($t)) {
				$v = $this->input->post($t);
				if(is_array($v)) {
					$v = implode(',', $v);
				}
				$template = str_replace('{'.strtolower($t).'}', $v, $template);
			}
		}
		
		if(isset($template) && $template != '') {
			$pdf_file = $this->generatePdf($template);
			$user_detail = $this->Document_maker_model->getDataBy('ia_users', $fData[0]->user_id, 'ia_users_id');
			$this->load->model('user/User_model');
			//$doc_setting = $this->get_settings();
			$body = $this->User_model->get_template('document_maker');
			$emails = array();
			if(isset($fData[0]->user_email) && $fData[0]->user_email != '') {
				$emails = explode(',', $fData[0]->user_email);
			} else {
				$emails[] = $user_detail[0]->email;
			}

			$dta = array(
				"email" => $emails, //$user_detail[0]->email,
				"body" => $body->html
			);

			$this->sendDocumentMail($pdf_file, $dta);
		}

		$inst = array();
		unset($post_arr['document_id']);
		$inst[] = $post_arr;
		if($fData[0]->document_data != '') {
			$old_rows = json_decode($fData[0]->document_data);
			array_push($old_rows, $inst[0]);
			$inst = $old_rows;
		}

		$inst_data = array(
			"document_data" => json_encode($inst)
		);
		$this->Document_maker_model->updateRow('ia_document_maker', 'document_maker_id', $this->input->post('document_id'), $inst_data );



		$art_msg['msg'] = 'Your request successfully submitted.'; 
		$art_msg['type'] = 'success'; 
		$this->session->set_userdata('alert_msg', $art_msg);
		redirect(base_url().'document_maker/form/'.$this->input->post('document_id'));

	}

	public function saveTemplate() {
		$data = array(
			'document_template' => $this->input->post('template'),
			'user_email' => $this->input->post('user_email')
		);
		$this->Document_maker_model->updateRow('document_maker', 'document_maker_id', $this->input->post('form_id'), $data );
		echo 1;
		exit;
	}

	public function sendDocumentMail($pdf, $data) {
		$setting = settings();
		$sub = "Document";
		$email = isset($data['email']) ? $data['email'] : '';
		$body = isset($data['body']) ? $data['body'] : '';

		if($setting['mail_setting'] == 'php_mailer') {
            $this->load->library("send_mail");         
            $emm = $this->send_mail->emailwith_attechment($sub, $body, $email, $setting, $pdf);
        } else {
            // content-type is required when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: '.$setting['EMAIL'] . "\r\n";
            $emm = mail($email,$sub,$body,$headers);
        }
	}

	public function generatePdf($template) {
		$this->load->library('Mypdf');
		$this->dompdf->load_html($template);
        $this->dompdf->set_paper("A4", "portrait");
        $this->dompdf->render();
       
        // Adding page number and invoice id
        $canvas = $this->dompdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(40, 780, "Page Number: {PAGE_NUM}", $font, 10, array(0,0,0));
        
        $filename = "Document-".strtotime("now").".pdf";
        $path = realpath(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/assets/images/pdf/';
        file_put_contents($path.$filename, $this->dompdf->output());
        return $path.$filename;
	}

	public function formData($id) {
		$fData = $this->Document_maker_model->getDataBy('ia_document_maker', $id, 'document_maker_id');
		/*$data["view_data"]= $this->Document_maker_model->getDataFormField($id);*/
		$fdata = $fData[0]->document_data;
		$fdata = json_decode($fdata);
		$data['form_data'] = $fdata;
		$this->load->view("include/header",$data);
		$this->load->view("formData");
		$this->load->view("include/footer");
	}

	public function delFormField($id) {
		$this->Document_maker_model->delFormField($id);


		$art_msg['msg'] = 'Field deleted successfully'; 
		$art_msg['type'] = 'success'; 
		$this->session->set_userdata('alert_msg', $art_msg);
		redirect($_SERVER['HTTP_REFERER']);

	}

/*	public function doc_setting() {
		$data['setting'] = $this->get_settings();
		$this->load->view("include/header", $data);
		$this->load->view("setting");
		$this->load->view("include/footer");
	}*/

/*	public function get_settings() {
		$setting = $this->Document_maker_model->getDataBy('document_settings', '', '');
		$res = array();
		foreach ($setting as $key => $value) {
			$res[$value->key] = $value->value;
		}

		return $res;
	}*/



/*	public function setting_save() {
		if($this->input->post()) {
			foreach ($this->input->post() as $key => $value) {
				$this->Document_maker_model->updateRow('document_settings', 'key', $key, array('value' => $value));		
			}
		}
		$art_msg['msg'] = 'Setting updated successfully'; 
		$art_msg['type'] = 'success'; 
		$this->session->set_userdata('alert_msg', $art_msg);
		redirect($_SERVER['HTTP_REFERER']);
	}*/
}
?>