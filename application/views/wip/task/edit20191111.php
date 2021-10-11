<script type="text/javascript">
   // check hodl

   function editcheckHold(rowno){
    if ($("#chkHoldIdedit"+rowno).is(":checked"))
    {
      $("#tblSubtaskforedit .editholddate"+rowno).css('display','');
      $("#editIddate"+rowno).datepicker({dateFormat: 'yy-mm-dd'});
    }
    else{
      $("#tblSubtaskforedit .editholddate"+rowno).css('display','none');
    }
  }

  // end check hodl
  
  $(document).ready(function(){
    var rowCount=$("#nuberofrowsedit").val();
    var numofrowsappend=$("#nuberofrowsedit").val();

  // add multipal sub task
  $("#addSubtaskforedit").click(function(){
    $("#tblSubtaskforedit").append('<tr>\
      <td>\
      <input type="text" class="form-control" name="subtaskedit['+rowCount+'][name]" placeholder="Sub Task Name" data-error=""  required>\
      <input type="hidden" name="subtaskedit['+rowCount+'][subid]" value="">\
      </td>\
      <td>\
      <input type="number" class="form-control" name="subtaskedit['+rowCount+'][durarion]"   placeholder="Sub Task Duration" data-error="" required onchange="checksubtaskdurarion('+rowCount+')" id="subtaskdurarion'+rowCount+'">\
      </td>\
      <td>\
      <textarea class="form-control" name="subtaskedit['+rowCount+'][sub_description]" placeholder="Description" rows="1" data-error="" required id="sub_description'+rowCount+'"></textarea>\
       </td>\
      <td>\
      <select class="form-control" placeholder="Qick Search.." name="subtaskedit['+rowCount+'][assign]" required>\
      <option value="0">Select Assigner</option>\
      <? foreach ($allemployees as $raw){?>\
        <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>\
        <? }?>\
        </select>\
        </td>\
        <td>\
        <label>Hold</label>\
        <input type="checkbox" class="form-control check_hold" name="subtaskedit['+rowCount+'][hold]" data-error="" id="chkHoldIdedit'+rowCount+'" onclick="editcheckHold('+rowCount+')" value="Hold">\
        </td>\
        <td>\
        <input type="text" class="form-control editholddate'+rowCount+'" name="subtaskedit['+rowCount+'][holdenddate]" placeholder="End Date" data-error="" style="display:none" id="editIddate'+rowCount+'">\
        </td>\
        <td class="tdDelete">\
        <a title="Delete"><i class="fa fa-times nav_icon icon_red remove_field_edit"></i></a>\
        </td>\
        </tr>');
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

      checksubtaskduration=checksubtaskduration+parseFloat(document.getElementById('subtaskdurarion'+i).value); 

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

    if(task_start_date!='' && task_duration!=''){
      var someDate = new Date(task_start_date);
      someDate.setDate(someDate.getDate() + task_duration);
      var dateFormated = someDate.toISOString().substr(0,10);

      document.getElementById('showenddate').value = dateFormated;

    }
       
  }

  // end set end date 

  $( function() {
    $( "#task_start_date").datepicker({dateFormat: 'yy-mm-dd'});
 
    $(tblSubtask).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault();
      $(this).closest("tr").remove();
    });

  } );

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
        $flag=FALSE ;
        $flag=$details->task_status;

        if($details->task_createby==$checkuser && $flag=='pending'){ 
          $flag=TRUE;
         ?>

        <div class="form-body">
          <div class="col-md-6 form_padding"> 
            <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$details->task_id?>">
            <div class="form-group">
              <label>Select Project</label>
              <select class="form-control" placeholder="Qick Search.."   id="prj_id" name="prj_id">
               <? foreach ($allproject as $raw){?>

                <? if($details->prj_id == $raw->prj_id){ ?>
                  <option value="<?=$raw->prj_id?>" selected="selected"><?=$raw->prj_name?></option>
                <? } ?>
                <option value="<?=$raw->prj_id?>" > <?=$raw->prj_name?></option>
              <? }?>                          
            </select>
          </div>
        </div>

        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <label>Select Assigner</label>
            <select class="form-control" placeholder="Qick Search.."   id="task_assign" name="task_assign">
              <? foreach ($allemployees as $raw){?>
                <? if($details->task_assign == $raw->id){ ?>
                  <option value="<?=$raw->id?>" selected="selected"><?=$raw->initials_full?></option>
                <? } ?>                   
                <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>
              <? }?>            
            </select>           
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Task Name</label>
            <input type="text" class="form-control" name="task_mame" id="task_name"   placeholder="Task Name" data-error=""  required value="<?=$details->task_name?>" <?if($flag==FALSE){?>readonly <?}?>>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

      
        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Duration</label>
            <input type="number" class="form-control"name="task_duration" id="task_duration"   placeholder="Duration (Days)" data-error=""  required value="<?=$details->task_duration?>" onchange="settaskenddate(this)">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

       <div class="col-md-6 form_padding">
        <div class="form-group" id="fromdatediv">
          <label>Task Strat Date</label>
          <input type="text" name="task_start_date" id="task_start_date" placeholder="Task Start Date"  class="form-control" required onchange="settaskenddate(this)" value="<?=$details->task_sdate?>">
        </div>
      </div>

      <div class="col-md-6 form_padding" id="showenddatediv">
        <div class="form-group">
          <label>Task End Date</label>
          <input type="text" name="showenddate" id="showenddate" class="form-control" readonly placeholder="Task End Date" value="<?=$details->task_edate?>">
        </div>
      </div>

      <div class="col-md-6 form_padding">       
          <div class="form-group has-feedback">
            <label>Description</label>
            <textarea class="form-control" id="task_description" name="task_description" rows="1" placeholder="Description"><?=$details->task_description?></textarea>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>
        
        <div class="col-md-6 form_padding">  
          <div class="bottom validation-grids">                      
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Sumbit</button>
            </div>
            <br><br><div class="clearfix"> </div>
          </div>
        </div>

        <button type="button" class="btn btn-success disabled" id="addSubtaskforedit">Add Sub Task</button>
        <br><br><br>
      </div>

      <table id="tblSubtaskforedit">

        <? if($subtaskdetails){
          $count=0;
          foreach ($subtaskdetails as $mainraw){?>
            <tr>
              <td>
                <input type="text" class="form-control" name="subtaskedit[<?= $count ?>][name]" placeholder="Sub Task Name" data-error=""  required value="<?=$mainraw->subt_name?>">
                <input type="hidden" name="subtaskedit[<?= $count ?>][subid]" value="<? echo $mainraw->subt_id; ?>">
              </td>
              
              <td>
                <input type="number" class="form-control" name="subtaskedit[<?= $count ?>][durarion]"   placeholder="Sub Task Duration" data-error="" required id="subtaskdurarion<?= $count ?>" value="<?=$mainraw->subt_duration?>">
              </td>

              <td>
               <textarea class="form-control" name="subtaskedit[<?= $count ?>][sub_description]" placeholder="Description" rows="1" data-error="" required><?=$mainraw->sub_description?></textarea>
             </td>

              <td>
                <select class="form-control" placeholder="Qick Search.." name="subtaskedit[<?= $count ?>][assign]">
                  <? foreach ($allemployees as $raw){?>

                    <? if($mainraw->subt_assign == $raw->id){ ?>
                      <option value="<?=$raw->id?>" selected="selected"><?=$raw->initials_full?></option>
                    <? } ?>

                    <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>
                  <? }?>
                </select>
              </td>
              <td>
                <label>Hold</label>

                <? if($mainraw->subt_status){ ?>
                  <input type="checkbox" class="form-control check_hold" name="subtaskedit[<?= $count ?>][hold]" data-error="" id="chkHoldIdedit<?= $count ?>" onclick="editcheckHold(<?= $count ?>);" value="Hold" checked>
                <? }else{ ?>
                  <input type="checkbox" class="form-control check_hold" name="subtaskedit[<?= $count ?>][hold]" data-error="" id="chkHoldIdedit<?= $count ?>" onclick="editcheckHold(<?= $count ?>);" value="Hold">
                <? } ?>
              </td>
              <td>

                <? if($mainraw->subt_status){ ?>
                 <input type="text" class="form-control editholddate<?= $count ?>" name="subtaskedit[<?= $count ?>][holdenddate]" placeholder="End Date" data-error="" id="editIddate<?= $count ?>" value="<?=$mainraw->subt_hold_edate?>">
               <? }else{ ?> 
                <input type="text" class="form-control editholddate<?= $count ?>" name="subtaskedit[<?= $count ?>][holdenddate]" placeholder="End Date" data-error="" id="editIddate<?= $count ?>" style="display: none;">

              <? } ?> 

            </td>
            <td class="tdDelete">
              <a title="Delete"><i class="fa fa-times nav_icon icon_red remove_field_edit"></i></a>
            </td>
          </tr>
          <?
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

</table>
<? } ?>

<!-- end edit view for task create user -->

<!-- view section for edit create user  task_status-->

        <? $checkuser=$this->session->userdata('userid');
        if($details->task_createby==$checkuser && $details->task_status!='pending'){ ?>

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
            <label>Select Assigner</label>
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
          <div class="form-group has-feedback">
            <label>Duration</label>
            <input type="number" class="form-control"name="task_duration" id="task_duration"   placeholder="Duration (Days)" data-error=""  required value="<?=$details->task_duration?>" readonly>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>
        
        <div class="col-md-6 form_padding">  
          <div class="bottom validation-grids">                      
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Sumbit</button>
            </div>
            <br><br><div class="clearfix"> </div>
          </div>
        </div>

        <button type="button" class="btn btn-success disabled" id="addSubtaskforedit">Add Sub Task</button>
        <br><br><br>
      </div>

      <table id="tblSubtaskforedit">

        <? if($subtaskdetails){
          $count=0;
          foreach ($subtaskdetails as $mainraw){?>
            <tr>
              <td>
                <input type="text" class="form-control" name="subtaskedit[<?= $count ?>][name]" placeholder="Sub Task Name" data-error=""  required value="<?=$mainraw->subt_name?>">
                <input type="hidden" name="subtaskedit[<?= $count ?>][subid]" value="<? echo $mainraw->subt_id; ?>">
              </td>
              
              <td>
                <input type="number" class="form-control" name="subtaskedit[<?= $count ?>][durarion]"   placeholder="Sub Task Duration" data-error="" required id="subtaskdurarion<?= $count ?>" value="<?=$mainraw->subt_duration?>">
              </td>

              <td>
              <textarea class="form-control" name="subtaskedit[<?= $count ?>][sub_description]" placeholder="Description" rows="1" data-error="" required><?=$mainraw->sub_description?></textarea>
            </td>

              <td>
                <select class="form-control" placeholder="Qick Search.." name="subtaskedit[<?= $count ?>][assign]">
                  <? foreach ($allemployees as $raw){?>

                    <? if($mainraw->subt_assign == $raw->id){ ?>
                      <option value="<?=$raw->id?>" selected="selected"><?=$raw->initials_full?></option>
                    <? } ?>

                    <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>
                  <? }?>
                </select>
              </td>
              <td>
                <label>Hold</label>

                <? if($mainraw->subt_status){ ?>
                  <input type="checkbox" class="form-control check_hold" name="subtaskedit[<?= $count ?>][hold]" data-error="" id="chkHoldIdedit<?= $count ?>" onclick="editcheckHold(<?= $count ?>);" value="Hold" checked>
                <? }else{ ?>
                  <input type="checkbox" class="form-control check_hold" name="subtaskedit[<?= $count ?>][hold]" data-error="" id="chkHoldIdedit<?= $count ?>" onclick="editcheckHold(<?= $count ?>);" value="Hold">
                <? } ?>
              </td>
              <td>

                <? if($mainraw->subt_status){ ?>
                 <input type="text" class="form-control editholddate<?= $count ?>" name="subtaskedit[<?= $count ?>][holdenddate]" placeholder="End Date" data-error="" id="editIddate<?= $count ?>" value="<?=$mainraw->subt_hold_edate?>">
               <? }else{ ?> 
                <input type="text" class="form-control editholddate<?= $count ?>" name="subtaskedit[<?= $count ?>][holdenddate]" placeholder="End Date" data-error="" id="editIddate<?= $count ?>" style="display: none;">

              <? } ?> 

            </td>
            <td class="tdDelete">
              <a title="Delete"><i class="fa fa-times nav_icon icon_red remove_field_edit"></i></a>
            </td>
          </tr>
          <?
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

</table>
<? } ?>

<!-- end create user edit section -->

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
            <label>Select Assigner</label>
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
          <div class="form-group has-feedback">
            <label>Duration</label>
            <input type="number" class="form-control"name="task_duration" id="task_duration"   placeholder="Duration (Days)" data-error=""  required value="<?=$details->task_duration?>" readonly>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>
        
        <div class="col-md-6 form_padding">  
          <div class="bottom validation-grids">                      
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Sumbit</button>
            </div>
            <br><br><div class="clearfix"> </div>
          </div>
        </div>

        <button type="button" class="btn btn-success disabled" id="addSubtaskforedit">Add Sub Task</button>
        <br><br><br>
      </div>

      <table id="tblSubtaskforedit">

        <? if($subtaskdetails){
          $count=0;
          foreach ($subtaskdetails as $mainraw){?>
            <tr>
              <td>
                <input type="text" class="form-control" name="subtaskedit[<?= $count ?>][name]" placeholder="Sub Task Name" data-error=""  required value="<?=$mainraw->subt_name?>">
                <input type="hidden" name="subtaskedit[<?= $count ?>][subid]" value="<? echo $mainraw->subt_id; ?>">
              </td>
              
              <td>
                <input type="number" class="form-control" name="subtaskedit[<?= $count ?>][durarion]"   placeholder="Sub Task Duration" data-error="" required id="subtaskdurarion<?= $count ?>" value="<?=$mainraw->subt_duration?>">
              </td>

              <td>

              <textarea class="form-control" name="subtaskedit[<?= $count ?>][sub_description]" placeholder="Description" rows="1" data-error="" required><?=$mainraw->sub_description?></textarea>
             </td>

              <td>
                <select class="form-control" placeholder="Qick Search.." name="subtaskedit[<?= $count ?>][assign]">
                  <? foreach ($allemployees as $raw){?>

                    <? if($mainraw->subt_assign == $raw->id){ ?>
                      <option value="<?=$raw->id?>" selected="selected"><?=$raw->initials_full?></option>
                    <? } ?>

                    <option value="<?=$raw->id?>" > <?=$raw->initials_full?></option>
                  <? }?>
                </select>
              </td>
              <td>
                <label>Hold</label>

                <? if($mainraw->subt_status){ ?>
                  <input type="checkbox" class="form-control check_hold" name="subtaskedit[<?= $count ?>][hold]" data-error="" id="chkHoldIdedit<?= $count ?>" onclick="editcheckHold(<?= $count ?>);" value="Hold" checked>
                <? }else{ ?>
                  <input type="checkbox" class="form-control check_hold" name="subtaskedit[<?= $count ?>][hold]" data-error="" id="chkHoldIdedit<?= $count ?>" onclick="editcheckHold(<?= $count ?>);" value="Hold">
                <? } ?>
              </td>
              <td>

                <? if($mainraw->subt_status){ ?>
                 <input type="text" class="form-control editholddate<?= $count ?>" name="subtaskedit[<?= $count ?>][holdenddate]" placeholder="End Date" data-error="" id="editIddate<?= $count ?>" value="<?=$mainraw->subt_hold_edate?>">
               <? }else{ ?> 
                <input type="text" class="form-control editholddate<?= $count ?>" name="subtaskedit[<?= $count ?>][holdenddate]" placeholder="End Date" data-error="" id="editIddate<?= $count ?>" style="display: none;">

              <? } ?> 

            </td>
            <td class="tdDelete">
              <a title="Delete"><i class="fa fa-times nav_icon icon_red remove_field_edit"></i></a>
            </td>
          </tr>
          <?
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

</table>
<? } ?>

<!-- end assign user edit section -->

</div>
</div>
<div class="clearfix"></div>  
</form> 
</div>

<br /><br /><br /><br /></div>