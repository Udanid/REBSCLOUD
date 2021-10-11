
<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:70%;
font-size:90%;
}
.row{
	font-size:80%;
}
.table{
	font-size:100%;
}
</style>
<script type="text/javascript">

function print_function()
{
	window.print() ;
	window.close();
}
</script>
<body onLoad="print_function()">
<div class="form-title">
 <?
 if($month!=''){
 $heading=date('F', mktime(0, 0, 0, intval($month), 10)). ' Month Profit Realization Summery';
  $heading2=date('F', mktime(0, 0, 0, intval($month), 10)). ' Month Profit Realization Details';
 }
 else{
 $heading='Profit Realization Summery of Current Finance Year';
  $heading2='Profit Realization Details of Current Finance Year';
 }
 
  if($prjlist){$counter=0;
		foreach($prjlist as $prjraw){
        $lable[$counter]=$prjraw->project_name;
		$profit[$counter]=0;
		$sale[$counter]=0;
		if($month!=''){
   if($transferlist[$prjraw->prj_id][$month]){
			$sale[$counter]=$transferlist[$prjraw->prj_id][$month]->selstot;
			$profit[$counter]=$transferlist[$prjraw->prj_id][$month]->selstot-$transferlist[$prjraw->prj_id][$month]->costtot;
					}}
	else
		{
			
			$start=date($this->session->userdata('fy_start'));
				$end=date('Y-m-d');
				while($start<=$end)
				{ 
					$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					$stdate=$year.'-'.$month2.'-01';
					$enddate=$year.'-'.$month2.'-31';
					$profit[$counter]=$profit[$counter]+$transferlist[$prjraw->prj_id][$month2]->selstot-$transferlist[$prjraw->prj_id][$month2]->costtot;
					$sale[$counter]=$sale[$counter]+$transferlist[$prjraw->prj_id][$month2]->selstot;
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					
				}
		}
		$fullsale[$counter]=$projecttots[$prjraw->prj_id]->totsale;
		$fullprofit[$counter]=$projecttots[$prjraw->prj_id]->totsale-$projecttots[$prjraw->prj_id]->totcost;
        $counter++;
		}}
		
		$js_label=json_encode($lable);
				$js_sale=json_encode($sale);
				$js_profit=json_encode($profit);
				$js_fullsale=json_encode($fullsale);
				$js_fullprofit=json_encode($fullprofit);
		?>
      
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <a href="javascript:load_printscrean1('0','<?=$month?>')"> <i class="fa fa-print nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered"><tr class="success"><th>Project Name</th>
        <? $counter=0; if($month!=""){ $counter=1;?>
        <th colspan="2"><?=date('F', mktime(0, 0, 0, intval($month), 10));?></th>
        <? }else{
        	$start=date($this->session->userdata('fy_start'));
				$end=date('Y-m-d');
				
				
				while($start<=$end)
				{ 
				$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					$counter++;
				?>
                
                   <th colspan="2" ><?=date('F', mktime(0, 0, 0, $month2, 10));?></th>
                <?
				}
         }?>
        </tr>
        <tr ><td></td>
        <? for($i=0; $i<$counter; $i++){?>
        <th class="info">Total Sale</th>
         <th class="info">Total Profit</th>
        <? }?>
        </tr>
       
    <? 
	
	
	if($prjlist){
		foreach($prjlist as $prjraw){?>
        <tr><td><?=$prjraw->project_name?></td>
         <? if($month!=""){
			 if($transferlist[$prjraw->prj_id][$month]->selstot) $sale=$transferlist[$prjraw->prj_id][$month]->selstot;else $sale=0;
					if($transferlist[$prjraw->prj_id][$month]->costtot)$cost=$sale-$transferlist[$prjraw->prj_id][$month]->costtot ;else $cost=0;
				
			 ?>
        <td  align="right"><?=number_format($sale,2)?></td>
           <td align="right" ><?=number_format($cost,2);?></td>
        <? }else{
        	$start=date($this->session->userdata('fy_start'));
				$end=date('Y-m-d');
				$counter=0;
				
				while($start<=$end)
				{ 
				$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					if($transferlist[$prjraw->prj_id][$month2]->selstot) $sale=$transferlist[$prjraw->prj_id][$month2]->selstot;else $sale=0;
					if($transferlist[$prjraw->prj_id][$month2]->costtot)$cost=$sale-$transferlist[$prjraw->prj_id][$month2]->costtot ;else $cost=0;
					?>
                      <td align="right" ><?=number_format($sale,2)?></td>
           <td  align="right"><?=number_format($cost,2)?></td>
                    <?
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					$counter++;
				?>
                
                
                <?
				}
         }?>
     </tr>
        
        
        <? }}?>
         </table></div>
    </div> 
    
</div>