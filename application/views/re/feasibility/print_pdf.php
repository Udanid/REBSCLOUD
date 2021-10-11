<html xmlns:o='urn:schemas-microsoft-com:office:office'
     xmlns:w='urn:schemas-microsoft-com:office:word'
     xmlns='http://www.w3.org/TR/REC-html40'>
     <head>
     <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>90</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
        </w:WordDocument>
    </xml>
    <link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
    <style type="text/css">
    .table{

      font-size: 10.0pt;
      font-family: "Times New Roman";
      padding: 0px !important;

    }
    .signs , .signs th, .signs td {
    	border: 0 !important;
    }
    .bordercls{
      border: 1px solid black;
      border-collapse: collapse;
    }
    body{
      /*margin-top: 0;*/
    }
    tr , td, th{
      line-height: 1.02857143 !important;
      /*padding: 0px !important;*/
      text-align: bottom !important;
      font-size: 10.0pt !important;
      font-family: "Times New Roman";

    }
    .datatable td,.datatable th{
      padding: 3px;
      padding-left: 8px;
      font-family: "Times New Roman";
    }
    .centervalue{
      text-align: center;
    }


    </style>
    <script type="text/javascript">

    function print_function()
    {
    	//window.print();
    	//window.close();
    }

    </script>
  </head>
<?
header("Content-Type: application/vnd.ms-word");
header("Expires: 0");
header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
header("Content-disposition: attachment; filename=ProjectReport.doc");
////////////////////////////////////first page//////////////////////////////
foreach($branchlist as $row){
if($row->branch_code==$details->branch_code){ $branch=$row->branch_name; }
}
$b='<body><table class="datatable" width="100%"><tbody><tr><th width="50%" class="leftmagin">FEASEBILITY REPORT ON</th>
<th width="2%">&nbsp;:&nbsp;&nbsp;</th><td colspan="3"> '.$details->project_name.'</td></tr>
  <tr><th class="leftmagin">BRANCH / DIVISION </th><th>&nbsp;:&nbsp;&nbsp;</th><td colspan="3"> '.$branch.'</td></tr>
                <tr><th class="leftmagin">DATE</th><th>&nbsp;:&nbsp;&nbsp;</th><td colspan="3"> '.date('d/m/Y').'</td></tr>';
$b=$b.'<tr><th colspan="5" class="leftmagin"><p style="height:30px;">&nbsp;</p>';
$b=$b.'<tr><th colspan="5" class="leftmagin"><h4><b><u>Genaral Information</u></b></h4></th></tr>';
$b=$b.'<tr><td colspan="5">01)&nbsp; Details of Owner </td></tr>';
$b=$b.'<tr><td class="leftmagin">a) Name of Owner </td><th>&nbsp;:&nbsp;&nbsp;</th>
<td class="bordercls" colspan="3">'.$details->owner_name.'</td></tr>';
$b=$b.'<tr><td class="leftmagin">b) Address</td><th>&nbsp;:&nbsp;&nbsp;</th>
<td class="bordercls" colspan="3">'.$printlnddata->address1.' '.$printlnddata->address1.','.$printlnddata->address3.'</td></tr>';
$b=$b.'<tr><td class="leftmagin">c) Tele No </td><th>&nbsp;:&nbsp;&nbsp;</th>
<td class="bordercls" colspan="3"></td></tr>';

$b=$b.'<tr><td>02)&nbsp; Mode of Purchases </td><th>&nbsp;:&nbsp;&nbsp;</th><th colspan="3"></th></tr>';
$b=$b.'<tr><td class="leftmagin">a)  </td><th></th>
<td class="bordercls" width="16%">Direct</td><td class="bordercls" width="16%"></td><td width="16%"></td></tr>';
$b=$b.'<tr><td class="leftmagin"></td><th></th>
<td class="bordercls" >Introduced</td><td class="bordercls" ></td><td></td></tr>';
$b=$b.'<tr><td class="leftmagin" colspan="5">b) if the land is introduced, Details Of the introducer. </td></tr>
<tr><td class="leftmagin">&nbsp;&nbsp;&nbsp;&nbsp;I) Name</td><th>&nbsp;:&nbsp;&nbsp;</th>
<td class="bordercls" colspan="3">'.$printitndata->first_name.' '.$printitndata->last_name.'</td></tr>';
$b=$b.'<tr><td class="leftmagin">&nbsp;&nbsp;&nbsp;&nbsp;II) Address</td><th>&nbsp;:&nbsp;&nbsp;</th>
<td class="bordercls" colspan="3">'.$printitndata->address1.','.$printitndata->address1.' ,'.$printitndata->address3.'</td></tr>';
$b=$b.'<tr><td class="leftmagin">&nbsp;&nbsp;&nbsp;&nbsp;III) Tele No</td><th>&nbsp;:&nbsp;&nbsp;</th>
<td class="bordercls" colspan="3">'.$printitndata->landphone.'</td></tr>';
$b=$b.'<tr><td class="leftmagin">c) Owner`s Expected Price </td><th>&nbsp;:&nbsp;&nbsp;</th><td colspan="2" >Rs.'.number_format($details->expect_price*$details->land_extend,2).' &nbsp;&nbsp;</td><td>Per Perch </td></tr>';
$b=$b.'<tr><td class="leftmagin">d) Mode of Payment </td><th>&nbsp;:&nbsp;&nbsp;</th><td colspan="2" class="bordercls">Agreement to sell&nbsp;&nbsp;</td><td>Out right </td></tr>';


