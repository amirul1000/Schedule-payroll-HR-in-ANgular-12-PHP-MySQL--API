<?php

/**
 * Author: Amirul Momenin
 * Desc:Users_training Model
 */
class Users_training_model extends CI_Model
{
	protected $users_training = 'users_training';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get users_training by id
	 *@param $id - primary key to get record
	 *
     */
    function get_users_training($id){
        $result = $this->db->get_where('users_training',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('users_training');
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
	
    /** Get all users_training
	 *
     */
    function get_all_users_training(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('users_training')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users_training
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_training($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('users_training')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users_training rows
	 *
     */
	function get_count_users_training(){
       $result = $this->db->from("users_training")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-users_training
	 *
     */
    function get_all_users_users_training(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_training')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-users_training
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_users_training($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_training')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-users_training rows
	 *
     */
	function get_count_users_users_training(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("users_training")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new users_training
	 *@param $params - data set to add record
	 *
     */
    function add_users_training($params){
        $this->db->insert('users_training',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update users_training
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_users_training($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('users_training',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete users_training
	 *@param $id - primary key to delete record
	 *
     */
    function delete_users_training($id){
        $status = $this->db->delete('users_training',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
