
<script type="text/javascript">

function load_printscrean1(branch,type,month)
{
			window.open( "<?=base_url()?>hm/report_excel/get_collection/"+branch+'/'+type+'/'+month);
	
}
function load_printscrean2(branch,type,from,to)
{
			window.open( "<?=base_url()?>hm/report_excel/date_get_collection/"+branch+'/'+type+'/'+from+'/'+to);
	
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>hm/eploan/get_loanfulldata_popup/"+id );
			
}


</script>
 <?
 if($month!=''){
  $heading2=' EP Collection  as at '.$reportdata;
  $monthname=date('F', mktime(0, 0, 0, intval($month), 10));
 }
 else{
   $heading2=' EP Collection  as at '.$reportdata;
    $monthname=date('F', mktime(0, 0, 0, intval(date('m')), 10));
 }
 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">   <? if(isset($fromdate) & isset($todate)){ ?>
       <a href="javascript:load_printscrean2('<?=$prj_id?>','02','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? }else{?>
          <a href="javascript:load_printscrean1('<?=$prj_id?>','02','<?=$month?>')"><i class="fa fa-file-excel-o nav_icon"></i></a>
   
       <? }?>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered"><tr class="success"><th  rowspan="2">Project Name</th><th rowspan="2" >Lot Number</th><th rowspan="2" >Monthly rental</th>
      <th  rowspan="2"> Land Value </th> <th  rowspan="2"> Down Payment </th><th  rowspan="2"> Finance Value </th><th rowspan="2">Interest Due </th><th rowspan="2">Agreed Value </th><th  colspan="3"> Total Payable as at <?=$sartdate?></th><th colspan="4"> Payments of Current  Period</th><th colspan="3" >Balance to be Received as at <?=$reportdata?> </th>
    
        </tr>
        <tr><th>Interest</th><th>Capital</th><th>Balance</th><th>Rental</th><th>Interest</th><th>Capital</th><th>Delay</th><th>Interest</th><th>Capital</th><th>Balance</th>
        </tr>
       
       
    <? 
	
	
	$fprjrental=0;$fprjlandval=0;$fprjdownpay=0;
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
			
			?>
        <tr class="active"><td colspan="17"><?=$details[$prj_id]->project_name?></td><td></td>
        
        </tr>
        <?  if($reservation[$prj_id]){
			foreach($reservation[$prj_id] as $raw){
				$monthtotcoll=0;$settlecap=0; $settleint=0;
				if($thispayment[$raw->loan_code])
					$monthtotcoll=$thispayment[$raw->loan_code]->sum_di+$thispayment[$raw->loan_code]->sum_cap+$thispayment[$raw->loan_code]->sum_int;
					if($settlepayment[$raw->loan_code])
					{$monthtotcoll=$monthtotcoll+$settlepayment[$raw->loan_code]->sum_cap+$settlepayment[$raw->loan_code]->sum_int;
					$settlecap=$settlepayment[$raw->loan_code]->sum_cap;
					$settleint=$settlepayment[$raw->loan_code]->sum_int;
					}
					$rptstatus=true;
					if($raw->loan_status=='SETTLED')
					{
						if($monthtotcoll>0)
						$rptstatus=true;
						else
						$rptstatus=false;
					}
					if($rptstatus){		
		$opbalcap=$raw->loan_amount-$prevpayment[$raw->loan_code]->sum_cap;
		$opbalint=$inttots[$raw->loan_code]-$prevpayment[$raw->loan_code]->sum_int;
		$opbal=$opbalcap+$opbalint;
		$clbalcap=$opbalcap-$thispayment[$raw->loan_code]->sum_cap-$settlecap;
		
		$clbalint=$opbalint-$thispayment[$raw->loan_code]->sum_int-$settleint;
		if($raw->loan_status=='SETTLED')
		{
		$clbalint=0;$clbalcap=0;}
		$clbal=$clbalint+$clbalcap;
		
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjrental=$prjrental+$raw->montly_rental;
						$prjdownpay=$prjdownpay+$raw->down_payment;
						$prjloanval=$prjloanval+$raw->loan_amount;
						$prjint=$prjint+$inttots[$raw->loan_code];
						$prjagreed=$prjagreed+$raw->loan_amount+$inttots[$raw->loan_code];
						$prjopbalint=$prjopbalint+$opbalint;
						$prjopbalcap=$prjopbalcap+$opbalcap;
						$prjopbaltot=$prjopbaltot+$opbal;
						$prjpayint=$prjpayint+$thispayment[$raw->loan_code]->sum_int+$settleint;
						$prjpaycap=$prjpaycap+$thispayment[$raw->loan_code]->sum_cap+$settlecap;
						$prjpaydi=$prjpaydi+$thispayment[$raw->loan_code]->sum_di;
						$prjpayrent=$prjpayrent+$thispayment[$raw->loan_code]->sum_int+$thispayment[$raw->loan_code]->sum_cap;
						$prjclbalint=$prjclbalint+$clbalint;
						$prjclbalcap=$prjclbalcap+$clbalcap;
						$prjclbaltot=$prjclbaltot+$clbal;
						
						
				?>
        <tr><td><a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->loan_code?></a></td><td><?=$raw->lot_number?></td>
          <td align="right"><?=number_format($raw->montly_rental,2)?></td>
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($raw->down_payment,2)?></td>
          <td align="right"><?=number_format($raw->loan_amount,2)?></td>
           <td align="right"><?=number_format($inttots[$raw->loan_code],2)?></td>
            <td align="right"><?=number_format($raw->loan_amount+$inttots[$raw->loan_code],2)?></td>
             <td align="right"><?=number_format($opbalint,2)?></td>
              <td align="right"><?=number_format($opbalcap,2)?></td>
                <td align="right"><?=number_format($opbal,2)?></td>
                     <td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_cap+$thispayment[$raw->loan_code]->sum_int,2)?></td>
              <td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_int+$settleint,2)?></td>
                <td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_cap+$settlecap,2)?></td>
                  <td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_di,2)?></td>
                     <td align="right"><?=number_format($clbalint,2)?></td>
                         <td align="right"><?=number_format($clbalcap,2)?></td>
                             <td align="right"><?=number_format($clbal,2)?></td>
             
           
        </tr>
        <? }}}?>
        
         <tr class="active" style="font-weight:bold"><td></td><td></td>
           <td align="right"><?=number_format($prjrental,2)?></td>
        <td align="right"><?=number_format($prjlandval,2)?></td>
         <td align="right"><?=number_format($prjdownpay,2)?></td>
          <td align="right"><?=number_format($prjloanval,2)?></td>
           <td align="right"><?=number_format($prjint,2)?></td>
            <td align="right"><?=number_format($prjagreed,2)?></td>
             <td align="right"><?=number_format($prjopbalint,2)?></td>
              <td align="right"><?=number_format($prjopbalcap,2)?></td>
                <td align="right"><?=number_format($prjopbaltot,2)?></td>
                     <td align="right"><?=number_format($prjpayrent,2)?></td>
              <td align="right"><?=number_format($prjpayint,2)?></td>
                <td align="right"><?=number_format($prjpaycap,2)?></td>
                  <td align="right"><?=number_format($prjpaydi,2)?></td>
                     <td align="right"><?=number_format($prjclbalint,2)?></td>
                         <td align="right"><?=number_format($prjclbalcap,2)?></td>
                             <td align="right"><?=number_format($prjclbaltot,2)?></td>
        </tr>
        
      <?
	 
						$fprjlandval=$fprjlandval+$prjlandval;
						$fprjrental=$fprjrental+$prjrental;
						$fprjdownpay=$fprjdownpay+$prjdownpay;
						$fprjloanval=$fprjloanval+$prjloanval;
						$fprjint=$fprjint+$prjint;
						$fprjagreed=$fprjagreed+$prjagreed;
						$fprjopbalint=$fprjopbalint+$prjopbalint;
						$fprjopbalcap=$fprjopbalcap+$prjopbalcap;
						$fprjopbaltot=$fprjopbaltot+$prjopbaltot;
						$fprjpayint=$fprjpayint+$prjpayint;
						$fprjpaycap=$fprjpaycap+$prjpaycap;
						$fprjpaydi=$fprjpaydi+$prjpaydi;
						$fprjpayrent=$fprjpayrent+$prjpayrent;
						$fprjclbalint=$fprjclbalint+$prjclbalint;
						$fprjclbalcap=$fprjclbalcap+$prjclbalcap;
						$fprjclbaltot=$fprjclbaltot+$prjclbaltot;
						
	 ?>
        </table></div>
    </div> 
    
</div>