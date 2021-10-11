
<script type="text/javascript">

function load_printscrean1(month,prjid)
{
			window.open( "<?=base_url()?>re/report/get_stock_all_print/"+month);
	
}
function expoet_excel(month,branch,year)
{
		
		
				window.open( "<?=base_url()?>re/report/arreas_data_excel/"+month+'/'+branch+'/'+year);
}
function expoet_excel2(month,branch,year)
{
		
		
				window.open( "<?=base_url()?>re/report/arreas_data_excel_ins/"+month+'/'+branch+'/'+year);
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
<style type="text/css">

</style>
 <?
 if($month!=''){
  $heading2=' EP Arrears Report   as at '.$reportdata;
 }
 else{
   $heading2=' EP Arrears Report   as at'.$reportdata;
 }
 
 $week1end=$start=date('Y-m-d',strtotime('+7 days',strtotime($sartdate)));
 $week2end=$start=date('Y-m-d',strtotime('+14 days',strtotime($sartdate)));
 $week3end=$start=date('Y-m-d',strtotime('+21 days',strtotime($sartdate)));
 $week4end=$start=date('Y-m-d',strtotime('+28 days',strtotime($sartdate)));
 $week5end=$reportdata;
for($i=-80; $i<=80; $i++){
	 $myque[$i]=NULL;
	 $quecounter[$i]=0;
 }
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                
      <table class="table table-bordered" id="table1">
      
     <tr   class="active"><th  rowspan="2"> Project Name </th><th  rowspan="2">LOT Number</th><th colspan="3">Opening Balances as at <?=$sartdate?> </th><th  rowspan="2" >Budget </th><th  rowspan="2">Actual</th><th  rowspan="2">Variance</th>
      <th colspan="3">Closing Balance as at <?=$reportdata?></th><th colspan="3">No of Arrears Instalments <?=$reportdata?></th></tr>
   
   <tr>  <th >Arrears Amount</th> <th>Instalment</th> <th>Total Receivables</th> <th >Arrears Amount</th> <th>Instalment</th> <th>Total Receivables</th><th>Opening</th><th>Closing</th><th>Variance</th></tr>
       
       <? $fulltot=0;?>
       
       <? 
	   $arrtot=0;$renttot=0;$budget=0; $paytot=0; $nextbudgettot=0;$credittot=0;
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
				if($arrearspay[$raw->res_code]){
				$arrearsmonth=$arrearspay[$raw->res_code]->arriastot-$startpayment[$raw->res_code];
				$arrtot=$arrearspay[$raw->res_code]->arriastot;
				$arrinscount=$arrearspay[$raw->res_code]->instalmentcount;
				$creditmonth=$startpayment[$raw->res_code];
				}
				
				if($credtipay[$raw->res_code])
				{
					$creditmonth=$credtipay[$raw->res_code]->totpay;
				$arrearsmonth=$arrearsmonth-$credtipay[$raw->res_code]->totpay;
				$arrinscount=$arrinscount-$credtipay[$raw->res_code]->instalmentcount;
				}
				if($thispay[$raw->res_code])
				{
					$thismonthpay=$thispay[$raw->res_code]->sum_cap+$thispay[$raw->res_code]->sum_int;
				}
				$thisbudget=$arrearsmonth+$raw->montly_rental;
				$variance=$thisbudget-$thismonthpay;
				$nextbudget=	$thisbudget-$thismonthpay+$raw->montly_rental;	
				
				$closins=round($variance/$raw->montly_rental,0);	
				$arrinscount=round(($arrearsmonth)/$raw->montly_rental,0);	
				//$closins=1+$arrinscount;
				$renttot=$renttot+$raw->montly_rental;	
				if($arrearsmonth>0)
				$arrtot=$arrtot+$arrearsmonth;
				else
				$credittot=$credittot+$arrearsmonth;
				$paytot=$paytot+$thismonthpay;
				$myclass="";
				 if($closins >= 3)
				 $myclass="red";
				 else if($raw->loan_type=='ZEP')
				  $myclass="info";
				  else $myclass="";
				  $cusfeedback='';
				  $officerfeedback='';
				  if($feedback[$raw->res_code])
				  { $officerfeedback=$feedback[$raw->res_code]->sales_feedback;
				    $cusfeedback=$feedback[$raw->res_code]->cus_feedback;
				  }
				 $myque[$arrinscount][$quecounter[$arrinscount]]=array('project_name'=>$details[$prraw->prj_id]->project_name,
				  'loan_code'=>$raw->loan_code,'lot_number'=>$raw->lot_number,'arrearsmonth'=>$arrearsmonth,
				  'montly_rental'=>$raw->montly_rental
				  ,'startrec'=>$arrearsmonth+$raw->montly_rental
				  ,'budget'=>$arrearsmonth+$raw->montly_rental
				  ,'actual'=>$thismonthpay
				  ,'variance'=>$variance
				  ,'arramount'=>$variance
				  ,'instalment'=>$raw->montly_rental
				  ,'nextbudget'=>$nextbudget
				  ,'opening'=>$arrinscount
				   ,'closing'=>$closins
				    ,'varinace'=>$closins-$arrinscount
					  ,'officerfeedback'=>$officerfeedback
					    ,'cusfeedback'=>$cusfeedback
					  
				  );
				 // $quecounter.$arrinscount++;*/
				   $quecounter[$arrinscount]++;
				  
				?>
                
      	<tr class="<?=$myclass?>"><td><a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->loan_code?></a>
        
        &nbsp;&nbsp;<a href="javascript:add_followup_detalis('<?=$raw->loan_code?>','<?=$reportdata?>')"><i class="fa fa-phone nav_icon icon_red "></i></a>
        </td><td><?=$raw->lot_number?></td>
            
          <td align="right"><?=number_format($arrearsmonth,2)?></td>
         <td align="right"><?=number_format($raw->montly_rental,2)?></td>
            <td align="right"><?=number_format($arrearsmonth+$raw->montly_rental,2)?></td>
              <td align="right"><?=number_format($arrearsmonth+$raw->montly_rental,2)?></td>
               <td align="right"><?=number_format($thismonthpay,2)?></td>
                <td align="right"><?=number_format($variance,2)?></td>
                <td align="right"><?=number_format($variance,2)?></td>
                <td align="right"><?=number_format($raw->montly_rental,2)?></td>
                <td align="right"><?=number_format($nextbudget,2)?></td>
                <td align="right"><?=$arrinscount?></td>
                <td align="right"><?=$closins?></td>
                 <td align="right"><?=$closins-$arrinscount?></td>
           
            
            </tr>
		<? 	?>
    
     
        <? 
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>
        
               
            
           
        
        
      <?
	//  $fulltot=$fulltot+$prjexp;
	   }}
	  
	  ?>
      <tr class="active" style="font-weight:bold">
         <td align="right" colspan="2">Total</td>
          <td align="right"><?=number_format($arrtot,2)?></td>
           <td align="right"><?=number_format($renttot,2)?></td>
            <td align="right"><?=number_format($arrtot+$renttot-$credittot,2)?></td>
              <td align="right"><?=number_format($arrtot+$renttot,2)?></td>
               <td align="right"><?=number_format($paytot,2)?></td>
                <td align="right"><?=number_format($arrtot+$renttot-$paytot,2)?></td>
                <td align="right"><?=number_format($arrtot+$renttot-$paytot,2)?></td>
                <td align="right"><?=number_format($renttot,2)?></td>
                <td align="right"><?=number_format($arrtot+$renttot+$renttot-$paytot-$credittot,2)?></td>
                <td align="right"></td>
                <td align="right"></td>
                 <td align="right">1</td>
            </tr>
         </table>
         
         
         
         
         </div>
    </div> 
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                 <div class="form-title">
		<h4>Arrears Report as at <?=$reportdata?> Installment wise
       <span style="float:right"> <h4><a href="#" id="create_excel_2" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
