
<script type="text/javascript">

function load_printscrean1(branch,type,from,to,prj_id)
{
			window.open( "<?=base_url()?>re/report_excel/collection_details/"+branch+'/'+type+'/'+from+'/'+to+'/'+prj_id);
	
}
function load_printscrean_new(branch,type,from,to,prj_id)
{
			window.open( "<?=base_url()?>re/report_excel/collection_details/"+branch+'/'+type+'/'+from+'/'+to+'/'+prj_id);
	
}

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
</script>
<script>
var $th = $('.tableFixHead').find('thead th')
$('.tableFixHead').on('scroll', function() {
  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
});
</script>
<style>
.tableFixHead { overflow-y: auto; height: 500px; }

/* Just common table stuff. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
</style> 
 <?
 
   $heading2=' Collection Details Report '.$fromdate;

 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">     
     <a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
      
       
       
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
      <div class="tableFixHead">               
      <table class="table table-bordered" id="table">
      <thead>
      	<tr>
      		<th colspan="18"><h4><?=$heading2?></h4></th>
      	</tr>
      	<tr class="success"><th >Project Name</th><th  >Lot Number</th>
      		<th>Customer Name</th>
      <th  >Reciept No</th>  <th  >Payment Date</th><th>Receipt Date</th>
       <!--  <th > NRA </th> --><th > Advance Payment </th><th >Loan Capital (NEP)</th><th >Loan Capital (ZEP)</th><th >Loan Capital (EPB)</th><th >LoanInterest </th>
      <th >Delay Interest</th><th>Stamp Fee</th><th>Legal Fees</th><th>Draft Checking Fee</th><th>Plan Copy Fees</th><th>PR Fees</th><th >Total</th>
        </tr>
        </tr>
       </thead>
       <tbody>
       
    <? 
	$current_name='';
	$prj_adv=0;$prj_cap_nep=$prj_cap_zep=$prj_cap_epb=0;$prj_int=0;$prj_di=0; $prj_other=0;$prj_nra=0;$prj_line_tot=0;
	$full_adv=0;$full_cap_nep=$full_cap_zep=$full_cap_epb=0;$full_int=0;$full_di=0; $full_other=0;$full_nra=0;$full_line_tot=0;
	$adv=0;$cap=0;$int=0;$di=0; $other=0;$nra=0;$line_tot=0;
	/*Ticket No:2520 Updated By Madushan 2021.04.20*/
	$stamp_fee=0;$legal_fees=0;$draft_fees=0;$plan_copy_fees=0;$pr_fees=0;
	$prj_stamp_fee=0;$prj_legal_fees=0;$prj_draft_fees=0;$prj_plan_copy_fees=0;$prj_pr_fees=0; 
	$full_stamp_fee=0;$full_legal_fees=0;$full_draft_fees=0;$full_plan_copy_fees=0;$full_pr_fees=0; 
	if($dataset){ 
		
		foreach($dataset as $prjraw){
			$adv=0;$cap=0;$int=0;$di=0; $other=0;$nra=0;$cap_nep=0;$cap_zep=0;$cap_epb=0; $intid=0;
			$stamp_fee=0;$legal_fees=0;$draft_fees=0;$plan_copy_fees=0;$pr_fees=0;
			if($prjraw->income_type=='Advance Payment')
			{	/*Ticket No:2520 Updated By Madushan 2021.04.20*/
				//  $intid=get_first_advance($prjraw->temp_code);// this function is in reaccount_helper
				// if($intid==$prjraw->id)
				// $nra=$prjraw->pay_amount;
				// else
				$adv=$prjraw->pay_amount;
			}
			//rental Payments
			
			
			if($prjraw->sum_cap)
			{
				if($prjraw->loan_type=='NEP') $cap_nep=$prjraw->sum_cap;
				if($prjraw->loan_type=='ZEP') $cap_zep=$prjraw->sum_cap;
				if($prjraw->loan_type=='EPB') $cap_epb=$prjraw->sum_cap;
			}
			if($prjraw->sum_int)
			$int=$prjraw->sum_int;
			if($prjraw->sum_di)
			$di=$prjraw->sum_di;
			// Ep Settlement
			if($prjraw->balance_capital)
			{
				if($prjraw->loan_type=='NEP') $cap_nep=$prjraw->sum_cap;
				if($prjraw->loan_type=='ZEP') $cap_zep=$prjraw->sum_cap;
				if($prjraw->loan_type=='EPB') $cap_epb=$prjraw->sum_cap;
			}
			if($prjraw->int_paidamount)
			$int=$prjraw->int_paidamount;
			// Advance Di
			if($prjraw->advance_di)
			$di=$prjraw->advance_di;
			if($prjraw->income_type!='Advance Payment' & $prjraw->income_type!='Rental Payment' & $prjraw->income_type!='EP Settlement'){
			 /*Ticket No:2520 Updated By Madushan 2021.04.20*/
				$other_chargers = other_chargers_data($prjraw->id);//chagers_helper
	           if($other_chargers){
	           		foreach($other_chargers as $row)
	           		{
	           			if($row['chage_type'] == 'stamp_duty')
	           				$stamp_fee = $row['pay_amount'];
	           			elseif($row['chage_type'] == 'leagal_fee')
	           				$legal_fees = $row['pay_amount'];
	           			elseif($row['chage_type'] == 'other_charges')
	           				$plan_copy_fees = $row['pay_amount'];
	           			elseif($row['chage_type'] == 'other_charge2')
	           				$pr_fees = $row['pay_amount'];
	           			elseif($row['chage_type'] == 'document_fee')
	           				$draft_fees = $row['pay_amount'];
	           		}
	       		}

			}
			$line_tot=$adv+$cap_epb+$cap_nep+$cap_zep+$int+$di+$other+$nra+$stamp_fee+$legal_fees+$draft_fees+$plan_copy_fees+$pr_fees;
			  if($current_name!='' & $current_name!=$prjraw->project_name){?>
			
			 <tr class="info" style="font-weight:bold"><td><?=$current_name?> Total</td><td></td><td></td><td></td><td></td><td></td>
      <!--  <td align="right"><?=number_format($prj_nra,2)?></td> -->
        <td align="right"><?=number_format($prj_adv,2)?></td>
           <td align="right"><?=number_format($prj_cap_nep,2)?></td>
          <td align="right"><?=number_format($prj_cap_zep,2)?></td>
           <td align="right"><?=number_format($prj_cap_epb,2)?></td>
       <td align="right"><?=number_format($prj_int,2)?></td>
          <td align="right"><?=number_format($prj_di,2)?></td>
          <td align="right"><?=number_format($prj_stamp_fee,2)?></td>
          <td align="right"><?=number_format($prj_legal_fees,2)?></td>
          <td align="right"><?=number_format($prj_draft_fees,2)?></td>
          <td align="right"><?=number_format($prj_plan_copy_fees,2)?></td>
          <td align="right"><?=number_format($prj_pr_fees,2)?></td>
          <td  align="right"><?=number_format($prj_line_tot,2)?></td>
        </tr>
					<? $prj_adv=0;$prj_cap=0;$prj_int=0;$prj_di=0; $prj_other=0;$prj_nra=0;$prj_line_tot=0;
					$prj_stamp_fee=0;$prj_legal_fees=0;$prj_draft_fees=0;$prj_plan_copy_fees=0;$prj_pr_fees=0;
					$prj_cap_nep=$prj_cap_zep=$prj_cap_epb=0;
					 }$current_name=$prjraw->project_name;
					
					?>
        <tr><td><?=$prjraw->project_name?></td>
        <td><a href="javascript:load_lotinquary('<?=$prjraw->lot_id?>','<?=$prjraw->pri_id?>')" ><?=$prjraw->lot_number?></a></td>
        <td><?=$prjraw->first_name?> <?=$prjraw->last_name?></td>
        <td><?=$prjraw->rct_no?></td>
         <td><?=$prjraw->income_date?></td>
          <td><?=$prjraw->entry_date?></td>
         <!--  <td align="right"><?=number_format($nra,2)?></td> -->
        <td align="right"><?=number_format($adv,2)?></td>
         <td align="right"><?=number_format($cap_nep,2)?></td>
           <td align="right"><?=number_format($cap_zep,2)?></td>
             <td align="right"><?=number_format($cap_epb,2)?></td>
          <td align="right"><?=number_format($int,2)?></td>
           <td align="right"><?=number_format($di,2)?></td>
            <td align="right"><?=number_format($stamp_fee,2)?></td>
            <td align="right"><?=number_format($legal_fees,2)?></td>
            <td align="right"><?=number_format($draft_fees,2)?></td>
            <td align="right"><?=number_format($plan_copy_fees,2)?></td>
            <td align="right"><?=number_format($pr_fees,2)?></td>

              <td align="right"><?=number_format($line_tot,2)?></td>
            <td>
            
            
           <?
		   $prj_nra= $prj_nra+ $nra;
		    $prj_adv= $prj_adv+ $adv;
		   $prj_cap_zep=$prj_cap_zep+ $cap_zep;
		    $prj_cap_nep=$prj_cap_nep+ $cap_nep;
			 $prj_cap_epb=$prj_cap_epb+ $cap_epb;
		   $prj_int=$prj_int+ $int;
		   $prj_di=$prj_di+ $di;
		    $prj_stamp_fee=$prj_stamp_fee+ $stamp_fee;
		     $prj_legal_fees=$prj_legal_fees+ $legal_fees;
		      $prj_draft_fees=$prj_draft_fees+ $draft_fees;
		       $prj_plan_copy_fees=$prj_plan_copy_fees+ $plan_copy_fees;
		        $prj_pr_fees=$prj_pr_fees+ $pr_fees;
			 $prj_line_tot=$prj_line_tot+ $line_tot;
			
			 $full_nra= $full_nra+ $nra;
			 $full_adv= $full_adv+ $adv;
		   $full_cap_zep=$full_cap_zep+ $cap_zep;
		    $full_cap_nep=$full_cap_nep+ $cap_nep;
			 $full_cap_epb=$full_cap_epb+ $cap_epb;
		   $full_int=$full_int+ $int;
		   $full_di=$full_di+ $di;
		    $full_stamp_fee=$full_stamp_fee+ $stamp_fee;
		    $full_legal_fees=$full_legal_fees+ $legal_fees;
		    $full_draft_fees=$full_draft_fees+ $draft_fees;
		    $full_plan_copy_fees=$full_plan_copy_fees+ $plan_copy_fees;
		    $full_pr_fees=$full_pr_fees+ $pr_fees;
			 $full_line_tot=$full_line_tot+ $line_tot;
		   
		   
	   }}?>
        <tr class="info" style="font-weight:bold"><td><?=$current_name?> Total</td><td></td><td></td><td></td><td></td><td></td>
       <!-- <td align="right"><?=number_format($prj_nra,2)?></td> -->
        <td align="right"><?=number_format($prj_adv,2)?></td>
         <td align="right"><?=number_format($prj_cap_nep,2)?></td>
          <td align="right"><?=number_format($prj_cap_zep,2)?></td>
           <td align="right"><?=number_format($prj_cap_epb,2)?></td>
          <td align="right"><?=number_format($prj_int,2)?></td>
          <td align="right"><?=number_format($prj_di,2)?></td>
          <td align="right"><?=number_format($prj_stamp_fee,2)?></td>
            <td align="right"><?=number_format($prj_legal_fees,2)?></td>
            <td align="right"><?=number_format($prj_draft_fees,2)?></td>
            <td align="right"><?=number_format($prj_plan_copy_fees,2)?></td>
            <td align="right"><?=number_format($prj_pr_fees,2)?></td>
           <td  align="right"><?=number_format($prj_line_tot,2)?></td>
        </tr>
       <tr class="active" style="font-weight:bold"><td></td><td></td><td></td><td></td><td></td><td></td>
      <!--  <td align="right"><?=number_format($full_nra,2)?></td> -->
        <td align="right"><?=number_format($full_adv,2)?></td>
         <td align="right"><?=number_format($full_cap_nep,2)?></td>
         <td align="right"><?=number_format($full_cap_zep,2)?></td>
         <td align="right"><?=number_format($full_cap_epb,2)?></td><!-- Ticket No:2520 Updated By Madushan 2021.04.20-->
          <td align="right"><?=number_format($full_int,2)?></td>
          <td align="right"><?=number_format($full_di,2)?></td>
         <td align="right"><?=number_format($full_stamp_fee,2)?></td>
            <td align="right"><?=number_format($full_legal_fees,2)?></td>
            <td align="right"><?=number_format($full_draft_fees,2)?></td>
            <td align="right"><?=number_format($full_plan_copy_fees,2)?></td>
            <td align="right"><?=number_format($full_pr_fees,2)?></td>
          <td  align="right"><?=number_format($full_line_tot,2)?></td>
        </tr>
         </tbody></table></div></div>
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
  tableToExcel('table', 'Collection Details Report', 'collection_details_report_<?=$fromdate?>.xls');
 });
</script>