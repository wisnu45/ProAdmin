<?php

class Messages_model extends CI_Model {

    private $table = null;

    function __construct() {
        $this->table = 'ia_messages';
        parent::__construct($this->table);
    }


        /*function __construct(){            
        parent::__construct();
        $this->load->database();
            $this->user_id =isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:'1';
        } */

    /*
     * prepare details info of a message
     */

    function getDetails($options = array()) {
        $messages_table = $this->db->dbprefix('ia_messages');
        $users_table = $this->db->dbprefix('ia_users');

        $mode = get_array_value($options, "mode");

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $messages_table.id=$id";
        }

        $message_id = get_array_value($options, "message_id");
        if ($message_id) {
            $where .= " AND $messages_table.message_id=$message_id";
        }

        $user_id = get_array_value($options, "user_id");
        $join_with = "$messages_table.from_user_id";
        if ($user_id && $mode === "inbox") {
            $where .= " AND $messages_table.message_id=0  AND ($messages_table.from_user_id=$user_id OR $messages_table.to_user_id=$user_id) ";
        } else if ($user_id && $mode === "sent_items") {
            $where .= " AND $messages_table.message_id=0  AND ($messages_table.from_user_id=$user_id OR $messages_table.to_user_id=$user_id)";
            $join_with = "$messages_table.to_user_id";
        }

        $sql = "SELECT 0 AS reply_message_id, $messages_table.*, CONCAT($users_table.name) AS user_name, $users_table.profile_pic AS user_image
        FROM $messages_table
        LEFT JOIN $users_table ON $users_table.ia_users_id=$join_with
        WHERE $messages_table.deleted=0 $where
        ORDER BY $messages_table.id ASC";

        return $this->db->query($sql);
    }


        /**
          * This function is get table data by id
          * @param : $id is value of expenses_id
          */
        public function getUsers() {
             $this->db->select('*');
             $this->db->from('ia_users');
             $this->db->where('ia_users_id !=' , $this->user_id);
             $query = $this->db->get();
             return $result = $query->result();
        }

    /*
     * prepare inbox/sent items list
     */

    function getList($options = array()) {
        $messages_table = $this->db->dbprefix('ia_messages');
        $users_table = $this->db->dbprefix('ia_users');

        $mode = get_array_value($options, "mode");
        $user_id = get_array_value($options, "user_id");

        if ($user_id && $mode === "inbox") {
            $where_user = "to_user_id";
            $select_user = "from_user_id";
        } else if ($user_id && $mode === "sent_items") {
            $where_user = "from_user_id";
            $select_user = "to_user_id";
        }

        //ignor sql mode here 
        try {
            $this->db->query("SET sql_mode = ''");
        } catch (Exception $e) {
            
        }

        $sql = "SELECT y.*, $messages_table.status, $messages_table.created_at, $messages_table.files,
                CONCAT($users_table.name) AS user_name, $users_table.profile_pic AS user_image
                FROM (
                    SELECT max(x.id) as id, main_message_id,  subject, IF(subject='', (SELECT subject FROM $messages_table WHERE id=main_message_id) ,'') as reply_subject, $select_user
                        FROM (SELECT id, IF(message_id=0,id,message_id) as main_message_id, subject, $select_user 
                                FROM $messages_table
                              WHERE deleted=0 AND $where_user=$user_id  AND FIND_IN_SET($user_id, $messages_table.deleted_by_users) = 0) x
                    GROUP BY main_message_id) y
                LEFT JOIN $users_table ON $users_table.ia_users_id= y.$select_user
                LEFT JOIN $messages_table ON $messages_table.id= y.id";
        return $this->db->query($sql);
    }

    /* prepare notifications of new message */

    function getNotifications($user_id, $last_message_checke_at = "0") {
        $messages_table = $this->db->dbprefix('messages');
        $users_table = $this->db->dbprefix('users');

        $sql = "SELECT $messages_table.id, $messages_table.message_id, $messages_table.created_at, CONCAT($users_table.first_name, ' ', $users_table.last_name) AS user_name, $users_table.image AS user_image
        FROM $messages_table
        LEFT JOIN $users_table ON $users_table.id=$messages_table.from_user_id
        WHERE $messages_table.deleted=0 AND $messages_table.status='unread'  AND $messages_table.to_user_id = $user_id
        AND timestamp($messages_table.created_at)>timestamp('$last_message_checke_at')
        ORDER BY timestamp($messages_table.created_at) DESC";
        return $this->db->query($sql);
    }

    /* update message ustats */

    function setMessageStatusAsRead($message_id, $user_id = 0) {
        $messages_table = $this->db->dbprefix('ia_messages');
        $sql = "UPDATE $messages_table SET status='read' WHERE $messages_table.to_user_id=$user_id AND ($messages_table.message_id=$message_id OR $messages_table.id=$message_id)";
        return $this->db->query($sql);
    }

    function countUnreadMessage($user_id = 0) {
        $messages_table = $this->db->dbprefix('messages');

        $sql = "SELECT COUNT($messages_table.id) as total
        FROM $messages_table
        WHERE $messages_table.deleted=0 AND $messages_table.status='unread'  AND $messages_table.to_user_id = $user_id";
        return $this->db->query($sql)->row()->total;
    }

    function deleteMessagesForUser($message_id = 0, $user_id = 0) {
        $messages_table = $this->db->dbprefix('messages');

        $sql = "UPDATE $messages_table SET $messages_table.deleted_by_users = CONCAT($messages_table.deleted_by_users,',',$user_id)
        WHERE $messages_table.id=$message_id OR $messages_table.message_id=$message_id";
        return $this->db->query($sql);
    }

    function clearDeletedStatus($message_id = 0) {
        $messages_table = $this->db->dbprefix('ia_messages');

        $sql = "UPDATE $messages_table SET $messages_table.deleted_by_users = ''
        WHERE $messages_table.id=$message_id OR $messages_table.message_id=$message_id";
        return $this->db->query($sql);
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


        function save(&$data = array(), $id = 0) {
            if ($id) {
                //return $success;
                return $success;

            } else {
                //insert
                if ($this->db->insert($this->table, $data)) {
                    $insert_id = $this->db->insert_id();
                    return $insert_id;
                }
            }
        }

}
