<?php

 /**
 * Author: Amirul Momenin
 * Desc:Business Controller
 *
 */
class Business extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Business_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of business table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['business'] = $this->Business_model->get_limit_business($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/business/index');
		$config['total_rows'] = $this->Business_model->get_count_business();
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
		
        $data['_view'] = 'admin/business/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save business
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
'business_name' => html_escape($this->input->post('business_name')),
'time_zone' => html_escape($this->input->post('time_zone')),
'address' => html_escape($this->input->post('address')),
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
			$data['business'] = $this->Business_model->get_business($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Business_model->update_business($id,$params);
				$this->session->set_flashdata('msg','Business has been updated successfully');
                redirect('admin/business/index');
            }else{
                $data['_view'] = 'admin/business/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $business_id = $this->Business_model->add_business($params);
				$this->session->set_flashdata('msg','Business has been saved successfully');
                redirect('admin/business/index');
            }else{  
			    $data['business'] = $this->Business_model->get_business(0);
                $data['_view'] = 'admin/business/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details business
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['business'] = $this->Business_model->get_business($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/business/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting business
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $business = $this->Business_model->get_business($id);

        // check if the business exists before trying to delete it
        if(isset($business['id'])){
            $this->Business_model->delete_business($id);
			$this->session->set_flashdata('msg','Business has been deleted successfully');
            redirect('admin/business/index');
        }
        else
            show_error('The business you are trying to delete does not exist.');
    }
	
	/**
     * Search business
	 * @param $start - Starting of business table's index to get query
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
$this->db->or_like('business_name', $key, 'both');
$this->db->or_like('time_zone', $key, 'both');
$this->db->or_like('address', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['business'] = $this->db->get('business')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/business/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('business_name', $key, 'both');
$this->db->or_like('time_zone', $key, 'both');
$this->db->or_like('address', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("business")->count_all_results();
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
		$data['_view'] = 'admin/business/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export business
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'business_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $businessData = $this->Business_model->get_all_business();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Id","Business Name","Time Zone","Address","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($businessData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $business = $this->db->get('business')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/business/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Business controller