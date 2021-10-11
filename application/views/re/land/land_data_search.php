<table class="table"> <thead> <tr> <th>Land Code</th> <th>Owner Name</th>  <th>Property Name</th><th>District </th> <th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->land_code?></th> <td><?=$row->owner_name ?></td> <td> <?=$row->property_name ?></td>
                        <td><?=$row->district?></td>
                        <td><?=$row->status ?></td>
                        <td align="right"><div id="checherflag">
													<a  href="javascript:view_confirm('<?=$row->land_code?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>

                           <a  href="javascript:call_comment('<?=$row->land_code?>')"><i class="fa fa-comments-o nav_icon icon_green"></i></a>
                        <? if($row->status=='PENDING' ){?>

                        <a  href="javascript:check_activeflag('<?=$row->land_code?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>

                             <a  href="javascript:call_confirm('<?=$row->land_code?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>

                             <a  href="javascript:call_delete('<?=$row->land_code?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
										<? if($row->status=='CONFIRMED' ){?>

												 <a  href="javascript:call_delete('<?=$row->land_code?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
								<? }?>
                        </div></td>
                         </tr>

                                <? }} ?>
                          </tbody></table>