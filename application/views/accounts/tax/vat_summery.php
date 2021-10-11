
<script type="text/javascript">


function expoet_excel(year,month,m_half)
{
window.open( "<?=base_url()?>accounts/tax/vat_summery_excel/"+year+'/'+month);
}
</script>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>VAT SUMMERY REPORT
       <span style="float:right"> <a href="javascript:expoet_excel('<?=$year?>','<?=$month?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>

<? $b='';
$b=$b.'  

  <div class="table-responsive bs-example widget-shadow"   style="" >
                
      <table class="table table-bordered">
      
     <tr  bgcolor="#d99795"><th  colspan="6" >Winrose Property Developers (Pvt) Ltd.</th></tr>
	  <tr  bgcolor="#d99795"><th  colspan="6" >VAT Payable for Month Of '.date('F', mktime(0, 0, 0, $month, 10)).' '.$year.' </th></tr>
	  
	  <tr  style="font-weight:bold"><td colspan="3">VALUE ADDED TAX</td></td><td></td><td></tr>
	    <tr  style="font-weight:bold"><td colspan="3">('.$startdate1.' - '.$enddate1.')</td></td><td></td><td></tr>
	    <tr  style="font-weight:bold"><td></td><td></td><td>Value of Supply</td><td>Vat '.($epsdata1->rate).' %</td> <td>Total</td></tr>
		<tr  style="font-weight:bold"><td  colspan="3">Opening Balance at the Beggining of the Period</td><td></td> <td></td></tr>
		<tr  style="font-weight:bold"><td colspan="3"></td></td><td></td><td></tr>
		<tr  ><td></td><td >Output Tax</td><td align="right">'.number_format($tot_totrcv_f,2).'</td><td align="right">'.number_format($totvat_firsthalf,2).'</td> <td></td></tr>
		<tr  style="font-weight:bold"><td colspan="3"></td></td><td></td><td></tr>
		<tr  style="font-weight:bold"><td>LESS</td><td  colspan="3"></td><td></td> <td></td></tr>
	  <tr ><td></td><td >Input Tax</td><td></td><td align="right">'.number_format($inputvat_fisthalf,2).'</td> <td></td></tr>
	  <tr  style="font-weight:bold"><td colspan="3"></td></td><td></td><td></tr>
	   <tr  style="font-weight:bold"><td  colspan="3">VAT Payable at the End of the Period</td><td></td><td  align="right">'.number_format($totvat_firsthalf-$inputvat_fisthalf,2).'</td> <td></td></tr>
	   <tr  style="font-weight:bold"><td colspan="3"></td></td><td></td><td></tr>
	    <tr  style="font-weight:bold"><td colspan="3">VALUE ADDED TAX</td></td><td></td><td></tr>
	    <tr  style="font-weight:bold"><td colspan="3">('.$startdate2.' - '.$enddate2.')</td></td><td></td><td></tr>
	    <tr  style="font-weight:bold"><td></td><td></td><td>Value of Supply</td><td>Vat '.($epsdata2->rate).' %</td> <td>Total</td></tr>
		<tr  style="font-weight:bold"><td  colspan="3">Opening Balance at the Beggining of the Period</td><td></td> <td></td></tr>
		<tr  style="font-weight:bold"><td colspan="3"></td></td><td></td><td></tr>
		<tr  ><td></td><td >Output Tax</td><td align="right">'.number_format($tot_totrcv_s,2).'</td><td align="right">'.number_format($totvat_secondhalf,2).'</td> <td></td></tr>
		<tr  style="font-weight:bold"><td>LESS</td><td  colspan="3"></td><td></td> <td></td></tr>
	  <tr  ><td></td><td >Input Tax</td><td></td><td align="right">'.number_format($inputvat_secondhalf,2).'</td> <td></td></tr>
	  <tr  style="font-weight:bold"><td colspan="3"></td></td><td></td><td></tr>
	   <tr  style="font-weight:bold"><td  colspan="3">VAT Payable at the End of the Period</td><td></td><td align="right">'.number_format($totvat_secondhalf-$inputvat_secondhalf,2).'</td> <td></td></tr>
	   <tr  style="font-weight:bold"><td colspan="3"></td></td><td></td><td></tr>
	     <tr  style="font-weight:bold"><td>VAT Payable</td><td ></td><td></td><td></td><td align="right">'.number_format($totvat_secondhalf+$totvat_firsthalf-$inputvat_secondhalf-$inputvat_fisthalf,2).'</td> <td></td></tr>
	  ';
      
          
           
            
      $b=$b.'      ';
     
     $b=$b.'    </table>';
         
   
	echo $b;
	?>        </div>
    </div> 
    
</div>