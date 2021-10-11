
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
            <p>Project Name : <?=$details->prj_name?></p>           
          </div>
        </div>

        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p>Project Create By : <?=$details->initial?> <?=$details->surname?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Task Name : <?=$details->task_name?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Duration : <?=$details->task_duration?> Days</p>
          </div>
        </div>

        <div class="col-md-6 form_padding">       
          <div class="form-group has-feedback">
            <p>Task Start Date : <?=$details->task_sdate?></p>
            
          </div>
        </div>

        <div class="col-md-6 form_padding">       
          <div class="form-group has-feedback">
          <p>Description : <?=$details->task_description?></p>          
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
            <th>Status</th>
            <th></th>
          </tr> 
        </thead>                                          
              
        <?foreach ($subtaskdetails as $mainraw){?>                    
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
