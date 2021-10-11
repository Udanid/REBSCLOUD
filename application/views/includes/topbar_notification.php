<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script src="<?=base_url()?>media/js/additional-methods.min.js"></script>
<script type="text/javascript">
 jQuery(document).ready(function() {
 	 
	 
	$( "#collapsenewsearch" ).load( "<?=base_url()?>advancesarch/searchpanel/" );
	
});
 function loadmycall()
{
	//alert("<?=base_url()?>advancesarch/searchpanel/" )
	$( "#collapsenewsearch" ).load( "<?=base_url()?>advancesarch/searchpanel/" );
}

// view sub task
function accept_prograss_notification(subtask_id,noti_id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/subtask/accept_prograss_notification/"+subtask_id+"/"+noti_id);
}

function close_viewsubtask(){
	window.location.replace("<?=base_url()?>wip/task/showall");
  	$('#popupform').delay(1).fadeOut(800);

}
// end view sub task
function clearMessages(user_id){
	window.location.replace("<?=base_url()?>wip/task/clear_messages/"+user_id);
}
 </script>


 <? $notifylist=check_notification();
 $notifylist_user=check_notification_user();
   $count=0;
   if($notifylist){
   	foreach($notifylist as $raw){
   		$count=$count+$raw->mycount;
	}}
	if($notifylist_user){
   	foreach($notifylist_user as $raw){
   		$count=$count+$raw->mycount;
	}}
	$letternotifi=0;//get_letternotification();
$count=$count+$letternotifi;
	$calender = get_calandar_notification($this->session->userdata('userid'));
	$calcount=0;
   if($calender){
   	foreach($calender as $raw){
   		$calcount++;;
	}}
	?>

<div class="sticky-header header-section">
	<div class="header-left">
		<!--toggle button start-->
		<button id="showLeftPush"><i class="fa fa-bars"></i></button>
		<!--toggle button end-->
		<!--logo -->
		<div class="logo">
			<a href="<?=base_url()?>home">
				<img src="<?=base_url()?>media/images/logo2.png" />
			</a>
		</div>
		<!--//logo-->
		<!--search-box-->
		<div class="search-box">
			<form class="input">
         
                
			 <button type="submit"  class="search-box_submit">SEARCH</button>
              
			</form>
          
		</div><!--//end-search-box-->
		<div class="clearfix"> </div>
	</div>
<div class="header-right">

    <div class="profile_details_left"><!--notifications of menu start -->
	 <ul class="nofitications-dropdown">

