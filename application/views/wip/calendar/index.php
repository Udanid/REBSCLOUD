<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/tui-time-picker.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/tui-date-picker.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/tui-calendar.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/default.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/icons.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/jquery.timepicker.css">
<script src="<?=base_url()?>media/js/jquery.timepicker.js"></script>
</head>
<script type="text/javascript">
jQuery(document).ready(function() {
	
	$("#userModel_butdata").focus(function() {
		$("#cat_id").chosen({
   	 		allow_single_deselect : true,
	 		search_contains: true,
	 		width:'100%',
	 		no_results_text: "Oops, nothing found!",
			placeholder_text_single: "Select Category"
    	});
		$("#staff").chosen({
   			 allow_single_deselect : true,
			 search_contains: true,
	 		width:'100%',
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Participant"
    	});
		$("#not_time_email").chosen({
   			allow_single_deselect : true,
	 		search_contains: true,
	 		width:'100%',
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Notification Time"
    	});
		$("#not_time_SMS").chosen({
   			allow_single_deselect : true,
	 		search_contains: true,
	 		width:'100%',
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Notification Time"
    	});
		//document.getElementById("emplist").value='';
		 //$( "#stafflist" ).html='';
		$('#assignForm').validate({ ignore: ":hidden:not(select)" });
		/*$('#assignForm').validate({
			ignore: ":hidden:not(.validate)",
			ignore: ":hidden:not(select)",
			rules: {
				emplist: {
					required: true
				}
			},
			messages: {
				emplist: {
					required: "You need to add atleat one participant."
				}
			}
		});*/
	});
});
$( function() {
    //$( "#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	//$( "#start_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	var dateToday = new Date();
	$( "#start_date" ).datepicker({minDate: dateToday,dateFormat: 'yy-mm-dd',onSelect: function(selectedDate) {
		$('#end_date').datepicker('option', 'minDate', selectedDate); //set todate mindate as fromdate
		//date = $(this).datepicker('getDate');
		selectedDate = $.datepicker.formatDate("yy-mm-dd", $(this).datepicker('getDate'));
		//var maxDate = new Date(date.getTime());
		//maxDate.setDate(maxDate.getDate() + 365); //add 31 days to from date
		//$('#end_date').datepicker('option', 'maxDate', maxDate);
		setTimeout(function() { $('#end_date').val(selectedDate); setEndDatetime(); }, 0);
		setStartDatetime();
	}});
	$( "#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	$('#start_time').timepicker({ timeFormat: 'H:i', scrollDefault: '08:00'});
	$('#end_time').timepicker({ timeFormat: 'H:i'});
	$('#start_time').on('changeTime', function() {
		//$('#end_time').val($(this).val());
		var hms = $(this).val()+':00';   // your input string
		var a = hms.split(':'); // split it at the colons

		// minutes are worth 60 seconds. Hours are worth 60 minutes.
		var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
		var addition = 60*60*0.5;
		var newtime = seconds+addition;
		$('#end_time').val(convertSecondstoTime(newtime));
		$('#end_time').timepicker('option', 'minTime', convertSecondstoTime(newtime));
	});
	
	$('.disablekeys').keypress(function(event) {
       event.preventDefault();
       return false;
   });
   
});

function checkAllday(){
	if ($('#allday').is(":checked"))
	{
		$('#start_time').fadeOut(200);
		$('#end_time').fadeOut(200);
		$('#start_time').val('00:00');
	  	$('#end_time').val('23:30');
		setEndDatetime();
		setStartDatetime();
		
	}else{
		$('#start_time').fadeIn(200);
		$('#end_time').fadeIn(200);
		$('#start_time').val('');
	  	$('#end_time').val('');
	}
}

function activateSMS(){
	if ($('#SMS').is(":checked"))
	{
		$("#not_sms").css({
			"opacity":"0",
			"display":"block",
		}).show().animate({opacity:1});
		$("#not_time_SMS").prop('required',true);
	}else{
		$("#not_sms").css({
			"opacity":"1",
			"display":"none",
		}).hide().animate({opacity:0});
		$("#not_time_SMS").prop('required',false);
	}
}

function activateEmail(){
	if ($('#email').is(":checked"))
	{
		$("#not_email").css({
			"opacity":"0",
			"display":"block",
		}).show().animate({opacity:1});
		$("#not_time_email").prop('required',true);
	}else{
		$("#not_email").css({
			"opacity":"1",
			"display":"none",
		}).hide().animate({opacity:0});
		$("#not_time_email").prop('required',false);
	}
}


function no_backspaces(event)
{
	backspace = 8;
	if (event.keyCode == backspace) event.preventDefault();
}

function convertSecondstoTime(given_seconds) { 
           // given_seconds = 3685; 
  
            dateObj = new Date(given_seconds * 1000); 
            hours = dateObj.getUTCHours(); 
            minutes = dateObj.getUTCMinutes(); 
            seconds = dateObj.getSeconds(); 
  
            timeString = hours.toString().padStart(2, '0') 
                + ':' + minutes.toString().padStart(2, '0') ;
                //+ ':' + seconds.toString().padStart(2, '0'); 
  
            return timeString; 
 } 

function formatvar(obj)
  {
	    var dateobj = new Date(obj.value); 
  
// Contents of above date object is converted 
// into a string using toISOString() function. 
		obj.value = dateobj.toISOString(); 
		//alert(B)
  }
  
function setStartDatetime(){
	enableStaff();
	var date = $( "#start_date" ).val();
	var time = $('#start_time').val();
	var timeString = time + ':00';
	//alert(timeString);
	var dateObj = new Date(date + ' ' + timeString);
	var newdate = changeTimezone(dateObj, "Europe/London");
	var datetime = newdate.toISOString();
	$( "#start_date_time").val(datetime);
	setEndDatetime();
}

function setEndDatetime(){
	var date = $( "#end_date" ).val();
	var time = $('#end_time').val();
	var timeString = time + ':00';
	//alert(timeString);
	var dateObj = new Date(date + ' ' + timeString);
	var newdate = changeTimezone(dateObj, "Europe/London");
	var datetime = newdate.toISOString();
	$( "#end_date_time").val(datetime);
}

function changeTimezone(date, ianatz) {

  // suppose the date is 12:00 UTC
  var invdate = new Date(date.toLocaleString('en-US', {
    timeZone: ianatz
  }));

  // then invdate will be 07:00 in Toronto
  // and the diff is 5 hours
  var diff = date.getTime() - invdate.getTime();

  // so 12:00 in Toronto is 17:00 UTC
  return new Date(date.getTime() + diff);

}

  function load_emplist(val)
  {
	    var sartdatetime = $( "#start_date_time").val();
	
	  var res = val.split(",");
	  var currentlist=document.getElementById("emplist").value;
	  var list=currentlist.split(",");
	  if(list.indexOf(res[0])  >= 0 )
	  {
	  
	 }
	 else
	 {
		  $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'wip/calendar/checktime';?>',
            data: {id:res[0], sartdatetime: sartdatetime },
            success: function(data) {
                if (data) {
					  //document.getElementById("checkflagmessage").innerHTML=res[1]+' '+data;
					  //$('#flagchertbtn').click();
					$('#availabilitycheck').val(res[1]);
					$('#availabilitycheckid').val(res[0]);
					$('#complexConfirmavailability').click();
					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					 $( "#stafflist" ).append('<li value="'+res[0]+'">'+res[1]+' <i class="fa fa-times red-400" style="cursor:pointer;" aria-hidden="true"></i></li>');
					  document.getElementById("emplist").value=res[0]+','+currentlist;
	 
				}
            }
        });
		 
	 
	 }
	 
  }
  function cleardata()
  {
	 // alert('sss')
	  document.getElementById("emplist").value='';
	  document.getElementById("stafflist").innerHTML ='';
		 
  }
  	//this function has called in app.js
  	function deleteSchedule(id){
	 	document.deletekeyform.deletekey.value=id;
		$('#complexConfirm').click();
 	}
	
	function enableStaff(){
		var date = $( "#start_date" ).val();
		var time = $('#start_time').val();
		if(date != '' && time != ''){
			$('#staff option:not(:selected)').attr('disabled', false);
		}else{
			$('#staff option:not(:selected)').attr('disabled', true);
		}
		
		$('#staff').trigger("chosen:updated");
	}
	
	function getNotificationtypes(schedule_id){
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'wip/calendar/get_notification_types';?>',
            data: {schedule_id: schedule_id },
            success: function(data) {
                if (data) {
					 var new_data = $.parseJSON(data);
					 $.each(new_data, function (i, item) {
						 var nameArr = item.split(',');
						 $("#"+nameArr[0]).prop("checked", true);
						 if(nameArr[0] == 'SMS'){
						 	activateSMS();
						 }
						 if(nameArr[0] == 'email'){
							activateEmail();
						 }
						 $("#not_time_"+nameArr[0]).val(nameArr[1]);
					});
				}
            }
        });
	}
	
	function getStaff(schedule_id){
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'wip/calendar/get_event_staff';?>',
            data: {schedule_id: schedule_id },
            success: function(data) {
                if (data) {
					 var list = '';
					 var new_data = $.parseJSON(data);
					 $.each(new_data, function (i, item) {
						list += item.staff_id+',';
						if(item.initial!=null){
						 	var initial = item.initial;
						}else{
							var initial = '';	 
						}
						if(item.surname!=null){
						 	var surname = item.surname;
						}else{
							var surname = '';	 
						}
						$( "#stafflist" ).append('<li value="'+item.staff_id+'">'+initial+' '+surname+' <i class="fa fa-times red-400" style="cursor:pointer;" aria-hidden="true"></i></li>');
					});
					document.getElementById("emplist").value=list;
				}
            }
        });
	}
	
	function setFormAction(event_id){
		$("#assignForm").attr("action", "<?=base_url()?>wip/calendar/update_event/"+event_id);
	}
