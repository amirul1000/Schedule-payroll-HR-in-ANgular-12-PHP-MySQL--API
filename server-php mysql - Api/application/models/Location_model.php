<?php

/**
 * Author: Amirul Momenin
 * Desc:Location Model
 */
class Location_model extends CI_Model
{
	protected $location = 'location';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get location by id
	 *@param $id - primary key to get record
	 *
     */
    function get_location($id){
        $result = $this->db->get_where('location',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('location');
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
	
    /** Get all location
	 *
     */
    function get_all_location(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit location
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_location($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count location rows
	 *
     */
	function get_count_location(){
       $result = $this->db->from("location")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-location
	 *
     */
    function get_all_users_location(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-location
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_location($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-location rows
	 *
     */
	function get_count_users_location(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("location")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new location
	 *@param $params - data set to add record
	 *
     */
    function add_location($params){
        $this->db->insert('location',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update location
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_location($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('location',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete location
	 *@param $id - primary key to delete record
	 *
     */
    function delete_location($id){
        $status = $this->db->delete('location',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
