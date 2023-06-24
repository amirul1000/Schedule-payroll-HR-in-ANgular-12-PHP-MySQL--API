<?php

/**
 * Author: Amirul Momenin
 * Desc:Task Model
 */
class Task_model extends CI_Model
{
	protected $task = 'task';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get task by id
	 *@param $id - primary key to get record
	 *
     */
    function get_task($id){
        $result = $this->db->get_where('task',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('task');
			foreach ($fields as $field)
			{
			   $result[$field] = ''; 	  
			}
		}
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all task
	 *
     */
    function get_all_task(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('task')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit task
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_task($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('task')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count task rows
	 *
     */
	function get_count_task(){
       $result = $this->db->from("task")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-task
	 *
     */
    function get_all_users_task(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('task')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-task
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_task($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('task')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-task rows
	 *
     */
	function get_count_users_task(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("task")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new task
	 *@param $params - data set to add record
	 *
     */
    function add_task($params){
        $this->db->insert('task',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update task
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_task($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('task',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete task
	 *@param $id - primary key to delete record
	 *
     */
    function delete_task($id){
        $status = $this->db->delete('task',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
