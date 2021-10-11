<script type="text/javascript">

function format_val(obj)
{
	a=obj.value;
	a=a.replace(/\,/g,'')
	obj.value=parseFloat(a).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
function call_staff(runid,projecid)
{
	
		// var vendor_no = src.value;
//alert(runid);
        
	
					$('#popupform').delay(1).fadeIn(600);a
				//	alert("<?=base_url()?>hm/commission/get_commision_staff/"+runid+"/"+projecid);
					$( "#popupform" ).load( "<?=base_url()?>hm/commission/get_commision_staff/"+runid+"/"+projecid );
			
}
function expoet_excel(month,year)
{
		
		
				window.open( "<?=base_url()?>hm/commission/commission_details_excel/"+month+'/'+year);
}
function expoet_excel2(month,year)
{
		
		
				window.open( "<?=base_url()?>hm/commission/commission_details_staff_excel/"+month+'/'+year);
}
</script>                
<br /><br />
 <div class="form-title">
								<h4>Commission Detail Report<span style="float:right"> <a href="javascript:expoet_excel('<?=$month?>','<?=$year?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
						</div>
 <div class="table-responsive bs-example widget-shadow"  >
   <table class="table table-bordered"> <thead> <tr> <th>Project Name</th> <th>Lot Id</th><th>Perch Price</th><th>Discount</th><th>Block Price</th>
    <th>Sold Date</th> <th>Finalized Date</th> <th>Finalized Type</th><th>Commission</th></tr> </thead>
                      <? $prj_tot=0;$prjid='';$tot=0;$ids=''; if($commisiondata){$c=0;
                          foreach($commisiondata as $row){
							  if($prjid!='' & $prjid!=$row->project_name){
							  ?>
                              <tr class="warning"> 
                        <th scope="row" ><?=$prjid?> Total &nbsp; &nbsp; &nbsp;</th><td colspan="7">
                      
 <a  href="javascript:call_staff('<?=$rundata->id?>','<?=$ids?>')" title="Confirm"><i class="fa fa-users nav_icon icon_blue"></i><i class="fa fa-edit nav_icon icon_blue"></i></a>
                       
                        </td>
                       
                            <td  align="right"><strong><?=number_format(trim($prj_tot),2) ?></strong> </td>
                         </tr> 
                              <? $prj_tot=0; }
							  $prjid=$row->project_name;
							 $prj_tot=$prj_tot+$row->commission;
							 $tot=$tot+$row->commission;
							 $ids=$row->project_id;
							  ?>
                          
                      
                        <tbody> <tr > 
                        <td scope="row"><?=$row->project_name?></td> 
                        <td><?=$row->lot_number ?> </td>
                        <td align="right"><?=number_format(trim($row->price_perch),2) ?> </td>
                        <td  align="right"><?=number_format(trim($row->discount),2) ?> </td>
                         <td  align="right"><?=number_format(trim($row->discounted_price),2) ?> </td>
                        <td align="right"><?=$row->res_date?></td>
                         <td align="right"><?=$row->finalizedate?></td>
                         <td align="right"><?=number_format(trim($row->persentage),2) ?></td>
                            <td  align="right"><?=number_format(trim($row->commission),2) ?> </td>
                         </tr> 
                        
                                <? }} ?>
                         
                     <tr class="warning"> 
                        <th scope="row" ><?=$prjid?> Total</td>
                       <td colspan="7">
                      
 <a  href="javascript:call_staff('<?=$rundata->id?>','<?=$ids?>')" title="Confirm"><i class="fa fa-users nav_icon icon_blue"></i><i class="fa fa-edit nav_icon icon_blue"></i></a>
                       
                        </td>
                            <td  align="right"><strong><?=number_format(trim($prj_tot),2) ?></strong> </td>
                         </tr> 
                          <tr class="active"> 
                        <th scope="row" colspan="8"> Total</td>
                       
                            <td  align="right"><strong><?=number_format(trim($tot),2) ?></strong> </td>
                         </tr> 
                     </tbody></table></div>
                      
                   <div class="form-title">
								<h4>Commission Staff Detail Report <span style="float:right"> <a href="javascript:expoet_excel2('<?=$month?>','<?=$year?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span> </h4>
						</div>
 <div class="table-responsive bs-example widget-shadow"  >
   <table class="table table-bordered"> <thead> <tr> <th>Project Name</th> 
   <? $staftot=NULL; if($staffsummery){foreach($staffsummery as $stfraw){$staftot[$stfraw->emp_id]=0;
	   ?>
    <th><?=$stfraw->surname?></th>
   <? }}?>
     <th class="active">Project Total</th>
 </tr> </thead>
                      <? $prj_tot=0;$prjid='';$tot=0;$ids=''; if($projectsummery){$c=0;
                          foreach($projectsummery as $row){
							  if($prjid!='' & $prjid!=$row->project_name){
							  ?>
                              
                              <? $prj_tot=0; }
							 
							  ?>
                          
                      
                        <tbody> <tr > 
                        <td scope="row"><?=$row->project_name?></td> 
                         <? if($staffsummery){foreach($staffsummery as $stfraw){ $amt=0;
							 if($staffdata[$stfraw->emp_id][$row->project_id])
							 {
								 $amt=$staffdata[$stfraw->emp_id][$row->project_id]->tot;
							 }
							 $staftot[$stfraw->emp_id]=$staftot[$stfraw->emp_id]+$amt;
							 ?>
                        <td align="right"><?=number_format($amt,2) ?> </td>
                               <? }}?>
                                <td class="active" align="right" style=" font-weight:bold"><?=number_format($row->current_comm,2) ?> </td>
                         </tr> 
                        
                                <? }} ?>
                         
                     <tr class="warning"  style="font-weight:bold"> 
                        <th scope="row" ><?=$prjid?> Total</td>
                       
                             <? $staftot=0; if($staffsummery){foreach($staffsummery as $stfraw){
								  $staftot=$staftot+$stfraw->month_add;
	   ?>
    <td align="right"><?=number_format($stfraw->month_add,2)?></th>
   <? }}?><td align="right"><?=number_format($staftot,2)?></th>
                         </tr> 
                          <tr class="info"  style="font-weight:bold"> 
                        <th scope="row"> This Month Deductions</td>
                       
                          <? $staftot=0; if($staffsummery){foreach($staffsummery as $stfraw){
							  $staftot=$staftot+$stfraw->month_deduct
;	   ?>
    <td align="right"><?=number_format($stfraw->month_deduct,2)?></th>
   <? }}?> <td align="right"><?=number_format($staftot,2)?></th>
                         </tr> 
                           <tr class="danger"  style="font-weight:bold"> 
                        <th scope="row"> Previous Month Deductions</td>
                       
                          <? $staftot=0; if($staffsummery){foreach($staffsummery as $stfraw){
							    $staftot=$staftot+$stfraw->prev_deduct;
	   ?>
    <td align="right"><?=number_format($stfraw->prev_deduct,2)?></th>
   <? }}?><td align="right"><?=number_format($staftot,2)?></th>
                         </tr> 
                             <tr class="active"  style="font-weight:bold"> 
                        <th scope="row"> Total</td>
                       
                          <? $staftot=0; if($staffsummery){foreach($staffsummery as $stfraw){
							  $staftot=$staftot+$stfraw->amount;
	   ?>
    <td align="right"><?=number_format($stfraw->amount ,2)?></th>
   <? }}?><td align="right"><?=number_format($staftot,2)?></th>
                         </tr> 
                     </tbody></table></div>