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

function loadcurrent_block(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#plandata" ).load( "<?=base_url()?>re/reservation/get_advancedata/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#plandata').delay(1).fadeOut(600);
 }
}

function load_amount(value)
{
	var amount=0;
	if(value!="")
	 amount=value.split(",")[1];
	document.getElementById("amount").value=amount;
}
function calculatetot()
{	var list=document.getElementById('inslist').value;
//alert(list);
	var res2 = list.split(",");
	
	var tot=0;
	
	//var rawmatcount=document.myform.rawmatcount.value;
	
		for(i=0; i< res2.length-1; i++)
	{
		
		totobj=document.getElementById('isselect'+res2[i]);
		
		amount=document.getElementById('raw_val'+res2[i]).value;
		
		if(totobj.checked)
		{
			//alert(totobj);
			tot=parseFloat(tot)+parseFloat(amount);
			
		}
		
	}
   
	if(tot!=0)
	{
	document.getElementById('payment').value=parseFloat(tot).toFixed(2);
	}
	else
	{
		document.getElementById('payment').value=0;;

	}
}
 </script>
 
						
                    
							
 <div class="form-title">
								<h4>Loan Details</h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                 <?
 $futureDate=$loanstart_date=$details->start_date;
 $arrayintlist=NULL;
 $current_date=date('Y-m-d');
 $end_date=date('Y-m-d',strtotime('+'.intval($details->period).' months',strtotime($futureDate)));
 
					  $date1=date_create($loanstart_date);
					  $date2=date_create($current_date);

					$diff=date_diff($date1,$date2);
					$current_cap=$details->loan_amount;
					$inttot=0;
					$dates=$diff->format("%m ");
					$thismonthint=0;
					if($dates>1)
					{
					for($i=1; $i<=$dates; $i++)
					{
						
						$thismonthint=0;
						$prvdate=$futureDate;
						if($i>$details->period)
						$thismonthint=round(($current_cap*$typedata->default_int)/(12*100),2);
						$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
						$this_payment= get_thismonth_payment($details->loan_code,$prvdate,$futureDate);
						$balance=$current_cap+$thismonthint - $this_payment;
						$arrayintlist[$i]['date']=$futureDate;
						$arrayintlist[$i]['int']=$thismonthint;
						$arrayintlist[$i]['payment']=$this_payment;
						$arrayintlist[$i]['balance']=$balance;
						$current_cap=$balance;
						$inttot=$inttot+$thismonthint;
					}
					}
					else
					{
						$prvdate=$current_date;
						$this_payment= get_thismonth_payment($details->loan_code,$prvdate,$futureDate);
						$current_cap=$current_cap-$this_payment;
					}
					$lastint=0; 
					if($end_date < $current_date)
					{
						//echo $current_date;
					 $date1=date_create($futureDate);
					 $date2=date_create($current_date);

					$diff=date_diff($date1,$date2);
				
					$dates=$diff->format("%a ");
					$lastint=round(($current_cap*$dates*$typedata->default_int)/(12*100*360),2);
					}
					$uptodateint=$thismonthint+$lastint;
					$inttot=$inttot+$lastint;
					$last_bal=$current_cap+$lastint;
 
 ?>
								
			      
				
             <? $totalout=$last_bal;
			 $delay_int=$inttot*$typedata->delay_int/100?>
                        <table class="table " > 
                       
                        <tbody> <tr> 
                        <th scope="row">Customer Name</th><td> <?=$details->first_name ?> &nbsp; <?=$details->last_name ?></td><th  align="right">NIC Number</th><td><?=$details->id_number ?></td> 
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Number</th><td> <?=$details->loan_code ?> &nbsp; </td><th  align="right">Artical Value</th><td><?=number_format($details->discounted_price,2) ?></td> <th  align="right">Contract Date</th><td><?=$details->start_date ?></td>
                         </tr> 
                        
                          <tr class="table-bordered"> 
                        <th scope="row">Capital</th><td  align="right"> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  >Total Interest</th><td align="right"><?=number_format($totint,2) ?></td> <th  >Agreed value</th><td align="right"><?=number_format($totint+$details->loan_amount,2)  ?></td>
                         </tr>
                       
                           
                           <tr class="table-bordered"> 
                        <th scope="row">Paid Capital</th><td  align="right"> <?=number_format($totset->totpaidcap,2)  ?> &nbsp; </td><th  >Paid Interest</th><td align="right"><?=number_format($totset->totpaidint,2) ?></td> <th  >Paid Total</th><td align="right"><?=number_format($totset->totpaidint+$totset->totpaidcap,2)  ?></td>
                         </tr> 
                          
                        
                            
                          </tbody></table>  
                          
                    </div>  
                   	
							</div>  
                         
                             <div class="form-title">
								<h4>Payment History
                                
                               
                                
                                </h4>
							</div>
                            	<div class="form-body  form-horizontal" >
                             

                                   <table class="table table-bordered"><tr><th>Payment Date</th><th>Capital Payment</th><th>Interest payment</th><th>Delay Interest</th><th> Total</th><th></th><th>Receipt No </th></tr>
                         <? $delaintot=0;$inslist="";
				  $delayrentaltot=0; $arieasins=0; if($paylist){foreach($paylist as $row)
				  {
					
						
					// $delaintot= $delaintot+$dalay_int;
				?>
                <tr class=""><td><?=$row->pay_date?></td><td><?=number_format($row->cap_amount,2) ?></td><td><?=number_format($row->int_amount ,2) ?></td>
                <td><?=number_format($row->di_amount ,2) ?></td>
                <td><?=number_format($row->pay_amount ,2) ?></td>
                 <td><?=$row->RCT?></td>
                </tr>
                <?
				  }}?>
                 
                    
                        
                            
                          </tbody></table>  
                        
                       
                    </div> 
                    