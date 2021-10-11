 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Reservation Code</th><th>Project Name</th><th>Lot Number</th> <th>Customer Name </th><th>Total DI</th><th>Return Amount</th><th>Remark</th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->res_code?></th><td> <?=$row->project_name ?></td><td> <?=$row->lot_number ?></td> <td><?=$row->first_name ?> <?=$row->last_name ?></td> 
                        <td align="right"><?=number_format($row->total_di,2)?></td> 
                        <td align="right"><?=number_format($row->return_amount,2)?></td>
                         <td align="right"><?=$row->remark?></td>
                        <td align="right"><div id="checherflag">
                       <? if($row->status=='PENDING'){?>
                             <a  href="javascript:call_confirm('<?=$row->return_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete('<?=$row->return_id?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i></a>
                    <? }
					else{
						if(check_chancel_true($row->return_entry)){?>
					
                      <a  href="javascript:call_delete_confirm('<?=$row->return_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
         
                    <?  }}?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>  