
<script type="text/javascript">


function load_printscrean2(id,month)
{
		
				window.open( "<?=base_url()?>re/report_excel/get_budget/"+id+"/"+month );
			}
function load_printscrean3(prjid,fromdate,todate)
{
			window.open( "<?=base_url()?>re/report_excel/get_budget_daterange/"+prjid+"/"+fromdate+"/"+todate );
	
}
</script>
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
 <?
 if($month!=''){
  $heading2=' Budget Report as at '.$reportdata;
 }
 else{
   $heading2=' Budget Report as at '.$reportdata;
 }
 
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">  <? if(isset($fromdate) & isset($todate)){ ?>
       <a href="javascript:load_printscrean3('0','<?=$prj_id?>','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? }else{?>
           <a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
   
       <? }?>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
        <div class="tableFixHead">               
      <table class="table table-bordered" id="table"><thead>
        <tr>
          <th colspan="5" style="text-align:center"><h4><?=$heading2?></h4></th>
        </tr>
     <tr class="success" style="font-weight:bold"></tr>
       <tr><th > Project Name </th><th > Category </th><th>Total Budget</th><th >Expense</th>
      <th >Balance</th>
        
        </tr></thead>
       
       
    <? 
	
	
		//echo $prjraw->prj_id;
			$full_prjbujet=$fullprjexp=$fullprjbal=0;
			
			?>
        <?  
        if($prjlist){
          foreach($prjlist as $row){
            $prjbujet=0;$prjexp=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
        if($reservation[$row->prj_id]){
			foreach($reservation[$row->prj_id] as $raw){
						if($raw->new_budget>0){			
				?>
        <tr>
          <td><?=$row->project_name?></td>
          <td><?=$raw->task_name?></td>
        <?if($raw->new_budget != ''){?>
           <td align="right"><?=number_format($raw->new_budget,2)?></td>
          <?}else{?>
            <td align="right"><?=number_format(0,2)?></td>
            <?}?>

             <?if($raw->tot_payments != ''){?>
            <td align="right"><?=number_format($raw->tot_payments,2)?></td>
          <?}else{?>
            <td align="right"><?=number_format(0,2)?></td>
            <?}?>
       <td align="right"> <?=number_format($raw->new_budget-$raw->tot_payments,2)?></td></tr>
        
       
        <? 
		$prjbujet=$prjbujet+$raw->new_budget;
		$prjexp=$prjexp+$raw->tot_payments;
		}}}?>
         <tr class="info" style="font-weight:bold">
         <td colspan="2">Project Total</td>
            <td align="right"><?=number_format($prjbujet,2)?></td>
          <td align="right"><?=number_format($prjexp,2)?></td>
         <td align="right"><?=number_format($prjbujet-$prjexp,2)?></td>
            
           
                   </tr>
          <?

                $full_prjbujet=$full_prjbujet+$prjbujet;
                $fullprjexp=$fullprjexp+$prjexp;
                $fullprjbal=$fullprjbal+($prjbujet-$prjexp);


        }}?>
        
         <tr class="info" style="font-weight:bold">
         <td colspan="2">Total</td>
            <td align="right"><?=number_format($full_prjbujet,2)?></td>
          <td align="right"><?=number_format($fullprjexp,2)?></td>
         <td align="right"><?=number_format($fullprjbal,2)?></td>
           
           
      <?
	 
	  
	  ?>
      
         </table></div>
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
  tableToExcel('table', 'Budget Report', 'budget_report_as_at_<?=$reportdata?>.xls');
 });    
</script>