<?php

/**
 * Author: Amirul Momenin
 * Desc:Users_leave Model
 */
class Users_leave_model extends CI_Model
{
	protected $users_leave = 'users_leave';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get users_leave by id
	 *@param $id - primary key to get record
	 *
     */
    function get_users_leave($id){
        $result = $this->db->get_where('users_leave',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('users_leave');
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
	
    /** Get all users_leave
	 *
     */
    function get_all_users_leave(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('users_leave')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users_leave
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_leave($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('users_leave')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users_leave rows
	 *
     */
	function get_count_users_leave(){
       $result = $this->db->from("users_leave")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-users_leave
	 *
     */
    function get_all_users_users_leave(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_leave')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-users_leave
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_users_leave($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_leave')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-users_leave rows
	 *
     */
	function get_count_users_users_leave(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("users_leave")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new users_leave
	 *@param $params - data set to add record
	 *
     */
    function add_users_leave($params){
        $this->db->insert('users_leave',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update users_leave
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_users_leave($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('users_leave',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete users_leave
	 *@param $id - primary key to delete record
	 *
     */
    function delete_users_leave($id){
        $status = $this->db->delete('users_leave',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
