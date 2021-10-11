<script type="text/javascript">


function expoet_excel(year,month,m_half)
{
window.open( "<?=base_url()?>accounts/tax/input_vatreport_excel/"+year+'/'+month+'/'+m_half);
}
function expoet_excel_csv(year,month,m_half)
{
window.open( "<?=base_url()?>accounts/tax/input_vatreport_csv/"+year+'/'+month+'/'+m_half);
}


</script>


<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>VAT SCHEDULE
       <span style="float:right"> <a href="javascript:expoet_excel('<?=$year?>','<?=$month?>','<?=$m_half?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a> <a href="javascript:expoet_excel_csv('<?=$year?>','<?=$month?>','<?=$m_half?>')" title="csv"> <i class="fa fa-file-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                
      <table class="table table-bordered">
      
     <tr   class="active"><td></td><th  > Invoice Date </th><th >Tax Invoice Number</th>
     <th >Supplier's TIN</th><th >Name of the Supplier</th><th >Description</th><th >Value of purchase </th><th >VAT Amount</th> </tr>
       <? $fulltot=0;?>
       
       <? 
	   $vat=$epsdata->rate/100;
	   $tot_sale=0;
	  if($reserv)
			{
				foreach($reserv as $prjraw){
	
		   


	
				
				 
				?>
      	<tr>
        <td></td>
        <td><?=$prjraw->date?></td>
        <td><?=$prjraw->inv_no?></td>
        <td><?=$prjraw->sup_tin?></td>
        <td ><?=$prjraw->first_name?> <?=$prjraw->last_name?></td>
        <td><?=$prjraw->note?></td>
        <td align="right"><?=number_format($prjraw->total,2)?></td>
            
          <td align="right"><?=number_format($prjraw->vat_amount,2)?></td>
         
          
           
            
            </tr>
	
        
      <? 
	  $tot_sale=$tot_sale+$prjraw->vat_amount;
	  
	//  $fulltot=$fulltot+$prjexp;
	  }}
	  
	  ?>
    
            
             <tr class="active">
        <td></td>
        <td colspan="4">Total</td><td></td>
        <td></td>
        <td align="right"><?=number_format($tot_sale,2)?></td>
     
           
            
            </tr>
     
         </table>
         
        </div>
    </div> 
    
</div>