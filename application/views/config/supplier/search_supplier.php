  <table class="table"> <thead> <tr> <th>Supplier/ Vendor Code</th> <th>Name</th> <th>Mobile </th> <th>email</th> <th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->sup_code?></th> <td><?=$row->first_name ?> <?=$row->last_name ?></td> <td><?=$row->mobile?></td>
                        <td><?=$row->email?></td> 
                        <td><?=$row->status ?></td>
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:check_activeflag('<?=$row->sup_code?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                        <? if($row->status=='PENDING'){?>
                             <a  href="javascript:call_confirm('<?=$row->sup_code?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete('<?=$row->sup_code?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table> <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />