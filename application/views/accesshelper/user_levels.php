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
	  	$("#userlevel").chosen({
     		allow_single_deselect : true
    	});
	}, 300);


});

function call_delete(id)
{
	document.deletekeyform.deletekey.value=id;
	$('#complexConfirm').click();
}

</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">
 
                 
 
      <h3 class="title1">User Levels</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">User Levels</a></li> 
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
               
               <form data-toggle="validator" method="post" action="<?=base_url()?>accesshelper/accesshelper/userlevels" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Add User Levels</h4>
						</div>
                        <div class="form-body form-horizontal">
                          <div class="form-group">
                            <div class="col-sm-3">
                            	<table class="table">
                                  <thead>
                                      <tr>
                                      	  <th>ID</th>
                                          <th>User Levels</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?
                                          if($userlevels){
                                              $c=0;
                                              foreach($userlevels as $data){
                                              ?>
                                                  <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                                  	  <td><?=$data->usertype_id?></td>
                                                      <td><?=$data->usertype?></td>
                                                      <td><? if(!check_user_usage($data->usertype_id)){ ?> <a  href="javascript:call_delete('<?=$data->usertype_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a> <? }?></td>
                                                  </tr>
                                              <?	
                                              }
                                          }
                                      ?>
                                  </tbody>
                              </table>
                            </div>
                            <div class="col-sm-1 "> </div>
                            <div class="col-sm-2 "> 
                            	<div class="form-group has-feedback">
                                      <input type="text" class="form-control" id="user_level" name="user_level" autocomplete="off"  placeholder="User Level" data-error="" required>
                                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                      <span class="help-block with-errors" ></span>
                                </div>
                            </div>
                            <div class="col-sm-1 ">
                                <div class="form-group">
                                    <select style="margin-left:20px;" name="module" id="module" class="form-control" placeholder="Select Module" required>
                                        <option value="">Select Module</option>
                                        <option value="accounts">Accounts</option>
                                        <option value="re">Real Estate</option>
                                        <option value="hm">Home</option>
                                        <option value="hr">HR</option>
                                    </select>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="help-block with-errors" ></span>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-group has-feedback">
                                	<button type="submit"  style="float:right;" class="btn btn-primary disabled">Submit</button>
                                </div>
                            </div>
                          </div>
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
                    window.location="<?=base_url()?>accesshelper/accesshelper/delete_user_level/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   
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