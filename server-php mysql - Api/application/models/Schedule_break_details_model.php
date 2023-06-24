<?php

/**
 * Author: Amirul Momenin
 * Desc:Schedule_break_details Model
 */
class Schedule_break_details_model extends CI_Model
{
	protected $schedule_break_details = 'schedule_break_details';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get schedule_break_details by id
	 *@param $id - primary key to get record
	 *
     */
    function get_schedule_break_details($id){
        $result = $this->db->get_where('schedule_break_details',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('schedule_break_details');
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
	
    /** Get all schedule_break_details
	 *
     */
    function get_all_schedule_break_details(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('schedule_break_details')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit schedule_break_details
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_schedule_break_details($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('schedule_break_details')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count schedule_break_details rows
	 *
     */
	function get_count_schedule_break_details(){
       $result = $this->db->from("schedule_break_details")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-schedule_break_details
	 *
     */
    function get_all_users_schedule_break_details(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('schedule_break_details')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-schedule_break_details
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_schedule_break_details($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('schedule_break_details')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-schedule_break_details rows
	 *
     */
	function get_count_users_schedule_break_details(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("schedule_break_details")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new schedule_break_details
	 *@param $params - data set to add record
	 *
     */
    function add_schedule_break_details($params){
        $this->db->insert('schedule_break_details',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update schedule_break_details
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_schedule_break_details($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('schedule_break_details',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete schedule_break_details
	 *@param $id - primary key to delete record
	 *
     */
    function delete_schedule_break_details($id){
        $status = $this->db->delete('schedule_break_details',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
