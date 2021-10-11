

<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">


function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		
					$('#popupform').delay(1).fadeIn(600);
				
					$( "#popupform" ).load( "<?=base_url()?>accounts/pettycashpayments/get_paymentdata/"+id );
			
}


function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	
					$('#complexConfirm').click();
			

//alert(document.testform.deletekey.value);

}

function call_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;
	
   
					$('#complexConfirm_confirm').click();
				


//alert(document.testform.deletekey.value);

}
function call_check(id)
{
	 document.deletekeyform.deletekey.value=id;
	
   
					$('#complexConfirm_check').click();
				


//alert(document.testform.deletekey.value);

}function call_approve(id)
{
	 document.deletekeyform.deletekey.value=id;
	
   
					$('#complexConfirm_approve').click();
				


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
								<h4>Settlement List  </h4>
							</div>
                            
                            
                              <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/pettycashpayments/payment"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
                                    <div class="form-body">
                                        <div class="form-inline">
                                        	<div class="form-group">
                                                <select class="form-control " placeholder="Qick Search.."   onchange="set_cashbook(this.value)" name="cashbookid_search" id="cashbookid_search">
                                                    <option value="all" >Cash Book</option>
                                                    <?    foreach($booklist as $row){?>
                                                    <option value="<?=$row->id?>" ><?=$row->type_name?>  <?=$row->name?></option>
                                                    <? }?>
                                            	</select> 
                                            </div>
                                            <div class="form-group"> 
                                                <select class="form-control" id="name" name='name' style="width:200px;">
                                                	<option value="">Supplier Name</option>
                                                	   <option value=""></option >
													 <? if($suplist){
                                                         foreach($suplist as $dataraw)
                                                         {
                                                         ?>
                                                    <option value="<?=$dataraw->sup_code?>"><?=$dataraw->first_name?>  <?=$dataraw->last_name?></option>
                                                     <? }}?>
                            
                                                     </select>
                                            </div>
                                           <!-- <div class="form-group">
                                                <input type="text" class="form-control" name="from_date" id="from_date" placeholder="To Date">
                                            </div>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="to_date" id="to_date" placeholder="To Date">
                                            </div>-->
                                            
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="amountsearch" id="amountsearch" placeholder="Amount">
                                            
                                            </div>
                                            
                                            <div class="form-group">
                                                <button  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                            
                            <br>
                  <table class="table table-bordered"> <thead> <tr><th> #</th> <th> Date</th> <th>Officer</th> <th>Supplier</th>  <th>Paid Amount</th> <th>Description</th><th>Payment Added By</th> <th>Confirmed By</th><th> Status</th><th></th></tr> </thead>
                      <? if($settlelist){$c =0;
                          foreach($settlelist as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->serial_number?></th>
                        <th scope="row"><?=$row->paid_date?></th> 
                        <td><?=$row->initial?> <?=$row->surname?></td>
                          <td scope="row"><?=$row->sup_name?></td> 
                            <td><?=number_format($row->pay_amount,2) ?></td>
                            
                        
                             <td><?=$row->note ?></td>
                             <td><?=get_user_fullname_id($row->paid_by)?></td>
                             <td><?=get_user_fullname_id($row->confirm_by)?></td>
                               <td><?=$row->status ?></td>
                                <td>
                               
                                <a  href="javascript:check_activeflag('<?=$row->id?>')" title="View"><i class="fa fa-info nav_icon icon_blue"></i></a>
                                 <a  href="javascript:print_data('<?=$row->id?>')" title="Print"><i class="fa fa-print nav_icon icon_blue"></i></a>
                                 <? if( $row->status=='PENDING')
							   {?>
                               
          				        <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                                 <? if (check_access('check_directpayments')){
									 if($this->session->userdata('userid')==$row->check_officerid  ||   check_access('all_access')){  ?>
              				         <a  href="javascript:call_check('<?=$row->id?>')" title="Check"><i class="fa fa-check nav_icon icon_blue"></i></a>
					   
					   			<? }}?>
                    	     <? }?>
                             <? if( $row->status=='CHECKED')
							   {?>
                                
                                 <? if (check_access('confirm_directpayments')){
									 if($this->session->userdata('userid')==$row->confirm_officerid  ||   check_access('all_access')){  ?>
              				         <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
					   
					   			<? }}?>
                    	     <? }?>
                              <? if( $row->status=='CONFIRMED')
							   {?>
                                
                                 <? if (check_access('approve_directpayments')){
									 if($this->session->userdata('userid')==$row->apprved_officerid  ||   check_access('all_access')){  ?>
              				         <a  href="javascript:call_approve('<?=$row->id?>')" title="Approve"><i class="fa fa-check nav_icon icon_red"></i></a>
					   
					   			<? }}?>
                    	     <? }?>
                             
                             
                             </td> 
                    </td>

                         </tr>

                                <? }} ?>
                          </tbody></table> </div><div id="pagination-container"><?php if(!$_POST) { echo $this->pagination->create_links(); }?></div></div>
                   </p>
                