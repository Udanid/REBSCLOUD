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
                 
				
				</div>
            
            
	              <div class="charts">
                  
					<div class="col-md-12 charts chrt-page-grids">
						 <div class="col-sm-6 "> Project Development Expences</h4></div> <? if($prjlist){?>
                        
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="load_currentchart(this.value)" id="prj_id" name="prj_id" >
                    <?    foreach($prjlist as $row){
						if($row->status=='CONFIRMED'){
						?>
                    <option value="<?=$row->prj_id?>" <? if($currentproject==$row->prj_id){?> selected<? }?>><?=$row->project_name?></option>
                    <? }}?>
             
					</select><input type="hidden" name="projectlist" id="projectlist" value="<?=$prjidlist?>"></div>  <? } ?>  
                    
                        <div class="clearfix"> </div>
                        <div id="chartset">	
                       <canvas id="canvas" width="300"></canvas>
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
      								          label: 'New Budget',
        								        backgroundColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
         									       borderColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
          									      borderWidth: 1,
           									     data: <?=$js_budget?>
          									  }, {
      								          label: 'Actual',
        								        backgroundColor:<?=$js_colors?>,
         									       borderColor: <?=$js_colors?>,
          									      borderWidth: 1,
           									     data: <?=$js_actual?>
          									  }]
			

       								 };

       				    var ctx = document.getElementById("canvas").getContext("2d");
         				   new Chart(ctx, {type: 'bar', data: barChartData});
			

       

      
    </script>
                        
						</div>
                          
					</div>
					
					<div class="clearfix"> </div>
							
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
   
