<a  href="<?php echo site_url('admin/users_pay_details/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Users_pay_details'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/users_pay_details/save/'.$users_pay_details['id'],array("class"=>"form-horizontal")); ?>
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($users_pay_details['super_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="Users" class="col-md-4 control-label">Users</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Users_model'); 
             $dataArr = $this->CI->Users_model->get_all_users(); 
          ?> 
          <select name="users_id"  id="users_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($users_pay_details['users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($users_pay_details['business_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['business_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
          <label for="Payroll ID" class="col-md-4 control-label">Payroll ID</label> 
          <div class="col-md-8"> 
           <input type="text" name="Payroll_ID" value="<?php echo ($this->input->post('Payroll_ID') ? $this->input->post('Payroll_ID') : $users_pay_details['Payroll_ID']); ?>" class="form-control" id="Payroll_ID" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Access Level" class="col-md-4 control-label">Access Level</label> 
          <div class="col-md-8"> 
           <input type="text" name="access_level" value="<?php echo ($this->input->post('access_level') ? $this->input->post('access_level') : $users_pay_details['access_level']); ?>" class="form-control" id="access_level" /> 
          </div> 
           </div>
<div class="form-group"> 
                                       <label for="Employee Start Date" class="col-md-4 control-label">Employee Start Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="employee_start_date"  id="employee_start_date"  value="<?php echo ($this->input->post('employee_start_date') ? $this->input->post('employee_start_date') : $users_pay_details['employee_start_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
          <label for="Stress Profile" class="col-md-4 control-label">Stress Profile</label> 
          <div class="col-md-8"> 
           <input type="text" name="stress_profile" value="<?php echo ($this->input->post('stress_profile') ? $this->input->post('stress_profile') : $users_pay_details['stress_profile']); ?>" class="form-control" id="stress_profile" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Employeement Type" class="col-md-4 control-label">Employeement Type</label> 
          <div class="col-md-8"> 
           <input type="text" name="employeement_type" value="<?php echo ($this->input->post('employeement_type') ? $this->input->post('employeement_type') : $users_pay_details['employeement_type']); ?>" class="form-control" id="employeement_type" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Pay Rate Type" class="col-md-4 control-label">Pay Rate Type</label> 
          <div class="col-md-8"> 
           <input type="text" name="pay_rate_type" value="<?php echo ($this->input->post('pay_rate_type') ? $this->input->post('pay_rate_type') : $users_pay_details['pay_rate_type']); ?>" class="form-control" id="pay_rate_type" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Salary Type" class="col-md-4 control-label">Salary Type</label> 
          <div class="col-md-8"> 
           <input type="text" name="salary_type" value="<?php echo ($this->input->post('salary_type') ? $this->input->post('salary_type') : $users_pay_details['salary_type']); ?>" class="form-control" id="salary_type" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Salary Amount" class="col-md-4 control-label">Salary Amount</label> 
          <div class="col-md-8"> 
           <input type="text" name="salary_amount" value="<?php echo ($this->input->post('salary_amount') ? $this->input->post('salary_amount') : $users_pay_details['salary_amount']); ?>" class="form-control" id="salary_amount" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Weekday Rate" class="col-md-4 control-label">Weekday Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="weekday_rate" value="<?php echo ($this->input->post('weekday_rate') ? $this->input->post('weekday_rate') : $users_pay_details['weekday_rate']); ?>" class="form-control" id="weekday_rate" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Public Holiday Rate" class="col-md-4 control-label">Public Holiday Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="public_holiday_rate" value="<?php echo ($this->input->post('public_holiday_rate') ? $this->input->post('public_holiday_rate') : $users_pay_details['public_holiday_rate']); ?>" class="form-control" id="public_holiday_rate" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Saterday Rate" class="col-md-4 control-label">Saterday Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="saterday_rate" value="<?php echo ($this->input->post('saterday_rate') ? $this->input->post('saterday_rate') : $users_pay_details['saterday_rate']); ?>" class="form-control" id="saterday_rate" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Sunday Rate" class="col-md-4 control-label">Sunday Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="sunday_rate" value="<?php echo ($this->input->post('sunday_rate') ? $this->input->post('sunday_rate') : $users_pay_details['sunday_rate']); ?>" class="form-control" id="sunday_rate" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Monday Rate" class="col-md-4 control-label">Monday Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="monday_rate" value="<?php echo ($this->input->post('monday_rate') ? $this->input->post('monday_rate') : $users_pay_details['monday_rate']); ?>" class="form-control" id="monday_rate" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Tuesday Rate" class="col-md-4 control-label">Tuesday Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="tuesday_rate" value="<?php echo ($this->input->post('tuesday_rate') ? $this->input->post('tuesday_rate') : $users_pay_details['tuesday_rate']); ?>" class="form-control" id="tuesday_rate" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Wednesday Rate" class="col-md-4 control-label">Wednesday Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="wednesday_rate" value="<?php echo ($this->input->post('wednesday_rate') ? $this->input->post('wednesday_rate') : $users_pay_details['wednesday_rate']); ?>" class="form-control" id="wednesday_rate" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Thrusday Rate" class="col-md-4 control-label">Thrusday Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="thrusday_rate" value="<?php echo ($this->input->post('thrusday_rate') ? $this->input->post('thrusday_rate') : $users_pay_details['thrusday_rate']); ?>" class="form-control" id="thrusday_rate" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Friday Rate" class="col-md-4 control-label">Friday Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="friday_rate" value="<?php echo ($this->input->post('friday_rate') ? $this->input->post('friday_rate') : $users_pay_details['friday_rate']); ?>" class="form-control" id="friday_rate" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Hourly Rate" class="col-md-4 control-label">Hourly Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="hourly_rate" value="<?php echo ($this->input->post('hourly_rate') ? $this->input->post('hourly_rate') : $users_pay_details['hourly_rate']); ?>" class="form-control" id="hourly_rate" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Overtime Rate" class="col-md-4 control-label">Overtime Rate</label> 
          <div class="col-md-8"> 
           <input type="text" name="overtime_rate" value="<?php echo ($this->input->post('overtime_rate') ? $this->input->post('overtime_rate') : $users_pay_details['overtime_rate']); ?>" class="form-control" id="overtime_rate" /> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($users_pay_details['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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