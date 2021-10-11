<table class="table">
  <thead>
    <tr>
      <th>Progress</th>
      <th style="text-align:right;">Planned End</th>
      <th style="text-align:right;">Projected End</th>
      <th style="text-align:center;">Diff (Days)</th>
      <th style="text-align:center;">Req. Completion</th>
    </tr>
  </thead>
  <tbody>
  	
  <?
  if(!empty($finarr)){ 
  foreach($finarr as $key => $value){
  ?>
      <tr>
          <td>
              <?
              $shortcode = $value['short_code'];
              $prgress = $value['progressvalue'];
			 
          	  $estimate = get_stage_estimated_enddate($value['prj_id'],$value['lot_id'],$value['code_id']); //hmaccount_helper function
			  
                  $heading = get_prjname($value['prj_id'])."/ UNIT ".get_unitname($value['lot_id'])."/".$value['short_code'];
              
              if($prgress>=60) $class='green'; else if($prgress<60 && $prgress>=50)  $class='blue'; else if($prgress<50 && $prgress>=25)  $class='yellow'; else $class='red';?>
          
                              <div class="task-info">
                            <span class="task-desc"><strong><?=$heading?></strong></span><span class="percentage"><?= number_format($prgress,2)?>% &nbsp;&nbsp;<a data-toggle="collapse" class="success" id="btn<?=$value['prj_id']?><?=$value['lot_id']?>" data-target="#demo<?=$value['prj_id']?><?=$value['lot_id']?><?=$value['code_id']?>" title="Expand"><span id="ico<?=$value['prj_id']?><?=$value['lot_id']?>"><i class="fa fa-plus-circle"></i></span></a></span>
                               <div class="clearfix"></div> 
                            </div>
                            <div class="progress progress-striped active">
                               <div class="bar <?=$class?>" style="width:<?=$prgress?>%;"></div>
                            </div>
                           
                            <div id="demo<?=$value['prj_id']?><?=$value['lot_id']?><?=$value['code_id']?>" class="collapse">
                            <table class="table" width="80%">
                              <tr>
                                  <th>#</th>
                                  <th width="50%">Remark</th>
                                  <th width="10%">Created Date</th>
                                  <th width="10%">Created by</th>
                                  <th width="10%">Confirm Date</th>
                                  <th width="10%">Confirm by</th>
                                  <th width="10%"></th>
                              </tr>
                              <tbody>
                                  <?
                                  $i=1;
                                  foreach($value['progressstages'] as $prgprj){
                                  ?>
                                  <tr>
                                    <td><?=$i?></td>
                                    <td width="50%"><?=$prgprj->progress?></td>
                                    <td width="10%"><?=$prgprj->update_date?></td>
                                    <td width="10%"><?=get_user_fullname_id($prgprj->updated_by)?></td>
                                    <td width="10%"><?=$prgprj->confirm_date?></td>
                                    <td width="10%"><?=get_user_fullname_id($prgprj->confirm_by)?></td>
                                    <td width="10%"><a href="javascript:viewprogressimages(<?=$prgprj->id?>)"><i class="fa fa-eye" title="View Progress images"></i></a></td>
                                  </tr>
                                  <?
                                   $i++;
                                   }
                                  ?>
                              </tbody>
                            </table>
                            </div>
                            <hr>
                           
            </td>
            <td style="text-align:right;"><?=$value['end_date']?></td>
            <td style="text-align:right;"><? echo $estimate['end_date'];?></td>
            <td style="text-align:center;">
           		<span <? if($estimate['day_difference'] > 0 ){?> style="color:#F00;" <? }else{?> style="color:#090;" <? }?>>
					<? echo $estimate['day_difference'];?>
                </span>
            </td>
            <td style="text-align:center;"><? echo $estimate['completion'];?></td>
        </tr>
     <?
		}
	}
	?>
  </tbody>
</table>
