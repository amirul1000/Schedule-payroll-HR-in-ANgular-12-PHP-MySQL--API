<a  href="<?php echo site_url('admin/users_leave/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Users_leave'); ?></h5>
<!--Data display of users_leave with id--> 
<?php
	$c = $users_leave;
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

<tr><td>End Date</td><td><?php echo $c['end_date']; ?></td></tr>

<tr><td>Leave Type</td><td><?php echo $c['leave_type']; ?></td></tr>


</table>
<!--End of Data display of users_leave with id//--> 