<?php

/**
 * Author: Amirul Momenin
 * Desc:Business Model
 */
class Business_model extends CI_Model
{
	protected $business = 'business';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get business by id
	 *@param $id - primary key to get record
	 *
     */
    function get_business($id){
        $result = $this->db->get_where('business',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('business');
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
	
    /** Get all business
	 *
     */
    function get_all_business(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('business')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit business
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_business($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('business')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count business rows
	 *
     */
	function get_count_business(){
       $result = $this->db->from("business")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-business
	 *
     */
    function get_all_users_business(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('business')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-business
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_business($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('business')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-business rows
	 *
     */
	function get_count_users_business(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("business")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new business
	 *@param $params - data set to add record
	 *
     */
    function add_business($params){
        $this->db->insert('business',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update business
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_business($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('business',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete business
	 *@param $id - primary key to delete record
	 *
     */
    function delete_business($id){
        $status = $this->db->delete('business',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
