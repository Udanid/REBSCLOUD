
<h4>Task Details<span  style="float:right; color:#FFF" ><a href="javascript:close_view('')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    
<form data-toggle="validator" method="post" action="" enctype="multipart/form-data">  
  <div class="row">
    <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <div class="form-body">
        <?if($projectdetails){?>
        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <label>Project</label>
            <input type="text" class="form-control" readonly  value="<?=$projectdetails->prj_name?>">
          </div>
        </div>
        <? } ?>

        <?if($taskdetails){?>
        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <label>Assignee</label>
            <input type="text" class="form-control" readonly  value="<?=$taskdetails->initials_full?>">
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Task Name</label>
            <input type="text" class="form-control" readonly value="<?=$taskdetails->task_name?>">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Duration</label>
            <input type="text" class="form-control" readonly value="<?=$taskdetails->task_duration?>">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors"></span>
          </div>
        </div>

      <div class="col-md-6 form_padding">       
        <div class="form-group has-feedback">
          <label>Description</label>
          <textarea class="form-control" readonly><?=$taskdetails->task_description?></textarea>
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <span class="help-block with-errors"></span>
        </div>
      </div>

      <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <label>Task Progress</label>
            <p style="text-align: center;font-size: 15px;"><?=$taskdetails->task_progress?>%</p>
             <div id="progress" class="progress progress-striped active">
              <?php if($taskdetails->task_progress>50){ ?>
                <div class="progress-bar progress-bar-success" style="width: <?=$taskdetails->task_progress?>%">                                                  
              </div>
             <? }else{ ?>
                <div class="bar red" style="width:<?=$taskdetails->task_progress?>%;"></div>
             <? } ?>                         
            </div>           
          </div>
        </div>
      <? } ?>

    <br><br><br>
    </div>
  </div>
  <div class="widget-shadow bs-example" data-example-id="contextual-table" > 
    <table class="table">
      <thead> 
        <tr> 
          <th>Sub Task Name</th> 
          <th>Duration </th>
          <th>Assignee</th> 
          <th>Progress</th> 
          <th>Status</th>
          <th></th>
        </tr> 
      </thead>                                          
              
      <? if($subtaskdetails){
          $c=0;
      ?>
        <tbody> 
        <?foreach ($subtaskdetails as $mainraw){?>                    
            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
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
              <? if($mainraw->subt_status  == 'pending'){?>
                  <td>Not Accepted</td>
              <?} ?>
              <? if($mainraw->subt_status  == 'processing'){?>
                  <td>Accepted</td>
              <?} ?>
              <? if($mainraw->subt_status  == 'completed'){?>
                  <td>Completed</td>
              <?}?>
            </tr>                          
        <?}?>
        </tbody>
        <?}?>
      </table>  
    </div> 
  </div>
</div>
<div class="clearfix"></div>  
</form> 
</div>
 <br /><br /><br /><br />
</div>