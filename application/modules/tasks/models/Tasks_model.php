<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_model extends CI_Model {       
	function __construct(){            
    parent::__construct();
    $this->load->database();
		$this->user_id =isset($this->session->get_userdata()['user_details'][0]->users_id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
	} 
	
	/**
      * This function is get table data by id
      * @param : $id is value of ticket_id
      */
	public function getDataId($id='') {
		 $this->db->select('*');
		 $this->db->from('tasks');
		 $this->db->where('id' , $id);
		 $query = $this->db->get();
		
		 return $result = $query->row();
	}
	
	/**
      * This function is get data for front end datatable
      * @param : $con is where condition for select query
      */
	public function getData($con=NULL) {
		if(CheckPermission('ticket', "own_read") && CheckPermission('ticket', "all_read")!=true){
			if($con != '') {
				$con .= " AND "; 
			}
			$con .= "  (`tasks`.`user_id` = '".$this->user_id."') ";
		}
		$sql = "SELECT *, `users0`.name as users_name FROM  `tasks` LEFT JOIN `ia_users` AS `users0` ON (`users0`.`ia_users_id` = `tasks`.`assigned_to`)";
		if($con != '') {
			$sql .= ' WHERE '.$con;	
		}
		$qr = $this->db->query($sql);
		
		return $qr->result();
	}

	public function getTaskItems($finished, $page = '')
    {
        $this->db->select();
        $this->db->from('tasks');
        $this->db->where('status', $finished);
        // if ($page != '' && $this->input->post('todo_page')) {
        //     $position = ($page * 10);
        //     $this->db->limit(10, $position);
        // } else {
        //     $this->db->limit(10);
        // }
        $tasks = $this->db->get()->result_array();
        // format date
        $i     = 0;
        foreach ($tasks as $task) {
            $tasks[$i]['start_date']    = $task['start_date'];
            $tasks[$i]['deadline'] = $task['deadline'];
            $tasks[$i]['title']  = $task['title'];
            $i++;
        }
        return $tasks;
    }

    public function changeTaskStatus($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->where('assigned_to', $this->user_id);
        $date = date('Y-m-d H:i:s');
        $this->db->update('tasks', array(
            'status' => $status,
            'deadline' => $date
        ));
        if ($this->db->affected_rows() > 0) {
            return array(
                'success' => true
            );
        }
        return array(
            'success' => false
        );
    }

    public function updateTaskItemsOrder($data)
    {
        for ($i = 0; $i < count($data['data']); $i++) {
            $update = array(
                'item_order' => $data['data'][$i][1],
                'status' => $data['data'][$i][2]
            );
            $this->db->where('id', $data['data'][$i][0]);
            $this->db->update('tasks', $update);
        }
    }

	/**
      * This function is used to delete record from table
      * @param : $id record id which you want to delete
      */

	/**
      * This function is used to Insert Record in table
      * @param : $table - table name in which you want to insert record 
      * @param : $data - record array 
      */
	public function insertRow($table, $data){
	  	$this->db->insert($table, $data);
	  	$last_id = $this->db->insert_id();
	  	$r = $this->db->select("*")
					  ->from($table)
					  ->where('id',$last_id)
					  ->get()
					  ->result();
	  	return $r;
	}

	public function deleteData($id='') {
		$this->db->where('id', $id);
    	$this->db->delete('tasks');
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
		$r = $this->db->select("*")
					  ->from($table)
					  ->where('id',$colVal)
					  ->get()
					  ->result();
		return $r;
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
						  ->from('ia_ticket')
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

   
}?>