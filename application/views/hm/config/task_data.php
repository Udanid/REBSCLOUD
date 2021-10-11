<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
function activatechosen(){
	setTimeout(function(){
	  	$("#ledger_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Ledger"
    	});
	  	$("#adv_ledgerid").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Ledger"
    	});
		$("#related_code").chosen({
       		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Related Code"
    	});

	 	$.ajaxSetup ({
    	// Disable caching of AJAX responses
    		cache: false
		});
	}, 800);
}
var deleteid="";
function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_tasktype', id: id,fieldname:'design_id' },
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
function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_config_task', id: id,fieldname:'task_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#mylistkkk').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>hm/hm_config/edit_task/"+id );
				}
            }
        });
}
function close_edit(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'hm_config_task', id: id,fieldname:'task_id' },
            success: function(data) {
                if (data) {
					 $('#popupform').delay(1).fadeOut(800);

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					 document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
					 $('#mylistkkk').click();

				}
            }
        });
}


jQuery(document).ready(function() {
$('#task_type').change(function(){
	var task_type=$('#task_type').val();

	if(task_type=='Common'){
		$('#related_code').prop('required',true);
		//alert(task_type)
	}else{
		$('#related_code').prop('required',false);
	}
});
});

function runScript(e,val) {
		//detect enter key and run the function
		if (e.keyCode == 13) {
			var tb = document.getElementById("search");
			//eval(tb.value);
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'hm/hm_config/search_task';?>',
				data: {string:val },
				success: function(data) {
					$("#taskdata").html('');
					$("#taskdata").html(data);
				}
			});
		}
	}
</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Product Task Config</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Product Task List</a></li>
          <li role="presentation"><a href="#profile" id="profile-tab" role="tab" onClick="activatechosen()" data-toggle="tab" aria-controls="profile" aria-expanded="false">New Product Task</a></li>
         </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
               <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
               <br>
              <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>

                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                        <table class="table"> <thead> <tr>
													<th>No</th>
													<th>Task Code</th>
													<th>Task Related Code</th>
													<th>Task Description</th>
												</tr>
												<tr>
													<th colspan="4">
														<div class="search">
															<span class="fa fa-search"></span>
															<input type="text" name="search" id="search" class="form-control" autocomplete="off" onkeypress="return runScript(event,this.value)" placeholder="Task code or Desctiption" style="width: 20%;" required>
														</div>
													</th>
												</tr>
											</thead>
											<tbody id="taskdata">
											<? if($datalist){$c=0;
                          foreach($datalist as $row){?>

                         <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <td scope="row"><?=$c?></td>
												<td><?=$row->task_code?></td>
												<td><?=$row->relative_code?></td>
												<td><?=$row->task_name?></td>

                        <td align="right"><? $statues=check_foreign_key('hm_config_boqtask',$row->task_id,'task_id');
												$statues2=check_foreign_key('re_hmacpaymentms',$row->task_id,'task_id');//call from hmconfig_helpere
												//echo $statues2;
                        if($row->active_status=='PENDING'){
							if($statues2){?>
                        
													<a  href="javascript:call_delete('<?=$row->task_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
													<a  href="javascript:check_activeflag('<?=$row->task_id?>')"><i class="fa fa-edit nav_icon icon_red"></i></a>
										<? }}?>

                        </td>
                         </tr>

                                <? }} ?>
                          </tbody></table>
													<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>
                  </div>
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab">

                    <p>
                    <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/add_task" id="mytestform">

                    <div class="form-title"> Add New Task

							</div>
						<div class="col-md-6 validation-grids " data-example-id="basic-forms">
							<div class="form-body">
								<label>Task Code</label>
								<div class="form-group">
									<input type="text"  name="task_code" id="task_code" class="form-control" required>
								</div>

								<label>Task Type</label>
								<div class="form-group">
									<select  name="task_type" id="task_type" class="form-control" required>
										<option value="BOQ">BOQ</option>
										<option value="Common">Common</option>
									</select>
								</div>
								<label>Task Related To</label>
								<div class="form-group">
									<select class="form-control" name="related_code" id="related_code" required>

										<? if($relative_code){?>
											<option value=""></option><? }?>
											<? foreach ($relative_code as $rw){?>
												<option value="<?=$rw->code?>"><?=$rw->code?> - <?=$rw->description?></option>
											<? }?>
									</select>
								</div>

									<label>Ledger Account</label>
									<div class="form-group">
										<select class="form-control" name="ledger_id" id="ledger_id" required>
											<? $ledgerlist=get_master_acclist()?>
											<? if($ledgerlist){?>
			<option value=""></option><? }?>
			<? foreach ($ledgerlist as $rw){?>
			<option value="<?=$rw->id?>"><?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
			<? }?>
										</select>

									</div>


                  <div class="form-group">
                    <button type="submit" class="btn btn-primary disabled">Submit</button>
                  </div>

							</div>
						</div>
						<div class="col-md-6 validation-grids " data-example-id="basic-forms">
							<div class="form-body">


									<label>Task Name</label>
									<div class="form-group">
                    <textarea name="task_name" id="task_name" rows="4" cols="20" class="form-control" required></textarea>
									</div>
									<label>Advance Ledger Account</label>
									<div class="form-group">
										<select class="form-control" name="adv_ledgerid" id="adv_ledgerid" required>
											<? if($ledgerlist){?>
			<option value=""></option><? }?>
			<? foreach ($ledgerlist as $rw){?>
			<option value="<?=$rw->id?>"><?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
			<? }?>
										</select>

									</div>
								</div>
							</div>
					</form></div></p>
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
                    window.location="<?=base_url()?>hm/hm_config/task_delete/"+document.deletekeyform.deletekey.value;
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

<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script  type="text/javascript">
	jQuery(document).ready(function() {

	//validate all fields
  	$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
		$("#mytestform").validate({
			rules: {
					task_code: {required: true},
					task_type: {required: true},
					ledger_id: {required: true},
					task_name: {required: true},
					adv_ledgerid: {required: true},
				},
        messages: {
            task_code: "Required",
						task_type: "Required",
						ledger_id: "Required",
						task_name: "Required",
						adv_ledgerid:"Required",
        }
});


	});
</script>
