
<script type="text/javascript">

function load_printscrean1(branch,year,month)
{
			window.open( "<?=base_url()?>hm/summeryreport/balance_summery_excel/"+year+'/'+branch+'/'+month);
	
}
function load_printscrean2(branch,type,from,to)
{
			window.open( "<?=base_url()?>hm/report_excel/date_get_collection_all/"+branch+'/'+type+'/'+from+'/'+to);
	
}

function load_lotinquary(id,prj_id)
{
	 if(id!="")
	 {
		// var prj_id= document.getElementById("prj_id").value
	//	alert("<?=base_url()?>hm/lotdata/get_fulldata/"+id+"/"+prj_id)
	 	 $('#popupform').delay(1).fadeIn(600);
   		   $( "#popupform").load( "<?=base_url()?>hm/lotdata/get_fulldata_popup/"+id+"/"+prj_id );
	 }
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>hm/eploan/get_loanfulldata_popup/"+id );
			
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
                     
        <table class="table table-bordered"><tr class="success"><th >Project Name</th><th>Inventory</th><th >DP Debtor</th><th >ZEP Debtor</th>
      <th >EP Debtor</th><th >EPB Debtor</th><th >Total Debtor</th>
        </tr>
        </tr>
       
       
    <? 
	
	
	if($prjlist){$fulldbdebtor=0; $fullzepdebtor=0;$fullnepdebtor=0;$fullepbdebtor=0; $fulltot=0; $fullinventory=0;
		foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjlandval=0;$prjprvcap=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			$stock=$lots[$prjraw->prj_id]+$soldlots[$prjraw->prj_id];
			$dbdebtor=$advancelist[$prjraw->prj_id];
			$zepdebtor=$zeplist[$prjraw->prj_id];
			$nepdebtor=$eplist[$prjraw->prj_id];
			$epbdebtor=$epblist[$prjraw->prj_id];
			$prjtot=$dbdebtor+$nepdebtor+$epbdebtor+$zepdebtor;
			$fulldbdebtor=$fulldbdebtor+$dbdebtor;
			$fullnepdebtor=$fullnepdebtor+$nepdebtor;
			$fullepbdebtor=$fullepbdebtor+$epbdebtor;
			$fullinventory=$fullinventory+$stock;
			$fulltot=$fulltot+$prjtot;
			$fullzepdebtor=$fullzepdebtor+$zepdebtor;
			
			?>
        <tr ><td><?=$prjraw->project_name?></td>
          <td align="right"><?=number_format($stock,2)?></td>
        <td align="right"><?=number_format($dbdebtor,2)?></td>
          <td align="right"><?=number_format($zepdebtor,2)?></td>
        <td align="right"><?=number_format($nepdebtor,2)?></td>
        <td  align="right"><?=number_format($epbdebtor,2)?></td>
        
        <td align="right"><?=number_format($prjtot,2)?></td></tr>
       
        <? }}?>
        
        
       <tr class="active" style="font-weight:bold"><td>Total</td>
          <td align="right"><?=number_format($fullinventory,2)?></td>
        <td align="right"><?=number_format($fulldbdebtor,2)?></td>
           <td align="right"><?=number_format($fullzepdebtor,2)?></td>
         <td align="right"><?=number_format($fullnepdebtor,2)?></td>
          <td align="right"><?=number_format($fullepbdebtor,2)?></td>
          <td align="right"><?=number_format($fulltot,2)?></td>
       
         
        </tr>
         </table></div>
    </div> 
    
</div>