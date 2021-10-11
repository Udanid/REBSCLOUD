<style>
	.tableFixHead { overflow-y: auto; height: 350px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
<script type="text/javascript">

 //Added By Madushan Ticket No:2604 01/04/2021
      $( function() {
      $( "#start_date" ).datepicker({dateFormat: 'yy-mm-dd',onSelect: function(selectedDate) {
            $('#end_date').datepicker('option', 'minDate', selectedDate); //set todate mindate as fromdate
             date = $(this).datepicker('getDate');
            var maxDate = new Date(date.getTime());
            maxDate.setMonth(maxDate.getMonth() + 1); //add 31 days to from date
            $('#end_date').datepicker('option', 'maxDate', maxDate);
            setTimeout(function() { $('#end_date').focus(); }, 0);
            }
        });
        $( "#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});
      
    } );
    //End of Ticket No:2604

$( function() {
    $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd',onSelect: function(selectedDate) {
		$('#todate').datepicker('option', 'minDate', selectedDate); //set todate mindate as fromdate
		date = $(this).datepicker('getDate');
		var maxDate = new Date(date.getTime());
		maxDate.setDate(maxDate.getDate() + 365); //add 31 days to from date
		$('#todate').datepicker('option', 'maxDate', maxDate);
		setTimeout(function() { $('#todate').focus(); }, 0);
	}});
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
 
});
    
    

    function check_activeflag(id)
    {
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_recieptdata', id: id,fieldname:'RCTID' },
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
                    $( "#popupform" ).load( "<?=base_url()?>accounts/entrymaster/edit/"+id );
                }
            }
        });
    }

    function close_edit(id)
    {
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'ac_recieptdata', id: id,fieldname:'RCTID' },
            success: function(data) {
                if (data) {
                    $('#popupform').delay(1).fadeOut(800);

                    //document.getElementById('mylistkkk').style.display='block';
                }
                else
                {
                    document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
                    $('#flagchertbtn').click();

                }
            }
        });
    }

    //Added By Madushan Ticket No:2604 01/04/2021
    function generateExcel(){ 
        var start_date = $('#start_date').val();    
        var end_date = $('#end_date').val();
        var payment_mode = $('#payment_mode_report').val();
       window.location="<?=base_url()?>accounts/report/download/receipts/"+start_date+"/"+end_date+'/'+payment_mode;
        
    }
     //End of Ticket No:2604

</script>

    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/entrymaster/search"  enctype="multipart/form-data">
                    <div class="col-md-6">
                    <div class="form-group" >
                        <input type="number" step="0.01" class="form-control"  name="amountsearch" id="amountsearch" placeholder="Amount">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="receipt_no" id="receipt_no" placeholder="Receipt No">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="payment_mode" name="payment_mode">
                            <option value='all'>Select Payment Mode</option>
                            <option value='all'>All</option>
                            <option value='CSH'>CASH</option>
                            <option value='CHQ'>CHEQUE</option>
                            <option value='CREDIT CARD'>CREDIT CARD</option>
                            <option value='DEBIT CARD'>DEBIT CARD</option>
                            <option value='DD'>DIRECT DEPOSIT</option>
                            <option value='FT'>FUND TRANSFER</option>
                        </select>
                    </div>
                    <br>
                     <div class="form-group" >
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TRN <input type="checkbox" name="trn" id="trn" value="YES" />&nbsp;&nbsp;&nbsp;
                    </div>
                     <div class="form-group" >
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CHEQUE <input type="checkbox" name="chq" id="chq" value="YES" />&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="form-group" >
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RETURNS <input type="checkbox" name="chq_rtn" id="chq_rtn" value="YES" />&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="form-group">
                    <select class="form-control" name="bank_data" id="bank_data"  required onchange="load_activebudle(this.value)"  >
                        <option value="ALL">Select Bank Account</option>
                        <? if($banks){foreach($banks as $raw){?>
                            <option value="<?=$raw->id?>" ><?=$raw->ref_id?> - <?=$raw->name?></option>
                        <? }}?>
                     
                    </select>
                   </div>
                    <div class="form-group">
                      <input type="text" name="fromdate" id="fromdate" placeholder="From Date" autocomplete="off"  class="form-control" >
                    </div>
                      <div class="form-group">
                      <input type="text" name="todate" id="todate" placeholder="To Date"  autocomplete="off" class="form-control" >
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                    </div>
                    </form>
                    <div class="col-md-6"> <!--Added By Madushan Ticket No:2604 01/04/2021-->
                        <div class="form-group">
                            <input type="text" class="form-control" name="start_date" id="start_date" autocomplete="off" placeholder="Start Date">
                        </div>
                         <div class="form-group">
                            <input type="text" class="form-control" name="end_date" id="end_date" autocomplete="off" placeholder="End Date">
                        </div>
                         <div class="form-group">
                        <select class="form-control" id="payment_mode_report" name="payment_mode_report">
                            <option value='all'>Select Payment Mode</option>
                            <option value='all'>All</option>
                            <option value='CSH'>CASH</option>
                            <option value='CHQ'>CHEQUE</option>
                            <option value='CREDIT CARD'>CREDIT CARD</option>
                            <option value='DEBIT CARD'>DEBIT CARD</option>
                            <option value='DD'>DIRECT DEPOSIT</option>
                            <option value='FT'>FUND TRANSFER</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <button  id="generate_excel" onclick="generateExcel();" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Generate Excel Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
             

