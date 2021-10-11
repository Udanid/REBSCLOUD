<h4>Boq Unit Details of Project <?=$projname?>-> Unit <?=$unitid?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit(2)"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
 <?
  $subcatarr=NULL;
 $counter=0;
 if($sub_cat_data_boq){$c=0;
 $total_tot=0;
  foreach($sub_cat_data_boq as $row){
	  if($datalist[$row->boqsubcat_id]){ $tot=0;
          foreach ($datalist[$row->boqsubcat_id] as $key => $value) {
			   $tot= $tot+$value->amount;
			}
			$subcatarr[$row->boqsubcat_id]=$tot;
			 $total_tot= $total_tot+$tot;
	  }
 }}
 
 ?>
  <table  class="table table-bordered" id="boqtbls"> <thead> <tr>
                          <th>Code</th>
                          <th>Description</th>
                          <th>Total</th>
                            </tr> </thead>
                        <tbody>
                      <? if($sub_cat_data_boq){$c=0;
                        $total_tot=0;
                          foreach($sub_cat_data_boq as $row){
						//	  print_r($row);
                            $c++;
                            $tot=0;
							$subcatarr[$counter]['name']=$row->subcat_name;
                            ?>

                             <tr>
                             <th width="10%" ><?=$row->subcat_code?> </th>
                             <th><a role="button" data-toggle="collapse" data-parent="#accordion" href="#coll<?=$row->boqsubcat_id?>" aria-expanded="true" aria-controls="coll<?=$row->boqsubcat_id?>"><?=$row->subcat_name?></a></th>
                             <th style="text-align:right"><?=number_format($subcatarr[$row->boqsubcat_id])?></th></tr>
							 <tr><td colspan="7">
                             <div id="coll<?=$row->boqsubcat_id?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							  <div class="panel-body"><table class="table table-bordered" id="boqtbls"> <thead> <tr>
                          <th>No</th>
                          <th>Description</th>
                          <th>Qty</th>
                          <th>Unit</th>
                          <th>Rate</th>
                          <th>Amount</th>
                         
                        </tr> </thead>
                        <tbody>
                            <? if($datalist[$row->boqsubcat_id]){ $n=0;
                              foreach ($datalist[$row->boqsubcat_id] as $key => $value) {
                                $n++;
                                $tot=$tot+$value->amount;
                               
                                ?>
                              <tr class="rows<?=$c?>">
                                <td scope="row"><?=$c?>.<?=$n?></td>
                                <td><?=$value->description?></td>
                                <td><?=$value->qty?></td>
                                <td><?=$value->mt_name?></td>
                                <td align="right"><?=$value->rate?></td>
                                <td align="right"><?=number_format($value->amount,2)?></td>

                                 </tr>
                            <?  } 
							 $total_tot=$total_tot+$tot;
								$subcatarr[$counter]['name']=$row->subcat_name;
									$subcatarr[$counter]['amount']= $tot;
									$counter++
							?>
							</table></div></div></td></tr>
                             <?  } }?>
                          <tr class="info total_total"><th  colspan="2">Total</th> <th style="text-align:right"><?=number_format($total_tot,2)?></th></tr>
                          <? } ?>
                          </tbody></table>
                          
                          <br />
                           
                          
                          
 </div>
</div>
