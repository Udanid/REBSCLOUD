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
	  	$("#boqcat_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select A Design Type"
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
            data: {table: 'hm_config_boqsubcat', id: id,fieldname:'boqsubcat_id' },
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
            data: {table: 'hm_config_boqsubcat', id: id,fieldname:'boqsubcat_id' },
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
					$( "#popupform" ).load( "<?=base_url()?>hm/hm_boqconfig/edit_subboq/"+id );
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
            data: {table: 'hm_config_boqsubcat', id: id,fieldname:'boqsubcat_id' },
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
function runScript(e,val) {
		//detect enter key and run the function
		if (e.keyCode == 13) {
			var tb = document.getElementById("search");
			//eval(tb.value);
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'hm/hm_boqconfig/search_subboq';?>',
				data: {string:val },
				success: function(data) {
					$("#subboqdata").html('');
					$("#subboqdata").html(data);
				}
			});
		}
	}
</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">BOQ Sub Category</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
          	<li role="presentation"><a href="<?=base_url()?>hm/hm_boqconfig/config_boq" id="home-tab" role="tab" aria-controls="home" aria-expanded="false">Boq Category</a></li>
          <li role="presentation" class="active"><a href="<?=base_url()?>hm/hm_boqconfig/config_subboq" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">Boq Sub Category</a></li>
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
                        <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_boqconfig/add_subboq" id="mytestform">

                    <div class="form-title"> Add New Task

							</div>
						<div class="col-md-6 validation-grids " data-example-id="basic-forms">
							<div class="form-body">
								<label>Design Type</label>
								<div class="form-group">
									<select class="form-control design_id" name="design_id" id="design_id" required>
										<? if($designs){?>
											<option value=""></option>
											<? foreach ($designs as $rw){?>
												<option value="<?=$rw->design_id?>"><?=$rw->short_code?> - <?=$rw->design_name?></option>
											<? }?>
											<? }?>
										</select>

								</div>
								  <label>BOQ Sub Category Name</label>
									<div class="form-group">
                    <input type="text" name="subcat_name" id="subcat_name" class="form-control" required>
									</div>





							</div>
						</div>
						<div class="col-md-6 validation-grids " data-example-id="basic-forms">
							<div class="form-body">
								<label>BOQ Main Category</label>
								<div class="form-group">
									<select class="form-control" name="boqcat_id" id="boqcat_id" required>
										<option ></option>

									</select>

								</div>
								<label>BOQ Sub Category Code</label>
								<div class="form-group">
									<input type="text" name="subcat_code" id="subcat_code" class="form-control" required>
								</div>

								<div class="form-group">
				                  <button type="submit" class="btn btn-primary disabled">Sumbit</button>
				                </div>

								</div>
							</div>
					</form></div>
                        <table class="table"> <thead> <tr>
													<th>No</th>
													<th>Design Type</th>
													<th>BOQ Category Name</th>
													<th>BOQ Sub Category Code</th>
													<th>BOQ Sub Category Name</th>

												</tr>
												<tr>
													<th colspan="6">
														<div class="search">
															<span class="fa fa-search"></span>
															<input type="text" name="search" id="search" class="form-control" autocomplete="off" onkeypress="return runScript(event,this.value)" placeholder="Sub BOQ Category , BOQ Category or Design" style="width: 40%;" required>
														</div>
													</th>
												</tr>
											 </thead>
											 <tbody id="subboqdata">
											<? if($datalist){$c=0;
                          foreach($datalist as $row){?>

                         <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <td scope="row"><?=$c?></td>
												<td><?=$row->short_code?> - <?=$row->design_name?></td>
												<td><?=$row->cat_name?></td>
												<td><?=$row->subcat_code?></td>
												<td><?=$row->subcat_name?> </td>


                        <td align="right"><? $statues=check_foreign_key('hm_config_boqtask',$row->boqsubcat_id,'boqsubcat_id');//call from hmconfig_helper
                        if($statues){?>
													<a  href="javascript:call_delete('<?=$row->boqsubcat_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
													<a  href="javascript:check_activeflag('<?=$row->boqsubcat_id?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>

										<? }?>

                        </td>
                         </tr>

                                <? }} ?>
                          </tbody></table>
													<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>
                  </div>
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab">

                    <p>
                    </p>
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
                    window.location="<?=base_url()?>hm/hm_boqconfig/boq_subdelete/"+document.deletekeyform.deletekey.value;
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
					subcat_name: {required: true},
					boqcat_id:{required: true},
					subcat_code:{required: true},
					design_id:{required: true},
				},
        messages: {
            subcat_name: "BOQ Sub Category Name Required",
						boqcat_id: "BOQ Category Required",
						subcat_code: "BOQ Sub Category Code Required",
						design_id:"Design Type Required",
        }
});
	$('#design_id').change(function(){

		var des_id=$('#design_id').val();
			$("#boqcat_id").chosen({
	       allow_single_deselect : false
	    });
		$('#boqcat_id').find('option').remove();
		$('#boqcat_id').append('<option value=""></option>');
		$('#boqcat_id').trigger("chosen:updated");
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
						$('#boqcat_id').find('option').remove();
						$('#boqcat_id').append('<option value=""></option>');
						$('#boqcat_id').trigger("chosen:updated");
					}
							}
					});
	});


	});
</script>
