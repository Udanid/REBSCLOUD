
<h4>Task Extend<span  style="float:right; color:#FFF" ><a href="javascript:close_sub_extend('')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    
<form data-toggle="validator" method="post" action="<?=base_url()?>wip/task/extendadd" enctype="multipart/form-data">  
  <div class="row">
    <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <div class="form-body">
        <input type="hidden" class="form-control" value="<?=$taskextend->task_id?>" name="task_id">

        <input type="hidden" class="form-control" value="<?=$taskextend->task_duration?>" name="task_duration">
      
        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Task Name</label>
            <input type="text" class="form-control" readonly value="<?=$taskextend->task_name?>">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Current Duration</label>
            <input type="text" class="form-control" readonly value="<?=$taskextend->task_duration?>">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

      <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Current Task Progress</label>
            <p style="text-align: center;font-size: 15px;"><?=$taskextend->task_progress?>%</p>
            <div class="progress progress-striped active">
                <div class="bar green" style="width:<?=$taskextend->task_progress?>%;"></div>
           </div>
          </div>
      </div>

      <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Extend Days</label>
            <input type="number" class="form-control" name="extend_days" required="required">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

        <div class="col-md-6 form_padding">       
          <div class="form-group has-feedback">
            <label>Reason</label>
            <textarea class="form-control" id="task_description" name="reason" rows="2" required="required" placeholder="Reason For Extend"></textarea>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <button type="submit" id="btnsubmit" class="btn btn-primary">Submit</button>
          </div>
        </div>

    <br><br><br>
    </div>
  </div>  
  </div>
  </form>
</div>
<div class="clearfix"></div>  
 
</div>
 <br /><br /><br /><br />
</div>