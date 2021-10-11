
<style>


</style>

<?
$totalsales=$yearvalue[1]['epsales']+$yearvalue[2]['epsales']+$yearvalue[1]['outright']+$yearvalue[2]['outright'];
$totinterest=0;
$totlbliEP=0;
$totlbliBFI=0;

$totlbint=0;
$totbrint=0;
for($i=1; $i<=8; $i++)
{
$totinterest=$totinterest+$yearvalue[$i]['interesttot'];
$totlbliEP=$totlbliEP+$yearvalue[$i]['lbliEP'];
$totlbliBFI=$totlbliBFI+$yearvalue[$i]['lbliBFI'];
$totlbint=$totlbint+$yearvalue[$i]['lbliRED'];
$totbrint=$totbrint+$yearvalue[$i]['intexpBR'];


}
//intexpBR+lbliRED
//$yearvalue[1]['salestax']=0;

//WINROWS CHANGE REMOVE SALES TAX FROM PROJECT COST
//$projectcost=$totdpcost;;
$projectcost=$totdpcost-$costofcapital;
$totfinanceit=0; //$totbrint+$totlbint;
$avgpurchcost=($projectcost)/$details->selable_area;

$avgsellingprice=$saleprice/$details->selable_area;
$avagprofit=$avgsellingprice-$avgpurchcost;
$purchase_price=$details->purchase_price*$details->land_extend;
$market_price=$details->market_price*$details->selable_area;
//echo $purchase_price;
 ?>




