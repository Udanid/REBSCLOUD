<h4>Sub Task Details<span  style="float:right; color:#FFF" ><a href="javascript:close_viewsubtask('')"><i class="fa fa-times-circle "></i></a></span></h4>

<div class="table widget-shadow">
 	<div class="row">
        <div class="col-md-12" data-example-id="basic-forms"> 
            <div class="form-body">
            	<div class="form-group">

                    <strong class="redtext">Project Name : </strong> 
                    <?=$details->prj_name?>             
                </div>

                <div class="form-group">
                    <strong class="redtext">Task Name : </strong> 
                    <?=$details->task_name?>             
                </div>

                <div class="form-group">
                    <strong class="redtext">Sub Task Name : </strong> 
                    <?=$details->subt_name?>               
                </div> 

                <div class="form-group">
                    <strong class="redtext">Create By : </strong> 
                    <?=$details->initials_full?>               
                </div>
                <div class="form-group">
                    <strong class="redtext">Created Date : </strong> 
                    <?=$details->subt_createdate?>                
                </div>

                <? if($details->subt_sdate!=''){?>
                <div class="form-group">
                    <strong class="redtext">Task Start Date / End Date : </strong> 
                    <?=$details->subt_sdate?> / <?=$details->subt_edate?>                
                </div>
                <?}?>                 

                <div class="form-group">
                    <strong class="redtext">Progress : </strong> 
                    <?=$details->subt_progress?>%
                    <div id="progress" class="progress progress-striped active">
                      <?php if($details->subt_progress>50){ ?>
                        <div class="progress-bar progress-bar-success" style="width: <?=$details->subt_progress?>%">                                                  
                      </div>
                     <? }else{ ?>
                        <div class="bar red" style="width:<?=$details->subt_progress?>%;"></div>
                     <? } ?>                         
                    </div>

                </div>

                <div class="form-group">
                    <strong class="redtext">Duration : </strong> 
                    <?=$details->subt_duration?>  Days             
                </div>          
               
                <div class="form-group bg-yellow-100 p-4">
                	<br>
                    <strong class="redtext">Description : </strong>
                    <br>
                    <p><?=$details->sub_description?></p>           
                    <br><br>
                </div>
                <div class="form-group" style="border-top:1px solid #999;">
                    <strong class="redtext">Attachments :</strong>
                    <? 
                        if($attachments){ 
                            foreach ($attachments as $row) { ?>
                               <a href="<?=base_url()?><?= $row->file_path ?>" target="_blank"><?= $row->file_name ?>,</a>                          
                       <? }}

                    ?>
                    <br> 
                </div>
                <div class="form-group">
                    <strong class="redtext">Comments : </strong> 
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                          <? 
                          if($comments){
                            $c=0;
                            ?> 
                             <table class="table"> 
                                <thead> 
                                    <tr>
                                        <th>Date</th> 
                                        <th>Progress</th> 
                                        <th>Comments</th>
                                    </tr> 
                                </thead> 
                                <tbody>
                                    <?foreach ($comments as $row) {?>
                                        <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                            <td><?=$row->updated_date?></td>
                                            <td><?=$row->cmnt_progress?>%</td>
                                            <td><?=$row->comment?></td>
                                        </tr>                       
                                        <?       
                                    }?>
                                </tbody>
                            </table>
                            <?}?>
                        </div>
                   </div>

                </div>
            </div>
       </div>
    </div>
<!--ends widget-shadow-->
</div>