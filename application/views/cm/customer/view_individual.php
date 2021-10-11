<style>
.redtext{ color:#C30; font-style:italic;}
</style>
<h4> <?=$details->first_name;?> - <?=$details->last_name;?><span  style="float:right; color:#FFF" ><a href="javascript:close_view()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                     <form data-toggle="validator" name="editform" id="editform" method="post" action="" enctype="multipart/form-data">
                        <div class="row">
						     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h5>Personal Information :</h5>
							</div>
							<div class="form-body editform">
								<div class="form-inline">
									<div class="form-group">
                                    <input type="hidden" name="cus_code" id="cus_code" value="<?=$details->cus_code?>">
                                    <input type="hidden" name="custtype" id="custtype" value="<?=$details->cus_type?>">
                                    <strong class="redtext">Main Applicant :</strong> <?=$details->title?>. <?=$details->first_name?>
									</div>
                              </div>
									<div class="form-group has-feedback">
                                    	<strong class="redtext">Last Name :</strong> <?=$details->last_name?>
									</div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Full Name According to Identification Document :</strong> <?=$details->full_name?>
									</div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Other Names (Maiden Name) :</strong> <?=$details->other_names?>
									</div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Name in Sinhala Unicode :</strong> <?=$details->unicode_name?>
									</div>
                                    <div class="form-group">
                                    	<strong class="redtext">Are You a Citizen of Sri Lanka? :</strong> <?=$details->citizenship?>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <strong class="redtext">Date of Birth :</strong> <?=$details->dob?>
                                        </div>
                                        <div class="form-group">
                                        	<strong class="redtext">Place of Birth :</strong> <?=$details->pob?>
                                        </div>
                                     </div>
                                     <div class="form-inline">
                                        <div class="form-group">
                                            <strong class="redtext">Gender :</strong> <?=$details->gender?>
                                        </div>
                                        <div class="form-group">
                                        	<strong class="redtext">Marital Status :</strong> <?=$details->civil_status?>
                                        </div>
                                    </div>
                                    <!--starts spouse block-->
                                    <div id="spouse" <? if($details->civil_status == 'single' ){?> style="display:none;" <? }?>>
                                        <br>
                                        <br>
                                        <h5><strong>Family Information</strong></h5>
                                        <br>
                                        <div class="form-group has-feedback">
                                        	<strong class="redtext">Name of the Spouse :</strong> <?=$details->spouse_name?>
                                        </div>
                                        <div class="form-group">
                                        	<strong class="redtext">Employer of the Spouse :</strong> <?=$details->spouse_employer?>
                                        </div>
                                        <div class="form-inline">
                                            <div class="form-group">
                                            	<strong class="redtext">Designation :</strong> <?=$details->spouse_designation?>
                                            </div>
                                            <div class="form-group">
                                            	<strong class="redtext">Income :</strong> <?=$details->spouse_income?>
                                            </div>
                                            <div class="form-group">
                                            	<strong class="redtext">Dependents :</strong> <?=$details->dependent?>
                                            </div>
                                        </div>
                                    </div>
                                    <!--ends spouse block-->
                                    <div class="form-group">
                                    	<div class="row" style="margin-top:5px;">
                                             <div class="col-sm-6">
                                             	<strong class="redtext">Customer Photo</strong>
                                                <br /><br />
                                                <span id="oldfiles3">
                                                <? if ($details->customer_photo){?>
                                                    <a href="<?=base_url()?>uploads/customer_ids/<?=$details->customer_photo?>"><img style="border:#CCCCCC 1px solid;" src="<?=base_url()?>uploads/customer_ids/thumbnail/<?=$details->customer_photo?>" /></a>
                                                <? }?>
                                                </span>
                                             </div>
                                             <div class="col-sm-6">
                                             	<strong class="redtext">Signature</strong>
                                                <br /><br />
                                                <span id="oldfiles4">
                                                <? if ($details->signature){?>
                                                    <a href="<?=base_url()?>uploads/customer_ids/<?=$details->signature?>"><img style="border:#CCCCCC 1px solid;" src="<?=base_url()?>uploads/customer_ids/thumbnail/<?=$details->signature?>" /></a>
                                                <? }?>
                                                </span>
                                             </div>
                                        </div>
                                   </div>
                                    <br>
                                    <br>
                                    <h5><strong>Identification Document</strong></h5>
                                    <br>
                                    <div class="form-group">
										<strong class="redtext">Document Type :</strong> <?=$details->id_type?>
									</div>
                                    <div class="form-inline">
                                        <div class="form-group has-feedback">
                                            <strong class="redtext">Document Number :</strong> <?=$details->id_number?>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <strong class="redtext">Date of Issue :</strong> <?=$details->id_doi?>
                                        </div>
                                    </div>
									<div class="form-group">
                                    	<strong class="redtext">NIC Front/Passport</strong>
                                        <br /><br />
                                        <span id="oldfiles">
                                        <? if ($details->id_copy_front){?>
                                        	<a href="<?=base_url()?>uploads/customer_ids/<?=$details->id_copy_front?>"><img src="<?=base_url()?>uploads/customer_ids/thumbnail/<?=$details->id_copy_front?>" /></a>
                                        <? }?>
                                        </span>
                                       <br /><br />
                                        <span id="documentback">
                                            <strong class="redtext">NIC Back</strong>
                                            <br /><br />
                                            <span id="oldfiles2">
                                            <? if ($details->id_copy_back){?>
                                            	<a href="<?=base_url()?>uploads/customer_ids/<?=$details->id_copy_back?>"><img src="<?=base_url()?>uploads/customer_ids/thumbnail/<?=$details->id_copy_back?>" /></a>
                                            <? }?>
                                            </span>
                                    	</span>
									 </div>
							</div>
                            	<div class="form-title">
                                    <h5>Employment Information :</h5>
                                </div>
                                <div class="form-body">
                                      <div class="form-group has-feedback">
                                      	  <strong class="redtext">Occupation/Profession :</strong> <?=$details->occupation?>
                                      </div>
                                      <div class="form-group has-feedback">
                                      	  <strong class="redtext">Name of the Employer :</strong> <?=$details->employer?>
                                      </div>
                                      <div class="form-group has-feedback">
                                      	  <strong class="redtext">Address of the Employer :</strong> <?=$details->employer_address?>
                                      </div>
                                      <div class="form-group has-feedback">
                                      	  <strong class="redtext">Employer Phone :</strong> <?=$details->employer_phone?>
                                      </div>
                                      <div class="form-group has-feedback">
                                      	  <strong class="redtext">Monthly Income :</strong> <?=$details->monthly_income?>
                                      </div>
                                      <div class="form-group has-feedback">
                                      	  <strong class="redtext">Principal Source of Income :</strong> <?=$details->income_source?>
                                      </div>
                                      <div class="form-group has-feedback">
                                      	  <strong class="redtext">Monthly Expenses :</strong> <?=$details->monthly_expence?>
                                      </div>
                                      <div class="form-group has-feedback">
                                          <strong class="redtext">Savings :</strong> <?=$details->savings?>
                                      </div>
                                      <div class="form-group has-feedback">
                                      	  <strong class="redtext">Movable Properties :</strong> <?=$details->moveable_property?>
                                      </div>
                                      <div class="form-group has-feedback">
                                      	  <strong class="redtext">Immovable Properties :</strong> <?=$details->imovable_property?>
                                      </div>

                                </div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
								<div class="form-title">
									<h5>Contact Information :</h5>
								</div>
								<div class="form-body">
                                    <h3 class="formheadtext">residential address</h3>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Address Line 1 :</strong> <?=$details->raddress1?>
                                    </div>
                                     <div class="form-group has-feedback">
                                     	<strong class="redtext">Address Line 2 :</strong> <?=$details->raddress2?>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">City :</strong> <?=$details->raddress3?>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Postal Code :</strong> <?=$details->rpostal_code?>
                                    </div><!-- ticket number 656 -->
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">How Long Resident at Above Address? :</strong> <?=$details->raddress_duration?>
                                    </div>
                                    <div class="form-group">
                                    	<strong class="redtext">Ownership of the Residency :</strong> <?=$details->raddress_ownership?>
                                    </div>
                                   	<br>
                                    <h3 class="formheadtext">postal address </h3>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Address Line 1 :</strong> <?=$details->address1?>
                                    </div>
                                     <div class="form-group has-feedback">
                                     	<strong class="redtext">Address Line 2 :</strong> <?=$details->address2?>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">City :</strong> <?=$details->address3?>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Postal Code :</strong> <?=$details->postal_code?>
                                    </div><!-- ticket number 656 -->
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Grama Sewa Ward :</strong> <?=$details->gsword?>
                                    </div>
                                    <br>
                                    <h3 class="formheadtext">overseas/other address </h3>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Address Line 1 :</strong> <?=$details->otheraddress1?>
                                    </div>
                                     <div class="form-group has-feedback">
                                     	<strong class="redtext">Address Line 2 :</strong> <?=$details->otheraddress2?>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">City :</strong> <?=$details->otheraddress3?>
                                    </div>

                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Country :</strong> <?=$details->otheraddress4?>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Postal Code :</strong> <?=$details->otherpostal_code?>
                                    </div><!-- ticket number 656 -->
                                    <br>
                                    <h3 class="formheadtext">other details</h3>
									<div class="form-group has-feedback">
                                    	<strong class="redtext">Land Phone :</strong> <?=$details->landphone?>
									</div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Work Phone :</strong> <?=$details->workphone?>
									</div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Mobile Number :</strong> <?=$details->mobile?>
									</div>
                                    <div class="form-group has-feedback">
                                    	<strong class="redtext">Fax Number :</strong> <?=$details->fax?>
									</div>
                                     <div class="form-group has-feedback">
                                     	<strong class="redtext">Email :</strong> <?=$details->email?>
									</div>
								</div>
                                <div class="form-title">
                                    <h5>Employment Information :</h5>
                                </div>
                                <? $counter=1;
								$myarra=NULL;
								$myarra[1]['bank']="";
								$myarra[1]['branch']="";
								$myarra[1]['acc']="";
								$myarra[2]['bank']="";
								$myarra[2]['branch']="";
								$myarra[2]['acc']="";
								foreach($bankdata as $raw)
								{
									$myarra[$counter]['bank']=$raw->bank_code;
									$myarra[$counter]['branch']=$raw->branch_code;
									$myarra[$counter]['acc']=$raw->acc_number;
									$counter++;
								}

								?>
                                <div class="form-body">
                                    <div class="form-group">
                                    	<strong class="redtext">Bank Name :</strong>
										<? foreach ($banklist as $raw){
                    							if($myarra[1]['bank']==$raw->BANKCODE){
													echo $raw->BANKNAME;
												}
										}?>
                                     </div>
                                     <div class="form-group">
                                     	<strong class="redtext">Branch :</strong> <?=$myarra[1]['branch']?>
                                     </div>
                                     <div class="form-group">
                                     	<strong class="redtext">Account Number :</strong> <?=$myarra[1]['acc']?>
                                     </div>
                                </div>
                                <div class="form-body">
                                     <div class="form-group">
                                    	<strong class="redtext">Bank Name :</strong>
										<? foreach ($banklist as $raw){
                    							if($myarra[2]['bank']==$raw->BANKCODE){
													echo $raw->BANKNAME;
												}
										}?>
                                     </div>
                                     <div class="form-group">
                                     	<strong class="redtext">Branch :</strong> <?=$myarra[2]['branch']?>
                                     </div>
                                     <div class="form-group">
                                     	<strong class="redtext">Account Number :</strong> <?=$myarra[2]['acc']?>
                                     </div>
                                </div>
							</div>
						</div>

					</form></div>

                    <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
									</div>
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>
                    <button type="button" style="display:none" class="btn btn-delete" id="complexConfirmImage" name="complexConfirmImage"  value="DELETE"></button>
                    <button type="button" style="display:none" class="btn btn-delete" id="complexConfirmImage2" name="complexConfirmImage2"  value="DELETE"></button>
<br /><br /><br /><br /></div>

<script>
$("#complexConfirmImage").confirm({
	title:"Delete confirmation",
	text: "Are you sure you want to delete this image?" ,
	headerClass:"modal-header",
	confirm: function(button) {
		button.fadeOut(2000).fadeIn(2000);
		var code=1
		var image = document.editform.id_copy_front.value;
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'cm/customer/deleteImage/';?>',
            data: {image:image },
            success: function(data) {
                if (data) {
					alert('File has been deleted successfully');
					$('#files').html('');
					$('#deletefile').fadeOut('slow');
					$('#progress').fadeIn('slow');
					$('#addfile').fadeIn('slow');


                } else{
					alert('File not found');
					$('#files').html('');
					$('#deletefile').fadeOut('slow');
					$('#progress').fadeIn('slow');
					$('#addfile').fadeIn('slow');
				}
            }
        });
		//window.location="cm/customer/deleteImage/"+document.editform.id_copy_front.value;
	},
	cancel: function(button) {
		button.fadeOut(2000).fadeIn(2000);
	   // alert("You aborted the operation.");
	},
	confirmButton: "Yes I am",
	cancelButton: "No"
});

