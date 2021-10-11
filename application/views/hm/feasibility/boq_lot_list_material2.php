<script type="text/javascript">
jQuery(document).ready(function() {
	setTimeout(function(){
	  	$("#task_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Task"
    	});


	 	$.ajaxSetup ({
    	// Disable caching of AJAX responses
    		cache: false
		});
	}, 800);
});
</script>
<style>
.headcol {
  position: sticky;
  left: 0;
  background: #fff;


}
.tableFixHead thead tr .headcol{ position: sticky;
left: 0;

  background:#fff ;
  color: #555;
}
.tableFixHead thead tr { position: sticky; top: 0;
  padding: 5px 8px;
  background: #fff;
  color: #555;
}



</style>
 <? $this->load->view("includes/flashmessage");?>
<h4>Boq Unit Details of Project <?=$projname?>-> Unit <?=$unitid?> Edit<span  style="float:right; color:#FFF" ><a href="javascript:close_edit(2)"><i class="fa fa-times-circle "></i></a></span></h4>
<div class=" widget-shadow">
 <div class="row ">
<form data-toggle="validator" action="<?=base_url()?>hm/feasibility/update_unitboqmaterial" method="post">
  <input type="hidden" name="designid" value="<?=$designid?>">
  <input type="hidden" name="lotid" value="<?=$unitid?>">
  <div class="col-md-6 validation-grids " data-example-id="basic-forms">
    <div class="form-body">
        <label>Task </label>
        <div class="form-group">
          <select  name="task_id" id="task_id" class="form-control" required>
            <option value=""></option>
            <? if($datalist){
              $v=0;
              foreach ($datalist as $key => $value) {
                $v=$v+1;?>
                <option value="<?=$value->id?>" ><?=$v?> - <?=$value->description?></option>
            <?	}
            }?>
          </select>
        </div>
      </div>
    </div>
<table class="table gridexample" id="boqtbls" > <thead id="thheader"> <tr >
                          <th class="headcol">Material</th>
                          <th class="headcol">Value</th></tr>
                          <th></th>
                          <? if($mat_list){
                            foreach ($mat_list as $key => $value) {?>
                          <tr>  <th><?=$value->mat_code?>-<?=$value->mat_name?></th>
                            <th><input name="<?=$value->mat_id?>val" id="<?=$value->mat_id?>val" value="0"></th></tr>
                            <?}
                          }?>
                         </thead>
                        <tbody>

                          </tbody></table>
                          <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                        </div>
                      </div>

<script type="text/javascript">
  $(function(){
    $('input.value').keyup(function() {

      var $row = $(this).closest('tr');
          $output = jQuery('input.total', $row),
          $output2 = jQuery('input.total2', $row),
          quantity = jQuery('input.quantity', $row).val(),
          price = jQuery('input.price', $row).val(),
          total = quantity * price;
          //append new quentity*price value..
      $output.val(total);
      $output2.val(total);
          if($output.val(total)){

        var rowsetid = jQuery('input.rowsetid', $row).val();
        cal_subamount(rowsetid);
          }

    });

    function cal_subamount(rowsetid){
          console.log("inside function row id "+rowsetid)
      var rows= $('#boqtbls tr.edrows'+rowsetid).length;
         console.log("rows count "+rows)
          var tot = 0;
          var i;
      for (i=1; i< rows+1; i++) {

             var totalnew = parseInt(jQuery('.totals'+rowsetid+i).val());
             console.log(totalnew)

             tot = tot+totalnew;
    }

      //console.log(tot)
      $('.subtotal2'+rowsetid).html(tot+'<input type="hidden" class="subtotal'+rowsetid+'" value="'+tot+'">');



    }
  });
</script>
