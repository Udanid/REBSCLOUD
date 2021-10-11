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
        $("#supplier_id").chosen({
           allow_single_deselect : true
         });
		
        
/////////////////////////////////////////////////////////////////////////////////////////////
$("#searchkey").keyup(function(event) { 
            if (event.keyCode === 13) { 
                var searchvalue = $("#searchkey").val();
                find_key_related_data(searchvalue);
            } 
}); 

   function find_key_related_data(searchvalue){
   var keyvalue = "";
   console.log(searchvalue)
   if(searchvalue==""){
     var keyvalue = 0;
   }else{
     var keyvalue = searchvalue;
   }
   $('#polistdiv').delay(1).fadeIn(600);
   $('#polistdiv').html('');
    console.log("<?=base_url()?>hm/hm_purchase_orders/get_data_by_keyword/"+keyvalue)
   $('#polistdiv').load("<?=base_url()?>hm/hm_purchase_orders/get_data_by_keyword/"+keyvalue);

}
///////////////////////////////////////////////////////////////////////////////////////////// 

		$( function() {
				$( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
			} );
	});

	$(document).on('click','table td .deleterow', function() {//change .live to .on
	$(this).parent().parent().remove();
	window.total_cal();

});



	function pop_upwindow(id,action)
	{

		$('#popupform').delay(1).fadeIn(600);
		$( "#popupform" ).load( "<?=base_url()?>hm/hm_purchase_orders/edit_view/"+id+"/"+action );

	}
	function close_edit(id)
	{
			$('#popupform').delay(1).fadeOut(800);
	}

	function load_item_list(sup_id)
	{
		$('#dataview').html('');
		$( "#dataview" ).load( "<?=base_url()?>hm/hm_purchase_orders/get_suplier_orders/"+sup_id);
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
					<li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Purchase Order</a></li>

					<li role="presentation" ><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Purchase Item List</a></li>

				</ul>
				<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
					<? $this->load->view("includes/flashmessage");?>

						<div role="tabpanel" class="tab-pane fade" id="list" aria-labelledby="list-tab">
							<p>
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">

									</div>



									<div class="clearfix"> </div>

									<div class=" widget-shadow" data-example-id="basic-forms">
										<div class="form-title">
											<h4>Purchase Order  List  </h4>
										</div>
										  <div class="search col-md-3">
					                       <span class="fa fa-search"></span>
					                       <input type="text" id="searchkey" class="form-control" placeholder="Supplier,Date or PO number">
					                      </div>
										<br><br>
										<table class="table table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Supplier</th>
												<th>Date</th>
												<th>Total Items</th>
												<th>Total Amount</th>
												<th>Statues</th>
												<th>Added By</th>
											</tr>
										</thead>
										<tbody id="polistdiv"> 
										
										<? if($list){$c =0;
											foreach($list as $row){?>
                                                  <tr>
												    <td><?=$row->po_code?></td>
													<td><?=$row->first_name?> <?=$row->last_name?></td>
													<td><?=$row->send_date?></td>
													<td><?=$row->tot_items?></td>
													<td class="text-right"><?=number_format($row->tot_price,2)?></td>
													<td><?=$row->create_by ?></td>

													<td>
														<a  href="javascript:pop_upwindow('<?=$row->poid?>','view')" title="view"><i class="fa fa-eye nav_icon icon_blue"></i></a>
														<? if($row->status=='PENDING'){?>
														<a  href="javascript:pop_upwindow('<?=$row->poid?>','approve')" title="approve"><i class="fa fa-check nav_icon icon_green"></i></a>
														<a  href="javascript:pop_upwindow('<?=$row->poid?>','edit')" title="edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
														<a  href="javascript:call_delete('<?=$row->poid?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
													<? }?>
													</td>

												</tr>

											<? }} ?>

											</tbody></table> </div></div>
										</p>
									</div>
									<div role="tabpanel" class="tab-pane fade  active in" id="profile" aria-labelledby="profile-tab">
										<p>


											<form data-toggle="validator" id="purchase" method="post" action="<?=base_url()?>hm/hm_purchase_orders/add_purchase" enctype="multipart/form-data">
												<div class="row">
													<div class=" widget-shadow" data-example-id="basic-forms">
														<div class="form-title">
															<h4>New Purchase Order</h4>
														</div>
														<div class="form-body form-horizontal">
														<div class="form-group">
															<label class=" control-label col-sm-3 " > Purchase Number</label>
																<div class="col-sm-3 ">
															<input type='text' class='form-control' style="text-align:left;" value="PO-<?=$newponumber?>" readonly="readonly">
															<input type='hidden' class='form-control' id='number'    name='number' style="text-align:left;" value="<?=$newponumber?>" required readonly="readonly">
													 </div>
															<!-- <label class=" control-label col-sm-3 " > Purchase Type</label>
																 <div class="col-sm-3 ">
																<select name="type" id="type" class="form-control"required="required" onChange="load_fixed_assetlist(this.value)"  >
																<option value="">Type</option>
																 <option value="P"> Project</option>
																 <option value="F"> Fixed Asset</option>
																	<option value="O"> Other</option>

																</select>
															</div> -->
														</div>
														<div class="form-group">
																<label class=" control-label col-sm-3 " >Supplier Name</label>
																	 <div class="col-sm-3 ">
																<select name='supplier_id' id='supplier_id' class='form-control' required='required' onChange="load_item_list(this.value)">
																 <option value=''> Select Supplier</option ><? if($suplist){foreach($suplist as $dataraw){?>
																 <option value='<?=$dataraw->sup_code?>'><?=$dataraw->first_name?> - <?=$dataraw->last_name?></option><? }}?></select>
															 </div>

																 <label class=" control-label col-sm-3 " > Send Date</label>
				 													 <div class="col-sm-3 ">
																 <input type='text' class='form-control date' id='date'    name='date' required='required'>
															</div>
															</div>
															<div id="dataview">


															</div>
																	<div ><button type="submit" class="btn btn-primary disabled pull-right" >Add Purchase Order</button>
																	</br></br></br></div>
																	</div>
																</div>
																</div>
															</form>
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
								window.location="<?=base_url()?>hm/hm_purchase_orders/delete_purchase/"+$('#deletekey').val();
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

								window.location="<?=base_url()?>hm/hm_purchase_orders/confirm_invoice/"+document.deletekeyform.deletekey.value;
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

			<script>
				$(document).ready(function () {
					//validate all fields
				  	$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });

				    $('#purchase').validate({ // initialize the plugin
							alert("PP")
				        rules: {
				            tot_un_price: {
				                required: true,
				                number: true,
												min:1
				            },

				        }
				    });

				});
				</script>