</span></h4>
	</div>
  
      <table class="table table-bordered" id="table2">
      
     <tr   class="active"><th  rowspan="2"> Project Name </th><th  rowspan="2"> Loan Code </th><th  rowspan="2">LOT Number</th><th colspan="3">Opening Balances as at <?=$sartdate?> </th><th  rowspan="2" >Budget </th><th  rowspan="2">Actual</th><th  rowspan="2">Variance</th>
      <th colspan="3">Closing Balance as at <?=$reportdata?></th><th colspan="3">No of Arrears Instalments <?=$reportdata?></th>
      <th  rowspan="2">Officer Feedback</th><th  rowspan="2">Customer Feedback</th>
      </tr>
   
   <tr>  <th >Arrears Amount</th> <th>Instalment</th> <th>Total Receivables</th> <th >Arrears Amount</th> <th>Instalment</th> <th>Total Receivables</th><th>Opening</th><th>Closing</th><th>Variance</th></tr>
       
      <? for($i=60; $i>=-60;$i--){
		if( $myque[$i]){  $projectname=0;
		for($j=0;$j<$quecounter[$i]; $j++){
			if($projectname!=$myque[$i][$j]['project_name']){?>
				 <tr class="active" style="font-weight:bold"><td><?=$myque[$i][$j]['project_name']?></td><td colspan="27"></td></tr>
				<?
				
				 }?>
			
		  
      
      <tr ><td><?=$myque[$i][$j]['project_name']?></td><td><a href="javascript:get_loan_detalis('<?=$myque[$i][$j]['loan_code']?>')"><?=$myque[$i][$j]['loan_code']?></a></td><td><?=$myque[$i][$j]['lot_number']?></td>
              <td align="right"><?=number_format($myque[$i][$j]['arrearsmonth'],2)?></td>
         <td align="right"><?=number_format($myque[$i][$j]['montly_rental'],2)?></td>
            <td align="right"><?=number_format($myque[$i][$j]['startrec'],2)?></td>
              <td align="right"><?=number_format($myque[$i][$j]['budget'],2)?></td>
               <td align="right"><?=number_format($myque[$i][$j]['actual'],2)?></td>
                <td align="right"><?=number_format($myque[$i][$j]['variance'],2)?></td>
                <td align="right"><?=number_format($myque[$i][$j]['arramount'],2)?></td>
                <td align="right"><?=number_format($myque[$i][$j]['instalment'],2)?></td>
                <td align="right"><?=number_format($myque[$i][$j]['nextbudget'],2)?></td>
                <td align="right"><?=$myque[$i][$j]['opening']?></td>
                <td align="right"><?=$myque[$i][$j]['closing']?></td>
                 <td align="right"><?=$myque[$i][$j]['varinace']?></td>
                  <td align="right"><?=$myque[$i][$j]['officerfeedback']?></td>
                 <td align="right"><?=$myque[$i][$j]['cusfeedback']?></td>
       
           
            
            </tr>
      <? $projectname=$myque[$i][$j]['project_name']; }}}?>
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
  tableToExcel('table1', 'EP Arrears Report', 'EP_Arrears_Report.xls');
 });   

    $('#create_excel_2').click(function(){
  tableToExcel('table2', 'EP Arrears Report Installment wise', 'EP_Arrears_Report_Installment_wise.xls');
 }); 
</script>