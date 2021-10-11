<style type="text/css">
	#imgloaddiv{
		padding-left: 20px;
	}
</style>
 		<h4>Project Progress Images<span  style="float:right; color:#FFF" ><a href="javascript:close_edit(10)"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row" id="imgloaddiv">
                     
								<?
									 if($projectprogressimg){
									 	$nmbr = 1;
									 	foreach($projectprogressimg as $ppimg){
									 	$heading = get_prjname($ppimg->prj_id)."/ UNIT ".get_unitname($ppimg->lot_id)."/".$ppimg->description;	
									 		?>		
									
										<br><strong><?=$heading?> : image <?=$nmbr?></strong><br>
                                            <?
                                            if($ppimg->image){
                                            ?>
                                            
										    <a target="_blank" href="<?=base_url()?>uploads/project_progress/<?=$ppimg->image?>"><img src="<?=base_url()?>uploads/project_progress/<?=$ppimg->image?>" width="80%" height="auto"></a><br> 

										    
										     
                                            <?
                                             }else{
                                             	echo "No images Upload";
                                             }
                                            ?>
										    <hr>
									
                                   			<?

                                   			$nmbr =$nmbr+1;
									 	}
									 }
									 ?>
					   </div>
<br /><br /><br /><br /></div>
