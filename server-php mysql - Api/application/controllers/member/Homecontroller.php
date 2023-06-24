<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author: Amirul Momenin
 * Desc:Landing Page
 */
class Homecontroller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
		$this->load->library('Customlib');
        $this->load->helper(array(
            'cookie',
            'url'
        ));
        $this->load->database();
		$this->load->model('Task_model');
        if (! $this->session->userdata('validated')) {
            redirect('member/login/index');
        }
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $data['_view'] = 'member_homepage';
        $this->load->view('layouts/member/body', $data);
    }
	
	function load(){
	   $task = $this->db->select('task.*,task.task_title,task.due_date,task.notes,customer.status')
         ->from('task','task.assign_by_users_id='.$this->session->userdata('id'),'left')
         ->join('task', 'task.company_id ='.$this->session->userdata('company_id'))
		 ->where('task.assign_by_users_id='.$this->session->userdata('id'))
		 ->get()->result_array();
	
	   $data = array();
	   
	   for($i=0;$i<count($task);$i++){
				$data[] = array(
					  'id'   => $task[$i]['id'],
					  'task_title'   => $task[$i]['task_title'],
					  'due_date'   => $task[$i]['due_date'],
					  'status'   => $task[$i]['status'],
					 );
			}
		echo json_encode($data);
	}
	 /**
     * Save task
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $created_at = "";
        $updated_at = "";

        if ($id <= 0) {
            $created_at = date("Y-m-d H:i:s");
        } else if ($id > 0) {
            $updated_at = date("Y-m-d H:i:s");
        }

       $params = array(
						'company_id' => $this->session->userdata('company_id'),
						'assign_by_users_id' => $this->session->userdata('id'),
						'assign_to_users_id' => html_escape($this->input->post('assign_to_users_id')),
						'task_title' => html_escape($this->input->post('task_title')),
						'due_date' => html_escape($this->input->post('due_date')),
						'notes' => html_escape($this->input->post('notes')),
						'status' => html_escape($this->input->post('status')),
						'created_at' =>$created_at,
						'updated_at' =>$updated_at,
				);
        if ($id > 0) {
            unset($params['created_at']);
        }
        if ($id <= 0) {
            unset($params['updated_at']);
        }
        $data['id'] = $id;
        if (isset($_POST) && count($_POST) > 0) {
			    if (isset($id) && $id > 0) {
					$this->Task_model->update_task($id, $params);
					$this->session->set_flashdata('msg', 'Task has been updated successfully');
					redirect('member/homecontroller/index');
				}else{
					$task_id = $this->Task_model->add_task($params);
					$this->session->set_flashdata('msg', 'Task has been saved successfully');
					redirect('member/homecontroller/index');
				}
        }
    }
	/**
     * Deleting task
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($delete_id=-1)
    {
		$id = $this->input->post('delete_id'); 
		
        $task = $this->Task_model->get_task($id);

        // check if the task exists before trying to delete it
        if (isset($task['id'])) {
            $this->Task_model->delete_task($id);
            $this->session->set_flashdata('msg', 'Task has been deleted successfully');
            redirect('member/homecontroller/index');
        } else
            show_error('The task you are trying to delete does not exist.');
    }
	
	function get_info(){
		$res = $this->Task_model->get_task($this->input->post('id'));
		echo json_encode($res);
		exit;
	}
	function delete(){
		$status = $this->db->delete('task', array(
            'id' => $this->input->post('id')
        ));
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
		
	}
	
	function insert(){
		
	}
	
	function update(){
		
	}
}
