<?php

/**
 * Author: Amirul Momenin
 * Desc:News Model
 */
class News_model extends CI_Model
{
	protected $news = 'news';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get news by id
	 *@param $id - primary key to get record
	 *
     */
    function get_news($id){
        $result = $this->db->get_where('news',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('news');
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
	
    /** Get all news
	 *
     */
    function get_all_news(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('news')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit news
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_news($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('news')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count news rows
	 *
     */
	function get_count_news(){
       $result = $this->db->from("news")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-news
	 *
     */
    function get_all_users_news(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('news')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-news
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_news($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('news')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-news rows
	 *
     */
	function get_count_users_news(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("news")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new news
	 *@param $params - data set to add record
	 *
     */
    function add_news($params){
        $this->db->insert('news',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update news
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_news($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('news',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete news
	 *@param $id - primary key to delete record
	 *
     */
    function delete_news($id){
        $status = $this->db->delete('news',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
