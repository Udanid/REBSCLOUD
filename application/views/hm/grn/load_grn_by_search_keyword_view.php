<?
 if(!empty($grnlist)){
  //print_r($grnlist);
   if($grnlist){
                          		$i=1;
                                foreach($grnlist as $grn){
                                	if($i % 2 == 0){
	                                  $clr = "#d9edf7";
	                                }else{
	                                  $clr = "#FFFFFF";
	                                }
                                  if($grn->grnstts=="PENDING"){
                              	?>
                          		<tr bgcolor="<?=$clr?>">
                          			<td><?=$i?></td>
                          			<td><?=$grn->grn_code?></td>
                          			<td><?=$grn->gr_date?></td>
                          			<th><?=$grn->grnqty?></th>
                          			<th><?=$grn->first_name?> <?=$grn->last_name?></th>
                          			<td><?=$grn->project_name?>/<?=$grn->req_date?>/<?=$grn->poreqiniby." ".$grn->poreqsurby?></td>
                          			<td><?=$grn->poconfirmdate?> By <?=$grn->poconfiniby." ".$grn->poconfsurby?></td>
                          			<td><a href="javascript:pop_upwindow('<?=$grn->prpoid?>','view')">PO <?=$grn->prpoid?></a></td>
                          			<td><?=$grn->gr_date?> by <?=$grn->grnreqiniby." ".$grn->grnreqsurby?></td>
                          			<td id="actions<?=$grn->grn_id?>">
                          		    <?
                          		     if (check_access('grn_approve'))//call from access_helper
                                    {
                          		    ?>		
                          			<a  href="javascript:edit_grn('<?=$grn->grn_id?>')" title="Edit GRN"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                                    <a  href="javascript:approve_grn('<?=$grn->grn_id?>')" title="Approve GRN"><i class="fa fa-check nav_icon icon_green"></i></a>
                                    <a  href="javascript:cancel_grn('<?=$grn->grn_id?>')" title="Cancel GRN"><i class="fa fa-times nav_icon icon_red"></i></a>
                                    <?
                                     }
                                    ?>
                          			</td>
                          		</tr>
                          		<?
                              }
                          		 $i++;
                                }
                              }
                              else{
                                echo "No Data";
                              }
                            }
 else if(!empty($grnlist2)){
   if($grnlist2){
                              $i2=1;
                                foreach($grnlist2 as $grn2){
                                  if($i2 % 2 == 0){
                                    $clr = "#d9edf7";
                                  }else{
                                    $clr = "#FFFFFF";
                                  }
                                ?>
                              <tr bgcolor="<?=$clr?>">
                                <td><?=$i2?></td>
                                <td>GRN <?=$grn2->grn_code?></td>
                                <td><?=$grn2->gr_date?></td>
                                <th><?=$grn2->grnqty?></th>
                                <th><?=$grn2->first_name?> <?=$grn2->last_name?></th>
                                <td><?=$grn2->project_name?>/<?=$grn2->req_date?>/<?=$grn2->poreqiniby." ".$grn2->poreqsurby?></td>
                                <td><?=$grn2->poconfirmdate?> By <?=$grn2->poconfiniby." ".$grn2->poconfsurby?></td>
                                <td><a href="javascript:pop_upwindow('<?=$grn2->prpoid?>','view')">PO <?=$grn2->prpoid?></a></td>
                                <td><?=$grn2->gr_date?> by <?=$grn2->grnreqiniby." ".$grn2->grnreqsurby?></td>
                                <td>
                                  <?
                                        if($grn2->grnconfiniby){
                                          echo $grn2->confirmed_date?> by <?=$grn2->grnconfiniby." ".$grn2->grnconfsurby;  
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
                              }else{
                                echo "No Data";
                              }
                            }
                              ?>                              