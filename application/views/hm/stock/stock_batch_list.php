<!DOCTYPE HTML>
<html>
<head>

	<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_notsearch");
	?>
	<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){


		$( function() {
				$( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
			} );
	});

	$(document).on('click','table td .deleterow', function() {//change .live to .on
	$(this).parent().parent().remove();
	window.total_cal();

});

	function load_item_list()
	{

		$('#dataview').html('');
		$( "#dataview" ).load( "<?=base_url()?>hm/hm_stockdispatch/get_dataset");
	}
	function loadcurrent_block(id)
	{
	 load_item_list();
	 if(id!=""){

								 $('#blocklist').delay(1).fadeIn(600);
	    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
						$( "#blocklist" ).load( "<?=base_url()?>hm/lotdata/get_blocklist/"+id);

						//get task list
						$('#tasklist').delay(1).fadeIn(600);
							 document.getElementById("tasklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
			 $( "#tasklist" ).load( "<?=base_url()?>hm/hm_stockusage/get_tasklist/"+id );

	 }
	 else
	 {
		 $('#blocklist').delay(1).fadeOut(600);

	 }

	 $('#lot_id').prop("required",false);


	}


	function call_confirm(id)
	{
		 document.deletekeyform.deletekey.value=id;
		$.ajax({
	            cache: false,
	            type: 'GET',
	            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
	            data: {table: 'hm_sitestock', id: id,fieldname:'site_stockid' },
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

	function call_delete(id)
	{
		document.deletekeyform.deletekey.value=id;
	 $.ajax({
						 cache: false,
						 type: 'GET',
						 url: '<?php echo base_url().'common/activeflag_cheker/';?>',
						 data: {table: 'hm_sitestock', id: id,fieldname:'site_stockid' },
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
	}
</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div class="table">



			<h3 class="title1">Stock Dispatch</h3>

			<div class="widget-shadow">
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active" ><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">New stock batch</a></li>

					<li role="presentation" ><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Stock List</a></li>


				</ul>
				<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;min-height:450px;">
					<? $this->load->view("includes/flashmessage");?>

					<div role="tabpanel" class="tab-pane fade active in" id="list" aria-labelledby="list-tab">
						<p>
							<form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_stockdispatch/add_dispatch">
							<div class="row">
								<div class=" widget-shadow" data-example-id="basic-forms">

								</div>



								<div class="clearfix"> </div>

								<div class=" widget-shadow" data-example-id="basic-forms">
									<div class="form-title">
										<h4>Stock Dispatch</h4>
									</div>
									<br>
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
														<option value="">To Project</option>
														<?    foreach($prjlist as $row){?>
															<option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
														<? }?>
													</select>
												</div>

												<div class="col-sm-3 " id="blocklist"></div>


														</div>

							 <? }?>




											</div>
											<div id="dataview">
											</div>

										</div>
									</form>
										</div>
									</p>
									</div>

									<div role="tabpanel" class="tab-pane fade  " id="profile" aria-labelledby="profile-tab">

											<table class="table">
												<tr>
													<th></th>
													<th>Project Name</th>
													<th>Material</th>
													<th>Date</th>
													<th>Quantity</th>
													<th>Unit Price</th>
													<th>Statues</th>
													<th></th>
												<tr>
													<?
													if($tranfer_list)
													{	$n=0;
														foreach ($tranfer_list as $key => $value) {
															$n=$n+1;
															$mat_data=get_meterials_all($value->mat_id);
										          //print_r($mat_data);
										          $mat_name=$mat_data->mat_name;
															$mt_name=$mat_data->mt_name;
															?>
															<tr>
																<td><?=$n?>--<?=$value->stock_id;?></td>
																<td><?=get_prjname($value->prj_id)?></td>
																<td><?=$mat_name?></td>
																<td><?=$value->rcv_date?></td>
																<td><?=$value->rcv_qty?>&nbsp; <?=$mt_name?></td>
																<td><?=$value->price?></td>
																<td><?=$value->status?></td>
																<td>
																<? if($value->status=='PENDING'){?>
								                                     <a  href="javascript:call_confirm('<?=$value->site_stockid?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
								                                     <a  href="javascript:call_delete('<?=$value->site_stockid?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
								                               <? }?>
																						 </td>

															<tr>
													<?	}
													}

													?>
											</table>
											<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
										</div>
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


						<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
						<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
						<form name="deletekeyform" >  <input name="deletekey" id="deletekey" value="0" type="hidden">
						</form>
						<script>
						$("#complexConfirm").confirm({
							title:"Delete confirmation",
							text: "Are You sure you want to delete this ?" ,
							headerClass:"modal-header",
							confirm: function(button) {
								button.fadeOut(2000).fadeIn(2000);
								var code=1
								window.location="<?=base_url()?>hm/hm_stockdispatch/delete_stock_tranfer/"+document.deletekeyform.deletekey.value;
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

								window.location="<?=base_url()?>hm/hm_stockdispatch/confirm_stock_tranfer/"+document.deletekeyform.deletekey.value;
							},
							cancel: function(button) {
								button.fadeOut(2000).fadeIn(2000);
								// alert("You aborted the operation.");
							},
							confirmButton: "Yes I am",
							cancelButton: "No"
						});
						function call_delete(id)
						{
							//alert(id)
							$('#deletekey').val(id);
							//document.deletekeyform.deletekey.value=id;

							$('#complexConfirm').click();

						}

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
				<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
