
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">

function load_lotinquary(id,prj_id)
{
	 if(id!="")
	 {
		// var prj_id= document.getElementById("prj_id").value
	//	alert("<?=base_url()?>re/lotdata/get_fulldata/"+id+"/"+prj_id)
	 	 $('#popupform').delay(1).fadeIn(600);
   		   $( "#popupform").load( "<?=base_url()?>re/lotdata/get_fulldata_popup/"+id+"/"+prj_id );
	 }
}
function get_loan_detalis(id)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );

}
function add_followup_detalis(id,date)
{

 if(id!=""){


	 $('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_followupdata_popup/"+id+"/"+date);







 }
 else
 {

	 $('#followdata').delay(1).fadeOut(600);
 }
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
tableToExcel('table2excel2', 'Collection_zep', 'Collection_zep<?=date('Y_m_d');?>.xls');
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
  $heading2=' ZEP Collection Report as at '.$reportdata;
 }
 else{
   $heading2=' ZEP Collection Report as at '.$reportdata;
 }

 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms" id="table2excel2">
   <div class="form-title">
		<h4><?=$heading2?>
       <span style="float:right">   <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>


</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow" >
     <input type="hidden" id="rptdate" value="<?=$todate?>">
     <div class="tableFixHead">
       <table  class="table table-bordered table2excel" ><thead>
        <tr>
          <th colspan="24"><h4><?=$heading2?></h4></th>
        </tr>
         <tr class="success">
           <th rowspan="2">Project Name</th>
           <th rowspan="2">Customer Name</th>
           <th rowspan="2">Contact Number</th>
           <th rowspan="2">Reservation Date</th>
           <th  rowspan="2">Lot Number</th>
           <th  rowspan="2">Loan Code</th>
           <th  rowspan="2">Loan Period</th>
           <th rowspan="2"> Land Value </th>
            <th rowspan="2"> Loan Value </th>
           <th rowspan="2">Total Payment As at <?=$sartdate?></th>
           <th rowspan="2">Due Date</th>

           <th rowspan="2">Current Month Due Rental</th>
           <th rowspan="2">Total Due</th>
           <th colspan="6" style="text-align:center">Payment</th>
           <th rowspan="2">Total Paid As at <?=$reportdata?></th>
            <th rowspan="2">Balance</th>
           <th rowspan="2">Paid %</th>
           <th rowspan="2">Collection Person</th>
           <th rowspan="2">Sales Person</th>
         </tr>
         <tr class="success">
           <th>Payment Date</th>
           <th>Receipt Date</th>
           <th>Receipt Number</th>
           <th>Receipt Amount</th>
           <th>DI amount</th>
           <th>Total Paid This Month (Without DI)</th>
         </tr>


        </thead>


    <?


	if($prjlist){$fullprjlandval=0;$fullprjprvcap=0;$fullprjbal=0; $fullprjpayment=0; $fullprjlastbal=0;$fulldue=0;$fullcrdue=0;$fullrcpt=0;$fulldi=0;$fullloanval=0;$fullprjthispay=0;$fullprjtotpaid=0;
		foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjlandval=0;$prjprvcap=0;$prjbal=0; $prjpayment=0; $prjlastbal=0; $prjdue=0;$prjcrdue=0;
			$c=0;$prjrcpt=0;$prjdi=0;$prjloanval=0;$prjthispay=0;$prjtotpaid=0;
			?>

        <? if($type=='04'){  if($zepreservation[$prjraw->prj_id]){
			foreach($zepreservation[$prjraw->prj_id] as $raw){
        $settlecap=0;$settleint=0;$settlepayment_check=0;
        $check = check_loan_payment_date_period($raw->loan_code,$sartdate,$todate);//custom_helper
        if($settlepayment[$raw->loan_code])
          {//$monthtotcoll=$monthtotcoll+$settlepayment[$raw->loan_code]->sum_cap+$settlepayment[$raw->loan_code]->sum_int;
          $settlecap=$settlepayment[$raw->loan_code]->sum_cap - $settlepayment[$raw->loan_code]->sum_add_discnt - $settlepayment[$raw->loan_code]->sum_credit_int;
          $settleint=$settlepayment[$raw->loan_code]->sum_int;
          $settlepayment_check = $settlecap  + $settleint;
          }
        if($check){
				//if($currentlist[$raw->res_code]){
					$zprvpayment=0;$zthispayment=0;
					if($zepprevpayment[$raw->loan_code])
					$zprvpayment=$zepprevpayment[$raw->loan_code]->sum_cap;
					if($zepthispayment[$raw->loan_code])
					$zthispayment=$zepthispayment[$raw->loan_code]->sum_cap;
					$fullpayment=$zprvpayment;

					$flag=true;
				if($raw->loan_status=='SETTLED')
				$flag=false;
				if($zthispayment>0)
				$flag=true;
					if($raw->discounted_price!=$fullpayment){
						if($flag || $settlepayment_check>0){
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjprvcap=$prjprvcap+$fullpayment;
						$prjbal=$prjbal+($raw->discounted_price-$fullpayment);
						$prjpayment=$prjpayment+$zthispayment;
            $prjloanval=$prjloanval+$raw->loan_amount;
            $prjthispay=$prjthispay+$zthispayment;
            $prjtotpaid=$prjtotpaid+$fullpayment+$zthispayment;
						$last_bal=$raw->loan_amount - $zthispayment - $zprvpayment;
						$due=uptodate_arrears($raw->loan_code,$sartdate);
						$alldue=uptodate_arrears($raw->loan_code,$todate);
						$crdue=$alldue-$due;

            
             

						$prjdue=$prjdue+$due;
						$prjcrdue=$prjcrdue+$crdue;

						$prjlastbal=$prjlastbal+$last_bal;
						$balance=$raw->discounted_price-$fullpayment-$zthispayment;
						$openpresentage=(($fullpayment+$zthispayment)/$raw->loan_amount)*100;

						 $date1=date_create($raw->res_date);
						 $date2=date_create($todate);
						 $diff=date_diff($date1,$date2);
						 $aging=$diff->format("%a ");

						$lastpaydate=get_last_payment_date($raw->loan_code);
						 $date1=date_create($lastpaydate);
						 $date2=date_create($todate);
						  $diff=date_diff($date1,$date2);
						 $datelast=$diff->format("%a ");



				?>
       <tr   class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
        <td><?=$prjraw->project_name?> &nbsp; <a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->loan_code?></a></td>
        <td ><?=$raw->first_name?> <?=$raw->last_name?></td>
          <td ><?=$raw->mobile?><a href="javascript:add_followup_detalis('<?=$raw->loan_code?>','<?=$reportdata?>')"><i class="fa fa-phone nav_icon icon_red "></i></a></td>
          <td><?=$raw->res_date?></td>
        <td><?=$raw->lot_number?></td>
        <td><?=$raw->unique_code?></td>
        <td><?=$raw->period?>M</td>
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
        <td align="right"><?=number_format($raw->loan_amount,2)?></td>
         <td align="right"><?=number_format($fullpayment,2)?></td>
           
           <?
           $due_date="-";
           if(isset($month_shedule[$raw->loan_code]->deu_date)){
             $due_date=$month_shedule[$raw->loan_code]->deu_date;
           //}else{
             //$due_date=get_eploan_last_date($raw->loan_code,$raw->reschdue_sqn);
           }?>
           <td align="right"><?=$due_date?></td>
             
              <td align="right"><?=number_format($crdue,2)?></td>
               <td align="right"><?=number_format($due,2)?></td>
              <td colspan="5">
              <? if($zepthisreceipts[$raw->loan_code]){?>
              <table>
                <?
                foreach ($zepthisreceipts[$raw->loan_code] as $key => $value) {
                  $zthispayment_receipt=$value->sum_cap+$value->sum_int;
                   $prjrcpt=$prjrcpt +  floatval($zthispayment_receipt);
                   $prjdi=$prjdi + floatval($value->sum_di);
                  ?>
                  <tr>
                    <td><?=$value->income_date?></td>
                    <td><?=$value->entry_date?></td>
                    <td><?=$value->rct_no?></td>
               <td align="right"><?=number_format($zthispayment_receipt,2)?></td>
               <td align="right"><?=number_format($value->sum_di,2)?></td>

                  </tr>
                <?}?>
                </table>

                <?

              }?>

               <? if($zepsettlereceipts[$raw->loan_code]){?>
              <table>
                <?
                foreach ($zepsettlereceipts[$raw->loan_code] as $key => $value) {
                  $zthispayment_receipt=($value->sum_cap+$value->sum_int) - $value->sum_add_discnt - $value->sum_credit_int;
                   $prjrcpt=$prjrcpt +  floatval($zthispayment_receipt);
                   $prjdi=$prjdi + floatval($value->sum_di);
                  ?>
                  <tr>
                    <td><?=$value->income_date?></td>
                    <td><?=$value->entry_date?></td>
                    <td><?=$value->rct_no?></td>
               <td align="right"><?=number_format($zthispayment_receipt,2)?></td>
               <td align="right"><?=number_format($value->sum_di,2)?></td>

                  </tr>
                <?}?>
                </table>
                
                <?

              }?>
               </td>
                 <td align="right"><?=number_format($zthispayment,2)?></td>
                <td align="right"><?=number_format($fullpayment+$zthispayment,2)?></td>
                <td align="right"><?=number_format($last_bal,2)?></td>
                <td align="right"><?=number_format($openpresentage,2)?></td>

                <td><?=get_user_fullname_id($raw->sales_person)?></td>
                <td><?=get_user_fullname_id($raw->sales_person)?></td>

        </tr>
        <? }}}} }}?>
        <? if($prjlandval>0){?>
          <tr class="active" style="font-weight:bold">
         <td> <?=$prjraw->project_name?>  Total</td>
				 <td></td><td></td><td></td>
				 <td></td>
				 <td></td><td></td>
        <td align="right"><?=number_format($prjlandval,2)?></td>
         <td align="right"><?=number_format($prjloanval,2)?></td>
         <td align="right"><?=number_format($prjprvcap,2)?></td>
         <td></td>
          <td align="right"><?=number_format($prjcrdue,2)?></td>
           <td align="right"><?=number_format($prjdue,2)?></td>
           
         
         <td></td>
				 <td></td>
         
          <td align="right"></td>
          <td><?=number_format($prjrcpt,2)?></td> 
          <td><?=number_format($prjdi,2)?></td> 
          <td><?=number_format($prjthispay,2)?></td>
          <td><?=number_format($prjtotpaid,2)?></td>
          <td align="right"><?=number_format($prjlastbal,2)?></td>
          
          <td></td><td></td><td></td>
        </tr><? }?>

      <?
	  $fullprjlandval=$fullprjlandval+$prjlandval;
	  $fullprjprvcap=$fullprjprvcap+$prjprvcap;
	  $fullprjbal=$fullprjbal+$prjbal;
	  $fullprjpayment=$fullprjpayment+$prjpayment;
	  $fullprjlastbal=$fullprjlastbal+$prjlastbal;
	    $fulldue=$fulldue+$prjdue;
		$fullcrdue=$fullcrdue+$prjcrdue;
    $fullrcpt=$fullrcpt + $prjrcpt;
    $fulldi=$fulldi + $prjdi;
    $fullloanval=$fullloanval+$prjloanval;
    $fullprjthispay=$fullprjthispay+$prjthispay;
    $fullprjtotpaid=$fullprjtotpaid+$prjtotpaid;

	   }}?>
      <tr class="active" style="font-weight:bold"><td></td>
				<td></td><td></td><td></td>
				<td></td>
				<td></td><td></td>

        <td align="right"><?=number_format($fullprjlandval,2)?></td>
        <td align="right"><?=number_format($fullloanval,2)?></td>
         <td align="right"><?=number_format($fullprjprvcap,2)?></td>
         <td></td>
          <td align="right"><?=number_format($fullcrdue,2)?></td>
           <td align="right"><?=number_format($fulldue,2)?></td>
         
           <td></td>
					 <td></td>

          
            
          <td align="right"></td>
           <td><?=number_format($fullrcpt,2)?></td> 
            <td><?=number_format($fulldi,2)?></td>
            <td><?=number_format($fullprjthispay,2)?></td>
            <td><?=number_format($fullprjtotpaid,2)?></td>
             <td align="right"><?=number_format($fullprjlastbal,2)?></td>
            <td></td><td></td><td></td>
        </tr></tbody>
         </table></div></div>
    </div>

</div>
