<!DOCTYPE HTML>
<html>
<head>

    <script src="<?=base_url()?>media/js/dist/Chart.bundle.js"></script>
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

   <div id="page-wrapper"  >
			<div class="main-page" >
             <h3 class="title1"><?=$branchdata->branch_name?> Dashboard</h3>
				<? $mcoll_target=0;$msales_target=0;$mincome_target=0;
				 $mcoll_actual=0;$msales_actual=0;$mincome_actual=0;
				 
				 $ycoll_actual=0;$ysales_actual=0;$yincome_actual=0;
                if($mforcast)
				{
					$mcoll_target=$mforcast->coll_target;
					$msales_target=$mforcast->sales_target;
					$mincome_target=$mforcast->income_target;
				}
				if($msales)
				{
					$msales_actual=$msales->selstot;
					$mincome_actual=$msales_actual-$msales->costtot;
				}
				if($mcollection)
				{
					$mcoll_actual=$mcollection->tot;
					
				}
				if($ysales)
				{
					$ysales_actual=$ysales->selstot;
					$yincome_actual=$ysales_actual-$ysales->costtot;
				}
				if($ycollection)
				{
					$ycoll_actual=$ycollection->tot;
					
				}
				
				?>
                 	
				 <div class="col-md-6 validation-grids  widget-shadow " data-example-id="basic-forms" style="margin-right:5px;"> 
                             <div class="form-title">
								<h4>Yearly  Summery</h4>
							</div>
                           
                              <div  class="table-responsive"   >
                              <? $presentage=100; if($ysales_target>0) $presentage=$ysales_actual/$ysales_target*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="warning"><th width="40%">SALES TARGET </th><td width="60%" align="right"><?=number_format($ysales_target,2)?></td></tr>
                              <tr class="success"><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($ysales_actual,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE</th><td align="right"><?=number_format($ysales_target-$ysales_actual,2)?></td></tr>
                               <tr class="info"><th>PERCENTAGE</th><td align="right"> 
                                   <div>
                                    <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div>
									</td></tr>
                              </table>	  
                     
                             </div>
                               <div  class="table-responsive"   >
                              <? $presentage=100; if($ycoll_target>0) $presentage=$ycoll_actual/$ycoll_target*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="warning"><th width="40%">D/P COLLECTION TARGET </th><td align="right"><?=number_format($ycoll_target,2)?></td></tr>
                              <tr class="success"><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($ycoll_actual,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE</th><td align="right"><?=number_format($ycoll_target-$ycoll_actual,2)?></td></tr>
                               <tr class="info"><th>PERCENTAGE</th><td align="right">
                                   <div>
                                    <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div>    
                                    </td></tr>
                              </table>	  
                     
                             </div>
                              <div  class="table-responsive"   >
                              <? $presentage=100; if($yincome_target>0) $presentage=$yincome_actual/$yincome_target*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="warning"><th width="40%">INCOME TARGET </th><td align="right"><?=number_format($yincome_target,2)?></td></tr>
                              <tr class="success"><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($yincome_actual,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE</th><td align="right"><?=number_format($yincome_target-$yincome_actual,2)?></td></tr>
                               <tr class="info"><th>PERCENTAGE</th><td align="right">
                               		 <div>
                                      <div class="col-sm-9">
                                              <div  class="progress progress-striped active">
                                                  <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                              </div>
                                      </div>
                                      <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                    </div>    
                               		</td></tr>
                              </table>	  
                     
                             </div>
                    </div>
                     <div class="col-md-6 validation-grids  widget-shadow" data-example-id="basic-forms"> 
                             <div class="form-title">
								<h4>Monthly  Summery</h4>
							</div>
                            <div  class="table-responsive"   >
                              <? $presentage=100; if($msales_target>0){ $presentage=$msales_actual/$msales_target*100;}
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="warning"><th width="40%">SALES TARGET </th><td align="right"><?=number_format($msales_target,2)?></td></tr>
                              <tr class="success"><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($msales_actual,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE</th><td align="right"><?=number_format($msales_target-$msales_actual,2)?></td></tr>
                               <tr class="info"><th>PERCENTAGE</th><td align="right">
                               		<div>
                                      <div class="col-sm-9">
                                              <div  class="progress progress-striped active">
                                                  <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                              </div>
                                      </div>
                                      <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                    </div>  </td></tr>
                              </table>	  
                     
                             </div>
                              <div  class="table-responsive"   >
                              <? $presentage=100; if($mcoll_target>0) $presentage=$mcoll_actual/$mcoll_target*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="warning"><th width="40%">D/P COLLECTION TARGET </th><td align="right"><?=number_format($mcoll_target,2)?></td></tr>
                              <tr class="success"><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($mcoll_actual,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE</th><td align="right"><?=number_format($mcoll_target-$mcoll_actual,2)?></td></tr>
                               <tr class="info"><th>PERCENTAGE</th><td align="right"> 
                               	    <div>
                                      <div class="col-sm-9">
                                              <div  class="progress progress-striped active">
                                                  <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                              </div>
                                      </div>
                                      <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                    </div>  
                               		</td></tr>
                              </table>	  
                     
                             </div>
                              <div  class="table-responsive"   >
                              <? $presentage=100; if($mincome_target>0) $presentage=$mincome_actual/$mincome_target*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="warning"><th width="40%">INCOME TARGET </th><td align="right"><?=number_format($mincome_target,2)?></td></tr>
                              <tr class="success"><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($mincome_actual,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE</th><td align="right"><?=number_format($mincome_target-$mincome_actual,2)?></td></tr>
                               <tr class="info"><th>PERCENTAGE</th><td align="right">
                               		<div>
                                      <div class="col-sm-9">
                                              <div  class="progress progress-striped active">
                                                  <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                              </div>
                                      </div>
                                      <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                    </div></td></tr>
                              </table>	  
                     
                             </div>
                    </div>
				
            
            
	              
                
                
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
   
