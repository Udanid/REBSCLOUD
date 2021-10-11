
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script type="text/javascript">
  jQuery(document).ready(function() {
  setTimeout(function(){ 
    
    $("#prj_id").chosen({
        allow_single_deselect : true,
      search_contains: true,
      no_results_text: "Oops, nothing found!",
      placeholder_text_single: "Customer Name"
      });

    $("#emp_id").chosen({
        allow_single_deselect : true,
      search_contains: true,
      no_results_text: "Oops, nothing found!",
      placeholder_text_single: "Customer Name"
      });

  }, 800);
});

</script>

<script type="text/javascript">
  $( function() {
    $( "#task_start_date").datepicker({dateFormat: 'yy-mm-dd'});
 
    $(tblSubtask).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault();
      $(this).closest("tr").remove();
    });

  } );

  // check hodl

  function checkHold(rowno){
    if ($("#chkHoldId"+rowno).is(":checked"))
    {
      $("#tblSubtask .clsholddate"+rowno).css('display','');
      $("#clsholddate"+rowno).datepicker({dateFormat: 'yy-mm-dd'});
    }
    else{
      $("#tblSubtask .clsholddate"+rowno).val('');
      $("#tblSubtask .clsholddate"+rowno).css('display','none');
    }
  }

  // end check hodl


  // add multipal sub task
 
  $(document).ready(function(){
  var rowCount=0;
  var apendNoofrows=0;

  $( "#start_date").datepicker({dateFormat: 'yy-mm-dd'});
 
  $(tblSubtask).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault();
      $(this).closest("tr").remove();
      apendNoofrows--;
      $("#numofrows").val(apendNoofrows);
  });

  $("#addSubtask").click(function(){
    rowCount++;
    apendNoofrows++;

      $("#tblSubtask").append('<tr id="'+rowCount+'">\
            <td>\
              <input type="text" class="form-control" name="subtask['+rowCount+'][name]" placeholder="Sub Task Name" data-error=""  required>\
            <td>\
            <td>\
              <input type="text" class="form-control" name="subtask['+rowCount+'][durarion]"   placeholder="Sub Task Duration" data-error="" required onchange="checksubtaskdurarion('+rowCount+')" id="subtaskdurarion'+rowCount+'">\
            </td>\
            <td>\
              <select class="form-control" placeholder="Qick Search.." name="subtask['+rowCount+'][assign]" required>\
                <option value="0">Select Assigner</option>\
                <? foreach ($allemployees as $raw){?>\
                  <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>\
                <? }?>\
              </select>\
            <td>\
            <td>\
                <label>Hold</label>\
                <input type="checkbox" class="form-control check_hold" name="subtask['+rowCount+'][hold]" data-error="" id="chkHoldId'+rowCount+'" onclick="checkHold('+rowCount+')" value="Hold">\
            </td>\
            <td>\
              <input type="text" class="form-control clsholddate'+rowCount+'" name="subtask['+rowCount+'][holdenddate]" placeholder="End Date" data-error="" style="display:none" id="clsholddate'+rowCount+'">\
            </td>\
            <td class="tdDelete">\
              <a title="Delete"><i class="fa fa-times nav_icon icon_red remove_field"></i></a>\
            </td>\
          </tr>');
        $("#numofrows").val(apendNoofrows);
      });
  });

// end add multipal sub task