<div class="row">
   <div class="col-md-6 validation-grids  widget-shadow" data-example-id="basic-forms">
		<div class="form-title">
			<h4 style="background-color:none;">Financial Results</h4>
		</div>
         <div class="table">
         <table class="table table-bordered" >
         <tr class="warning"><td colspan="3"><strong>Total OR Sales</strong></td></tr>
          <tr><td><strong>Year 1</strong></td><td align="right"><?=number_format($yearvalue[1]['outright'],2)?></td><td></td></tr>
          <tr><td><strong>Year 2</strong></td><td align="right"><?=number_format($yearvalue[2]['outright'],2)?></td>
          <td align="right"><?=number_format($yearvalue[1]['outright']+$yearvalue[2]['outright'],2)?></td></tr>
          <tr class="warning"><td colspan="3"><strong>Total EP Sales</strong></td></tr>
          <tr><td><strong>Year 1</strong></td><td align="right"><?=number_format($yearvalue[1]['epsales'],2)?></td><td></td></tr>
          <tr><td><strong>Year 2</strong></td><td align="right"><?=number_format($yearvalue[2]['epsales'],2)?></td>
          <td align="right"><?=number_format($yearvalue[1]['epsales']+$yearvalue[2]['epsales'],2)?></td></tr>

          <tr><td></td><td></td>
          <td align="right"><strong><?=number_format($totalsales,2)?></strong></td></tr>
          <tr><td colspan="4" height="50px;">&nbsp;</td></tr>
          <tr><td colspan="2"><strong>Average Selling Price/Perch</strong></td><td align="right"><?=number_format($avgsellingprice,2)?></td></tr>
          <tr><td colspan="2"><strong>Average Cost/Perch</strong></td><td align="right"><?=number_format($avgpurchcost,2)?></td></tr>
           <tr><td colspan="2"><strong>Average Profit /Perch</strong></td><td align="right"><?=number_format($avagprofit,2)?></td></tr>
         </table>

        </div>
    </div>
    <div class="col-md-8 validation-grids validation-grids-right widget-shadow" data-example-id="basic-forms">
		<div class="form-title">
			<h4 style="background-color:none;">Real Estate Investment</h4>
		</div>
        <div class="table">
        <table class="table table-bordered" >
       <? $discount=($totalsales*$details->prj_discount/100);?>
          <tr  class="active"><td ><strong>Total  Sales</strong></td><td></td><td align="right"><?=number_format($totalsales,2)?></td><td></td></tr>
            <tr  class="active"><td ><strong>Discount and Tax</strong></td><td></td><td align="right"><?=number_format($discount,2)?></td><td></td></tr>
            <tr  class="active"><td ><strong>Net Sale</strong></td><td></td><td align="right"><?=number_format($totalsales-$discount,2)?></td><td></td></tr>
          <tr><td colspan="4"><strong><u>Less</u></strong></td></td></tr>
        <?
		$projectcost=$totdpcost-$costofcapital;
		  $vat=($totalsales-$market_price)*get_rate('Vat')/100;
		$nbt=($totalsales-$market_price)*get_rate('NBT')/100;

		$projectcostfinance=$totdpcost-$costofcapital;
		$totcost_with_finance=$totdpcost;?>

          <tr><td>Project Cost</td><td></td><td align="right"><?=number_format($projectcost-$taxes,2)?></td></tr>
          <? if($taxes_list)
		  { foreach($taxes_list as $raw)
		  {?>
            <tr><td><?=$raw->subtask_name?></td><td></td><td align="right"><?=number_format($raw->budget,2)?></td></tr>
          <? }}?>
            <tr><td>Total Cost</td><td></td><td align="right"><?=number_format($projectcostfinance,2)?></td></tr>
          <tr><td><strong>RE Profit Before Finance Cost</strong></td><td></td>
          <? $profitbeforcost=$totalsales-$discount-$projectcostfinance?>
          <td align="right"><?=number_format($profitbeforcost,2)?></td><td></td></tr>
            <tr><td colspan="4"><strong><u>Less : Finance Cost</u></strong></td></td></tr>
          <tr><td>Cost Of capital</td><td align="right"><?=number_format($costofcapital,2)?></td><td></td><td></td></tr>

            <tr><td><strong>RE Profit After Finance Cost</strong></td><td></td><td></td><td align="right"><?=number_format($profitbeforcost-$costofcapital,2)?></td></tr>
            </table>

        </div>
        <div class="form-title">
				<h4 style="background-color:none;">Land EP Investment</h4>
		</div>
               <div class="table">
               <?
			 //  $totlpbeforfin=$profitbeforcost-$costofcapital;//echo $totcost_with_finance;
			   $totlpbeforfin=$profitbeforcost;
               $totlpfin=$totinterest-($totlbliEP+$totlbliBFI);
			   $totlpfinal= $totlpfin+$profitbeforcost-$costofcapital;
			 //  echo $totlpbeforfin;

			   ?>
        <table class="table table-bordered" >

          <tr  class="active"><td ><strong>Gross E/P Interest</strong></td><td></td><td align="right"><?=number_format($totinterest,2)?></td><td></td></tr>
          <tr><td colspan="4"><strong><u>Less</u></strong></td></td></tr>

          <tr><td colspan="2">Bank Loan Int. relevent to ep Inv.</td><td align="right"><?=number_format($totlbliEP,2)?></td></tr>
          <tr><td colspan="2">Branch Fund Int. relevent to ep Inv.</td><td align="right"><?=number_format($totlbliBFI,2)?></td><td></td></tr>
          <tr><td  colspan="2">Ep Interest Net Funding Cost </td><td align="right"><?=number_format($totlbliEP+$totlbliBFI,2)?></td>
          <td align="right"><?=number_format($totinterest-($totlbliEP+$totlbliBFI),2)?></td></tr>
             <tr class="active"><td colspan="2"><strong>Total Profit/Loss after Finance Cost</strong></td><td></td><td align="right"><?=number_format($totlpfinal,2)?></td></tr>
            </table>
            	              
        </div>

   </div>
 </div>
 <?
$beforfinance= $profitbeforcost;
 if($projectcost>0){
 	 $ovrprofoncost=(($beforfinance)/$projectcostfinance)*100;
 }
 else
	$ovrprofoncost=0;

 if($totalsales>0)
 $ovrprofonsale=(($beforfinance)/$totalsales)*100;

 else
 $ovrprofonsale=0;
 // echo $ovrprofoncost/$details->period*12;
 $monthOC=$ovrprofoncost/$details->period;
 $monthOS=$ovrprofonsale/$details->period;
 $annumOC= $monthOC*12;
  $annumOS= $monthOS*12;

