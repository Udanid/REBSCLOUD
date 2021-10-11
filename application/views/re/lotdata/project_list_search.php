     <table class="table"> <thead> <tr> <th>Project ID</th> <th>Project Name</th>  <th>Land Extent</th><th>Project Officer </th> <th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->project_code?></th> <td><?=$row->project_name ?></td> <td> <?=$row->selable_area ?></td>
                        <td><?=$row->initial?>&nbsp; <?=$row->surname?></td> 
                        <td><?=$row->price_status ?></td>
                        <td align="right"><div id="checherflag">
                      
                           <a  href="javascript:load_lotdetails('<?=$row->prj_id?>')" title="Block Out Plans"  ><i class="fa fa-sitemap nav_icon icon_blue"></i></a>
                         <? if($row->price_status=='PENDING'){?>
                             <a  href="javascript:call_confirm('<?=$row->prj_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                                <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  <br /><br /><br /><br /><br /><br /><br /><br />