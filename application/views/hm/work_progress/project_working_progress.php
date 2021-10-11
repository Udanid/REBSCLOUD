<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>

<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script type="text/javascript">

 $(function(){

    $("#progressform").submit(function(e){
     e.preventDefault();
     var file_array = $('#file_array').val();
     var file_array2 = $('#file_array2').val();
     var arrcount = file_array.length;
     if(arrcount==0){
       document.getElementById("checkflagmessage").innerHTML='Must Select Image/Images';
    $('#flagchertbtn').click();
     }else{
      // alert(file_array +"/////"+file_array2)
       e.currentTarget.submit();
       $('#progressbtn').disabled('true');
     }
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


function load_polist_and_project_list(id){
  console.log("inside unitlist "+id)
  $("#curprogress").html("");
   $("#lotlist").html("");
   $( "#lotlist" ).load( "<?=base_url()?>hm/hm_grn/get_project_rel_lots/"+id);
}


function load_polist(id){
   $("#curprogress").html("");
}

function load_current_progress(stageid){
  var prjid = $('#prjid').val();
  var lotid = $('#lotid').val();
  if(prjid=="" || lotid==""){
    alert("Please Select Project and LOT")
  }else{
    console.log(stageid+" "+prjid+" "+lotid)
    $("#curprogress").html("");
    $("#curprogress" ).load( "<?=base_url()?>hm/hm_work_progress/get_current_progress/"+prjid+"/"+lotid+"/"+stageid);
  }
}
function approve_progress(id){
  console.log(id)
  document.deletekeyform.deletekey.value=id;
  $('#complexConfirm_confirm').click();
}

function cancel_progress(id){
  document.deletekeyform.deletekey.value=id;
  $('#complexConfirm_subtask').click();
  console.log(id)
}
function load_stages(id){
   $("#related_code").val($("#related_code").data("default-value"));
   var lot  = id;
   var proj = $('#prjid2').val();
   $('#related_code2').empty().append('<option value=""></option>').trigger('chosen:updated');
	$.ajax({
		cache: false,
		type: 'POST',
		url: '<?php echo base_url().'hm/hm_work_progress/load_stages/';?>',
		data: {prjid: proj, lotid: lot },
		success: function(data) {
			if (data) {
			  	var x = $.parseJSON(data);
               	for (i = 0; i < x.length; i++)
                {
                   $('#related_code2').append('<option value="'+x[i].code_id+'">'+x[i].code+' - '+x[i].description+'</option>');
                }
				$('#related_code2').trigger("chosen:updated");
			}
			else
			{
				//$('#complexConfirm').click();
			}
		}
	});

   //alert(lot+" "+proj)
   $("#curprogress2").html("");
   $("#curprogress2" ).load( "<?=base_url()?>hm/hm_work_progress/get_prj_lot_rel_stages_progress/"+proj+"/"+lot);
}

function loadStages(){
	var prjid = $('#prjid').val();
	var lotid = $('#lotid').val();
	$('#related_code').empty().append('<option value=""></option>').trigger('chosen:updated');
	$.ajax({
		cache: false,
		type: 'POST',
		url: '<?php echo base_url().'hm/hm_work_progress/load_stages/';?>',
		data: {prjid: prjid, lotid: lotid },
		success: function(data) {
			if (data) {
			  	
			  	var x = $.parseJSON(data);
               	for (i = 0; i < x.length; i++)
                {
                   $('#related_code').append('<option value="'+x[i].code_id+'">'+x[i].code+' - '+x[i].description+'</option>');
                }
				$('#related_code').trigger("chosen:updated");
			}
			else
			{
				//$('#complexConfirm').click();
			}
		}
	});
}
</script>
<link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Progress Update</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
						<li role="presentation" <? if($tab=='profile'){?> class="active" <? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Update Progress</a></li>
						<li role="presentation" ><a href="#pendinglist" role="tab" id="pendinglist-tab" data-toggle="tab" aria-controls="pendinglist" aria-expanded="true">View Confirm List</a></li>
						<li role="presentation" ><a href="#listConfirm" role="tab" id="listConfirm-tab" data-toggle="tab" aria-controls="listConfirm" aria-expanded="true" onClick="loadSelect();">View Progress</a></li>

          </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px; min-height:400px;">
            <div role="tabpanel" class="tab-pane fade active in" id="profile" aria-labelledby="progress-tab" >
               <br>
                    <? $this->load->view("includes/flashmessage");?>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                        <div class="row">
                    <form data-toggle="validator" method="post" id="progressform" action="<?=base_url()?>hm/hm_work_progress/add_project_progress" >

                    <div class="form-title"> Add Progress

							</div>
						  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
							<div class="form-body">
								  <label>Project</label>
                  <div class="form-group">
                    <select class="form-control" name="prjid" id="prjid" onChange="load_polist_and_project_list(this.value)">
                      <option value=""></option>
                      <? if($prjlist){
                        foreach ($prjlist as $key => $pl) {?>
                          <option value="<?=$pl->prj_id?>"> <?=$pl->project_name?></option>
                      <?  }
                      }?>
                    </select>

                  </div>


                  <div class="form-group" id="lotlist">
                    <label>Lot</label>
                    <select class="form-control" name="lotid" id="lotid" onChange="loadStages();">

                    </select>

                  </div>

					        <label>Stage</label>
									<div class="form-group">
										<select class="form-control" name="related_code" id="related_code" required onChange="load_current_progress(this.value)">

                      
                        <option value=""></option>
                       
                    </select>

									</div>

                  <label>Current Progress</label>
                  <div class="form-group" id="curprogress">


                  </div>





							</div>
						</div>
						<div class="col-md-6 validation-grids " data-example-id="basic-forms">
							<div class="form-body">

									<label>Remarks</label>
                  <div class="form-group">
                    <textarea class="form-control" required name="progress_remark" id="progress_remark" rows="3" cols="20"></textarea>
                  </div>

									<div class="form-title">
									<h4>Upload Images</h4>
								</div>
								<div class="form-body">
                                	<!--starts residential block-->
									<div id="residential">
                                       <span id="addfiles" class="btn btn-success fileinput-button" style="width:25%;">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Select files</span>
                                            <!-- The file input field used as target for the file upload widget -->
                                            <input id="fileupload" type="file" name="files[]" multiple>
                                            <div id="deletearr">
                                              <input type="hidden" name="file_array" id="file_array">
                                              <input type="hidden" name="file_array2" id="file_array2">

                                            </div>
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
                  <div class="form-group">

                    <button type="submit" class="btn btn-primary disabled" id="progressbtn">Submit</button>

                  </div>

							</div>
						</div>
					</form></div>

                    </div>
               </div>
							 <div role="tabpanel" class="tab-pane fade" id="pendinglist" aria-labelledby="pendinglist-tab">
	 									 <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
	 										 <?=$this->load->view('hm/work_progress/project_progress_confirm_view');?>
	 										</div>

	 					</div>
	 						<!--PENDING REQUEST LIST CONFIRMVIEW-->
	 						<div role="tabpane2" class="tab-pane fade <? if($tab=='listConfirm'){?> active in <? }?>" id="listConfirm" aria-labelledby="list-tab">
	 									 <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
											 <?=$this->load->view('hm/work_progress/working_progress_list');?>
	 										</div>

	 					</div>
            </div>
         </div>
      </div>
<!--load gallery images-->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-load-image/2.18.0/load-image.all.min.js"></script>
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

  $("#prjid").chosen({
    allow_single_deselect : true,
	placeholder_text_single: "Select Project",
	width: '100%'
  });
	$("li.active a#listConfirm-tab .prjid").chosen({
    allow_single_deselect : true
  });

  $("#related_code").chosen({
    allow_single_deselect : true,
	placeholder_text_single: "Select Stage",
	width: '100%'
  });

	var file_list = [];
  var curtime = $.now();
  $('#deletemsg').html('');
'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '<?=base_url()?>uploads/project_progress/',
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
        //$("#file_array2").val(file_list);
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

//............. get previous deleted image names......................
    var file_list2 = [];
    var prevdelimages = $('#file_array2').val();
    var arrlength = prevdelimages.length;
    if(arrlength>0){

      //create for loop for push names to array.
      var i;
      for(i=0;i<arrlength;i++){
        file_list2.push(prevdelimages[i]);
      }

      $("#file_array2").val(file_list2);

    }
//.............. get previous deleted image names......................

    $('#files').on('click', 'a.delete', function (e) {
      e.preventDefault();

      var file_list = [];

      $("#file_array").val(file_list);

      $("a.delete").each(function() {
        var $link = $(this);
        var filenames = $(this).data('filename');

        file_list2.push(filenames);
        $("#file_array2").val(file_list2);

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

         $('#progress .progress-bar').css(
                'width',
                0 + '%'
            );
      })

         //file_list.push(1);

         $("#files").html('');
         $("#files").val('');
         $("#fileupload").html('');
         $("#fileupload").val('');

    });
//.........................end file upload process jquery ............................................
  </script>
						<script type="text/javascript">

						      $("#complexConfirm_confirm").confirm({
						                title:"Project Progress confirmation",
						                text: "Are You sure you want to confirm This Project Progress ?" ,
						        headerClass:"modal-header confirmbox_green",
						                confirm: function(button) {
						                    button.fadeOut(2000).fadeIn(2000);
						                    var id = document.deletekeyform.deletekey.value;
						                    progress_appr_disapprove(id,1);
						                },
						                cancel: function(button) {
						                    button.fadeOut(2000).fadeIn(2000);
						                   // alert("You aborted the operation.");
						                },
						                confirmButton: "Yes I am",
						                cancelButton: "No"
						            });

						            $("#complexConfirm_subtask").confirm({
						                title:"Project Progress Cancel",
						                text: "Are You sure you want to Cancel This Project Progress ?" ,
						        headerClass:"modal-header",
						                confirm: function(button) {
						                    button.fadeOut(2000).fadeIn(2000);
						                    var id = document.deletekeyform.deletekey.value;
						                    progress_appr_disapprove(id,2);
						                },
						                cancel: function(button) {
						                    button.fadeOut(2000).fadeIn(2000);
						                   // alert("You aborted the operation.");
						                },
						                confirmButton: "Yes I am",
						                cancelButton: "No"
						            });

						      function progress_appr_disapprove(id,stts){
						          $.ajax({
						                cache: false,
						                type: 'GET',
						                url: '<?php echo base_url()?>hm/hm_work_progress/progress_approve_disapprove_process',
						                data: {'id':id,'stts':stts},
						                success: function(data) {
						                   console.log("return value is "+data)

						                   $(base).html('');
						                   if(data==1){
						                    //alert("Approved")
						                         var base = '#actions'+id;
						                         $(base).html('');
						                         $(base).append('Approved  <i class="fa fa-check nav_icon icon_green"></i>');
						                   }else if(data==2){
						                    //alert("Cancelled")
						                         var res = id.split('_');
						                         var ids = res[0];
						                         var base = '#actions'+ids;
						                         $(base).html('');
						                         $(base).append('Cancelled <i class="fa fa-times nav_icon icon_red"></i>');
						                   }else{
						                      document.getElementById("checkflagmessage").innerHTML='Error in Process Approve/Disapprove';
						                      $('#flagchertbtn').click();
						                   }
						                       //$("#grntotallist").html('');

						                }
						            });
						            }

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
