
  <!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<style type="text/css">
  #curprogress2{
    padding-left: 35px;
    padding-right: 35px;
  }
</style>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(function(){

  $("#prjid").chosen({
    allow_single_deselect : true,
	placeholder_text_single: "Select Project",
	width: '100%'
  });
  $("#lotid").chosen({
    allow_single_deselect : true,
	placeholder_text_single: "Select Lot",
	width: '100%'
  });
  $("#related_code").chosen({
    allow_single_deselect : true,
	placeholder_text_single: "Select Stage",
	width: '100%'
  });
});
var deleteid="";

function viewdesigntypeimages(id){
	$('#popupform').delay(1).fadeIn(600);
    $( "#popupform" ).load( "<?=base_url()?>hm/hm_config/view_designtype_images/"+id);
}




function load_lot_list(id){
  console.log("inside unitlist "+id)
   $("#curprogress2").html("");
   $("#lotlist2").html("");
   $( "#lotlist2" ).load( "<?=base_url()?>hm/dashboard/get_project_rel_lots/"+id);
   setTimeout(function(){
	   $("#lotid2").chosen({
		allow_single_deselect : true,
		placeholder_text_single: "Select Lot",
		width: '100%'
	  });
   },500);
}

function load_dashboard(id){
   $("#related_code").val($("#related_code").data("default-value"));
   var lot  = id;
   var proj = $('#prjid').val();
   //alert(lot+" "+proj)
   $("#curprogress2").html("");
 window.location= "<?=base_url()?>hm/dashboard/get_prj_lot_rel_stages_progress/"+proj+"/"+lot;
}

function load_current_progress2(stageid){
  var prjid = $('#prjid').val();
  var lotid = $('#lotid').val();
  if(prjid=="" || lotid==""){
    alert("Please Select Project and Lot")
  }else{
    console.log(stageid+" "+prjid+" "+lotid)
    $("#curprogress2").html("");
    $("#curprogress2" ).load( "<?=base_url()?>hm/dashboard/get_prj_lot_stage_rel_progress/"+prjid+"/"+lotid+"/"+stageid);
  }
}


</script>
<link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Housing Dashboard</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">View Progress</a></li>
          </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px; min-height:300px;">
               <div role="tabpanel" class="tab-pane fade active in" id="progress" aria-labelledby="progress-tab" >
               
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                        <div class="row">
                    <div class="col-md-3">
                      <div class="form-body">
                          <label>Project</label>
                          <div class="form-group">
                            <select class="form-control" name="prjid" id="prjid" onChange="load_lot_list(this.value)">
                              <option ></option>
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
                    <select class="form-control" name="lotid" id="lotid">
                      
                    </select>

                  </div>
              </div>
            </div>  
            <!--<div class="col-md-3">
              <div class="form-body">
                 <label>Stage</label>
                  <div class="form-group">
                    <select class="form-control" name="related_code" id="related_code" required onChange="load_current_progress2(this.value)" data-default-value="">

                      <? if($relative_code){?>
                        <option value=""></option><? }?>
                        <? foreach ($relative_code as $rw){?>
                          <option value="<?=$rw->code_id?>"><?=$rw->code?> - <?=$rw->description?></option>
                        <? }?>
                    </select>

                  </div>
              </div>
              </div>--></div>
                        
                    <div class="form-group" id="curprogress2">
                  
  
  
  </div>
                    </div>


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
									<div class="modal-body" id="checkflagmessage"> Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
									</div>
								</div>
							</div>
						</div>
					</div>

<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_subtask" name="complexConfirm_subtask"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_subtask" name="complexConfirm_confirm_subtask"  value="DELETE"></button>

<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
<script>
//.........................end file upload process jquery ............................................

            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>hm/hm_config/designtypes_delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
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
</div>
		<!--footer-->

<?
	$this->load->view("includes/footer");
?>

