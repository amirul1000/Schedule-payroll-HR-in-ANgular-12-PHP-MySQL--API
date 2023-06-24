<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Users_unavailability'); ?></h5>
<?php
  	echo $this->session->flashdata('msg');
?>
<!--Action-->
<div>
	<div class="float_left padding_10">
		<a href="<?php echo site_url('admin/users_unavailability/save'); ?>"
			class="btn btn-success">Add</a>
	</div>
	<div class="float_left padding_10">
		<i class="fa fa-download"></i> Export <select name="xeport_type" class="select"
			onChange="window.location='<?php echo site_url('admin/users_unavailability/export'); ?>/'+this.value">
			<option>Select..</option>
			<option>Pdf</option>
			<option>CSV</option>
		</select>
	</div>
	<div  class="float_right padding_10">
		<ul class="left-side-navbar d-flex align-items-center">
			<li class="hide-phone app-search mr-15">
                <?php echo form_open_multipart('admin/users_unavailability/search/',array("class"=>"form-horizontal")); ?>
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
   
<!--Data display of users_unavailability-->       
<table class="table table-striped table-bordered">
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

		<th>Actions</th>
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

		<td>
            <a href="<?php echo site_url('admin/users_unavailability/details/'.$c['id']); ?>"  class="action-icon"> <i class="zmdi zmdi-eye"></i></a>
            <a href="<?php echo site_url('admin/users_unavailability/save/'.$c['id']); ?>" class="action-icon"> <i class="zmdi zmdi-edit"></i></a>
            <a href="<?php echo site_url('admin/users_unavailability/remove/'.$c['id']); ?>" onClick="return confirm('Are you sure to delete this item?');" class="action-icon"> <i class="zmdi zmdi-delete"></i></a>
        </td>
    </tr>
	<?php } ?>
</table>
<!--End of Data display of users_unavailability//--> 

<!--No data-->
<?php
	if(count($users_unavailability)==0){
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
