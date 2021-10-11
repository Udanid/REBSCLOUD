<? /*
                          		$i2=1;
                                foreach($grnlist2 as $grn2){
                              	?>
                          		<tr>
                          			<td><?=$i2?></td>
                          			<td>GRN NO <?=$grn2->grn_code?> (GRN Date <?=$grn2->gr_date?>)</td>
                          			<td><?=$grn2->status?></td>
                          			<td id="actions<?=$grn2->grn_id?>">
                          			  <?
                          			   if($grn2->status=="CONFIRMED"){
                                       ?>
                                       <a  href="javascript:viewgrn('<?=$grn2->grn_id?>_CONFIRMED')" title="View Confirmed GRN"><i class="fa fa-eye nav_icon icon_green"></i></a>
                                       <?
                          			   }else if($grn2->status=="CANCELLED"){
                                       ?>
                                       <a  href="javascript:viewgrn('<?=$grn2->grn_id?>_CANCELLED')" title="View Cancelled GRN"><i class="fa fa-eye nav_icon icon_red"></i></a>
                                       <?
                          			   }else if($grn2->status=="PENDING"){
                                       ?>
                                       <a  href="javascript:viewgrn('<?=$grn2->grn_id?>_PENDING')" title="View Pending GRN"><i class="fa fa-eye nav_icon icon_black" style="color:yellow;"></i></a>
                                       <?
                          			   }
                          			  ?>	
                                      
                                    </td>
                          		</tr>
                          		<?
                          		 $i2++;
                                } */

<?
                              $i2=1;
                                foreach($grnlist2 as $grn2){
                                ?>
                              <tr>
                                <td><?=$i2?></td>
                                <td>GRN <?=$grn2->grn_code?></td>
                                <td><?=$grn2->gr_date?></td>
                                <th><?=$grn2->grnqty?></th>
                                <th><?=$grn2->sup_id?></th>
                                <td><?=get_prjname($grn2->prjid)?>/<?=$grn2->req_date?>/<?=get_user_fullname_id($grn2->po_requestby)?></td>
                                <td><?=$grn2->poconfirmdate?> By <?=get_user_fullname_id($grn2->poconfirmby)?></td>
                                <td><a href="javascript:pop_upwindow('<?=$grn2->prpoid?>','view')">PO <?=$grn2->prpoid?></a></td>
                                <td><?=$grn2->gr_date?> by <?=get_user_fullname_id($grn2->recieved_by)?></td>
                                <td>
                                  <?
                                        if($grn2->confirmed_by){
                                          echo $grn2->confirmed_date?> by <?=get_user_fullname_id($grn2->confirmed_by);  
                                        }
                                  ?>
                                    
                                </td>
                                <td><?=$grn2->grnstts?></td>
                                <td id="actions<?=$grn2->grn_id?>">
                                  <?
                                   if($grn2->grnstts=="CONFIRMED"){
                                       ?>
                                       <a  href="javascript:viewgrn('<?=$grn2->grn_id?>_CONFIRMED')" title="View Confirmed GRN"><i class="fa fa-eye nav_icon icon_green"></i></a>
                                       <?
                                   }else if($grn2->grnstts=="CANCELLED"){
                                       ?>
                                       <a  href="javascript:viewgrn('<?=$grn2->grn_id?>_CANCELLED')" title="View Cancelled GRN"><i class="fa fa-eye nav_icon icon_red"></i></a>
                                       <?
                                   }else if($grn2->grnstts=="PENDING"){
                                       ?>
                                       <a  href="javascript:viewgrn('<?=$grn2->grn_id?>_PENDING')" title="View Pending GRN"><i class="fa fa-eye nav_icon icon_black" style="color:yellow;"></i></a>
                                       <?
                                   }
                                  ?>  
                                      
                                    </td>
                              </tr>
                              <?
                               $i2++;
                                }
                              ?>

                          		?>