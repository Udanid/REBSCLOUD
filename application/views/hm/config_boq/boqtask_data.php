<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
function activatechosen(){
	setTimeout(function(){
		$("#task_id").chosen({
			allow_single_deselect : true,
		search_contains: true,
		no_results_text: "Oops, nothing found!",
		placeholder_text_single: "Select a Task"
		});
		$("#boqsubcat_id").chosen({
			allow_single_deselect : true,
		search_contains: true,
		no_results_text: "Oops, nothing found!",
		placeholder_text_single: "Select a Sub Category"
		});

	 	$.ajaxSetup ({
    	// Disable caching of AJAX responses
    		cache: false
		});
	}, 800);
}
var deleteid="";
function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_config_boqtask', id: id,fieldname:'boqtask_id' },
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
function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_config_boqtask', id: id,fieldname:'boqtask_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#mylistkkk').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>hm/hm_boqconfig/edit_boqtask/"+id );
				}
            }
        });
}
function close_edit(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'hm_config_boqtask', id: id,fieldname:'boqtask_id' },
            success: function(data) {
                if (data) {
					 $('#popupform').delay(1).fadeOut(800);

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					 document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
					 $('#mylistkkk').click();

				}
            }
        });
}

function calcamount()
{
	var qty=0;
	var rate=0;
	if($('#qty').val()>0){
		qty=$('#qty').val();
	}
	if($('#rate').val()>0){
		rate=$('#rate').val();
	}
	var amt=qty*rate;
	$('#amount').val(amt);
}
function add_services(id)
{
	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>hm/hm_boqconfig/add_taskser_view/"+id );
}
function add_matireal(id)
{
	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>hm/hm_boqconfig/add_taskmat_view/"+id );
}
function view_data(val_id)
{
	//$("tr[class*='name_'],tr[class*='subname_'],tr[class*='data_'],tr[class*='total']").hide();
//alert("ll")
	// $(".name_"+val_id).show();
	// $(".subname_"+val_id).show();
	// $(".data_"+val_id).show();
	// $(".total"+val_id).show();

	if ($(".name_"+val_id).is(':visible')) { $(".name_"+val_id).hide();}else{
		$(".name_"+val_id).show();
	}
	if ($(".subname_"+val_id).is(':visible')) { $(".subname_"+val_id).hide();}else{
		$(".subname_"+val_id).show();
	}
	if ($(".data_"+val_id).is(':visible')) { $(".data_"+val_id).hide();}else{
		$(".data_"+val_id).show();
	}
	if ($(".total_"+val_id).is(':visible')) { $(".total_"+val_id).hide();}else{
		$(".total_"+val_id).show();
	 }

	 if ($(".total_total_"+val_id).is(':visible')) { $(".total_total_"+val_id).hide();}else{
 		$(".total_total_"+val_id).show();
 	 }

}
$(function(){
  $("#boqcat_id").focus(function() {
  	$("#boqcat_id").chosen({
       allow_single_deselect : true
    });
  });
	  $(".design_id").focus(function() {
	  	$(".design_id").chosen({
	       allow_single_deselect : true
	    });
	  });
});
</script>
<script type="text/javascript">
jQuery(document).ready(function() {
	$('#task_id').change(function(){
			var selected = $('#task_id').find('option:selected');
         var taskval = selected.data('des');
			$("#description").val(taskval)

		});
	});


