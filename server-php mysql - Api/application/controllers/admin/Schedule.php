<?php

 /**
 * Author: Amirul Momenin
 * Desc:Schedule Controller
 *
 */
class Schedule extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Schedule_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of schedule table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['schedule'] = $this->Schedule_model->get_limit_schedule($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/schedule/index');
		$config['total_rows'] = $this->Schedule_model->get_count_schedule();
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
		
        $data['_view'] = 'admin/schedule/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save schedule
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
'location_id' => html_escape($this->input->post('location_id')),
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
		 
		if($id>0){
							                        unset($params['created_at']);
						                          }if($id<=0){
							                        unset($params['updated_at']);
						                          } 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['schedule'] = $this->Schedule_model->get_schedule($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Schedule_model->update_schedule($id,$params);
				$this->session->set_flashdata('msg','Schedule has been updated successfully');
                redirect('admin/schedule/index');
            }else{
                $data['_view'] = 'admin/schedule/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $schedule_id = $this->Schedule_model->add_schedule($params);
				$this->session->set_flashdata('msg','Schedule has been saved successfully');
                redirect('admin/schedule/index');
            }else{  
			    $data['schedule'] = $this->Schedule_model->get_schedule(0);
                $data['_view'] = 'admin/schedule/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details schedule
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['schedule'] = $this->Schedule_model->get_schedule($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/schedule/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting schedule
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $schedule = $this->Schedule_model->get_schedule($id);

        // check if the schedule exists before trying to delete it
        if(isset($schedule['id'])){
            $this->Schedule_model->delete_schedule($id);
			$this->session->set_flashdata('msg','Schedule has been deleted successfully');
            redirect('admin/schedule/index');
        }
        else
            show_error('The schedule you are trying to delete does not exist.');
    }
	
	/**
     * Search schedule
	 * @param $start - Starting of schedule table's index to get query
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
$this->db->or_like('location_id', $key, 'both');
$this->db->or_like('start_date', $key, 'both');
$this->db->or_like('start', $key, 'both');
$this->db->or_like('finish', $key, 'both');
$this->db->or_like('meal_break', $key, 'both');
$this->db->or_like('rest_break', $key, 'both');
$this->db->or_like('notes', $key, 'both');
$this->db->or_like('status', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['schedule'] = $this->db->get('schedule')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/schedule/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('assign_by_users_id', $key, 'both');
$this->db->or_like('assign_to_users_id', $key, 'both');
$this->db->or_like('location_id', $key, 'both');
$this->db->or_like('start_date', $key, 'both');
$this->db->or_like('start', $key, 'both');
$this->db->or_like('finish', $key, 'both');
$this->db->or_like('meal_break', $key, 'both');
$this->db->or_like('rest_break', $key, 'both');
$this->db->or_like('notes', $key, 'both');
$this->db->or_like('status', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("schedule")->count_all_results();
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
		$data['_view'] = 'admin/schedule/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export schedule
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'schedule_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $scheduleData = $this->Schedule_model->get_all_schedule();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Assign By Users Id","Assign To Users Id","Location Id","Start Date","Start","Finish","Meal Break","Rest Break","Notes","Status","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($scheduleData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $schedule = $this->db->get('schedule')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/schedule/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Schedule controller