<?php

/**
 * Author: Amirul Momenin
 * Desc:Area Model
 */
class Area_model extends CI_Model
{
	protected $area = 'area';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get area by id
	 *@param $id - primary key to get record
	 *
     */
    function get_area($id){
        $result = $this->db->get_where('area',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('area');
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
	
    /** Get all area
	 *
     */
    function get_all_area(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('area')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit area
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_area($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('area')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count area rows
	 *
     */
	function get_count_area(){
       $result = $this->db->from("area")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-area
	 *
     */
    function get_all_users_area(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('area')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-area
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_area($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('area')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-area rows
	 *
     */
	function get_count_users_area(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("area")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new area
	 *@param $params - data set to add record
	 *
     */
    function add_area($params){
        $this->db->insert('area',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update area
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_area($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('area',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete area
	 *@param $id - primary key to delete record
	 *
     */
    function delete_area($id){
        $status = $this->db->delete('area',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
