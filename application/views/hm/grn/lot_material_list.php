<script type="text/javascript">
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

	
</script>

<h4>Full Details of Project <strong><?=get_prjname($prjid)?></strong> meterial <strong><? $mat=get_meterials_all($matid)?><?=$mat->mat_name?> <?=$mat->mt_name?></strong><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('1')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
 	<div class="col-md-2"></div>
 	<div class="col-md-8">
 		
		 <table class="table">
		 	<thead>
		 	  <tr>
		 		<td>Lot</td>
		 		<td>Received Quantity</td>
		 		<td>Used Quantity</td>
		 		<td>Transfered Quantity</td>
		 		<td>Transfered To</td>
		 	  </tr>
		    </thead>
		    <tbody>
		    	<?
		          foreach($prjmatfull as $pmatfull){
		          
		          ?>
		    	<tr>
		    		<td>Lot <?=get_unitname($pmatfull->mat_id)?></td>
		    		<td><?=$pmatfull->rcv_qty?></td>
		    		<td><?=$pmatfull->ussed_qty?></td>
		    		<td><?=$pmatfull->trans_qty?></td>
		    		<td><?=get_prjname($pmatfull->to_prj_id)?></td>
		    	</tr>
		    	<?
		         }
		    	?>
		    </tbody>
		  </table>
		  
 	</div>
 	<div class="col-md-2"></div>
</div>
</div>