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
 <h4>Ledger Card <?if($dataset){echo $details->loan_code;}else{echo $res_code;}?> <a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a><span  style="float:right; color:#FFF" ><a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
<div class="tableFixHead">
<table class="table" id="table">
   <tr>
    <td><strong>Project Name</strong></td><td><?=$details->project_name?></td>
    <td><strong>Lot No</strong></td><td><?=$details->lot_number?></td>
  </tr>
  <tr>
    <td><strong>Customer Name</strong></td><td><?=$details->first_name ?> &nbsp; <?=$details->last_name ?></td>
    <td><strong>NIC</strong></td><td><?=$details->id_number ?></td>
  </tr>
   <tr>
    <td><strong>Loan Number</strong></td><td><?=$details->unique_code;?></td>
    <td><strong>Article Value</strong></td><td><?=number_format($details->discounted_price,2) ?></td>
    <td><strong>Monthly Rental</strong></td><td><?=number_format($details->montly_rental,2)  ?></td>
  </tr>
   <?if($advance_shedule){?>
   <tr><th colspan="7" style="text-align:center;">Advance Payments</th></tr>
  <tr><th>Due Date</th> <th> Instalment</th> <th>Remart</th>  <th>Monthly  Rental</th><th>Rental Payment</th><th>DI Payment</th><th>Balance</th></tr> 
    
             <!-- Ticket No:2889 Added by Madushan 2021.06.14 -->
             <? $first_advance_payment =  $first_advance_balance = 0;?>
             <?if($first_advance_payments){
              foreach($first_advance_payments as $first_row){
                  $first_advance_payment = $first_advance_payment + $first_row->amount;
                  $first_advance_balance=$first_advance_balance-$first_row->amount?>
                <tr>
                        <td><?=$first_row->income_date;?></td>
                        <td></td>
                        <td><?=$first_row->rct_no;?></td>
                        <td></td>
                        <td><?=number_format($first_row->amount,2);?></td> 
                        <td></td> 
                        <td><?=number_format($first_advance_balance,2)?></td>  
                      </tr>
                <?}}?>
            
              <?$advance_balance = 0;$advance_payments=0;?>
               <? foreach($advance_shedule as $row){
                  $advance_balance = $advance_balance + $row->amount + $first_advance_balance;
                  ?>
                  <tr class="info">
                   <th><?=$row->due_date;?></th>
                   <th><?=$row->installment_number;?></th>
                   <td>Instalment</td>
                   <td><?=number_format($row->amount,2)?></td>
                   <td></td>
                   <td></td>
                   <td><?=number_format($advance_balance,2);?></td>
                  </tr>
                  <?if($advance_payment[$row->installment_number]){
                    foreach($advance_payment[$row->installment_number] as $payadvance){
                      $advance_payments=$payadvance->amount;
                      $advance_balance=$advance_balance-$advance_payments;
                       ?>
                      <tr>
                        <td><?=$payadvance->income_date;?></td>
                        <td></td>
                        <td><?=$payadvance->rct_no;?></td>
                        <td></td>
                        <td><?=number_format($payadvance->amount,2);?></td> 
                        <td></td> 
                        <td><?=number_format($advance_balance,2)?></td>  
                      </tr>
              <?}}
              $first_advance_balance = 0;
              }}?>
              <!--End of Ticket No:2889-->

                  <!-- Ticket No:2817 Added by Madushan 2021.05.12 -->
    <?if($dataset){?>
    <tr><th colspan="7" style="text-align:center;">Loan Payments</th></tr>
  <tr><th>Due Date</th> <th> Instalment</th> <th>Remart</th>  <th>Monthly  Rental</th><th>Rental Payment</th><th>DI Payment</th><th>Balance</th></tr> 
  <?}?>
                  <?$firstpayment = 0;$arrtot=0;
                  if($first_payments){
            foreach($first_payments as $row){
               $totpay=$row->tot_cap+$row->tot_int;
               $firstpayment = $firstpayment + $totpay;
               $arrtot=$arrtot-$totpay?>
              <tr > 
                  <th scope="row"><?=$row->income_date?></th> 
                  <th scope="row"></th> <td><?=$row->RCT?></td> <td></td>
                  <td><?=number_format($totpay,2) ?></td> 
                  <td><?=number_format($row->tot_di,2) ?></td> 
                  <td><?=number_format($arrtot,2) ?></td> 
                  </tr>
              <?}}?> 

                      <? if($dataset){$c=0;
					  $arrtot=0;
                          foreach($dataset as $row){
							   $arrtot= $arrtot+$row->tot_instalment-$firstpayment;
							   
							  
							  ?>
                      
                        <tbody>

                          <tr class="info">


                          <th scope="row"><?=$row->deu_date?></th> 
                        <th scope="row"><?=$row->instalment?></th> <td>Instalment</td> <td><?=number_format($row->tot_instalment,2) ?></td>
                            <td></td> 
                             <td></td> 
                             <td><?=number_format($arrtot,2) ?></td> 
                         </tr>
                         <? if($paydata[$row->instalment]){
							 foreach ($paydata[$row->instalment] as $payraw){
							 $totpay=$payraw->tot_cap+$payraw->tot_int;
							 $arrtot=$arrtot-$totpay
							 ?>
                         <tr > 
                          <th scope="row"><?=$payraw->income_date?></th> 
                        <th scope="row"></th> <td><?=$payraw->RCT?></td> <td></td>
                              <td><?=number_format($totpay,2) ?></td> 
                             <td><?=number_format($payraw->tot_di,2) ?></td> 
                             <td><?=number_format($arrtot,2) ?></td> 
                         </tr>
                         <? }}?> 
                        
                                <? $firstpayment=0;}} ?>

                                 <?$lastpayment = 0;
                if($last_payments){
            foreach($last_payments as $row){
               $totpay=$row->tot_cap+$row->tot_int;
               $lastpayment = $lastpayment + $totpay;
               $arrtot=$arrtot-$totpay?>
              <tr > 
                  <th scope="row"><?=$row->income_date?></th> 
                  <th scope="row"></th> <td><?=$row->RCT?></td> <td></td>
                  <td><?=number_format($totpay,2) ?></td> 
                  <td><?=number_format($row->tot_di,2) ?></td> 
                  <td><?=number_format($arrtot,2) ?></td> 
                  </tr>
              <?}}?> 

                 <?if($rebate){
                       $balance = $arrtot - $rebate->balance_capital-$rebate->credit_int-$rebate->new_discount-$rebate->int_paidamount - $rebate->int_release;
                       $paid_amount = $rebate->balance_capital-$rebate->credit_int-$rebate->new_discount + $rebate->int_paidamount;
                      ?>  
                  <tr><th colspan="7" style="text-align:center;">Early Settlement</th></tr>
                     
                    <tr>
                      <th scope="row"><?=$rebate->apply_date?></th>
                      <th></th>
                      <td><?=$rebate->rct_no?></td>
                      <td></td>
                      <td><?=number_format($paid_amount,2)?></td>
                      <td><?=number_format($rebate->delay_int ,2) ?></td>
                      <td><?=number_format($balance ,2) ?></td>
                    </tr>
                <?}?>


                     

                          </tbody></table>  

</div>

				            
                                    
                                 <br /></div>
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
  tableToExcel('table', 'Ledger Card', 'ledger_card_<?=$details->unique_code?>.xls');
 });
</script>