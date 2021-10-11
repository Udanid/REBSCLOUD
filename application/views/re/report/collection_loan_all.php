<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">

function load_printscrean1(branch,type,month)
{
			window.open( "<?=base_url()?>re/report_excel/get_collection_all/"+branch+'/'+type+'/'+month);
	
}
function load_printscrean2(branch,type,from,to)
{
			window.open( "<?=base_url()?>re/report_excel/date_get_collection_all/"+branch+'/'+type+'/'+from+'/'+to);
	
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );
			
}
</script>
<script>
$(document).ready(function() {
var tableToExcel = (function() {
var uri = 'data:application/vnd.ms-excel;base64,'
, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
return function(table, name, fileName) {
if (!table.nodeType) table = document.getElementById(table)
var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}

var link = document.createElement("A");
link.href = uri + base64(format(template, ctx));
link.download = fileName || 'Workbook.xls';
link.target = '_blank';
document.body.appendChild(link);
link.click();
document.body.removeChild(link);
}
})();

$('#create_excel').click(function(){
tableToExcel('table', 'Bank Loan Collection Report', 'bank_loan_collection_as_at_<?=date('Y_m_d');?>.xls');
// util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
});
});

</script>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
</script>
<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
 <?
 if($month!=''){
  $heading2=' Bank Loan Collection Report as at '.$reportdata;
  $monthname=date('F', mktime(0, 0, 0, intval($month), 10));
 }
 else{
   $heading2=' Bank Loan Collection Report as at '.$reportdata;
    $monthname=date('F', mktime(0, 0, 0, intval(date('m')), 10));
 }
 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow">
         <input type="hidden" id="rptdate" value="<?=$todate?>">
      <div class="tableFixHead">          
      <table  class="table table-bordered" id="table"><thead>
      	<tr>
      		<th colspan="22"><h4><?=$heading2?></h4></th>
      	</tr>
      	<tr class="success"><th  rowspan="2">Reservation Code</th><th  rowspan="2">Reservation Date</th><th  rowspan="2">Project Name</th><th   rowspan="2">Lot Number</th><th  rowspan="2" >Loan Code</th><th rowspan="2">Customer Name</th><th rowspan="2">Contact Number</th>
      <th  rowspan="2"> Land Value </th> <th  rowspan="2"> Loan Value </th><th width="50" rowspan="2">Paid Amounts as at <?=$sartdate?></th><th  rowspan="2">balance%</th><th width="50"  rowspan="2">Balance to be Received as at <?=$sartdate?> </th>
      <th colspan="6" style="text-align:center">Payment For this Month</th> <th  rowspan="2">Balance</th><th rowspan="2">Paid%</th><th rowspan="2">Sales Person</th>
        </tr>
        <tr>
        	<th>Total Payment</th>
        	<th>Payment Date</th>
        	<th>Receipt Date</th>
        	<th>Receipt Number</th>
        	<th>Payment Capital</th>
        	<th>Delay Int</th>
        </tr>
       
       </thead>
       
       
    <? 
	
	
	if($prjlist){$fprjrental=0;$fprjlandval=0;$fprjdownpay=0;
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
			$fprjcrdue=0;
			$fprjtotpayment=0;
			$fprjcap=0;
			$fprjdi=0;
		foreach($prjlist as $prjraw){
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
			$prjcrdue=0;
			$prjpayamount=0;
			$prjrcpt=0;
			$prjdi=0;
			$prjtotpayment=0;
			$prjcap=0;

			
			?>
       
        <?  if($reservation[$prjraw->prj_id]){
			foreach($reservation[$prjraw->prj_id] as $raw){
					$monthtotcoll=0; $settlecap=0; $settleint=0;$settlepayment_check=0;$epbthispayment_cap=0;$di=0;$totpayment=0;
				if($thispayment[$raw->loan_code])
					$monthtotcoll=$thispayment[$raw->loan_code]->sum_di+$thispayment[$raw->loan_code]->sum_cap+$thispayment[$raw->loan_code]->sum_int;
					if($settlepayment[$raw->loan_code])
					{$monthtotcoll=$monthtotcoll+$settlepayment[$raw->loan_code]->sum_cap+$settlepayment[$raw->loan_code]->sum_int;
					$settlecap=$settlepayment[$raw->loan_code]->sum_cap - $settlepayment[$raw->loan_code]->sum_add_discnt - $settlepayment[$raw->loan_code]->sum_credit_int;
					$settleint=$settlepayment[$raw->loan_code]->sum_int;
					$settlepayment_check = $settlecap  + $settleint;
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
		if($raw->loan_status=='SETTLED'){
		$clbalint=0;$clbalcap=0;}
		$clbal=$clbalint+$clbalcap;
		
		
						
						 $date1=date_create($raw->res_date);
						 $date2=date_create($todate);
						 $diff=date_diff($date1,$date2);
						 $aging=$diff->format("%a ");
						
						$lastpaydate=get_last_payment_date($raw->loan_code);
						 $date1=date_create($lastpaydate);
						 $date2=date_create($todate);
						  $diff=date_diff($date1,$date2);
						 $datelast=$diff->format("%a ");
		
		$fullpayment=$prevpayment[$raw->loan_code]->sum_cap;
		$due=uptodate_arrears($raw->loan_code,$sartdate);
		$alldue=uptodate_arrears($raw->loan_code,$todate);
		$crdue=$alldue-$due;
		$openpresentage=(($raw->loan_amount-$fullpayment)/$raw->loan_amount)*100;
		if($thispayment[$raw->loan_code]->pay_amount !=0 || $settlepayment_check !=0){
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjrental=$prjrental+$raw->montly_rental;
						$prjdownpay=$prjdownpay+$raw->down_payment;
						$prjloanval=$prjloanval+$raw->loan_amount;
						$prjint=$prjint+$inttots[$raw->loan_code];
						$prjagreed=$prjagreed+$raw->loan_amount+$inttots[$raw->loan_code];
						$prjopbalint=$prjopbalint+$opbalint;
						$prjopbalcap=$prjopbalcap+$fullpayment;
						$prjopbaltot=$prjopbaltot+$opbal;
						$prjpayint=$prjpayint+$thispayment[$raw->loan_code]->sum_int+$settleint;
						$prjpaycap=$prjpaycap+$thispayment[$raw->loan_code]->sum_cap+$settlecap;;
						$prjpaydi=$prjpaydi+$thispayment[$raw->loan_code]->sum_di;
						$prjpayrent=$prjpayrent+$thispayment[$raw->loan_code]->sum_int+$thispayment[$raw->loan_code]->sum_cap;
						$prjclbalint=$prjclbalint+$clbalint;
						$prjclbalcap=$prjclbalcap+$clbalcap;
						$prjclbaltot=$prjclbaltot+$due;
						$prjcrdue=$prjcrdue+$crdue;
						$prjpayamount=$prjpayamount+$thispayment[$raw->loan_code]->pay_amount;
						



           	if($epbthisreceipts[$raw->loan_code]){
             	foreach ($epbthisreceipts[$raw->loan_code] as $key => $value){
                   $epbthispayment_cap=$epbthispayment_cap+$value->sum_cap;
                   $di =  $di + $value->sum_di;
                   $totpayment = $totpayment + $value->sum_cap +$value->sum_int + $value->sum_di;
                 
                }
			}

            if($epbsettlereceipts[$raw->loan_code]){
                foreach ($epbsettlereceipts[$raw->loan_code] as $key => $value) {
                   $epbthispayment_cap=$epbthispayment_cap+$value->sum_cap;
                   $di = $di + $value->sum_di;
                   $totpayment = ($totpayment + $value->sum_cap + $value->sum_int) - $value->sum_add_discnt - $value->sum_credit_int;;
                 
                }
            }
               
					$prjtotpayment=$prjtotpayment + $totpayment;
					$prjcap=$prjcap + $epbthispayment_cap;
					$prjdi=$prjdi + $di;
						
				?>
      <tr ><td><?=$raw->res_code?></td>
      <td><?=$raw->res_date?></td>
      <td><?=$prjraw->project_name?> &nbsp; <a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->loan_code?></a></td>
      <td><?=$raw->lot_number?></td>
      <td><?=$raw->period?> M - <?=$raw->unique_code?></td>
       <td align="right"><?=$raw->first_name?> <?=$raw->last_name?></td>
                <td align="right"><?=$raw->mobile?><a href="javascript:add_followup_detalis('<?=$raw->loan_code?>','<?=$reportdata?>')"><i class="fa fa-phone nav_icon icon_red "></i></a></td>
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
        <td align="right"><?=number_format($raw->loan_amount,2)?></td>
         <td align="right"><?=number_format($fullpayment,2)?></td>
           <td align="right"><?=number_format($openpresentage,2)?></td>
          <td align="right"><?=number_format($raw->loan_amount-$fullpayment,2)?></td>
          
             
             
               <td align="right"><?=number_format($totpayment,2)?></td>
                <td colspan="3">
              <? if($epbthisreceipts[$raw->loan_code]){?>
              <table>
                <?
                foreach ($epbthisreceipts[$raw->loan_code] as $key => $value) {
                  ?>
                  <tr>
                  	<td><?=$value->income_date?></td>
                    <td><?=$value->entry_date?></td>
                    <td><?=$value->rct_no?></td>

                  </tr>
                <?}?>
                </table>

                <?

              }?>

               <? if($epbsettlereceipts[$raw->loan_code]){?>
              <table>
                <?
                foreach ($epbsettlereceipts[$raw->loan_code] as $key => $value) {
                  ?>
                  <tr>
                  	<td><?=$value->income_date?></td>
                    <td><?=$value->entry_date?></td>
                    <td><?=$value->rct_no?></td>

                  </tr>
                <?}?>
                </table>
                
                <?

              }?>
               </td>
           <td align="right"><?=number_format($epbthispayment_cap,2)?></td>
             <td align="right"><?=number_format($di,2)?></td>
            <td align="right"><?=number_format($clbalcap,2)?></td>
             <td>
            
            
            <? $presentage=round(($raw->loan_amount-$clbalcap)/$raw->loan_amount*100,2);
						     if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';?>
                              
		
                         <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
            </td>
             
                
                <td><?=get_user_fullname_id($raw->sales_person)?></td>
                </tr>
        <? }}}}?>
        <? if($prjrental>0 && ($prjpayamount!=0 || $settlepayment_check !=0)){?>
         <tr class="active" style="font-weight:bold"><td> <?=$prjraw->project_name?>  Total</td><td></td><td></td><td></td><td></td><td></td><td></td>
        <td align="right"><?=number_format($prjlandval,2)?></td>
        <td align="right"><?=number_format($prjloanval,2)?></td>
         <td align="right"><?=number_format($prjopbalcap,2)?></td><td></td>
          <td align="right"><?=number_format($prjloanval-$prjopbalcap,2)?></td>
           	<td align="right"><?=number_format($prjtotpayment,2)?>
           </td><td></td><td></td><td></td>
          <td align="right"><?=number_format($prjcap,2)?></td>
          <td align="right"><?=number_format($prjdi,2)?></td>
           <td align="right"><?=number_format($prjclbalcap,2)?></td>
          <td></td><td></td>
        </tr>
        </tr>
        <? }?>
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
						$fprjcrdue=$fprjcrdue+$prjcrdue;
						$fprjtotpayment=$fprjtotpayment+$prjtotpayment;
						$fprjcap=$fprjcap+$prjcap;
						$fprjdi=$fprjdi+$prjdi;
						
	   }}?>
        <tr class="active" style="font-weight:bold"><td></td><td></td><td></td><td></td><td></td>
        	<td></td><td></td>
        <td align="right"><?=number_format($fprjlandval,2)?></td>
        <td align="right"><?=number_format($fprjloanval,2)?></td>
         <td align="right"><?=number_format($fprjopbalcap,2)?></td><td></td>
          <td align="right"><?=number_format($fprjloanval-$fprjopbalcap,2)?></td>
            	<td align="right"><?=number_format($fprjtotpayment,2)?>
            </td><td></td><td></td><td></td>
           <td align="right"><?=number_format($fprjcap,2)?></td>
             <td align="right"><?=number_format($fprjdi,2)?></td>
              <td align="right"><?=number_format($fprjclbalcap,2)?></td>

          <td></td><td></td>
        </tr></table></div></div>
    </div> 
    
</div>