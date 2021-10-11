 <script type="text/javascript">

  

function check_before_transfer(type)
{	
	var res_code = $('#reservation_data').val();
	var button = false;
	// var chkbox = $('stamp_duty')
	// alert(chkbox);
	if($('#'+type+'_check').is(":checked"))
	{
		check(type);
	}
	else
	{
		document.getElementById(type+'_error').innerHTML = '';

		//document.getElementById("submit").disabled = true;

		if($('#document_fee_check').is(":checked"))
		{
			if(check('document_fee'))
			{
				button = true;
			}
			else
			{
				button = false;
			}
		}

		if($('#stamp_check').is(":checked"))
		{
			if(check('stamp_duty'))
			{
				button = true;
			}
			else
			{
				button = false;
			}
		}

		if($('#leagal_fee_check').is(":checked"))
		{
			if(check('leagal_fee'))
			{
				button = true;
			}
			else
			{
				button = false;
			}
		}

		if($('#other_charges_check').is(":checked"))
		{
			if(check('other_charges'))
			{
				button = true;
			}
			else
			{
				button = false;
			}
		}

		if($('#other_charge2_check').is(":checked"))
		{
			if(check('other_charge2'))
			{
				button = true;
			}
			else
			{
				button = false;
			}
		}

		if($('#opinion_fee_check').is(":checked"))
		{
			if(check('opinion_fee'))
			{
				button = true;
			}
			else
			{
				button = false;
			}
		}

		if($('#document_chargers_check').is(":checked"))
		{
			if(check('document_chargers'))
			{
				button = true;
			}
			else
			{
				button = false;
			}
		}

		if($('#ep_document_chargers_check').is(":checked"))
		{
			if(check('ep_document_chargers'))
			{
				button = true;
			}
			else
			{
				button = false;
			}
		}

		document.getElementById("submit").disabled = button;
	}
	
	function check(type)
	{
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'re/reservation/check_transfer';?>',
            data: {type: type, res_code:res_code },
            success: function(data) {
                if (data) {

                	if(data.trim() != 'True')
                	{
                		document.getElementById(type+'_error').innerHTML = "Canno't Transfer";
                		document.getElementById("submit").disabled = true;
                		return true;
                	}
               
                } 
				
            }
        });
	}
	
}
 </script>
 
 

							<div class="form-body  form-horizontal" >
                       <?
							$paiddoc=0; $padilegal=0; $paidstamp=0;$paidothercharge=0;$paidothercharge2=0;$paid_opinion_fee=0; $paiddocchargers=0; $paidepdocchargers=0;
							if($charge_payment){
							foreach($charge_payment as $raw)
							{
								if($raw->chage_type=='leagal_fee')
								$padilegal=$padilegal+$raw->pay_amount ;
								if($raw->chage_type=='stamp_duty')
								$paidstamp=$paidstamp+$raw->pay_amount ;
								if($raw->chage_type=='document_fee')
								$paiddoc=$paiddoc+$raw->pay_amount ;
								if($raw->chage_type=='other_charges')
								$paidothercharge=$paidothercharge+$raw->pay_amount ;
								if($raw->chage_type=='other_charge2')
								$paidothercharge2=$paidothercharge2+$raw->pay_amount ;
								if($raw->chage_type=='opinion_fee')
								$paid_opinion_fee=$paid_opinion_fee+$raw->pay_amount ;
								if($raw->chage_type=='document_chargers')
								$paiddocchargers=$paiddocchargers+$raw->pay_amount ;
								if($raw->chage_type=='ep_document_chargers')
								$paidepdocchargers=$paidepdocchargers+$raw->pay_amount ;
							}
							}
							?>


                           
                            
                             <table>
                             	<tr>
                             		<?if($paidstamp != 0){?>
                             		<th>Stamp Fee</th>
                             		<td>
                             			<input type="text" class="form-control number-separator"   id="stamp_duty_val"  value="<?=number_format($paidstamp,2) ?>" name="stamp_duty_val" readonly>
                             			<span style="color: red;" id="stamp_duty_error"></span>
                             		</td>
                             		<td>
                             			<input type="checkbox" name="stamp_check" id="stamp_check" value="stamp_duty" onchange="check_before_transfer(this.value)">
                             		</td>
                             		<?}?>
                             	</tr>
                             	<tr>
                             		<?if($padilegal != 0){?>
                             		<th>Legal Fees</th>
                             		<td>
                             			<input type="text" class="form-control number-separator" id="leagal_fee_val"   name="leagal_fee_val"  data-error=""    value="<?=number_format($padilegal,2) ?>" readonly>
                             			<span style="color: red;" id="leagal_fee_error"></span>
                             		</td>
                             		<td>
                             			<input type="checkbox" name="leagal_fee_check" id="leagal_fee_check" value="leagal_fee" onchange="check_before_transfer(this.value)">
                             		</td>
                             		<?}?>
                             	</tr>
                             	<tr>
                             		<?if($paiddoc != 0){?>
                             		<th>Draft Checking Fee</th>
                             		<td>
                             			<input  type="text"   class="form-control number-separator" id="document_fee_val"    name="document_fee_val"  value="<?=number_format($paiddoc,2) ?>" data-error=""   readonly>
                             			<span style="color: red;" id="document_fee_error"></span>

                             		</td>
                             		<td>
                             			<input type="checkbox" name="document_fee_check" id="document_fee_check" value="document_fee" onchange="check_before_transfer(this.value)">
                             		</td>
                             		<?}?>
                             	</tr>
                             	<tr>
                             		<?if($paidothercharge != 0){?>
                             		<th>Plan Copy Fees</th>
                             		<td>
                             			<input type="text" class="form-control number-separator"   id="other_charges_val"    value="<?=number_format($paidothercharge,2) ?>" name="other_charges_val" readonly>
                             			<span style="color: red;" id="other_charges_error"></span>
                             		</td>
                             		<td>
                             			<input type="checkbox" name="other_charges_check" id="other_charges_check" value="other_charges" onchange="check_before_transfer(this.value)">
                             		</td>
                             		<?}?>
                             	</tr>
                             	<tr>
                             		<?if($paidothercharge2 != 0){?>
                             		<th>PR Fees</th>
                             		<td>
                             			<input type="text" class="form-control number-separator" id="other_charges2_val"  name="other_charges2_val"  data-error=""    value="<?=number_format($paidothercharge2,2) ?>" readonly>
                             			<span style="color: red;" id="other_charge2_error"></span>
                             		</td>
                             		<td>
                             			<input type="checkbox" name="other_charge2_check" id="other_charge2_check" value="other_charge2" onchange="check_before_transfer(this.value)">
                             		</td>
                             		<?}?>
                             	</tr>
                             	<tr>
                             		<?if($paid_opinion_fee != 0){?>
                             		<th>Opinion Fee</th>
                             		<td>
                             			<input type="text" class="form-control number-separator" id="opinion_fee_val" name="opinion_fee_val"  data-error=""    value="<?=number_format($paid_opinion_fee,2) ?>" readonly>
                             			<span style="color: red;" id="opinion_fee_error"></span>
                             		</td>
                             		<td>
                             			<input type="checkbox" name="opinion_fee_check" id="opinion_fee_check" value="opinion_fee" onchange="check_before_transfer(this.value)">
                             		</td>
                             		<?}?>
                             	</tr>
                             	<tr>
                             		<?if($paiddocchargers != 0){?>
                             		<th>Document Charges</th>
                             		<td>
                             			<input type="text" class="form-control number-separator"   id="document_chargers_val"  value="<?=number_format($paiddocchargers,2) ?>" name="document_chargers_val" readonly>
                             			<span style="color: red;" id="document_chargers_error"></span>
                             		</td>
                             		<td>
                             			<input type="checkbox" name="document_chargers_check" id="document_chargers_check" value="document_chargers" onchange="check_before_transfer(this.value)">
                             		</td>
                             		<?}?>
                             	</tr>
                             	<tr>
                             		<?if($paidepdocchargers != 0){?>
                             		<th>EP Document Charges</th>
                             		<td>
                             			<input  type="text"  class="form-control number-separator" id="ep_document_val"    name="ep_document_val"  value="<?=number_format($paidepdocchargers,2) ?>" data-error=""   readonly >
                             			<span style="color: red;" id="ep_document_chargers_error"></span>
                             		</td>
                             		<td>
                             			<input type="checkbox" name="ep_document_chargers_check" id="ep_document_chargers_check" value="ep_document_chargers" onchange="check_before_transfer(this.value)">
                             		</td>
                             		<?}?>
                             	</tr>
                             </table>
                            
                           
                                 

                                      <div class="form-group " style="float:right">
										<div class="col-sm-3 has-feedback"><button type="submit" class="btn btn-primary disabled" id="submit" >Transfer</button>
											</div>
                                        <input type="hidden" class="form-control" id="pendingamount"  value=""name="pendingamount"    data-error=""  >
									</div>
                                      <br /><br /><br />
                                   
                                          <div class="form-group validation-grids " style="float:right">
												
												
											
										</div>
								
							</div>
                  