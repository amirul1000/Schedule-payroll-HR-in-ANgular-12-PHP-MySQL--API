<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Location'); ?></h5>
<?php
  	echo $this->session->flashdata('msg');
?>
<!--Action-->
<div>
	<div class="float_left padding_10">
		<a href="<?php echo site_url('admin/location/save'); ?>"
			class="btn btn-success">Add</a>
	</div>
	<div class="float_left padding_10">
		<i class="fa fa-download"></i> Export <select name="xeport_type" class="select"
			onChange="window.location='<?php echo site_url('admin/location/export'); ?>/'+this.value">
			<option>Select..</option>
			<option>Pdf</option>
			<option>CSV</option>
		</select>
	</div>
	<div  class="float_right padding_10">
		<ul class="left-side-navbar d-flex align-items-center">
			<li class="hide-phone app-search mr-15">
                <?php echo form_open_multipart('admin/location/search/',array("class"=>"form-horizontal")); ?>
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
   
<!--Data display of location-->       
<table class="table table-striped table-bordered">
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

		<th>Actions</th>
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

		<td>
            <a href="<?php echo site_url('admin/location/details/'.$c['id']); ?>"  class="action-icon"> <i class="zmdi zmdi-eye"></i></a>
            <a href="<?php echo site_url('admin/location/save/'.$c['id']); ?>" class="action-icon"> <i class="zmdi zmdi-edit"></i></a>
            <a href="<?php echo site_url('admin/location/remove/'.$c['id']); ?>" onClick="return confirm('Are you sure to delete this item?');" class="action-icon"> <i class="zmdi zmdi-delete"></i></a>
        </td>
    </tr>
	<?php } ?>
</table>
<!--End of Data display of location//--> 

<!--No data-->
<?php
	if(count($location)==0){
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