$b=$b.'<tr><td colspan="5">03)&nbsp; Details Of Land</td></tr>';
$arc=floor($details->land_extend / 160);
$arcprc=$arc*160;
$rds=floor(($details->land_extend-$arcprc)/40);
$rdsprch=$rds*40;
$balprc=$details->land_extend-($arcprc+$rdsprch);
$b=$b.'<tr><td class="leftmagin">a)  Extent</td><th>&nbsp;:&nbsp;&nbsp;</th>
<td class="bordercls">Acs</td><td class="bordercls">Rds</td><td class="bordercls">Pcs</td></tr>';
$b=$b.'<tr><td class="leftmagin"></td><th></th>
<td class="bordercls" ></td>'.$arc.'<td class="bordercls" >'.$rds.'</td><td class="bordercls" >'.$balprc.'</td></tr>';
$b=$b.'<tr><th colspan="3" class="leftmagin"><p style="height:30px;">&nbsp;</p>';
$b=$b.'<tr><td class="leftmagin">b) Negotiated Per Purch </td><th>&nbsp;:&nbsp;&nbsp;</th><td colspan="3" class="bordercls">Rs.&nbsp;&nbsp;'.$details->purchase_price.'</td></tr>';
$b=$b.'<tr><th colspan="3" class="leftmagin"><p style="height:30px;">&nbsp;</p>';
$b=$b.'<tr><td class="leftmagin">c) Total Extent(Perches) </td><th>&nbsp;:&nbsp;&nbsp;</th><td class="bordercls">Pc.&nbsp;&nbsp;'.$details->land_extend.'</td><td></td><td></td></tr>';
$b=$b.'<tr><td class="leftmagin">d) Extent road reservation</td><th>&nbsp;:&nbsp;&nbsp;</th><td class="bordercls">Pc.&nbsp;&nbsp;'.$details->road_ways.'</td><td></td><td></td></tr>';
$b=$b.'<tr><td class="leftmagin">e) Other Reservation</td><th>&nbsp;:&nbsp;&nbsp;</th><td class="bordercls">Pc.&nbsp;&nbsp;'.$details->other_res.'</td><td></td><td></td></tr>';
$b=$b.'<tr><td class="leftmagin">f) Extent open space reservation</td><th>&nbsp;:&nbsp;&nbsp;</th><td class="bordercls">Pc.&nbsp;&nbsp;'.$details->open_space.'</td><td></td><td></td></tr>';
$b=$b.'<tr><td class="leftmagin">j) Total reservation </td><th>&nbsp;:&nbsp;&nbsp;</th><td class="bordercls">Pc.&nbsp;&nbsp;'.$details->unselable_area.'</td><td></td><td></td></tr>';
$b=$b.'<tr><td class="leftmagin">k) Saleable Area</td><th>&nbsp;:&nbsp;&nbsp;</th><td class="bordercls">Pc.&nbsp;&nbsp;'.$details->selable_area.'</td><td></td><td></td></tr>';

$b=$b.'<tr><th colspan="3" class="leftmagin"><p style="height:30px;">&nbsp;</p>';
$b=$b.'<tr><td >04)&nbsp; Inventory of Valuable items</td><th>&nbsp;:&nbsp;&nbsp;</th><th colspan="3"></th></tr>';
$b=$b.'<tr><th><center>Item</center></th><th></th><th class="bordercls"><center>QTY</center></th><th class="bordercls"><center>VALUE</center></th><th class="bordercls"><center>RS.</center></th></tr>';
$count=0;
$alphas = range('a', 'z');
$val=0;
 if($valuse_items){
foreach($valuse_items as $raw) {
$val=$val+$raw->value;
$b=$b.'<tr> <td colspan="2">'.$alphas[$count].')'.$raw->name.'</td>
   <td class="bordercls">'.$raw->quontity.'</td>
    <td class="bordercls" align="right">'.number_format($raw->value/$raw->quontity,2).'</td>
     <td class="bordercls" align="right">'.number_format($raw->value,2).'</td></tr>';
    $count++; }}
    $b=$b.'<tr><th><center>Total</center></th><th></th><th class="bordercls"><center></center></th><th class="bordercls"><center></center></th><th class="bordercls"><center>'.number_format($val,2).'</center></th></tr>';


$b=$b.'<tr><th colspan="3" class="leftmagin"><p style="height:30px;">&nbsp;</p>';
$b=$b.'</tbody></table>';
//$b=$b.'<p style="page-break-before: always">&nbsp;</p>';




////////////////////////////////////////////////////////////////////
$projectprice=$details->purchase_price*$details->land_extend;
$b=$b.'<body><table class="table" ><tbody><tr><th width="40%" style="vertical-align: text-top;">FEASEBILITY REPORT ON</th>
<th><table >
							  <tr><th>Project</th><th>&nbsp;:&nbsp;&nbsp;</th><th> '.$details->project_name.'</th></tr>
                <tr><th>Extent</th><th>&nbsp;:&nbsp;&nbsp;</th><th> '.$details->land_extend.'</th></tr>
                <tr><th>Salable Area</th><th>&nbsp;:&nbsp;&nbsp;</th><th> '.$details->selable_area.'</th></tr>
							</table></th></tr></tbody></table>';
$b=$b.'<b><u>Project Cost Estimates</u></b></br>';
$b=$b.'<table class="datatable" width="100%">';


