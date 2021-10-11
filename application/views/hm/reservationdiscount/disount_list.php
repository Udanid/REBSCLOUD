

                       <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Project Name</th><th>Lot Number</th> <th>Customer Name </th><th>Price List Value</th><th>Old Disounted Price</th><th>New Discount</th><th>New Discounted Price</th><th>Repay Amount</th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->project_name ?></td><td> <?=$row->lot_number ?>-<?=$row->plan_sqid ?></td> <td><?=$row->first_name ?> <?=$row->last_name ?></td> 
                          <td align="right"><?=number_format($row->sale_val,2)?></td> 
                             <td align="right"><?=number_format($row->old_discountedprice,2)?></td> 
                              <td align="right"><?=number_format($row->new_discount,2)?></td> 
                        <td align="right"><?=number_format($row->new_discountedprice,2)?></td> 
                        <td align="right"><?=number_format($row->repay_amount,2)?></td>
                        <td align="right"><div id="checherflag">
                       
                        <? if($row->res_status=='PENDING'){?>
                             <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                                </div>   
            