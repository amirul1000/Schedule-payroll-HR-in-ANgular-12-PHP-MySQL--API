<?php

/**
 * Author: Amirul Momenin
 * Desc:Users_location Model
 */
class Users_location_model extends CI_Model
{
	protected $users_location = 'users_location';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get users_location by id
	 *@param $id - primary key to get record
	 *
     */
    function get_users_location($id){
        $result = $this->db->get_where('users_location',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('users_location');
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
	
    /** Get all users_location
	 *
     */
    function get_all_users_location(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('users_location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users_location
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_location($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('users_location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users_location rows
	 *
     */
	function get_count_users_location(){
       $result = $this->db->from("users_location")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-users_location
	 *
     */
    function get_all_users_users_location(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-users_location
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_users_location($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-users_location rows
	 *
     */
	function get_count_users_users_location(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("users_location")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new users_location
	 *@param $params - data set to add record
	 *
     */
    function add_users_location($params){
        $this->db->insert('users_location',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update users_location
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_users_location($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('users_location',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete users_location
	 *@param $id - primary key to delete record
	 *
     */
    function delete_users_location($id){
        $status = $this->db->delete('users_location',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
