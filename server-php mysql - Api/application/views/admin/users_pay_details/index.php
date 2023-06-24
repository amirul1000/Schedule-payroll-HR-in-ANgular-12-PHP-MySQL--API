<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Users_pay_details'); ?></h5>
<?php
  	echo $this->session->flashdata('msg');
?>
<!--Action-->
<div>
	<div class="float_left padding_10">
		<a href="<?php echo site_url('admin/users_pay_details/save'); ?>"
			class="btn btn-success">Add</a>
	</div>
	<div class="float_left padding_10">
		<i class="fa fa-download"></i> Export <select name="xeport_type" class="select"
			onChange="window.location='<?php echo site_url('admin/users_pay_details/export'); ?>/'+this.value">
			<option>Select..</option>
			<option>Pdf</option>
			<option>CSV</option>
		</select>
	</div>
	<div  class="float_right padding_10">
		<ul class="left-side-navbar d-flex align-items-center">
			<li class="hide-phone app-search mr-15">
                <?php echo form_open_multipart('admin/users_pay_details/search/',array("class"=>"form-horizontal")); ?>
                    <input name="key" type="text"
				value="<?php echo isset($key)?$key:'';?>" placeholder="Search..."
				class="form-control">
				<button type="submit" class="mr-0">
					<i class="fa fa-search"></i>
				</button>
                <?php echo form_close(); ?>
            </li>
		</ul>
	</div>
</div>
<!--End of Action//--> 
   
<!--Data display of users_pay_details-->       
<table class="table table-striped table-bordered">
    <tr>
		<th>Super Users</th>
<th>Users</th>
<th>Business</th>
<th>Payroll ID</th>
<th>Access Level</th>
<th>Employee Start Date</th>
<th>Stress Profile</th>
<th>Employeement Type</th>
<th>Pay Rate Type</th>
<th>Salary Type</th>
<th>Salary Amount</th>
<th>Weekday Rate</th>
<th>Public Holiday Rate</th>
<th>Saterday Rate</th>
<th>Sunday Rate</th>
<th>Monday Rate</th>
<th>Tuesday Rate</th>
<th>Wednesday Rate</th>
<th>Thrusday Rate</th>
<th>Friday Rate</th>
<th>Hourly Rate</th>
<th>Overtime Rate</th>

		<th>Actions</th>
    </tr>
	<?php foreach($users_pay_details as $c){ ?>
    <tr>
		<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['super_users_id']);
									   echo $dataArr['email'];?>
									</td>
<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['users_id']);
									   echo $dataArr['email'];?>
									</td>
<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Business_model');
									   $dataArr = $this->CI->Business_model->get_business($c['business_id']);
									   echo $dataArr['business_name'];?>
									</td>
<td><?php echo $c['Payroll_ID']; ?></td>
<td><?php echo $c['access_level']; ?></td>
<td><?php echo $c['employee_start_date']; ?></td>
<td><?php echo $c['stress_profile']; ?></td>
<td><?php echo $c['employeement_type']; ?></td>
<td><?php echo $c['pay_rate_type']; ?></td>
<td><?php echo $c['salary_type']; ?></td>
<td><?php echo $c['salary_amount']; ?></td>
<td><?php echo $c['weekday_rate']; ?></td>
<td><?php echo $c['public_holiday_rate']; ?></td>
<td><?php echo $c['saterday_rate']; ?></td>
<td><?php echo $c['sunday_rate']; ?></td>
<td><?php echo $c['monday_rate']; ?></td>
<td><?php echo $c['tuesday_rate']; ?></td>
<td><?php echo $c['wednesday_rate']; ?></td>
<td><?php echo $c['thrusday_rate']; ?></td>
<td><?php echo $c['friday_rate']; ?></td>
<td><?php echo $c['hourly_rate']; ?></td>
<td><?php echo $c['overtime_rate']; ?></td>

		<td>
            <a href="<?php echo site_url('admin/users_pay_details/details/'.$c['id']); ?>"  class="action-icon"> <i class="zmdi zmdi-eye"></i></a>
            <a href="<?php echo site_url('admin/users_pay_details/save/'.$c['id']); ?>" class="action-icon"> <i class="zmdi zmdi-edit"></i></a>
            <a href="<?php echo site_url('admin/users_pay_details/remove/'.$c['id']); ?>" onClick="return confirm('Are you sure to delete this item?');" class="action-icon"> <i class="zmdi zmdi-delete"></i></a>
        </td>
    </tr>
	<?php } ?>
</table>
<!--End of Data display of users_pay_details//--> 

<!--No data-->
<?php
	if(count($users_pay_details)==0){
?>
 <div align="center"><h3>Data is not exists</h3></div>
<?php
	}
?>
<!--End of No data//-->

<!--Pagination-->
<?php
	echo $link;
?>
<!--End of Pagination//-->
