<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
<script type="text/javascript">

function load_printscrean1(id,month)
{
		
			
				window.open( "<?=base_url()?>re/report/get_profit_month_project_print/"+id+"/"+month );
}
function load_printscrean2(id,month)
{
		
		
				window.open( "<?=base_url()?>re/report_excel/get_profits_all/"+id+"/"+month );
}
function load_printscrean3(branchid,prjid,fromdate,todate)
{
			window.open( "<?=base_url()?>re/report_excel/get_profits_all_daterange/"+branchid+"/"+prjid+"/"+fromdate+"/"+todate );
	
}
</script>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>Profit Realization Report
       <span style="float:right">

   <? if(isset($fromdate) & isset($todate)){ ?>
       <a href="javascript:load_printscrean3('<?=$branchid?>','0','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? }else{?>
           <a href="javascript:load_printscrean2('<?=$branchid?>','<?=$month?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
   
       <? }?>
</span></h4>
	</div>
  		<div class="tableFixHead"> 
          <table class="table"> <thead> <tr>  <th>Res Code</th><th>Lot Number</th><th>Profit Transfer Date</th><th>Selling Price </th><th>Cost of Sale</th>
         <th>Paid Total</th><th>Actual Profit</th><th>Realized Profit</th> <th>Settlement Type</th> <th>Profit  Realized %</th></tr> </thead>
         <? if($prjlist){  foreach($prjlist as $prjraw)
		{if($transferlist[$prjraw->prj_id]){
			?> 
            <tr style="font-weight:bold" class="info"><td colspan="10"><?=$prjraw->project_name?></td></tr>
                  
    <? $c=0;$current=0;$paidtotal=0;
		foreach($transferlist[$prjraw->prj_id] as $raw){
			if($lotdata[$prjraw->prj_id][$raw->res_code]->status=='SOLD'){
			//$current=$paidadvance[$raw->res_code]+$paidcap[$raw->res_code];
			$current=$raw->down_payment+$paidcap[$prjraw->prj_id][$raw->res_code];
			$presentage=($current/$raw->discounted_price)*100;
			$presentage_pay=($current/$raw->discounted_price)*100;
			$realized_proft=$current-($lotdata[$prjraw->prj_id][$raw->res_code]->costof_sale*($current/$raw->discounted_price));
			$paidtotal=$paidtotal+$current;
		?>
     <tbody> <tr > 
                         <th scope="row"><?=$raw->res_code?></th> <th scope="row"><?=$lotdata[$prjraw->prj_id][$raw->res_code]->lot_number?></th> <th scope="row"><?=$raw->profit_date?></th>
                        <td  align="right"> <?=number_format($raw->discounted_price,2)?></td> 
                          <td  align="right"> <?=number_format($lotdata[$prjraw->prj_id][$raw->res_code]->costof_sale,2)?></td> 
                            <td  align="right"> <?=number_format($current,2)?></td> 
                     
                        <td  align="right"> <?=number_format($raw->discounted_price-$lotdata[$prjraw->prj_id][$raw->res_code]->costof_sale,2)?></td> 
                            <td  align="right"> <?=number_format($realized_proft,2)?></td> 
                        
                        <td><?=$raw->pay_type?></td>
                       
                        <td>
                        <?  $presentage=round((($current)/($raw->discounted_price))*100,2);
						     if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';?>
                              
		
                         <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
                        
                        
                        
                        </td>
                         </tr> 
    <? } }}?>
    
    <? }}?>
    </tbody></table>
    </div>
   
    </div> 
</div>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
</script>