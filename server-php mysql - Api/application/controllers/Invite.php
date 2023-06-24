<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author: Amirul Momenin
 * Desc:Landing Page
 */
class Invite extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('Customlib');
        $this->load->helper(array(
            'cookie',
            'url',
            'captcha'
        ));
        $this->load->database();
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of About_us table's index to get query
     *            
     */
    function index($id,$users_id)
    {
		$id = base64_decode($id);
		$users_id = base64_decode($users_id);
		
		$this->db->order_by('id', 'desc');
		$this->db->select('schedule.*,area.area_name as area');
		$this->db->where('schedule.id', $id);
		//$this->db->where('schedule.publish_type', '1');
		//$this->db->where('schedule.start_date BETWEEN "'. date('Y-m-d', strtotime($this->input->get('start_date'))). '" and "'. date('Y-m-d', strtotime($this->input->get('end_date'))).'"');
		$this->db->join('area', 'area.id = schedule.area_id', 'left');
		$task = $this->db->get('schedule')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		} 
		
		$this->load->helper('utility');
		$location = get_location_info($task[0]['location_id']);
		$user = get_user_info($users_id);

		$data['id'] = $id;
		$data['users_id'] = $users_id;
		$data['task'] = $task;
		$data['location'] = $location;
		$data['user'] = $user;
		
        //$data['_view'] = 'front/invite/index';
        $this->load->view('invite/index', $data);
    }
	
	function accept($id,$users_id)
    {
		$id = base64_decode($id);
		$users_id = base64_decode($users_id);
		
		$this->db->order_by('id', 'desc');
		$this->db->select('schedule.*,area.area_name as area');
		$this->db->where('schedule.id', $id);
		//$this->db->where('schedule.publish_type', '1');
		//$this->db->where('schedule.start_date BETWEEN "'. date('Y-m-d', strtotime($this->input->get('start_date'))). '" and "'. date('Y-m-d', strtotime($this->input->get('end_date'))).'"');
		$this->db->join('area', 'area.id = schedule.area_id', 'left');
		$task = $this->db->get('schedule')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		} 
		
		
		$worker_users_id = $task[0]['worker_users_id'];
		
		$this->db->distinct();
		$this->db->select('users.*');
		$this->db->from('users_location');
		$this->db->order_by('users.id', 'ASC');
		$this->db->where("users.first_name in('OpenShift','EmptyShift')");
		$this->db->join('users', 'users_location.users_id = users.id', 'left');
		$users = $this->db->get()->result_array();
		
		$id_1 = $users[0]['id'];
		$id_2 = $users[1]['id'];
		
		$status = '';
		
		if($worker_users_id==$id_1 || $worker_users_id==$id_2){
			$this->load->model('Schedule_model');
			$params = array(
						'worker_users_id' => $users_id
				);
			$this->Schedule_model->update_schedule($id,$params);	
			$status = 'success';
		}
		else{
			$status = 'fail';
		}
		
		
		$this->load->helper('utility');
		$location = get_location_info($task[0]['location_id']);
		$user = get_user_info($users_id);

		$data['id'] = $id;
		$data['users_id'] = $users_id;
		$data['task'] = $task;
		$data['location'] = $location;
		$data['user'] = $user;
		$data['status'] = $status;
		
		$this->load->view('invite/accept', $data);
		
	}
}