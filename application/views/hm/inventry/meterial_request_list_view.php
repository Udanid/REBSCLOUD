<?
                          if($meterialrequestlist2){
                            $i=1;
                            foreach($meterialrequestlist2 as $metreqlist2){
                             ?>
                             <tr> 
                              <td><?=$i?></td> 
                              <td><?=get_prjname($metreqlist2->prj_id)?></td>
                              <td><?
                              if($metreqlist2->lot_id!==0){
                               $mat=get_meterials_all($metreqlist2->lot_id)?><?=$mat->mat_name?> <?=$mat->mt_name?>
                              } ?>
                              </td>
                              <td><?=$metreqlist2->mat_name?></td>
                              <td><?=$metreqlist2->qty?></td>
                              <td><?=$metreqlist2->req_date?></td>
                              <td><?
                              if($metreqlist2->initials_full){
                                echo $metreqlist2->initials_full;
                              }else{
                                echo "Admin";
                              }
                              ?></td>
                              <td><?
                              
                              if($metreqlist2->confirmby && $metreqlist2->status!=="PENDING"){
                                echo $metreqlist2->confirmby;
                              }else if($metreqlist2->confirmby=="" && $metreqlist2->status!=="PENDING"){
                                echo "Admin";
                              }else{

                              }
                              ?></td>
                              <td><?=$metreqlist2->status?></td>
                            </tr>
                             <? 
                             $i++;
                            }
                          }
                          ?>