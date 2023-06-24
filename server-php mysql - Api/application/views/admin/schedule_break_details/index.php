<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Schedule_break_details'); ?></h5>
<?php
  	echo $this->session->flashdata('msg');
?>
<!--Action-->
<div>
	<div class="float_left padding_10">
		<a href="<?php echo site_url('admin/schedule_break_details/save'); ?>"
			class="btn btn-success">Add</a>
	</div>
	<div class="float_left padding_10">
		<i class="fa fa-download"></i> Export <select name="xeport_type" class="select"
			onChange="window.location='<?php echo site_url('admin/schedule_break_details/export'); ?>/'+this.value">
			<option>Select..</option>
			<option>Pdf</option>
			<option>CSV</option>
		</select>
	</div>
	<div  class="float_right padding_10">
		<ul class="left-side-navbar d-flex align-items-center">
			<li class="hide-phone app-search mr-15">
                <?php echo form_open_multipart('admin/schedule_break_details/search/',array("class"=>"form-horizontal")); ?>
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
   
<!--Data display of schedule_break_details-->       
<table class="table table-striped table-bordered">
    <tr>
		<th>Schedule</th>
<th>Type</th>
<th>Duration</th>
<th>Start</th>
<th>Finish</th>

		<th>Actions</th>
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

		<td>
            <a href="<?php echo site_url('admin/schedule_break_details/details/'.$c['id']); ?>"  class="action-icon"> <i class="zmdi zmdi-eye"></i></a>
            <a href="<?php echo site_url('admin/schedule_break_details/save/'.$c['id']); ?>" class="action-icon"> <i class="zmdi zmdi-edit"></i></a>
            <a href="<?php echo site_url('admin/schedule_break_details/remove/'.$c['id']); ?>" onClick="return confirm('Are you sure to delete this item?');" class="action-icon"> <i class="zmdi zmdi-delete"></i></a>
        </td>
    </tr>
	<?php } ?>
</table>
<!--End of Data display of schedule_break_details//--> 

<!--No data-->
<?php
	if(count($schedule_break_details)==0){
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
