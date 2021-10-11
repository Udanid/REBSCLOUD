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
    <tr>
        <td>
			<?
             if(empty($progressproject)){
                
                $prgrsss=0;
                if($prgrsss>=60) $class='green'; else if($prgrsss<60 && $prgrsss>=50)  $class='blue'; else if($prgrsss<50 && $prgrsss>=25)  $class='yellow'; else $class='red';?>
            
                           <!--     <div class="task-info">
                              <span class="task-desc">No Progress </span><span class="percentage"><?= number_format($prgrsss,2)?>%</span>
                                 <div class="clearfix"></div> 
                              </div>
                              <div class="progress progress-striped active">
                                 <div class="bar <?=$class?>" style="width:<?=$prgrsss?>%;"></div>
                              </div> -->
                              <?
             }else{
				$estimate = get_stage_estimated_enddate($progressproject['prj_id'],$progressproject['lot_id'],$progressproject['stage_id']); //hmaccount_helper function
                $heading = get_prjname($progressproject['prj_id'])."/ UNIT ".get_unitname($progressproject['lot_id'])."/".$progressproject['stage'];
                $prgrsss=$progressproject['curprogress'];
                if($prgrsss>=60) $class='green'; else if($prgrsss<60 && $prgrsss>=50)  $class='blue'; else if($prgrsss<50 && $prgrsss>=25)  $class='yellow'; else $class='red';?>
            
                                <div class="task-info">
                              <span class="task-desc"><strong><?=$heading?></strong></span><span class="percentage"><?= number_format($prgrsss,2)?>%</span>
                                 <div class="clearfix"></div> 
                              </div>
                              <div class="progress progress-striped active">
                                 <div class="bar <?=$class?>" style="width:<?=$prgrsss?>%;"></div>
                              </div>
            
                              <br><br>
                              <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>Remark</th>
                                    <th>Created Date</th>
                                    <th>Created by</th>
                                    <th></th>
                                </tr>
                                <tbody>
                                    <?
                                    $i=1;
									if(!empty($progressactions))
                                    foreach($progressactions as $prgprj){
                                    ?>
                                    <tr>
                                      <td><?=$i?></td>
                                      <td><?=$prgprj->progress?></td>
                                      <td><?=$prgprj->update_date?></td>
                                      <td><?=get_user_fullname_id($prgprj->updated_by)?></td>
                                      <td><a href="javascript:viewprogressimages(<?=$prgprj->id?>)"><i class="fa fa-eye" title="View Progress images"></i></a></td>
                                    </tr>
                                    <?
                                     $i++;
                                     }
                                    ?>
                                </tbody>
                              </table>
                              
            </td>
            <td style="text-align:right;"><?=$progressproject['end_date']?></td>
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
	?>
  </tbody>
</table>
