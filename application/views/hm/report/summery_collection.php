
<script type="text/javascript">

function load_printscrean1(branch,year,month)
{
			window.open( "<?=base_url()?>hm/summeryreport/collection_summery_excel/"+year+'/'+branch+'/'+month);
	
}

</script>
 <?
 if($month!=''){
  $heading2=' Collection Summery Report ';
 }
 else{
   $heading2='  Collection Summery Report  ';
 }
 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">       
          <a href="javascript:load_printscrean1('<?=$branchid?>','<?=$year?>','<?=$month?>')"><i class="fa fa-file-excel-o nav_icon"></i></a>
    
      
       
       
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered"><tr class="success"><th >Project Name</th><th>DP Debtor</th><th>ZEP Debtor</th><th >EP Debtor</th>
      <th >EPB Debtor</th><th >Total</th>
        </tr>
        </tr>
       
       
    <? 
	
	
	if($prjlist){$fulldbdebtor=0;$fullnepdebtor=0;$fullepbdebtor=0; $fulltot=0; $fullprjlastbal=0;$fullzepdebtor=0;
		foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjlandval=0;$prjprvcap=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			$dbdebtor=$advance[$prjraw->prj_id];
			$zepdebtor=$zep[$prjraw->prj_id]->sum_cap+$zep[$prjraw->prj_id]->sum_di;
			
			$nepdebtor=$nep[$prjraw->prj_id]->sum_cap+$nep[$prjraw->prj_id]->sum_int+$nep[$prjraw->prj_id]->sum_di;
			//$epbdebtor=$epb[$prjraw->prj_id]->sum_cap+$epb[$prjraw->prj_id]->sum_int+$epb[$prjraw->prj_id]->sum_di;
			$epbdebtor=$epb[$prjraw->prj_id];//->sum_cap+$epb[$prjraw->prj_id]->sum_int+$epb[$prjraw->prj_id]->sum_di;
			$prjtot=$dbdebtor+$nepdebtor+$epbdebtor +$zepdebtor;
			$fulldbdebtor=$fulldbdebtor+$dbdebtor;
			$fullnepdebtor=$fullnepdebtor+$nepdebtor;
			$fullepbdebtor=$fullepbdebtor+$epbdebtor;
			$fullzepdebtor=$fullzepdebtor+$zepdebtor;
			$fulltot=$fulltot+$prjtot;
			
			?>
        <tr ><td><?=$prjraw->project_name?></td>
        <td align="right"><?=number_format($dbdebtor,2)?></td>
         <td align="right"><?=number_format($zepdebtor,2)?></td>
        <td align="right"><?=number_format($nepdebtor,2)?></td>
        <td  align="right"><?=number_format($epbdebtor,2)?></td>
        
        <td align="right"><?=number_format($prjtot,2)?></td></tr>
       
        <? }}?>
        
        
       <tr class="active" style="font-weight:bold"><td>Total</td>
        <td align="right"><?=number_format($fulldbdebtor,2)?></td>
         <td align="right"><?=number_format($fullzepdebtor,2)?></td>
         <td align="right"><?=number_format($fullnepdebtor,2)?></td>
          <td align="right"><?=number_format($fullepbdebtor,2)?></td>
          <td align="right"><?=number_format($fulltot,2)?></td>
       
         
        </tr>
         </table></div>
    </div> 
    
</div>