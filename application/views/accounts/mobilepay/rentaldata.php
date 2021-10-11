
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
jQuery(document).ready(function() {
  $("#prj_id").chosen({
     allow_single_deselect : true
    });

	$("#loan_code").chosen({
     allow_single_deselect : true
    });
	$("#cus_code").chosen({
     allow_single_deselect : true
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
 function loadcurrent_block(id)
{
	//alert(id)
 if(id!=""){ $('#fulldata').delay(1).fadeOut(600);
	 
							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#blocklist" ).load( "<?=base_url()?>re/eploan/get_blocklist/"+id );
				
					 $('#myloanlist').delay(1).fadeIn(600);
    					    document.getElementById("myloanlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#myloanlist" ).load( "<?=base_url()?>re/eploan/get_project_loan/"+id );
				
	 
	 
		
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);
	
 }
}
function load_loanlist(id)
{
 if(id!=""){
	  $('#fulldata').delay(1).fadeOut(600);
							 $('#myloanlist').delay(1).fadeIn(600);
    					    document.getElementById("myloanlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#myloanlist" ).load( "<?=base_url()?>re/eploan/get_lot_loan/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);
	
 }
}

function loan_fulldata(id)
{//alert('sss');
	 if(id!="")
	 {
		var paydate=document.getElementById("paydate").value;
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		   $( "#fulldata").load( "<?=base_url()?>re/eploan/get_rentalpaydata/"+id+"/"+paydate);
	 }
}

function load_fulldetails(id)
{
	
	 if(id!="")
	 {var paydate=document.getElementById("paydate").value;
		
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		   $( "#fulldata").load( "<?=base_url()?>re/eploan/get_rentalpaydata/"+id+"/"+paydate);
	 }
}
function load_detailsagain()
{
	id=document.getElementById("loan_code").value;

 if(id!=""){
	 
	 var paydate=document.getElementById("paydate").value;
	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		   $( "#fulldata").load( "<?=base_url()?>re/eploan/get_rentalpaydata/"+id+"/"+paydate);
				
					
				
	 
	 
		
 }
 
}

function call_delete_follow(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_epfollowups', id: id,fieldname:'id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#complexConfirm').click();
				}
            }
        });
	
	
//alert(document.testform.deletekey.value);
	
}

