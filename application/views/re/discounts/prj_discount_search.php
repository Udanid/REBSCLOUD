<table width="400" class="table" border="0" cellspacing="0" cellpadding="0">
                                      	<thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Project</th>
                                                <th>Created By</th>
                                                <th>Updated By</th>
                                                <th>Checked By</th>
                                                <th>Confirmed By</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    <?
									if($project_discounts){ 
										foreach ($project_discounts as $row){
									?>
                                    	<tbody>
                                            <tr>
                                                <td><?=$row->prj_id;?></td>
                                                <td><?=$row->project_name;?></td>
                                                <td><?=$row->created_by;?></td>
                                                <td><?=$row->updated_by;?></td>
                                                <td><?=$row->checked_by;?></td>
                                                <td><?=$row->confirmed_by;?></td>
                                                <td>
                                                	<? if(check_access('edit_project_discounts')){
														if($row->status == 'PENDING'){ ?>
                                                		<a  href="javascript:check_activeflag('<?=$row->prj_id?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                                                    <? 
														}
													}?>
                                                    <? if(check_access('delete_project_discounts')){
                                                    	if($row->status == 'PENDING'){ ?>
                                                		<a  href="javascript:check_delete('<?=$row->prj_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                                                    <? 
														}
													}?>
                                                   
                                                    <a  href="javascript:viewScheme('<?=$row->prj_id?>')" title="View"><i class="fa fa-eye nav_icon icon_green"></i></a>
                                                     <? if(check_access('check_project_discounts')){
                                                    	if($row->status == 'PENDING'){ ?>
                                                		<a  href="javascript:check_confirm('<?=$row->prj_id?>','check')" title="Check"><i class="fa fa-check-square-o nav_icon brown-400"></i></a>
                                                        <? }
                                                     }?>
                                                     <? if(check_access('confirm_project_discounts')){
                                                    	if($row->status == 'CHECKED'){ ?>
                                                		<a  href="javascript:check_confirm('<?=$row->prj_id?>','confirm')" title="Confirm"><i class="fa fa-check nav_icon green-400"></i></a>
                                                        <? }
                                                     }?>
                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?	
										}
									}else{ echo '<tr><td colspan="3">Nothing to Display!</td></tr>';}
									?>
                                    </table>