
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<style type="text/css">
  .form_padding{
    padding-left: 0px;
  }
</style>

<script type="text/javascript">
// update progess
function updateprograss(task_id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/subtask/progess_view/"+task_id );
}

function close_updateprograss(){
  $('#popupform').delay(1).fadeOut(800);
}
// end update progess

// view sub task
function viewsubtask(subtask_id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/subtask/viewsubtask/"+subtask_id );
}

function close_viewsubtask(){
  $('#popupform').delay(1).fadeOut(800);
}
// end view sub task

// tast delete section

  var deleteid="";

  function call_delete(id)
  {
    document.deletekeyform.deletekey.value=id;
    $.ajax({
        cache: false,
        type: 'GET',
        url: '<?php echo base_url().'common/activeflag_cheker/';?>',
        data: {table: 'wip_sub_task', id: id,fieldname:'subt_id' },
        success: function(data) {
        if (data) {
          document.getElementById("checkflagmessage").innerHTML=data; 
          $('#flagchertbtn').click();         
        
        }else{
          $('#complexConfirm').click();
        }
      }
    }); 
  }
// end tast delete section

// sub task accept section

function call_accept(subt_id){
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>wip/subtask/sub_task_accept_view_for_popup/"+subt_id );
}

function close_accept(){
  $('#popupform').delay(1).fadeOut(800);
}

// end sub task accept section

</script>


</head>


<!-- //header-ends -->
<!-- main content start-->

<div id="page-wrapper">
 <div class="main-page">

  <div class="table">

    <h3 class="title1">Sub Task Data</h3>

    <div class="widget-shadow">               
        <br><a href="<?=base_url()?>wip/task/showall" aria-expanded="false" style="margin-left: 10px;font-size: 15px;px;
"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back Task List</a>
    
    <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
      <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
        <br>              

        <div class="form-title">
          <h4>Sub Task List
            <span style="float:right"> 
              <a href="javascript:load_printscrean2()"> <i class="fa fa-file-excel-o nav_icon"></i></a>
            </span>
          </h4>
        </div>     

        <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
          <table class="table"> 
            <thead> 
              <tr> 
                <th>Project Name</th> 
                <th>Task Name</th>
                <th>Duration</th> 
                <th>Progress</th>
                <th>Task End Date</th>
                <th>Status</th><th></th><th></th><th></th>
              </tr> 
            </thead> 

            <?if($subtaskdetalist){?>
              <tbody> 
              <?foreach ($subtaskdetalist as $subtask) {
                if($subtask->subt_createby==$this->session->userdata('userid') || $subtask->subt_assign==$this->session->userdata('userid') || $subtask->task_assign==$this->session->userdata('userid')){
                ?>

                  <tr>
                    <td><?=$subtask->prj_name?></td>
                    <td><?=$subtask->subt_name?></td>
                    <td><?=$subtask->subt_duration?> Days</td>
                    <td><?=$subtask->subt_progress?>%</td>
                    <td><?=$subtask->subt_edate?></td>
                    <? if($subtask->subt_status == 'pending'){?>
                      <td style="color: #cccc00">Pending</td>
                    <?} ?>
                    <? if($subtask->subt_status == 'processing'){?>
                          <td style="color: #007600">Processing</td>
                    <?} ?>
                    <? if($subtask->subt_status == 'completed'){?>
                          <td style="color: #3333ff">Completed</td>
                    <?} ?>
                    <td align="right">
                      <div id="checherflag">
                       <a  href="javascript:viewsubtask('<?=$subtask->subt_id?>')" title="view"><i class="fa fa-eye nav_icon icon_blue"></i></a>

                    <? $checkuser=$this->session->userdata('userid');
                    if($subtask->subt_assign==$checkuser && $subtask->subt_accepted_status==0){ ?>
                      <a  href="javascript:call_accept('<?=$subtask->subt_id?>')" title="Accept"><i class="fa fa-check nav_icon icon_green"></i></a>                      
                    <? } ?>

                    <?
                      if($subtask->subt_assign==$checkuser){ ?>
                       <a href="javascript:updateprograss('<?=$subtask->subt_id?>')" title="Update Progress"><i class="fa fa-plus-square nav_icon blue-500"></i></a>
                     <? } ?>

                     <?
                    
                    if($subtask->subt_createby==$checkuser){ ?>

                    <a  href="javascript:call_delete('<?=$subtask->subt_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>

                    <? } ?>

                      </div>
                    </td>
                  </tr>
              <? } }?>
              </tbody>
            <?}?>
            </table>  
         </div>  
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
    <div class="modal-body" id="checkflagmessage">
    </div>
  </div>
</div>
</div>
</div>
                    
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
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
                    window.location="<?=base_url()?>wip/subtask/delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
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
					
                    window.location="<?=base_url()?>re/customer/confirm/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
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
</div></html>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>