</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">BOQ Task Config</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">BOQ Task List</a></li>
          <li role="presentation"><a href="#profile" id="profile-tab" role="tab" onClick="activatechosen()" data-toggle="tab" aria-controls="profile" aria-expanded="false">New BOQ Task</a></li>
         </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
               <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
               <br>
              <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>

                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                        <table class="table"> <thead> <tr>
													<th>No</th>
													<th>Description</th>
													<th>Qty</th>
													<th>Unit</th>
													<th>Rate</th>
													<th>Amount</th>
													<th></th>
												</tr> </thead>
												<tbody>
													<? if($design_type){
														foreach ($design_type as $key2 => $value2) {
															$statues=check_foreign_key('hm_prjaclotdata',$value2->design_id,'design_id');
															//echo $statues; echo $row->boqtask_id;
															?>

															<tr class="danger" id="<?=$value2->design_id?>"><th colspan="6"> Design Type <?=$value2->short_code?> - <?=$value2->design_name?>
																<th align="right">
																	<a href="javascript:view_data('<?=$value2->design_id?>')" title="View Data"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

																</th>

															</th></tr>
											<? if($sub_cat_data_boq[$value2->design_id]){$c=0;
												$tot_total=0;
                          foreach($sub_cat_data_boq[$value2->design_id] as $row){
														$c++;
														$tot=0;
														?>

														<tr class="warning name_<?=$value2->design_id?>" style="display:none"><th colspan="7"><?=$c?> - <?=$row->cat_name?></th></tr>
														<tr class="success subname_<?=$value2->design_id?>" style="display:none"><th colspan="7"><?=$row->subcat_name?></th></tr>

														<? if($datalist){ $n=0;
															foreach ($datalist[$row->boqsubcat_id] as $key => $value) {
																$n++;
																$tot=$tot+$value->amount;
																$tot_total=$tot_total+$tot;
																?>
															<tr style="display:none" class="data_<?=$value2->design_id?>">	<td scope="row"><?=$c?>.<?=$n?></td>
																<td><?=$value->description?></td>
																<td><?=$value->qty?></td>
																<td><?=$value->unit?></td>
																<td align="right"><?=$value->rate?></td>
																<td align="right"><?=number_format($value->amount,2)?></td>

				                        <td align="right"><?
																if($statues){?>
																	<a  href="javascript:call_delete('<?=$value->boqtask_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
																	<a  href="javascript:check_activeflag('<?=$value->boqtask_id?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>

														<? }?>
														<a  href="javascript:add_services('<?=$value->boqtask_id?>')" title="View Servies"><i class="fa fa-list nav_icon icon_green"></i></a>
														<a  href="javascript:add_matireal('<?=$value->boqtask_id?>')" title="View Material"><i class="fa fa-cubes nav_icon icon_red"></i></a>

				                        </td>
				                         </tr>
														<?	} ?>
														<tr class="info total_<?=$value2->design_id?>" style="display:none"><th colspan="6">Sub total carried out to summary</th><th><?=number_format($tot,2)?></th></tr>
														<tr class="total_<?=$value2->design_id?>" style="display:none"><th colspan="6"></th><th></th></tr>
													<?	} }?>
													<tr class="info total_total_<?=$value2->design_id?>" style="display:none"><th colspan="6">Total</th><th><?=number_format($tot_total,2)?></th></tr>
													<tr class="total_total_<?=$value2->design_id?>" rowspan="2" style="display:none"><th colspan="6"></th><th></th></tr>
													<tr><th colspan="6"></th><th></th></tr>
												<? }} }?>

                          </tbody></table>

                    </div>
                  </div>
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab">

                    <p>
                    <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_boqconfig/add_boqtask" id="mytestform">

                    <div class="form-title"> Add New BOQ Task

							</div>
						<div class="col-md-6 validation-grids " data-example-id="basic-forms">
							<div class="form-body">
								<label>Design Type</label>
								<div class="form-group">
									<select class="form-control design_id" name="design_id" id="design_id" required>
										<? if($design_type){?>
											<option value=""></option>
											<? foreach ($design_type as $rw){?>
												<option value="<?=$rw->design_id?>"><?=$rw->short_code?> - <?=$rw->design_name?></option>
											<? }?>
											<? }?>
										</select>

								</div>
								<label>BOQ Main Category</label>
								<div class="form-group">
									<select class="form-control" name="boqcat_id" id="boqcat_id" required>
										<option ></option>

									</select>

								</div>
								  <label>Sub Category</label>
									<div class="form-group">
                    <select name="boqsubcat_id" id="boqsubcat_id" class="form-control" required>
											<option value=""></option>

										</select>

									</div>
									<label>Task </label>
									<div class="form-group">
                    <select  name="task_id" id="task_id" class="form-control" required>
											<option value=""></option>
											<? if($hmtask){
												foreach ($hmtask as $key => $rw) {?>
													<option value="<?=$rw->task_id?>" data-des="<?=$rw->task_name?>"><?=$rw->task_code?> - <?=$rw->task_name?></option>
											<?	}
											}?>
										</select>
									</div>

									<label>Description</label>
									<div class="form-group">
										<textarea type="text" name="description" id="description"   class="form-control" required></textarea>

									</div>



                  <div class="form-group">
                    <button type="submit" class="btn btn-primary disabled">Sumbit</button>
                  </div>

							</div>
						</div>
						<div class="col-md-4 validation-grids " data-example-id="basic-forms">
							<div class="form-body">
								<label>Unit</label>
								<div class="form-group">
									<input type="text" name="unit" id="unit" class="form-control" required>

								</div>

									<label>Quantity</label>
									<div class="form-group">
										<input type="number" step="0.01" name="qty" id="qty" class="form-control" required onchange="calcamount()">

									</div>

									<label>Rate</label>
									<div class="form-group">
										<input type="number" step="0.01" name="rate" id="rate" class="form-control" required onchange="calcamount()">

									</div>
									<label>Amount</label>
									<div class="form-group">
										<input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
									</div>
								</div>
							</div>
					</form></div></p>
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
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>hm/hm_boqconfig/task_boqdelete/"+document.deletekeyform.deletekey.value;
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

