<script type="text/javascript">
function load_detailpopup(type,id)
{

                $('#popupform').delay(1).fadeIn(600);
                $( "#popupform" ).load( "<?=base_url()?>accounts/entry/view_popup/"+type+"/"+ id);

}
function closepo()
{
    $('#popupform').delay(1).fadeOut(600);
}
</script>
<div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
    <div  style="text-align:right">
    <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
</h4>
</div>
<div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
        <table class="table" id='entry_table'>
            <thead>
            <tr>
                <th>Date</th>
                <th>No</th>
                <th>Ledger Account</th>
                <th>Type</th>
                <th>Receipt No</th>
                <th>Narration</th>
                <th>Project</th>
                <th>Lot</th>
                <th>DR Amount</th>
                <th>CR Amount</th>
                <th colspan="3"></th>
            </tr>
            </thead>

            <?php
            $c=0;
            if($entries){
            foreach ($entries as $row)
            {
            $current_entry_type = entry_type_info($row->entry_type);
            ?>
            <tbody>
            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">

                <?php

                echo "<td>" . date('Y-m-d',strtotime($row->date)). "</td>";
                echo "<td>" ?>
	<a href="javascript:load_detailpopup('<?=$current_entry_type['label']?>','<?=$row->id?>')" ><?=full_entry_number($row->entry_type, $row->id)?></a>
                                      <? 
                echo "<td>";
                echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
                echo "</td>";

                echo "<td>" . $current_entry_type['name'] . "</td>";
                 echo "<td>" . $row->RCTNO . "</td>";
				  echo "<td>" . $row->narration . "</td>";
                  echo "<td>" . $row->project_name . "</td>";
                  echo "<td>" . $row->lot_number . "</td>";
                echo "<td align=right>" . number_format($row->dr_total, 2, '.', ',') . "</td>";
                echo "<td align=right>" . number_format($row->cr_total, 2, '.', ',') . "</td><td>";

            
           

                echo "</tr>";
            }}

                ?>
            </tbody>

        </table>
    </div>
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
        tableToExcel('entry_table', 'Entries', 'entries_<?=date('Y_m_d');?>.xls');
        // util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
    });
</script>