</script>
<!-- //header-ends -->
<!-- main content start-->

<div id="page-wrapper">
 <div class="main-page">
  <div class="table">
   <h3 class="title1">Calendar</h3>
					
    <div class="widget-shadow">
        <ul id="myTabs" class="nav nav-tabs" role="tablist">           
          <li role="presentation" class="active">
              <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false" onclick="showserrchbox()">Calendar</a>
       
          </li>  
           <li role="presentation" >
              <a href="#cat" id="cat-tab" role="tab" data-toggle="tab" aria-controls="cat" aria-expanded="false" >Categories</a>
       
          </li>                    	
        </ul>	
           
    <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
      <? $this->load->view("includes/flashmessage");?>
        <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
        <br>              
          <div class="form-title">
                    <h4>Calendar
            
                    </h4>
          </div>     
     		<div class=" widget-shadow bs-example" data-example-id="contextual-table" id="tasktable"> 
             <div class="row">
               <div class="col-md-8  widget-shadow" data-example-id="basic-forms"> 
            	 <div id="right">
                 <!--Start Menu Dive-->
                      <div id="menu">
                          <span class="dropdown">
                              <button id="dropdownMenu-calendarType" class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                  aria-haspopup="true" aria-expanded="true">
                                  <i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;"></i>
                                  <span id="calendarTypeName">Dropdown</span>&nbsp;
                                  <i class="calendar-icon tui-full-calendar-dropdown-arrow"></i>
                              </button>
                              <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-calendarType">
                                  <li role="presentation">
                                      <a class="dropdown-menu-title" role="menuitem" data-action="toggle-daily">
                                          <i class="calendar-icon ic_view_day"></i>Daily
                                      </a>
                                  </li>
                                  <li role="presentation">
                                      <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weekly">
                                          <i class="calendar-icon ic_view_week"></i>Weekly
                                      </a>
                                  </li>
                                  <li role="presentation">
                                      <a class="dropdown-menu-title" role="menuitem" data-action="toggle-monthly">
                                          <i class="calendar-icon ic_view_month"></i>Month
                                      </a>
                                  </li>
                                  <li role="presentation">
                                      <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks2">
                                          <i class="calendar-icon ic_view_week"></i>2 weeks
                                      </a>
                                  </li>
                                  <li role="presentation">
                                      <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks3">
                                          <i class="calendar-icon ic_view_week"></i>3 weeks
                                      </a>
                                  </li>
                                  <li role="presentation" class="dropdown-divider"></li>
                                  <li role="presentation">
                                      <a role="menuitem" data-action="toggle-workweek">
                                          <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-workweek" checked>
                                          <span class="checkbox-title"></span>Show weekends
                                      </a>
                                  </li>
                                  <li role="presentation">
                                      <a role="menuitem" data-action="toggle-start-day-1">
                                          <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-start-day-1">
                                          <span class="checkbox-title"></span>Start Week on Monday
                                      </a>
                                  </li>
                                  <li role="presentation">
                                      <a role="menuitem" data-action="toggle-narrow-weekend">
                                          <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-narrow-weekend">
                                          <span class="checkbox-title"></span>Narrower than weekdays
                                      </a>
                                  </li>
                              </ul>
                          </span>
                          <span id="menu-navi">
                              <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">Today</button>
                              <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
                                  <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
                              </button>
                              <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
                                  <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
                              </button>
                          </span>
                          <span id="renderRange" class="render-range"></span>
                      </div>
                        <!--End MEnu Div Menu Dive-->
                      <div id="calendar"></div>
                      </div>
                       <!--End right Div Menu Dive-->
                      </div>
					 <div class="col-md-2 widget-shadow" data-example-id="basic-forms"> 
                        <div id="lnb">
                            <div class="lnb-new-schedule">
                                <button   data-target="#userModel_butdata" type="button" class="btn btn-secondary btn-block lnb-new-schedule-btn" data-toggle="modal">New Schedule</button><br>
                            </div>
                            <div id="lnb-calendars" class="lnb-calendars  ">
                            <div>
                            	<div class="lnb-calendars-item">
                                <label>
                                    <input class="tui-full-calendar-checkbox-square" type="checkbox" value="all" checked>
                                    <span></span>
                                    <strong>View all</strong>
                                </label>
                             	</div>
                            </div>
                            <div id="calendarList" class="lnb-calendars-d1">
                            </div>
                        </div><!--End col md 2  Dive-->
                     </div><!--End raw  Dive-->
                     </div><!--End widget  Dive-->
                    
                  </div>
      
         <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
          <script src="<?=base_url()?>media/js/tui-code-snippet.min.js"></script>
          <script src="<?=base_url()?>media/js/tui-dom.js"></script>
          <script src="<?=base_url()?>media/js/tui-time-picker.min.js"></script>
          <script src="<?=base_url()?>media/js/tui-date-picker.min.js"></script>
          <script src="<?=base_url()?>media/js/moment.min.js"></script>
          <script src="<?=base_url()?>media/js/chance.min.js"></script>
          <script src="<?=base_url()?>media/js/dist/tui-calendar.js"></script>
          <!--<script src="<?=base_url()?>media/js/data/calendars.js"></script>-->
          <script src="<?=base_url()?>media/js/data/schedules.js"></script>
          <!-- <script src="./js/theme/dooray.js"></script> -->
          
          <script>
          'use strict';
      
          /* eslint-disable require-jsdoc, no-unused-vars */
            
          var CalendarList = [];
            
          function CalendarInfo() {
              this.id = null;
              this.name = null;
              this.checked = true;
              this.color = null;
              this.bgColor = null;
              this.borderColor = null;
              this.dragBgColor = null;
          }
          
          function addCalendar(calendar) {
              CalendarList.push(calendar);
			  
          }
          
          function findCalendar(id) {
              var found;
          
              CalendarList.forEach(function(calendar) {
                  if (calendar.id === id) {
                      found = calendar;
                  }
              });
          
              return found || CalendarList[0];
          }
          
          function hexToRGBA(hex) {
              var radix = 16;
              var r = parseInt(hex.slice(1, 3), radix),
                  g = parseInt(hex.slice(3, 5), radix),
                  b = parseInt(hex.slice(5, 7), radix),
                  a = parseInt(hex.slice(7, 9), radix) / 255 || 1;
              var rgba = 'rgba(' + r + ', ' + g + ', ' + b + ', ' + a + ')';
          
              return rgba;
          }
          
          (function() {
                var calendar;
                var id = 0;
               
                <? if($category) foreach ($category as $catraw) {?>
                calendar = new CalendarInfo();
                id = <?=$catraw->cat_id?>;
                calendar.id = String(id);
                calendar.name = '<?=$catraw->cat_name?>';
                calendar.color = '#ffffff';
                calendar.bgColor = '<?=$catraw->cat_color?>';
                calendar.dragBgColor = '<?=$catraw->cat_color?>';
                calendar.borderColor = '<?=$catraw->cat_color?>';
                addCalendar(calendar);
                <? } ?>
                
           })();
           
      
          
          function generateSchedule() {
              
              ScheduleList = [];
              var id = 0;
			  //start
			  <? if ($eventslist)foreach ($eventslist as $raw) {?>
				
              var schedule = new ScheduleInfo();
              schedule.id = <?=$raw->event_id?>;
			  id = <?=$raw->cat_id?>;
              schedule.calendarId = String(id);
          
              schedule.title = '<?=$raw->title?>';
              schedule.body = '<?=$raw->details?>';
			  <? if($raw->create_by == $this->session->userdata('userid')){?>
              	schedule.isReadOnly = false;
			  <? }else{?>
			 
			  	schedule.isReadOnly = true;
			  <? }?>
              schedule.isAllDay = <?=$raw->allday?>;
              //generateTime(schedule, renderStart, renderEnd);
              schedule.start = '<?=$raw->start_date?>';
              schedule.end = '<?=$raw->end_date?>';
              schedule.isPrivate = false;
              schedule.category = 'time'; //'milestone', 'task', allday', 'time'
              schedule.location = '<?=$raw->location?>';
              schedule.attendees = <?=$participent[$raw->event_id]?>;
              schedule.recurrenceRule = ''; //'repeated events' : ''
              //schedule.state = 'Free';//'Free' : 'Busy'
              schedule.color = calendar.color;
              schedule.bgColor = calendar.bgColor;
              schedule.dragBgColor = calendar.dragBgColor;
              schedule.borderColor = calendar.borderColor;
          
              if (schedule.category === 'milestone') {
                  schedule.color = schedule.bgColor;
                  schedule.bgColor = 'transparent';
                  schedule.dragBgColor = 'transparent';
                  schedule.borderColor = 'transparent';
              }
          
              schedule.raw.memo = chance.sentence();
              schedule.raw.creator.name = chance.name();
              schedule.raw.creator.avatar = chance.avatar();
              schedule.raw.creator.company = chance.company();
              schedule.raw.creator.email = chance.email();
              schedule.raw.creator.phone = chance.phone();
          
              if (chance.bool({ likelihood: 20 })) {
                  var travelTime = chance.minute();
                  schedule.goingDuration = travelTime;
                  schedule.comingDuration = travelTime;
              }
          
              ScheduleList.push(schedule);
              
			  //added
			  <? }?>
              
          }
          
          
          </script>
          <script src="<?=base_url()?>media/js/app.js"></script>
      </div>  
    </div>
    <!--End Home tap--> 
    <!--Start Cat tab-->
	<div role="tabpanel" class="tab-pane fade " id="cat" aria-labelledby="cat-tab" >
                     
          
          
          <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
          <div class="row">
           <div class="form-title">
                    <h4>Add Category</h4>
          </div>
           <form data-toggle="validator" method="post" action="<?=base_url()?>wip/calendar/add_category" enctype="multipart/form-data">
            <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label" >Name</label>
                              <div class="col-md-2">
                             <input type="text"  class="form-control" placeholder="Category Name" value="" name="cat_name" id="cat_name" required>
                       		 </div>
                              <label class="col-md-2 control-label" >Color</label>
                            <div class="col-md-2">
                             <input type="color"   class="form-control"   value="" name="cat_color" id="cat_color" required>
                       		</div>
                           <div class="col-md-2"><button type="submit" class="btn btn-primary disabled">Add</button></div>
                         </div>
                         <div class="clearfix"> </div><br>
               </div>
           
           
           </form>
           <div class="form-title">
                    <h4>Category List</h4>
          </div> <br>
                    <? if($category){
                                      foreach($category as $catraw){?>
                                       <button class="btn btn-default" style="background:<?=$catraw->cat_color?>; cursor:none; margin-left:20px;" ><?=$catraw->cat_name?></button>
                                   <? }}?>
                                   <br><br><br><br>  
          </div>
         </div>
 
          
     </div>
    <!--Ent Cat tab-->
