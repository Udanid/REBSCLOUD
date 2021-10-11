<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
?> 
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">-->
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/tui-time-picker.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/tui-date-picker.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/tui-calendar.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/default.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/icons.css">
</head>
<script type="text/javascript">
jQuery(document).ready(function() {
  $("#userModel_butdata").focus(function() {
		$("#cat_id").chosen({
   			 allow_single_deselect : true,
	 search_contains: true,
	 width:'200%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select an Instance"
    	});
			$("#staff").chosen({
   			 allow_single_deselect : true,
	 search_contains: true,
	 width:'200%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select an Instance"
    	});
		$("#not_time").chosen({
   			 allow_single_deselect : true,
	 search_contains: true,
	 width:'200%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select an Instance"
    	});
		
		//document.getElementById("emplist").value='';
		 //$( "#stafflist" ).html='';
	});
	 

	
});
$( function() {
    $( "#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#start_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	 
	 
	 



	
  } );
  function formatvar(obj)
  {
	    var dateobj = new Date(obj.value); 
  
// Contents of above date object is converted 
// into a string using toISOString() function. 
		obj.value = dateobj.toISOString(); 
		//alert(B)
  }
  function load_emplist(val)
  {
	  var res = val.split(",");
	  var currentlist=document.getElementById("emplist").value;
	  var list=currentlist.split(",");
	  if(list.indexOf(res[0])  >= 0 )
	  {
	  
	 }
	 else
	 {
		  $( "#stafflist" ).append('<li>'+res[1]+'</li>');
	  document.getElementById("emplist").value=res[0]+','+currentlist;
	 
	 }
	 
  }
  function cleardata()
  {
	 // alert('sss')
	  document.getElementById("emplist").value='';
	  document.getElementById("stafflist").innerHTML ='';
		 
  }
  function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
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
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
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
<!-- //header-ends -->
<!-- main content start-->

<div id="page-wrapper">
 <div class="main-page">
  <div class="table">
   <h3 class="title1">Calendar</h3>
					
    <div class="widget-shadow">
        <ul id="myTabs" class="nav nav-tabs" role="tablist">           
          <li role="presentation" class="active">
              <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false" onclick="showserrchbox()">Schedule Data</a>
       
          </li>  
                            	
        </ul>	
           
    <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
      <? $this->load->view("includes/flashmessage");?>
        <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
        
 <div class="row">
                    
<form data-toggle="validator" method="post" action="<?=base_url()?>wip/task/task_accept_add" enctype="multipart/form-data">  
  <div class="row">
    <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$details->event_id?>">
      <div class="form-body">
        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p> <strong>Event Name: </strong><?=$details->title?></p>           
          </div>
        </div>
 <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p><strong>Description:</strong> <?=$details->details ?></p>           
          </div>
        </div>
        <div class="col-md-6 form_padding"> 
          <div class="form-group">
          	<? 
			date_default_timezone_set('Europe/London');
			if($details->allday == 'true'){?>
            	<p><strong>Time :</strong> From <span style="color:#F60"><?= date('Y-m-d', strtotime($details->start_date)); ?></span> To <span style="color:#F60"><?= date('Y-m-d', strtotime($details->end_date));?></span></p>
            <? }else{?>
            	<p><strong>Time :</strong> From <span style="color:#F60"><?= date('Y-m-d H:i A', strtotime($details->start_date)); ?></span> To <span style="color:#F60"><?= date('Y-m-d H:i A', strtotime($details->end_date));?></span></p>
            <? }?>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p><strong>Location :</strong> <?=$details->location?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p><strong>Participants :</strong> 
            <ul style=" padding-left:20px;">
            <?
            foreach($list as $raw1)
			{$class=''; if($raw1->status=='ACCEPT') $class='green'; if($raw1->status=='REJECT') $class='red'?>
				
                <li  style="color:<?=$class?>"><?=$raw1->initial?> <?=$raw1->surname?> - <?=$raw1->status?></li>
			<? }
			
			?>
            </ul>
             </p>
          </div>
        </div>
		<div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p><strong>Created By :</strong> <?=get_user_fullname_id($details->create_by) //re_account helper function?></p>
          </div>
        </div>
       <div class="clearfix"></div><br>

      <div class="col-md-2 ">  
         <button type="button" onClick="call_confirm('<?=$details->event_id?>')"class="btn btn-success form-control">Accept</button>
        
      </div>
       <div class="col-md-2 ">  
    
          <button type="button" style="background:#F30; color:#fff;" onClick="call_delete('<?=$details->event_id?>')" class="btn btn-default form-control">Reject</button>
        
      </div>
      
    </div>

    <br><br><br>
    </div>
  </div>
  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
  
    </div> 
  </div>
</div>
<div class="clearfix"></div>  
</form> 
</div>
 <br /><br /><br /><br />

        
        
        
        
        
   		 </div>
    <!--End Home tap--> 
    <!--Start Cat tab-->
	<div role="tabpanel" class="tab-pane fade " id="cat" aria-labelledby="cat-tab" >
                     
          
        
          
     </div>
    <!--Ent Cat tab-->
</div>
</div>

</div>
<!--Start Popup Model-->

 <!--Start Popup Model-->

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
                    
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_sub" name="complexConfirm_sub"  value="DELETE"></button>
<button type="button" style="display:none; visibility:hidden;" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>

<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are you sure you want to reject this?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>wip/calendar/reject_meeting/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });


             $("#complexConfirm_confirm").confirm({
                title:"Record confirmation",
                text: "Are you sure you want to accept this?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>wip/calendar/accept_meeting/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            </script> 

        <div class="row calender widget-shadow "  style="display:none">
            <h4 class="title">Calender</h4>
            <div class="cal1">
                
            </div>
        </div>

        <div class="clearfix"> </div>
    </div>
</div></html>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>