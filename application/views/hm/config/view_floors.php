<!DOCTYPE HTML>
<html>
<head>
<script src="<?=base_url()?>media/js/jquery-1.11.1.min.js"></script>
<?
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>

<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>

<script type="text/javascript">
$(document).ready( function() {
  
   var activeTab = window.location.hash;
   //alert(activeTab)
   if (activeTab) {

      $(activeTab+"-tab").click();



   }
});
$(function(){

  //validate all fields
      $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
      $("#floorform").validate({
            rules: {
        designtype: {
              required: true
           },
        floorname: {
              required: true
           },
        noof_bedrooms: {
              required: true,
              number: true
            },
        noof_bathrooms: {
             required: true,
             number: true
            },
        totext: {
             required: true,
             number: true
            }
      },
        messages: {
            designtype:{
              required: "Required",
            },

            floorname: {
              required: "Required",
            },

            noof_bedrooms: {
              required: "Required",

            },

            meterial_desc: {
              required: "Required",

            },

            totext: {
              required: "Required",

            }

        }
});
$('#formcount').val(1);
var ol_max_subjects = 10; //maximum input boxes allowed
  var ol_wrapper = $(".ol_input_fields_wrap"); //Fields wrapper
  var ol_add_button = $(".add_ol_subject_button"); //Add button ID

  var olCount = 1; //initlal text box count
  $(ol_add_button).click(function(e){ //on add input button click
    e.preventDefault();
    if(olCount < ol_max_subjects){
      $(ol_wrapper).append('<div class="emp_rows col-xs-12"><div class="col-md-6 validation-grids " data-example-id="basic-forms"><div class="form-body"><label>Room Type</label><div class="form-group">\
                    <select id="froomtypes" name="floorroom['+olCount+'][froomtypes]" class="form-control froomtypes" required>\
                      <option value="">Select Room Type</option>\
                      <?
                      if($roomtypelist)
                      {
                       foreach($roomtypelist as $rtyp){
                       ?>
                         <option value="<?=$rtyp->roomtype_id;?>"><?=$rtyp->roomtype_name;?></option>\
                       <?
                       }
                      }
                      ?></select></div>\
                    <label>Width(ft)</label>\
                    <div class="form-group">\
                    <input type="text" name="floorroom['+olCount+'][fwidth]" id="fwidth" class="form-control" required>\
                    </div>\
                    <label>Height(ft)</label>\
                    <div class="form-group">\
                    <input type="text" name="floorroom['+olCount+'][fheight]" id="fheight" class="form-control" required>\
                    </div>\
                    <label>Length(ft)</label>\
                    <div class="form-group">\
                    <input type="text" name="floorroom['+olCount+'][flenght]" id="flenght" class="form-control" required>\
                    </div>\
                  </div>\
                  </div>\
                  <div class="col-md-6 validation-grids " data-example-id="basic-forms">\
                  <div class="form-body">\
                    <label>Total Extend(sq ft)</label>\
                    <div class="form-group">\
                    <input type="text" name="floorroom['+olCount+'][ftotext]" id="ftotext" class="form-control" required>\
                    </div>\
                    <label>Doors</label>\
                    <div class="form-group">\
                    <input type="text" name="floorroom['+olCount+'][fdoors]" id="fdoors" class="form-control" required>\
                    </div>\
                    <label>Windows</label>\
                    <div class="form-group">\
                    <input type="text" name="floorroom['+olCount+'][fwindows]" id="fwindows" class="form-control" required>\
                    </div>\
                    </div>\
                    <a href="#" class="remove_field btn btn-danger">Remove</a>\
                    </div>\
                    </div>'); //add input box
      olCount++; //text box increment

    }
    console.log("add new forms count "+olCount)
    $('#formcount').val(olCount);
  });

  $(ol_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault();
    $(this).parent('div').parent('div').remove(); olCount--;
    var curformcount = $('#formcount').val();
    var newformcount = curformcount-1;
    $('#formcount').val(newformcount);
  })

});

function viewfloorimages(id)
{
 $('#popupform').delay(1).fadeIn(600);
 $( "#popupform" ).load( "<?=base_url()?>hm/hm_config/view_floor_images/"+id);
}

function update_floor(id){
   $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_config_floors', id: id,fieldname:'floor_id' },
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
          $( "#popupform" ).load( "<?=base_url()?>hm/hm_config/floor_edits/"+id );
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
				url: '<?php echo base_url().'hm/hm_config/search_floors';?>',
				data: {string:val },
				success: function(data) {
					$("#floorsdata").html('');
					$("#floorsdata").html(data);
				}
			});
		}
	}
