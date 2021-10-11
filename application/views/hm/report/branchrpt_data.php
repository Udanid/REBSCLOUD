
<script type="text/javascript">

function load_printscrean1(month,prjid)
{
			window.open( "<?=base_url()?>hm/report/get_stock_all_print/"+month);
	
}
function load_lotdetails(id)
{
	$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>hm/lotdata/search/"+id );
}
</script>
 <?
 $heading2=' Project Profitability Report '.$details->project_name;
 
 ?>
 
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?><span style="float:right"> <a href="javascript:load_lotdetails('<?=$prj_id?>')" title="Price List"> <i class="fa fa-sitemap nav_icon icon_blue"></i></a>
</span> 
       </h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
        		            
      <table class="table table-bordered"><tr class="success"><th ></th><th  >Number Of Lots</th>
      <th > Sale Price </th><th >Cost</th><th  >Realized</th>
      <th >Unrealized</th>
      <? 
	  $full_sett=0;
	  $realized_adv=0; $full_adv=0;
	  $realized_epb=0; $full_epb=0;
	  $realized_nep=0; $full_nep=0;
	  $realized_zep=0; $full_zep=0;
	  $realized_adv=0; $full_adv=0;
	  $full_stock=0;
	   $full_all=0;
	  if($settled)
	  if($zep_profit)$realized_zep =$zep_profit->totsale-$zep_profit->totcost;
	  if($adv_profit)$realized_adv =$adv_profit->totsale-$adv_profit->totcost;
	 	 if($settled)$full_sett=$settled->totsale-$settled->totcost;
	  	 if($adv)$full_adv=$adv->totsale-$adv->totcost;
	   	 if($nep)$full_nep=$nep->totsale-$nep->totcost;
		 if($epb)$full_epb=$epb->totsale-$epb->totcost;
		 if($zep)$full_zep=$zep->totsale-$zep->totcost;
		 if($stock)$full_stock=$stock->totsale-$stock->totcost;
		 if($all)$full_all=$all->totsale-$all->totcost;
	  
	  ?>
        </tr>
		<? if($settled){?>
        <tr><td class="red">SETTLED</td><td align="right"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><?=$settled->lotcount+$initsettled->lotcount?></a></td><td align="right"><?=number_format($settled->totsale+$initsettled->totsale)?></td><td align="right"><?=number_format($settled->totcost+$initsettled->totcost)?></td><td align="right"><?=number_format($settled->totsale+$initsettled->totsale-$settled->totcost-$initsettled->totcost)?></td><td align="right">-</td></tr>
		
		<tr><td colspan="6"><div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
                      <table class="table table-bordered">
                      <tr class="active"><th>Lot Number</th><th>Customer Name</th><th>Article Value</th><th>Sale Value</th></tr>
						<? 
						//print_r($initsettledlist);
						if($initsettledlist){foreach($initsettledlist as  $intraw){
							?>
                             <tr><td><?=$intraw->lot_number?></td><td></td><td><?=number_format($intraw->sale_val,2)?></td><td></td></tr>
                            <? }}
							 if($settledlist){  foreach($settledlist as $raw){?>
                        <tr><td><?=$raw->lot_number?></td><td><?=$raw->first_name?><?=$raw->last_name?></td><td><?=number_format($raw->sale_val,2)?></td><td><?=number_format($raw->discounted_price,2)?></td></tr>
                        <? } }?>
                        
                        </table>
					  </div>
					</div> </td></tr>
		<? }?>
        <? if($stock){?>
        <tr><td class="info">STOCK</td><td align="right"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2"><?=$stock->lotcount?></a></td><td align="right"><?=number_format($stock->totsale)?></td><td align="right"><?=number_format($stock->totcost)?></td><td align="right">-</td><td align="right"><?=number_format($stock->totsale-$stock->totcost)?></td></tr>
		<tr><td colspan="6"><div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
                      <table class="table table-bordered">
                      <tr class="active"><th>Lot Number</th><th>Sale Value</th></tr>
						<? if($stocklist){  foreach($stocklist as $raw){?>
                        <tr><td><?=$raw->lot_number?></td><td><?=number_format($raw->sale_val,2)?></td></tr>
                        <? }}?></table>
					  </div>
					</div> </td></tr>
		
		<? }?>
        <? if($nep){?>
        <tr><td class="yellow">NEP</td><td align="right"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3"><?=$nep->lotcount?></a></td><td align="right"><?=number_format($nep->totsale)?></td><td align="right"><?=number_format($nep->totcost)?></td><td align="right"><?=number_format($nep->totsale-$nep->totcost)?></td><td align="right">-</td></tr>
		<tr><td colspan="6"><div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
                      <table class="table table-bordered">
                      <tr class="active"><th>Lot Number</th><th>Customer Name</th><th>Article Value</th><th>Sale Value</th></tr>
						<?
							 if($neplist){ foreach($neplist as $raw){?>
                        <tr><td><?=$raw->lot_number?></td><td><?=$raw->first_name?><?=$raw->last_name?></td><td><?=number_format($raw->sale_val,2)?></td><td><?=number_format($raw->discounted_price,2)?></td></tr>
                        <? } }?>
                        
                        </table>
					  </div>
					</div> </td></tr>
		
		<? }?>
        <? if($epb){?>
        <tr><td class="brown">EPB</td><td align="right"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4"><?=$epb->lotcount?></a></td><td align="right"><?=number_format($epb->totsale)?></td><td align="right"><?=number_format($epb->totcost)?></td><td align="right"><?=number_format($epb->totsale-$epb->totcost)?></td><td align="right">-</td></tr>
		
		<tr><td colspan="6"><div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
                      <table class="table table-bordered">
                      <tr class="active"><th>Lot Number</th><th>Customer Name</th><th>Article Value</th><th>Sale Value</th></tr>
						<?
							 if($epblist){ foreach($epblist as $raw){?>
                        <tr><td><?=$raw->lot_number?></td><td><?=$raw->first_name?><?=$raw->last_name?></td><td><?=number_format($raw->sale_val,2)?></td><td><?=number_format($raw->discounted_price,2)?></td></tr>
                        <? }} ?>
                        
                        </table>
					  </div>
					</div> </td></tr>
		
		
		<? }?>
        <? if($adv){?>
         <tr><td class="green">ADVANCE</td><td align="right"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="true" aria-controls="collapse5"><?=$adv->lotcount?></a></td><td align="right"><?=number_format($adv->totsale)?></td><td align="right"><?=number_format($adv->totcost)?></td><td align="right"><?=number_format($realized_adv)?></td><td align="right"><?=number_format($full_adv-$realized_adv)?></td></tr>
		 	 
		 <tr><td colspan="6"><div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
                      <table class="table table-bordered">
                      <tr class="active"><th>Lot Number</th><th>Customer Name</th><th>Article Value</th><th>Sale Value</th></tr>
						<?
							 if($advlist){ foreach($advlist as $raw){?>
                        <tr><td><?=$raw->lot_number?></td><td><?=$raw->first_name?><?=$raw->last_name?></td><td><?=number_format($raw->sale_val,2)?></td><td><?=number_format($raw->discounted_price,2)?></td></tr>
                        <? }} ?>
                        
                        </table>
					  </div>
					</div> </td></tr>
		 
		 
		 <? }?>
         <? if($zep){?>
         <tr><td class="purple">ZEP</td align="right"><td align="right"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="true" aria-controls="collapse6"><?=$zep->lotcount?></a></td><td align="right"><?=number_format($zep->totsale)?></td><td align="right"><?=number_format($zep->totcost)?></td><td align="right"><?=number_format($realized_zep)?></td><td align="right"><?=number_format($full_zep-$realized_zep)?></td></tr>
		 
		 <tr><td colspan="6"><div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
                      <table class="table table-bordered">
                      <tr class="active"><th>Lot Number</th><th>Customer Name</th><th>Article Value</th><th>Sale Value</th></tr>
						<?
							 if($zeplist){foreach($zeplist as $raw){?>
                        <tr><td><?=$raw->lot_number?></td><td><?=$raw->first_name?><?=$raw->last_name?></td><td><?=number_format($raw->sale_val,2)?></td><td><?=number_format($raw->discounted_price,2)?></td></tr>
                        <? }} ?>
                        
                        </table>
					  </div>
					</div> </td></tr>
		 
		 <? }?>
          <? if($all){?>
         <tr class="active" style="font-weight:bold"><td>Total</td><td align="right"><?=$all->lotcount?></td><td align="right"><?=number_format($all->totsale)?></td><td align="right"><?=number_format($all->totcost)?></td><td></td><td></td></tr><? }?>
        
        
       
 
        
       
      <?
	 
	  
	  ?>
      
         </table></div>
    </div> 
    

