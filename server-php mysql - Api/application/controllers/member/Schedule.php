<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author: Amirul Momenin
 * Desc:Landing Page
 */
class Schedule extends CI_Controller
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
		$this->load->model('Schedule_model');
        if (! $this->session->userdata('validated')) {
            redirect('member/login/index');
        }
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
		$data['_view'] = 'member/schedule/index';
        $this->load->view('layouts/member/body', $data);
    }
	
	function load(){
	    $this->db->order_by('id', 'desc');
		$this->db->where('schedule.assign_by_users_id', $this->session->userdata('id'));
		$this->db->where('schedule.company_id', $this->session->userdata('company_id'));
        $task = $this->db->get('schedule')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		} 
	   $data = array();
	   
	   for($i=0;$i<count($task);$i++){
				$data[] = array(
					  'id'   => $task[$i]['id'],
					  'title'   => $task[$i]['area'],
					  'start'   => date("Y-m-d",strtotime($task[$i]['start_date'])),
					  'end'   => date("Y-m-d",strtotime($task[$i]['start_date'])),
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
					'area' => html_escape($this->input->post('area')),
					'start_date' => html_escape($this->input->post('start_date')),
					'start' => html_escape($this->input->post('start')),
					'finish' => html_escape($this->input->post('finish')),
					'meal_break' => html_escape($this->input->post('meal_break')),
					'rest_break' => html_escape($this->input->post('rest_break')),
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
        //update		
        if(isset($id) && $id>0){
			$data['schedule'] = $this->Schedule_model->get_schedule($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Schedule_model->update_schedule($id,$params);
				$this->session->set_flashdata('msg','Schedule has been updated successfully');
                redirect('member/schedule/index');
            }/*else{
                $data['_view'] = 'admin/schedule/form';
                $this->load->view('layouts/admin/body',$data);
            }*/
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $schedule_id = $this->Schedule_model->add_schedule($params);
				$this->session->set_flashdata('msg','Schedule has been saved successfully');
                redirect('member/schedule/index');
            }/*else{  
			    $data['schedule'] = $this->Schedule_model->get_schedule(0);
                $data['_view'] = 'admin/schedule/form';
                $this->load->view('layouts/admin/body',$data);
            }*/
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
		
        $task = $this->Schedule_model->get_schedule($id);

        // check if the task exists before trying to delete it
        if (isset($task['id'])) {
            $this->Schedule_model->delete_schedule($id);
            $this->session->set_flashdata('msg', 'Schedule has been deleted successfully');
            redirect('member/schedule/index');
        } else
            show_error('The schedule you are trying to delete does not exist.');
    }
	
	function get_info($id){
		$res = $this->Schedule_model->get_schedule($id);//
		echo json_encode($res);
		exit;
	}
	function delete(){
		$status = $this->db->delete('schedule', array(
            'id' => $this->input->post('id')
        ));
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        redirect('member/schedule/index');
		
	}
	
	function insert(){
		
	}
	
	function update(){
		
	}
}
