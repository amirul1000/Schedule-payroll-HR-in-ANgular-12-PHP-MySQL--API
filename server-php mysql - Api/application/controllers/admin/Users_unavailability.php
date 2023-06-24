<?php

 /**
 * Author: Amirul Momenin
 * Desc:Users_unavailability Controller
 *
 */
class Users_unavailability extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Users_unavailability_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of users_unavailability table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['users_unavailability'] = $this->Users_unavailability_model->get_limit_users_unavailability($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/users_unavailability/index');
		$config['total_rows'] = $this->Users_unavailability_model->get_count_users_unavailability();
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
		
        $data['_view'] = 'admin/users_unavailability/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save users_unavailability
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'users_pay_details_id' => html_escape($this->input->post('users_pay_details_id')),
'start_date' => html_escape($this->input->post('start_date')),
'start_time' => html_escape($this->input->post('start_time')),
'end_date' => html_escape($this->input->post('end_date')),
'end_time' => html_escape($this->input->post('end_time')),
'repeat_type' => html_escape($this->input->post('repeat_type')),
'Mon' => html_escape($this->input->post('Mon')),
'Tue' => html_escape($this->input->post('Tue')),
'Wed' => html_escape($this->input->post('Wed')),
'Thu' => html_escape($this->input->post('Thu')),
'Fri' => html_escape($this->input->post('Fri')),
'Sat' => html_escape($this->input->post('Sat')),
'Sun' => html_escape($this->input->post('Sun')),
'notes' => html_escape($this->input->post('notes')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['users_unavailability'] = $this->Users_unavailability_model->get_users_unavailability($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Users_unavailability_model->update_users_unavailability($id,$params);
				$this->session->set_flashdata('msg','Users_unavailability has been updated successfully');
                redirect('admin/users_unavailability/index');
            }else{
                $data['_view'] = 'admin/users_unavailability/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $users_unavailability_id = $this->Users_unavailability_model->add_users_unavailability($params);
				$this->session->set_flashdata('msg','Users_unavailability has been saved successfully');
                redirect('admin/users_unavailability/index');
            }else{  
			    $data['users_unavailability'] = $this->Users_unavailability_model->get_users_unavailability(0);
                $data['_view'] = 'admin/users_unavailability/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details users_unavailability
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['users_unavailability'] = $this->Users_unavailability_model->get_users_unavailability($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/users_unavailability/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting users_unavailability
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $users_unavailability = $this->Users_unavailability_model->get_users_unavailability($id);

        // check if the users_unavailability exists before trying to delete it
        if(isset($users_unavailability['id'])){
            $this->Users_unavailability_model->delete_users_unavailability($id);
			$this->session->set_flashdata('msg','Users_unavailability has been deleted successfully');
            redirect('admin/users_unavailability/index');
        }
        else
            show_error('The users_unavailability you are trying to delete does not exist.');
    }
	
	/**
     * Search users_unavailability
	 * @param $start - Starting of users_unavailability table's index to get query
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
$this->db->or_like('users_pay_details_id', $key, 'both');
$this->db->or_like('start_date', $key, 'both');
$this->db->or_like('start_time', $key, 'both');
$this->db->or_like('end_date', $key, 'both');
$this->db->or_like('end_time', $key, 'both');
$this->db->or_like('repeat_type', $key, 'both');
$this->db->or_like('Mon', $key, 'both');
$this->db->or_like('Tue', $key, 'both');
$this->db->or_like('Wed', $key, 'both');
$this->db->or_like('Thu', $key, 'both');
$this->db->or_like('Fri', $key, 'both');
$this->db->or_like('Sat', $key, 'both');
$this->db->or_like('Sun', $key, 'both');
$this->db->or_like('notes', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['users_unavailability'] = $this->db->get('users_unavailability')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/users_unavailability/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_pay_details_id', $key, 'both');
$this->db->or_like('start_date', $key, 'both');
$this->db->or_like('start_time', $key, 'both');
$this->db->or_like('end_date', $key, 'both');
$this->db->or_like('end_time', $key, 'both');
$this->db->or_like('repeat_type', $key, 'both');
$this->db->or_like('Mon', $key, 'both');
$this->db->or_like('Tue', $key, 'both');
$this->db->or_like('Wed', $key, 'both');
$this->db->or_like('Thu', $key, 'both');
$this->db->or_like('Fri', $key, 'both');
$this->db->or_like('Sat', $key, 'both');
$this->db->or_like('Sun', $key, 'both');
$this->db->or_like('notes', $key, 'both');

		$config['total_rows'] = $this->db->from("users_unavailability")->count_all_results();
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
		$data['_view'] = 'admin/users_unavailability/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export users_unavailability
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'users_unavailability_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $users_unavailabilityData = $this->Users_unavailability_model->get_all_users_unavailability();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Pay Details Id","Start Date","Start Time","End Date","End Time","Repeat Type","Mon","Tue","Wed","Thu","Fri","Sat","Sun","Notes"); 
		   fputcsv($file, $header);
		   foreach ($users_unavailabilityData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $users_unavailability = $this->db->get('users_unavailability')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/users_unavailability/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Users_unavailability controller