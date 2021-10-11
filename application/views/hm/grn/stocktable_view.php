<table class="table" id="purchase_table" width="50%" >
<?

 if(!empty($finarr)){
 ?>
 <thead>
    <tr>
        <th>#</th>
        <th>Meterial</th>
        <th>Batch No</th>
        <th>Quantity</th>
        <th>Quantity (balance)</th>
        <th>Price</th>
        <th>Stock Received Date</th>
        <th></th>
    </tr>
 </thead>
 <tbody>
 <?
  $i=1;
  foreach($finarr as $key => $value){
                          if($i % 2 == 0){
                            $clr = "#d9edf7";
                          }else{
                            $clr = "#FFFFFF";
                          }
 ?>
  <tr bgcolor="<?=$clr?>">
       <td><strong><?=$i?></strong></td>
  	   <td><strong><?=$value['meterial']?></strong></td>
       <td><strong><?=$value['batchno']?> </strong></td>
       <td><strong><?=$value['quantity']?></strong></td>
       <td><strong><?=$value['balquantity']?></strong></td>
       <td><strong><?=$value['price']?></strong></td>
       <td><strong><?=$value['confirmdate']?></strong></td>
       <td>
        <?
        if(sizeof($value['stockdispach'])>0){
        ?>
        <a data-toggle="collapse" class="success" id="btn<?=$value['mat_id']?>" data-target="#demo<?=$value['mat_id']?><?=$value['batch_code']?>" title="Expand"><span id="ico<?=$value['mat_id']?>"><i class="fa fa-plus-circle"></i></span></a> &nbsp;&nbsp;
        <?
        }

        if(sizeof($value['porequests'])>0){
          ?>
          <a data-toggle="collapse" id="btn<?=$value['mat_id']?>" data-target="#dispache<?=$value['mat_id']?><?=$value['batch_code']?>" title="Dispatch"><span id="ico<?=$value['mat_id']?>"><i class="fa fa-exchange"></i></span></a>
          <?
        }
        ?>

      </td>
  </tr>
  <tr id="demo<?=$value['mat_id']?><?=$value['batch_code']?>" class="collapse">
      <td colspan="6">
        <table class="table">
          <?
            
          ?>
          <tr bgcolor="#5bc0de">
            <td>Project</td>
            <td>Total Quantity</td>
            <td>Used Qty</td>
            <td>Transfer Qty</td>
            <td>Processed Type</td>
          </tr>

          <?
          foreach($value['stockdispach'] as $pmatfull){
            ?>
            <tr bgcolor="#5bc0de">
              <td><?=get_prjname($pmatfull->prj_id)?></td>
              <td><?=$pmatfull->rcv_qty?></td>
              <td><?=$pmatfull->ussed_qty?></td>
              <td><?=$pmatfull->trans_qty?></td>
              <td><?=$pmatfull->transfer?></td>
            </tr>
            <?
             }
          ?>
        <tr><td colspan="5"><hr></td></tr>
        </table>
      </td>
  </tr>

  <tr id="dispache<?=$value['mat_id']?><?=$value['batch_code']?>" class="collapse">
      <td colspan="6">
        <table class="table">
          <?
            
          ?>
          <tr bgcolor="#5cb85c">
            <td>Project</td>
            <td>Request Quantity</td>
            <td></td>
          </tr>

          <?
          if(!empty($value['porequests'])){
          foreach($value['porequests'] as $prlist){
            ?>

             <tr bgcolor="#5cb85c">
              <td><?=get_prjname($prlist->prj_id)?></td>
              <td>
                <input type="text" name="req_qty" id="req_qty" value="<?=$prlist->qty-$prlist->dispatched_qty?>" readonly="readonly">
            </td>
              <td><!--<input type="submit" class="btn btn-default" name="dispatch" value="Dispatch">-->
                <form action="<?=base_url()?>hm/hm_grn/add_dispatch" method="post">
                  <input type="hidden" name="req_qty" id="req_qty" value="<?=$prlist->qty-$prlist->dispatched_qty?>" readonly="readonly">
                  <input type="hidden" name="ussed_qty" id="ussed_qty" value="<?=$value['ussedmainstock']?>" readonly="readonly">
                  <input type="hidden" name="req_id" id="req_id" value="<?=$prlist->req_id?>" readonly="readonly">
                  <input type="hidden" name="prj_id" id="prj_id" value="<?=$prlist->prj_id?>" readonly="readonly">
                  <input type="hidden" name="lot_id" id="lot_id" value="<?=$prlist->lot_id?>" readonly="readonly">
                  <input type="hidden" name="mat_id" id="mat_id" value="<?=$prlist->mat_id?>" readonly="readonly">
                  <input type="hidden" name="stock_id" id="stock_id" value="<?=$value['stock_id']?>" readonly="readonly">
                  <input type="hidden" name="price" id="price" value="<?=$value['buyprice']?>" readonly="readonly">
              <button type="submit" class="btn btn-primary">Dispatch</button></form></td>
            </tr>

            <?
              }
             }
          ?>
        <tr><td colspan="5"><hr></td></tr>
        </table>
      </td>
  </tr>
  <?
   $i++;
   }
  ?>
 </tbody>
 <?
 }

 /** if project was selected **/

 if(!empty($stocklist)){
 ?>
 <thead>
    <tr>
        <th>#</th>
        <th>Meterial</th>
        <th>Total Quantity</th>
        <th>Used Quantity</th>
        <th></th>
    </tr>
 </thead>
 <tbody>
 <?
  $i2=1;
  foreach($stocklist as $sl){
                         if($i2 % 2 == 0){
                            $clr = "#d9edf7";
                          }else{
                            $clr = "#FFFFFF";
                          }
 ?>
  <tr bgcolor="<?=$clr?>">
       <td><?=$i2?></td>
  	   <td><? $mat=get_meterials_all($sl->mat_id)?><?=$mat->mat_name?> <?=$mat->mt_name?></td>
       <td><?=$sl->recqtytotal?> <?=$mat->mt_name?></td>
       <td><?=$sl->usdqtytotal?> <?=$mat->mt_name?></td>
       <!--<td><a  href="javascript:viewfull('<?=$sl->mat_id?>')" title="View Site Stock Breakdown"><i class="fa fa-eye nav_icon icon_green"></i></a></td>-->
  </tr>
  <?
   $i2++;
   }
  ?>
 </tbody>
 <?
 }
?>

</table>

