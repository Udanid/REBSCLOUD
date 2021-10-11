 <script type="text/javascript">
$( function() {
    $( "#promissed_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );

 $("#contact_officer").chosen({
    		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Contact Officer"
    	});

  $("#bank1").chosen({
    		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Contact Officer"
    	});
   function get_loan_detalis_fl(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );
			
}
function print_followup_data(id)
{
	
	window.open( "<?=base_url()?>re/eploan/get_followup_print/"+id );
	
			
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
				<div id='bank_details' <?if($details->loan_type == 'EPB'){?> style="display: block"<?}else{?>style="display: none"<?}?>>
				
					<div class="form-group">
                <label class="col-sm-3 control-label" >EPB Bank Data</label>
                 <table  class="table"><tr><td>
                  <select name="bank1" id="bank1" class="form-control" placeholder="Bank" onchange="loadbranchlist(this.value,'1')" required>
                    <option value="">Bank</option>
                    <? foreach ($banklist as $raw){?>
                      <option value="<?=$raw->BANKCODE?>" <?if($raw->BANKCODE == $details->epb_bank){?> selected <?}?>><?=$raw->BANKNAME?></option>
                    <? }?>

                  </select>
                </td>
                <td> 
                	<?if($details->epb_branch){?>

                		<div id="branch"><select name="branch" id="branch" class="form-control" placeholder="Bank">
                  <option value="<?=$details->epb_branch?>" selected><?=$details->epb_branch;?></option>


                </select></div>

                		<div id="branch-1" style="display:none"><select name="branch1" id="branch1" class="form-control" placeholder="Bank">
                  <option value="">Banch</option>


                </select></div>
                		<?}else{?>
                	<div id="branch-1"><select name="branch1" id="branch1" class="form-control" placeholder="Bank">
                  <option value="">Banch</option>


                </select></div>
                <?}?>
            	</td>
                <td> <div><select name="contact_officer" id="contact_officer" class="form-control" placeholder="Contact Officer" >
                  <option value="">Contact Officer</option>
                  <?if($emp_list){foreach($emp_list as $row){?>
                  	<option value="<?=$row->id?>" <?if($row->id == $details->epb_officer){?> selected <?}?>><?=$row->emp_no?>-<?=$row->display_name?></option>
                  	<?}}?>

                </select></div></td>
                <td><input type="text" class="form-control" name="contact_name" id="contact_name"   placeholder="contact_person" data-error="" value="<?=$details->epb_contact?>">
                </td>
                <td>
                	<button type="button" class="btn btn-primary" onclick="update_bank_details()">Update</button>
                </td>
              </tr></table>
        
				</div>

				<div id="bank_updated" class="alert alert-success" role="alert" style="display:none;">
				</div>
			</div>
 <div class="form-title">
								<h4>Add New </h4>  <span ><a href="javascript:get_loan_detalis_fl('<?=$details->loan_code?>')"><span class="label label-success" style="float:right; font-size:14px; top:-100px;  margin-top:-20px;	 ">Loan Data</span></a></span>
    
							</div><br />
                  
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
												
												<button type="submit" class="btn btn-primary disabled">Update</button>
											
											
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
                  
                    