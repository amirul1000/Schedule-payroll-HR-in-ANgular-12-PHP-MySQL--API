<?php

/**
 * Author: Amirul Momenin
 * Desc:Users_leave Model
 */
class Users_leave_apply_model extends CI_Model
{
	protected $users_leave_apply = 'users_leave_apply';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get users_leave_apply by id
	 *@param $id - primary key to get record
	 *
     */
    function get_users_leave_apply($id){
        $result = $this->db->get_where('users_leave_apply',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('users_leave_apply');
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
	
    /** Get all users_leave_apply
	 *
     */
    function get_all_users_leave_apply(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('users_leave_apply')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users_leave_apply
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_leave_apply($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('users_leave_apply')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users_leave_apply rows
	 *
     */
	function get_count_users_leave_apply(){
       $result = $this->db->from("users_leave_apply")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-users_leave_apply
	 *
     */
    function get_all_users_users_leave_apply(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_leave_apply')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-users_leave_apply
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_users_leave_apply($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_leave_apply')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-users_leave_apply rows
	 *
     */
	function get_count_users_users_leave_apply(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("users_leave_apply")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new users_leave_apply
	 *@param $params - data set to add record
	 *
     */
    function add_users_leave_apply($params){
        $this->db->insert('users_leave_apply',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update users_leave_apply
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_users_leave_apply($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('users_leave_apply',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete users_leave_apply
	 *@param $id - primary key to delete record
	 *
     */
    function delete_users_leave_apply($id){
        $status = $this->db->delete('users_leave_apply',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
