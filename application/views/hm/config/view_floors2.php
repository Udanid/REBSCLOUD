view_floors<!DOCTYPE HTML>
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

</script>
<link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">
<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Floors Types</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Floors List</a></li>
          <li role="presentation"><a href="#profile" id="profile-tab" role="tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">Add New Floor</a></li>
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

                        <table class="table"> 
                          <thead> 
                            <tr>
                              <th></th> 
                              <th>Design</th>
                              <th>Floor name</th>
                              <th>No: of Bedrooms</th>
                              <th>No: of bathrooms</th>
                              <th>Total Extend</th>
                            </tr> 
                          </thead>
                      
                        <tbody>
                            
                          </tbody></table>
                          
                    </div>
                  </div>
                <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab">

                    <p>
                    <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/add_new_meterial" id="meterialform">

                    <div class="form-title"> Add New Floor

                  </div>
                  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">

                    <label>Design Type</label>
                    <div class="form-group">
                    <select id="designtype" name="designtype" class="form-control" required>
                      <option value="">Select Design Type</option>
                      <?
                      if($designtypes)
                      {
                       foreach($designtypes as $dt){
                       ?>
                         <option value="<?=$dt->design_id;?>"><?=$dt->prjtype_name;?>-><?=$dt->design_name;?>(<?=$dt->short_code;?>)</option>
                       <?
                       }
                      } 
                      ?>
                      
                    </select>
                    </div>

                    <label>Floor Name</label>
                    <div class="form-group">
                    <input type="text" name="floorname" id="floorname" class="form-control" required>
                    </div>

                    <label>No of Bedrooms</label>
                    <div class="form-group">
                    <input type="text" name="noof_bedrooms" id="noof_bedrooms" class="form-control" required>
                    </div>

                    <label>No of Bathrooms</label>
                    <div class="form-group">
                    <input type="text" name="noof_bathrooms" id="noof_bathrooms" class="form-control" required>
                    </div>

                    <label>Total Extend</label>
                    <div class="form-group">
                    <input type="text" name="totext" id="totext" class="form-control" required>
                    </div>

                    <div class="form-group">
                    <button type="submit" class="btn btn-primary disabled">Sumbit</button>
                    </div>
                  </div>
</div>
<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
								<div class="form-title">
									<h4>Upload Floor Image</h4>
								</div>
								<div class="form-body">
                                	<!--starts residential block-->
									<div id="residential">
                                       <span id="addfile" class="btn btn-success fileinput-button" style="width:25%;">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Add file</span>
                                            <!-- The file input field used as target for the file upload widget -->
                                            <input id="fileupload" type="file" name="files[]" required>
                                            <input type="hidden" name="id_copy_front" id="id_copy_front">
                                            <div id="upfiles" class="upfiles"></div>
                                        </span>

                                        <!-- The global progress bar -->
                                        <div id="progress" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <!-- The container for the uploaded files -->
                                        <div id="files" class="files" style="width:25%;"></div>
                                    </div>
                                    <!--ends residential block-->
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
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?=base_url()?>media/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?=base_url()?>media/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-validate.js"></script>

<script>

//........................jquery file upload process...........................
        'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '<?=base_url()?>uploads/temp/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });

        $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i,
        maxFileSize: 999000,
		//maxNumberOfFiles: 5,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true,
		done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                //.text('Upload')
				.hide()
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
		$("#addfile").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
				$("#id_copy_front").val(file.name);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
//.......................ending jquery file upload porcess.....................


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
