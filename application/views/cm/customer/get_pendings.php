
 <h4><?=$customer->last_name.' '.$customer->first_name.' '.$customer->cus_number?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$customer->cus_code;?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
 	<div class="form-body editform">
    	<div class="form-title">
            <h5><strong>Changed Fields</strong></h5>
        </div>
        <table class="table"> <thead> <tr> <th>Field Name</th> <th>Current Value</th> <th>Changed Value</th><th></th><th></th></tr></thead>
 		<? foreach ($pendings as $data){ $c=0?>
			<tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
            	<td><?=$data->changed_field?></td>
                <td><? if(in_array($data->changed_field, array('id_copy_back' ,'id_copy_front','customer_photo','signature'))){?>
					
                    <!--gallery	-->
                     <span id="image<?=$data->id?>">
                      	<? if ($data->prv_val){?>
                        	<a href="<?=base_url()?>uploads/customer_ids/<?=$data->prv_val?>"><img src="<?=base_url()?>uploads/customer_ids/thumbnail/<?=$data->prv_val?>" /></a>
						<? }else{?>Unavailable<? }?>
					</span>
                    <script>
					  $(function () {document.getElementById('image<?=$data->id?>').onclick = function (event) {
						event = event || window.event;
						var target = event.target || event.srcElement,
							link = target.src ? target.parentNode : target,
							options = {index: link, event: event},
							links = this.getElementsByTagName('a');
						blueimp.Gallery(links, options);
					};
					
					});
					</script>
                    
					<? }else{ echo $data->prv_val; }?>
				
                </td>
                <td><? if(in_array($data->changed_field, array('id_copy_back' ,'id_copy_front','customer_photo','signature'))){?>
					
                    <!--gallery	-->
                     <span id="images<?=$data->id?>">
                      
                        <a href="<?=base_url()?>uploads/temp/<?=$data->new_val?>"><img src="<?=base_url()?>uploads/temp/thumbnail/<?=$data->new_val?>" /></a>
					
					</span>
                    <script>
					  $(function () {document.getElementById('images<?=$data->id?>').onclick = function (event) {
						event = event || window.event;
						var target = event.target || event.srcElement,
							link = target.src ? target.parentNode : target,
							options = {index: link, event: event},
							links = this.getElementsByTagName('a');
						blueimp.Gallery(links, options);
					};
					
					});
					</script>
                    
					<? }else{ echo $data->new_val; }?>
                    
                </td>
            </tr>
		<? }?>
        	<tr><td colspan="3"></td><td><a href="javascript:approve_all('<?=$customer->cus_code;?>')" title="Approve">Approve <i class="fa fa-check-circle "></i></a></td><td><a href="javascript:call_delete('<?=$customer->cus_code?>')" title="Cancel" style="color:red">Cancel <i class="fa fa-times nav_icon icon_red"></i></a></td></tr>
        </table>
        
     </div>               
 </div>
                    
                    <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content"> 
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4> 
									</div> 
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>				            
                    <button type="button" style="display:none" class="btn btn-delete" id="complexConfirmImage" name="complexConfirmImage"  value="DELETE"></button> 
                    <button type="button" style="display:none" class="btn btn-delete" id="complexConfirmImage2" name="complexConfirmImage2"  value="DELETE"></button>                
<br /><br /><br /><br /></div>
   