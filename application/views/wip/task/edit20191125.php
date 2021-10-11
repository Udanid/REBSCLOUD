<script type="text/javascript">

  $( function() {
    $( "#task_start_date").datepicker({dateFormat: 'yy-mm-dd'});
  } );
   // check hodl

   function editcheckHold(rowno){
    if ($("#chkHoldIdedit"+rowno).is(":checked"))
    {
      $("#tblSubtaskforedit .editholddate"+rowno).css('display','');
      $("#editIddate"+rowno).datepicker({dateFormat: 'yy-mm-dd'});
    }
    else{
      $("#tblSubtaskforedit .editholddate"+rowno).css('display','none');
      $("#validation_resumedate"+rowno).text('');
    }
  }

  // end check hodl

  //delete row in sub task list
  function remove_field(id){
    $("#divrow"+id).remove();
  }
  //end delete row in sub task list
  
  $(document).ready(function(){
    $( "#tblSubtaskforedit .resumedate").datepicker({dateFormat: 'yy-mm-dd'});

    var rowCount=$("#nuberofrowsedit").val();
    var numofrowsappend=$("#nuberofrowsedit").val();

  // add multipal sub task
  $("#addSubtaskforedit").click(function(){
    $("#tblSubtaskforedit").append('<div class="col-md-12" id="divrow'+rowCount+'">\
      <div class="col-md-2 form_padding">\
        <div class="form-group has-feedback">\
          <input type="text" class="form-control" name="subtaskedit['+rowCount+'][name]" placeholder="Sub Task Name" data-error=""  required>\
          <input type="hidden" name="subtaskedit['+rowCount+'][subid]" value="">\
        </div>\
      </div>\
      <div class="col-md-1 form_padding">\
        <div class="form-group has-feedback">\
          <input type="number" class="form-control" name="subtaskedit['+rowCount+'][durarion]"   placeholder="Days" data-error="" required onchange="checksubtaskdurarion('+rowCount+')" id="subtaskdurarion'+rowCount+'">\
        </div>\
      </div>\
      <div class="col-md-3 form_padding">\
        <div class="form-group has-feedback">\
          <textarea class="form-control" name="subtaskedit['+rowCount+'][sub_description]" placeholder="Description" rows="1" data-error="" required id="sub_description'+rowCount+'"></textarea>\
        </div>\
      </div>\
      <div class="col-md-2 form_padding">\
        <div class="form-group has-feedback">\
          <select class="form-control" placeholder="Qick Search.." name="subtaskedit['+rowCount+'][assign]" id="subtaskedit'+rowCount+'" required>\
          <option value="">Select Assignee</option>\
          <? foreach ($allemployees as $raw){?>\
            <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>\
          <? }?>\
          </select>\
        </div>\
      </div>\
      <div class="col-md-1 form_padding" style="margin-top: -14px;">\
        <div class="form-group has-feedback">\
          <label for="chkHoldIdedit'+rowCount+'" style="margin-left: 14px;">Hold</label>\
          <input type="checkbox" class="form-control check_hold" name="subtaskedit['+rowCount+'][hold]" data-error="" id="chkHoldIdedit'+rowCount+'" onclick="editcheckHold('+rowCount+')" value="Hold" style="margin-top: -3px;">\
        </div>\
      </div>\
      <div class="col-md-2 form_padding">\
        <div class="form-group has-feedback">\
          <input type="text" class="form-control editholddate'+rowCount+'" name="subtaskedit['+rowCount+'][holdenddate]" placeholder="Resume Date" data-error="" style="display:none" id="editIddate'+rowCount+'">\
          <span class="help-block with-errors" id="validation_resumedate'+rowCount+'" style="color: #ff0000;"></span>\
        </div>\
      </div>\
      <div class="col-md-1 form_padding">\
        <div class="form-group has-feedback">\
          <a title="Delete"><i class="fa fa-times nav_icon icon_red remove_field" onclick="remove_field('+rowCount+')" autocomplete="off"></i></a>\
        </div>\
      </div>\
    </div>');
    $("#subtaskedit"+rowCount).chosen({
       allow_single_deselect : true,
       search_contains: true,
       no_results_text: "Oops, nothing found!",
       placeholder_text_single: "Search"
    });
    rowCount++;
    numofrowsappend++;
    $("#nuberofrowsedit").val(numofrowsappend);
  });

});

