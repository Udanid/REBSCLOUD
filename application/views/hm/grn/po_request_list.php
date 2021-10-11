<?
                       if($reqmeterial){
                         ?>
                         <table class="table" id="purchase_table" width="50%" >
                         <thead>
                          <tr>
                            <th>Request Project</th>
                            <th>Meterial</th>
                            <th>Request Quantity</th>
                            <th></th>
                          </tr>
                         </thead>
                         <tbody>
                         <?
                         foreach($reqmeterial as $rmet){
                           ?>
                           <tr>
                              <td><strong><?=get_prjname($rmet->prj_id)?></strong></td>
                              <td><strong><? $mat=get_meterials_all($rmet->mat_id)?><?=$mat->mat_name?> <?=$mat->mt_name?></strong></td>
                              <td><strong><?=$rmet->qty?></strong></td>
                              <td>
                              <?
                               if(get_available_sitestocks($rmet->mat_id,$rmet->prj_id,$rmet->qty)>0){
                              ?>
                              <a data-toggle="collapse" id="btn<?=$rmet->mat_id?>" data-target="#transfer<?=$rmet->mat_id?><?=$rmet->prj_id?>" title="View Full"><span id="ico<?=$rmet->mat_id?>"><i class="fa fa-exchange"></i></span></a>
                              <?
                               }
                              ?>
                              </td>
                           </tr>
                           <tr id="transfer<?=$rmet->mat_id?><?=$rmet->prj_id?>" class="collapse">
                             <td colspan="4">
                                <?
                                 $availablesiteqty = get_available_sitestocks($rmet->mat_id,$rmet->prj_id,$rmet->qty);
                                ?>
                                <table class="table">
                                    <tr>
                                      <th>Project/batch code</th>
                                      <th>Available Quantity</th>
                                      <th>Requested Quantity</th>
                                      <th></th>
                                    </tr>
                                    <?
                                     foreach($availablesiteqty as $avlqty){
                                       ?>
                                       
                                       <tr>
                                        <td><?=get_prjname($avlqty->prj_id)?>/<?=$avlqty->batch_code?></td>
                                        <td><?=$avlqty->balanceqty?></td>
                                        <td><input type="text" name="transqty" readonly value="<?=$rmet->qty?>"></td>
                                        <td>
                                        <form action="<?=base_url()?>hm/hm_grn/transfer_stock_process" method="post">
                                        <input type="hidden" name="fromprj" value="<?=$avlqty->prj_id?>">
                                        <input type="hidden" name="toprj" value="<?=$rmet->prj_id?>">
                                        <input type="hidden" name="transferqty" value="<?=$rmet->qty?>">
                                        <input type="hidden" name="materialid" value="<?=$rmet->mat_id?>">
                                        <input type="hidden" name="stockid" value="<?=$avlqty->stock_id?>">
                                        <input type="hidden" name="price" value="<?=$avlqty->siteprice?>">
                                        <input type="hidden" name="sitestockid" value="<?=$avlqty->site_stockid?>">
                                        <input type="hidden" name="porequestid" value="<?=$rmet->req_id?>">
                                        <input type="hidden" name="transqty" value="<?=$avlqty->trans_qty?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Transfer</button>
                                        </form>
                                        </td>
                                       </tr>
                                       
                                       <?
                                     }
                                    ?>
                                </table>
                             </td>
                           </tr>
                           <?
                         }
                       }
                      ?>
                       </tbody>
                      </table>