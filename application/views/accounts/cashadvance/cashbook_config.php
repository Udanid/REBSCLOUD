
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

$("#ledger_id").chosen({
    allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select an Option"
    });
	
});

function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accounts/cashadvance/delete_chercker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#complexConfirm').click();
				}
            }
        });
	
	
//alert(document.testform.deletekey.value);
	
}

function call_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_deedtrn', id: id,fieldname:'id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#complexConfirm_confirm').click();
				}
            }
        });
	
	
//alert(document.testform.deletekey.value);
	
}
function call_confirm_deed(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_deedtrn', id: id,fieldname:'id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#complexConfirm_confirm_deed').click();
				}
            }
        });
	
	
//alert(document.testform.deletekey.value);
	
}


function load_fulldetails(id)
{
	
	 if(id!=="CSH")
	 {
		 $('#float_cash').delay(1).fadeOut(600);
	 }
	 else
	 {
		 $('#float_cash').delay(1).fadeIn(600);
	 }
}

</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Cash Books Configuration</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
           <li role="presentation" <? if($list=''){?> class="active"<? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Book Types</a></li> 
           <li role="presentation" <? if($list='book'){?> class="active"<? }?>><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Assing Books</a></li> 
         
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          <? $this->load->view("includes/flashmessage");?>
            
                <div role="tabpanel" class="tab-pane fade <? if($list=''){?>  active in <? }?>" id="profile" aria-labelledby="profile-tab"> 
                    <p>	
                    
                     
                          <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashadvance/add_type" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>New Book Type </h4>
						</div>
                        <div class="form-body form-horizontal">
                           
                          <div class="form-group"><div class="col-sm-3 ">  <input  type="text" class="form-control" id="type_name"    name="type_name"  value=""   data-error="" required  placeholder=" Type Name"onChange="load_detailsagain()" ></div>
                         
										<div class="col-sm-3 has-feedback" id="paymentdateid"><button type="submit" class="btn btn-primary disabled" >Add Type</button></div></div></div>
                       
                       </div>
                       
                       
                       </div>
                       
                        
                        
                        
					</form>
                    
                    
                  
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                      <div class="form-title">
								<h4>Book Type List  </h4>
							</div>  
                            <br>
                   <table class="table"> <thead> <tr> <th>ID</th> <th>Type</th><th></th> </tr> </thead>
                      <? if($searchdata){$c=0;
                          foreach($searchdata as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->type_id?></th> <td><?=$row->type_name ?> </td>
                        <td align="right"><div id="checherflag">
                      
                             <a  href="javascript:call_delete('<?=$row->type_id?>')" title="Confirm"><i class="fa fa-times nav_icon icon_red"></i></a>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table></div>
                    
                    
                    
                      
                   </p> 
               
                </div>
                <div role="tabpanel" class="tab-pane fade  <? if($list='book'){?>  active in <? }?> " id="list" aria-labelledby="list-tab"> 
                    <p>	
                        <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                      <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashadvance/add_book" enctype="multipart/form-data">
                     
                       <div class="form-title">
								<h4>Assing Ledger to Cash Book </h4>
						</div>
                        <div class="form-body form-horizontal">
                           
                          <div class="form-group"><div class="col-sm-2 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="branch_code" name="branch_code"  required="required" >
                    <option value="">Branch Name</option>
                    <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>"><?=$row->branch_name?></option>
                    <? }?>
             
					</select></div>
                          <div class="col-sm-2 "  id="myloanlist">  <select class="form-control" placeholder="Qick Search.."    id="type_id" name="type_id"  required="required" >
                    <option value="">Type search</option>
                    <?    foreach($searchdata as $row){
						
						?>
                    <option value="<?=$row->type_id?>" ><?=$row->type_name?>  </option>
                    <? }?>
             
					</select></div>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><select class="form-control" placeholder="Qick Search.."    id="ledger_id" name="ledger_id"  required="required" >
                    <option value="">Ledger Account</option>
                    <?    foreach($ledgerlist as $row){
						
						?>
                    <option value="<?=$row->id?>" ><?=$row->name?>  </option>
                    <? }?>
             
					</select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                       
                                         <div class="col-sm-2 "  id="myloanlist">  <select class="form-control" placeholder="Qick Search.."    id="pay_type" name="pay_type"  onChange="load_fulldetails(this.value)" required="required" >
                    <option value="">Pay Type</option>
                  
                    <option value="CHQ" >Cheque</option>
                     <option value="CSH" >Cash</option>
                  
             
					</select></div>   <div class="form-group"><div class="col-sm-3 " id="float_cash" style="display:none">  <input  type="text" class="form-control number-separator" id="cash_float"    name="cash_float"  value=""   data-error="" required  placeholder="Cash Float"></div></div>
                                        <div class="col-sm-3 has-feedback" id="paymentdateid"><button type="submit" class="btn btn-primary disabled" >Add Ledger</button></div>
                                        </div>
                        
                       
                       </div>
                        
                        
                        
					</form>
                    </div>
                    
                       
                      
                         <div class="clearfix"> </div>
                   
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                      <div class="form-title">
								<h4>Cash Book List  </h4>
							</div>  
                            <br>
                   <table class="table"> <thead> <tr> <th>ID</th> <th>Branch</th> <th>Type</th> <th>Ledger Account </th> </tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->id?></th> <td><?=$row->branch_name ?> </td> <td><?=$row->type_name?></td>
                        <td><?=$row->name?></td> 
                        <td></td>
                      
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table></div></div>
                   </p> 
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
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>
 <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_advdelete" name="complexConfirm_advdelete"  value="DELETE"></button>
                   
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_deed" name="complexConfirm_confirm_deed"  value="DELETE"></button>

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
                    window.location="<?=base_url()?>accounts/cashadvance/delete_type/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			 $("#complexConfirm_advdelete").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this advance Payment ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>re/reservation/delete_advance/"+document.deletekeyform.deletekey.value;
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
					
                    window.location="<?=base_url()?>re/deedtransfer/confirm_transfer/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			$("#complexConfirm_confirm_deed").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>re/deedtransfer/confirm_deed/"+document.deletekeyform.deletekey.value;
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