function activateChosen(){
	setTimeout(function(){
    	$("#designtype").chosen({
        	allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Design Type"
    	});

    	$(".froomtypes").chosen({
        	allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Room Type"
     	});
	}, 800);
}

function getDimensions(val){
	$.ajax({
		cache: false,
		type: 'POST',
		url: '<?php echo base_url().'hm/hm_config/get_room_dimensions';?>',
		data: {room_id:val },
		success: function(data) {
			$("#dimensions").html('');
			$("#dimensions").html(data);
		}
	});	
}
</script>
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Floors Types</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Floors List</a></li>
          <li role="presentation"><a href="#profile" id="profile-tab" role="tab" data-toggle="tab" aria-controls="profile" aria-expanded="false" onClick="activateChosen();">Add New Floor</a></li>
          <li role="presentation"><a href="<?=base_url()?>hm/hm_config/config_roomtypes" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">Room Types</a></li>

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
                              <th>Design Type</th>
                              <th>Floor name</th>
                              <th>No: of Bedrooms</th>
                              <th>No: of bathrooms</th>
                              <th>Total Extent(sq ft)</th>
                              <th></th>
                            </tr>
                            <tr>
                              <th colspan="7">
                                <div class="search">
                                  <span class="fa fa-search"></span>
                                  <input type="text" name="search" id="search" class="form-control" autocomplete="off" onkeypress="return runScript(event,this.value)" placeholder="Floor Name Or Design Name" style="width: 20%;" required>
                                </div>
                              </th>
                            </tr>
                          </thead>

                        <tbody id="floorsdata">
                             <? if($floorlist){$c=0;
                          foreach($floorlist as $fl){?>

                         <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                            <th scope="row"><?=$c?></th>
                            <td><?=$fl->short_code?> - <?=$fl->design_name?></td>
                            <td><?=$fl->floor_name?></td>
                            <td><?=$fl->num_of_bedrooms?></td>
                            <td><?=$fl->num_of_bathrooms?></td>
                            <td><?=$fl->tot_ext?></td>
                            <td align="right"><div id="checherflag">

                        <a  href="javascript:viewfloorimages('<?=$fl->floor_id?>')" title="Floor Image View"><i class="fa fa-eye nav_icon icon_green"></i></a>
                        <? $statues=check_foreign_key('hm_config_boqcat',$fl->design_id,'design_id');//call from hmconfig_helper
                        if($statues){?>
                        <a  href="javascript:update_floor('<?=$fl->floor_id?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a></td>
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
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/add_floors" id="floorform">

                    <div class="form-title"> Add New Floor

                  </div>
                  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">

                    <label>Design Type</label>
                    <div class="form-group">
                    <select id="designtype" name="designtype" class="form-control" required>
                      <option value=""></option>
                      <?
                      if($designtypes)
                      {
                       foreach($designtypes as $dt){
                       ?>
                         <option value="<?=$dt->design_id;?>"><?=$dt->prjtype_name;?>-><?=$dt->design_name;?>(<?=$dt->scode;?>)</option>
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

                    <label>Total Extent(sq ft)</label>
                    <div class="form-group">
                    <input type="text" name="totext" id="totext" class="form-control" required>
                    </div>
  <!-- ...................................add multiple floor rooms......................................-->
                    <input type="hidden" id="formcount" name="formcount">
                    <div class="form-title">
                      <h4>Add New Floor Room:
                    <span  style="float:right">
                    <button class="add_ol_subject_button btn btn-success" style="margin-top:-10px;">(+) Add </button></span></h4>
                   </div>

                   <div class="form-body">
                        <div class="form-group ol_input_fields_wrap">
                        <div class="emp_rows col-xs-12">
                         <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">

                    <label>Room Type</label>
                    <div class="form-group">
                    <select id="froomtypes" name="floorroom[0][froomtypes]" class="form-control froomtypes" onChange="getDimensions(this.value);" required>
                      <option value=""></option>
                      <?
                      if($roomtypelist)
                      {
                       foreach($roomtypelist as $rtyp){
                       ?>
                         <option value="<?=$rtyp->roomtype_id;?>"><?=$rtyp->roomtype_name;?></option>
                       <?
                       }
                      }
                      ?>

                    </select>
                    </div>
					<div id="dimensions">
                        <label>Width(ft)</label>
                        <div class="form-group">
                        <input type="text" name="floorroom[0][fwidth]" id="fwidth" class="form-control" required>
                        </div>
    
                        <label>Height(ft)</label>
                        <div class="form-group">
                        <input type="text" name="floorroom[0][fheight]" id="fheight" class="form-control" required>
                        </div>
    
                        <label>Length(ft)</label>
                        <div class="form-group">
                        <input type="text" name="floorroom[0][flenght]" id="flenght" class="form-control" required>
                        </div>
					</div>

                  </div>
                  </div>
                  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">


                    <label>Total Extent(sq ft)</label>
                    <div class="form-group">
                    <input type="text" name="floorroom[0][ftotext]" id="ftotext" class="form-control" required>
                    </div>

                    <label>Doors</label>
                    <div class="form-group">
                    <input type="text" name="floorroom[0][fdoors]" id="fdoors" class="form-control" required>
                    </div>

                    <label>Windows</label>
                    <div class="form-group">
                    <input type="text" name="floorroom[0][fwindows]" id="fwindows" class="form-control" required>
                    </div>
                   </div>
                  </div>
                </div>
              </div>
            <div class="clearfix"> </div><br>
          </div>
<!-- ...................................add multiple floor rooms............................................-->
                  </div>
</div>
<div class="col-md-6 validation-grids validation-grids-right">
              <div class="widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                  <h4>Upload Floor Images</h4>
                </div>
                <div class="form-body">
                                  <!--starts residential block-->
                  <div id="residential">
                                       <span id="addfiles" class="btn btn-success fileinput-button" style="width:25%;">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Select files</span>
                                            <!-- The file input field used as target for the file upload widget -->
                                            <input id="fileupload" type="file" name="files[]" multiple>
                                            <input type="hidden" name="file_array" id="file_array">
                                        </span>
                                        <br /><br />
                                        <!-- The global progress bar -->
                                        <div id="progress" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <p id="deletemsg"></p>
                                        <!-- The container for the uploaded files -->
                                        <div id="files" class="files" style="width:25%;"></div>
                                    </div>
                                    <!--ends residential block-->
                                </div>
                                <br><br>
                                <div class="form-group">
                            <button type="submit" class="btn btn-primary disabled">Submit</button>
                        </div>
                             </div>
            </div>
</form></div></p>
                </div>




            </div>
         </div>
      </div>

<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
          <div class="slides"></div>
          <h3 class="title"></h3>
          <a class="prev">‹</a>
          <a class="next">›</a>
          <a class="close">×</a>
          <a class="play-pause"></a>
          <ol class="indicator"></ol>
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
//...........................file upload processs jquery .............................................
$(function(){
  var file_list = [];
  var curtime = $.now();
  $('#deletemsg').html('');
'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '<?=base_url()?>uploads/floor_img/',
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
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf|PDF|plain|doc|docx|xls|xlsx|csv)$/i,
    //previewFileTypes: /^.*\/(gif|jpe?g|png|pdf|PDF|plain|doc|docx)$/,
        maxFileSize: 50000000,
    // maxNumberOfFiles: 10,
    // singleFileUploads: false,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: false,
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" data-filename="'+file.name+'" title="Delete"> Delete All</a>').appendTo('#files');
            });
        }
    }).on('fileuploadadd', function (e, data) {

        data.context = $('<div class="11">').appendTo('#files');
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
        $('#deletemsg').html('');
        console.log(data)
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node.prepend('<br>').prepend(file.preview);
           // node.prepend('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" data-filename="'+file.name+'" title="Delete">'+file.name+' Delete</a>');
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
    $("#addfiles").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);

        file_list.push(file.name);
        $("#file_array").val(file_list);
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

  //Load blueimp image gallery on click
  document.getElementById('files').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
      link = target.src ? target.parentNode : target,
      options = {index: link, event: event},
      links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
  };
});

//remove file when click delete
    $('#files').on('click', 'a.delete', function (e) {
      e.preventDefault();

      $("a.delete").each(function() {
        var $link = $(this);
        var filenames = $(this).data('filename');
        var req = $.ajax({
        dataType: 'json',
        url: $link.data('url'),
        type: 'DELETE'
        });

        req.success(function () {
        $link.closet('p').remove();
        });


        $("#addfiles").show();
        $('#deletemsg').html("All Images Removed Succesfully");
         //$( "p" ).eq(filenames).removeClass('');
        // $link.html(filenames+' Deleted');
         //filenames.html('');
         //$('div.'+filenames).hide();

         $("#files").html('');



         $('#progress .progress-bar').css(
                'width',
                0 + '%'
            );
      })


    });
//.........................end file upload process jquery ............................................


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
