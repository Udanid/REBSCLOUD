
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
		$("#letter_type").focus(function() {
			$("#letter_type").chosen({
				allow_single_deselect : true
			});
		});
		$("#prj_id").focus(function() {
			$("#prj_id").chosen({
				allow_single_deselect : true
			});
		});


	});
	function call_delete(id)
	{
		 document.deletekeyform.deletekey.value=id;
		 $('#complexConfirm').click();
	}
	function view_print(id)
	{
		var winPrint = window.open(id, '', 'left=0,top=0,width=800,height=600,toolbar=0,scrollbars=0,status=0');

winPrint.document.close();
winPrint.focus();
winPrint.print();
winPrint.close();
	}

	function loadcurrent_block(id)
	{
		if(id!=""){
			$( "#fulldata").html("");
			$('#blocklist').delay(1).fadeIn(600);
			document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
			$( "#blocklist" ).load( "<?=base_url()?>re/cus_hand_overdocs/get_blocklist/"+id );


		}
		else
		{
			$('#blocklist').delay(1).fadeOut(600);

		}
	}
	function loadcurrent_cuslist(id)
	{
		if(id!=""){
			console.log(id);
			$( "#fulldata").html( "");
			$('#cuslist').delay(1).fadeIn(600);
			document.getElementById("cuslist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
			$( "#cuslist" ).load( "<?=base_url()?>re/cus_hand_overdocs/get_reslist/"+id );


		}
		else
		{
			$('#cuslist').delay(1).fadeOut(600);

		}
	}

	function load_fulldetails(id)
	{
		if(id!="")
		{
			var prj_id= document.getElementById("prj_id").value;
			var lot_id= document.getElementById("lot_id").value
			$('#fulldata').delay(1).fadeIn(600);
			document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
			$( "#fulldata").load( "<?=base_url()?>re/cus_hand_overdocs/get_docsfulldata/"+id+"/"+"/"+lot_id+"/"+prj_id );
			$("#submit_btn").show();
		}
	}
	function load_fulldetails_popup(prj_id,lot_id)
	{

		// var prj_id= document.getElementById("prj_id").value



		$( "#popupform").load( "<?=base_url()?>re/deedtransfer/get_fulldata_popup/"+lot_id+"/"+prj_id );
		$('#popupform').delay(1).fadeIn(600);

	}
</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div class="table">



			<h3 class="title1">Customer Hand Over Docs</h3>

			<div class="widget-shadow">
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Upload Docs</a></li>

				</ul>
				<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;min-height:400px;">
					<? $this->load->view("includes/flashmessage");?>

					<div role="tabpanel" class="tab-pane fade active in " id="profile" aria-labelledby="profile-tab">
						<p>

							<div class="row">
								<div class=" widget-shadow" data-example-id="basic-forms">
									<div class="form-title">
										<h4>Block Infomation </h4>
									</div>
									<form data-toggle="validator"  method="post" action="<?=base_url()?>re/cus_hand_overdocs/add" enctype="multipart/form-data">

										<div class="form-body form-horizontal">
											<? if($prjlist){?>
												<div class="form-group">

													<div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
														<option value="">Project Name</option>
														<?    foreach($prjlist as $row){?>
															<option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
														<? }?>

													</select> </div>
													<div class="col-sm-3 " id="blocklist">   </div>
													<div class="col-sm-3 " id="cuslist">   </div>
												</div><? }?>



												<div id="fulldata" style="min-height:100px;"></div>

												<div class="form-group  validation-grids" id="submit_btn" style="float:right;display:none;">
													<!-- <input type="submit" class="btn btn-primary"  value="submit" name="submit"> -->
													<button type="submit" class="btn btn-primary disabled" >Upload</button>
												</div>
												<div class="clearfix"> </div>
											</div>
										</form>
									</div></div>
								</p>
							</div>
							<div role="tabpanel" class="tab-pane fade " id="settlment" aria-labelledby="settlment-tab">
								<p>
									<div class="row">
										<div class=" widget-shadow" data-example-id="basic-forms">

											<br>
											</div></div>
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
												<div class="modal-body" id="checkflagmessage">
												</div>
											</div>
										</div>
									</div>
								</div>
								<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_advdelete" name="complexConfirm_advdelete"  value="DELETE"></button>

								<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_deed" name="complexConfirm_confirm_deed"  value="DELETE"></button>

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
										window.location="<?=base_url()?>re/cus_hand_overdocs/delete/"+document.deletekeyform.deletekey.value;
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
