<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){  
      $('#create_excel').click(function(){         
        //var date =  document.getElementById('rptdate').value;
          $(".table2excel").table2excel({
          exclude: ".noExl",
          name: "Tak Report ",
          filename: "task_list_reprot_.xls",
          fileext: ".xls",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
      });
             
        });  
   });

</script>

</script>

<script type="text/javascript">

$( function() {
	var exclude = []; //define an array to skip days
	<? 
	if(get_holidays()){
		foreach(get_holidays() as $holiday){
	?>
		exclude.push("<?=$holiday->holiday_date?>"); //add holidays to array
	<? 
		}
	}
	?>
    $( "#task_start_date").datepicker({
		beforeShowDay: function(date) {
		  var day = jQuery.datepicker.formatDate('yy-mm-dd', date);
		  return [!~$.inArray(day, exclude)]; //block holidays
		},dateFormat: 'yy-mm-dd',minDate: 0
		
	});
});

  // check hodl

  function checkHold(rowno){
    if ($("#chkHoldId"+rowno).is(":checked"))
    {

	   $("#hold_date"+rowno).css({
		  "opacity":"0",
		  "display":"block",
	  }).show().animate({opacity:1});
    //$("#tblSubtask .clsholddate"+rowno).css('display','');
	  
	  var exclude = []; //define an array to skip days
	  <? 
	  if(get_holidays()){
		  foreach(get_holidays() as $holiday){
	  ?>
		  exclude.push("<?=$holiday->holiday_date?>"); //add holidays to array
	  <? 
		  }
	  }
	  ?>
	  
	  var today = new Date();
	  var tomorrow = new Date();
	  tomorrow.setDate(today.getDate() + 1);

      //Ticket 1036 Bilani 2020-01-01
      var subt_duration=parseInt($('#subtaskdurarion'+rowno).val());
      var task_enddate=$("#showenddate").val();

      var someDate = new Date(task_enddate);
      someDate.setDate(someDate.getDate() - subt_duration); //number  of days to add
      var maxdateFormated = someDate.toISOString().substr(0,10);
     //Ticket 1036 Bilani 2020-01-01 -end

	     $("#clsholddate"+rowno).datepicker("destroy");
      $("#clsholddate"+rowno).datepicker({
			 beforeShowDay: function(date) {
				var day = jQuery.datepicker.formatDate('yy-mm-dd', date);
				return [!~$.inArray(day, exclude)]; //block holidays
			  },dateFormat: 'yy-mm-dd',minDate: tomorrow,maxDate: maxdateFormated
		});
    }
    else{
	  $("#hold_date"+rowno).fadeOut("slow");
      $("#tblSubtask .clsholddate"+rowno).val('');
      //$("#tblSubtask .clsholddate"+rowno).css('display','none');
    }
  }

  // end check hodl


  // add multipal sub task
 
