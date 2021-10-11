     <table class="table"> <thead> <tr> <th>Project Name</th><th>Lot Number</th> <th>Customer Name </th> <th>Customer NIC </th ><th>Reserve Date </th ><th style="text-align:right;">Sale Value</th><th style="text-align:right;">Discount</th><th style="text-align:right;">Discounted Price</th><th style="text-align:right;">Minimum Down Payment</th><th style="text-align:center;">DP Completion Date</th><th>Create By </th><th>Confirm By </th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->project_name ?></td><td> <?=$row->lot_number ?>-<?=$row->plan_sqid ?></td> <td><a  href="javascript:viewCustomer('<?=$row->cus_code?>')" title="View Customer Info"><?=$row->first_name ?> <?=$row->last_name ?></a></td> <td><?=$row->id_number ?></td><td><?=$row->res_date?></td>
                          <td align="right"><?=number_format($row->seling_price,2)?></td> 
                             <td align="right"><?=number_format($row->discount,2)?></td>
                              <td align="right"><?=number_format($row->discounted_price,2)?></td>
                        <td align="right"><?=number_format($row->min_down,2)?></td>
                        <td align="center"><?=$row->dp_cmpldate?></td>
                         <td><?=get_user_fullname($row->apply_by)?></td>
                               <td><?=get_user_fullname($row->confirm_by)?></td>

                        <td align="right"><div id="checherflag">


                        <? if($row->res_status=='PENDING'){?>
                         <a  href="javascript:check_activeflag('<?=$row->res_code?>')" title="Confirm"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                             <a  href="javascript:call_confirm('<?=$row->res_code?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete('<?=$row->res_code?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr>

                                <? }} ?>
                          </tbody></table>