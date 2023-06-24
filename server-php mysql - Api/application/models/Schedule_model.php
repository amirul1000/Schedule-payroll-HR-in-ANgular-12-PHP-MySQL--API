<?php

/**
 * Author: Amirul Momenin
 * Desc:Schedule Model
 */
class Schedule_model extends CI_Model
{
	protected $schedule = 'schedule';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get schedule by id
	 *@param $id - primary key to get record
	 *
     */
    function get_schedule($id){
        $result = $this->db->get_where('schedule',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('schedule');
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
	
    /** Get all schedule
	 *
     */
    function get_all_schedule(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('schedule')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit schedule
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_schedule($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('schedule')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count schedule rows
	 *
     */
	function get_count_schedule(){
       $result = $this->db->from("schedule")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-schedule
	 *
     */
    function get_all_users_schedule(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('schedule')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-schedule
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_schedule($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('schedule')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-schedule rows
	 *
     */
	function get_count_users_schedule(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("schedule")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new schedule
	 *@param $params - data set to add record
	 *
     */
    function add_schedule($params){
        $this->db->insert('schedule',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update schedule
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_schedule($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('schedule',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete schedule
	 *@param $id - primary key to delete record
	 *
     */
    function delete_schedule($id){
        $status = $this->db->delete('schedule',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
