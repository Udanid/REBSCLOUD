<?
 if(!empty($meterialrequestlist2)){
  /////// getting all meterial list
  if($meterialrequestlist2){

                            print_r($meterialrequestlist2);
                            $i=1;
                            foreach($meterialrequestlist2 as $metreqlist2){
                              if($i % 2 == 0){
                                  $clr = "#d9edf7";
                                }else{
                                  $clr = "#FFFFFF";
                                }
                             ?>
                             <tr bgcolor="<?=$clr?>">
                              <td><?=$i?></td> 
                              <td><?=$metreqlist2->project_name?></td>
                              <td><?=$metreqlist2->lot_id?></td>
                              <td><?=$metreqlist2->mat_name?> <?=$metreqlist2->mt_name?></td>
                              <td><?=$metreqlist2->qty?></td>
                              <td><?=$metreqlist2->req_date?></td>
                              <td><?
                              if($metreqlist2->reqini){
                                 echo $metreqlist2->reqini." ".$metreqlist2->reqsurname;
                              }else{
                                echo "Admin";
                              }
                              ?></td>
                              <td><?
                              
                              if($metreqlist2->confini && $metreqlist2->status!=="PENDING"){
                                echo $metreqlist2->confini." ".$metreqlist2->confsurname;
                              }else if($metreqlist2->status=="PENDING"){
                                echo "Not Approved/Cancelled Yet";
                              }else{

                              }
                              ?></td>
                              <td><?=$metreqlist2->status?></td>
                            </tr>
                             <? 
                              $i++;
                            }
                          }else{
                            ?>
                           <tr>
                             <td colspan="9">Nothing Found</td>
                           </tr>
                            <?
                          }
  /////// getting all meterial list 
 }else if(!empty($meterialrequestlist)){
  /////// getting pending meterials list
    if($meterialrequestlist){
                            
                            $i22=1;
                            foreach($meterialrequestlist as $metreqlist){
                              if($i22 % 2 == 0){
                                  $clr = "#d9edf7";
                                }else{
                                  $clr = "#FFFFFF";
                                }
                              if($metreqlist->status=="PENDING"){  
                             ?>
                             <tr bgcolor="<?=$clr?>"> 
                              <td><?=$i22?></td>
                              <td><?=$metreqlist->project_name?></td>
                              <td><?=$metreqlist->lot_id?></td>
                              <td><?=$metreqlist->mat_name?> <?=$metreqlist->mt_name?></td>
                              <td><?=$metreqlist->qty?></td>
                              <td><?=$metreqlist->req_date?></td>
                              <td><?
                              if($metreqlist->reqini){
                                echo $metreqlist->reqini." ".$metreqlist->reqsurname;
                              }else{
                                echo "Admin";
                              }
                              ?></td>
                              <td id="tbldata<?=$metreqlist->req_id?>">
                                <?
                                if (check_access('approve_disapprove_metrequest'))//call from access_helper
                                {
                                ?>
                                <a href="javascript:approve('<?=$metreqlist->req_id?>')" title="Confirm This"><i class="fa fa-check nav_icon icon_green"></i></a>
                                <a href="javascript:disapprove('<?=$metreqlist->req_id?>')" title="Reject This"><i class="fa fa-close nav_icon icon_red"></i></a>
                                <?
                                }
                                ?>
                              </td>
                            </tr>
                             <? 
                             $i22++;
                            }
                           }
                          }
  /////// getting pending meterials list
 }
?>