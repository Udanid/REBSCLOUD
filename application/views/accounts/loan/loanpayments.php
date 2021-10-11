
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
		$( "#paydate" ).datepicker({dateFormat: 'yy-mm-dd'});

	} );
	$(document).ready(function(){
		$('#cap_div').hide();
		$('#inst_div').hide();
		$('#insloan_no').change(function(){
			var pay_type=$('#pay_type').val();
			var loan_number=$('#insloan_no').val();
			if(loan_number)
			{
				var paydate=document.getElementById("paydate").value;
					$('#fulldata').delay(1).fadeIn(600);
					document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#fulldata").load( "<?=base_url()?>accounts/loan/get_rentalpaydata/"+loan_number+"/"+paydate+"/"+pay_type);

			}else
			{
				document.getElementById("checkflagmessage").innerHTML='Please Select Loan Number';
			 $('#flagchertbtn').click();
			}

		});
		$('#caploan_no').change(function(){
			var pay_type=$('#pay_type').val();
			var loan_number=$('#caploan_no').val();
			if(loan_number)
			{
				var paydate=document.getElementById("paydate").value;
					$('#fulldata').delay(1).fadeIn(600);
					document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#fulldata").load( "<?=base_url()?>accounts/loan/get_rentalpaydata/"+loan_number+"/"+paydate+"/"+pay_type);

			}else
			{
				document.getElementById("checkflagmessage").innerHTML='Please Select Loan Number';
			 $('#flagchertbtn').click();
			}

		});
		$('#pay_type').change(function(){
			$('#fulldata').html('');
			var pay_type=$('#pay_type').val();
			if(pay_type=="installment"){
				$('#cap_div').hide();
				$('#inst_div').show();

			}else if(pay_type=="capital_payment"){
				$('#cap_div').show();
				$('#inst_div').hide();

			}
		});


	});
	function check_activeflag(id)
	{
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
					$( "#popupform" ).load( "<?=base_url()?>re/customer/edit/"+id );
				}
			}
		});
	}
	function call_confirm(id)
	{

		document.deletekeyform.deletekey.value=id;
		$('#complexConfirm_confirm').click();

	}
	function call_edit(id) {
		document.deletekeyform.deletekey.value=id;
		$('#popupform').delay(1).fadeIn(600);
		$("#popupform").load( "<?=base_url()?>accounts/loan/loanpaymentedit_view/"+id );
	}

	$(document).on('click','#close-btn', function(){
	  location.reload();
	});