$cost_of_purchase=0;
$com_legak_and_survay=0;
$development=0;
$selling=0;
$financing=0;
$rows_i=0;
if($tasklist)
{
	$b=$b.'<tr bgcolor="#bbd8f9"><th align="left"><u>Purchases Consideration</u></th></tr>';
  $b=$b.'<tr><th></th><th >Rate</th><th >Cost Rs</th><th >Cumulative</th><th >Cost / Pc</th></tr>';
	$i=0;
	foreach ($maintaskdata[1]['prjsubtask'] as $subtask) {
		$i++;
    $rows_i++;

		$b=$b.'<tr ><td align="left">'.$i.". ".$subtask->subtask_name.'</td>';
		if($i=='1')
		{
			$b=$b.'<td align="right" class="bordercls">'.number_format($subtask->budget/$details->selable_area,2).'</td>';
		}else{
			$b=$b.'<td class="bordercls"></td>';
		}
		$b=$b.'<td align="right" class="bordercls">'.number_format($subtask->budget,2).'</td>
    <td class="bordercls"></td>
    <td class="bordercls"></td>
    </tr>';
    if($subtask->subtask_name=="Purchase Price")
    {
      $cost_of_purchase_val=$subtask->budget;
    }

	}
	$cost_of_purchase=$cost_of_purchase+$maintaskdata[1]['maintask']->budget;

	//$i=0;

	foreach ($maintaskdata[2]['prjsubtask'] as $subtask) {
		$i++;
    $rows_i++;
    $rate="";
    if($subtask->subtask_name=='Stamp Fees')
    {
      $rate=get_rate('Stamp Fee')."%";
    }
    if($subtask->subtask_name=='Legal Fees')
    {
      $rate="&nbsp;&nbsp;&nbsp;".get_rate('Legal Fee')."%";
    }
		$b=$b.'<tr><td>'.$i.". ".$subtask->subtask_name.''.$rate.'</td><td class="bordercls"></td><td align="right" class="bordercls">'.number_format($subtask->budget,2).'</td><td class="bordercls"></td><td class="bordercls"></td></tr>';
	}
	$b=$b.'<tr><td><b>Sub Total</b></td><td class="bordercls"></td><td align="right" class="bordercls">'.number_format($maintaskdata[2]['maintask']->budget+$cost_of_purchase,2).'</td><td align="right" class="bordercls">'.number_format($maintaskdata[2]['maintask']->budget+$cost_of_purchase,2).'</td><td align="right" class="bordercls">'.number_format(($maintaskdata[2]['maintask']->budget+$cost_of_purchase)/$details->selable_area,2).'</td></tr>';

	//$b=$b.'<tr><th colspan="5">Purchases Consideration</th></tr>';
	$com_legak_and_survay=$maintaskdata[2]['maintask']->budget;
	$tasktot=0;
	$per_cost=0;
	$per_cost=$cost_of_purchase+$com_legak_and_survay;
	foreach ($tasklist as $key => $value) {
		if($maintaskdata[$value->task_id]['maintask'])
		{
			$tasktot=$maintaskdata[$value->task_id]['maintask']->budget;


		}
		else
		$tasktot=0;
		if($value->task_id!=1 && $value->task_id!=2){
      $development=$development+$maintaskdata[$value->task_id]['maintask']->budget;
      $rows_i=$rows_i+1;
			$per_cost=$per_cost+$tasktot;
      $sub_taskarray_count=count($maintaskdata[$value->task_id]['prjsubtask']);
      $new_page_count=$rows_i+$sub_taskarray_count;
      if($new_page_count>=26)
      {
        $rows_i=0;
        $b=$b.'<p style="page-break-before: always">&nbsp;</p>';
      }

			$b=$b.'<tr ><th align="left" bgcolor="#bbd8f9"><u>'.$value->task_name.'</u></th></tr>';
			if($maintaskdata[$value->task_id]['prjsubtask']){
				$i=0;
				foreach ($maintaskdata[$value->task_id]['prjsubtask'] as $subtask) {
					$i++;
          $rows_i++;
					$b=$b.'<tr><td>'.$i.". ".$subtask->subtask_name.'</td><td class="bordercls"></td><td align="right" class="bordercls">'.number_format($subtask->budget,2).'</td><td class="bordercls"></td><td class="bordercls"></td></tr>';
					// code...
				}
				$b=$b.'<tr><td><b>Sub Total</b></td><td class="bordercls"></td><td align="right" class="bordercls">'.number_format($tasktot,2).'</td><td align="right" class="bordercls">'.number_format($per_cost,2).'</td><td align="right" class="bordercls">'.number_format($per_cost/$details->selable_area,2).'</td></tr>';

			}else{
        $b=$b.'<tr><td><b>Sub Total</b></td><td class="bordercls"></td><td align="right" class="bordercls">'.number_format($maintaskdata[$value->task_id]['maintask']->budget,2).'</td><td align="right" class="bordercls">'.number_format($per_cost,2).'</td><td align="right" class="bordercls">'.number_format($per_cost/$details->selable_area,2).'</td></tr>';

      }

		}
	}


}
$projectcost=$totdpcost-$costofcapital;
$total=$per_cost;
$margin_15=$total*get_rate('Financial Cost')/100;
$margin_40=($total+$margin_15)*get_rate('profit margin')/100;
$margin_15_val=$total+$margin_15;
$margin_40_val=$total+$margin_15+$margin_40;
$b=$b.'<tr></tr>';
$b=$b.'<tr><td bgcolor="#bbd8f9">Financial Cost</td><td class="bordercls"></td><td align="right" class="bordercls">'.number_format($margin_15,2).'</td><td class="bordercls">'.number_format($margin_15_val,2).'</td><td class="bordercls">'.number_format($margin_15_val/$details->selable_area,2).'</td></tr>';
$b=$b.'<tr></tr>';
$b=$b.'<tr><td bgcolor="#bbd8f9">30 % Profit Margin</td><td class="bordercls"></td><td align="right" class="bordercls">'.number_format($margin_40,2).'</td><td class="bordercls">'.number_format($margin_40_val,2).'</td><td class="bordercls">'.number_format(($margin_40_val)/$details->selable_area,2).'</td></tr>';

