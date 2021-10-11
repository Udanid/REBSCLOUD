<script type="text/javascript">

function load_printscrean1(id)
{
			window.open( "<?=base_url()?>re/eploan/print_repayment_schedule/"+id );
	
}

</script>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
</script>
<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
<h4>Repayment Schedule of <?=$details->loan_code ?> <span  style="float:right; color:#FFF" ><a href="javascript:load_printscrean1('<?=$details->loan_code ?>')"><i class="fa fa-print nav_icon"></i></a>&nbsp;&nbsp;<a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>

<form data-toggle="validator" method="post" action="<?=base_url()?>re/reservation/editdata_compete" enctype="multipart/form-data">
                       
							<div class="form-body  form-horizontal" >
                                   		 <div class="form-group">
                                      
                                      <label class="col-sm-3 control-label" >Loan Amount</label>
										<div class="col-sm-3" id="subtaskdata"><input  type="text" class="form-control" name="interest" id="interest"  onblur=" instalment_cal()"   required value="<?=number_format(floatval($details->loan_amount),2)?>"  >
										</div>
                                     
                                     <label class="col-sm-3 control-label">Loan Period</label>
										<div class="col-sm-3">
                                        <input  type="number" class="form-control" name="interest" id="interest"  onblur=" instalment_cal()"   required value="<?=$details->period?>"  >
                                       </div>
                                        
                                      </div>
                                       <div class="form-group ">
									<label class="col-sm-3 control-label">Interest</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="instalments"    name="instalments" value="<?=$details->interest?>"     data-error="" readonly="readonly"   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Settlement Date</label>
                                        <? $futureDate=date('Y-m-d',strtotime('+'.intval($details->period).' months',strtotime($details->start_date)));?>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate"    name="settldate" value="<?=$futureDate?>"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                       <input type="hidden" class="form-control" id="instalments_val"  value=""name="instalments_val"    data-error=""  >
							
											</div>
                                            <? if($details->pay_type=='EPB'){?>
                                                  <div class="form-group ">
									<label class="col-sm-3 control-label">Total Amount</label>
                                    <? $tot=floatval($details->loan_amount)+ (floatval($details->loan_amount)*floatval($details->interest)*floatval($details->period))/(100*12) ?> 
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="instalments"    name="instalments" value="<?=number_format($tot,2)?>"     data-error="" readonly="readonly"   required="required" >
										</div>
                                      	
                                        	
                                                <? } else { ?> 
                                                 <div class="form-group ">
									<label class="col-sm-3 control-label">Total Outstanding</label>
                                    <? $tot=floatval($details->loan_amount)- (floatval($totset->totpaidcap)) ?> 
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="instalments"    name="instalments" value="<?=number_format($tot,2)?>"     data-error="" readonly="readonly"   required="required" >
										</div>
                                                <? }?>
                                        		</div>
                                                
                                              
                                      </div>
                                    
                                             
                                   
                                       
                                       
                                        <div class="clearfix"> </div>
								
							</div>
                            </form>
<div class="table widget-shadow">
<? if($dataset){$c=0;?>
<div class="tableFixHead"> 
<table class="table"> <thead> <tr> <th> Instalment</th> <th>Capital Amount</th> <th>Interest Amount</th> <th>Monthly  Rental</th><th>Due Date</th><th>Pay Status</th></tr> </thead>
                      <?
                          foreach($dataset as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->instalment?></th> <td><?=number_format($row->cap_amount,2)?></td> <td><?=number_format($row->int_amount,2) ?></td>
                         <td><?=number_format($row->tot_instalment,2) ?></td> 
                          <td><?=$row->deu_date ?></td> 
                          <td><?=$row->pay_status ?></td> 
                      
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
</div>


				            
                                    
                                 <br /></div>