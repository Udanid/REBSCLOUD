<h4>Edit Subcontract Payment<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$pay_data->pay_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
<div class="row">
									 <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_subcontract/update_subcontract_payment" id="mytestform">

					 <div class="col-md-6 validation-grids " data-example-id="basic-forms">

						 <div class="form-body">
							 <label>Project : </label>
							 <div class="form-group">
								 <input type="text" name="prj_name" id="prj_name" class="form-control" value="<?=$pay_data->project_name?>" readonly>
									<input type="hidden" name="pay_id" id="pay_id" class="form-control" value="<?=$pay_data->pay_id?>">
							 </div>
							 <label>Service :</label>
							 <div class="form-group">
								 <input type="text" name="ser_name" id="ser_name" class="form-control" value="<?=$pay_data->service_name?>" readonly>
							 </div>
							 <label>Supplier :</label>
							 <div class="form-group">
								 <input type="text" name="sup_name" id="sup_name" class="form-control" value="<?=$pay_data->first_name.' '.$pay_data->last_name?>" readonly>
							 </div>

							 <label class=" control-label" >Stage</label>
							 <div class="form-group">
								 <input type="text" id="stage" name="stage" class="form-control" value="<?=$pay_data->payment_stage?>" required='required'>
							 </div>

							 <!-- percentage div start-->
							 <label class=" control-label" >Percentage</label>
							 <div class="form-group">
								 <input type="text" id="percentage" name="percentage" class="form-control" value="<?=$pay_data->persentage?>" required='required'>
							 </div>

								 <!-- stage div start-->
								 <label class=" control-label" >Pay Amount</label>
								 <div class="form-group">
									 <input type="number" step="0.01" id="amount" name="amount" class="form-control" value="<?=$pay_data->pay_amount?>" required='required'>
								 </div>

								 <!-- percentage div start-->
								 <label class=" control-label" >Pay Date</label>
								 <div class="form-group">
									 <input type="text" id="pay_date" name="pay_date" class="form-control pay_date" value="<?=$pay_data->pay_date?>" required='required'>
								 </div>


								<div class="bottom">

										 <div class="form-group">
											 <button type="submit" class="btn btn-primary ">Sumbit</button>
										 </div>
										 <div class="clearfix"> </div>
									 </div>




						 </div>
					 </div>




				 </form></div>
</div>
<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script  type="text/javascript">
 jQuery(document).ready(function() {
	 $( "#pay_date" ).datepicker({dateFormat: 'yy-mm-dd'});
//
//  //validate all fields
// 	 $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
// 	 $("#mytestform").validate({
// 		 rules: {
// 				 room_name: {required: true},
// 				 lenth:{required: true},
// 				 height:{required: true},
// 				 width:{required: true},
// 			 },
// 			 messages: {
// 					 room_name: "Required",
// 					 lenth: "Required",
// 					 height: "Required",
// 					 width: "Required",
// 			 }
// });
//
//
 });
</script>
