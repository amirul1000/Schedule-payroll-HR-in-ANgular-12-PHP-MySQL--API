<a  href="<?php echo site_url('admin/schedule/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Schedule'); ?></h5>
<!--Data display of schedule with id--> 
<?php
	$c = $schedule;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Super Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['super_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Worker Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['worker_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Business</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Business_model');
									   $dataArr = $this->CI->Business_model->get_business($c['business_id']);
									   echo $dataArr['business_name'];?>
									</td></tr>

<tr><td>Location</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Location_model');
									   $dataArr = $this->CI->Location_model->get_location($c['location_id']);
									   echo $dataArr['location_name'];?>
									</td></tr>

<tr><td>Area</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Area_model');
									   $dataArr = $this->CI->Area_model->get_area($c['area_id']);
									   echo $dataArr['area_name'];?>
									</td></tr>

<tr><td>Start Date</td><td><?php echo $c['start_date']; ?></td></tr>

<tr><td>End Date</td><td><?php echo $c['end_date']; ?></td></tr>

<tr><td>Start</td><td><?php echo $c['start']; ?></td></tr>

<tr><td>Finish</td><td><?php echo $c['finish']; ?></td></tr>

<tr><td>Meal Break</td><td><?php echo $c['meal_break']; ?></td></tr>

<tr><td>Rest Break</td><td><?php echo $c['rest_break']; ?></td></tr>

<tr><td>Notes</td><td><?php echo $c['notes']; ?></td></tr>

<tr><td>Publish Type</td><td><?php echo $c['publish_type']; ?></td></tr>

<tr><td>Status</td><td><?php echo $c['status']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of schedule with id//--> 