// check sub task duration
  function checksubtaskdurarion(rowno){ 

    var taskduration=parseFloat(document.getElementById('task_duration').value);
    var checksubtaskduration=0;

    var i;
    for (i = 1; i <= rowno; i++) {      
      checksubtaskduration=checksubtaskduration+parseFloat(document.getElementById('subtaskdurarion'+i).value);   

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

    if(task_start_date!='' && task_duration!=''){
      var someDate = new Date(task_start_date);
      someDate.setDate(someDate.getDate() + task_duration);
      var dateFormated = someDate.toISOString().substr(0,10);

      document.getElementById('showenddate').value = dateFormated+ " - Task End Date";

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

</script>


<style type="text/css">
  .form_padding{
    padding-left: 0px;
  }
</style>

</head>

<!-- //header-ends -->
<!-- main content start-->

<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

    <h3 class="title1">Task Data</h3>
     			
    <div class="widget-shadow">
        <ul id="myTabs" class="nav nav-tabs" role="tablist">           
           	
          <li role="presentation" class="">
              <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Task List</a>
          </li>
          
          <li role="presentation" class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true" onClick="chosenActivate()">Add New Task</a></li> 
          	
        </ul>	
           
    <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
      <? $this->load->view("includes/flashmessage");?>
        <div role="tabpanel" class="tab-pane fade" id="home" aria-labelledby="home-tab" >
        <br>              
      <div class="form-title">
				<h4>Task List
          <span style="float:right"> 
          <a href="javascript:load_printscrean2()"> <i class="fa fa-file-excel-o nav_icon"></i></a>
				 </span>
				</h4>
      </div>     

     	<div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
        <table class="table"> 
          <thead> 
            <tr> 
              <th>Project Name</th>
              <th>Task Name</th> 
              <th>Duration </th> 
              <th>Progress</th> 
              <th>Status</th>
              <th></th>
            </tr> 
            </thead>                                          
              
            <? if($datalist){$c=0;
                foreach($datalist as $row){?>                     
                  <tbody> 
                    <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                      <td><?=$row->prj_name?></td> 
                      <td><?=$row->task_name?></td>
                      <td><?=$row->task_duration?> Days</td>
                      <td><?=$row->task_progress?>%</td>
                      <td><?=$row->task_status?></td>
                
                <td align="right"><div id="checherflag">
                   <a  href="javascript:view('<?=$row->task_id?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>

                  <a  href="javascript:check_activeflag('<?=$row->task_id?>')" title="Edit"> <i class="fa fa-edit nav_icon icon_blue"></i></a>

                  <?
                    if($row->task_accepted_status==0){ ?>
                      <a  href="javascript:call_confirm('')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                  <? } ?>                   
                   
                   <a  href="javascript:call_delete('<?=$row->task_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                </div></td>
              </tr>                        
                </tbody>
                <?}}?>
              </table>  
      </div>  
        </div> 

<div role="tabpanel" class="tab-pane fade  active in" id="profile" aria-labelledby="profile-tab">
    <form data-toggle="validator" method="post" action="<?=base_url()?>wip/task/add" enctype="multipart/form-data">
  
  <div class="row">
    <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <div class="form-body">
        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <select class="form-control" placeholder="Qick Search.."   id="prj_id" name="prj_id">   <option value="0">Select Project</option>
               <? foreach ($allproject as $raw){?>
                    <option value="<?=$raw->prj_id?>" > <?=$raw->prj_name?></option>
                    <? }?>                          
            </select>
          </div>
        </div>

        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <select class="form-control" placeholder="Qick Search.."   id="task_assign" name="task_assign">   <option value="0">Select Assigner</option>
               <? foreach ($allemployees as $raw){?>
                    <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>
                    <? }?>            
            </select>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <input type="text" class="form-control"name="task_mame" id="task_name"   placeholder="Task Name" data-error=""  required>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

      <div class="col-md-6 form_padding">       
        <div class="form-group has-feedback">
          <textarea class="form-control" id="task_description" name="task_description" rows="1" placeholder="Description"></textarea>
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <span class="help-block with-errors"></span>
        </div>
      </div>

      <div class="col-md-6 form_padding">
        <div class="form-group has-feedback">
          <input type="number" class="form-control"name="task_duration" id="task_duration"   placeholder="Duration (Days)" data-error=""  required>
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <span class="help-block with-errors"></span>
        </div>
      </div>

      <div class="col-md-6 form_padding">
        <div class="form-group" id="fromdatediv">
          <input type="text" name="task_start_date" id="task_start_date" placeholder="Task Start Date"  class="form-control" required onchange="settaskenddate(this)">
        </div>
      </div>

      <div class="col-md-6 form_padding" id="showenddatediv">
        <div class="form-group">
          <input type="text" name="showenddate" id="showenddate" class="form-control" readonly>
        </div>
      </div>
      
      <input type="hidden" name="numofrows" id="numofrows">
  
    <div class="col-md-6 form_padding">  
      <div class="bottom validation-grids">                      
        <div class="form-group">
          <button type="submit" class="btn btn-primary disabled">Sumbit</button>
        </div>
        <br><br><div class="clearfix"> </div>
      </div>
    </div>

    <button type="button" class="btn btn-success disabled" id="addSubtask">Add Sub Task</button>
    <br><br><br>
    <table id="tblSubtask">
    </table>

    </div>
    </div>
    </div>
    <div class="clearfix"></div>  
    </form>   
    </div>
            </div>
         </div>
      </div>

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
<!-- <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button> -->
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
            
              $("#complexConfirm_confirm").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>re/customer/confirm/"+document.deletekeyform.deletekey.value;
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