<?
  $heading2=' Budget Report as at '.$reportdata;

 
 ?>

	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <a href="javascript:load_printscrean1('')"> <i class="fa fa-print nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered">
     <tr class="success" style="font-weight:bold"><td colspan="4"  align="center"><?=$details->project_name?></td></tr>
       <tr><th > Category </th><th>Total Budget</th><th >Expense</th>
      <th >Balance</th>
        
        </tr>
       
       
    <? 
	
	
		//echo $prjraw->prj_id;
			$prjbujet=0;$prjexp=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			?>
        <?  if($reservation[$prj_id]){
			foreach($reservation[$prj_id] as $raw){
						if($raw->new_budget>0){			
				?>
        <tr><td><?=$raw->task_name?></td>
        <td align="right"><?=number_format($raw->new_budget,2)?></td>
        <td align="right"><?=number_format($raw->tot_payments,2)?></td>
        <td align="right"> <?=number_format($raw->new_budget-$raw->tot_payments,2)?></td></tr>
        
       
        <? 
		$prjbujet=$prjbujet+$raw->new_budget;
		$prjexp=$prjexp+$raw->tot_payments;
		}}}?>
         <tr class="info" style="font-weight:bold">
         <td align="right">Total</td>
            <td align="right"><?=number_format($prjbujet,2)?></td>
          <td align="right"><?=number_format($prjexp,2)?></td>
         <td align="right"><?=number_format($prjbujet-$prjexp,2)?></td>
            
           
                   </tr>
           
           
      <?
	 
	  
	  ?>
      
         </table></div>
    </div> 
    
</div>