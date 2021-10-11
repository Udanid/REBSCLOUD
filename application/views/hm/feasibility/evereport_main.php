<script type="text/javascript">

function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
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
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
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
</script>
<script type="text/javascript">

function load_printscrean1(id)
{
			window.open( "<?=base_url()?>hm/feasibility/print_report/"+id);

}
</script>
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
$totalunitboq = $totalunitboq->totalconstruction;
$yearvalue[1]['salestax']=$yearvalue[1]['salestax'];
$projectcost=$totdpcost-$costofcapital+$totalunitboq;
//WINROWS CHANGE REMOVE SALES TAX FROM PROJECT COST
//$projectcost=$totdpcost;;

$totfinanceit=0;//$totbrint+$totlbint;
$avgpurchcost=0;//($projectcost)/$details->selable_area;

$avgsellingprice=0;//$saleprice/$details->selable_area;
$avagprofit=$avgsellingprice-$avgpurchcost;
$purchase_price=$details->purchase_price*$details->land_extend;
$market_price=$details->market_price*$details->selable_area;


$vat=($totalsales-$market_price)*0.15;
$nbt=($totalsales-$market_price)*0.02;
		$projectcostfinance=$totdpcost-$marketing_commision-$costofcapital+$vat+$yearvalue[1]['salestax']+$nbt+$totalunitboq;
		$totcost_with_finance=$totdpcost-$marketing_commision+$vat+$yearvalue[1]['salestax']+$nbt+$totalunitboq;
		$profitbeforcost=$totalsales-$projectcostfinance;
 ?>
 <?  //echo $totcost_with_finance;
			   $totlpbeforfin=$profitbeforcost;
               $totlpfinal= $totlpbeforfin;

			   ?>
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
 <?
 $OPinflowYT=NULL;
 $OPoutflowYT=NULL;
 ?>

        <? $OPtot=0;
		 $REtot=0;$expectyeald=30;
		 for($i=1; $i<=8; $i++){

			$OPinflowYT[$i]=$yearvalue[$i]['outright']+$yearvalue[$i]['epdp']+$yearvalue[$i]['rentaltot']+$yearvalue[$i]['fundrecipt'];
			$OPoutflowYT[$i]=$yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax']+$yearvalue[$i]['outflowbloanset']+$yearvalue[$i]['intexpLB']+$yearvalue[$i]['lbliBFI'];
			$netflow=$OPinflowYT[$i]-$OPoutflowYT[$i];
			$discfact=1/(pow((1+$expectyeald/100),$i));
			$disccash=$netflow*$discfact;
			$OPanalysisYT[$i]=$netflow;
			$OPtot=$OPtot+$OPanalysisYT[$i];

			$REinflowYT[$i]=$yearvalue[$i]['outright']+$yearvalue[$i]['epdp']+$yearvalue[$i]['epsdeple']+$yearvalue[$i]['fundrecipt'];
			$REoutflowYT[$i]=$yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax']+$yearvalue[$i]['outflowbloanset']+$yearvalue[$i]['lbliRED']+0;
			$netflow=$REinflowYT[$i]-$REoutflowYT[$i];
			$discfact=1/(pow((1+$expectyeald/100),$i));
			$disccash=$netflow*$discfact;
			$REanalysisYT[$i]=$netflow;
			$REtot=$REanalysisYT[$i]+$REtot;
			$OPIRR[$i]=($yearvalue[$i]['outright']+$yearvalue[$i]['epdp']+$yearvalue[$i]['rentaltot'])-($yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax']+$yearvalue[$i]['intexpLB']+$yearvalue[$i]['lbliBFI']);
			$REIRR[$i]=($yearvalue[$i]['outright']+$yearvalue[$i]['epdp']+$yearvalue[$i]['epsdeple'])-($yearvalue[$i]['outflowprjx']+$yearvalue[$i]['outflowsalestax']+$yearvalue[$i]['lbliRED']+0);
		 }
		$OPIRRC=array($OPIRR[1],$OPIRR[2],$OPIRR[3],$OPIRR[4],$OPIRR[5],$OPIRR[6],$OPIRR[7],$OPIRR[8]);
       $REIRRC=array($REIRR[1],$REIRR[2],$REIRR[3],$REIRR[4],$REIRR[5],$REIRR[6],$REIRR[7],$REIRR[8]);
	?>
    <div style="float:right"> <? if($details->status=='PENDING'){?>
   <h2 >
   <a href="<?=base_url()?>hm/feasibility/checked/<?=$details->prj_id?>"><span class="label label-info">Checked</span></a>
						<a href="javascript:call_confirm('<?=$details->prj_id?>')"><span class="label label-success">Confirm</span></a>
							<a href="javascript:call_delete('<?=$details->prj_id?>')"><span class="label label-danger">Delete</span></a>
					</h2> <? }?>
                    </div>
                     <div class="clearfix"> </div>
<div class="row">
   <div class="col-md-12   widget-shadow" data-example-id="basic-forms">
		<div class="form-title">
			<h4 style="background-color:none;">Overall Project
            </h4>
		</div>
        <div class="form-body">
<?
$newprofitbf=$profitbeforcost/$totalsales*100;
$newprofitaf=($profitbeforcost-$costofcapital)/$totalsales*100;

 if($newprofitbf>=60) $class='green'; else if($newprofitbf<60 && $newprofitbf>=50)  $class='blue'; else if($newprofitbf<50 && $newprofitbf>=25)  $class='yellow'; else $class='red';?>

        						<div class="task-info">
									<span class="task-desc">Before Fin. Cost</span><span class="percentage"><?=number_format($newprofitbf,2)?>%</span>
 									   <div class="clearfix"></div>
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$newprofitbf?>%;"></div>
									</div>
                                    <? if($newprofitaf>=60) $class='green'; else if($newprofitaf<60 && $newprofitaf>=50)  $class='blue'; else if($newprofitaf<50 && $newprofitaf>=25)  $class='yellow'; else $class='red';?>

        						<div class="task-info">
									<span class="task-desc">After Fin. Cost</span><span class="percentage"><?= number_format($newprofitaf,2)?>%</span>
 									   <div class="clearfix"></div>
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$newprofitaf?>%;"></div>
									</div>

           </div>

    </div>

 </div>

	<div class="row">

  <div class="widget-shadow" data-example-id="basic-forms">

        <div class="form-body">


           <table class="table " >

           <tr class="success" ><td><strong>Total Cost  &nbsp;&nbsp; <?=number_format($projectcostfinance,2)?></strong></td><td colspan="3" align="right"><strong>Total Sales &nbsp;&nbsp;  <?=number_format($totalsales,2)?></strong></td></tr>
           <tr  class="active"><td colspan="6"><strong><u>Profitability</u></strong></td></tr>
            <tr><td> Profit Before Finance Cost</td><td align="right"><?=number_format($profitbeforcost,2)?></td><td align="right"></td></tr>
             <tr ><td>Total Profit/Loss after Finance Cost</td><td align="right"><?=number_format($profitbeforcost-$costofcapital,2)?></td></tr>
             <? if($ovrprofoncost<=80){?>
              <tr  class="active"><td colspan="6"><strong><u>IRR</u></strong></td></tr>
               <tr><td>Real Estate Project</td><td align="right"><?=IRR($REIRRC,0.18)*100;?></td><td align="right"></td><td></td></tr>
             <tr ><td>Overall Project</td><td align="right"><?=IRR($OPIRRC,0.18)*100;?></td><td align="right"></td><td></td></tr><? }?>
            </table>

		</div>
        </div>
      </div>



<div class="row">

  <div class="widget-shadow" data-example-id="basic-forms">
		<div class="form-title">
			<h4 style="background-color:none;">Return On Investment</h4>
		</div>
        <div class="table">
        <table class="table table-bordered" >
        <tr class="info"><td ></td><td >Per Month %</td><td >Per Annum %</td></tr>
          <tr><td>Before Fin. Cost</td>

          <td align="right"><?= number_format($monthOC,2)?></td></td>
           <td align="right"><?= number_format($annumOC,2)?></td></tr>
            <tr><td>After Fin. Cost</td>
          <td align="right"><?= number_format($monthFINOC,2)?></td>
           <td align="right"><?= number_format($annumFINOC,2)?></td></tr>

        </table>
        </div>

  </div>


 </div>

               <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
									</div>
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>
    <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this <?=$details->project_name?> Project" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>hm/feasibility/delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

              $("#complexConfirm_confirm").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this <?=$details->project_name?> Project ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>hm/feasibility/confirm/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            </script>
