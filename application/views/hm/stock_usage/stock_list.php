<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">


jQuery(document).ready(function() {

$('#fulldata').hide();


$("#prj_id").focus(function() {
	$("#prj_id").chosen({
     allow_single_deselect : true
  });
});

$("#mat_code").focus(function() {
	$("#mat_code").chosen({
     allow_single_deselect : true
  });
});


});




function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>hm/customer/edit/"+id );
				}
            }
        });
}

// get branch related projects..
function loadcurrent_projects(id){
  $('#prjlist').html('');
  if(id!=""){

    $('#prjlist').delay(1).fadeIn(600);
    document.getElementById("prjlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
    $( "#prjlist" ).load( "<?=base_url()?>hm/Hm_inventry/get_projectsby_branch/"+id );
    console.log("<?=base_url()?>hm/Hm_inventry/get_projectsby_branch/"+id)
 }
 else
 {
   $('#prjlist').delay(1).fadeOut(600);

 }
}

function loadcurrent_block(id)
{
 //$('#fulldata').show();

 $('#tasklist').delay(1).fadeOut(600);
 $('#matlist').delay(1).fadeOut(600);
 $('#fulldata').delay(1).fadeOut(600);
 if(id!=""){

							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#blocklist" ).load( "<?=base_url()?>hm/hm_stockusage/get_blocklist/"+id);

		 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);

 }
}
function load_mat_task(id)
{

  $('#matlist').delay(1).fadeOut(600);
	$('#fulldata').delay(1).fadeOut(600);

	if(id!=""){

		var prj_id=$('#prj_id').val();
 					//get task list
 					$('#tasklist').delay(1).fadeIn(600);
 						 document.getElementById("tasklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
 		 $( "#tasklist" ).load( "<?=base_url()?>hm/hm_stockusage/get_tasklist/"+prj_id+"/"+id);

  }
  else
  {
 	 $('#tasklist').delay(1).fadeOut(600);

  }
}

function load_matdetails(id)
{
  //$('#fulldata').show();
	if($("li.active a#profile-tab").length!=0){
		$('#fulldata').delay(1).fadeOut(600);
		 $('#fullview').delay(1).fadeOut(600);
		 if(id!="")
		 {
			 var prj_id=$('#prj_id').val();
			 var lot_id= $('#lot_id').val();
		 	 $('#matlist').delay(1).fadeIn(600);
	    	  document.getElementById("matlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
			   $( "#matlist").load( "<?=base_url()?>hm/hm_stockusage/get_boqmaterials/"+id+"/"+prj_id+"/"+lot_id );
		 }
 }
 if($("li.active a#view_usage-tab").length!=0){
	 //$('#fullview').delay(1).fadeOut(600);
	 $('#matlist').delay(1).fadeOut(600);
 	$('#fulldata').delay(1).fadeOut(600);
		if(id!="")
		{
			var prj_id=$('#prj_id').val();
			var lot_id= $('#lot_id').val();
			$('#fullview').delay(1).fadeIn(600);
				 document.getElementById("fullview").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
				$( "#fullview").load( "<?=base_url()?>hm/hm_stockusage/get_boqmaterials_view/"+id+"/"+prj_id+"/"+lot_id );
		}
 }

}
function load_fulldetails(id)
{
  //$('#fulldata').show();
	 if(id!="")
	 {
		 var prj_id=$('#prj_id').val();
		 var lot_id= $('#lot_id').val();
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		   $( "#fulldata").load( "<?=base_url()?>hm/hm_stockusage/get_stockdata/"+id+"/"+prj_id+"/"+lot_id );
	 }
}
function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}

function call_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm_confirm').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}

function approve(id){
  ajax_for_approve_disapprove(id,'APPROVED');
  $('#tbldata'+id).html("");
  $('#tbldata'+id).append("APPROVED <a href='javascript:resetthis("+id+")' title='Reset This'><i class='fa fa-refresh nav_icon icon_black' aria-hidden='true' title='approved'></i></a>");

}

function disapprove(id){
  ajax_for_approve_disapprove(id,'CANCELLED');
  $('#tbldata'+id).html("");
  $('#tbldata'+id).append("CANCELLED <a href='javascript:resetthis("+id+")' title='Reset This'><i class='fa fa-refresh nav_icon icon_black' aria-hidden='true' title='Disapproved'></i></a>");
}

function resetthis(id){
  ajax_for_approve_disapprove(id,'PENDING');
  $('#tbldata'+id).html("");
  $('#tbldata'+id).append("<a href='javascript:approve("+id+")' title='Confirm This'><i class='fa fa-check nav_icon icon_green' aria-hidden='true'></i></a><a href='javascript:disapprove("+id+")' title='Confirm This'><i class='fa fa-close nav_icon icon_red' aria-hidden='true'></i></a>");
}

function ajax_for_approve_disapprove(id,stts){
    //console.log("<?php echo base_url()?>hm/hm_inventry/request_meterial_stts")
    $.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url()?>hm/hm_inventry/upd_request_meterial_stts',
            data: {'id':id,'stts':stts},
            success: function(data){
              console.log(data)
              if(data!=='"PENDING"'){
                alert("Status Updated")
              }

            }
    });
}


