<a  href="<?php echo site_url('admin/users_unavailability/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Users_unavailability'); ?></h5>
<!--Data display of users_unavailability with id--> 
<?php
	$c = $users_unavailability;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Users Pay Details</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_pay_details_model');
									   $dataArr = $this->CI->Users_pay_details_model->get_users_pay_details($c['users_pay_details_id']);
									   echo $dataArr['Payroll_ID'];?>
									</td></tr>

<tr><td>Start Date</td><td><?php echo $c['start_date']; ?></td></tr>

<tr><td>Start Time</td><td><?php echo $c['start_time']; ?></td></tr>

<tr><td>End Date</td><td><?php echo $c['end_date']; ?></td></tr>

<tr><td>End Time</td><td><?php echo $c['end_time']; ?></td></tr>

<tr><td>Repeat Type</td><td><?php echo $c['repeat_type']; ?></td></tr>

<tr><td>Mon</td><td><?php echo $c['Mon']; ?></td></tr>

<tr><td>Tue</td><td><?php echo $c['Tue']; ?></td></tr>

<tr><td>Wed</td><td><?php echo $c['Wed']; ?></td></tr>

<tr><td>Thu</td><td><?php echo $c['Thu']; ?></td></tr>

<tr><td>Fri</td><td><?php echo $c['Fri']; ?></td></tr>

<tr><td>Sat</td><td><?php echo $c['Sat']; ?></td></tr>

<tr><td>Sun</td><td><?php echo $c['Sun']; ?></td></tr>

<tr><td>Notes</td><td><?php echo $c['notes']; ?></td></tr>


</table>
<!--End of Data display of users_unavailability with id//--> 