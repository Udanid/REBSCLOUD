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
 	 
	 
	$("#prj_id").focus(function() { $("#prj_id").chosen({
     allow_single_deselect : true
    }); });
	$("#sup_code").focus(function() { $("#sup_code").chosen({
     allow_single_deselect : true
    }); });
	

 
	
});

function load_projectdata(code)
{
	if(code=='03')
	{
		$('#projectdata').delay(1).fadeOut(600);
	}
	else
	$('#projectdata').delay(1).fadeIn(600);
}
function load_fulldetails()
{
	 var rpt_type=document.getElementById("rpt_type").value;
	  var sup_code=document.getElementById("sup_code").value;
	  if(rpt_type=='02')
	  {
		 if(sup_code!="")
		 {
			document.getElementById("suppsearchform").submit(); 
	 	}
		 	 else
	 	 {
		 	  document.getElementById("checkflagmessage").innerHTML='Please Select Supplier to generate report';
			   $('#flagchertbtn').click();
	 	 }
	  }
	   if(rpt_type=='01')
	  {
		
			document.getElementById("suppsearchform").submit(); 
	 	
	  }
}


function load_branchproject(id)
{
			 document.getElementById("prjlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
			  $( "#prjlist").load( "<?=base_url()?>re/report/get_branch_projectlist/"+id);



}
function expoet_excel_supliier()
{
		
		
		document.getElementById("myexportform_supplier").submit();
				//window.open( "<?=base_url()?>advancesarch/reservationlist_excel/"+qua);
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
			<div class="main-page  " >
             
				<div class="row-one">
                 <h3 class="title1"> Invoice Reports</h3>
                 	  <form data-toggle="validator" id="suppsearchform" name="suppsearchform" method="post" action="<?=base_url()?>accounts/invoice/report_data"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;  background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">  <div class="form-group" id="typeid">
                    <select class="form-control" placeholder="Qick Search.."    id="rpt_type" name="rpt_type"  >
                    <option value="ALL">Report Type</option>
                    <option value="01">Outstanding Report </option>
                    <option value="02">Payment Report </option>
                  
             
					</select>  </div>
                    
                     <div class="form-group" id="prjlist">
                        <select class="form-control" placeholder="Qick Search.."    id="sup_code" name="sup_code" >
                    <option value="">Supplier Name</option>
                    <?    foreach($suplist as $row){?>
                    <option value="<?=$row->sup_code?>"><?=$row->first_name?>  <?=$row->last_name?></option>
                    <? }?>

					</select>  </div>
                     <div class="form-group" id="blocklist">
                       <input type="text" name="fromdate" id="fromdate" placeholder="From Date"  class="form-control" >
                 
                    </div>
                    <div class="form-group" id="blocklist">
                       <input type="text" name="todate" id="todate" placeholder="To Date"  class="form-control" >
                 
                    </div>
                    
                  
                    <div class="form-group">
                        <button type="button" onclick="load_fulldetails()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>
            
        </div>
           
  
    </div>
</form>   <div class="clearfix"> </div><br><div id="fulldata" style="min-height:100px;">   

<?  if($datalist){?>
 <div class="form-title">
		<h4> Supplier Payment Report
       <span style="float:right"> <!--<a href="javascript:expoet_excel_supliier()"> <i class="fa fa-file-excel-o nav_icon"></i></a>-->
</span></h4></div>
   <div class="col-md-12  widget-shadow" data-example-id="basic-forms" >
   
 <form data-toggle="validator" id="myexportform_supplier" method="post" action="<?=base_url()?>accounts/invoice/supplier_outstanding_excel"  enctype="multipart/form-data">
                  <input type="hidden" name="lastq" id="lastq" value="<?=$lastq?>">
                  
                  </form>
 <table class="table"> <thead> <thead> <tr> <th> Date</th> <th>Supplier Name</th>  <th>Invoice Type</th> <th>Invoice Number</th> <th>Payment Date</th><th>Payment Description</th> <th>Invoice Amount</th><th>Paid Amount</th><th>Vouvher/Cheque No</th></tr> </thead>
                      <? $prjname='';$brcode='';  
					  $suptot=0; $suppaytot=0;
					  $prj_id=''; $brid='';
					  $fulltot=0; $fullpaytot=0;
					  if($datalist){$c=0;
                          foreach($datalist as $row){
							 ?>  <tbody>
                      <? if($prj_id!='' & $prj_id!=$row->invoice_id){?>
                       <tr class="info" style="font-weight:bold"> 
                        <td scope="row" colspan="7"><?=$prjname?> Invoice Paid  Total</td>
                        
                       
                               <td align="right"><?=number_format($suppaytot,2)?></td>
                                <td></td>
                           </tr> 
                         
                      <? $suppaytot=0;$prjdis=0;$prjsale=0; $prjmdp=0;$prjpaid=0;$prjbmdp=0;
					   }?>
                       
                       <tr > 
                        <td scope="row"><?=$row->date?></td><td> <?=$row->first_name?> <?=$row->last_name?></td><td> <?=$row->type ?></td> <td><?=$row->inv_no ?>
                         <td><?=$row->pay_date?></td>
                        <td><?=$row->note ?></td>
                        <td align="right"><?=number_format($row->total,2)?></td>
                         <td align="right"><?=number_format($row->pay_amount,2)?></td>
                            <td><?=$row->voucher_id ?>/<?=$row->CHQNO ?></td>
                     
                         </tr> 
                        
                                <?
									$suptot=$suptot+($row->total);
									$suppaytot=$suppaytot+($row->pay_amount);
								$prj_id=$row->invoice_id;
								$prjname=$row->inv_no;
									$fulltot=$fulltot+($row->total);
								$fullpaytot=$fullpaytot+($row->pay_amount);
								
								
								
								  }} ?>
                                     <tr class="info" style="font-weight:bold"> 
                        <td scope="row" colspan="7"> <?=$prjname?> Invocie Total</td>
                               <td align="right"><?=number_format($suppaytot,2)?></td>
                                <td></td>
                            </tr> 
                         
                          <tr class="yellow" style="font-weight:bold"> 
                        <td scope="row" colspan="7"> Total</td>
                                <td align="right"><?=number_format($fullpaytot,2)?></td>
                                <td></td>
                              </tr> 
                          </tbody></table></div> <? }?></div></p>  
				
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
   
