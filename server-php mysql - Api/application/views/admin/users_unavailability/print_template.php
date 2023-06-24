<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css"> 
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Users_unavailability'); ?></h3>
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
<!--Data display of users_unavailability-->    
<table   cellspacing="3" cellpadding="3" class="table" align="center">
    <tr>
		<th>Users Pay Details</th>
<th>Start Date</th>
<th>Start Time</th>
<th>End Date</th>
<th>End Time</th>
<th>Repeat Type</th>
<th>Mon</th>
<th>Tue</th>
<th>Wed</th>
<th>Thu</th>
<th>Fri</th>
<th>Sat</th>
<th>Sun</th>
<th>Notes</th>

    </tr>
	<?php foreach($users_unavailability as $c){ ?>
    <tr>
		<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_pay_details_model');
									   $dataArr = $this->CI->Users_pay_details_model->get_users_pay_details($c['users_pay_details_id']);
									   echo $dataArr['Payroll_ID'];?>
									</td>
<td><?php echo $c['start_date']; ?></td>
<td><?php echo $c['start_time']; ?></td>
<td><?php echo $c['end_date']; ?></td>
<td><?php echo $c['end_time']; ?></td>
<td><?php echo $c['repeat_type']; ?></td>
<td><?php echo $c['Mon']; ?></td>
<td><?php echo $c['Tue']; ?></td>
<td><?php echo $c['Wed']; ?></td>
<td><?php echo $c['Thu']; ?></td>
<td><?php echo $c['Fri']; ?></td>
<td><?php echo $c['Sat']; ?></td>
<td><?php echo $c['Sun']; ?></td>
<td><?php echo $c['notes']; ?></td>

    </tr>
	<?php } ?>
</table>
<!--End of Data display of users_unavailability//--> 