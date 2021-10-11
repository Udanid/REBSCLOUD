
<script type="text/javascript">

function load_printscrean1(month,prjid)
{
			window.open( "<?=base_url()?>hm/report/get_stock_all_print/"+month);
	
}
function expoet_excel(month,branch)
{
		
		
				window.open( "<?=base_url()?>hm/report/arreas_data_date_excel/"+month+'/'+branch);
}
function expoet_excel2(month,branch)
{
		
		
				window.open( "<?=base_url()?>hm/report/arreas_data_excel_ins/"+month+'/'+branch);
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>hm/eploan/get_loanfulldata_popup/"+id );
			
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
       <span style="float:right"> <a href="javascript:expoet_excel('<?=$date?>','<?=$branchid?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                
      <table class="table table-bordered">
      
     <tr   class="active"><th > Project Name </th><th  >LOT Number</th><th >Monthly Instalment</th>
          <th >Arrears Amount as at <?=$sartdate?></th>
         <th >Recieved Amount During the month</th>
         <th >Arrears Amount as at <?=$date?></th>
          <th >Arrears number of Instalments</th>
		 <th >Feedback Date</th>
		 <th >Action</th>
		 <th >Officer Feedbak</th>
		 <th >Customer Feedback</th>
          </tr>
   
   
       
       <? $fulltot=0;?>
       
       <? 
	  $fstartarrarstot=0;$farrtot=0; $fthismonthpay=0;
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
                if($arrearspay[$raw->res_code])
                {
                     $startarrarstot=$arrearspay[$raw->res_code]->arriastot-$startpayment[$raw->res_code];
                }
				if($thispay[$raw->res_code])
                {
                   $thismonthpay=$thispay[$raw->res_code]->sum_cap+$thispay[$raw->res_code]->sum_int; 
                }
				  $loanstdatearr=explode('-',$raw->start_date);
                $curentdatearr=explode('-',$date);
                if($curentdatearr[2]>$loanstdatearr[2])
                {
                   
                        $arrtot= ($startarrarstot+$raw->montly_rental)-$thismonthpay;
                   
                   
                }
                else{
                     $arrtot= ($startarrarstot)-$thismonthpay;
                }
                $closins=round($arrtot/$raw->montly_rental,0);
                    $myclass="";
				 if($closins >= 3)
				 $myclass="red";
          ?>
                
      	<tr class="<?=$myclass?>"><td><a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->loan_code?></a></td><td><?=$raw->lot_number?></td>
            
          <td align="right"><?=number_format($raw->montly_rental,2)?></td>
         <td align="right"><?=number_format($startarrarstot,2)?></td>
            <td align="right"><?=number_format($thismonthpay,2)?></td>
              <td align="right"><?=number_format($arrtot,2)?></td>
               <td align="right"><?=$closins?></td>
			<? if($feedback[$raw->res_code]){?>
			  <td align="right"><?=$feedback[$raw->res_code]->follow_date?></td>
			  <td align="right"><?=$feedback[$raw->res_code]->contact_media?></td>
			  <td align="right"><?=$feedback[$raw->res_code]->sales_feedback?></td>
			  <td align="right"><?=$feedback[$raw->res_code]->cus_feedback?></td>
               
            <?}?>
            </tr>
		<? 	?>
    
     
        <? 
               $fstartarrarstot= $fstartarrarstot+$startarrarstot;
              $farrtot= $farrtot+$arrtot; 
                $fthismonthpay= $fthismonthpay+$thismonthpay; 
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>
        
               
            
           
        
        
      <?
	//  $fulltot=$fulltot+$prjexp;
	   }}
	  
	  ?>
      <tr class="active" style="font-weight:bold">
         <td align="right" colspan="2">Total</td>
                        <td align="right"></td>
              <td align="right"><?=number_format($fstartarrarstot,2)?></td>
            <td align="right"><?=number_format($fthismonthpay,2)?></td>
              <td align="right"><?=number_format($farrtot,2)?></td>
                <td align="right"></td>
               
            </tr>
         </table>
         
         
         
         
         </div>
    </div> 
   
    
</div>