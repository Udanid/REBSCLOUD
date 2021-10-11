<?
 foreach ($finarr as $key => $value) {

 	$shortcode = $value['short_code'];
    $prgress = $value['progress'];
  
     if($prgress==0){
 	$prgress=0;
 	if($prgress>=60) $class='green'; else if($prgress<60 && $prgress>=50)  $class='blue'; else if($prgress<50 && $prgress>=25)  $class='yellow'; else $class='red';?>

                    <div class="task-info">
                  <span class="task-desc"><?=$shortcode?></span><span class="percentage"><?= number_format($prgress,2)?>%</span>
                     <div class="clearfix"></div> 
                  </div>
                  <div class="progress progress-striped active">
                     <div class="bar <?=$class?>" style="width:<?=$prgress?>%;"></div>
                  </div>
                  <?
 }else{
 	if($prgress>=60) $class='green'; else if($prgress<60 && $prgress>=50)  $class='blue'; else if($prgress<50 && $prgress>=25)  $class='yellow'; else $class='red';?>

                    <div class="task-info">
                  <span class="task-desc"><?=$shortcode?></span><span class="percentage"><?= number_format($prgress,2)?>%</span>
                     <div class="clearfix"></div> 
                  </div>
                  <div class="progress progress-striped active">
                     <div class="bar <?=$class?>" style="width:<?=$prgress?>%;"></div>
                  </div>
                  <?
 }
    
 }
?>


