
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
	 $("#cus_code").focus(function() {


	$("#cus_code").chosen({
     allow_single_deselect : true
    });
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
					$( "#popupform" ).load( "<?=base_url()?>hm/customer/edit/"+id );
				}
            }
        });
}


function loadcurrent_block(id)
{
 if(id!=""){
	 
							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#blocklist" ).load( "<?=base_url()?>hm/reservation/get_blocklist/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);
	
 }
}

function load_fulldetails(id)
{
	 if(id!="")
	 {
		 var prj_id= document.getElementById("prj_id").value
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		   $( "#fulldata").load( "<?=base_url()?>hm/reservation/get_fulldata/"+id+"/"+prj_id );
	 }
}
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

</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">New Reservation</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          
           <li role="presentation" <? if($tab==''){?> class="active" <? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Reservation Data</a></li> 
           <li role="presentation" <? if($tab=='list'){?> class="active" <? }?>><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Reservation List</a></li> 
        
        
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          
            
                 <? $this->load->view("includes/flashmessage");?> 
                <div role="tabpanel" class="tab-pane fade <? if($tab==''){?> active in <? }?>" id="profile" aria-labelledby="profile-tab"> 
                   
                  
                       <form data-toggle="validator" method="post" action="<?=base_url()?>hm/reservation/add" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Basic Information </h4>
						</div>
                        <div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group">
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."  <? if(! check_access('all_branch')){?> disabled <? }?>  id="branch_code" name="branch_code" >
                    <option value="">Search here..</option>
                    <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>,<?=$row->shortcode?>" <? if($row->branch_code==$this->session->userdata('branchid')){?> selected<? }?>><?=$row->branch_name?></option>
                    <? }?>
             
					</select> </div>
                    <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   id="sale_type" name="sale_type" >
                    <option value="1">Sales Division</option>
                     <option value="2">Marketing  Division </option>
                 
             
					</select> </div>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   id="cus_code" name="cus_code" >
                    <option value="">Customer Name</option>
                    <?    foreach($cuslist as $row){?>
                    <option value="<?=$row->cus_code?>"><?=$row->first_name?> <?=$row->last_name?></option>
                    <? }?>
             
					</select> </div>
                                       <div class="clearfix"> </div> <br />
                    <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Project Name</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
             
					</select> </div>
                     <div class="col-sm-3 " id="blocklist">   </div>
                          </div><? }?></div>
                        
                        
                       </div></div>
                       <div id="fulldata" style="min-height:100px;"></div>    
                        
                        
                        
					</form></p> 
                </div>
                <div role="tabpanel" class="tab-pane fade  <? if($tab=='list'){?> active in <? }?> " id="list" aria-labelledby="list-tab">
                       <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Project Name</th><th>Lot Number</th> <th>Customer Name </th><th>Reserve Date</th><th>Sale Value</th><th>Discount</th><th>Discounted Price</th><th>Minimum Down Payment</th><th>DP Completion Date</th><th>Create By </th><th>Confirm By </th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->project_name ?></td><td> <?=$row->lot_number ?>-<?=$row->plan_sqid ?></td> <td><?=$row->first_name ?> <?=$row->last_name ?></td> <td><?=$row->res_date?></td>
                          <td align="right"><?=number_format($row->sale_val,2)?></td> 
                             <td align="right"><?=number_format($row->discount,2)?></td> 
                              <td align="right"><?=number_format($row->discounted_price,2)?></td> 
                        <td align="right"><?=number_format($row->min_down,2)?></td> 
                        <td align="right"><?=$row->dp_cmpldate?></td>
                         <td ><?=get_user_fullname($row->apply_by)?></td>
                               <td><?=get_user_fullname($row->confirm_by)?></td>
                        
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:check_activeflag('<?=$row->res_code?>')" title="Edit"><!--<i class="fa fa-edit nav_icon icon_blue"></i>--></a>
                        <? if($row->res_status=='PENDING'){?>
                             <a  href="javascript:call_confirm('<?=$row->res_code?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete('<?=$row->res_code?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>   
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
                    window.location="<?=base_url()?>hm/reservation/delete/"+document.deletekeyform.deletekey.value;
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
					
                    window.location="<?=base_url()?>hm/reservation/confirm/"+document.deletekeyform.deletekey.value;
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