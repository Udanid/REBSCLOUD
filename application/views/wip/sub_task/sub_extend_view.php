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

  function call_reject(id,subt_id)
  {
    window.location=( "<?=base_url()?>wip/subtask/reject_extend/"+id+'/'+subt_id);
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
                    
<form data-toggle="validator" method="post" action="<?=base_url()?>wip/subtask/sub_task_extend_accept_or_request" enctype="multipart/form-data">  
  <div class="row">
    <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <input type="hidden" class="form-control" name="request_duration" id="request_duration" data-error="" value="<?=$subtaskextend->days?>">

      <input type="hidden" class="form-control" name="subt_id" id="subt_id" data-error="" value="<?=$subtaskextend->subt_id?>">

      <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$subtaskextend->task_id?>">
      
      <input type="hidden" class="form-control" name="sub_start_date" id="sub_start_date" data-error="" value="<?=$subtaskextend->subt_sdate?>">
      <input type="hidden" class="form-control" name="task_end_date" id="task_end_date" data-error="" value="<?=$subtaskextend->task_edate?>">

      <input type="hidden" class="form-control" name="task_duration" id="task_duration" data-error="" value="<?=$subtaskextend->task_duration?>">

      <input type="hidden" class="form-control" name="task_createby" id="task_createby" data-error="" value="<?=$subtaskextend->task_createby?>">
	  <?
      	 $request_duration = sub_task_skip_holiday_count($subtaskextend->subt_sdate,$subtaskextend->days); //wip helper function
		 $main_task_duration = $subtaskextend->task_edate;
         $user=$this->session->userdata('userid');
	  ?>
      <div class="form-body">
        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p>Sub Task Name : <?=$subtaskextend->subt_name?></p>           
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Sub Task Current Duration : <?=$subtaskextend->subt_duration?> Days</p>
          </div>
        </div>

        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p>Main Task Duration : <?=$subtaskextend->task_duration?> Days</p>           
          </div>
        </div>
        
        

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Request Duration : <?=$subtaskextend->days?> Days</p>
          </div>
        </div>
        
        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p>Main Task End Date : <?=$subtaskextend->task_edate?></p>           
          </div>
        </div>
        
        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Requested End Date : <?=$request_duration?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Reason : <?=$subtaskextend->reason?></p>
          </div>
        </div>
    <div class="row">
      <div class="col-md-12" data-example-id="basic-forms">

        <? 
		
         // $request_duration=$subtaskextend->days;
         // $main_task_duration=$subtaskextend->task_duration;
		 //$request_duration = date('Y-m-d',strtotime($subtaskextend->subt_sdate. '+ '.$subtaskextend->days.' days'));

        if($main_task_duration >= $request_duration && $subtaskextend->task_assign==$user){ ?>
          <div class="col-md-4 form_padding">
            <div class="bottom validation-grids">                      
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Accept</button>
              </div>
            </div>
        </div>

        <? } ?>

         <? if($main_task_duration < $request_duration && $subtaskextend->task_createby==$user){ ?>
          <div class="col-md-4 form_padding">
            <div class="bottom validation-grids">                      
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Accept</button>
              </div>
            </div>
          </div>

        <? } ?>

        <? if($main_task_duration < $request_duration && $subtaskextend->task_assign==$user && $subtaskextend->task_createby!=$user){ ?>
          <div class="col-md-4 form_padding">
            <div class="bottom validation-grids">                      
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Request Extension</button>
              </div>
            </div>
          </div>

        <? } ?>

        <div class="col-md-4 form_padding">
          <div class="bottom validation-grids">                      
            <div class="form-group">
              <a  href="javascript:call_reject('<?=$subtaskextend->id?>/<?=$subtaskextend->subt_id?>')" title="Reject" class="btn btn-primary" style="background: #ff0000 !important;" id="complexConfirm">Reject</a>

            </div>
          </div>
        </div>

      </div>

</div>
</div>
</div> 
</div>

</div>
</form> 

</div>
</div>

</html>
    <!--footer-->
<?
  $this->load->view("includes/footer");
?>