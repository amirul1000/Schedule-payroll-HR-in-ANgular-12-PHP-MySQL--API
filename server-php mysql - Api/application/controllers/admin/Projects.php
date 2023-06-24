<?php

 /**
 * Author: Amirul Momenin
 * Desc:Projects Controller
 *
 */
class Projects extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Projects_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of projects table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['projects'] = $this->Projects_model->get_limit_projects($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/projects/index');
		$config['total_rows'] = $this->Projects_model->get_count_projects();
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
		
        $data['_view'] = 'admin/projects/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save projects
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		$file_project = "";
 
		$created_at = "";
$updated_at = "";

		if($id<=0){
															 $created_at = date("Y-m-d H:i:s");
														 }
else if($id>0){
															 $updated_at = date("Y-m-d H:i:s");
														 }

		$params = array(
					 'business_id' => html_escape($this->input->post('business_id')),
'super_users_id' => html_escape($this->input->post('super_users_id')),
'assign_to_users_id' => html_escape($this->input->post('assign_to_users_id')),
'location_id' => html_escape($this->input->post('location_id')),
'project_title' => html_escape($this->input->post('project_title')),
'project_description' => html_escape($this->input->post('project_description')),
'due_date' => html_escape($this->input->post('due_date')),
'notes' => html_escape($this->input->post('notes')),
'priority' => html_escape($this->input->post('priority')),
'project_status' => html_escape($this->input->post('project_status')),
'file_project' => $file_project,
'created_at' =>$created_at,
'updated_at' =>$updated_at,

				);
		
						$config['upload_path']          = "./public/uploads/images/projects";
						$config['allowed_types']        = "gif|jpg|png";
						$config['max_size']             = 100;
						$config['max_width']            = 1024;
						$config['max_height']           = 768;
						$this->load->library('upload', $config);
						
						if(isset($_POST) && count($_POST) > 0)     
							{  
							  if(strlen($_FILES['file_project']['name'])>0 && $_FILES['file_project']['size']>0)
								{
									if ( ! $this->upload->do_upload('file_project'))
									{
										$error = array('error' => $this->upload->display_errors());
									}
									else
									{
										$file_project = "uploads/images/projects/".$_FILES['file_project']['name'];
									    $params['file_project'] = $file_project;
									}
								}
								else
								{
									unset($params['file_project']);
								}
							}
							
						    
		if($id>0){
							                        unset($params['created_at']);
						                          }if($id<=0){
							                        unset($params['updated_at']);
						                          } 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['projects'] = $this->Projects_model->get_projects($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Projects_model->update_projects($id,$params);
				$this->session->set_flashdata('msg','Projects has been updated successfully');
                redirect('admin/projects/index');
            }else{
                $data['_view'] = 'admin/projects/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $projects_id = $this->Projects_model->add_projects($params);
				$this->session->set_flashdata('msg','Projects has been saved successfully');
                redirect('admin/projects/index');
            }else{  
			    $data['projects'] = $this->Projects_model->get_projects(0);
                $data['_view'] = 'admin/projects/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details projects
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['projects'] = $this->Projects_model->get_projects($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/projects/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting projects
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $projects = $this->Projects_model->get_projects($id);

        // check if the projects exists before trying to delete it
        if(isset($projects['id'])){
            $this->Projects_model->delete_projects($id);
			$this->session->set_flashdata('msg','Projects has been deleted successfully');
            redirect('admin/projects/index');
        }
        else
            show_error('The projects you are trying to delete does not exist.');
    }
	
	/**
     * Search projects
	 * @param $start - Starting of projects table's index to get query
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
$this->db->or_like('business_id', $key, 'both');
$this->db->or_like('super_users_id', $key, 'both');
$this->db->or_like('assign_to_users_id', $key, 'both');
$this->db->or_like('location_id', $key, 'both');
$this->db->or_like('project_title', $key, 'both');
$this->db->or_like('project_description', $key, 'both');
$this->db->or_like('due_date', $key, 'both');
$this->db->or_like('notes', $key, 'both');
$this->db->or_like('priority', $key, 'both');
$this->db->or_like('project_status', $key, 'both');
$this->db->or_like('file_project', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['projects'] = $this->db->get('projects')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/projects/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('business_id', $key, 'both');
$this->db->or_like('super_users_id', $key, 'both');
$this->db->or_like('assign_to_users_id', $key, 'both');
$this->db->or_like('location_id', $key, 'both');
$this->db->or_like('project_title', $key, 'both');
$this->db->or_like('project_description', $key, 'both');
$this->db->or_like('due_date', $key, 'both');
$this->db->or_like('notes', $key, 'both');
$this->db->or_like('priority', $key, 'both');
$this->db->or_like('project_status', $key, 'both');
$this->db->or_like('file_project', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("projects")->count_all_results();
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
		$data['_view'] = 'admin/projects/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export projects
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'projects_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $projectsData = $this->Projects_model->get_all_projects();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Business Id","Super Users Id","Assign To Users Id","Location Id","Project Title","Project Description","Due Date","Notes","Priority","Project Status","File Project","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($projectsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $projects = $this->db->get('projects')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/projects/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Projects controller