$b=$b.'</table></div>';
$b=$b.'<p style="page-break-before: always">&nbsp;</p>';
$b=$b.'<h5><u>Sales Report</u></h5>';
$b=$b.'<div class="row"><table class="table" >';


$b=$b.'<tr><td>1) Project  Name</td><td class="bordercls" colspan="4">'.$details->project_name.'</td></tr>';
$b=$b.'<tr><td><p style="height:30px;">&nbsp;</p><td></tr>';
$b=$b.'<tr><td>2) Loction</td><td class="bordercls" colspan="4">'.$printlnddata->address1.','.$printlnddata->address2.','.$printlnddata->address3.'</td></tr>';
$b=$b.'<tr><td><p style="height:30px;">&nbsp;</p><td></tr>';
$b=$b.'<tr><td>3) Property</td><td class="bordercls">100</td><td class="bordercls">Commercial</td><td class="bordercls">Residential</td><td class="bordercls">Total</td><td></td></tr>';
$b=$b.'<tr><td></td><td class="bordercls">%</td><td class="bordercls"></td><td class="bordercls">80%</td><td class="bordercls"></td></tr>';
$b=$b.'<tr><td><p style="height:30px;">&nbsp;</p><td></tr>';
$b=$b.'<tr><td>4) Extent</td><td class="bordercls"></td><td class="bordercls">Recservations</td><td class="bordercls">Saleable</td><td class="bordercls">Total</td></tr>';
$b=$b.'<tr><td></td><td class="bordercls">Psc</td><td class="bordercls">'.$details->unselable_area.'</td><td class="bordercls">'.$details->selable_area.'</td><td class="bordercls">'.$details->land_extend.'</td></tr>';
$b=$b.'<tr><td><p style="height:30px;">&nbsp;</p><td></tr>';
$b=$b.'<tr><td>5) Date of Purchase </td><td class="bordercls">'.$details->date_purchase.'</td><td class="bordercls">Dev . Monts</td><td class="bordercls">Total</td><td class="bordercls">Pro Month</td></tr>';
$datetime1 = date_create($details->date_prjcommence);
$datetime2 = date_create($details->date_dvpcompletion);
$interval = date_diff($datetime1, $datetime2);
$dpmonths= $interval->format('%m')+1;
$datetime1 = date_create($details->date_dvpcompletion);
$datetime2 = date_create($details->date_prjcompletion);
$interval = date_diff($datetime1, $datetime2);
$salemonths= $details->period-$dpmonths;
$tot_month=$dpmonths+$salemonths;
$b=$b.'<tr><td> Selling Starts on</td><td class="bordercls">'.$details->date_slscommence.'</td><td class="bordercls">'.$dpmonths.'</td><td class="bordercls">'.$tot_month.'</td><td class="bordercls">'.$salemonths.'</td></tr>';

$b=$b.'</table></br></br></div><p style="height:30px;">&nbsp;</p>';

$b=$b.'<div class="row"><table class="table" >';
$b=$b.'<tr><td>6) Costing</td><td></td><td></td></tr>';


$b=$b.'<tr><td >Item </td><td><center>Total</center></td><td>Per Perch</td></tr>';
$sale_total=$cost_of_purchase_val+$com_legak_and_survay+$development+$margin_40+$margin_15;
$b=$b.'<tr><td>Cost of Purchase</td><td class="bordercls" align="right">'.number_format($cost_of_purchase_val,2).'</td><td  class="bordercls" align="right">'.number_format($cost_of_purchase_val/$details->selable_area,2).'</td></tr>';
$b=$b.'<tr><td>Com ,Legal & Surver chgs</td><td  class="bordercls" align="right">'.number_format($com_legak_and_survay,2).'</td><td  class="bordercls" align="right">'.number_format($com_legak_and_survay/$details->selable_area,2).'</td></tr>';
$b=$b.'<tr><td>Development </td><td  class="bordercls" align="right">'.number_format($development,2).'</td><td class="bordercls" align="right">'.number_format($development/$details->selable_area,2).'</td></tr>';
$b=$b.'<tr><td>Selling</td><td  class="bordercls" align="right">'.number_format($margin_40,2).'</td><td class="bordercls" align="right">'.number_format($margin_40/$details->selable_area,2).'</td></tr>';
$b=$b.'<tr><td>Financing</td><td  class="bordercls" align="right">'.number_format($margin_15,2).'</td><td class="bordercls" align="right">'.number_format($margin_15/$details->selable_area,2).'</td></tr>';
$b=$b.'<tr><td>Total</td><td  class="bordercls" align="right">'.number_format($sale_total,2).'</td><td class="bordercls" align="right">'.number_format($sale_total/$details->selable_area,2).'</td></tr>';

$b=$b.'</table></br></br></div><p style="height:30px;">&nbsp;</p>';

