
<script type="text/javascript">
jQuery(document).ready(function() {
	
		$("#item_id").chosen({
        allow_single_deselect : true,
        search_contains: true,
		width: '100%',
        no_results_text: "Oops, nothing found!",
        placeholder_text_single: "Select Assignee"
      });
	  
	 
	
});
function load_itemdatalist(val)
  {
	  if(val!='')
	  {
	  var res = val.split(",");
	  document.getElementById('unit_rate').value=res[1];
	   $('#dataset').delay(1).fadeIn(600);
	  }
	  else
	  {
		  $('#dataset').delay(1).fadeOut(600);
	  }
	
  }
  function add_data()
  {
	var  unit_rate=document.getElementById('unit_rate').value ;
	var qty=document.getElementById('qty').value ;
	var item_id=document.getElementById('item_id').value ;
	var prj_id=document.getElementById('prj_id').value ;
	var lot_id=document.getElementById('lot_id').value ;
	
	if( unit_rate !='' &  qty !='')
	{
		
		 $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'hm/feasibility/add_boq_items';?>',
            data: {item_id:item_id, qty: qty, unit_rate: unit_rate, prj_id: prj_id, lot_id: lot_id },
            success: function(data) {
                if (data) {
				//	alert(data)
					  document.getElementById("tabledataset").innerHTML=data;
					// $('#flagchertbtn').click();
					
  					$('#dataset').delay(1).fadeOut(600);
					document.getElementById('qty').value="";
					document.getElementById('item_id').value="";
					document.getElementById('unit_rate').value="";
					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
				 document.getElementById("checkflagmessage").innerHTML='Somthing Went Wrong';
					$('#flagchertbtn').click();
	 
				}
            }
        });
	}
	
  }
  function call_delete_item(id)
{
	//alert(id)
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'hm/feasibility/call_delete_item';?>',
            data: { id: id },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("tabledataset").innerHTML=data;
					

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					 document.getElementById("checkflagmessage").innerHTML='Somthing Went Wrong';
					$('#flagchertbtn').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}

</script>

<h4>Boq Unit Details of Project <?=$projname?>-> Unit <?=$unitid?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit(2)"><i class="fa fa-times-circle "></i></a></span></h4>
 <div class="row">
 <div class=" widget-shadow" data-example-id="basic-forms"> 
       <div class="form-title">
        <h5>Add Items </h5>
      </div>
      <div class="clearfix"> </div>
      <div class="form-body form-horizontal">
          <div class="col-md-3">
                <select class="form-control chosen-select" name="item_id" id="item_id" onChange="load_itemdatalist(this.value)"  required>
                  <option value="" ></option>
                  <? if($itemlist){
                      foreach($itemlist as $catraw){?>
                   <option value="<?=$catraw->item_id?>,<?=$catraw->unit_rate?>"   ><?=$catraw->brand_name?> <?=$catraw->item_name?> </option>
                  <? }}?>
                 
              </select>
              <input type="hidden" value="<?=$prj_id?>" id="prj_id" name="prj_id">
               <input type="hidden" value="<?=$unitid?>" id="lot_id" name="lot_id">
           </div>
           <div id="dataset" style="display:none">
             <div class="col-md-3"> <input type="text" class="form-control "  placeholder="Unit Rate"  value="" id="unit_rate" name="unit_rate"></div>
             <div class="col-md-3"> <input type="number" class="form-control "   placeholder="Quantity" value="" id="qty" name="qty"></div>
              <div class="col-md-3"> <button class="btn btn-primary btnaddnew " onclick="add_data()"> + </button></div>
           </div>
           <div class="clearfix"> </div>
           <br /> <br />
       </div>
   </div>
   <div class="table widget-shadow" id="tabledataset">

        <table  class="table table-bordered" id="boqtbls"> 
        <thead> <tr>
              <th>Item</th>
              <th>Qty</th>
              <th>Unit Price</th>
              <th>Total</th>
              <th></th>
                </tr> 
        </thead>
         <tbody>
          <? if($boqitems){$c=0;
            $total_tot=0;
              foreach($boqitems as $row){
            //	  print_r($row);
                $c++;
                $tot=0;
				$total_tot=$total_tot+$row->total;
                ?>
        
                 <tr>
                 <td><?=$row->item_name?> -<?=$row->brand_name?> </td>
                 <td><?=$row->qty ?></th>
                 <td style="text-align:right"><?=number_format($row->unit_rate,2)?></td>
                 <td style="text-align:right"><?=number_format($row->total,2)?></td>
                 <td>
                 <? if($prj_data->status=='PENDING'){?>
                 <a  href="javascript:call_delete_item('<?=$row->boq_itemid?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                 <? }?>
                  </td>
                 </tr>
                 
                 <?   }?>
              <tr class="info total_total"><th  colspan="3">Total</td> 
              <th style="text-align:right"><?=number_format($total_tot,2)?></th><th></th></tr>
              <? } ?>
         </tbody>
        </table>
          <br /> <br /> <br /> <br /> <br />
                           
   </div>
</div>
