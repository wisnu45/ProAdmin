<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Todo extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('todo/todo_model');
        $this->lang->load('todo', $this->session->userdata('site_lang'));
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->ia_users_id) ? $this->session->get_userdata()['user_details'][0]->ia_users_id : '1';
        $this->user_type = isset($this->session->get_userdata()['user_details'][0]->user_type) ? $this->session->get_userdata()['user_details'][0]->user_type : '';
        $this->checkEnableStatus();
    }
    /* Get all staff todo items */
    public function index()
    {
        if ($this->input->is_ajax_request()) {
            // echo $this->user_type;die();
            if ($this->user_type == "admin") {
                echo json_encode($this->todo_model->getTodoItems($this->input->post('finished'), $this->input->post('todo_page')));
                exit;
            }
            else {
                if (CheckPermission("todo", "all_read")) {
                    echo json_encode($this->todo_model->getTodoItems($this->input->post('finished'), $this->input->post('todo_page')));
                    exit;
                }
                else {
                    echo json_encode($this->todo_model->getUserTodoItems($this->input->post('finished'), $this->input->post('todo_page')));
                    exit;
                }
            }
            
        }
        $data['bodyclass'] = 'main_todo_page';
        $data['total_pages_finished'] = ceil($this->totalRows('ia_todo', array(
            'finished' => 1,
            'user_id' => $this->user_id,
        )) / $this->todo_model->todo_limit);
        $data['total_pages_unfinished'] = ceil($this->totalRows('ia_todo', array(
            'finished' => 0,
            'user_id' => $this->user_id,
        )) / $this->todo_model->todo_limit);
        $data['title'] = lang('my_todos');
        $this->load->view("include/header");
        $this->load->view('all', $data);
        $this->load->view("include/footer");
    }

    public function checkEnableStatus()
    {
        $res = checkEnableStatus('todo');
        if (empty($res)) {
            $art_msg['msg'] = lang('extension_is_not_activate');
            $art_msg['type'] = 'warning';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url());
        }
    }

    /* Add new todo item */
    public function todo()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($data['todo_id'] == '') {
                unset($data['todo_id']);
                $id = $this->todo_model->add($data);
                if ($id) {
                    $this->getById($id);
                    /*$art_msg['msg'] = lang('added_successfuly');
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);*/
                }
            } else {
                $id = $data['todo_id'];
                unset($data['todo_id']);
                $success = $this->todo_model->update($id, $data);
                if ($success) {
                    $this->getById($id);
                    /*$art_msg['msg'] = lang('updated_successfuly');
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);*/
                }
            }

            //redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function getById($id)
    {
        $todo = $this->todo_model->get($id);
        // $todo->description = $todo->description;
        echo json_encode($todo);
    }

    public function getUserType($id)
    {
        $todo = $this->todo_model->getUserType($id);
        // $todo->description = $todo->description;
        echo json_encode($todo->user_type);
    }
    /* Change todo status */
    public function changeTodoStatus($id, $status)
    {
        $success = $this->todo_model->changeTodoStatus($id, $status);
        $res = 0;
        if ($success) {
            $res = 1;
           
        }
        echo $res;
        exit;
        //redirect($_SERVER['HTTP_REFERER']);
    }
    /* Update todo order / ajax */
    public function updateTodoItemsOrder()
    {
        if ($this->input->post()) {
            $this->todo_model->updateTodoItemsOrder($this->input->post());
        }
    }
    /* Delete todo item from databse */
    public function deleteTodoItem($id)
    {
        if ($this->input->is_ajax_request()) {
            if ($this->user_type == "admin") {
                echo json_encode(array(
                    'success' => $this->todo_model->deleteTodoItem($id),
                ));
            }
            else {
                echo json_encode(array(
                    'success' => $this->todo_model->deleteUserTodoItem($id),
                ));
            }
        }
        die();
    }

    /**
     * Count total rows on table based on params
     * @param  string $table Table from where to count
     * @param  array  $where
     * @return mixed  Total rows
     */
    public function totalRows($table, $where = array())
    {
        if (is_array($where)) {
            if (sizeof($where) > 0) {
                $this->db->where($where);
            }
        } else if (strlen($where) > 0) {
            $this->db->where($where);
        }
        return $this->db->count_all_results($table);
    }
}