$(document).ready(function(){
  
	
  var rowCount=0;
  var apendNoofrows=0;
	var exclude = []; //define an array to skip days
	  <? 
	  if(get_holidays()){
		  foreach(get_holidays() as $holiday){
	  ?>
		  exclude.push("<?=$holiday->holiday_date?>"); //add holidays to array
	  <? 
		  }
	  }
	  ?>
  $( "#start_date").datepicker({
		beforeShowDay: function(date) {
		  var day = jQuery.datepicker.formatDate('yy-mm-dd', date);
		  return [!~$.inArray(day, exclude)]; //block holidays
		},dateFormat: 'yy-mm-dd'  
	});
 
  $("#addSubtask").click(function(){
    rowCount++;
    apendNoofrows++;
  
  setTimeout(function(){ 
  
    $("#sub_task_assign"+rowCount).chosen({
        allow_single_deselect : true,
        search_contains: true,
		width: '100%',
        no_results_text: "Oops, nothing found!",
        placeholder_text_single: "Select Assignee"
      });

  }, 800);

      $("#tblSubtask").append('<div class="col-md-12 bg-grey-100" style="border:1px solid #ccc; padding:10px 0px 10px 10px; margin-bottom:5px;" id="divrow'+rowCount+'">\
              <div class="col-md-4 form_padding">\
                  <div class="form-group has-feedback">\
                    <input type="text" class="form-control" name="subtask['+rowCount+'][name]" placeholder="Sub Task Name" data-error=""  required>\
                    </div>\
              </div>\
              <div class="col-md-3 form_padding">\
                  <div class="form-group has-feedback">\
                    <input type="number" min="0" class="form-control" name="subtask['+rowCount+'][durarion]"   placeholder="Duration (days)" data-error="" required onchange="display_checkBox('+rowCount+');checksubtaskdurarion('+rowCount+')" onkeyup="display_checkBox('+rowCount+')" id="subtaskdurarion'+rowCount+'">\
                  </div>\
              </div>\
              <div class="col-md-5 form_padding">\
                <div class="form-group has-feedback">\
                  <textarea class="form-control" name="subtask['+rowCount+'][sub_description]" placeholder="Description" rows="2" data-error="" required id="sub_description'+rowCount+'"></textarea>\
                </div>\
              </div>\
              <div class="col-md-3 form_padding">\
                <div class="form-group has-feedback">\
                  <select required class="form-control chosen-select" placeholder="Qick Search.." name="subtask['+rowCount+'][assign]" required id="sub_task_assign'+rowCount+'">\
                    <option value=""></option>\
                    <? foreach ($allemployees as $raw){?>\
                      <option value="<?=$raw->id?>" > <?=$raw->initial.' '.$raw->surname?></option>\
                    <? }?>\
                  </select>\
                </div>\
              </div>\
              <div class="col-md-1 form_padding" style="display: none;" id="div_checkbox'+rowCount+'">\
                <div class="form-group has-feedback">\
                  <label for="chkHoldId'+rowCount+'">Hold\
                  <input type="checkbox" class="form-control check_hold" name="subtask['+rowCount+'][hold]" data-error="" id="chkHoldId'+rowCount+'" onclick="checkHold('+rowCount+')" value="Hold"></label>\
                </div>\
              </div>\
              <div class="col-md-2 form_padding" id="hold_date'+rowCount+'" style="display:none">\
                <div class="form-group has-feedback">\
                  <input type="text" class="form-control clsholddate'+rowCount+'" autocomplete="off" name="subtask['+rowCount+'][holdenddate]" placeholder="Resume Date" data-error="" required id="clsholddate'+rowCount+'" autocomplete="off">\
                </div>\
              </div>\
            <div class="col-md-1 form_padding">\
                <div class="form-group has-feedback">\
                  <a title="Delete" class="btn btn-danger" onclick="remove_field('+rowCount+')">Remove</a>\
                </div>\
            </div>\
          </div>');
        $("#numofrows").val(apendNoofrows);
      });
      // end add multipal sub task
	
	//validate all fields
	$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
	$("#task_form").validate({
		rules: {
			
			id: {
						required: true
					 }
			
		},
		messages: {
			
			id: "Please Select an Assignee"
			
		}
	});
    $("#seach").chosen({
     allow_single_deselect : true,
     search_contains: true,
	 width: '30%',
     no_results_text: "Oops, nothing found!",
     placeholder_text_single: "Select Project"
    });
  });
  //end doucmentready

// check sub task duration
  function checksubtaskdurarion(rowno){ 

    var taskduration=parseFloat(document.getElementById('task_duration').value);
    var checksubtaskduration=0;

    var i;
    for (i = 1; i <= rowno; i++) {      
      checksubtaskduration=parseFloat(document.getElementById('subtaskdurarion'+i).value);   

      if(checksubtaskduration>taskduration){
        document.getElementById('subtaskdurarion'+i).value = "";

        document.getElementById("checkflagmessage").innerHTML='Sub Task Duration Greater Than Task Duration'; 

        $('#flagchertbtn').click();

      } 
    }    
  }

  // end sub task duration

  // task edit section

  function check_activeflag(id){
        
  $.ajax({
        cache: false,
        type: 'GET',
        url: '<?php echo base_url().'common/activeflag_cheker/';?>',
        data: {table: 'wip_project', id: id,fieldname:'task_id' },
        success: function(data) {
        if (data) {
          document.getElementById("checkflagmessage").innerHTML=data; 
          $('#flagchertbtn').click();
         
        } 
      else
      {
        $('#popupform').delay(1).fadeIn(600);
        $( "#popupform" ).load( "<?=base_url()?>wip/task/edit/"+id );
      }
        }
    });
}

