<a  href="<?php echo site_url('admin/projects/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Projects'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/projects/save/'.$projects['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($projects['business_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['business_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($projects['super_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="Assign To Users" class="col-md-4 control-label">Assign To Users</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Users_model'); 
             $dataArr = $this->CI->Users_model->get_all_users(); 
          ?> 
          <select name="assign_to_users_id"  id="assign_to_users_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($projects['assign_to_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($projects['location_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['location_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
          <label for="Project Title" class="col-md-4 control-label">Project Title</label> 
          <div class="col-md-8"> 
           <input type="text" name="project_title" value="<?php echo ($this->input->post('project_title') ? $this->input->post('project_title') : $projects['project_title']); ?>" class="form-control" id="project_title" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Project Description" class="col-md-4 control-label">Project Description</label> 
          <div class="col-md-8"> 
           <textarea  name="project_description"  id="project_description"  class="form-control" rows="4"/><?php echo ($this->input->post('project_description') ? $this->input->post('project_description') : $projects['project_description']); ?></textarea> 
          </div> 
           </div>
<div class="form-group"> 
                                       <label for="Due Date" class="col-md-4 control-label">Due Date</label> 
          <div class="col-md-8"> 
           <input type="text" name="due_date"  id="due_date"  value="<?php echo ($this->input->post('due_date') ? $this->input->post('due_date') : $projects['due_date']); ?>" class="form-control-static datepicker"/> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Notes" class="col-md-4 control-label">Notes</label> 
          <div class="col-md-8"> 
           <textarea  name="notes"  id="notes"  class="form-control" rows="4"/><?php echo ($this->input->post('notes') ? $this->input->post('notes') : $projects['notes']); ?></textarea> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Priority" class="col-md-4 control-label">Priority</label> 
          <div class="col-md-8"> 
           <?php 
             $enumArr = $this->customlib->getEnumFieldValues('projects','priority'); 
           ?> 
           <select name="priority"  id="priority"  class="form-control"/> 
             <option value="">--Select--</option> 
             <?php 
              for($i=0;$i<count($enumArr);$i++) 
              { 
             ?> 
             <option value="<?=$enumArr[$i]?>" <?php if($projects['priority']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php 
              } 
             ?> 
           </select> 
          </div> 
            </div>
<div class="form-group"> 
                                        <label for="Project Status" class="col-md-4 control-label">Project Status</label> 
          <div class="col-md-8"> 
           <?php 
             $enumArr = $this->customlib->getEnumFieldValues('projects','project_status'); 
           ?> 
           <select name="project_status"  id="project_status"  class="form-control"/> 
             <option value="">--Select--</option> 
             <?php 
              for($i=0;$i<count($enumArr);$i++) 
              { 
             ?> 
             <option value="<?=$enumArr[$i]?>" <?php if($projects['project_status']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php 
              } 
             ?> 
           </select> 
          </div> 
            </div>
<div class="form-group"> 
                                        <label for="File Project" class="col-md-4 control-label">File Project</label> 
          <div class="col-md-8"> 
           <input type="file" name="file_project"  id="file_project" value="<?php echo ($this->input->post('file_project') ? $this->input->post('file_project') : $projects['file_project']); ?>" class="form-control-file"/> 
          </div> 
            </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($projects['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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