
<script type="text/javascript">

function load_printscrean1(prjid)
{
			window.open( "<?=base_url()?>re/report_excel/get_finance/"+prjid);
	
}

</script>
 <?
  $heading2='Finance Cost  '.$details->project_name;

 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <a href="javascript:load_printscrean1('<?=$details->prj_id?>')"> <i class="fa fa-print nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered">
     <tr class="success" style="font-weight:bold"><td colspan="7"  align="center"><?=$details->project_name?></td></tr>
       <tr><th >Serial No</th><th > Month </th><th>Cash Outflow</th><th >Cash inflow</th><th >NET CF</th> <th >Interest</th> <th >Interest Cost</th>
      
        
        </tr>
       
       
    <? 
	$srat=explode('-',$sartdate);
			$year=$srat[0];
			$month=$srat[1];
			$startDate=$year.'-'.$month.'-01';
			$totinti=0;
			$cumulativeout=0;
			$cumulativein=0;
			for($i=1; $i<=24; $i++)
			{
				if($startDate<date('Y-m-d')){
				$startDate=$startDate;
				$datearr=explode('-',$startDate);
				//print_r()
				$year=$datearr[0];
				$month=$datearr[1];
				$enddate=$year.'-'.$month.'-31';
				$monthName = date('F', mktime(0, 0, 0, intval($month), 10));
				$cumulativeout=$cumulativeout+$expence[$i];
				$cumulativein=$cumulativein+$dpcollect[$i];
				$netflow=$cumulativein-$cumulativeout;
				$intcost=0;
				if($netflow<0)
				{
					$intcost=$netflow*(-1)*1.5/100;
				}
				else $intcost=$netflow*1.5/100;
				$totinti=$totinti+$intcost;
				?>
                
				 <tr><td><?=$i?></td>
                 <td><?=$monthName."-".$year?></td>
        <td align="right"><?=number_format($expence[$i],2)?></td>
        <td align="right"><?=number_format($dpcollect[$i],2)?></td>
        <td align="right"> <?=number_format($netflow,2)?></td>
         <td align="right"> 1.5</td>
            <td align="right"><?=number_format($intcost,2)?></td></tr>
				<?
				
				$startDate=date('Y-m-d',strtotime('+1 months',strtotime($startDate)));
			}
			}
	
		//echo $prjraw->prj_id;
			$prjbujet=0;$prjexp=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			?>
  
        <tr class="active" style="font-weight:bold"><td colspan="6">Total</td>
        <td align="right"><?=number_format($totinti,2)?></td></td>
      
       
       
      
         </table></div>
    </div> 
    
</div>