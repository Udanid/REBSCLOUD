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

 $( function() {
    $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
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
			$( "#chartset2" ).load( "<?=base_url()?>re/home/mychart/"+id );
		
}
function load_fulldetails()
{
	 var fromdate= document.getElementById("fromdate").value;
	  var collection=document.getElementById("collection").value;
	    var branchid=document.getElementById("branch_code").value;
	if(fromdate!='')
	{
	  if(collection!='')
	  {
		
		
		  
	 		 $('#fulldata').delay(1).fadeIn(600);
    		  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 				
			// alert(  "<?=base_url()?>re/summeryreport/loan_arrears_summery/"+branchid+'/'+fromdate);
				  $( "#fulldata").load( "<?=base_url()?>re/summeryreport/loan_arrears_summery/"+branchid+'/'+fromdate+'/'+collection);
			  
			  
	  }
	  else
	  { 
		   document.getElementById("checkflagmessage").innerHTML='Please Select Report Type generate report'; 
		   $('#flagchertbtn').click(); 
	  }
	}
	else
	{
		document.getElementById("checkflagmessage").innerHTML='Please Select Month to generate report'; 
		   $('#flagchertbtn').click(); 
	}
}
function load_branchproject(id)
{
			 document.getElementById("prjlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
			  $( "#prjlist").load( "<?=base_url()?>re/report/get_branch_projectlist/"+id);
	
		
		
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
                 	  <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/income/search"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                <div class="form-group">
                        <select class="form-control" placeholder="Qick Search.."    id="branch_code" name="branch_code" >
                    <? if(check_access('all_branch')){?>
                    <option value="ALL">All Branch</option>
                     <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>" <? ?>><?=$row->branch_name?> </option>
                    <? }?>
                    <? } else {?>
                    <?    foreach($branchlist as $row){if($this->session->userdata('branchid')==$row->branch_code){?>
                    <option value="<?=$row->branch_code?>" <? ?>><?=$row->branch_name?> </option>
                    <? }} }?>
             
					</select>  </div>
                    <div class="form-group" id="prjlist">
                        <input type="text" name="fromdate" id="fromdate" placeholder="From Date"  value="<?=date('Y-m-d')?>" class="form-control" >  </div>
                   
                    <div class="form-group" id="blocklist">
                        <select  name="collection" id="collection" class="form-control" >
                         <option value="">Report Type</option>
                        <option value="01">Arrears Summery</option>
                       <option value="02">Loan Summery</option>
                    
                       
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="button" onclick="load_fulldetails()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>
            
        </div>
           
  
    </div>
</form>   <div class="clearfix"> </div><br><div id="fulldata" style="min-height:100px;"></div>    <br />
<br /><br /><br /><br /><br /><br /><br /><br /><br /></p> 
				
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
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>
                    
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
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
                    window.location="<?=base_url()?>re/project/delete/"+document.deletekeyform.deletekey.value;
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
					
                    window.location="<?=base_url()?>re/lotdata/confirm_price/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            </script> 
            
                
				<div class="row calender widget-shadow" style="display:none">
					<h4 class="title">Calender</h4>
					<div class="cal1" >
						
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>
   
