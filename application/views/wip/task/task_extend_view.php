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

<script>

  function call_reject(id,task_id)
  {
    window.location=( "<?=base_url()?>wip/task/reject_extend/"+id+'/'+task_id);
  }

</script>

</head>

<!-- //header-ends -->
<!-- main content start-->

<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

    <h3 class="title1">Task Extend Details</h3>
          
    
    </div>
</div>


<div class="table widget-shadow">
 <div class="row">
                    
<form data-toggle="validator" method="post" action="<?=base_url()?>wip/task/task_extend_accept" enctype="multipart/form-data"> 
  <div class="row">
    <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <input type="hidden" class="form-control" name="request_duration" id="request_duration" data-error="" value="<?=$taskextend->days?>">

      <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$taskextend->task_id?>">
      <input type="hidden" class="form-control" name="task_end_date" id="task_end_date" data-error="" value="<?=$taskextend->end_date?>">

      <input type="hidden" class="form-control" name="task_duration" id="task_duration" data-error="" value="<?=$taskextend->task_duration?>">

      <div class="form-body">
        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p>Task Name : <?=$taskextend->task_name?></p>           
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Current Task Duration : <?=$taskextend->task_duration?> Days</p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
          	<?				
				
				$remaining_days = get_task_remaining_days($taskextend->task_sdate,$taskextend->end_date) //wip helper function
				
			?>
            <p>Requested Duration : <?=$remaining_days?> Days</p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Reason : <?=$taskextend->reason?></p>
          </div>
        </div>

      <div class="col-md-12 form_padding">  
      <div class="bottom validation-grids">                      
        <div class="form-group">
          <div class="col-md-6 form_padding">
            <button type="submit" class="btn btn-primary disabled">Accept</button>
          </div>
          <div class="col-md-6 form_padding">
          
            <a  href="javascript:call_reject('<?=$taskextend->id?>/<?=$taskextend->task_id?>')" title="Reject" class="btn btn-primary" style="background: #ff0000 !important;" id="complexConfirm">Reject</a>

          </div>
        </div>
        <br><br><div class="clearfix"> </div>
      </div>
    </div>

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