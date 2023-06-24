<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Projects'); ?></h5>
<?php
  	echo $this->session->flashdata('msg');
?>
<!--Action-->
<div>
	<div class="float_left padding_10">
		<a href="<?php echo site_url('admin/projects/save'); ?>"
			class="btn btn-success">Add</a>
	</div>
	<div class="float_left padding_10">
		<i class="fa fa-download"></i> Export <select name="xeport_type" class="select"
			onChange="window.location='<?php echo site_url('admin/projects/export'); ?>/'+this.value">
			<option>Select..</option>
			<option>Pdf</option>
			<option>CSV</option>
		</select>
	</div>
	<div  class="float_right padding_10">
		<ul class="left-side-navbar d-flex align-items-center">
			<li class="hide-phone app-search mr-15">
                <?php echo form_open_multipart('admin/projects/search/',array("class"=>"form-horizontal")); ?>
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
   
<!--Data display of projects-->       
<table class="table table-striped table-bordered">
    <tr>
		<th>Business</th>
<th>Super Users</th>
<th>Assign To Users</th>
<th>Location</th>
<th>Project Title</th>
<th>Project Description</th>
<th>Due Date</th>
<th>Notes</th>
<th>Priority</th>
<th>Project Status</th>
<th>File Project</th>

		<th>Actions</th>
    </tr>
	<?php foreach($projects as $c){ ?>
    <tr>
		<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Business_model');
									   $dataArr = $this->CI->Business_model->get_business($c['business_id']);
									   echo $dataArr['business_name'];?>
									</td>
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
									   $dataArr = $this->CI->Users_model->get_users($c['assign_to_users_id']);
									   echo $dataArr['email'];?>
									</td>
<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Location_model');
									   $dataArr = $this->CI->Location_model->get_location($c['location_id']);
									   echo $dataArr['location_name'];?>
									</td>
<td><?php echo $c['project_title']; ?></td>
<td><?php echo $c['project_description']; ?></td>
<td><?php echo $c['due_date']; ?></td>
<td><?php echo $c['notes']; ?></td>
<td><?php echo $c['priority']; ?></td>
<td><?php echo $c['project_status']; ?></td>
<td><?php
											if(is_file(APPPATH.'../public/'.$c['file_project'])&&file_exists(APPPATH.'../public/'.$c['file_project']))
											{
										 ?>
										  <img src="<?php echo base_url().'public/'.$c['file_project']?>" class="picture_50x50">
										  <?php
											}
											else
											{
										?>
										<img src="<?php echo base_url()?>public/uploads/no_image.jpg" class="picture_50x50">
										<?php		
											}
										  ?>	
										</td>

		<td>
            <a href="<?php echo site_url('admin/projects/details/'.$c['id']); ?>"  class="action-icon"> <i class="zmdi zmdi-eye"></i></a>
            <a href="<?php echo site_url('admin/projects/save/'.$c['id']); ?>" class="action-icon"> <i class="zmdi zmdi-edit"></i></a>
            <a href="<?php echo site_url('admin/projects/remove/'.$c['id']); ?>" onClick="return confirm('Are you sure to delete this item?');" class="action-icon"> <i class="zmdi zmdi-delete"></i></a>
        </td>
    </tr>
	<?php } ?>
</table>
<!--End of Data display of projects//--> 

<!--No data-->
<?php
	if(count($projects)==0){
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
