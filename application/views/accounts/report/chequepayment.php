<!DOCTYPE HTML>
<html>
<head>

<?
$this->load->model('Ledger_model');
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_accounts");

if($fromdate !="" &  $todate !="")
{
	$stdate=$fromdate;
	$enddate=$todate;
}
else if($fromdate !='' && $todate ==''){
	$stdate=$fromdate;
	$enddate=$this->session->userdata('fy_end');
}
else if($fromdate =='' && $todate !=''){
	$stdate=$this->session->userdata('fy_start');
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
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script type="text/javascript">

 $( function() {
    $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
  $(document).ready(function() {
 	 $("#ledger_id").chosen({
     	allow_single_deselect : true,
	 	width:'70%',
    });
	var tableToExcel = (function() {
	  var uri = 'data:application/vnd.ms-excel;base64,'
		, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
		, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
		, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	  return function(table, name, fileName) {
		if (!table.nodeType) table = document.getElementById(table)
		var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
		
		var link = document.createElement("A");
		link.href = uri + base64(format(template, ctx));
		link.download = fileName || 'Workbook.xls';
		link.target = '_blank';
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	  }
	})();

	$('#create_excel').click(function(){
		tableToExcel('chequetable', 'Cheque_Payments', 'Cheque_Payments_<?=date('Y_m_d');?>.xls');
		// util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
	});
  });
  
function clearAll(){
	$('#fromdate').val('');
	$('#todate').val('');
}
</script>
<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
	</style>
<div id="page-wrapper">
 <div class="main-page">
  <h3 class="title1">Cheque Payment</h3>
       <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
        <div class="form-title">
        <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
</h4>
	</div>
       <div class="form-body ">
    <?php
		$page_count = 0;
		echo form_open('accounts/report/cheque_payment/');
		?>
       <div class="form-group">
          <div class="col-sm-4"> 
				<select class="form-control" placeholder="Qick Search.."    id="ledger_id" name="ledger_id">
                    <option value="ALL">All Account</option>
                     <?    foreach($ladgers as $row){?>
                    <option value="<?=$row->id?>" <? if($row->id==$ledger_id){ ?> selected <? }?>><?=$row->name?> </option>
                    <? }?>
                </select>
			</div> 
                                            
              	<div class="col-sm-2 ">
                    <input type="text" name="fromdate" id="fromdate" placeholder="From Date" <? echo 'value="'.$fromdate.'"';?>  class="form-control" autocomplete="off" >
                </div>
                <div class="col-sm-2 ">
                    <input type="text" name="todate" id="todate" placeholder="To Date" <? echo 'value="'.$todate.'"';?> class="form-control" autocomplete="off"  >
                </div>
            	<div class="col-sm-4 " style="float:right; text-align:right;">
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
	?>
			<div class="form-title">
				<h4>Cheque Payment from <?=FYSTV?> to <?=FYENDV?>
				</h4>
			</div>

	<?php
			if (! $print_preview) {
					$this->db->select('ac_ledgers.id as ac_ledgers_id,ac_ledgers.name as ac_ledgers_name ,ac_entries.id as entry_id,ac_entries.number,ac_entries.cr_total as ac_entries_cr_total,ac_entries.narration as ac_entries_narration,ac_chqprint.CRDATE as ac_chqprint_CRDATE,ac_chqprint.CHQNO as ac_chqprint_CHQNO,ac_chqprint.CHQNAME as ac_chqprint_CHQNAME,ac_entry_items.dc as dc');
					if($ledger_id !='ALL'){
						$this->db->where('ac_entry_items.ledger_id', $ledger_id);
					}
					$this->db->where('ac_chqprint.CRDATE >=', FYSTV);
					$this->db->where('ac_chqprint.CRDATE <=', FYENDV);
					$this->db->where('ac_chqprint.TRANS_TYPE !=', 'ONLINE');
					$this->db->where('ac_entry_items.dc', 'C');
					$this->db->from('ac_entries')->join('ac_entry_items','ac_entries.id=ac_entry_items.entry_id')->join('ac_ledgers','ac_entry_items.ledger_id=ac_ledgers.id')->join('ac_chqprint','ac_entries.id=ac_chqprint.PAYREFNO');
					$ac_ledgerst_q = $this->db->get();
			}
			else{
				$page_count = 0;
				$this->db->select('ac_ledgers.id as ac_ledgers_id,ac_ledgers.name as ac_ledgers_name ,ac_entries.id as entry_id,ac_entries.number,ac_entries.cr_total as ac_entries_cr_total,ac_entries.narration as ac_entries_narration,ac_chqprint.CRDATE as ac_chqprint_CRDATE,ac_chqprint.CHQNO as ac_chqprint_CHQNO,ac_chqprint.CHQNAME as ac_chqprint_CHQNAME,ac_entry_items.dc as dc');
					if($ledger_id !='ALL'){
						$this->db->where('ac_entry_items.ledger_id', $ledger_id);
					}
					$this->db->where('ac_chqprint.CRDATE >=', FYSTV);
					$this->db->where('ac_chqprint.CRDATE <=', FYENDV);
					$this->db->where('ac_chqprint.TRANS_TYPE !=', 'ONLINE');
					
					$this->db->where('ac_entry_items.dc', 'C');
					$this->db->from('ac_entries')->join('ac_entry_items','ac_entries.id=ac_entry_items.entry_id')->join('ac_ledgers','ac_entry_items.ledger_id=ac_ledgers.id')->join('ac_chqprint','ac_entries.id=ac_chqprint.PAYREFNO');
					$ac_ledgerst_q = $this->db->get();
			}

			echo '<div class="tableFixHead">';
			echo "<table id=\"chequetable\" class=\"table table-bordered table2excel\">";

			echo "<thead><tr><th>Date</th><th>Bank A/C NO</th><th>CHQ NO</th><th>Amount</th><th>Payee</th><th>Details/Description</th><th>GL Code(Account Name)</th></tr></thead>";
			
			$total = 0;
			foreach ($ac_ledgerst_q ->result() as $row) {

				$dt=$row->ac_chqprint_CRDATE;
				$date=date("Y-m-d",strtotime($dt));
				$total = $total+$row->ac_entries_cr_total;
				echo '<tr>';
					echo "<td>".$date;
					echo "</td>";
					echo "<td>".$row->ac_ledgers_name;
					echo "</td>";
					echo "<td>".$row->ac_chqprint_CHQNO;
					echo "</td>";
					echo "<td>".$row->ac_entries_cr_total;
					echo "</td>";
					echo "<td>".$row->ac_chqprint_CHQNAME;
					echo "</td>";
					echo "<td>".$row->ac_entries_narration;
					echo "</td>";

					echo "<td>".get_debit_account($row->entry_id,$row->number);
					echo "</td>";
				echo "</tr>";
			}
			echo '<tr><td colspan="3"><strong>Total</strong></td><td><strong>'.$total.'</strong></td><td colspan="3"></td></tr>';
			echo "</table>";
			echo "</div>";
		}
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