
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal_encript");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
  setTimeout(function(){ 
	$("#land_code").chosen({
     	allow_single_deselect : true,
	 	search_contains: true,
	 	no_results_text: "Oops, nothing found!",
	 	placeholder_text_single: "Select a Land"
    });
	});
	$("#bank2").chosen({
     	allow_single_deselect : true,
	 	search_contains: true,
	 	no_results_text: "Oops, nothing found!",
	 	placeholder_text_single: "Select a Bank Account"
    });
	$("#branch2").chosen({
    	allow_single_deselect : true,
	 	search_contains: true,
	 	no_results_text: "Oops, nothing found!",
	 	placeholder_text_single: "Select a Bank Account"
    });
 	}, 800); 
	

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
                code='Nic Cannot be Blank';
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
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>re/project/edit/"+id );
				}
            }
        });
}
function loadlandadata(id)
{
	
 if(id!=""){
	 $('#landinfomation').delay(1).fadeIn(600);
        document.getElementById("landinfomation").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_landms', id: id,fieldname:'land_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
			 		 $('#landinfomation').delay(1).fadeOut(600);
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					
					$( "#landinfomation" ).load( "<?=base_url()?>re/project/landinformation/"+id );
				}
            }
        });
 }
 else
 {
	 $('#landinfomation').delay(1).fadeOut(600);
 }
}
function call_comment(id)
{
	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>re/project/comments/"+id );
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
function loadbranchlist(itemcode,caller)
{ 
var code=itemcode.split("-")[0];
//alert("<?=base_url().$searchpath?>/"+code)
if(code!=''){
	//alert(code)
	//$('#popupform').delay(1).fadeIn(600);
	$( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}
	
}

  
 
function  calculate_arc(val)
{
	if(val>0)
	{
		var arc=val/160;
		document.getElementById('project_arc').value=arc;
	}
	else
	document.getElementById('project_arc').value=0.00;
}
function  calculate_tot(val)
{
	
	var unselabletot=parseFloat(document.getElementById('road_ways').value)+parseFloat(document.getElementById('other_res').value)+parseFloat(document.getElementById('open_space').value);
	document.getElementById('unselable_area').value=unselabletot.toFixed(2);
		var seleble=parseFloat(document.getElementById('land_extend').value)-unselabletot;
		document.getElementById('selable_area').value=seleble.toFixed(2);
		var road_waysP=(parseFloat(document.getElementById('road_ways').value)/unselabletot)*100;
		var other_resP=(parseFloat(document.getElementById('other_res').value)/unselabletot)*100;
		var open_spaceP=(parseFloat(document.getElementById('open_space').value)/unselabletot)*100;
		document.getElementById('tot_resprecentage').value=unselabletot.toFixed(2);
		document.getElementById('road_waysP').value=road_waysP.toFixed(2);
		document.getElementById('other_resP').value=other_resP.toFixed(2);
		document.getElementById('open_spaceP').value=open_spaceP.toFixed(2);
		//alert(seleble);
	
	
}
</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">Project Details</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          <? $error=""; if(!check_project_count()){$tab='list'; $error='Your maximum project count reached. Please increase your package to add new projects';}
		  if(!check_access('add_project'))$tab='list';?>
           <? if(check_access('add_project') & check_project_count()){?> <li role="presentation" <? if($tab==''){?> class="active" <? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add New Project</a></li> 
          <? }?><li role="presentation"   <? if($tab=='list'){?> class="active" <? }?>>
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Project List</a></li> 
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          
               <div role="tabpanel" class="tab-pane fade   <? if($tab=='list'){?> active in <? }?>" id="home" aria-labelledby="home-tab" >
               <br>
              <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error') || $error){?>
               <div class="alert alert-danger" role="alert">
						<?=$error.'<br>'.$this->session->flashdata('error')?>
				</div><? }?>
              
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Project ID</th> <th>Project Name</th>  <th>Property Name</th><th>Project Branch</th><th>Project Officer </th> <th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->prj_id?></th> <td><?=$row->project_name ?></td> <td> <?=$row->property_name ?></td>
                        <td><?=$row->branch_name?></td>
                        <td><?=$row->initial?>&nbsp; <?=$row->surname?></td> 
                        <td><?=$row->status ?></td>
                        <td align="right"><div id="checherflag">
                      
                           <a  href="<?=base_url()?>re/feasibility/showall/<?=$this->encryption->encode($row->prj_id)?>" title="Feacibility Data"  ><i class="fa fa-list nav_icon icon_green"></i></a>
                        <? if($row->status=='PENDING' && !check_access('data_entry') ){?>
                        
                        
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>  
                </div> 
               <? if(check_access('add_project')& check_project_count()){?>
                <div role="tabpanel" class="tab-pane fade <? if($tab==''){?> active in <? }?>" id="profile" aria-labelledby="profile-tab"> 
                    <p>	  <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>
                  
                       <form data-toggle="validator"  method="post" action="<?=base_url()?>re/project/add" enctype="multipart/form-data">
                       <input type="hidden" name="product_code" id="product_code" value="<?=$product_code?>">
                        <div class="row">
						     <div class="  widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Master Information :</h4>
							</div>
							<div class="form-body">
								<div class="form-inline"> 
									<div class="form-group">
                                      <div class="form-group">
                                         <label class="control-label" for="inputSuccess1">Branch </label>
                                         <select class="form-control" placeholder="Qick Search.."  <? if(! check_access('all_branch')){?> disabled <? }?>  id="branch_code" name="branch_code" >
                    <option value="">Search here..</option>
                    <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>" <? if($row->branch_code==$this->session->userdata('branchid')){?> selected<? }?>><?=$row->branch_name?></option>
                    <? }?> 
					</select> 
										
									</div>
                                    <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;Land&nbsp;&nbsp;&nbsp;&nbsp;</label> 
                                    <select name="land_code" id="land_code" class="form-control" placeholder="Introducer"  onChange="loadlandadata(this.value)" required>
                                    <option value=""></option>
                                     <? foreach ($land_list as $raw){?>
                    <option value="<?=$raw->land_code?>" ><?=$raw->property_name?>-<?=$raw->district?></option>
                    <? }?>
        
                                    </select>
										</div>&nbsp;<div class="form-group">
                                         <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;Project Officer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> 
										 <select name="officer_code" id="officer_code" class="form-control" placeholder="Introducer" required>
                                    <option value="">Project Officer</option>
                                    
                                     <? if($officerlist) {foreach ($officerlist as $raw){?>
                    <option value="<?=$raw->id?>" ><?=$raw->initials_full?> - <?=$raw->display_name?></option><!-- Ticket No.2502 || Added by Uvini -->
                    <? }}?>
        
                                    </select></div>
                                    <div class="form-group">
                                         <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;CR Officer </label> 
										 <select name="officer_code2" id="officer_code2" class="form-control" placeholder="Introducer" >
                                    <option value="">CR Officer 2</option>
                                    
                                     <? if($officerlist) {foreach ($officerlist as $raw){?>
                    <option value="<?=$raw->id?>" ><?=$raw->initials_full?> - <?=$raw->display_name?></option><!--Uvini-->
                    <? }}?>
        
                                    </select></div>
										
                                  </div>
                                  <br>
                                    
									<br>
						</div>
                        </div>
                        <div class="clearfix"> </div></div>
                      
                      <div id="landinfomation" style="display:none"><img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif"> <br> <br> <br> <br> <br></div>
                        
                        <br> <br> <br><br> <br> <br>
                        
					</form></p> 
                </div>
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
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>re/project/confirm/"+document.deletekeyform.deletekey.value;
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