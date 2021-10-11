 <table class="table table-bordered"> 
                	<thead> 
                    	<tr> 
                        	<th>Invoice Date</th> 
                            <th>Supplier Name</th>  
                            <th>Payment Type</th> 
                            <th>Invoice Number</th> 
                            <th>Payment Date</th>
                            <th>Payment Description</th> 
                            <th>Invoice Amount</th>
                            <th>Paid Amount</th>
                            <th>Confirmed By</th>
                            <th>Pay Status</th>
                        </tr> 
					</thead>
                    <? if($datalist){$c =0;
                        	foreach($datalist as $row){
					?>
                    <tbody> 
                    	<tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                            <td scope="row"><?=$row->date?></td> 
                            <td><?=$row->first_name?> <?=$row->last_name?></td>
                            <td><?=$row->type?></td>
                            <td><?=$row->inv_no?></td>
                            <td><?=$row->pay_date?></td>
                            <td><?=$row->note ?></td>
                            <td align="right"><?=number_format($row->total,2) ?></td>
                            <td align="right"><?=number_format($row->pay_amount,2) ?></td>
                            <td><?=get_user_fullname_id($row->aproved_by)?></td>
                            <td><?=$row->pay_status ?></td>
                            <td>
                           <? if( $row->pay_status=='PENDING'){?>
                                <? // if($this->session->userdata('userid')!=$row->officer_id ){?>
                                <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                                <? // }?>
                                <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                                <? } if( $row->pay_status=='APPROVED'){?>
                                <a  href="javascript:pay_cash('<?=$row->id?>','<?=$row->book_id?>')" title="Pay Cash"><i class="fa fa-money nav_icon icon_red"></i></a>
                                <? }?>
                           </td>
                       </tr>

                     <? }} ?>
                    </tbody>
                 </table>