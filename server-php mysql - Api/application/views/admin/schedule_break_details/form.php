<a  href="<?php echo site_url('admin/schedule_break_details/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Schedule_break_details'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/schedule_break_details/save/'.$schedule_break_details['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
                                    <label for="Schedule" class="col-md-4 control-label">Schedule</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Schedule_model'); 
             $dataArr = $this->CI->Schedule_model->get_all_schedule(); 
          ?> 
          <select name="schedule_id"  id="schedule_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($schedule_break_details['schedule_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['start_date']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
          <label for="Type" class="col-md-4 control-label">Type</label> 
          <div class="col-md-8"> 
           <input type="text" name="type" value="<?php echo ($this->input->post('type') ? $this->input->post('type') : $schedule_break_details['type']); ?>" class="form-control" id="type" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Duration" class="col-md-4 control-label">Duration</label> 
          <div class="col-md-8"> 
           <input type="text" name="duration" value="<?php echo ($this->input->post('duration') ? $this->input->post('duration') : $schedule_break_details['duration']); ?>" class="form-control" id="duration" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Start" class="col-md-4 control-label">Start</label> 
          <div class="col-md-8"> 
           <input type="text" name="start" value="<?php echo ($this->input->post('start') ? $this->input->post('start') : $schedule_break_details['start']); ?>" class="form-control" id="start" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Finish" class="col-md-4 control-label">Finish</label> 
          <div class="col-md-8"> 
           <input type="text" name="finish" value="<?php echo ($this->input->post('finish') ? $this->input->post('finish') : $schedule_break_details['finish']); ?>" class="form-control" id="finish" /> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($schedule_break_details['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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