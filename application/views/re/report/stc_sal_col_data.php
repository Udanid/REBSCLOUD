<!DOCTYPE html>
<html>
<body>
<script>
    var $th = $('.tableFixHead').find('thead th')
    $('.tableFixHead').on('scroll', function() {
      $th.css('transform', 'translateY('+ this.scrollTop +'px)');
    });
</script>
<style>
    .tableFixHead { overflow-y: auto; height: 600px; }
    table  { border-collapse: collapse; width: 100%; }
    th, td { padding: 8px 16px; }
    th     { background:#eee; }
</style>
 <div class="widget-shadow">
       <div class="form-title">
        <h4>Stock,Sales & Collection Summery Report As At <?=$date?> 
       <span style="float:right">    
        <div class="form-group" style="margin-left: 100%;">
            <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
         </div>
    </span></h4>
    </div>
     <div class="table-responsive bs-example widget-shadow"  >
       <div class="tableFixHead">        
      <table class="table table-bordered" id="table">
        <thead>
        <tr>
            <th style="text-align:center;" colspan="29" style="text-align:center;">Stock,Sales & Collection Summery Report As At <?=$date?></th>
        </tr>
        <tr>
            
            <th style="text-align:center;" rowspan='2'>No</th>
            <th style="text-align:center;" rowspan='2'>Project Name</th>
            <th style="text-align:center;" rowspan='2'>Project Code</th>
            <th style="text-align:center;" rowspan='2'>Land Proposed Date</th>
            <th style="text-align:center;" rowspan='2'>Land Purchase Date</th>
            <th style="text-align:center;" rowspan='2'>Land Project Commence Date</th>
            <th style="text-align:center;" rowspan='2'>Land Sales Commence Date</th>
            <th style="text-align:center;" rowspan='2'>Land Project Completion Date</th>
            <th style="text-align:center;" rowspan='2'>Project Period(Months)</th>
            <th style="text-align:center;" rowspan='2'>Land Extent(Purchase)</th>
            <th style="text-align:center;" rowspan='2'>Land Purchase Price</th>
            <th style="text-align:center;" rowspan='2'>Overheads</th>
            <th style="text-align:center;" rowspan='2'>Land Development Cost</th>
            <th style="text-align:center;" rowspan='2'>Total Stock</th> 
            <th style="text-align:center;" rowspan='2'>Balance Stock</th>
            <th style="text-align:center;" rowspan='2'>Advance Stock</th>
            <th style="text-align:center;" rowspan='2'>Total Sales Value</th>
            <th style="text-align:center;" rowspan='2'>Advance Sales Value</th>
            <th style="text-align:center;" rowspan='2'>Total Sold Sales Value</th>
            <th style="text-align:center;" rowspan='2'>Total Blocks</th>
            <th style="text-align:center;" rowspan='2'>Total Sold Blocks</th>
            <th style="text-align:center;" rowspan='2'>Number of Advance Blocks</th>
            <th style="text-align:center;" rowspan='2'>Balance Blocks</th>
            <th style="text-align:center;" rowspan='2'>Down Payment Collection</th>
            <th style="text-align:center;" rowspan='2'>Zero Intrest Collection (ZEP)</th>
            <th style="text-align:center;" colspan="2">EP Collection (NEP)</th>
            <th style="text-align:center;" rowspan='2'>Bank Loan Collection (EPB)</th>
            <th style="text-align:center;" rowspan='2'>Total Collection</th>
            </tr>
            <tr>
                <th style="text-align:center;">Capital</th>
                <th style="text-align:center;">Intrest Colle</th>
            </tr>
            </thead>
            <?     $full_tot_stock=$full_balance_stock=$full_tot_sale=$full_sold_sale=$full_tot_blocks=$full_sold_blocks=$full_balance_blocks=$full_dp_collection=$full_zep_collection=$full_nep_cap=$full_nep_int=$full_epb_collection =$full_tot=$full_land_purchase=$full_overheads=$full_dvp_cst=$full_adv_stock=$full_adv_sale=$full_adv_blocks=0;

                if($prjlist){
                $count = 1;
                foreach($prjlist as $row){
                    $tot_stock = 0;$balance_stock = 0;$tot_sales=0;$tot_sold_sales=0;$block_count=0;$sold_blocks=0;$balance_blocks=0;$sold_stock=0;$dpcollection=0;$nepcapital=0;$nepint=0;$zepcollection=0;$epbcollection=0;$tot_collection=0;$land_purchasing=0;$verheads=0;$land_development=0;$advance_blocks=0;$advance_stock=0;$tot_advance_sales=0;$prj_periods=0;
                    if($all_blocks){
                        if($all_blocks[$row->prj_id])
                        {
                             foreach ($all_blocks[$row->prj_id] as $block) 
                            {
                                $tot_stock = $tot_stock + floatval($block->costof_sale);
                                if($block->status == "PENDING")
                                    $tot_sales = $tot_sales + floatval($block->sale_val);
                                else
                                    $tot_sales = $tot_sales + floatval($block->discounted_price);

                                $block_count++;
                            }
                        }

                        if($sold_lots[$row->prj_id])
                        {
                             foreach ($sold_lots[$row->prj_id] as $lots) 
                            {
                                

                                 if($lots->status == "SOLD")
                                 {
                                    $sold_stock = $sold_stock + floatval($lots->costof_sale);
                                    $tot_sold_sales = $tot_sold_sales + floatval($lots->discounted_price);
                                    $sold_blocks++;
                                 }
                                 else
                                 {
                                    $advance_stock = $advance_stock + floatval($lots->costof_sale);
                                    $tot_advance_sales = $tot_advance_sales + floatval($lots->discounted_price);
                                    $advance_blocks++;
                                 }
                               
                            }

                            

                        }

                        $balance_stock = $tot_stock - $sold_stock - $advance_stock;
                        $balance_blocks =  $block_count - $sold_blocks-$advance_blocks;
                       
                    }

                    if($all_reservations[$row->prj_id]){
                        foreach($all_reservations[$row->prj_id] as $res){
                            $dpcollection = $dpcollection + floatval($dp_collection[$res->res_code]);

                            if($res->pay_type == 'NEP' || $res->pay_type == 'ZEP' || $res->pay_type == 'EPB'){
                                  if($loan_payment[$res->res_code]){
                                    if($res->pay_type == 'ZEP'){
                                        $zepcollection = $zepcollection + floatval($loan_payment[$res->res_code]->sum_cap)+ floatval($loan_payment[$res->res_code]->sum_int)+ floatval($loan_payment[$res->res_code]->sum_di);
                                        if($settlepayment[$res->res_code])
                                            $zepcollection = $zepcollection + floatval($settlepayment[$res->res_code]->sum_cap)+ floatval($settlepayment[$res->res_code]->sum_int)+ floatval($settlepayment[$res->res_code]->sum_di);
                                    }

                                    if($res->pay_type == 'NEP'){
                                        $nepcapital = $nepcapital + floatval($loan_payment[$res->res_code]->sum_cap);
                                        $nepint = $nepint  + floatval($loan_payment[$res->res_code]->sum_int)+ floatval($loan_payment[$res->res_code]->sum_di);

                                         if($settlepayment[$res->res_code]){
                                            $nepcapital = $nepcapital + floatval($settlepayment[$res->res_code]->sum_cap);
                                            $nepint = $nepint + floatval($settlepayment[$res->res_code]->sum_int)+ floatval($settlepayment[$res->res_code]->sum_di);
                                        }
                                    }

                                    if($res->pay_type == 'EPB'){
                                        $epbcollection = $epbcollection + floatval($loan_payment[$res->res_code]->sum_cap)+ floatval($loan_payment[$res->res_code]->sum_int)+ floatval($loan_payment[$res->res_code]->sum_di);

                                         if($settlepayment[$res->res_code])
                                            $epbcollection = $epbcollection + floatval($settlepayment[$res->res_code]->sum_cap)+ floatval($settlepayment[$res->res_code]->sum_int)+ floatval($settlepayment[$res->res_code]->sum_di);
                                    }
                                }
                            }
                          
                       
                        }
                    }


                     $tot_collection = $dpcollection + $zepcollection + $epbcollection + $nepcapital + $nepint;

                    if($prj_budget[$row->prj_id]){
                        foreach($prj_budget[$row->prj_id] as $budget){
                            if($budget->task_id == '1' && $budget->new_budget != '')
                                $land_purchasing = $budget->new_budget;
                            if($budget->task_id == '11' && $budget->new_budget != '')
                                $overheads = $budget->new_budget;
                            if($budget->task_id == '5' && $budget->new_budget != '')
                                $land_development = $budget->new_budget;

                        }
                    }

                    if($row->date_prjcommence != '' && $row->date_prjcompletion != ''){
                        $prj_commence = date_create($row->date_prjcommence);
                        $prj_complete = date_create($row->date_prjcompletion);
                        if(gettype($prj_commence) != 'boolean' && gettype($prj_complete) != 'boolean'){
                            $interval = date_diff($prj_commence, $prj_complete);
                             $prj_periods = $interval->format('%m');
                        }
                       
                    }
                    
                    ?>

                <tr <?if($count%2 == 0){?> class="info"<?}?>>
                    <td style="text-align:right;"><?=$count;?></td>
                    <td><?=$row->project_name;?></td>
                    <td style="text-align:right;"><?=$row->project_code;?></td>
                    <td style="text-align:right;"><?=$row->date_proposal?></td>
                    <td style="text-align:right;"><?=$row->date_purchase?></td>
                    <td style="text-align:right;"><?=$row->date_prjcommence?></td>
                    <td style="text-align:right;"><?=$row->date_slscommence?></td>
                    <td style="text-align:right;"><?=$row->date_prjcompletion?></td>
                    <td style="text-align:right;"><?=$prj_periods?></td>
                    <td style="text-align:right;"><?=$row->land_extend?></td>
                    <td style="text-align:right;"><?=number_format($land_purchasing,2)?></td>
                    <td style="text-align:right;"><?=number_format($overheads,2)?></td>
                    <td style="text-align:right;"><?=number_format($land_development,2)?></td>
                    <td style="text-align:right;"><?=number_format($tot_stock,2);?></td>
                    <td style="text-align:right;"><?=number_format($balance_stock,2);?></td>
                    <td style="text-align:right;"><?=number_format($advance_stock,2);?></td>
                    <td style="text-align:right;"><?=number_format($tot_sales,2);?></td>
                    <td style="text-align:right;"><?=number_format($tot_advance_sales,2);?></td>
                    <td style="text-align:right;"><?=number_format($tot_sold_sales,2);?></td>
                    <td style="text-align:right;"><?=$block_count;?></td>
                    <td style="text-align:right;"><?=$sold_blocks;?></td>
                    <td style="text-align:right;"><?=$advance_blocks;?></td>
                    <td style="text-align:right;"><?=$balance_blocks;?></td>
                    <td style="text-align:right;"><?=number_format($dpcollection,2);?></td>
                    <td style="text-align:right;"><?=number_format($zepcollection,2);?></td>
                    <td style="text-align:right;"><?=number_format($nepcapital,2);?></td>
                    <td style="text-align:right;"><?=number_format($nepint,2);?></td>
                    <td style="text-align:right;"><?=number_format($epbcollection,2);?></td>
                    <td style="text-align:right;"><?=number_format($tot_collection,2);?></td>
                </tr>
                <?
                   $full_tot_stock = $full_tot_stock + $tot_stock;
                   $full_balance_stock = $full_balance_stock + $balance_stock;
                   $full_tot_sale = $full_tot_sale + $tot_sales;
                   $full_sold_sale = $full_sold_sale + $tot_sold_sales;
                   $full_tot_blocks = $full_tot_blocks + $block_count;
                   $full_sold_blocks = $full_sold_blocks + $sold_blocks;
                   $full_balance_blocks = $full_balance_blocks + $balance_blocks;
                   $full_dp_collection = $full_dp_collection + $dpcollection;
                   $full_zep_collection = $full_zep_collection + $zepcollection;
                   $full_nep_cap = $full_nep_cap + $nepcapital;
                   $full_nep_int = $full_nep_int + $nepint;
                   $full_epb_collection = $full_epb_collection + $epbcollection;
                   $full_tot = $full_tot + $tot_collection;
                   $full_land_purchase = $full_land_purchase + $land_purchasing;
                   $full_overheads = $full_overheads + $overheads;
                   $full_dvp_cst = $full_dvp_cst + $land_development;
                   $full_adv_stock = $full_adv_stock + $advance_stock;
                   $full_adv_sale = $full_adv_sale + $tot_advance_sales;
                   $full_adv_blocks = $full_adv_blocks + $advance_blocks;

                $count++;}}?>
            <tr>
                <th colspan="10" style="text-align:center;">Total</th>
                <th style="text-align:right;"><?=number_format($full_land_purchase,2)?></th>
                <th style="text-align:right;"><?=number_format($full_overheads,2)?></th>
                <th style="text-align:right;"><?=number_format($full_dvp_cst,2)?></th>
                <th style="text-align:right;"><?=number_format($full_tot_stock,2)?></th>
                <th style="text-align:right;"><?=number_format($full_balance_stock,2)?></th>
                 <th style="text-align:right;"><?=number_format($full_adv_stock,2)?></th>
                <th style="text-align:right;"><?=number_format($full_tot_sale,2)?></th>
                <th style="text-align:right;"><?=number_format($full_adv_sale,2)?></th>
                <th style="text-align:right;"><?=number_format($full_sold_sale,2)?></th>
                <th style="text-align:right;"><?=$full_tot_blocks?></th>
                <th style="text-align:right;"><?=$full_sold_blocks?></th>
                <th style="text-align:right;"><?=$full_adv_blocks?></th>
                <th style="text-align:right;"><?=$full_balance_blocks?></th>
                <th style="text-align:right;"><?=number_format($full_dp_collection,2)?></th>
                <th style="text-align:right;"><?=number_format($full_zep_collection,2)?></th>
                <th style="text-align:right;"><?=number_format($full_nep_cap,2)?></th>
                <th style="text-align:right;"><?=number_format($full_nep_int,2)?></th>
                <th style="text-align:right;"><?=number_format($full_epb_collection,2)?></th>
                <th style="text-align:right;"><?=number_format($full_tot,2)?></th>
            </tr>
    </table>

</div>
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
  tableToExcel('table', 'Stock,Sale,Collection Summery Report', 'stock_sale_collection_as_at_<?=$date?>.xls');
 });    
</script>
<!-- Ticket No-2902 | Added By Uvini -->