$b=$b.'<div class="row"><table width="100%" class="datatable">';

$b=$b.'<tr><td >7)Pricing</td><td class="bordercls">Extent Pchs</td><td class="bordercls">Total Extent</td><td class="bordercls">Per Pchs Price</td> <td class="bordercls">Sale Value</td></tr>';
$count=1; $tot=0; if($perch_price){
foreach($perch_price as $raw) {
$tot=$tot+$raw->perches_count*$raw->price;

$b=$b.'<tr> <td></td>
<td class="bordercls">'.$raw->perches_count.'</td>
<td class="bordercls"></td>
 <td class="bordercls">'.number_format($raw->price).'</td>
	<td align="right" class="bordercls">'.number_format($raw->perches_count*$raw->price,2).'</td></tr>';
	$count++; }

 }
 $avg_profit_per_perch=($tot/$details->selable_area)-($projectcost/$details->selable_area);
$b=$b.'<tr><td >Total</td><td class="bordercls">'.$details->selable_area.'</td><td class="bordercls"></td><td class="bordercls"></td><td align="right" class="bordercls">'.number_format($tot,2).'</td> </tr>';
$b=$b.'<tr><td >Average Seling Price/Perch</td><td></td> <td></td><td></td><td align="right" class="bordercls">'.number_format($tot/$details->selable_area,2).'</td></tr>';
$b=$b.'<tr><td >Average Profit/Perch</td><td></td><td></td><td></td><td align="right" class="bordercls">'.number_format($avg_profit_per_perch,2).'</td></tr>';


$b=$b.'</table></div>';
$b=$b.'<p style="page-break-before: always">&nbsp;</p>';


$b=$b.'<div class="row"><table class="table" border="1" >';

$b=$b.'<tr><td colspan="3">8)Reduction of Profit margin if not sold within the Project Period</td></tr>';
$b=$b.'<tr><td>Delay in Proj.  Month</td><td>Loss Per Pchse</td><td>Cuttent Profit / Pch</td></tr>';
$b=$b.'<tr><td></td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr>';
$b=$b.'<tr><td></td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr>';
$b=$b.'<tr><td></td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr>';
$b=$b.'<tr><td></td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr>';
$b=$b.'<tr><td></td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr>';
$b=$b.'<tr><td></td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr>';
$b=$b.'<tr><td></td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr>';
$b=$b.'<tr><td></td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr>';
$b=$b.'<tr><td></td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr>';
$b=$b.'<tr><td></td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr>';
$b=$b.'</table></br></br></div><p style="height:30px;">&nbsp;</p>';



$b=$b.'<div class="row"><table class="datatable" width="50%">';

$b=$b.'<tr><td >9) Marketing Date</td><td></td></tr>';
$b=$b.'<tr><td>Expecting Sales Mix  (%)</td><td></td></tr>';
$b=$b.'<tr><td>Ouright  Sales</td><td class="bordercls">'.$details->outright.'</td></tr>';
$b=$b.'<tr><td>Easy Peyment Sales</td><td class="bordercls">'.$details->epsales.'</td></tr>';

$b=$b.'</table></br></br></div><p style="height:30px;">&nbsp;</p>';
$b=$b.'Easy Payment Sales Distrbution';
$b=$b.'<table class="table" border="1" width="100%">';

$b=$b.'<tr><td rowspan="2" width="25%">D / P</td>
<td rowspan="2" width="25%">Total Sales %</td>
<td colspan="2" width="50%">E / P  Contrcts </td></tr>';
$b=$b.'<tr><td width="25%">%</td><td width="25%">Period</td></tr>';
$b=$b.'<tr><td colspan="2">';
$b=$b.'<table class="table" border="1" >';
$epchart_rows=count($epchart);
$count=1; $tot='';if($dplist){
foreach($dplist as $raw) {
if($dpdata[$raw->dp_id])
$value=$dpdata[$raw->dp_id]->percentage;
else
$value=0;
$tot=$tot+$value;

$b=$b.'<tr><td>'.$raw->dp_rate.'</td><td class="centervalue">'.$value.'</td></tr>';
$count++; }



}
if($epchart_rows>$count){
  for($c=0;$epchart_rows>=$count;$c++)
  {
    $count++;
    $b=$b.'<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
  }
}


$b=$b.'</table></td><td colspan="2"><table class="table" border="1">';

$count=1; $tot='0';if($epchart){
foreach($epchart as $raw) {

$tot=$tot+$raw->percentage;

$b=$b.'<tr><td width="50%" class="centervalue">'.$raw->percentage.'</td><td class="centervalue">'.$raw->timerange.'M</td></tr>';
$count++; }


}

$b=$b.'</table></td><tr>';
$b=$b.'<tr><td >Total</td><td>'.$tot.'</td><td ></td><td></td></tr>';
$b=$b.'</table></br></br></div><p style="height:30px;">&nbsp;</p>';
$b=$b.'<p style="page-break-before: always">&nbsp;</p>';
$b=$b.'<h5>Sales Span</h5>';
$b=$b.'<div class="row"><table class="table" border="1" width="80%">';


$b=$b.'<tr><td colspan="2">';
$b=$b.'<table class="table"  border="1" width="100%"> <thead>

			<tr  > <th colspan="2"> year 01</th> </tr><tr><th >Month</th> <th >Sales %</th></tr>
				</thead>';
			$tot=0; for($i=1; $i<=12; $i++){
if($salestime[$i])
$val=$salestime[$i]->percentage;
else
$val=0;
$tot=$tot+$val;
		$b=$b.'  <tr>
			<td >&nbsp;&nbsp;&nbsp;M'.str_pad($i, 2, "0", STR_PAD_LEFT).'</td>
			 <td class="centervalue">
			'.$val.'</td></tr>';
			 }

