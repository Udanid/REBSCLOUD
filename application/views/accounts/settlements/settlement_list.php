

<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
 $("#name").focus(function() {
		$("#name").chosen({
   			 allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select an Instance"
    	});
	});

});
function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
				
					$('#popupform').delay(1).fadeIn(600);
				
					$( "#popupform" ).load( "<?=base_url()?>accounts/settlments/get_settementdata/"+id );
				}
            }
        });
}


function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}

function call_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm_confirm').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}
function call_check(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm_check').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}
function call_approve(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm_approve').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}
function print_data(id)
{
		window.open( "<?=base_url()?>accounts/settlments/print_settementdata/"+id );
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
                            <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/settlments/settlement"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
                                    <div class="form-body">
                                        <div class="form-inline">
                                        	<div class="form-group">
                                                <select class="form-control " placeholder="Qick Search.."   onchange="set_cashbook(this.value)" name="cashbookid_search" id="cashbookid_search">
                                                    <option value="all" >Cash Book</option>
                                                    <?    foreach($datalist as $row){?>
                                                    <option value="<?=$row->id?>" ><?=$row->name?></option>
                                                    <? }?>
                                            	</select> 
                                            </div>
                                            <div class="form-group"> <!-- Ticket No.2502 || Added by Uvini -->
                                                <select class="form-control" id="name" name='name' style="width:200px;">
                                                	<option value="">Payee Name</option>
                                                	<? foreach($emplist as $row){
													if($row->display_name)
													$displayname=$row->display_name;
													else
													$displayname=$row->initial.' '.$row->surname;
                                                	 echo '<option value='.$row->id.'>'.$displayname.'</option>';
													}?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="advance_no" id="advance_no" placeholder="Cash Advance No">
                                            </div>
                                            
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="amountsearch" id="amountsearch" placeholder="Amount">
                                                 <input type="hidden" class="form-control" name="pay_type" id="pay_type" value="<?=$pay_type?>" placeholder="Amount">
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
                  <table class="table table-bordered"> <thead> <tr> <th> Date</th> <th>Payee</th>  <th>Full Amount</th><th>Settle Amount</th>  <th>Cash Advance No</th><th>Description</th><th>Confirmed By</th><th> Status</th></tr> </thead>
                      <? if($settlelist){$c =0;
                          foreach($settlelist as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->settled_date?></th> <td><?=$row->initial?> <?=$row->surname?></td>
                            <td><?=number_format($row->amount,2) ?></td>
                             <td><?=number_format($row->settled_amount,2)?></td>
                          <td><?=$row->adv_code ?></td>
                             <td><?=$row->note ?></td>
                             <td><?=get_user_fullname_id($row->confirm_by)?></td>
                               <td><?=$row->settlstat ?></td>
                                <td>
                               
                                <a  href="javascript:check_activeflag('<?=$row->id?>')" title="View"><i class="fa fa-info nav_icon icon_blue"></i></a>
                                 <a  href="javascript:print_data('<?=$row->id?>')" title="Print"><i class="fa fa-print nav_icon icon_blue"></i></a>
                                 <? if( $row->settlstat=='PENDING')
							   {?>
                               
          				        <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                                 <? if (check_access('check_cashadvance')){
									 if($this->session->userdata('userid')==$row->check_officerid  ||   check_access('all_access')){  ?>
              				         <a  href="javascript:call_check('<?=$row->id?>')" title="Check"><i class="fa fa-check nav_icon icon_blue"></i></a>
					   
					   			<? }}?>
                    	     <? }?>
                             <? if( $row->settlstat=='CHECKED')
							   {?>
                                
                                 <? if (check_access('confirm_cashadvance')){
									 if($this->session->userdata('userid')==$row->confirm_officerid  ||   check_access('all_access')){  ?>
              				         <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
					   
					   			<? }}?>
                    	     <? }?>
                              <? if( $row->settlstat=='CONFIRMED')
							   {?>
                                
                                 <? if (check_access('approve_cashadvance')){
									 if($this->session->userdata('userid')==$row->apprved_officerid  ||   check_access('all_access')){  ?>
              				         <a  href="javascript:call_approve('<?=$row->id?>')" title="Approve"><i class="fa fa-check nav_icon icon_red"></i></a>
					   
					   			<? }}?>
                    	     <? }?></td>

                         </tr>

                                <? }} ?>
                          </tbody></table> </div> <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div></div></div>
                   </p>
                