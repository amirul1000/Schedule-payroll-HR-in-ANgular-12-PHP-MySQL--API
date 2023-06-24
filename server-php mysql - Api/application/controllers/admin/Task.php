<?php

 /**
 * Author: Amirul Momenin
 * Desc:Task Controller
 *
 */
class Task extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Task_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of task table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['task'] = $this->Task_model->get_limit_task($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/task/index');
		$config['total_rows'] = $this->Task_model->get_count_task();
		$config['per_page'] = 10;
		//Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';		
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
        $data['_view'] = 'admin/task/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save task
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		$created_at = "";
$updated_at = "";

		if($id<=0){
															 $created_at = date("Y-m-d H:i:s");
														 }
else if($id>0){
															 $updated_at = date("Y-m-d H:i:s");
														 }

		$params = array(
					 'assign_by_users_id' => html_escape($this->input->post('assign_by_users_id')),
'assign_to_users_id' => html_escape($this->input->post('assign_to_users_id')),
'task_title' => html_escape($this->input->post('task_title')),
'due_date' => html_escape($this->input->post('due_date')),
'notes' => html_escape($this->input->post('notes')),
'status' => html_escape($this->input->post('status')),
'created_at' =>$created_at,
'updated_at' =>$updated_at,

				);
		 
		if($id>0){
							                        unset($params['created_at']);
						                          }if($id<=0){
							                        unset($params['updated_at']);
						                          } 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['task'] = $this->Task_model->get_task($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Task_model->update_task($id,$params);
				$this->session->set_flashdata('msg','Task has been updated successfully');
                redirect('admin/task/index');
            }else{
                $data['_view'] = 'admin/task/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $task_id = $this->Task_model->add_task($params);
				$this->session->set_flashdata('msg','Task has been saved successfully');
                redirect('admin/task/index');
            }else{  
			    $data['task'] = $this->Task_model->get_task(0);
                $data['_view'] = 'admin/task/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details task
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['task'] = $this->Task_model->get_task($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/task/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting task
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $task = $this->Task_model->get_task($id);

        // check if the task exists before trying to delete it
        if(isset($task['id'])){
            $this->Task_model->delete_task($id);
			$this->session->set_flashdata('msg','Task has been deleted successfully');
            redirect('admin/task/index');
        }
        else
            show_error('The task you are trying to delete does not exist.');
    }
	
	/**
     * Search task
	 * @param $start - Starting of task table's index to get query
     */
	function search($start=0){
		if(!empty($this->input->post('key'))){
			$key =$this->input->post('key');
			$_SESSION['key'] = $key;
		}else{
			$key = $_SESSION['key'];
		}
		
		$limit = 10;		
		$this->db->like('id', $key, 'both');
$this->db->or_like('assign_by_users_id', $key, 'both');
$this->db->or_like('assign_to_users_id', $key, 'both');
$this->db->or_like('task_title', $key, 'both');
$this->db->or_like('due_date', $key, 'both');
$this->db->or_like('notes', $key, 'both');
$this->db->or_like('status', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['task'] = $this->db->get('task')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/task/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('assign_by_users_id', $key, 'both');
$this->db->or_like('assign_to_users_id', $key, 'both');
$this->db->or_like('task_title', $key, 'both');
$this->db->or_like('due_date', $key, 'both');
$this->db->or_like('notes', $key, 'both');
$this->db->or_like('status', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("task")->count_all_results();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		$config['per_page'] = 10;
		// Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
		$data['key'] = $key;
		$data['_view'] = 'admin/task/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export task
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'task_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $taskData = $this->Task_model->get_all_task();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Assign By Users Id","Assign To Users Id","Task Title","Due Date","Notes","Status","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($taskData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $task = $this->db->get('task')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/task/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Task controller