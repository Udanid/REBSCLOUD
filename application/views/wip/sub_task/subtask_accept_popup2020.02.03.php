
<h4>Sub Task Details<span  style="float:right; color:#FFF" ><a href="javascript:close_accept_sub('')"><i class="fa fa-times-circle "></i></a></span></h4>   
    </div>
</div>

<div class="table widget-shadow">
 <div class="row">
                    
<form data-toggle="validator" method="post" action="<?=base_url()?>wip/subtask/accept_notification" enctype="multipart/form-data">  
  <div class="row">
    <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <input type="hidden" class="form-control" name="subt_id" id="subt_id" data-error="" value="<?=$details->subt_id?>">

      <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$details->task_id?>">

      <input type="hidden" class="form-control" name="subt_duration" id="subt_duration" data-error="" value="<?=$details->subt_duration?>">

      <div class="form-body">
        <div class="col-md-12 form_padding"> 
          <div class="form-group">
            <p>Project Name : <?=$details->prj_name?></p>           
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Task Name : <?=$details->task_name?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Sub Task Name : <?=$details->subt_name?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Assignee : <?=$details->initials_full?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Duration : <?=$details->subt_duration?> Days</p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            Description : <?=$details->sub_description?>
          </div>
        </div>

      <div class="col-md-6 form_padding">  
      <div class="bottom validation-grids">                      
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Accept</button>
        </div>
        <br><br><div class="clearfix"> </div>
      </div>
    </div>

    </div>
  </div>
  
  </div>
</form> 
</div>

</div>
