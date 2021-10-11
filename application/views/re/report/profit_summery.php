<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){  
      $('#create_excel').click(function(){ 
	  	//	var date =  document.getElementById('rptdate').value;
           $(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Profit Realization Report ",
					filename: "Profit.xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
           
      });  
 });
function load_printscrean1(id,month)
{
		
			if(month=='')
				window.open( "<?=base_url()?>re/report/get_profit_print/"+id+"/"+month );
				else
				window.open( "<?=base_url()?>re/report/get_profit_month_project_print/"+id+"/"+month );
}
function load_printscrean2(id,month)
{
		
			if(month=='')
				window.open( "<?=base_url()?>re/report_excel/get_profit/"+id+"/"+month );
				else
				window.open( "<?=base_url()?>re/report_excel/get_profit_month_project/"+id+"/"+month );
}
function load_printscrean3(branchid,prjid,fromdate,todate)
{
			window.open( "<?=base_url()?>re/report_excel/get_profit_month_project_daterange/"+branchid+"/"+prjid+"/"+fromdate+"/"+todate );
	
}
</script>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>Project Details 
       <span style="float:right"> 
     <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
      </span></h4>
	</div>
    <? if($prj_id!='ALL') {?>
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
      </table><? }?>
       <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
    
          <table class="table table-bordered table2excel"> <thead> <tr>  <th>Pro</th><th>Lot Number</th><th>Reservation Date</th><th>Profit Transfer Date</th><th>Selling Price </th><th>Cost of Sale</th>
         <th>Paid Total as at date</th><th>Actual Profit</th><th>Initally Realized Profit</th><th>Realized Profit As at Date</th> <th>Settlement Type</th> <th>Inital Profit  Realized %</th><th>Uptodate Profit  Realized %</th><th>Customer Name</th><th>NIC</th><th>Address</th></tr> </thead>
                  
    <? if($transferlist){$c=0;$current=0;$paidtotal=0;
		foreach($transferlist as $raw){
			if($lotdata[$raw->res_code]->status=='SOLD'){
				
				$initrealization=get_realized_sale_andcost_date($raw->res_code,$raw->profit_date);
				$initial=0;
				$totpaid=0;
				if($initrealization)
				{
					$totpaid=$initrealization->totsale;
					$initial=$initrealization->totsale-$initrealization->totcost;
				}
				$asdateprofit=get_realized_sale_andcost_date($raw->res_code,$todate);
				$dateprofit=$initial;
				if($asdateprofit)
				{
					$totpaid=$asdateprofit->totsale;
					$dateprofit=$asdateprofit->totsale-$asdateprofit->totcost;
				}
			//$current=$paidadvance[$raw->res_code]+$paidcap[$raw->res_code];
			$current=$totpaid;
			$fullprofit=$raw->discounted_price-$lotdata[$raw->res_code]->costof_sale;
			$rate_first=($initial/$fullprofit)*100;
			$rate_date=($dateprofit/$fullprofit)*100;
			$paidtotal=$paidtotal+$current;
		?>
     <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                         <th scope="row"><?=$raw->project_name?></th> <th scope="row"><?=$lotdata[$raw->res_code]->lot_number?></th><th scope="row"><?=$raw->res_date?></th> <th scope="row"><?=$raw->profit_date?></th>
                        <td  align="right"> <?=number_format($raw->discounted_price,2)?></td> 
                          <td  align="right"> <?=number_format($lotdata[$raw->res_code]->costof_sale,2)?></td> 
                            <td  align="right"> <?=number_format($current,2)?></td> 
                    
                        <td  align="right"> <?=number_format($fullprofit,2)?></td> 
                            <td  align="right"> <?=number_format($initial,2)?></td> 
                             <td  align="right"> <?=number_format($dateprofit,2)?></td> 
                        
                        <td><?=$raw->pay_type?></td>
                        <td  align="right"> <?=number_format($rate_first,2)?></td> 
                             <td  align="right"> <?=number_format($rate_date,2)?></td> 
                              <td > <?=$raw->first_name?> <?=$raw->last_name?></td> 
                               <td  align="right">  <?=$raw->id_number?></td> 
                                <td  align="right"><?=$raw->address1?> , <?=$raw->address2?>, <?=$raw->address3?></td> 
                       
                        <td>
                        <?  
						     if($rate_date>=60) $class='green'; else if($rate_date<60 && $rate_date>=50)  $class='blue'; else if($rate_date<50 && $rate_date>=25)  $class='yellow'; else $class='red';?>
                              
		
                         <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($rate_date,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$rate_date?>%;"></div>
									</div>
                        
                        
                        
                        </td>
                         </tr> 
    <? } }}?>
    </tbody></table></div>
   
    </div> 
</div>