// end task edit section

function close_edit(id){         
    $.ajax({
          cache: false,
          type: 'GET',
          url: '<?php echo base_url().'common/delete_activflag/';?>',
          data: {table: 'wip_project', id: id,fieldname:'prj_id' },
          success: function(data) {
              if (data) {
           $('#popupform').delay(1).fadeOut(800);
           
          //document.getElementById('mylistkkk').style.display='block';
              } 
        else
        {
           document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin '; 
           $('#flagchertbtn').click();
          
        }
          }
      });
    }

// end edit section

// tast delete section

  var deleteid="";

  function call_delete(id)
  {
    document.deletekeyform.deletekey.value=id;
    $.ajax({
        cache: false,
        type: 'GET',
        url: '<?php echo base_url().'common/activeflag_cheker/';?>',
        data: {table: 'wip_task', id: id,fieldname:'task_id' },
        success: function(data) {
        if (data) {
          document.getElementById("checkflagmessage").innerHTML=data; 
          $('#flagchertbtn').click();         
        
        }else{
          $('#complexConfirm').click();
        }
      }
    }); 
  }

// end tast delete section

// set end date 

function settaskenddate(){ 

    var task_start_date=document.getElementById('task_start_date').value;
    var task_duration=parseFloat(document.getElementById('task_duration').value);
    var count=0;

    someDate = new Date(task_start_date);
    someDate.setDate(someDate.getDate() + task_duration);
    enddate = someDate.toISOString().substr(0,10);

    if(task_start_date!='' && task_duration!=''){
      
    $.ajax({
        cache: false,
        type: 'POST',
        url: '<?=base_url()?>wip/task/get_all_holidays',
        dataType: 'JSON',
        success: function(response) {    

          for (var i = 0; i < response.length; i++) {
            var check_holiday = response[i]['holiday_date'];

            if(task_start_date <= check_holiday && check_holiday <= enddate){             
              
              count++;
			  task_duration=task_duration+count;

            }
            someDate = new Date(task_start_date);
            someDate.setDate(someDate.getDate() + task_duration);
            dateFormated = someDate.toISOString().substr(0,10);

          }
          
          document.getElementById('showenddate').value = dateFormated;          
        }
    });
    event.preventDefault();
      
  }
}

  // end set end date 
  // task view section

function view(id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/task/view/"+id );
}

// end task view section

function close_view(){
  $('#popupform').delay(1).fadeOut(800);
}

// task accept section

function call_accept(task_id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/task/task_accept_view_for_popup/"+task_id );
}

function close_accept(){
  $('#popupform').delay(1).fadeOut(800);
}

// end task accept section

function chosenActivate(){
    document.getElementById("custsearch").style.display="none";

  setTimeout(function(){ 
    $("#prj_id").chosen({
      allow_single_deselect : true,
      search_contains: true,
	  width: '100%',
      no_results_text: "Oops, nothing found!",
      placeholder_text_single: "Select a Project"
    });

    $("#task_assign").chosen({
        allow_single_deselect : true,
      search_contains: true,
	  width: '100%',
      no_results_text: "Oops, nothing found!",
      placeholder_text_single: "Select an Assignee"
      });

  }, 800);
}

//validation
function validateForm(){
  var projectid=false;
  var empid=false;
  if($("#prj_id").val()!=''){
    projectid=true;
    $("#validation_prj_id").text("");
  }
  else{
    $("#validation_prj_id").text("Please Select Project");
  }
  if($("#task_assign").val()!=''){
    empid=true;
    $("#validation_task_assign").text("");
  }
  else{
    $("#validation_task_assign").text("Please Select Assignee");
  } 

  if(projectid==true && empid==true){
    $("#hiddensubmit").click();
  }else{
	$('#btnsubmit').removeAttr("disabled");  
  }
  


}
//end validation

//delete row in sub task list
function remove_field(id){
  $("#divrow"+id).remove();
}
//end delete row in sub task list

// update progess
function updateprograss(task_id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/subtask/progess_view/"+task_id );
}

function close_updateprograss(){
  $('#popupform').delay(1).fadeOut(800);
}
// end update progess

// sub task accept section
function call_accept_sub(subt_id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/subtask/sub_task_accept_view_for_popup/"+subt_id );
}

