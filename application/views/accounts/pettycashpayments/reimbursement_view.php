<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){  
      $('#create_excel').click(function(){ 
	  	;
           $(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Reimbersment Report ",
					filename: "reimbersment_report.xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
           
      });  
 });
</script>
<style type="text/css">
.denomiform_sm {
	 border: 1px solid #ccc;
	 text-align:right;
	  padding: 2px 2px;
	width:30px;
	height:20px;
	padding:0;
	}
	.denomiform_md {
		 border: 1px solid #ccc;
	 text-align:right;
	  padding: 2px 2px;
	   background:#e8e3de;
	width:60px;
	height:20px;
	padding:0;
	}
</style>
<? 
?>
<h4>Pettycash Reimbersment - <?=get_ledger_name($rptdata->ledger_id)?><span  style="float:right; color:#FFF" ><a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>&nbsp;&nbsp;<a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>

<div  style=" width:90% ; margin-left:5%">
 <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
             
     		 <table class="table table-bordered table2excel">
      		 <tr>  <th >IOU No</th>  <th >Cash Advance No</th> <th >Requested Date</th> <th>Settlement Date</th> <th>Branch</th> <th >Employee Name</th> <th>Project</th><th>Payment Added By</th> <th>Confirmed By</th><th>Description </th><th>Actual Amount</th></tr>
     	  <? $fulltot=0;?>
            <?  if($settledlist){
			foreach($settledlist as $raw){
				?>
         		<tr><td><?=$raw->serial_number?></td><td><?=$raw->adv_code?></td><td><?=$raw->apply_date;?></td><td><?=$raw->settled_date?></td>
          		<td align="right"><?=get_branch_name($raw->branch)?></td>
         		<td align="right"><?=$raw->initial?> <?=$raw->surname?></td>
          		  <td align="right"><?=$raw->project_name?></td>
                <td><?=get_user_fullname_id($raw->paid_by)?></td>
                <td><?=get_user_fullname_id($raw->check_officerid)?></td>
             	 <td align="right"><?=$raw->description?></td>
             	 <td align="right"><?=number_format($raw->amount,2)?></td>
             	 
           		</tr>
		<? 	 $fulltot= $fulltot+$raw->amount;
		}}?>
   		   <tr class="active" style="font-weight:bold">
      	   <td align="right" >Settelment Total</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
       	   <td align="right"><?=number_format($fulltot,2)?></td>
            
            </tr>
         
         <tr><th>PV No</th> <th> Date</th> <th>Supplier Name</th><th>Branch</th><th>Payee</th>   <th>Description</th><th>Payment Added By</th> <th>Confirmed By</th><th>Paid Amount</th></tr> 
                      <?  $directot=0; if($paymentlist){$c =0;
                          foreach($paymentlist as $row){
							  $fulltot=$fulltot+$row->pay_amount;
							   $directot= $directot+$row->pay_amount;;
							  ?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->serial_number?></th>
                        <th scope="row"><?=$row->paid_date?></th> <td><?=$row->initial?> <?=$row->surname?></td>
                          <td><?=get_officer_branch($raw->officer_id);?></td>
                            
                          <td><?=$row->sup_name ?></td>
                             <td><?=$row->note ?></td>
                             <td><?=get_user_fullname_id($row->paid_by)?></td>
                             <td><?=get_user_fullname_id($row->confirm_by)?></td>
                               
                                 <td><?=number_format($row->pay_amount,2) ?></td>
                               </tr>
                               <? }}?>
                               <tr class="active" style="font-weight:bold">
      	  					 <td align="right" >Payment Total</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
       	  					 <td align="right"><?=number_format($directot,2)?></td>
           					
           						 </tr>
                                 <tr class="active" style="font-weight:bold">
      	  					 <td align="right" >Total Reimbursement </td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
       	  					 <td align="right"><?=number_format($fulltot,2)?></td>
           					
           						 </tr>
                                </tbody></table>
                                <input  type="hidden" name='reim_amount' id="reim_amount" value="<?=$fulltot?>" />
         
         </div>
 
 

  </div>                 