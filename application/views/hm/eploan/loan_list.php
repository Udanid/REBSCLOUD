
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
  $("#res_code").focus(function() {
	  $("#res_code").chosen({
     allow_single_deselect : true
    });
	});
	 $("#res_code_set").focus(function() {
	  $("#res_code_set").chosen({
     allow_single_deselect : true
    });
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
                else if ((id.match(pattern) == null) || (id.length != 10))
				{
       				//alert(' Please enter a valid NIC.\n');
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
            data: {table: 'hm_resevation', id: id,fieldname:'res_code' },
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
					
					$( "#popupform" ).load( "<?=base_url()?>hm/reservation/edit_complete/"+id );
				}
            }
        });
}
function get_repayment_shedule(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>hm/reservation/repayment_schedule/"+id );
			
}
function update_customerinfo(id)
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
					
					$( "#popupform" ).load( "<?=base_url()?>hm/customer/edit_loan/"+id );
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
            data: {table: 'hm_resevation', id: id,fieldname:'res_code' },
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
function call_delete_advance(id)
{
	 document.deletekeyform.deletekey.value=id;
	 rescode= document.getElementById("res_code").value
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_resevation', id: id,fieldname:'res_code' },
            success: function(data) {
                if (data) {
						// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
         			   //document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#complexConfirm_advdelete').click();
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
            data: {table: 'hm_resevation', id: id,fieldname:'res_code' },
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
function get_repayment_shedule(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>hm/reservation/repayment_schedule/"+id );
			
}
</script>
	
    <style type="text/css">
  
/****** Style Star Rating Widget *****/

.rating { 
  border: none;
  float: left;
}

.rating > input { display: none; } 
.rating > label:before { 
  margin: 5px;
  font-size: 1.25em;
  font-family: FontAwesome;
  display: inline-block;
  content: "\f005";
}

.rating > .half:before { 
  content: "\f089";
  position: absolute;
}

.rating > label { 
  color: #ddd; 
 float: right; 
 color: #FFED85; 
}

/***** CSS Magic to Highlight Stars on Hover *****/

</style>
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Easy Payment Loan</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
           <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Loan List</a></li> 
        <!--  <li role="presentation"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Loan Inquiry</a></li> 
 -->       
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          <? $this->load->view("includes/flashmessage");?>
               <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab" >
               <br>
             
              
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Loan Code</th><th>Land Details</th> <th>Customer Name </th><th>Agreement Date</th><th>Down Payment</th><th>Purchase Type</th><th>Create By </th><th>Confirm By </th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){
							  if($row->pay_type!='Outright'){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->unique_code?></th><td> <?=$row->project_name ?>&nbsp; <?=$row->lot_number ?>-<?=$row->plan_sqid ?></td> <td> <a  href="javascript:update_customerinfo('<?=$row->cus_code?>')" title="Update Customer Info"><?=$row->first_name ?> <?=$row->last_name ?></a></td> <td><?=$row->start_date?></td>
                        <td align="right"><?=number_format($row->down_payment,2)?></td> 
                        <td align="right"><?=$row->loan_type?></td>
                           <td ><?=get_user_fullname($row->apply_by)?></td>
                               <td><?=get_user_fullname($row->confirm_by)?></td>
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:check_activeflag('<?=$row->res_code?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                      <a  href="javascript:get_repayment_shedule('<?=$row->loan_code?>')" title="Repayment Schedule"><i class="fa fa-calendar nav_icon icon_green"></i></a>
                        <? if($row->loan_status=='PENDING'){?>
                             <a  href="javascript:call_confirm('<?=$row->res_code?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }}} ?>
                          </tbody></table> 
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>  
                </div> 
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab"> 
                    <p>	 
                  <? // $this->load->view("hm/eploan/loan_inquary"); ?>
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
                    window.location="<?=base_url()?>hm/customer/delete/"+document.deletekeyform.deletekey.value;
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
                    window.location="<?=base_url()?>hm/reservation/delete_advance/"+document.deletekeyform.deletekey.value;
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
					
                    window.location="<?=base_url()?>hm/reservation/confirm_loan/"+document.deletekeyform.deletekey.value;
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