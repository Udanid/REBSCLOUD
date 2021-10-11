<? if(!empty($listkeyval)){
			foreach($listkeyval as $row){?>
				                              <tr>
                                                    <td><?=$row->po_code?></td>
													<td><?=$row->first_name?> <?=$row->last_name?></td>
													<td><?=$row->send_date?></td>
													<td><?=$row->tot_items?></td>
													<td class="text-right"><?=number_format($row->tot_price,2)?></td>
													<td><?=$row->create_by ?></td>

													<td>
														<a  href="javascript:pop_upwindow('<?=$row->poid?>','view')" title="view"><i class="fa fa-eye nav_icon icon_blue"></i></a>
														<? if($row->status=='PENDING'){?>
														<a  href="javascript:pop_upwindow('<?=$row->poid?>','approve')" title="approve"><i class="fa fa-check nav_icon icon_green"></i></a>
														<a  href="javascript:pop_upwindow('<?=$row->poid?>','edit')" title="edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
														<a  href="javascript:call_delete('<?=$row->poid?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
													<? }?>
													</td>

												</tr>

											<? }
										}else{
												?>
                                                No Data
												<?
											} ?>