// end add multipal sub task

// check sub task duration
  function checksubtaskdurarion(rowno){ 

    var taskduration=parseFloat(document.getElementById('task_duration').value);
    var checksubtaskduration=0;  

    var i;
    for (i = 0; i <= rowno; i++) { 

      checksubtaskduration=parseFloat(document.getElementById('subtaskdurarion'+i).value); 

      if(checksubtaskduration>taskduration){
        document.getElementById('subtaskdurarion'+i).value = "";

        document.getElementById("checkflagmessage").innerHTML='Sub Task Duration Greater Than Task Duration'; 

        $('#flagchertbtn').click();

      } 
    }   
  }

  // end sub task duration

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
              task_duration=task_duration+count;

              count++;

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

  //validation
    function validateForm(){
      var validatedate=true;
      var i;
      var rowCount=$("#nuberofrowsedit").val();
      for(i=0;i<=rowCount;i++){
        if($("#chkHoldIdedit"+i).is(":checked")){
          if($("#editIddate"+i).val()==""){
            $("#validation_resumedate"+i).text('Please Select Resume Date');
            validatedate=false;
            return;
          }
        }
      }
      if(validatedate==true){
        $("#hiddensubmit").click();
      }
    }
  //End validation

</script>

<h4>Task Details<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
  
  <form data-toggle="validator" method="post" action="<?=base_url()?>wip/task/addedit" enctype="multipart/form-data">

    <input type="hidden" class="form-control" name="previous_task_assign" id="previous_task_assign" data-error="" value="<?=$details->task_assign?>">
    
    <div class="row">
      <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 

      <!-- view section for only edit task create user -->

      <? $checkuser=$this->session->userdata('userid');
        $flag=0 ;

        if($details->task_createby==$checkuser){ 
         
        
        if($details->task_createby==$checkuser && $details->task_status=='pending'){ 
          $flag=1;
         
         } 
         ?>
   
        <div class="form-body">
          <div class="col-md-6 form_padding"> 
            <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$details->task_id?>">
            <div class="form-group">
              <label>Select Project</label>
              <select class="form-control" placeholder="Qick Search.."   id="prj_id" name="prj_id" <?if($flag==0){ ?> readonly <? } ?>>
               
               <? foreach ($allproject as $raw){?>

                <? if($details->prj_id == $raw->prj_id){ ?>
                  <option value="<?=$raw->prj_id?>" selected="selected"><?=$raw->prj_name?></option>
                <? } ?>

                <? if($flag==1){ ?>
                <option value="<?=$raw->prj_id?>" > <?=$raw->prj_name?></option>
              <? }}?>                          
            </select>
          </div>
        </div>

        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <label>Select Assignee</label>
            <select class="form-control" placeholder="Qick Search.."   id="task_assign" name="task_assign" <?if($flag==0){ ?> readonly <? } ?>>
              <? foreach ($allemployees as $raw){?>
                <? if($details->task_assign == $raw->id){ ?>
                  <option value="<?=$raw->id?>" selected="selected"><?=$raw->initials_full?></option>
                <? } ?> 
                <? if($flag==1){ ?>                  
                <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>
              <? }}?>            
            </select>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Task Name</label>
            <input type="text" class="form-control" name="task_mame" id="task_name"   placeholder="Task Name" data-error=""  required value="<?=$details->task_name?>" <?if($flag==0){ ?> readonly <? } ?>>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Duration</label>
            <input type="number" min="0" class="form-control"name="task_duration" id="task_duration" onchange="settaskenddate(this)"   placeholder="Duration (Days)" data-error=""  required value="<?=$details->task_duration?>" <?if($flag==0){ ?> readonly <? } ?>>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

        <div class="col-md-6 form_padding">
        <div class="form-group" id="fromdatediv">
          <label>Task Strat Date</label>
          <input type="text" name="task_start_date" <?if($flag==1){ ?> id="task_start_date" <? } ?>  placeholder="Task Start Date"  class="form-control" required onchange="settaskenddate(this)" value="<?=$details->task_sdate?>" <?if($flag==0){ ?> readonly <? } ?>>
        </div>
      </div>

      <div class="col-md-6 form_padding" id="showenddatediv">
        <div class="form-group">
          <label>Task End Date</label>

          <input type="text" name="showenddate" <?if($flag==1){ ?> id="showenddate" <? } ?> class="form-control" readonly placeholder="Task End Date" value="<?=$details->task_edate?>" <?if($flag==0){ ?> readonly <? } ?>>
        </div>
      </div>

      <div class="col-md-6 form_padding">       
          <div class="form-group has-feedback">
            <label>Description</label>
            <textarea class="form-control" id="task_description" name="task_description" rows="1" placeholder="Description" <?if($flag==0){ ?> readonly <? } ?>><?=$details->task_description?></textarea>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>
        <br><br><br>
      </div>

      <div id="tblSubtaskforedit" style="margin-left: 12px;">

        <? if($subtaskdetails){
          $count=0;

          foreach ($subtaskdetails as $mainraw){
            ?>
            <script>
              $("#subtaskedit<?= $count ?>").chosen({
                 allow_single_deselect : true,
                 search_contains: true,
                 no_results_text: "Oops, nothing found!",
                 placeholder_text_single: "Search"
              });
            </script>
            <?
            $subflag=0;

            if($mainraw->subt_status=='processing' || $mainraw->subt_status=='completed'){
              $subflag=1;
            }

            if($mainraw->subt_status!='deleted'){

            ?>


            <div class="col-md-12">
            <div class="col-md-2 form_padding">
              <div class="form-group has-feedback">
                <input type="text" class="form-control" name="subtaskedit[<?= $count ?>][name]" placeholder="Sub Task Name" data-error=""  required value="<?=$mainraw->subt_name?>" <?if($subflag==1){ ?> readonly <? } ?>>
                <input type="hidden" name="subtaskedit[<?= $count ?>][subid]" value="<? echo $mainraw->subt_id; ?>" <?if($subflag==1){ ?> readonly <? } ?>>
              </div>
            </div>
              
            <div class="col-md-1 form_padding">
              <div class="form-group has-feedback">
                <input type="number" min="0" class="form-control" name="subtaskedit[<?= $count ?>][durarion]"   placeholder="Days" onchange="checksubtaskdurarion(<? echo $count; ?>)" data-error="" required id="subtaskdurarion<?= $count ?>" value="<?=$mainraw->subt_duration?>" <?if($subflag==1){ ?> readonly <? } ?>>
              </div>
            </div>
            <div class="col-md-3 form_padding">
              <div class="form-group has-feedback">
               <textarea class="form-control" name="subtaskedit[<?= $count ?>][sub_description]" placeholder="Description" rows="1" data-error="" required <?if($subflag==1){ ?> readonly <? } ?>><?=$mainraw->sub_description?></textarea>
              </div>
            </div>

             <div class="col-md-2 form_padding">
                <div class="form-group has-feedback">
                <select class="form-control" placeholder="Qick Search.." name="subtaskedit[<?= $count ?>][assign]" <?if($subflag==1){ ?> readonly <? } ?> id="subtaskedit<?= $count ?>" >
                  <? foreach ($allemployees as $raw){?>

                    <? if($mainraw->subt_assign == $raw->id){ ?>
                      <option value="<?=$raw->id?>" selected="selected"><?=$raw->initials_full?></option>
                    <? } ?>
                    <?if($subflag==0){ ?>
                    <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>
                  <? }}?>
                </select>
              </div>
            </div>
            <div class="col-md-1 form_padding" style="margin-top: -14px;">
              <div class="form-group has-feedback">
                <label for="chkHoldIdedit<?= $count ?>" style="margin-left: 14px;">Hold</label>
                <? if($mainraw->hold_status=='Hold'){ ?>
                  <input type="checkbox" class="form-control check_hold" name="subtaskedit[<?= $count ?>][hold]" data-error="" id="chkHoldIdedit<?= $count ?>" value="Hold" checked <?if($subflag==1){ ?> readonly onclick="return false;" <? }else{?>onclick="editcheckHold(<?= $count ?>);"<?} ?> style="margin-top: -3px;">
                <? }else{ ?>
                  <input type="checkbox" class="form-control check_hold" name="subtaskedit[<?= $count ?>][hold]" data-error="" id="chkHoldIdedit<?= $count ?>" value="Hold" <?if($subflag==1){ ?> readonly onclick="return false;"<? }else{?>onclick="editcheckHold(<?= $count ?>);"<?} ?>>
                <? } ?>
              </div>
            </div>
            <div class="col-md-2 form_padding">
              <div class="form-group has-feedback">
                <? if($mainraw->hold_status=='Hold'){ ?>
                 <input type="text" name="subtaskedit[<?= $count ?>][holdenddate]" placeholder="Resume Date" data-error="" id="editIddate<?= $count ?>" value="<?=$mainraw->subt_hold_edate?>" <?if($subflag==1){ ?> readonly class="form-control"<? }else{?>class="form-control editholddate<?= $count ?> resumedate"<?} ?>>
               <? }else{ ?> 
                <input type="text" class="form-control editholddate<?= $count ?> resumedate" name="subtaskedit[<?= $count ?>][holdenddate]" placeholder="Resume Date" data-error="" id="editIddate<?= $count ?>" style="display: none;" <?if($subflag==1){ ?> readonly <? } ?>>

              <? } ?>
              <span class="help-block with-errors" style="color: #ff0000;" id="validation_resumedate<?= $count ?>"></span>
              </div>
            </div>
            <div class="col-md-1 form_padding">
              <div class="form-group has-feedback">
              </div>
            </div>
          </div>
          <? }
          $count++;
   }//end for loop
   ?>
   <input type="hidden" name="nuberofrowsedit" id="nuberofrowsedit" value="<?= $count; ?>"/>
 <? } 
 else{
  ?>
  <input type="hidden" name="nuberofrowsedit" id="nuberofrowsedit" value="0"/>
  <?
}?>
</div>
<div class="col-md-12 form_padding" style="margin-left: 26px;">  
  <div class="form-group">
    <button type="button" class="btn btn-success" id="addSubtaskforedit">Add Sub Task</button>
    <button type="button" id="btnsubmit" onclick="validateForm();" class="btn btn-primary disabled">Sumbit</button>
    <button type="submit"  id="hiddensubmit" style="display: none;" class="btn btn-primary disabled">Sumbit</button>
  </div>
  <br><br><div class="clearfix"> </div>
</div>

<? }
?>