<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script  type="text/javascript">
	jQuery(document).ready(function() {

	//validate all fields
  	//$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
		$.validator.setDefaults({ignore: [] });
		$("#mytestform").validate({
			rules: {
					boqcat_id:{required: true},
					design_id:{required: true},
					boqsubcat_id: {required: true},
					description:{required: true},
					unit:{required: true},
					amount:{required: true},
					task_id:{required: true},
					qty:{required: true},
					rate:{required: true},
				},
        messages: {
						boqcat_id:"Required",
						design_id:"Required",
            boqsubcat_id: "Required",
						description: "Required",
						unit: "Required",
						amount: "Required",
						task_id:"Required",
						qty:"Required",
						rate:"Required",
        }
});
$('#design_id').change(function(){

	var des_id=$('#design_id').val();
		$("#boqcat_id").chosen({
			 allow_single_deselect : false
		});
	$('#boqcat_id').find('option').remove();
	$('#boqcat_id').append('<option value=""></option>');
	$.ajax({
						cache: false,
						type: 'POST',
						url: '<?php echo base_url().'hm/hm_boqconfig/get_main_boqtask_bydesign';?>',
						data: {des_id:des_id},
						dataType: "json",
						success: function(data) {

								if (data) {

									jQuery.each(data, function(index, item) {

										$('#boqcat_id').append('<option value="'+item.boqcat_id+'">'+item.cat_name+'</option>');
									});
									$('#boqcat_id').trigger("chosen:updated");
								}
				else
				{
					//$('#complexConfirm').click();
				}
						}
				});
});

$('#boqcat_id').change(function(){

	var boq_id=$('#boqcat_id').val();
		$("#boqsubcat_id").chosen({
			 allow_single_deselect : false
		});
	$('#boqsubcat_id').find('option').remove();
	$('#boqsubcat_id').append('<option value=""></option>');
	$.ajax({
						cache: false,
						type: 'POST',
						url: '<?php echo base_url().'hm/hm_boqconfig/get_sub_boqtask_bydesign';?>',
						data: {boq_id:boq_id},
						dataType: "json",
						success: function(data) {
							//alert(data)
								if (data) {

									jQuery.each(data, function(index, item) {

										$('#boqsubcat_id').append('<option value="'+item.boqsubcat_id+'">'+item.subcat_code+' -'+item.subcat_name+'</option>');

									});
									$('#boqsubcat_id').trigger("chosen:updated");
								}
				else
				{
					//$('#complexConfirm').click();
				}
						}
				});
});



	});
</script>
