<?php

/**
 * Author: Amirul Momenin
 * Desc:Users_unavailability Model
 */
class Users_unavailability_model extends CI_Model
{
	protected $users_unavailability = 'users_unavailability';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get users_unavailability by id
	 *@param $id - primary key to get record
	 *
     */
    function get_users_unavailability($id){
        $result = $this->db->get_where('users_unavailability',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('users_unavailability');
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
	
    /** Get all users_unavailability
	 *
     */
    function get_all_users_unavailability(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('users_unavailability')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users_unavailability
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_unavailability($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('users_unavailability')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users_unavailability rows
	 *
     */
	function get_count_users_unavailability(){
       $result = $this->db->from("users_unavailability")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-users_unavailability
	 *
     */
    function get_all_users_users_unavailability(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_unavailability')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-users_unavailability
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_users_unavailability($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_unavailability')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-users_unavailability rows
	 *
     */
	function get_count_users_users_unavailability(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("users_unavailability")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new users_unavailability
	 *@param $params - data set to add record
	 *
     */
    function add_users_unavailability($params){
        $this->db->insert('users_unavailability',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update users_unavailability
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_users_unavailability($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('users_unavailability',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete users_unavailability
	 *@param $id - primary key to delete record
	 *
     */
    function delete_users_unavailability($id){
        $status = $this->db->delete('users_unavailability',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
