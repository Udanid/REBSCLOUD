 <script type="text/javascript">

   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 
 function check_this_totals()
 {  
 	var pendingamount=parseFloat(document.getElementById('pendingamount').value);
   var payamoount=parseFloat(document.getElementById('amount').value);
   if(document.getElementById('task_id').value=="")
   {
	     document.getElementById("checkflagmessage").innerHTML='Please Select Task'; 
		 
					 $('#flagchertbtn').click();
					  document.getElementById('amount').value="";
   }
  
   if(payamoount>pendingamount)
   {
	    document.getElementById("checkflagmessage").innerHTML='Pay Amount exseed Budget Allocation'; 
					 $('#flagchertbtn').click();
					 document.getElementById('amount').value="";
   }
	
	 
 }


function load_subtasklist(id)
{
	 var prj_id= document.getElementById("prj_id").value;
	 if(id!=""){
	 taskid=id.split(",")[0];
	 
	 document.getElementById("pendingamount").value=id.split(",")[1];
	 
						 $('#subtaskdata').delay(1).fadeIn(600);
    					    document.getElementById("subtaskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#subtaskdata" ).load( "<?=base_url()?>common/get_subtask_list/"+taskid+"/"+ prj_id	);
				
	 
	 
		
 }
	 
}


function load_amount(value)
{
	var amount=0;
	if(value!="")
	 amount=value.split(",")[1];
	document.getElementById("amount").value=amount;
}
function load_realvalues()
{
	// alert('sss');
	var stamp= document.getElementById("stamp_duty_val").value;
	
	document.getElementById("stamp_duty").value=stamp.replace(",", "");
	
	var leagal_fee= document.getElementById("leagal_fee_val").value;
		
	document.getElementById("leagal_fee").value=leagal_fee.replace(",", "");
	var document_fee= document.getElementById("document_fee_val").value;

	document.getElementById("document_fee").value=document_fee.replace(",", "");
		var other_charges= document.getElementById("other_charges_val").value;
	document.getElementById("other_charges").value=other_charges.replace(",", "");
		var other_charge2= document.getElementById("other_charge2_val").value;
	document.getElementById("other_charge2").value=other_charge2.replace(",", "");
		 stamp=stamp.replace(",", "");
	  leagal_fee=leagal_fee.replace(",", "");
	  document_fee=document_fee.replace(",", "");
	  other_charges=other_charges.replace(",", "");
	  other_charge2=other_charge2.replace(",", "");
	  
	  var total=parseFloat(stamp)+parseFloat(leagal_fee)+parseFloat(document_fee)+parseFloat(other_charges)+parseFloat(other_charge2);
	
	  
	  document.getElementById("pay_amount_val").value=parseFloat(total).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	    document.getElementById("pay_amount").value=parseFloat(total);
		if(parseFloat(total)<=0)
			 document.getElementById("pay_amount_val").value="";
		
			
}
 </script>
 
 
 <div class="form-title">
								<h4>Customer Name : &nbsp;  <?=$resdata->first_name ?> <?=$resdata->last_name ?>
                                &nbsp;  &nbsp; Project Name :&nbsp;<?=$resdata->project_name?> &nbsp;&nbsp;  Land Details :  <?=$resdata->lot_number ?>-<?=$resdata->plan_sqid ?>
                                </h4>
							</div>
							<div class="form-body  form-horizontal" >
                           <?
							
							?>
                           
                          
                             
                                
                                <table class="table"><tr><th>Discription</th><th>Payable Amount</th><th>Paid Amount</th><th>Current payment</th></tr>
                      <? 
					   $all_payable=0;
					   if($development_data)
					   {foreach($development_data as $raw)
					  {
						  $totpaid=get_paid_amount_code($raw->id);
						  $totalpaybel=$raw->sale_value-$totpaid;
						  if( $totalpaybel>0)
						  {
						  ?>
                      
                      <tr>
                      <td><?=$raw->description?></td>
                      <td><?=number_format($raw->sale_value,2)?></td>
                      <td><?=number_format( $totpaid,2)?></td>
                      <td><div class="has-feedback" id="paymentdateid"><input  type="number" max="<?=$totalpaybel?>"    class="form-control" id="pay_amount_val<?=$raw->id?>"   name="pay_amount_val<?=$raw->id?>"  value="<?=$totalpaybel?>"  data-error=""   required="required"  >
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                      </td>
                      </tr>
                      <?
					  }} }?>
                     
                            </table>   
                            
                                     <div class="form-group " style="float:right">
									 
										<div class="col-sm-3 has-feedback"><button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Make Payment</button>
											</div>
                                    
									</div>
                                    
                                   
                                         <br /><br /><br />
							</div>
                    <div class="form-title">
								<h4>Additional Development Payment History</h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Payment Date</th><th>Charge Type </th><th>Amount</th><th>Reciept No</th> <th>Status </th></tr> </thead>
                      <?
					 
					   if($development_payment){$c=0;
                          foreach($development_payment as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->income_date?></th>
                        <td> <?=$row->description ?></td>
                        <td  align="right"> <?=number_format($row->amount,2)?></td> 
                        <td><?=$row->rct_no?></td>
                        <td><?=$row->status?></td>
                        <td><div id="checherflag">
                         
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          
                    </div>  