</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Update Meterial Usage</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">

           <li role="presentation" <? if($tab==''){?> class="active" <? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add Usage</a></li>
           <li role="presentation" <? if($tab=='view_usage'){?> class="active" <? }?>><a href="#view_usage" role="tab" id="view_usage-tab" data-toggle="tab" aria-controls="view_usage" aria-expanded="true">View Usage</a></li>


        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;min-height:500px;">



                 <? $this->load->view("includes/flashmessage");?>

              <!--  <? if($this->session->flashdata('msg')){?>
                <div class="alert alert-success" role="alert">
                <?=$this->session->flashdata('msg')?>
                </div><? }?>
                <? if($this->session->flashdata('error')){?>
                <div class="alert alert-danger" role="alert">
                <?=$this->session->flashdata('error')?>
                </div><? }?> -->


<form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_stockusage/add_meterial_usage">

                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms">
                       <div class="form-title">
								<h4>Basic Information </h4>
						</div>
                        <div class="form-body form-horizontal">
                            <? if($prjlist){?>
                    <div class="form-group">
                    <div class="col-sm-3 ">
                      <select class="form-control" onchange="loadcurrent_projects(this.value)" placeholder="Qick Search.."  <? if(! check_access('all_branch')){?> disabled <? }?>  id="branch_code" name="branch_code" >
                      <option value="">Search here..</option>
                      <?    foreach($branchlist as $row){?>
                      <option value="<?=$row->branch_code?>" <? if($row->branch_code==$this->session->userdata('branchid')){?> selected<? }?>><?=$row->branch_name?></option>
                      <? }?>
                      </select>
                    </div>
                    <div class="col-sm-3 " id="prjlist">
                      <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Project Name</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
                     </select>
                   </div>
                     <div class="col-sm-3 " id="blocklist"></div>
									 </div><? }?></div><!-- load by js -->
											<div class="form-body form-horizontal">

												<div class="form-group">

													<div class="col-md-9 " id="tasklist"><!-- load by js according to block (task_table.php)--></div>
												</div>
												<div class="form-group">

													<div class="col-md-9 " id="matlist"><!-- load by js according to task (boq_mat_list.php)--></div>
												</div>
											</div>

											<div role="tabpanel" class="tab-pane fade <? if($tab==''){?> active in <? }?>" id="profile" aria-labelledby="profile-tab">




                       <div id="fulldata" class="fulldata" style="min-height:100px;">
												 <!-- load by js according to task (boq_mat_table.php)-->
                       </div>

										 </div>
										 <div role="tabpanel" class="tab-pane fade  <? if($tab=='view_usage'){?> active in <? }?> " id="view_usage" aria-labelledby="view_usage-tab">
			                       <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

															 <div id="fullview" class="fullview" style="min-height:100px;">
																 <!-- load by js according to task (boq_mat_table.php)-->
				                       </div>
														 </div>


			              </div>

									 </div>
										 <hr>

				</form></p>
                </div>

              <!--METERIAL LIST CONFIRMVIEW-->
                <div role="tabpanel" class="tab-pane fade  <? if($tab=='list'){?> active in <? }?> " id="list" aria-labelledby="list-tab">
                       <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                        </div>

              </div>
                    <!--METERIAL LIST CONFIRM VIEW-->
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
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
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
                    window.location="<?=base_url()?>hm/reservation/delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
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

                    window.location="<?=base_url()?>hm/reservation/confirm/"+document.deletekeyform.deletekey.value;
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