$b=$b.'<tr><td>Total</td><td>'.$tot.'</td></tr>';





$b=$b.' </table></td><td colspan="2">
				<table class="table" border="1" width="100%"> <thead><tr> <th colspan="2"> year 02</th> </tr><tr> <th >Month</th> <th > Sales %</th></tr></thead>';
		$tot=0;	for($i=13; $i<=24; $i++){
if($salestime[$i])
$val=$salestime[$i]->percentage;
else
$val=0;
$tot=$tot+$val;
		 $b=$b.' <tr><td>&nbsp;&nbsp;&nbsp;M'.str_pad($i, 2, "0", STR_PAD_LEFT).'</td><td class="centervalue">'.$val.'</td></tr>';
			 }
$b=$b.'<tr><td>Total</td><td>'.$tot.'</td></tr>';

		 $b=$b.'  </table>';

$b=$b.'</table></br></br></div><p style="height:30px;">&nbsp;</p>';
$b=$b.'<p style="page-break-before: always">&nbsp;</p>';

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
$avgpurchcost=($projectcost)/$details->selable_area;

$avgsellingprice=$saleprice/$details->selable_area;
$avagprofit=$avgsellingprice-$avgpurchcost;
$purchase_price=$details->purchase_price*$details->land_extend;
$market_price=$details->market_price*$details->selable_area;

$vat=($totalsales-$market_price)*0.15;
$nbt=($totalsales-$market_price)*0.02;
$projectcostfinance=$totdpcost-$marketing_commision-$costofcapital+$vat+$yearvalue[1]['salestax']+$nbt;;
$totcost_with_finance=$totdpcost-$marketing_commision+$vat+$yearvalue[1]['salestax']+$nbt;
	 $profitbeforcost=$totalsales-$projectcostfinance;

 $newprofitbf_persentage=$profitbeforcost/$totalsales*100;
$newprofitaf_persentage=($profitbeforcost-$costofcapital)/$totalsales*100;
$totlpbeforfin=$profitbeforcost;
		$totlpfin=$totinterest-($totlbliEP+$totlbliBFI);
$totlpfinal= $totlpfin+$totlpbeforfin;
$b=$b.'<h5>Financial Report</h5>';
$b=$b.'<table class="datatable" width="80%" >
							  <tr bgcolor=""><th colspan="3" align="center" >Financial Result</th></tr>
         <tr class="warning"><td colspan="3"><strong>Total OR Sales</strong></td></tr>
          <tr><td><strong>Year 1</strong></td><td align="right" class="bordercls">'.number_format($yearvalue[1]['outright'],2).'</td><td class="bordercls"></td></tr>
          <tr><td><strong>Year 2</strong></td><td align="right" class="bordercls">'.number_format($yearvalue[2]['outright'],2).'</td>
          <td align="right" class="bordercls">'.number_format($yearvalue[1]['outright']+$yearvalue[2]['outright'],2).'</td></tr>
          <tr class="warning"><td colspan="3"><strong>Total Ep Sales</strong></td></tr>
          <tr><td><strong>Year 1</strong></td><td align="right" class="bordercls">'.number_format($yearvalue[1]['epsales'],2).'</td><td class="bordercls"></td></tr>
          <tr><td><strong>Year 2</strong></td><td align="right" class="bordercls">'.number_format($yearvalue[2]['epsales'],2).'</td>
          <td align="right" class="bordercls">'.number_format($yearvalue[1]['epsales']+$yearvalue[2]['epsales'],2).'</td></tr>';
$b=$b.'<tr><td>Total Sales</td><td colspan="2" class="bordercls">'.number_format($totalsales,2).'</td></tr>';
$b=$b.'<tr><td>Less</td><td></td><td></td></tr>';
$b=$b.'<tr><td>Project Cost</td><td align="right" class="bordercls" colspan="2">'.number_format($projectcost,2).'</td></tr>';
$b=$b.'<tr><td>Profit Before Fin Cost</td><td align="right" class="bordercls" colspan="2">'.number_format($profitbeforcost,2).'</td></tr>';

$b=$b.'<tr><td>Finacial Costs</td><td align="right" class="bordercls" colspan="2">'.number_format($projectcostfinance,2).'</td></tr>';
$b=$b.'<tr><td>Intrust</td><td></td><td></td></tr>';
$b=$b.'<tr><td>Intrust</td><td></td><td></td></tr>';
$b=$b.'<tr><td>Profit After Fin Cost</td><td align="right" class="bordercls" colspan="2">'.number_format($profitbeforcost-$costofcapital,2).'</td></tr>';
$b=$b.'</table></br></br><p style="height:30px;">&nbsp;</p>';

$b=$b.'<div class="row"></br></br><table class="table"  >';
$beforfinance=$profitbeforcost;
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
	$aftermonthOC=(($reprofitafterfin/($totcost_with_finance))/$details->period)*100;
}
else{
	$afterFINOC=0;
	$aftermonthOC=0;
}

	if($totalsales>0){
		$afterFINOS=($reprofitafterfin/$totalsales)*100;
		$aftermonthOS=(($reprofitafterfin/$totalsales)/$details->period)*100;
	}else{
		$afterFINOS=0;
		$aftermonthOS=0;
	}