<li class="dropdown head-dpdn">

	<?php
	  date_default_timezone_set('Asia/Colombo');
	  $ci =&get_instance();
	  $ci->load->model('user/user_model'); 
	  $ci->load->model('wip/Tasknotification_model');
	  $userid = $this->session->userdata('userid');

	  $get_all_notification_count = $ci->Tasknotification_model->get_all_notification_count($userid)+$calcount;

	  $get_task_count = $ci->Tasknotification_model->get_task_notification_count($userid);

	  $get_subtask_count = $ci->Tasknotification_model->get_sub_task_notification_count($userid);

	  $get_complted_task_notification_count=$ci->Tasknotification_model->get_complted_task_notification_count($userid);

	  $get_task_notification = $ci->Tasknotification_model->get_task_notification($userid);

	  $get_subtask_notification = $ci->Tasknotification_model->get_sub_task_notification($userid);

	  $get_task_completed_notification = $ci->Tasknotification_model->get_task_completed_notification($userid);

	  $get_task_extend_notification = $ci->Tasknotification_model->get_task_extend_notification($userid);

	  $get_main_task_extend_notification = $ci->Tasknotification_model->get_main_task_extend_notification($userid);

	  $get_sub_task_completed_notification = $ci->Tasknotification_model->get_sub_task_completed_notification($userid);

	  $get_sub_task_extend_accept_notification = $ci->Tasknotification_model->get_sub_task_extend_accept_notification($userid);

	  $get_main_task_extend_accept_notification = $ci->Tasknotification_model->get_main_task_extend_accept_notification($userid);

	  $get_sub_task_prograss_update_notification = $ci->Tasknotification_model->get_sub_task_prograss_update_notification($userid);

	  $accepted_task_notification_view_task_createor = $ci->Tasknotification_model->accepted_task_notification_view_task_createor($userid);

	  $get_sub_task_accepted_notification__task_assigner = $ci->Tasknotification_model->get_sub_task_accepted_notification__task_assigner($userid);

	  $get_sub_task_extention_reject_notification = $ci->Tasknotification_model->get_sub_task_extention_reject_notification($userid);

	  $get_main_task_extention_reject_notification = $ci->Tasknotification_model->get_main_task_extention_reject_notification($userid);


	  	$total_count=0;
	  	$task_conut=0;
	  	$task_complted_conut=0;
	  	$count1=0;
	   								
	 ?>

	<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks" aria-hidden="true"></i></i><span class="badge blue"><?=$get_all_notification_count?></span></a>
    <ul class="dropdown-menu drp-mnu">

    <!--pending task confirm notification -->
    
    <? if($get_task_notification || $get_subtask_notification){ ?>
        <li>
			<div class="notification_header">
				<h3>You have Tasks to Accept</h3>
			</div>
		</li>
	<? } ?>
    
    <? if($get_task_notification){
    	foreach($get_task_notification as $raw){?>
		
		<li>
		  <a href="<?=base_url()?>wip/task/task_accept_view/<?=$raw->task_id?>">									
		   <div class="notification_desc">
			<p><?=$raw->prj_name?> - <?=$raw->task_name?></p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a></li>
         
        <? }}?>

        <? if($get_subtask_notification){
    	foreach($get_subtask_notification as $raw){?>
		
		<li>
		  <a href="<?=base_url()?>wip/subtask/sub_task_accept/<?=$raw->subt_id?>">									
		   <div class="notification_desc">
			<p><?=$raw->task_name?> - <?=$raw->subt_name?></p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a></li>
         
        <? }}?>

        <!-- end pending task comform -->

        <!-- complete task or sub task comform notification -->

        <? if($get_task_completed_notification || $get_sub_task_completed_notification){ ?>
            <li>
				<div class="notification_header">
					<h3>Completed Tasks</h3>
				</div>									
											
			</li>

		<? }?>

		<? if($get_task_completed_notification){
    		foreach($get_task_completed_notification as $raw){?>

		<li>
		  <a href="<?=base_url()?>wip/task/completed_task_notification_accept/<?=$raw->id?>">									
		   <div class="notification_desc">
			<p><?=$raw->task_name?></p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a></li>
         
        <? }}?>

        <? if($get_sub_task_completed_notification){
    		foreach($get_sub_task_completed_notification as $raw){?>

		<li>
		  <a href="<?=base_url()?>wip/subtask/completed_subtask_notification_accept/<?=$raw->id?>">									
		   <div class="notification_desc">
			<p><?=$raw->task_name?> - <?=$raw->subt_name?></p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a></li>
         
        <? }}?>

        <!-- end complete task notification -->

        <!-- Extend sub task notification -->

        <? if($get_task_extend_notification){ ?>

         <li>
			<div class="notification_header">
				<h3>You have Task Extension to Confirm</h3>
			</div>									
										
		</li>

		<? }?>

		<? if($get_task_extend_notification){
    		foreach($get_task_extend_notification as $raw){?>

		<li>
		  <a href="<?=base_url()?>wip/subtask/extend_task_accept_view/<?=$raw->subt_id?>">									
		   <div class="notification_desc">
			<p><?=$raw->task_name?> - <?=$raw->subt_name?></p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a>
		</li>
         
        <? }}?>

        <!-- end sub task etend notification -->

        <!-- Extend main task notification -->


        <? if($get_main_task_extend_notification){ ?>

         <li>
			<div class="notification_header">
				<h3>You have Task Extension to Confirm</h3>
			</div>									
										
		</li>

		<? }?>

        <? if($get_main_task_extend_notification){
    		foreach($get_main_task_extend_notification as $raw){?>

		<li>
		  <a href="<?=base_url()?>wip/task/extend_main_task_accept_view/<?=$raw->task_id?>">									
		   <div class="notification_desc">
			<p><?=$raw->prj_name?> - <?=$raw->task_name?></p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a>
		</li>
         
        <? }}?>

        <!-- end main task etend notification -->


        
        <!-- sub task prograss update notification -->

        <? if($get_sub_task_prograss_update_notification){ ?>

         <li>
			<div class="notification_header">
				<h3>New Task Progress</h3>
			</div>									
										
		</li>

		<? }?>

		<? 
		$messages = false;
		if($get_sub_task_prograss_update_notification){
			$messages = true;
    		foreach($get_sub_task_prograss_update_notification as $raw){?>

		<li>
		  
		  <a  href="javascript:accept_prograss_notification('<?=$raw->subt_id?>/<?=$raw->id?>')" title="View">								
		   <div class="notification_desc">
			<p><?=$raw->task_name?> - <?=$raw->subt_name?></p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a>
		</li>
         
        <? }}?>
        
         <? if($calcount){ ?>

         <li>
			<div class="notification_header">
				<h3>New Event Schedules</h3>
			</div>									
										
		</li>

		<? }?>
         <? 
		$calender = get_calandar_notification($this->session->userdata('userid'));
		//print_r($calender);
		if($calender){
			//$messages = true;
    		foreach($calender as $raw){?>

		<li>
		  
		  <a href="<?=base_url()?><?=$raw->link?>">									
		  								
		   <div class="notification_desc">
			<p> <?=$raw->title ?> <?=$raw->title ?> <?=$raw->start_date ?>  </p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a>
		</li>
         
        <? }}?>
       

        <!-- end sub task prograss update notification --> 

        <!-- Common notification -->

        <? if($get_main_task_extend_accept_notification || $get_sub_task_extend_accept_notification || $accepted_task_notification_view_task_createor || $get_sub_task_accepted_notification__task_assigner || $get_sub_task_extention_reject_notification || $get_main_task_extention_reject_notification){ ?>

         <li>
			<div class="notification_header">
				<h3>You have new Messages</h3>
			</div>									
										
		</li>

		<? }?>

		<!-- main task extend request accepted notification -->

        <? 
		if($get_main_task_extend_accept_notification){
			$messages = true;
    		foreach($get_main_task_extend_accept_notification as $raw){?>

		<li>
		  <a href="<?=base_url()?>wip/subtask/sub_task_accept_notification_comform/<?=$raw->id?>">									
		   <div class="notification_desc">
			<p><?=$raw->task_name?> - <?=$raw->subt_name?> - Task Extension Requert Accepted</p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a>
		</li>
         
        <? }}?>

        <!-- end section -->

		<!-- accepted task comform notification for task creator -->

		<? if($accepted_task_notification_view_task_createor){
			$messages = true;
    		foreach($accepted_task_notification_view_task_createor as $raw){?>

		<li>
		  <a href="<?=base_url()?>wip/task/task_accept_notification_comform_by_task_creator/<?=$raw->id?>">									
		   <div class="notification_desc">
			<p><?=$raw->prj_name?> - <?=$raw->task_name?> - Task Accepted</p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a>
		</li>
         
        <? }}?> 

        <!-- end section --> 

        <!-- accepted sub task comform notification for task assigner -->

		<? if($get_sub_task_accepted_notification__task_assigner){
			$messages = true;
    		foreach($get_sub_task_accepted_notification__task_assigner as $raw){?>

		<li>
		  <a href="<?=base_url()?>wip/subtask/sub_task_accept_notification_comform_by_task_assigner/<?=$raw->id?>">									
		   <div class="notification_desc">
			<p><?=$raw->task_name?> - <?=$raw->subt_name?> - Task Accepted</p>
			
			</div>

		  <div class="clearfix"></div>	
		 </a>
		</li>
         
        <? }}?> 

        <!-- end section -->  

        
        <!-- sub task extend accept notification for sub task assigner -->                           
        <? if($get_sub_task_extend_accept_notification){
			$messages = true;
    		foreach($get_sub_task_extend_accept_notification as $raw){?>

		<li>
		  <a href="<?=base_url()?>wip/subtask/sub_task_accept_notification_comform/<?=$raw->id?>">									
		   <div class="notification_desc">
			<p><?=$raw->task_name?> - <?=$raw->subt_name?> - Task Extension Requert Accepted</p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a>
		</li>
         
        <? }}?>

        <!-- end section -->

        <!-- sub task reject notification for sub task assigner -->

        <? if($get_sub_task_extention_reject_notification){
			$messages = true;
    		foreach($get_sub_task_extention_reject_notification as $raw){?>

		<li>
		  <a href="<?=base_url()?>wip/subtask/sub_task_reject_notification_comform/<?=$raw->id?>">									
		   <div class="notification_desc">
			<p><?=$raw->task_name?> - <?=$raw->subt_name?> - Task Extension Request Rejected</p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a>
		</li>
         
        <? }}?>

        <!-- end section -->

        <!-- main task reject notification for sub task assigner -->

        <? if($get_main_task_extention_reject_notification){
			$messages = true;
    		foreach($get_main_task_extention_reject_notification as $raw){?>

		<li>
		  <a href="<?=base_url()?>wip/subtask/sub_task_reject_notification_comform/<?=$raw->id?>">									
		   <div class="notification_desc">
			<p><?=$raw->task_name?> - <?=$raw->subt_name?> - Task Extension Request Rejected</p>
			
			</div>
		  <div class="clearfix"></div>	
		 </a>
		</li>
         
        <? }}?>
		<? if($messages == true){ echo '<li style="background:#ccc;"><a href="#" class="btn btn-link" onClick="clearMessages('.$userid.');">Clear all Messages</a></li>';}?>
        <!-- end section -->
		
	</ul>
	
