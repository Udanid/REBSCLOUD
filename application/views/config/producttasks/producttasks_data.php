
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
function activatechosen(){
	setTimeout(function(){ 
	  	$("#ledger_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Ledger"
    	});
	  	$("#adv_ledgerid").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Ledger"
    	});

	 	$.ajaxSetup ({
    	// Disable caching of AJAX responses
    		cache: false
		});
	}, 800);
}

function check_activeflag(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_tasktype', id: id,fieldname:'task_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>config/producttasks/edit/"+id );
				}
            }
        });
}
function close_edit(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'cm_tasktype', id: id,fieldname:'task_id' },
            success: function(data) {
                if (data) {
					 $('#popupform').delay(1).fadeOut(800);
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					 document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin '; 
					 $('#flagchertbtn').click();
					
				}
            }
        });
}
var deleteid="";
function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_tasktype', id: id,fieldname:'task_id' },
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
            data: {table: 'cm_tasktype', id: id,fieldname:'task_id' },
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
function call_delete_subtask(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_subtask', id: id,fieldname:'subtask_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#complexConfirm_subtask').click();
				}
            }
        });
	
	
//alert(document.testform.deletekey.value);
	
}

function call_confirm_subtask(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_subtask', id: id,fieldname:'subtask_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#complexConfirm_confirm_subtask').click();
				}
            }
        });
	
	
//alert(document.testform.deletekey.value);
	
}
function load_sublist(itemcode)
{ 
var code=itemcode.split("-")[0];


if(code!=''){
	//alert(code)
		$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>config/producttasks/subtask_list/"+code );}
	
}
function loadsubtasklist(code)
{ 
//alert('ssss')

	$('#selectsublist').delay(1).fadeIn(600);
	$( "#selectsublist" ).load( "<?=base_url()?>config/producttasks/subtask_editlist/"+code );
}


function update_oreder_key(key,mainid)
{
	
	 // alert(mainid)
	  if(key!='' &  mainid!=''){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'config/producttasks/update_order_key_main';?>',
            data: {main_id: mainid,  key:key },
            success: function(data) {
                if (data) {
			//	 alert(data);
					//alert("<?=base_url()?>accesshelper/accesshelper/mainmenulist/")

						location.reload(); 
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				
            }
        });
	
	  }
	  else
	  {
		  document.getElementById("checkflagmessage").innerHTML='Please Fill The name and module'; 
					 $('#flagchertbtn').click();
	  }
}
</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">
 
                 
 
      <h3 class="title1">Product Tasks</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Product Task List</a></li> 
         <? if(check_access('add_producttask')){?> <li role="presentation"  class=""><a href="#profile" role="tab" id="profile-tab" onClick="activatechosen()" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Tasks</a></li> 
        <li role="presentation"  class=""><a href="#subtask" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Sub Task</a></li> 
          <? }?></ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
               <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
               <br>
              <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>
              
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Product Code</th> <th>Task Code</th> <th>Task Name</th> <th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->product_code?></th> <td><input type="number" value="<?=$row->task_code?>"  name="orderkey<?=$row->task_id?>" id="orderkey<?=$row->task_id?>" onChange="update_oreder_key(this.value,'<?=$row->task_id?>')"></td> <td><?=$row->task_name?></td> 
                        <td><?=$row->status ?></td>
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:load_sublist('<?=$row->task_id?>')"><i class="fa fa-list nav_icon icon_blue"></i></a>
                        <? if($row->status=='PENDING'){?>
                             <a  href="javascript:call_confirm('<?=$row->task_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete('<?=$row->task_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>  
                </div> 
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab"> 
            
                    <p>	
                    <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>config/producttasks/add" id="mytestform">
                      
                    <div class="form-title">
								
							</div>
						<div class="col-md-6 validation-grids " data-example-id="basic-forms"> 
							<? $ledgerlist=get_master_acclist()?>
							<div class="form-body">
								  <label>Product Code</label>
									<div class="form-group"> <select class="form-control" placeholder="Product Code"  id="product_code" name="product_code"   required >
                                    <? if($activcount>1){?>
                    <option value="">Product Code</option><? }?>
                    <? foreach ($activeprd as $rw){?>
                    <option value="<?=$rw->product_code?>"><?=$rw->product?></option>
                    <? }?>
              
					
					</select> 
									    <span class="help-block with-errors" ></span>
									</div>
                                   
									
								
									
									
								
								
							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms"> 
								
								<div class="form-body">
									 <label>Task Name</label>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" name="task_name" id="task_name" placeholder="Task Name"  required>
										
										<span class="help-block with-errors" ></span>
									</div>
                                     
                                    
										<div class="bottom">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled">Submit</button>
											</div>
											<div class="clearfix"> </div>
                                              <br><br><br><br><br><br>
										</div>
								
								</div>
							</div>
						</div>
                      
					</form></div></p> 
                </div>
                  <div role="tabpanel" class="tab-pane fade " id="subtask" aria-labelledby="profile-tab"> 
                    <p>	
                    <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>config/producttasks/add_subtask">
                   
						<div class="col-md-6 validation-grids " data-example-id="basic-forms"> 
							
							<div class="form-body">
								  <label>Task Name</label>
                                  <select class="form-control" placeholder="Task Code"  id="task_id" name="task_id" onChange="loadsubtasklist(this.value)" required  >
                                    
                    <option value=""></option>
                    <? foreach ($fulllist as $rw){ if($rw->status==CONFIRMKEY){?>
                    <option value="<?=$rw->task_id?>"><?=$rw->product_code?><?=$rw->task_code?> &nbsp;-&nbsp; <?=$rw->task_name?></option>
                    <? }}?>
              
					
					</select> 
									<div class="form-group"> 
									    <span class="help-block with-errors" ></span>
									</div>
									
								
									
									
								
								
							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms"> 
								
								<div class="form-body">
									 <label>Sub Task Name</label>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" name="subtask_name" id="subtask_name" placeholder="Sub Task Name"  required>
										
										<span class="help-block with-errors" ></span>
									</div>
                                    
										<div class="bottom">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled">Submit</button>
											</div>
											<div class="clearfix"> </div>
										</div>
								
								</div>
							</div>
						</div>
					</form>
                    <div id="selectsublist" style="display:nene"></div>
                    
                    </div></p> 
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