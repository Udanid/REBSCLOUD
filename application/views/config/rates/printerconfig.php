
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">


function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_rates', id: id,fieldname:'rate_id' },
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
					$( "#popupform" ).load( "<?=base_url()?>config/rates/edit/"+id );
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
            data: {table: 'cm_rates', id: id,fieldname:'rate_id' },
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
function update_this_data(obj,id)
{
	value=obj.value;
	

	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'config/rates/update_confimation_level';?>',
            data: {id:id,value:value},
            success: function(data) {
                if (data) {
				
					 $('#popupform').delay(1).fadeOut(800);

					//document.getElementById('mylistkkk').style.display='block';
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



      <h3 class="title1">Receipt And Voucher Configuration</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Update Details</a></li>
        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
               <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
               <br>
             <? $this->load->view("includes/flashmessage");?>

                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                       <div class="row">
						     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
                            
                            <!--start Business block-->
                            <div id="business">
                                <div class="form-title">
                                    <h5>Receipt</h5>
                                </div>
                                      <form data-toggle="validator" id="customerform" method="post" action="<?=base_url()?>config/rates/update_printconfig" enctype="multipart/form-data">
                                <div class="form-body" style="float:left">
                                
                                    <div class="form-group has-feedback"><label class="form_control" > Include Header </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="r_include_header" <? if($recipetdata->include_header==1) {?>checked="checked"<? }?> value="1" >
                                              Yes
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="r_include_header" value="0" <? if($recipetdata->include_header==0) {?>checked="checked"<? }?>  >
                                              No
                                            </label>
                                        </div>
                                     </div>
                                     <div class="form-group has-feedback"><label > Include Logo </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;
                                      
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="r_include_logo" <? if($recipetdata->include_logo==1) {?>checked="checked"<? }?> value="1">
                                               Yes
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="r_include_logo" value="0" <? if($recipetdata->include_logo==0) {?>checked="checked"<? }?>  >
                                              No
                                            </label>
                                        </div>
                                     </div>
                                      <div class="form-group has-feedback"> <label > Include  Nonrefund Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      </label>
                                        <div class="radio">
                                           
                                            <label >
                                              <input type="radio" name="r_nonrefund_include" <? if($recipetdata->nonrefund_include==1) {?>checked="checked"<? }?> value="1" onclick="calculate_charge()" >
                                             Yes
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="r_nonrefund_include" value="0" <? if($recipetdata->include_logo==0) {?>checked="checked"<? }?> onclick="calculate_charge()" >
                                               No
                                            </label>
                                        </div>
                                     </div>
                                     <div class="form-group has-feedback"> <label > Include Loan Balance &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;
                                      
                                      </label>
                                        <div class="radio">
                                           
                                            <label >
                                              <input type="radio" name="r_loan_balanceinclude" <? if($recipetdata->include_logo==1) {?>checked="checked"<? }?> value="1" onclick="calculate_charge()" >
                                             Yes
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="r_loan_balanceinclude" value="0" <? if($recipetdata->include_logo==0) {?>checked="checked"<? }?> onclick="calculate_charge()" >
                                               No
                                            </label>
                                        </div>
                                     </div>
                             
                                </div></div>
						</div>
                        	     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
                            
                            <!--start Business bloc</div>k-->
                            <div id="business">
                                <div class="form-title">
                                    <h5>Voucher  :</h5>
                                </div>
                                <div class="form-body" style="float:left">
                                
                                    <div class="form-group has-feedback"><label class="form_control" > Include Header </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="v_include_header" <? if($voucherdata->include_header==1) {?>checked="checked"<? }?> value="1" >
                                              Yes
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="v_include_header" value="0" <? if($voucherdata->include_header==0) {?>checked="checked"<? }?>  >
                                              No
                                            </label>
                                        </div>
                                     </div>
                                     <div class="form-group has-feedback"><label > Include Logo </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;
                                      
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="v_include_logo" <? if($voucherdata->include_logo==1) {?>checked="checked"<? }?> value="1">
                                               Yes
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="v_include_logo" value="0" <? if($voucherdata->include_logo==0) {?>checked="checked"<? }?>  >
                                              No
                                            </label>
                                        </div>
                                     </div>
                                      <div class="form-group has-feedback"> <label > Include  Acknowledgment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      </label>
                                        <div class="radio">
                                           
                                            <label >
                                              <input type="radio" name="v_include_acknowledge" <? if($voucherdata->include_acknowledge==1) {?>checked="checked"<? }?> value="1" onclick="calculate_charge()" >
                                             Yes
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="v_include_acknowledge" value="0" <? if($voucherdata->include_acknowledge==0) {?>checked="checked"<? }?> onclick="calculate_charge()" >
                                               No
                                            </label>
                                        </div><br><br><br>
                                        
                                        
                                     
                                    
                                     </div></div>
                                     
                                     
						</div>
                        




</div>

                    </div>  </div> <div class="form-group"  >
                                                    <button  type="Update" style="width:50%;" class="btn btn-primary ">Update</button>
                                                </div></form>
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
