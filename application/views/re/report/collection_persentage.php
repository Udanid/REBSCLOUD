<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">

function load_printscrean1(branch,type,month)
{
	window.open( "<?=base_url()?>re/report_excel/get_collection_all/"+branch+'/'+type+'/'+month);

}

</script>


<script>

function get_loan_detalis(id)
{
	$('#popupform').delay(1).fadeIn(600);

	$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );

}
</script>


<script>
	$(document).ready(function(){
      $('#create_excel').click(function(){

           $(".table2excel").table2excel({
                exclude: ".noExl",
                name: "Loan Report",
                filename: "Loan_Reprot.xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });

      });
 });

</script>
<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
	</style>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
    <div class="form-title">

		  <h4>Loan Report
	        <span style="float:right"><? if($fromdate!='' & $todate!=''){ ?>
		        <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>

	       <? }?>
	       </span>
	       </h4>
	</div>

     <div class="table-responsive bs-example widget-shadow table table-bordered table2excel">
     <div class="tableFixHead">
      <table class="table table-bordered">
      <thead>
      	<tr class="success">
	      	<th >Product</th>
	      	<th >Project Name</th>
	      	<th>Lot Number</th>
	        <th>Bal B/F</th>
	      	<th>Curr Due</th>
	      	<th>Tat Collection</th>
	      	<th>Bal C/F</th>
	      	<th>Curr Collection</th>
	      	<th>%</th>
	      	<th>Deb Collection</th>
	      	<th>%</th>
        </tr>
       </thead>

       <tbody>

    <?

	if($prjlist){

		$totalbalanceBF=0;
		$totalcurrdeu=0;
		$tatalcollectio=0;
		$totalbalanceCF=0;
		$totalcurr_coll=0;
		$totaldebcoll=0;

		foreach($prjlist as $prjraw){

			?>

        <?  if($zepreservation[$prjraw->prj_id]){
			  foreach($zepreservation[$prjraw->prj_id] as $raw){
				$arrbefore=0;$balanceBF=0;$currdue=0;

				if($totalduearrears[$raw->loan_code]){
					$arrbefore=$totalduearrears[$raw->loan_code]->arriastot;
				}

				$prevcollection=0;

				if($prevpayment[$raw->loan_code]){
					$prevcollection=($prevpayment[$raw->loan_code]->sum_cap+$prevpayment[$raw->loan_code]->sum_int);
				}else{
					$prevcollection=0;
				}

				$balanceBF=$arrbefore-$prevcollection;

				if($totalcollection[$raw->loan_code]){
					$tot_collection = $totalcollection[$raw->loan_code]->sum_cap+$totalcollection[$raw->loan_code]->sum_int;
				}else{
					$tot_collection=0;
				}

				if($totaldue[$raw->loan_code]){
					$currdue = $totaldue[$raw->loan_code]->toteldue;
				}else{
					$currdue=0;
				}

				$balanceCF = $balanceBF+$currdue-$tot_collection;

				$deb_coll=0;

				$curr_coll=0;

				if($balanceBF>0){
					if($tot_collection>$balanceBF){
						$deb_coll=$balanceBF;
						$curr_coll=$tot_collection-$deb_coll;
					}
					else
					{
						$deb_coll=$tot_collection;
						$curr_coll=0;
					}

				}
				else{
					$curr_coll=$tot_collection ;
				}

				if($curr_coll && $currdue){
					$curr_coll_percentage=($curr_coll/$currdue)*100;
				}else{
					$curr_coll_percentage=0;
				}

				if($deb_coll){
					$deb_coll_percentage=($deb_coll/$balanceBF)*100;
				}else{
					$deb_coll_percentage=0;
				}
		?>
			<? if($raw->loan_status!="SETTLED"){?>
        <tr >
        	<td><a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?php echo $raw->unique_code; ?></a></td>
        	<td><?php echo $raw->project_name; ?></td>
        	<td><?php echo $raw->lot_number; ?></td>
        	<td><?php echo number_format($balanceBF,2) ?></td>
        	<td><?php echo number_format($currdue,2) ?></td>
        	<td><?php echo number_format($tot_collection,2) ?></td>
        	<td><?php echo number_format($balanceCF,2) ?></td>
        	<td><?php echo number_format($curr_coll,2) ?></td>
        	<td><?php echo number_format($curr_coll_percentage,2) ?>%</td>
        	<td><?php echo number_format($deb_coll,2) ?></td>
        	<td><?php echo number_format($deb_coll_percentage,2) ?>%</td>
        </tr>

        <?

        	$totalbalanceBF+=$balanceBF;
        	$totalcurrdeu+=$currdue;
        	$tatalcollectio+=$tot_collection;
        	$totalbalanceCF+=$balanceCF;
        	$totalcurr_coll+=$curr_coll;
        	$totaldebcoll+=$deb_coll;

				}elseif($fromdate < $last_paymentdate[$raw->loan_code]->income_date &&  $last_paymentdate[$raw->loan_code]->income_date< $todate){
					//if this loan settle but have last payment in data range.

?>
<tr >
	<td><a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?php echo $raw->unique_code; ?></a></td>
	<td><?php echo $raw->project_name; ?></td>
	<td><?php echo $raw->lot_number; ?></td>
	<td><?php echo number_format($balanceBF,2) ?></td>
	<td><?php echo number_format($currdue,2) ?></td>
	<td><?php echo number_format($tot_collection,2) ?></td>
	<td><?php echo number_format($balanceCF,2) ?></td>
	<td><?php echo number_format($curr_coll,2) ?></td>
	<td><?php echo number_format($curr_coll_percentage,2) ?>%</td>
	<td><?php echo number_format($deb_coll,2) ?></td>
	<td><?php echo number_format($deb_coll_percentage,2) ?>%</td>
</tr>
<?
					$totalbalanceBF+=$balanceBF;
					$totalcurrdeu+=$currdue;
					$tatalcollectio+=$tot_collection;
					$totalbalanceCF+=$balanceCF;
					$totalcurr_coll+=$curr_coll;
					$totaldebcoll+=$deb_coll;
				}
         }

    	}

    }

    }?>

        <tr  class="warning">
        	<td><b>Total</b></td>
        	<td></td>
        	<td></td>
        	<td><?php echo number_format($totalbalanceBF,2) ?></td>
        	<td><?php echo number_format($totalcurrdeu,2) ?></td>
        	<td><?php echo number_format($tatalcollectio,2) ?></td>
        	<td><?php echo number_format($totalbalanceCF,2) ?></td>
        	<td><?php echo number_format($totalcurr_coll,2) ?></td>
        	<td></td>
        	<td><?php echo number_format($totaldebcoll,2) ?></td>
        	<td></td>
        </tr>

        </tbody>
         </table>
         </div>
        </div>
    </div>

</div>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
	</script>
