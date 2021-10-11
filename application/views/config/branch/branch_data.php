
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?> 
<script type="text/javascript">
function check_is_exsit(src)
{
	var number=src.value.length;
	if(number==3)
	{
		 var vendor_no = src.value;
//alert(number);
        
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'config/branch/check_shortcode';?>',
            data: {vendor_no: vendor_no},
            success: function(data) {
                if (data) {
				//	 alert(data);
                    document.getElementById("myerrorcode").innerHTML=data; 
					document.getElementById("shortcode").focus();
					document.getElementById("shortcode").setAttribute("placeholder", data);
					document.getElementById("shortcode").setAttribute("error", data);
					src.value="";
					
					//src.data-error=data; 
					document.getElementById("short_description").focus();
                } 
            }
        });
   
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
            data: {table: 'cm_branchms', id: id,fieldname:'branch_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#mylistkkk').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>config/branch/edit/"+id );
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
            data: {table: 'cm_branchms', id: id,fieldname:'branch_code' },
            success: function(data) {
                if (data) {
					 $('#popupform').delay(1).fadeOut(800);
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					 document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin '; 
					 $('#mylistkkk').click();
					
				}
            }
        });
}
</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">
      <h3 class="title1">Branch Details</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Branch List</a></li> 
          <li role="presentation"  class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Branch</a></li> 
          </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
               <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
               <span class="success"><?=$this->session->flashdata('msg')?></span><span class="error"><?=$this->session->flashdata('error')?></span><br>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Branch Code</th> <th>Short Cord</th> <th>Branch Name</th> <th>Contact Number</th> <th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->branch_code ?></th> <td><?=$row->shortcode ?></td> <td><?=$row->branch_name?></td> 
                        <td><?=$row->Contact_number 	 ?></td>
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:check_activeflag('<?=$row->branch_code?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
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
                    <form data-toggle="validator" method="post" action="<?=base_url()?>config/branch/add">
						<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Basic Information :</h4>
							</div>
							<div class="form-body">
								
									<div class="form-group">
										<input type="text" class="form-control" name="branch_name" id="branch_name" placeholder="Branch Name" required>
									</div>
									<div class="form-group has-feedback">
										<input type="text" class="form-control"name="shortcode" id="shortcode" maxlength="3"   pattern="[A-Za-z]{3}" placeholder="Short Code" data-error="" onChange="check_is_exsit(this)" required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" id="myerrorcode">Branch Short code contains maximum 3 letters</span>
									</div>
									<div class="form-group"><textarea name="short_description" maxlength="150"   id="short_description"  class="form-control" placeholder="Short Description About the branch" required></textarea>
									   <span class="help-block">Maximum of 150 characters</span>
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
										<input type="text" class="form-control" name="location_map" id="location_map" placeholder="Location Map" >
										
										<span class="help-block with-errors" >Google Map share link Shoud be goes here</span>
									</div>
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
										<input type="text" class="form-control" id="Contact_number" name="Contact_number" pattern="[0-9]{10}" placeholder="Contact Number" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" id="fax" name="fax" pattern="[0-9]{10}" placeholder="Fax Number" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<input type="email" class="form-control" id="email" name="email" placeholder="Email" data-error="That email address is invalid"  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
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
					</form></div></p> 
                </div>
            </div>
         </div>
      </div>
        
        
        
         <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="mylistkkk"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
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