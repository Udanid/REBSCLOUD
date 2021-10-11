
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
	 $("#interf_prj_id").focus(function() {
	  $("#interf_prj_id").chosen({
     allow_single_deselect : true
    });
	});
	 $("#intert_prj_id").focus(function() {
	  $("#intert_prj_id").chosen({
     allow_single_deselect : true
    });
	});

	$("#land_code").chosen({
     allow_single_deselect : true
    });
	
	$("#bank2").chosen({
     allow_single_deselect : true
    });
	$("#branch2").chosen({
     allow_single_deselect : true
    });
 
 
	
});


function close_edit(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'hm_prjacbudgettrn', id: id,fieldname:'id' },
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
            data: {table: 'hm_prjacbudgettrn', id: id,fieldname:'id' },
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
            data: {table: 'hm_prjacbudgettrn', id: id,fieldname:'prj_id' },
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
function load_lotdetails(id)
{
	$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>hm/lotdata/search/"+id );
}
</script>
<style type="text/css">



</style>
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Project Fund Transfers</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          
          <li role="presentation"  class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Payment List</a></li> 
            <li role="presentation" >
          <a href="#in" id="in-tab" role="tab" data-toggle="tab" aria-controls="in" aria-expanded="false">Inter Task</a></li>
           <!--  <li role="presentation" >
          <a href="#inter" id="inter-tab" role="tab" data-toggle="tab" aria-controls="inter" aria-expanded="false">Inter Project</a></li>
        -->   <li role="presentation" >
          <a href="#external" id="external-tab" role="tab" data-toggle="tab" aria-controls="external" aria-expanded="false">External</a></li> 
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          
               <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab" >
               <br>
             
               <? $this->load->view("includes/flashmessage");?>

                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Project ID</th> <th>Project Name</th><th>From Task</th>  <th>To Task </th><th>Transfer Type</th><th>Amount </th> <th>Payment Date</th><th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->project_code?></th> <td><?=$row->project_name ?></td>
                          <td><?=get_taskname($row->from_task_id) ?></td>
                        <td><?=$row->task_name ?></td>
                         <td> <?=$row->trn_type ?></td>
                        <td><?=$row->amount ?></td> 
                        <td><?=$row->cr_date ?></td>
                         <td><?=$row->status ?></td>
                        <td align="right"><div id="checherflag">
                      
                        <? if($row->status=='PENDING'){?>
                         <? if($row->trn_type=='External') { if( check_access('confirm_fundtransfers')){?>
                             <a  href="javascript:call_confirm('<?=$row->trn_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a><? }}else{?>
                              <a  href="javascript:call_confirm('<?=$row->trn_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <? }?>
                             <a  href="javascript:call_delete('<?=$row->trn_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>  
                </div> 
             <div role="tabpanel" class="tab-pane fade " id="in" aria-labelledby="in-tab" >
               <br>
               <? $this->load->view("hm/fundtransfers/inproject");?>
               </div>
                 <div role="tabpanel" class="tab-pane fade " id="inter" aria-labelledby="inter-tab" >
               <br>
               <? // $this->load->view("hm/fundtransfers/interproject");?>
               </div>
                <div role="tabpanel" class="tab-pane fade " id="external" aria-labelledby="external-tab" >
               <br>
               <? $this->load->view("hm/fundtransfers/external");?>
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
                    window.location="<?=base_url()?>hm/fundtransfers/delete/"+document.deletekeyform.deletekey.value;
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
					
                    window.location="<?=base_url()?>hm/fundtransfers/confirm/"+document.deletekeyform.deletekey.value;
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