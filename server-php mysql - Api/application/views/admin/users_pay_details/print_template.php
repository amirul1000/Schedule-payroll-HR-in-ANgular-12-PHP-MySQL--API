<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css"> 
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Users_pay_details'); ?></h3>
Date: <?php echo date("Y-m-d");?>
<hr>
<!--*************************************************
*********mpdf header footer page no******************
****************************************************-->
<htmlpageheader name="firstpage" class="hide">
</htmlpageheader>

<htmlpageheader name="otherpages" class="hide">
    <span class="float_left"></span>
    <span  class="padding_5"> &nbsp; &nbsp; &nbsp;
     &nbsp; &nbsp; &nbsp;</span>
    <span class="float_right"></span>         
</htmlpageheader>      
<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" /> 
   
<htmlpagefooter name="myfooter"  class="hide">                          
     <div align="center">
               <br><span class="padding_10">Page {PAGENO} of {nbpg}</span> 
     </div>
</htmlpagefooter>    

<sethtmlpagefooter name="myfooter" value="on" />
<!--*************************************************
*********#////mpdf header footer page no******************
****************************************************-->
<!--Data display of users_pay_details-->    
<table   cellspacing="3" cellpadding="3" class="table" align="center">
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

    </tr>
	<?php } ?>
</table>
<!--End of Data display of users_pay_details//--> 