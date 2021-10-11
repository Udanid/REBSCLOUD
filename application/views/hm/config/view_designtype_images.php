<link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<h4>View Design Type<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->design_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
<div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/update_designtypes" id="mytestform">

						<div class="col-md-6 validation-grids " data-example-id="basic-forms">

							<div class="form-body">
                <label>Design Type Name</label>
                <div class="form-group">
                  <input type="text" name="design_name" id="design_name" value="<?=$details->design_name?>" class="form-control" required>
                  <input type="hidden" name="design_id" id="design_id" value="<?=$details->design_id?>" class="form-control" required>
                </div>
                <label>Short Code</label>
                <div class="form-group">
                  <input type="text"  name="short_code" id="short_code" value="<?=$details->short_code?>" class="form-control" required>
                </div>
                <label>Project Type</label>
                <div class="form-group">
                  <select class="form-control" name="prj_type" id="prj_type">
                    <option value="">Select Project Type</option>
                    <? if($prjtypes){
                      $prj=$details->prjtype_id;
                      foreach ($prjtypes as $key => $value) {?>
                        <option value="<?=$value->prjtype_id?>" <? if($prj==$value->prjtype_id){echo "selected";}?>> <?=$value->short_code?> - <?=$value->prjtype_name?></option>
                    <?	}
                    }?>
                  </select>

                </div>
                <label>Number Of floors</label>
                <div class="form-group">
                  <input type="number" step="1" min="1" name="floors" id="floors" value="<?=$details->num_of_floors?>" class="form-control" required>
                </div>
                <label>Total Extends</label>
                <div class="form-group">
                  <input type="number" step="0.01" name="tot_ext" id="tot_ext" value="<?=$details->tot_ext?>" class="form-control" required>
                </div>
                <label>Description</label>
                <div class="form-group">
                  <textarea name="description" id="description" class="form-control" required><?=$details->description?></textarea>
                </div>
				<div class="bottom">
                   <div class="clearfix"> </div>
				</div>




							</div>
						</div>
                        <div class="col-md-6 validation-grids validation-grids-right">
                            <div class="widget-shadow" data-example-id="basic-forms">
                                <div class="form-title">
                                    <h4>Uploads Design Type Images</h4>
                                </div>
                                <center>
                                <?
                                     $nmbr = 1;
                                     if($designtypeimgs){
                                        ?>
                                        <input type="hidden" name="imgcount" id="imgcount" value="<?=sizeof($designtypeimgs)?>">
                                        <?
                                        echo "<h5><strong>Current Design Type Images</strong></h5>";
                                        $prvsimgnamearr = array();
                                        $imgnames = '';
                                        $i=1;
                                        foreach($designtypeimgs as $dtimg){
                                            ?>

                                        <br>image <?=$nmbr?> <br> <span id="oldfiles<?=$i?>"><a href="<?=base_url()?>uploads/design_type/<?=$dtimg->designtype_image?>"><img src="<?=base_url()?>uploads/design_type/thumbnail/<?=$dtimg->designtype_image?>"></a><br>

                                            <?
                                            $nmbr =$nmbr+1;
                                            $imgnames = $imgnames.",".$dtimg->designtype_image;
                                            array_push($prvsimgnamearr,$dtimg->designtype_image);

                                            $i++;
                                        }
                                     }else{
                                        $imgnames = '';
                                     }
                                     ?>
                                     <br>

                                    </center>
                                <input type="hidden" name="file_array_upd" id="file_array_upd" value="<?=$imgnames?>">

                                
                                <br><br>

                             </div>
                        </div>
          </form></div>
        </div>
<!-- The blueimp Gallery widget -->
      <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
          <div class="slides"></div>
          <h3 class="title"></h3>
          <a class="prev">‹</a>
          <a class="next">›</a>
          <a class="close">×</a>
          <a class="play-pause"></a>
          <ol class="indicator"></ol>
      </div>
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

<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>

        <script  type="text/javascript">
        	$(function(){

        	//validate all fields
          	$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
        		$("#mytestform").validate({
        			rules: {
        					design_name: {required: true},
        					short_code:{required: true},
        					prj_type:{required: true},
        					floors:{required: true},
        					tot_ext:{required: true},
        					description:{required: true},
        				},
                messages: {
                    design_name: "Required",
        						short_code: "Required",
        						prj_type: "Required",
        						floors: "Required",
        						tot_ext:"Required",
        						description:"Required",
                }
        });

         	});
        </script>

        <script type="text/javascript">
    //...........................file upload processs jquery .............................................
$(function(){

    var file_list = [];
    $('#deletemsg').html('');
'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '<?=base_url()?>uploads/design_type/',
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
        $('#deletemsg').html('');
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
         $("#file_array").html('');


         $('#progress .progress-bar').css(
                'width',
                0 + '%'
            );
      })


    });
//.........................end file upload process jquery ............................................

var imagescount = $('#imgcount').val();
    console.log(imagescount)
    console.log(parseInt(imagescount)+1)
    var newcount = parseInt(imagescount)+1;

    for (i = 1; i < newcount; i++) {
        console.log('oldfiles'+i)
        document.getElementById('oldfiles'+i).onclick = function(event){
        event = event || window.event;
        var target = event.target || event.srcElement,
            link = target.src ? target.parentNode : target,
            options = {index: link, event: event},
            links = this.getElementsByTagName('a');
        blueimp.Gallery(links, options);
        };
    }


</script>