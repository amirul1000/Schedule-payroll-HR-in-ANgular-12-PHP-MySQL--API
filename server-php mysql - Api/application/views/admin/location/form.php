<a  href="<?php echo site_url('admin/location/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Location'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/location/save/'.$location['id'],array("class"=>"form-horizontal")); ?>
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($location['super_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($location['business_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['business_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
          <label for="Location Name" class="col-md-4 control-label">Location Name</label> 
          <div class="col-md-8"> 
           <input type="text" name="location_name" value="<?php echo ($this->input->post('location_name') ? $this->input->post('location_name') : $location['location_name']); ?>" class="form-control" id="location_name" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Location Code" class="col-md-4 control-label">Location Code</label> 
          <div class="col-md-8"> 
           <input type="text" name="location_code" value="<?php echo ($this->input->post('location_code') ? $this->input->post('location_code') : $location['location_code']); ?>" class="form-control" id="location_code" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Address" class="col-md-4 control-label">Address</label> 
          <div class="col-md-8"> 
           <textarea  name="address"  id="address"  class="form-control" rows="4"/><?php echo ($this->input->post('address') ? $this->input->post('address') : $location['address']); ?></textarea> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Timezone" class="col-md-4 control-label">Timezone</label> 
          <div class="col-md-8"> 
           <input type="text" name="timezone" value="<?php echo ($this->input->post('timezone') ? $this->input->post('timezone') : $location['timezone']); ?>" class="form-control" id="timezone" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Week Start" class="col-md-4 control-label">Week Start</label> 
          <div class="col-md-8"> 
           <input type="text" name="week_start" value="<?php echo ($this->input->post('week_start') ? $this->input->post('week_start') : $location['week_start']); ?>" class="form-control" id="week_start" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="ROSTER DEFAULT SHIFT LEN" class="col-md-4 control-label">ROSTER DEFAULT SHIFT LEN</label> 
          <div class="col-md-8"> 
           <input type="text" name="ROSTER_DEFAULT_SHIFT_LEN" value="<?php echo ($this->input->post('ROSTER_DEFAULT_SHIFT_LEN') ? $this->input->post('ROSTER_DEFAULT_SHIFT_LEN') : $location['ROSTER_DEFAULT_SHIFT_LEN']); ?>" class="form-control" id="ROSTER_DEFAULT_SHIFT_LEN" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="DEFAULT MEALBREAK DURATION" class="col-md-4 control-label">DEFAULT MEALBREAK DURATION</label> 
          <div class="col-md-8"> 
           <input type="text" name="DEFAULT_MEALBREAK_DURATION" value="<?php echo ($this->input->post('DEFAULT_MEALBREAK_DURATION') ? $this->input->post('DEFAULT_MEALBREAK_DURATION') : $location['DEFAULT_MEALBREAK_DURATION']); ?>" class="form-control" id="DEFAULT_MEALBREAK_DURATION" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Monday" class="col-md-4 control-label">Monday</label> 
          <div class="col-md-8"> 
           <input type="text" name="monday" value="<?php echo ($this->input->post('monday') ? $this->input->post('monday') : $location['monday']); ?>" class="form-control" id="monday" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Monday From" class="col-md-4 control-label">Monday From</label> 
          <div class="col-md-8"> 
           <input type="text" name="monday_from" value="<?php echo ($this->input->post('monday_from') ? $this->input->post('monday_from') : $location['monday_from']); ?>" class="form-control" id="monday_from" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Monday To" class="col-md-4 control-label">Monday To</label> 
          <div class="col-md-8"> 
           <input type="text" name="monday_to" value="<?php echo ($this->input->post('monday_to') ? $this->input->post('monday_to') : $location['monday_to']); ?>" class="form-control" id="monday_to" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Tuesday" class="col-md-4 control-label">Tuesday</label> 
          <div class="col-md-8"> 
           <input type="text" name="tuesday" value="<?php echo ($this->input->post('tuesday') ? $this->input->post('tuesday') : $location['tuesday']); ?>" class="form-control" id="tuesday" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Tuesday From" class="col-md-4 control-label">Tuesday From</label> 
          <div class="col-md-8"> 
           <input type="text" name="tuesday_from" value="<?php echo ($this->input->post('tuesday_from') ? $this->input->post('tuesday_from') : $location['tuesday_from']); ?>" class="form-control" id="tuesday_from" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Tuesday To" class="col-md-4 control-label">Tuesday To</label> 
          <div class="col-md-8"> 
           <input type="text" name="tuesday_to" value="<?php echo ($this->input->post('tuesday_to') ? $this->input->post('tuesday_to') : $location['tuesday_to']); ?>" class="form-control" id="tuesday_to" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Wednesday" class="col-md-4 control-label">Wednesday</label> 
          <div class="col-md-8"> 
           <input type="text" name="wednesday" value="<?php echo ($this->input->post('wednesday') ? $this->input->post('wednesday') : $location['wednesday']); ?>" class="form-control" id="wednesday" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Wednesday From" class="col-md-4 control-label">Wednesday From</label> 
          <div class="col-md-8"> 
           <input type="text" name="wednesday_from" value="<?php echo ($this->input->post('wednesday_from') ? $this->input->post('wednesday_from') : $location['wednesday_from']); ?>" class="form-control" id="wednesday_from" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Wednesday To" class="col-md-4 control-label">Wednesday To</label> 
          <div class="col-md-8"> 
           <input type="text" name="wednesday_to" value="<?php echo ($this->input->post('wednesday_to') ? $this->input->post('wednesday_to') : $location['wednesday_to']); ?>" class="form-control" id="wednesday_to" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Thursday" class="col-md-4 control-label">Thursday</label> 
          <div class="col-md-8"> 
           <input type="text" name="thursday" value="<?php echo ($this->input->post('thursday') ? $this->input->post('thursday') : $location['thursday']); ?>" class="form-control" id="thursday" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Thursday From" class="col-md-4 control-label">Thursday From</label> 
          <div class="col-md-8"> 
           <input type="text" name="thursday_from" value="<?php echo ($this->input->post('thursday_from') ? $this->input->post('thursday_from') : $location['thursday_from']); ?>" class="form-control" id="thursday_from" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Thursday To" class="col-md-4 control-label">Thursday To</label> 
          <div class="col-md-8"> 
           <input type="text" name="thursday_to" value="<?php echo ($this->input->post('thursday_to') ? $this->input->post('thursday_to') : $location['thursday_to']); ?>" class="form-control" id="thursday_to" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Friday" class="col-md-4 control-label">Friday</label> 
          <div class="col-md-8"> 
           <input type="text" name="friday" value="<?php echo ($this->input->post('friday') ? $this->input->post('friday') : $location['friday']); ?>" class="form-control" id="friday" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Friday From" class="col-md-4 control-label">Friday From</label> 
          <div class="col-md-8"> 
           <input type="text" name="friday_from" value="<?php echo ($this->input->post('friday_from') ? $this->input->post('friday_from') : $location['friday_from']); ?>" class="form-control" id="friday_from" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Friday To" class="col-md-4 control-label">Friday To</label> 
          <div class="col-md-8"> 
           <input type="text" name="friday_to" value="<?php echo ($this->input->post('friday_to') ? $this->input->post('friday_to') : $location['friday_to']); ?>" class="form-control" id="friday_to" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Saturday" class="col-md-4 control-label">Saturday</label> 
          <div class="col-md-8"> 
           <input type="text" name="saturday" value="<?php echo ($this->input->post('saturday') ? $this->input->post('saturday') : $location['saturday']); ?>" class="form-control" id="saturday" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Saturday From" class="col-md-4 control-label">Saturday From</label> 
          <div class="col-md-8"> 
           <input type="text" name="saturday_from" value="<?php echo ($this->input->post('saturday_from') ? $this->input->post('saturday_from') : $location['saturday_from']); ?>" class="form-control" id="saturday_from" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Saturday To" class="col-md-4 control-label">Saturday To</label> 
          <div class="col-md-8"> 
           <input type="text" name="saturday_to" value="<?php echo ($this->input->post('saturday_to') ? $this->input->post('saturday_to') : $location['saturday_to']); ?>" class="form-control" id="saturday_to" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Sunday" class="col-md-4 control-label">Sunday</label> 
          <div class="col-md-8"> 
           <input type="text" name="sunday" value="<?php echo ($this->input->post('sunday') ? $this->input->post('sunday') : $location['sunday']); ?>" class="form-control" id="sunday" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Sunday From" class="col-md-4 control-label">Sunday From</label> 
          <div class="col-md-8"> 
           <input type="text" name="sunday_from" value="<?php echo ($this->input->post('sunday_from') ? $this->input->post('sunday_from') : $location['sunday_from']); ?>" class="form-control" id="sunday_from" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Sunday To" class="col-md-4 control-label">Sunday To</label> 
          <div class="col-md-8"> 
           <input type="text" name="sunday_to" value="<?php echo ($this->input->post('sunday_to') ? $this->input->post('sunday_to') : $location['sunday_to']); ?>" class="form-control" id="sunday_to" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Notes" class="col-md-4 control-label">Notes</label> 
          <div class="col-md-8"> 
           <textarea  name="notes"  id="notes"  class="form-control" rows="4"/><?php echo ($this->input->post('notes') ? $this->input->post('notes') : $location['notes']); ?></textarea> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($location['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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