<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Timeline_model extends CI_Model {       
	function __construct(){            
    parent::__construct();
    $this->load->database();
		$this->user_id = isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:'0';
		$this->user_type = isset($this->session->get_userdata()['user_details'][0]->user_type)?$this->session->get_userdata()['user_details'][0]->user_type:'';
	} 

	/**
      * This function is used to delete record from table
      * @param : $id record id which you want to delete
      */
	public function deleteData($id='') {
		$this->db->where('daily_log_id', $id);
    	$this->db->delete('daily_log');
	}

	/**
      * This function is used to Insert Record in table
      * @param : $table - table name in which you want to insert record 
      * @param : $data - record array 
      */
	public function insertRow($table, $data){
	  	$this->db->insert($table, $data);
	  	return  $this->db->insert_id();
	}

	/**
      * This function is used to Update Record in table
      * @param : $table - table name in which you want to update record 
      * @param : $col - field name for where clause 
      * @param : $colVal - field value for where clause 
      * @param : $data - updated array 
      */
  	public function updateRow($table, $col, $colVal, $data) {
  		$this->db->where($col,$colVal);
		$this->db->update($table,$data);
		return true;
  	}


  	public function getQrResult($qr) {
  		$exe = $this->db->query($qr);
  		return $exe->result();
  	}


   /**
     * This function is used to select data form table  
     */
	function getDataBy($tableName='', $value='', $colum='') {	
		if( (!empty($value)) && (!empty($colum)) ) { 
			$this->db->where($colum, $value);
		}
		$this->db->select('*');
		$this->db->from($tableName);
		$query = $this->db->get();
		return $query->result();
  	}



  	public function getPosts($offset = 0 , $limit = 10) {

  		$where = '';
  		if($this->user_type != 'admin') {
  			$per = $this->getDataBy('ia_permission', $this->user_type, 'user_type');
  			if(isset($per[0]->id)){
  				$where = " AND (`p`.`share_with` = '".$per[0]->id."' OR `p`.`share_with` = '0' )";
  			}
  		}
      if(!CheckPermission("timeline", "all_read")){
        $where = " AND `p`.`created_by` = '".$this->user_id."'";
      }

  		$qry = "SELECT `p`.*, `u`.`name` AS `user_name`, `u`.`profile_pic` AS `profile_pic`, `pr`.`user_type`  FROM `ia_posts` AS `p` LEFT JOIN `ia_users` AS `u` ON `p`.`created_by` = `u`.`ia_users_id` LEFT JOIN `ia_permission` AS `pr` ON `p`.`share_with` = `pr`.`id` WHERE `p`.`deleted` = '0' ".$where." ORDER BY `created_at` DESC LIMIT ".$offset.", ".$limit." ";
  		return $this->getQrResult($qry);
  	}


  	public function commentCount($pid) {
  		$result = 0;
  		$qry = "SELECT count('*') AS `mka_count` FROM `ia_post_comments` WHERE `post_id` = '".$pid."'";
  		$res = $this->getQrResult($qry);
  		if(isset($res[0]->mka_count)) {
  			$result = $res[0]->mka_count;
  		}
  		return $result;
  	}

    public function setReadPost($post_id) {
      $this->db->where('user_id', $this->user_id);
      $this->db->where('post_id', $post_id);
      $this->db->delete('ia_post_notification');
    }
}?>