$b=$b.'<tr bgcolor="#CCCCCC"><td colspan="2">Return On Investment</td></tr>';
$b=$b.'<tr><td></td><td colspan="2"><center>Oreall  %</center></td><td colspan="2"><center>  Per Month %</center></td></tr>';
$b=$b.'<tr><td></td><td class="bordercls"><center>On Cost</center></td><td class="bordercls"><center>On sales</center></td>
<td class="bordercls"><center>On cost</center></td><td class="bordercls"><center>On sales</center></td></tr>';
$b=$b.'<tr><td>Before Fin  Costs</td><td align="right" class="bordercls">'.number_format($annumOC,2).'</td><td align="right" class="bordercls">'.number_format($annumOS,2).'</td><td align="right" class="bordercls">'.number_format($monthOC,2).'</td><td align="right" class="bordercls">'.number_format($monthOS,2).'</td></tr>';
$b=$b.'<tr><td>After Fin Costs</td><td align="right" class="bordercls">'.number_format($afterFINOC,2).'</td><td align="right" class="bordercls">'.number_format($afterFINOS,2).'</td><td align="right" class="bordercls">'.number_format($aftermonthOC,2).'</td><td align="right" class="bordercls">'.number_format($aftermonthOS,2).'</td></tr>';



$year1outright=array();
$year1dp=array();
$year1sum=array();
$year1ep = array();
$epdp_tot=0;
$ep_sale=0;
$ep_rental=0;
$ep_investment=0;
$ep_interest=0;
if($namelist){
for($t=0; $t<count($namelist);$t++){
$key=$namelist[$t]['thiskey'];
if($key=='infloworsales'){
	$count=1;

$rawtot=0; for($j=1; $j<=8; $j++) {

 $year1outright[$j]=$yearvalue[$j][$key];
$rawtot =$rawtot+ $yearvalue[$j][$key]; }
}
if($key=='inflowepdp'){
	$count=1;

$rawtot=0; for($j=1; $j<=8; $j++) {

 $year1dp[$j]=$yearvalue[$j][$key];
$rawtot =$rawtot+ $yearvalue[$j][$key];
$epdp_tot=$epdp_tot+$yearvalue[$j][$key];

}
}

if($key=='inflowrental'){
	$count=1;

$rawtot=0; for($j=1; $j<=8; $j++) {

 $year1ep[$j]=$yearvalue[$j][$key];
$rawtot =$rawtot+ $yearvalue[$j][$key];
$ep_rental=$ep_rental+$yearvalue[$j][$key]; }
}
if($key=='epsales'){
$rawtot=0; for($j=1; $j<=8; $j++) {

$ep_sale=$ep_sale+$yearvalue[$j][$key]; }
}
if($key=='epsinv'){
$rawtot=0; for($j=1; $j<=8; $j++) {

$ep_investment=$ep_investment+$yearvalue[$j][$key]; }
}
if($key=='interesttot'){
$rawtot=0; for($j=1; $j<=8; $j++) {

$ep_interest=$ep_interest+$yearvalue[$j][$key]; }
}


}}


$b=$b.'<tr><td class="bordercls">E / P  Sales</td><td align="right" class="bordercls">'.number_format($ep_sale,2).'</td><td class="bordercls">E / P Invest</td><td align="right" class="bordercls">'.number_format($ep_investment,2).'</td><td class="bordercls">Tot .Rentals</td></tr>';
$b=$b.'<tr><td class="bordercls">E / P   D / Payt</td><td align="right" class="bordercls">'.number_format($epdp_tot,2).'</td><td class="bordercls">Tot . Interest</td><td align="right" class="bordercls">'.number_format($ep_interest,2).'</td><td align="right" class="bordercls">'.number_format($ep_rental,2).'</td></tr>';

$b=$b.'</table></br></br></div><p style="height:30px;">&nbsp;</p>';
$b=$b.'<p style="page-break-before: always">&nbsp;</p>';

$b=$b.'<h5>Income</h5>';
$b=$b.'<div class="row"><table class="datatable" border="1" width="100%">';

$b=$b.'<tr><td>Year</td><td>Real Est Inc</td><td>E/P Income</td></tr>';

//
$outright_tot=0;
$ep_tot=0;
for($j=1; $j<=8; $j++) {
	$year1sum[$j]=$year1outright[$j]+$year1dp[$j];
	$outright_tot=$outright_tot+$year1sum[$j];
	$ep_tot=$ep_tot+$year1ep[$j];
  $b=$b.'<tr><td>Year 0'.$j.'</td><td align="right">'.number_format($year1sum[$j],2).'</td><td align="right">'.number_format($year1ep[$j],2).'</td></tr>';

}

 $b=$b.'<tr><td>Total</td><td align="right">'.number_format($outright_tot,2).'</td><td align="right">'.number_format($ep_tot,2).'</td></tr>';

$b=$b.'</table></div><p style="height:30px;">&nbsp;</p>';

$b=$b.'<div class="row"><table class="datatable" width="80%">';


