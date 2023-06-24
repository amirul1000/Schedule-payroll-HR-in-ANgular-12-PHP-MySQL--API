<a  href="<?php echo site_url('admin/users_unavailability/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Users_unavailability'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/users_unavailability/save/'.$users_unavailability['id'],array("class"=>"form-horizontal")); ?>
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($users_unavailability['users_pay_details_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['Payroll_ID']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                       <label for="Start Date" class="col-md-4 control-label">Start Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="start_date"  id="start_date"  value="<?php echo ($this->input->post('start_date') ? $this->input->post('start_date') : $users_unavailability['start_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
          <label for="Start Time" class="col-md-4 control-label">Start Time</label> 
          <div class="col-md-8"> 
           <input type="text" name="start_time" value="<?php echo ($this->input->post('start_time') ? $this->input->post('start_time') : $users_unavailability['start_time']); ?>" class="form-control" id="start_time" /> 
          </div> 
           </div>
<div class="form-group"> 
                                       <label for="End Date" class="col-md-4 control-label">End Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="end_date"  id="end_date"  value="<?php echo ($this->input->post('end_date') ? $this->input->post('end_date') : $users_unavailability['end_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
          <label for="End Time" class="col-md-4 control-label">End Time</label> 
          <div class="col-md-8"> 
           <input type="text" name="end_time" value="<?php echo ($this->input->post('end_time') ? $this->input->post('end_time') : $users_unavailability['end_time']); ?>" class="form-control" id="end_time" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Repeat Type" class="col-md-4 control-label">Repeat Type</label> 
          <div class="col-md-8"> 
           <input type="text" name="repeat_type" value="<?php echo ($this->input->post('repeat_type') ? $this->input->post('repeat_type') : $users_unavailability['repeat_type']); ?>" class="form-control" id="repeat_type" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Mon" class="col-md-4 control-label">Mon</label> 
          <div class="col-md-8"> 
           <input type="text" name="Mon" value="<?php echo ($this->input->post('Mon') ? $this->input->post('Mon') : $users_unavailability['Mon']); ?>" class="form-control" id="Mon" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Tue" class="col-md-4 control-label">Tue</label> 
          <div class="col-md-8"> 
           <input type="text" name="Tue" value="<?php echo ($this->input->post('Tue') ? $this->input->post('Tue') : $users_unavailability['Tue']); ?>" class="form-control" id="Tue" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Wed" class="col-md-4 control-label">Wed</label> 
          <div class="col-md-8"> 
           <input type="text" name="Wed" value="<?php echo ($this->input->post('Wed') ? $this->input->post('Wed') : $users_unavailability['Wed']); ?>" class="form-control" id="Wed" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Thu" class="col-md-4 control-label">Thu</label> 
          <div class="col-md-8"> 
           <input type="text" name="Thu" value="<?php echo ($this->input->post('Thu') ? $this->input->post('Thu') : $users_unavailability['Thu']); ?>" class="form-control" id="Thu" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Fri" class="col-md-4 control-label">Fri</label> 
          <div class="col-md-8"> 
           <input type="text" name="Fri" value="<?php echo ($this->input->post('Fri') ? $this->input->post('Fri') : $users_unavailability['Fri']); ?>" class="form-control" id="Fri" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Sat" class="col-md-4 control-label">Sat</label> 
          <div class="col-md-8"> 
           <input type="text" name="Sat" value="<?php echo ($this->input->post('Sat') ? $this->input->post('Sat') : $users_unavailability['Sat']); ?>" class="form-control" id="Sat" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Sun" class="col-md-4 control-label">Sun</label> 
          <div class="col-md-8"> 
           <input type="text" name="Sun" value="<?php echo ($this->input->post('Sun') ? $this->input->post('Sun') : $users_unavailability['Sun']); ?>" class="form-control" id="Sun" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Notes" class="col-md-4 control-label">Notes</label> 
          <div class="col-md-8"> 
           <textarea  name="notes"  id="notes"  class="form-control" rows="4"/><?php echo ($this->input->post('notes') ? $this->input->post('notes') : $users_unavailability['notes']); ?></textarea> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($users_unavailability['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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