</li>						

                    	<li class="dropdown head-dpdn">
							<a href="javascript:loadpage('home/myinvoice')" class="dropdown-toggle"  style="color:#0C0"><!-- Cash Invoice--></a><a role="button" data-toggle="collapse" class="dropdown-toggle"  data-parent="#accordion" href="#collapsenewsearch"  onClick="loadmycall()"aria-expanded="true" aria-controls="collapsenewsearch"  name="Advance Search">
						  <i class="fa fa-search-plus icon_red"></i>
						</a>
							
						</li>
                          <li class="dropdown head-dpdn">
							<a href="#" class="dropdown-toggle"  data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue"><?=$count?></span></a>
                            <ul class="dropdown-menu drp-mnu">
                            <li>
									<div class="notification_header">
										<h3>You have <?=$count?> pending Records  to confirm</h3>
									</div>
								</li>
                            <? if($notifylist){foreach($notifylist as $raw){?>
								
								<li><a href="<?=base_url().$raw->module?>">
									
								   <div class="notification_desc">
									<p><?=$raw->mycount?> Pending <?=$raw->notification?> </p>
									
									</div>
								  <div class="clearfix"></div>	
								 </a></li>
                                 <? }}?>
                                   <? if($notifylist_user){foreach($notifylist_user as $raw){?>
								
								<li><a href="<?=base_url().$raw->module?>">
									
								   <div class="notification_desc">
									<p><?=$raw->mycount?> Pending <?=$raw->notification?> </p>
									
									</div>
								  <div class="clearfix"></div>	
								 </a></li>
                                 <? }}?>
                                 <? if($letternotifi){?>
                               			 <li>
                                          <a href="<?=base_url()?>re/customerletter/showall">
                                            <div class="notification_desc">
                                              <p><?php echo $letternotifi; ?> Pending  Letters to Print</p>
                                            </div>
                                            <div class="clearfix"></div>
                                          </a>
                                        </li>
                                <? }?>
								
							</ul>
							
						</li>	
                       
                        <li class="dropdown head-dpdn">
						  <?php
						  date_default_timezone_set('Asia/Colombo');
						  $ci =&get_instance();
						  $ci->load->model('user/user_model'); 
						  $ci->load->model('hr/employee_model');

						  $userid = $this->session->userdata('userid');
							//$today = date('Y-m-d');

						  $validate_user = $ci->user_model->validate_current_password($userid);
						  $current_url = current_url();
						  if($validate_user['EXPDATE'] <= date('Y-m-d') && $validate_user['EXPDATE'] != 0000-00-00){
							if($current_url != base_url('login/password_reset')){
								$this->session->set_flashdata('error',"Your password has expired, please reset the pasword");
								redirect('login/password_reset');
							}
						  }
						  if($validate_user['active_flag'] == 0){
							$this->session->set_flashdata('error',"You've entered the wrong password too many times, your account has been disabled. Please contact the system administrator");
								redirect('login');
						  }

						  $employee_details = $ci->user_model->get_employee_details($userid);
						  if($employee_details['fuel_allowance_status'] == "Y"){
							$last_meter_reading = $ci->user_model->get_user_meter_reading_last_record($userid);
							if($last_meter_reading['date'] != date('Y-m-d')){
							  $this->session->set_flashdata('error',"You need to submit meter readings to proceed further");
							  redirect(base_url()."user/meter_reading");
							}
						  }

						  $check_immediate_manager = $ci->user_model->check_immediate_manager($userid);
						  if(count($check_immediate_manager)>0){ 
							$get_team_employees_leave_records_for_notificaton = $ci->user_model->get_team_employees_leave_records_for_notificaton($userid);
							if(count($get_team_employees_leave_records_for_notificaton) > 0){
								$pending_leave_count = count($get_team_employees_leave_records_for_notificaton);
							}else{
								$pending_leave_count = 0;
							}
						  }else{
							  $pending_leave_count = 0;
						  }

						  if(check_submenu('Additional Fuel Requests')){
							  $all_pending_employee_additional_fuel_allowance_list = $ci->employee_model->get_all_pending_employee_additional_fuel_allowance_list();
							  $pending_emp_additional_fuel_allowance_list_count = count($all_pending_employee_additional_fuel_allowance_list);
						  }else{
							  $pending_emp_additional_fuel_allowance_list_count = 0;
						  }
						  ?>
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-user"></i><span class="badge blue"><?php echo $pending_emp_additional_fuel_allowance_list_count+$pending_leave_count; ?></span> </a>
						  <ul class="dropdown-menu drp-mnu">
							<li>
							  <div class="notification_header">
								<a href="<?php echo base_url();?>leave/apply">Apply Leave</a>
							  </div>
							</li>
							<li>
							  <div class="notification_header">
								<a href="<?php echo base_url();?>leave/leave_list">Leave List</a>
							  </div>
							</li>

							<?php
							if(count($check_immediate_manager)>0){ 
							?>
								<li>
								  <div class="notification_header">
									<a href="<?php echo base_url();?>leave/approve_leave">Approve Leave - <span style="background-color: red;border-radius: 50%; color: white;">&nbsp;&nbsp;<?php echo $pending_leave_count; ?>&nbsp;&nbsp;</span></a>
								  </div>
								</li>
								<?php
							 } ?>

							 <?php
							 if(check_submenu('Additional Fuel Requests')){ ?>  
								<li>
								  <div class="notification_header">
									<a href="<?php echo base_url();?>hr/employee/additional_fuel_request">Additional Fuel Requests - <span style="background-color: red;border-radius: 50%; color: white;">&nbsp;&nbsp;<?php echo $pending_emp_additional_fuel_allowance_list_count; ?>&nbsp;&nbsp;</span></a>
								  </div>
								</li>
							 <?php 									
							 } ?>

						  </ul>	
						</li>
                 
						
					</ul>
					<div class="clearfix"> </div>
				</div>
				<!--notification menu end -->
				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
								  <?php
								  $employee_details = $ci->user_model->get_employee_details($userid);
								  if($employee_details['profile_pic'] != ""){ ?>
									<span class="prfil-img"><img src="<?php echo base_url();?>uploads/propics/<?php echo $employee_details['profile_pic']; ?>" alt="" style="height: 50px;width: 50px;"> </span> 
								  <?php  
								  }else{ ?>
									<span class="prfil-img"><img src="<?php echo base_url();?>media/images/a.png" alt=""> </span> 
								  <?php  
								  }
								  ?>
									<div class="user-name"><!--Ticket No-2502 | Added By Uvini-->
										<p><?=$this->session->userdata('display_name')?></p>
										<span><?=$this->session->userdata('username')?></span>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>
							</a>
							<ul class="dropdown-menu drp-mnu">
								   <li> <a href="<?php echo base_url();?>login/password_reset"><i class="fa fa-key"></i> Password Reset </a> </li>
		    <!--<li> <a href="#"><i class="fa fa-user"></i> Duty In</a> </li>-->
            <li> <a href="<?php echo base_url();?>leave/duty_out"><i class="fa fa-user"></i> Duty Out</a> </li>
            <li> <a href="<?php echo base_url();?>leave/go_out"><i class="fa fa-exchange"></i> Go Out</a> </li>
            <li> <a href="<?php echo base_url();?>leave/go_in"><i class="fa fa-exchange"></i> Go In</a> </li>
            <li> <a href="<?php echo base_url();?>login/logout"><i class="fa fa-sign-out"></i> Logout</a> </li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
        <div id="serchload"></div>
<!-- //header-ends -->
 <div class="adv_searchpanel" >
      
        <div id="collapsenewsearch" class="panel-collapse collapse  " role="tabpanel" aria-labelledby="headingOne">
					  <div class=" row-one panel-body">
						
					  </div>
				
                             
                             
                   </div></div>