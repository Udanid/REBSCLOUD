
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
  $heading2=' EP Arrears Report   as at'.$date;

 

 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                
      <table class="table table-bordered" id="table">
      
     <tr   class="active"><th > Project Name </th><th  >LOT Number</th>
     <th >Customer Name</th>
      <th >Loan Capital</th>
      <th > Loan Interest</th>
       <th > Total Finance</th>
     <th >Monthly Instalment</th>
          <th >Arrears Amount as at <?=$sartdate?></th>
         <th >Recieved Amount During the month</th>
         <th >Arrears Amount as at <?=$date?></th>
          <th >Arrears number of Instalments</th>
          
          <th >Balance Capital</th>
      <th > Balance Interest</th>
       <th > Balance Total </th>
       
        
		 <th >Feedback Date</th>
		 <th >Action</th>
		 <th >Officer Feedbak</th>
		 <th >Customer Feedback</th>
          </tr>
   
   
       
       <? $fulltot=0;?>
       
       <? 
	  $fstartarrarstot=0;$farrtot=0; $fthismonthpay=0;
	   $flontot=0;$finttot=0; 
	   $ballontot=0;$balinttot=0; 
	   if($prjlist){foreach($prjlist  as $prraw){ ?> 
  	
	<?
			
			
			?>
        <?  if($transferlist[$prraw->prj_id]){
			
			?>
              <tr class="active" style="font-weight:bold"><td><?=$details[$prraw->prj_id]->project_name?></td><td colspan="27"></td></tr>

            <?
			foreach($transferlist[$prraw->prj_id] as $raw){
				//print_r($arrearspay[$raw->res_code]);
				$arrearsmonth=0;$thismonthpay=0;$arrinscount=0;$creditmonth=0;$arrtot=0;
                $startarrarstot=0;
				$fullint=0;
				$ful_tot=loan_due_totals_loancode($raw->loan_code,'');
				if($ful_tot)
				{
					$fullint=$ful_tot->due_int;
				}
				$balcap=$raw->loan_amount;
				$balint=$fullint;
				$stpaytot=0;$stduetot=0;
                $startpaytot=loan_paid_totals_loancode($raw->loan_code,$sartdate);
				$startduetot=loan_due_totals_loancode($raw->loan_code,$sartdate);
				if($startpaytot)
				{
					$stpaytot=$startpaytot->paid_cap+$startpaytot->paid_int;
				}
				if($startduetot)
				{
					$stduetot=$startduetot->due_cap+$startduetot->due_int;
				}
				$endpaytot=loan_paid_totals_loancode($raw->loan_code,$date);
				$endduetot=loan_due_totals_loancode($raw->loan_code,$date);
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
            <td><?=$raw->first_name?></td>
              <td align="right"><?=number_format($raw->loan_amount,2)?></td>
         <td align="right"><?=number_format($fullint,2)?></td>
            <td align="right"><?=number_format($fullint+$raw->loan_amount,2)?></td>
          <td align="right"><?=number_format($raw->montly_rental,2)?></td>
         <td align="right"><?=number_format($startarrarstot,2)?></td>
            <td align="right"><?=number_format($thismonthpay,2)?></td>
              <td align="right"><?=number_format($arrtot,2)?></td>
               <td align="right"><?=$closins?></td>
               <td align="right"><?=number_format($balcap,2)?></td>
            <td align="right"><?=number_format($balint,2)?></td>
              <td align="right"><?=number_format($balcap+$balint,2)?></td>
			<? if($feedback[$raw->res_code]){?>
			  <td align="right"><?=$feedback[$raw->res_code]->follow_date?></td>
			  <td align="right"><?=$feedback[$raw->res_code]->contact_media?></td>
			  <td align="right"><?=$feedback[$raw->res_code]->sales_feedback?></td>
			  <td align="right"><?=$feedback[$raw->res_code]->cus_feedback?></td>
               
            <?}?>
            </tr>
		<? 	?>
    
     
        <? 
		 $flontot=$flontot+$raw->loan_amount;
		 $finttot=$finttot+$fullint; 
               $fstartarrarstot= $fstartarrarstot+$startarrarstot;
              $farrtot= $farrtot+$arrtot; 
                $fthismonthpay= $fthismonthpay+$thismonthpay;  $ballontot=$ballontot+$balcap;
				$balinttot=$balint+$balinttot; 
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>
        
               
            
           
        
        
      <?
	//  $fulltot=$fulltot+$prjexp;
	   }}
	  
	  ?>
      <tr class="active" style="font-weight:bold">
         <td align="right" colspan="3">Total</td>
           <td align="right"><?=number_format($flontot,2)?></td>
            <td align="right"><?=number_format($finttot,2)?></td>
              <td align="right"><?=number_format($finttot+$flontot,2)?></td>
                        <td align="right"></td>
              <td align="right"><?=number_format($fstartarrarstot,2)?></td>
            <td align="right"><?=number_format($fthismonthpay,2)?></td>
              <td align="right"><?=number_format($farrtot,2)?></td>
                <td align="right"></td>
                   <td align="right"><?=number_format($ballontot,2)?></td>
            <td align="right"><?=number_format($balinttot,2)?></td>
              <td align="right"><?=number_format($balinttot+$ballontot,2)?></td>
               
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
  tableToExcel('table', 'EP Arrears Report', 'EP_Arrears_Report.xls');
 });   
</script>