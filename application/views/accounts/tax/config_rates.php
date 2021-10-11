
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">


function edit_vat(id)
{
	
//alert(id);
        
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_vatconfig', id: id,fieldname:'id' },
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
					$( "#popupform" ).load( "<?=base_url()?>accounts/tax/edit_vat/"+id );
				}
            }
        });
}
function edit_esp(id)
{
	
//alert(id);
        
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_vatconfig', id: id,fieldname:'id' },
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
					$( "#popupform" ).load( "<?=base_url()?>accounts/tax/edit_esp/"+id );
				}
            }
        });
}
function close_edit_vat(id)
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

</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">
 
                 
 
      <h3 class="title1">VAT and ESC Rates</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <li role="presentation" class="active">
          <a href="#vat" id="vat-tab" role="tab" data-toggle="tab" aria-controls="vat" aria-expanded="false">VAT</a></li> 
            <li role="presentation">
          <a href="#esp" id="esp-tab" role="tab" data-toggle="tab" aria-controls="esp" aria-expanded="false">ESC</a></li> 
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
               <div role="tabpanel" class="tab-pane fade active in" id="vat" aria-labelledby="vat-tab" >
               <br>
             <? $this->load->view("includes/flashmessage");?>
              <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/tax/add_vat" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Define Vat Rate</h4>
						</div>
                        <div class="form-body form-horizontal">
                           
                          <div class="form-group"><div class="col-sm-2 "> 
                          <select class="form-control" placeholder="Qick Search.."   id="year" name="year"  required="required" >
                           <option value="">Year</option>
                          <? for($i=2018; $i<=2055; $i++){?>
                          <option value="<?=$i?>"><?=$i?></option>
                          <? }?>
                          </select></div>
                          <div class="col-sm-2 ">   <select class="form-control" placeholder="Qick Search.."  id="month" name="month"   >
                           <option value="">Month</option>
                          <? for($i=1; $i<=12; $i++){
							  $monthName = date('F', mktime(0, 0, 0, $i, 10));?>
                          <option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=$monthName?></option>
                          <? }?>
                          </select></div>
                          <div class="col-sm-2 ">  <select class="form-control" placeholder="Qick Search.."    id="m_half" name="m_half"  >
                           <option value="">Select Period</option>
                         
                          <option value="1">first Half</option>
                           <option value="2">Second Half</option>
                        
                          </select></div>
                          <div class="col-sm-2 ">  <input  type="text" class="form-control" id="rate"    name="rate"  value=""   data-error="" required  placeholder="Rate (%)"> </div>
                         
										<div class="col-sm-3 has-feedback" id="paymentdateid"><button type="submit" class="btn btn-primary disabled" >Add Type</button></div></div></div>
                       
                       </div>
                       
                       
                       </div>
                       
                        
                        
                        
					</form>
              
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table table-bordered"> <thead> <tr> <th >ID</th> <th >year</th> <th >Month</th><th >Month hald</th><th >rate</th><th></th></tr>
                      </thead>
                      <? if($vatdata){$c=0;
                          foreach($vatdata as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->id?></th> 
                        <td><?=$row->year ?></td> 
                        <td><?=$row->month?></td>
                        <td><?=$row->m_half?></td>
                         <td><?=$row->rate?></td>
                        
                       
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:edit_vat('<?=$row->id?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                      
                          
                   
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                            
                    </div>  
                </div> 
               
                  <div role="tabpanel" class="tab-pane fade " id="esp" aria-labelledby="esp-tab" >
               <br>
             <? $this->load->view("includes/flashmessage");?>
               <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/tax/add_esp" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Define ESC Rate</h4>
						</div>
                        <div class="form-body form-horizontal">
                           
                          <div class="form-group"><div class="col-sm-2 "> 
                          <select class="form-control" placeholder="Qick Search.."    id="year_sep" name="year_sep"  required="required" >
                           <option value=">">Year</option>
                          <? for($i=2018; $i<=2055; $i++){?>
                          <option value="<?=$i?>"><?=$i?></option>
                          <? }?>
                          </select></div>
                          
                          <div class="col-sm-2 ">  <select class="form-control" placeholder="Quarter "    id="quoter" name="quoter"  >
                           <option value="">Select Quarter</option>
                         
                          <option value="1"> 1 st Quarter</option>
                           <option value="2">2 nd Quarter</option>
                             <option value="3">3 rd Quarter</option>
                               <option value="4">4 th Quarter</option>
                        
                          </select></div>
                          <div class="col-sm-2 ">  <input  type="text" class="form-control" id="rate"    name="rate"  value=""   data-error="" required  placeholder="Rate (%)"> </div>
                         
										<div class="col-sm-3 has-feedback" id="paymentdateid"><button type="submit" class="btn btn-primary disabled" >Add Rate</button></div></div></div>
                       
                       </div>
                       
                       
                       </div>
                       
                        
                        
                        
					</form>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table table-bordered"> <thead> <tr> <th >ID</th> <th >year</th> <th >Quotare</th><th >rate</th><th></th></tr>
                      </thead>
                      <? if($espdata){$c=0;
                          foreach($espdata as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->id?></th> 
                        <td><?=$row->year ?></td> 
                        <td><?=$row->quoter?></td>
                         <td><?=$row->rate?></td>
                        
                       
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:edit_esp('<?=$row->id?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                      
                          
                   
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                            
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