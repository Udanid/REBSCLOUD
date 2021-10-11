
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
?> 

<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script>
jQuery(document).ready(function() {
	$("#input-31").chosen({
     	allow_single_deselect : true
    });
	
	
});



var deleteid="";
function call_delete(id)
{
	document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerchangelog', id: id,fieldname:'cus_code' },
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

function approve_all(id){
	document.deletekeyform.deletekey.value=id;
	$('#complexConfirmApprove').click();
}

function check_activeflag(id)
{

        
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
					$( "#popupform" ).load( "<?=base_url()?>cm/customer/approve_changes/"+id );
				}
            }
        });
}


function close_edit(){
	$('#popupform').delay(1).fadeOut(800);
}

</script>
      
 <link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Customer Changes</h3>
      <!--search-box-->
      <div class="search-box-cust">
          <form class="input">
          <select class="sb-search-input input__field--madoka" placeholder="Qick Search.."  id="input-31" name="input-31" onChange="check_activeflag(this.value)">
          <option value="">Search here..</option>
    	<? if($pendings){$c=0;
              foreach($pendings as $row){
              
              	echo '<option id="'.$row->cus_code.'" value="'.$row->cus_code.'">'.$row->cus_number.' '.$row->first_name .' '.$row->last_name .' '.$row->id_number .' '.$row->mobile.'</option>';
                
              }
			  
		}?>
          
          </select> 
              
           <button type="submit"  class="search-box_submit">SEARCH</button>
            
          </form>
        
      </div><!--//end-search-box-->
      <br>
     			
      <div class="widget-shadow">
      
          
                
              
               <? if(check_access('view_customerchanges')){?>
                    <p>	  <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>
                  
                      
                        <table class="table"> <thead> <tr> <th>Customer Code</th><th>Customer Number</th> <th>Customer Type</th><th>Name</th> <th>Date of Birth </th> <th>Mobile</th> <th>ID Number</th><th></th></tr> </thead>
                      <? if($pendings){$c=0;
                          foreach($pendings as $row){?>
                      
                        <tbody> 
                        <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        	<td scope="row"><?=$row->cus_code?></td> 
                            <td><?=$row->cus_number?></td>
                            <td><?=ucfirst($row->cus_type)?></td>
                            <td><?=strtoupper($row->first_name.' '.$row->last_name) ?></td> 
                            <td><?=$row->dob?></td>
                        	<td><?=$row->mobile?></td> 
                        	<td><?=$row->id_number ?></td>
                        	<td align="right"><div id="checherflag">
                            
                            	<a  href="javascript:check_activeflag('<?=$row->cus_code?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>
                            
                             	<a  href="javascript:call_delete('<?=$row->cus_code?>')" title="Cancel"><i class="fa fa-times nav_icon icon_red"></i></a>
                        
                        	</td>
                         </tr> 
                        
                                <? }}else{ ?>
                              <tr><td colspan="7"> Nothing to Approve!</td></tr>
                                <? }?>
                          </tbody></table>  
                          <div id="pagination-container"><?php echo $links; ?></div>
                    
                <? }?>
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
                    
    <button type="button" style="display:none; visibility:hidden;" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
    <button type="button" style="display:none; visibility:hidden;" class="btn btn-delete" id="complexConfirmApprove" name="complexConfirmApprove"  value="DELETE"></button>
    <form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
    </form>
        
        
<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are you sure you want to cancel this?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>cm/customer/cancel_changes/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			
			$("#complexConfirmApprove").confirm({
                title:"Approve confirmation",
                text: "Are you sure you want to approve this?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>cm/customer/approve_all/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			
            
          
</script> 
<!-- The blueimp Gallery widget -->
      <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
          <div class="slides"></div>
          <h3 class="title"></h3>
          <a class="prev">‹</a>
          <a class="next">›</a>
          <a class="close">×</a>
          <a class="play-pause"></a>
          <ol class="indicator"></ol>
      </div> 

  <script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>  
          
            
       
        
        
        <div class="clearfix"> </div>
    </div>
</div>
<!--footer-->
<?
	$this->load->view("includes/footer");
?>