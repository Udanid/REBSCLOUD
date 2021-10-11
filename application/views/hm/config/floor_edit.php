 <link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">
<script type="text/javascript">

$(function(){
  $("#edesigntype").focus(function() {
  	$("#edesigntype").chosen({
       allow_single_deselect : true
    });
  });
});
$(function(){
  var ol_max_subjects = 10; //maximum input boxes allowed
  var ol_wrapper = $(".ol_input_fields_wrap"); //Fields wrapper
  var ol_add_button = $(".add_ol_subject_button"); //Add button ID

  var olCount = 0; //initlal text box count
  $(ol_add_button).click(function(e){ //on add input button click
    e.preventDefault();
    if(olCount < ol_max_subjects){
      $(ol_wrapper).append('<div class="emp_rows col-xs-12"><div class="col-md-6 validation-grids " data-example-id="basic-forms"><div class="form-body"><label>Room Type</label><div class="form-group">\
                    <select id="froomtypes" name="floorroom['+olCount+'][froomtypes]" class="form-control" required>\
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
</script>


 <?
 if($floorlist){
 	foreach($floorlist as $fl){
 		?>
 		<h4>Floor Details of <?=$fl->floor_name?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$fl->floor_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/update_floors" id="floorform">

                    <div class="form-title"> Update Floor
                  <input type="hidden" name="flrid" value="<?=$fl->floor_id?>">
                  </div>
                  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">

                    <label>Design Type</label>
                    <div class="form-group">
                    <select id="edesigntype" name="edesigntype" class="form-control" required>
                      <option value="">Select Design Type</option>
                      <?
                      if($designtypes)
                      {
                       foreach($designtypes as $dt){
                       	if($dt->design_id==$fl->design_id){
                       ?>
                         <option value="<?=$dt->design_id;?>" selected><?=$dt->prjtype_name;?>-><?=$dt->design_name;?>(<?=$dt->scode;?>)</option>
                       <?
                        }else{
                        ?>
                        <option value="<?=$dt->design_id;?>"><?=$dt->prjtype_name;?>-><?=$dt->design_name;?>(<?=$dt->scode;?>)</option>
                        <?
                        }
                       }
                      }
                      ?>

                    </select>
                    </div>

                    <label>Floor Name</label>
                    <div class="form-group">
                    <input type="text" name="efloorname" id="efloorname" class="form-control" required value="<?=$fl->floor_name?>">
                    </div>

                    <label>No of Bedrooms</label>
                    <div class="form-group">
                    <input type="text" name="enoof_bedrooms" id="enoof_bedrooms" class="form-control" required value="<?=$fl->num_of_bedrooms?>">
                    </div>

                    <label>No of Bathrooms</label>
                    <div class="form-group">
                    <input type="text" name="enoof_bathrooms" id="enoof_bathrooms" class="form-control" required value="<?=$fl->num_of_bathrooms?>">
                    </div>

                    <label>Total Extend(sq ft)</label>
                    <div class="form-group">
                    <input type="text" name="etotext" id="etotext" class="form-control" required value="<?=$fl->tot_ext?>">
                    </div>
                    <br><hr><br>
        <!-- ...................................add multiple floor rooms......................................-->
           <input type="hidden" id="formcount" name="formcount">
           <input type="hidden" id="formcounto" name="formcounto" value="<?=sizeof($floorroomslist)?>">

            <h4>Add New Floor Room:<span  style="float:right"><button class="add_ol_subject_button btn btn-success" style="margin-top:-10px;">(+) Add </button></span></h4>

            <div class="form-body">
             <div class="form-group ol_input_fields_wrap">
          <?
             if($floorroomslist){
                $i=0;
                foreach($floorroomslist as $frl){

                    ?>

                 <div class="emp_rows col-xs-12">
                  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">

                    <label>Room Type</label>
                    <div class="form-group">
                    <input type="hidden" name="floorroomo[<?=$i?>][oldroomid]" value="<?=$frl->room_id?>">
                    <select id="froomtypes" name="floorroomo[<?=$i?>][froomtypes]" class="form-control" required>
                      <option value="">Select Room Type</option>
                      <?
                      if($roomtypelist)
                      {
                       foreach($roomtypelist as $rtyp){
                         if($rtyp->roomtype_id==$frl->roomtype_id){
                       ?>
                         <option value="<?=$rtyp->roomtype_id;?>" selected><?=$rtyp->roomtype_name;?></option>
                       <?
                        }else{
                            ?>
                         <option value="<?=$rtyp->roomtype_id;?>"><?=$rtyp->roomtype_name;?></option>
                            <?
                        }
                       }
                      }
                      ?>

                    </select>
                    </div>

                    <label>Width(ft)</label>
                    <div class="form-group">
                    <input type="text" name="floorroomo[<?=$i?>][fwidth]" id="fwidth" class="form-control" value="<?=$frl->width?>" required>
                    </div>

                    <label>Height(ft)</label>
                    <div class="form-group">
                    <input type="text" name="floorroomo[<?=$i?>][fheight]" id="fheight" class="form-control" value="<?=$frl->height?>" required>
                    </div>

                    <label>Length(ft)</label>
                    <div class="form-group">
                    <input type="text" name="floorroomo[<?=$i?>][flenght]" id="flenght" class="form-control" value="<?=$frl->length?>" required>
                    </div>


                  </div>
                  </div>
                  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">


                    <label>Total Extend(sq ft)</label>
                    <div class="form-group">
                    <input type="text" name="floorroomo[<?=$i?>][ftotext]" id="ftotext" class="form-control" value="<?=$frl->tot_extent?>" required>
                    </div>

                    <label>Doors</label>
                    <div class="form-group">
                    <input type="text" name="floorroomo[<?=$i?>][fdoors]" id="fdoors" class="form-control" value="<?=$frl->doors?>" required>
                    </div>

                    <label>Windows</label>
                    <div class="form-group">
                    <input type="text" name="floorroomo[<?=$i?>][fwindows]" id="fwindows" class="form-control" value="<?=$frl->windows?>" required>
                    </div>
                   </div>
                  </div>
                </div>
              </div>
            <div class="clearfix">
                    <?

                    $i++;
                }
             }
          ?>
           </div><br>
          </div>
          <div class="form-group">
               <button type="submit" class="btn btn-primary">Update</button>
          </div>
<!-- ..........................................add multiple floor rooms.........................................-->


                  </div>
</div>
<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
								<div class="form-title">
									<h4>Upload Floor Images</h4>
								</div>
								<center>
								<?
								     $nmbr = 1;
									 if($floorimgs){
                    ?>
                    <input type="hidden" name="imgcount" id="imgcount" value="<?=sizeof($floorimgs)?>">
                    <?
                    echo "<h5><strong>Current Floor Images</strong></h5>";
									 	$prvsimgnamearr = array();
									 	$imgnames = '';
                    $i=1;
									 	foreach($floorimgs as $flimg){
									 		?>

										<br>image <?=$nmbr?> <br><span id="oldfiles<?=$i?>"><a href="<?=base_url()?>uploads/floor_img/<?=$flimg->floor_image?>"><img src="<?=base_url()?>uploads/floor_img/thumbnail/<?=$flimg->floor_image?>" /></a></span><br>

                                   			<?
                                   			$nmbr =$nmbr+1;
                                   			$imgnames = $imgnames.",".$flimg->floor_image;
                                   			array_push($prvsimgnamearr,$flimg->floor_image);
                              $i++;
									 	}

									 }else{
                                        $imgnames = '';
                                     }
									 ?>
                                     <br>

                                    </center>
                                <input type="hidden" name="file_array_upd" id="file_array_upd" value="<?=$imgnames?>">

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

                             </div>
						</div>
</form></div>
<br /><br /><br /><br /></div>
 		<?
 	}
 }
 ?>


</script>

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

<script type="text/javascript">
    //...........................file upload processs jquery .............................................
$(function(){

    //validate all fields
      $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
      $("#floorform").validate({
            rules: {
        edesigntype: {
              required: true
           },
        efloorname: {
              required: true
           },
        enoof_bedrooms: {
              required: true,
              number: true
            },
        enoof_bathrooms: {
             required: true,
             number: true
            },
        etotext: {
             required: true,
             number: true
            }
      },
        messages: {
            edesigntype:{
                required: "Required",
            },

            efloorname: {
                required: "Required",
            },

            enoof_bedrooms: {
                required: "Required",

            },

            enoof_bathrooms: {
                required: "Required",

            },

            etotext: {
                required: "Required",

            }

        }
});

//validate ends

    var file_list = [];
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
         $("#file_array").val('');

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
