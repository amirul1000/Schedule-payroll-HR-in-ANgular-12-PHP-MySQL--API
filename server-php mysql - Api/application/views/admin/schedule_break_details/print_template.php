<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css"> 
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Schedule_break_details'); ?></h3>
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
<!--Data display of schedule_break_details-->    
<table   cellspacing="3" cellpadding="3" class="table" align="center">
    <tr>
		<th>Schedule</th>
<th>Type</th>
<th>Duration</th>
<th>Start</th>
<th>Finish</th>

    </tr>
	<?php foreach($schedule_break_details as $c){ ?>
    <tr>
		<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Schedule_model');
									   $dataArr = $this->CI->Schedule_model->get_schedule($c['schedule_id']);
									   echo $dataArr['start_date'];?>
									</td>
<td><?php echo $c['type']; ?></td>
<td><?php echo $c['duration']; ?></td>
<td><?php echo $c['start']; ?></td>
<td><?php echo $c['finish']; ?></td>

    </tr>
	<?php } ?>
</table>
<!--End of Data display of schedule_break_details//--> 