function close_accept_sub(){
  $('#popupform').delay(1).fadeOut(800);
}

// end sub task accept section

// tast delete section

  var deleteid="";

  function call_delete_sub(id)
  {
    document.deletekeyform.deletekey.value=id;
    $.ajax({
        cache: false,
        type: 'GET',
        url: '<?php echo base_url().'common/activeflag_cheker/';?>',
        data: {table: 'wip_sub_task', id: id,fieldname:'subt_id' },
        success: function(data) {
        if (data) {
          document.getElementById("checkflagmessage").innerHTML=data; 
          $('#flagchertbtn').click();         
        
        }else{
          $('#complexConfirm_sub').click();
        }
      }
    }); 
  }
// end tast delete section

// view sub task
function viewsubtask(subtask_id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/subtask/viewsubtask/"+subtask_id );
}

function close_viewsubtask(){
  window.location.href = "<?=base_url()?>wip/task/showall";
  $('#popupform').delay(1).fadeOut(800);
}
// end view sub task

function sub_extend(subtask_id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/subtask/view_subtask_extend/"+subtask_id );
}

function task_extend(task_id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/task/view_task_extend/"+task_id );
}

function close_sub_extend(){
  $('#popupform').delay(1).fadeOut(800);
}

function getTaskbyProjectID(pro_id){
  if(pro_id!=""){
    
    $('#tasktable').delay(1).fadeIn(600);
    document.getElementById("tasktable").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
          $( "#tasktable").load( "<?=base_url()?>wip/task/getTaskbyProjectID/"+pro_id);
  }
}

function showserrchbox(){
  document.getElementById("custsearch").style.display="block";
}

//display chceck box  Ticket 1036 Bilani 2020-01-01
  function display_checkBox(rowno){
    var subt_duration=$('#subtaskdurarion'+rowno).val();
    if(subt_duration!='' && subt_duration!=0){
        $("#div_checkbox"+rowno).css({
          "opacity":"0",
          "display":"block",
        }).show().animate({opacity:1});
    }
    else{
       $("#chkHoldId"+rowno).prop('checked', false); // Unchecks it
       $("#hold_date"+rowno).fadeOut("slow");
      $("#div_checkbox"+rowno).fadeOut("slow");
    }
    
  }
  //display chceck box End  Ticket 1036 Bilani 2020-01-01 

</script>


<style type="text/css">
  .form_padding{
    padding-left: 0px;
  }
  .white-bg{
	  color:#FFF;
	  border-radius:5px;
	  padding:3px 10px;
   }
   .dark-bg{
	  color:#FFF;
	  border-radius:10px;
	  padding:3px 10px;
   }
</style>

</head>

<!-- //header-ends -->
<!-- main content start-->

