
<style type="text/css">
  #curprogress2{
    padding-left: 35px;
    padding-right: 35px;
  }
</style>
<script type="text/javascript">
function loadSelect(){
	setTimeout(function(){ 
		$("#prjid2").chosen({
			allow_single_deselect : true,
			placeholder_text_single: "Select Project",
		});
		$("#lotid2").chosen({
			allow_single_deselect : true,
			placeholder_text_single: "Select Lot",
		});
		$("#related_code2").chosen({
			allow_single_deselect : true,
			placeholder_text_single: "Select Stage",
		});
	}, 500);
}

function load_polist_and_project_list2(id){
  console.log("inside unitlist "+id)
   $("#curprogress2").html("");
   $("#lotlist2").html("");
   $( "#lotlist2" ).load( "<?=base_url()?>hm/hm_work_progress/get_project_rel_lots/"+id);
   setTimeout(function(){ 
   		$("#lotid2").chosen({
			allow_single_deselect : true,
			placeholder_text_single: "Select Lot",
		});
	}, 500);
	
}



function load_current_progress2(stageid){
  var prjid = $('#prjid2').val();
  var lotid = $('#lotid2').val();
  if(prjid=="" || lotid==""){
    //alert("Please Select Project and LOT")
    document.getElementById("checkflagmessage").innerHTML='Please Select Project and LOT';
    $('#flagchertbtn').click();
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
function close_edit(id)
{
	$('#popupform').delay(1).fadeOut(600);

}
</script>

                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                        <div class="row">
                    <div class="col-md-3">
                      <div class="form-body">
                          <label>Project</label>
                          <div class="form-group">
                            <select class="form-control prjid" name="prjid" id="prjid2" onChange="load_polist_and_project_list2(this.value)">
                              <option value=""></option>
                              <? if($prjlist){
                                foreach ($prjlist as $key => $pl) {?>
                                  <option value="<?=$pl->prj_id?>"> <?=$pl->project_name?></option>
                              <?  }
                              }?>
                            </select>

                          </div>

                     </div>
                    </div>
            <div class="col-md-3">
              <div class="form-body">
                 <div class="form-group" id="lotlist2">
                    <label>Lot</label>
                    <select class="form-control" name="lotid" id="lotid2" required="required" onChange="load_stages(this.value);loadStages();">

                    </select>

                  </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-body">
                 <label>Stage</label>
                  <div class="form-group">
                    <select class="form-control" name="related_code" id="related_code2" required onChange="load_current_progress2(this.value)" data-default-value="">
                    	<option value=""></option>
                    </select>

                  </div>
              </div>
              </div></div>

                    <div class="form-group" id="curprogress2"></div>
                    </div>


                  </div>
