
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
$( function() {
    $( "#paydate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
jQuery(document).ready(function() {
  
setTimeout(function(){ 
	$("#res_code").chosen({
    allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select an Option"
    });
	}, 500);
	
});

function chosenActivate(){
	setTimeout(function(){ 
	  $("#loan_code_his").chosen({
    		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select an Option"
    	});
	}, 500);
}
	

function load_fulldetails(id)
{//alert('ssss');
id=document.getElementById("res_code").value;
	 if(id!="")
	 {
		var paydate=document.getElementById("paydate").value;
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		   $( "#fulldata").load( "<?=base_url()?>re/di_return/get_di_payment_data/"+id+"/"+paydate);
	 }
}





function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_return', id: id,fieldname:'return_id' },
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
function call_delete_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_return', id: id,fieldname:'return_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#complexConfirm_delete').click();
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
            data: {table: 're_return', id: id,fieldname:'return_id' },
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
</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">DI Return Module</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          
           <li role="presentation"  <? if($tab==''){?> class="active"<? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Di Return</a></li> 
             <li role="presentation"  <? if($tab=='list'){?> class="active"<? }?>><a href="#history" role="tab" id="history-tab" data-toggle="tab" aria-controls="history" aria-expanded="true" onClick="chosenActivate()">Di Return List</a></li> 

            <!-- <li role="presentation"  < ? if($this->session->flashdata('tab')=='followups'){?> class="active"< ? }?>><a href="#followups" role="tab" id="followups-tab" data-toggle="tab" aria-controls="followups" aria-expanded="true">Followup Index</a></li> 

        -->
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          
            <? $this->load->view("includes/flashmessage");?>
             
                <div role="tabpanel" class="tab-pane fade <? if($tab==''){?>active in<? }?>" id="profile" aria-labelledby="profile-tab"> 
                   
                  
                       <form data-toggle="validator" method="post" action="<?=base_url()?>re/di_return/apply_return" enctype="multipart/form-data">
                       <div class="row">
					
                       <div class=" widget-shadow" data-example-id="basic-forms"> 
                               <div class="form-title">
                                        <h4>Reservation Details</h4>
                                </div>
                        <div class="form-body form-horizontal">
                            <? if($reslist){?>
                       
                          <div class="col-sm-3 "  id="myloanlist">  
                          <select class="form-control" placeholder="Qick Search.."    id="res_code" name="res_code"  onChange="load_fulldetails()">
                            <option value="">Loan search</option>
                            <?    foreach($reslist as $row){
                                
                                $loanarr=$row->res_code;?>
                            <option value="<?=$row->res_code?>" ><?=$row->project_name?> <?=$row->lot_number?>- <?=$row->id_number?> <?=$row->last_name ?> </option>
                            <? }?>
                     
                            </select>
                            </div>
							<div class="col-sm-3 has-feedback" id="paymentdateid">
                            <input  type="text" class="form-control" id="paydate"    name="paydate"  value="<?=date("Y-m-d")?>"   data-error="" required onChange="load_fulldetails()" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                        
                         <? }?>
                       </div>
                        <div id="fulldata" style="min-height:400px;"></div>   
                        
                        
                       </div>
                      
                     
                       
                        
                          </div>
					</form></p> 
                </div>
                    <div role="tabpanel" class="tab-pane fade  <? if($tab=='list'){?>active in<? }?>" id="history" aria-labelledby="history-tab"> 
                    <?   $this->load->view("re/di_return/di_return_list"); ?>
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
                    
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_delete" name="complexConfirm_delete"  value="DELETE"></button>

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
                    window.location="<?=base_url()?>re/di_return/delete_pending_return/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			     $("#complexConfirm_delete").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>re/di_return/delete_confirm_return/"+document.deletekeyform.deletekey.value;
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
					
                    window.location="<?=base_url()?>re/di_return/confirm_di_return/"+document.deletekeyform.deletekey.value;
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