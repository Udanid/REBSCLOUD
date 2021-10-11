
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
			// cal unit sum
			$('#purchase_table').on('change', '.quantity', function() {
				var price = $(this).closest('tr').find('.price').val();
				var quantity = $(this).closest('tr').find('.quantity').val();

				var tot_price=quantity*price;
				$(this).closest('tr').find('.tot_price').val(tot_price.toFixed(2));
				total_cal();

			});
			$('#purchase_table').on('change', '.price', function() {
				var price = $(this).closest('tr').find('.price').val();
				var quantity = $(this).closest('tr').find('.quantity').val();
				var tot_price=quantity*price;
				$(this).closest('tr').find('.tot_price').val(tot_price.toFixed(2));
				total_cal();
			});
			window.total_cal = function()
			{
				// cal total SUM
				var tot_p=0;
				var tot_q=0;
				var tot_p_q=0;
				$('.price').each(function()
				{
					var val = $.trim( $(this).val().replace(/,/g, "") );
					if ( val ) {
						tot_p=parseFloat(tot_p)+parseFloat(val);
					}
				});
				$('.quantity').each(function()
				{
					var val = $.trim( $(this).val().replace(/,/g, "") );
					if ( val ) {
						tot_q=parseFloat(tot_q)+parseFloat(val);
					}
				});
				$('.tot_price').each(function()
				{
					var val = $.trim( $(this).val().replace(/,/g, "") );
					if ( val ) {
						tot_p_q=parseFloat(tot_p_q)+parseFloat(val);
					}
				});
				$('#tot_un_price').val(tot_p.toFixed(2));
				$('#tot_quantity').val(tot_q);
				$('#tot_tot_price').val(tot_p_q.toFixed(2));
			}
			$( function() {
					$( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
				} );
    });

		$(document).on('click','table td .deleterow', function() {//change .live to .on
		$(this).parent().parent().remove();
		window.total_cal();

	});


</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div class="table">



			<h3 class="title1">New Purchase Order</h3>

			<div class="widget-shadow">
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Purchase Order</a></li>
					<li role="presentation" ><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Purchase Item List</a></li>

				</ul>
				<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
					<? $this->load->view("includes/flashmessage");?>

					<div role="tabpanel" class="tab-pane fade  active in" id="profile" aria-labelledby="profile-tab">
						<p>


							<form data-toggle="validator" method="post" action="<?=base_url()?>accounts/purchase/add_purchase" enctype="multipart/form-data">
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">
										<div class="form-title">
											<h4>New Purchase Order</h4>
										</div>
										<div class="form-body form-horizontal">
										<div class="form-group">
											<label class=" control-label col-sm-3 " > sadsadPurchase Number</label>
												<div class="col-sm-3 ">
											<input type='text' class='form-control' id='number' name='number'>
									 </div>
											<label class=" control-label col-sm-3 " > Purchase Type</label>
												 <div class="col-sm-3 ">
												<select name="type" id="type" class="form-control"required="required" onChange="load_fixed_assetlist(this.value)"  >
												<option value="">Type</option>
												 <option value="P"> Project</option>
												 <option value="F"> Fixed Asset</option>
													<option value="O"> Other</option>

												</select>
											</div>
										</div>
										<div class="form-group">
												<label class=" control-label col-sm-3 " >Supplier Name</label>
													 <div class="col-sm-3 ">
												<select name='supplier_id' id='supplier_id' class='form-control' required='required' >
												 <option value=''> Select Supplier</option ><? if($suplist){foreach($suplist as $dataraw){?>
												 <option value='<?=$dataraw->sup_code?>'><?=$dataraw->first_name?> - <?=$dataraw->last_name?></option><? }}?></select>
											 </div>

												 <label class=" control-label col-sm-3 " > Purchase Date</label>
 													 <div class="col-sm-3 ">
												 <input type='text' class='form-control date' id='date'    name='date' required='required'>
											</div>
											</div>
												<table class="tables" id="purchase_table">
													<thead>
													<tr>

														<th>Item Name</th>
														<th>Quantity</th>
														<th>Unit Price</th>
														<th>Total</th>
														<th ></th>
														<th ></th>
													</tr>
													</thead>
													<div class="form-body form-inline">
												<tbody>

													<tr>
														<td class='col-sm-6 name'><input type='text' class='form-control ' id='name' name='name[]'></td>
													<td class=''><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="quantity form-control" id="quantity" value="0" name="quantity[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
														<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>
													<td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="price form-control" value="0.00" id="price" name="price[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
														<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>

														<td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_price form-control" id="tot_price" value="0.00" name="tot_price[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
															<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>
														<td><img src='<?=base_url()?>images/icons/delete.png' border='0' alt='Remove row' class='deleterow'></td>
														<td><img src='<?=base_url()?>images/icons/add.png' border='0' alt='Add row' class='addrow'></td>

														</tr>

												</tbody>
												</div>

												</table>
											</hr></br></br>
												<table id="tot_table" border="2">
													<tr >
														<th class='col-sm-6 name'>Total</th>
													<th class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_quantity form-control" id="tot_quantity" value="0" name="tot_quantity" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
														<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>
													<th class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_un_price form-control" value="0.00" id="tot_un_price" name="tot_un_price" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
														<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>

														<th class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_tot_price form-control" id="tot_tot_price" value="0.00" name="tot_tot_price" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
															<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>
														</tr>
												</table>
												</br></br></br>
													<div ><button type="submit" class="btn btn-primary disabled pull-right" >Add Purchase Order</button>
													</br></br></br></div>
													</div>
												</div>
												</div>
										</div>
									</div>
								</form>
							</p>

						</div>
						<div role="tabpanel" class="tab-pane fade" id="list" aria-labelledby="list-tab">

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
								window.location="<?=base_url()?>accounts/invoice/delete_invoice/"+document.deletekeyform.deletekey.value;
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
						$(document).ready(function(){


						$(".addrow").click(function(){
		            $("#purchase_table tbody").append( '<tr><td class="col-sm-6 name"><input type="text" class="form-control" id="name" name="name[]"></td>'+
							'<td ><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="quantity form-control" id="quantity" value="0" name="quantity[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>'+
'<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>'+

								'<td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="price form-control" value="0.00" id="price" name="price[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>'+
'<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>'+

								'<td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_price form-control" id="tot_price" value="0.00" name="tot_price[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>'+
'<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>'+
								'<td><img src="<?=base_url()?>images/icons/delete.png" border="0" alt="Remove row" class="deleterow"></td></tr>');

		        });
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
