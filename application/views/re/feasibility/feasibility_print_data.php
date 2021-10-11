<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Print - Entry Number</title>
    <?php echo link_tag(asset_url() . 'images/favicon.ico', 'shortcut icon', 'image/ico'); ?>
    <link type="text/css" rel="stylesheet" href="<?php echo asset_url(); ?>css/printentry.css">
</head>
<script>
    function printfunction()
    {
     	window.print() ;
		setTimeout(function(){
      		window.close();
		},100);
    }
</script>
<style>
body{ font-family:Verdana, Geneva, sans-serif; font-size:11px;}
</style>

<body onload="printfunction()">
<?php 
	$totalsales=$yearvalue[1]['epsales']+$yearvalue[2]['epsales']+$yearvalue[1]['outright']+$yearvalue[2]['outright'];
    $perchase_price = $details->land_extend * $details->purchase_price ;
    $stamp_rate = get_rate('Stamp Fee')/100;
    $stamp_fees = ($perchase_price * $stamp_rate) -1000;

    $introducer_commission_rate = get_rate('Introducer  Commission')/100;
    $introducer_commission_value = $perchase_price * $introducer_commission_rate;

    $projectcost=$totdpcost-$costofcapital;
    $totfinanceit=0; //$totbrint+$totlbint;
    $avgpurchcost=($projectcost)/$details->selable_area;

    $avgsellingprice=$saleprice/$details->selable_area;
    $avagprofit=$avgsellingprice-$avgpurchcost;
    $purchase_price=$details->purchase_price*$details->land_extend;
    $market_price=$details->market_price*$details->selable_area;
	$projectprice = 0;
	
	$x = 'A';
	
