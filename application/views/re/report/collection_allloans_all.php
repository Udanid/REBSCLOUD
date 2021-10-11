
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
  $heading2=' All reservation  Payment as at '.$reportdata;

 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">   <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       
       
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow">
     <input type="hidden" id="rptdate" value="<?=$todate?>">
      <div class="tableFixHead">                 
      <table  class="table table-bordered table2excel"><thead><tr class="success">
      <th >Reservation Code</th><th >Reservation Date</th>
      <th >Project Name</th><th  >Lot Number</th>
      <th  >Scheme</th>
      <th  >Loan Code</th>
      <th > Land Value </th>
      <th >Total Paid</th>
      <th >Balance</th>
      <th>%</th>
    <th >Total Due</th> 
     <th >Current Due</th> <th >Payment</th><th>Aging</th><th># days since Last Payment</th><th>Customer Name</th><th>Contact Number</th>
      <th>ID Number</th> <th>Sales Person</th>
        </tr>
        </tr>
       </thead>
       
    <? 
	
	
	if($prjlist){$fullprjlandval=0;$fullprjprvcap=0;$fullprjbal=0; $fullprjpayment=0; $fullprjlastbal=0;$fulldue=0;$fullcrdue=0;
	$collectionarr=NULL;	foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjlandval=0;$prjprvcap=0;$prjbal=0; $prjpayment=0; $prjlastbal=0; $prjdue=0;$prjcrdue=0;
			$c=0; 
			?>
        
        <?  if($reservation[$prjraw->prj_id]){
			foreach($reservation[$prjraw->prj_id] as $raw){
			
			$flag=true; 
				if($raw->res_status=='REPROCESS')
				$flag=false;
				if($raw->loan_code)
						$flag=false;
				if($thispayment[$raw->res_code]>0)
				$flag=true;
				$collectionarr[$raw->res_code]=0;
				if($raw->loan_code)
				{
					$flag=false;
						$last_bal=0;
						$collectionarr[$raw->res_code]=$thispayment[$raw->res_code];
				}
					if($raw->discounted_price!=$prevpayment[$raw->res_code]){
						if($flag){
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjprvcap=$prjprvcap+$prevpayment[$raw->res_code]+$thispayment[$raw->res_code];
						$prjbal=$prjbal+($raw->discounted_price-$prevpayment[$raw->res_code]);
						$prjpayment=$prjpayment+$thispayment[$raw->res_code];
						$last_bal=$raw->discounted_price-$prevpayment[$raw->res_code]-$thispayment[$raw->res_code];
						
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
        <tr  class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
        <td><?=$raw->res_code?></td>
        <td><?=$raw->res_date?></td>
        <td><?=$prjraw->project_name?></td>
        <td><a href="javascript:load_lotinquary('<?=$raw->lot_id?>','<?=$raw->prj_id?>')" ><?=$raw->lot_number?></a></td>
            <td align="right"><?=$raw->pay_type?></td>
              <td align="right"><? if($raw->res_status=='REPROCESS') echo "CANCELLED";?></td>
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($prevpayment[$raw->res_code]+$thispayment[$raw->res_code],2)?></td>
          <td align="right"><?=number_format($last_bal,2)?></td>
            <td align="right"><?=number_format($openpresentage,2)?></td>
               <td align="right">-</td>
              <td align="right">-</td>
           <td align="right"><?=number_format($thispayment[$raw->res_code],2)?></td>
                <td align="right"><?=$aging?></td>
            <td align="right"><?=$datelast?></td> 
     
             <td align="right"><?=$raw->first_name?> <?=$raw->last_name?></td>
                <td align="right"><?=$raw->mobile?></td>
                <td><?=$raw->id_number?></td>
                <td><?=get_user_fullname_id($raw->sales_person)?></td>
                
        </tr>
        <? }}} }?><?  if($zepreservation[$prjraw->prj_id]){
			foreach($zepreservation[$prjraw->prj_id] as $raw){
				//if($currentlist[$raw->res_code]){
					$zprvpayment=0;$zthispayment=0;$intpayment=0;
					if($zepprevpayment[$raw->loan_code])
					$zprvpayment=$zepprevpayment[$raw->loan_code]->sum_cap;
					if($zepthispayment[$raw->loan_code])
					{
					$zthispayment=$zepthispayment[$raw->loan_code]->sum_cap;
					$intpayment=$zepthispayment[$raw->loan_code]->sum_int;
					}
					
					$zthispayment=$zthispayment;//+$collectionarr[$raw->res_code];
					$fullpayment=$raw->down_payment+$zprvpayment;
					
					$flag=true; 
				if($raw->loan_status=='SETTLED')
				$flag=false;
				if($zthispayment>0)
				$flag=true;
					if($raw->discounted_price!=$fullpayment){
						if($flag){
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjprvcap=$prjprvcap+$fullpayment+$zthispayment;
						$prjbal=$prjbal+($raw->discounted_price-$fullpayment);
						$prjpayment=$prjpayment+$zthispayment+$collectionarr[$raw->res_code]+$intpayment;
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
						if($lastpaydate==0)
						{
							$lastpaydate=get_last_payment_date($raw->res_code);
						}
						 $date1=date_create($lastpaydate);
						 $date2=date_create($todate);
						  $diff=date_diff($date1,$date2);
						 $datelast=$diff->format("%a ");
						
				?>
        <tr  class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"><td><?=$raw->res_code?></td><td><?=$raw->res_date?></td>
        <td><?=$prjraw->project_name?></td>
        <td><?=$raw->lot_number?></td>
           <td><?=$raw->loan_type?></td>
        <td><?=$raw->period?>M - <a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->unique_code?></a>
        
        
        </td>
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($fullpayment+$zthispayment,2)?></td>
            <td align="right"><?=number_format($last_bal,2)?></td>
           <td align="right"><?=number_format($openpresentage,2)?></td>
              <td align="right"><?=number_format($due,2)?></td>
              <td align="right"><?=number_format($crdue,2)?></td>
           <td align="right"><?=number_format($zthispayment+$collectionarr[$raw->res_code]+$intpayment,2)?></td>
         
               <td align="right"><?=$aging?></td>
            <td align="right"><?=$datelast?></td>
      
              <td align="right"><?=$raw->first_name?> <?=$raw->last_name?></td>
                <td align="right"><?=$raw->mobile?><a href="javascript:add_followup_detalis('<?=$raw->loan_code?>','<?=$reportdata?>')"><i class="fa fa-phone nav_icon icon_red "></i></a></td>
                   <td><?=$raw->id_number?></td>
                <td><?=get_user_fullname_id($raw->sales_person)?></td>
          
        </tr>
        <? }}} }?>
        <? if($prjlandval>0){?>
         <tr class="active" style="font-weight:bold"><td></td><td></td>
         <td> <?=$prjraw->project_name?>  Total</td><td></td><td></td><td></td>
        <td align="right"><?=number_format($prjlandval,2)?></td>
         <td align="right"><?=number_format($prjprvcap,2)?></td>
         <td align="right"><?=number_format($prjlastbal,2)?></td>
         <td></td>
          <td align="right"><?=number_format($prjdue,2)?></td>
            <td align="right"><?=number_format($prjcrdue,2)?></td>
          <td align="right"><?=number_format($prjpayment,2)?></td>
          
           
          <td></td> <td></td> <td></td> <td></td><td></td><td></td>
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
       <tr class="active" style="font-weight:bold"><td></td><td></td><td></td><td></td><td></td><td></td>
        <td align="right"><?=number_format($fullprjlandval,2)?></td>
         <td align="right"><?=number_format($fullprjprvcap,2)?></td>
           <td align="right"><?=number_format($fullprjlastbal,2)?></td>
           <td></td>
      
           <td align="right"><?=number_format($fulldue,2)?></td>
             <td align="right"><?=number_format($fullcrdue,2)?></td>
          <td align="right"><?=number_format($fullprjpayment,2)?></td>
        
            
          <td></td> <td></td> <td></td> <td></td><td></td><td></td>
        </tr>
         </table></div></div>
    </div> 
    
</div>