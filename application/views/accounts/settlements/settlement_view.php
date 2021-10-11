<script type="text/javascript">

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
<h4>Pettycash Settlment Details <span  style="float:right; color:#FFF" ><!--<a href="javascript:load_printscrean1('')"><i class="fa fa-print nav_icon"></i></a>-->&nbsp;&nbsp;<a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>

<div  style=" width:90% ; margin-left:5%">
 <table class="table">
 <tr>
 <th width="15%">Advance Number</th><td width="2%">:</td><td><?=$settledata->adv_code?></td>
 <th width="15%">Advance Date</th><td width="2%">:</td><td><?=$settledata->apply_date?></td>
 </tr>
  <tr>
 <th width="15%">Officer Name</th><td width="2%">:</td><td><?=$settledata->initial?> <?=$settledata->surname?></td>
 <th width="15%">Advanced Amount</th><td width="2%">:</td><td><?=number_format($settledata->amount,2)?></td>
 </tr>
 <tr>
 <th width="15%">Settled Date</th><td width="2%">:</td><td> <?=$settledata->settled_date?></td>
 <th width="15%">Settled Amount</th><td width="2%">:</td><td><?=number_format($settledata->settled_amount,2)?></td>
 </tr>
 
 </table>
 
 <? if($list){?>
 
 <table class="table table-bordered" >
 <tr><th>Ledger Account</th><th>Project Name</th><th>Task Name</th><th>Discription </th><th>Amount </th></tr>
 
 <? $tot=0; foreach($list as $raw){$tot=$tot+$raw->settleamount;?>
 <tr>
 <td><?=get_dr_account_name($raw->settle_entry_id)?></td>
  <td><?=$raw->project_name?></td>
   <td><?=$raw->task_name?></td>
    <td><?=$raw->note?></td>
     <td align="right"><?=number_format($raw->settleamount,2)?></td>
 
 </tr>
 
 <? }?>
 <tr style="font-weight:bold">
 <td>Total</td>
  <td></td>
   <td></td>
    <td></td>
     <td align="right"><?=number_format($settledata->settled_amount,2)?></td>
 
 </tr>
 </table>
 
 
 
 <? }?>
 
  <?
                                          
if($attachments){
?>
 <div class="form-title">
    <h5>Attachments :</h5>
</div>
<?	foreach ($attachments as $data){
?>
	<span >
		<a href="<?=base_url()?>uploads/pettycash/<?=$settledata->file_folder.'/'.$data->file_name?>"  target="_blank">
		
		<?	$file_parts = pathinfo($data->file_name);

			$file_parts['extension'];
			$cool_extensions = Array('jpg','png','gif','jpeg');
			
			if (in_array($file_parts['extension'], $cool_extensions)){
				echo '&nbsp;&nbsp;&nbsp;<img src="'.base_url().'uploads/pettycash/'.$settledata->file_folder.'/thumbnail/'.$data->file_name.'">';
			} else {
				echo '&nbsp;&nbsp;&nbsp;'.$data->file_name;
			}
		?>
                                                    
        </a>
    </span>
	<script>
     /*   //this will enable blueimp.Gallery
        document.getElementById('image<?=$settledata->file_folder.$data->id?>').onclick = function (event) {
            event = event || window.event;
            var target = event.target || event.srcElement,
            link = target.src ? target.parentNode : target,
            options = {index: link, event: event},
            links = this.getElementsByTagName('a');
            blueimp.Gallery(links, options);
        };*/
    </script>	
<?
		}
	}
?>
<br /><br /><br />
  </div>                 