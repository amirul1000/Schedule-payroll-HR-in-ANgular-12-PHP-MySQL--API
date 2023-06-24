<?php

 /**
 * Author: Amirul Momenin
 * Desc:Users_training Controller
 *
 */
class Users_training extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Users_training_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of users_training table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['users_training'] = $this->Users_training_model->get_limit_users_training($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/users_training/index');
		$config['total_rows'] = $this->Users_training_model->get_count_users_training();
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
		
        $data['_view'] = 'admin/users_training/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save users_training
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'users_pay_details_id' => html_escape($this->input->post('users_pay_details_id')),
'training_type' => html_escape($this->input->post('training_type')),
'renewal_date' => html_escape($this->input->post('renewal_date')),
'notes' => html_escape($this->input->post('notes')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['users_training'] = $this->Users_training_model->get_users_training($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Users_training_model->update_users_training($id,$params);
				$this->session->set_flashdata('msg','Users_training has been updated successfully');
                redirect('admin/users_training/index');
            }else{
                $data['_view'] = 'admin/users_training/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $users_training_id = $this->Users_training_model->add_users_training($params);
				$this->session->set_flashdata('msg','Users_training has been saved successfully');
                redirect('admin/users_training/index');
            }else{  
			    $data['users_training'] = $this->Users_training_model->get_users_training(0);
                $data['_view'] = 'admin/users_training/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details users_training
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['users_training'] = $this->Users_training_model->get_users_training($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/users_training/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting users_training
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $users_training = $this->Users_training_model->get_users_training($id);

        // check if the users_training exists before trying to delete it
        if(isset($users_training['id'])){
            $this->Users_training_model->delete_users_training($id);
			$this->session->set_flashdata('msg','Users_training has been deleted successfully');
            redirect('admin/users_training/index');
        }
        else
            show_error('The users_training you are trying to delete does not exist.');
    }
	
	/**
     * Search users_training
	 * @param $start - Starting of users_training table's index to get query
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
$this->db->or_like('training_type', $key, 'both');
$this->db->or_like('renewal_date', $key, 'both');
$this->db->or_like('notes', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['users_training'] = $this->db->get('users_training')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/users_training/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_pay_details_id', $key, 'both');
$this->db->or_like('training_type', $key, 'both');
$this->db->or_like('renewal_date', $key, 'both');
$this->db->or_like('notes', $key, 'both');

		$config['total_rows'] = $this->db->from("users_training")->count_all_results();
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
		$data['_view'] = 'admin/users_training/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export users_training
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'users_training_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $users_trainingData = $this->Users_training_model->get_all_users_training();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Pay Details Id","Training Type","Renewal Date","Notes"); 
		   fputcsv($file, $header);
		   foreach ($users_trainingData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $users_training = $this->db->get('users_training')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/users_training/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Users_training controller