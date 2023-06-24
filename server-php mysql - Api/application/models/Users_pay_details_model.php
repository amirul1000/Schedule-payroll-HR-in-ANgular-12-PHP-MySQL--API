<?php

/**
 * Author: Amirul Momenin
 * Desc:Users_pay_details Model
 */
class Users_pay_details_model extends CI_Model
{
	protected $users_pay_details = 'users_pay_details';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get users_pay_details by id
	 *@param $id - primary key to get record
	 *
     */
    function get_users_pay_details($id){
        $result = $this->db->get_where('users_pay_details',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('users_pay_details');
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
	
    /** Get all users_pay_details
	 *
     */
    function get_all_users_pay_details(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('users_pay_details')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users_pay_details
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_pay_details($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('users_pay_details')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users_pay_details rows
	 *
     */
	function get_count_users_pay_details(){
       $result = $this->db->from("users_pay_details")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-users_pay_details
	 *
     */
    function get_all_users_users_pay_details(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_pay_details')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-users_pay_details
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_users_pay_details($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('users_pay_details')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-users_pay_details rows
	 *
     */
	function get_count_users_users_pay_details(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("users_pay_details")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new users_pay_details
	 *@param $params - data set to add record
	 *
     */
    function add_users_pay_details($params){
        $this->db->insert('users_pay_details',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update users_pay_details
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_users_pay_details($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('users_pay_details',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete users_pay_details
	 *@param $id - primary key to delete record
	 *
     */
    function delete_users_pay_details($id){
        $status = $this->db->delete('users_pay_details',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
