
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
  $heading2=' EP Collection Report As At '.$reportdata;
  $monthname=date('F', mktime(0, 0, 0, intval($month), 10));
 }
 else{
   $heading2=' EP Collection Report As At '.$reportdata;
    $monthname=date('F', mktime(0, 0, 0, intval(date('m')), 10));
 }
 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">    
       	<div class="form-group" style="margin-left: 100%;">
            <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
         </div>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
       <div class="tableFixHead">        
      <table class="table table-bordered" id="table"><thead>
      	<tr>
      		<th colspan="22"><h4><?=$heading2?></h4></th>
      	</tr>
      	<tr class="success"><th  rowspan="2">Project Name</th><th  rowspan="2">Loan Code</th><th rowspan="2" >Lot Number</th>
      <th  rowspan="2"> Land Value </th> <th  rowspan="2"> Down Payment </th><th  rowspan="2"> Finance Value </th><th rowspan="2">Interest Due </th><th rowspan="2">Agreed Value </th><th rowspan="2" >Monthly rental</th><th  colspan="3"> Total Payable as at <?=$sartdate?></th><th colspan="7"> Payments of Current  Period</th><th colspan="3" >Balance to be Received as at <?=$reportdata?> </th>
    
        </tr>
        <tr><th>Interest</th><th>Capital</th><th>Balance</th><th>Payment Date</th><th>Receipt Date</th><th>Receipt Number</th><th>Rental</th><th>Interest</th><th>Capital</th><th>Delay</th><th>Interest</th><th>Capital</th><th>Balance</th>
        </tr></thead>
       
       
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
			$prjpayamount=0;
			
			
			?>
       
        <?  if($reservation[$prjraw->prj_id]){
			foreach($reservation[$prjraw->prj_id] as $raw){
					$monthtotcoll=0; $settlecap=0; $settleint=0;$settledi=0;$settlepayment_check=0; 
				if($thispayment[$raw->loan_code])
					$monthtotcoll=$thispayment[$raw->loan_code]->sum_di+$thispayment[$raw->loan_code]->sum_cap+$thispayment[$raw->loan_code]->sum_int;
					if($settlepayment[$raw->loan_code])
					{$monthtotcoll=$monthtotcoll+$settlepayment[$raw->loan_code]->sum_cap+$settlepayment[$raw->loan_code]->sum_int;
					$settlecap=$settlepayment[$raw->loan_code]->sum_cap - $settlepayment[$raw->loan_code]->sum_add_discnt - $settlepayment[$raw->loan_code]->sum_credit_int;
					$settleint=$settlepayment[$raw->loan_code]->sum_int;
					$settledi=$settlepayment[$raw->loan_code]->sum_di;//Ticket No:2791 Added By Madushan 2021.05.10
					$settlepayment_check = $settlecap + $settledi + $settleint;
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
		if($thispayment[$raw->loan_code]->pay_amount !=0 || $settlepayment_check !=0){
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
						$prjpaycap=$prjpaycap+$thispayment[$raw->loan_code]->sum_cap+$settlecap;;
						$prjpaydi=$prjpaydi+$thispayment[$raw->loan_code]->sum_di+$settledi;//Ticket No:2791 Added By Madushan 2021.05.10
						$prjpayrent=$prjpayrent+$thispayment[$raw->loan_code]->sum_int+$thispayment[$raw->loan_code]->sum_cap;
						$prjclbalint=$prjclbalint+$clbalint;
						$prjclbalcap=$prjclbalcap+$clbalcap;
						$prjclbaltot=$prjclbaltot+$clbal;
						$prjpayamount=$prjpayamount+$thispayment[$raw->loan_code]->pay_amount;
						
						
				?>
		
        <tr><td><?=$prjraw->project_name?></td><td><a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->loan_code?></a></td><td><?=$raw->lot_number?></td>
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($raw->down_payment,2)?></td>
          <td align="right"><?=number_format($raw->loan_amount,2)?></td>
           <td align="right"><?=number_format($inttots[$raw->loan_code],2)?></td>
            <td align="right"><?=number_format($raw->loan_amount+$inttots[$raw->loan_code],2)?></td>
             <td align="right"><?=number_format($raw->montly_rental,2)?></td>
             <td align="right"><?=number_format($opbalint,2)?></td>
              <td align="right"><?=number_format($opbalcap,2)?></td>
                <td align="right"><?=number_format($opbal,2)?></td>
                 <td colspan="3">
              <? if($epthisreceipts[$raw->loan_code]){?>
              <table>
                <?
                foreach ($epthisreceipts[$raw->loan_code] as $key => $value) {
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

               <? if($epsettlereceipts[$raw->loan_code]){?>
              <table>
                <?
                foreach ($epsettlereceipts[$raw->loan_code] as $key => $value) {
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
              
                     <td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_cap+$thispayment[$raw->loan_code]->sum_int,2)?></td>
                   
                  
                   	<td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_int+$settleint,2)?></td>
                   	
              	
              		<td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_cap+$settlecap,2)?></td>
              		
                 
                 	<td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_di+$settledi,2)?></td><!-- Ticket No:2791 Added By Madushan 2021.05.10 -->
                     <td align="right"><?=number_format($clbalint,2)?></td>
                         <td align="right"><?=number_format($clbalcap,2)?></td>
                             <td align="right"><?=number_format($clbal,2)?></td>
             
           
        </tr>
        <? }}}}?>
        <? if($prjrental>0 && ($prjpayamount !=0 || $settlepayment_check !=0)){?>
         <tr class="active" style="font-weight:bold"><td colspan="2"> <?=$prjraw->project_name?> Total</td><td></td>
           
        <td align="right"><?=number_format($prjlandval,2)?></td>
         <td align="right"><?=number_format($prjdownpay,2)?></td>
          <td align="right"><?=number_format($prjloanval,2)?></td>
           <td align="right"><?=number_format($prjint,2)?></td>
            <td align="right"><?=number_format($prjagreed,2)?></td>
            <td align="right"><?=number_format($prjrental,2)?></td>
             <td align="right"><?=number_format($prjopbalint,2)?></td>
              <td align="right"><?=number_format($prjopbalcap,2)?></td>
                <td align="right"><?=number_format($prjopbaltot,2)?></td>
                <td colspan="3"></td>
               	<td align="right"><?=number_format($prjpayrent,2)?></td>
				<td align="right"><?=number_format($prjpayint,2)?></td>
				<td align="right"><?=number_format($prjpaycap,2)?></td>
 				<td align="right"><?=number_format($prjpaydi,2)?></td>
                	
             
               
                 
                     <td align="right"><?=number_format($prjclbalint,2)?></td>
                         <td align="right"><?=number_format($prjclbalcap,2)?></td>
                             <td align="right"><?=number_format($prjclbaltot,2)?></td>
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
						
	   }}?>
       <tr class="active" style="font-weight:bold"><td colspan="2"></td><td></td>
           
      	  <td align="right"><?=number_format($fprjlandval,2)?></td>
       	  <td align="right"><?=number_format($fprjdownpay,2)?></td>
          <td align="right"><?=number_format($fprjloanval,2)?></td>
          <td align="right"><?=number_format($fprjint,2)?></td>
          <td align="right"><?=number_format($fprjagreed,2)?></td>
          <td align="right"><?=number_format($fprjrental,2)?></td>
          <td align="right"><?=number_format($fprjopbalint,2)?></td>
             <td align="right"><?=number_format($fprjopbalcap,2)?></td>
               <td align="right"><?=number_format($fprjopbaltot,2)?></td>
               <td colspan="3"></td>
			<td align="right"><?=number_format($fprjpayrent,2)?></td>
			<td align="right"><?=number_format($fprjpayint,2)?></td>
			 <td align="right"><?=number_format($fprjpaycap,2)?></td>
			<td align="right"><?=number_format($fprjpaydi,2)?></td>

                     <td align="right"><?=number_format($fprjclbalint,2)?></td>
                         <td align="right"><?=number_format($fprjclbalcap,2)?></td>
                             <td align="right"><?=number_format($fprjclbaltot,2)?></td>
        </tr>   </table></div></div>
    </div> 
    
</div>

<script type="text/javascript">
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
   tableToExcel('table', 'EP Collection Report', 'ep_collection_report_as_at_<?=$reportdata;?>.xls');
 });    
</script>