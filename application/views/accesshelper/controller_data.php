
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	setTimeout(function(){ 
	  $("#main_id_sub").chosen({
     		allow_single_deselect : true,
			search_contains: true,
			width:'100%',
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select an Option"
    	});
		$("#main_id_cont").chosen({
     		allow_single_deselect : true,
			search_contains: true,
			width:'100%',
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Option"
    	});
	}, 500);
  $("#main_id_sub").focus(function() {
	  $("#main_id_sub").chosen({
     allow_single_deselect : true
    });
	});
	  $("#main_id_cont").focus(function() {
	  $("#main_id_cont").chosen({
     allow_single_deselect : true
    });
	});
	
	 $("#adv_ledgerid").focus(function() {
	  $("#adv_ledgerid").chosen({
     allow_single_deselect : true
    });
	});

	 $.ajaxSetup ({
    // Disable caching of AJAX responses
    cache: false
});

});

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
function call_delete_controller(id)
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
function call_delete_submenu(id)
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
					$('#complexConfirm_subtask').click();
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

function add_mainmenu(id)
{
	 menu_name=document.getElementById("menu_name").value;
	  module_code=document.getElementById("module_code").value;
	   menu_url=document.getElementById("menu_url").value;
	    color=document.getElementById("color").value;
		 icon=document.getElementById("icon").value;
	  
	  if(menu_name!='' &  module_code!=''){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/add_mainmenu';?>',
            data: {menu_name: menu_name,  module_code:module_code, menu_url:menu_url, color:color, icon:icon},
            success: function(data) {
                if (data) {
					//alert(color);
					document.getElementById("menu_name").value="";
					document.getElementById("module_code").value="";
					document.getElementById("menu_url").value="";
					//alert("<?=base_url()?>accesshelper/accesshelper/mainmenulist/")

					 	$( "#mainmenulist" ).load( "<?=base_url()?>accesshelper/accesshelper/mainmenulist/");
             
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
	
//alert(document.testform.deletekey.value);
	
}
function add_submenu(id)
{
	 sub_name=document.getElementById("sub_name").value;
	  main_id=document.getElementById("main_id_sub").value;
	  sub_url=document.getElementById("sub_url").value;
	  //alert(sub_url)
	  if(sub_name!='' &  main_id!=''){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/add_submenu';?>',
            data: {sub_name: sub_name,  main_id:main_id, sub_url:sub_url },
            success: function(data) {
                if (data) {
					// alert(data);
					document.getElementById("menu_name").value="";
					document.getElementById("sub_name").value="";
					document.getElementById("sub_url").value="";
					
					//alert("<?=base_url()?>accesshelper/accesshelper/mainmenulist/")

					 	$( "#selectsublist" ).load( "<?=base_url()?>accesshelper/accesshelper/sublist/"+main_id);
             
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
		$( "#selectsublist" ).load( "<?=base_url()?>accesshelper/accesshelper/sublist/"+code);
}
function loadsubtasklist_select(code)
{ 
//alert('ssss')
	$('#selectlist').delay(1).fadeIn(600);
		$( "#selectlist" ).load( "<?=base_url()?>accesshelper/accesshelper/loadsubtasklist_select/"+code);
		$('#contollerlist').delay(1).fadeIn(600);
		$( "#contollerlist" ).load( "<?=base_url()?>accesshelper/accesshelper/load_controller/"+code);
		
}
function add_controller(id)
{
	 cont_name=document.getElementById("controller_name").value;
	  main_id=document.getElementById("main_id_cont").value;
	   sub_id=document.getElementById("sub_id_cont").value;
	  
	  if(cont_name!='' &  main_id!=''){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/add_controller';?>',
            data: {cont_name: cont_name,  main_id:main_id, sub_id: sub_id },
            success: function(data) {
                if (data) {
					// alert(data);
					document.getElementById("menu_name").value="";
					document.getElementById("sub_name").value="";
					//alert("<?=base_url()?>accesshelper/accesshelper/mainmenulist/")

					 	$( "#contollerlist" ).load( "<?=base_url()?>accesshelper/accesshelper/load_controller/"+main_id);
             
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
	
//alert(document.testform.deletekey.value);
	
}
function update_oreder_key(key,mainid)
{
	
	 // alert(mainid)
	  if(key!='' &  mainid!=''){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/update_order_key_main';?>',
            data: {main_id: mainid,  key:key },
            success: function(data) {
                if (data) {
				//	 alert(data);
					//alert("<?=base_url()?>accesshelper/accesshelper/mainmenulist/")

					 	$( "#contollerlist" ).load( "<?=base_url()?>accesshelper/accesshelper/load_controller/"+main_id);
             
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
 
                 
 
      <h3 class="title1">Menu Controller</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Main Menu List</a></li> 
          <li role="presentation"  class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Sub Menu</a></li> 
        <li role="presentation"  class=""><a href="#subtask" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Access Controllers</a></li> 
         </ul>	
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
               <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>config/producttasks/add" id="mytestform">
                    <div class="form-title">
						Ad Main Menu		
							</div>
						<div class="col-md-6 validation-grids " data-example-id="basic-forms"> 
								<div class="form-body">
								  <label>Module Code</label>
									<div class="form-group"> <select class="form-control" placeholder="module_code Code"  id="module_code" name="module_code"   required >
                                    <? if($activcount>1){?>
                    <option value="">Module Code</option><? }?>
                    <? foreach ($activeprd as $rw){?>
                    <option value="<?=$rw->module_code?>"><?=$rw->name?></option>
                    <? }?>
                      </select> 
									    <span class="help-block with-errors" ></span>
									</div>
                              	</div>
                                <div class="form-body">
									 <label>Menu Link </label>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" name="menu_url" id="menu_url" placeholder="Main Menu"  required>				<span class="help-block with-errors" ></span>
									</div></div>
                                     <div class="form-body">
									 <label>Menu Color </label>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" name="color" id="color" placeholder="Main Menu"  required>				<span class="help-block with-errors" ></span>
									</div></div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms"> 
									<div class="form-body">
									 <label>Menu Name</label>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" name="menu_name" id="menu_name" placeholder="Main Menu"  required>				<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-body">
									 <label>Menu Icon </label>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" name="icon" id="icon" placeholder="Icon"  required>				<span class="help-block with-errors" ></span>
									</div></div><br><br><br><br>
                                   	<div class="bottom">
											<div class="form-group">
												<button  type="button" onClick="add_mainmenu()"class="btn btn-primary ">Add Main Menu</button>
											</div>
											<div class="clearfix"> </div>
                                            <br>
										</div>
								
								</div>
							</div>
						</div>
                      
					</form></div>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" id="mainmenulist" > 
                  
                        <table class="table"> <thead> <tr> <th>Module</th> <th>Main Menu</th> <th>URL</th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->module_name?></th> <td><?=$row->menu_name ?></td>
                        <td><?=$row->url ?></td>
                        <td><input type="number" value="<?=$row->order_key?>"  name="orderkey<?=$row->main_id?>" id="orderkey<?=$row->main_id?>" onChange="update_oreder_key(this.value,'<?=$row->main_id?>')"></td>
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:call_delete('<?=$row->main_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                  
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                         
                    </div>  
                </div> 
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab"> 
            
                    <p> <p>	
                    <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>config/producttasks/add_subtask">
                   
						<div class="col-md-6 validation-grids " data-example-id="basic-forms"> 
							
							<div class="form-body">
								  <label>Main Menu</label>
                                  <select class="form-control" placeholder="Task Code"  id="main_id_sub" name="main_id_sub" onChange="loadsubtasklist(this.value)" required  >
                                    
                    <option value=""></option>
                    <? foreach ($datalist as $rw){ if($rw->status=='Active'){?>
                    <option value="<?=$rw->main_id?>"><?=$rw->module_name?> -> <?=$rw->menu_name?> </option>
                    <? }}?>
              
					
					</select> 
									
								</div>
                             <div class="form-body">
									 <label>Menu Link </label>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" name="sub_url" id="sub_url" placeholder="Main Menu"  required>				<span class="help-block with-errors" ></span>
									</div></div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms"> 
								
								<div class="form-body">
									 <label>Sub Menu Name</label>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" name="sub_name" id="sub_name" placeholder="Sub Task Name"  required>
										
										<span class="help-block with-errors" ></span>
									</div>
                                    
										<div class="bottom">
											<br><br><br>
											<div class="form-group">
												<button  type="button" onClick="add_submenu()"class="btn btn-primary ">Add Sub Menu</button>
											</div>
											<div class="clearfix"> </div>
										</div>
								
								</div>
							</div>
						</div>
					</form><div class="clearfix"> </div>
                    <div class="col-md-6 validation-grids validation-grids" id="selectsublist" style="display:none"></div>
                    
                    </div></p>                   <br><br><br><br><br><br><br><br><br><br> </p> 
                </div>
                  <div role="tabpanel" class="tab-pane fade " id="subtask" aria-labelledby="profile-tab"> 
                  
                  <form data-toggle="validator" method="post" action="<?=base_url()?>pawning/config/add_item_price" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Add Controllers</h4>
						</div>
                        <div class="form-body form-horizontal">
                           
                          <div class="form-group">
                         
							<div class="col-sm-3 "> 	
                            <select class="form-control" placeholder="Task Code"  id="main_id_cont" name="main_id_cont" onChange="loadsubtasklist_select(this.value)" required  >
                                    
                    <option value="">Select Main Menu</option>
                    <? foreach ($datalist as $rw){ if($rw->status=='Active'){?>
                    <option value="<?=$rw->main_id?>"><?=$rw->module_name?> -> <?=$rw->menu_name?> </option>
                    <? }}?>
              
					
					</select> </div><div class="col-sm-3 " id="selectlist"> 
                           <input  type="text" class="form-control" id="sub_id_cont"    name="sub_id_cont"  value=""   data-error="" required  placeholder="Default value"> </div>
                         <div class="col-sm-3 ">    <input  type="text" class="form-control" id="controller_name"    name="controller_name"  value=""   data-error="" required  placeholder="Default value"> </div>
                         	<div class="col-sm-3 has-feedback" id="paymentdateid"><button type="button" onClick="add_controller()" class="btn btn-primary disabled" >Add Range</button></div>
                          </div>
                        <div id="contollerlist"></div><br><br><br><br><br><br><br>
                       </div>
                      
                       
                     </div></div>
                       
                        
                        
                        
					</form>
                   
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
                    window.location="<?=base_url()?>accesshelper/accesshelper/delete_main_menu/"+document.deletekeyform.deletekey.value;
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
					
                    window.location="<?=base_url()?>accesshelper/accesshelper/delete_controller/"+document.deletekeyform.deletekey.value;
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
                    window.location="<?=base_url()?>accesshelper/accesshelper/delete_submenu/"+document.deletekeyform.deletekey.value;
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