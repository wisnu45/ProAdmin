<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_model extends CI_Model {       
	function __construct(){            
    parent::__construct();
    $this->load->database();
		$this->user_id =isset($this->session->get_userdata()['user_details'][0]->users_id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
	} 
	
	/**
      * This function is get table data by id
      * @param : $id is value of customers_id
      */
	public function Get_data_id($id='') {
		 $this->db->select('*');
		 $this->db->from('customers');
		 $this->db->where('customers_id' , $id);
		 $query = $this->db->get();
		 return $result = $query->row();
	}
	
	/**
      * This function is get data for front end datatable
      * @param : $con is where condition for select query
      */
	public function get_data($con=NULL) {
		if(CheckPermission('customers', "own_read") && CheckPermission('customers', "all_read")!=true){
			if($con != '') {
				$con .= " AND "; 
			}
			$con .= "  (`customers`.`user_id` = '".$this->user_id."') ";
		}
		$sql = "SELECT * FROM  `customers` ";
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
	public function delete_data($id='') {
		$this->db->where('customers_id', $id);
    	$this->db->delete('customers');
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

  	public function get_filter_dropdown_options($fild, $rel_table, $rel_col) {
  		if($rel_table != '') {
  			$r = $this->db->select($rel_table.'_id')
  					  ->select($rel_col)	
					  ->from($rel_table)
					  ->get()
					  ->result();
		} else {
	  		$r = $this->db->select($fild)
						  ->from('customers')
						  ->group_by($fild)
						  ->get()
						  ->result();
		} 
		return $r;
  	}


   /**
     * This function is used to select data form table  
     */
	function get_data_by($tableName='', $value='', $colum='',$condition='') {	
		if( (!empty($value)) && (!empty($colum)) ) { 
			$this->db->where($colum, $value);
		}
		$this->db->select('*');
		$this->db->from($tableName);
		$query = $this->db->get();
		return $query->result();
  	}
}?>