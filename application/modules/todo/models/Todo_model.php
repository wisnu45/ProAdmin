<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Todo_model extends CI_Model
{
    public $todo_limit;
    function __construct()
    {
        parent::__construct();
        $limit            = 10;
        $limit            = 10;//do_action('todos_limit', $limit);
        $this->todo_limit = $limit;
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:'1';
        $this->user_type = isset($this->session->get_userdata()['user_details'][0]->user_type) ? $this->session->get_userdata()['user_details'][0]->user_type : '';
    }
    public function get($id = '')
    {
        if ($this->user_type=="admin") {
            $this->db->where('todo_id', $id);
            return $this->db->get('ia_todo')->row();
        }
        else {
            $this->db->where('user_id', $this->user_id);
            $this->db->where('todo_id', $id);
            return $this->db->get('ia_todo')->row();
        }
        

        // return $this->db->get('ia_todo')->result_array();
    }
    public function getUserType($id = '')
    {

        if (is_numeric($id)) {
            $this->db->where('todo_id', $id);
            $results = $this->db->get('ia_todo')->row();
            $userId = $results->user_id;
            $this->db->where('ia_users_id', $userId);
            return $this->db->get('ia_users')->row();
        }
    }
    /**
     * Get all user todos
     * @param  boolean $finished is finished todos or not
     * @param  mixed $page     pagination limit page
     * @return array
     */
    public function getTodoItems($finished, $page = '')
    {
        $this->db->select();
        $this->db->from('ia_todo');
        $this->db->where('finished', $finished);
        $this->db->order_by('item_order', 'asc');
        if ($page != '' && $this->input->post('todo_page')) {
            $position = ($page * $this->todo_limit);
            $this->db->limit($this->todo_limit, $position);
        } else {
            $this->db->limit($this->todo_limit);
        }
        $todos = $this->db->get()->result_array();
        // format date
        $i     = 0;
        foreach ($todos as $todo) {
            $todos[$i]['dateadded']    = $todo['dateadded'];
            $todos[$i]['datefinished'] = $todo['datefinished'];
            $todos[$i]['description']  = $todo['description'];
            $i++;
        }
        return $todos;
    }
    public function getUserTodoItems($finished, $page = '')
    {
        $this->db->select();
        $this->db->from('ia_todo');
        $this->db->where('finished', $finished);
        $this->db->where('user_id', $this->user_id);
        $this->db->order_by('item_order', 'asc');
        if ($page != '' && $this->input->post('todo_page')) {
            $position = ($page * $this->todo_limit);
            $this->db->limit($this->todo_limit, $position);
        } else {
            $this->db->limit($this->todo_limit);
        }
        $todos = $this->db->get()->result_array();
        // format date
        $i     = 0;
        foreach ($todos as $todo) {
            $todos[$i]['dateadded']    = $todo['dateadded'];
            $todos[$i]['datefinished'] = $todo['datefinished'];
            $todos[$i]['description']  = $todo['description'];
            $i++;
        }
        return $todos;
    }
    /**
     * Add new user todo
     * @param mixed $data todo $_POST data
     */
    public function add($data)
    {
        $data['dateadded']   = date('Y-m-d H:i:s');
        $data['description'] = nl2br($data['description']);
        $data['user_id']     = $this->user_id;
        $this->db->insert('ia_todo', $data);
        return $this->db->insert_id();
    }
    public function update($id, $data)
    {

        $data['description'] = nl2br($data['description']);

        $this->db->where('todo_id', $id);
        $this->db->update('ia_todo', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return false;
    }
    /**
     * Update todo's order / Ajax - Sortable
     * @param  mixed $data todo $_POST data
     */
    public function updateTodoItemsOrder($data)
    {
        for ($i = 0; $i < count($data['data']); $i++) {
            $update = array(
                'item_order' => $data['data'][$i][1],
                'finished' => $data['data'][$i][2]
            );
            if ($data['data'][$i][2] == 1) {
                $update['datefinished'] = date('Y-m-d H:i:s');
            }
            $this->db->where('todo_id', $data['data'][$i][0]);
            $this->db->update('ia_todo', $update);
        }
    }
    /**
     * Delete todo
     * @param  mixed $id todo id
     * @return boolean
     */
    public function deleteTodoItem($id)
    {
        $this->db->where('todo_id', $id);
        $this->db->delete('ia_todo');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
    public function deleteUserTodoItem($id)
    {
        $this->db->where('todo_id', $id);
        $this->db->where('user_id', $this->user_id);
        $this->db->delete('ia_todo');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
    /**
     * Change todo status / finished or not finished
     * @param  mixed $id     todo id
     * @param  integer $status can be passed 1 or 0
     * @return array
     */
    public function changeTodoStatus($id, $status)
    {
        $this->db->where('todo_id', $id);
        $this->db->where('user_id', $this->user_id);
        $date = date('Y-m-d H:i:s');
        $this->db->update('ia_todo', array(
            'finished' => $status,
            'datefinished' => $date
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


    public function checkEnableStatus() {
        return $this->db->where('name', 'todo')
                 ->where('status', 1)
                 ->get('ia_extension')->result();
    }
}
