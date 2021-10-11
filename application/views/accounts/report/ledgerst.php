<!DOCTYPE HTML>
<html>
<head>

<?
$this->load->model('Ledger_model');
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_accounts");
if($month!="0")
{
	if($month=='01' ||$month=='02' || $month=='03')
	{

	$yeararr=explode('-',$this->session->userdata('fy_end'));
	}
	else
	{
		$yeararr=explode('-',$this->session->userdata('fy_start'));
	}
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

	$year=$yeararr[0];
	$stdate=$year.'-'.$month.'-01';
	$enddate=$year.'-'.$month.'-31';

}
else if($fromdate !="" &  $todate !="")
{
	$stdate=$fromdate;
	$enddate=$todate;
}
else
{
	$stdate=$this->session->userdata('fy_start');
	$enddate=$this->session->userdata('fy_end');
}

define("FYSTV",$stdate);
define("FYENDV",$enddate);
?>
<link rel="stylesheet" href="<?=base_url()?>media/css/yearpicker.css" />
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script type="text/javascript">

 $( function() {
    $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
  $(document).ready(function() {
  $("#ledger_id").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select an Instance"
    });
	 $("#month").chosen({
     allow_single_deselect : true,
	 width: '100%',
    });
	$("#project").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select a Project"
    });
	$("#lot").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select a Lot"
    });
  });
  function clearAll(){
	$("#month").val('').trigger("chosen:updated");
	$('#fromdate').val('');
	$('#todate').val('');
	$('#amount').val('');
	$('#project').val('');
	$('#rctno').val('');
	$('#chequeno').val('');
	$('#payeename').val('');
}
function load_detailpopup(type,id)
{

				$('#popupform').delay(1).fadeIn(600);
				$( "#popupform" ).load( "<?=base_url()?>accounts/entry/view_popup/"+type+"/"+ id);

}
</script>
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>
<script>
$(document).ready(function(){
      $('#create_excel').click(function(){

		  var string = "<?=companyname?> Ledger Statement of <?=$ref_id?> - <?=$ledger_name?> (<?=$ledger_id?>) from <?=FYSTV?> to <?=FYENDV?>";

		   $("#ledger_table").find("tr.ledgername").first().children("th:nth-child(1)").text(string);

           $(".table2excel").table2excel({
                exclude: ".noExl",
                name: "Ledger Statement",
                filename: "Ledger_Statement.xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });

			$('.ledgername').html('');

      });

	  var availableTags = [<?
	  foreach($suppliers as $data){
		echo '"'.$data->first_name.' '.$data->last_name.'",';
	  }
	  ?>];

	  $( "#payeename" ).autocomplete({
      		source: availableTags
    	});

	/*var availableTags2 = [];

	  $( "#project" ).autocomplete({
      		source: availableTags2
    	});*/


 });

function getLedgerReportall(){
	var month = $('#month').val();
	var year = $('#year').val();
	if(month == '00'){
		$('.alert').css('display', 'block');
		$('.alert').html('Please Select Month');
	}else{
		$('.alert').css('display', 'none');
		window.open( "<?=base_url()?>accounts/report/all_ledgerst/"+year+"/"+month );
	}
}

 function loadLots(value){

	 if(value == ''){
		$('#lot').prop('disabled', true);
		$('#lot').val('').trigger("chosen:updated");
	 }else{
		 $.ajax({
			cache: false,
			type: 'POST',
			url: '<?php echo base_url().'re/lotdata/get_blocklist_json';?>',
			data: {prj_id: value },
			success: function(data) {
				if (data) {
					$('#lot').prop('disabled', false);
					$('#lot').val('').trigger("chosen:updated");
					$('#lot').append(data);
					$('#lot').trigger("chosen:updated");
				}
				else
				{
					//alert('Unable to check customer ID. Please search on top search field');
				}
			}
		});
	 }
 }
</script>
<style>
	.tableFixHead { overflow-y: auto; height: 400px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
<div id="page-wrapper">
 <div class="main-page">
  <h3 class="title1">Ledger Statement</h3>
       <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
       <div class="alert alert-danger" style="display:none;" role="alert"></div>
        <div class="form-title">
		<h4><a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</h4>
	</div>
       <div class="form-body ">
              <?php
$page_count = 0;
	//if ( ! $print_preview)
	//{
		echo form_open('accounts/report/ac_ledgerst/' . $ledger_id);
		?>
       <div class="form-group">
          <div class="col-sm-4">
		<?

		echo form_input_ledger('ledger_id', $ledger_id);

	//	echo form_submit('submit', 'Show');
	?> </div>

    	<div class="col-sm-2">
                    <select class="form-control" placeholder="Select Month" name="month" id="month">
                    <option value="00">Select Month</option>
                     <option <? if($month=='01'){ echo'selected'; }?> value="01">January</option>
                     <option <? if($month=='02'){ echo'selected'; }?> value="02">February</option>
                     <option <? if($month=='03'){ echo'selected'; }?> value="03">March</option>
                     <option <? if($month=='04'){ echo'selected'; }?> value="04">April</option>
                     <option <? if($month=='05'){ echo'selected'; }?> value="05">May</option>
                     <option <? if($month=='06'){ echo'selected'; }?> value="06">June</option>
                     <option <? if($month=='07'){ echo'selected'; }?> value="07">July</option>
                     <option <? if($month=='08'){ echo'selected'; }?> value="08">August</option>
                     <option <? if($month=='09'){ echo'selected'; }?> value="09">September</option>
                     <option <? if($month=='10'){ echo'selected'; }?> value="10">October</option>
                      <option <? if($month=='11'){ echo'selected'; }?> value="11">November</option>
                      <option <? if($month=='12'){ echo'selected'; }?> value="12">December</option>
                    </select>
                </div>

              	<div class="col-sm-2 ">
                    <input type="text" name="fromdate" id="fromdate" placeholder="From Date" <? echo 'value="'.$fromdate.'"';?>  class="form-control" autocomplete="off" >
                </div>
                <div class="col-sm-2 ">
                    <input type="text" name="todate" id="todate" placeholder="To Date" <? echo 'value="'.$todate.'"';?> class="form-control" autocomplete="off"  >
                </div>

                <div class="col-sm-2 ">
                    <input type="text" name="amount" id="amount" <? echo 'value="'.$amount.'"';?> placeholder="Amount"  class="form-control" autocomplete="off"  >
                </div>
                <div class="col-sm-4">
                	<select class="form-control" placeholder="Project" onChange="loadLots(this.value);" name="project" id="project">
                    	<option value=""></option>
                        <?
                        foreach($projects as $data2){
						  echo '<option value="'.$data2->prj_id.'"';
						  if($data2->prj_id == $project_id){
							 echo ' selected ';
						  }
						  echo '>'.$data2->project_name.'</option>';
						}
						?>
                    </select>
                </div>
                <div class="col-sm-2 ">
                    <select class="form-control" placeholder="Lot" disabled name="lot" id="lot">
                    	<option value=""></option>
                    </select>
                </div>
                <div class="col-sm-2 ">
                    <input type="text" name="rctno" id="rctno" <? echo 'value="'.$rctno.'"';?> placeholder="Receipt number"  class="form-control"  autocomplete="off" >
                </div>
                <div class="col-sm-2 ">
                    <input type="text" name="chequeno" id="chequeno" <? echo 'value="'.$chequeno.'"';?> placeholder="Cheque number"  class="form-control"  autocomplete="off" >
                </div>
                  <div class="col-sm-2 ">
                    <input type="text" name="payeename" id="payeename" <? echo 'value="'.$payeename.'"';?> placeholder="Payee Name"  class="form-control"  autocomplete="off" >
                </div>
                <div class="clearfix"> </div><div class="clearfix"> </div><br>
				<div class="col-sm-2 " style="float:right; text-align:right;">
					<button type="submit" class="btn btn-primary ">Show</button>
                    <button type="button" class="btn btn-success" onClick="clearAll();">Clear</button></div>
				</div>
				<div class="clearfix"> </div><div class="clearfix"> </div><br>

    <?php
		echo "</p>";
		echo form_close();
//	}

	/* Pagination configuration */
	?>

    <?php
	if ($ledger_id != "")
	{	
		$direct_payment = false;
	//echo $month;
	?>
    <div class="form-title">
								<h4>Ledger Statement from <?=FYSTV?> to <?=FYENDV?></h4>
							</div>
    <?
    	
		if($month!="00" || $fromdate!="")
		list ($opbalance, $optype) = $this->Ledger_model->get_op_balance($ledger_id);
		else /* Opening Balance */
		list ($opbalance, $optype) = $this->Ledger_model->get_op_balance($ledger_id);
		if($month!="00" || $fromdate!=""){
			$clbalance = $this->Ledger_model->get_ledger_balance($ledger_id); /* Final Closing Balance */
		}else{
			$clbalance = $this->Ledger_model->get_ledger_balance_period($ledger_id,FYSTV,FYENDV);
		}
		/* Ledger Summary */
		if($month=="00" &  $fromdate==""){
		echo "<table class=\"table\">";
		echo "<tr class=\"warning\">";
		echo "<td><b>Opening Balance</b></td><td>" . convert_opening($opbalance, $optype) . "</td>";
		echo "</tr>";
		echo "<tr  class=\"warning\">";
		echo "<td><b>Closing Balance</b></td><td>" . convert_amount_dc($clbalance) . "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<br />";
		}
		if ( ! $print_preview) {
			$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc,ac_chqprint.CHQNO ,ac_recieptdata.RCTNO,,re_projectms.project_name,re_prjaclotdata.lot_number,ac_chqprint.CHQNAME');
			$this->db->where('ac_entries.date >=', FYSTV);
			$this->db->where('ac_entries.date <=', FYENDV);
			if($amount!=''){
				$this->db->where('ac_entry_items.amount', $amount);
			}
			/*if($project!=''){
				$this->db->like('re_projectms.project_name', $project,'both');
			}*/
			if($rctno!=''){
				$this->db->like('ac_recieptdata.RCTNO', $rctno,'both');
			}
			if($chequeno!=''){
				$this->db->like('ac_chqprint.CHQNO', $chequeno,'both');
			}
			/*if($payeename!=''){
				//$this->db->like('ac_chqprint.CHQNAME', $payeename,'both');
				$this->db->like('ac_payvoucherdata.payeename', $payeename,'both');
			}*/
			$this->db->from('ac_entries');
			$this->db->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id');
			$this->db->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left');
			$this->db->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left');
			$this->db->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left');
			$this->db->join('re_prjaclotdata', 're_prjaclotdata.lot_id =ac_entries.lot_id','left');
			$this->db->where('ac_entry_items.ledger_id', $ledger_id);
			$this->db->order_by('ac_entries.date', 'asc');
			$this->db->order_by('ac_entries.number', 'asc');
			$ac_ledgerst_q = $this->db->get();
		} else {
			$page_count = 0;
			$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc,ac_chqprint.CHQNO ,ac_recieptdata.RCTNO,re_projectms.project_name,re_prjaclotdata.lot_number,ac_chqprint.CHQNAME');
			$this->db->where('ac_entries.date >=', FYSTV);
			$this->db->where('ac_entries.date <=', FYENDV);
			if($amount!=''){
				$this->db->where('ac_entry_items.amount', $amount);
			}
			/*if($project!=''){
				$this->db->like('re_projectms.project_name', $project,'both');
			}*/
			if($rctno!=''){
				$this->db->like('ac_recieptdata.RCTNO', $rctno,'both');
			}
			if($chequeno!=''){
				$this->db->like('ac_chqprint.CHQNO', $chequeno,'both');
			}
			/*if($payeename!=''){
				//$this->db->like('ac_chqprint.CHQNAME', $payeename,'both');
				$this->db->like('ac_payvoucherdata.payeename', $payeename,'both');
			}*/
			$this->db->from('ac_entries');
			$this->db->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id');
			$this->db->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left');
			$this->db->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left');
			$this->db->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left');
			$this->db->join('re_prjaclotdata', 're_prjaclotdata.lot_id =ac_entries.lot_id','left');
			$this->db->where('ac_entry_items.ledger_id', $ledger_id);
			$this->db->order_by('ac_entries.date', 'asc');
			$this->db->order_by('ac_entries.number', 'asc');
			$ac_ledgerst_q = $this->db->get();
		}
		echo '<div class="tableFixHead">';
		echo "<table id='ledger_table' class=\"table table-bordered table2excel\">";
		echo "<thead>
				  <tr class='ledgername'>
					  <th colspan='13'></th>
				  </tr>
			  </thead>";
		echo "<thead><tr><th>Date</th><th>No.</th><th>Ledger Name</th><th>Type</th><th>RCT/CHEQUE No</th><th>Voucher No</th><th>Payee Name</th><th>Project Name </th><th>Lot Number </th><th>Dr Amount</th><th>Cr Amount</th><th>Balance</th></tr></thead>";
		$odd_even = "odd";

		$cur_balance = 0;

			/* Opening balance */
			if ($optype == "D")
			{
				$cur_balance = float_ops($cur_balance, $opbalance, '+');
			} else {
				$cur_balance = float_ops($cur_balance, $opbalance, '-');
			}

			/* Calculating previous balance */
			$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc');
			$this->db->where('ac_entries.date <', FYSTV);
			$this->db->where('ac_entries.date >=',$this->session->userdata('fy_start'));
		$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');

			$prevbal_q = $this->db->get();
			foreach ($prevbal_q->result() as $row )
			{
				if ($row->ac_entry_items_dc == "D")
					$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
				else
					$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
			}

			/* Show new current total */
			echo "<tr  class=\"info\"><td colspan=11>Opening</td><td>" . convert_amount_dc( $this->Ledger_model->get_opledger_balance_period( $ledger_id,FYSTV,FYENDV)) . "</td></tr>";

//echo $cur_balance;
		foreach ($ac_ledgerst_q->result() as $row)
		{	
			$payee_name = '';
			if($project!='' && $lot == '' ){
				if($project == $row->project_name || strpos(get_entry_projectlist($row->ac_entries_id),$project) !== false ){
					$current_entry_type = entry_type_info($row->ac_entries_entry_type);

					echo "<tr class=\"tr-" . $odd_even . "\">";
					echo "<td>";
					echo $row->ac_entries_date;
					echo "</td>";
					echo "<td>";
				//	echo anchor('accounts/entry/view/' . $current_entry_type['label'] . '/' . $row->ac_entries_id, full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number), array('title' => 'View ' . ' Entry', 'class' => 'anchor-link-a'));
				?>
				<a href="javascript:load_detailpopup('<?=$current_entry_type['label']?>','<?=$row->ac_entries_id?>')" ><?=full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number)?></a>

				<?
					echo "</td>";

					/* Getting opposite Ledger name */
					echo "<td>";
					echo $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'html');
					if ($row->ac_entries_narration)
						echo "<div class=\"small-font\">" . character_limiter($row->ac_entries_narration, 50) . "</div>";
					echo "</td>";

					echo "<td>";
					echo $current_entry_type['name'];
					echo "</td>";
					echo "<td>";
						if($row->CHQNO != '' || $row->RCTNO != '')
							echo $row->CHQNO .$row->RCTNO;
						else{
							$invo_chq_details = get_inv_payment_details($row->ac_entries_id); //reaccount_helper
							if($invo_chq_details){
								echo $invo_chq_details->CHQNO;
								$payee_name = $invo_chq_details->CHQNAME;
							}
					
						}
					echo "</td>";
					echo "<td>";
					$vouchers =  get_vouchers_by_entryid($row->ac_entries_id,$ledger_id); //this function is in re account helper
					// foreach($vouchers as $data){
					// 	echo $data->voucherid.'<br>';
					// }
					if($vouchers){
					foreach($vouchers as $data){//ticket number 653 reopen update by nadee.
							
							if($data->direct_payid != '')
							{
								echo get_ontimepayment_serial($data->direct_payid); //
								$direct_payment = true;
								$payee_code = $data->payeecode;
							}
							else
							{	
								echo $data->voucherid;
								if($data->voucher_ncode!='undefined' || $data->voucher_ncode!=''){
										echo ' / '.$data->voucher_ncode;
								}
								$direct_payment = false;
							}
							
								echo "</br>";
						}
					}
				else
				{

					$vouchers =  get_invoice_vouchers_by_entryid($row->ac_entries_id,$ledger_id); //this function is in re account helper
				// foreach($vouchers as $data){
				// 	echo $data->voucherid.'<br>';
				// }
					if($vouchers){
					foreach($vouchers as $data){//ticket number 653 reopen update by nadee.
						
							if($data->direct_payid != '')
							{
								echo get_ontimepayment_serial($data->direct_payid); //
								$direct_payment = true;
								$payee_code = $data->payeecode;
							}
							else
							{	
								echo 'Settel by '.$data->voucherid;
								if($data->voucher_ncode!='undefined' || $data->voucher_ncode!=''){
										echo ' / '.$data->voucher_ncode;
								}
								$direct_payment = false;
							}
							
								echo "</br>";

						}
					}

				}
				echo "</td>";
				echo "<td>";
					if($direct_payment)
					{
						$emp_details = get_emp_details($payee_code); //custom helper
						if($emp_details)
							echo $emp_details->emp_no.'-'.$emp_details->initial.' '.$emp_details->surname;
						else
							echo '';
					}
				else
					{
						if($row->CHQNAME != '')
							echo $row->CHQNAME;
						else
							echo $payee_name;
					}
					echo "</td>";
					echo "<td>";
					echo $row->project_name.(get_entry_projectlist($row->ac_entries_id));
					echo "</td>";
					echo "<td>";
					echo $row->lot_number ;
					echo "</td>";
					if ($row->ac_entry_items_dc == "D")
					{
						$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
						echo "<td>";
						echo "";//convert_dc($row->ac_entry_items_dc);
						echo " ";
						echo $row->ac_entry_items_amount;
						echo "</td>";
						echo "<td></td>";
					} else {
						$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
						echo "<td></td>";
						echo "<td>";
						echo "";//convert_dc($row->ac_entry_items_dc);
						echo " ";
						echo $row->ac_entry_items_amount;
						echo "</td>";
					}
					echo "<td>";
					echo convert_amount_dc($cur_balance);
					echo "</td>";
					echo "</tr>";
					$odd_even = ($odd_even == "odd") ? "even" : "odd";

				}
			}else if($project!='' && $lot != ''){
				if($project == $row->project_name & $lot == $row->lot_number || strpos(get_entry_projectlist($row->ac_entries_id),$project) !== false){
					$current_entry_type = entry_type_info($row->ac_entries_entry_type);

					echo "<tr class=\"tr-" . $odd_even . "\">";
					echo "<td>";
					echo $row->ac_entries_date;
					echo "</td>";
					echo "<td>";
					//echo anchor('accounts/entry/view/' . $current_entry_type['label'] . '/' . $row->ac_entries_id, full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number), array('title' => 'View ' . ' Entry', 'class' => 'anchor-link-a'));
					?>
					<a href="javascript:load_detailpopup('<?=$current_entry_type['label']?>','<?=$row->ac_entries_id?>')" ><?=full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number)?></a>

					<?
					echo "</td>";

					/* Getting opposite Ledger name */
					echo "<td>";
					echo $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'html');
					if ($row->ac_entries_narration)
						echo "<div class=\"small-font\">" . character_limiter($row->ac_entries_narration, 50) . "</div>";
					echo "</td>";

					echo "<td>";
					echo $current_entry_type['name'];
					echo "</td>";
					echo "<td>";
						if($row->CHQNO != '' || $row->RCTNO != '')
							echo $row->CHQNO .$row->RCTNO;
						else{
							$invo_chq_details = get_inv_payment_details($row->ac_entries_id); //reaccount_helper
							if($invo_chq_details){
								echo $invo_chq_details->CHQNO;
								$payee_name = $invo_chq_details->CHQNAME;
							}
					
						}
					echo "</td>";
					echo "<td>";
					$vouchers =  get_vouchers_by_entryid($row->ac_entries_id,$ledger_id); //this function is in re account helper
					// foreach($vouchers as $data){
					// 	echo $data->voucherid.'<br>';
					// }
					if($vouchers){
					foreach($vouchers as $data){//ticket number 653 reopen update by nadee.
							if($data->direct_payid != '')
							{
								echo get_ontimepayment_serial($data->direct_payid); //
								$direct_payment = true;
								$payee_code = $data->payeecode;
							}
							else
							{	
								echo $data->voucherid;
								if($data->voucher_ncode!='undefined' || $data->voucher_ncode!=''){
										echo ' / '.$data->voucher_ncode;
								}
								$direct_payment = false;
							}
							
								echo "</br>";
						}
					}
				else
				{

					$vouchers =  get_invoice_vouchers_by_entryid($row->ac_entries_id,$ledger_id); //this function is in re account helper
				// foreach($vouchers as $data){
				// 	echo $data->voucherid.'<br>';
				// }
					if($vouchers){
					foreach($vouchers as $data){//ticket number 653 reopen update by nadee.
						
							if($data->direct_payid != '')
							{
								echo get_ontimepayment_serial($data->direct_payid); //
								$direct_payment = true;
								$payee_code = $data->payeecode;
							}
							else
							{	
								echo 'Settel by '.$data->voucherid;
								if($data->voucher_ncode!='undefined' || $data->voucher_ncode!=''){
										echo ' / '.$data->voucher_ncode;
								}
								$direct_payment = false;
							}
							
								echo "</br>";

						}
					}

				}
				echo "</td>";
				echo "<td>";
					if($direct_payment)
					{
						$emp_details = get_emp_details($payee_code); //custom helper
						if($emp_details)
							echo $emp_details->emp_no.'-'.$emp_details->initial.' '.$emp_details->surname;
						else
							echo '';
					}
				else
					{
						if($row->CHQNAME != '')
							echo $row->CHQNAME;
						else
							echo $payee_name;
					}
					echo "</td>";
					echo "<td>";
					echo $row->project_name.(get_entry_projectlist($row->ac_entries_id));
					echo "</td>";
					echo "<td>";
					echo $row->lot_number ;
					echo "</td>";
					if ($row->ac_entry_items_dc == "D")
					{
						$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
						echo "<td>";
						echo "";//"";//convert_dc($row->ac_entry_items_dc);
						echo " ";
						echo $row->ac_entry_items_amount;
						echo "</td>";
						echo "<td></td>";
					} else {
						$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
						echo "<td></td>";
						echo "<td>";
						echo "";//"";//convert_dc($row->ac_entry_items_dc);
						echo " ";
						echo $row->ac_entry_items_amount;
						echo "</td>";
					}
					echo "<td>";
					echo convert_amount_dc($cur_balance);
					echo "</td>";
					echo "</tr>";
					$odd_even = ($odd_even == "odd") ? "even" : "odd";
				}
			}else if($payeename!=''){
				if(strpos(get_payee_by_entryid($row->ac_entries_id),$payeename) !== false ){
					$current_entry_type = entry_type_info($row->ac_entries_entry_type);

					echo "<tr class=\"tr-" . $odd_even . "\">";
					echo "<td>";
					echo $row->ac_entries_date;
					echo "</td>";
					echo "<td>";
					//echo anchor('accounts/entry/view/' . $current_entry_type['label'] . '/' . $row->ac_entries_id, full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number), array('title' => 'View ' . ' Entry', 'class' => 'anchor-link-a'));
					?>
					<a href="javascript:load_detailpopup('<?=$current_entry_type['label']?>','<?=$row->ac_entries_id?>')" ><?=full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number)?></a>

					<?
					echo "</td>";

					/* Getting opposite Ledger name */
					echo "<td>";
					echo $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'html');
					if ($row->ac_entries_narration)
						echo "<div class=\"small-font\">" . character_limiter($row->ac_entries_narration, 50) . "</div>";
					echo "</td>";

					echo "<td>";
					echo $current_entry_type['name'];
					echo "</td>";
					echo "<td>";
						if($row->CHQNO != '' || $row->RCTNO != '')
							echo $row->CHQNO .$row->RCTNO;
						else{
							$invo_chq_details = get_inv_payment_details($row->ac_entries_id); //reaccount_helper
							if($invo_chq_details){
								echo $invo_chq_details->CHQNO;
								$payee_name = $invo_chq_details->CHQNAME;
							}
					
						}					
					echo "</td>";
					echo "<td>";
					$vouchers =  get_vouchers_by_entryid($row->ac_entries_id,$ledger_id); //this function is in re account helper
					// foreach($vouchers as $data){
					// 	echo $data->voucherid.'<br>';
					// }
					if($vouchers){
					foreach($vouchers as $data){//ticket number 653 reopen update by nadee.
							if($data->direct_payid != '')
							{
								echo get_ontimepayment_serial($data->direct_payid); //
								$direct_payment = true;
								$payee_code = $data->payeecode;
							}
							else
							{	
								echo $data->voucherid;
								if($data->voucher_ncode!='undefined' || $data->voucher_ncode!=''){
										echo ' / '.$data->voucher_ncode;
								}
								$direct_payment = false;
							}
							
								echo "</br>";
						}
					}
				else
				{

					$vouchers =  get_invoice_vouchers_by_entryid($row->ac_entries_id,$ledger_id); //this function is in re account helper
				// foreach($vouchers as $data){
				// 	echo $data->voucherid.'<br>';
				// }
					if($vouchers){
					foreach($vouchers as $data){//ticket number 653 reopen update by nadee.
						
							if($data->direct_payid != '')
							{
								echo get_ontimepayment_serial($data->direct_payid); //
								$direct_payment = true;
								$payee_code = $data->payeecode;
							}
							else
							{	
								echo 'Settel by '.$data->voucherid;
								if($data->voucher_ncode!='undefined' || $data->voucher_ncode!=''){
										echo ' / '.$data->voucher_ncode;
								}
								$direct_payment = false;
							}
							
								echo "</br>";

						}
					}

				}
				echo "</td>";
				echo "<td>";
					if($direct_payment)
					{
						$emp_details = get_emp_details($payee_code); //custom helper
						if($emp_details)
							echo $emp_details->emp_no.'-'.$emp_details->initial.' '.$emp_details->surname;
						else
							echo '';
					}
				else
					{
						if($row->CHQNAME != '')
							echo $row->CHQNAME;
						else
							echo $payee_name;
					}
					echo "</td>";
					echo "<td>";
					echo $row->project_name.(get_entry_projectlist($row->ac_entries_id));
					echo "</td>";
					echo "<td>";
					echo $row->lot_number ;
					echo "</td>";
					if ($row->ac_entry_items_dc == "D")
					{
						$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
						echo "<td>";
						echo "";//convert_dc($row->ac_entry_items_dc);
						echo " ";
						echo $row->ac_entry_items_amount;
						echo "</td>";
						echo "<td></td>";
					} else {
						$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
						echo "<td></td>";
						echo "<td>";
						echo "";//convert_dc($row->ac_entry_items_dc);
						echo " ";
						echo $row->ac_entry_items_amount;
						echo "</td>";
					}
					echo "<td>";
					echo "";//convert_amount_dc($cur_balance);
					echo "</td>";
					echo "</tr>";
					$odd_even = ($odd_even == "odd") ? "even" : "odd";
				}
			}else{
				$current_entry_type = entry_type_info($row->ac_entries_entry_type);

				echo "<tr class=\"tr-" . $odd_even . "\">";
				echo "<td>";
				echo $row->ac_entries_date;
				echo "</td>";
				echo "<td>";
				//echo anchor('accounts/entry/view/' . $current_entry_type['label'] . '/' . $row->ac_entries_id, full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number), array('title' => 'View ' . ' Entry', 'class' => 'anchor-link-a'));
				?>
				<a href="javascript:load_detailpopup('<?=$current_entry_type['label']?>','<?=$row->ac_entries_id?>')" ><?=$row->ac_entries_id?></a>

				<?
				echo "</td>";

				/* Getting opposite Ledger name */
				echo "<td>";
				echo $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'html');
				if ($row->ac_entries_narration)
					echo "<div class=\"small-font\">" . character_limiter($row->ac_entries_narration, 50) . "</div>";
				echo "</td>";

				echo "<td>";
				echo $current_entry_type['name'];
				echo "</td>";
				echo "<td>";
				if($row->CHQNO != '' || $row->RCTNO != '')
					echo $row->CHQNO .$row->RCTNO;
				else{
					$invo_chq_details = get_inv_payment_details($row->ac_entries_id); //reaccount_helper
					if($invo_chq_details){
						echo $invo_chq_details->CHQNO;
						$payee_name = $invo_chq_details->CHQNAME;
					}
					
				}
				echo "</td>";
				echo "<td>";
				$vouchers =  get_vouchers_by_entryid($row->ac_entries_id,$ledger_id); //this function is in re account helper
				// foreach($vouchers as $data){
				// 	echo $data->voucherid.'<br>';
				// }
				if($vouchers){
				foreach($vouchers as $data){//ticket number 653 reopen update by nadee.
						if($data->direct_payid != '')
							{
								echo get_ontimepayment_serial($data->direct_payid); //
								$direct_payment = true;
								$payee_code = $data->payeecode;
							}
							else
							{	
								echo $data->voucherid;
								if($data->voucher_ncode!='undefined' || $data->voucher_ncode!=''){
										echo ' / '.$data->voucher_ncode;
								}
								$direct_payment = false;
							}
							
								echo "</br>";
					}
				}
				else
				{

					$vouchers =  get_invoice_vouchers_by_entryid($row->ac_entries_id,$ledger_id); //this function is in re account helper
				// foreach($vouchers as $data){
				// 	echo $data->voucherid.'<br>';
				// }
					if($vouchers){
					foreach($vouchers as $data){//ticket number 653 reopen update by nadee.
						
							if($data->direct_payid != '')
							{
								echo get_ontimepayment_serial($data->direct_payid); //
								$direct_payment = true;
								$payee_code = $data->payeecode;
							}
							else
							{	
								echo 'Settel by '.$data->voucherid;
								if($data->voucher_ncode!='undefined' || $data->voucher_ncode!=''){
										echo ' / '.$data->voucher_ncode;
								}
								$direct_payment = false;
							}
							
								echo "</br>";

						}
					}

				}
				echo "</td>";
				echo "<td>";
				if($direct_payment)
					{
						$emp_details = get_emp_details($payee_code); //custom helper
						if($emp_details)
							echo $emp_details->emp_no.'-'.$emp_details->initial.' '.$emp_details->surname;
						else
							echo '';
					}
				else
					{
						if($row->CHQNAME != '')
							echo $row->CHQNAME;
						else
							echo $payee_name;
					}
				echo "</td>";
				echo "<td>";
				echo $row->project_name.(get_entry_projectlist($row->ac_entries_id));
				echo "</td>";
				echo "<td>";
				echo $row->lot_number ;
				echo "</td>";
				if ($row->ac_entry_items_dc == "D")
				{
					$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
					echo "<td>";
					echo "";//convert_dc($row->ac_entry_items_dc);
					echo " ";
					echo $row->ac_entry_items_amount;
					echo "</td>";
					echo "<td></td>";
				} else {
					$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
					echo "<td></td>";
					echo "<td>";
					echo "";//convert_dc($row->ac_entry_items_dc);
					echo " ";
					echo $row->ac_entry_items_amount;
					echo "</td>";
				}
				echo "<td>";
				echo "";//convert_amount_dc($cur_balance);
				echo "</td>";
				echo "</tr>";
				$odd_even = ($odd_even == "odd") ? "even" : "odd";

			}
		}

		/* Current Page Closing Balance */
		if($amount=='' && $project=='' && $payeename=='' && $rctno=='' && $chequeno==''){
			echo "<tr class=\"info\"><td colspan=11>Closing</td><td>" .  convert_amount_dc($this->Ledger_model->get_ledger_balance_period( $ledger_id,FYSTV,FYENDV)) . "</td></tr>";
		}
		echo "</table></div>";
	}//$this->Ledger_model->get_ledger_balance_period( $ledger_id,FYSTV,FYENDV)
?>


<?php
  //$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
//  echo "<a href='$url'>Back</a>";
?></div> </div>
        <div class="row calender widget-shadow"  style="display:none">
            <h4 class="title">Calender</h4>
            <div class="cal1">

            </div>
        </div>



        <div class="clearfix"> </div>
    </div>
</div>

<script src="<?=base_url()?>media/js/yearpicker.js"></script>
<script>
  $(document).ready(function() {
	$(".yearpicker").yearpicker({
	  year: <?=date('Y')?>,
	  startYear: 2017,
	});
  });
</script>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
	</script>
		<!--footer-->
<?php
	$this->load->view("includes/footer");
?>
