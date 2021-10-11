<div class="table widget-shadow">
<table class="table" width="90%"> <thead> <tr> <th> Sub Task code</th> <th>Task name</th> <th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <td scope="row"><?=$row->subtask_code?></th> <td><?=$row->subtask_name?></td> <td><?=$row->status?></td> 
                     <td> <? if($row->status=='PENDING'){?>
                             <a  href="javascript:call_confirm_subtask('<?=$row->subtask_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete_subtask('<?=$row->subtask_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  



				            
                                    
                                 <br /></div>