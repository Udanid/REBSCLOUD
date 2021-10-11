
<script type="text/javascript">
$( function() {
    $( "#deed_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#landr_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	  $( "#rcv_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	   $( "#informed_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	    $( "#issue_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	 	
  } );
function load_printscrean1(id,prjid)
{
			window.open( "<?=base_url()?>hm/deedtransfer/print_lowyercopy/"+id+"/"+prjid );
	
}
function load_printscrean2(id,prjid)
{
			window.open( "<?=base_url()?>hm/deedtransfer/print_customer/"+id+"/"+prjid );
	
}
</script>
<? if($current_res){?>
<h4>  <?=$current_res->first_name?> - <?=$current_res->last_name?><span  style="float:right; color:#FFF" ><a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
<? $loanpay=0; if($paydata)$loanpay=$paydata->totcap;
	$totpay=$current_res->down_payment+$loanpay;
	?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h5>Customer Reservation Details
      </h5>
	</div>
     <table class="table">
		  <tr>
    <th>Project Name</th><td><?=$current_res->project_name?> </td>
    <th>Lot Number</th><td><?=$current_res->lot_number?></td>
  
    </tr>
    <tr>
    <th>Customer Name</th><td><?=$current_res->first_name?> <?=$current_res->last_name?></td>
    <th>NIC Number</th><td><?=$cus_data->id_number?></td>
     <th>Telephone</th><td><?=$cus_data->mobile?></td>
   
    </tr>
    <tr>
    <th>Sales Type</th><td><?=$current_res->pay_type?></td>
    <th>Down Payment</th><td><?=number_format($current_res->down_payment ,2)?></td>
     <th>Balance Amount</th><td><?=number_format($current_res->discounted_price-$totpay,2)?></td>
    </tr>
    </table>
     <div class="form-title">
								<h5>Reservation Charge Payment History</h5>
							</div>
     <table class="table"> <thead> <tr> <th>Payment Date</th><th>Charge Type </th><th>Amount</th><th>Receipt No</th> <th>Status </th></tr> </thead>
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
   
  <? if($deed_data){
	  if($deed_data->form_status=='PENDING'){
	  ?>
   <div class=" widget-shadow " data-example-id="basic-forms"> 
                       
   <div class="form-title">
								<h5>Deed Transfer Details</h5>
							</div>
   <form data-toggle="validator" method="post" action="<?=base_url()?>hm/deedtransfer/update_transfer" enctype="multipart/form-data">
                        <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                        <input type="hidden" name="lot_id" id="lot_id" value="<?=$lot_id?>">
                         <input type="hidden" name="res_code" id="res_code" value="<?=$current_res->res_code?>">
                        <input type="hidden" name="cus_code" id="cus_code" value="<?=$current_res->cus_code?>">
                       <input type="hidden" name="id" id="id" value="<?=$deed_data->id?>">
                         <input type="hidden" name="old_Affidavit" id="old_Affidavit" value="<?=$deed_data->Affidavit?>">
                    
                          <div class="form-body ">
                         <div class="form-group "><label class="col-sm-3 control-label">Deed Transfer to</label>
										<div class="col-sm-8   has-feedback "><input type="text" class="form-control"   id="trn_name1"  value="<?=$deed_data->trn_name1?>" name="trn_name1"   data-error=" Please fill this Value"  placeholder="Full Name 1"   required>
                                       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                       </div></div>
                                       
                                          <div class="form-group  ">
                                        <label class="col-sm-3 control-label" ></label>
										<div class="col-sm-8  has-feedback "><input type="text" class="form-control" id="trn_name2"    value="<?=$deed_data->trn_name2?>" name="trn_name2"  data-error=""    placeholder="Full Name 2"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                         <div class="form-group  ">
                                        <label class="col-sm-3 control-label" ></label>
										<div class="col-sm-8  has-feedback "><input type="text" class="form-control" id="trn_name3"  value="<?=$deed_data->trn_name3?>" name="trn_name3"  data-error=""    placeholder="Full Name 2"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                           <div class="form-group  ">
                                         <label class="col-sm-3 control-label" >Address</label>
										<div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="address1"   value="<?=$deed_data->address1?>" name="address1"  data-error=""    placeholder="Address Line 1"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="address2"   value="<?=$deed_data->address2?>" name="address2"  data-error=""    placeholder="Address Line 1"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="address3"  value="<?=$deed_data->address3?>"  name="address3"  data-error=""    placeholder="Address Line 3"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                        <div class="clearfix"> </div>
                                        <div class="form-group  ">
                                        <label class="col-sm-3 control-label" >Language</label>
										<div class="col-sm-6  has-feedback "><select name="language" id="language" class="form-control"  required>
                                        <option  value="Sinhala" <? if($deed_data->language=='Sinhala'){?> selected="selected"<? }?> >Sinhala</option>
                                        <option  value="Tamil" <? if($deed_data->language=='Tamil'){?> selected="selected"<? }?> >Tamil</option>
                                         <option  value="English" <? if($deed_data->language=='English'){?> selected="selected"<? }?> >English</option>
                                        </select>
                                        
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                              <div class="clearfix"> </div>
                                         <div class="form-group">
                                         <label class="col-sm-3 control-label" >Legal Officer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> 
										 <div class="col-sm-6  has-feedback "><select name="legal_officer" id="legal_officer" class="form-control" placeholder="Introducer" required>
                                    <option value="">Legal Officer</option>
                                    
                                     <? if($legal_officer) {foreach ($legal_officer as $raw){?>
                    <option value="<?=$raw->id?>"  <? if($deed_data->legal_officer==$raw->id){?> selected="selected"<? }?> ><?=$raw->initial?>&nbsp; <?=$raw->surname?></option>
                    <? }}?>
        
                                    </select></div></div>
                                         <div class="clearfix"> </div>
                                    <br />
                                     <div class="form-group">
                                         <label class="col-sm-3 control-label" >Affidavit/Letter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
										 <div class="col-sm-6  has-feedback ">
                                         <input type="file"  name="Affidavit" id="Affidavit"/></div></div>  <? if($deed_data->Affidavit){?> <a  href="<?=base_url()?>uploads/deedtransfer/<?=$deed_data->Affidavit?>" target="_blank"><i class="fa fa-download nav_icon"></i>Affidavit</a><? }?>
                                          <div class="clearfix"> </div>
                                    <br />
                                         <? if( check_access('finance_remark')){?>
                                         <div class="form-group">
                                         <label class="col-sm-3 control-label" >Finance Manager Remark&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
										 <div class="col-sm-6  has-feedback ">
                                         <textarea  name="fin_remark" id="fin_remark"  class="form-control" placeholder="Finance Manager Remark" ><?=$deed_data->fin_remark?></textarea></div></div>
                                         
                                         <? }?>
                                         <div class="form-group " style="float:right">
                                          <h3> <a href="javascript:call_confirm('<?=$deed_data->id?>')"><span class="label label-success">Confirm</span></a>
												<button type="submit" class="btn btn-primary disabled" >Update Details</button></h3>
											</div>
											<div class="clearfix"> </div>
                                        </div>
                                       
										
                        
 </form>
  </div>
  <? } else{?>
   <div class="form-title">
								<h5>Deed Transfer Details  <span style="float:right"> <a href="javascript:load_printscrean1('<?=$lot_id?>','<?=$prj_id?>')"> <i class="fa fa-print nav_icon"></i></a>
</span></h5>
							</div>
   <div class=" widget-shadow " data-example-id="basic-forms"> 
                         
     <table class="table">
    <tr>
    <th rowspan="3">Deed Transfer Names </th><td>1. <?=$deed_data->trn_name1?></td></tr>
    <tr><td>2. <?=$deed_data->trn_name2?></td></tr>
    <tr><td>3. <?=$deed_data->trn_name3?></td></tr>
    <tr>
    <th>Address</th><td><?=$deed_data->address1?>, <?=$deed_data->address2?>, <?=$deed_data->address3?></td></tr>
   <tr> <th>Language</th><td><?=$deed_data->language?></td>
     <tr> <th>Affidavit</th><td><? if($deed_data->Affidavit){?> <a  href="<?=base_url()?>uploads/deedtransfer/<?=$deed_data->Affidavit?>" target="_blank"><i class="fa fa-download nav_icon"></i>Affidavit</a><? }?></td>
      <tr> <th>Managers Remark</th><td><?=$deed_data->fin_remark?></td>
    </tr>
    </table>
  
                            
   <div class="form-title">
								<h5>Deed Details   <span style="float:right"> <a href="javascript:load_printscrean2('<?=$lot_id?>','<?=$prj_id?>')"> <i class="fa fa-print nav_icon"></i></a>
</span></h5>
							</div>
                            <?   if($deed_data->deed_status!='CONFIRMED'){?>
   <form data-toggle="validator" method="post" action="<?=base_url()?>hm/deedtransfer/update_deeddata" enctype="multipart/form-data">
                        <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                        <input type="hidden" name="lot_id" id="lot_id" value="<?=$lot_id?>">
                         <input type="hidden" name="res_code" id="res_code" value="<?=$current_res->res_code?>">
                        <input type="hidden" name="cus_code" id="cus_code" value="<?=$current_res->cus_code?>">
                       <input type="hidden" name="id" id="id" value="<?=$deed_data->id?>">
                    
                          <div class="form-body ">
                         <div class="form-group "><label class="col-sm-3 control-label">Attest By</label>
										<div class="col-sm-3   has-feedback "><input type="text" class="form-control"   id="attest_by"  value="<?=$deed_data->attest_by?>" name="attest_by"   data-error=" Please fill this Value"  placeholder="Attest By"   required>
                                       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                       </div>
                                        <label class="col-sm-3 control-label" >Plan Number</label>
										<div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="plan_number"  value="<?=$plandata->plan_no?>" name="plan_number"  data-error="" readonly="readonly"    placeholder="Plan Number"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                       
                                          <div class="form-group  ">
                                        <label class="col-sm-3 control-label" >Deed Number</label>
										<div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="deed_number"    value="<?=$deed_data->deed_number?>" name="deed_number"  data-error=""    placeholder="Deed Number"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div>
                                        <label class="col-sm-3 control-label" >Deed Date</label>
										<div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="deed_date"   value="<?=$deed_data->deed_date?>" name="deed_date"  data-error=""    placeholder="Deed Date"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                           <div class="form-group  ">
                                         <label class="col-sm-3 control-label" >Land Registry Date</label>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="landr_date"   value="<?=$deed_data->landr_date?>" name="landr_date"  data-error=""    placeholder="Land Registry Date"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div>
                                         <label class="col-sm-3 control-label" >Day Book No</label>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="day_book_no"   value="<?=$deed_data->day_book_no?>" name="day_book_no"  data-error=""    placeholder="Day Book No"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                         <div class="form-group  ">
                                           <label class="col-sm-3 control-label" >Received Date</label>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="rcv_date"  value="<?=$deed_data->rcv_date?>"  name="rcv_date"  data-error=""    placeholder="Recieved Date"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div>
                                         <label class="col-sm-3 control-label" >Register Porlio</label>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="register_portfolio"  value="<?=$deed_data->register_portfolio?>"  name="register_portfolio"  data-error=""    placeholder="Register Porlio"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                        <div class="clearfix"> </div>
                                        
                                          <div class="form-group  ">
                                           <label class="col-sm-3 control-label" >Informed Date</label>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" 
                                        id="informed_date"  value="<?=$deed_data->informed_date?>"  name="informed_date"  data-error=""    placeholder="Informed Date"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div>
                                         <label class="col-sm-3 control-label" >Informed Method</label>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control"
                                         id="informed_method"  value="<?=$deed_data->informed_method?>"  name="informed_method"  data-error=""    placeholder="Informed Method"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                        <div class="clearfix"> </div>
                                         <div class="form-group  ">
                                           <label class="col-sm-3 control-label" >Issue Date</label>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" 
                                        id="issue_date"  value="<?=$deed_data->issue_date?>"  name="issue_date"  data-error=""    placeholder="Issue Date"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div>
                                         <label class="col-sm-3 control-label" >Issue to</label>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="issue_to"  value="<?=$deed_data->issue_to?>"  name="issue_to"  data-error=""    placeholder="Issue To"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                        <div class="clearfix"> </div>
                                        
                                        
                                        
                                        
                                         <div class="form-group  ">
                                           <label class="col-sm-3 control-label" >Remark</label>
                                        <div class="col-sm-8  has-feedback "><input type="text" class="form-control" id="remark"  value="<?=$deed_data->remark?>"  name="remark"  data-error=""    placeholder="Remark"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div>
                                        </div>
                                        <div class="clearfix"> </div>
                                        
                                        
                                      
                                         <? if($this->session->userdata('usertype')=='Legal Officer' || $this->session->userdata('usertype')=='Legal Executive'){?>
                                         <div class="form-group " style="float:right">
                                          <h3> <? if($deed_data->deed_status=='UPDATED'){?><a href="javascript:call_confirm_deed('<?=$deed_data->id?>')"><span class="label label-success">Confirm</span></a><? }?>
												<button type="submit" class="btn btn-primary disabled" >Update Details</button></h3>
											</div><? }?>
											<div class="clearfix"> </div>
                                        </div>
                                       
										
                        
 </form>
 <? } else{?>
 <table class="table">
    <tr>
    <th >Attest By </th><td colspan="2"> <?=$deed_data->attest_by?></td></tr>
    <tr> <th >Deed Number </th><td> <?=$deed_data->deed_number?></td> <th >Plan Number </th><td> <?=$deed_data->plan_number?></td></tr>
    <tr> <th >Deed Date	 </th><td> <?=$deed_data->deed_date?></td> <th >Land Registry Date </th><td> <?=$deed_data->landr_date?></td></tr>
   <tr> <th >Recieve Date	 </th><td> <?=$deed_data->rcv_date?></td> <th >Hand Over Date </th><td> <?=$deed_data->handover_date?>
   
   <? if($deed_data->scan_copy){?> <a  href="<?=base_url()?>uploads/deedtransfer/<?=$deed_data->scan_copy?>" target="_blank"><i class="fa fa-download nav_icon"></i>Scan Copy</a><? }?>
   </td></tr>
  
 
    </table>
   <form data-toggle="validator" method="post" action="<?=base_url()?>hm/deedtransfer/upload_cuscopy" enctype="multipart/form-data">
                        <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                        <input type="hidden" name="lot_id" id="lot_id" value="<?=$lot_id?>">
                         <input type="hidden" name="res_code" id="res_code" value="<?=$current_res->res_code?>">
                        <input type="hidden" name="cus_code" id="cus_code" value="<?=$current_res->cus_code?>">
                       <input type="hidden" name="id" id="id" value="<?=$deed_data->id?>">
                    
                          <div class="form-body ">
                         <div class="form-group "><label class="col-sm-3 control-label">Upload Customer Copy</label>
										<div class="col-sm-3   has-feedback "><input type="file" class="form-control"   id="scan_copy"  name="scan_copy"    required>
                                       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                       </div>
                                       <div class="col-sm-3   has-feedback ">	<button type="submit" class="btn btn-primary disabled" >Update Details</button></h3>
											</div>
                                       </div>
                                 
                                        
                                        </form><br /><br />
 <? }?>
  </div>
  <? }?>
  
  
  <? }else
  {?>
  <div class=" widget-shadow " data-example-id="basic-forms"> 
                       
   <div class="form-title">
								<h4>Deed Transfer Details</h4>
							</div>
   <form data-toggle="validator" method="post" action="<?=base_url()?>hm/deedtransfer/add_transfer" enctype="multipart/form-data">
                        <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                        <input type="hidden" name="lot_id" id="lot_id" value="<?=$lot_id?>">
                        <input type="hidden" name="res_code" id="res_code" value="<?=$current_res->res_code?>">
                        <input type="hidden" name="cus_code" id="cus_code" value="<?=$current_res->cus_code?>">
                          <div class="form-body ">
                         <div class="form-group "><label class="col-sm-3 control-label">Deed Transfer to</label>
										<div class="col-sm-8   has-feedback "><input type="text" class="form-control"   id="trn_name1"  value="" name="trn_name1"   data-error=" Please fill this Value"  placeholder="Full Name 1"   required>
                                       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                       </div></div>
                                       
                                          <div class="form-group  ">
                                        <label class="col-sm-3 control-label" ></label>
										<div class="col-sm-8  has-feedback "><input type="text" class="form-control" id="trn_name2"  name="trn_name2"  data-error=""    placeholder="Full Name 2"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                         <div class="form-group  ">
                                        <label class="col-sm-3 control-label" ></label>
										<div class="col-sm-8  has-feedback "><input type="text" class="form-control" id="trn_name3"  name="trn_name3"  data-error=""    placeholder="Full Name 2"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                           <div class="form-group  ">
                                         <label class="col-sm-3 control-label" >Address</label>
										<div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="address1"  name="address1"  data-error=""    placeholder="Address Line 1"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="address2"  name="address2"  data-error=""    placeholder="Address Line 1"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div>
                                        <div class="col-sm-3  has-feedback "><input type="text" class="form-control" id="address3"  name="address3"  data-error=""    placeholder="Address Line 3"   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                        <div class="clearfix"> </div>
                                        <div class="form-group  ">
                                        <label class="col-sm-3 control-label" >Language</label>
										<div class="col-sm-6  has-feedback "><select name="language" id="language" class="form-control"  required>
                                        <option  value="Sinhala">Sinhala</option>
                                        <option  value="Tamil">Tamil</option>
                                         <option  value="English">English</option>
                                        </select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                        </div></div>
                                        <div class="clearfix"> </div>
                                         <div class="form-group">
                                         <label class="col-sm-3 control-label" >Legal Officer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> 
										 <div class="col-sm-6  has-feedback "><select name="legal_officer" id="legal_officer" class="form-control" placeholder="Introducer" required>
                                    <option value="">Legal Officer</option>
                                    
                                     <? if($legal_officer) {foreach ($legal_officer as $raw){?>
                    <option value="<?=$raw->id?>" ><?=$raw->initial?>&nbsp; <?=$raw->surname?></option>
                    <? }}?>
        
                                    </select></div></div>
                                         <div class="form-group validation-grids" style="float:right">
												<button type="submit" class="btn btn-primary disabled" >Add Details</button>
											</div>
											<div class="clearfix"> </div>
                                        </div>
                                       
										
                        
 </form>
</div>
  <? }?>
    </div> 
</div>
<? }?>