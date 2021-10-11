
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
  
	 $("#res_code_set").focus(function() {
	  $("#res_code_set").chosen({
     allow_single_deselect : true
    });
	});

	
});
function chosenActivate(){
	setTimeout(function(){ 
	  $("#prj_id").chosen({
    		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Project Name"
    	});
	}, 800);
}	
function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
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
function loadcurrent_block(id)
{
 if(id!=""){
	 document.getElementById("fulldata").innerHTML='';
							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#blocklist" ).load( "<?=base_url()?>re/deedtransfer/get_blocklist/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);
	
 }
}

function load_fulldetails(id)
{
	 if(id!="")
	 {$('#deedlist').delay(1).fadeOut(600);
		 var prj_id= document.getElementById("prj_id").value
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		   $( "#fulldata").load( "<?=base_url()?>re/deedtransfer/get_fulldata/"+id+"/"+prj_id );
	 }
}
function load_fulldetails_popup(prj_id,lot_id)
{
	
		// var prj_id= document.getElementById("prj_id").value
	 	
    	 
					
					  $( "#popupform").load( "<?=base_url()?>re/deedtransfer/get_fulldata_popup/"+lot_id+"/"+prj_id );
		   $('#popupform').delay(1).fadeIn(600);
	
}

function close_view(){
	$('#popupform').delay(1).fadeOut(800);
}
function viewCustomer(cus_code){

	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>cm/customer/view/"+cus_code );

}
</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Deed Transfers</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
           <li role="presentation" class="active"><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Deed Transfer List</a></li> 
           <li role="presentation" ><a href="#profile" role="tab" onClick="chosenActivate()" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Search Deed</a></li> 
          
         
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          <? $this->load->view("includes/flashmessage");?>
            
                <div role="tabpanel" class="tab-pane fade  " id="profile" aria-labelledby="profile-tab"> 
                    <p>	
                    
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Project Infomation </h4>
						</div>
                        <div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group">
                        
                    <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value=""></option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
             
					</select> </div>
                     <div class="col-sm-3 " id="blocklist">   </div>
                          </div><? }?></div>
                        
                        
                       </div></div>
                       <div id="fulldata" style="min-height:100px; "></div>    
                        
                        
                         
					 
                    
                    
                    
                    
                    
                    
                      
                   </p> 
               
                </div>
                <div role="tabpanel" class="tab-pane fade  active in" id="list" aria-labelledby="list-tab"> 
                    <p>	
                      <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                      <div class="form-title">
								<h4>Deed Transfer List  </h4>
							</div>  
                            <br>
                   <table class="table"> <thead> <tr> <th>ID</th> <th>Customer Name</th> <th>Project Details </th> <th>Selling Price</th> <th>Status</th><th></th></tr> </thead>
                      <? if($deedlist){$c=0;
                          foreach($deedlist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->id?></th> <td><a  href="javascript:viewCustomer('<?=$row->cus_code?>')" title="View Customer Info"><?=$row->first_name ?> <?=$row->last_name ?></a></td> <td><?=$row->project_name?> - <?=$row->lot_number?></td>
                        <td><?=$row->discounted_price?></td> 
                        <td><?=$row->form_status ?></td>
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:load_fulldetails_popup('<?=$row->prj_id?>','<?=$row->lot_id?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                        <? if($row->form_status=='PENDING' ){?>
                        <? if( check_access('confirm_deedtrn')) {?>
                             <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a><? }?>
                           
                    <? }?>
                        </div></td>
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
                    window.location="<?=base_url()?>re/customer/delete/"+document.deletekeyform.deletekey.value;
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