
<style type="text/css">
  #curprogress2{
    padding-left: 35px;
    padding-right: 35px;
  }
</style>
<script type="text/javascript">


function load_polist_and_project_list(id){
  console.log("inside unitlist "+id)
  $("#curprogress").html("");
   $("#lotlist").html("");
   $( "#lotlist" ).load( "<?=base_url()?>hm/hm_grn/get_project_rel_lots/"+id);
}

function load_polist_and_project_list2(id){
  console.log("inside unitlist "+id)
   $("#curprogress2").html("");
   $("#lotlist2").html("");
   $( "#lotlist2" ).load( "<?=base_url()?>hm/hm_grn/get_project_rel_lots/"+id);
}

function load_polist(id){
   $("#curprogress2").html("");
   $("#curprogress").html("");
   $("#related_code").val($("#related_code").data("default-value"));
}



function load_current_progress2(stageid){
  var prjid = $('#prjid').val();
  var lotid = $('#lotid').val();
  if(prjid=="" || lotid==""){
    alert("Please Select Project and LOT")
  }else{
    console.log(stageid+" "+prjid+" "+lotid)
    $("#curprogress2").html("");
    $("#curprogress2" ).load( "<?=base_url()?>hm/hm_work_progress/get_prj_lot_stage_rel_progress/"+prjid+"/"+lotid+"/"+stageid);
  }
}

function viewprogressimages(id){

  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>hm/hm_work_progress/view_progress_images/"+id);
}




</script>

               <table class="table">
                 <tr>
                   <th>#</th>
                   <th>Project/Lot/Stage</th>
                   <th>Remarks</th>
                   <th>Presentage</th>
                   <th>Updated Date and Updated By</th>
									 <th>Status</th>
                   <th></th>
                 </tr>
                 <tbody>
                  <?
                  if($pendingprojectprogress){
                  $i=1;
                  foreach($pendingprojectprogress as $ppp)
                  {
                    $heading = get_prjname($ppp->prj_id)." / Lot ".get_unitname($ppp->lot_id)." / ".$ppp->description;
                  ?>
                   <tr>
                     <td><?=$i?></td>
                     <td><?=$heading?></td>
                     <td><?=$ppp->progress?></td>
                     <td><?=$ppp->progress_pressentage?> %</td>
                     <td><?=$ppp->update_date?> by <?=get_user_fullname_id($ppp->updated_by)?></td>
										 <td><?=$ppp->progress_status?></td>
                     <td id="actions<?=$ppp->progid?>">

                      <?
                      if (check_access('Project progress approve') && $ppp->progress_status=="PENDING")//call from access_helper
                      {
                      ?>
                      <a  href="javascript:approve_progress('<?=$ppp->progid?>')" title="Approve"><i class="fa fa-check nav_icon icon_green"></i></a>
                      <a  href="javascript:cancel_progress('<?=$ppp->progid?>_<?=$ppp->progress_pressentage?>')" title="Cancel"><i class="fa fa-times nav_icon icon_red"></i></a>

                      <?
                      }
                      ?>
                      <a href="javascript:viewprogressimages(<?=$ppp->progid?>)" title="View Progress images"><i class="fa fa-eye"></i></a>
                     </td>
                   </tr>
                   <?
                    $i++;
                     }

                   }
                   ?>
                 </tbody>
               </table>

    


<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
