
<!DOCTYPE HTML>
<html>
<head>

	<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_notsearch");
	?>
	<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
	<script type="text/javascript">

	function call_delete(id)
	{
		document.deletekeyform.deletekey.value=id;
		$('#complexConfirm').click();

	}
	function pop_upwindow(id,action)
	{

		$('#popupform').delay(1).fadeIn(600);
		$( "#popupform" ).load( "<?=base_url()?>accounts/purchase/edit_view/"+id+"/"+action );

	}
	function close_edit(id)
	{
			$('#popupform').delay(1).fadeOut(800);
	}


</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div class="table">



			<h3 class="title1">New Purchase Item</h3>

			<div class="widget-shadow">
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Purchase Item List</a></li>

				</ul>
				<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
					<? $this->load->view("includes/flashmessage");?>

						<div role="tabpanel" class="tab-pane fade active in" id="list" aria-labelledby="list-tab">
							<p>
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">

									</div>



									<div class="clearfix"> </div>

									<div class=" widget-shadow" data-example-id="basic-forms">
										<div class="form-title">
											<h4>Purchase Order  List  </h4>
										</div>
										<br>
										<table class="table table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Supplier</th>
												<th>Date</th>
												<th>Type</th>
												<th>Total Amount</th>
												<th>Statues</th>
												<th>Added By</th>
												<th>Details</th>
											</tr>
										</thead>
											<? if($list){$c =0;
												foreach($list as $row){?>

													<tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">

														<td><?=$row->purchase_number?></td>
														<td><?=$row->first_name?> <?=$row->last_name?></td>
														<td><?=$row->purchase_date?></td>
														<td><? if($row->purchase_type=='P'){
												      echo "Project";
												     }elseif($row->purchase_type=='F'){
												      echo "Fixed Asset";
												    }elseif($row->purchase_type=='O'){
												      echo "Other";
												    }?></td>
														<td class="text-right"><?=number_format($row->tot_price,2)?></td>
														<td><?=$row->statues ?></td>
														<td><?=$row->added_by ?></td>

														<td>
															<a  href="javascript:pop_upwindow('<?=$row->purchase_id?>','view')" title="view"><i class="fa fa-eye nav_icon icon_blue"></i></a>
															<? if($row->statues=='PENDING'){?>
															<a  href="javascript:pop_upwindow('<?=$row->purchase_id?>','approve')" title="approve"><i class="fa fa-check nav_icon icon_green"></i></a>
															<a  href="javascript:pop_upwindow('<?=$row->purchase_id?>','edit')" title="edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
															<a  href="javascript:call_delete('<?=$row->purchase_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
														<? }?>
														</td>

													</tr>

												<? }} ?>
											</tbody></table> </div></div>
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
								window.location="<?=base_url()?>accounts/purchase/delete_purchase/"+document.deletekeyform.deletekey.value;
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

								window.location="<?=base_url()?>accounts/invoice/confirm_invoice/"+document.deletekeyform.deletekey.value;
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
