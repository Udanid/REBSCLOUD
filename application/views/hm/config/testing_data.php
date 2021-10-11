<form action="<?=base_url()?>hm/testing_ctrl/add_unitboq" method="post">
<table class="table"> <thead> <tr>
													<th>No</th>
													<th>Description</th>
													<th>Qty</th>
													<th>Unit</th>
													<th>Rate</th>
													
													<th></th>
												</tr> </thead>
												<tbody>
											<? if($sub_cat_data_boq){$c=0;
                          foreach($sub_cat_data_boq as $row){
														$c++;
														$tot=0;
														?>
														<? if($datalist){ $n=0;
															foreach ($datalist[$row->boqsubcat_id] as $key => $value) {
																$n++;
																$tot=$tot+$value->amount;
																?>
															<tr>	<td scope="row"><?=$c?>.<?=$n?></td>
																<td><?=$value->description?></td>
																<td><input type="text" name="<?=$value->boqtask_id?>qty" value="<?=$value->qty?>"></td>
																<td><?=$value->unit?></td>
																<td align="right"><input type="text" name="<?=$value->boqtask_id?>rate" value="<?=$value->rate?>"></td>
																
				                         </tr>
														<?	} ?>
														
													<?	} }?>
													<? } ?>
                          </tbody></table>
                          <input type="submit" name="update" value="update">
</form>