</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div class="table">



			<h3 class="title1">Payments</h3>

			<div class="widget-shadow">
				<ul id="myTabs" class="nav nav-tabs" role="tablist">

					<li role="presentation"class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Monthly Instalment</a></li>
					<li role="presentation"><a href="#confirm" role="tab" id="confirm-tab" data-toggle="tab" aria-controls="confirm" aria-expanded="false">Instalment confirm</a></li>

				</ul>
				<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
					<div role="tabpanel" class="tab-pane fade <? if(!$this->session->flashdata('tab')){?>active in<? }?>" id="profile" aria-labelledby="profile-tab">


						<form data-toggle="validator" method="post" action="<?=base_url()?>accounts/loan/pay_rental" enctype="multipart/form-data">
							<div class="row">
								<div class=" widget-shadow" data-example-id="basic-forms">
									<div class="form-title">
										<h4>Monthly Instalment </h4>
									</div>
									<div class="form-body form-horizontal">
										<p>
											<? if($this->session->flashdata('msg')){?>
		    								<div class="alert alert-success" role="alert">
		    									<?=$this->session->flashdata('msg')?>
		    								</div><? }?>
		    								<? if($this->session->flashdata('error')){?>
		    									<div class="alert alert-danger" role="alert">
		    										<?=$this->session->flashdata('error')?>
		    									</div><? }?>
										</p>
										<div class="form-group">
											<div class="col-sm-3 ">
												<select class="form-control" placeholder="Qick Search.."  id="pay_type" name="pay_type" >
													<option value="">Payment Type</option>
													<option value="installment">Instalment</option>
													<option value="capital_payment">Capital Payment</option>


												</select>
											</div>
											<div class="col-sm-3 " id="cap_div">
												<select class="form-control" placeholder="Qick Search.." id="caploan_no" name="caploan_no" >
													<option value="">Loan Numbers</option>
													<?    foreach($cap_loan_numbers as $row){?>
														<option value="<?=$row->id?>"><?=$row->loan_number?></option>
													<? }?>

												</select>
											</div>
											<div class="col-sm-3 " id="inst_div">
												<select class="form-control" placeholder="Qick Search.." id="insloan_no" name="insloan_no" >
													<option value="">Loan Number</option>
													<?    foreach($loan_numbers as $row){?>
														<option value="<?=$row->id?>"><?=$row->loan_number?></option>
													<? }?>

												</select>
											</div>
											<div class="col-sm-3 has-feedback" id="paymentdateid">
												<input  type="text" class="form-control" id="paydate"    name="paydate"  value="<?=date("Y-m-d")?>"   data-error="" required="required" onChange="load_detailsagain()" >
												<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
												<span class="help-block with-errors" ></span></div></div>

											</div>

											<div id="fulldata" style="min-height:200px;"></div>

										</div>
										<br> <br> <br> <br> <br> <br>

									</div>





								</form></p>
							</div>
							<div role="tabpanel" class="tab-pane fade <? if(!$this->session->flashdata('tab')){?>active in<? }?>" id="confirm" aria-labelledby="confirm-tab">
								<div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                  <table class="table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Loan Number</th>
                        <th>Paid Type</th>
                        <th>paid Amount</th>
												<th>Paid Date</th>
                        <th>Status</th>
                        <th>Edit</th>
                      </tr>
                    </thead>
										<tbody>
										<?php
										$no=0;
											foreach ($payid_details as $key => $value) {

												if($value->payment_statues == "Pending"){
													$no=$no+1;
												?>
												<tr>
												<th><?=$no;?></th>
                        <th><?=$loandata[$value->loan_id]->loan_number?></th>
                        <th><?php if($value->pay_type=="installment"){echo "Installment";}
												else if($value->pay_type=="capital_payment"){echo "Capital Payment";}?></th>
                        <th class="text-right"><?=number_format($value->pay_amount,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
												<th><?=$value->pay_date;?></th>
												<th><?=$value->payment_statues;?></th>
												<th>
													<a href="javascript:call_edit('<?php echo $value->pay_id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
													<a href="javascript:call_confirm('<?php echo $value->pay_id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>

												</th>

											</tr>

										<?	}}?>
									</tbody>
									<tbody>
										<?php
											$no1=0;
											foreach ($payid_details as $key => $value) {

										 if($value->payment_statues == "Confirmed"){
											 $no1=$no1+1;
											 ?>
											<tr>
											<th><?=$no1;?></th>
											<th><?=$loandata[$value->loan_id]->loan_number?></th>
											<th><?php if($value->pay_type=="installment"){echo "Installment";}
											else if($value->pay_type=="capital_payment"){echo "Capital Payment";}?></th>
											<th class="text-right"><?=number_format($value->pay_amount,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
											<th><?=$value->pay_date;?></th>
												<th><?=$value->payment_statues;?></th>
											<th>
													<a href="" title="Confirmed"><i class="fa fa-check nav_icon icon_green"></i></a>
										</th>

										</tr>
										<?
											}}
										?>
									</tbody>
                  </table>
                  <div id="pagination-container"></div>
                </div>
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
						window.location="<?=base_url()?>re/eploan/delete_feedback/"+document.deletekeyform.deletekey.value;
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

						window.location="<?=base_url()?>accounts/loan/pay_rental_confirm/"+document.deletekeyform.deletekey.value;
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
