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
function load_printscrean1(branch,type,month)
{
			window.open( "<?=base_url()?>re/report_excel/get_collection_all/"+branch+'/'+type+'/'+month);
	
}
function load_printscrean2(branch,type,from,to)
{
			window.open( "<?=base_url()?>re/report_excel/date_get_collection_all/"+branch+'/'+type+'/'+from+'/'+to);
	
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>hm/eploan/get_loanfulldata_popup/"+id );
			
}
</script>
 <?
 if($month!=''){
  $heading2=' EP Collection as at '.$reportdata;
  $monthname=date('F', mktime(0, 0, 0, intval($month), 10));
 }
 else{
   $heading2=' EP Collection as at '.$reportdata;
    $monthname=date('F', mktime(0, 0, 0, intval(date('m')), 10));
 }
 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:300px; overflow:scroll" >
         <input type="hidden" id="rptdate" value="<?=$todate?>">
               
      <table  class="table table-bordered table2excel"><tr class="success"><th >Reservation Code</th>
      <th >Reservation Date</th><th >Project Name</th><th  >Lot Number</th><th  >scheme</th><th  >loan Code</th>
      <th > Land Value </th><th width="50">Paid Amounts as at <?=$sartdate?></th><th >Balance %</th><th width="50" >Balance to be Received as at <?=$sartdate?> </th><th>Aging</th><th># days since Last Payment</th>
     <th >Toal Due</th> <th >Current Due</th> <th >Payment Capital</th><th >Payment Int</th><th >Balance</th><th>Paid%</th><th>Customer Name</th><th>Contact Number</th>     <th>ID Number</th> <th>Sales Person</th>
        </tr>
        </tr>
       
       
       
    <? 
	
	
	if($prjlist){$fprjrental=0;$fprjlandval=0;$fprjdownpay=0;$fprjcrdue=0;
			$fprjloanval=0;$fprjint=0; $fprjagreed=0; 
			$fprjopbalint=0;
			$fprjopbalcap=0;
			$fprjopbaltot=0;
			$fprjpayint=0;
			$fprjpaycap=0;
			$fprjpaydi=0;
			$fprjpayrent=0;
			$fprjclbalint=0;
			$fprjclbalcap=0;
			$fprjclbaltot=0;
		foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjrental=0;$prjlandval=0;$prjdownpay=0;
			$prjloanval=0;$prjint=0; $prjagreed=0; 
			$prjopbalint=0;
			$prjopbalcap=0;
			$prjopbaltot=0;
			$prjpayint=0;
			$prjpaycap=0;
			$prjpaydi=0;
			$prjpayrent=0;
			$prjclbalint=0;
			$prjclbalcap=0;
			$prjclbaltot=0;
			$prjcrdue=0;
			
			?>
       
        <?  if($reservation[$prjraw->prj_id]){
			foreach($reservation[$prjraw->prj_id] as $raw){
					$monthtotcoll=0; $settlecap=0; $settleint=0;
				if($thispayment[$raw->loan_code])
					$monthtotcoll=$thispayment[$raw->loan_code]->sum_di+$thispayment[$raw->loan_code]->sum_cap+$thispayment[$raw->loan_code]->sum_int;
					if($settlepayment[$raw->loan_code])
					{$monthtotcoll=$monthtotcoll+$settlepayment[$raw->loan_code]->sum_cap+$settlepayment[$raw->loan_code]->sum_int;
					$settlecap=$settlepayment[$raw->loan_code]->sum_cap;
					$settleint=$settlepayment[$raw->loan_code]->sum_int;
					}
					$rptstatus=true;
					if($raw->loan_status=='SETTLED')
					{
						if($monthtotcoll>0)
						$rptstatus=true;
						else
						$rptstatus=false;
					}
					if($rptstatus){	
						
							
		$opbalcap=$raw->loan_amount-$prevpayment[$raw->loan_code]->sum_cap;
		$opbalint=$inttots[$raw->loan_code]-$prevpayment[$raw->loan_code]->sum_int;
		$opbal=$opbalcap+$opbalint;
		$clbalcap=$opbalcap-$thispayment[$raw->loan_code]->sum_cap-$settlecap;
		$clbalint=$opbalint-$thispayment[$raw->loan_code]->sum_int-$settleint;
		if($raw->loan_status=='SETTLED'){
		$clbalint=0;$clbalcap=0;}
		$clbal=$clbalint+$clbalcap;
		
		
						
						 $date1=date_create($raw->res_date);
						 $date2=date_create($todate);
						 $diff=date_diff($date1,$date2);
						 $aging=$diff->format("%a ");
						
						$lastpaydate=hm_get_last_payment_date($raw->loan_code);
						 $date1=date_create($lastpaydate);
						 $date2=date_create($todate);
						  $diff=date_diff($date1,$date2);
						 $datelast=$diff->format("%a ");
		
		$fullpayment=$raw->down_payment+$prevpayment[$raw->loan_code]->sum_cap;
		$due=hm_uptodate_arrears($raw->loan_code,$sartdate);
		$alldue=hm_uptodate_arrears($raw->loan_code,$todate);
		$crdue=$alldue-$due;
		$openpresentage=(($raw->discounted_price-$fullpayment)/$raw->discounted_price)*100;
		
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjrental=$prjrental+$raw->montly_rental;
						$prjdownpay=$prjdownpay+$raw->down_payment;
						$prjloanval=$prjloanval+$raw->loan_amount;
						$prjint=$prjint+$inttots[$raw->loan_code];
						$prjagreed=$prjagreed+$raw->loan_amount+$inttots[$raw->loan_code];
						$prjopbalint=$prjopbalint+$opbalint;
						$prjopbalcap=$prjopbalcap+$fullpayment;
						$prjopbaltot=$prjopbaltot+$opbal;
						$prjpayint=$prjpayint+$thispayment[$raw->loan_code]->sum_int+$settleint;
						$prjpaycap=$prjpaycap+$thispayment[$raw->loan_code]->sum_cap+$settlecap;;
						$prjpaydi=$prjpaydi+$thispayment[$raw->loan_code]->sum_di;
						$prjpayrent=$prjpayrent+$thispayment[$raw->loan_code]->sum_int+$thispayment[$raw->loan_code]->sum_cap;
						$prjclbalint=$prjclbalint+$clbalint;
						$prjclbalcap=$prjclbalcap+$clbalcap;
						$prjclbaltot=$prjclbaltot+$due;
						$prjcrdue=$crdue+$crdue;
						
						
				?>
      <tr ><td><?=$raw->res_code?></td><td><?=$raw->res_date?></td>
      <td><?=$prjraw->project_name?> </td>
      <td><?=$raw->lot_number?></td>
       <td><?=$raw->loan_type?></td>
      <td><?=$raw->period?>M - <a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->unique_code?></a></td>
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($fullpayment,2)?></td>
           <td align="right"><?=number_format($openpresentage,2)?></td>
          <td align="right"><?=number_format($raw->discounted_price-$fullpayment,2)?></td>
           <td align="right"><?=$aging?></td>
            <td align="right"><?=$datelast?></td>
             <td align="right"><?=number_format($due,2)?></td>
               <td align="right"><?=number_format($crdue,2)?></td>
           <td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_cap+$settlecap,2)?></td>
             <td align="right"><?=number_format($thispayment[$raw->loan_code]->sum_int+$settleint,2)?></td>
            <td align="right"><?=number_format($clbalcap,2)?></td>
             <td>
            
            
            <? $presentage=round(($clbalcap-$raw->discounted_price)/$raw->discounted_price*100,2);
						     if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';?>
                              
		
                         <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
            </td>
              <td align="right"><?=$raw->first_name?> <?=$raw->last_name?></td>
                <td align="right"><?=$raw->mobile?><a href="javascript:add_followup_detalis('<?=$raw->loan_code?>','<?=$reportdata?>')"><i class="fa fa-phone nav_icon icon_red "></i></a></td>
                 <td><?=$raw->id_number?></td>
                <td><?=get_user_fullname_id($raw->sales_person)?></td>
                </tr>
        <? }}}?>
        <? if($prjrental>0){?>
         <tr class="active" style="font-weight:bold"><td> <?=$prjraw->project_name?>  Total</td><td></td><td></td><td></td><td></td><td></td>
        <td align="right"><?=number_format($prjlandval,2)?></td>
         <td align="right"><?=number_format($prjopbalcap,2)?></td><td></td>
          <td align="right"><?=number_format($prjlandval-$prjopbalcap,2)?></td><td></td><td></td>
          <td align="right"><?=number_format($prjclbaltot,2)?></td>
             <td align="right"><?=number_format($prjcrdue,2)?></td>
          <td align="right"><?=number_format($prjpaycap,2)?></td>
           <td align="right"><?=number_format($prjpayint,2)?></td>
          <td align="right"><?=number_format($prjclbalcap,2)?></td>
          <td></td><td></td>
        </tr>
        </tr>
        <? }?>
      <?
	 
						$fprjlandval=$fprjlandval+$prjlandval;
						$fprjrental=$fprjrental+$prjrental;
						$fprjdownpay=$fprjdownpay+$prjdownpay;
						$fprjloanval=$fprjloanval+$prjloanval;
						$fprjint=$fprjint+$prjint;
						$fprjagreed=$fprjagreed+$prjagreed;
						$fprjopbalint=$fprjopbalint+$prjopbalint;
						$fprjopbalcap=$fprjopbalcap+$prjopbalcap;
						$fprjopbaltot=$fprjopbaltot+$prjopbaltot;
						$fprjpayint=$fprjpayint+$prjpayint;
						$fprjpaycap=$fprjpaycap+$prjpaycap;
						$fprjpaydi=$fprjpaydi+$prjpaydi;
						$fprjpayrent=$fprjpayrent+$prjpayrent;
						$fprjclbalint=$fprjclbalint+$prjclbalint;
						$fprjclbalcap=$fprjclbalcap+$prjclbalcap;
						$fprjclbaltot=$fprjclbaltot+$prjclbaltot;
						$fprjcrdue=$fprjcrdue+$prjcrdue;
					
						
	   }}?>
        <tr class="active" style="font-weight:bold"><td></td><td></td><td></td><td></td><td></td><td></td>
        <td align="right"><?=number_format($fprjlandval,2)?></td>
         <td align="right"><?=number_format($fprjopbalcap,2)?></td><td></td>
          <td align="right"><?=number_format($fprjlandval-$fprjopbalcap,2)?></td><td></td><td></td>
           <td align="right"><?=number_format($fprjclbaltot,2)?></td>
              <td align="right"><?=number_format($fprjcrdue,2)?></td>
          <td align="right"><?=number_format($fprjpaycap,2)?></td>
            <td align="right"><?=number_format($fprjpayint,2)?></td>
          <td align="right"><?=number_format($prjclbalcap,2)?></td>
          <td></td><td></td>
        </tr></table></div>
    </div> 
    
</div>