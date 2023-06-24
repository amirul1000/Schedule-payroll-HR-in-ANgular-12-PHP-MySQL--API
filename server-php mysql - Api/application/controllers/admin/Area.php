<?php

 /**
 * Author: Amirul Momenin
 * Desc:Area Controller
 *
 */
class Area extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Area_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of area table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['area'] = $this->Area_model->get_limit_area($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/area/index');
		$config['total_rows'] = $this->Area_model->get_count_area();
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
		
        $data['_view'] = 'admin/area/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save area
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
'area_name' => html_escape($this->input->post('area_name')),
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
			$data['area'] = $this->Area_model->get_area($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Area_model->update_area($id,$params);
				$this->session->set_flashdata('msg','Area has been updated successfully');
                redirect('admin/area/index');
            }else{
                $data['_view'] = 'admin/area/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $area_id = $this->Area_model->add_area($params);
				$this->session->set_flashdata('msg','Area has been saved successfully');
                redirect('admin/area/index');
            }else{  
			    $data['area'] = $this->Area_model->get_area(0);
                $data['_view'] = 'admin/area/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details area
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['area'] = $this->Area_model->get_area($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/area/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting area
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $area = $this->Area_model->get_area($id);

        // check if the area exists before trying to delete it
        if(isset($area['id'])){
            $this->Area_model->delete_area($id);
			$this->session->set_flashdata('msg','Area has been deleted successfully');
            redirect('admin/area/index');
        }
        else
            show_error('The area you are trying to delete does not exist.');
    }
	
	/**
     * Search area
	 * @param $start - Starting of area table's index to get query
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
$this->db->or_like('area_name', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['area'] = $this->db->get('area')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/area/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('business_id', $key, 'both');
$this->db->or_like('location_id', $key, 'both');
$this->db->or_like('area_name', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("area")->count_all_results();
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
		$data['_view'] = 'admin/area/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export area
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'area_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $areaData = $this->Area_model->get_all_area();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Id","Business Id","Location Id","Area Name","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($areaData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $area = $this->db->get('area')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/area/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Area controller