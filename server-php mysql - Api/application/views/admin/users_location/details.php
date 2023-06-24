<a  href="<?php echo site_url('admin/users_location/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Users_location'); ?></h5>
<!--Data display of users_location with id--> 
<?php
	$c = $users_location;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['users_id']);
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

<tr><td>Location Name</td><td><?php echo $c['location_name']; ?></td></tr>

<tr><td>Main</td><td><?php echo $c['main']; ?></td></tr>

<tr><td>Status</td><td><?php echo $c['status']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of users_location with id//--> 