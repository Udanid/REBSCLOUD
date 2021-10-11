
<!-- Ticket No-2861 | Added By Uvini -->
<script type="text/javascript">
  $("#purchase_order").chosen({
        allow_single_deselect : true,
      search_contains: true,
      no_results_text: "Oops, nothing found!",
      placeholder_text_single: "Select a Supplier"
      });
</script>
 <div class="form-group" <?if(!$po_list){?>style="display: none;"<?}?>>
                          
                           
                            <label class=" control-label col-sm-3 " >Purchase Order</label>
                             <div class="col-sm-3 "><select name="purchase_order" id="purchase_order" class="form-control chosen-select">
                              <option value=""></option >
                              <?if($po_list){foreach($po_list as $row){?>
                              		<?$po_balance = cal_po_balance($row->purchase_id,$row->tot_price);
                              		if($po_balance>0)
                              		{?>
                        			<option value="<?=$row->purchase_id;?>"><?=$row->purchase_number.' (Total Amount '.number_format($row->tot_price,2).')'. '(Balance '.number_format($po_balance,2).')';?></option>
                              	<?}}}?>
                         </select></div>
                        	</div>