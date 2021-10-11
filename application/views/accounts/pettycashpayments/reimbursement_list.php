.

<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">


function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		
					$('#popupform').delay(1).fadeIn(600);
					//alert("<?=base_url()?>accounts/pettycashpayments/get_payment_reimbersment/"+id)
				
					$( "#popupform" ).load( "<?=base_url()?>accounts/pettycashpayments/get_reimbersment_data/"+id );
			
}


function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	
					$('#complexConfirm').click();
			

//alert(document.testform.deletekey.value);

}

function call_confirm1(id)
{
	 document.deletekeyform.deletekey.value=id;
	
   
					$('#complexConfirm_confirm1').click();
				


//alert(document.testform.deletekey.value);

}

function print_data(id)
{
		window.open( "<?=base_url()?>accounts/pettycashpayments/print_paymentdata/"+id );
}
</script>

		<!-- //header-ends -->
		<!-- main content start-->
             <p>
                        <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms">

                    </div>



                         <div class="clearfix"> </div>

						<div class=" widget-shadow" data-example-id="basic-forms">
                      <div class="form-title">
								<h4>Reimbursement List  </h4>
							</div>
                            <br>
                  <table class="table table-bordered"> <thead> <tr> <th>Reimbursement Date</th> <th>Officer</th>  <th>Cash Book</th><th>Amount</th> <th>Voucher Id</th><th>Apply Date</th> <th>Confirmed By</th><th> Status</th><th></th></tr> </thead>
                      <? if($reimlist){$c =0;
                          foreach($reimlist as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->date?></th>
                         <td><?=$row->initial?> <?=$row->surname?></td>
                         <td><?=get_ledger_name($row->ledger_id)?></td>
                            <td><?=number_format($row->amount,2) ?></td>
                            <td><?=$row->voucherid?></td>
                            
                        
                             <td><?=$row->apply_date ?></td>
                              <td><?=get_user_fullname_id($row->confirm_by)?></td>
                               <td><?=$row->status ?></td>
                                <td>
                               
                                <a  href="javascript:check_activeflag('<?=$row->id?>')" title="View"><i class="fa fa-info nav_icon icon_blue"></i></a>
                              <!--   <a  href="javascript:print_data('<?=$row->id?>')" title="Print"><i class="fa fa-print nav_icon icon_blue"></i></a>-->
                                <? if( $row->status=='PENDING'){?>
           
                       <a  href="javascript:call_confirm1('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>

                       <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                    
                             </td> 
                    </td>

                         </tr>

                                <? }} ?>
                          </tbody></table> </div></div>
                   </p>
                