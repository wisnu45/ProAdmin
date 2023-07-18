<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events_model extends CI_Model {       
	function __construct(){
	$this->table = 'ia_events';
    parent::__construct($this->table);    
    $this->load->database();
	$this->user_id =isset($this->session->get_userdata()['user_details'][0]->users_id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
    $this->user_type =isset($this->session->get_userdata()['user_details'][0]->user_type)?$this->session->get_userdata()['user_details'][0]->user_type:'';

	} 
	
	function getDetails($options = array()) {
        $events_table = $this->db->dbprefix('ia_events');
        $users_table = $this->db->dbprefix('ia_users');

        $where = "";

        if (array_key_exists("id", $options)) {
            $id = $options["id"];
        }else{
            $id = '';
        }
        if ($id) {
            $where .= " AND $events_table.id=$id";
        }

        if (array_key_exists("start_date", $options)) {
            $start_date = $options["start_date"];
        }else{
            $start_date = '';
        }
        if ($start_date) {
            $where .= " AND DATE($events_table.start_date)>='$start_date'";
        }

        if (array_key_exists("end_date", $options)) {
            $end_date = $options["end_date"];
        }else{
            $end_date = '';
        }
        if ($end_date) {
            $where .= " AND DATE($events_table.end_date)<='$end_date'";
        }

        if (array_key_exists("user_id", $options)) {
            $user_id = $options["user_id"];
        }else{
            $user_id = '';
        }
        if ($this->user_type!="admin") {
            if(CheckPermission('events', "all_read")){
            }
            else if(CheckPermission('events', "own_read")){
                if ($user_id) {
                    //searh for user and teams
                    $where .= " AND ($events_table.created_by=$user_id 
                OR $events_table.share_with='all' 
                    OR (FIND_IN_SET('member:$user_id', $events_table.share_with))
                        )";
                }
            } else {
                $where .= " AND ($events_table.share_with='all' 
                    OR (FIND_IN_SET('member:$user_id', $events_table.share_with))
                        )";
            }
        }
         
        


        if (array_key_exists("limit", $options)) {
            $limit = $options["limit"];
        }else{
            $limit = '';
        }
        $limit = $limit ? $limit : "20000";

        if (array_key_exists("offset", $options)) {
            $offset = $options["offset"];
        }else{
            $offset = '';
        }
        $offset = $offset ? $offset : "0";

        $sql = "SELECT $events_table.*,
            $users_table.name AS created_by_name, $users_table.profile_pic AS created_by_avatar FROM $events_table
        LEFT JOIN $users_table ON $users_table.ia_users_id = $events_table.created_by 
        WHERE $events_table.deleted=0 $where
        ORDER BY $events_table.start_date ASC
        LIMIT $offset, $limit";
        return $this->db->query($sql);
    }

    function getOne($id = 0) {
        return $this->getOneWhere(array('id' => $id));
    }

    function getOneWhere($where = array()) {
        $result = $this->db->get_where($this->table, $where, 1);
        if ($result->num_rows()) {
            return $result->row();
        } else {
            $db_fields = $this->db->list_fields($this->table);
            $fields = new stdClass();
            foreach ($db_fields as $field) {
                $fields->$field = "";
            }
            return $fields;
        }
    }

    function countEventsToday($user_id = 0) {
        $events_table = $this->db->dbprefix($this->table);
        $now = get_my_local_time("Y-m-d");
        $sql = "SELECT COUNT($events_table.id) AS total
        FROM $events_table
        WHERE $events_table.deleted=0 AND $events_table.created_by = $user_id AND ($events_table.start_date='$now' OR $events_table.end_date='$now')";
        return $this->db->query($sql)->row()->total;
    }

    function getLabelSuggestions() {
        $events_table = $this->db->dbprefix($this->table);
        $sql = "SELECT GROUP_CONCAT(labels) AS label_groups
        FROM $events_table
        WHERE $events_table.deleted=0";
        return $this->db->query($sql)->row()->label_groups;
    }

    function save(&$data = array(), $id = 0) {
        if ($id) {
            //update
            $where = array("id" => $id);            
            $success = $this->updateWhere($data, $where);
            return $success;
        } else {
            //insert
            if ($this->db->insert($this->table, $data)) {
                $insert_id = $this->db->insert_id();
                return $insert_id;
            }
        }
    }

    function updateWhere($data = array(), $where = array()) {
        if (count($where)) {
            if ($this->db->update($this->table, $data, $where)) {
                $id = $where["id"];
                if ($id) {
                    return $id;
                } else {
                    return true;
                }
            }
        }
    }

    function delete($id = 0) {
        $data = array('deleted' => 1);
        $this->db->where("id", $id);
        $success = $this->db->update($this->table, $data);
        return $success;
    }
}?>