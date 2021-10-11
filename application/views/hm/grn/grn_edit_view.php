<script type="text/javascript">
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

	$(function(){
			
			$('input.value').keyup(function() {
  
			  var $row = $(this).closest('tr');
			      recqty = jQuery('input.recquantity', $row).val(),
			      qty = jQuery('input.qty', $row).val(),
			      
	              console.log(Number(recqty))
	              console.log(Number(qty))
	              if(Number(recqty)>Number(qty)){
	              	console.log("error")
	              	jQuery('input.recquantity', $(this).closest('tr')).val(qty);
	              }

		    });
		});
</script>

<?
 if($typ==1){
?>
<h4>GRN No <?=$ids?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('1')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
 	<div class="col-md-2"></div>
 	<div class="col-md-8">
 		<form action="<?=base_url()?>hm/hm_grn/update_grn_qty" method="post" data-toggle="validator">
 			<input type="hidden" name="grnid" value="<?=$ids?>">
		 <table class="table">
		 	<thead>
		 	  <tr>
		 		<td>Meterial Name</td>
		 		<td>Quantity</td>
		 	  </tr>
		    </thead>
		    <tbody>
		    	<?
		          foreach($listgrnitems as $lstgrn){
		          	

		            $qtys=($lstgrn->podataqty-$lstgrn->rec_qty)+$lstgrn->stockbthqty;
		          ?>
		    	<tr>
		    		<td><?=$lstgrn->mat_name?></td>
		    		<td>
		    		<input type="hidden" name="poitemid<?=$lstgrn->batch_id?>" value="<?=$lstgrn->po_itemid?>">
		    		<input type="hidden" name="batchid<?=$lstgrn->batch_id?>" value="<?=$lstgrn->batch_id?>">
		    		<input class="value qty" type="hidden" name="qty" value="<?=$qtys?>">
		    		<input type="text" class="value recquantity" name="recquantity<?=$lstgrn->batch_id?>" value="<?=$lstgrn->stockbthqty?>" required="required"></td>
		    	</tr>
		    	<?
		         }
		    	?>
		    </tbody>
		  </table>
		  <button type="submit" class="btn btn-primary">Update</button>
		</form>
 	</div>
 	<div class="col-md-2"></div>
</div>
</div>
<?
}else{
?>
<h4>GRN No <?=$ids?>  <?=$stts?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('1')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
 	<div class="col-md-2"></div>
 	<div class="col-md-8">
 		
		 <table class="table">
		 	<thead>
		 	  <tr>
		 		<td>Meterial Name</td>
		 		<td>Quantity</td>
		 	  </tr>
		    </thead>
		    <tbody>
		    	<?
		          foreach($listgrnitems as $lstgrn){
		          $qtys=($lstgrn->podataqty-$lstgrn->rec_qty)+$lstgrn->stockbthqty;
		          ?>
		    	<tr>
		    		<td><?=$lstgrn->mat_name?></td>
		    		<td><?=$lstgrn->stockbthqty?></td>
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
<?
} 	

?>
