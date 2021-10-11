<!DOCTYPE HTML>
<html>
<head>

<?
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_customer");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(function(){
  $("#messure_type").focus(function() {
  	$("#messure_type").chosen({
       allow_single_deselect : true
    });
  });
  //validate all fields
      $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
      $("#mytestform").validate({
            rules: {
        meterial_code: {
              required: true
           },
        meterial_name: {
              required: true
           },
        messure_type: {
              required: true
            },
        meterial_desc: {
          required: true
            },
      },
        messages: {
            meterial_code: "Required",
            meterial_name: "Required",
            messure_type: "Required",
            meterial_desc: "Required",

        }
});

});

function update_meterial(id)
{

    // var vendor_no = src.value;
//alert(id);

    $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_config_material', id: id,fieldname:'mat_id' },
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
          $( "#popupform" ).load( "<?=base_url()?>hm/hm_config/meterial_edits/"+id );
        }
            }
        });
}


function check_activeflag(id)
{

// var vendor_no = src.value;
//alert(id);

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
$('#popupform').delay(1).fadeIn(600);
$( "#popupform" ).load( "<?=base_url()?>config/producttasks/edit/"+id );
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
            data: {table: 'cm_tasktype', id: id,fieldname:'task_id' },
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

function call_confirm(id)
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
$('#complexConfirm_confirm').click();
}
            }
        });


//alert(document.testform.deletekey.value);

}
function runScript(e,val) {
		//detect enter key and run the function
		if (e.keyCode == 13) {
			var tb = document.getElementById("search");
			//eval(tb.value);
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'hm/hm_config/search_material';?>',
				data: {string:val },
				success: function(data) {
					$("#meterialdata").html('');
					$("#meterialdata").html(data);
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



      <h3 class="title1">Meterial Types</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="<?=base_url()?>hm/hm_config/showall" id="home-tab" role="tab" aria-controls="home" aria-expanded="false">Messurements</a></li>
          <li role="presentation" class="active"><a href="<?=base_url()?>hm/hm_config/meterialview" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">Meterials</a></li>
          <li role="presentation"><a href="<?=base_url()?>hm/hm_config/config_services" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">Services</a></li>
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

                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/add_new_meterial" id="meterialform">
                <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">

                    <label>Meterial Code</label>
                    <div class="form-group">
                    <input type="text" name="meterial_code" id="meterial_code" class="form-control" required>
                    </div>

                    <label>Meterial Name</label>
                    <div class="form-group">
                    <input type="text" name="meterial_name" id="meterial_name" class="form-control" required>
                    </div>

                    <label>Messurement Type</label>
                    <div class="form-group">
                    <select id="messure_type" name="messure_type" class="form-control" required>
                      <option >Select Mesurement</option>
                      <?
                      if($messures)
                      {
                       foreach($messures as $msrs){
                       ?>
                         <option value="<?=$msrs->mt_id;?>"><?=$msrs->mt_name;?></option>
                       <?
                       }
                      }
                      ?>

                    </select>
                    </div>

                    </div>
                  </div>
                  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">

                    <label>Description</label>
                    <div class="form-group">

                    <textarea name="meterial_desc" id="meterial_desc" class="form-control" required rows="4" cols="20"></textarea>
                    </div>

                    <div class="form-group">
                    <button type="submit" class="btn btn-primary">Sumbit</button>
                    </div>
                  </div>
                </div>
</form></div>
                        <table class="table">

                          <thead>
                            <tr>
                              <th></th>
                              <th>Meterial code</th>
                              <th>Meterial Name</th>
                              <th>Mesurement</th>
                              <th>Description</th>
                              <th></th>
                            </tr>
                            <tr>
                              <th colspan="6">
                                <div class="search">
                                  <span class="fa fa-search"></span>
                                  <input type="text" name="search" id="search" class="form-control" autocomplete="off" onkeypress="return runScript(event,this.value)" placeholder="Meterial code or Meterial Name" style="width: 20%;" required>
                                </div>
                              </th>
                            </tr>
                          </thead>
                          <tbody id="meterialdata">

                      <? if($meterial){$c=0;
                          foreach($meterial as $met){?>

                         <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                            <th scope="row"><?=$c?></th>
                            <td><?=$met->mat_code ?></td>
                            <td><?=$met->mat_name ?></td>
                            <td><?=$met->mt_name ?></td>
                            <td><?=$met->description ?></td>
                            <td align="right">
                              <? $statues=check_foreign_key('cm_suppliermaterial',$met->mat_id,'mat_id');//call from hmconfig_helper
                              $statues2=check_foreign_key('hm_config_taskmat',$met->mat_id,'mat_id');//call from hmconfig_helper
                              $statues3=check_foreign_key('hm_prjfboqmaterial',$met->mat_id,'mat_id');//call from hmconfig_helper
                              $statues4=check_foreign_key('hm_po_request',$met->mat_id,'mat_id');//call from hmconfig_helper
                              if($statues && $statues2 && $statues3 && $statues4){?>
      													<a  href="javascript:update_meterial('<?=$met->mat_id?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a></td>
                                  <? }?>
                         </tr>

                                <? }} ?>
                          </tbody></table>
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>
                  </div>
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab">

                    <p>
                    <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/add_new_meterial" id="meterialform">

                    <div class="form-title"> Add New Messure Types

                  </div>
                  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">

                    <label>Meterial Code</label>
                    <div class="form-group">
                    <input type="text" name="meterial_code" id="meterial_code" class="form-control" required>
                    </div>

                    <label>Meterial Name</label>
                    <div class="form-group">
                    <input type="text" name="meterial_name" id="meterial_name" class="form-control" required>
                    </div>

                    <label>Messurement Type</label>
                    <div class="form-group">
                    <select id="messure_type" name="messure_type" class="form-control" required>
                      <option value="">Select Mesurement</option>
                      <?
                      if($messures)
                      {
                       foreach($messures as $msrs){
                       ?>
                         <option value="<?=$msrs->mt_id;?>"><?=$msrs->mt_name;?></option>
                       <?
                       }
                      }
                      ?>

                    </select>
                    </div>

                    <label>Description</label>
                    <div class="form-group">

                    <textarea name="meterial_desc" id="meterial_desc" class="form-control" required rows="4" cols="20"></textarea>
                    </div>

                    <div class="form-group">
                    <button type="submit" class="btn btn-primary disabled">Sumbit</button>
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
