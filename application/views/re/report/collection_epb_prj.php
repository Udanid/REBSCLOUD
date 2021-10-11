
<script type="text/javascript">

function load_printscrean1(branch,type,month)
{
			window.open( "<?=base_url()?>re/report_excel/get_collection/"+branch+'/'+type+'/'+month);
	
}
function load_printscrean2(branch,type,from,to)
{
			window.open( "<?=base_url()?>re/report_excel/date_get_collection/"+branch+'/'+type+'/'+from+'/'+to);
	
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );
			
}



</script>
 <?
 if($month!=''){
  $heading2=' EP Collection as at '.$reportdata;
  $monthname=date('F', mktime(0, 0, 0, intval($month), 10));
 }
 else{
   $heading2=' EP Collection as at '.$reportdata;
    $monthname=date('F', mktime(0, 0, 0, intval(date('m')), 10));
 }
 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">  <? if(isset($fromdate) & isset($todate)){ ?>
       <a href="javascript:load_printscrean2('<?=$prj_id?>','03','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? }else{?>
          <a href="javascript:load_printscrean1('<?=$prj_id?>','03','<?=$month?>')"><i class="fa fa-file-excel-o nav_icon"></i></a>
   
       <? }?>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:500px; overflow:scroll" >
                     
      <table class="table table-bordered"><tr class="success"><th  rowspan="2">Project Name</th><th rowspan="2" >Lot Number</th><th rowspan="2" >Agreement Date</th>
      <th  rowspan="2"> Land Value </th> <th  rowspan="2"> Down Payment </th><th  rowspan="2"> Finance Value </th><th rowspan="2">Total Payments As at </th><th  colspan="2"> Total Payable as at <?=$sartdate?></th><th colspan="2"> Payments of Current  Period </th><th colspan="1" >Balance to be Received as at <?=$reportdata?> </th>
    
        </tr>
        <tr><th>Interest Due </th><th>Balance</th><th>Interest</th><th>Capital</th><th>Balance</th>
        </tr>
       
       
    <? 
	
	
			$fprjloanval=0;$fprjint=0; $fprjagreed=0; 
			$fprjopbalint=0;
			$fprjopbalcap=0;
			$fprjopbaltot=0;
			$fprjpayint=0;
			$fprjpaycap=0;
			$fprjpaydi=0;
			$fprjpayrent=0;
			$fprjclbalint=0;
			$fprjclbalcap=0;
			$fprjclbaltot=0;
			//echo $prjraw->prj_id;
			$prjrental=0;$prjlandval=0;$prjdownpay=0;
			$prjloanval=0;$prjint=0; $prjagreed=0; 
			$prjopbalint=0;
			$prjopbalcap=0;
			$prjopbaltot=0;
			$prjpayint=0;
			$prjpaycap=0;
			$prjpaydi=0;
			$prjpayrent=0;
			$prjclbalint=0;
			$prjclbalcap=0;
			$prjclbaltot=0;
			if($reservation[$prj_id]){
			?>
        <tr class="active"><td colspan="17"><?=$details[$prj_id]->project_name?></td><td></td>
        
        </tr>
        <?  
			foreach($reservation[$prj_id] as $raw){
					
						
							
		$opbalcap=$raw->loan_amount-$prevpayment[$raw->loan_code]->sum_cap;
		$paidtots=$prevpayment[$raw->loan_code]->sum_cap+$prevpayment[$raw->loan_code]->sum_int;
		$opbalint=$inttots[$raw->loan_code]-$prevpayment[$raw->loan_code]->sum_int;
		$opbal=$raw->loan_amount+$inttots[$raw->loan_code]-($paidtots);
		$clbalcap=$opbalcap-$thispayment[$raw->loan_code]->sum_cap;
		$clbalint=$opbalint-$thispayment[$raw->loan_code]->sum_int;
		$clbal=$opbal-($thispayment[$raw->loan_code]->sum_int+$thispayment[$raw->loan_code]->sum_cap);
		
			$totpaidcap=$prevpayment[$raw->loan_code]->sum_cap+$thispayment[$raw->loan_code]->sum_cap;
		$thispaidcap=0;
		
		if($clbal<0)
		{ //echo 'exxcess';
			$thispaidcap=$thispayment[$raw->loan_code]->sum_cap+$clbal;
		}
		else
		$thispaidcap=$thispayment[$raw->loan_code]->sum_cap;
		
		if($clbal<0)
		$clbal=0;
		$thispyament=$thispayment[$raw->loan_code]->sum_int+$thispayment[$raw->loan_code]->sum_cap;
		$flag=false;
		$status=$raw->loan_status;
		if($status=='CONFIRMED')
		$flag=true;
		if($thispyament>0)
		$flag=true;
		if($flag){
		
						$prjlandval=$prjlandval+$raw->discounted_price;
					
						$prjdownpay=$prjdownpay+$raw->down_payment;
						$prjloanval=$prjloanval+$raw->loan_amount;
						$prjint=$prjint+$inttots[$raw->loan_code];
						$prjagreed=$prjagreed+$paidtots;
						$prjopbalint=$prjopbalint+$opbalint;
						$prjopbalcap=$prjopbalcap+$opbalcap;
						$prjopbaltot=$prjopbaltot+$opbal;
						$prjpayint=$prjpayint+$thispayment[$raw->loan_code]->sum_int;
						$prjpaycap=$prjpaycap+$thispaidcap;
						$prjpaydi=$prjpaydi+$thispayment[$raw->loan_code]->sum_di;
						
						$prjclbaltot=$prjclbaltot+$clbal;
						
						
				?>
        <tr><td><a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->loan_code?></a></td><td><?=$raw->lot_number?></td><td><?=$raw->start_date?></td>
         <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($raw->down_payment,2)?></td>
          <td align="right"><?=number_format($raw->loan_amount,2)?></td>
             <td align="right"><?=number_format($paidtots,2)?></td>
           <td align="right"><?=number_format($inttots[$raw->loan_code],2)?></td>
                      <td align="right"><?=number_format($opbal,2)?></td>
              <td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_int,2)?></td>
                <td align="right"><?=number_format($thispaidcap,2)?></td>
                              <td align="right"><?=number_format($clbal,2)?></td>
             
           
        </tr>
        <?  }}?>
        
         <tr class="active" style="font-weight:bold"><td></td><td></td><td></td>
         <td align="right"><?=number_format($prjlandval,2)?></td>
         <td align="right"><?=number_format($prjdownpay,2)?></td>
          <td align="right"><?=number_format($prjloanval,2)?></td>
           <td align="right"><?=number_format($prjagreed,2)?></td>
            <td align="right"><?=number_format($prjint,2)?></td>
             <td align="right"><?=number_format($prjopbaltot,2)?></td>
             <td align="right"><?=number_format($prjpayint,2)?></td>
              <td align="right"><?=number_format($prjpaycap,2)?></td>
                                    <td align="right"><?=number_format($prjclbaltot,2)?></td>
        </tr>
        
      <?
	 
					
						
	  } ?>
        </table></div>
    </div> 
    
</div>