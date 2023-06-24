<?php

 /**
 * Author: Amirul Momenin
 * Desc:Schedule_break_details Controller
 *
 */
class Schedule_break_details extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Schedule_break_details_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of schedule_break_details table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['schedule_break_details'] = $this->Schedule_break_details_model->get_limit_schedule_break_details($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/schedule_break_details/index');
		$config['total_rows'] = $this->Schedule_break_details_model->get_count_schedule_break_details();
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
		
        $data['_view'] = 'admin/schedule_break_details/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save schedule_break_details
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
					 'schedule_id' => html_escape($this->input->post('schedule_id')),
'type' => html_escape($this->input->post('type')),
'duration' => html_escape($this->input->post('duration')),
'start' => html_escape($this->input->post('start')),
'finish' => html_escape($this->input->post('finish')),
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
			$data['schedule_break_details'] = $this->Schedule_break_details_model->get_schedule_break_details($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Schedule_break_details_model->update_schedule_break_details($id,$params);
				$this->session->set_flashdata('msg','Schedule_break_details has been updated successfully');
                redirect('admin/schedule_break_details/index');
            }else{
                $data['_view'] = 'admin/schedule_break_details/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $schedule_break_details_id = $this->Schedule_break_details_model->add_schedule_break_details($params);
				$this->session->set_flashdata('msg','Schedule_break_details has been saved successfully');
                redirect('admin/schedule_break_details/index');
            }else{  
			    $data['schedule_break_details'] = $this->Schedule_break_details_model->get_schedule_break_details(0);
                $data['_view'] = 'admin/schedule_break_details/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details schedule_break_details
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['schedule_break_details'] = $this->Schedule_break_details_model->get_schedule_break_details($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/schedule_break_details/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting schedule_break_details
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $schedule_break_details = $this->Schedule_break_details_model->get_schedule_break_details($id);

        // check if the schedule_break_details exists before trying to delete it
        if(isset($schedule_break_details['id'])){
            $this->Schedule_break_details_model->delete_schedule_break_details($id);
			$this->session->set_flashdata('msg','Schedule_break_details has been deleted successfully');
            redirect('admin/schedule_break_details/index');
        }
        else
            show_error('The schedule_break_details you are trying to delete does not exist.');
    }
	
	/**
     * Search schedule_break_details
	 * @param $start - Starting of schedule_break_details table's index to get query
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
$this->db->or_like('schedule_id', $key, 'both');
$this->db->or_like('type', $key, 'both');
$this->db->or_like('duration', $key, 'both');
$this->db->or_like('start', $key, 'both');
$this->db->or_like('finish', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['schedule_break_details'] = $this->db->get('schedule_break_details')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/schedule_break_details/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('schedule_id', $key, 'both');
$this->db->or_like('type', $key, 'both');
$this->db->or_like('duration', $key, 'both');
$this->db->or_like('start', $key, 'both');
$this->db->or_like('finish', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("schedule_break_details")->count_all_results();
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
		$data['_view'] = 'admin/schedule_break_details/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export schedule_break_details
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'schedule_break_details_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $schedule_break_detailsData = $this->Schedule_break_details_model->get_all_schedule_break_details();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Schedule Id","Type","Duration","Start","Finish","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($schedule_break_detailsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $schedule_break_details = $this->db->get('schedule_break_details')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/schedule_break_details/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Schedule_break_details controller