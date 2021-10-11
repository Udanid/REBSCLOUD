  <!-- Ticket No-2861|Added By Uvini -->

  <div class="form-group" <?if(!$po_list){?>style="display: none;"<?}?>>
    
   
    <label class=" control-label col-sm-3 " >Purchase Order</label>
    <div class="col-sm-3 "><select name="purchase_order" id="purchase_order" class="form-control chosen-select">
      <option value=""></option >
      <?if($po_list){foreach($po_list as $row){?>
        <?$po_balance = cal_po_balance($row->purchase_id,$row->tot_price);
        if($po_balance>0)
          {?>
           <option value="<?=$row->purchase_id;?>"><?=$row->purchase_number.' (Total Amount '.$row->tot_price.')'. '(Balance '.$po_balance.')';?></option>
           <?}}}?>
         </select></div>
       </div>