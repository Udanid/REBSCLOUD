<?
echo $ids;
$batchcode=$batchid;

foreach($listpoitems as $lpi)
{

	if($lpi->status=='CONFIRMED'){
    ?>
<tr class="rw<?=$lpi->po_itemid?>" bgcolor="#dddef5">
	<td></td>
	<td><?=$lpi->mat_name?></td>
	<td><?=$lpi->qty?>&nbsp;&nbsp;<?=$lpi->mt_name?></td>

	<td width="20%"><?=$lpi->rec_qty?></td>
	<td width="20%"><i class="fa fa-check-square-o" aria-hidden="true"></i>
</td>
</tr>
    <?
	}else{
?>
<tr class="rw<?=$lpi->po_itemid?>">
	<td><input type="text" class="value bthcode" name="batchcode<?=$lpi->po_itemid?>" value="<?=$batchcode?>" readonly="readonly"><input type="hidden" class="value rws" value="<?=$lpi->po_itemid?>" ></td>
	<td><?=$lpi->mat_name?></td>
	<td id="qty<?=$lpi->po_itemid?>"><?=$lpi->qty-$lpi->rec_qty?>&nbsp;&nbsp;<?=$lpi->mt_name?>
    <?
     $x = $lpi->qty-$lpi->rec_qty;
     //echo $x;
     if(($lpi->rec_qty>0)){
     	echo "(Received ".$lpi->rec_qty." Earlier)";
     }
    ?>
	<input class="value qty" type="hidden" name="qty<?=$lpi->po_itemid?>" value="<?=$lpi->qty-$lpi->rec_qty?>"><input class="value qty2" type="hidden" name="qty2<?=$lpi->po_itemid?>" value="<?=$lpi->rec_qty?>"></td>
    
	<td width="20%">
		<input type="hidden" name="reqqtys" value="<?=$lpi->rec_qty?>">
		<input class="value recquantity" type="number" name="reqqty<?=$lpi->po_itemid?>" id="reqqty<?=$lpi->po_itemid?>" value=""></td>
	<td width="20%"><input type="checkbox" class="value chkbox" id="reqqtychk<?=$lpi->po_itemid?>" name="grns[]" value="<?=$lpi->po_itemid?>"></td>
</tr>
<?
 }

 $batchcode++;
}
?>

<script type="text/javascript">
		$(function(){
			$("input.chkbox").attr("disabled", true);
			var numarr = [];
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

                  var currow=jQuery('input.rws', $(this).closest('tr')).val();
                  //////////////////////
                      if(numarr.includes(currow)){

		              }else{
		              	 if(Number(recqty)>0){
		                   numarr.push(currow);
		                 }else{
                           //arrayRemove(numarr,currow);
                           //valuesToRemove = [currow];
                           //numarr.filter(item => !valuesToRemove.includes(item))
                           numarr.pop(currow);
		                 }
		              }
		             console.log(numarr)  
                   //////////////////////


                  if(Number(recqty)>0){
	               var bcode=jQuery('input.bthcode', $(this).closest('tr')).val();
	               if(bcode==""){
                     alert("please enter Batch Code First")
	               }	

                   jQuery('input.chkbox', $(this).closest('tr')).prop("checked",true);
                   jQuery('input.chkbox', $(this).closest('tr')).attr("disabled", false);
                   
	              }else{
	               //jQuery('input.bthcode', $(this).closest('tr')).val('');
	                

	               jQuery('input.chkbox', $(this).closest('tr')).prop("checked",false);	
	               jQuery('input.chkbox', $(this).closest('tr')).attr("disabled", true);
	               
	              }
	              


 
		    });

		    

		    $('.chkbox').on('change', function(){ // on change of state
		    	  var rows = $(this).val();
		    	 	    	  
				  if(this.checked) // if changed state is "CHECKED"
				  {
				     console.log("ok")
				  }else{
				  	$("#reqqtychk"+rows).attr("disabled", true);
				  	$('#reqqty'+rows).val("");
				  }
			})
		});
</script>		