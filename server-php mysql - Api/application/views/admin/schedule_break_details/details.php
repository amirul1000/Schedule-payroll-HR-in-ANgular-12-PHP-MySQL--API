<a  href="<?php echo site_url('admin/schedule_break_details/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Schedule_break_details'); ?></h5>
<!--Data display of schedule_break_details with id--> 
<?php
	$c = $schedule_break_details;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Schedule</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Schedule_model');
									   $dataArr = $this->CI->Schedule_model->get_schedule($c['schedule_id']);
									   echo $dataArr['start_date'];?>
									</td></tr>

<tr><td>Type</td><td><?php echo $c['type']; ?></td></tr>

<tr><td>Duration</td><td><?php echo $c['duration']; ?></td></tr>

<tr><td>Start</td><td><?php echo $c['start']; ?></td></tr>

<tr><td>Finish</td><td><?php echo $c['finish']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of schedule_break_details with id//--> 