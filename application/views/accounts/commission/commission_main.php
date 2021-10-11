
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
  $("#prj_id").focus(function() {
	  $("#prj_id").chosen({
     allow_single_deselect : true
    });
	});
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
            data: {table: 'ac_cashbooktypes', id: id,fieldname:'id' },
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
	 
							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#blocklist" ).load( "<?=base_url()?>re/deedtransfer/get_blocklist/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);
	
 }
}

function load_commisssiondata()
{
	var id=document.getElementById("month_search").value
	 if(id!="")
	 {$('#deedlist').delay(1).fadeOut(600);
		 var year= document.getElementById("year_search").value
	 	 $('#com_data').delay(1).fadeIn(600);
	//	 alert( "<?=base_url()?>accounts/commission/get_commisiondata/"+id+"/"+year)
    	  document.getElementById("com_data").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		   $( "#com_data").load( "<?=base_url()?>accounts/commission/get_commisiondata/"+id+"/"+year );
	 }
}

</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Commission Details</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
           <li role="presentation" class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Generate Commission</a></li> 
           <li role="presentation"><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Search Commission </a></li> 
         
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          <? $this->load->view("includes/flashmessage");?>
            
                <div role="tabpanel" class="tab-pane fade active in" id="profile" aria-labelledby="profile-tab"> 
                    <p>	
                    
                     
                         
                      <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/commission/generate_commission" enctype="multipart/form-data">
                     
                       <div class="form-title">
								<h4>Generate Commission </h4>
						</div>
                        <div class="form-body form-horizontal">
                           
                          <div class="form-group"><div class="col-sm-3 "> <input  type="text" class="form-control" id="year"    name="year"  value="<?=date("Y")?>"   data-error=""  required  placeholder="Year" ></div><div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."    id="month" name="month"   required="required" >
                    <option value="">Select Month</option>
                 
                    <option value="01" >January</option>
                     <option value="02" >February  </option>
                      <option value="03" >March  </option>
                      <option value="04" >April  </option>
                       <option value="05" >May  </option>
                        <option value="06" >June  </option>
                         <option value="07" >July  </option>
                          <option value="08" >August  </option>
                           <option value="09" >September  </option>
                            <option value="10" >October  </option>
                             <option value="11" >November  </option>
                              <option value="12" >December  </option>
                    
                    
             
					</select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <div class="col-sm-3 has-feedback" id="paymentdateid"><button type="submit" class="btn btn-primary disabled" >Generate Commission</button></div>
                                        </div></div>
                        	</form>
                    
                  
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                      <div class="form-title">
								<h4>Commission List  </h4>
							</div>  
                            <br>
                   <table class="table"> <thead> <tr> <th>ID</th> <th>Year</th><th>Month</th><th>Generate Date</th>
                   <th>Generate By</th><th>Confirm By</th><th>Status</th> </tr> </thead>
                      <? if($searchdata){$c=0;
                          foreach($searchdata as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->id?></th> <td><?=$row->year ?> </td>
                        <td align="right"><?=$row->month ?> </td>
                           <td align="right"><?=$row->run_date ?> </td>
                        <td  align="right"><?=get_user_fullname_id($row->run_by)?> </td>
                          <td  align="right"><?=get_user_fullname_id($row->confirm_by)?> </td>
                           <td  align="right"><?=$row->status?> </td>
                        <td align="right"><div id="checherflag">
                      <? if($row->status=='PENDING'){?>
                             <a  href="javascript:call_delete('<?=$row->id?>')" title="Confirm"><i class="fa fa-times nav_icon icon_red"></i></a>
							  <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a><? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table></div>
                    
                    
                    
                      
                   </p> 
               
                </div>
                <div role="tabpanel" class="tab-pane fade  " id="list" aria-labelledby="list-tab"> 
                    <p>	
                        <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                     
                     
                       <div class="form-title">
								<h4>Commission Rates </h4>
						</div>
                        <div class="form-body form-horizontal">
                           
                          <div class="form-group"><div class="col-sm-3 "> <input  type="text" class="form-control" id="year_search"    name="year_search"  value="<?=date("Y")?>"   data-error=""  required  placeholder="Year" ></div><div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."  i   id="month_search" name="month_search"    required="required" >
                    <option value="">Select Month</option>
                 
                    <option value="01" >January</option>
                     <option value="02" >February  </option>
                      <option value="03" >March  </option>
                      <option value="04" >April  </option>
                       <option value="05" >May  </option>
                        <option value="06" >June  </option>
                         <option value="07" >July  </option>
                          <option value="08" >August  </option>
                           <option value="09" >September  </option>
                            <option value="10" >October  </option>
                             <option value="11" >November  </option>
                              <option value="12" >December  </option>
                    
                    
             
					</select></div>
										<div class="col-sm-3 has-feedback" id="paymentdateid">
                                         <button type="button" onclick="load_commisssiondata()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button></div>
                                         
                                    
                    </div>
                    
                       
                       <div id="com_data">
                                        </div></div>
                         <div class="clearfix"> </div>
                   
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                   
                            <br>
                 </div></div>
                   </p> </div>
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
                    window.location="<?=base_url()?>accounts/commission/delete_commission/"+document.deletekeyform.deletekey.value;
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
					
                    window.location="<?=base_url()?>accounts/commission/confirm_commission/"+document.deletekeyform.deletekey.value;
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