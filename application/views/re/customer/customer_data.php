
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_customer");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
  
$("#title").chosen({
     allow_single_deselect : true
    });
	$("#bank1").chosen({
     allow_single_deselect : true
    });
	$("#branch1").chosen({
     allow_single_deselect : true
    });
	$("#bank2").chosen({
     allow_single_deselect : true
    });
	$("#branch2").chosen({
     allow_single_deselect : true
    });
 
 
	
});
function check_is_exsit(src)
{
	var number=src.value.length;
	val=$('input[name=idtype]:checked').val();
	//alert(val);
	document.getElementById("id_type").value=val;
	if(val=='NIC')
	{ 
	
	 var pattern = /\d\d\d\d\d\d\d\d\d\V|X|Z|v|x|z/;
                var id=src.value;
				 var code="";
                            
                if ((id.length == 0))
				{
                code='NIC Cannot be Blank';
				 //obj.focus();
				}
				else if (id.length == 10)
				{
       				//alert(' Please enter a valid NIC.\n');
					 if (id.match(pattern) == null)
						code='Invalid NIC';
					
					
				}
                else if (id.length == 12)
				{
       				//alert(' Please enter a valid NIC.\n');
					code="";
					
				}
				else
				{
					code='Invalid NIC';
				}
				
				

      			// document.getElementById("myerrorcode").innerHTML=code; 
		
                if (code!="") {
				//	 alert(data);
                   
					document.getElementById("id_number").focus();
					document.getElementById("id_number").setAttribute("placeholder", data);
					document.getElementById("id_number").setAttribute("error", data);
					src.value="";
					document.getElementById("id_type").value=val;
				
					document.getElementById("short_description").focus();
                } 
				
        
	}
}
function check_activeflag(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
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
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>re/customer/edit/"+id );
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
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
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
					$('#complexConfirm_confirm').click();
				}
            }
        });
	
	
