
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
  	setTimeout(function(){ 
	  $("#prj_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Project Name"
    	});
	}, 500);
	 $("#res_code_set").focus(function() {
	  $("#res_code_set").chosen({
     allow_single_deselect : true
    });
	});

	
});
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
	// alert("<?=base_url()?>re/stampfee/get_blocklist/"+id)
	 
							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#blocklist" ).load( "<?=base_url()?>re/stampfee/get_blocklist/"+id );
				
					
				
	 
	 
		
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
		   $( "#fulldata").load( "<?=base_url()?>re/stampfee/get_fulldata/"+id+"/"+prj_id );
	 }
}
function calculate_totalvalues()
{
	var mainlist=document.getElementById('idlist').value;
	var res2 = mainlist.split(",");
	var res2 = mainlist.split(",");
	var maintot=0;
	var disctrip="";
	
	for(i=0; i< res2.length-1; i++)
	{
		var selectobj=document.getElementById('isselect'+res2[i]);
		if(selectobj.checked){
		maintot=parseFloat(maintot)+parseFloat(document.getElementById('amount'+res2[i]).value);
		disctrip=document.getElementById('prjname'+res2[i]).value+'-'+document.getElementById('lotnumber'+res2[i]).value+'- Request Date '+document.getElementById('need_date'+res2[i]).value+','+disctrip
		}
	}
		
		document.getElementById('totalval').value= maintot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;	
		document.getElementById('total').value= maintot;	
			document.getElementById('paymentdes').value= disctrip;	
		if(maintot==0)
		{
			document.getElementById('totalval').value='';
		}
}
</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Stamp Fee Request</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
           
           <li role="presentation"  <? if($this->session->userdata('usertype')!='Legal Officer'){?>class="active"<? }?>  ><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Stamp Fee</a></li> 
         <li role="presentation" <? if($this->session->userdata('usertype')=='Legal Officer'){?>class="active"<? }?> ><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true"> Stamp Fee Request List</a></li>
          <li role="presentation"><a href="#listpaid" role="tab" id="listpaid-tab" data-toggle="tab" aria-controls="listpaid" aria-expanded="true"> Stamp Fee Paid List</a></li>
          
         
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          <? $this->load->view("includes/flashmessage");?>
            
                <div role="tabpanel" class="tab-pane fade <? if($this->session->userdata('usertype')!='Legal Officer'){?>active in<? }?>   " id="profile" aria-labelledby="profile-tab"> 
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
                <div role="tabpanel" class="tab-pane fade  <? if($this->session->userdata('usertype')=='Legal Officer'){?>active in<? }?> " id="list" aria-labelledby="list-tab"> 
                    <p>	
                      <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                      <div class="form-title">
								<h4>Stamp Fee Request List  </h4>
							</div>  
                            <br> <form data-toggle="validator" method="post" action="<?=base_url()?>re/stampfee/approved_request" enctype="multipart/form-data">
  
                   <table class="table"> <thead> <tr> <th>ID</th> <th>Customer Name</th> <th>Project Details </th> 
                   <th style="text-align:right;">Stamp Fee</th><th style="text-align:right;">Request Amount</th> <th style="text-align:center;">Request Date</th><th>Status</th><th></th><th>Select To Approve</th></tr> </thead>
                      <? $list=''; if($deedlist){$c=0;$list='';
                          foreach($deedlist as $row){ $list=$row->id.','.$list?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->id?></th> <td><?=$row->first_name ?> <?=$row->last_name ?></td> <td><?=$row->project_name?> - <?=$row->lot_number?></td>
                        <td align="right"><?=number_format($row->full_amount,2)?>
                        
                          <input type="hidden" value="<?=$row->paid_amount?>" name="amount<?=$row->id?>" id="amount<?=$row->id?>">
                          <input type="hidden" value="<?=$row->project_name?>" name="prjname<?=$row->id?>" id="prjname<?=$row->id?>">
                          <input type="hidden" value="<?=$row->lot_number?>" name="lotnumber<?=$row->id?>" id="lotnumber<?=$row->id?>">
                           <input type="hidden" value="<?=$row->need_date?>" name="need_date<?=$row->id?>" id="need_date<?=$row->id?>"></td> 
                           <td align="right"><?=number_format($row->paid_amount,2)?></td>
                          <td align="center"><?=$row->need_date?></td> 
                        <td><?=$row->status ?></td>
                        <td align="right"><div id="checherflag">
                       
                        <? if($row->status=='PENDING' ){?>
                      
                             <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
							 
							 
							 
							 <? }?>
                           
                   
                        </div></td>
                        <td> <? if($row->status=='PENDING' ){?><input class="form-control" type="checkbox" value="Yes" name="isselect<?=$row->id?>" id="isselect<?=$row->id?>"  onclick="calculate_totalvalues()"/><? }?> </td>
                         </tr> 
                        
                                <? }?><? if( check_access('confirm_stampfee_request')) {?> 
                                <tr><th colspan="3"><strong>Total</strong></th><th>
                                <input type="hidden" value="<?=$list?>" name="idlist" id="idlist">
                                <input type="hidden" value="0"  name="total"  id="total">
                                   <input type="hidden" value=""  name="paymentdes"  id="paymentdes">
                                 <div class="form-group ">
                                <input type="text" name="totalval" id="totalval" value="" class="form-control"  data-error="Total Value should grater than 0" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></th><th colspan="2" align="right">
                                
                                
                                <div class="col-sm-3"  style="float:right"><button type="submit" class="btn btn-primary disabled " >Approve and Send for Payment</button></div><th></tr><? } }?>
                          </tbody></table></form></div></div>
                   </p> 
                </div>
                 <div role="tabpanel" class="tab-pane fade  " id="listpaid" aria-labelledby="listpaid-tab"> 
                    <p>	
                      <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                      <div class="form-title">
								<h4>Stamp Fee Paid List  </h4>
							</div>  
                            <br> 
  
                   <table class="table"> <thead> <tr> <th>ID</th> <th>Customer Name</th> <th>Project Details </th> 
                   <th style="text-align:right;">Stamp Fee</th><th style="text-align:right;">Request Amount</th> <th style="text-align:center;">Request Date</th> <th>Request By</th><th>Status</th><th>Voucher/Cheque No</th><th style="text-align:right;"> Approve By</th></tr> </thead>
                      <? $list=''; if($paidlist){$c=0;$list='';
                          foreach($paidlist as $row){ $list=$row->id.','.$list?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->id?></th> <td><?=$row->first_name ?> <?=$row->last_name ?></td> <td><?=$row->project_name?> - <?=$row->lot_number?></td>
                        <td align="right"><?=number_format($row->full_amount,2)?>
                        <td align="right"><?=number_format($row->paid_amount,2)?>
                        
                        </td> 
                          <td align="center"><?=$row->need_date?></td> 
                            <td><?=get_user_fullname_id($row->request_by)?></td> 
                        <td><?=$row->paystatus ?></td>
                           <td><?=$row->voucher_id ?>/<?=$row->CHQNO ?></td>
                        <td align="right"><?=get_user_fullname_id($row->approved_by)?></td>
                        <td></td>
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
                    window.location="<?=base_url()?>re/stampfee/delete/"+document.deletekeyform.deletekey.value;
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