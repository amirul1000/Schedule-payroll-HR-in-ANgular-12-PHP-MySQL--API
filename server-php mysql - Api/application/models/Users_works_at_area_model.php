<?php

/**
 * Author: Amirul Momenin
 * Desc:Users_works_at_area Model
 */
class Users_works_at_area_model extends CI_Model
{
	protected $users_works_at_area = 'users_works_at_area';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get users_works_at_area by id
	 *@param $id - primary key to get record
	 *
     */
    function get_users_works_at_area($id){
        $result = $this->db->get_where('users_works_at_area',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('users_works_at_area');
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
	
    /** Get all users_works_at_area
	 *
     */
    function get_all_users_works_at_area(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('users_works_at_area')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users_works_at_area
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_works_at_area($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('users_works_at_area')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users_works_at_area rows
	 *
     */
	function get_count_users_works_at_area(){
       $result = $this->db->from("users_works_at_area")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-users_works_at_area
	 *
     */
    function get_all_users_users_works_at_area(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_works_at_area')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-users_works_at_area
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_users_works_at_area($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_works_at_area')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-users_works_at_area rows
	 *
     */
	function get_count_users_users_works_at_area(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("users_works_at_area")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new users_works_at_area
	 *@param $params - data set to add record
	 *
     */
    function add_users_works_at_area($params){
        $this->db->insert('users_works_at_area',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update users_works_at_area
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_users_works_at_area($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('users_works_at_area',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete users_works_at_area
	 *@param $id - primary key to delete record
	 *
     */
    function delete_users_works_at_area($id){
        $status = $this->db->delete('users_works_at_area',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
