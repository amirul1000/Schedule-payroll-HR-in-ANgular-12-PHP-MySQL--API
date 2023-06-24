<?php

 /**
 * Author: Amirul Momenin
 * Desc:Users_pay_details Controller
 *
 */
class Users_pay_details extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Users_pay_details_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of users_pay_details table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['users_pay_details'] = $this->Users_pay_details_model->get_limit_users_pay_details($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/users_pay_details/index');
		$config['total_rows'] = $this->Users_pay_details_model->get_count_users_pay_details();
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
		
        $data['_view'] = 'admin/users_pay_details/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save users_pay_details
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'super_users_id' => html_escape($this->input->post('super_users_id')),
'users_id' => html_escape($this->input->post('users_id')),
'business_id' => html_escape($this->input->post('business_id')),
'Payroll_ID' => html_escape($this->input->post('Payroll_ID')),
'access_level' => html_escape($this->input->post('access_level')),
'employee_start_date' => html_escape($this->input->post('employee_start_date')),
'employeement_type' => html_escape($this->input->post('employeement_type')),
'pay_rate_type' => html_escape($this->input->post('pay_rate_type')),
'salary_type' => html_escape($this->input->post('salary_type')),
'salary_amount' => html_escape($this->input->post('salary_amount')),
'weekday_rate' => html_escape($this->input->post('weekday_rate')),
'public_holiday_rate' => html_escape($this->input->post('public_holiday_rate')),
'saterday_rate' => html_escape($this->input->post('saterday_rate')),
'sunday_rate' => html_escape($this->input->post('sunday_rate')),
'monday_rate' => html_escape($this->input->post('monday_rate')),
'tuesday_rate' => html_escape($this->input->post('tuesday_rate')),
'wednesday_rate' => html_escape($this->input->post('wednesday_rate')),
'thrusday_rate' => html_escape($this->input->post('thrusday_rate')),
'friday_rate' => html_escape($this->input->post('friday_rate')),
'hourly_rate' => html_escape($this->input->post('hourly_rate')),
'overtime_rate' => html_escape($this->input->post('overtime_rate')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['users_pay_details'] = $this->Users_pay_details_model->get_users_pay_details($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Users_pay_details_model->update_users_pay_details($id,$params);
				$this->session->set_flashdata('msg','Users_pay_details has been updated successfully');
                redirect('admin/users_pay_details/index');
            }else{
                $data['_view'] = 'admin/users_pay_details/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $users_pay_details_id = $this->Users_pay_details_model->add_users_pay_details($params);
				$this->session->set_flashdata('msg','Users_pay_details has been saved successfully');
                redirect('admin/users_pay_details/index');
            }else{  
			    $data['users_pay_details'] = $this->Users_pay_details_model->get_users_pay_details(0);
                $data['_view'] = 'admin/users_pay_details/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details users_pay_details
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['users_pay_details'] = $this->Users_pay_details_model->get_users_pay_details($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/users_pay_details/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting users_pay_details
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $users_pay_details = $this->Users_pay_details_model->get_users_pay_details($id);

        // check if the users_pay_details exists before trying to delete it
        if(isset($users_pay_details['id'])){
            $this->Users_pay_details_model->delete_users_pay_details($id);
			$this->session->set_flashdata('msg','Users_pay_details has been deleted successfully');
            redirect('admin/users_pay_details/index');
        }
        else
            show_error('The users_pay_details you are trying to delete does not exist.');
    }
	
	/**
     * Search users_pay_details
	 * @param $start - Starting of users_pay_details table's index to get query
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
$this->db->or_like('super_users_id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('business_id', $key, 'both');
$this->db->or_like('Payroll_ID', $key, 'both');
$this->db->or_like('access_level', $key, 'both');
$this->db->or_like('employee_start_date', $key, 'both');
$this->db->or_like('employeement_type', $key, 'both');
$this->db->or_like('pay_rate_type', $key, 'both');
$this->db->or_like('salary_type', $key, 'both');
$this->db->or_like('salary_amount', $key, 'both');
$this->db->or_like('weekday_rate', $key, 'both');
$this->db->or_like('public_holiday_rate', $key, 'both');
$this->db->or_like('saterday_rate', $key, 'both');
$this->db->or_like('sunday_rate', $key, 'both');
$this->db->or_like('monday_rate', $key, 'both');
$this->db->or_like('tuesday_rate', $key, 'both');
$this->db->or_like('wednesday_rate', $key, 'both');
$this->db->or_like('thrusday_rate', $key, 'both');
$this->db->or_like('friday_rate', $key, 'both');
$this->db->or_like('hourly_rate', $key, 'both');
$this->db->or_like('overtime_rate', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['users_pay_details'] = $this->db->get('users_pay_details')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/users_pay_details/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('super_users_id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('business_id', $key, 'both');
$this->db->or_like('Payroll_ID', $key, 'both');
$this->db->or_like('access_level', $key, 'both');
$this->db->or_like('employee_start_date', $key, 'both');
$this->db->or_like('employeement_type', $key, 'both');
$this->db->or_like('pay_rate_type', $key, 'both');
$this->db->or_like('salary_type', $key, 'both');
$this->db->or_like('salary_amount', $key, 'both');
$this->db->or_like('weekday_rate', $key, 'both');
$this->db->or_like('public_holiday_rate', $key, 'both');
$this->db->or_like('saterday_rate', $key, 'both');
$this->db->or_like('sunday_rate', $key, 'both');
$this->db->or_like('monday_rate', $key, 'both');
$this->db->or_like('tuesday_rate', $key, 'both');
$this->db->or_like('wednesday_rate', $key, 'both');
$this->db->or_like('thrusday_rate', $key, 'both');
$this->db->or_like('friday_rate', $key, 'both');
$this->db->or_like('hourly_rate', $key, 'both');
$this->db->or_like('overtime_rate', $key, 'both');

		$config['total_rows'] = $this->db->from("users_pay_details")->count_all_results();
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
		$data['_view'] = 'admin/users_pay_details/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export users_pay_details
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'users_pay_details_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $users_pay_detailsData = $this->Users_pay_details_model->get_all_users_pay_details();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Super Users Id","Users Id","Business Id","Payroll ID","Access Level","Employee Start Date","Employeement Type","Pay Rate Type","Salary Type","Salary Amount","Weekday Rate","Public Holiday Rate","Saterday Rate","Sunday Rate","Monday Rate","Tuesday Rate","Wednesday Rate","Thrusday Rate","Friday Rate","Hourly Rate","Overtime Rate"); 
		   fputcsv($file, $header);
		   foreach ($users_pay_detailsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $users_pay_details = $this->db->get('users_pay_details')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/users_pay_details/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Users_pay_details controller