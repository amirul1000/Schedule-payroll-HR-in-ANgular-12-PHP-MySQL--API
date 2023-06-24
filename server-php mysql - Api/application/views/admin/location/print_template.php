<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css"> 
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Location'); ?></h3>
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
<!--Data display of location-->    
<table   cellspacing="3" cellpadding="3" class="table" align="center">
    <tr>
		<th>Super Users</th>
<th>Business</th>
<th>Location Name</th>
<th>Location Code</th>
<th>Address</th>
<th>Timezone</th>
<th>Week Start</th>
<th>ROSTER DEFAULT SHIFT LEN</th>
<th>DEFAULT MEALBREAK DURATION</th>
<th>Monday</th>
<th>Monday From</th>
<th>Monday To</th>
<th>Tuesday</th>
<th>Tuesday From</th>
<th>Tuesday To</th>
<th>Wednesday</th>
<th>Wednesday From</th>
<th>Wednesday To</th>
<th>Thursday</th>
<th>Thursday From</th>
<th>Thursday To</th>
<th>Friday</th>
<th>Friday From</th>
<th>Friday To</th>
<th>Saturday</th>
<th>Saturday From</th>
<th>Saturday To</th>
<th>Sunday</th>
<th>Sunday From</th>
<th>Sunday To</th>
<th>Notes</th>

    </tr>
	<?php foreach($location as $c){ ?>
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
									   $this->CI->load->model('Business_model');
									   $dataArr = $this->CI->Business_model->get_business($c['business_id']);
									   echo $dataArr['business_name'];?>
									</td>
<td><?php echo $c['location_name']; ?></td>
<td><?php echo $c['location_code']; ?></td>
<td><?php echo $c['address']; ?></td>
<td><?php echo $c['timezone']; ?></td>
<td><?php echo $c['week_start']; ?></td>
<td><?php echo $c['ROSTER_DEFAULT_SHIFT_LEN']; ?></td>
<td><?php echo $c['DEFAULT_MEALBREAK_DURATION']; ?></td>
<td><?php echo $c['monday']; ?></td>
<td><?php echo $c['monday_from']; ?></td>
<td><?php echo $c['monday_to']; ?></td>
<td><?php echo $c['tuesday']; ?></td>
<td><?php echo $c['tuesday_from']; ?></td>
<td><?php echo $c['tuesday_to']; ?></td>
<td><?php echo $c['wednesday']; ?></td>
<td><?php echo $c['wednesday_from']; ?></td>
<td><?php echo $c['wednesday_to']; ?></td>
<td><?php echo $c['thursday']; ?></td>
<td><?php echo $c['thursday_from']; ?></td>
<td><?php echo $c['thursday_to']; ?></td>
<td><?php echo $c['friday']; ?></td>
<td><?php echo $c['friday_from']; ?></td>
<td><?php echo $c['friday_to']; ?></td>
<td><?php echo $c['saturday']; ?></td>
<td><?php echo $c['saturday_from']; ?></td>
<td><?php echo $c['saturday_to']; ?></td>
<td><?php echo $c['sunday']; ?></td>
<td><?php echo $c['sunday_from']; ?></td>
<td><?php echo $c['sunday_to']; ?></td>
<td><?php echo $c['notes']; ?></td>

    </tr>
	<?php } ?>
</table>
<!--End of Data display of location//--> 