<!-- end edit view for task create user -->


<!-- view section for only edit assign user -->

<? $checkuser=$this->session->userdata('userid');

        if($details->task_assign==$checkuser && $details->task_createby!=$checkuser){ ?>

        <div class="form-body">
          <div class="col-md-6 form_padding"> 
            <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$details->task_id?>">
            <div class="form-group">
              <label>Select Project</label>
              <select class="form-control" placeholder="Qick Search.."   id="prj_id" name="prj_id" readonly>
               <? foreach ($allproject as $raw){?>

                <? if($details->prj_id == $raw->prj_id){ ?>
                  <option value="<?=$raw->prj_id?>" selected="selected"><?=$raw->prj_name?></option>
                <? } ?>
                
              <? }?>                          
            </select>
          </div>
        </div>

        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <label>Select Assignee</label>
            <select class="form-control" placeholder="Qick Search.."   id="task_assign" name="task_assign" readonly>
              <? foreach ($allemployees as $raw){?>
                <? if($details->task_assign == $raw->id){ ?>
                  <option value="<?=$raw->id?>" selected="selected"><?=$raw->initials_full?></option>
                <? } ?>                                  
              <? }?>            
            </select>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Task Name</label>
            <input type="text" class="form-control" name="task_mame" id="task_name"   placeholder="Task Name" data-error=""  required value="<?=$details->task_name?>" readonly>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

        <div class="col-md-6 form_padding">       
          <div class="form-group has-feedback">
            <label>Description</label>
            <textarea class="form-control" id="task_description" name="task_description" rows="1" placeholder="Description" readonly><?=$details->task_description?></textarea>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

        <div class="col-md-6 form_padding">
        <div class="form-group" id="fromdatediv">
          <label>Task Strat Date</label>
          <input type="text" name="task_start_date" id="" placeholder="Task Start Date"  class="form-control" required onchange="settaskenddate(this)" value="<?=$details->task_sdate?>" <?if($flag==0){ ?> readonly <? } ?>>
        </div>
      </div>

      <div class="col-md-6 form_padding" id="showenddatediv">
        <div class="form-group">
          <label>Task End Date</label>
          <input type="text" name="showenddate" id="" class="form-control" readonly placeholder="Task End Date" value="<?=$details->task_edate?>" <?if($flag==0){ ?> readonly <? } ?>>
        </div>
      </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Duration</label>
            <input type="number" min="0" class="form-control"name="task_duration" id="task_duration"   placeholder="Duration (Days)" data-error=""  required value="<?=$details->task_duration?>" readonly>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>
      
        <br><br><br>
      </div>

       <div id="tblSubtaskforedit" style="margin-left: 12px;">

        <? if($subtaskdetails){
          $count=0;

          foreach ($subtaskdetails as $mainraw){ ?>

            <script>
              $("#subtaskedit<?= $count ?>").chosen({
                 allow_single_deselect : true,
                 search_contains: true,
                 no_results_text: "Oops, nothing found!",
                 placeholder_text_single: "Search"
              });
            </script>

          <?

            $subflag=0;

            if($mainraw->subt_status=='processing'){
              $subflag=1;

              if($mainraw->subt_status!='deleted'){
            }

            ?>
            <div class="col-md-12">
            <div class="col-md-2 form_padding" >
              <div class="form-group has-feedback">
                <input type="text" class="form-control" name="subtaskedit[<?= $count ?>][name]" placeholder="Sub Task Name" data-error=""  required value="<?=$mainraw->subt_name?>" <?if($subflag==1){ ?> readonly <? } ?>>
                <input type="hidden" name="subtaskedit[<?= $count ?>][subid]" value="<? echo $mainraw->subt_id; ?>" <?if($subflag==1){ ?> readonly <? } ?>>
              </div>
            </div>
              
            <div class="col-md-1 form_padding">
              <div class="form-group has-feedback">
                <input type="number" min="0" class="form-control" name="subtaskedit[<?= $count ?>][durarion]"   placeholder="Days" onchange="checksubtaskdurarion(<? echo $count; ?>)" data-error="" required id="subtaskdurarion<?= $count ?>" value="<?=$mainraw->subt_duration?>" <?if($subflag==1){ ?> readonly <? } ?>>
              </div>
            </div>
            <div class="col-md-3 form_padding">
              <div class="form-group has-feedback">
               <textarea class="form-control" name="subtaskedit[<?= $count ?>][sub_description]" placeholder="Description" rows="1" data-error="" required <?if($subflag==1){ ?> readonly <? } ?>><?=$mainraw->sub_description?></textarea>
              </div>
            </div>

             <div class="col-md-2 form_padding">
                <div class="form-group has-feedback">
                <select class="form-control" id="subtaskedit<?= $count ?>" placeholder="Qick Search.." name="subtaskedit[<?= $count ?>][assign]" <?if($subflag==1){ ?> readonly <? } ?>>
                  <? foreach ($allemployees as $raw){?>

                    <? if($mainraw->subt_assign == $raw->id){ ?>
                      <option value="<?=$raw->id?>" selected="selected"><?=$raw->initials_full?></option>
                    <? } ?>
                    <?if($subflag==0){ ?>
                    <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>
                  <? }}?>
                </select>
              </div>
            </div>
            <div class="col-md-1 form_padding" style="margin-top: -14px;">
              <div class="form-group has-feedback">
                <label for="chkHoldIdedit<?= $count ?>" style="margin-left: 14px;">Hold</label>
                <? if($mainraw->hold_status=='Hold'){ ?>
                  <input type="checkbox" class="form-control check_hold" name="subtaskedit[<?= $count ?>][hold]" data-error="" id="chkHoldIdedit<?= $count ?>" value="Hold" checked <?if($subflag==1){ ?> readonly onclick="return false;"<? }else{?>onclick="editcheckHold(<?= $count ?>);"<?} ?>>
                <? }else{ ?>
                  <input type="checkbox" class="form-control check_hold" name="subtaskedit[<?= $count ?>][hold]" data-error="" id="chkHoldIdedit<?= $count ?>" value="Hold" <?if($subflag==1){ ?> readonly onclick="return false;"<? }else{?>onclick="editcheckHold(<?= $count ?>);"<?} ?> style="margin-top: -3px;">
                <? } ?>
              </div>
            </div>
            <div class="col-md-2 form_padding">
              <div class="form-group has-feedback">
                <? if($mainraw->hold_status=='Hold'){ ?>
                 <input type="text" name="subtaskedit[<?= $count ?>][holdenddate]" placeholder="Resume Date" data-error="" id="editIddate<?= $count ?>" value="<?=$mainraw->subt_hold_edate?>" <?if($subflag==1){ ?> readonly class="form-control editholddate<?= $count ?>" <? }else{?>class="form-control editholddate<?= $count ?> resumedate"<?} ?>>
               <? }else{ ?> 
                <input type="text" class="form-control editholddate<?= $count ?>" name="subtaskedit[<?= $count ?>][holdenddate]" placeholder="Resume Date" data-error="" id="editIddate<?= $count ?> resumedate" style="display: none;" <?if($subflag==1){ ?> readonly <? } ?>>

              <? } ?>
                <span class="help-block with-errors" style="color: #ff0000;" id="validation_resumedate<?= $count ?>"></span> 
              </div>
            </div>
            <div class="col-md-1 form_padding">
              <div class="form-group has-feedback">
              </div>
            </div>
          </div>
          <? }
          $count++;
   }//end for loop
   ?>
   <input type="hidden" name="nuberofrowsedit" id="nuberofrowsedit" value="<?= $count; ?>"/>
 <? } 
 else{
  ?>
  <input type="hidden" name="nuberofrowsedit" id="nuberofrowsedit" value="0"/>
  <?
}
?>

</div>
<div class="col-md-12 form_padding" style="margin-left: 26px;">  
  <div class="form-group">
   <button type="button" class="btn btn-success" id="addSubtaskforedit">Add Sub Task</button>
   <button type="button" id="btnsubmit" onclick="validateForm();" class="btn btn-primary disabled">Sumbit</button>
    <button type="submit"  id="hiddensubmit" style="display: none;" class="btn btn-primary disabled">Sumbit</button>
 </div>
 <br><br><div class="clearfix"> </div>
</div>
<? } ?>

<!-- end assign user edit section -->

</div>
</div>
<div class="clearfix"></div>  
</form> 
</div>
<br /><br /><br /><br />
</div>