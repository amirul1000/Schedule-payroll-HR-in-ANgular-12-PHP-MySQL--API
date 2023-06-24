<a  href="<?php echo site_url('admin/users_pay_details/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Users_pay_details'); ?></h5>
<!--Data display of users_pay_details with id--> 
<?php
	$c = $users_pay_details;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Super Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['super_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

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

<tr><td>Payroll ID</td><td><?php echo $c['Payroll_ID']; ?></td></tr>

<tr><td>Access Level</td><td><?php echo $c['access_level']; ?></td></tr>

<tr><td>Employee Start Date</td><td><?php echo $c['employee_start_date']; ?></td></tr>

<tr><td>Stress Profile</td><td><?php echo $c['stress_profile']; ?></td></tr>

<tr><td>Employeement Type</td><td><?php echo $c['employeement_type']; ?></td></tr>

<tr><td>Pay Rate Type</td><td><?php echo $c['pay_rate_type']; ?></td></tr>

<tr><td>Salary Type</td><td><?php echo $c['salary_type']; ?></td></tr>

<tr><td>Salary Amount</td><td><?php echo $c['salary_amount']; ?></td></tr>

<tr><td>Weekday Rate</td><td><?php echo $c['weekday_rate']; ?></td></tr>

<tr><td>Public Holiday Rate</td><td><?php echo $c['public_holiday_rate']; ?></td></tr>

<tr><td>Saterday Rate</td><td><?php echo $c['saterday_rate']; ?></td></tr>

<tr><td>Sunday Rate</td><td><?php echo $c['sunday_rate']; ?></td></tr>

<tr><td>Monday Rate</td><td><?php echo $c['monday_rate']; ?></td></tr>

<tr><td>Tuesday Rate</td><td><?php echo $c['tuesday_rate']; ?></td></tr>

<tr><td>Wednesday Rate</td><td><?php echo $c['wednesday_rate']; ?></td></tr>

<tr><td>Thrusday Rate</td><td><?php echo $c['thrusday_rate']; ?></td></tr>

<tr><td>Friday Rate</td><td><?php echo $c['friday_rate']; ?></td></tr>

<tr><td>Hourly Rate</td><td><?php echo $c['hourly_rate']; ?></td></tr>

<tr><td>Overtime Rate</td><td><?php echo $c['overtime_rate']; ?></td></tr>


</table>
<!--End of Data display of users_pay_details with id//--> 