<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

    <h3 class="title1">Task Data</h3>

    <!--search-box-->
    <div class="search-box-cust" id="custsearch">
      <form class="input">
        <select class="sb-search-input input__field--madoka" placeholder="Qick Search.."  id="seach" name="seach"   onChange="getTaskbyProjectID(this.value)">
        <option value=""></option>
        <?=$searchdata?>
        </select> 
              
        <button type="submit"  class="search-box_submit">SEARCH</button>
      </form>
    </div><!--//end-search-box-->
    <br>
     			
    <div class="widget-shadow">
        <ul id="myTabs" class="nav nav-tabs" role="tablist">           
           	
          <li role="presentation" class="active">
              <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false" onclick="showserrchbox()">Task List</a>
          </li>

          <?php
            if (check_access('add_task')){ ?>
               <li role="presentation" class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true" onClick="chosenActivate()">Add New Task</a></li>
           <? } ?>
                    	
        </ul>	
           
    <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
      <? $this->load->view("includes/flashmessage");?>
        <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
        <br>              
      <div class="form-title">
				<h4>Task List
         
				</h4>
      </div>     

     	<div class=" widget-shadow bs-example" data-example-id="contextual-table" id="tasktable"> 
        <table class="table table2excel"> 
          <thead> 
            <tr> 
              <th>Project Name</th>
              <th>Task Name</th>
              <th>Created By</th>
              <th>Asignee</th>
              <th>Duration </th> 
              <th>Start Date </th>
              <th>End Date </th>
              <th>Progress</th> 
              <th></th>
              <th>Status</th>
              <th></th>
            </tr> 
            </thead> 
            <tbody> 
                                                                  
            <? if($datalist){
				
                $c=0;
                $checkuser=$this->session->userdata('userid');
                $taskid=''; 
                $subt_assign='';
                $today=date("Y-m-d");             
                foreach($datalist as $row){

					$task_progress=0;
					if(get_task_progress($row->task_id)){ //this function is in WIP helper
						$task_progress = get_task_progress($row->task_id);
					}

					if($row->task_sdate <= $today && ($row->task_createby==$checkuser || $row->task_assign==$checkuser || is_user_have_subtasks($checkuser,$row->task_id) /*wip helper funtion*/ || is_project_owner($checkuser,$row->prj_id)/* wip helper function*/) ){ 
						$subtasks = get_subtasks_by_taskid($row->task_id,$checkuser); //wip helper function
						$color = '';
					    if($row->task_status == 'pending'){
						$color = '#ECB35B';   
				    ?>
                    	<tr class="bg-orange-200" style="border-top:5px solid #ECB35B;">
                    <? }
						if($row->task_status == 'processing'){
						$color = '#91cc87';
					?>
                        <tr class="bg-green-200" style="border-top:5px solid #9BCE93;">
                    <? }
						if($row->task_status == 'rejected'){
						$color = '#FEA0A3';
					?>
                        <tr class="bg-red-100" style="border-top:5px solid #FEA0A3;">
                    <? }
						if($row->task_status == 'expired'){
						$color = '#999';
					?>
                    	<tr class="bg-grey-400" style="border-top:5px solid #999;">
					<? }
						if($row->task_status == 'completed'){
						$color = '#75BAFF';
					?>
                         <tr class="bg-blue-200" style="border-top:5px solid #75BAFF;">
                    <? }?>
                            <td><?=$row->prj_name?></td> 
                            <td><?=$row->task_name?></td>
                            <td><?=get_user_fullname_id($row->task_createby) //re_account helper funtion?></td>
                            <td><?=get_user_fullname_id($row->task_assign) //re_account helper funtion?></td>
                            <td><?=$row->task_duration?> Days</td>
                            <td><?=$row->task_sdate?></td>
                            <td><span 
                      <? 
						
						//we show different colors depend on time remains for the task
						if($row->task_status != 'completed'){
							$task_duration = $row->task_duration;
							$end_date = strtotime(date('Y-m-d'));
							$start_date = strtotime($row->task_sdate);
							$datediff = $end_date - $start_date;
							$datediff = round($datediff / (60 * 60 * 24));
							$task_duration_todate = $datediff;
							$task_duration_used = ($task_duration_todate / $task_duration) * 100;
							
							if($row->task_status == 'expired'){
								echo ' class="white-bg bg-grey-600"';
							}else if ($task_duration_used >= 90){
								echo ' class="white-bg bg-red-600"';   
							}
							else if ($task_duration_used >= 75 && $task_duration_used <= 90){
								echo ' class="white-bg bg-orange-800"';
							}
							else if ($task_duration_used >= 50 && $task_duration_used <= 75){
								echo ' class="white-bg bg-orange-500"';
							}
							else if ( $task_duration_used <= 50){
								echo ' class="white-bg bg-green-600"';
							}
						}else{
							echo ' class="white-bg"';
						}
					  ?> > <?=$row->task_edate?></span></td>
                          <td>
                            <div id="progress" class="progress progress-striped active">
                            <?php if($task_progress == 100){ ?>
                                <div class="bar blue" style="width: <?=$task_progress?>%"></div>
                             <? }else if($task_progress >= 75 && $task_progress < 100){ ?>
                                <div class="bar green" style="width: <?=$task_progress?>%"></div>
                             <? }else if($task_progress >= 50 && $task_progress < 75){ ?>
                                <div class="bar yellow" style="width:<?=$task_progress?>%;"></div>
                             <? }else if($task_progress >= 30 && $task_progress < 50){ ?>
                                <div class="bar orange" style="width:<?=$task_progress?>%;"></div>
                             <? }else{ ?>
                                <div class="bar red" style="width:<?=$task_progress?>%;"></div>
                             <? } ?>                         
                            </div>
                          </td>
                      
                      <td><?=$task_progress?>%</td>
                      <? if($row->task_status == 'pending'){?>
                          <td >Pending Acceptence</td>
                      <? } ?>
                      <? if($row->task_status == 'rejected'){?>
                          <td >Rejected</td>
                      <? } ?>
                      <? if($row->task_status == 'processing'){?>
                          <td>Ongoing</td>
                      <? } ?>
                      <? if($row->task_status == 'completed'){?>
                          <td>Completed</td>
                      <? } ?>
                      <? if($row->task_status == 'expired'){?>
                          <td>Expired</td>
                      <? } ?>

                      <td align="right"><div id="checherflag">

                        <? $checkuser=$this->session->userdata('userid');
                          if($row->task_createby==$checkuser && $row->task_assign==$checkuser){ ?>

                         	<a  href="javascript:view('<?=$row->task_id?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>

                         <? } ?>

                         <? $checkuser=$this->session->userdata('userid');
                          if($row->task_createby==$checkuser && $row->task_progress!=100 || ($row->task_assign==$checkuser && $row->task_accepted_status!=0 && $row->task_progress!=100)){
							if($row->task_status != 'expired'){ ?>
                            	<a  href="javascript:check_activeflag('<?=$row->task_id?>')" title="Edit"> <i class="fa fa-edit nav_icon icon_blue"></i></a>
						<?	
							}
						 } ?>
                    
                         <?
                         $current_date=date("Y-m-d");
                          if($row->task_accepted_status==0 && $row->task_assign==$checkuser && $row->task_sdate <= $current_date){
                           ?>
                            <a  href="javascript:call_accept('<?=$row->task_id?>')" title="Accept Task"><i class="fa fa-check nav_icon icon_green"></i></a>
                        <? } ?>

                        <?
                          if($row->task_createby==$checkuser && $row->task_progress==0){ ?>
                              <a  href="javascript:call_delete('<?=$row->task_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>               
                         <? } ?>                                      
                      </div></td>
                    </tr>
                

                 <? if(!empty($subtasks)){
				 ?>
                 		<thead>
                            <tr> 
                                <th colspan="11" style="background:<?=$color;?>">Sub Tasks</th>
                            </tr> 
                        </thead>
                 <?
						foreach($subtasks as $data){
							 if($data->subt_hold_edate <= $today && ($row->task_createby==$checkuser || $row->task_assign==$checkuser || $data->subt_createby==$checkuser || $data->subt_assign==$checkuser || is_project_owner($checkuser,$row->prj_id)/* wip helper function*/)){
                  ?>
                                <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                  <td></td> 
                                  <td><?=$data->subt_name?></td>
                                  <td><?=get_user_fullname_id($data->subt_createby) //re_account helper funtion?></td>
                                  <td><?=get_user_fullname_id($data->subt_assign) //re_account helper funtion?></td>
                                  <td><?=$data->subt_duration?> Days</td>
                                  <td><?=$data->subt_sdate?></td>
                                  <td style="padding-left:30px;"><span 
                                  <? 
                                    
                                    //we show different colors depend on time remains for the task
                                    if($row->task_status != 'completed' && $data->subt_status != 'pending' && $data->subt_status != 'rejected'){
                                        $task_duration = $data->subt_duration;
                                        $end_date = strtotime(date('Y-m-d'));
                                        $start_date = strtotime($data->subt_sdate);
                                        $datediff = $end_date - $start_date;
                                        $datediff = round($datediff / (60 * 60 * 24));
                                        $task_duration_todate = $datediff;
                                        $task_duration_used = ($task_duration_todate / $task_duration) * 100;
                                        
                                        
                                        if($row->task_status != 'expired'){
                                            if($data->subt_status == 'completed'){
                                                
                                                echo ' class="dark-bg bg-blue-500"';
                                                
                                            }else if($data->subt_status == 'expired'){
                                                
                                                echo ' class="dark-bg bg-grey-500"';
                                                
                                            }else{
                                                if ($task_duration_used >= 90){
                                                    echo ' class="dark-bg bg-red-400"';   
                                                }
                                                else if ($task_duration_used >= 75 && $task_duration_used <= 90){
                                                    echo ' class="dark-bg bg-orange-600"';
                                                }
                                                else if ($task_duration_used >= 50 && $task_duration_used <= 75){
                                                    echo ' class="dark-bg bg-orange-400"';
                                                }
                                                else if ( $task_duration_used <= 50){
                                                    echo ' class="dark-bg bg-green-500"';
                                                }
                                            }
                                        }else{
                                            if($data->subt_status == 'completed'){
                                                
                                                echo ' class="dark-bg bg-blue-500"';
                                                
                                            }else{
                                                echo ' class="dark-bg bg-grey-500"';
                                            }
                                        }
                                    }
                                    
                                  ?> > <?=$data->subt_edate?></span></td>
                                  <td>
                                    <div id="progress" class="progress progress-striped active">
                                    <?php if($data->subt_progress == 100){ ?>
                                        <div class="bar blue" style="width: <?=$data->subt_progress?>%"></div>
                                     <? }else if($data->subt_progress >= 75 && $data->subt_progress < 100){ ?>
                                        <div class="bar green" style="width: <?=$data->subt_progress?>%"></div>
                                     <? }else if($data->subt_progress >= 50 && $data->subt_progress < 75){ ?>
                                        <div class="bar yellow" style="width:<?=$data->subt_progress?>%;"></div>
                                     <? }else if($data->subt_progress >= 30 && $data->subt_progress < 50){ ?>
                                        <div class="bar orange" style="width:<?=$data->subt_progress?>%;"></div>
                                     <? }else{ ?>
                                        <div class="bar red" style="width:<?=$data->subt_progress?>%;"></div>
                                     <? } ?>                         
                                    </div>
                                  </td>
                                  <td><?=$data->subt_progress?>%</td>
                                  <?
                                  if($row->task_status != 'expired'){
                                   if($data->subt_status  == 'pending'){?>
                                      <td><span class="bg-orange-700 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Pending Acceptence</span></td>
                                  <? } ?>
                                  <? if($data->subt_status  == 'processing'){?>
                                      <td><span class="bg-green-600 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Ongoing</span></td>
                                  <? } ?>
                                   <? if($data->subt_status  == 'rejected'){?>
                                      <td><span class="bg-red-300 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Rejected</span></td>
                                  <? } ?>
                                  <? if($data->subt_status  == 'completed'){?>
                                      <td><span class="bg-blue-600 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Completed</span></td>
                                  <? }?>
                                  <? if($data->subt_status  == 'expired'){?>
                                      <td><span class="bg-grey-500 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Expired</span></td>
                                  <? }
                                  }else{
                                      if($data->subt_status  == 'completed'){
                                  ?>
                                        <td><span class="bg-blue-600 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Completed</span></td>
                                  <?
                                      }else{
                                    ?>
                                        <td><span class="bg-grey-500 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Expired</span></td>
                                  <?
                                      }
                                  }?>
                    
            
                            
                                  <td align="right"><div id="checherflag">
                                    <? $checkuser=$this->session->userdata('userid');
                                    if(($data->subt_assign==$checkuser && $row->task_accepted_status==1) || $data->subt_createby==$checkuser || is_project_owner($checkuser,$row->prj_id)/* wip helper function*/){ ?>
            
                                        <a  href="javascript:viewsubtask('<?=$data->subt_id?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>
                                    <? } ?>
            
                                    <? if($data->subt_assign==$checkuser && $data->subt_accepted_status==0 && $row->task_accepted_status == 1){ ?>
                                        
                                        <a  href="javascript:call_accept_sub('<?=$data->subt_id?>')" title="Accept"><i class="fa fa-check nav_icon icon_green"></i></a>                                               
                                    <? } ?>
            
                                      <? if($data->subt_assign==$checkuser && $row->task_accepted_status==1 && $data->subt_accepted_status==1 && $data->subt_status != 'completed' && $data->subt_status != 'expired' && $row->task_status != 'expired' && check_access('view_progress')){ ?>
            
                                         <a href="javascript:updateprograss('<?=$data->subt_id?>')" title="Update Progress"><i class="fa fa-spinner nav_icon blue-500"></i></a>
            
                                      <? } ?>
            
                                      <? if($data->subt_assign==$checkuser && $row->task_accepted_status==1 && $data->subt_accepted_status==1 && $data->subt_status != 'completed'){ ?>
            
                                         <a href="javascript:sub_extend('<?=$data->subt_id?>')" title="Extend Days"><i class="fa fa-plus-square nav_icon icon_green"></i></a>
            
                                      <? } ?>
            
                                       <?
                                      
                                      if($data->subt_createby==$checkuser && $data->subt_progress==0){ ?>
            
                                      <a  href="javascript:call_delete_sub('<?=$data->subt_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
            
                                      <? } ?>                                     
            
                                  </div></td>
                                  <td></td>
                                </tr>                 
                 		<? }
						}
				  		}//subtask foreack
               		 }//check subtask id
                	$taskid=$row->task_id;
              	}//end foreach
            }//check is set rows?>
            </tbody>
          </table>
          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>   
      </div>  
    </div> 

    <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
      <form data-toggle="validator" id="task_form" method="post" action="<?=base_url()?>wip/task/add" enctype="multipart/form-data">

        <div class="row">
          <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
            <div class="form-body">

              <div class="col-md-4 form_padding"> 
                <div class="form-group">
                  <select required class="form-control" placeholder="Qick Search.." id="prj_id" name="prj_id">   
                    <option value=""></option>
                    <? foreach ($allproject as $raw){?>
                      <option value="<?=$raw->prj_id?>" > <?=$raw->prj_name?></option>
                    <? }?>                          
                  </select>
                  <span class="help-block with-errors" id="validation_prj_id" style="color: #a94442;"></span>
                </div>
              </div>

              <div class="col-md-4 form_padding"> 
                <div class="form-group">
                  <select required class="form-control" placeholder="Qick Search.." id="task_assign" name="task_assign">  
                    <option value=""></option>
                    <? foreach ($allemployees as $raw){?>
                      <option value="<?=$raw->id?>" > <?=$raw->initial." ".$raw->surname?></option>
                    <? }?>            
                  </select>
                  <span class="help-block with-errors" id="validation_task_assign" style="color: #a94442;"></span>
                </div>
              </div>

              <div class="col-md-4 form_padding">
                <div class="form-group has-feedback">
                  <input type="text" class="form-control"name="task_mame" id="task_name"   placeholder="Task Name" data-error=""  required>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
              </div>

              <div class="col-md-4 form_padding">       
                <div class="form-group has-feedback">
                  <textarea class="form-control" id="task_description" name="task_description" rows="1" placeholder="Description" required></textarea>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
              </div>

              <div class="col-md-4 form_padding">
                <div class="form-group has-feedback">
                  <input type="number" class="form-control"name="task_duration" id="task_duration" placeholder="Duration (Days)" min="0" data-error="" required onchange="settaskenddate(this)">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
              </div>

              <div class="col-md-4 form_padding">
                <div class="form-group" id="fromdatediv">
                  <input type="text" name="task_start_date" id="task_start_date" placeholder="Task Start Date" autocomplete="off" class="form-control" required onchange="settaskenddate(this)">
                </div>
              </div>

              <div class="col-md-4 form_padding" id="showenddatediv">
                <div class="form-group">
                  <input type="text" name="showenddate" id="showenddate" class="form-control" readonly placeholder="Task End Date">
                </div>
              </div>

              <input type="hidden" name="numofrows" id="numofrows">

            <br><br><br>
            <div id="tblSubtask">
            </div>

            <div class="col-md-12 form_padding">  
                <!-- <div class="bottom validation-grids">  -->                     
                  <div class="form-group">
                    <button type="button" id="btnsubmit" onclick="this.disabled=true;this.value='Sending, please wait...';validateForm();" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-success" id="addSubtask">Add Sub Task</button>
                    <button type="submit" style="display: none;" id="hiddensubmit" class="btn btn-primary disabled">Submit</button>
                  </div>
                  <br><br><div class="clearfix"> </div>
                <!--  </div>-->         
            </div>

          </div>
        </div>
      </div>
      <div class="clearfix"></div>  
    </form>   
  </div>
</div>
</div>
</div>

<div id="fulldata" style="min-height:100px;"></div>

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
                    
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_sub" name="complexConfirm_sub"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>wip/task/delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });


            $("#complexConfirm_sub").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
        headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
          var code=1
                    window.location="<?=base_url()?>wip/subtask/delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
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