
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){  
      $('#create_excel').click(function(){ 
	  		var date =  document.getElementById('rptdate').value;
           $(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Collection Report " +date,
					filename: "Collection_" + date + ".xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
           
      });  
 });

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
 
   $heading2=' Collection Details Report from '.$fromdate.' to '.$todate;

 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">     
       <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
      
       
       <input type="hidden" id="rptdate" value="<?=$todate?>">
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
      <div class="tableFixHead">               
      <table class="table table-bordered table2excel">
      <thead><tr class="success"><th >Project Name</th>
        <th > Down Payment</th><th >NEP</th><th >ZEP</th><th >EPB</th>
      <th >Delay Interest</th><th >Other Charges</th><th >Total</th>
        </tr>
        </tr>
       </thead>
       <tbody>
       
    <? 
	$current_name='';
	$prj_adv=0;$prj_cap_nep=$prj_cap_zep=$prj_cap_epb=0;$prj_int=0;$prj_di=0; $prj_other=0;$prj_nra=0;$prj_line_tot=0;
	$full_adv=0;$full_cap_nep=$full_cap_zep=$full_cap_epb=0;$full_int=0;$full_di=0; $full_other=0;$full_nra=0;$full_line_tot=0;
	$adv=0;$cap=0;$int=0;$di=0; $other=0;$nra=0;$line_tot=0;
	if($dataset){ 
		
		foreach($dataset as $prjraw){
			$adv=0;$cap=0;$int=0;$di=0; $other=0;$nra=0;$cap_nep=0;$cap_zep=0;$cap_epb=0; $intid=0;
			if($prjraw->income_type=='Advance Payment')
			{
				 $intid=get_first_advance($prjraw->temp_code);// this function is in reaccount_helper
				if($intid==$prjraw->id)
				$nra=$prjraw->pay_amount;
				else
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
			if($prjraw->income_type!='Advance Payment' & $prjraw->income_type!='Rental Payment' & $prjraw->income_type!='EP Settlement')
			 $other=$prjraw->amount;
			$line_tot=$adv+$cap_epb+$cap_nep+$cap_zep+$int+$di+$other+$nra;
			  if($current_name!='' & $current_name!=$prjraw->project_name){?>
			
			 <tr ><td><?=$current_name?> Total</td>
     <!--  <td align="right">< ?=number_format($prj_nra,2)?></td>
     -->   <td align="right"><?=number_format($prj_adv+$prj_nra,2)?></td>
           <td align="right"><?=number_format($prj_cap_nep+$prj_int,2)?></td>
          <td align="right"><?=number_format($prj_cap_zep,2)?></td>
           <td align="right"><?=number_format($prj_cap_epb,2)?></td>
    <!--   <td align="right">< ?=number_format($prj_int,2)?></td>
    -->      <td align="right"><?=number_format($prj_di,2)?></td>
          <td align="right"><?=number_format($prj_other,2)?></td>
          <td  align="right"><?=number_format($prj_line_tot,2)?></td>
        </tr>
					<? $prj_adv=0;$prj_cap=0;$prj_int=0;$prj_di=0; $prj_other=0;$prj_nra=0;$prj_line_tot=0;
					$prj_cap_nep=$prj_cap_zep=$prj_cap_epb=0;
					 }$current_name=$prjraw->project_name;
					
					?>
       
            
            
           <?
		   $prj_nra= $prj_nra+ $nra;
		    $prj_adv= $prj_adv+ $adv;
		   $prj_cap_zep=$prj_cap_zep+ $cap_zep;
		    $prj_cap_nep=$prj_cap_nep+ $cap_nep;
			 $prj_cap_epb=$prj_cap_epb+ $cap_epb;
		   $prj_int=$prj_int+ $int;
		   $prj_di=$prj_di+ $di;
		    $prj_other=$prj_other+ $other;
			 $prj_line_tot=$prj_line_tot+ $line_tot;
			
			 $full_nra= $full_nra+ $nra;
			 $full_adv= $full_adv+ $adv;
		   $full_cap_zep=$full_cap_zep+ $cap_zep;
		    $full_cap_nep=$full_cap_nep+ $cap_nep;
			 $full_cap_epb=$full_cap_epb+ $cap_epb;
		   $full_int=$full_int+ $int;
		   $full_di=$full_di+ $di;
		    $full_other=$full_other+ $other;
			 $full_line_tot=$full_line_tot+ $line_tot;
		   
		   
	   }}?>
        <tr><td><?=$current_name?> Total</td>
        <!--  <td align="right">< ?=number_format($prj_nra,2)?></td>
     -->   <td align="right"><?=number_format($prj_adv+$prj_nra,2)?></td>
           <td align="right"><?=number_format($prj_cap_nep+$prj_int,2)?></td>
          <td align="right"><?=number_format($prj_cap_zep,2)?></td>
           <td align="right"><?=number_format($prj_cap_epb,2)?></td>
    <!--   <td align="right">< ?=number_format($prj_int,2)?></td>
    -->      <td align="right"><?=number_format($prj_di,2)?></td>
          <td align="right"><?=number_format($prj_other,2)?></td>
          <td  align="right"><?=number_format($prj_line_tot,2)?></td>
        </tr>
       <tr class="active" style="font-weight:bold"><td></td>
       <td align="right"><?=number_format($full_nra,2)?></td>
   <!--     <td align="right"><?=number_format($full_adv+$full_nra,2)?></td>-->
         <td align="right"><?=number_format($full_cap_nep+$full_int,2)?></td>
         <td align="right"><?=number_format($full_cap_zep,2)?></td>
         <td align="right"><?=number_format($full_cap_epb,2)?></td>
         <!-- <td align="right"><?=number_format($full_int,2)?></td>-->
          <td align="right"><?=number_format($full_di,2)?></td>
          <td align="right"><?=number_format($full_other,2)?></td>
          <td  align="right"><?=number_format($full_line_tot,2)?></td>
        </tr>
         </tbody></table></div></div>
    </div> 
    
</div>