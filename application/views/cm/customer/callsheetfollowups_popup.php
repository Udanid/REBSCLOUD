 <script type="text/javascript">

  $( function() {
    $( "#promissed_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
function print_followup_data(id)
{
	
	window.open( "<?=base_url()?>re/eploan/get_followup_print/"+id );
	
			
}

  function closepo()
{
	$('#popupform').delay(1).fadeOut(800);
}
 </script>
 
             
 <h4>Call Sheet Followups <?=$details->customer_name?>
                                 <span style="float:right"> <a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a>
</span></h4><br />
                   <form data-toggle="validator" method="post" action="<?=base_url()?>cm/customer/add_callhefollowups" enctype="multipart/form-data">
                            <input type="hidden" name="call_sheet_id" id="call_sheet_id" value="<?=$details->call_sheet_id?>">
                        
                  <div class="form-group ">
									<label class="col-sm-3 control-label">Action</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"> <select class="form-control" placeholder="Qick Search.."    id="contact_media" name="contact_media"  required >
             	<option value="Customer Call">Customer Call</option>
                    <option value="Send SMS">Send SMS</option>
                      <option value="Send EMAIL">Send EMAIL</option> 
                   
             
					</select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label"></label>
                                        <div class="col-sm-3 has-feedback" id="paymentdateid"></div>
                               	</div>
                                      
                                    <div class="form-group ">
									<label class="col-sm-3 control-label">Officer Feedback</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><textarea  class="form-control" id="sales_feedback"    name="sales_feedback"     data-error=""   required="required" ></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Customer Feedback</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><textarea class="form-control" id="cus_feedback"    name="cus_feedback"     data-error=""   required="required" ></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        
                                        </div>
                                       
                                          <div class="form-group validation-grids " style="float:right">
												
												<button type="submit"  class="btn  " value="Update">Update</button>
											
											
										</div>
                            
                          
                            <table class="table table-bordered"> <thead> <tr> <th>Date</th> <th>Action </th><th>Customer Feedback</th><th>Officer Feedback</th><th>Create By</th><th></th></tr> </thead>
                      <? if($loanfollow){$c=0;
                          foreach($loanfollow as $row){?>
							 
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                       <td><?=$row->follow_date  ?></td>
                         <td><?=$row->contact_media  ?> </td> 
                         <td><?=$row->cus_feedback?></td>
                         <td><?=$row->sales_feedback?></td>
                     <td align="right"><?=get_user_fullname($row->create_by)?></td>
                       <td>  
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table> 
                  
                    