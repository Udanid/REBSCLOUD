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
             <h3 class="title1">Managing Director Dashboard</h3>
		
        
        
        
           <div class="widget-shadow">
      
       
        <div class="clearfix"> </div>
      
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
           <li role="presentation"   class="active" >
           <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Company Summery</a></li> 
                <li role="presentation">
          <a href="#collection" id="collection-tab" role="tab" data-toggle="tab" aria-controls="collection" aria-expanded="false">Collection</a></li> 
           <li role="presentation">
          <a href="#finance" id="finance-tab" role="tab" data-toggle="tab" aria-controls="finance" aria-expanded="false">Finance</a></li> 
         
        </ul>
       
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
            <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab"> 
                    <p>	<? $this->load->view("dashboard/md_main_data");?> </p> 
                </div>
                       <div role="tabpanel" class="tab-pane fade " id="collection" aria-labelledby="collection-tab"> 
                    <p>	 <? $this->load->view("dashboard/md_collection")?> </p> 
                </div>
                 <div role="tabpanel" class="tab-pane fade " id="finance" aria-labelledby="finance-tab"> 
                    <p>	 <? $this->load->view("dashboard/md_finance");?> </p> 
                </div>
                
               </div>
            </div>
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
   
