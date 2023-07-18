<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Projects_model extends CI_Model {       
	function __construct(){            
    parent::__construct();
    $this->load->database();
		$this->user_id =isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:'1';
	} 
	
	/**
      * This function is get table data by id
      * @param : $id is value of document_maker_id
      */
	public function getDataId($id='') {
		 $this->db->select('*');
		 $this->db->from('projects');
		 $this->db->where('id' , $id);
		 $query = $this->db->get();
		 return $result = $query->row();
	}
	
	/**
      * This function is get data for front end datatable
      * @param : $con is where condition for select query
      */
	public function getData($con=NULL) {
		if(CheckPermission('ia_document_maker', "own_read") && CheckPermission('ia_document_maker', "all_read")!=true){
			if($con != '') {
				$con .= " AND "; 
			}
			$con .= "  (`projects`.`created_by` = '".$this->user_id."') ";
		}
		$sql = "SELECT * FROM  `projects` ";
		if($con != '') {
			$sql .= ' WHERE '.$con;	
		}
		$qr = $this->db->query($sql);
		return $qr->result();
	}

	/**
      * This function is used to delete record from table
      * @param : $id record id which you want to delete
      */
	public function deleteData($id='') {
		$this->db->where('document_maker_id', $id);
    	$this->db->delete('ia_document_maker');
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

  	public function getFilterDropdownOptions($fild, $rel_table, $rel_col) {
  		if($rel_table != '') {
  			$r = $this->db->select($rel_table.'_id')
  					  ->select($rel_col)	
					  ->from($rel_table)
					  ->get()
					  ->result();
		} else {
	  		$r = $this->db->select($fild)
						  ->from('projects')
						  ->group_by($fild)
						  ->get()
						  ->result();
		} 
		return $r;
  	}


   /**
     * This function is used to select data form table  
     */
	function getDataBy($tableName='', $value='', $colum='',$condition='') {	
		if( (!empty($value)) && (!empty($colum)) ) { 
			$this->db->where($colum, $value);
		}
		$this->db->select('*');
		$this->db->from($tableName);
		$query = $this->db->get();
		return $query->result();
  	}
	
	/**
      * This function is get table data by id
      * @param : $id is value of document_maker_id
      */
	public function GetFieldDataId($id='') {
		 $this->db->select('*');
		 $this->db->from('ia_document_makerfield_type');
		 $this->db->where('field_type_id' , $id);
		 $query = $this->db->get();
		 return $result = $query->row();
	}
	public function getDataFormField($id='') {
		 $this->db->select('*');
		 $this->db->from('ia_document_makerfield_type');
		 $this->db->where('formBuider_id' , $id);
		 $query = $this->db->get();
		 return $result = $query->result();
	}

	public function delFormField($id) {
		$this->db->where('field_type_id', $id);
    	$this->db->delete('ia_document_makerfield_type');
	}
}?>