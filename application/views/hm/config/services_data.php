<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_customer");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">

var deleteid="";
function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_tasktype', id: id,fieldname:'task_id' },
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
            data: {table: 'hm_config_services', id: id,fieldname:'service_id' },
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
					$( "#popupform" ).load( "<?=base_url()?>hm/hm_config/edit_services/"+id );
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
            data: {table: 'hm_config_services', id: id,fieldname:'service_id' },
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
function runScript(e,val) {
		//detect enter key and run the function
		if (e.keyCode == 13) {
			var tb = document.getElementById("search");
			//eval(tb.value);
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'hm/hm_config/search_services';?>',
				data: {string:val },
				success: function(data) {
					$("#servisedata").html('');
					$("#servisedata").html(data);
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



      <h3 class="title1">Services Config</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <li role="presentation"><a href="<?=base_url()?>hm/hm_config/showall" id="home-tab" role="tab" aria-controls="home" aria-expanded="false">Messurements</a></li>
          <li role="presentation"><a href="<?=base_url()?>hm/hm_config/meterialview" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">Meterials</a></li>
          <li role="presentation" class="active"><a href="<?=base_url()?>hm/hm_config/config_services" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">Services</a></li>
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
                        <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/add_services" id="mytestform">

                    <div class="form-title"> Add New Service Types

              </div>
            <div class="col-md-6 validation-grids " data-example-id="basic-forms">
              <div class="form-body">
                  <label>Service Name</label>
                  <div class="form-group">
                    <input type="text" name="service_name" id="service_name" class="form-control" required>
                  </div>
                  <label>Pay Type</label>
                  <div class="form-group">
                    <input type="text" name="pay_type" id="pay_type" class="form-control" required>
                  </div>

              </div>
            </div>
            <div class="col-md-6 validation-grids " data-example-id="basic-forms">
              <div class="form-body">
                  <label>Pay Rate</label>
                  <div class="form-group">
                    <input type="number" name="pay_rate" step="0.01" id="pay_rate" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary disabled">Sumbit</button>
                 </div>
              </div>
            </div>
          </form></div>
                        <table class="table">
													 <thead> <tr> <th>No</th> <th>Service Name</th><th>Pay Type</th><th>Pay Rate</th></tr>
														 <tr>
                               <th colspan="6">
                                 <div class="search">
                                   <span class="fa fa-search"></span>
                                   <input type="text" name="search" id="search" class="form-control" autocomplete="off" onkeypress="return runScript(event,this.value)" placeholder="Service Name, Pay Type or Pay Rate" style="width: 20%;" required>
                                 </div>
                               </th>
                             </tr>
												</thead>
												<tbody id="servisedata">
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>

                         <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <td scope="row"><?=$c?></td>
												<td scope="row"><?=$row->service_name?></td>
												<td scope="row"><?=$row->pay_type?></td>
                        <td><?=$row->pay_rate?></td>
                        <td align="right"><? $statues=check_foreign_key('hm_config_taskserv',$row->service_id,'service_id');//call from hmconfig_helper
												if($statues){?>
													<a  href="javascript:check_activeflag('<?=$row->service_id?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
													<a  href="javascript:call_delete('<?=$row->service_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </td>
                         </tr>

                                <? }} ?>
                          </tbody></table>
													<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>
                  </div>
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab">

                    <p>
                    </p>
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
                    window.location="<?=base_url()?>hm/hm_config/servicetype_delete/"+document.deletekeyform.deletekey.value;
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
					service_name: {required: true},
					pay_type:{required: true},
					pay_rate:{required: true},

	},
        messages: {
            service_name: "Required",
						pay_type: "Required",
						pay_rate: "Required",

        }
});


	});
</script>
