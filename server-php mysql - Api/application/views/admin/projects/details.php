<a  href="<?php echo site_url('admin/projects/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Projects'); ?></h5>
<!--Data display of projects with id--> 
<?php
	$c = $projects;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Business</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Business_model');
									   $dataArr = $this->CI->Business_model->get_business($c['business_id']);
									   echo $dataArr['business_name'];?>
									</td></tr>

<tr><td>Super Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['super_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Assign To Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['assign_to_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Location</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Location_model');
									   $dataArr = $this->CI->Location_model->get_location($c['location_id']);
									   echo $dataArr['location_name'];?>
									</td></tr>

<tr><td>Project Title</td><td><?php echo $c['project_title']; ?></td></tr>

<tr><td>Project Description</td><td><?php echo $c['project_description']; ?></td></tr>

<tr><td>Due Date</td><td><?php echo $c['due_date']; ?></td></tr>

<tr><td>Notes</td><td><?php echo $c['notes']; ?></td></tr>

<tr><td>Priority</td><td><?php echo $c['priority']; ?></td></tr>

<tr><td>Project Status</td><td><?php echo $c['project_status']; ?></td></tr>

<tr><td>File Project</td><td><?php
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
										</td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of projects with id//--> 