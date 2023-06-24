<a  href="<?php echo site_url('admin/location/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Location'); ?></h5>
<!--Data display of location with id--> 
<?php
	$c = $location;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Super Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['super_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Business</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Business_model');
									   $dataArr = $this->CI->Business_model->get_business($c['business_id']);
									   echo $dataArr['business_name'];?>
									</td></tr>

<tr><td>Location Name</td><td><?php echo $c['location_name']; ?></td></tr>

<tr><td>Location Code</td><td><?php echo $c['location_code']; ?></td></tr>

<tr><td>Address</td><td><?php echo $c['address']; ?></td></tr>

<tr><td>Timezone</td><td><?php echo $c['timezone']; ?></td></tr>

<tr><td>Week Start</td><td><?php echo $c['week_start']; ?></td></tr>

<tr><td>ROSTER DEFAULT SHIFT LEN</td><td><?php echo $c['ROSTER_DEFAULT_SHIFT_LEN']; ?></td></tr>

<tr><td>DEFAULT MEALBREAK DURATION</td><td><?php echo $c['DEFAULT_MEALBREAK_DURATION']; ?></td></tr>

<tr><td>Monday</td><td><?php echo $c['monday']; ?></td></tr>

<tr><td>Monday From</td><td><?php echo $c['monday_from']; ?></td></tr>

<tr><td>Monday To</td><td><?php echo $c['monday_to']; ?></td></tr>

<tr><td>Tuesday</td><td><?php echo $c['tuesday']; ?></td></tr>

<tr><td>Tuesday From</td><td><?php echo $c['tuesday_from']; ?></td></tr>

<tr><td>Tuesday To</td><td><?php echo $c['tuesday_to']; ?></td></tr>

<tr><td>Wednesday</td><td><?php echo $c['wednesday']; ?></td></tr>

<tr><td>Wednesday From</td><td><?php echo $c['wednesday_from']; ?></td></tr>

<tr><td>Wednesday To</td><td><?php echo $c['wednesday_to']; ?></td></tr>

<tr><td>Thursday</td><td><?php echo $c['thursday']; ?></td></tr>

<tr><td>Thursday From</td><td><?php echo $c['thursday_from']; ?></td></tr>

<tr><td>Thursday To</td><td><?php echo $c['thursday_to']; ?></td></tr>

<tr><td>Friday</td><td><?php echo $c['friday']; ?></td></tr>

<tr><td>Friday From</td><td><?php echo $c['friday_from']; ?></td></tr>

<tr><td>Friday To</td><td><?php echo $c['friday_to']; ?></td></tr>

<tr><td>Saturday</td><td><?php echo $c['saturday']; ?></td></tr>

<tr><td>Saturday From</td><td><?php echo $c['saturday_from']; ?></td></tr>

<tr><td>Saturday To</td><td><?php echo $c['saturday_to']; ?></td></tr>

<tr><td>Sunday</td><td><?php echo $c['sunday']; ?></td></tr>

<tr><td>Sunday From</td><td><?php echo $c['sunday_from']; ?></td></tr>

<tr><td>Sunday To</td><td><?php echo $c['sunday_to']; ?></td></tr>

<tr><td>Notes</td><td><?php echo $c['notes']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of location with id//--> 