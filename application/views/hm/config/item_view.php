
        <script>
//Onload focus to username box
/*	$(function() {
	$("#CATNAME").focus();
  });*/
  

$(function() {
	var availableTagsDecs = [
		<? if ($brandlist) foreach ($brandlist as $row){
			echo '"'.$row->brand_name.'",';
		}?>
		""
	];
	
   
	 $( "#brand_name" ).autocomplete({
		source: availableTagsDecs
	});
});
	

function update_items(id)
{

    // var vendor_no = src.value;
//alert(id);

    $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_config_items', id: id,fieldname:'item_id' },
            success: function(data) {
                if (data) {
          // alert(data);
            document.getElementById("checkflagmessage").innerHTML=data;
           $('#flagchertbtn').click();

          //document.getElementById('mylistkkk').style.display='block';
                }
        else
        {
          $('#popupform').delay(1).fadeIn(600);
		   $( "#popupform" ).load( "<?=base_url()?>hm/hm_config/item_edits/"+id );
		 
        }
            }
        });
}	
	
		
</script>            <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                        <div class="row">

                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/add_new_items" id="meterialform">
                <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">

                 

                    <label>Iem Name</label>
                    <div class="form-group">
                    <input type="text" name="item_name" id="item_name" class="form-control" required>
                    </div>

                    <label>Brand</label>
                    <div class="form-group">
                    <input type="text" name="brand_name" id="brand_name" class="form-control" required>
                   
                    </div>

                    </div>
                  </div>
                  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                  <div class="form-body">

                    <label>Unit Rate</label>
                    <div class="form-group">

                      <input type="text" name="unit_rate" id="unit_rate" class="form-control" required>
                   </div>

                    <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
</form></div></div>
                        <table class="table">

                          <thead>
                            <tr>
                              <th></th>
                              <th>Item code</th>
                              <th>Item Name</th>
                              <th>Brand </th>
                              <th>Unit Rate</th>
                              <th></th>
                            </tr>
                            
                          </thead>
                          <tbody id="meterialdata">

                      <? if($itemlist){$c=0;
                          foreach($itemlist as $raw){?>

                         <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                            <th scope="row"><?=$c?></th>
                            <td><?=$raw->item_code ?></td>
                            <td><?=$raw->item_name ?></td>
                            <td><?=$raw->brand_name ?></td>
                            <td><?=number_format($raw->unit_rate,2) ?></td>
                            <td align="right">
                             <a  href="javascript:update_items('<?=$raw->item_id?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a></td>
                                 
                         </tr>

                                <? }} ?>
                          </tbody></table>
                      