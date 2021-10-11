<!DOCTYPE HTML>
<html>
<head>

    <script src="<?=base_url()?>media/js/dist/Chart.bundle.js"></script>
    <script src="<?=base_url()?>media/js/utils.js"></script>
    
<?

	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<script type="text/javascript">
jQuery(document).ready(function() {
 	  $("#prj_id").chosen({
     allow_single_deselect : true
    });
	

 
	
});


</script>

<style type="text/css">

@media(max-width:1920px){
	.topup{
	margin-top:-90px;
}
}
@media(max-width:360px){
	.topup{
	margin-top:90px;
}
}
@media(max-width:790px){
	.topup{
	margin-top:100px;
}
}
@media(max-width:768px){
	.topup{
	margin-top:-80px;
}
}
</style> 

   <div id="page-wrapper"  >
			<div class="main-page topup" >
				<div class="row-one">
                 	<div class="col-md-4 widget">
						<div class="stats-left ">
							<h5>Ongoing</h5>
							<h4>Projects</h4>
						</div>
						<div class="stats-right">
							<label> <?=$ongingprojects?></label>
						</div>
						<div class="clearfix"> </div>	
					</div>
					<div class="col-md-4 widget states-mdl">
						<div class="stats-left">
							<h5>Today</h5>
							<h4>Expences</h4>
						</div>
						<div class="stats-right">
							<label><?=number_format($outflow)?></label>
						</div>
						<div class="clearfix"> </div>	
					</div>
					<div class="col-md-4 widget states-last">
						<div class="stats-left">
							<h5>Today</h5>
							<h4>Income</h4>
						</div>
						<div class="stats-right">
							<label><?=number_format($inflow)?></label>
						</div>
						<div class="clearfix"> </div>	
					</div>
				
				</div>
            
            
	              <div class="charts">
                  
					<div class="col-md-12 charts chrt-page-grids">
						 <div class="col-sm-6 "> <h4 class="title">Project Development Expences</h4></div> <? if($prjlist){?>
                        
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Select Project</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
             
					</select></div> <? }?>  
                    
                        <div class="clearfix"> </div>	
						 <canvas id="canvas" width="300"></canvas>
					</div>
					
					<div class="clearfix"> </div>
	<script type="text/javascript">
         var color = Chart.helpers.color;
        var barChartData = {
            labels: <?=$js_label?>,
            datasets: [{
                label: 'Estimate',
                backgroundColor:color(window.chartColors.blue).alpha(0.5).rgbString(),
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data:<?=$js_estimate?>
            }, {
                label: 'Actual',
                backgroundColor:<?=$js_colors?>,
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: <?=$js_actual?>
            }]
			

        };

           var ctx = document.getElementById("canvas").getContext("2d");
            new Chart(ctx, {type: 'bar', data: barChartData});

       

      
    </script>
							
				</div>
                
                
				<div class="row calender widget-shadow">
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
   
