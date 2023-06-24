<?php

 /**
 * Author: Amirul Momenin
 * Desc:Users_location Controller
 *
 */
class Users_location extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Users_location_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of users_location table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['users_location'] = $this->Users_location_model->get_limit_users_location($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/users_location/index');
		$config['total_rows'] = $this->Users_location_model->get_count_users_location();
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
		
        $data['_view'] = 'admin/users_location/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save users_location
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
					 'users_id' => html_escape($this->input->post('users_id')),
'business_id' => html_escape($this->input->post('business_id')),
'location_id' => html_escape($this->input->post('location_id')),
'location_name' => html_escape($this->input->post('location_name')),
'main' => html_escape($this->input->post('main')),
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
			$data['users_location'] = $this->Users_location_model->get_users_location($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Users_location_model->update_users_location($id,$params);
				$this->session->set_flashdata('msg','Users_location has been updated successfully');
                redirect('admin/users_location/index');
            }else{
                $data['_view'] = 'admin/users_location/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $users_location_id = $this->Users_location_model->add_users_location($params);
				$this->session->set_flashdata('msg','Users_location has been saved successfully');
                redirect('admin/users_location/index');
            }else{  
			    $data['users_location'] = $this->Users_location_model->get_users_location(0);
                $data['_view'] = 'admin/users_location/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details users_location
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['users_location'] = $this->Users_location_model->get_users_location($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/users_location/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting users_location
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $users_location = $this->Users_location_model->get_users_location($id);

        // check if the users_location exists before trying to delete it
        if(isset($users_location['id'])){
            $this->Users_location_model->delete_users_location($id);
			$this->session->set_flashdata('msg','Users_location has been deleted successfully');
            redirect('admin/users_location/index');
        }
        else
            show_error('The users_location you are trying to delete does not exist.');
    }
	
	/**
     * Search users_location
	 * @param $start - Starting of users_location table's index to get query
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
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('business_id', $key, 'both');
$this->db->or_like('location_id', $key, 'both');
$this->db->or_like('location_name', $key, 'both');
$this->db->or_like('main', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['users_location'] = $this->db->get('users_location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/users_location/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('business_id', $key, 'both');
$this->db->or_like('location_id', $key, 'both');
$this->db->or_like('location_name', $key, 'both');
$this->db->or_like('main', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("users_location")->count_all_results();
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
		$data['_view'] = 'admin/users_location/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export users_location
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'users_location_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $users_locationData = $this->Users_location_model->get_all_users_location();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Id","Business Id","Location Id","Location Name","Main","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($users_locationData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $users_location = $this->db->get('users_location')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/users_location/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Users_location controller