$reprofitafterfin= $profitbeforcost-$costofcapital;
 if($projectcost>0){
	 $afterFINOC=($reprofitafterfin/($totcost_with_finance))*100;
 }
 else
	$afterFINOC=0;

	 if($totalsales>0)
 $afterFINOS=($reprofitafterfin/$totalsales)*100;

 else
 $afterFINOS=0;
  $monthFINOC=$afterFINOC/$details->period;
 $monthFINOS=$afterFINOS/$details->period;
 $annumFINOC= $monthFINOC*12;
  $annumFINOS= $monthFINOS*12;



  if($projectcost>0)
		  $REOverallOC=$beforfinance*100/$projectcost;
  else  $REOverallOC=0;
   if($totalsales>0)
   $REOverallOS=$beforfinance*100/$totalsales;
   else
   $REOverallOS=0;
   $REmonthOC=$REOverallOC/$details->period;
   $REmonthOS=$REOverallOS/$details->period;
   $REyearOC=$REmonthOC*12;
    $REyearOS=$REmonthOS*12;


	 if($projectcost>0)
		  $REAFOverallOC=$totlpbeforfin*100/$projectcost;
	 else  $REAFOverallOC=0;
	 if($totalsales>0)
		  $REAFOverallOS=$totlpbeforfin*100/$totalsales;
	 else  $REAFOverallOS=0;

   $REAFmonthOC=$REAFOverallOC/$details->period;
   $REAFmonthOS=$REAFOverallOS/$details->period;
   $REAFyearOC=$REAFmonthOC*12;
    $REAFyearOS=$REAFmonthOS*12;


 ?>
