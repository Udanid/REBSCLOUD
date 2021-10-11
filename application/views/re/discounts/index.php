
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

 setTimeout(function(){
	$("#district").chosen({
     	allow_single_deselect : true
    });
	
	$("#procouncil").chosen({
     	allow_single_deselect : true
    });
	
	$("#town").chosen({
     	allow_single_deselect : true,
		
    });
	$("#project_search").chosen({
     	allow_single_deselect : true,
		
    });
	
	 
 },500);
 
});

function chosenActivate(){
	setTimeout(function(){ 
		$("#prj_id").chosen({
			allow_single_deselect : true,
			search_contains: true,
			no_results_text: "Oops, nothing found!",
			placeholder_text_single: "Select a Project"
		});
    	$("#dicountform").validate({
			ignore: ":hidden:not(select)",
			rules: {
				prj_id: {
					required: true
				},
			},
			message: {prj_id:"Select a Country"},
			errorPlacement: function(error, element) {
			  var placement = $(element).data('error');
			  if (placement) {
				$(placement).append(error)
			  } else {
				error.insertAfter(element);
			  }
			}
		});
	}, 800);
}

function showTable(){
	$('#discounttable').html('');
	var periods = $('#periods').val();
	var levels = $('#levels').val();
	if(periods != '' && periods != 0 && levels != 0 && levels != ''){
		$.ajax({
			cache: false,
			type: 'POST',
			url: '<?php echo base_url().'re/discounts/create_list';?>',
			data: {periods: periods, levels:levels },
			success: function(data) {
				if (data) {
					$('#discounttable').html(data);
				}
				else
				{
					//alert('Unable to check customer ID. Please search on top search field');
				}
			}
		});	
	}
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57 ) && charCode != 46) {
        return false;
    }
    return true;
}

function viewScheme(prj_id){

	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>re/discounts/view/"+prj_id );

}

function close_view(){
	$('#popupform').delay(1).fadeOut(800);
}

function check_activeflag(id)
{
	$.ajax({
		cache: false,
		type: 'GET',
		url: '<?php echo base_url().'common/activeflag_cheker/';?>',
		data: {table: 're_discountschedule', id: id,fieldname:'prj_id' },
		success: function(data) {
			if (data) {
				  document.getElementById("checkflagmessage").innerHTML=data; 
				 $('#flagchertbtn').click();
			} 
			else
			{
				$('#popupform').delay(1).fadeIn(600);
				$( "#popupform" ).load( "<?=base_url()?>re/discounts/edit/"+id );
			}
		}
	});
}

function check_delete(id)
{
	document.deletekeyform.deletekey.value=id;
	$.ajax({
		cache: false,
		type: 'GET',
		url: '<?php echo base_url().'common/activeflag_cheker/';?>',
		data: {table: 're_discountschedule', id: id,fieldname:'prj_id' },
		success: function(data) {
			if (data) {
				  document.getElementById("checkflagmessage").innerHTML=data; 
				 $('#flagchertbtn').click();
			} 
			else
			{
				$('#complexConfirm').click();
			}
		}
	});
}

function check_confirm(id,action)
{
	document.deletekeyform.deletekey.value=id;
	document.deletekeyform.action.value=action;
	$.ajax({
		cache: false,
		type: 'GET',
		url: '<?php echo base_url().'common/activeflag_cheker/';?>',
		data: {table: 're_discountschedule', id: id,fieldname:'prj_id' },
		success: function(data) {
			if (data) {
				  document.getElementById("checkflagmessage").innerHTML=data; 
				 $('#flagchertbtn').click();
			} 
			else
			{
				$('#complexConfirm_confirm').click();
			}
		}
	});
}

function close_edit(id)
{
	$.ajax({
		cache: false,
		type: 'GET',
		url: '<?php echo base_url().'common/delete_activflag/';?>',
		data: {table: 're_discountschedule', id: id,fieldname:'prj_id' },
		success: function(data) {
			if (data) {
				 $('#popupform').delay(1).fadeOut(800);
			} 
			else
			{
				 document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin '; 
				 $('#flagchertbtn').click();
				
			}
		}
	});
}


//Ticket No:2689 Added By Madushan 2021.04.20
function loadcurrent_search_project(id)
{
  // alert(id)
 if(id!=""){


     $('#plandata').delay(1).fadeIn(600);

             $('#project_data_search').delay(1).fadeIn(600);
                  document.getElementById("project_data_search").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
          $( "#project_data_search" ).load( "<?=base_url()?>re/discounts/seach_project_data/"+id );
          



 }
 else
 {
   $('#lotinfomation').delay(1).fadeOut(600);
   $('#plandata').delay(1).fadeOut(600);
 }
}


