
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">

setTimeout(function(){ 
		$("#year_sep").chosen({
   			 allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select an Instance"
    	});
	}, 300); 
	setTimeout(function(){ 
		$("#quoter").chosen({
   			 allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select an Instance"
    	});
	}, 300);

function run_report()
{
	var month= document.getElementById("month").value;
	var year= document.getElementById("year").value;
	var m_half= document.getElementById("m_half").value;
	var report_type= document.getElementById("report_type").value;
	if(report_type!='3')
	{
		if(month!="" &  year!="" &  m_half!=""){
	 
							 $('#fulldata').delay(1).fadeIn(600);
    					    document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
							if(report_type=='1')
							{
							//	alert("<?=base_url()?>accounts/tax/vat_schedule/"+year+"/"+month+"/"+m_half )
					$( "#fulldata" ).load( "<?=base_url()?>accounts/tax/vat_schedule/"+year+"/"+month+"/"+m_half );
					
							}
							if(report_type=='2')
							{
								//alert("<?=base_url()?>accounts/tax/input_vatreport/"+year+"/"+month+"/"+m_half )
					$( "#fulldata" ).load( "<?=base_url()?>accounts/tax/input_vatreport/"+year+"/"+month+"/"+m_half );
					
							}
				
					
	 
	 
		
 		}
		 else
 		{
			 document.getElementById("checkflagmessage").innerHTML='Please Select Year and Quater to generate report'; 
					 $('#flagchertbtn').click();
	
 		}
	}
	else
	{
		if(month!="" &  year!="" ){
	 
							 $('#fulldata').delay(1).fadeIn(600);
    					    document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
							if(report_type=='3')
							{
							//	alert("<?=base_url()?>accounts/tax/vat_summery/"+year+"/"+month )
					$( "#fulldata" ).load( "<?=base_url()?>accounts/tax/vat_summery/"+year+"/"+month );
					
							}
						
				
					
	 
	 
		
 		}
		 else
 		{
			 document.getElementById("checkflagmessage").innerHTML='Please Select Year and Quater to generate report'; 
						 $('#flagchertbtn').click();
	
 		}
	}
	 
}
var deleteid="";

</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">
 
                 
 
      <h3 class="title1">VAT Reports</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <li role="presentation" class="active">
          <a href="#vat" id="vat-tab" role="tab" data-toggle="tab" aria-controls="vat" aria-expanded="false">VAT Reports</a></li> 
          
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
               <div role="tabpanel" class="tab-pane fade active in" id="vat" aria-labelledby="vat-tab" >
               <br>
             <? $this->load->view("includes/flashmessage");?>
                        <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       
                        <div class="form-body form-horizontal">
                           
                          <div class="form-group"><div class="col-sm-2 "> 
                          <select class="form-control" placeholder="Qick Search.."    id="year" name="year"  required="required" >
                           <option value="">Year</option>
                          <? for($i=2018; $i<=2055; $i++){?>
                          <option value="<?=$i?>"><?=$i?></option>
                          <? }?>
                          </select></div>
                          
                          <div class="col-sm-2 ">   <select class="form-control" placeholder="Qick Search.."  id="month" name="month"  required="required" >
                           <option value="">Month</option>
                          <? for($i=1; $i<=12; $i++){
							  $monthName = date('F', mktime(0, 0, 0, $i, 10));?>
                          <option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=$monthName?></option>
                          <? }?>
                          </select></div>
                          <div class="col-sm-2 ">  <select class="form-control" placeholder="Qick Search.."    id="m_half" name="m_half"  required="required" >
                           <option value="">Select Period</option>
                         
                          <option value="1">first Half</option>
                           <option value="2">Second Half</option>
                        
                          </select></div>
                           <div class="col-sm-2 ">  <select class="form-control" placeholder="Qick Search.."    id="report_type" name="report_type"  required="required" >
                        
                         
                          <option value="1">VAT Schedule </option>
                           <option value="2">Input Vat Report</option>
                           <option value="3"> Vat Summery</option>
                        
                          </select></div>
                         
										<div class="col-sm-3 has-feedback" id="paymentdateid"><button  class="btn btn-primary "  onClick="run_report()">Run Report</button></div></div></div>
                       
                       </div>
                       
                       
                       </div>
                       <div id="fulldata"> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>
                        
                        
                        
				
                    
                </div> 
               
                
                
                
                
            </div>
         </div>
      </div>
        
        
        
         <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content"> 
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4> 
									</div> 
									<div class="modal-body" id="checkflagmessage"> Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
									</div>
								</div>
							</div>
						</div>
					</div>
                    
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_subtask" name="complexConfirm_subtask"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_subtask" name="complexConfirm_confirm_subtask"  value="DELETE"></button>

<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>config/producttasks/delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            
              $("#complexConfirm_confirm").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>config/producttasks/confirm/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			$("#complexConfirm_subtask").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>config/producttasks/delete_subtask/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            
              $("#complexConfirm_confirm_subtask").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>config/producttasks/confirm_subtask/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			
			
            </script> 
            
            
        
        <div class="row calender widget-shadow"  style="display:none">
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