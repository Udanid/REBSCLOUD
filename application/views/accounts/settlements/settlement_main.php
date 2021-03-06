
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
$( function() {
    $( "#settledate" ).datepicker({dateFormat: 'yy-mm-dd'});


  } );
  $( function() {
	 $( "#promiss_date" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
jQuery(document).ready(function() {
  
	 $("#res_code_set").focus(function() {
	  $("#res_code_set").chosen({
     allow_single_deselect : true
    });
	});
	$("#ledger_id").chosen({
    		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Ledger"
    	});
		$("#adv_id").chosen({
    		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Ledger"
    	});


 /* Delete ledger row */
            /* Delete ledger row */
			
	// project related settlement wrapper		
 	var prj_wrapper = $(".prj_input_fields_wrap"); //Fields wrapper
  	var prj_add_button = $(".add_prj_subject_button"); //Add button ID
	var prjCount = 1; //initlal text box count
 	 $(prj_add_button).click(function(e){ //on add input button click
  	  e.preventDefault();
  	
		$.ajax({
                   url:'<?php echo base_url().'accounts/settlments/add_project_raw/settle_prj/';?>'+prjCount,
                    success: function(data) {
                        $(prj_wrapper).append(data)
						
                      
                   }
               });
		
     
      prjCount++; //text box increment
	  document.getElementById("prjcount").value=prjCount;
	 
	  if(parseFloat(prjCount)>2)
			{
				var removount=parseFloat(prjCount)-2
			 var str="rawremovesettle_prj"+removount
			
				$('#' + str).delay(1).fadeOut(600);
			}
   
  });

  $(prj_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault();
    $(this).parent('div').parent('div').remove(); prjCount--;
	  document.getElementById("prjcount").value=prjCount;
  })
  //end Priject retated settlment wrapper
  
  //external settlment wrapper
  var ext_wrapper = $(".ext_input_fields_wrap"); //Fields wrapper
  	var ext_add_button = $(".add_ext_subject_button"); //Add button ID
	var extCount = 1; //initlal text box count
 	 $(ext_add_button).click(function(e){ //on add input button click
  	  e.preventDefault();
  	
		$.ajax({
                   url:'<?php echo base_url().'accounts/settlments/add_external_raw/settle_ex/';?>'+extCount,
                    success: function(data) {
                        $(ext_wrapper).append(data)
                       
                      
                   }
               });
		
     
      extCount++; //text box increment
	    document.getElementById("extcount").value=extCount;
		
		
		 if(parseFloat(extCount)>2)
			{
				var removount=parseFloat(extCount)-2
			 var str="rawremovesettle_ex"+removount
			
				$('#' + str).delay(1).fadeOut(600);
			}
   
  });

  $(ext_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault();
    $(this).parent('div').parent('div').remove(); extCount--;
	document.getElementById("extcount").value=extCount;
  })
  // end external settlemet wrapper
            
});

function load_tasklist(value,id,tag)
{
	
	var stirng='tasklist1'+tag+id;
	$("#" + stirng).load( "<?=base_url()?>accounts/settlments/get_tasklist/"+tag+'/'+id+'/'+value );
}
	
function load_subtasklist(id,cont,tag)
{
	// var prj_id= document.getElementById("prj_id").value;
	 if(id!=""){
		taskid=id.split(",")[0];
	 	document.getElementById("val_available_"+tag+cont).value=id.split(",")[1];
		prj_id=document.getElementById("prj_id_"+tag+cont).value;
	 	
	 	document.getElementById("available_"+tag+cont).value=parseFloat(id.split(",")[1]).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
		//$('#subtaskdata').delay(1).fadeIn(600);
   var stirng='subtasklist1'+tag+cont;
		$( "#" + stirng   ).load( "<?=base_url()?>accounts/settlments/get_subtask_list_payment/"+taskid+"/"+ prj_id+"/"+ tag+"/"+ cont	);
 	}
}
function load_advancebalance(val)
{

	if(val!='none')
	{
		$('#fulldatablock').delay(1).fadeIn(600);
		
		var paid = val.split("-")[1];
		if(val.split("-")[1])
		paid = val.split("-")[1];
		else
		paid = 0;
		var total = val.split("-")[2];
		var tot=parseFloat(total)-parseFloat(paid);
		 document.getElementById("advance_bal").value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		
	}
	else
	{
		$('#fulldatablock').delay(1).fadeOut(600);
	}
}
function validation()
{
	var prjCount=document.getElementById("prjcount").value
	var extCount=document.getElementById("extcount").value
	
	var tot=0;
	for(i=1; i<prjCount ; i++)
	{
		prj_id=document.getElementById("prj_id_settle_prj"+i).value;
		
		budget=document.getElementById("val_available_settle_prj"+i).value;
		amount=document.getElementById("amount_settle_prj"+i).value;
		task_id="";
		amount=amount.replace(/\,/g,'')
		budget=budget.replace(/\,/g,'')
		var errordiv='blockerrorsettle_prj'+i;
		if(prj_id=='' )
		{
			$('#' + errordiv).delay(1).fadeIn(600);
			
			document.getElementById(errordiv).innerHTML='Please select Project Name ';
			document.getElementById("amount_settle_prj"+i).value=0;
		}
		else
		{
			task_id=document.getElementById("task_id_settle_prj"+i).value;
			 if(task_id=="")
			{
				$('#' + errordiv).delay(1).fadeIn(600);
				document.getElementById(errordiv).innerHTML='Please select Task ';
				document.getElementById("amount_settle_prj"+i).value=0;
			}
			else if(parseFloat(amount)>parseFloat(budget))
			{
				$('#' + errordiv).delay(1).fadeIn(600);
				document.getElementById(errordiv).innerHTML='Settled Amount Cannot exceed the budget amount';
				document.getElementById("amount_settle_prj"+i).value=0;
			}
			
			else
			{
				$('#' + errordiv).delay(1).fadeOut(600);
				tot=parseFloat(tot)+parseFloat(amount);
			}
		}
	}
	for(i=1; i<extCount ; i++)
	{
		ledger=document.getElementById("ledgerid_settle_ex"+i).value;
		amount=document.getElementById("amount_settle_ex"+i).value;
		
		amount=amount.replace(/\,/g,'')
		var errordiv='blockerrorsettle_ex'+i;
		if(ledger=='')
		{
			$('#' + errordiv).delay(1).fadeIn(600);
			document.getElementById(errordiv).innerHTML='Please select Ledger  Name';
			document.getElementById("amount_settle_ex"+i).value=0;
		}
		else
		{
			$('#' + errordiv).delay(1).fadeOut(600);
			tot=parseFloat(tot)+parseFloat(amount);
		}
	}
	
	totamount= document.getElementById("advance_bal").value;
	totamount=totamount.replace(/\,/g,'');
	if(tot>0)
	{
		$('#finalpayment_data').delay(1).fadeIn(600);
	}
	if(parseFloat(tot)>parseFloat(totamount))
	{
		$('#blockerror_main').delay(1).fadeIn(600);
			document.getElementById('blockerror_main').innerHTML='Total Settled amount cannot exceed the available amount';
			document.getElementById('settleamount').value='';
			$('#finalpayment_data').delay(1).fadeOut(600);
			
	}
	else
	{
		$('#blockerror_main').delay(1).fadeOut(600);
			document.getElementById('settleamount').value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
	}
}

</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Cash Advance Settlements</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <li role="presentation" <? if($list==''){?> class="active"<? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Settle Advance</a></li>
           <li role="presentation" <? if($list=='book'){?> class="active"<? }?>><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Settlement List</a></li>

        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          <? $this->load->view("includes/flashmessage");?>

                <div role="tabpanel" class="tab-pane fade <? if($list==''){?>  active in <? }?>" id="profile" aria-labelledby="profile-tab">
                    <p>

                  <!--   <?=base_url()?>accounts/cashadvance/add_settlment-->
                          <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/settlments/add_settlment" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms">
                      <div class="alert alert-danger" style="display:none" role="alert" id="blockerror_main"></div>
                        <div class="form-body form-horizontal">
                         <div class="form-group"><label class=" control-label col-sm-3 " >Select Advance</label>
                             <div class="col-sm-3 ">
                              <select name="adv_id" id="adv_id" class="form-control"required="required" onChange="load_advancebalance(this.value)"  ><option value="none">Select Advance</option>
                               <? if($advlist){
                                 foreach($advlist as $dataraw)
                                 {
                                    
                                 ?>
                                <option value="<?=$dataraw->adv_id?>-<?=$dataraw->totpay?>-<?=$dataraw->amount?>" > <?=$dataraw->emp_no?> -<?=$dataraw->serial_number?> - <?=$dataraw->initial?> <?=$dataraw->surname?>-<?=$dataraw->totpay?></option>
                                                <? }}?>
                                </select>
                                </div>
                                 <label class=" control-label col-sm-3 " >Advance Balance Amount</label>
                                 <div class="col-sm-3 "><input  type="text" class="form-control" id="advance_bal"    name="advance_bal"  value=""   data-error=""    readonly placeholder="Advance Balance Amount" >
                                 </div> 
                             </div>
  						<div class="clearfix"> </div>
                        <!--All Details  Block-->
                        <div id="fulldatablock" style=" display:none">
                        
                        <!--Project Settlement  Block-->
                         <div class="form-title">
								<h4>Project Related Settlments  <span  style="float:right"  > <button class="add_prj_subject_button btn btn-success " style="margin-top:-10px;"> + </button></span></h4>
						</div>
                        <div class="col-sm-12">
                          <div class="form-group prj_input_fields_wrap">
								 <div class="emp_rows col-xs-12">
               							
                                                   
                					</div>

              				</div>

                        </div>
                        <!-- End Project Settlement  Block-->
                        <input type="hidden"  name="prjcount" id="prjcount">
                         <input type="hidden"  name="extcount" id="extcount">
                        
                        <div class="clearfix"> </div>
                        
                        <!--External Settlement  Block-->
                         <div class="form-title">
								<h4>External Settlments  <span  style="float:right"  > <button class="add_ext_subject_button btn btn-success " style="margin-top:-10px;"> + </button></span></h4>
						</div>
                        <br>
                        <div class="col-sm-12">
                          <div class=" ext_input_fields_wrap">
								 <div class="emp_rows col-xs-12">
               							
                                                   
                					</div>

              				</div>

                        </div>
                        <!-- End External Settlement  Block-->
                        
                        
                        
                        
                         
    					<div  id="finalpayment_data"  style="display:none"><!--Final Payment Block-->
                           <div class="form-group">
                           <label class=" control-label col-sm-3 " >Pay Amount</label><div class="col-sm-3 ">  <input   min="1"  class="form-control" id="settleamount" readonly    name="settleamount"  value=""   data-error="" required   placeholder="Pay Amount" ></div> <label class=" control-label col-sm-3 " >Settle Date</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="settledate"    name="settledate"  value=""   data-error="" required  placeholder="Settle Date" ></div>
                           </div>
    
                              <div class="form-group"> <label class=" control-label col-sm-3 " >Description</label>
                                <div id="tasklistdiv" class="col-sm-6"><input  type="text" class="form-control" id="note"    name="note"  value=""   data-error=""  placeholder="Description" ></div></div>
                                
                                <!--File Attachnebts-->
                                
                                 <div  data-example-id="basic-forms"> 
                                    <div class="form-title">
                                        <h4>Attachments :</h4>
                                    </div>
                                    <div class="form-body">
                                        <br /><br />
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
                                        <br />
                                        <!-- The container for the uploaded files -->
                                        <div id="files" class="files"></div>
                                        <div class="form-group has-feedback" id="loanins">
                                       
                                      </div>
                                   </div>
                                </div>
                          
                                
                                
                                <!--File Attachemebnts-->
                                
                                
                                
                                
                                    <div class="col-sm-3 has-feedback" id="paymentdateid"><button type="submit" class="btn btn-primary disabled" onClick="check_projectselected()" >Make Settlement</button></div></div>
                                    <br> <br> <br> <br>
                                </div>
                                
                           </div><!-- End Final Payment Block-->
                           
                           </div>
                           
                           <!-- End Full Details block Block-->
                           <br> <br> <br> <br> <br> <br> <br> <br> <br>
    
                           </div>
                           

                      





					</form>





                   </p>

                </div>
                <div role="tabpanel" class="tab-pane fade  <? if($list=='book'){?>  active in <? }?> " id="list" aria-labelledby="list-tab">
                <?  $this->load->view("accounts/settlements/settlement_list");?>
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
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">??</span></button>
										<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
									</div>
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>
 <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_advdelete" name="complexConfirm_advdelete"  value="DELETE"></button>

<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_deed" name="complexConfirm_confirm_deed"  value="DELETE"></button>

<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_check" name="complexConfirm_check"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_approve" name="complexConfirm_approve"  value="DELETE"></button>
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
                    window.location="<?=base_url()?>accounts/settlments/delete_settlement/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>accounts/settlments/confirm_settlement/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			$("#complexConfirm_check").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>accounts/settlments/check_settlement/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			$("#complexConfirm_approve").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to Approve this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>accounts/settlments/approve_settlement/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

            </script>


<link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">

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
var file_list = [];
//var type = 'lands';
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '<?=base_url()?>uploads/pettycash/temp_images/',
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
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files_other');
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

$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>
<style>
.ui-autocomplete { position: absolute; cursor: default; z-index:99999999999; font-size:0.8em; !important;}  
</style>
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
