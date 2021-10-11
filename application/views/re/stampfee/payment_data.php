
<script type="text/javascript">
$( function() {
    $( "#need_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	
	
  } );
function load_printscrean1(id,prjid)
{
			window.open( "<?=base_url()?>re/deedtransfer/print_lowyercopy/"+id+"/"+prjid );
	
}
function load_printscrean2(id,prjid)
{
			window.open( "<?=base_url()?>re/deedtransfer/print_customer/"+id+"/"+prjid );
	
}
</script>
<? if($current_res){?>
<? $loanpay=0; if($paydata)$loanpay=$paydata->totcap;
	$totpay=$current_res->down_payment+$loanpay;
	?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>Customer Reservation Details
      </h4>
	</div>
     <table class="table">
    <tr>
    <th>Customer Name</th><td><?=$current_res->first_name?> <?=$current_res->last_name?></td>
    <th>NIC Number</th><td><?=$cus_data->id_number?></td>
     <th>Telephone</th><td><?=$cus_data->mobile?></td>
   
    </tr>
    <tr>
    <th>Sales Type</th><td><?=$current_res->pay_type?></td>
    <th>Down Payment</th><td><?=number_format($current_res->down_payment ,2)?></td>
     <th>Balance Amount</th><td><?=number_format($current_res->discounted_price-$totpay,2)?></td>
    </tr>
    <tr><th>Stamp Fee amount</th><td><?=number_format($chargedata->stamp_duty ,2)?></td></tr>
    </table>
     <div class="form-title">
								<h4>Reservation Charge Payment History</h4>
							</div>
     <table class="table"> <thead> <tr> <th>Payment Date</th><th>Charge Type </th><th style="text-align:right;">Amount</th><th style="text-align:center;">Receipt No</th> <th>Status </th></tr> </thead>
                      <? if($charge_payment){$c=0;$rctlist=''; $paydate=''; $payamount=0;
                          foreach($charge_payment as $row){ if($row->chage_dis=='Stamp Fee')
						  {$rctlist=$row->rct_no.','.$rctlist;
						  $paydate=$row->pay_date;
						  $payamount=$payamount+$row->pay_amount;
						  }?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->pay_date?></th><td> <?=$row->chage_dis ?></td>
                        <td  align="right"> <?=number_format($row->pay_amount,2)?></td> 
                        <td align="center"><?=$row->rct_no?></td>
                        <td><?=$row->status?></td>
                        <td><div id="checherflag">
                         
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
   
 <? if($requestdata) {?>
   <div class="alert alert-success" role="alert">
						Payment Already Requested
				</div>
 <? }else {?>
  <div class=" widget-shadow " data-example-id="basic-forms"> 
                       
   <div class="form-title">
								<h4>Payment Request</h4>
							</div>
   <form data-toggle="validator" method="post" action="<?=base_url()?>re/stampfee/add_request" enctype="multipart/form-data">
                        <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                       
                        <input type="hidden" name="res_code" id="res_code" value="<?=$current_res->res_code?>">
                        <input type="hidden" name="cus_code" id="cus_code" value="<?=$current_res->cus_code?>">
                         <input type="hidden" name="full_amount" id="full_amount" value="<?=$chargedata->stamp_duty?>">
                            <input type="hidden" name="paid_date" id="paid_date" value="<?=$paydate?>">
                             <input type="hidden" name="paid_rctno" id="paid_rctno" value="<?=$rctlist?>">
                          <div class="form-body ">
                        
                                         <div class="form-group">
                                         <label class="col-sm-3 control-label" >Payment Request  Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> 
										 <div class="col-sm-3  has-feedback "><input type="text" class="form-control" name="need_date" id="need_date" autocomplete="off"  required="required" /></div> 
                                           <label class="col-sm-3 control-label" >Request Amount&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> 
										 <div class="col-sm-3  has-feedback "><input type="text"  max="<?=$payamount?>" value="<?=$payamount?>" class="form-control number-separator" name="paid_amount" id="paid_amount"  required="required" /></div>
                                         </div> 
                                         
                                         <div class="form-group has-feedback">
                                          <div class="col-sm-3" >
                                         <div class="col-sm-3" ><button type="submit" class="btn btn-primary " >Request Payment</button></div></div>
                                         
											<div class="clearfix"> </div>
                                        </div>
                                       
										
                        
 </form>
</div>
  <? }}?>
    </div> 
</div>
