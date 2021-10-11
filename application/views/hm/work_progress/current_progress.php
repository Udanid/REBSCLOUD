<? 
 if(empty($prgress)){
 	$prgrsss=0;
 	if($prgrsss>=60) $class='green'; else if($prgrsss<60 && $prgrsss>=50)  $class='blue'; else if($prgrsss<50 && $prgrsss>=25)  $class='yellow'; else $class='red';?>

                    <div class="task-info">
                  <span class="task-desc">No Progress </span><span class="percentage"><?= number_format($prgrsss,2)?>%</span>
                     <div class="clearfix"></div> 
                  </div>
                  <div class="progress progress-striped active">
                     <div class="bar <?=$class?>" style="width:<?=$prgrsss?>%;"></div>
                  </div>
                  <?
 }else{
 	$prgrsss=$prgress->progress;
 	if($prgrsss>=60) $class='green'; else if($prgrsss<60 && $prgrsss>=50)  $class='blue'; else if($prgrsss<50 && $prgrsss>=25)  $class='yellow'; else $class='red';?>

                    <div class="task-info">
                  <span class="task-desc"><?=get_prjname($prgress->prj_id)?> / UNIT <?=get_unitname($prgress->lot_id)?> / <?=$prgress->description?></span><span class="percentage"><?= number_format($prgrsss,2)?>%</span>
                     <div class="clearfix"></div> 
                  </div>
                  <div class="progress progress-striped active">
                     <div class="bar <?=$class?>" style="width:<?=$prgrsss?>%;"></div>
                  </div>
                  <?
 }
 ?>

	<div class="form-group">
       <?
        if($prgrsss==100){
        ?>
        <input type="hidden" name="prevprogress" value="<?=$prgrsss?>">
        <input type="number" min="<?=$prgrsss?>" max="100" name="curprogress" id="curprogress" class="form-control" value="<?=$prgrsss?>" readonly="readonly">
        <?
        }else{
        ?>
        <label>Progress (enter between <?=$prgrsss?> & 100)</label>
        <input type="hidden" name="prevprogress" value="<?=$prgrsss?>">
        <input type="number" min="<?=$prgrsss?>" max="100" name="curprogress" id="curprogress" class="form-control" required="required">
        <?
        }
       ?>
       
	</div>

                    
                    