$("#complexConfirmImage2").confirm({
	title:"Delete confirmation",
	text: "Are you sure you want to delete this image?" ,
	headerClass:"modal-header",
	confirm: function(button) {
		button.fadeOut(2000).fadeIn(2000);
		var code=1
		var image = document.editform.id_copy_back.value;
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'cm/customer/deleteImage/';?>',
            data: {image:image },
            success: function(data) {
                if (data) {
					alert('File has been deleted successfully');
					$('#files2').html('');
					$('#deletefile2').fadeOut('slow');
					$('#progress2').fadeIn('slow');
					$('#addfile2').fadeIn('slow');


                } else{
					alert('File not found');
					$('#files2').html('');
					$('#deletefile2').fadeOut('slow');
					$('#progress2').fadeIn('slow');
					$('#addfile2').fadeIn('slow');
				}
            }
        });
		//window.location="cm/customer/deleteImage/"+document.editform.id_copy_front.value;
	},
	cancel: function(button) {
		button.fadeOut(2000).fadeIn(2000);
	   // alert("You aborted the operation.");
	},
	confirmButton: "Yes I am",
	cancelButton: "No"
});
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
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '<?=base_url()?>uploads/customer_ids/',
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
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
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
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
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

document.getElementById('oldfiles').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('oldfiles2').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};
document.getElementById('oldfiles3').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};
document.getElementById('oldfiles4').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

});
</script>