</script>
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">
      <h3 class="title1">Project Discount Schemes</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <? if(check_access('add_project_discounts')){?>  
           	<li role="presentation"  <? if($tab=='list'){?> class="active" <? }?>>
          		<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Scheme List</a></li>
           <li role="presentation"    <? if($tab==''){?> class="active" <? }?>><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true" onClick="chosenActivate();">Add New Scheme</a></li>
		   <? }else {?>
              <li role="presentation"  class="active" >
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Scheme List</a></li>
      
           <? }?>

               </ul>
           <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">

               <div role="tabpanel" class="tab-pane fade <? if($tab==''){?> active in <? }?> " id="list" aria-labelledby="home-tab" >
               <br>
              

                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
						<div class="row">
						     <div class="widget-shadow" data-example-id="basic-forms"> 
                                <div class="form-title">
                                    <h4>New Scheme</h4>
                                </div>
                                <div class="form-body">
                                    <div class="form-inline"> 
                                    	<form data-toggle="validator" method="post" id="dicountform" action="<?=base_url()?>re/discounts/index" enctype="multipart/form-data">
                                    		<div class="form-group">
                                            	<label class="control-label" for="inputSuccess1">Project&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            	<select class="form-control chosen-select" placeholder="Qick Search.." id="prj_id" name="prj_id" >
                    								<option value=""></option>
                    								<?   foreach($datalist as $row){?>
                    									<option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    								<? }?>

												</select>
                                        	</div>
                                            
                                           <div class="form-group">
                                              <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;Periods&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                              <input type="number" name="periods" <? if(empty($datalist)){?>readonly <? }?> placeholder="Number of Periods" id="periods" onKeyUp="showTable();" class="form-control">
                                           </div>
                                           <div class="form-group">
                                              <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;Levels&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                              <input type="number" name="levels"  <? if(empty($datalist)){?>readonly <? }?> id="levels" placeholder="Number of Levels" onKeyUp="showTable();" class="form-control">
                                         	</div>
                                         	<br><br>
                                         	<div class="form-group">
                                         		<div id="discounttable"></div>
                                         	</div>
                                    	</form>
                                    </div>
                                </div>
                            </div>
                       	</div>
                    </div>   
                </div>
                <div role="tabpanel" class="tab-pane fade <? if($tab=='list'){?> active in <? }?> " id="home" aria-labelledby="home-tab" >
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
						<div class="row">
						     <div class="widget-shadow" data-example-id="basic-forms"> 
              						              <div class="form-body form-horizontal">
                          <div class="form-group"><label class="col-sm-3 control-label">Select Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."  onchange="loadcurrent_search_project(this.value)" id="project_search" name="project_search" >
                    <option value=""></option>
                    <?   foreach($project_discounts as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>

          </select> </div>
                          </div></div>
                                <div class="form-body">
                                	<div id="project_data_search">
                                	<table width="400" class="table" border="0" cellspacing="0" cellpadding="0">
                                      	<thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Project</th>
                                                <th>Created By</th>
                                                <th>Updated By</th>
                                                <th>Checked By</th>
                                                <th>Confirmed By</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    <?
									if($project_discounts){ 
										foreach ($project_discounts as $row){
									?>
                                    	<tbody>
                                            <tr>
                                                <td><?=$row->prj_id;?></td>
                                                <td><?=$row->project_name;?></td>
                                                <td><?=$row->created_by;?></td>
                                                <td><?=$row->updated_by;?></td>
                                                <td><?=$row->checked_by;?></td>
                                                <td><?=$row->confirmed_by;?></td>
                                                <td>
                                                	<? if(check_access('edit_project_discounts')){
														if($row->status == 'PENDING'){ ?>
                                                		<a  href="javascript:check_activeflag('<?=$row->prj_id?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                                                    <? 
														}
													}?>
                                                    <? if(check_access('delete_project_discounts')){
                                                    	if($row->status == 'PENDING'){ ?>
                                                		<a  href="javascript:check_delete('<?=$row->prj_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                                                    <? 
														}
													}?>
                                                   
                                                    <a  href="javascript:viewScheme('<?=$row->prj_id?>')" title="View"><i class="fa fa-eye nav_icon icon_green"></i></a>
                                                     <? if(check_access('check_project_discounts')){
                                                    	if($row->status == 'PENDING'){ ?>
                                                		<a  href="javascript:check_confirm('<?=$row->prj_id?>','check')" title="Check"><i class="fa fa-check-square-o nav_icon brown-400"></i></a>
                                                        <? }
                                                     }?>
                                                     <? if(check_access('confirm_project_discounts')){
                                                    	if($row->status == 'CHECKED'){ ?>
                                                		<a  href="javascript:check_confirm('<?=$row->prj_id?>','confirm')" title="Confirm"><i class="fa fa-check nav_icon green-400"></i></a>
                                                        <? }
                                                     }?>
                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?	
										}
									}else{ echo '<tr><td colspan="3">Nothing to Display!</td></tr>';}
									?>
                                    </table>
                                </div>
                                </div>
                            </div>
                       	</div>
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
<form name="deletekeyform">  
	<input name="deletekey" id="deletekey" value="0" type="hidden">
	<input name="action" id="action" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are you sure you want to delete this?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>re/discounts/delete/"+document.deletekeyform.deletekey.value;
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
                text: "Are you sure you want to confirm this?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>re/discounts/confirm/"+document.deletekeyform.deletekey.value+"/"+document.deletekeyform.action.value;
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