?>
    <div id="page-wrapper">
        <div align="center" style="border:1px solid #000; padding:5px; font-weight:bold;">Feasibility Summary Report</div>
        <div class="main-page">
            <div class="table">
                <div class="widget-shadow">
                    <div id="myTabContent" class="tab-content scrollbar1" style="padding: 5px; overflow: hidden; outline: currentcolor none medium;" tabindex="5000">
                        <div role="tabpanel" class="tab-pane fade  active in " id="profile" aria-labelledby="profile-tab">
                        	 <br />
                            <table width="400" border="0" cellspacing="0" cellpadding="0" style="line-height:20px;">
                              <tr>
                                <td><strong>Name Of Projet :</strong></td>
                                <td><strong><?php echo($details->project_name);?></strong></td>
                              </tr>
                              <tr>
                                <td><strong>Date :</strong></td>
                                <td><strong><?php echo($details->date_purchase);?></strong></td>
                              </tr>
                            </table>
              
                            <br />
                            <div class=" widget-shadow bs-example" data-example-id="contextual-table">
                            <table class="table table-bordered" width="100%" border="1" cellpadding="0" cellspacing="0">
						    <thead>
							<tr>
								<th colspan="2"></th>
								<th width="20%" style="text-align:center;">Amount Rs.</th>
							</tr>
						</thead>
                        <?php 
                        $count=1;
                        $taskid=""; 
                        $nettotal=0;

                        if($tasklist)
                        {
                            foreach($tasklist as $raw1) {
                                    $taskid=$taskid.$raw1->task_id.',';
                            }
                            
                            foreach($tasklist as $raw) {
								if($maintaskdata[$raw->task_id]['maintask'])
                                {
                                    $tasktot=$maintaskdata[$raw->task_id]['maintask']->budget;
                                }
								else
                                    $tasktot=0;
                                    $nettotal=$nettotal+$tasktot;
									$subidlist="";
						?>
                        <? if($maintaskdata[$raw->task_id]['prjsubtask'])
                        {
							$mylist=NULL; $count=0;
							foreach($maintaskdata[$raw->task_id]['prjsubtask'] as $subraw)
							{ 
                                $mylist[$count]=$subraw->subtask_id; 
                                $subidlist=$subidlist.$subraw->subtask_id.",";
						
                            $count++; 
                        }
                                   foreach($maintaskdata[$raw->task_id]['subtask'] as $myraw)
                                   {
                                        if(!in_array($myraw->subtask_id,$mylist))
                                        { 
                                             $subidlist=$subidlist.$myraw->subtask_id.",";
                                   
                                        }
                                    }

								   } else { $maintot_val=0;if($maintaskdata[$raw->task_id]['subtask']){

                                       foreach($maintaskdata[$raw->task_id]['subtask'] as $myraw)
                                       {
                                           $subidlist=$subidlist.$myraw->subtask_id.",";
									
                                }
                            }
                        }
                        $count++;

						?>
						<tr class="info">
							<td align="center" width="5%">  
                                <?
								echo '<b>'.$x.'</b>';
								$x++;
								?> 
                            </td>
							<td style="padding-left:10px;"> 
                                <?=$raw->task_name?>
							
							<?
                                     if($tasktot==0){
										$tasktot=$maintot_val;
										
									}

									//if($raw->task_id==15 || $raw->task_id==14)
									//$tasktot=0;
									?>
							    <td style="padding-right:10px;" align="right">                                
                                    <?=number_format($tasktot,2)?>          							
							    </td>
						</tr>

						<?
								    }


								    } ?>
						<tr class="active" style="font-weight:bold;"> 
                        	<td align="center" width="5%"><?
								echo '<b>'.$x.'</b>';
								$x++;
								?> </td>
							<td style="padding-left:10px;">Total </td>
							<td style="padding-right:10px;"  class="form-control" align="right">
                                <?=number_format($nettotal,2)?> 
                            </td>
						</tr>
                    </table>
                    
                    <table class="table table-bordered" style="margin-top:5px;" width="100%" border="1" cellpadding="0" cellspacing="0">
                    	<tr class="active" >
                        	<td align="center" width="5%"><?
								echo '<b>'.$x.'</b>';
								$x++;
								?> </td>
							<td style="padding-left:10px;">Cost Per Perch </td>
							<td style="padding-right:10px;"  width="20%" class="form-control" align="right">
                               <?=number_format($avgpurchcost,2)?>
                            </td>
						</tr>
                    </table>
                    
                    <table class="table table-bordered" width="100%" style="margin-top:5px;"  border="1" cellpadding="0" cellspacing="0">
                    	<tr class="active" style="font-weight:bold;" >
                        	<td align="center" width="5%"><?
								echo '<b>'.$x.'</b>';
								$a = $x;
								$x++;
								?> </td>
							<td style="padding-left:10px;">Average Selling / Gross Sale (<?=number_format($avgsellingprice,2)?> X <?=$details->selable_area?>P) </td>
							<td style="padding-right:10px;"  width="20%" class="form-control" align="right">
                               <?=number_format($avgsellingprice*$details->selable_area,2)?>
                            </td>
						</tr>
                    </table>
					
                    <table class="table table-bordered" width="100%" style="margin-top:5px;"  border="1" cellpadding="0" cellspacing="0">
                    	<tr class="active" >
                        	<td align="center" width="5%"><?
								echo '<b>'.$x.'</b>';
								$b = $x;
								$x++;
								?> </td>
							<td style="padding-left:10px;">Discount + (2.5) </td>
							<td style="padding-right:10px;"  width="20%" class="form-control" align="right">
                               <? $discount=($totalsales*$details->prj_discount/100);;
							   	echo number_format($discount,2);
							   ?>
                            </td>
						</tr>
                    </table>
 					
                    <table class="table table-bordered" width="100%" style="margin-top:5px;"  border="1" cellpadding="0" cellspacing="0">
                    	<tr class="active" style="font-weight:bold;" >
                        	<td align="center" width="5%"><?
								echo '<b>'.$x.'</b>';
								$x++;
								?> </td>
							<td style="padding-left:10px;">Net Sale (<?=$a?>-<?=$b?>) </td>
							<td style="padding-right:10px;"  width="20%" class="form-control" align="right">
                               <?
                               $net_sale = ($avgsellingprice*$details->selable_area)-$discount;
							   echo number_format($net_sale,2)?>
                            </td>
						</tr>
                    </table>
					
                    <table class="table table-bordered" width="100%" style="margin-top:5px;"  border="1" cellpadding="0" cellspacing="0">
                    	<tr class="active" style="font-weight:bold;" >
                        	<td align="center" width="5%"><?
								echo '<b>'.$x.'</b>';
								$x++;
								?> </td>
							<td style="padding-left:10px;">Total Cost </td>
							<td style="padding-right:10px;"  width="20%" class="form-control" align="right">
                               <?=number_format($nettotal,2)?>
                            </td>
						</tr>
                    </table>
                    
                    <table class="table table-bordered" width="100%" style="margin-top:5px;"  border="1" cellpadding="0" cellspacing="0">
                    	<tr class="active" style="font-weight:bold;" >
                        	<td align="center" width="5%"><?
								echo '<b>'.$x.'</b>';
								$x++;
								?> </td>
							<td style="padding-left:10px;">Net Income</td>
							<td style="padding-right:10px;"  width="20%" class="form-control" align="right">
                               <?=number_format($net_sale-$nettotal,2)?>
                            </td>
						</tr>
                    </table>
					
                    <table class="table table-bordered" width="100%" style="margin-top:5px;"  border="1" cellpadding="0" cellspacing="0">
                    	<tr class="active" style="font-weight:bold;" >
                        	<td align="center" width="5%"><?
								echo '<b>'.$x.'</b>';
								$x++;
								?> </td>
							<td style="padding-left:10px;">ROI</td>
							<td style="padding-right:10px;"  width="20%" class="form-control" align="right">
                               <?=number_format((($net_sale-$nettotal)/$nettotal)*100,0)?>%
                            </td>
						</tr>
                    </table>
                    <br />
                   
                     <br />
						<div align="center">
                         <table class="table table-bordered">
    
                            <tr><td colspan="2">Total Extent:</td><td width="200"align="right"><?=@$details->land_extend?>P</td></tr>
                            <tr><td colspan="2">Road Ways:</td><td align="right"><?=@$details->road_ways?>P</td></tr>
                            <tr><td colspan="2">Other Reservations:</td><td align="right"><?=@$details->other_res?>P</td></tr>
                            <tr><td colspan="2">Open Space:</td><td align="right"><?=@$details->open_space?>P</td></tr>
                            <tr><td colspan="2">Unsalable Area:</td><td align="right"><?=@$details->unselable_area?>P</td></tr>
                            <tr><td colspan="2">Salable Area:</td><td align="right"><?=@$details->selable_area?>P</td></tr>
                        </table>
						</div>
                        <br /><br /><br />
                        <table class="table table-bordered">
                        	<tr>
                            	<td align="center"><strong>.........................................<br />Branch Manager</strong></td>
                                <td width="250"></td>
                                <td align="center"><strong>.........................................<br />Snr.AGM(Branch & Opper.)</strong></td>
                            </tr>
                        </table>
                        <br /><br /> <br /><br />
                        <table class="table table-bordered">
                        	<tr>
                            	<td align="center"><strong>.........................................<br />Finance Manager</strong></td>
                                <td width="250"></td>
                                <td align="center"><strong>.........................................<br />Managing Director</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="clearfix"> </div>
                    <br />

                    </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>