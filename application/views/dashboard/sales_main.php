<!DOCTYPE HTML>
<html>
<head>

    <script src="<?=base_url()?>media/js/dist/Chart.js"></script>
    <script src="<?=base_url()?>media/js/utils.js"></script>
    
<?

	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script type="text/javascript">
jQuery(document).ready(function() {
 	  $("#prj_id").chosen({
     allow_single_deselect : true
    });
	

 
	
});
function load_currentchart(id)
{
	var list=document.getElementById('projectlist').value;
	var res = list.split(",");
	//alert(document.getElementById('estimate'+id).value)
	
			//$('#canvas'+res[i]).delay(1).fadeIn(1000);
			 document.getElementById("chartset").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		
			$( "#chartset" ).load( "<?=base_url()?>re/home/mychart/"+id );
		
}

</script>

<style type="text/css">

@media(max-width:1920px){
	.topup{
	margin-top:0px;
}
}
@media(max-width:360px){
	.topup{
	margin-top:0px;
}
}
@media(max-width:790px){
	.topup{
	margin-top:100px;
}
}
@media(max-width:768px){
	.topup{
	margin-top:-10px;
}
}
</style> 
 <script src="<?=base_url()?>media/js/dist/Chart.bundle.js"></script>
  								  <script src="<?=base_url()?>media/js/utils.js"></script>
                 
   <div id="page-wrapper"  >
			<div class="main-page" >
             <h3 class="title1">Sales Dashboard</h3>
		
        
        
        
           <div class="widget-shadow">
      
       
        <div class="clearfix"> </div>
      
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
           <li role="presentation"  class="active" >
           <a href="#allbranch" role="tab" id="allbranch-tab" data-toggle="tab" aria-controls="allbranch">All Branch</a></li> 
       
            <?  if($branchlist)
		 { $COUNT=0;
			 foreach($branchlist as $raw)
			 {?>
             <li role="presentation" >
             <a href="#<?=$raw->branch_code?>" role="tab" id="<?=$raw->branch_code?>-tab" data-toggle="tab" aria-controls="<?=$raw->branch_code?>"><?=$raw->branch_name?></a></li> 
          <?  $COUNT++;}
		 }?>
           
        
           
         
        </ul>
       
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
           
                <div role="tabpanel" class="tab-pane fade active in " id="allbranch" aria-labelledby="allbranch-tab"> 
						<p>  	<? $this->load->view("dashboard/salesmain_main_data");?> </p>
                      </div>
                
                 <?  if($branchlist)
				 { $COUNT=0;
					 foreach($branchlist as $raw)
					 {?>
					<div role="tabpanel" class="tab-pane fade  " id="<?=$raw->branch_code?>" aria-labelledby="<?=$raw->branch_code?>-tab"> 
						<p> <br>
                            <div class="form-title">
								<h4><?=$raw->branch_name?> Branch Sales as at <?=date('Y-m-d')?></h4>
							</div>
                            
                             <br />
                            <div class="row">
                             <div class="col-md-6">
                                  <table class="table table-bordered">
                                  <thead>
                                  <tr class="success"><th>Project Name</th>
                                  <th>Officer Name</th>
                                  <th>Total Blocks</th>
                                  <th>Total Sales</th>
                                  <th>Balance Block</th>
                                   <th>Balance Block %</th>
                                     <th>Balance Block Sale Value</th>
                                   
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?
								   $full_lots=0;$full_sale=0; $bal_lot=0; $bal_sale=0;
								    if($prjlist[$raw->branch_code])
									{
										
										foreach($prjlist[$raw->branch_code] as $raw2)
										{  $totlots=0;$totsale=0;$soldlot=0;$soldval=0;
											if($lotcount[$raw2->prj_id])
											{
												 $totlots=$lotcount[$raw2->prj_id]->totlots;
												 $totsale=$lotcount[$raw2->prj_id]->selstot;
											}
											if($sales[$raw2->prj_id])
											{
												 $soldval=$sales[$raw2->prj_id]->selstot;
												 $soldlot=$sales[$raw2->prj_id]->totcount;
											}
											$presentage=0;
											if($totlots>0)
											$presentage=($totlots-$soldlot)/$totlots*100;
											$full_lots=$full_lots+$totlots;
											$full_sale=$full_sale+$totsale; 
											$bal_lot=$bal_lot+($totlots-$soldlot); 
											$bal_sale=$bal_sale+($totsale-$soldval);
											
											?>
                                         <tr ><th><?=$details[$raw2->prj_id]->project_name?></th>
                                          <td><?=$details[$raw2->prj_id]->surname?></td>
                                          <td><?=$totlots?></td>
                                          <td><?=number_format($totsale,2)?></td>
                                          <td><?=$totlots-$soldlot?></td>
                                           <td><?=number_format($presentage,2)?></td>
                                             <td><?=number_format($totsale-$soldval,2)?></td>
                                   
                                		  </tr>
                                  <? 	}
									}?>
                                    <tr class="active"><th>Total</th>
                                  <th></th>
                                  <th><?=$full_lots?></th>
                                  <th><?=number_format($full_sale,2)?></th>
                                  <th><?=$bal_lot?></th>
                                   <th>-</th>
                                     <th><?=number_format($bal_sale,2)?></th>
                                   
                                  </tr>
                                  </tbody>
                                  
                                  </table>
                              </div>
                              <div class="col-md-6">
                               <canvas id="canvas<?=$raw->branch_code?>"  width="300"><img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif"></canvas>
                           <script type="text/javascript">
     						    var color = Chart.helpers.color;
    							    var barChartData = {
    							        labels: <?=$js_label[$raw->branch_code]?>,
    							        datasets: [{
    							            label: 'Total Blocks',
    							            backgroundColor:color(window.chartColors.blue).alpha(0.5).rgbString(),
     							           borderColor: window.chartColors.blue,
          							      borderWidth: 1,
         								       data:<?=$js_tot[$raw->branch_code]?>
       									     },{
    							            label: 'Balance Blcoks',
    							            backgroundColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
     							           borderColor: window.chartColors.purple,
          							      borderWidth: 1,
         								       data:<?=$js_bal[$raw->branch_code]?>
       									     }]
			

       								 };

       				    var ctx = document.getElementById("canvas<?=$raw->branch_code?>").getContext("2d");
         				   new Chart(ctx, {type: 'bar', data: barChartData});
						   
						   
						  
			

       

      
    </script>
					
                              </div>
                          </div>
                           <div class="form-title">
								<h4> Officers Achievment - month of <?=date("F")?></h4>
							</div>
                            
                             <br />
                            <div class="row">
                             <div class="col-md-6">
                                  <table class="table table-bordered">
                                  <thead>
                                  <tr class="success">
                                  <th>Officer Name</th>
                                  <th>Sale Target</th>
                                  <th>Acheivment</th>
                                  
                                   <th> %</th>
                                  <th>Block Target</th>
                                  <th>Acheivment</th>
                                  
                                   <th> %</th>
                                
                                
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?
								   $full_lots=0;$full_sale=0; $bal_lot=0; $bal_sale=0;
								   $counter=0;
								    if($offierlist[$raw->branch_code])
									{
										foreach($offierlist[$raw->branch_code] as $raw3)
										{  $totlots=0;$totsale=0;$soldlot=0;$soldval=0;
											if($target[$raw3->id])
											{
												 $totlots=$target[$raw3->id]->block;
												 $totsale=$target[$raw3->id]->sales;
											}
											if($salesachev[$raw3->id])
											{
												 $soldval=$salesachev[$raw3->id]->selstot;
												 $soldlot=$salesachev[$raw3->id]->totcount;
											}
											$label_sales[$counter]=$raw3->surname;
											$presentage_sale=0;$presentage_lot=0;
											if($totsale>0)
											$presentage_sale=($soldval)/$totsale*100;
											if($totlots>0)
											$presentage_lot=($soldlot)/$totlots*100;
											$full_lots=$full_lots+$totlots;
											$full_sale=$full_sale+$totsale; 
											$bal_lot=$bal_lot+$soldlot; 
											$bal_sale=$bal_sale+$soldval;
											$persentage_s[$counter]=$presentage_sale;
											$counter++;
											?>
                                         <tr ><th> <?=$raw3->initial?> <?=$raw3->surname?> </th>
                                          <td><?=number_format($totsale,2)?></td>
                                            <td><?=number_format($soldval,2)?></td>
                                           <td><?=number_format($presentage_sale,2)?></td>
                                            <td><?=number_format($totlots,2)?></td>
                                            <td><?=number_format($soldlot,2)?></td>
                                           <td><?=number_format($presentage_lot,2)?></td>
                                           
                                   
                                		  </tr>
                                  <? 	}
									}
									$js_label_sales=NULL;$js_persentage_s=NULL;
									$js_label_sales=json_encode($label_sales);
									$js_persentage_s=json_encode($persentage_s);
									?>
                                    <tr class="active"><th>Total</th>
                                
                                  <th><?=number_format($full_sale,2)?></th>
                                  <th><?=number_format($bal_sale,2)?></th>
                                  
                                   <th>-</th>
                                   <th><?=number_format($full_lots,2)?></th>
                                  <th><?=number_format($bal_lot,2)?></th>
                                     <th></th>
                                   
                                  </tr>
                                  </tbody>
                                  
                                  </table>
                              </div>
                              <div class="col-md-6">
                              
                                 <canvas id="canvas2<?=$raw->branch_code?>" width="300"></canvas>
                          	<script type="text/javascript">
     						  
						   
						   
						    var config = {
								type: 'pie',
								data: {
									datasets: [{
										data: <?=$js_persentage_s?>,
										backgroundColor: [
										 color(window.chartColors.red).alpha(0.5).rgbString(),
											color(window.chartColors.green).alpha(0.7).rgbString()
										],
										label: 'Dataset 1'
									}],
									labels: <?=$js_label_sales?>
								},
								options: {
									responsive: true
								}
   						 };
						   
						    var ctx = document.getElementById("canvas2<?=$raw->branch_code?>").getContext("2d");
         				 new Chart(ctx,  config);
			

       

      
    </script>
					
                              </div>
                          </div>
                        </p> 
                        
                        	
					</div> 
				  <?  $COUNT++;}
				 }?>
                     
               </div>
            </div>
         </div>
      </div>
        
        
        
        
	              
                </head>
                
				<div class="row calender widget-shadow" style="display:none">
					<h4 class="title">Calender</h4>
					<div class="cal1">
						
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>
   
