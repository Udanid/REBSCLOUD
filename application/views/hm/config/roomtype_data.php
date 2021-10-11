<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
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
            data: {table: 'cm_tasktype', id: id,fieldname:'roomtype_id' },
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
            data: {table: 'hm_config_roomtypes', id: id,fieldname:'roomtype_id' },
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
					$( "#popupform" ).load( "<?=base_url()?>hm/hm_config/edit_roomtypes/"+id );
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
            data: {table: 'hm_config_roomtypes', id: id,fieldname:'mt_id' },
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
				url: '<?php echo base_url().'hm/hm_config/search_rooms';?>',
				data: {string:val },
				success: function(data) {
					$("#roomsdata").html('');
					$("#roomsdata").html(data);
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



      <h3 class="title1">Room Type Config</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
             <!-- <li role="presentation"><a href="<?=base_url()?>hm/hm_config/config_designtypes" id="home-tab" role="tab" aria-controls="home" aria-expanded="false">Design Types</a></li> -->
						<li role="presentation">
					<a href="<?=base_url()?>hm/hm_config/showfloor" id="home-tab" role="tab" aria-controls="home" aria-expanded="false">Floors List</a></li>
					<li role="presentation"><a href="<?=base_url()?>hm/hm_config/showfloor#profile" id="home-tab" role="tab" aria-controls="home" aria-expanded="false">Add New Floor</a></li>

					<li role="presentation" class="active"><a href="<?=base_url()?>hm/hm_config/config_roomtypes" id="rooms-tab" role="tab" aria-controls="rooms" aria-expanded="false">Room Types</a></li>

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
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/add_roomtypes" id="mytestform">

                    <div class="form-title"> Add New Room Types

              </div>
            <div class="col-md-6 validation-grids " data-example-id="basic-forms">
              <div class="form-body">
                  <label>Room Name</label>
                  <div class="form-group">
                    <input type="text" name="room_name" id="room_name" class="form-control" required>
                  </div>
                  <label>Length</label>
                  <div class="form-group">
                    <input type="number" step="0.01" name="lenth" id="lenth" class="form-control" required>
                  </div>


              </div>
            </div>
            <div class="col-md-6 validation-grids " data-example-id="basic-forms">
              <div class="form-body">
                  <label>Height</label>
                  <div class="form-group">
                    <input type="number" step="0.01" name="height" id="height" class="form-control" required>
                  </div>
                  <label>Width</label>
                  <div class="form-group">
                    <input type="number" step="0.01" name="width" id="width" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary disabled">Submit</button>
                  </div>
              </div>
            </div>
          </form></div>
                        <table class="table"> <thead> <tr> <th>No</th> <th>Room Type Name</th><th>Length</th><th>Height</th><th>Width</th></tr>
													<tr>
														<th colspan="6">
															<div class="search">
																<span class="fa fa-search"></span>
																<input type="text" name="search" id="search" class="form-control" autocomplete="off" onkeypress="return runScript(event,this.value)" placeholder="Rooms Name" style="width: 20%;" required>
															</div>
														</th>
													</tr>
												 </thead>
													<tbody id="roomsdata">
										  <? if($datalist){$c=0;
                          foreach($datalist as $row){?>

                         <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <td scope="row"><?=$c?></td>
												<td><?=$row->roomtype_name?></td>
												<td><?=$row->def_length?></td>
                        <td><?=$row->def_height?></td>
												<td><?=$row->def_width?></td>

                        <td align="right"><? $statues=check_foreign_key('hm_config_floorrooms',$row->roomtype_id,'roomtype_id');//call from hmconfig_helper
                         if($statues){?>
													<a  href="javascript:check_activeflag('<?=$row->roomtype_id?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
	                        <a  href="javascript:call_delete('<?=$row->roomtype_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </td>
                         </tr>

                                <? }} ?>
                          </tbody></table>
													<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>

                    </div>
                  </div>
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="rooms-tab">

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
                    window.location="<?=base_url()?>hm/hm_config/roomtypes_delete/"+document.deletekeyform.deletekey.value;
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
					room_name: {required: true},
					lenth:{required: true},
					height:{required: true},
					width:{required: true},
				},
        messages: {
            room_name: "Required",
						lenth: "Required",
						height: "Required",
						width: "Required",
        }
});


	});
</script>
