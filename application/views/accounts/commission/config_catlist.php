<script type="text/javascript">

function format_val(obj)
{
	a=obj.value;
	a=a.replace(/\,/g,'')
	obj.value=parseFloat(a).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}


</script>                

   <table class="table"> <thead> <tr> <th>ID</th> <th>Officer Type</th> <th>Persentage</th></tr> </thead>
                      <? if($catlist){$c=0;
                          foreach($catlist as $row){
							  $rate=get_commission_rate_by_catid_tableid($row->id,$tableid,$year);
							  $amount=0; $status='PENDING';$rate_type='';
							  if($rate)
							  {
							  $amount=$rate->rate;
							  $status=$rate->status;
							  $rate_type=$rate->rate_type;
							  }
							  
							  ?>
                          
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->id?></th> 
                        <td ><?=$row->officer_type ?> </td>
                       <td align="right"><select name="rate_type<?=$row->id?>"  class="form-control" id="rate_type<?=$row->id?>">
                       <option value="Percentage" <? if($rate_type=='Percentage'){?> selected="selected"<? }?>>Percentage</option>
                       <option value="Amount"  <? if($rate_type=='Amount'){?> selected="selected"<? }?>>Amount</option>
                       </select> </td>
                        
                        <td align="right"> <input  type="text" class="form-control" id="amount<?=$row->id?>"    name="amount<?=$row->id?>"  value="<?=number_format($amount,2)?>"  <? if($status!='PENDING'){?> readonly<? }?>  data-error=""  required  placeholder="Year"onchange="format_val(this)" ></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table><div class="col-sm-12 has-feedback" id="paymentdateid" style="float:right"><button type="submit" class="btn btn-primary disabled" >Update Commission Rates</button></div>
                                        </div>
                    
                    
                    
                      
                  