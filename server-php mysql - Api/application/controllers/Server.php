<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

date_default_timezone_set('Europe/London');

error_reporting(E_ALL & ~E_NOTICE);
/**
 * Author: Amirul Momenin
 * Desc:Server REST API
 */
class Server extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper(array(
            'cookie',
            'url'
        ));
        $this->load->database();
    }

    function serve()
    {
        $method = strtolower($this->input->server('REQUEST_METHOD'));
        switch ($method) {
            case "get":
                $this->get();
                break;
            case "post":
                $this->post();
                break;
            case "delete":
                $this->delete();
                break;
            case "put":
                $this->get();
                break;
        }
    }

    function get()
    {
        $cmd = $this->input->get('cmd');
        switch ($cmd) {
            case "users":			    
				//$this->db->order_by('id','ASC');
			    $this->db->select('users.*');
				$this->db->from('users_location');
			    $this->db->order_by('users.first_name', 'ASC');
				$this->db->where('users_location.business_id', $this->input->get('business_id'));
                $this->db->where('users_location.status', 'active');
				$this->db->join('users', 'users_location.users_id = users.id', 'left');
                $users = $this->db->get()->result_array();
				
				for($i=0;$i<count($users);$i++){
					if($users[$i]['first_name'] == 'OpenShift'){
						$temp = $users[0];
						$users[0] = $users[$i];
						$users[$i] = $temp;
						
					}
					
					if($users[$i]['first_name'] == 'EmptyShift'){
						$temp = $users[1];
						$users[1] = $users[$i];
						$users[$i] = $temp;
					}
				}
				
				  
				for($i=0;$i<count($users);$i++){
					$pay_details = array();
					$this->db->where('users_id',$users[$i]['id']);
					$this->db->where('business_id', $this->input->get('business_id'));
					$pay_details = $this->db->get('users_pay_details')->result_array();
					$db_error = $this->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}
					
					
					//leave
					$leave = array();
					$this->db->where('users_pay_details_id', $pay_details[0]['id']);
					$leave = $this->db->get('users_leave')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					}
					
					//training
					$training = array();
					$this->db->where('users_pay_details_id', $pay_details[0]['id']);
					$training = $this->db->get('users_training')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					}
					
					$users[$i]['payroll'] = $pay_details; 	
					$users[$i]['leave'] = $leave; 	
					$users[$i]['training'] = $training; 	
					
					$employeement_type= $pay_details[0]['employeement_type'];
					$pay_rate_type= $pay_details[0]['pay_rate_type'];
					/*$salary_type=$pay_details[0]['salary_type'];
					$salary_amount=$pay_details[0]['salary_amount'];
					$weekday_rate=$pay_details[0]['weekday_rate'];
					$public_holiday_rate=$pay_details[0]['public_holiday_rate'];
					$saterday_rate=$pay_details[0]['saterday_rate'];
					$sunday_rate=$pay_details[0]['sunday_rate'];
					$monday_rate=$pay_details[0]['monday_rate'];
					$tuesday_rate=$pay_details[0]['tuesday_rate'];
					$wednesday_rate=$pay_details[0]['wednesday_rate'];
					$thrusday_rate=$pay_details[0]['thrusday_rate'];
					$friday_rate=$pay_details[0]['friday_rate'];
					$hourly_rate=$pay_details[0]['hourly_rate'];
					$overtime_rate=$pay_details[0]['overtime_rate'];*/
					
					$this->db->order_by('start_date', 'desc');
					$this->db->select('schedule.*,area.area_name as area');
					$this->db->where('schedule.worker_users_id', $users[$i]['id']);
					$this->db->where('schedule.business_id', $this->input->get('business_id'));
					$this->db->where('schedule.start_date BETWEEN "'. date('Y-m-d', strtotime($this->input->get('start_date'))). '" and "'. date('Y-m-d', strtotime($this->input->get('end_date'))).'"');
					$this->db->join('area', 'area.id = schedule.area_id', 'left');
					$schedule = $this->db->get('schedule')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
					
					$users[$i]['total_hrs'] = 0;
					$users[$i]['total_pay'] = 0;
					
					for($j=0;$j<count($schedule);$j++){
						   $start_date = $schedule[$j]['start_date'];
						   $timestamp = strtotime($start_date);
                           $day = date('D', $timestamp);
						   
						   $this->load->model('Location_model');
						   $location = $this->Location_model->get_location($schedule[$j]['location_id']);
						   $ROSTER_DEFAULT_SHIFT_LEN = $location['ROSTER_DEFAULT_SHIFT_LEN'];
						 
						   $diff_time = strtotime($schedule[$j]['end_date'].' '.$schedule[$j]['finish']) - strtotime($schedule[$j]['start_date'].' '.$schedule[$j]['start']);
						   $SHIFT_HR = $diff_time/(60*60);
						   
						   $BASE_HR = 0;
						   $over_time_hrs = 0;
						   if($SHIFT_HR>$ROSTER_DEFAULT_SHIFT_LEN){
						   	$over_time_hrs = $SHIFT_HR-$ROSTER_DEFAULT_SHIFT_LEN;
							$BASE_HR = $ROSTER_DEFAULT_SHIFT_LEN;
						   }
						   else{
							 $over_time_hrs = 0;   
							 $BASE_HR = $SHIFT_HR;
						   }
						   
						    $public_holiday_rate = $pay_details[0]['public_holiday_rate'];
							$weekday_rate = $pay_details[0]['weekday_rate'];
							$overtime_rate = $pay_details[0]['overtime_rate'];	
							
							if($pay_rate_type=='Hourly'){
								if($day=='Sat'){
									 $saterday_rate= $pay_details[0]['saterday_rate'];
									
									 $users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                 $users[$i]['total_pay'] = $users[$i]['total_pay']+ $saterday_rate*$BASE_HR;
									 $users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
									
								}else if($day=='Sun'){ 
									$sunday_rate=$pay_details[0]['sunday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$sunday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}
								else{
								     $users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                 $users[$i]['total_pay'] = $users[$i]['total_pay']+$weekday_rate*$BASE_HR;
									 $users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;	
								}
								
														
							}/*else if($pay_rate_type=='Hourly (1.5 x Overtime)'){
								$public_holiday_rate=$pay_details[0]['public_holiday_rate'];
								$hourly_rate=$pay_details[0]['hourly_rate'];	
								
								$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					            $users[$i]['total_pay'] = $users[$i]['total_pay']+ $hourly_rate*$SHIFT_HR;
													
							}*/else if($pay_rate_type=='Salary'){
								$overtime_rate=$pay_details[0]['overtime_rate'];	
								
								$users[$i]['total_hrs'] = $pay_details[0]['salary_type'];
					            $users[$i]['total_pay'] = $pay_details[0]['salary_amount'];
								
							}/*else if($pay_rate_type=='Hourly (44 h + 1.5 x Overtime)'){
								$overtime_rate=$pay_details[0]['overtime_rate'];
								$hourly_rate=$pay_details[0]['hourly_rate'];
								
								$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$over_time_hrs;
					            $users[$i]['total_pay'] = $users[$i]['total_pay']+ $overtime_rate*$over_time_hrs;
								
								$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					            $users[$i]['total_pay'] = $users[$i]['total_pay']+ $hourly_rate*$SHIFT_HR;
							}*/else if($pay_rate_type=='Rates per Day'){								
								if($day=='Sat'){
									 $saterday_rate= $pay_details[0]['saterday_rate'];
									
									 $users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                 $users[$i]['total_pay'] = $users[$i]['total_pay']+ $saterday_rate*$BASE_HR;
									 $users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
									
								}else if($day=='Sun'){ 
									$sunday_rate=$pay_details[0]['sunday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$sunday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}else if($day=='Mon'){ 
									$monday_rate=$pay_details[0]['monday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$monday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}else if($day=='Tue'){ 
									$tuesday_rate=$pay_details[0]['tuesday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$tuesday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}else if($day=='Wed'){ 
									$wednesday_rate=$pay_details[0]['wednesday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$wednesday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}else if($day=='Thu'){ 
									$thrusday_rate=$pay_details[0]['thrusday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$thrusday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}else if($day=='Fri'){ 
									$friday_rate=$pay_details[0]['friday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$friday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}
							}
					
					}
				}
				  //ob_start();
				  //ob_get_clean();
                  echo json_encode($users);
				
                break;
			case "invite_users_list":			    
				//$this->db->order_by('id','ASC');
			    $this->db->select('users.*');
				$this->db->from('users_location');
			    $this->db->order_by('users.id', 'ASC');
				$this->db->where('users_location.business_id', $this->input->get('business_id'));
                $this->db->where('users_location.status', 'active');
				$this->db->join('users', 'users_location.users_id = users.id', 'left');
                $users = $this->db->get()->result_array();
				
				$users_arr = array();
				for($i=0;$i<count($users);$i++){
					  $this->load->helper('utility');
					  if(check_overlapping($users[$i]['id'],
					  $this->input('start'),
					  $this->input('finish'),
					  $this->input('start_date'),
					  $this->input('business_id'))){
					    continue;
					  }
					  $users_arr[] = $users[$i]; 
					}
                  echo json_encode($users_arr);
                break;	
			case "users_list":			    
				//$this->db->order_by('id','ASC');
			    $this->db->select('users.*');
				$this->db->from('users_location');
			    $this->db->order_by('users.id', 'ASC');
				$this->db->where('users_location.business_id', $this->input->get('business_id'));
                $this->db->where('users_location.status', 'active');
				$this->db->join('users', 'users_location.users_id = users.id', 'left');
                $users = $this->db->get()->result_array();
				
				$users_arr = array();
				for($i=0;$i<count($users);$i++){
					  $users_arr[] = $users[$i]; 
					}
                  echo json_encode($users_arr);
                break;		
		    case "check_exist_email":
			     $this->db->where('email', $this->input->get('email'));
				// Run the query
				$result = $this->db->get('users')->result_array();
				// Let's check if there are any results
				if(count($result) == 1) {
					
					$data = array(
						'id' => $result[0]['id'],
						'email' => $result[0]['email'],
						'first_name' => $result[0]['first_name'],
						'last_name' => $result[0]['last_name'],	
						'company_id' => $result[0]['company_id'],		
						'user_type' => $result[0]['user_type'],						
						'file_picture' => $result[0]['file_picture'],
						'validated' => true
					);
					
					$arr[0]['status'] = 'success';
					$arr[0]['user'] = $data;
					ob_clean();
					echo json_encode($arr);
				}else{
					
					$data = array(
						'id' => '',
						'email' => '',
						'first_name' => '',
						'last_name' => '',	
						'company_id' => '',		
						'user_type' => '',						
						'file_picture' => '',
						'validated' => false
					);
					
					$arr[0]['status'] = 'fail';
					$arr[0]['user'] = array();
					ob_clean();
					echo json_encode($arr);
				}
				break; 		
			case "login":
                 // grab user input
				$email = $this->security->xss_clean($this->input->get('email'));
				$password = $this->security->xss_clean($this->input->get('password'));
		
				// Prep the query
				$this->db->where('email', $email);
				$this->db->where('password', $password);
		
				// Run the query
				$result = $this->db->get('users')->result_array();
				// Let's check if there are any results
				if (count($result) == 1) {
					// If there is a user, then create session data
					$data = array(
						'id' => $result[0]['id'],
						'email' => $result[0]['email'],
						'first_name' => $result[0]['first_name'],
						'last_name' => $result[0]['last_name'],	
						'company_id' => $result[0]['company_id'],		
						'user_type' => $result[0]['user_type'],						
						'file_picture' => $result[0]['file_picture'],
						'validated' => true
					);
					$this->session->set_userdata($data);
					
					$arr[0]['status'] = 'success';
					$arr[0]['user'] = $data; 					
					ob_clean();
					echo json_encode($arr);
					exit;
				}
				// If the previous process did not validate
				// then return false.
				$data = array(
						'id' => '',
						'email' => '',
						'first_name' => '',
						'last_name' => '',	
						'company_id' => '',		
						'user_type' => '',						
						'file_picture' => '',
						'validated' => false
					);
				$arr[0]['status'] = 'fail';
				$arr[0]['user'] = $data; 
				ob_clean();
				echo json_encode($arr);
				exit;
                break;
		  case "register":
		         $this->load->database();
				 $this->db->where('email', $this->input->get('email'));
                 $result = $this->db->get('users')->result_array();
				 if(count($result)>0){
					 $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = "You already are a  registered user";	
					 echo json_encode($arr);
					 exit;	
				 }
				 
				 if (!filter_var(trim($this->input->get('email')), FILTER_VALIDATE_EMAIL)) {
					  $emailErr = "Invalid email format";
					  $arr[0]['status'] = 'fail'; 
					  $arr[0]['msg'] = $emailErr;	
					  echo json_encode($arr);
					  exit;	
					}
				 
                 $this->load->model('Users_model');
		         $params = array(
						'email' => html_escape(trim($this->input->get('email'))),
						'password' => html_escape($this->input->get('password')),
						'first_name' => html_escape($this->input->get('first_name')),
						'last_name' => html_escape($this->input->get('last_name')),
						'file_picture' => html_escape($this->input->get('file_picture')),
						'user_type' => html_escape($this->input->get('user_type')),
						'status' => 'active',
						'created_at' => date("Y-m-d H:i:s"),
					);
					$users_id = $this->Users_model->add_users($params);
					
				// grab user input
				$email = $this->security->xss_clean(trim($this->input->get('email')));
				// Run the query
				
				$this->db->where('email', $email);
				$result = $this->db->get('users')->result_array();
				$data = array();
				// Let's check if there are any results
				if (count($result) == 1) {
					// If there is a user, then create session data
					$data = array(
						'id' => $result[0]['id'],
						'email' => $result[0]['email'],
						'first_name' => $result[0]['first_name'],
						'last_name' => $result[0]['last_name'],	
						'company_id' => $result[0]['company_id'],		
						'user_type' => $result[0]['user_type'],						
						'file_picture' => $result[0]['file_picture'],
						'validated' => true
					);
				}
				else{
					$data = array(
						'id' => '',
						'email' => '',
						'first_name' => '',
						'last_name' => '',	
						'company_id' => '',		
						'user_type' => '',						
						'file_picture' => '',
						'validated' => false
					);
				}
				ob_clean();
				 
					if($users_id>0){
					   $arr[0]['status'] = 'success'; 	
					   $arr[0]['user'] = $data; 	
					   $arr[0]['msg'] = "Registration has been completed successfully";	
					   echo json_encode($arr);
					   exit;	
					}
					else{
					   $arr[0]['status'] = 'fail'; 	
					   $arr[0]['user'] = $data; 	
					   $arr[0]['msg'] = "Registration fail";		
					   echo json_encode($arr);
					   exit;	
					}
		       break;		
			case "forget_password":
			     $this->load->database();
				 $this->db->where('email', trim($this->input->get('email')));
                 $result = $this->db->get('users')->result_array();
				 if(count($result)==0){
					 $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = "This email is not a registered user";	
					 echo json_encode($arr);
					 exit;	
				 }
				 
				 if (!filter_var(trim($this->input->get('email')), FILTER_VALIDATE_EMAIL)) {
					  $emailErr = "Invalid email format";
					  $arr[0]['status'] = 'fail'; 
					  $arr[0]['msg'] = $emailErr;	
					  echo json_encode($arr);
					  exit;	
					}
				 
                 $this->load->model('Users_model');
		         $rand = rand(0000, 9999);
				 $params = array(
					'password' => $rand
				 );
				 $users_id = $this->Users_model->update_users($result[0]['id'], $params);
				 if ($users_id) {
					$this->load->library('email');
					$this->email->from('info@online.com', 'online');
					$this->email->to($result[0]['email']);
					// $this->email->cc('another@another-example.com');
					// $this->email->bcc('them@their-example.com');
	
					$this->email->subject('Reset Password');
					$this->email->message('Your New Password is ' . $rand);
	
					if($this->email->send()){
					   $arr[0]['status'] = 'success'; 	
					   $arr[0]['msg'] = "An email has been sent with new password.Login and change your password.";	
					   echo json_encode($arr);
					   exit;	
					}
				 }
			  break;   
			case "get_profile":
			     $this->load->database();
				 $this->db->where('id', $this->input->get('users_id'));
                 $result = $this->db->get('users')->result_array();
				 if(count($result)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Profile has been loaded successfully'; 
					 $arr[0]['user'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Profile loading failed'; 
					 $arr[0]['user'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
			break;  
	    case "get_payroll":
		        $this->db->where('super_users_id', $this->input->get('users_id'));
				$this->db->where('users_id', $this->input->get('selected_users_id'));
				$this->db->where('business_id', $this->input->get('business_id'));
				$result = $this->db->get('users_pay_details')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				//location
				$this->db->where('users_pay_details_id', $result[0]['id']);
				$result2 = $this->db->get('users_works_at_location')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				
				//leave
				$this->db->where('users_pay_details_id', $result[0]['id']);
				$leave = $this->db->get('users_leave')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				//training
				$this->db->where('users_pay_details_id', $result[0]['id']);
				$training = $this->db->get('users_training')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				//unavailability
				$this->db->where('users_pay_details_id', $result[0]['id']);
				$unavailability = $this->db->get('users_unavailability')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				
				ob_clean();
				if(count($result)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Payroll has been loaded successfully'; 
					 $arr[0]['payroll'] = $result;	
					 $arr[0]['location'] = $result2;	
					 $arr[0]['leave'] = $leave;	
					 $arr[0]['training'] = $training;	
					 $arr[0]['unavailability'] = $unavailability;
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Payroll loading has been failed'; 
					 $arr[0]['payroll'] = $result;	
					 $arr[0]['location'] = $result2;	
					 $arr[0]['leave'] = $leave;	
					 $arr[0]['training'] = $training;	
					 $arr[0]['unavailability'] = $unavailability;
					 echo json_encode($arr);
					 exit;	
				 }
			break;	 	
	    case "get_users_payroll":
				$this->db->where('users_id', $this->input->get('users_id'));
				//$this->db->where('business_id', $this->input->get('business_id'));
				$result = $this->db->get('users_pay_details')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				for($i=0;$i<count($result);$i++){
					//location
					$this->db->where('users_pay_details_id', $result[$i]['id']);
					$result2 = $this->db->get('users_works_at_location')->result_array();
					$db_error = $this->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}	
					
					//leave
					$this->db->where('users_pay_details_id', $result[$i]['id']);
					$leave = $this->db->get('users_leave')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					}
					
					
					//leave_apply
					$this->db->where('users_pay_details_id', $result[$i]['id']);
					$leave_apply = $this->db->get('users_leave_apply')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					}
					
					//training
					$this->db->where('users_pay_details_id', $result[$i]['id']);
					$training = $this->db->get('users_training')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					}
					
					//unavailability
					$this->db->where('users_pay_details_id', $result[$i]['id']);
					$unavailability = $this->db->get('users_unavailability')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					}
					
					$payroll[] = array('payroll' => array($result[$i]),
					                  'location' => $result2,	
									  'leave' => $leave,	
									  'leave_apply'=>$leave_apply,
									  'training' => $training,
									  'unavailability' => $unavailability);
					
				}
				
				ob_clean();
				if(count($result)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['payroll'] = $payroll;
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['payroll'] = '';
					 echo json_encode($arr);
					 exit;	
				 }
			break;					
		/************************************
			  Locations
		************************************/ 		
		case "get_all_locations":
		        $this->db->order_by('id','DESC');
		        $this->db->where('super_users_id', $this->input->get('users_id'));
				$this->db->where('business_id', $this->input->get('business_id'));
				$locations = $this->db->get('location')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				echo json_encode($locations);	
			break;	 
		case "location":
				$this->db->where('id', $this->input->get('location_id'));
		        $this->db->where('super_users_id', $this->input->get('users_id'));
				$this->db->where('business_id', $this->input->get('business_id'));
				$result = $this->db->get('location')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				ob_clean();
				if(count($result)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Location has been loaded successfully'; 
					 $arr[0]['location'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Location loading has been failed'; 
					 $arr[0]['location'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
			break;	
		/*
		  area
		*/	 
		case "get_all_areas_of_business":
		        $this->db->order_by('id','DESC');
		        //$this->db->where('location_id', $this->input->get('location_id'));
		        $this->db->where('super_users_id', $this->input->get('users_id'));
				$this->db->where('business_id', $this->input->get('business_id'));
				$area = $this->db->get('area')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				echo json_encode($area);
			break;		
		case "get_all_areas":
		        $this->db->order_by('id','DESC');
		        $this->db->where('location_id', $this->input->get('location_id'));
		        $this->db->where('super_users_id', $this->input->get('users_id'));
				$this->db->where('business_id', $this->input->get('business_id'));
				$area = $this->db->get('area')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				echo json_encode($area);
			break;		
		case "area":
		        $this->db->where('id', $this->input->get('area_id'));
				$this->db->where('location_id', $this->input->get('location_id'));
		        $this->db->where('super_users_id', $this->input->get('users_id'));
				$this->db->where('business_id', $this->input->get('business_id'));
				$result = $this->db->get('area')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				ob_clean();
				if(count($result)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Area has been loaded successfully'; 
					 $arr[0]['area'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Area loading has been failed'; 
					 $arr[0]['area'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
			break;	   
			case "access_level":
				      $enum_array = array();
				      $query = "SHOW COLUMNS FROM users LIKE 'user_type'";
					  $row = $this->db->query($query)->row()->Type;
					  $regex = "/'(.*?)'/";
					  preg_match_all($regex, $row, $enum_array);
					  $enum_fields = $enum_array[1];					  
					echo json_encode($enum_fields);
				  
			break;	
			case "projects":
		       //$this->db->where('company_id', $this->session->userdata('company_id'));
				$this->db->order_by('id','DESC');
				$projects = $this->db->get('projects')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				echo json_encode($projects);	
			break;	
			case "projects_details":
		        $this->db->where('id', $this->input->get('id'));
				$project = $this->db->get('projects')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				if(count($project)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Project has been loaded successfully'; 
					 $arr[0]['project'] = $project;	
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Project loading has been failed'; 
					 $arr[0]['project'] = $project;	
					 echo json_encode($arr);
					 exit;	
				 }
			break;	
			case "project_priority":
				      $enum_array = array();
				      $query = "SHOW COLUMNS FROM projects LIKE 'priority'";
					  $row = $this->db->query($query)->row()->Type;
					  $regex = "/'(.*?)'/";
					  preg_match_all($regex, $row, $enum_array);
					  $enum_fields = $enum_array[1];					  
					echo json_encode($enum_fields);
				  
			break;	 
			case "project_area":
		        $this->db->select('area.id,concat(location.location_name,"[",area.area_name,"]") as area_name');
				$this->db->from('area');
		        $this->db->where('area.super_users_id', $this->input->get('users_id'));
				$this->db->where('area.business_id', $this->input->get('business_id'));
				$this->db->join('location', 'area.location_id = location.id', 'left');
                $result = $this->db->get()->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				ob_clean();
				if(count($result)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Area has been loaded successfully'; 
					 $arr[0]['area'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Area loading has been failed'; 
					 $arr[0]['area'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
			break;	   
			case "project_status":
				      $enum_array = array();
				      $query = "SHOW COLUMNS FROM projects LIKE 'project_status'";
					  $row = $this->db->query($query)->row()->Type;
					  $regex = "/'(.*?)'/";
					  preg_match_all($regex, $row, $enum_array);
					  $enum_fields = $enum_array[1];					  
					echo json_encode($enum_fields);
				  
			break;	
		  case "archive_team_member":
		        $params = array(
				       'status'=>'inactive'
				);
		        $this->db->where('users_id', $this->input->get('users_id'));
				$this->db->where('business_id', $this->input->get('business_id'));
				$status = $this->db->update('users_location', $params);
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}
				if($status){
					   $arr[0]['status'] = 'success'; 	
					   $arr[0]['msg'] = "Member  has been archived successfully";	
				}
				else{
					$arr[0]['status'] = 'fail'; 	
					$arr[0]['msg'] = "Error-Archived fail";	
				}
				echo json_encode($arr);
		     break;	 
		 case "member_details":
			     $this->load->database();
				 $this->db->where('id', $this->input->get('id'));
                 $result = $this->db->get('users')->result_array();
				 if(count($result)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Profile has been loaded successfully'; 
					 $arr[0]['user'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Profile loading has been failed'; 
					 $arr[0]['user'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
			break; 
		  case "leave_details":
		         $this->load->database();
				 $this->db->where('id', $this->input->get('id'));
                 $leave = $this->db->get('users_leave')->result_array();
				 if(count($leave)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Leave has been loaded successfully'; 
					 $arr[0]['leave'] = $leave;	
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Leave loading has been failed'; 
					 $arr[0]['leave'] = $leave;	
					 echo json_encode($arr);
					 exit;	
				 }
		  break;	
		  case "training_details":
		         $this->load->database();
				 $this->db->where('id', $this->input->get('id'));
                 $training = $this->db->get('users_training')->result_array();
				 if(count($training)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Training has been loaded successfully'; 
					 $arr[0]['training'] = $training;	
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Training loading has been failed'; 
					 $arr[0]['training'] = $training;	
					 echo json_encode($arr);
					 exit;	
				 }
			 break;		
			case "unavailability_details":
		         $this->load->database();
				 $this->db->where('id', $this->input->get('id'));
                 $unavailability = $this->db->get('users_unavailability')->result_array();
				 if(count($unavailability)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Unavailability has been loaded successfully'; 
					 $arr[0]['unavailability'] = $unavailability;	
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Unavailability loading has been failed'; 
					 $arr[0]['unavailability'] = $unavailability;	
					 echo json_encode($arr);
					 exit;	
				 }
			 break;		   
			/************************************
			  Business
			************************************/ 
		   case "count_business":
				$this->db->where('super_users_id', $this->input->get('users_id'));
				$result = $this->db->from("business")->count_all_results();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				echo json_encode($result);
		    break;
	      case "save_business":
		        //make OpenShift EmptyShift
				$this->db->where('first_name', 'OpenShift');
				$resos = $this->db->get('users')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				if(count($resos)==0){
					    $params = array(
						   'first_name'=>'OpenShift',
						   'visiblity'=>'-1',
						   'user_type'=>'Employee',
						   'status'=>'active'
						);
						$this->db->insert('users',$params);
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
				}
				
				$this->db->where('first_name', 'EmptyShift');
				$reses = $this->db->get('users')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				if(count($reses)==0){
					    $params = array(
						   'first_name'=>'EmptyShift',
						   'visiblity'=>'-1',
						   'user_type'=>'Employee',
						   'status'=>'active'
						);
						$this->db->insert('users',$params);
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
				}
				///////////////////////
				
		        $id='';
				$business_id = $this->input->get('business_id');
				if($business_id>0){
					$params = array(
				     'super_users_id'=>$this->input->get('users_id'),
					 'business_name'=>$this->input->get('business_name'),
					 'time_zone'=>$this->input->get('time_zone'),
					 'address'=>$this->input->get('address'),
					 'updated_at'=>date("Y-m-d H:i:s"),
			     	);
					$this->db->where('id', $business_id);
					$status = $this->db->update('business', $params);
					$db_error = $this->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}
					$id = $this->input->get('business_id');
				}
				else{
					$params = array(
				     'super_users_id'=>$this->input->get('users_id'),
					 'business_name'=>$this->input->get('business_name'),
					 'time_zone'=>$this->input->get('time_zone'),
					 'address'=>$this->input->get('address'),
					 'created_at'=>date("Y-m-d H:i:s"),
				    );
					$this->db->insert('business',$params);
					$id = $this->db->insert_id();
				}
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				if($id>0){
				     $this->load->database();
					 $this->db->where('id',$id);
					 $this->db->where('super_users_id', $this->input->get('users_id'));
					 $result = $this->db->get('business')->result_array();
					 if(count($result)>0){
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'Business has been saved successfully'; 
						 $arr[0]['business'] = $result;	
						 echo json_encode($arr);
						 exit;	
					 }
					 else
					 {
						 $arr[0]['status'] = 'fail'; 
						 $arr[0]['msg'] = 'Business saving has been failed'; 
						 $arr[0]['business'] = $result;	
						 echo json_encode($arr);
						 exit;	
					 }
				}
		   break; 
		   case "get_all_business":
		        $this->db->where('super_users_id', $this->input->get('users_id'));
				$result = $this->db->get("business")->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				for($i=0;$i<count($result);$i++){
					    //$this->db->where('users_id', $this->input->get('users_id'));
						$this->db->where('business_id', $result[$i]['id']);
						$this->db->where('users_location.status', 'active');
						$result1 = $this->db->get("users_location")->result_array();
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
						
						$this->db->where('super_users_id', $this->input->get('users_id'));
						$this->db->where('business_id', $result[$i]['id']);
						$result2 = $this->db->get("location")->result_array();
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
						$result[$i]['users_total'] = count($result1);
						$result[$i]['location_total'] = count($result2);
				}
				
				echo json_encode($result);
		   break;
		   case "delete_business":
		        $this->db->where('super_users_id', $this->input->get('users_id'));
		        $status = $this->db->delete('business',array('id'=>$this->input->get('business_id')));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				if($status==true){
						//$this->db->where('users_id', $this->input->get('users_id'));
						$this->db->delete('users_location',array('business_id'=>$this->input->get('business_id')));
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
						
						//$this->db->where('users_id', $this->input->get('users_id'));
						$this->db->delete('location',array('business_id'=>$this->input->get('business_id')));
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
						
						//$this->db->where('users_id', $this->input->get('users_id'));
						$this->db->delete('area',array('business_id'=>$this->input->get('business_id')));
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
						
				
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'Business has been deleted successfully'; 						
						 echo json_encode($arr);
						 exit;	
					 }
					 else
					 {
						 $arr[0]['status'] = 'fail'; 
						 $arr[0]['msg'] = 'Business deleted has been failed'; 
						 echo json_encode($arr);
						 exit;	
					 }
		     
		   break;
		  case "business":
		        $this->db->where('super_users_id', $this->input->get('users_id'));
				$this->db->where('id', $this->input->get('business_id'));
				$result = $this->db->get("business")->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				if(count($result)>0){
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Business has been loaded successfully'; 
					 $arr[0]['business'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
				 else
				 {
				     $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Business loading has been failed'; 
					 $arr[0]['business'] = $result;	
					 echo json_encode($arr);
					 exit;	
				 }
		  break; 
		 //Schedule
		  case "load_schedule":
					$this->db->order_by('id', 'desc');
					$this->db->select('schedule.*,area.area_name as area,area.color_code');
					$this->db->where('schedule.business_id', $this->input->get('business_id'));
					$this->db->where('schedule.super_users_id', $this->input->get('super_users_id'));
					$this->db->where('schedule.start_date BETWEEN "'. date('Y-m-d', strtotime($this->input->get('start_date'))). '" and "'. date('Y-m-d', strtotime($this->input->get('end_date'))).'"');
					$this->db->join('area', 'area.id = schedule.area_id', 'left');
					$task = $this->db->get('schedule')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
				   $data = array();
				   
				   for($i=0;$i<count($task);$i++){
					      	$hr = ((strtotime($task[$i]['end_date'].' '.$task[$i]['finish'])-strtotime($task[$i]['start_date'].' '.$task[$i]['start']))/(60*60)).'hr';						
							$finish = date("g:i a",strtotime($task[$i]['finish']));
							$color  = $task[$i]['color_code'];
							if($task[$i]['publish_type'] ==2){
								$color  = '#00FF00';
							}
							if($this->input->get('resource_type')=='resource_by_area'){
								
								
								$data[] = array(
								  'id'   => $task[$i]['id'], 
								  'name' => date("Y-m-d",strtotime($task[$i]['start_date'])).$task[$i]['area_id'],
								  'resourceId'   => $task[$i]['area_id'],
								  'title'   => $finish.' '.$task[$i]['area'].' '.$hr,
								  'start'   => date("Y-m-d H:i:s",strtotime($task[$i]['start_date'].' '.$task[$i]['start'])),
								  'end'   => date("Y-m-d  H:i:s",strtotime($task[$i]['end_date'].' '.$task[$i]['finish'])),
								  'color' => $color,
								  'status'   => $task[$i]['status'],
								 );
							}
							else{
							
							$data[] = array(
							      'id'   => $task[$i]['id'], 
								  'name' => date("Y-m-d",strtotime($task[$i]['start_date'])).$task[$i]['worker_users_id'],
								  'resourceId'   => $task[$i]['worker_users_id'],
								  'title'   => $finish.' '.$task[$i]['area'].' '.$hr,
								  'start'   => date("Y-m-d H:i:s",strtotime($task[$i]['start_date'].' '.$task[$i]['start'])),
								  'end'   => date("Y-m-d  H:i:s",strtotime($task[$i]['end_date'].' '.$task[$i]['finish'])),
								  'color' => $color, 
								  'status'   => $task[$i]['status'],
								 );
							}
						}
					echo json_encode($data);
					
				//$calendarEvents = array('title' => 'Event name', 'start' => '2022-02-11');
               // echo json_encode($calendarEvents);	
					
			 break;	
		case "load_schedule_detail":
					$this->db->order_by('id', 'desc');
					$this->db->select('schedule.*,area.area_name as area,concat(users.first_name," ",users.last_name) as worker');
					$this->db->where('schedule.id',$this->input->get('id'));
					$this->db->join('users', 'schedule.worker_users_id = users.id', 'left');
					$this->db->join('area', 'area.id = schedule.area_id', 'left');
					$task = $this->db->get('schedule')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
					
					$this->db->order_by('id', 'asc');
					//$this->db->where('schedule.assign_by_users_id', $this->session->userdata('id'));
					$this->db->where('schedule_break_details.schedule_id',$this->input->get('id'));
					$task_detail = $this->db->get('schedule_break_details')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
					
					ob_clean();
				   
					$task[0]['more_detail'] = $task_detail;
					echo json_encode($task);
					
			 break;	 
			 //dropdown to select at header
		 case "schedule_location_area":
		        $this->db->where('super_users_id', $this->input->get('super_users_id'));
				$this->db->where('business_id', $this->input->get('business_id'));
		        $locations = $this->db->get('location')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				$arr_loc = array();
				$m=0;
				for($i=0;$i<count($locations);$i++){	
				
				    $arr_loc[$m] = array('id'=>$locations[$i]['id'],'location'=>$locations[$i]['location_name'],'loc_type'=>'parent');
					$m++;
					
					$this->db->where('location_id', $locations[$i]['id']);
					$this->db->where('business_id', $this->input->get('business_id'));
					$area = $this->db->get('area')->result_array();
					$db_error = $this->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}
					for($j=0;$j<count($area);$j++){
					   $arr_loc[$m] = array('id'=>$area[$j]['id'],'location'=>$area[$j]['area_name'],'loc_type'=>'child');
					   $m++;
					}
				}
				
				ob_clean();
				echo json_encode($arr_loc);
			break;
			//dropdown at modal popup
		  case "schedule_area":
		        $this->db->select('area.id,concat(location.location_name,"[",area.area_name,"]") as area_name');
				$this->db->from('area');
		        $this->db->where('area.super_users_id', $this->input->get('super_users_id'));
				$this->db->where('area.business_id', $this->input->get('business_id'));
				$this->db->join('location', 'area.location_id = location.id', 'left');
                $result = $this->db->get()->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				ob_clean();
				echo json_encode($result);
			break;	
		    case "schedule_resources_users":
			    $this->db->select('users.id,concat(users.first_name," ",users.last_name) as title,users.first_name');
				$this->db->from('users_location');			    
				$this->db->order_by('first_name','ASC');
				//$this->db->order_by('first_name', 'ASC');
				//$this->db->where('users_location.business_id='. $this->input->get('business_id'));
				//$this->db->or_where('users_works_at_location.business_id='. $this->input->get('business_id'));
				
				$this->db->where('(users_location.business_id = '. $this->input->get('business_id'). '
				  OR users_works_at_location.business_id =' . $this->input->get('business_id').')');
				
                $this->db->where('users_location.status', 'active');
				if($this->input->get('location_type')=='parent'){
				 // $this->db->where('users_location.location_id='.$this->input->get('location_id'));	
				 //  $this->db->or_where('users_works_at_location.location_id='.$this->input->get('location_id'));	
				 $this->db->where('(users_location.location_id = '.$this->input->get('location_id').'
				  OR users_works_at_location.location_id = '.$this->input->get('location_id').')');
				}
				
				if($this->input->get('location_type')=='child'){
					
				  //$this->db->where('area.id', $this->input->get('area_id'));	
				  //$this->db->join('area', 'users_location.location_id = area.location_id', 'left');
				  
				   $this->db->where('(users_location.location_id in ( SELECT location_id from area WHERE area.id='.$this->input->get('area_id').')
				  OR users_works_at_location.location_id in ( SELECT location_id from area WHERE area.id='.$this->input->get('area_id').'))');
				  
				}
				$this->db->join('users', 'users_location.users_id = users.id', 'left');
				$this->db->join('users_works_at_location', 'users_works_at_location.worker_users_id = users.id', 'left');
			    $users = $this->db->get()->result_array();
				
				//echo $this->db->last_query();
				
				for($i=0;$i<count($users);$i++){
					if($users[$i]['first_name'] == 'OpenShift'){
						$temp = $users[0];
						$users[0] = $users[$i];
						$users[$i] = $temp;
						
					}
					
					if($users[$i]['first_name'] == 'EmptyShift'){
						$temp = $users[1];
						$users[1] = $users[$i];
						$users[$i] = $temp;
					}
				}
				
				for($i=0;$i<count($users);$i++){
					$users[$i]['order'] = $i;
				}
				
				//echo "<pre>";
				//print_r($users);
				//echo "</pre>";
				
				
				for($i=0;$i<count($users);$i++){
					$this->db->where('users_id',$users[$i]['id']);
					$this->db->where('business_id', $this->input->get('business_id'));
					$result = $this->db->get('users_pay_details')->result_array();
					$db_error = $this->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}	
					$users[$i]['payroll'] = $result; 
				 }
                echo json_encode($users);
                break;   		  
	     case "schedule_users_payroll":
			       $this->db->select('distinct(users.id),concat(users.first_name," ",users.last_name) as title,users.first_name');
				$this->db->from('users_location');			    
				$this->db->order_by('first_name','ASC');
				//$this->db->order_by('first_name', 'ASC');
				//$this->db->where('users_location.business_id='. $this->input->get('business_id'));
				//$this->db->or_where('users_works_at_location.business_id='. $this->input->get('business_id'));
				
				$this->db->where('(users_location.business_id = '. $this->input->get('business_id'). '
				  OR users_works_at_location.business_id =' . $this->input->get('business_id').')');
				
                $this->db->where('users_location.status', 'active');
				if($this->input->get('location_type')=='parent'){
				 // $this->db->where('users_location.location_id='.$this->input->get('location_id'));	
				 //  $this->db->or_where('users_works_at_location.location_id='.$this->input->get('location_id'));	
				 $this->db->where('(users_location.location_id = '.$this->input->get('location_id').'
				  OR users_works_at_location.location_id = '.$this->input->get('location_id').')');
				}
				
				if($this->input->get('location_type')=='child'){
					
				  //$this->db->where('area.id', $this->input->get('area_id'));	
				  //$this->db->join('area', 'users_location.location_id = area.location_id', 'left');
				  
				   $this->db->where('(users_location.location_id in ( SELECT location_id from area WHERE area.id='.$this->input->get('area_id').')
				  OR users_works_at_location.location_id in ( SELECT location_id from area WHERE area.id='.$this->input->get('area_id').'))');
				  
				}
				$this->db->join('users', 'users_location.users_id = users.id', 'left');
				$this->db->join('users_works_at_location', 'users_works_at_location.worker_users_id = users.id', 'left');
			    $users = $this->db->get()->result_array();
				//echo $this->db->last_query();
				
				for($i=0;$i<count($users);$i++){
					if($users[$i]['first_name'] == 'OpenShift'){
						$temp = $users[0];
						$users[0] = $users[$i];
						$users[$i] = $temp;
						
					}
					
					if($users[$i]['first_name'] == 'EmptyShift'){
						$temp = $users[1];
						$users[1] = $users[$i];
						$users[$i] = $temp;
					}
				}
				
				  
				for($i=0;$i<count($users);$i++){
					$pay_details = array();
					$this->db->where('users_id',$users[$i]['id']);
					$this->db->where('business_id', $this->input->get('business_id'));
					$pay_details = $this->db->get('users_pay_details')->result_array();
					$db_error = $this->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}
					
					
					//leave
					$leave = array();
					$this->db->where('users_pay_details_id', $pay_details[0]['id']);
					$leave = $this->db->get('users_leave')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					}
					
					//training
					$training = array();
					$this->db->where('users_pay_details_id', $pay_details[0]['id']);
					$training = $this->db->get('users_training')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					}
					
					$users[$i]['payroll'] = $pay_details; 	
					$users[$i]['leave'] = $leave; 	
					$users[$i]['training'] = $training; 	
					
					$employeement_type= $pay_details[0]['employeement_type'];
					$pay_rate_type= $pay_details[0]['pay_rate_type'];
					/*$salary_type=$pay_details[0]['salary_type'];
					$salary_amount=$pay_details[0]['salary_amount'];
					$weekday_rate=$pay_details[0]['weekday_rate'];
					$public_holiday_rate=$pay_details[0]['public_holiday_rate'];
					$saterday_rate=$pay_details[0]['saterday_rate'];
					$sunday_rate=$pay_details[0]['sunday_rate'];
					$monday_rate=$pay_details[0]['monday_rate'];
					$tuesday_rate=$pay_details[0]['tuesday_rate'];
					$wednesday_rate=$pay_details[0]['wednesday_rate'];
					$thrusday_rate=$pay_details[0]['thrusday_rate'];
					$friday_rate=$pay_details[0]['friday_rate'];
					$hourly_rate=$pay_details[0]['hourly_rate'];
					$overtime_rate=$pay_details[0]['overtime_rate'];*/
					
					$this->db->order_by('start_date', 'desc');
					$this->db->select('schedule.*,area.area_name as area');
					$this->db->where('schedule.worker_users_id', $users[$i]['id']);
					$this->db->where('schedule.business_id', $this->input->get('business_id'));
					$this->db->where('schedule.start_date BETWEEN "'. date('Y-m-d', strtotime($this->input->get('start_date'))). '" and "'. date('Y-m-d', strtotime($this->input->get('end_date'))).'"');
					$this->db->join('area', 'area.id = schedule.area_id', 'left');
					$schedule = $this->db->get('schedule')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
					
					$users[$i]['total_hrs'] = 0;
					$users[$i]['total_pay'] = 0;
					
					for($j=0;$j<count($schedule);$j++){
						   $start_date = $schedule[$j]['start_date'];
						   $timestamp = strtotime($start_date);
                           $day = date('D', $timestamp);
						   
						   $this->load->model('Location_model');
						   $location = $this->Location_model->get_location($schedule[$j]['location_id']);
						   $ROSTER_DEFAULT_SHIFT_LEN = $location['ROSTER_DEFAULT_SHIFT_LEN'];
						 
						   $diff_time = strtotime($schedule[$j]['end_date'].' '.$schedule[$j]['finish']) - strtotime($schedule[$j]['start_date'].' '.$schedule[$j]['start']);
						   $SHIFT_HR = $diff_time/(60*60);
						   
						   $BASE_HR = 0;
						   $over_time_hrs = 0;
						   if($SHIFT_HR>$ROSTER_DEFAULT_SHIFT_LEN){
						   	$over_time_hrs = $SHIFT_HR-$ROSTER_DEFAULT_SHIFT_LEN;
							$BASE_HR = $ROSTER_DEFAULT_SHIFT_LEN;
						   }
						   else{
							 $over_time_hrs = 0;   
							 $BASE_HR = $SHIFT_HR;
						   }
						   
						    $public_holiday_rate = $pay_details[0]['public_holiday_rate'];
							$weekday_rate = $pay_details[0]['weekday_rate'];
							$overtime_rate = $pay_details[0]['overtime_rate'];	
							
							if($pay_rate_type=='Hourly'){
								if($day=='Sat'){
									 $saterday_rate= $pay_details[0]['saterday_rate'];
									
									 $users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                 $users[$i]['total_pay'] = $users[$i]['total_pay']+ $saterday_rate*$BASE_HR;
									 $users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
									
								}else if($day=='Sun'){ 
									$sunday_rate=$pay_details[0]['sunday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$sunday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}
								else{
								     $users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                 $users[$i]['total_pay'] = $users[$i]['total_pay']+$weekday_rate*$BASE_HR;
									 $users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;	
								}
								
														
							}/*else if($pay_rate_type=='Hourly (1.5 x Overtime)'){
								$public_holiday_rate=$pay_details[0]['public_holiday_rate'];
								$hourly_rate=$pay_details[0]['hourly_rate'];	
								
								$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					            $users[$i]['total_pay'] = $users[$i]['total_pay']+ $hourly_rate*$SHIFT_HR;
													
							}*/else if($pay_rate_type=='Salary'){
								$overtime_rate=$pay_details[0]['overtime_rate'];	
								
								$users[$i]['total_hrs'] = $pay_details[0]['salary_type'];
					            $users[$i]['total_pay'] = $pay_details[0]['salary_amount'];
								
							}/*else if($pay_rate_type=='Hourly (44 h + 1.5 x Overtime)'){
								$overtime_rate=$pay_details[0]['overtime_rate'];
								$hourly_rate=$pay_details[0]['hourly_rate'];
								
								$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$over_time_hrs;
					            $users[$i]['total_pay'] = $users[$i]['total_pay']+ $overtime_rate*$over_time_hrs;
								
								$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					            $users[$i]['total_pay'] = $users[$i]['total_pay']+ $hourly_rate*$SHIFT_HR;
							}*/else if($pay_rate_type=='Rates per Day'){								
								if($day=='Sat'){
									 $saterday_rate= $pay_details[0]['saterday_rate'];
									
									 $users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                 $users[$i]['total_pay'] = $users[$i]['total_pay']+ $saterday_rate*$BASE_HR;
									 $users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
									
								}else if($day=='Sun'){ 
									$sunday_rate=$pay_details[0]['sunday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$sunday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}else if($day=='Mon'){ 
									$monday_rate=$pay_details[0]['monday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$monday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}else if($day=='Tue'){ 
									$tuesday_rate=$pay_details[0]['tuesday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$tuesday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}else if($day=='Wed'){ 
									$wednesday_rate=$pay_details[0]['wednesday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$wednesday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}else if($day=='Thu'){ 
									$thrusday_rate=$pay_details[0]['thrusday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$thrusday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}else if($day=='Fri'){ 
									$friday_rate=$pay_details[0]['friday_rate'];
									
									$users[$i]['total_hrs'] = $users[$i]['total_hrs']+$SHIFT_HR;
					                $users[$i]['total_pay'] = $users[$i]['total_pay']+$friday_rate*$BASE_HR;
									$users[$i]['total_pay'] = $users[$i]['total_pay']+$overtime_rate*$over_time_hrs;
								}
							}
					
					}
				}
				  //ob_start();
				  //ob_get_clean();
                  echo json_encode($users);
				
                break;
		  case "schedule_resources_area":
			     $this->db->select('area.id,concat(location.location_name,"[",area.area_name,"]") as title');
				$this->db->from('area');
				if($this->input->get('location_type')=='parent'){
				  $this->db->where('area.location_id', $this->input->get('location_id'));	
				}
				if($this->input->get('location_type')=='child'){
				  $this->db->where('area.id', $this->input->get('area_id'));	
				}
		        $this->db->where('area.super_users_id', $this->input->get('super_users_id'));
				$this->db->where('area.business_id', $this->input->get('business_id'));
				$this->db->join('location', 'area.location_id = location.id', 'left');
                $result = $this->db->get()->result_array(); 
				echo $this->db->last_query();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				ob_clean();
				 echo json_encode($result);
                break;   
	       case "check_overlapping":
		            $arr =  array();
					$msg = "";
					$overlapping = false;
		            $start = $this->input->get('start');
					$finish = $this->input->get('finish');
					$start_date = $this->input->get('start_date');
					$end_date = strtotime($finish)<strtotime($start)?date("Y-m-d",(strtotime($start_date.'+1 day'))):$start_date;
		   
		            $this->db->where('users_id',$this->input->get('worker_users_id'));
					$this->db->where('business_id', $this->input->get('business_id'));
					$result = $this->db->get('users_pay_details')->result_array();
					$db_error = $this->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}	
					$users_pay_details_id = $result[0]['id']; 
					   
		            
					$this->db->where('users_pay_details_id', $users_pay_details_id);
					$this->db->where('start_date <= "'. $start_date.' '.$start. '" AND end_date >= "'. $end_date.' '.$finish. '"');
                    $leave = $this->db->get('users_leave')->result_array();
					$db_error = $this->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}
					
					//overlapping
					$this->db->order_by('id', 'desc');
					$this->db->select('schedule.*');
					$this->db->where('schedule.worker_users_id',$this->input->get('worker_users_id'));
					$this->db->where('schedule.business_id', $this->input->get('business_id'));
					$this->db->where('schedule.super_users_id', $this->input->get('super_users_id'));
					$this->db->where('CONCAT(start_date," ",start) BETWEEN "'. $start_date.' '.$start. '" AND "'. $end_date.' '.$finish. '"');
					$this->db->where('CONCAT(end_date," ",finish) BETWEEN "'. $start_date.' '.$start. '" AND  "'. $end_date.' '.$finish. '"');
					$task = $this->db->get('schedule')->result_array();	
							
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
					if(count($task)>0){
					   $overlapping=true;
					   $msg .= "You can not create schedule in this date range.The Previous Schedule is:".
					   date("D F jS,Y H:i:s A",strtotime($task[0]['start_date'].' '.$task[0]['start']))." And End:".date("D F jS,Y H:i:s A",strtotime($task[0]['end_date'].' '.$task[0]['finish']));
				
				       $arr[0]['status'] = 'success'; 	
					   $arr[0]['leave'] = 'overlapping'; 	 	
					   $arr[0]['unavailability'] = 'Overlapping'; 	 	
					   $arr[0]['msg'] =$msg ; 	
				       echo json_encode($arr);
					   exit;
					}
					
					//leave
					if(count($leave)>0){
					   $overlapping=true;
					   $msg .= "You can not create schedule in this date range.The leave is between Start:".
					   date("D F jS,Y",strtotime($leave[0]['start_date']))." And End:".date("D F jS,Y",strtotime($leave[0]['end_date']));
					}
					
					
					$this->db->where('users_pay_details_id', $users_pay_details_id);
					//$this->db->where("start_date >= '". $start_date."'");
					$unavailability = $this->db->get('users_unavailability')->result_array();
					$db_error = $this->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}
					
					//unavailability
					if(count($unavailability)>0){	
						$cal_end = strtotime($end_date.' '.$finish);
						$cal_start = strtotime($start_date.' '.$start);
						
					    for($i=0;$i<count($unavailability);$i++){
							
						$repeat_type = $unavailability[$i]['repeat_type'];						
						$una_start_date = $unavailability[$i]['start_date'];			
						$una_start_time = $unavailability[$i]['start_time'];			
						$una_end_date = $unavailability[$i]['end_date'];			
						$una_end_time = $unavailability[$i]['end_time'];			
						$una_Mon = $unavailability[$i]['Mon'];			
						$una_Tue = $unavailability[$i]['Tue'];			
						$una_Wed = $unavailability[$i]['Wed'];			
						$una_Thu = $unavailability[$i]['Thu'];			
						$una_Fri = $unavailability[$i]['Fri'];			
						$una_Sat = $unavailability[$i]['Sat'];			
						$una_Sun = $unavailability[$i]['Sun'];	
						
						$una_end = strtotime($una_end_date.' '.$una_end_time);
						$una_start = strtotime($una_start_date.' '.$una_start_time);		
						
						if($repeat_type=='Do not repeat'){
							
							if( ($cal_end<=$una_end && $cal_end>=$una_start) || 
							    ($cal_start>=$una_start && $cal_start<=$una_end)
							){
							   $overlapping=true;
						  	   $msg .= "You can not create schedule in this date range.The unavailability is between Start:".
							   date("D F jS,Y",strtotime($unavailability[$i]['start_date']))." ".date("H:i:s A",strtotime($unavailability[$i]['start_time']))." And 
							   End:".date("D F jS,Y",strtotime($unavailability[$i]['end_date']))." ".date("H:i:s A",strtotime($unavailability[$i]['end_time']));
							   break;
							}
							
						}
						else{
							   $timestamp = strtotime($start_date);
							   $day = date('D', $timestamp);
							
						       if($day=='Sat' && $unavailability[$i]['Sat']==1){
								    $overlapping=true;
					   				$msg .= "You can not create schedule in this date range.The unavaility type is ".$unavailability[$i]['repeat_type']."
									 and off day is Sat";
								   break;
								}else if($day=='Sun' && $unavailability[$i]['Sun']==1){ 
								    $overlapping=true;
					   				$msg .= "You can not create schedule in this date range.The unavaility type is ".$unavailability[$i]['repeat_type']."
									 and off day is Sun";
								   break;
									
								}else if($day=='Mon' && $unavailability[$i]['Mon']==1){ 
									 $overlapping=true;
					   				 $msg .= "You can not create schedule in this date range.The unavaility type is ".$unavailability[$i]['repeat_type']."
									 and off day is Mon";
									   break;
								}else if($day=='Tue' && $unavailability[$i]['Tue']==1){ 
									 $overlapping=true;
					   				 $msg .= "You can not create schedule in this date range.The unavaility type is ".$unavailability[$i]['repeat_type']."
									 and off day is Tue";
									   break;
								}else if($day=='Wed' && $unavailability[$i]['Wed']==1){ 
								    $overlapping=true;
					   				$msg .= "You can not create schedule in this date range.The unavaility type is ".$unavailability[$i]['repeat_type']."
									 and off day is Wed";
								   break;
								}else if($day=='Thu' && $unavailability[$i]['Thu']==1){ 
									 $overlapping=true;
					   				$msg .= "You can not create schedule in this date range.The unavaility type is ".$unavailability[$i]['repeat_type']."
									 and off day is Thu";
								   break;
								}else if($day=='Fri' && $unavailability[$i]['Fri']==1){ 
									 $overlapping=true;
					   				 $msg .= "You can not create schedule in this date range.The unavaility type is ".$unavailability[$i]['repeat_type']."
									 and off day is Fri";
									 break;
								}	
							  
						}
						
						}
					}
					
					
					if($overlapping==true){
					   $arr[0]['status'] = 'success'; 	
					   $arr[0]['leave'] = $leave; 	
					   $arr[0]['unavailability'] = $unavailability; 	
					   $arr[0]['msg'] = $msg;
				   	}
					else{
					   $arr[0]['status'] = 'fail'; 	
					   $arr[0]['leave'] = $leave; 	
					   $arr[0]['unavailability'] = $unavailability; 	
					   $arr[0]['msg'] = "";	
					}
				   echo json_encode($arr);
				   exit;
		        break;		
	       case "count_unpublished_schedule":
		            $this->db->order_by('id', 'desc');
					$this->db->select('schedule.*,area.area_name as area');
					$this->db->where('schedule.business_id', $this->input->get('business_id'));
					$this->db->where('schedule.super_users_id', $this->input->get('super_users_id'));
					$this->db->where('schedule.publish_type', '1');
					$this->db->where('schedule.start_date BETWEEN "'. date('Y-m-d', strtotime($this->input->get('start_date'))). '" and "'. date('Y-m-d', strtotime($this->input->get('end_date'))).'"');
					$this->db->join('area', 'area.id = schedule.area_id', 'left');
					$task = $this->db->from('schedule')->count_all_results();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
				   echo json_encode($task);
		   	     exit;
		        break;	
			 case "published_schedule":
			 
			        $pub_type = explode(",",$this->input->get('pub_type'));
					
		            $this->db->order_by('id', 'desc');
					$this->db->select('schedule.*,area.area_name as area');
					$this->db->where('schedule.business_id', $this->input->get('business_id'));
					$this->db->where('schedule.super_users_id', $this->input->get('super_users_id'));
					$this->db->where('schedule.publish_type', '1');
					$this->db->where('schedule.start_date BETWEEN "'. date('Y-m-d', strtotime($this->input->get('start_date'))). '" and "'. date('Y-m-d', strtotime($this->input->get('end_date'))).'"');
					$this->db->join('area', 'area.id = schedule.area_id', 'left');
					$task = $this->db->get('schedule')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
					 for($i=0;$i<count($task);$i++){
						$params = array(
										'publish_type'=>2
									); 
					    $this->db->where('id',$task[$i]['id']);
						$status = $this->db->update('schedule',$params);
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
								echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
								exit;
							}
							
						$this->load->helper('utility');
						$location = get_location_info($task[$i]['location_id']);
						$user = get_user_info($task[$i]['worker_users_id']);
						
						if(isset($user[0]['email'])){	
							// Mail it
							$subject = "Schedule Published from kinstaff.com"; // "You requested to change Your Password";
					
							$message_body = "Dear ".$user[0]['first_name']." ".$user[0]['last_name'].",<br>
											 Your Schedule has been published at kinstaff.com<br>
											 Your Schedule is Start:".date("D F jS,Y g:i a",strtotime($task[$i]['start_date']." ".$task[$i]['start']))." End:".date("D F jS,Y g:i a",strtotime($task[$i]['end_date']." ".$task[$i]['finish']))." <br>
											 Your Location is :".$location[0]['location_name']." ".$location[0]['address']."<br>
											 Thank You,<br>
											 kinstaff.com<br>";
							$this->load->helper('utility');				 
							send_email($user[0]['email'],$subject,$message_body);
							
						}
							
					 }
				   $arr[0]['status'] = 'success'; 	
				   $arr[0]['msg'] = 'Published has been completed successfully';	 
				   echo json_encode($arr);
		   	     exit;
		        break;		
			case "published_schedule_id":
			        $pub_type = explode(",",$this->input->get('pub_type'));
					
		            $this->db->order_by('id', 'desc');
					$this->db->select('schedule.*,area.area_name as area');
					$this->db->where('schedule.id', $this->input->get('id'));
					$this->db->where('schedule.business_id', $this->input->get('business_id'));
					$this->db->where('schedule.super_users_id', $this->input->get('super_users_id'));
					//$this->db->where('schedule.publish_type', '1');
					//$this->db->where('schedule.start_date BETWEEN "'. date('Y-m-d', strtotime($this->input->get('start_date'))). '" and "'. date('Y-m-d', strtotime($this->input->get('end_date'))).'"');
					$this->db->join('area', 'area.id = schedule.area_id', 'left');
					$task = $this->db->get('schedule')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
					 for($i=0;$i<count($task);$i++){
						$params = array(
										'publish_type'=>2
									); 
					    $this->db->where('id',$task[$i]['id']);
						$status = $this->db->update('schedule',$params);
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
								echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
								exit;
							}
							
						$this->load->helper('utility');
						$location = get_location_info($task[$i]['location_id']);
						$user = get_user_info($task[$i]['worker_users_id']);
						
						if(isset($user[0]['email'])){	
							// Mail it
							$subject = "Schedule Published from kinstaff.com"; // "You requested to change Your Password";
					
							$message_body = "Dear ".$user[0]['first_name']." ".$user[0]['last_name'].",<br>
											 Your Schedule has been published at kinstaff.com<br>
											 Your Schedule is Start:".date("D F jS,Y g:i a",strtotime($task[$i]['start_date']." ".$task[$i]['start']))." End:".date("D F jS,Y g:i a",strtotime($task[$i]['end_date']." ".$task[$i]['finish']))." <br>
											 Your Location is :".$location[0]['location_name']." ".$location[0]['address']."<br>
											 Thank You,<br>
											 kinstaff.com<br>";
							$this->load->helper('utility');				 
							send_email($user[0]['email'],$subject,$message_body);
						}
							
					 }
				   $arr[0]['status'] = 'success'; 	
				   $arr[0]['msg'] = 'Published has been completed successfully';	 
				   echo json_encode($arr);
		   	     exit;
		        break;	
		  case "invite_schedule":
			        $users_id_list = json_decode($this->input->get('users_id_list'));
					//print_r($users_id_list);
					//exit;
					
		            $this->db->order_by('id', 'desc');
					$this->db->select('schedule.*,area.area_name as area');
					$this->db->where('schedule.id', $this->input->get('id'));
					$this->db->where('schedule.business_id', $this->input->get('business_id'));
					$this->db->where('schedule.super_users_id', $this->input->get('super_users_id'));
					//$this->db->where('schedule.publish_type', '1');
					//$this->db->where('schedule.start_date BETWEEN "'. date('Y-m-d', strtotime($this->input->get('start_date'))). '" and "'. date('Y-m-d', strtotime($this->input->get('end_date'))).'"');
					$this->db->join('area', 'area.id = schedule.area_id', 'left');
					$task = $this->db->get('schedule')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
					 for($i=0;$i<count($users_id_list);$i++){
						$this->load->helper('utility');
						$location = get_location_info($task[$i]['location_id']);
						$user = get_user_info($users_id_list[$i]);
						
						if(isset($user[0]['email'])){
							// Mail it
							$subject = "You are invited to join the defined schedule in kinstaff.com"; // "You requested to change Your Password";
					
							$message_body = "Dear ".$user[0]['first_name']." ".$user[0]['last_name'].",<br>
											 Your Schedule is Start:".date("D F jS,Y g:i a",strtotime($task[$i]['start_date']." ".$task[$i]['start']))." End:".date("D F jS,Y g:i a",strtotime($task[$i]['end_date']." ".$task[$i]['finish']))." <br>
											 Your Location is :".$location[0]['location_name']." ".$location[0]['address']."<br>
											 Go to <a href=\"".site_url('invite/index/'.base64_encode($task[0]['id']).'/'.base64_encode($user[0]['id']))."\">Accept</a><br>
											 Thank You,<br>
											 kinstaff.com<br>";
							$this->load->helper('utility');				 
							send_email($user[0]['email'],$subject,$message_body);		
						}
							
					 }
				   $arr[0]['status'] = 'success'; 	
				   $arr[0]['msg'] = 'Invitation has been completed successfully';	 
				   echo json_encode($arr);
		   	     exit;
		        break;	
				
				
		    //user dashboard
			//user load schedule
			//Schedule
		  case "get_user_schedule":
					$this->db->order_by('id', 'desc');
					$this->db->select('schedule.*,area.area_name as area,area.color_code');
					//$this->db->where('schedule.business_id', $this->input->get('business_id'));
					$this->db->where('schedule.worker_users_id', $this->input->get('users_id'));
					$this->db->where('schedule.start_date BETWEEN "'. date('Y-m-d', strtotime($this->input->get('start_date'))). '" and "'. date('Y-m-d', strtotime($this->input->get('end_date'))).'"');
					$this->db->join('area', 'area.id = schedule.area_id', 'left');
					$task = $this->db->get('schedule')->result_array();
					$db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					} 
				   $data = array();
				   
				   for($i=0;$i<count($task);$i++){
					      	$hr = ((strtotime($task[$i]['end_date'].' '.$task[$i]['finish'])-strtotime($task[$i]['start_date'].' '.$task[$i]['start']))/(60*60)).'hr';						
							$finish = date("g:i a",strtotime($task[$i]['finish']));
							$color  = $task[$i]['color_code'];
							if($task[$i]['publish_type'] ==2){
								$color  = '#00FF00';
							}
						 $data[] = array(
						  'id'   => $task[$i]['id'], 
						  'name' => date("Y-m-d",strtotime($task[$i]['start_date'])).$task[$i]['area_id'],
						  'resourceId'   => $task[$i]['area_id'],
						  'title'   => $finish.' '.$task[$i]['area'].' '.$hr,
						  'start'   => date("Y-m-d H:i:s",strtotime($task[$i]['start_date'].' '.$task[$i]['start'])),
						  'end'   => date("Y-m-d  H:i:s",strtotime($task[$i]['end_date'].' '.$task[$i]['finish'])),
						  'color' => $color,
						  'status'   => $task[$i]['status'],
						 );
							
						}
					echo json_encode($data);
			 break;			
				
			case "get_share_with":	
			    $data_arr = array();
			    $data_arr[] = 'All';
				
			    $this->db->select('users.*');
				$this->db->from('users_location');
			    $this->db->order_by('users.id', 'ASC');
				$this->db->where('users_location.business_id', $this->input->get('business_id'));
                $this->db->where('users_location.status', 'active');
				$this->db->join('users', 'users_location.users_id = users.id', 'left');
                $users = $this->db->get()->result_array();
				
			
				for($i=0;$i<count($users);$i++){
					  if($users[$i]['first_name']=='OpenShift' || $users[$i]['first_name']=='EmptyShift'){
					   continue;
					  }
					  $data_arr[] = $users[$i]['first_name']; 
					}


                $this->db->where('id', $this->input->get('area_id'));
				//$this->db->where('location_id', $this->input->get('location_id'));
		        $this->db->where('super_users_id', $this->input->get('users_id'));
				$this->db->where('business_id', $this->input->get('business_id'));
				$result = $this->db->get('area')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
				for($i=0;$i<count($result);$i++){
					  $data_arr[] = $result[$i]['area_name']; 
					}
			
			    $this->db->where('super_users_id', $this->input->get('users_id'));
				$result = $this->db->get("business")->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				for($i=0;$i<count($result);$i++){
					  $data_arr[] = $result[$i]['business_name']; 
					}

				
				echo json_encode($data_arr);
		        break;		
					
		case "get_news":
				
				$this->db->select('users.*,news.*');
				$this->db->from('news');
			    $this->db->order_by('news.id', 'ASC');
				$this->db->where('business_id', $this->input->get('business_id'));
				//$this->db->where('users_location.business_id', $this->input->get('business_id'));
                //$this->db->where('users_location.status', 'active');
				$this->db->join('users', 'news.creator_users_id = users.id', 'left');
                $result = $this->db->get()->result_array();
				
				
				/*$this->db->where('business_id', $this->input->get('business_id'));
				$result = $this->db->get('news')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}*/		
			echo json_encode($result);
		    break;	
		case "get_leave_by_business":
			    $this->db->select('users.*');
				$this->db->from('users_location');
			    $this->db->order_by('users.id', 'ASC');
				//$this->db->where("users","id>0");
				$this->db->where('users_location.business_id', $this->input->get('business_id'));
                $this->db->where('users_location.status', 'active');
				$this->db->join('users', 'users_location.users_id = users.id', 'left');
                $users = $this->db->get()->result_array();
				
				
				$ul = array();
				foreach($users as $each){
					if($each['id']>0){
					$ul[] = "'".$each['id']."'";
					}
				}
				
				$result = array();
				if(count($ul)>0){
				$this->db->order_by('users_leave_apply.id', 'desc');
				$this->db->select('users_leave_apply.*,users.first_name,users.last_name');
				$this->db->from('users_leave_apply');
				$this->db->where('users_leave_apply.users_id  in ('.implode(',',$ul).')');
				$this->db->join('users', 'users.id = users_leave_apply.users_id', 'left');
				$result = $this->db->get()->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				}
				echo json_encode($result);
			 break;	
			 
		case "accept_leave_apply":
		      $this->load->model('Users_leave_apply_model');
			  $this->load->model('Users_leave_model');
		      $ula = $this->Users_leave_apply_model->get_users_leave_apply($this->input->get('id'));
			  
			  
			  $users_id = $ula['users_id'];
			  $users_pay_details_id  = $ula['users_pay_details_id'];
			  $start_date  = $ula['start_date'];
			  $end_date  = $ula['end_date'];
			  $leave_type  = $ula['leave_type'];
			  $status  = $ula['status'];
			 
			  $params = array(
					 'users_pay_details_id' => $users_pay_details_id,
					'start_date' => $start_date,
					'end_date' => $end_date,
					'leave_type' => $leave_type,
					
									);
		      $users_leave_id = $this->Users_leave_model->add_users_leave($params);
			  ob_clean();
				if($users_leave_id>0){
					//update leave apply
					 $this->load->model('Users_leave_apply_model');
					 $params = array(
					 'status' =>'accept'
									);
		             $this->Users_leave_apply_model->update_users_leave_apply($this->input->get('id'),$params);
					
					 $arr[0]['status'] = 'success'; 
					 $arr[0]['msg'] = 'Leave apply has been added to HR Leave successfully'; 
					 echo json_encode($arr);
					 exit;	
				 }
		break;	
		
		
		case "reject_leave_apply":
		     //update leave apply
			 $this->load->model('Users_leave_apply_model');
			 $params = array(
			 'status' =>'reject'
							);
			 $this->Users_leave_apply_model->update_users_leave_apply($this->input->get('id'),$params);
			
			 $arr[0]['status'] = 'success'; 
			 $arr[0]['msg'] = 'Leave apply has rejected successfully'; 
			 echo json_encode($arr);
			 exit;	
		
		break;	      
			  	 	  	 
	    		  						
        }
    }

    function post()
    {
        $cmd = $this->input->get('cmd');
		switch ($cmd) {
			/************************
			    Schedule
			**********************/  
			case "save_schedule":	
				$request = '';
				  $postdata = file_get_contents("php://input");
					if (isset($postdata)) {
						$request     = json_decode($postdata);	
					}
					
			     $id = $request->id; 
					
				 $status = $this->db->delete('schedule_break_details',array('schedule_id'=>$id));
				 $db_error = $this->db->error();
				 if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				 }
				 
				 $this->load->model('Area_model');
				 $area = $this->Area_model->get_area($request->area_id);
					
					
				 $this->load->model('Schedule_model');
				 
			      $created_at = "";
				  $updated_at = "";
				  
				

				if($id<=0){
					 $created_at = date("Y-m-d H:i:s");
				 }
				else if($id>0){
					 $updated_at = date("Y-m-d H:i:s");
				 }

				$params = array(
							'super_users_id' => $request->super_users_id,
							'worker_users_id' => $request->worker_users_id,
							'business_id' => $area['business_id'],
							'location_id' => $area['location_id'],
							'area_id' => $request->area_id,
							'start_date' => $request->start_date,
							'end_date' => strtotime($request->finish)<strtotime($request->start)?date("Y-m-d",(strtotime($request->start_date.'+1 day'))):$request->start_date,
							'start' => $request->start,
							'finish' => $request->finish,
							'meal_break' => $request->meal_break,
							'rest_break' => $request->rest_break,
							'notes' => $request->notes,
							'status' => $request->status,
							'publish_type' => 1,
							'created_at' =>$created_at,
							'updated_at' =>$updated_at,
											);
											
											
				/*$this->load->helper('utility');
				  if(check_overlapping($request->worker_users_id,$request->start,
					 $request->finish,
					 $request->start_date,
					 $area['business_id'])){
							echo json_encode(array('status'=>'success','msg'=>'Overlapping occures'));
							exit;
				  }		*/		
											
							 
					if($id>0){
						unset($params['created_at']);
					  }if($id<=0){
						unset($params['updated_at']);
					  } 
					//update		
					if(isset($id) && $id>0){
						$data['schedule'] = $this->Schedule_model->get_schedule($id);
						//if(isset($_POST) && count($_POST) > 0){   
						     unset($params['publish_type']);
							$this->Schedule_model->update_schedule($id,$params);
							
							$more_detail = $request->more_detail;
							for($i=0;$i<count($more_detail);$i++){
								$this->load->model('Schedule_break_details_model');
								$created_at = date("Y-m-d H:i:s");
								$updated_at = date("Y-m-d H:i:s");
								$params = array(
											'schedule_id' => $id,
											'type' => $more_detail[$i]->brkd_type,
											'duration' => $more_detail[$i]->brkd_duration,
											'start' => $more_detail[$i]->brkd_start,
											'finish' => $more_detail[$i]->brkd_finish,
											'created_at' =>$created_at,
											'updated_at' =>$updated_at,
										);
								$this->Schedule_break_details_model->add_schedule_break_details($params);
							}
							
							ob_clean();
							echo json_encode(array('status'=>'success','msg'=>'Schedule has been updated successfully'));
						//}
					} //save
					else{
						//if(isset($_POST) && count($_POST) > 0){   
							$schedule_id = $this->Schedule_model->add_schedule($params);
							
							$more_detail = $request->more_detail;
							for($i=0;$i<count($more_detail);$i++){
								$this->load->model('Schedule_break_details_model');
								$created_at = date("Y-m-d H:i:s");
								$updated_at = date("Y-m-d H:i:s");
								$params = array(
											'schedule_id' => $schedule_id,
											'type' => $more_detail[$i]->brkd_type,
											'duration' => $more_detail[$i]->brkd_duration,
											'start' => $more_detail[$i]->brkd_start,
											'finish' => $more_detail[$i]->brkd_finish,
											'created_at' =>$created_at,
											'updated_at' =>$updated_at,
										);
								$this->Schedule_break_details_model->add_schedule_break_details($params);
							}
							
							
							ob_clean();
							echo json_encode(array('status'=>'success','msg'=>'Schedule has been saved successfully'));
						//}
					}
				break;
			   case "delete_schedule":
			      $request = '';
				  $postdata = file_get_contents("php://input");
					if (isset($postdata)) {
						$request     = json_decode($postdata);	
					}
					
				 $id = $request->id;
				 $status = $this->db->delete('schedule_break_details',array('schedule_id'=>$id));
				 $db_error = $this->db->error();
				 if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				 }
					
			     $this->load->model('Schedule_model');
			     $status = $this->Schedule_model->delete_schedule($request->id);
				 ob_clean();
				 echo json_encode(array('status'=>'success','msg'=>'Schedule has been deleted successfully'));	
				break;
		   case "drag_drop_schedule":
		       $request = '';
			   $users_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
					
				$id  = $request->id;
				$old_resource_id  = $request->old_resource_id;
				$new_resource_id  = $request->new_resource_id;
				$resource_type  = $request->resource_type;
				$dropped_date = $request->dropped_date;
				
				
				$this->load->model('Schedule_model');
			    $schedule = $this->Schedule_model->get_schedule($request->id);
				
				$finish = $schedule['finish'];
				$start = $schedule['start'];
				$start_date  = $dropped_date;
				
				$params = array();
				if($resource_type=='resource_by_area'){
					$params = array(
								'area_id' => $new_resource_id[0],
								'start_date' => $dropped_date,
								'end_date' => strtotime($finish)<strtotime($start)?date("Y-m-d",(strtotime($start_date.'+1 day'))):$start_date,
							);
				}else{
					
					 $params = array(
								'worker_users_id' => $new_resource_id[0],
								'start_date' => $dropped_date,
								'end_date' => strtotime($finish)<strtotime($start)?date("Y-m-d",(strtotime($start_date.'+1 day'))):$start_date,
							);
				}
				
				//print_r($params); 
			    
				$this->load->model('Schedule_model');
			    $status = $this->Schedule_model->update_schedule($request->id,$params);
				
				if($status){
				 ob_clean();
				 echo json_encode(array('status'=>'success','msg'=>'Schedule has been dropped'));
				}
		   
		        break;		
		  case "copy_paste_schedule":
		       $request = '';
			   $users_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
					
				$id  = $request->id;
				$old_resource_id  = $request->old_resource_id;
				$new_resource_id  = $request->new_resource_id;
				$resource_type  = $request->resource_type;
				$dropped_date = $request->dropped_date;
				
				$this->load->model('Schedule_model');
			    $schedule = $this->Schedule_model->get_schedule($request->id);
				
				$finish = $schedule['finish'];
				$start = $schedule['start'];
				$start_date  = $dropped_date;
				
				$params = array();
				if($resource_type=='resource_by_area'){
					$params = array(
								'super_users_id' => $schedule['super_users_id'],
								'worker_users_id' => $schedule['worker_users_id'],
								'business_id' => $schedule['business_id'],
								'location_id' => $schedule['location_id'],
								'start' => $schedule['start'],
								'finish' => $schedule['finish'],
								'meal_break' => $schedule['meal_break'],
								'rest_break' => $schedule['rest_break'],
								'notes' => $schedule['notes'],
								'status' => $schedule['status'],
								'created_at' => date("Y-m-d H:i:s"),
								'area_id' => $new_resource_id,
								'publish_type'=>1, 
								'start_date' => $dropped_date,
								'end_date' => strtotime($finish)<strtotime($start)?date("Y-m-d",(strtotime($start_date.'+1 day'))):$start_date,

							);
				}else{
					
					 $params = array(
					            'super_users_id' => $schedule['super_users_id'],
								'business_id' => $schedule['business_id'],
								'location_id' => $schedule['location_id'],
								'area_id' => $schedule['area_id'],
								'start' => $schedule['start'],
								'finish' => $schedule['finish'],
								'meal_break' => $schedule['meal_break'],
								'rest_break' => $schedule['rest_break'],
								'notes' => $schedule['notes'],
								'status' => $schedule['status'],
								'publish_type'=>1, 
								'created_at' => date("Y-m-d H:i:s"),
								'worker_users_id' => $new_resource_id,
								'start_date' => $dropped_date,
								'end_date' => strtotime($finish)<strtotime($start)?date("Y-m-d",(strtotime($start_date.'+1 day'))):$start_date,

							);
				}
				
				//print_r($params); 
				$this->load->model('Schedule_model');
			    $schedule_id = $this->Schedule_model->add_schedule($params);
				
				
			   //schedule_break_details
			   $this->db->where('schedule_id', $request->id);
			   $more_detail = $this->db->get("schedule_break_details")->result_array();
			   $db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				for($i=0;$i<count($more_detail);$i++){
					$this->load->model('Schedule_break_details_model');
					$params = array(
								'schedule_id' => $schedule_id,
								'type' => $more_detail[$i]['type'],
								'duration' => $more_detail[$i]['duration'],
								'start' => $more_detail[$i]['start'],
								'finish' => $more_detail[$i]['finish'],
								'created_at' =>date("Y-m-d H:i:s"),
								'updated_at' =>date("Y-m-d H:i:s")
							);
					$this->Schedule_break_details_model->add_schedule_break_details($params);
				}
				
				
				
				if($schedule_id){
				 ob_clean();
				 echo json_encode(array('status'=>'success','msg'=>'Schedule has been pasted successfully'));
				}
		   
		        break;	
		  case "repeat_seven_days_schedule":
		       $request = '';
			   $users_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
					
				$id  = $request->id;
				
				
				$this->load->model('Schedule_model');
			    $schedule = $this->Schedule_model->get_schedule($request->id);
				
				for($k=1;$k<=7;$k++){
					$start_date = date("Y-m-d",(strtotime($schedule['start_date'].'+'.$k.' day')));
					$end_date = date("Y-m-d",(strtotime($schedule['end_date'].'+'.$k.' day')));
					
					
					 $this->load->helper('utility');
					  if(check_overlapping($schedule['worker_users_id'],$schedule['start'],
						 $schedule['finish'],
						 $start_date,
						 $schedule['business_id'])){
						continue;
					  }
					
					$params = array();
					
						$params = array(
									'super_users_id' => $schedule['super_users_id'],
									'worker_users_id' => $schedule['worker_users_id'],
									'business_id' => $schedule['business_id'],
									'location_id' => $schedule['location_id'],
									'start' => $schedule['start'],
									'finish' => $schedule['finish'],
									'meal_break' => $schedule['meal_break'],
									'rest_break' => $schedule['rest_break'],
									'notes' => $schedule['notes'],
									'status' => $schedule['status'],
									'created_at' => date("Y-m-d H:i:s"),
									'area_id' => $schedule['area_id'],
									'publish_type'=>1, 
									'start_date' => $start_date,
									'end_date' => $end_date,
	
								);
					
					
					//print_r($params); 
					$this->load->model('Schedule_model');
					$schedule_id = $this->Schedule_model->add_schedule($params);
					
					
				   //schedule_break_details
				   $this->db->where('schedule_id', $request->id);
				   $more_detail = $this->db->get("schedule_break_details")->result_array();
				   $db_error = $this->db->error();
					if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					}
					for($i=0;$i<count($more_detail);$i++){
						$this->load->model('Schedule_break_details_model');
						$params = array(
									'schedule_id' => $schedule_id,
									'type' => $more_detail[$i]['type'],
									'duration' => $more_detail[$i]['duration'],
									'start' => $more_detail[$i]['start'],
									'finish' => $more_detail[$i]['finish'],
									'created_at' =>date("Y-m-d H:i:s"),
									'updated_at' =>date("Y-m-d H:i:s")
								);
						$this->Schedule_break_details_model->add_schedule_break_details($params);
					}
					
				}
				
				if($schedule_id){
				 ob_clean();
				 echo json_encode(array('status'=>'success','msg'=>'Schedule has been pasted successfully'));
				}
		   
		   break;						
		 /************************
			    user
		  **********************/  		
		 case "save_user":
			   $request = '';
			   $users_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
				
				//make OpenShift EmptyShift
				$this->db->where('first_name', 'OpenShift');
				$resos = $this->db->get('users')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				//create user
				if(count($resos)==0){
					    $this->load->model('Users_model');
						$params = array(
							'first_name' =>'OpenShift',
							'status' => 'active',
							'created_at' => date("Y-m-d H:i:s"),
						);					
						$resos[0]['id'] = $this->Users_model->add_users($params);
				}
				
				$this->db->where('first_name', 'EmptyShift');
				$reses = $this->db->get('users')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				//create user
				if(count($reses)==0){
					    $this->load->model('Users_model');
						$params = array(
							'first_name' =>'EmptyShift',
							'status' => 'active',
							'created_at' => date("Y-m-d H:i:s"),
						);					
						$reses[0]['id'] = $this->Users_model->add_users($params);
				}
				
				
				
				$this->db->where('users_id', $resos[0]['id']);
				$this->db->where('business_id', $request->business_id);
				//$this->db->where('location_id', $request->main_location_id);
				$resul1 = $this->db->get('users_location')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				if(count($resul1)==0){
						$params = array(
									'users_id' =>$resos[0]['id'],
									'business_id' => $request->business_id,
									'location_id' => $request->main_location_id,
									'location_name' => $request->main_location,
									'main' => 'yes',
									'status' => 'active',
									'updated_at' =>date("Y-m-d H:i:s")
								);
						$this->db->insert('users_location',$params);
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
				}
				
				$this->db->where('users_id', $reses[0]['id']);
				$this->db->where('business_id', $request->business_id);
				//$this->db->where('location_id', $request->main_location_id);
				$resul2 = $this->db->get('users_location')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				if(count($resul2)==0){
					    $params = array(
									'users_id' =>$reses[0]['id'],
									'business_id' => $request->business_id,
									'location_id' => $request->main_location_id,
									'location_name' => $request->main_location,
									'main' => 'yes',
									'status' => 'active',
									'updated_at' =>date("Y-m-d H:i:s")
								);
						$this->db->insert('users_location',$params);
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
				}
				///////////////////////
					
				$first_name  = $request->first_name;
				$last_name = $request->last_name;
				$main_location_id = $request->main_location_id;
				$main_location = $request->main_location;
				$phone_no = $request->phone_no;
				$email = $request->email;
				$user_type = $request->user_type;
				
				$this->load->model('Users_model');
				$this->load->model('Users_location_model');
				
				$this->db->where('email', $request->email);
				$result = $this->db->get('users')->result_array();
			    
				 if($request->users_id>0){
					   //update user
					    $params = array(
							'email' =>$email,							
							'first_name' => $first_name,
							'last_name' => $last_name,			
							'phone_no' => $phone_no,		 			
							'user_type' => $user_type,
							'main_location_id' => $main_location_id,
							'main_location'=>$main_location,
							'inventory_status' =>'live',
							'status' => 'active',
							'updated_at' => date("Y-m-d H:i:s"),
						);					
					  $this->Users_model->update_users($request->users_id,$params);
					 
					  //update user locations
					  //select
					  $this->db->order_by('id', 'desc');
					  $this->db->where('users_id',$request->users_id);
					  $this->db->where('business_id',$request->business_id);
					  //$this->db->where('location_id',$main_location_id);
					  $result2 = $this->db->get('users_location')->result_array();
					  $db_error = $this->db->error();
					  if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					  }
					  if(count($result2)>0){
						$params = array(
									'users_id' =>$request->users_id,
									'business_id' => $request->business_id,
									'location_id' => $main_location_id,
									'location_name' => $main_location,
									'main' => 'yes',
									'status' => 'active',
									'updated_at' =>date("Y-m-d H:i:s")
								);
						$this->Users_location_model->update_users_location($result2[0]['id'],$params);  
					  }else{ 
						$this->load->model('Users_location_model');
						//save user locations
						$params = array(
									'users_id' => $request->users_id,
									'business_id' => $request->business_id,
									'location_id' => $main_location_id,
									'location_name' => $main_location,
									'main' => 'yes',
									'status' => 'active',
									'created_at' =>date("Y-m-d H:i:s")
								);
						$this->Users_location_model->add_users_location($params);
					  }
				 } //if user no exists add new ussers and  users_location
				 else{
					if(count($result)==0){
						 $params = array(
								'email' =>$email,
								'password' => rand(0,99999),
								'first_name' => $first_name,
								'last_name' => $last_name,			
								'phone_no' => $phone_no,		 			
								'user_type' => $user_type,
								'main_location_id' => $main_location_id,
								'main_location'=>$main_location,
								'inventory_status' =>'live',
								'status' => 'active',
								'created_at' => date("Y-m-d H:i:s"),
							);					
					      $users_id = $this->Users_model->add_users($params);
						  //Mail It
						  $subject = "Your Login access to kinstaff.com";
						  $message_body = $message_body = "Dear ".$params['first_name']." ".$params['last_name'].",<br>
											 Your email(username) is ".$email."<br>
											 Your password is ".$params['password']."<br>
											 Thank You,<br>
											 kinstaff.com<br>";
						  $this->load->helper('utility');				 
						  send_email($email,$subject,$message_body);
					}
					else{
						 $users_id = $result[0]['id'];
						}
						//save user locations
						$params = array(
									'users_id' => $users_id,
									'business_id' => $request->business_id,
									'location_id' => $main_location_id,
									'location_name' => $main_location,
									'main' => 'yes',
									'status' => 'active',
									'created_at' =>date("Y-m-d H:i:s")
								);
						$this->Users_location_model->add_users_location($params);
				 }
                
				// grab user input
				$email = $this->security->xss_clean(trim($email));
				// Run the query
				
				$this->db->where('email', $email);
				$result = $this->db->get('users')->result_array();
				$data = array();
				// Let's check if there are any results
				if (count($result) == 1) {
					// If there is a user, then create session data
					$data = array(
						'id' => $result[0]['id'],
						'email' => $result[0]['email'],
						'first_name' => $result[0]['first_name'],
						'last_name' => $result[0]['last_name'],	
						'company_id' => $result[0]['company_id'],	
						'user_type' => $result[0]['user_type'],						
						'file_picture' => $result[0]['file_picture'],
						'validated' => true
					);
				}
				else{
					$data = array(
						'id' => '',
						'email' => '',
						'first_name' => '',
						'last_name' => '',	
						'company_id' => '',		
						'user_type' => '',						
						'file_picture' => '',
						'validated' => false
					);
				}
				ob_clean();
				 
					if (count($result) > 0) {
					   $arr[0]['status'] = 'success'; 	
					   $arr[0]['user'] = $data; 	
					   $arr[0]['msg'] = "Member creation has been completed successfully";	
					   echo json_encode($arr);
					   exit;	
					}
					else{
					   $arr[0]['status'] = 'fail'; 	
					   $arr[0]['user'] = $data; 	
					   $arr[0]['msg'] = "Registration fail";		
					   echo json_encode($arr);
					   exit;	
					}
		      break;
		   case "save_multi_users":
			   $request = '';
			   $users_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
				
				//make OpenShift EmptyShift
				$this->db->where('first_name', 'OpenShift');
				$resos = $this->db->get('users')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				//create user
				if(count($resos)==0){
					    $this->load->model('Users_model');
						$params = array(
							'first_name' =>'OpenShift',
							'status' => 'active',
							'created_at' => date("Y-m-d H:i:s"),
						);					
						$resos[0]['id'] = $this->Users_model->add_users($params);
				}
				
				$this->db->where('first_name', 'EmptyShift');
				$reses = $this->db->get('users')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				//create user
				if(count($reses)==0){
					    $this->load->model('Users_model');
						$params = array(
							'first_name' =>'EmptyShift',
							'status' => 'active',
							'created_at' => date("Y-m-d H:i:s"),
						);					
						$reses[0]['id'] = $this->Users_model->add_users($params);
				}
				
				
				$this->db->where('users_id', $resos[0]['id']);
				$this->db->where('business_id', $request->business_id);
				//$this->db->where('location_id', $request->main_location_id);
				$resul1 = $this->db->get('users_location')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				if(count($resul1)==0){
						$params = array(
									'users_id' =>$resos[0]['id'],
									'business_id' => $request->business_id,
									'location_id' => $request->main_location_id,
									'location_name' => $request->main_location,
									'main' => 'yes',
									'status' => 'active',
									'updated_at' =>date("Y-m-d H:i:s")
								);
						$this->db->insert('users_location',$params);
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
				}
				
				$this->db->where('users_id', $reses[0]['id']);
				$this->db->where('business_id', $request->business_id);
				//$this->db->where('location_id', $request->main_location_id);
				$resul2 = $this->db->get('users_location')->result_array();
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				if(count($resul2)==0){
					    $params = array(
									'users_id' =>$reses[0]['id'],
									'business_id' => $request->business_id,
									'location_id' => $request->main_location_id,
									'location_name' => $request->main_location,
									'main' => 'yes',
									'status' => 'active',
									'updated_at' =>date("Y-m-d H:i:s")
								);
						$this->db->insert('users_location',$params);
						$db_error = $this->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
				}
				///////////////////////
				
				$members = $request->members;
				$main_location_id = $request->main_location_id;
				$main_location = $request->main_location;
				$user_type = $request->user_type;
			
			
			    for($i=0;$i<count($members);$i++){
					$email = $members[$i]->email;
					$first_name =$members[$i]->first_name;
					$last_name	= $members[$i]->last_name;	
					$phone_no	= $members[$i]->phone_no; 			
					
					
					$this->load->model('Users_model');
					$this->load->model('Users_location_model');
					
					$this->load->database();
					$this->db->where('email', $email);
					$result = $this->db->get('users')->result_array();
					if(count($result)==0){
						 $params = array(
								'email' =>$email,
								'password' => rand(0,99999),
								'first_name' => $first_name,
								'last_name' => $last_name,			
								'phone_no' => $phone_no,		 			
								'user_type' => $user_type,
								'main_location_id' => $main_location_id,
								'main_location'=>$main_location,
								'inventory_status' =>'live',
								'status' => 'active',
								'created_at' => date("Y-m-d H:i:s"),
							);
					 $users_id = $this->Users_model->add_users($params);
					 
					 //Mail It
					  $subject = "Your Login access to kinstaff.com";
					  $message_body = $message_body = "Dear ".$params['first_name']." ".$params['last_name'].",<br>
										 Your email(username) is ".$email."<br>
										 Your password is ".$params['password']."<br>
										 Thank You,<br>
										 kinstaff.com<br>";
					  $this->load->helper('utility');				 
					  send_email($email,$subject,$message_body);
				 }
				 else{
					$users_id =  $result[0]['id'];
				 }
					
					 //update user locations
					  //select
					  $this->db->order_by('id', 'desc');
					  $this->db->where('users_id',$users_id);
					  $this->db->where('business_id',$request->business_id);
					  $this->db->where('location_id',$main_location_id);
					  $result2 = $this->db->get('users_location')->result_array();
					  $db_error = $this->db->error();
					  if (!empty($db_error['code'])){
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit;
					  }
					  if(count($result2)>0){
						$params = array(
									'users_id' =>$result2[0]['users_id'],
									'business_id' => $request->business_id,
									'location_id' => $main_location_id,
									'location_name' => $main_location,
									'main' => 'yes',
									'status' => 'active',
									'updated_at' =>date("Y-m-d H:i:s")
								);
						$this->Users_location_model->update_users_location($result2[0]['id'],$params);  
					  }else{ 
						//save user locations
						$params = array(
									'users_id' => $users_id,
									'business_id' => $request->business_id,
									'location_id' => $main_location_id,
									'location_name' => $main_location,
									'main' => 'yes',
									'status' => 'active',
									'created_at' =>date("Y-m-d H:i:s")
								);
						$this->Users_location_model->add_users_location($params);
					  }
				}
				//ob_clean();
				$arr[0]['status'] = 'success'; 
				$arr[0]['msg'] = "Members has been created successfully";	
				echo json_encode($arr);
		      break;	
			case "upload_people_csv":
			    $request     = '';
				$line = '';
				$postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
				$business_id = $this->input->post('business_id');
				$main_location_id = $this->input->post('main_location_id');
				$users_id = $this->input->post('users_id');
				$main_location = $this->input->post('main_location');
				$user_type = 'Employee';
				
				
                 // If file uploaded
                if(is_uploaded_file($_FILES['file_csv']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');
                    
                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file_csv']['tmp_name']);
                    
                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row){ 
						$rowCount++;
					
					
					$first_name = $row['first_name'];
					$last_name = $row['last_name'];
					$email = trim($row['email']);
					$phone_no = $row['phone_no'];
					
					
					$this->load->helper('utility');			
					create_user($first_name,  
							$last_name, 
							$phone_no, 
							$email, 
							$user_type, 
							$business_id,
							$main_location_id,
							$main_location);
			 
				}
			 
				}
				}
				 
			    $arr[0]['status'] = 'success'; 
				$arr[0]['msg'] = "CSV imported successfully";	
				echo json_encode($arr);
			 break;
			/************************
			    Location
			**********************/  
			case "save_location":
			   $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
					
				$users_id  = $request->users_id;
				$business_id = $request->business_id;
				$location_name = $request->location_name;
				$location_code = $request->location_code;
				$address = $request->address;
				$time_zone = $request->time_zone;
				$location_id = $request->location_id;
				
				$params = array('super_users_id'  => $request->users_id,
								'business_id' => $request->business_id,
								'location_name' => $request->location_name,
								'location_code' => $request->location_code,
								'address' => $request->address,
								'timezone' => $request->time_zone,
								'monday' => isset($request->monday)?$request->monday:'',
								'monday_from' => isset($request->monday)?$request->monday_from:'',
								'monday_to' => isset($request->monday)?$request->monday_to:'',
								'tuesday' => isset($request->monday)?$request->tuesday:'',
								'tuesday_from' => isset($request->monday)?$request->tuesday_from:'',
								'tuesday_to' => isset($request->monday)?$request->tuesday_to:'',
								'wednesday' => isset($request->monday)?$request->wednesday:'',
								'wednesday_from' => isset($request->monday)?$request->wednesday_from:'',
								'wednesday_to' => isset($request->monday)?$request->wednesday_to:'',
								'thursday' => isset($request->monday)?$request->thursday:'',
								'thursday_from' => isset($request->monday)?$request->thursday_from:'',
								'thursday_to' => isset($request->monday)?$request->thursday_to:'',
								'friday' => isset($request->monday)?$request->friday:'',
								'friday_from' => isset($request->monday)?$request->friday_from:'',
								'friday_to' => isset($request->monday)?$request->friday_to:'',
								'saturday' => isset($request->monday)?$request->saturday:'',
								'saturday_from' => isset($request->monday)?$request->saturday_from:'',
								'saturday_to' => isset($request->monday)?$request->saturday_to:'',
								'sunday' => isset($request->monday)?$request->sunday:'',
								'sunday_from' => isset($request->monday)?$request->sunday_from:'',
								'sunday_to' => isset($request->monday)?$request->sunday_to:'',
								'notes' => isset($request->monday)?$request->notes:'',);
				
				$this->load->model('Location_model');
				if($location_id>0){
					$this->Location_model->update_location($location_id,$params);
				}
				else{
			        $location_id =  $this->Location_model->add_location($params);
				}
				ob_clean();
				if($location_id){
					$arr[0]['status'] = 'success'; 
					$arr[0]['msg'] = "Location has been saved successfully";	
					echo json_encode($arr);
				}
				else{
					$arr[0]['status'] = 'fail'; 
					$arr[0]['msg'] = "Location creation has been failed";	
					echo json_encode($arr);
				}
			break;  
		    case "save_location_shift":
		         $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
					
				$week_start  = $request->week_start;
				$ROSTER_DEFAULT_SHIFT_LEN = $request->ROSTER_DEFAULT_SHIFT_LEN;
				$DEFAULT_MEALBREAK_DURATION = $request->DEFAULT_MEALBREAK_DURATION;
				$location_id = $request->location_id;
				
				$params = array('week_start'  => isset($request->week_start)?$request->week_start:'',
								'ROSTER_DEFAULT_SHIFT_LEN' => isset($request->ROSTER_DEFAULT_SHIFT_LEN)?$request->ROSTER_DEFAULT_SHIFT_LEN:'',
								'DEFAULT_MEALBREAK_DURATION' => isset($request->DEFAULT_MEALBREAK_DURATION)?$request->DEFAULT_MEALBREAK_DURATION:'');
				
				$this->load->model('Location_model');
				if($location_id>0){
					$this->Location_model->update_location($location_id,$params);
				}
				
				ob_clean();
				if($location_id){
					$arr[0]['status'] = 'success'; 
					$arr[0]['msg'] = "Shift has been saved successfully";	
					echo json_encode($arr);
				}
				else{
					$arr[0]['status'] = 'fail'; 
					$arr[0]['msg'] = "Shift creation has been failed";	
					echo json_encode($arr);
				}
		      break;				
			case "delete_location":
			   $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
					
				$users_id  = $request->users_id;
				$business_id = $request->business_id;
				$location_id = $request->location_id;
			    $this->db->where('super_users_id', $request->users_id);
				$this->db->where('business_id', $request->business_id);
		        $status = $this->db->delete('Location',array('id'=>$request->location_id));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				if($status==true){
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'Location has been deleted successfully'; 						
						 echo json_encode($arr);
						 exit;	
					 }
					 else
					 {
						 $arr[0]['status'] = 'fail'; 
						 $arr[0]['msg'] = 'Location deleted has been failed'; 
						 echo json_encode($arr);
						 exit;	
					 }	
			 break; 
		  /***********************************
		  area
		  ***********************************/	 			 
		  case "save_area":
			   $request = '';
			   $area_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
					
				$users_id  = $request->users_id;
				$business_id = $request->business_id;
				
				$area_id = $request->area_id;
				
				$params = array('super_users_id'  => $request->users_id,
								'business_id' => $request->business_id,
								'location_id' => $request->location_id,
								'area_name' => $request->area_name,
								'color_code' => $request->color_code,
								);
				
				$this->load->model('Area_model');
				if($area_id>0){
					$this->Area_model->update_area($area_id,$params);
				}
				else{
			        $area_id =  $this->Area_model->add_area($params);
				}
				ob_clean();
				if($area_id){
					$arr[0]['status'] = 'success'; 
					$arr[0]['msg'] = "Area has been saved successfully";	
					echo json_encode($arr);
				}
				else{
					$arr[0]['status'] = 'fail'; 
					$arr[0]['msg'] = "Area creation has been failed";	
					echo json_encode($arr);
				}
			break; 
			case "delete_area":
			   $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
					
				$users_id  = $request->users_id;
				$business_id = $request->business_id;
				$area_id = $request->area_id;
			    $this->db->where('super_users_id', $request->users_id);
				$this->db->where('business_id', $request->business_id);
				$this->db->where('location_id', $request->location_id);
		        $status = $this->db->delete('area',array('id'=>$request->area_id));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				if($status==true){
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'Area has been deleted successfully'; 						
						 echo json_encode($arr);
						 exit;	
					 }
					 else
					 {
						 $arr[0]['status'] = 'fail'; 
						 $arr[0]['msg'] = 'Area deletion has been failed'; 
						 echo json_encode($arr);
						 exit;	
					 }	
			 break; 
		   /************************
			    PayRoll
			**********************/  
			case "save_payroll":
			   $request = '';
			   $payroll_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
					
				$super_users_id  = $request->super_users_id;
				$business_id = $request->business_id;
				$users_id = $request->selected_users_id;
				$payroll_id = $request->payroll_id;
				
				$params = array('super_users_id'  => $request->super_users_id,
								'business_id' => $request->business_id,
								'users_id' => $request->selected_users_id,
								'Payroll_ID' => isset($request->Payroll_ID)?$request->Payroll_ID:'',
								'access_level' => isset($request->access_level)?$request->access_level:'',
								'stress_profile' => isset($request->stress_profile)?$request->stress_profile:'',
								'employee_start_date' => isset($request->employee_start_date)?$request->employee_start_date:'',
								'employeement_type' => isset($request->employeement_type)?$request->employeement_type:'',
								'pay_rate_type' => isset($request->pay_rate_type)?$request->pay_rate_type:'',
								'salary_type' => isset($request->salary_type)?$request->salary_type:'',
								'salary_amount' => isset($request->salary_amount)?$request->salary_amount:'',
								'weekday_rate' => isset($request->weekday_rate)?$request->weekday_rate:'',
								'public_holiday_rate' => isset($request->public_holiday_rate)?$request->public_holiday_rate:'',
								'saterday_rate' => isset($request->saterday_rate)?$request->saterday_rate:'',
								'sunday_rate' =>isset($request->sunday_rate)?$request->sunday_rate:'', 
								'monday_rate' => isset($request->monday_rate)?$request->monday_rate:'',
								'tuesday_rate' =>isset($request->tuesday_rate)?$request->tuesday_rate:'', 
								'wednesday_rate' => isset($request->wednesday_rate)?$request->wednesday_rate:'',
								'thrusday_rate' =>isset($request->thrusday_rate)?$request->thrusday_rate:'', 
								'friday_rate' => isset($request->friday_rate)?$request->friday_rate:'',
								'hourly_rate' => isset($request->hourly_rate)?$request->hourly_rate:'',
								'overtime_rate' =>isset($request->overtime_rate)?$request->overtime_rate:'',
								);
				
				$this->load->model('Users_pay_details_model');
				if($payroll_id>0){
					 $this->Users_pay_details_model->update_users_pay_details($payroll_id,$params);
				}
				else{
			       $payroll_id =  $this->Users_pay_details_model->add_users_pay_details($params);
				}
				//save locations
				  //delete
				$this->db->delete('users_works_at_location',array('users_pay_details_id'  => $payroll_id));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				 //save
				 
				 if(isset($request->location)){
				 for($i=0;$i<count($request->location);$i++){	 
					 $this->load->model('Users_works_at_location_model');
					 $params = array(
					            'users_pay_details_id' => $payroll_id, 
								'super_users_id' => $request->super_users_id,
								'worker_users_id' => $request->selected_users_id,
								'business_id' => $request->business_id,
								'location_id' => $request->location[$i]->item_id,
								'location_name' =>$request->location[$i]->item_text,
								'created_at' =>date("Y-m-d H:i:s")
							 );
					 $this->Users_works_at_location_model->add_users_works_at_location($params);
					 }
				 }
				
				ob_clean();
				if($payroll_id){
					$arr[0]['status'] = 'success'; 
					$arr[0]['msg'] = "Pay details has been saved successfully";	
					echo json_encode($arr);
				}
				else{
					$arr[0]['status'] = 'fail'; 
					$arr[0]['msg'] = "Pay details creation has been failed";	
					echo json_encode($arr);
				}
			break;  
			
			case "delete_payroll":
			   $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
					
				$users_id  = $request->users_id;
				$business_id = $request->business_id;
				$payroll_id = $request->payroll_id;
			    $this->db->where('super_users_id', $request->users_id);
				$this->db->where('business_id', $request->business_id);
		        $status = $this->db->delete('users_pay_details_model',array('id'=>$request->payroll_id));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				if($status==true){
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'Pay details has been deleted successfully'; 						
						 echo json_encode($arr);
						 exit;	
					 }
					 else
					 {
						 $arr[0]['status'] = 'fail'; 
						 $arr[0]['msg'] = 'Pay details deleted has been failed'; 
						 echo json_encode($arr);
						 exit;	
					 }	
			 break; 
			case "save_leave":
			   $request = '';
			   $leave_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
				$payroll_id = $request->payroll_id;
				
				$params = array('users_pay_details_id'  => $request->payroll_id,
								'start_date' => isset($request->start_date)?$request->start_date:'',
								'end_date' => isset($request->end_date)?$request->end_date:'',
								'leave_type' => isset($request->leave_type)?$request->leave_type:'',
								);
				
				$this->load->model('Users_leave_model');
				if($request->leave_id>0){
					 $this->Users_leave_model->update_users_leave($request->leave_id,$params);
					 $leave_id = $request->leave_id;
				}
				else{
			       $leave_id = $this->Users_leave_model->add_users_leave($params);
				}
				
				ob_clean();
				if($leave_id){
					$arr[0]['status'] = 'success'; 
					$arr[0]['msg'] = "Leave has been saved successfully";	
					echo json_encode($arr);
				}
				else{
					$arr[0]['status'] = 'fail'; 
					$arr[0]['msg'] = "Leave creation has been failed";	
					echo json_encode($arr);
				}
			 break; 
			 
			case "delete_leave":
			   $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
		        $status = $this->db->delete('users_leave',array('id'=>$request->leave_id));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				if($status==true){
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'Leave has been deleted successfully'; 						
						 echo json_encode($arr);
						 exit;	
				 }
				 else
				 {
					 $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Leave deleted has been failed'; 
					 echo json_encode($arr);
					 exit;	
				 }	
			 break;  
			 
			 
			 //Leave apply
			 case "save_leave_apply":
			   $request = '';
			   $leave_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
				$params = array('users_id'  => $request->users_id,
				                'users_pay_details_id'  => $request->users_pay_details_id,
								'start_date' => isset($request->start_date)?$request->start_date:'',
								'end_date' => isset($request->end_date)?$request->end_date:'',
								'leave_type' => isset($request->leave_type)?$request->leave_type:'',
								'status' => 'pending',
								);
				
				$this->load->model('Users_leave_apply_model');
				if($request->leave_id>0){
					 $this->Users_leave_apply_model->update_users_leave_apply($request->leave_id,$params);
					 $leave_id = $request->leave_id;
				}
				else{
			       $leave_id = $this->Users_leave_apply_model->add_users_leave_apply($params);
				}
				
				ob_clean();
				if($leave_id){
					$arr[0]['status'] = 'success'; 
					$arr[0]['msg'] = "Leave has been saved successfully";	
					echo json_encode($arr);
				}
				else{
					$arr[0]['status'] = 'fail'; 
					$arr[0]['msg'] = "Leave creation has been failed";	
					echo json_encode($arr);
				}
			 break; 
			 
			case "delete_leave_apply":
			   $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
		        $status = $this->db->delete('users_leave_apply',array('id'=>$request->leave_id));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				if($status==true){
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'Leave has been deleted successfully'; 						
						 echo json_encode($arr);
						 exit;	
				 }
				 else
				 {
					 $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Leave deleted has been failed'; 
					 echo json_encode($arr);
					 exit;	
				 }	
			 break; 
			 
			case "save_training":
			   $request = '';
			   $leave_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
				$payroll_id = $request->payroll_id;
				
				$params = array('users_pay_details_id'  => $request->payroll_id,
								'training_type' => isset($request->training_type)?$request->training_type:'',
								'renewal_date' => isset($request->renewal_date)?$request->renewal_date:'',
								'notes' => isset($request->notes)?$request->notes:'',
								);
				
				$this->load->model('Users_training_model');
				if($request->training_id>0){
					 $this->Users_training_model->update_users_training($request->training_id,$params);
					 $training_id = $request->training_id;
				}
				else{
			       $training_id = $this->Users_training_model->add_users_training($params);
				}
				
				ob_clean();
				if($training_id){
					$arr[0]['status'] = 'success'; 
					$arr[0]['msg'] = "Training has been saved successfully";	
					echo json_encode($arr);
				}
				else{
					$arr[0]['status'] = 'fail'; 
					$arr[0]['msg'] = "Training creation has been failed";	
					echo json_encode($arr);
				}
			 break;  
			case "delete_training":
			   $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
		        $status = $this->db->delete('users_training',array('id'=>$request->training_id));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				if($status==true){
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'Training has been deleted successfully'; 						
						 echo json_encode($arr);
						 exit;	
				 }
				 else
				 {
					 $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Training deleted has been failed'; 
					 echo json_encode($arr);
					 exit;	
				 }	
			 break;   
			case "save_unavailability":
			   $request = '';
			   $unavailability_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
				$payroll_id = $request->payroll_id;
				
				$params = array('users_pay_details_id'  => $request->payroll_id,
								'repeat_type' => isset($request->repeat_type)?$request->repeat_type:'',
								'Mon' => isset($request->Mon)?$request->Mon:'',
								'Tue' => isset($request->Tue)?$request->Tue:'',
								'Wed' => isset($request->Wed)?$request->Wed:'',
								'Thu' => isset($request->Thu)?$request->Thu:'',
								'Fri' => isset($request->Fri)?$request->Fri:'',
								'Sat' => isset($request->Sat)?$request->Sat:'',
								'Sun' => isset($request->Sun)?$request->Sun:'',
								'notes' => isset($request->notes)?$request->notes:'',
								);
								
				if(!empty($request->start_date)){
					$params['start_date'] = $request->start_date; 
				}
				if(!empty($request->start_time)){
					$params['start_time'] = $request->start_time; 
				}
				if(!empty($request->end_date)){
					$params['end_date'] = $request->end_date; 
				}
				if(!empty($request->end_time)){
					$params['end_time'] = $request->end_time; 
				}
				
				$this->load->model('Users_unavailability_model');
				if($request->unavailability_id>0){
					 $this->Users_unavailability_model->update_users_unavailability($request->unavailability_id,$params);
					 $unavailability_id = $request->unavailability_id;
				}
				else{
			       $unavailability_id = $this->Users_unavailability_model->add_users_unavailability($params);
				}
				
				ob_clean();
				if($unavailability_id){
					$arr[0]['status'] = 'success'; 
					$arr[0]['msg'] = "Unavailability has been saved successfully";	
					echo json_encode($arr);
				}
				else{
					$arr[0]['status'] = 'fail'; 
					$arr[0]['msg'] = "Unavailability creation has been failed";	
					echo json_encode($arr);
				}
			 break;  
			case "delete_unavailability":
			   $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
		        $status = $this->db->delete('users_unavailability',array('id'=>$request->unavailability_id));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				if($status==true){
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'Unavailability has been deleted successfully'; 						
						 echo json_encode($arr);
						 exit;	
				 }
				 else
				 {
					 $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Unavailability deleted has been failed'; 
					 echo json_encode($arr);
					 exit;	
				 }	
			 break;    
			case "update_profile":
		        $request = '';
			    $location_id = '';
			    $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
		         $this->load->database();
				 $this->db->where('id', $request->users_id);
                 $result = $this->db->get('users')->result_array();
				 if(count($result)>0){
					 $this->load->model('Users_model');
					 $params = array(
							'first_name' =>isset($request->first_name)?$request->first_name:'',
							'last_name' =>isset($request->last_name)?$request->last_name:'',
							'email' =>isset($request->email)?$request->email:'',
							'phone_no' =>isset($request->phone_no)?$request->phone_no:'',
							'dob' =>isset($request->date_of_birth)?$request->date_of_birth:'',
							'gender' => isset($request->gender)?$request->gender:'',
							'address' => isset($request->address)?$request->address:'',
							'city' =>isset($request->city)?$request->city:'',
							'country' => isset($request->country)?$request->country:'',
							'zip' => isset($request->postcode)?$request->postcode:'',
							'updated_at' => date("Y-m-d H:i:s"),
						);
						 $this->Users_model->update_users($result[0]['id'],$params);
						 ob_clean();
						if($request->users_id>0){
						   $arr[0]['status'] = 'success'; 	
						   $arr[0]['msg'] = "Update has been completed successfully";	
						   echo json_encode($arr);
						   exit;	
						}
				  }else{
					    ob_clean();
					   $arr[0]['status'] = 'fail'; 	
					   $arr[0]['msg'] = "Update fail";		
					   echo json_encode($arr);
					   exit;	
					}
		      break; 
		 case "save_project":
					$request     = '';
					$line = '';
					$postdata = file_get_contents("php://input");
					if (isset($postdata)) {
						$request     = json_decode($postdata);	
					}
					
					$this->load->model('Projects_model');
					
					$file_project = "";
					
					$created_at = "";
					$updated_at = "";
					$id = $this->input->post('id');
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
							'updated_at' =>$updated_at
									);
					
						$config['upload_path']          = "./public/uploads/images/projects";
						$config['allowed_types']        = "gif|jpg|png|csv|pdf|xls";
						//$config['max_size']             = 100;
						//$config['max_width']            = 1024;
						//$config['max_height']           = 768;
						
						
						if(isset($_POST) && count($_POST) > 0)     
							{  
							  if(strlen($_FILES['file_project']['name'])>0 && $_FILES['file_project']['size']>0)
								{
									$new_name = time().str_replace(" ","_",$_FILES["file_project"]['name']);
									$config['file_name'] = $new_name;
									$config['encrypt_name'] = FALSE;
									$this->load->library('upload', $config);
									
									if ( ! $this->upload->do_upload('file_project'))
									{
										$error = array('error' => $this->upload->display_errors());
									}
									else
									{
										$file_project = base_url()."public/uploads/images/projects/".$new_name;
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
					//update		
					if(isset($id) && $id>0){
						$data['projects'] = $this->Projects_model->get_projects($id);
					if(isset($_POST) && count($_POST) > 0){   
						$this->Projects_model->update_projects($id,$params);
						}
					} //save
					else{
						if(isset($_POST) && count($_POST) > 0){   
						$projects_id = $this->Projects_model->add_projects($params);
						}		
					}
				$arr[0]['status'] = 'success'; 
				$arr[0]['msg'] = "Project hass been added successfully";	
				echo json_encode($arr);
			 break;	
		case "delete_project":
			   $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
		        $status = $this->db->delete('projects',array('id'=>$request->id));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				if($status==true){
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'Project has been deleted successfully'; 						
						 echo json_encode($arr);
						 exit;	
				 }
				 else
				 {
					 $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Project deleted has been failed'; 
					 echo json_encode($arr);
					 exit;	
				 }	
			 break;	  
			 
		 case "upload_picture":
		            $request     = '';					
					$postdata = file_get_contents("php://input");
					if (isset($postdata)) {
						$request     = json_decode($postdata);	
					}
					
					$this->load->model('Users_model');
					
					$file_picture = "";
					
					$created_at = "";
					$updated_at = "";
					$id = $this->input->post('users_id');
					if($id<=0){
							 $created_at = date("Y-m-d H:i:s");
						 }
					else if($id>0){
							 $updated_at = date("Y-m-d H:i:s");
						 }
					
					$params = array(							
							'updated_at' =>$updated_at
									);
					
						$config['upload_path']          = "./public/uploads/images/users";
						$config['allowed_types']        = "gif|jpeg|jpg|png|csv|pdf|xls";
						//$config['max_size']             = 100;
						//$config['max_width']            = 1024;
						//$config['max_height']           = 768;
						
						$new_name = time().str_replace(" ","_",$_FILES["file_picture"]['name']);
						$config['file_name'] = $new_name;
						$config['encrypt_name'] = FALSE;
						
						
						$this->load->library('upload', $config);
						
						if(isset($_POST) && count($_POST) > 0)     
							{  
							  if(strlen($_FILES['file_picture']['name'])>0 && $_FILES['file_picture']['size']>0)
								{
									
									if ( ! $this->upload->do_upload('file_picture'))
									{
										$error = array('error' => $this->upload->display_errors());
									}
									else
									{
										$this->load->helper('url');
										$file_picture = base_url()."public/uploads/images/users/".$new_name;
										$params['file_picture'] = $file_picture;
									}
								}
								else
								{
									unset($params['file_picture']);
								}
							}
							
							
					if($id>0){
						unset($params['created_at']);
					}if($id<=0){
						unset($params['updated_at']);
					} 
					//update		
					if(isset($id) && $id>0){
						$data['users'] = $this->Users_model->get_users($id);
					if(isset($_POST) && count($_POST) > 0){   
						$this->Users_model->update_users($id,$params);
						}
					} //save
					else{
						if(isset($_POST) && count($_POST) > 0){   
						$users_id = $this->Users_model->add_users($params);
						}		
					}
				$arr[0]['status'] = 'success'; 
				$arr[0]['msg'] = "Picture hass been added successfully";	
				echo json_encode($arr);
		 
		  break;
		  
		  case "download_leave_csv":
		            $request     = '';					
					$postdata = file_get_contents("php://input");
					if (isset($postdata)) {
						$request     = json_decode($postdata);	
					}
					
					
					$super_users_id = $this->input->post('users_id');
					$business_id = $this->input->post('business_id');
					
				$this->db->select('users_pay_details.id as users_pay_details_id ,users.id as users_id,users.first_name,users.last_name');
				$this->db->where('super_users_id',$this->input->post('users_id'));
				$this->db->where('business_id',$this->input->post('business_id'));
				$this->db->join('users', 'users_pay_details.users_id = users.id', 'left');
				$result = $this->db->get('users_pay_details')->result_array();
				$db_error = $this->db->error();
				if (! empty($db_error['code'])) {
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit();
				}	
					
					// file name 
				   $filename = 'users_'.date('Ymd').'.csv'; 
				   header("Content-Description: File Transfer"); 
				   header("Content-Disposition: attachment; filename=$filename"); 
				   header("Content-Type: application/csv; ");
				   
				   // file creation 
				   $file = fopen('php://output', 'w');
				 
				   $header = array("users_pay_details_id","users_id","first_name","last_name","start_date","end_date","leave_type"); 
				   fputcsv($file, $header);
				   foreach ($result as $key=>$value){ 
				       $line[0]=$value['users_pay_details_id'];
					   $line[1]=$value['users_id'];
					   $line[2]=$value['first_name'];
					   $line[3]=$value['last_name'];
					   //$line[4]=array('1','2','3');
					 
					 fputcsv($file,$line); 
				   }
				   fclose($file); 
				   exit;
		    break;	 
			
		 case "upload_leave_csv":
			    /*$request     = '';
				$line = '';
				$postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
				$business_id = $this->input->post('business_id');
				$users_id = $this->input->post('users_id');*/
				
                 // If file uploaded
                if(is_uploaded_file($_FILES['file_employee_csv']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');
                    
                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file_employee_csv']['tmp_name']);
                    
                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row){ 
						$rowCount++;
					
					
					$first_name = $row['first_name'];
					$last_name = $row['last_name'];
					$users_pay_details_id = $row['users_pay_details_id'];
					$start_date  = $row['start_date'];
					$end_date  = $row['end_date'];
					$leave_type  = $row['leave_type'];
					
					$this->load->model('Users_leave_model');
					$params = array();
					if(strlen($start_date)>0&&strlen($end_date)>0){
					$params = array(
					 'users_pay_details_id' => $users_pay_details_id,
					'start_date' => date("Y-m-d",strtotime($start_date)),
					'end_date' => date("Y-m-d",strtotime($end_date)),
					'leave_type' => html_escape($leave_type));
					
					
					$this->Users_leave_model->add_users_leave($params);
			         }
				}
			 
				}
				}
				 
			    $arr[0]['status'] = 'success'; 
				$arr[0]['msg'] = "CSV imported successfully";	
				echo json_encode($arr);
			 break;	 
			 
			 
		  //News
		  case "save_news":
					$request     = '';
					$line = '';
					$postdata = file_get_contents("php://input");
					if (isset($postdata)) {
						$request     = json_decode($postdata);	
					}
					
					$this->load->model('News_model');
					
					$file_news = "";
					
					$created_at = "";
					$updated_at = "";
					$id = $this->input->post('id');
					if($id<=0){
							 $created_at = date("Y-m-d H:i:s");
						 }
					else if($id>0){
							 $updated_at = date("Y-m-d H:i:s");
						 }
					
					$params = array(
							'creator_users_id' => html_escape($this->input->post('creator_users_id')),
							'business_id' => html_escape($this->input->post('business_id')),
							'contents' => html_escape($this->input->post('contents')),
							'keywords' => html_escape($this->input->post('keywords')),
							'user_type' => html_escape($this->input->post('user_type')),
							'file_news' => $file_news,
							'created_at' =>$created_at,
							'updated_at' =>$updated_at
									);
					
						$config['upload_path']          = "./public/uploads/images/news";
						$config['allowed_types']        = "gif|jpg|png|csv|pdf|xls";
						//$config['max_size']             = 100;
						//$config['max_width']            = 1024;
						//$config['max_height']           = 768;
						
						
						if(isset($_POST) && count($_POST) > 0)     
							{  
							  if(strlen($_FILES['file_news']['name'])>0 && $_FILES['file_news']['size']>0)
								{
									$new_name = time().str_replace(" ","_",$_FILES["file_news"]['name']);
									$config['file_name'] = $new_name;
									$config['encrypt_name'] = FALSE;
									$this->load->library('upload', $config);
									
									if ( ! $this->upload->do_upload('file_news'))
									{
										$error = array('error' => $this->upload->display_errors());
									}
									else
									{
										$file_news = base_url()."public/uploads/images/news/".$new_name;
										$params['file_news'] = $file_news;
									}
								}
								else
								{
									unset($params['file_news']);
								}
							}
							
							
					if($id>0){
						unset($params['created_at']);
					}if($id<=0){
						unset($params['updated_at']);
					} 
					//update		
					if(isset($id) && $id>0){
						$data['projects'] = $this->News_model->get_news($id);
					if(isset($_POST) && count($_POST) > 0){   
						$this->News_model->update_news($id,$params);
						}
					} //save
					else{
						if(isset($_POST) && count($_POST) > 0){   
						$news_id = $this->News_model->add_news($params);
						}		
					}
				$arr[0]['status'] = 'success'; 
				$arr[0]['msg'] = "News hass been added successfully";	
				echo json_encode($arr);
			 break;	
		case "delete_news":
			   $request = '';
			   $location_id = '';
			   $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);	
				}
		        $status = $this->db->delete('News',array('id'=>$request->id));
				$db_error = $this->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				if($status==true){
						 $arr[0]['status'] = 'success'; 
						 $arr[0]['msg'] = 'News has been deleted successfully'; 						
						 echo json_encode($arr);
						 exit;	
				 }
				 else
				 {
					 $arr[0]['status'] = 'fail'; 
					 $arr[0]['msg'] = 'Project deleted has been failed'; 
					 echo json_encode($arr);
					 exit;	
				 }	
			 break;	
        }
    }

    function delete()
    {
		$cmd = $this->input->get('cmd');
		switch ($cmd) {
			case "delete_schedule":
			     //$this->load->model('Schedule_model');
			     //$status = $this->Schedule_model->delete_schedule($this->input->get('id'));
				 ob_clean();
				echo json_encode(array('status'=>'success','msg'=>'Schedule has been '.$status.' successfully'));
			break;
		}
	}

    function put()
    {
		
	}
}
?>