<div class="row">
    <div id="loader" class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
    	<div class="tableFixHead">
        <table class="table">
            <thead>
            <tr>
                <th>Date</th>
                <th>No</th>
                <th>Ledger Account</th>
                <th>Receipt Number</th>
                 <th>TR Number</th>
                  <th>Payment Mode</th>
                     <th>Cheque Number</th>
                <th>Receipt Status</th>
                <th style="text-align:right;">Receipt Amount</th>
                 <th style="text-align:center;">Create By</th>
                <th>Cancelled By</th>
               
                <th colspan="3"></th>
            </tr>
            </thead>

            <?php
            $c=0;
            foreach ($entry_data->result() as $row)
            {
				
                $current_entry_type = entry_type_info($row->entry_type);
            ?>
            <tbody>
                <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">

            <?php
                
                echo "<td>" . date('Y-m-d',strtotime($row->date)). "</td>";
                echo "<td>" . anchor('accounts/entrymaster/view/' . $current_entry_type['label'] . "/" . $row->id, full_entry_number($row->entry_type, $row->number), array('title' => 'View ' . $current_entry_type['name'] . ' Entry', 'class' => 'anchor-link-a')) . "</td>";

                echo "<td>";
                echo $this->Tag_model->show_entry_tag($row->tag_id);
                echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
                echo "</td>";
$status= $row->RCTSTATUS;
if($row->CHQSTATUS=='DL')
$status= 'Cheque Return';
                echo "<td>" . $row->RCTNO . "</td>";
				  echo "<td>" . $row->temp_rctno . "</td>";
                    echo "<td>" . $row->rcvmode . "</td>";
				   echo "<td>" . $row-> 	CHQNO . "</td>";
                echo "<td>" . $status . "</td>";
                echo "<td align=right>" . number_format($row->cr_total, 2, '.', ',') . "</td>";
					echo "<td align=center>" . get_user_fullname_id($row->CRBY). "</td>";
				 
				echo "<td>" . $row->CNBY. "</td>";
                if($row->RCTSTATUS=="QUEUE")
                {
                    ?>
                    <td>
                        <a href=<?echo base_url().'accounts/entrymaster/edit/'.$current_entry_type['name'].'/'.$row->id;?>><i
                                    class="fa fa-edit nav_icon icon_blue"></i></a>
<!--                        <a onclick="return confirm('Are you sure you want to delete this Receipt Entry?');" href=--><?//echo base_url().'accounts/entrymaster/delete/'.$current_entry_type['name'].'/'.$row->id;?><!--><i-->
<!--                                class="fa fa-trash-o nav_icon icon_blue"></i></a>-->
                        <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i></a>
                            <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check-square-o nav_icon icon_blue"></i></a>
<!--                        <a onclick="return confirm('Are you sure you want to confirm this Receipt Entry?');" href=--><?//echo base_url().'accounts/entrymaster/confirm/'.$current_entry_type['name'].'/'.$row->id;?><!--><i-->
<!--                                class="fa fa-check-square-o nav_icon icon_blue"></i></a>-->
                    </td>
                    <?


                }
				  if($row->RCTSTATUS=="CONFIRM")
                {
                    ?>
                    <td>
                         <a href=<?=base_url().'accounts/entrymaster/printreciepts/'.$row->id;?>  title="Print"><i
                                    class="fa fa-print nav_icon icon_blue"></i></a>
                    </td>
                    <?


                }

                if($row->RCTSTATUS=="PRINT"){
                    ?>
                    <td>
                    <? if(check_access('reprint original')){?>
                    <a href=<?=base_url().'accounts/entrymaster/printreciepts/'.$row->id;?>  title="Print"><i
                                    class="fa fa-print nav_icon icon_green"></i></a>
                    <? }?>
                    <? if(check_access('reprint receipt')){?>
                    <a href=<?=base_url().'accounts/entrymaster/printreciepts_duplicate/'.$row->id;?>  title="Re Print"><i
                                    class="fa fa-print nav_icon icon_blue"></i></a>
                    <? }?>
                 <!--         <a  href="javascript:call_delete('< ?=$row->id?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i></a>
                  
<!--                    <a title="Cancel Receipt" onclick="return confirm('Are you sure you want to cancel this Receipt Entry');" href=--><?//echo base_url().'accounts/entrymaster/cancel/'.$current_entry_type['name'].'/'.$row->id;?><!--><i-->
<!--                            class="fa fa-times nav_icon icon_red"></i></a>-->
<?
$mydate=date('Y-m-d')." 00:00:00";
 if($row->date==$mydate){?>
 <? if(check_access('cancel receipt entry')) {?>
  <? if(check_chancel_true($row->id)){?>
                      <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete Receipt"><i class="fa fa-trash-o nav_icon icon_red"></i></a>
					  <? } }}?>
					  <? if(check_access('cancel receipt entry')) {?>
                       <? if(check_chancel_true($row->id)){?>
                         <a  href="javascript:call_cancel('<?=$row->id?>')" title="Cancel Receipt"><i class="fa fa-times nav_icon icon_blue"></i></a><? }?>
                           <?
                                    if($row->rcvmode=='CHQ'){  ?>
                          <a  href="javascript:call_return('<?=$row->id?>')" title="Return Cheque"><i class="fa fa-credit-card nav_icon icon_red"></i></a> 
                          <? }?>
<? }?>
                    <?
                 //   echo " &nbsp;" . anchor_popup('accounts/entrymaster/printreciepts/' . $row->id , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Print ' . $current_entry_type['name'] . ' Entry')), array('title' => 'Print ' . $current_entry_type['name']. ' Entry', 'width' => '600', 'height' => '600')) . " ";
                  //  echo" ";
                    ?>

                        </td>
                        <?
                }
                else
                {
                    echo"<td>&nbsp;";
                }

                echo "</tr>";
            }
            ?>
            </tbody>


        </table>
        </div>
        <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
    </div>
    <div id="load_list"></div>
</div>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
	</script>

  