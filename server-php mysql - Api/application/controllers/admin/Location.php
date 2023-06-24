<?php

 /**
 * Author: Amirul Momenin
 * Desc:Location Controller
 *
 */
class Location extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Location_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of location table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['location'] = $this->Location_model->get_limit_location($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/location/index');
		$config['total_rows'] = $this->Location_model->get_count_location();
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
		
        $data['_view'] = 'admin/location/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save location
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
'location_name' => html_escape($this->input->post('location_name')),
'location_code' => html_escape($this->input->post('location_code')),
'address' => html_escape($this->input->post('address')),
'timezone' => html_escape($this->input->post('timezone')),
'monday' => html_escape($this->input->post('monday')),
'monday_from' => html_escape($this->input->post('monday_from')),
'monday_to' => html_escape($this->input->post('monday_to')),
'tuesday' => html_escape($this->input->post('tuesday')),
'tuesday_from' => html_escape($this->input->post('tuesday_from')),
'tuesday_to' => html_escape($this->input->post('tuesday_to')),
'wednesday' => html_escape($this->input->post('wednesday')),
'wednesday_from' => html_escape($this->input->post('wednesday_from')),
'wednesday_to' => html_escape($this->input->post('wednesday_to')),
'thursday' => html_escape($this->input->post('thursday')),
'thursday_from' => html_escape($this->input->post('thursday_from')),
'thursday_to' => html_escape($this->input->post('thursday_to')),
'friday' => html_escape($this->input->post('friday')),
'friday_from' => html_escape($this->input->post('friday_from')),
'friday_to' => html_escape($this->input->post('friday_to')),
'saturday' => html_escape($this->input->post('saturday')),
'saturday_from' => html_escape($this->input->post('saturday_from')),
'saturday_to' => html_escape($this->input->post('saturday_to')),
'sunday' => html_escape($this->input->post('sunday')),
'sunday_from' => html_escape($this->input->post('sunday_from')),
'sunday_to' => html_escape($this->input->post('sunday_to')),
'notes' => html_escape($this->input->post('notes')),
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
			$data['location'] = $this->Location_model->get_location($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Location_model->update_location($id,$params);
				$this->session->set_flashdata('msg','Location has been updated successfully');
                redirect('admin/location/index');
            }else{
                $data['_view'] = 'admin/location/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $location_id = $this->Location_model->add_location($params);
				$this->session->set_flashdata('msg','Location has been saved successfully');
                redirect('admin/location/index');
            }else{  
			    $data['location'] = $this->Location_model->get_location(0);
                $data['_view'] = 'admin/location/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details location
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['location'] = $this->Location_model->get_location($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/location/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting location
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $location = $this->Location_model->get_location($id);

        // check if the location exists before trying to delete it
        if(isset($location['id'])){
            $this->Location_model->delete_location($id);
			$this->session->set_flashdata('msg','Location has been deleted successfully');
            redirect('admin/location/index');
        }
        else
            show_error('The location you are trying to delete does not exist.');
    }
	
	/**
     * Search location
	 * @param $start - Starting of location table's index to get query
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
$this->db->or_like('location_name', $key, 'both');
$this->db->or_like('location_code', $key, 'both');
$this->db->or_like('address', $key, 'both');
$this->db->or_like('timezone', $key, 'both');
$this->db->or_like('monday', $key, 'both');
$this->db->or_like('monday_from', $key, 'both');
$this->db->or_like('monday_to', $key, 'both');
$this->db->or_like('tuesday', $key, 'both');
$this->db->or_like('tuesday_from', $key, 'both');
$this->db->or_like('tuesday_to', $key, 'both');
$this->db->or_like('wednesday', $key, 'both');
$this->db->or_like('wednesday_from', $key, 'both');
$this->db->or_like('wednesday_to', $key, 'both');
$this->db->or_like('thursday', $key, 'both');
$this->db->or_like('thursday_from', $key, 'both');
$this->db->or_like('thursday_to', $key, 'both');
$this->db->or_like('friday', $key, 'both');
$this->db->or_like('friday_from', $key, 'both');
$this->db->or_like('friday_to', $key, 'both');
$this->db->or_like('saturday', $key, 'both');
$this->db->or_like('saturday_from', $key, 'both');
$this->db->or_like('saturday_to', $key, 'both');
$this->db->or_like('sunday', $key, 'both');
$this->db->or_like('sunday_from', $key, 'both');
$this->db->or_like('sunday_to', $key, 'both');
$this->db->or_like('notes', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['location'] = $this->db->get('location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/location/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('business_id', $key, 'both');
$this->db->or_like('location_name', $key, 'both');
$this->db->or_like('location_code', $key, 'both');
$this->db->or_like('address', $key, 'both');
$this->db->or_like('timezone', $key, 'both');
$this->db->or_like('monday', $key, 'both');
$this->db->or_like('monday_from', $key, 'both');
$this->db->or_like('monday_to', $key, 'both');
$this->db->or_like('tuesday', $key, 'both');
$this->db->or_like('tuesday_from', $key, 'both');
$this->db->or_like('tuesday_to', $key, 'both');
$this->db->or_like('wednesday', $key, 'both');
$this->db->or_like('wednesday_from', $key, 'both');
$this->db->or_like('wednesday_to', $key, 'both');
$this->db->or_like('thursday', $key, 'both');
$this->db->or_like('thursday_from', $key, 'both');
$this->db->or_like('thursday_to', $key, 'both');
$this->db->or_like('friday', $key, 'both');
$this->db->or_like('friday_from', $key, 'both');
$this->db->or_like('friday_to', $key, 'both');
$this->db->or_like('saturday', $key, 'both');
$this->db->or_like('saturday_from', $key, 'both');
$this->db->or_like('saturday_to', $key, 'both');
$this->db->or_like('sunday', $key, 'both');
$this->db->or_like('sunday_from', $key, 'both');
$this->db->or_like('sunday_to', $key, 'both');
$this->db->or_like('notes', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("location")->count_all_results();
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
		$data['_view'] = 'admin/location/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export location
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'location_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $locationData = $this->Location_model->get_all_location();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Id","Business Id","Location Name","Location Code","Address","Timezone","Monday","Monday From","Monday To","Tuesday","Tuesday From","Tuesday To","Wednesday","Wednesday From","Wednesday To","Thursday","Thursday From","Thursday To","Friday","Friday From","Friday To","Saturday","Saturday From","Saturday To","Sunday","Sunday From","Sunday To","Notes","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($locationData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $location = $this->db->get('location')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/location/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Location controller