<!DOCTYPE HTML>
<html>
<head>

    <?
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));
    $this->load->view("includes/topbar_accounts");?>
<script>

(function ($) {
    $.fn.formNavigation = function () {
        $(this).each(function () {
            $(this).find('input').on('keyup', function(e) {
                switch (e.which) {
                    case 39:
                        $(this).closest('td').next().find('input').focus(); break;
                    case 37:
                        $(this).closest('td').prev().find('input').focus(); break;
                    case 40:
                        $(this).closest('tr').next().children().eq($(this).closest('td').index()).find('input').focus(); break;
                    case 38:
                        $(this).closest('tr').prev().children().eq($(this).closest('td').index()).find('input').focus(); break;
                }
            });
        });
    };
})(jQuery);

</script>
<style>
.headcol {
  position: sticky;
  left: 0;
  background:  #a399f6 ;


}
.tableFixHead thead tr .headcol{ position: sticky;
left: 0;

  background: #a399f6  ;
  color: #555;
}
.tableFixHead thead tr { position: sticky; top: 0;
  padding: 5px 8px;
  background:  #a399f6 ;
  color: #555;
}



</style>
<style>
 .goback{
   position:fixed;
   width:60px;
   height:60px;
   bottom:20px;
   right:40px;
   background-color:#e74c3c;
   background-image: linear-gradient(to right, #d23a2a 0%, #e74c3c 51%, #d23a2a 100%) !important;
   background-position: -90px -90px, 0 0;
   color:#FFF;
   border-radius:50px;
   text-align:center;
   box-shadow: 2px 2px 3px #FFF;
   cursor:pointer;
   background-position: -30px -30px, 0 0;
   -webkit-transition-duration: 0.5s;
     -moz-transition-duration: 0.5s;
       transition-duration: 0.5s;
   cursor: url(<?=base_url()?>media/images/pointer.png), auto;

 }
 .goback:hover{
   background: #7b1d13 !important;
   background-image: linear-gradient(to right, #e74c3c 0%, #7b1d13 51%, #e74c3c 100%) !important;
   -webkit-transition-duration: 0.5s;
     -moz-transition-duration: 0.5s;
       transition-duration: 0.5s;
   }

 .my-float{
   margin-top:22px;
 }

</style>

  <div id="page-wrapper">
    <div class="main-page">

     <div class="table">
        <h3 class="title1">Boq Unit Material Details of Project <?=$projname?>-> Unit <?=get_unitname($unitid)?> Edit</h3>
        <div class="widget-shadow">
          <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;max-height:500px">

 <? $this->load->view("includes/flashmessage");?>

<div class="table widget-shadow">
 <div class="row tableFixHead">
<!-- <form action="<?=base_url()?>hm/feasibility/update_unitboqmaterial" method="post"> -->
<form action="<?=base_url()?>hm/feasibility/add_unitboqmaterial" method="post">
  <input type="hidden" name="designid" value="<?=$designid?>">
  <input type="hidden" name="lotid" value="<?=$unitid?>">
  <input type="hidden" name="prjid" value="<?=$prjid?>">
  <input type="hidden" name="roots" value="<?=$roots?>">
  <div class="row">
  <label class="col-md-1">BOQ Task</label>
  <div class="form-group col-md-8">

    <select name="fboq_id" id="fboq_id" class="form-control" required>
      <option value=""></option>
      <? if($boq_taskdata){
        foreach ($boq_taskdata as $key => $value) {?>
          <option value="<?=$value->id?>" > <?=$value->description?></option>
      <?	}
      }?>
    </select>

  </div>
</div>
<div class="row">
  <label class="col-md-1">Meterial Type</label>
  <div class="form-group col-md-3">

    <select name="mat_id" id="mat_id" class="form-control" required>
      <option value=""></option>
      <? if($mat_list){
        foreach ($mat_list as $key => $value) {?>
          <option value="<?=$value->mat_id?>" ><?=$value->mat_code?> - <?=$value->mat_name?></option>
      <?	}
      }?>
    </select>

  </div>
  <label class="col-md-1">Default Quantity</label>
  <div class="form-group col-md-3">
    <input type="number" name="default_qnt" id="default_qnt" class="form-control col-md-3">
  </div>
  <button type="submit" class="btn btn-primary ">Add</button>
</div>
</form>

<table class="table gridexample" id="boqtbls" > <thead id="thheader"> <tr >
                          <th class="headcol">No</th>
                          <th class="headcol">Description </th>
                          <th></th>

                          <? if($mat_list){
                           $v=1;
                           foreach ($mat_list as $matkey => $matvalue) {
                            ?>
                           <th><?=$matvalue->mat_code?>-<?=$matvalue->mat_name?></th>
                           <?
                          }
                         }?>
                        </tr> </thead>
                        <tbody>
                      <? if($sub_cat_data_boq){$c=0;
                          foreach($sub_cat_data_boq as $row){
                            $c++;
                            $tot=0;
                            $col=3+sizeof($mat_list);
                            ?>

                            <tr class="warning"><th colspan="<?=$col?>"><?=$c?> - <?=$row->cat_name?></th></tr>
                            <tr class="success"><th colspan="<?=$col?>"><?=$row->subcat_name?></th></tr>

                            <? if($datalist[$row->boqsubcat_id]){ $n=0;
                              foreach ($datalist[$row->boqsubcat_id] as $key => $value) {
                                $n++;
                                $tot=$tot+$value->amount;
                                ?>
                              <tr class="edrows<?=$c?>">
                                <input type="hidden" id="rowsetid" name="rowsetid" class="value rowsetid" value="<?=$c?>">



                                <input type="hidden" name="<?=$value->boqtask_id?>subcatid" id="subcatid" value="<?=$value->boqsubcat_id?>">
                                <td scope="row" class="headcol"><?=$c?>.<?=$n?></td>
                                <td class="headcol" ><textarea name="<?=$value->boqtask_id?>desk" rows="3" cols="60" readonly><?=$value->description ?></textarea></td>
                                  <th></th>
                                   <input type="hidden" class="total2 totals<?=$c?><?=$n?>" name="<?=$value->boqtask_id?>" value="<?=$value->amount?>"></td>
                                   <? if($mat_list){?>

                                       <?
                                    $v=1;
                                    foreach ($mat_list as $matkey => $matvalue) {
                                     ?>
                                     <td>
                                     <? if($matdata[$value->id]){
                                       $io=1;
                                       foreach ($matdata[$value->id] as $matkey2 => $matvalue2) {
                                         //$io=1;
                                         if($matvalue2->mat_id==$matvalue->mat_id){
                                           $io=0;
                                        ?>


                                         <input type="text" style="width:50px; padding:3px;" class="form-control" name="<?=$value->id?><?=$matvalue2->mat_id?>amt" value="<?=$matvalue2->value?>">

                                       <?
                                     }?>
                                    <?
                                  }
                                  if($io!=0){?>
                                    <input type="text" style="width:50px; padding:3px;" class="form-control" name="<?=$value->id?><?=$matvalue->mat_id?>amt" value="0">

                                <?  }

                                  ?>

                                  <?
                                }else{?>
                                <input type="text" style="width:50px; padding:3px;" class="form-control" name="<?=$value->id?><?=$matvalue->mat_id?>amt" value="0">

                              <?}?>
                            </td>
                            <?
                          }}?>

                                 </tr>
                            <?  } ?>


                          <?  } }?>
                          <? } ?>
                          </tbody></table>
                        <!--  <button type="submit" class="btn btn-primary">Update</button>
                         </form> -->
                        <?
                                $CI =& get_instance();
                                $CI->load->library('user_agent');
                                //if ($CI->agent->is_referral())
                                //{?>
                                	<div class="goback">
                                        <a title="Back to previous page" href="<?=$CI->agent->referrer()?>" class="float">
                                            <i class="fa fa-backward my-float" style="color:#FFFFFF;"></i>
                                        </a>
                                    </div>
                               <? //} ?>
                        </div>
                      </div>
                    </div>
                   </div>
</div>
</div>
</div>




                  <?php
                  $this->load->view("includes/footer");?>
<script type="text/javascript">
  $(function(){
   /* $('input.value').keyup(function() {

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



    } */
  });
</script>
<script>
	$(document).ready(function () {
		$('.gridexample').formNavigation();
    $("#fboq_id").chosen({
      allow_single_deselect : true,
    });
    $("#mat_id").chosen({
      allow_single_deselect : true,
    });
	});
	</script>
