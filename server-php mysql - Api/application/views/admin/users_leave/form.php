<a  href="<?php echo site_url('admin/users_leave/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Users_leave'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/users_leave/save/'.$users_leave['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
                                    <label for="Users Pay Details" class="col-md-4 control-label">Users Pay Details</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Users_pay_details_model'); 
             $dataArr = $this->CI->Users_pay_details_model->get_all_users_pay_details(); 
          ?> 
          <select name="users_pay_details_id"  id="users_pay_details_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($users_leave['users_pay_details_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['Payroll_ID']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                       <label for="Start Date" class="col-md-4 control-label">Start Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="start_date"  id="start_date"  value="<?php echo ($this->input->post('start_date') ? $this->input->post('start_date') : $users_leave['start_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
                                       <label for="End Date" class="col-md-4 control-label">End Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="end_date"  id="end_date"  value="<?php echo ($this->input->post('end_date') ? $this->input->post('end_date') : $users_leave['end_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
          <label for="Leave Type" class="col-md-4 control-label">Leave Type</label> 
          <div class="col-md-8"> 
           <input type="text" name="leave_type" value="<?php echo ($this->input->post('leave_type') ? $this->input->post('leave_type') : $users_leave['leave_type']); ?>" class="form-control" id="leave_type" /> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($users_leave['id'])){?>Save<?php }else{?>Update<?php } ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->	
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>  			