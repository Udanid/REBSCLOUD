
<!DOCTYPE HTML>
<html>
<head>

	<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_notsearch");
	?>
	<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
	<script type="text/javascript">
	$( function() {
		$.validator.setDefaults({ ignore: ":hidden:not(.select)" });

		//set validation options
		$("#advForm").validate();
		$( "#apply_date" ).datepicker({dateFormat: 'yy-mm-dd',onSelect: function(selectedDate) {
			var promise_date = updateDatesNew(selectedDate);
			$('#promiss_date').datepicker('option', 'minDate', selectedDate); //set promiss_date mindate as fromdate
			$('#promiss_date').datepicker('setDate', promise_date); //set promiss_date mindate as fromdate

		}});
		$( "#promiss_date" ).datepicker({dateFormat: 'yy-mm-dd'});
		$("#officer_id").chosen({
			allow_single_deselect : true,
			search_contains: true,
			no_results_text: "Oops, nothing found!",
			placeholder_text_single: "Select Officer"
		});
		$("#officer_id").chosen({
			allow_single_deselect : true,
			search_contains: true,
			no_results_text: "Oops, nothing found!",
			placeholder_text_single: "Select Officer"
		});
		$("#apprved_officerid").chosen({
			allow_single_deselect : true,
			search_contains: true,
			no_results_text: "Oops, nothing found!",
			placeholder_text_single: "Select Officer"
		});
		$("#check_officerid").chosen({
			allow_single_deselect : true,
			search_contains: true,
			no_results_text: "Oops, nothing found!",
			placeholder_text_single: "Select Officer"
		});

	});
	jQuery(document).ready(function() {
		$("#project_id").focus(function() {
			$("#project_id").chosen({
				allow_single_deselect : true
			});
		});
		$("#res_code_set").focus(function() {
			$("#res_code_set").chosen({
				allow_single_deselect : true
			});
		});
		$("#name").focus(function() {
			$("#name").chosen({
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
			data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
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
					$( "#popupform" ).load( "<?=base_url()?>accounts/cashadvance/get_cashadvance/"+id );
				}
			}
		});
	}
	function extend_settledate(id)
	{
		$('#popupform').delay(1).fadeIn(600);
		$( "#popupform" ).load( "<?=base_url()?>accounts/cashadvance/edit_settledate_cashadvance/"+id );
	}
	function pay_cash(id,bookid)
	{

		// var vendor_no = src.value;
		//alert(id);
		$.ajax({
			cache: false,
			type: 'GET',
			dataType: 'json',
			url: '<?php echo base_url().'accounts/cashadvance/check_balance';?>',
			data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id',bookid:bookid },
			success: function(data) {
				if (data=="true") {
					document.getElementById("checkflagmessage").innerHTML="The ledger balance is not enough for pay cash";
					$('#flagchertbtn').click();


					//document.getElementById('mylistkkk').style.display='block';
				}
				else
				{
					$.ajax({
						cache: false,
						type: 'GET',
						url: '<?php echo base_url().'accounts/cashadvance/pay_cash';?>',
						data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
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
								$( "#popupform" ).load( "<?=base_url()?>accounts/cashadvance/denomination/"+bookid );
							}
						}
					});
				}
			}
		});
	}
	function refund_balance(id,bookid)
	{

		// var vendor_no = src.value;
		//alert(id);

		$.ajax({
			cache: false,
			type: 'GET',
			url: '<?php echo base_url().'accounts/cashadvance/refund_cash';?>',
			data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
			success: function(data) {
				if (data) {
					//alert(data);
					document.getElementById("checkflagmessage").innerHTML=data;
					$('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
				}
				else
				{

					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>accounts/cashadvance/denomination/"+bookid );
				}
			}
		});
	}

	function call_delete(id)
	{
		document.deletekeyform.deletekey.value=id;
		$.ajax({
			cache: false,
			type: 'GET',
			url: '<?php echo base_url().'accounts/cashadvance/delete_chercker/';?>',
			data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
			success: function(data) {
				//   if (data) {
				// alert(data);
				//  document.getElementById("checkflagmessage").innerHTML=data;
				// $('#flagchertbtn').click();

				//document.getElementById('mylistkkk').style.display='block';
				//  }
				//else
				//{
				$('#complexConfirm').click();
				//	}
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
			data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
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


	}
	function confirm_dateextend(id)
	{
		document.deletekeyform.deletekey.value=id;
		$.ajax({
			cache: false,
			type: 'GET',
			url: '<?php echo base_url().'common/activeflag_cheker/';?>',
			data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
			success: function(data) {
				if (data) {
					// alert(data);
					document.getElementById("checkflagmessage").innerHTML=data;
					$('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
				}
				else
				{
					$('#complexConfirm_dateextend').click();
				}
			}
		});


	}
	function call_check(id)
	{
		document.deletekeyform.deletekey.value=id;
		$.ajax({
			cache: false,
			type: 'GET',
			url: '<?php echo base_url().'common/activeflag_cheker/';?>',
			data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
			success: function(data) {
				if (data) {
					// alert(data);
					document.getElementById("checkflagmessage").innerHTML=data;
					$('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
				}
				else
				{
					$('#complexConfirm_check').click();
				}
			}
		});


	}
	//alert(document.testform.deletekey.value);


	call_check
	function loadcurrent_block(id)
	{
		if(id!=""){

			$('#blocklist').delay(1).fadeIn(600);
			document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
			$( "#blocklist" ).load( "<?=base_url()?>re/deedtransfer/get_blocklist/"+id );






		}
		else
		{
			$('#blocklist').delay(1).fadeOut(600);

		}
	}

	function load_fulldetails(id)
	{
		if(id!="")
		{$('#deedlist').delay(1).fadeOut(600);
		var prj_id= document.getElementById("prj_id").value
		$('#fulldata').delay(1).fadeIn(600);
		document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		$( "#fulldata").load( "<?=base_url()?>re/deedtransfer/get_fulldata/"+id+"/"+prj_id );
	}
}
function load_fulldetails_popup(prj_id,lot_id)
{

	// var prj_id= document.getElementById("prj_id").value



	$( "#popupform").load( "<?=base_url()?>re/deedtransfer/get_fulldata_popup/"+lot_id+"/"+prj_id );
	$('#popupform').delay(1).fadeIn(600);

}
function load_prjlist(obj)
{
	if(obj=='Project')
	{
		$('#prjlistdiv').delay(1).fadeIn(600);
		$("#project_id").chosen({
			allow_single_deselect : true,
			width: '100%'
		});
	}
	else
	{
		$('#prjlistdiv').delay(1).fadeOut(600);
	}
}
function load_tasklist(obj)
{
	if(obj!=''){
		//alert(obj)
		$( "#tasklistdiv").load( "<?=base_url()?>accounts/cashadvance/get_tasklist/"+obj );
	}
	else
	{
		document.getElementById("checkflagmessage").innerHTML='Please Select Project';
		$('#flagchertbtn').click();
	}
}
function check_projectselected()
{
	var type = document.getElementById("adv_type").value;
	var officerid = document.getElementById("officer_id").value;
	var apprvedoff_id = document.getElementById("apprved_officerid").value;
	var checkedofficer_id = document.getElementById("check_officerid").value;
	if(officerid=='')
	{
		document.getElementById("checkflagmessage").innerHTML='Please Select Officer';
		$('#flagchertbtn').click();
		document.getElementById("amount").value='';
		return false;
	}
	else if(checkedofficer_id=='')
	{
		document.getElementById("checkflagmessage").innerHTML='Please Select Checking  Officer';
		$('#flagchertbtn').click();
		document.getElementById("amount").value='';
		return false;
	}
	else if(apprvedoff_id=='')
	{
		document.getElementById("checkflagmessage").innerHTML='Please Select Approverd Officer';
		$('#flagchertbtn').click();
		document.getElementById("amount").value='';
		return false;
	}
	else if(obj=='Project')
	{
		var project=document.getElementById("project_id").value;
		if(project=='')
		{
			document.getElementById("checkflagmessage").innerHTML='Please Select Project';
			$('#flagchertbtn').click();
			document.getElementById("amount").value='';
			return false;
		}
		else
		return true;
	}
	else
	return true;
}
function updateDates(date){
	var dp_cmpldate = '<?=get_rate("Cash Advance Settled Period")?>';
	$.ajax({
		cache: false,
		type: 'POST',
		url: '<?php echo base_url().'re/reservation/get_updated_date/';?>',
		data: {date: date, days: dp_cmpldate },
		success: function(data) {
			if (data) {
				$('#promiss_date').val('');
				$('#promiss_date').val(data.trim());
			}

		}
	});

}

function updateDatesNew(date){
	var dp_cmpldate = '<?=get_rate("Cash Advance Settled Period")?>';

	var dateFormatTotime = new Date(date);
	var increasedDate = new Date(dateFormatTotime.getTime() +(dp_cmpldate *86400000));

	month = '' + (increasedDate.getMonth() + 1),
	day = '' + increasedDate.getDate(),
	year = increasedDate.getFullYear();

	if (month.length < 2)
	month = '0' + month;
	if (day.length < 2)
	day = '0' + day;

	return [year, month, day].join('-');
}

function check_unsettled(){

	var officer_id= document.getElementById("officer_id").value;
	if(officer_id!='')
	{
		$.ajax({
			cache: false,
			type: 'POST',
			url: '<?php echo base_url().'accounts/cashadvance/check_officer_unsettled_advance/';?>',
			data: {officer_id: officer_id },
			success: function(data) {
				if (data) {
					$('#cash_advance_warning').delay(1).fadeIn(600);
					document.getElementById("cash_advance_warning").innerHTML=data

					$('#allowadvance').delay(1).fadeOut(600);


				}
				else
				{
					$('#cash_advance_warning').delay(1).fadeOut(600);
					document.getElementById("cash_advance_warning").innerHTML='';
					$('#allowadvance').delay(1).fadeIn(600);
				}

			}
		});
	}


}
function call_printarpoval(month,prjid)
{
	window.open( "<?=base_url()?>accounts/cashadvance/print_checklist");

}
function change_narration_name(val)
{
	//alert(val)
	document.getElementById("description").value=val;
}
</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div class="table">

			<?
			$heading='IOU';
			if($pay_type=='CHQ')
			$heading='Cash Advance';
			?>

			<h3 class="title1">New <?=$heading?></h3>

			<div class="widget-shadow">
				<ul id="myTabs" class="nav nav-tabs" role="tablist">


					<li role="presentation" <? if($list==''){?> class="active"<? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Apply <?=$heading?></a></li>
					<li role="presentation" <? if($list=='book'){?> class="active"<? }?>><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true"><?=$heading?> List</a></li>

				</ul>
				<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
					<? $this->load->view("includes/flashmessage");?>

					<div role="tabpanel" class="tab-pane fade <? if($list==''){?>  active in <? }?>" id="profile" aria-labelledby="profile-tab">
						<p>


							<form id="advForm" method="post" action="<?=base_url()?>accounts/cashadvance/add_advance" enctype="multipart/form-data">
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">
										<div class="form-title">
											<h4>New <?=$heading?> </h4>
										</div>
										<div class="form-body form-horizontal">

											<div class="form-group">
												<input type="hidden" class="form-control" name="pay_type_insert" id="pay_type_insert" value="<?=$pay_type?>" placeholder="Amount">

												<label class=" control-label col-sm-3 " >Advance Type</label>
												<div class="col-sm-3 "><select name="adv_type" id="adv_type" class="form-control"required="required" onChange="load_prjlist(this.value)"  >
													<option value=""> Advance type</option>
													<option value="Project"> Project</option>
													<option value="Other"> Other</option>
												</select>
											</div>
											<label class=" control-label col-sm-3 " >Expence Type</label>
											<div class="col-sm-3 "><select name="expence_type" id="expence_type" class="form-control"required="required" onChange="change_narration_name(this.value)">
												<option value=""> Expence type</option>
												<option value="Material"> Material</option>
												<option value="Machinery"> Machinery</option>
												<option value="Labour"> Labour </option>
												<option value="Other"> Other </option>
												<option value="Insurance (motor vehicle, personal accident, health)">Insurance (motor vehicle, personal accident, health) </option>
												<?  if($pay_type!='CHQ'){
													?>
													<option value="Telephone SLT">  Telephone SLT</option>
													<option value="Telephone Mobitel">   Telephone Mobitel</option>
													<option value="Electricity Expenses">Electricity Expenses</option>
													<option value="Water Expenses American Premium">Water Expenses American Premium</option>
													<option value="Water Expenses NWSDB"> Water Expenses NWSDB</option>
													<option value="Consultants payments">Consultants' payments</option>
													<option value="Office Cleaning">Office Cleaning</option>
													<option value="Postage & Courier">Postage & Courier</option>
													<option value="Printing & Stationery"> Printing & Stationery</option>
													<option value="Advertising Expenses - (Jobs & notices)">Advertising Expenses - (Jobs & notices)</option>							<option value="Meeting Expenses"> Meeting Expenses</option>
													<option value="Refreshments & Tea">Refreshments & Tea</option>
													<option value="Equipment Repairs & Maintenance">Equipment Repairs & Maintenance</option>
													<option value="Office Repairs & Maintenance">Office Repairs & Maintenance</option>
													<option value="Building Rent">Building Rent</option>
													<option value="Rates & Licenses">Rates & Licenses</option>
													<option value="Donations">Donations</option>
													<option value="Accounting Fees">Accounting Fees</option>
													<option value="Office Renovation Expenses">Office Renovation Expenses</option>
													<option value="Fines & Surcharges">Fines & Surcharges</option>
													<option value="Secretarial Charges">Secretarial Charges</option>
													<option value="Annual Subscriptions">Annual Subscriptions</option>
													<option value="Audit Fees">Audit Fees</option>
													<option value="Travelling">Travelling</option>
													<option value="Training Expenses">Training Expenses</option>
													<option value="Janitorial">Janitorial</option>
													<option value="Vehicle Rent">Vehicle Rent</option>
													<option value="Fuel Expenses">Fuel Expenses</option>
													<option value="Development Exp.">Development Exp.</option>
													<option value="Legal Exp">Legal Exp</option>
													<option value="Casual Wages">Casual Wages</option>
													<option value="Plan Approval">Plan Approval</option>
													<option value="Site Exp">Site Exp</option>
													<option value="Land Cleaning">Land Cleaning</option>
													<option value="Vehicle Maintenance">Vehicle Maintenance</option>
													<option value="Bank Loan Exp.">Bank Loan Exp.</option>
												<? } ?>

											</select>
										</div></div>
										<? if (  check_access('all_cashadvances')){?>

											<div class="form-group">
												<label class=" control-label col-sm-3 " >Officer</label>
												<div class="col-sm-3 "><select name="officer_id" id="officer_id" class="form-control chosen-select" required="required"  onChange="check_unsettled()" >
													<option value=""></option>
													<? if($emplist){
														foreach($emplist as $dataraw)
														{
															?>
															<option value="<?=$dataraw->id?>"><?=$dataraw->emp_no?> -<?=$dataraw->initials_full?> - <?=$dataraw->display_name?></option><!-- Ticket No.2502 || Added by Uvini -->
														<? }}?>

													</select></div>
													<label class=" control-label col-sm-3 " ></label><div class="col-sm-3 ">  </div></div>
												<? } else { ?>  <input  type="hidden" class="form-control" id="officer_id"    name="officer_id"  value="<?=$this->session->userdata('userid')?>"   data-error="" required  placeholder="Advance Number" ><? }?>

												<div class="alert alert-danger" role="alert"  <? if($officersettlflag) {?> style="display:block"<? } else {?>style="display:none" <? }?> id="cash_advance_warning"> You Have Unsettled Cash Advances

												</div>
												<div  id="allowadvance" <? if($officersettlflag) {?> style="display:none"<? }?>>
													<div class="form-group">
														<label class=" control-label col-sm-3 " >Cash Book</label>
														<div class="col-sm-3 "><select name="book_id" id="book_id" class="form-control"required="required"  >
															<option value=""> Cash Book</option>
															<? if($datalist){
																foreach($datalist as $dataraw)
																{
																	?>
																	<option value="<?=$dataraw->id?>"><?=$dataraw->type_name?> <?=$dataraw->name?></option>
																<? }}?>

															</select></div>
															<label class=" control-label col-sm-3 " >Amount</label><div class="col-sm-3 ">  <input  type="text" class="form-control number-separator" id="amount"    name="amount"  value=""   data-error="" required  placeholder="Amount" ></div></div>

															<div class="form-group">
																<label class=" control-label col-sm-3 " >Apply Date</label><div class="col-sm-3 ">  <input  type="text" class="form-control" autocomplete="off" id="apply_date"  onchange="updateDates(this.value);"   name="apply_date"  value=""   data-error="" required  placeholder="Apply Date" ></div>
																<label class=" control-label col-sm-3 " >Settle Date</label><div class="col-sm-3 ">  <input  type="text" class="form-control" autocomplete="off" id="promiss_date"    name="promiss_date"  value=""   data-error="" required  placeholder="Settle Date" ></div>
															</div>
															<div class="form-group">
																<label class=" control-label col-sm-3 " >Description</label><div class="col-sm-3 ">  <textarea  type="text" class="form-control" id="description"    name="description"  value=""   data-error="" required  placeholder="Description" ></textarea></div>
																<div id="prjlistdiv" style="display:none">   <label class=" control-label col-sm-3 " >Project</label>
																	<div class="col-sm-3 "><select name="project_id" id="project_id" class="form-control" required="required" onChange="load_tasklist(this.value)"  >
																		<option value=""> Select Project</option>
																		<? if($prjlist){
																			foreach($prjlist as $raw)
																			{
																				?>
																				<option value="<?=$raw->prj_id?>"><?=$raw->project_name?></option>
																			<? }}?>

																		</select></div></div>  <div class="clearfix"> </div><br>

																		<div class="clearfix"> </div><br>

																		<div class="form-group">
																			<label class=" control-label col-sm-3 " >Approved By</label>
																			<div class="col-sm-3 "><select name="apprved_officerid" id="apprved_officerid" class="form-control chosen-select" required="required"   >
																				<option value=""></option>
																				<? if($approvlist){
																					foreach($approvlist as $dataraw)
																					{
																						?>
																						<option value="<?=$dataraw->id?>"><?=$dataraw->surname?> - <?=$dataraw->display_name?></option>
																					<? }}?>

																				</select></div>
																				<label class=" control-label col-sm-3 " >Checked By</label>
																				<div class="col-sm-3 "><select name="check_officerid" id="check_officerid" class="form-control chosen-select" required="required"   >
																					<option value=""></option>
																					<? if($check_list){
																						foreach($check_list as $dataraw)
																						{
																							?>
																							<option value="<?=$dataraw->id?>"><?=$dataraw->surname?> - <?=$dataraw->display_name?></option>
																						<? }}?>

																					</select></div></div>
																					<div class="form-group"><div class="col-sm-3"></div>
																					<div id="tasklistdiv" class="col-sm-6"></div>
																					<div class="col-sm-3 has-feedback" id="paymentdateid"><button type="submit" class="btn btn-primary disabled" onClick="check_projectselected()" >Apply Advance</button></div></div></div>

																				</div></div>

																			</div>
																		</div>




																	</form>





																</p>

															</div>
															<div role="tabpanel" class="tab-pane fade  <? if($list=='book'){?>  active in <? }?> " id="list" aria-labelledby="list-tab">
																<p>
																	<div class="row">
																		<div class=" widget-shadow" data-example-id="basic-forms">

																		</div>



																		<div class="clearfix"> </div>

																		<div class=" widget-shadow" data-example-id="basic-forms">
																			<div class="form-title">
																				<h4><?=$heading?> List  <span style="float:right"> <a href="javascript:call_printarpoval('')"><span class="label label-success">Print List for Approval</span></a>
																				</span> </h4>

																			</div>
																			<form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashadvance/search"  enctype="multipart/form-data">
																				<div class="row">
																					<div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
																						<div class="form-body">
																							<div class="form-inline">
																								<div class="form-group">
																									<select class="form-control" placeholder="Qick Search.."   onchange="set_cashbook(this.value)" name="cashbookid_search" id="cashbookid_search">
																										<option value="all" >All</option>
																										<?    foreach($datalist as $row){?>
																											<option value="<?=$row->id?>" ><?=$row->name?></option>
																										<? }?>
																									</select>
																								</div>
																								<div class="form-group"> <!-- Ticket No.2502 || Added by Uvini -->
																									<select class="form-control" id="name" name='name'>
																										<option value="">Payee Name</option>
																										<? if($emplist){
																											foreach($emplist as $row){
																												if($row->display_name)
																												$displayname=$row->display_name;
																												else
																												$displayname=$row->initial.' '.$row->surname;
																												?>
																												<option value='<?=$row->id?>'><?=$row->emp_no?> <?=$displayname?></option>;
																											<?	}}?>
																										</select>
																									</div>
																									<div class="form-group">
																										<input type="text" class="form-control" name="advance_no" id="advance_no" placeholder="Cash Advance No">
																									</div>
																									<div class="form-group">
																										<input type="text" class="form-control" name="pay_status" id="pay_status" placeholder="Pay Status">
																									</div>
																									<div class="form-group">
																										<input type="text" class="form-control" name="amountsearch" id="amountsearch" placeholder="Amount">
																										<input type="hidden" class="form-control" name="pay_type" id="pay_type" value="<?=$pay_type?>" placeholder="Amount">
																									</div>

																									<div class="form-group">
																										<button  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</form>
																				<br>
																				<table class="table table-bordered"> <thead> <tr>

																					<? if($pay_type=='CSH'){?> <th>#</th><? }?> <th> Date</th> <th>Payee</th>  <th>Amount</th> <th>Settlement Date</th> <th>Cash Advance No</th><th>Description</th><th>Settled Amount</th><th>Balance</th><th>Refund Amount</th><th>Checked by</th><th>Approved by</th><th>Pay Status</th><th>Date Extend</th><th></th></tr> </thead>
<? if($advlist){$c =0;
foreach($advlist as $row){?>

	<tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
		<? if($pay_type=='CSH'){?>  <th scope="row"><?=$row->serial_number?></th> <? }?>
		<th scope="row"><?=$row->apply_date?></th> <td><?=$row->initial?> <?=$row->surname?></td>
		<td><?=number_format($row->amount,2) ?></td>
		<td><?=$row->promiss_date ?></td>
		<td><?=$row->adv_code ?></td>
		<td><?=$row->description ?></td>
		<td><?=number_format($row->totpay,2) ?></td>
		<td><?=number_format($row->amount-$row->totpay,2) ?></td>
		<td><?=number_format($row->refund_amount,2) ?></td>
		<td><?=get_user_fullname_id($row->checked_by)?></td>
		<td><?=get_user_fullname_id($row->aprove_by)?></td>
		<td><?=$row->status ?>
			<? //ticket number 3318 updated by nadee 2021-08-19
			if($row->status=='PAID'){
			if($pay_type=='CHQ' && $row->payvoucher_id!=""){
				$voucher_statues=check_voucher_statues($row->payvoucher_id);
			if($voucher_statues->status=='DELETED'){
				//check_voucher_statues helper is in cashadvance_helper
				echo "</br>Voucher DELETED";
				 }}

		}?>
		</td>
		<td><?=$row->extend_date ?></td>
		<td>
			<? if( $row->status=='PENDING'){?>
				<a  href="javascript:check_activeflag('<?=$row->adv_id?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
				<a  href="javascript:call_delete('<?=$row->adv_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
				<?  if (  check_access('check_cashadvance')){
					if($this->session->userdata('userid')==$row->check_officerid  ||   check_access('all_access')){  ?>

						<a  href="javascript:call_check('<?=$row->adv_id?>')" title="Check"><i class="fa fa-check nav_icon icon_blue"></i></a>
					<?  }}} ?>
					<? if( $row->status=='CHECKED'){?>

						<?  if (  check_access('approve_cashadvance')){
							if($this->session->userdata('userid')==$row->apprved_officerid ||   check_access('all_access')){  ?>
								<a  href="javascript:check_activeflag('<?=$row->adv_id?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
								<a  href="javascript:call_confirm('<?=$row->adv_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
								<?
							}}?>

						<? }
						if( $row->status=='APPROVED'){
							if($pay_type=='CSH'){?>
								

								<a  href="javascript:pay_cash('<?=$row->adv_id?>','<?=$row->book_id?>')" title="Pay Cash"><i class="fa fa-money nav_icon icon_red"></i></a>
							<?  }}
							//ticket number 3318 updated by nadee 2021-08-19
							if( $row->status=='APPROVED' || $row->status=='PAID'){
								
								if($pay_type=='CHQ' && $row->payvoucher_id!="" && check_access('delete_afterapprove')){
									
									$voucher_statues=check_voucher_statues($row->payvoucher_id);
									if($voucher_statues->status=='DELETED' || $voucher_statues->status=='CONFIRMED'){
								//check_voucher_statues helper is in cashadvance_helper
									?>

										<a  href="javascript:call_delete('<?=$row->adv_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
							<? }}

						}


							if( $row->status!='SETTLED'){
								?>

								<a  href="javascript:extend_settledate('<?=$row->adv_id?>')" title="Extend Settledate"><i class="fa fa-plus-square  nav_icon icon_green"></i></a>

								<? if( $row->extend_date){
									if( $row->extend_status=='PENDING'){	if($this->session->userdata('userid')==$row->apprved_officerid ||   check_access('all_access')){ ?>
										<a  href="javascript:confirm_dateextend('<?=$row->adv_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>

									<? }}}}
									?></td>

								</tr>

							<? }} ?>
						</tbody></table> </div>
																												<div id="pagination-container"><?php echo $links; ?></div></div>
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

																							<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_check" name="complexConfirm_check"  value="DELETE"></button>
																							<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_dateextend" name="complexConfirm_dateextend"  value="DELETE"></button>

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
																									window.location="<?=base_url()?>accounts/cashadvance/delete_advance/"+document.deletekeyform.deletekey.value;
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

																									window.location="<?=base_url()?>accounts/cashadvance/confirm_advance/"+document.deletekeyform.deletekey.value;
																								},
																								cancel: function(button) {
																									button.fadeOut(2000).fadeIn(2000);
																									// alert("You aborted the operation.");
																								},
																								confirmButton: "Yes I am",
																								cancelButton: "No"
																							});
																							$("#complexConfirm_check").confirm({
																								title:"Record confirmation",
																								text: "Are You sure you want to confirm this ?" ,
																								headerClass:"modal-header confirmbox_green",
																								confirm: function(button) {
																									button.fadeOut(2000).fadeIn(2000);
																									var code=1

																									window.location="<?=base_url()?>accounts/cashadvance/check_advance/"+document.deletekeyform.deletekey.value;
																								},
																								cancel: function(button) {
																									button.fadeOut(2000).fadeIn(2000);
																									// alert("You aborted the operation.");
																								},
																								confirmButton: "Yes I am",
																								cancelButton: "No"
																							});
																							$("#complexConfirm_dateextend").confirm({
																								title:"Record confirmation",
																								text: "Are You sure you want to confirm Date Extend ?" ,
																								headerClass:"modal-header confirmbox_green",
																								confirm: function(button) {
																									button.fadeOut(2000).fadeIn(2000);
																									var code=1

																									window.location="<?=base_url()?>accounts/cashadvance/confirm_dateextend/"+document.deletekeyform.deletekey.value;
																								},
																								cancel: function(button) {
																									button.fadeOut(2000).fadeIn(2000);
																									// alert("You aborted the operation.");
																								},
																								confirmButton: "Yes I am",
																								cancelButton: "No"
																							});

																							/*function set_cashbook(val){
																							$.ajax({
																							cache: false,
																							type: 'POST',
																							url: '< ?php echo base_url().'accounts/cashadvance/set_cashbook/';?>',
																							data: {bookid: val},
																							success: function(data) {
																							window.location="<?=base_url()?>accounts/cashadvance/advancelist/book";
																						}
																					});
																				}*/

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
