<?php
   function get_location_info($id){
		$CI = & get_instance();
		$CI->load->database();
		$CI->db->where('id', $id);
		$location = $CI->db->get_where('location')->result_array();	   
	    return  $location;
   }
   function get_user_info($id){
		$CI = & get_instance();
		$CI->load->database();
		$CI->db->where('id', $id);
		$user = $CI->db->get_where('users')->result_array();	   
	    return  $user;
   }
   
   function check_overlapping($worker_users_id,$start,$finish,$start_date,$business_id){
       				$CI = & get_instance();
		            $CI->load->database();
					$arr =  array();
					$msg = "";
					$overlapping = false;
					$end_date = strtotime($finish)<strtotime($start)?date("Y-m-d",(strtotime($start_date.'+1 day'))):$start_date;
		   
		            $CI->db->where('users_id',$worker_users_id);
					$CI->db->where('business_id', $business_id);
					$result = $CI->db->get('users_pay_details')->result_array();
					$db_error = $CI->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}	
					$users_pay_details_id = $result[0]['id']; 
					   
		            
					$CI->db->where('users_pay_details_id', $users_pay_details_id);
					$CI->db->where('start_date <= "'. $start_date.' '.$start. '" AND end_date >= "'. $end_date.' '.$finish. '"');
                    $leave = $CI->db->get('users_leave')->result_array();
					$db_error = $CI->db->error();
					if (! empty($db_error['code'])) {
						echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
						exit();
					}
					
					//leave
					if(count($leave)>0){
					   $overlapping=true;
					   $msg .= "You can not create schedule in this date range.The leave is between Start:".
					   date("D F jS,Y",strtotime($leave[0]['start_date']))." And End:".date("D F jS,Y",strtotime($leave[0]['end_date']));
					}
					
					
					$CI->db->where('users_pay_details_id', $users_pay_details_id);
					//$CI->db->where("start_date >= '". $start_date."'");
					$unavailability = $CI->db->get('users_unavailability')->result_array();
					$db_error = $CI->db->error();
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
					
		if($overlapping==true)
		{
			return true;
		}
		else{
		   return false;
		}
   }
   
	function send_email($email,$subject,$message_body){
		    $CI = & get_instance();
			ob_start();
			include(VIEWPATH.'email_template/template.php');
			$html = ob_get_clean();	
			
			$CI->load->library('email');
			$email_setting  = array('mailtype'=>'html');
			//$email_setting['mailtype'] = 'html';
			$email_setting['protocol'] = 'smtp';
			$email_setting['smtp_host'] = 'mail.kinstaff.com';
			$email_setting['smtp_user'] = 'info@kinstaff.com';
			$email_setting['smtp_pass'] = 'JNE,1Y169^K]';
			$email_setting['smtp_port'] = 587;
			$CI->email->initialize($email_setting);
			$CI->email->from('info@kinstaff.com', 'kinstaff.com');
			$CI->email->to($email);
			// Mail it
			$message = str_replace("<MSGBODY>",$message_body,$html);					
			$CI->email->subject($subject);
			$CI->email->message($message);
			$CI->email->send();	
	}
	
function create_user($first_name,  
				$last_name, 
				$phone_no, 
				$email, 
				$user_type, 
				$business_id,
				$main_location_id,
				$main_location){
				$users_id = '';	
	            $CI = & get_instance();
               //make OpenShift EmptyShift
				$CI->db->where('first_name', 'OpenShift');
				$resos = $CI->db->get('users')->result_array();
				$db_error = $CI->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				$CI->db->where('first_name', 'EmptyShift');
				$reses = $CI->db->get('users')->result_array();
				$db_error = $CI->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				
				
				
				$CI->db->where('users_id', $resos[0]['id']);
				$CI->db->where('business_id', $business_id);
				$CI->db->where('location_id', $main_location_id);
				$resul1 = $CI->db->get('users_location')->result_array();
				$db_error = $CI->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				if(count($resul1)==0){
						$params = array(
									'users_id' =>$resos[0]['id'],
									'business_id' => $business_id,
									'location_id' => $main_location_id,
									'location_name' => $main_location,
									'main' => 'yes',
									'status' => 'active',
									'updated_at' =>date("Y-m-d H:i:s")
								);
						$CI->db->insert('users_location',$params);
						$db_error = $CI->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
				}
				
				$CI->db->where('users_id', $reses[0]['id']);
				$CI->db->where('business_id', $business_id);
				$CI->db->where('location_id', $main_location_id);
				$resul2 = $CI->db->get('users_location')->result_array();
				$db_error = $CI->db->error();
				if (!empty($db_error['code'])){
					echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
					exit;
				}
				if(count($resul2)==0){
					    $params = array(
									'users_id' =>$reses[0]['id'],
									'business_id' => $business_id,
									'location_id' => $main_location_id,
									'location_name' => $main_location,
									'main' => 'yes',
									'status' => 'active',
									'updated_at' =>date("Y-m-d H:i:s")
								);
						$CI->db->insert('users_location',$params);
						$db_error = $CI->db->error();
						if (!empty($db_error['code'])){
							echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
							exit;
						}
				}
				///////////////////////
				$CI->load->model('Users_model');
				$CI->load->model('Users_location_model');
				
				$CI->db->where('email', $email);
				$result = $CI->db->get('users')->result_array();
			    
				
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
					  $users_id = $CI->Users_model->add_users($params);
					  //Mail It
					  $subject = "Your Login access to kinstaff.com";
					  $message_body = $message_body = "Dear ".$params['first_name']." ".$params['last_name'].",<br>
										 Your email(username) is ".$email."<br>
										 Your password is ".$params['password']."<br>
										 Thank You,<br>
										 kinstaff.com<br>";
					  $CI->load->helper('utility');				 
					  send_email($email,$subject,$message_body);
				}
				else{
					 $users_id = $result[0]['id'];
					}
				//save user locations
				$CI->db->where('users_id', $users_id);
				$CI->db->where('business_id', $business_id);
				$CI->db->where('location_id', $main_location_id);
				$result = $CI->db->get('users_location')->result_array();
				if(count($result)==0){
					$params = array(
								'users_id' => $users_id,
								'business_id' => $business_id,
								'location_id' => $main_location_id,
								'location_name' => $main_location,
								'main' => 'yes',
								'status' => 'active',
								'created_at' =>date("Y-m-d H:i:s")
							);
					$CI->Users_location_model->add_users_location($params);
				}
}
   
?>