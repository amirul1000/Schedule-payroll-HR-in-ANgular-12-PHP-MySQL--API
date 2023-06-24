<a  href="<?php echo site_url('admin/schedule/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Schedule'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/schedule/save/'.$schedule['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
                                    <label for="Super Users" class="col-md-4 control-label">Super Users</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Users_model'); 
             $dataArr = $this->CI->Users_model->get_all_users(); 
          ?> 
          <select name="super_users_id"  id="super_users_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($schedule['super_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="Worker Users" class="col-md-4 control-label">Worker Users</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Users_model'); 
             $dataArr = $this->CI->Users_model->get_all_users(); 
          ?> 
          <select name="worker_users_id"  id="worker_users_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($schedule['worker_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="Business" class="col-md-4 control-label">Business</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Business_model'); 
             $dataArr = $this->CI->Business_model->get_all_business(); 
          ?> 
          <select name="business_id"  id="business_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($schedule['business_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['business_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="Location" class="col-md-4 control-label">Location</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Location_model'); 
             $dataArr = $this->CI->Location_model->get_all_location(); 
          ?> 
          <select name="location_id"  id="location_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($schedule['location_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['location_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="Area" class="col-md-4 control-label">Area</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Area_model'); 
             $dataArr = $this->CI->Area_model->get_all_area(); 
          ?> 
          <select name="area_id"  id="area_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($schedule['area_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['area_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                       <label for="Start Date" class="col-md-4 control-label">Start Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="start_date"  id="start_date"  value="<?php echo ($this->input->post('start_date') ? $this->input->post('start_date') : $schedule['start_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
                                       <label for="End Date" class="col-md-4 control-label">End Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="end_date"  id="end_date"  value="<?php echo ($this->input->post('end_date') ? $this->input->post('end_date') : $schedule['end_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
          <label for="Start" class="col-md-4 control-label">Start</label> 
          <div class="col-md-8"> 
           <input type="text" name="start" value="<?php echo ($this->input->post('start') ? $this->input->post('start') : $schedule['start']); ?>" class="form-control" id="start" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Finish" class="col-md-4 control-label">Finish</label> 
          <div class="col-md-8"> 
           <input type="text" name="finish" value="<?php echo ($this->input->post('finish') ? $this->input->post('finish') : $schedule['finish']); ?>" class="form-control" id="finish" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Meal Break" class="col-md-4 control-label">Meal Break</label> 
          <div class="col-md-8"> 
           <input type="text" name="meal_break" value="<?php echo ($this->input->post('meal_break') ? $this->input->post('meal_break') : $schedule['meal_break']); ?>" class="form-control" id="meal_break" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Rest Break" class="col-md-4 control-label">Rest Break</label> 
          <div class="col-md-8"> 
           <input type="text" name="rest_break" value="<?php echo ($this->input->post('rest_break') ? $this->input->post('rest_break') : $schedule['rest_break']); ?>" class="form-control" id="rest_break" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Notes" class="col-md-4 control-label">Notes</label> 
          <div class="col-md-8"> 
           <textarea  name="notes"  id="notes"  class="form-control" rows="4"/><?php echo ($this->input->post('notes') ? $this->input->post('notes') : $schedule['notes']); ?></textarea> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Publish Type" class="col-md-4 control-label">Publish Type</label> 
          <div class="col-md-8"> 
           <input type="text" name="publish_type" value="<?php echo ($this->input->post('publish_type') ? $this->input->post('publish_type') : $schedule['publish_type']); ?>" class="form-control" id="publish_type" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Status" class="col-md-4 control-label">Status</label> 
          <div class="col-md-8"> 
           <?php 
             $enumArr = $this->customlib->getEnumFieldValues('schedule','status'); 
           ?> 
           <select name="status"  id="status"  class="form-control"/> 
             <option value="">--Select--</option> 
             <?php 
              for($i=0;$i<count($enumArr);$i++) 
              { 
             ?> 
             <option value="<?=$enumArr[$i]?>" <?php if($schedule['status']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php 
              } 
             ?> 
           </select> 
          </div> 
            </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($schedule['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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