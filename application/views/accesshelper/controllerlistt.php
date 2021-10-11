  <table class="table"> <thead> <tr>  <th>ID</th><th>Menu</th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->controle_id ?></th> <td><?=$row->controller_name ?></td>
                       
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:call_delete_controller('<?=$row->controle_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                  
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table> 