<div class="row">

  <div class="widget-shadow" data-example-id="basic-forms">
		<div class="form-title">
			<h4 style="background-color:none;">Return On Investment</h4>
		</div>
        <div class="table">
        <table class="table table-bordered" >
        <tr><td ></td><td >Per Month %</td><td >Per Annum %</td></tr>
         <tr><td>Before Fin. Cost</td>

          <td align="right"><?= number_format($monthOC,2)?></td></td>
           <td align="right"><?= number_format($annumOC,2)?></td></tr>
            <tr><td>After Fin. Cost</td>
          <td align="right"><?= number_format($monthFINOC,2)?></td>
           <td align="right"><?= number_format($annumFINOC,2)?></td></tr>

        </table>
        <div class="task-info">

        </div>

  </div>
 <?
 $OPinflowYT=NULL;
 $OPoutflowYT=NULL;
 ?>
 <div class="widget-shadow" data-example-id="basic-forms">
		<div class="form-title">
			<h4 style="background-color:none;">Cash Flow - Overall Project</h4>
		</div>
        <div class="table">
        <table class="table table-bordered" >
        <thead> <tr class="active"><td colspan="6"><strong>Receipits</strong></td></tr>
      <tr><th>Year</th><th>Out Right</th><th>E/P Down Payments</th><th>E/P Rentals</th><th>Loans</th><th>Total</th></tr></thead>
        <? $tot=0; $outot=0; $epdptot=0;$rentaltot=0; $fundtot=0; for($i=1; $i<=8; $i++){
			$outot=$outot+$yearvalue[$i]['outright'];
			$epdptot=$epdptot+$yearvalue[$i]['epdp'];
			$rentaltot=$rentaltot+$yearvalue[$i]['rentaltot'];
			$fundtot=$fundtot+$yearvalue[$i]['fundrecipt'];
			$OPinflowYT[$i]=$yearvalue[$i]['outright']+$yearvalue[$i]['epdp']+$yearvalue[$i]['rentaltot']+$yearvalue[$i]['fundrecipt'];
			?>
        <tr align="right">
        <td><?=$i?></td>
			<td ><?=number_format( $yearvalue[$i]['outright'],2)?></td>
            <td><?=number_format( $yearvalue[$i]['epdp'],2)?></td>
              <td><?=number_format( $yearvalue[$i]['rentaltot'],2)?></td>
               <td><?=number_format( $yearvalue[$i]['fundrecipt'],2)?></td>
                <td><?=number_format($OPinflowYT[$i],2)?></td></tr>
		<? }
		$OPinflowtot=$outot+$epdptot+$rentaltot+$fundtot;
		?>
        <tr class="info" align="right">
        <td>Total</td>
        <td><?=number_format( $outot,2)?></td>
            <td><?=number_format( $epdptot,2)?></td>
              <td><?=number_format( $rentaltot,2)?></td>
               <td><?=number_format( $fundtot,2)?></td>
                <td><?=number_format( $OPinflowtot,2)?></td>
        </tr>

        </table>
        <table class="table table-bordered" >
        <thead> <tr class="active"><td colspan="6"><strong>Payments</strong></td></tr>
      <tr><th>Year</th><th>Project Expences</th><th>Loan Repayment</th><th>L/B Loan Interest</th><th>Br Fund Interest</th><th>Total</th></tr></thead>
        <? $tot=0; $prjex=0; $outflowbloanset=0;$intexpLB=0; $lbliBFI=0; for($i=1; $i<=8; $i++){
			$prjex=$prjex+$yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax'];
			$outflowbloanset=$outflowbloanset+$yearvalue[$i]['outflowbloanset'];
			$intexpLB=$intexpLB+$yearvalue[$i]['intexpLB'];
			$lbliBFI=$lbliBFI+$yearvalue[$i]['lbliBFI'];
			$OPoutflowYT[$i]=$yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax']+$yearvalue[$i]['outflowbloanset']+$yearvalue[$i]['intexpLB']+$yearvalue[$i]['lbliBFI'];
			?>
        <tr align="right">
        <td><?=$i?></td>
			<td ><?=number_format( $yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax'],2)?></td>
            <td><?=number_format( $yearvalue[$i]['outflowbloanset'],2)?></td>
              <td><?=number_format( $yearvalue[$i]['intexpLB'],2)?></td>
               <td><?=number_format( $yearvalue[$i]['lbliBFI'],2)?></td>
                <td><?=number_format($OPoutflowYT[$i],2)?></td></tr>
		<? }
		$OPoutflowtot=$prjex+$outflowbloanset+$intexpLB+$lbliBFI;
		?>
        <tr class="info" align="right">
        <td>Total</td>
        <td><?=number_format( $prjex,2)?></td>
            <td><?=number_format( $outflowbloanset,2)?></td>
              <td><?=number_format( $intexpLB,2)?></td>
               <td><?=number_format( $lbliBFI,2)?></td>
                <td><?=number_format( $OPoutflowtot,2)?></td>
        </tr>

        </table>
          <table class="table table-bordered" >
        <thead> <tr class="active"><td colspan="6"><strong>Cash Flow Analysis</strong></td></tr>
      <tr><th>Year</th><th>Net Cash Flow</th><th>Disc Factor</th><th>Disc Cash Flow</th><th rowspan="10">Internal Rate Per Anum</th></tr></thead>
        <? $expectyeald=30; $tot=0; $disccash=0; $netflowtot=0;$discfacttot=0; $disccashtot=0; for($i=1; $i<=8; $i++){

			$netflow=$OPinflowYT[$i]-$OPoutflowYT[$i];
			$discfact=1/(pow((1+$expectyeald/100),$i));
			$disccash=$netflow*$discfact;
			$netflowtot=$netflowtot+$netflow;
			$discfacttot=$discfacttot+$discfact;
			$disccashtot=$disccashtot+$disccash;
			$OPanalysisYT[$i]=$netflowtot+$discfacttot+$disccashtot;
			?>
        <tr align="right">
        <td><?=$i?></td>
			<td ><?=number_format( $netflow,2)?></td>
            <td><?=number_format( $discfact,2)?></td>
              <td><?=number_format($disccash,2)?></td>
                </tr>
		<? }
		$OPanalysistot=$netflowtot+$discfacttot+$disccashtot;
		?>
        <tr class="info" align="right">
        <td>Total</td>
        <td><?=number_format( $netflowtot,2)?></td>
            <td><?=number_format( $discfacttot,2)?></td>
              <td><?=number_format( $disccashtot,2)?></td>
              </td>

        </tr>

        </table>


  </div>

 </div>




  <div class="widget-shadow" data-example-id="basic-forms">
		<div class="form-title">
			<h4 style="background-color:none;">Cash Flow - Real Estate Project</h4>
		</div>
        <div class="table">
        <table class="table table-bordered" >
        <thead> <tr class="active"><td colspan="6"><strong>Receipits</strong></td></tr>
      <tr><th>Year</th><th>Out Right</th><th>E/P Down Payments</th><th>E/P Stock Depletion</th><th>Loans</th><th>Total</th></tr></thead>
        <? $tot=0; $outot=0; $epdptot=0;$rentaltot=0; $fundtot=0; for($i=1; $i<=8; $i++){
			$outot=$outot+$yearvalue[$i]['outright'];
			$epdptot=$epdptot+$yearvalue[$i]['epdp'];
			$rentaltot=$rentaltot+$yearvalue[$i]['epsdeple'];
			$fundtot=$fundtot+$yearvalue[$i]['fundrecipt'];
			$REinflowYT[$i]=$yearvalue[$i]['outright']+$yearvalue[$i]['epdp']+$yearvalue[$i]['epsdeple']+$yearvalue[$i]['fundrecipt'];
			?>
        <tr align="right">
        <td><?=$i?></td>
			<td ><?=number_format( $yearvalue[$i]['outright'],2)?></td>
            <td><?=number_format( $yearvalue[$i]['epdp'],2)?></td>
              <td><?=number_format( $yearvalue[$i]['epsdeple'],2)?></td>
               <td><?=number_format( $yearvalue[$i]['fundrecipt'],2)?></td>
                <td><?=number_format($REinflowYT[$i],2)?></td></tr>
		<? }
		$REinflowtot=$outot+$epdptot+$rentaltot+$fundtot;
		?>
        <tr class="info" align="right">
        <td>Total</td>
        <td><?=number_format( $outot,2)?></td>
            <td><?=number_format( $epdptot,2)?></td>
              <td><?=number_format( $rentaltot,2)?></td>
               <td><?=number_format( $fundtot,2)?></td>
                <td><?=number_format( $REinflowtot,2)?></td>
        </tr>

        </table>
        <table class="table table-bordered" >
        <thead> <tr class="active"><td colspan="6"><strong>Payments</strong></td></tr>
      <tr><th>Year</th><th>Project Expences</th><th>Loan Repayment</th><th>L/B Loan Interest</th><th>Br Fund Interest</th><th>Total</th></tr></thead>
        <? $tot=0; $prjex=0; $outflowbloanset=0;$intexpLB=0; $lbliBFI=0; for($i=1; $i<=8; $i++){
			$prjex=$prjex+$yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax'];
			$outflowbloanset=$outflowbloanset+$yearvalue[$i]['outflowbloanset'];
			$intexpLB=$intexpLB+$yearvalue[$i]['lbliRED'];
			$lbliBFI=$lbliBFI+0;
			$REoutflowYT[$i]=$yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax']+$yearvalue[$i]['outflowbloanset']+$yearvalue[$i]['lbliRED']+0;
			?>
        <tr align="right">
        <td><?=$i?></td>
			<td ><?=number_format( $yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax'],2)?></td>
            <td><?=number_format( $yearvalue[$i]['outflowbloanset'],2)?></td>
              <td><?=number_format( $yearvalue[$i]['lbliRED'],2)?></td>
               <td><?=number_format( 0,2)?></td>
                <td><?=number_format($REoutflowYT[$i],2)?></td></tr>
		<? }
		$REoutflowtot=$prjex+$outflowbloanset+$intexpLB+$lbliBFI;
		?>
        <tr class="info" align="right">
        <td>Total</td>
        <td><?=number_format( $prjex,2)?></td>
            <td><?=number_format( $outflowbloanset,2)?></td>
              <td><?=number_format( $intexpLB,2)?></td>
               <td><?=number_format( $lbliBFI,2)?></td>
                <td><?=number_format( $REoutflowtot,2)?></td>
        </tr>

        </table>
          <table class="table table-bordered" >
        <thead> <tr class="active"><td colspan="6"><strong>Cash Flow Analysis</strong></td></tr>
      <tr><th>Year</th><th>Net Cash flow</th><th>Disc Factor</th><th>Disc Cash Flow</th><th rowspan="10">Internal Rate Per Anum</th></tr></thead>
        <? $expectyeald=30; $tot=0; $disccash=0; $netflowtot=0;$discfacttot=0; $disccashtot=0; for($i=1; $i<=8; $i++){

			$netflow=$REinflowYT[$i]-$REoutflowYT[$i];
			$discfact=1/(pow((1+$expectyeald/100),$i));
			$disccash=$netflow*$discfact;
			$netflowtot=$netflowtot+$netflow;
			$discfacttot=$discfacttot+$discfact;
			$disccashtot=$disccashtot+$disccash;
			$REanalysisYT[$i]=$netflowtot+$discfacttot+$disccashtot;
			?>
        <tr align="right">
        <td><?=$i?></td>
			<td ><?=number_format( $netflow,2)?></td>
            <td><?=number_format( $discfact,2)?></td>
              <td><?=number_format($disccash,2)?></td>
                </tr>
		<? }
		$REanalysistot=$netflowtot+$discfacttot+$disccashtot;
		?>
        <tr class="info" align="right">
        <td>Total</td>
        <td><?=number_format( $netflowtot,2)?></td>
            <td><?=number_format( $discfacttot,2)?></td>
              <td><?=number_format( $disccashtot,2)?></td>
              </td>

        </tr>

        </table>


  </div>

 </div>


  <div class="widget-shadow" data-example-id="basic-forms">
		<div class="form-title">
			<h4 style="background-color:none;">Irr Computation</h4>
		</div>
        <div class="table">

          <table class="table table-bordered" >
        <thead> <tr class="active"><td colspan="6"><strong>Cash Flow Analysis overall Project</strong></td></tr>
      <tr><th>Year</th><th>Net Cash flow</th><th>Disc Factor</th><th>Disc Cash Flow</th><th>Internal Rate Per Anum
       echo

      </th></tr></thead>
        <? $expectyeald=794.50; $tot=0; $disccash=0; $netflowtot=0;$discfacttot=0; $disccashtot=0;
		 for($i=1; $i<=8; $i++){
			/*$outot=$outot+$yearvalue[$i]['outright'];
			$epdptot=$epdptot+$yearvalue[$i]['epdp'];
			$rentaltot=$rentaltot+$yearvalue[$i]['rentaltot'];
			$fundtot=$fundtot+$yearvalue[$i]['fundrecipt'];*/
			/*
			$prjex=$prjex+$yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax'];
			$outflowbloanset=$outflowbloanset+$yearvalue[$i]['outflowbloanset'];
			$intexpLB=$intexpLB+$yearvalue[$i]['intexpLB'];
			$lbliBFI=$lbliBFI+$yearvalue[$i]['lbliBFI'];*/
			$netflow=($yearvalue[$i]['outright']+$yearvalue[$i]['epdp']+$yearvalue[$i]['rentaltot'])-($yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax']+$yearvalue[$i]['intexpLB']+$yearvalue[$i]['lbliBFI']);
			$discfact=1/(pow((1+$expectyeald/100),$i));
			$disccash=$netflow*$discfact;
			$netflowtot=$netflowtot+$netflow;
			$discfacttot=$discfacttot+$discfact;
			$disccashtot=$disccashtot+$disccash;

			$OPIRR[$i]=$netflow;
			?>
        <tr align="right">
        <td><?=$i?></td>
			<td ><?=number_format( $netflow,2)?></td>
            <td><?=number_format( $discfact,2)?></td>
              <td><?=number_format($disccash,2)?></td>

                </tr>
		<? }
		$REanalysistot=$netflowtot+$discfacttot+$disccashtot;
		?>
        <tr class="info" align="right">
        <td>Total</td>
        <td><?=number_format( $netflowtot,2)?></td>
            <td><?=number_format( $discfacttot,2)?></td>
              <td><?=number_format( $disccashtot,2)?></td>
                <td rowspan="10"><?  echo IRR(array($OPIRR[1],$OPIRR[2],$OPIRR[3],$OPIRR[4],$OPIRR[5],$OPIRR[6],$OPIRR[7],$OPIRR[8]),0.18)*100;?></td>
              </td>

        </tr>

        </table>
          <table class="table table-bordered" >
        <thead> <tr class="active"><td colspan="6"><strong>Cash Flow Analysis Real Estate Project (Ignore Banking Transaction)</strong></td></tr>
      <tr><th>Year</th><th>Net Cash flow</th><th>Disc Factor</th><th>Disc Cash Flow</th><th>Internal IRR Per Anum


      </th></tr></thead>
        <? $expectyeald=1087.35; $tot=0; $disccash=0; $netflowtot=0;$discfacttot=0; $disccashtot=0;
		 for($i=1; $i<=8; $i++){
			/*$outot=$outot+$yearvalue[$i]['outright'];
			$epdptot=$epdptot+$yearvalue[$i]['epdp'];
			$rentaltot=$rentaltot+$yearvalue[$i]['epsdeple'];
			$fundtot=$fundtot+$yearvalue[$i]['fundrecipt'];*/
			/*
			$prjex=$prjex+$yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax'];
			$outflowbloanset=$outflowbloanset+$yearvalue[$i]['outflowbloanset'];
			$intexpLB=$intexpLB+$yearvalue[$i]['lbliRED'];
			$lbliBFI=$lbliBFI+0;*/
			$netflow=($yearvalue[$i]['outright']+$yearvalue[$i]['epdp']+$yearvalue[$i]['epsdeple'])-($yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax']+$yearvalue[$i]['lbliRED']+0);
			$discfact=1/(pow((1+$expectyeald/100),$i));
			$disccash=$netflow*$discfact;
			$netflowtot=$netflowtot+$netflow;
			$discfacttot=$discfacttot+$discfact;
			$disccashtot=$disccashtot+$disccash;

			$REIRR[$i]=$netflow;
			?>
        <tr align="right">
        <td><?=$i?></td>
			<td ><?=number_format( $netflow,2)?></td>
            <td><?=number_format( $discfact,2)?></td>
              <td><?=number_format($disccash,2)?></td>

                </tr>
		<? }
		$REanalysistot=$netflowtot+$discfacttot+$disccashtot;
		$REIRRC=array($REIRR[1],$REIRR[2],$REIRR[3],$REIRR[4],$REIRR[5],$REIRR[6],$REIRR[7],$REIRR[8]);
		?>
        <tr class="info" align="right">
        <td>Total</td>
        <td><?=number_format( $netflowtot,2)?></td>
            <td><?=number_format( $discfacttot,2)?></td>
              <td><?=number_format( $disccashtot,2)?></td>
                <td rowspan="10"><strong><?=number_format(IRR($REIRRC,0.18)*100,2);?></strong></td>
              </td>

        </tr>

        </table>


  </div>

 </div>















 </div>
