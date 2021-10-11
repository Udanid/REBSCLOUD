
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">


function load_lotinquary(id,prj_id)
{
	 if(id!="")
	 {
		// var prj_id= document.getElementById("prj_id").value
	//	alert("<?=base_url()?>re/lotdata/get_fulldata/"+id+"/"+prj_id)
	 	 $('#popupform').delay(1).fadeIn(600);
   		   $( "#popupform").load( "<?=base_url()?>re/lotdata/get_fulldata_popup/"+id+"/"+prj_id );
	 }
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );
			
}
function add_followup_detalis(id,date)
{
	
 if(id!=""){
	 
	 
	 $('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_followupdata_popup/"+id+"/"+date);
	
				
					
				
	 
	 
		
 }
 else
 {
	
	 $('#followdata').delay(1).fadeOut(600);
 }
}
</script>
<script>
$(document).ready(function() {
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
tableToExcel('table', 'Down Payment collection Report', 'down_payment_collection_as_at_<?=date('Y_m_d');?>.xls');
// util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
});
});

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
  $heading2=' Down Payment collection as at '.$reportdata;
 }
 else{
   $heading2=' Down Payment collection as at '.$reportdata;
 }
 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">   <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       
       
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow" >
     <input type="hidden" id="rptdate" value="<?=$todate?>">
      <div class="tableFixHead">                        
     <table  class="table table-bordered" id="table"><thead>
     <tr>
     	<th colspan="19" align="center"><h4><?=$heading2?></h4></th>
     </tr>
     <tr class="success">
      <th  rowspan="2">Reservation Code</th><th  rowspan="2">Reservation Date</th>
      <th  rowspan="2">Project Name</th><th rowspan="2">Customer Name</th>
      <th rowspan="2">Contact Number</th>
      <th   rowspan="2">Lot Number</th>
      <th  rowspan="2" >Scheme</th>
      <th  rowspan="2"> Land Value </th>
      <th colspan="3">Receipt Details</th>
      <th  rowspan="2">Payment</th>
      <th  rowspan="2">Total Paid</th>
      <th  rowspan="2">Balance</th>
      <th rowspan="2">%</th>
    
     
       <th rowspan="2">Sales Person</th>
        </tr>
        <tr>
        	<th> Payment Date </th>
		    <th> Receipt Date </th>
		    <th> Receipt Number </th>
        </tr>
        </thead>
       
       
    <? 
	
	
	if($prjlist){$fullprjlandval=0;$fullprjprvcap=0;$fullprjbal=0; $fullprjpayment=0; $fullprjlastbal=0;$fulldue=0;$fullcrdue=0;
		foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjlandval=0;$prjprvcap=0;$prjbal=0; $prjpayment=0; $prjlastbal=0; $prjdue=0;$prjcrdue=0;
			$c=0;
			?>
        
        <?  if($type=='01'){ if($reservation[$prjraw->prj_id]){
			foreach($reservation[$prjraw->prj_id] as $raw){
			
			$flag=true; 
				if($raw->res_status=='REPROCESS')
				$flag=false;
				if($raw->loan_code)
						$flag=false;
				if($thispayment[$raw->res_code]>0)
				$flag=true;
					if($raw->discounted_price!=$prevpayment[$raw->res_code]){
						if($flag && $thispayment[$raw->res_code]!=0){
							
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjprvcap=$prjprvcap+$prevpayment[$raw->res_code]+$thispayment[$raw->res_code];
						$prjbal=$prjbal+($raw->discounted_price-$prevpayment[$raw->res_code]);
						$prjpayment=$prjpayment+$thispayment[$raw->res_code];
						$last_bal=$raw->discounted_price-$prevpayment[$raw->res_code]-$thispayment[$raw->res_code];
						if($raw->loan_code)
						$last_bal=0;
						if($raw->res_status=='REPROCESS')
							$last_bal=0;
						
						$prjlastbal=$prjlastbal+$last_bal;
						$balance=$raw->discounted_price-$prevpayment[$raw->res_code]-$thispayment[$raw->res_code];
						
						$openpresentage=(($thispayment[$raw->res_code]+$prevpayment[$raw->res_code])/$raw->discounted_price)*100;
						
						 $date1=date_create($raw->res_date);
						 $date2=date_create($todate);
						 $diff=date_diff($date1,$date2);
						 $aging=$diff->format("%a ");
						
						$lastpaydate=get_last_payment_date($raw->res_code);
						 $date1=date_create($lastpaydate);
						 $date2=date_create($todate);
						  $diff=date_diff($date1,$date2);
						 $datelast=$diff->format("%a ");
						
						
				?>
         <tbody>
         <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
        <td><?=$raw->res_code?></td>
        <td><?=$raw->res_date?></td>
        <td><?=$prjraw->project_name?></td>
        <td><?=$raw->first_name?> <?=$raw->last_name?></td>
        <td align="right"><?=$raw->mobile?></td>
        <td><a href="javascript:load_lotinquary('<?=$raw->lot_id?>','<?=$raw->prj_id?>')" ><?=$raw->lot_number?></a></td>
            <td align="right"><?=$raw->pay_type?></td>
         
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
        <td colspan="3">
        <? if($dpthisreceipts[$raw->res_code]){?>
              <table>
                <?
                foreach ($dpthisreceipts[$raw->res_code] as $key => $value) {
                  ?>
                  <tr>
                    <td><?=$value->income_date?></td>
                    <td><?=$value->entry_date?></td>
                    <td><?=$value->rct_no?></td>
                  </tr>
                <?}?>
                </table>

                <?}?>
       </td>
        <td align="right"><?=number_format($thispayment[$raw->res_code],2)?></td>
         <td align="right"><?=number_format($prevpayment[$raw->res_code]+$thispayment[$raw->res_code],2)?></td>
          <td align="right"><?=number_format($last_bal,2)?></td>
            <td align="right"><?=number_format($openpresentage,2)?></td>

           
                
            
     
             
                
               
                <td><?=get_user_fullname_id($raw->sales_person)?></td>
                
        </tr>
        <? }}}} }?><? if($type=='04'){  if($zepreservation[$prjraw->prj_id]){
			foreach($zepreservation[$prjraw->prj_id] as $raw){
				//if($currentlist[$raw->res_code]){
					$zprvpayment=0;$zthispayment=0;
					if($zepprevpayment[$raw->loan_code])
					$zprvpayment=$zepprevpayment[$raw->loan_code]->sum_cap;
					if($zepthispayment[$raw->loan_code])
					$zthispayment=$zepthispayment[$raw->loan_code]->sum_cap;
					$fullpayment=$raw->down_payment+$zprvpayment;
					
					$flag=true; 
				if($raw->loan_status=='SETTLED')
				$flag=false;
				if($zthispayment>0)
				$flag=true;
					if($raw->discounted_price!=$fullpayment){
						if($flag && $zthispayment !=0){
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjprvcap=$prjprvcap+$fullpayment+$zthispayment;
						$prjbal=$prjbal+($raw->discounted_price-$fullpayment);
						$prjpayment=$prjpayment+$zthispayment;
						$last_bal=$raw->discounted_price-$fullpayment-$zthispayment;
						$due=uptodate_arrears($raw->loan_code,$sartdate);
						$alldue=uptodate_arrears($raw->loan_code,$todate);
						$crdue=$alldue-$due;
						
						$prjdue=$prjdue+$due;
						$prjcrdue=$prjcrdue+$crdue;
						
						$prjlastbal=$prjlastbal+$last_bal;
						$balance=$raw->discounted_price-$fullpayment-$zthispayment;
						$openpresentage=(($fullpayment+$zthispayment)/$raw->discounted_price)*100;
						
						 $date1=date_create($raw->res_date);
						 $date2=date_create($todate);
						 $diff=date_diff($date1,$date2);
						 $aging=$diff->format("%a ");
						
						$lastpaydate=get_last_payment_date($raw->loan_code);
						 $date1=date_create($lastpaydate);
						 $date2=date_create($todate);
						  $diff=date_diff($date1,$date2);
						 $datelast=$diff->format("%a ");
						
				?>
       <tr   class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"><td><?=$raw->res_code?></td><td><?=$raw->res_date?></td>
        <td><?=$prjraw->project_name?> &nbsp; <a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->loan_code?></a></td>
        <td><?=$raw->lot_number?></td>
           <td><?=$raw->loan_type?></td>
        <td><?=$raw->period?>M - <?=$raw->unique_code?></td>
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($fullpayment+$zthispayment,2)?></td>
            <td align="right"><?=number_format($last_bal,2)?></td>
           <td align="right"><?=number_format($openpresentage,2)?></td>
              <td align="right"><?=number_format($due,2)?></td>
              <td align="right"><?=number_format($crdue,2)?></td>
           <td align="right"><?=number_format($zthispayment,2)?></td>
         
               <td align="right"><?=$aging?></td>
            <td align="right"><?=$datelast?></td>
      
              <td align="right"><?=$raw->first_name?> <?=$raw->last_name?></td>
                <td align="right"><?=$raw->mobile?><a href="javascript:add_followup_detalis('<?=$raw->loan_code?>','<?=$reportdata?>')"><i class="fa fa-phone nav_icon icon_red "></i></a></td>
                   <td><?=$raw->id_number?></td>
                <td><?=get_user_fullname_id($raw->sales_person)?></td>
          
        </tr>
        <? }}}} }?>
        <? if($prjlandval>0){?>
          <tr class="active" style="font-weight:bold"><td></td><td></td>
         <td> <?=$prjraw->project_name?>  Total</td><td></td><td></td><td></td><td></td>
        <td align="right"><?=number_format($prjlandval,2)?></td>
         <td colspan="3"></td>
        <td align="right"><?=number_format($prjpayment,2)?></td>
         <td align="right"><?=number_format($prjprvcap,2)?></td>
         <td align="right"><?=number_format($prjlastbal,2)?></td>
         <td></td>
          <td></td>
        </tr><? }?>
        
      <?
	  $fullprjlandval=$fullprjlandval+$prjlandval;
	  $fullprjprvcap=$fullprjprvcap+$prjprvcap;
	  $fullprjbal=$fullprjbal+$prjbal;
	  $fullprjpayment=$fullprjpayment+$prjpayment;
	  $fullprjlastbal=$fullprjlastbal+$prjlastbal;
	    $fulldue=$fulldue+$prjdue;
		$fullcrdue=$fullcrdue+$prjcrdue;
	  
	   }}?>
      <tr class="active" style="font-weight:bold"><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        <td align="right"><?=number_format($fullprjlandval,2)?></td>
         <td colspan="3"></td>
        <td align="right"><?=number_format($fullprjpayment,2)?></td>
         <td align="right"><?=number_format($fullprjprvcap,2)?></td>
           <td align="right"><?=number_format($fullprjlastbal,2)?></td>
           <td></td>
          <td></td>
        </tr></tbody>
         </table></div></div>
    </div> 
    
</div>
