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
 	 
	
   $("#emp").chosen({
     allow_single_deselect : true
    });

   $("#supplier").chosen({
     allow_single_deselect : true
    });
 
	
});

 $( function() {
    $( "#from_date" ).datepicker({dateFormat: 'yy-mm-dd'});
     $( "#to_date" ).datepicker({dateFormat: 'yy-mm-dd'});
  } );

function load_fulldetails()
{
	 var emp_id=document.getElementById("emp").value;
	  var sup_id=document.getElementById("supplier").value;
       var from_date=document.getElementById("from_date").value;
        var to_date=document.getElementById("to_date").value;

        if(from_date == '')
        {
            from_date = 'all';
        }

         if(to_date == '')
        {
            to_date = 'all';
        }
	// alert(month)
	
		$('#fulldata').delay(1).fadeIn(600);
    	document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		$( "#fulldata").load( "<?=base_url()?>accounts/report/direct_payment_report_data/"+emp_id+'/'+sup_id+'/'+from_date+'/'+to_date);
	
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
                        <select class="form-control" placeholder="Qick Search.."    id="emp" name="emp" >
                        	<option value='all'>Select Officer</option>
                            <?if($emp_list){foreach($emp_list as $row){?>
                                <option value="<?=$row->id;?>"><?=$row->emp_no?> - <?=$row->display_name?></option>
                    	   <?}}?>
             
					</select>  </div>
                    <div class="form-group">
                        <select class="form-control" placeholder="Qick Search.."    id="supplier" name="supplier" >
                            <option value='all'>Select Supplier</option>
                           <?if($suplist){foreach($suplist as $row){?>
                                <option value="<?=$row->sup_code;?>"><?=$row->first_name?> <?=$row->last_name?></option>
                           <?}}?>
             
                    </select>  </div>

                    <div class="form-group">
                        <input type="text" name="from_date" class="form-control"  id="from_date" autocomplete="off" placeholder="From Date">
             
                    </div>


                    <div class="form-group">
                         <input type="text" name="to_date" class="form-control" id="to_date" autocomplete="off" placeholder="To Date">
                         </div>
                    
                    <div class="form-group">
                        <button type="button" onclick="load_fulldetails()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</form>   <div class="clearfix"> </div><br><div id="fulldata"></div>    <br />
<br /><br /><br /><br /><br /><br /><br /><br /><br /></p> 
				
				</div>
            
            
	             
                 <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content"> 
									<div class="modal-header"  style="background-color:#339">
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
   