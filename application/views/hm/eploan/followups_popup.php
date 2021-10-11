 <script type="text/javascript">
$( function() {
    $( "#promissed_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
  
function print_followup_data(id)
{
	
	window.open( "<?=base_url()?>hm/eploan/get_followup_print/"+id );
	
			
}
function submit_followup()
{
	
	
	
	var loan_code= document.getElementById("loan_code").value;
		var date=document.getElementById("searchdate").value;
		var cus_feedback=document.getElementById("cus_feedback").value;
		var sales_feedback=document.getElementById("sales_feedback").value;
		var todate_arreas=document.getElementById("todate_arreas").value;
		var contact_media=document.getElementById("contact_media").value;
		var promissed_date=document.getElementById("promissed_date").value;
		var promissed_amount=document.getElementById("promissed_amount1").value;
		//alert(isNaN(promissed_amount))
		var error='';
		if(date=='')
		error=error+'no date';
		if(isNaN(promissed_amount))
		error=error+'Promissed Amount should be numaric<br>';
		if(contact_media=='')
		error=error+'Please update Contact media<br>';
		if(sales_feedback=='')
		error=error+'Please update sales_feedback<br>';
		if(cus_feedback=='')
		error=error+'Please update Customer Feedback<br>';
		// var vendor_no = src.value;
//alert( promissed_date);
       if(error=='')
	   {
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'hm/eploan/add_followups_popup/';?>',
            data: {loan_code: loan_code, date: date,cus_feedback:cus_feedback,sales_feedback:sales_feedback,todate_arreas:todate_arreas,contact_media:contact_media,promissed_date:promissed_date,promissed_amount:promissed_amount },
            success: function(data) {
                if (data) {
					// alert('sss')
					$('#popupform').delay(1).fadeOut(100);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#popupform').delay(1).fadeOut(600);
					
				}
            }
        });
	   }
	   else
	   {
		// alert(promissed_date)
		  document.getElementById("checkflagmessage").innerHTML=error; 
					 $('#flagchertbtn').click();
	   }
}
  
 </script>
 
	<? $delaintot=0;$arreascap=0;$arreasint=0; 
				  $delayrentaltot=0; $arieasins=0; if($ariastot){foreach($ariastot as $raw)
				  {
					  
					  $date1=date_create($raw->deu_date);
					  $date2=date_create(date("Y-m-d"));
 $arreascap=$arreascap+$raw->cap_amount-$raw->paid_cap;
					   $arreasint=$arreasint+$raw->int_amount-$raw->paid_int ;
					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					if($date1 >	 $date2)
					$dates=0-($dates);
					$delay_date=intval($dates)-intval($details->grase_period);
					if($delay_date >0)
					{
					$dalay_int=floatval($details->montly_rental)*floatval($details->delay_interest)*$delay_date/(100*360);
					 $delaintot= $delaintot+$dalay_int;
					  $delayrentaltot= $delayrentaltot+$details->montly_rental;
					  $arieasins++;
					
					}
						
				  }}
				   $delayrentaltot=$arreascap+$arreasint;
				  ?>                
 <h4>Loan Details <?=$details->loan_code?>
                                 <span style="float:right"> <a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a>
</span></h4><br />
                   <form data-toggle="validator" method="post" action="<?=base_url()?>hm/eploan/add_followups" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
                            <input type="hidden" name="loan_code" id="loan_code" value="<?=$details->loan_code?>">
                             <input type="hidden" name="searchdate" id="searchdate" value="<?=$searchdate?>">

                  <div class="form-group ">
									<label class="col-sm-3 control-label">Action</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"> <select class="form-control" placeholder="Qick Search.."    id="contact_media" name="contact_media"  required >
                    <option value="">Select Media</option>
                    <option value="Reminder Send">Reminder Send</option>
				<option value="Reminder Call">Customer Call</option>
                    <option value="Customer Visit">Customer Visit</option>
                    
                      <option value="Payment Projection">Payment Projection</option>
             
					</select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Upto Date Arrears</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="arreas"  value="<?=number_format($delayrentaltot,2)?>"name="arreas"    data-error=""  required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <input type="hidden" class="form-control" id="todate_arreas"  value="<?=$delayrentaltot?>"name="todate_arreas"    data-error=""  >
									</div>
                                      
                                    <div class="form-group ">
									<label class="col-sm-3 control-label">Officer Feedback</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="sales_feedback"    name="sales_feedback"     data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Customer Feedback</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="cus_feedback"    name="cus_feedback"     data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        
                                        </div>
                                         <div class="form-group ">
									<label class="col-sm-3 control-label">Payment Promissed Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="promissed_date"    name="promissed_date"     data-error=""  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Promissed Amount</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="number"  step="0.01"class="form-control" id="promissed_amount"    name="promissed_amount"     data-error=""    >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        
                                        </div>
                                          <div class="form-group validation-grids " style="float:right">
												
												<button type="button"  onclick="submit_followup()"class="btn btn-primary ">Update</button>
											
											
										</div>
                             <table class="table table-bordered"> <thead> <tr> <th>Loan Code</th><th>Date</th> <th>Action </th><th>Customer Feedback</th><th>Promissed Date</th><th>Promissed Amount</th><th>Arrears Amount</th><th>Create By</th><th><a href="javascript:print_followup_data('<?=$details->loan_code?>')" title="Follow Up"><i class="fa fa-print nav_icon "></i></a></th></tr> </thead>
                      <? if($loanfollow){$c=0;
                          foreach($loanfollow as $row){?>
							 
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->loan_code?></th><td><?=$row->follow_date  ?></td> <td><?=$row->contact_media  ?> </td> <td><?=$row->cus_feedback?></td>
                      <td><?=$row->promissed_date?></td>  
                         <td align="right"><?=number_format($row->promissed_amount,2)?></td>
                        <td align="right"><?=number_format($row->todate_arreas,2)?></td>
                        <td align="right"><?=get_user_fullname($row->create_by)?></td>
                       <td>  
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table> 
                  
                    