<head>
    <style type="text/css">
        img{
            width: 10%;
        }
    </style>

</head>

<script type="text/javascript">
//validation
function validateForm(){
    var pre_val= parseInt($("#hidden_progress").val());
    var curent_val=parseInt($("#subt_progress").val());
    if(curent_val > pre_val && curent_val<=100){
        $("#submit-but").click();
    }
    else{
        $("#validation_subt_progress").text("Progress should be greater than "+pre_val);
        $("#subt_progress").val(pre_val);
    }
}
//end validation

$(document).keypress(function (e) {
    if (e.which == 13) {
        var pre_val= parseInt($("#hidden_progress").val());
        var curent_val=parseInt($("#subt_progress").val());
        
        if(curent_val >= pre_val && curent_val<=100){
            $("#submit-but").click();
        }else{
            $("#validation_subt_progress").text("Progress should be greater than "+pre_val);
            $("#subt_progress").val(pre_val);
        }
    }
});

$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });
});

</script>

<h4>Task Progress Update<span  style="float:right; color:#FFF" ><a href="javascript:close_updateprograss('')"><i class="fa fa-times-circle "></i></a></span></h4>

<div class="table widget-shadow">
 	<div class="row">
        <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
            <div class="form-title">
                <h5>Task Details</h5>
            </div>
            <div class="form-body">
            	<div class="form-group">

                    <strong class="redtext">Project Name :</strong> 
                    <?=$details->prj_name?>             
                </div>

                <div class="form-group">
                    <strong class="redtext">Task Name :</strong> 
                    <?=$details->task_name?>             
                </div>

                <div class="form-group">
                    <strong class="redtext">Sub Task Name :</strong> 
                    <?=$details->subt_name?>               
                </div> 

                <div class="form-group">
                    <strong class="redtext">Task Created By :</strong> 
                    <?=$details->initials_full?>               
                </div>
                
                <div class="form-group">
                    <strong class="redtext">Created Date :</strong> 
                    <?=$details->subt_createdate?>                
                </div>

                <div class="form-group">
                    <strong class="redtext">Duration :</strong> 
                    <?=$details->subt_duration?> Days               
                </div>          
               
                <div class="form-group bg-yellow-100 p-4">
                	<br>
                    <strong class="redtext">Description :</strong>
                    <br>
                    <p><?=$details->sub_description?></p>           
                    <br><br>
                </div>
                <div class="form-group" style="border-top:1px solid #999;">
                	<strong class="redtext">Attachments :</strong>
                    <? 
                        if($attachments){ 
                            foreach ($attachments as $row) { ?>
                               <a href="<?=base_url()?><?= $row->file_path ?>" target="_blank"><?= $row->file_name ?>,</a>                          
                       <? }}

                    ?>
                    <br>
                </div>
            </div>
       </div>
       <div class="col-md-6 validation-grids validation-grids-right">
            <div class="widget-shadow" data-example-id="basic-forms"> 
                <div class="form-title">
                    <h5>Update Progress</h5>
                </div>
                <div class="form-body">
                    <form data-toggle="validator" id="action_form" name="action_form" method="post" action="<?=base_url()?>wip/subtask/update_prograss" enctype="multipart/form-data" novalidate="novalidate">
                        <input type="hidden" class="form-control" name="subt_id" id="subt_id" data-error="" value="<?=$details->subt_id?>">
                        <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$details->task_id?>">

                        <input type="hidden" class="form-control" name="task_assign" id="task_assign" data-error="" value="<?=$details->task_assign?>">
                        
                        <div class="form-group" id="email-block">
                            <label>Progress</label>
                            <input type="number" class="form-control" min="<?=$details->subt_progress?>" max="100" id="subt_progress" name="subt_progress" autocomplete="off" data-error="" required="" value="<?=$details->subt_progress?>">
                            <span class="help-block with-errors" id="validation_subt_progress" style="color: red;font-size: 14px;"></span>
                            <input type="hidden" id="hidden_progress" name="hidden_progress" value="<?=$details->subt_progress?>">
                        </div>

                        <div class="form-group" id="email-block">
                            <label>Comment</label>
                            <textarea class="form-control" id="subt_comment" name="subt_comment" rows="2" placeholder="Comment"><?=$details->subt_comment?></textarea>
                        </div>                                        
                          
                        <div class="form-group" id="attachment-block">
                        	<label>Attachments</label>                          

                            <input type="file" name="files[]" id="gallery-photo-add" multiple>
                            <div class="gallery"></div>
                            
                            <br><br>
                            <!-- The global progress bar -->
                            
                            <div id="progress" class="progress progress-striped active">
                              <?php if($details->subt_progress>50){ ?>
                                <div class="progress-bar progress-bar-success" style="width: <?=$details->subt_progress?>%">                                                  
                              </div>
                             <? }else{ ?>
                                <div class="bar red" style="width:<?=$details->subt_progress?>%;"></div>
                             <? } ?>                         
                            </div>

                            <br>
                            <!-- The container for the uploaded files -->
                            <div id="files3" class="files3"></div>
                      	</div>
                        
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-4">
                                    <button type="button" id="btnsubmit" onclick="validateForm();" class="btn btn-primary disabled">Submit</button>
                                	<button type="submit" id="submit-but" style="width:40%; float:right;display: none;" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="col-2">
                                </div>
                                <div class="col-4"></div>
                            </div>
                        </div>
                    </form>
                   	
                    <div class="clearfix"> </div> 
                </div>
           </div>
       </div>
       <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
          <? 
          if($comments){?> 
             <table class="table"> 
                <thead> 
                    <tr>
                        <th>Date</th> 
                        <th>Progress</th> 
                        <th>Comments</th>
                    </tr> 
                </thead> 
                <tbody>
                    <?foreach ($comments as $row) {?>
                        <tr>
                            <td><?=$row->updated_date?></td>
                            <td><?=$row->cmnt_progress?>%</td>
                            <td><?=$row->comment?></td>
                        </tr>                       
                        <?       
                    }?>
                </tbody>
            </table>
            <?}?>
        </div>
   </div>
