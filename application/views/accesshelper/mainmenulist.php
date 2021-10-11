  <table class="table"> <thead> <tr> <th>Module</th> <th>Main Menu</th><th>Url</th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->module_name?></th> <td><?=$row->menu_name ?></td>
                        <td><?=$row->url ?></td>
                       
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:call_delete('<?=$row->main_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                  
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table> 