//alert(document.testform.deletekey.value);
	
}
function loadbranchlist(itemcode,caller)
{ 
var code=itemcode.split("-")[0];
//alert("<?=base_url().$searchpath?>/"+code)
if(code!=''){
	//alert(code)
	//$('#popupform').delay(1).fadeIn(600);
	$( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}
	
}
function load_printscrean2()
{
	
			window.open( "<?=base_url()?>re/customer/excel_cusdata/");
	
}
</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Customer Data</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          
           <? if(check_access('add_customer')){?> <li role="presentation"  <? if($tab==''){?> class="active" <? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add New customer</a></li> 
          <? }?><li role="presentation" <? if($tab=='list'){?> class="active" <? }?>>
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Customer List</a></li> 
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          
               <div role="tabpanel" class="tab-pane fade  <? if($tab=='list'){?> active in <? }?>" id="home" aria-labelledby="home-tab" >
               <br>
              <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>
              <div class="form-title">
								<h4>Customer List
                                 <span style="float:right"> <a href="javascript:load_printscrean2()"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
               </div>     <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Customer Code</th> <th>Name</th> <th>Mobile </th> <th>E mail</th> <th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->cus_code?></th> <td><?=$row->first_name ?> <?=$row->last_name ?></td> <td><?=$row->mobile?></td>
                        <td><?=$row->email?></td> 
                        <td><?=$row->status ?></td>
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:check_activeflag('<?=$row->cus_code?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                        <? if($row->status=='PENDING'){?>
                             <a  href="javascript:call_confirm('<?=$row->cus_code?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete('<?=$row->cus_code?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>  
                </div> 
               <? if(check_access('add_customer')){?>
                <div role="tabpanel" class="tab-pane fade <? if($tab==''){?> active in <? }?>" id="profile" aria-labelledby="profile-tab"> 
                    <p>	  <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>
                  
                       <form data-toggle="validator" method="post" action="<?=base_url()?>re/customer/add" enctype="multipart/form-data">
                        <div class="row">
						     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Basic Information :</h4>
							</div>
							<div class="form-body">
								<div class="form-inline"> 
									<div class="form-group">
                                    <select name="title" id="title" class="form-control" placeholder="Branch Name" required>
                                    <option value="">Title</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Dr">Dr</option>
                                     <option value="Rev">Rev</option>
        
                                    </select><input type="hidden" name="id_type" id="id_type" value="">
										</div>&nbsp;<div class="form-group">
										<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name Or Initials"  value="<?=$this->session->flashdata('customername')?>"	 required>
									</div></div>
                                     <div class="clearfix"> </div><br>
									<div class="form-group has-feedback">
										<input type="text" class="form-control"name="last_name" id="last_name"   placeholder="Last Name" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control"name="full_name" id="full_name"   placeholder="Full Name" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    <div class="form-group">
										<div class="radio">
											<label>
											  <input type="radio" name="idtype" value="NIC" required>
											  NIC
											</label>
										</div>
										<div class="radio">
											<label>
											<input type="radio"  name="idtype" value="Passport" required>
											Passport
											</label>
										</div>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control"name="id_number" id="id_number"   placeholder="NIC Passport Number"   value="<?=$this->session->flashdata('cusnic')?>"	 data-error="Please Enter Valid NIC Number" onChange="check_is_exsit(this)" required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" id="myerrorcode"></span>
									</div>
									<div class="form-group"><h5>Upload NIC/Passport Copy</h5><br><input type="file" name="idcopy"  id="idcopy" placeholder="Last Name"class="form-control">
									 </div>
								
									
									
								
								
							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms"> 
								<div class="form-title">
									<h4>Contact Information :</h4>
								</div>
								<div class="form-body">
									
									
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" id="address1" name="address1"  placeholder="Address Line 1" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<input type="text" class="form-control" id="address2" name="address2"  placeholder="Address Line 2" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" name="address3" id="address3" placeholder="City" >
										
										<span class="help-block with-errors" ></span>
									</div>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" id="landphone" name="landphone" pattern="[0-9]{10}" placeholder="Contact Number" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" id="mobile" name="mobile"  placeholder="Mobile Number" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<input type="email" class="form-control" id="email" name="email" placeholder="Email" data-error="That email address is invalid"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<textarea class="form-control" id="permenant_address" name="permenant_address" placeholder="Permanent Address" ></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
											
								
								</div>
							</div>
						</div>
                        </div>
                        <div class="clearfix"> </div>
                        <br>
                         <div class="widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Bank Account Details</h4>
							</div>
							<div class="form-body">
								<div class="form-inline"> 
									<div class="form-group">
                                    <select name="bank1" id="bank1" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'1')" >
                                    <option value="">Bank</option>
                                     <? foreach ($banklist as $raw){?>
                    <option value="<?=$raw->BANKCODE?>" ><?=$raw->BANKNAME?></option>
                    <? }?>
        
                                    </select>
										</div>&nbsp;<div class="form-group" id="branch-1">
										 <select name="branch1" id="branch1" class="form-control" placeholder="Bank" >
                                    <option value="">Branch</option>
                                    
        
                                    </select>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control"name="acc1" id="acc1"   placeholder="Account Number" data-error="" >
										
									</div>
                                    </div>
                                     <br>
								
                                    	<div class="form-inline"> 
									<div class="form-group">
                                    <select name="bank2" id="bank2" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'2')">
                                    <option value="">Bank</option>
                                     <? foreach ($banklist as $raw){?>
                    <option value="<?=$raw->BANKCODE?>" ><?=$raw->BANKNAME?></option>
                    <? }?>
        
                                    </select>
										</div>&nbsp;<div class="form-group"  id="branch-2">
										 <select name="branch2" id="branch2" class="form-control" placeholder="Bank" >
                                    <option value="">Branch</option>
                                    
        
                                    </select>
									</div>
                                    <div class="form-group has-feedback" >
										<input type="text" class="form-control"name="acc2" id="acc2"   placeholder="Account Number" data-error=""  >
										
									</div>
                                    </div>
                                   <br>
								
									
									<div class="bottom validation-grids">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled">Submit</button>
											</div>
											<div class="clearfix"> </div>
										</div>
								
								
							</div>
						</div>
                        
                        
                        
                        
					</form></p> 
                </div>
                <? }?>
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
            
              $("#complexConfirm_confirm").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>re/customer/confirm/"+document.deletekeyform.deletekey.value;
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