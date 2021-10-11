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
			<div class="main-page  topup" >
				<div class="row-one">
                 <? $this->load->view("includes/flashmessage");
				/// echo $this->session->userdata('usermodule');
				 
				 ?>
          
				
				</div>
            
                             
                             
                   </div>
                <? if($prjlist){?>
	              <div class="">
                    <div class="row ">
						     <div class="col-md-8 validation-grids  widget-shadow " data-example-id="basic-forms"> 
                             <div class="form-title">
								<h4>Monthly Target</h4>
							</div>
                            <br><br><br>
                              <div id="chartset">	  
                        <? $this->load->view("user/charts");?>
                        <br><br><br>
                        </div>
                             </div>
                             <div class="col-md-6 validation-grids widget-shadow validation-grids-right "  data-example-id="basic-forms"> 
                              <div class="form-title">
								<h4>Current Month Profit Transfers</h4>
                         	</div>
                            <br><div class="widget-shadow" style="max-height:350px; overflow:scroll" >
                                  <table class="table table-bordered" style="font-size:12px"><tr class="active"><th>Customer Name</th><th>Land</th><th>Profit Trn date</th><th>Paid %</th></tr>
                                 <? foreach($prjlist as $prjraw){
									 if( $profitlist[$prjraw->prj_id]){
										 foreach( $profitlist[$prjraw->prj_id] as $raw){  $paidpreentage=round(($raw->down_payment/$raw->discounted_price)*100,2); ?>
                                         <tr><td><?=$raw->first_name?> <?=$raw->last_name?>
                                         <td><?=$prjraw->project_name?>- <?=$raw->lot_number?></td>
                                         
                                            <?  if($paidpreentage>=60) $class='green'; else if($paidpreentage<60 && $paidpreentage>=50)  $class='blue'; else if($paidpreentage<50 && $paidpreentage>=25)  $class='red'; else $class='green';?><td colspan="2"> <span class="pull-right"><?=$paidpreentage?>%</span>
									<div class="progress progress-striped active ">
										<div class="bar <?=$class?>" style="width:<?=$paidpreentage?>%;"></div>
									</div></td>
                                         
                                          </tr>
                                 
                                 <? 	 }}}?>
                                 </table></div>
                                 
                   </div>
					
					<? }?>
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
   