</div>
</div>

</div>
<!--Start Popup Model-->
<div class="modal fade text-left" id="userModel_butdata" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-header confirmbox_green">
                <h4><span id="event-h4">Add Calendar Event</span>
                	<button type="button" class="close" onClick="cleardata()" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                	</button>
                </h4>
                
            </div>
            <div class="modal-body">

                <div class="login px-4 mx-auto mw-100">
                    <form id="assignForm" method="post" action="<?=base_url()?>wip/calendar/add_event">
                    
                        <div class="row">
                           <div class="col-md-12">
                                  <select class="form-control chosen-select" name="cat_id" id="cat_id"  required>
                                    <option value=""></option>
                                    <? if($category){
                                        foreach($category as $catraw){?>
                                     <option value="<?=$catraw->cat_id?>"  ><?=$catraw->cat_name?></option>
                                    <? }}?>
                                   
                                </select>
                           </div>
                           
                           <div class="clearfix"> </div><br>
                           <div class="col-md-12">
                               <textarea class="form-control" rows="3"  placeholder="Description" value="" name="details" id="details" required></textarea>
                           </div>
                           <div class="clearfix"> </div><br>
                           
                      
                         
                            <div class="col-md-6">
                             <input type="text"  class="form-control" autocomplete="off" placeholder="Event Name" value="" name="title" id="title" required>
                       		 </div>
                             <div class="clearfix"> </div><br>
                            <div class="col-md-6">
                             <input type="text"  class="form-control" autocomplete="off" placeholder="Location" value="" name="location" id="location" required>
                       		</div>
                            <div class="col-md-6">
                             	<input  type="checkbox" name="allday" id="allday" onChange="checkAllday();">&nbsp;All Day
                       		</div>
                        	<div class="clearfix"> </div><br>
                         
                            <div class="col-md-6">
                                 <input type="text"  class="form-control disablekeys" autocomplete="off" onkeydown="no_backspaces(event);" placeholder="Start Date" onChange="setStartDatetime();"  value="" name="start_date" id="start_date" required>
                       		 </div>
                             <div class="col-md-3">
                                 <input type="text"  class="form-control timepicker disablekeys" onkeydown="no_backspaces(event);" autocomplete="off" placeholder="Start Time" onChange="setStartDatetime();"  value="" name="start_time" id="start_time" required>
                                 <input type="hidden" name="start_date_time" id="start_date_time">
                       		 </div>
                             <div class="clearfix"> </div><br>
                            <div class="col-md-6">
                                 <input type="text"  class="form-control disablekeys" placeholder="End Date" onkeydown="no_backspaces(event);" autocomplete="off" value="" name="end_date" onChange="setEndDatetime();" id="end_date" required>
                       		</div>
                            <div class="col-md-3">
                                 <input type="text"  class="form-control timepicker disablekeys" autocomplete="off" onkeydown="no_backspaces(event);" placeholder="End Time"  value="" onChange="setEndDatetime();" name="end_time" id="end_time" required>
                                  <input type="hidden" name="end_date_time" id="end_date_time">
                       		 </div>
                         	<div class="clearfix"> </div><br>
                            <div class="col-md-12">
                            	<label class="control-label" >Notification Mode</label> 
                            </div>
                            <div class="clearfix"> </div><br>
                            <div class="col-md-3">
                            <input  type="checkbox" name="SMS" id="SMS" value="SMS" onChange="activateSMS();">&nbsp;SMS 
                            </div>
                            <div class="col-md-6" id="not_sms" style="display:none;">
                              	<select class="form-control chosen-select" name="not_time_SMS" id="not_time_SMS">
                                	<option value=""></option>
                                    <option value="30">Prior to 30 minutes</option>
                                 	<option value="60">Prior to one hour</option>
                                 	<option value="120" >Prior to two hours</option>
                                 	<option value="1440" >Prior to one day</option>
                               	</select>
                            </div>
                            <div class="clearfix"> </div>
                            <div class="col-md-3">
                            <input  type="checkbox" name="email" id="email" value="email" onChange="activateEmail();">&nbsp;Email 
                            </div>
                          	<div class="col-md-6" id="not_email" style="display:none;">
                              	<select class="form-control chosen-select" name="not_time_email" id="not_time_email">
                                	<option value=""></option>
                                    <option value="30">Prior to 30 minutes</option>
                                 	<option value="60">Prior to one hour</option>
                                 	<option value="120" >Prior to two hours</option>
                                 	<option value="1440" >Prior to one day</option>
                               	</select>
                            </div>
                           		
                            
                         	<div class="clearfix"> </div><br>
                            <label class="col-md-3 control-label" >Add Participants</label>
                         
                            <div class="col-md-6">
                                <select class="form-control chosen-select" name="staff" id="staff" onChange="load_emplist(this.value)">
                                  <option value="" ></option>
                                  <? if($employees){
                                      foreach($employees as $catraw){?>
                                   <option value="<?=$catraw->id?>,<?=$catraw->initial?> <?=$catraw->surname?>"   ><?=$catraw->initial?> <?=$catraw->surname?></option>
                                  <? }}?>
                                 
                              </select>
                              <input type="hidden" value="" id="emplist" name="emplist" class="validate">
                              </div>
                           
                         
                         	<div class="clearfix"> </div><br>
                         	
                         
                         
                          	<div class="col-md-3">
                                 	<h5>Participant List</h5>
                            </div>
                            <div class="col-md-9">
     						 		 <ul class="icon_blue" style="padding-left:30px;">
                                    <div  id="stafflist"></div>
                                 	</ul>
                             </div>
                        	<p class="usererrors" style="color:#F00"></p>
                        	<p class="usersuccess" style="color:#0C0"></p>
                        	<br /><br />
                        	<button type="submit" id="submit-butdata" name="submit-butdata" class="btn btn-success submit mb-4">Add Schedule</button>
                       	</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 <!--Start Popup Model-->

    <div class="col-md-4 modal-grids">
		<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
		<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-sm">
				<div class="modal-content"> 
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4> 
					</div> 
					<div class="modal-body" id="checkflagmessage">
					</div>
				</div>
			</div>
		</div>
	</div>
    
    <div class="col-md-4 modal-grids">
		<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn2"  data-toggle="modal" data-target=".bs-example-modal-sm2">Small modal 2</button>
		<div class="modal fade bs-example-modal-sm2"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel2" id="small-model">
			<div class="modal-dialog modal-sm">
				<div class="modal-content"> 
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="mySmallModalLabel2"><i class="fa fa-info-circle nav_icon"></i> Alert</h4> 
					</div> 
					<div class="modal-body" id="checkflagmessage2">
					</div>
				</div>
			</div>
		</div>
	</div>
                   
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirmavailability" name="complexConfirmavailability"  value="DELETE"></button>
<form name="deletekeyform">  
<input name="deletekey" id="deletekey" value="0" type="hidden">
<input type="hidden" id="availabilitycheck"> 
<input type="hidden" id="availabilitycheckid"> 
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this event?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>wip/calendar/delete_event/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					window.location.reload();
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });


            $("#complexConfirmavailability").confirm({
                title:"Duplicating time confirmation",
                text: "Staff member has another meeting. Are you sure you want to add?" ,
        		headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var staff = $('#availabilitycheck').val();
					var staffid = $('#availabilitycheckid').val();
         			$( "#stafflist" ).append('<li value="'+staffid+'">'+staff+' <i class="fa fa-times red-400" style="cursor:pointer;" aria-hidden="true"></i></li>');
					document.getElementById("emplist").value=staffid+','+document.getElementById("emplist").value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			
/*			$(document).keyup(function(e) {    
				if (e.keyCode == 27) { //escape key
			
					//reload the page if you still need to
					setTimeout(function(){ 
						window.location.reload();
					}, 500); //we use interval to avoid multiple reload
				}
			});*/
			
			//reload page when press escape key. this will reload the calendar to show jquery deleted events back in calender
			$('#userModel_butdata').on('hidden.bs.modal', function () {
			 	location.reload();
			})
			
			$('#small-model').on('hidden.bs.modal', function () {
			 	location.reload();
			})
			
			$('#stafflist').on('click', 'li', function(e) {
				
				var toremove = String($(this).val());
				var emplist = document.getElementById("emplist").value;
				
				var remains = remove(emplist,toremove)
				
				document.getElementById("emplist").value = remains;
				
				//now remove item from list
				$(this).remove();
			});
			
			function remove(array,to_remove)
			{
			  var elements=array.split(",");
			  var remove_index=elements.indexOf(to_remove);
			  elements.splice(remove_index,1);
			  var result=elements.join(",");
			  return result;
			}
			
			$('#staff option:not(:selected)').attr('disabled', true);
			
            </script> 

        <div class="row calender widget-shadow"  style="display:none">
            <h4 class="title">Calender</h4>
            <div class="cal1">
                
            </div>
        </div>

        <div class="clearfix"> </div>
    </div>
</div></html>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>