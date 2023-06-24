<a  href="<?php echo site_url('admin/task/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Task'); ?></h5>
<!--Data display of task with id--> 
<?php
	$c = $task;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Assign By Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['assign_by_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Assign To Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['assign_to_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Task Title</td><td><?php echo $c['task_title']; ?></td></tr>

<tr><td>Due Date</td><td><?php echo $c['due_date']; ?></td></tr>

<tr><td>Notes</td><td><?php echo $c['notes']; ?></td></tr>

<tr><td>Status</td><td><?php echo $c['status']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of task with id//--> 