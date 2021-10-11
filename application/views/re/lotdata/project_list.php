
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
  

	$("#land_code").chosen({
     allow_single_deselect : true
    });
	
	$("#bank2").chosen({
     allow_single_deselect : true
    });
	$("#branch2").chosen({
     allow_single_deselect : true
    });
 setTimeout(function(){ 
	  $("#prj_id_search").chosen({
		  allow_single_deselect : true,
		  search_contains: true,
		  no_results_text: "Oops, nothing found!",
		  placeholder_text_single: "Select a Project"
	  });
	}, 800);

 setTimeout(function(){ 
    $("#prj_id_upload").chosen({
      allow_single_deselect : true,
      search_contains: true,
      no_results_text: "Oops, nothing found!",
      width:100,
      placeholder_text_single: "Select a Project"
    });
  }, 800);
 
	
});
function chosenActivate(){
	setTimeout(function(){ 
	  $("#prj_id").chosen({
		  allow_single_deselect : true,
		  search_contains: true,
		  no_results_text: "Oops, nothing found!",
		  placeholder_text_single: "Select a Project"
	  });
	}, 800);
}

function close_edit(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
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
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
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
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
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

function call_delete(id)
{
   document.deletekeyform.deletekey.value=id;
  $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
            success: function(data) {
                if (data) {
          // alert(data);
            document.getElementById("checkflagmessage").innerHTML=data; 
           $('#flagchertbtn').click();
             
          //document.getElementById('mylistkkk').style.display='block';
                } 
        else
        {
          $('#complexConfirm_delete').click();
        }
            }
        });
  
  
//alert(document.testform.deletekey.value);
  
}
function call_soldout(id)
{
   document.deletekeyform.deletekey.value=id;
  $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
            success: function(data) {
                if (data) {
          // alert(data);
            document.getElementById("checkflagmessage").innerHTML=data; 
           $('#flagchertbtn').click();
             
          //document.getElementById('mylistkkk').style.display='block';
                } 
        else
        {
          $('#complexConfirm_soldout').click();
        }
            }
        });
  
  
//alert(document.testform.deletekey.value);
  
}

function load_lotdetails(id)
{
	$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>re/lotdata/search/"+id );
}

function loadcurrent_search_block(id)
{
	//alert(id)
 if(id!=""){


		 $('#plandata').delay(1).fadeIn(600);

						 $('#project_list_search').delay(1).fadeIn(600);
    					    document.getElementById("project_list_search").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#project_list_search" ).load( "<?=base_url()?>re/lotdata/seach_project_blockplan/"+id );
					



 }
 else
 {
	 $('#lotinfomation').delay(1).fadeOut(600);
	 $('#plandata').delay(1).fadeOut(600);
 }
}

</script>
<style type="text/css">



</style>
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Price List</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          
          <li role="presentation"  class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Project List</a></li> 
            <li role="presentation" >
          <a href="#block" id="block-tab" role="tab" data-toggle="tab" onClick="chosenActivate()" aria-controls="block" aria-expanded="false">Add Block Out Plan</a></li> 
           <li role="presentation" >
          <a href="#upload" id="upload-tab" role="tab" data-toggle="tab" aria-controls="upload" aria-expanded="false">Upload Block Out Plan</a></li> 
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          
               <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab" >
               <br>
             <div class="form-body form-horizontal">
                          <div class="form-group"><label class="col-sm-3 control-label">Select Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."  onchange="loadcurrent_search_block(this.value)" id="prj_id_search" name="prj_id_search" >
                    <option value=""></option>
                    <?   foreach($searchdata as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>

					</select> </div>
                          </div></div>
               <? $this->load->view("includes/flashmessage");?>

                    <div class=" widget-shadow bs-example" data-example-id="contextual-table"  id="project_list_search"> 
                  
                        <table class="table"> <thead> <tr> <th>Project ID</th> <th>Project Name</th>  <th>Land Extent</th><th>Project Officer </th> <th>Status</th><th>Sales Completion Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->project_code?></th> <td><?=$row->project_name ?></td> <td> <?=$row->selable_area ?></td>
                        <td><?=$row->initial?>&nbsp; <?=$row->surname?></td> 
                        <td><?=$row->price_status ?></td>
                          <td><?=$row->sales_cml_status ?></td>
                        <td align="right"><div id="checherflag">
                      
                           <a  href="javascript:load_lotdetails('<?=$row->prj_id?>')" title="Block Out Plans"  ><i class="fa fa-sitemap nav_icon icon_blue"></i></a>
                         <? if($row->price_status=='PENDING'){?>
                             <a  href="javascript:call_confirm('<?=$row->prj_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                                <? }?>
                                 <? if($row->price_status=='CONFIRMED' & $row->sales_cml_status=='PENDING'){?>
                             <a  href="javascript:call_soldout('<?=$row->prj_id?>')" title="Soldout All Blocks"><i class="fa fa-lock nav_icon icon_red"></i></a>
                                <? }?>

                          <? if($row->price_status=='PENDING' && check_blockout($row->prj_id)){?>
                             <a  href="javascript:call_delete('<?=$row->prj_id?>')" title="Delete Block Out"><i class="fa fa-trash nav_icon icon_red"></i></a>
                                <? }?>

                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>  
                </div> 
             <div role="tabpanel" class="tab-pane fade " id="block" aria-labelledby="block-tab" >
               <br>
               <? $this->load->view("re/lotdata/newlotplan");?>
               </div>

                <div role="tabpanel" class="tab-pane fade " id="upload" aria-labelledby="upload-tab" >
               <br>
               <? $this->load->view("re/lotdata/newlotplan_upload");?>
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
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_delete" name="complexConfirm_delete"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_soldout" name="complexConfirm_soldout"  value="DELETE"></button>

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
                    window.location="<?=base_url()?>re/project/delete/"+document.deletekeyform.deletekey.value;
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
                text: "Are you sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>re/lotdata/confirm_price/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

               $("#complexConfirm_delete").confirm({
                title:"Record Delete",
                text: "Are you sure you want to delete this ?" ,
        headerClass:"modal-header confirmbox_red",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
          var code=1
          
                    window.location="<?=base_url()?>re/lotdata/delete_blockout/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			
			$("#complexConfirm_soldout").confirm({
                title:"Record confirmation",
                text: "Are you sure you want to Make this project as Sold out ?" ,
				headerClass:"modal-header confirmbox_red",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>re/lotdata/soldout/"+document.deletekeyform.deletekey.value;
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