
<script type="text/javascript">

function load_printscrean1(month,prjid)
{
      window.open( "<?=base_url()?>re/report/get_stock_all_print/"+month);
  
}
function expoet_excel(month,branch)
{
    
    
        window.open( "<?=base_url()?>re/report/arreas_data_date_excel/"+month+'/'+branch);
}
function expoet_excel2(month,branch)
{
    
    
        window.open( "<?=base_url()?>re/report/arreas_data_excel_ins/"+month+'/'+branch);
}
function get_loan_detalis(id)
{
  
    // var vendor_no = src.value;
//alert(id);
        
    
          $('#popupform').delay(1).fadeIn(600);
          
          $( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );
      
}
</script>
<style type="text/css">

</style>
 <?
  $heading2=' ZERO INTEREST (ZEP) Arrears Report as at '.$date;

 

 ?>

<div class="row">
  <div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
    <h4><?=$heading2?> 
       <span style="float:right"> <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
</span></h4>
  </div>
     <div class="table-responsive bs-example widget-shadow" style="max-height:400px; overflow:scroll">
                
      <table class="table table-bordered" id="table">
       <tr>
        <th colspan="26" style="text-align:center;"><h4>ZERO INTEREST (ZEP) Arrears Report as at <?=$date?></h4></th>
      </tr>
     <tr class="active"><th> Project Name </th><th>LOT Number</th>
      <th>Lot Type</th>
     <th>Customer Name</th>
     <th>Customer Contact Number</th>
      <th>Loan Capital</th>
     <th>Repayment Period (Months)</th>
      <th>Monthly Instalment</th>
      <th>Commensing Date</th>
      <th>Due Date</th>
          <th >Opening Balance as at <?=$sartdate?></th>
          <th>Current Month Due Amount</th>
          <th>Total Due</th>
          <th>Current Month Payment Date</th>
         <th >Recieved Amount During the month</th>
         <th >Arrears Balance as at <?=$date?> (L-N)</th>
         <th>Last Payment Date</th>
          <th >Arrears number of Rental</th>
          
          <th >Balance Capital As At <?=$date?></th>
        
     <th >Date of action</th>
     <th >Action</th>
    <th >Customer Feedback</th>
     <th >Officer Feedbak</th>
    
          </tr>
   
   
       
       <? $fulltot=0;?>
       
       <? 
    $fstartarrarstot=0;$farrtot=0; $fthismonthpay=0;
     $flontot=0;$finttot=0; 
     $ballontot=0;$balinttot=0;
     $instalment_tot=0;
      $due_tot=0;
      $current_month_due_tot=0; 
     if($prjlist){foreach($prjlist  as $prraw){ ?> 
  
        <?  if($transferlist[$prraw->prj_id]){
      
      ?>
              <tr class="active" style="font-weight:bold"><td><?=$details[$prraw->prj_id]->project_name?></td><td colspan="27"></td></tr>

            <?
      foreach($transferlist[$prraw->prj_id] as $raw){
        //print_r($arrearspay[$raw->res_code]);
        $arrearsmonth=0;$thismonthpay=0;$arrinscount=0;$creditmonth=0;$arrtot=0;
                $startarrarstot=0;$total_due=0;
        $fullint=0;
        $ful_tot=loan_due_totals_loancode($raw->loan_code,'',$raw->reschdue_sqn);
        if($ful_tot)
        {
          $fullint=$ful_tot->due_int;
        }
        $balcap=$raw->loan_amount;
        $balint=$fullint;
        $stpaytot=0;$stduetot=0;
                $startpaytot=loan_paid_totals_loancode($raw->loan_code,$sartdate,$raw->reschdue_sqn);
        $startduetot=loan_due_totals_loancode($raw->loan_code,$sartdate,$raw->reschdue_sqn);
        if($startpaytot)
        {
          $stpaytot=$startpaytot->paid_cap+$startpaytot->paid_int;
        }
        if($startduetot)
        {
          $stduetot=$startduetot->due_cap+$startduetot->due_int;
        }
        $endpaytot=loan_paid_totals_loancode($raw->loan_code,$date,$raw->reschdue_sqn);
        $endduetot=loan_due_totals_loancode($raw->loan_code,$date,$raw->reschdue_sqn);
        $epaytot=0;$eduetot=0;
        if($endpaytot)
        {
          $epaytot=$endpaytot->paid_cap+$endpaytot->paid_int;
          $balcap=$raw->loan_amount-$endpaytot->paid_cap;
          $balint=$fullint-$endpaytot->paid_int;
        }
        if($endduetot)
        {
          $eduetot=$endduetot->due_cap+$endduetot->due_int;
        }
        
        
        
         $thismonthpay=$epaytot-$stpaytot;
         if($thismonthpay<0)
         $thismonthpay=0;
         $startarrarstot=$stduetot-$stpaytot;
        $arrtot=$eduetot-$epaytot;
                $closins=round($arrtot/$raw->montly_rental,0);
                    $myclass="";
         if($closins >= 3)
         $myclass="red";
         
        
         
         
          ?>
                
        <tr class="<?=$myclass?>"><td><a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->unique_code?></a></td><td><?=$raw->lot_number?></td>
          <td><?=$raw->lot_type;?></td>
            <td><?=$raw->first_name?> <?=$raw->last_name?></td>
             <td><?=$raw->mobile?></td>
              <td align="right"><?=number_format($raw->loan_amount,2)?></td>
              <td align="right"><?=$raw->period?></td>
          <td align="right"><?=number_format($raw->montly_rental,2)?></td>
          <td align="right"><?=$raw->start_date?></td>
           <td>
                  <?if(isset($current_month_details[$raw->loan_code]->deu_date)){?>
                <?=$current_month_details[$raw->loan_code]->deu_date?>
                <?}?>
                </td>
            <td align="right"><?=number_format($startarrarstot,2)?></td>
            <td align="right">
                <?if(isset($current_month_details[$raw->loan_code]->tot_instalment)){?>
                <?=number_format(($current_month_details[$raw->loan_code]->tot_instalment),2)?>
                <?}?>
                </td>
                <?
                  if(isset($current_month_details[$raw->loan_code]->tot_instalment))
                     $total_due = floatval($startarrarstot) + floatval($current_month_details[$raw->loan_code]->tot_instalment);
                   else
                    $total_due = floatval($startarrarstot);
                ?>
                 <td align="right"><?=number_format($total_due,2)?></td>
                  <td>
                  <?if(isset($current_month_payment_date[$raw->loan_code]->pay_date)){?>
                <?=$current_month_payment_date[$raw->loan_code]->pay_date?>
                <?}?>
                </td>
                 <td align="right"><?=number_format($thismonthpay,2)?></td>
                  <td align="right"><?=number_format($arrtot,2)?></td>
                  <td><?=$last_payment_date[$raw->loan_code]->last_date?></td>
                  <td align="right"><?=$closins?></td>
                   <td align="right"><?=number_format($balcap,2)?></td>
           
            
      <? if($feedback[$raw->res_code]){?>
        <td align="right"><?=$feedback[$raw->res_code]->follow_date?></td>
        <td align="right"><?=$feedback[$raw->res_code]->contact_media?></td>
         <td align="right"><?=$feedback[$raw->res_code]->cus_feedback?></td>
        <td align="right"><?=$feedback[$raw->res_code]->sales_feedback?></td>
       
               
            <?}?>
            </tr>
    <?  ?>
    
     
        <? 
     $flontot=$flontot+$raw->loan_amount;
     $finttot=$finttot+$fullint; 
               $fstartarrarstot= $fstartarrarstot+$startarrarstot;
              $farrtot= $farrtot+$arrtot; 
                $fthismonthpay= $fthismonthpay+$thismonthpay;  $ballontot=$ballontot+$balcap;
        $balinttot=$balint+$balinttot; 
  //  $prjbujet=$prjbujet+$raw->new_budget;
  //  $prjexp=$prjexp+$raw->tot_payments;

         $instalment_tot = $instalment_tot + $raw->montly_rental;
           $due_tot = $due_tot + $total_due;
            if(isset($current_month_details[$raw->loan_code]->tot_instalment))
                $current_month_due_tot = $current_month_due_tot + $current_month_details[$raw->loan_code]->tot_instalment;
    }}?>
        
               
            
           
        
        
      <?
  //  $fulltot=$fulltot+$prjexp;
     }}
    
    ?>
      <tr class="active" style="font-weight:bold">
         <td align="center" colspan="4">Total</td>
           <td align="right"><?=number_format($flontot,2)?></td>
            <td></td>
              <td align="right"><?=number_format($instalment_tot,2)?></td>
                        <td colspan="2"></td>
              <td align="right"><?=number_format($fstartarrarstot,2)?></td>
              <td align="right"><?=number_format($current_month_due_tot,2)?></td>
              <td align="right"><?=number_format($due_tot,2)?></td>
              <td></td>
            <td align="right"><?=number_format($fthismonthpay,2)?></td>
              <td align="right"><?=number_format($farrtot,2)?></td>
                <td colspan="2"></td>
                   <td align="right"><?=number_format($ballontot,2)?></td>
           <td colspan="4"></td>
               
            </tr>
         </table>
         
         
         
         
         </div>
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
  tableToExcel('table', 'ZEP Arrears Report', 'zep_Arrears_Report.xls');
 });   
</script>