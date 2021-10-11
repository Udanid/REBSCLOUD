 <script type="text/javascript">
$( function() {
    $( "#promissed_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
//    function get_loan_detalis_fl(id)
// {
	
// 		// var vendor_no = src.value;
// //alert(id);
        
		
// 					$('#popupform').delay(1).fadeIn(600);
					
// 					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );
			
// }
function print_advance_followup_data(id)
{
	
	window.open( "<?=base_url()?>re/eploan/get_advance_followup_print/"+id );
	
			
}
  
 </script>
            
							
 <div class="form-title">
								<h4>Add New</h4>  
    
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
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="arreas"  value="<?=number_format(($ariastot - $paidtot),2)?>"name="arreas"    data-error=""  required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <input type="hidden" class="form-control" id="todate_arreas"  value="<?=$ariastot - $paidtot?>"name="todate_arreas"    data-error=""  >
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
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control number-separator" id="promissed_amount"    name="promissed_amount"     data-error=""    >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        
                                        </div>
                                          <div class="form-group validation-grids " style="float:right">
												
												<button type="submit" class="btn btn-primary disabled">Update</button>
											
											
										</div>
										  <table class="table table-bordered"> <thead> <tr> <th>Reservation Code</th><th>Date</th> <th>Action </th><th>Customer Feedback</th><th>Promissed Date</th><th>Promissed Amount</th><th>Arrears Amount</th><th>Create By</th><th><a href="javascript:print_advance_followup_data('<?=$lot_id;?>')" title="Follow Up"><i class="fa fa-print nav_icon "></i></a></th></tr> </thead>
                      <? if($advancefollow){$c=0;
                          foreach($advancefollow as $row){?>
							 
                      
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
                            
                  
                    