<!--ends widget-shadow-->
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

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
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
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

    $('#fileupload2').fileupload({
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
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files2');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files2');
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
                .hide()
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress2 .progress-bar').css(
            'width',
            progress + '%'
        );
        $("#addfile2").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);

                $(data.context.children()[index])
                    .wrap(link);
                $("#id_copy_back").val(file.name);

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
        //end file upload 2
    $('#fileupload3').fileupload({
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
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files3');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files3');
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
                .hide()
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress3 .progress-bar').css(
            'width',
            progress + '%'
        );
        $("#addfile3").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);

                $(data.context.children()[index])
                    .wrap(link);
                $("#customer_photo").val(file.name);
                $("#webcamimage").val('');

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
        //end file upload 3
    $('#fileupload4').fileupload({
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
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files4');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files4');
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
                .hide()
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress4 .progress-bar').css(
            'width',
            progress + '%'
        );
        $("#addfile4").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);

                $(data.context.children()[index])
                    .wrap(link);
                $("#signature").val(file.name);

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
    //end file upload 4

        //remove file when click delete
      $('#files').on('click', 'a.delete', function (e) {
          e.preventDefault();

          var $link = $(this);

          var req = $.ajax({
            dataType: 'json',
            url: $link.data('url'),
            type: 'DELETE'
          });

          req.success(function () {
            $link.closet('p').remove();
          });
         $("#addfile").show();
         $("#files").html('');
         $('#progress .progress-bar').css(
            'width',
            0 + '%'
        );
      });

      $('#files2').on('click', 'a.delete', function (e) {
          e.preventDefault();

          var $link = $(this);

          var req = $.ajax({
            dataType: 'json',
            url: $link.data('url'),
            type: 'DELETE'
          });

          req.success(function () {
            $link.closet('p').remove();
          });
         $("#addfile2").show();
         $("#files2").html('');
         $('#progress2 .progress-bar').css(
            'width',
            0 + '%'
        );
      });

      $('#files3').on('click', 'a.delete', function (e) {
          e.preventDefault();

          var $link = $(this);

          var req = $.ajax({
            dataType: 'json',
            url: $link.data('url'),
            type: 'DELETE'
          });

          req.success(function () {
            $link.closet('p').remove();
          });
         $("#addfile3").show();
         $("#files3").html('');
         $('#progress3 .progress-bar').css(
            'width',
            0 + '%'
        );
      });

      $('#files4').on('click', 'a.delete', function (e) {
          e.preventDefault();

          var $link = $(this);

          var req = $.ajax({
            dataType: 'json',
            url: $link.data('url'),
            type: 'DELETE'
          });

          req.success(function () {
            $link.closet('p').remove();
          });
         $("#addfile4").show();
         $("#files4").html('');
         $('#progress4 .progress-bar').css(
            'width',
            0 + '%'
        );
      });

document.getElementById('files2').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('files').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('files3').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('files4').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};


});

</script>
<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            document.getElementById('confirm-but').disabled = false;
            $('#confirm-but').html('Confirm');
        } );
    }

</script>
 <script>
    $('#confirm-but').on("click", function(e){
        e.preventDefault();
        processWebcam();
    });
    //webcam form action
    function processWebcam(){
         // event.preventDefault();
          document.getElementById('confirm-but').disabled = true;
          $('#confirm-but').html('Please Wait');
          var webcam_image = document.getElementById("webcamimage").value;
          $.ajax({
              cache: false,
              type: 'POST',
              url: '<?php echo base_url().'cm/customer/webcam_image';?>',
              data: {webcam_image:webcam_image},
              success: function(data) {
                  if (data) {
                      $('#confirm-but').html('Uploaded');
                      document.getElementById("webcamimage").value = data;
                      document.getElementById("customer_photo").value = '';
                      var newURL = '<?php echo base_url()?>uploads/temp/' + data;
                      document.getElementById('results_anchor').href = newURL;
                      document.getElementById('results_span').onclick = function (event) {
                          event = event || window.event;
                          var target = event.target || event.srcElement,
                              link = target.src ? target.parentNode : target,
                              options = {index: link, event: event},
                              links = this.getElementsByTagName('a');
                          blueimp.Gallery(links, options);
                      };
                  }
                  else
                  {
                      alert('Unable to upload the image. Please use manual upload option!');
                  }
              }
          });
    }

</script>
