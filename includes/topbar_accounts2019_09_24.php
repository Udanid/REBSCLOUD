<script type="text/javascript">
 jQuery(document).ready(function() {


	$( "#collapsenewsearch" ).load( "<?=base_url()?>advancesarch/searchpanel/" );




});
 function loadmycall()
{
	//alert("<?=base_url()?>advancesarch/searchpanel/" )
	$( "#collapsenewsearch" ).load( "<?=base_url()?>advancesarch/searchpanel/" );
}
 </script>

 <? $notifylist=check_notification();
                   $count=0;
				   if($notifylist){
                   foreach($notifylist as $raw){
                   $count=$count+$raw->mycount;
}}?>

<div class="sticky-header header-section ">
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
							<a href="javascript:loadpage('home/myinvoice')" class="dropdown-toggle"  style="color:#0C0"><!-- Cash Invoice--></a><a role="button" data-toggle="collapse" class="dropdown-toggle"  data-parent="#accordion" href="#collapsenewsearch"  onClick="loadmycall()"aria-expanded="true" aria-controls="collapsenewsearch"  name="Advance Search">
						  <i class="fa fa-search-plus icon_red"></i>
						</a>

						</li>
                          <li class="dropdown head-dpdn">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue"><?=$count?></span></a>
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
								  if(!empty($employee_details['profile_pic'])){ ?>
									<span class="prfil-img"><img src="<?php echo base_url();?>uploads/propics/<?php echo $employee_details['profile_pic']; ?>" alt="" style="height: 50px;width: 50px;"> </span>
								  <?php
								  }else{ ?>
									<span class="prfil-img"><img src="<?php echo base_url();?>media/images/a.png" alt=""> </span>
								  <?php
								  }
								  ?>
									<div class="user-name">
										<p><?php echo $employee_details['surname']; ?></p>
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
            <li> <a href="javascript:call_dutyin('')"><i class="fa fa-user"></i> Duty In</a> </li>
            <li> <a href="javascript:call_dutyout('')"><i class="fa fa-user"></i> Duty Out</a> </li>
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
