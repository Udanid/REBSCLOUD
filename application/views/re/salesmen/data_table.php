
 <div class="alert alert-success" role="alert">
						Sales Officer successfully insrted
				</div>
<table class="table"> <thead> <tr> <th>Employee Code</th> <th>Name</th> <th>Project Name</th> <th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->id?></th> <td><?=$row->initial ?> <?=$row->surname ?></td>
                          <td><?=$row->project_name ?></td>
                        <td><?=$row->status ?></td>
                        <td align="right"><div id="checherflag">
                              <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                       </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>