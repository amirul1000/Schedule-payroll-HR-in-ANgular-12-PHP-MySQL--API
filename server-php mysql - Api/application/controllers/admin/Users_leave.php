<?php

 /**
 * Author: Amirul Momenin
 * Desc:Users_leave Controller
 *
 */
class Users_leave extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Users_leave_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of users_leave table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['users_leave'] = $this->Users_leave_model->get_limit_users_leave($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/users_leave/index');
		$config['total_rows'] = $this->Users_leave_model->get_count_users_leave();
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
		
        $data['_view'] = 'admin/users_leave/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save users_leave
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'users_pay_details_id' => html_escape($this->input->post('users_pay_details_id')),
'start_date' => html_escape($this->input->post('start_date')),
'end_date' => html_escape($this->input->post('end_date')),
'leave_type' => html_escape($this->input->post('leave_type')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['users_leave'] = $this->Users_leave_model->get_users_leave($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Users_leave_model->update_users_leave($id,$params);
				$this->session->set_flashdata('msg','Users_leave has been updated successfully');
                redirect('admin/users_leave/index');
            }else{
                $data['_view'] = 'admin/users_leave/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $users_leave_id = $this->Users_leave_model->add_users_leave($params);
				$this->session->set_flashdata('msg','Users_leave has been saved successfully');
                redirect('admin/users_leave/index');
            }else{  
			    $data['users_leave'] = $this->Users_leave_model->get_users_leave(0);
                $data['_view'] = 'admin/users_leave/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details users_leave
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['users_leave'] = $this->Users_leave_model->get_users_leave($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/users_leave/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting users_leave
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $users_leave = $this->Users_leave_model->get_users_leave($id);

        // check if the users_leave exists before trying to delete it
        if(isset($users_leave['id'])){
            $this->Users_leave_model->delete_users_leave($id);
			$this->session->set_flashdata('msg','Users_leave has been deleted successfully');
            redirect('admin/users_leave/index');
        }
        else
            show_error('The users_leave you are trying to delete does not exist.');
    }
	
	/**
     * Search users_leave
	 * @param $start - Starting of users_leave table's index to get query
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
$this->db->or_like('end_date', $key, 'both');
$this->db->or_like('leave_type', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['users_leave'] = $this->db->get('users_leave')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/users_leave/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_pay_details_id', $key, 'both');
$this->db->or_like('start_date', $key, 'both');
$this->db->or_like('end_date', $key, 'both');
$this->db->or_like('leave_type', $key, 'both');

		$config['total_rows'] = $this->db->from("users_leave")->count_all_results();
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
		$data['_view'] = 'admin/users_leave/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export users_leave
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'users_leave_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $users_leaveData = $this->Users_leave_model->get_all_users_leave();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Pay Details Id","Start Date","End Date","Leave Type"); 
		   fputcsv($file, $header);
		   foreach ($users_leaveData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $users_leave = $this->db->get('users_leave')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/users_leave/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Users_leave controller