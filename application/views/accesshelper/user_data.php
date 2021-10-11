
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
	  $("#usertype").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select an Option"
    	});
		$("#module_code_main").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Module"
    	});
	}, 500);
	
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
	  
	  if(menu_name!='' &  module_code!=''){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/add_mainmenu';?>',
            data: {menu_name: menu_name,  module_code:module_code },
            success: function(data) {
                if (data) {
					// alert(data);
					document.getElementById("menu_name").value="";
					document.getElementById("module_code").value="";
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
	  
	  if(menu_name!='' &  module_code!=''){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/add_submenu';?>',
            data: {sub_name: sub_name,  main_id:main_id },
            success: function(data) {
                if (data) {
					// alert(data);
					document.getElementById("menu_name").value="";
					document.getElementById("sub_name").value="";
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

function select_user_fulldata(itemcode)
{ 
var usertype=document.getElementById("usertype").value
var module=document.getElementById("module_code_main").value
usertype=usertype.replace(" ", "-");
usertype=usertype.replace(" ", "-");

	if(usertype!='' & module!=''){
	//alert("<?=base_url()?>accesshelper/accesshelper/get_user_prvdata/"+usertype+"/"+module)
		$('#fulldatalist').delay(1).fadeIn(600);
		 document.getElementById("fulldatalist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		
	$( "#fulldatalist" ).load( "<?=base_url()?>accesshelper/accesshelper/get_user_prvdata/"+usertype+"/"+module );
	}
	else
	  {
		  document.getElementById("checkflagmessage").innerHTML='Please Fill The type and module'; 
					 $('#flagchertbtn').click();
	  }
}

</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">
 
                 
 
      <h3 class="title1">User Controller</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">User Previlages</a></li> 
       <!--   <li role="presentation"  class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New User</a></li> 
        <li role="presentation"  class=""><a href="#subtask" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Access Controllers</a></li> 
    -->     </ul>	
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
               
               <form data-toggle="validator" method="post" action="<?=base_url()?>pawning/config/add_item_price" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Update Privilages</h4>
						</div>
                        <div class="form-body form-horizontal">
                           
                          <div class="form-group">
                         
							<div class="col-sm-3 "> 	
                            <select class="form-control" placeholder="Task Code"  id="usertype" name="usertype"  required  >
                                    
                    <option value=""></option>
                    <? foreach ($usertypes as $rw){ ?>
                    <option value="<?=$rw->usertype?>"><?=$rw->usertype?>  </option>
                    <? }?>
              
					
					</select> </div><div class="col-sm-3 " id="selectlist"> 
                           <select class="form-control" placeholder="module_code Code"  id="module_code_main" name="module_code_main"   required onChange="select_user_fulldata(this.value)" >
                                    <? if($activcount>1){?>
                    <option value=""></option><? }?>
                    <? foreach ($activeprd as $rw){?>
                    <option value="<?=$rw->module_code?>"><?=$rw->name?></option>
                    <? }?>
                      </select> </div>
                        
                          </div>
                        <div id="fulldatalist"></div><br><br><br><br><br><br><br>
                       </div>
                      
                       
                     </div></div>
                       
                        
                        
                        
					</form>
                   </div>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" id="mainmenulist" > 
                  
                      
                         
                    </div>  
                </div> 
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab"> 
            
                    <p> </p> 
                </div>
                  <div role="tabpanel" class="tab-pane fade " id="subtask" aria-labelledby="profile-tab"> 
                  
                 
                   
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