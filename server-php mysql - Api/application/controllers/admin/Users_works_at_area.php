<?php

 /**
 * Author: Amirul Momenin
 * Desc:Users_works_at_area Controller
 *
 */
class Users_works_at_area extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Users_works_at_area_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of users_works_at_area table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['users_works_at_area'] = $this->Users_works_at_area_model->get_limit_users_works_at_area($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/users_works_at_area/index');
		$config['total_rows'] = $this->Users_works_at_area_model->get_count_users_works_at_area();
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
		
        $data['_view'] = 'admin/users_works_at_area/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save users_works_at_area
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
					 'super_users_id' => html_escape($this->input->post('super_users_id')),
'worker_users_id' => html_escape($this->input->post('worker_users_id')),
'business_id' => html_escape($this->input->post('business_id')),
'location_id' => html_escape($this->input->post('location_id')),
'area_id' => html_escape($this->input->post('area_id')),
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
			$data['users_works_at_area'] = $this->Users_works_at_area_model->get_users_works_at_area($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Users_works_at_area_model->update_users_works_at_area($id,$params);
				$this->session->set_flashdata('msg','Users_works_at_area has been updated successfully');
                redirect('admin/users_works_at_area/index');
            }else{
                $data['_view'] = 'admin/users_works_at_area/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $users_works_at_area_id = $this->Users_works_at_area_model->add_users_works_at_area($params);
				$this->session->set_flashdata('msg','Users_works_at_area has been saved successfully');
                redirect('admin/users_works_at_area/index');
            }else{  
			    $data['users_works_at_area'] = $this->Users_works_at_area_model->get_users_works_at_area(0);
                $data['_view'] = 'admin/users_works_at_area/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details users_works_at_area
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['users_works_at_area'] = $this->Users_works_at_area_model->get_users_works_at_area($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/users_works_at_area/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting users_works_at_area
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $users_works_at_area = $this->Users_works_at_area_model->get_users_works_at_area($id);

        // check if the users_works_at_area exists before trying to delete it
        if(isset($users_works_at_area['id'])){
            $this->Users_works_at_area_model->delete_users_works_at_area($id);
			$this->session->set_flashdata('msg','Users_works_at_area has been deleted successfully');
            redirect('admin/users_works_at_area/index');
        }
        else
            show_error('The users_works_at_area you are trying to delete does not exist.');
    }
	
	/**
     * Search users_works_at_area
	 * @param $start - Starting of users_works_at_area table's index to get query
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
$this->db->or_like('worker_users_id', $key, 'both');
$this->db->or_like('business_id', $key, 'both');
$this->db->or_like('location_id', $key, 'both');
$this->db->or_like('area_id', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['users_works_at_area'] = $this->db->get('users_works_at_area')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/users_works_at_area/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('super_users_id', $key, 'both');
$this->db->or_like('worker_users_id', $key, 'both');
$this->db->or_like('business_id', $key, 'both');
$this->db->or_like('location_id', $key, 'both');
$this->db->or_like('area_id', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("users_works_at_area")->count_all_results();
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
		$data['_view'] = 'admin/users_works_at_area/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export users_works_at_area
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'users_works_at_area_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $users_works_at_areaData = $this->Users_works_at_area_model->get_all_users_works_at_area();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Super Users Id","Worker Users Id","Business Id","Location Id","Area Id","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($users_works_at_areaData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $users_works_at_area = $this->db->get('users_works_at_area')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/users_works_at_area/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Users_works_at_area controller