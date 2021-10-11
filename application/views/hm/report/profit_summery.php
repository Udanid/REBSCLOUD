
<script type="text/javascript">

function load_printscrean1(id,month)
{
		
			if(month=='')
				window.open( "<?=base_url()?>hm/report/get_profit_print/"+id+"/"+month );
				else
				window.open( "<?=base_url()?>hm/report/get_profit_month_project_print/"+id+"/"+month );
}
function load_printscrean2(id,month)
{
		
			if(month=='')
				window.open( "<?=base_url()?>hm/report_excel/get_profit/"+id+"/"+month );
				else
				window.open( "<?=base_url()?>hm/report_excel/get_profit_month_project/"+id+"/"+month );
}
function load_printscrean3(branchid,prjid,fromdate,todate)
{
			window.open( "<?=base_url()?>hm/report_excel/get_profit_month_project_daterange/"+branchid+"/"+prjid+"/"+fromdate+"/"+todate );
	
}
</script>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>Project Details 
       <span style="float:right"> <a href="javascript:load_printscrean1('<?=$details->prj_id?>','<?=$month?>')"> <i class="fa fa-print nav_icon"></i></a>

   <? if(isset($fromdate) & isset($todate)){ ?>
       <a href="javascript:load_printscrean3('0','<?=$details->prj_id?>','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? }else{?>
           <a href="javascript:load_printscrean2('<?=$details->prj_id?>','<?=$month?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
   
       <? }?>
</span></h4>
	</div>
    <table class="table">
    <tr>
    <th>Project Name</th><td><?=$details->project_name?></td>
    <th>Town</th><td><?=$details->town?></td>
     <th>Branch Name</th><td><?=$details->branch_name?></td>
    <? $c=0;$current=0;$paidtotal=0;$totsale=0;;
   if($transferlist){
		foreach($transferlist as $raw){
			if($lotdata[$raw->res_code]->status=='SOLD'){
			$current=$raw->down_payment+$paidcap[$raw->res_code];
			$presentage=($current/$raw->discounted_price)*100;
			
			
			$paidtotal=($raw->discounted_price-$lotdata[$raw->res_code]->costof_sale)+$paidtotal;
		$totsale=$totsale+$raw->discounted_price;
			}}}
			
   ?>
    </tr>
    <tr>
    <th>Total Selling Price</th><td><?=number_format($projecttots->totsale,2)?></td>
    <th>Cost of Sale</th><td><?=number_format($projecttots->totcost,2)?></td>
     <th>Expected Profit</th><td><?=number_format($projecttots->totsale-$projecttots->totcost,2)?></td>
  
    </tr>
    <tr> <th>Actual Sales</th><td><?=number_format($totsale,2)?></td>
    <th>Realized Profit</th><td><?=number_format($paidtotal,2)?></td>
    
    <td colspan="2">
    
      <?  $presentage=round((($paidtotal)/($projecttots->totsale-$projecttots->totcost))*100,2);
						     if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';?>
                              
		
                         <div class="task-info">
									<span class="task-desc">Profit Realized  percentage</span><span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
    
    </td></tr>
      </table>
          <table class="table"> <thead> <tr>  <th>Res Code</th><th>Lot Number</th><th>Profit Transfer Date</th><th>Selling Price </th><th>Cost of Sale</th>
         <th>Paid Total</th><th>Actual Profit</th><th>Realized Profit</th> <th>Settlement Type</th> <th>Profit  Realized %</th></tr> </thead>
                  
    <? if($transferlist){$c=0;$current=0;$paidtotal=0;
		foreach($transferlist as $raw){
			if($lotdata[$raw->res_code]->status=='SOLD'){
			//$current=$paidadvance[$raw->res_code]+$paidcap[$raw->res_code];
			$current=$raw->down_payment+$paidcap[$raw->res_code];
			$presentage=($current/$raw->discounted_price)*100;
			$paidtotal=$paidtotal+$current;
		?>
     <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                         <th scope="row"><?=$raw->res_code?></th> <th scope="row"><?=$lotdata[$raw->res_code]->lot_number?></th> <th scope="row"><?=$raw->profit_date?></th>
                        <td  align="right"> <?=number_format($raw->discounted_price,2)?></td> 
                          <td  align="right"> <?=number_format($lotdata[$raw->res_code]->costof_sale,2)?></td> 
                            <td  align="right"> <?=number_format($current,2)?></td> 
                     
                        <td  align="right"> <?=number_format($raw->discounted_price-$lotdata[$raw->res_code]->costof_sale,2)?></td> 
                            <td  align="right"> <?=number_format($current-$lotdata[$raw->res_code]->costof_sale,2)?></td> 
                        
                        <td><?=$raw->pay_type?></td>
                       
                        <td>
                        <?  $presentage=round((($current-$lotdata[$raw->res_code]->costof_sale)/($raw->discounted_price-$lotdata[$raw->res_code]->costof_sale))*100,2);
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
    </tbody></table>
   
    </div> 
</div>