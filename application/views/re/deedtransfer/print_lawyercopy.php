<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:70%;
font-size:90%;
}
.row{
	font-size:80%;
}
.table{
	font-size:100%;
}
</style>
<script type="text/javascript">

function print_function()
{
	window.print();
	//window.close();
}
</script>
<body onLoad="print_function()">

<?
//echo project_expence($details->prj_id);

?><? $loanpay=0; if($paydata)$loanpay=$paydata->totcap;
	$totpay=$current_res->down_payment+$loanpay;
	?>
 <div class="table-responsive bs-example widget-shadow"  >
  <div class="form-title">
		<h4>Customer Reservation Details
      </h4>
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
     <tr>
    <th>Pay Outside Lawyer</th><td><?=$deed_data->outside_lawyer?></td>
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
    <div class="form-title">
								<h4>Deed Transfer Details  <span style="float:right"> <a href="javascript:load_printscrean1('<?=$lot_id?>','<?=$prj_id?>')"> <i class="fa fa-print nav_icon"></i></a>
</span></h4>
							</div>
   <div class=" widget-shadow " data-example-id="basic-forms">

     <table class="table">
    <tr>
    <th rowspan="3">Deed Transfer Names </th><td>1. <?=$deed_data->trn_name1?> - <?=$deed_data->trn_nic1?></td></tr>
    <tr><td>2. <?=$deed_data->trn_name2?> - <?=$deed_data->trn_nic2?></td></tr>
    <tr><td>3. <?=$deed_data->trn_name3?> - <?=$deed_data->trn_nic3?></td></tr>
    <tr>
    <th>Address</th><td><?=$deed_data->address1?>, <?=$deed_data->address2?>, <?=$deed_data->address3?></td></tr>
   <tr> <th>Language</th><td><?=$deed_data->language?></td>
    </tr>
    </table>
    <br><br>

     <table width="100%"><tr>
 <td>.....................</td>
 <td>.....................</td>
 <td>.....................</td>
 <td>.....................</td></tr>
 <tr><td><?=get_user_fullname_id($deed_data->create_by)?></td>
 <td>Manager</td>
 <td><?=get_user_fullname_id($deed_data->form_confirm_by)?></td>
 <td>MD</td></tr>
  <tr><td><strong>Create By</strong></td>
  <td><strong>Generate By</strong></td>
  <td><strong>Confirmed By</strong></td>
  <td><strong>Checked By</strong></td>
  <tr></table>


</div>
