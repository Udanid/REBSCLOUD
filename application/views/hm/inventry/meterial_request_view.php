
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

$(".meterials").focus(function(){
  $(".meterials").chosen({
    allow_single_deselect : true
  });
});  

$('#fulldata').hide();

$( ".needdate" ).datepicker({dateFormat: 'yy-mm-dd'});
//////////////////////////////////////////////////////////////////////////////////////////
$('#formcount').val(1);
var ol_max_subjects = 200; //maximum input boxes allowed
var ol_wrapper = $(".fullmetqty"); //Fields wrapper
var ol_add_button = $(".btnaddnew"); //Add button ID
var olCount = 1; //initlal text box count
  $(ol_add_button).click(function(e){ //on add input button click
    e.preventDefault();
    
    if(olCount < ol_max_subjects){
      $(ol_wrapper).append('<tr><td width="25%"><select class="form-control meterials" id="meterials'+olCount+'" name="metrequest[][meterials]" required="req'+olCount+'uired" onchange="get_messures('+olCount+')">\
        <option value="">Select Meterial</option>\
        <?
                foreach($meterial as $met){
                  ?>
                <option data-units="<?=$met->mt_name?>" data-row="'+olCount+'" value="<?=$met->mat_id?>"><?=$met->mat_name?></option>\
                  <?
                }
        ?>
      </select></td>\
     <td width="10%">\
      <input type="Number" class="form-control" name="metrequest['+olCount+'][req_qty]" placeholder="Qty" required="required">\
    </td>\
    <td id="messurtype'+olCount+'"></td>\
    <td width="15%">\
      <input type="text" class="form-control needdate" name="metrequest['+olCount+'][needdate]" id="needdate'+olCount+'" placeholder="Need Date" required="required">\
    </td>\
    <td><a href="#" class="remove_field btn btn-danger"><i class="fa fa-trash"></i></a></td></tr>'); //add input box
    ///////////////////////////////
      var dt = "#needdate"+olCount;
      $(dt).datepicker({dateFormat: 'yy-mm-dd'});

    $(".meterials").focus(function(){
      $(".meterials").chosen({
         allow_single_deselect : true
      });
    });
    ///////////////////////////////
      olCount++; //text box increment

    }
    console.log("add new forms count "+olCount)
    $('#formcount').val(olCount);
    
  });

  $(ol_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault();
    $(this).closest('tr').remove(); olCount--;
    var curformcount = $('#formcount').val();
    var newformcount = curformcount-1;
    $('#formcount').val(newformcount);
  });

//////////////////////////////////////////////////////////////////////////////////////////
  
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

$("#meterials").focus(function() {
  $("#meterials").chosen({
     allow_single_deselect : true
  });
});
	
});


/*$('.meterials').change(function(){
  var rowid = $(this).find(':selected').data('row');
  var messurename = $(this).find(':selected').data('units');
  //var messurtype = "#messurtype"+rowid;
  $('#messurtype'+rowid).html(messurename);
  console.log("messurtype"+rowid)
});*/


function get_messures(id){
   var rowid = id;
   var rowid = $('#meterials'+id).find(':selected').data('row');//$(this).find(':selected').data('row');
   var messurename = $('#meterials'+id).find(':selected').data('units');
   $('#messurtype'+rowid).html(messurename);
   console.log(rowid)
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
					$( "#popupform" ).load( "<?=base_url()?>hm/customer/edit/"+id );
				}
            }
        });
}

// get branch related projects..
function loadcurrent_projects(id){
  $('#prjlist').html('');
  if(id!=""){
   
    $('#prjlist').delay(1).fadeIn(600);
    document.getElementById("prjlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
    $( "#prjlist" ).load( "<?=base_url()?>hm/Hm_inventry/get_projectsby_branch/"+id );
    console.log("<?=base_url()?>hm/Hm_inventry/get_projectsby_branch/"+id)
 }
 else
 {
   $('#prjlist').delay(1).fadeOut(600);
  
 }
}

function loadcurrent_block(id)
{
 $('#fulldata').show(); 
 if(id!=""){
	 
							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#blocklist" ).load( "<?=base_url()?>hm/lotdata/get_blocklist/"+id );
		
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);
	
 }
}

