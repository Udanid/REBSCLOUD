<script type="text/javascript">

function format_val(obj)
{
	a=obj.value;
	a=a.replace(/\,/g,'')
	obj.value=parseFloat(a).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

function  calculate_subtotal()
{
	
	var list=document.getElementById('sublist').value;
	if(list!="")
	{
			var res = list.split(",");
	
	
	
	//alert(list);
			var unselabletot=0;
			for(i=0; i< res.length-1; i++)
			{
				a=document.getElementById('amount'+res[i]).value;
				a=a.replace(/\,/g,'')
				unselabletot=parseFloat(unselabletot)+parseFloat(a);
			}
		document.getElementById('newtot').value=unselabletot;
		document.getElementById('newtot').value=parseFloat(unselabletot).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;;
		}
	
	
	
}
function submit_mysearch_data()
{
	
	 var oldtot=document.getElementById('oldtot').value;
				oldtot=oldtot.replace(/\,/g,'')
			var	newtot=document.getElementById('newtot').value;
				newtot=newtot.replace(/\,/g,'')
				
				if(parseFloat(newtot)==parseFloat(oldtot))
				{
					document.getElementById("staffcomm").submit(); 
				}
				else
				{
					 document.getElementById("checkflagmessage").innerHTML='Total Project Commissaion Values not Match'; 
					 $('#flagchertbtn').click();
				}
}
</script>        
 <h4>Staff Commission Details<span  style="float:right; color:#FFF" ><a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
 <div class="table-responsive bs-example widget-shadow"  style="max-height:400px; overflow:scroll"  >
 <form data-toggle="validator" method="post" id="staffcomm"  action="<?=base_url()?>hm/commission/staff_commission_update" enctype="multipart/form-data">
   <table class="table table-bordered" style="font-size:12px"> <thead> <tr> <th>Project Name</th> <th>Lot Id</th><th>Perch Price</th><th>Discount</th><th>Block Price</th>
    <th>Sold Date</th> <th>Finalized Date</th> <th>Finalized Type</th><th>Commission</th></tr> </thead>
                      <? $staffarr=NULL; $taskid=''; $prj_tot=0;$prjid='';$tot=0; if($commisiondata){$c=0;
                          foreach($commisiondata as $row){
							$tot=$tot+$row->commission;
							  ?>
                          
                      
                        <tbody> <tr class="info"  style="font-weight:bold" > 
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
                        <tr>
                        <? ?>
                        <td colspan="9">  <table class="table table-bordered">
                        <? if($staffdata[$row->id]){
							$counter=0;
							foreach($staffdata[$row->id] as $straw){
								$taskid=$taskid.$row->id.$straw->emp_id.',';
								 $staffarr[$counter]=$straw->emp_id; 
								 $counter++;
							?>
                        <tr><td width="70%"><?=$straw->initial?> <?=$straw->surname?></td>
                          <td align="right">
						  <input  type="text" style="text-align:right" id="amount<?=$row->id.$straw->emp_id?>"    name="amount<?=$row->id.$straw->emp_id?>"  value="<?=number_format(trim($straw->amount),2) ?>"    data-error=""  required  placeholder="Year"onchange="format_val(this),calculate_subtotal()" ></td></tr>
                        
                        <? }}?>
                      
                        
                        
                        
                        
                        </table>
                         <?   if($tpodata[$row->id]){?>
                    <table class="table table-bordered">
                        <? // echo '$tpodata[$row->id]';
					//	print_r($tpodata[$row->id]);
							$counter=0;
							foreach($tpodata[$row->id] as $tpors){
								$taskid=$taskid.$row->id.'tpo,';
								
								 $counter++;
							?>
                        <tr><td width="70%"><?=$tpors->tpo_name?> </td>
                          <td align="right">
						  <input  type="text" style="text-align:right" id="amount<?=$row->id?>tpo"    name="amount<?=$row->id?>tpo"  value="<?=number_format(trim($tpors->amount),2) ?>"    data-error=""  required  placeholder="Year"onchange="format_val(this),calculate_subtotal()" ></td></tr>
                        
                        <? }?>
                      
                        
                        
                        
                        
                        </table><? }?>
                        
                   <!--      <table class="table table-bordered"><tr>
                        <? if($staffarr){ if($allstaff){
							
							foreach($allstaff as $straw){
								if(!in_array($straw->id,$staffarr)){
								//$taskid=$taskid.$row->id.$straw->id.',';
							?>
                        <td ><?=$straw->surname?>
                        <br /> <input  type="text" style="text-align:right" class="form-control" id="amount<?=$row->id.$straw->id?>"    name="amount<?=$row->id.$straw->id?>"  value="0"    data-error=""  required  placeholder="Year"onchange="format_val(this),calculate_subtotal()" ></td>
                        
                        
                        <? }}}}?></tr>
                      
                        
                        
                        
                        
                        </table>-->
                        
                        
                        </td>
                        
                        
                        </tr>
                                <? }} ?>
                         
                    
                          <tr class="active">
                           <th scope="row" colspan="8"> New Total</td>
                       
                            <td  align="right"><strong>						  <input readonly="readonly"  type="text" class="form-control" id="newtot"    name="newtot"   style="text-align:right" value="<?=number_format(trim($tot),2) ?>"    data-error=""  required  placeholder="Year"onchange="format_val(this)" >
                             <input  type="hidden" class="form-control" id="sublist"    name="sublist"   style="text-align:right" value="<?=$taskid ?>"    data-error=""  required  placeholder="Year"onchange="format_val(this)" >
                              <input  type="hidden" class="form-control" id="projectid"    name="projectid"   style="text-align:right" value="<?=$projectid ?>"    data-error=""  required  placeholder="Year"onchange="format_val(this)" >
                              <input  type="hidden" class="form-control" id="runid"    name="runid"   style="text-align:right" value="<?=$runid ?>"    data-error=""  required  placeholder="Year"onchange="format_val(this)" >
                               <input  type="hidden" class="form-control" id="oldtot"    name="oldtot"   style="text-align:right" value="<?=$tot ?>"    data-error=""  required  placeholder="Year"onchange="format_val(this)" ></strong> </td>
                         </tr>  
                        <th scope="row" colspan="8"> Total</td>
                       
                            <td  align="right"><strong><?=number_format(trim($tot),2) ?></strong> </td>
                         </tr> 
                     </tbody></table>  <? if($rundata->status=='PENDING'){?> 
										<div class="col-md-12 has-feedback" id="paymentdateid" style="float:right">
                                         <button type="button" onclick="submit_mysearch_data()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Update Commission</button></div></form></div><? }?>
                      
                  