$b=$b.'<tr><td >Average Selling Price  / Pch</td><td align="right" class="bordercls">'.number_format($avgsellingprice,2).'</td></tr>';
$b=$b.'<tr><td>Average Cost / Pch</td><td align="right" class="bordercls">'.number_format($avgpurchcost,2).'</td></tr>';
$b=$b.'<tr><td>Average  Cost /Pch</td><td align="right" class="bordercls">'.number_format($avgpurchcost,2).'</td></tr>';
$b=$b.'<tr><td>&nbsp;<td><tr>';
$b=$b.'<tr><td>Gross E/P  Interst</td><td align="right" class="bordercls">'.number_format($totinterest,2).'</td></tr>';
$b=$b.'<tr><td>Less : Relevant lanka Intrust</td><td align="right" class="bordercls">'.number_format($totlbliEP,2).'</td></tr>';
$b=$b.'<tr><td>E/P Intrest After Lanka Intrust</td><td align="right" class="bordercls">'.number_format($totlpfinal,2).'</td></tr>';

$b=$b.'</table></div><p style="height:30px;">&nbsp;</p>';

$b=$b.'<div class="row"><table class="datatable" border="1" width="80%">';
$b=$b.'<tr><td>Average Rental  Values</td><td></td></tr>';
$b=$b.'<tr><td>Cout . Period</td><td>Rental</td></tr>';
$rentalmonths = array();
$count=0;
 if($rentalchart){
foreach($rentalchart as $rentraw){
if($rentraw->raw_name=='Average Rental'){
 for($i=12; $i<=96; $i=$i+12){
	 $rawname=$i.'M';
$b=$b.'<tr><td>'.$i.'M</td><td align="right">'.number_format($rentraw->$rawname,2).'</td></tr>';
$count++ ; }
	$b=$b.'<tr><td></td><td align="right">'.number_format($rentraw->raw_total,2).'</td></tr>';
}
}}

//for($i=12; $i<=96; $i=$i+12){
	//$b=$b.'<tr><td>'.$i.'M</td><td>'.$rentalmonths[$i].'</td></tr>';
 //}
$b=$b.'</table></br></br></div><p style="height:30px;">&nbsp;</p>';

$b=$b.'<p style="page-break-before: always">&nbsp;</p>';

$b=$b.'<table class="table"  >
<tr bgcolor="#bbd8f9"><th colspan="2" align="center" >Project Development Plan</th>
<th colspan="4" align="center" ></th></tr>
			 </table>


					<table class="table"  border="1"> <thead> <tr  class="info">  <th rowspan="2">Item</th>
								<th  colspan="'.$details->period.'" align="center">Percentage Completion</th>
								<th  rowspan="2">Raw Total</th>
								</tr>
								<tr  class="info">';
 for($i=1; $i<=$details->period; $i++){
								$b=$b.'<th>'.str_pad($i, 2, "0", STR_PAD_LEFT).'M</th>';
								}
								$b=$b.'</tr>
								</thead>';
								$count=1;  if($tasklist){
 foreach($tasklist as $raw) {
 $rawtot=0;



 $b=$b.' <tr style="border-bottom:1px solid #CCC;">
								<td style=" padding:0; margin:0"> '.$raw->task_name.'</td>';
							 for($i=1; $i<=$details->period; $i++){
if($timechart[$raw->task_id][$i])
$val=$timechart[$raw->task_id][$i]->percentage;
else
$val=0;
$rawtot=$rawtot+$val;

								 $b=$b.' <td style=" padding:0; margin:0" class="centervalue">'.$val.'</td>';
									}

								$b=$b.'   <td style=" padding:0; margin:0" class="centervalue">'.$rawtot.'</td> </tr>';


 }


 }

$b=$b.' </table>';
$b=$b.' <table class="signs" border="0">
<tr><td>&nbsp;</td><td><p style="height:30px;">&nbsp;</p></td><td></td></tr><tr><td></td><td>&nbsp;</td><td><p style="height:30px;">&nbsp;</p></td></tr>
<tr><td></td><td></td><td><p style="height:30px;">&nbsp;</p></td></tr>
<tr>
<td>..........................................</td><td></td><td>..........................................</td></tr>
<tr><td><strong>Project Officer</strong></td>
 <td><strong></strong></td>
 <td><strong>Technical Manager</strong></td></tr>
 <tr><td></td><td></td><td><p style="height:30px;">&nbsp;</p></td></tr>
 <tr><td></td><td></td><td><p style="height:30px;">&nbsp;</p></td></tr>
 <tr>
 <td>..........................................</td><td></td><td>..........................................</td></tr>
   <tr><td><strong>Sales  Ex/Asm/Sm</strong></td>
  <td><strong></strong></td>
  <td><strong>Administration Manager</strong></td></tr>
	<tr><td></td><td></td><td><p style="height:30px;">&nbsp;</p></td></tr>
  <tr><td></td><td></td><td><p style="height:30px;">&nbsp;</p></td></tr>
	<tr>
	<td>..........................................</td><td></td><td>..........................................</td></tr>
 <tr><td><strong>Dy. Gm/ AGM</strong></td>
	 <td><strong></strong></td>
	 <td><strong> Finance / Dy Finace Dirctor</strong></td></tr>
	 <tr><td></td><td></td><td><p style="height:30px;">&nbsp;</p></td></tr>
   <tr><td></td><td></td><td><p style="height:30px;">&nbsp;</p></td></tr>
	 <tr>
	 <td></td><td>..........................................</td><td></td></tr>
	 <tr><td></td><td></td><td><p style="height:30px;">&nbsp;</p></td></tr>
		<tr><td><strong></strong></td>
		<td><strong>Chief Executive Director</strong></td>
		<td><strong></strong></td></tr>

 </table></body>';




 //header("Content-type: application/vnd.ms-excel");
	//header("Content-Disposition: attachment;Filename=ProjectReport.xls");

	echo $b;
 ?>