</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

             <? //transfer_todayint('2018-01-25')?>    
 
      <h3 class="title1">Loan Payments</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          
           <li role="presentation"  <? if(!$this->session->flashdata('tab')){?> class="active"<? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Monthly Instalment</a></li> 
             <li role="presentation"  <? if($this->session->flashdata('tab')=='history'){?> class="active"<? }?>><a href="#history" role="tab" id="history-tab" data-toggle="tab" aria-controls="history" aria-expanded="true">Payment History</a></li> 

           
        
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          
            <? $this->load->view("includes/flashmessage");?>
             
                <div role="tabpanel" class="tab-pane fade <? if(!$this->session->flashdata('tab')){?>active in<? }?>" id="profile" aria-labelledby="profile-tab"> 
                   
                  
                       <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashier/pay_rental" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Monthly Instalment </h4>
						</div>
                        <div class="form-body form-horizontal">
                         <input  class="form-control" type="hidden" readonly name="temp_receipt"   value="<?=$temp_rct_no?>" />
										<input  class="form-control" type="hidden" readonly name="temp_receipt_date"   value="<?=$temp_rct_date?>" />
                          <div class="form-group"><div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."    id="prj_id" name="prj_id" >
                   
                   
                    <option value="<?=$mobdetails['project_name']?>"><?=$mobdetails['project_name']?> - <?=$mobdetails['lot_number']?></option>
                   
             
					</select></div>
                          <div class="col-sm-3 "  id="myloanlist">  <select class="form-control" placeholder="Qick Search.."    id="loan_code" name="loan_code" >
                  
                  
                    <option value="<?=$loan_code?>" ><?=$loan_code?></option>
                  
             
					</select></div>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="paydate"    name="paydate" value="<?=$paydate?>"    data-error="" required  onChange="load_detailsagain()" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                      
                       </div>
                        <div id="fulldata" style="min-height:100px;">
                        
                        
                        <div class="form-body  form-horizontal" >
                              <? $retruncharge=get_pending_return_charge($details->cus_code);
							
							if($retruncharge>0){?>
                             <div class="form-group"><label class="col-sm-3 control-label">Cheque Retrun Charge</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="chqcharge"    name="chqcharge"  value="<?=$retruncharge?>" readonly   data-error="" required >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                                        <? }?>
                                   <table class="table"><tr><th>Instalment</th><th>Rental</th><th>Due Date</th><th>Delay Interest</th><th>Paid DI</th><th>Paid Total</th><th>Credit Balance</th><th  style="color:#F30">DI Waveoff</th><th>Payment</th></tr>
                         <? $delaintot=0;$inslist="";$tot=0;$thisdelayint=0;
				  $delayrentaltot=0; $arieasins=0; if($ariastot){foreach($ariastot as $row)
				  {
					  
					  $date1=date_create($row->deu_date);
					  $date2=date_create($paydate);
					
 					$paidtotals=$row->paid_cap+$row->paid_int;
					 // echo $paidtotals.'sss';
					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					$delay_date=intval($dates)-intval($details->grase_period);
					$dalay_int=0;
					
					
					if($delay_date >0)
					{
						$dalay_int=($tot+floatval($details->montly_rental-$paidtotals))*floatval($details->delay_interest)/(100);
						$thisdelayint=$thisdelayint+$dalay_int;
					 	
					  $arieasins++;
					
					}
					//echo $thisdelayint;
					$inslist=$row->id.','.$inslist;
					 $delayrentaltot= $delayrentaltot+$details->montly_rental;
					// $delaintot= $delaintot+$dalay_int-$row->balance_di;
					 //echo $row->balance_di;
					 $currentdi=round($dalay_int,2)-$row->balance_di;
					 if($currentdi<0)
					  $currentdi=0;
					   $delaintot=$delaintot+$currentdi;
					
					 //$thisdibalance=$dalay_int-$row->balance_di
					 $thispayment=($details->montly_rental)-$row->tot_payment+$currentdi;
					 if($delay_date >0)
					{
					  $tot=$thispayment+$tot;
					}
					// echo $row->tot_payment;
				?>
                <tr><td><?=$row->instalment?></td><td><?=number_format($row->tot_instalment,2) ?></td><td><?=$row->deu_date?></td><td align="right"><?=number_format($currentdi,2) ?></td><td><?=number_format($row->balance_di,2) ?></td><td><?=number_format($row->balance_di+$row->tot_payment,2) ?></td><td><input  class="form-control" type="text" readonly name="raw_valtot<?=$row->id?>" id="raw_valtot<?=$row->id?>"  value="<?=number_format($thispayment,2) ?>" />
                <input  class="form-control" type="hidden" readonly name="raw_val<?=$row->id?>" id="raw_val<?=$row->id?>"  value="<?=$dalay_int+$row->tot_instalment?>" />
                 <input  class="form-control" type="hidden" readonly name="raw_delayint<?=$row->id?>" id="raw_delayint<?=$row->id?>"  value="<?=round($currentdi,2)?>" />
                 <input  class="form-control" type="hidden" readonly name="raw_int<?=$row->id?>" id="raw_int<?=$row->id?>"  value="<?=$row->int_amount?>" />
                    <input  class="form-control" type="hidden" readonly name="raw_intalment<?=$row->id?>" id="raw_intalment<?=$row->id?>"  value="<?=$row->instalment?>" /></td>
                <td><div <? if( check_access('waive_off DI')) {?> style="display:block" <? } else{ ?>  style="display:none" <? }?> ><input type="checkbox"   style="color:#F30" value="YES" name="isselect<?=$row->id?>"  id="isselect<?=$row->id?>"    /></div></td>
                     
                </tr>
                <?
				  }}else{ if($currentins){
					   $thispayment=($currentins->tot_instalment+$currentins->balance_di)-$currentins->tot_payment;
					  ?>
                  
                   <tr><td><?=$currentins->instalment?></td><td><?=number_format($currentins->tot_instalment,2) ?></td><td><?=$currentins->deu_date?></td><td>0.00</td><td>0.00</td><td><?=number_format($currentins->tot_payment,2)?></td><td><input  class="form-control" type="text" readonly name="raw_valtot<?=$currentins->id?>" id="raw_valtot<?=$currentins->id?>"  value="<?=number_format( $thispayment,2) ?>" />
                <input  class="form-control" type="hidden" readonly name="raw_val<?=$currentins->id?>" id="raw_val<?=$currentins->id?>"  value="<?=$thispayment?>" /></td>
                <input  class="form-control" type="hidden" readonly name="raw_delayint<?=$currentins->id?>" id="raw_delayint<?=$currentins->id?>"  value="0" />
                 <input  class="form-control" type="hidden" readonly name="raw_int<?=$currentins->id?>" id="raw_int<?=$currentins->id?>"  value="<?=$currentins->int_amount?>" />
                    <input  class="form-control" type="hidden" readonly name="raw_intalment<?=$currentins->id?>" id="raw_intalment<?=$currentins->id?>"  value="<?=$currentins->instalment?>" /></td>

                <td><div  <? if( check_access('waive_off DI')) {?> style="display:block" <? } else{ ?>  style="display:none" <? }?>><input type="checkbox"   style="color:#F30" value="YES" name="isselect<?=$currentins->id?>"  id="isselect<?=$currentins->id?>"    /></div></td>
                </tr>
				  <? 	$inslist=$currentins->id.','.$inslist; $tot=$tot+$thispayment;
				  }}
                  ?>
                 
                     <tr><th>Total Payment</th><td></td><td></td><td align="right"><?=number_format($delaintot,2)?></td><td></td><td></td>
                     <td><input  class="form-control" type="text" readonly name="payment_full" id="payment_full"  value="<?=number_format($tot,2)?>"  required="required"/></td><td></td><td>
                     <div class="form-group has-feedback"><input  class="form-control" type="number" step="0.01" min="1"  name="payment" id="payment"  value="<?=$amount?>"  required="required" onchange="check_value()"/>
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></td></tr>
             
                        
                            
                          </tbody>
                          <tr><td colspan="3" style="color:#F30"></td>
                          <td  valign="bottom" style=" margin-top:30px;"></td>
                          </tr>
                          </table>  
                         <input type="hidden" value="<?=$inslist?>" name="inslist" id="inslist" />
                         <?
                         $balance=($details->loan_amount+$totint)-($totset->totpaidcap+$totset->totpaidint);
						 ?>
                          <input type="hidden" value="<?=$balance?>" name="balance_val" id="balance_val"  />
                         
                                   <input  class="form-control" type="hidden" step="0.01" name="totdelayint" id="totdelayint"  value="<?=round($delaintot,2)?>"   required="required"/>
                                   
                         <div class="bottom ">
											
											<div class="form-group validation-grids" style="float:right">
												<button type="submit" class="btn btn-primary disabled" >Make Payment</button>
											</div>
											<div class="clearfix"> </div>
										</div>
                       
                    </div> 
                    
							
 <div class="form-title">
								<h4>Loan Details</h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                  <? $delaintot=0;$tot=0;
				 // print_r($ariastot);
				  $thisdelayint=0;
				  $delayrentaltot=0; $arieasins=0; if($ariastot){foreach($ariastot as $raw)
				  {
					  
					  $date1=date_create($raw->deu_date);
					  $date2=date_create($paydate);

					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					$delay_date=intval($dates)-intval($details->grase_period);
					if($delay_date >0)
					{
					$dalay_int=($tot+floatval($details->montly_rental))*floatval($details->delay_interest)/(100);
					$thisdelayint=$thisdelayint+$dalay_int;
					  $currentdi=round($dalay_int,2)-$raw->balance_di;
					 if($currentdi<0)
					  $currentdi=0;
					   $delaintot=$delaintot+$currentdi;
					// echo $row->balance_di;
					  $delayrentaltot= $delayrentaltot+$details->montly_rental;
					  $arieasins++;
					 $tot=$details->montly_rental+$dalay_int+$tot;
					}
						
				  }}?>
                        <table class="table"> 
                       
                        <tbody> <tr> 
                        <th scope="row">Customer Name</th><td> <?=$details->first_name ?> &nbsp; <?=$details->last_name ?></td><th  align="right">NIC Number</th><td><?=$details->id_number ?></td> 
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Number</th><td> <?=$details->loan_code ?> &nbsp; </td><th  align="right">Article Value</th><td><?=number_format($details->discounted_price,2) ?></td> <th  align="right">Contract Date</th><td><?=$details->start_date ?></td>
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Amount</th><td> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  align="right">Period</th><td><?=$details->period ?></td> <th  align="right">Interest</th><td><?=$details->interest ?></td>
                         </tr> 
                           <tr> 
                        <th scope="row">Capital</th><td> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  align="right">Total Interest </th><td><?=number_format($totint,2) ?></td> <th  align="right">Agreed value</th><td><?=number_format($totint+$details->loan_amount,2)  ?></td>
                         </tr> 
                           <tr> 
                        <th scope="row">Monthly Rental</th><td> <?=number_format($details->montly_rental,2)  ?> &nbsp; </td><th  align="right"></th><td></td> <th  align="right"></th><td></td>
                         </tr> 
                          <tr class="warning"> 
                        <th scope="row">Arrears Rental</th><td> <?=number_format($delayrentaltot,2)  ?> &nbsp; </td><th  align="right">Delay Interest</th><td><?=number_format(get_loan_date_di($details->loan_code,date('Y-m-d')),2)?></td> <th  align="right">Arrears Instalments</th><td><?=$arieasins  ?></td>
                         </tr> 
                        
                            
                          </tbody></table>  
                          
                    </div>  
                   	
							</div>
                    
                        
                        
                        
                        </div>   
                         
                    
                        
                       </div>
                       
                       
                       </div>
                       
                        
                        
                        
					</form></p> 
                </div>
                    <div role="tabpanel" class="tab-pane fade  <? if($this->session->flashdata('tab')=='history'){?>active in<? }?>" id="history" aria-labelledby="history-tab"> 
                    <?  $this->load->view("re/eploan/payment_history"); ?>
                    </div>
                     <div role="tabpanel" class="tab-pane fade  <? if($this->session->flashdata('tab')=='followups'){?>active in<? }?> " id="followups" aria-labelledby="followups-tab"> 
                    <?  $this->load->view("re/eploan/followup_index"); ?>
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
					
                    window.location="<?=base_url()?>re/customer/confirm/"+document.deletekeyform.deletekey.value;
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