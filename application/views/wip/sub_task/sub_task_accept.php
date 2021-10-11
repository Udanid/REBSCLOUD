
<!DOCTYPE HTML>
<html>
<head>

<?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script>
function subtaskReject(){
  var reason = $('#reason').val();
  var task_id = '<?=$details->task_id?>';
  var subt_id = '<?=$details->subt_id?>';
  var formatted = reason.replace(/(\r\n|\n|\r)/gm,"<br>");
  if(reason == ''){
    formatted = 'No reason.';
  }
  var encoded = encodeURIComponent(window.btoa(formatted));
  window.location="<?=base_url()?>wip/subtask/reject/"+task_id+"/"+subt_id+"/"+encoded;
}
</script>
<style type="text/css">
  .form_padding{
    padding-left: 0px;
  }
</style>

</head>

<!-- //header-ends -->
<!-- main content start-->

<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

    <h3 class="title1">Sub Task Details</h3>
          
    
    </div>
</div>


<div class="table widget-shadow">
 <div class="row">
                    
<form data-toggle="validator" method="post" action="<?=base_url()?>wip/subtask/accept_notification" enctype="multipart/form-data">  
  <div class="row">
    <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <input type="hidden" class="form-control" name="subt_id" id="subt_id" data-error="" value="<?=$details->subt_id?>">

      <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$details->task_id?>">

      <input type="hidden" class="form-control" name="subt_duration" id="subt_duration" data-error="" value="<?=$details->subt_duration?>">

      <div class="form-body">
        <div class="col-md-12 form_padding"> 
          <div class="form-group">
            <p><strong>Project Name</strong> : <?=$details->prj_name?></p>           
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p><strong>Task Name</strong> : <?=$details->task_name?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p><strong>Sub Task Name</strong> : <?=$details->subt_name?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p><strong>Assignee </strong>: <?=$details->initials_full?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p><strong>Duration</strong> : <?=$details->subt_duration?> Days</p>
          </div>
        </div>

        <div class="col-md-12 form_padding">
          <div class="form-group has-feedback">
            <p><strong>Description</strong> : <?=$details->sub_description?></p>
          </div>
        </div>

      <div class="col-md-6 form_padding">  
      <div class="bottom validation-grids">                      
        <div class="form-group">
          <button type="submit" class="btn btn-primary disabled">Accept</button>
        </div>
        <br><br><div class="clearfix"> </div>
      </div>
    </div>
    <div class="col-md-6 form_padding">  
        <div class="bottom validation-grids">                      
          
            <textarea class="form-control" name="reason" id="reason" placeholder="Reject Reason"></textarea>
                  
          <br>
            <button type="button" onClick="subtaskReject();" class="btn btn-danger form-control">Reject</button>
          
          <br><br><div class="clearfix"> </div>
        </div>
      </div>

      <? if($get_sub_task_file_attachment){ ?>
          <div class="col-md-6 form_padding">       
            <div class="form-group has-feedback">
              <p>Sub Task File Attachments : </p>
              <? 
                foreach ($get_sub_task_file_attachment as $key => $row) { ?>
                  <a href="<?=base_url()?><?= $row->file_path ?>" target="_blank"><?= $row->file_name ?></a>
                  <br>       
              <? } ?>                
            </div><br>
          </div>
        <? } ?>

    <br><br><br>
    </div>
  </div>
  
  </div>
</div>
<div class="clearfix"></div>  
</form> 
</div>
 <br /><br /><br /><br />
</div>

</html>
    <!--footer-->
<?
  $this->load->view("includes/footer");
?>