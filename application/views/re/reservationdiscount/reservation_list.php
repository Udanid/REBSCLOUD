
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
	$.validator.setDefaults({ ignore: ":hidden:not(select)" })
	 $("#myform").validate({
		submitHandler: function(form) { // <- pass 'form' argument in
			$("#submit").attr("disabled", true);
			form.submit(); // <- use 'form' argument here.
		},
    });
	
  $("#res_code").focus(function() {
	  $("#res_code").chosen({
     allow_single_deselect : true
    });
	});
	
	 $("#res_code_charge").focus(function() {
	  $("#res_code_charge").chosen({
     allow_single_deselect : true
    });
	});
	
	$("#res_code_new").chosen({
		  allow_single_deselect : true,
		  search_contains: true,
		  no_results_text: "Oops, nothing found!",
		  placeholder_text_single: "Select a Reservation"
	  });
	
});
function chosenActivate(){
	setTimeout(function(){ 
	  $("#res_code_set").chosen({
    		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Reservation"
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
function load_details(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata_settlment').delay(1).fadeIn(600);
	 			    document.getElementById("plandata_settlment").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#plandata_settlment" ).load( "<?=base_url()?>re/reservationdiscount/get_details/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#lotinfomation').delay(1).fadeOut(600);
	 $('#plandata_settlment').delay(1).fadeOut(600);
 }
}
function close_view(){
	$('#popupform').delay(1).fadeOut(800);
}
function viewCustomer(cus_code){

	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>cm/customer/view/"+cus_code );

}

function filterReservations(val){
	window.location="<?=base_url()?>re/reservationdiscount/showall/<?=$page?>/"+val;
}
</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Reservation Discount</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
         <!--  <li role="presentation" class="active">
 -->      <!--   <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Reservation List</a></li> 
           <li role="presentation"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Advance Payment</a></li> 
           
      -->     
        <li role="presentation"  class="active"><a href="#home" role="tab" id="home-tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Discount List</a></li> <li role="presentation"><a href="#settlment" role="tab" id="settlment-tab" data-toggle="tab" aria-controls="settlment" onClick="chosenActivate()" aria-expanded="true">Reservation Discount</a></li> 
            
 
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          <? $this->load->view("includes/flashmessage");?>
               <div role="tabpanel" class="tab-pane fade active in " id="home" aria-labelledby="home-tab" >
                 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                 <div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group">
                          <div class="col-sm-3 ">  <label>Select Reservation</label><select class="form-control" placeholder="Qick Search.."   onchange="filterReservations(this.value);" id="res_code_new" name="res_code_new" >
                    <option value=""></option>
                    <?    foreach($searchdata as $row){?>
                    <option value="<?=$row->res_code?>"><?=$row->res_code?> - <?=$row->project_name?>  <?=$row->lot_number ?> - <?=$row->first_name ?> <?=$row->last_name ?>  <?=$row->id_number ?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                 <div class="tableFixHead"> 
                <table class="table"> <thead> <tr class="active"> <th>Project Name</th><th>Lot Number</th> <th>Customer Name </th><th style="text-align:right;">Price List Value</th><th style="text-align:right;">Old Discounted Price</th><th style="text-align:right;">New Discount</th><th style="text-align:right;">New Discounted Price</th><th style="text-align:right;">Discount Type</th><th style="text-align:right;">Repay Amount</th><th style="text-align:right;">Created By</th><th style="text-align:right;">Confirmed By</th><th style="text-align:right;">Confirmed On</th></tr> </thead> <tbody>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){$note='';$class='';
							  if($row->sale_val>=$row->new_discountedprice)
							  {
								  $class='danger';
								  $note=' - New Price is lower than the approved Price';
							  }
							  					   
														   
								if( $row->pay_id)
							  $type='Payment';
							  else $type='Special';?>
                      
                         <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->project_name ?></td><td> <?=$row->lot_number ?>-<?=$row->plan_sqid ?></td> <td><a  href="javascript:viewCustomer('<?=$row->cus_code?>')" title="View Customer Info"><?=$row->first_name ?> <?=$row->last_name ?></a></td> 
                          <td align="right"><?=number_format($row->sale_val,2)?></td> 
                             <td align="right"><?=number_format($row->old_discountedprice,2)?></td> 
                              <td align="right"><?=number_format($row->new_discount,2)?></td> 
                        <td align="right"><?=number_format($row->new_discountedprice,2)?></td> 
                          <td align="right"><?=$type?> <span style="color:#F00"><?=$note?></span></td> 
                        <td align="right"><?=number_format($row->repay_amount,2)?></td>
                        <td align="right"><?=get_user_fullname_id($row->user_id); //this function is in reaccount helper?></td>
                        <td align="right"><?=get_user_fullname_id($row->confirmed_by);?></td>
                        <td align="right"><?=$row->confirmed_date?></td>
                        <td align="right"><div id="checherflag">
                       
                        <? if($row->status=='PENDING'){?>
                             <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table> <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div></div> 
                          
                          </div> 
               <br>
             
                </div> 
              
                <div role="tabpanel" class="tab-pane fade  " id="settlment" aria-labelledby="settlment-tab"> 
                    <p>	  
                  <form id="myform" method="post" action="<?=base_url()?>re/reservationdiscount/add" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group">
                          <div class="col-sm-3 ">  <label>Select Reservation</label><select class="form-control" placeholder="Qick Search.."   onchange="load_details(this.value)" id="res_code_set" name="res_code_set" >
                    <option value=""></option>
                    <?    foreach($searchdata as $row){?>
                    <option value="<?=$row->res_code?>"><?=$row->res_code?> - <?=$row->project_name?>  <?=$row->lot_number ?> - <?=$row->first_name ?> <?=$row->last_name ?>  <?=$row->id_number ?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="plandata_settlment" style="display:none">
                           
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>
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
                    window.location="<?=base_url()?>re/reservationdiscount/delete/"+document.deletekeyform.deletekey.value;
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
					
                    window.location="<?=base_url()?>re/reservationdiscount/confirm/"+document.deletekeyform.deletekey.value;
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