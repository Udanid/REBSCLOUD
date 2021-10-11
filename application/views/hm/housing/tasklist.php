<script>
$("form").submit(function(e){
	e.preventDefault();
	var amount = $('#amount').val();
	var selling = $('#selling').val();
	if(parseFloat(selling) < parseFloat(amount)){
		//a=a.replace(/\,/g,'')
		//alert(selling)
		document.getElementById("checkflagmessage").innerHTML='Selling price cannot be lower than the cost'; 
		$('#flagchertbtn').click(); 	
	}else{
    	e.currentTarget.submit();
	}
});
</script>
<? 
if ($tasklist) {
		foreach($tasklist as $data){
?>
		<label><?=$data->task_name?></label>&nbsp;&nbsp;<input type="text" onblur="setSaleprice(this.value);" class="form-control number-separator" value="<? if($current_design){ echo $current_design->estimate_budget; }?>" required="required" placeholder="Rupees" name="amount" id="amount" />&nbsp;&nbsp;&nbsp;
        <input type="hidden" name="task" value="<?=$data->task_id?>" />
<?  
		}
?>
	<label>Selling Price</label>&nbsp;&nbsp;<input type="text" class="form-control number-separator" <? if($current_design){?> min="<?=$current_design->estimate_budget?>" <? }?> value="<? if($current_design){ echo $current_design->selling_price; }?>" required="required" placeholder="Rupees" name="selling" id="selling" />&nbsp;&nbsp;&nbsp;
    <div class="clearfix"> </div><br>
    
    <? if($current_design){ ?>
    	<button type="submit" style="width:150px" class="btn btn-primary">Update</button>
    <? }else{ ?>
    	<button type="submit" style="width:150px" class="btn btn-primary">Submit</button>
    <? }?>
	
<br /><br />
    <?

         if($designtypeimgs){

            foreach($designtypeimgs as $dtimg){
                ?>

            <div> <img class="img-fluid" width="50%" src="<?=base_url()?>uploads/design_type/<?=$dtimg->designtype_image?>" ></div><br />

                <?
                break;
            }
         }else{
            $imgnames = '';
         }
         ?>


<table class="table">
  <tr>
    <td >Project Type </td>
    <td >&nbsp;&nbsp;:</td>
    <td ><?=$details->short_code?> - <?=$details->prjtype_name?></td>
  </tr>
  <tr>
    <td >Number of floors</td>
    <td >&nbsp;&nbsp;:</td>
    <td ><?=$details->num_of_floors?></td>
  </tr>
  <tr>
    <td >Total Extend </td>
    <td >&nbsp;&nbsp;:</td>
    <td ><?=$details->tot_ext?>(ft&#178;)</td>
  </tr>
  <tr>
    <td >Description </td>
    <td >&nbsp;&nbsp;:</td>
    <td ><?=$details->description?></td>

  </tr>
</table>
<br />
<div id="floordata">
  <? if($floors){?>

  <?  $divid=0;
    foreach ($floors as $key => $fl) {?>
      <div class="eachfloor">
      <h4><?=ucwords($fl->floor_name)?> - &nbsp;&nbsp;:&nbsp;&nbsp; Total Floor Extend : <?=$fl->tot_ext?>(ft&#178;)</h4>
      <table class="table floortable">
        <tr>
          <th><center><i class="fa fa-bed roomicon" aria-hidden="true"></i></center></th>
          <th><center><i class="fa fa-bath roomicon" aria-hidden="true"></i></center></th>

        </tr>
        <tr>
          <th><center>Number of Bedrooms</center></th>
          <th><center>Number of Bathrooms</center></th>
        <tr>
          <tr>
            <th><center><?=$fl->num_of_bedrooms?></center></th>
            <th><center><?=$fl->num_of_bathrooms?></center></th>
          <tr>
            <!--floor rooms data --->


      </table>


            <div class="floorroomsdiv">
                    <? if($rooms[$fl->floor_id]){?>
                      <table class="table">
                        <tr class="success">
                          <th>Room type</th>
                          <th>Room Width(ft)</th>
                          <th>Room Height(ft)</th>
                          <th>Room Length(ft)</th>
                          <th>Total Extent (ft&#178;)</th>
                          <th>Doors</th>
                          <th>Windows</th>
                        </tr>
                        <?
                      foreach ($rooms[$fl->floor_id] as $key => $roomdata) {?>


                            <th ><h5><?=$roomdata->roomtype_name?></h5></th>

                            <td><?=$roomdata->width?></td>
                            <td><?=$roomdata->height?></td>
                            <td><?=$roomdata->length?></td>
                            <td><?=$roomdata->tot_extent?></td>
                            <td><?=$roomdata->doors?></td>
                            <td><?=$roomdata->windows?></td>
                          </tr>


                    <?  }?>
                    </table>
                    <?
                    }?>
            </div>

            
                  </div>
  <?  $divid=$divid+1;}
    }?>  
<?
}else {
	echo 'No Tasks Found';
}?>							