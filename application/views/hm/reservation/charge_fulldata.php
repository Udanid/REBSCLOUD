 <script type="text/javascript">

</script>
 <h4>Customer Name : &nbsp;  <?=$resdata->first_name ?> <?=$resdata->last_name ?>
                                &nbsp;  &nbsp; Project Name :&nbsp;<?=$resdata->project_name?> &nbsp;&nbsp;  Land Details :  <?=$resdata->lot_number ?>-<?=$resdata->plan_sqid ?>
                                <span style="float:right">  <a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span>
                                </h4>
 
 
							<div class="form-body  form-horizontal" >
                            <? if($charge_data){
								$status='Update';
								$document_fee=$charge_data->document_fee;
								$leagal_fee=$charge_data->leagal_fee;
								$stamp_duty=$charge_data->stamp_duty;
								$other_charges=$charge_data->other_charges;
							} else{
								$status='Insert';
								$document_fee=0;
								$stamp_duty=0;
								$leagal_fee=0;
								$other_charges=0;
                            }
							$paiddoc=0; $padilegal=0; $paidstamp=0;
							if($charge_payment){
							foreach($charge_payment as $raw)
							{
								if($raw->chage_type=='leagal_fee')
								$padilegal=$padilegal+$raw->pay_amount ;
								if($raw->chage_type=='stamp_duty')
								$paidstamp=$paidstamp+$raw->pay_amount ;
								if($raw->chage_type=='document_fee')
								$paiddoc=$paiddoc+$raw->pay_amount ;
							}
							}
							?>         <div class="form-group  "><label class="col-sm-3 control-label">Stamp Fee</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="stamp_duty_val"  onblur="load_realvalues()"  value="<?=number_format($stamp_duty,2) ?>" name="stamp_duty_val" <? if($paidstamp>0){?>  readonly="readonly"<? }?> required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Legal Fees</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="leagal_fee_val" onblur="load_realvalues()"   name="leagal_fee_val"  data-error=""    value="<?=number_format($leagal_fee,2) ?>"  <? if($padilegal>0){?>  readonly="readonly"<? }?>required>
										</div></div>
									 
                                     <div class="form-group ">
									<label class="col-sm-3 control-label">Document Fee</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text"  onblur="load_realvalues()" class="form-control" id="document_fee_val"    name="document_fee_val"  value="<?=number_format($document_fee,2) ?>"   <? if($paiddoc>0){?>  readonly="readonly"<? }?>  data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     
									
                                      
                                   
                                          <div class="form-group validation-grids " style="float:right">
												
												
											
										</div>
								
							</div>
                    <div class="form-title">
								<h5>Reservation Charge Payment History</h5>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Payment Date</th><th>Charge Type </th><th>Amount</th><th>Reciept No</th> <th>Status </th></tr> </thead>
                      <? if($charge_payment){$c=0;
                          foreach($charge_payment as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->pay_date?></th><td> <?=$row->chage_dis ?></td><td  align="right"> <?=number_format($row->pay_amount,2)?></td> 
                        <td><?=$row->rct_no?></td>
                        <td><?=$row->status?></td>
                        <td><div id="checherflag">
                          <? if($row->status=='PENDING'){?>
                              <a  href="javascript:call_delete_advance('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          
                    </div>  