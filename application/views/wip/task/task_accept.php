<script>
function taskReject(){
  var reason = $('#reason').val();
  var task_id = '<?=$details->task_id?>';
  var formatted = reason.replace(/(\r\n|\n|\r)/gm,"<br>");
  if(reason == ''){
    formatted = 'No reason.';
  }
  var encoded = encodeURIComponent(window.btoa(formatted));
  window.location="<?=base_url()?>wip/task/reject/"+task_id+"/"+encoded;
}
</script>
<h4>Task Details<span  style="float:right; color:#FFF" ><a href="javascript:close_accept('')"><i class="fa fa-times-circle "></i></a></span></h4>   
    </div>
</div>


<div class="table widget-shadow">
 <div class="row">
                    
<form data-toggle="validator" method="post" action="<?=base_url()?>wip/task/task_accept_add" enctype="multipart/form-data">  
  <div class="row">
    <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$details->task_id?>">
      <div class="form-body">
        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p><strong>Project Name</strong> : <?=$details->prj_name?></p>           
          </div>
        </div>

        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p><strong>Project Create By</strong> : <?=$details->initial?> <?=$details->surname?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p><strong>Task Name</strong> : <?=$details->task_name?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p><strong>Duration</strong> : <?=$details->task_duration?> Days</p>
          </div>
        </div>

        <div class="col-md-6 form_padding">       
          <div class="form-group has-feedback">
            <p><strong>Task Start Date</strong> : <?=$details->task_sdate?></p>
            
          </div>
        </div>

        <div class="col-md-6 form_padding">       
          <div class="form-group has-feedback">
          <p><strong>Description</strong> : <?=$details->task_description?></p>          
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
    <div class="col-md-6 form_padding">  
        <div class="bottom validation-grids">                      
          
            <textarea class="form-control" name="reason" id="reason" placeholder="Reject Reason"></textarea>
                  
          <br>
            <button type="button" onClick="taskReject();" class="btn btn-danger form-control">Reject</button>
          
          <br><br><div class="clearfix"> </div>
        </div>
      </div>

      <div class="col-md-6 form_padding">       
        <div class="form-group has-feedback">
          <p>Task File Attachment : </p>
          <?  if($get_task_file_attachment){
            foreach ($get_task_file_attachment as $key => $row) { ?>
              <a href="<?=base_url()?><?= $row->file_path ?>" target="_blank"><?= $row->file_name ?></a>
              <br>       
          <? }} ?>                
        </div><br>
      </div>

    <br><br><br>
    </div>
  </div>
  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
    <? if($subtaskdetails){?> 
      <table class="table"> 
        <thead> 
          <tr> 
            <th>Sub Task Name</th> 
            <th>Duration </th>
            <th>Assignee</th> 
            <th>Progress</th>
            <th>Attachments</th> 
            <th>Status</th>
            <th></th>
          </tr> 
        </thead>                                          
              
        <?foreach ($subtaskdetails as $mainraw){?> 

          <?
            date_default_timezone_set('Asia/Colombo');
            $ci =&get_instance();
            $ci->load->model('wip/Sub_task_model');

            $get_sub_task_file_attachment = $ci->Sub_task_model->get_task_file_attachment($mainraw->subt_id);
          ?>

          <tbody> 
            <tr>
              <td>
              <?=$mainraw->subt_name?>
              </td>
              <td>
                <?=$mainraw->subt_duration?> Days
              </td>
              <td>
                <?=$mainraw->initials_full?>
              </td>
              <td>
                <?=$mainraw->subt_progress?>%
              </td>

              <td>
                <? if($get_sub_task_file_attachment){ ?>
                    <? 
                      foreach ($get_sub_task_file_attachment as $key => $row) { ?>
                        <a href="<?=base_url()?><?= $row->file_path ?>" target="_blank"><?= $row->file_name ?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=base_url()?><?= $row->file_path ?>" title="Print" onclick="window.print();return false;"><i class="fa fa-print nav_icon icon_blue"></i></a>
                        <br>       
                    <? } ?>
                <? } ?>
              </td>

              <td>
                <? if($mainraw->subt_status  == 'pending'){?>
                  Not Accepted
                <?} ?>
                <? if($mainraw->subt_status  == 'processing'){?>
                  Accepted
                <?} ?>
                <? if($mainraw->subt_status  == 'completed'){?>
                  Completed
                <?} ?>
              </td>
            </tr>                          
          </tbody>
        <?}?>
        </table>
      <?}?>  
    </div> 
  </div>
</div>
<div class="clearfix"></div>  
</form> 
</div>
 <br /><br /><br /><br />
</div>