function load_fulldetails(id)
{
  //$('#fulldata').show();
	/* if(id!="")
	 {
		 var prj_id= document.getElementById("prj_id").value
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		   $( "#fulldata").load( "<?=base_url()?>hm/Hm_inventry/get_fulldata/"+id+"/"+prj_id );
	 } */
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

function approve(id){
  ajax_for_approve_disapprove(id,'APPROVED');
  $('#tbldata'+id).html("");
  $('#tbldata'+id).append("APPROVED <a href='javascript:resetthis("+id+")' title='Reset This'><i class='fa fa-refresh nav_icon icon_black' aria-hidden='true' title='approved'></i></a>");

}

function disapprove(id){
  ajax_for_approve_disapprove(id,'CANCELLED');
  $('#tbldata'+id).html("");
  $('#tbldata'+id).append("CANCELLED <a href='javascript:resetthis("+id+")' title='Reset This'><i class='fa fa-refresh nav_icon icon_black' aria-hidden='true' title='Disapproved'></i></a>");
}

function resetthis(id){
  ajax_for_approve_disapprove(id,'PENDING');
  $('#tbldata'+id).html("");
  $('#tbldata'+id).append("<a href='javascript:approve("+id+")' title='Confirm This'><i class='fa fa-check nav_icon icon_green' aria-hidden='true'></i></a><a href='javascript:disapprove("+id+")' title='Confirm This'><i class='fa fa-close nav_icon icon_red' aria-hidden='true'></i></a>");
}

function ajax_for_approve_disapprove(id,stts){
    //console.log("<?php echo base_url()?>hm/hm_inventry/request_meterial_stts")
    $.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url()?>hm/hm_inventry/upd_request_meterial_stts',
            data: {'id':id,'stts':stts},
            success: function(data){
              console.log(data)
              if(data!=='"PENDING"'){
                //alert("Status Updated")
                
              }
             get_meterial_request_list();
            }
    });
}

function get_meterial_request_list(){
  
  $('#metrequestlist').delay(1).fadeIn(600);
  $('#metrequestlist').load("<?=base_url()?>hm/hm_inventry/meterialreqlist");
}

</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">New Meterial Request</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          
          <li role="presentation" class="active"><a href="<?=base_url()?>hm/hm_inventry" id="progresslst-tab" role="tab" aria-controls="progresslst" aria-expanded="false">Meterial Request</a></li>

          <li role="presentation"><a href="<?=base_url()?>hm/hm_inventry/show_all_pending_po_request" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">Meterial Request Confirm List</a></li>

          <li role="presentation"><a href="<?=base_url()?>hm/hm_inventry/show_all_po_request" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">Meterial Request List</a></li>
        
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;height:500px;">
          
            
                 <? $this->load->view("includes/flashmessage");?> 
                <div role="tabpanel" class="tab-pane fade <? if($tab==''){?> active in <? }?>" id="profile" aria-labelledby="profile-tab"> 

              <!--  <? if($this->session->flashdata('msg')){?>
                <div class="alert alert-success" role="alert">
                <?=$this->session->flashdata('msg')?>
                </div><? }?>
                <? if($this->session->flashdata('error')){?>
                <div class="alert alert-danger" role="alert">
                <?=$this->session->flashdata('error')?>
                </div><? }?> -->
                   
                  
<form data-toggle="validator" method="post" action="<?=base_url()?>hm/Hm_inventry/add_request_meterials">
                        <input type="hidden" id="formcount" name="formcount">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Basic Information </h4>
						</div>
                        <div class="form-body form-horizontal">
                            <? if($prjlist){?>
                    <div class="form-group">
                    <div class="col-sm-3 ">  
                      <select class="form-control" onchange="loadcurrent_projects(this.value)" placeholder="Qick Search.."  <? if(! check_access('all_branch')){?> disabled <? }?>  id="branch_code" name="branch_code" >
                      <option value="">Search here..</option>
                      <?    foreach($branchlist as $row){?>
                      <option value="<?=$row->branch_code?>" <? if($row->branch_code==$this->session->userdata('branchid')){?> selected<? }?>><?=$row->branch_name?></option>
                      <? }?>
                      </select>
                    </div>
                    <div class="col-sm-3 " id="prjlist">  
                      <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Project Name</option>
                    <option value="all">Main Stock</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
                     </select> 
                   </div>
                     <div class="col-sm-3 " id="blocklist"></div>
                          </div><? }?></div>
                        
                        
                       </div></div>
                       <hr>
                     
                       
                       <div id="fulldata" class="fulldata" style="min-height:100px;">
                       <table class="table fullmetqty" width="70%">
                          <tr>
                            <td width="25%">
                              <select class="form-control meterials" id="meterials0" name="metrequest[0][meterials]" required="required" onchange="get_messures(0)">
                                <option value="">Select Meterial</option>
                                <?
                                        foreach($meterial as $met){
                                          ?>
                                        <option data-units="<?=$met->mt_name?>" data-row="0" value="<?=$met->mat_id?>"><?=$met->mat_name?></option>
                                          <?
                                        }
                                ?>
                              </select>
                            </td>
                            <td width="10%">
                              <input type="Number" class="form-control" name="metrequest[0][req_qty]" placeholder="Qty" required="required">
                            </td>
                            <td id="messurtype0" width="10%"></td>
                            <td width="15%">
                              <input type="text" class="form-control needdate" name="metrequest[0][needdate]" id="needdate" placeholder="Need Date" required="required">
                            </td>
                            <td><button class="btn btn-primary btnaddnew"> + </button></td>
                            
                          </tr>
                        </table>
                        <button type="sumit" class="btn btn-primary" name="update">Update</button>
                       </div>

				</form></p> 
                </div>
              
              <!--METERIAL LIST CONFIRMVIEW-->
                   
              <!--METERIAL LIST CONFIRM VIEW-->
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