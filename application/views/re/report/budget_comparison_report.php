<!DOCTYPE html>
<html>
<body>
<?php
    if(!isset($yearvalue[1]['epsales']))
        $yearvalue[1]['epsales'] = 0;
    if(!isset($yearvalue[2]['epsales']))
        $yearvalue[2]['epsales'] = 0;
    if(!isset($yearvalue[1]['outright']))
        $yearvalue[1]['outright'] = 0;
    if(!isset($yearvalue[2]['outright']))
        $yearvalue[2]['outright'] = 0;
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

<?
        $tasktot = $tasktot_confirmed = $tasktot_new = 0.0;
        $budget = array();
        $confirm_budget = array();
        $new_budget = array();
        $task_list = array();
       foreach($tasklist as $raw) {
           if($maintaskdata[$raw->task_id]['maintask'])
           {
                $tasktot=$maintaskdata[$raw->task_id]['maintask']->budget;
                array_push($budget,$tasktot);
            }

            if($maintaskdata_confirmed[$raw->task_id]['maintask'])
            {
                  $tasktot_confirmed = $maintaskdata_confirmed[$raw->task_id]['maintask']->budget;
                   array_push($confirm_budget,$tasktot_confirmed);
            }

            if($maintaskdata_new[$raw->task_id]['maintask'])
            {
                 $tasktot_new = $maintaskdata_new[$raw->task_id]['maintask']->budget;
                  array_push($new_budget,$tasktot_new);
            }

            array_push($task_list,$raw->task_name);
        }

        $budget = json_encode($budget);
        $confirm_budget = json_encode($confirm_budget);
        $new_budget = json_encode($new_budget);
        $task_list = json_encode($task_list);
    ?>
            <div class="widget-shadow">
                <div class="form-body" style="text-align:center">
                    <h4>Budget Comparison (<?=$details->project_name;?>)</h4>
                </div>
             <div id="chartset">
     
                       <canvas id="canvas1" width="1000" style="overflow-x: scroll;"></canvas>
                            <script type="text/javascript">
                                var color = Chart.helpers.color;
                                    var barChartData = {
                                        labels:<?=$task_list?>,

                                        datasets: [{
                                            label: 'Feasibility Budget',
                                            backgroundColor:color(window.chartColors.green).alpha(0.3).rgbString(),
                                           borderColor: window.chartColors.green,
                                          borderWidth: 1,
                                               data:<?=$budget?>,
                                             },
                                             {
                                                  label: 'Comfirmed Budget',
                                            backgroundColor:color(window.chartColors.orange).alpha(0.3).rgbString(),
                                           borderColor: window.chartColors.green,
                                          borderWidth: 1,
                                               data:<?=$confirm_budget?>,
                                             },
                                              {
                                                  label: 'New Estimated Budget',
                                            backgroundColor:color(window.chartColors.red).alpha(0.3).rgbString(),
                                           borderColor: window.chartColors.green,
                                          borderWidth: 1,
                                               data:<?=$new_budget?>,
                                             }]


                                     };

                        var ctx = document.getElementById("canvas1").getContext("2d");
                           new Chart(ctx, {type: 'bar', data: barChartData,  options: {
scales: {
   xAxes: [{
       ticks: {
           autoSkip: false,
           maxRotation: 90,
           minRotation: 90
       }
   }]
}
},});





    </script>


                        </div>
        </div>

 <div class="widget-shadow">
       <div class="form-group" style="margin-left: 95%;margin-top:20px;">
                        <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
                    </div>
    <table class="table table-bordered" id="table">
        <tr>
            <th style="text-align:center" colspan="5">Budget Comparison Report (<?=$details->project_name;?>)</th>
        </tr>
        <tr>
            <th></th>
            <th style="text-align:center;">Task</th>
            <th style="text-align:center;">Feasibility Budget</th>
            <th style="text-align:center;">Comfirmed Budget</th>
            <th style="text-align:center;">New Estimated Budget</th>
            </tr>
        <tr>
        <?
            $count=1;
            $taskid="";
            $nettotal=$nettotal_confirmed=$nettotal_new=0;

            if($tasklist)
            {$tasktot=$tasktot_confirmed =$tasktot_new = 0;
                foreach($tasklist as $raw1) {
                    $taskid=$taskid.$raw1->task_id.',';
                }

                foreach($tasklist as $raw) {
                    // if($maintaskdata[$raw->task_id]['maintask'])
                    // {
                    //     $tasktot=$maintaskdata[$raw->task_id]['maintask']->budget;
                    //     $tasktot_confirmed = $maintaskdata_confirmed[$raw->task_id]['maintask']->estimate_budget;
                    //      $tasktot_new = $maintaskdata_new[$raw->task_id]['maintask']->new_budget;
                    // }
                    // else
                    // {
                    //     $tasktot=$tasktot_confirmed=$tasktot_new=0;
                    // }

                    if($maintaskdata[$raw->task_id]['maintask'])
                    {
                        $tasktot=$maintaskdata[$raw->task_id]['maintask']->budget;
                        if($tasktot==Null){
                          $tasktot=0;
                        }
                    }else{
                      $tasktot=0;
                    }
                    if($maintaskdata_confirmed[$raw->task_id]['maintask'])
                    {

                        $tasktot_confirmed = $maintaskdata_confirmed[$raw->task_id]['maintask']->budget;
                        if($tasktot_confirmed==Null){
                          $tasktot_confirmed=0;
                        }
                    }else{
                      $tasktot_confirmed=0;
                    }
                    if($maintaskdata_new[$raw->task_id]['maintask'])
                    {
                        $tasktot_new = $maintaskdata_new[$raw->task_id]['maintask']->budget;
                        if($tasktot_new==Null){
                          $tasktot_new=0;
                        }
                    }else{
                      $tasktot_new=0;
                    }
                    //updated by ticket 3099
                    $nettotal=$nettotal+$tasktot;
                    $nettotal_confirmed=$nettotal_confirmed+$tasktot_confirmed;
                    $nettotal_new=$nettotal_new+$tasktot_new;
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
            <th style="text-align:center;"><?=$x?></th>
            <td align="center"> <?=$raw->task_name?></td>
            <td style="text-align:right;"> <?=number_format($tasktot,2);?></td>
            <?if($tasktot_confirmed > $tasktot && $tasktot != 0){?>
                 <td style="text-align:right;background-color:#ff4444;"> <?=number_format($tasktot_confirmed,2);?></td>
            <?}elseif($tasktot_confirmed < $tasktot && $tasktot != 0){?>
                 <td style="text-align:right;background-color:#66ff66;"> <?=number_format($tasktot_confirmed,2);?></td>
            <?}else{?>
                 <td style="text-align:right;"> <?=number_format($tasktot_confirmed,2);?></td>
            <?}?>

             <?if($tasktot_new > $tasktot && $tasktot != 0){?>
                 <td style="text-align:right;"> <?=number_format($tasktot_new,2);?></td>
            <?}elseif($tasktot_new < $tasktot && $tasktot != 0){?>
                <td style="text-align:right;"> <?=number_format($tasktot_new,2);?></td>
            <?}else{?>
                <td style="text-align:right;"> <?=number_format($tasktot_new,2);?></td>
            <?}?>

        </tr>
        <?$x++;}}?>
        <tr>
            <th colspan="2" style="text-align:center;">Total</th>
            <th style="text-align:right;"> <?=number_format($nettotal,2);?></td>
            <th style="text-align:right;"> <?=number_format($nettotal_confirmed,2);?></td>
            <th style="text-align:right;"> <?=number_format($nettotal_new,2);?></td>
        </tr>
    </table>

</div>

<script type="text/javascript">
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
  tableToExcel('table', 'Budget Comparison Report', 'budget_comparison_report.xls');
 });
</script>
<!-- Ticket No-2902 | Added By Uvini -->
