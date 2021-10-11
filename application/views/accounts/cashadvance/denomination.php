<script type="text/javascript">
function calculate_total(name,value,count)
{
	var tot=parseFloat(value)*parseFloat(count);
	document.getElementById(name+'totv').value=tot;
	document.getElementById(name+'tot').value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;;
	var total=parseFloat(document.getElementById('N5000totv').value)+parseFloat(document.getElementById('N2000totv').value)+parseFloat(document.getElementById('N1000totv').value)+parseFloat(document.getElementById('N500totv').value)+parseFloat(document.getElementById('N100totv').value)+parseFloat(document.getElementById('N50totv').value)+parseFloat(document.getElementById('N20totv').value)+parseFloat(document.getElementById('N10totv').value)+parseFloat(document.getElementById('C10totv').value)+parseFloat(document.getElementById('C5totv').value)+parseFloat(document.getElementById('C2totv').value)+parseFloat(document.getElementById('C1totv').value)+parseFloat(document.getElementById('CC50totv').value)+parseFloat(document.getElementById('CC25totv').value)+parseFloat(document.getElementById('bankbaltotv').value)
	document.getElementById('totalv').value=total;
	var advancetot=document.getElementById('outbal').value;
	var ledgerbal=document.getElementById('ledgerbal').value;
	var cashbal=parseFloat(total)+parseFloat(advancetot);
	var variance=parseFloat(ledgerbal)-parseFloat(cashbal);
	document.getElementById("cashbookbal").innerHTML=cashbal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
; document.getElementById("vari").innerHTML=variance.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
; 

	document.getElementById('total').value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById('variance').value=variance;
	
	
	
	
}
</script>
<style type="text/css">
.denomiform_sm {
	 border: 1px solid #ccc;
	 text-align:right;
	  padding: 2px 2px;
	width:30px;
	height:20px;
	padding:0;
	}
	.denomiform_md {
		 border: 1px solid #ccc;
	 text-align:right;
	  padding: 2px 2px;
	   background:#e8e3de;
	width:60px;
	height:20px;
	padding:0;
	}
</style>
<? 
?>
<h4>Cash Book Details -  <?=$details->name ?> <span  style="float:right; color:#FFF" ><!--<a href="javascript:load_printscrean1('<?=$details->id ?>')"><i class="fa fa-print nav_icon"></i></a>-->&nbsp;&nbsp;<a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="col-sm-6">


  <div class="clearfix"> </div><br /></div>
  <div class="row">
<div class="col-sm-8 ">
<div class="form-title">
								<h5>Cash Advances </h5>
						</div>  <div class="widget-shadow table-responsive bs-example widget-shadow">
<table class="table table-bordered"> <thead> <tr> <th> Date</th> <th>Payee</th>  <th>Amount</th> <th>Settlement Date</th> <th>Cash Advance No</th><th>Description</th><th>Settled Amount</th><th>Pay Status</th></tr> </thead>
                      <? if($advancedata){$c =0;
                          foreach($advancedata as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->apply_date?></th> <td><?=$row->initial?> <?=$row->surname?></td>
                            <td><?=number_format($row->amount,2) ?></td>
                             <td><?=$row->promiss_date ?></td> 
                          <td><?=$row->adv_code ?></td> 
                             <td><?=$row->description ?></td> 
                              <td><?=number_format($row->settled_amount,2) ?></td> 
                               <td><?=$row->status ?></td> 
                      
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
</div>
<div class="widget-shadow table-responsive bs-example widget-shadow" >
<?
					 $physicalbal=get_cashbook_balance($details->id);
							 $outbal=get_cashbook_outstanding($details->id);
							 $totbal=$outbal+$physicalbal;
							 $variance=$ledgerbalance-$physicalbal;
							  $class='';
							  if($variance!=0)
							  {
								  $class='red';
							  }
?>
<table class="table table-bordered">
<tr style="font-weight:bold" class="info"><td>Book Balance</td><td align="right"><?=number_format($ledgerbalance,2)?></td></tr>
<tr style="font-weight:bold" class="info"><td>Physical Balance</td><td align="right"><div id="cashbookbal"><?=number_format($physicalbal,2)?></div></td></tr> 
<tr style="font-weight:bold" class="<?=$class?>"><td>Variance</td><td align="right"><div id="vari"><?=number_format($variance,2)?></div></td></tr>
<tr style="font-weight:bold" class="info"><td>Outstanding Cash</td><td align="right"><div id="cashbookbal"><?=number_format($outbal,2)?></div></td></tr> 
</table> 

<input type="hidden"  name="ledgerbal" id="ledgerbal" value="<?=$ledgerbalance?>">
<input type="hidden"  name="outbal" id="outbal" value="<?=$outbal?>">
<input type="hidden"  name="physicalbal" id="physicalbal" value="<?=$physicalbal?>">
<input type="hidden"  name="variance" id="variance" value="<?=$variance?>">
</div>

				            
                                    
                                 <br /></div>
                                 
                                 <div class="col-sm-4">
                                 <div class="form-title">
								<h5>Physical Cash </h5>
						</div>
                        
                          <div class="widget-shadow table-responsive bs-example">
                           <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashadvance/update_denomination" enctype="multipart/form-data">
                          <input type="hidden" name="bookid" id="bookid" value="<?=$details->id?>" />
                          <table class="table table-bordered">
                          <tr class="active" ><th>Value</th><th>Count</th><th>Total</th></tr>
                          <tr class="info" ><th colspan="3"> NOTES</th></tr>
                          <tr><td>5000</td>
                          <td align="right"> <input type="text"  name="N5000" id="N5000"   class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('N5000','5000',this.value)" required="required" value="<?=$details->N5000?>" ></td>
                           <td align="right" > <input type="text"  name="N5000tot" id="N5000tot"   value="<?=number_format($details->N5000*5000,2)?>"  class="denomiform_md"   readonly="readonly" ><input  type="hidden"  name="N5000totv" id="N5000totv" value="<?=$details->N5000*5000?>"></td>
                          </tr>
                           <tr><td>2000</td>
                          <td align="right"> <input type="text"  name="N2000" id="N2000"  class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('N2000','2000',this.value)" required="required" value="<?=$details->N2000?>" ></td>
                           <td align="right" > <input type="text"  name="N2000tot" id="N2000tot"   value="<?=number_format($details->N2000*2000,2)?>" class="denomiform_md"  readonly="readonly" ><input type="hidden"  name="N2000totv" id="N2000totv" value="<?=$details->N2000*2000?>"></td>
                          </tr>
                           <tr><td>1000</td>
                          <td align="right"> <input type="text"  name="N1000" id="N1000"   class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('N1000','1000',this.value)" required="required" value="<?=$details->N1000?>" ></td>
                           <td align="right" > <input type="text"  name="N1000tot" id="N1000tot"   value="<?=number_format($details->N1000*1000,2)?>" class="denomiform_md"    readonly="readonly" ><input type="hidden"  name="N1000totv" id="N1000totv" value="<?=$details->N1000*1000?>"></td>
                          </tr>
                          <tr><td>500</td>
                          <td align="right"> <input type="text"  name="N500" id="N500"    class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('N500','500',this.value)" required="required" value="<?=$details->N500?>" ></td>
                           <td align="right" > <input type="text"  name="N500tot" id="N500tot"   value="<?=number_format($details->N500*500,2)?>" class="denomiform_md"   readonly="readonly" ><input type="hidden"  name="N500totv" id="N500totv" value="<?=$details->N500*500?>"></td>
                          </tr>
                           <tr><td>100</td>
                          <td align="right"> <input type="text"  name="N100" id="N100"    class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('N100','100',this.value)" required="required" value="<?=$details->N100?>" ></td>
                           <td align="right" > <input type="text"  name="N100tot" id="N100tot"   value="<?=number_format($details->N100*100,2)?>"  class="denomiform_md"   readonly="readonly" ><input type="hidden"  name="N100totv" id="N100totv" value="<?=$details->N100*100?>"></td>
                          </tr>
                              <tr><td>50</td>
                          <td align="right"> <input type="text"  name="N50" id="N50"    class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('N50','50',this.value)" required="required" value="<?=$details->N50?>" ></td>
                           <td align="right" > <input type="text"  name="N50tot" id="N50tot"   value="<?=number_format($details->N50*50,2)?>" class="denomiform_md"  readonly="readonly" ><input type="hidden"  name="N50totv" id="N50totv" value="<?=$details->N50*50?>"></td>
                          </tr>
                            <tr><td>20</td>
                          <td align="right"> <input type="text"  name="N20" id="N20"    class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('N20','20',this.value)" required="required" value="<?=$details->N20?>" ></td>
                           <td align="right" > <input type="text"  name="N20tot" id="N20tot"   value="<?=number_format($details->N20*20,2)?>" class="denomiform_md" readonly ><input type="hidden"  name="N20totv" id="N20totv" value="<?=$details->N20*20?>"></td>
                          </tr>
                           <tr><td>10</td>
                          <td align="right"> <input type="text"  name="N10" id="N10"   class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('N10','10',this.value)" required="required" value="<?=$details->N10?>" ></td>
                           <td align="right" > <input type="text"  name="N10tot" id="N10tot"   value="<?=number_format($details->N10*10,2)?>" class="denomiform_md"    readonly="readonly" ><input type="hidden"  name="N10totv" id="N10totv" value="<?=$details->N10*10?>" /></td>
                          </tr>
                           <tr class="info" ><th colspan="3"> COINS</th></tr>
                           <tr><td>10</td>
                          <td align="right"> <input type="text"  name="C10" id="C10"   class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('C10','10',this.value)" required="required" value="<?=$details->C10?>" ></td>
                           <td align="right" > <input type="text"  name="C10tot" id="C10tot"   value="<?=number_format($details->C10*10,2)?>" class="denomiform_md"    readonly="readonly" ><input type="hidden"  name="V10totv" id="C10totv" value="<?=$details->C10*10?>"></td>
                          </tr>
                           <tr><td>5</td>
                          <td align="right"> <input type="text"  name="C5" id="C5"   class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('C5','5',this.value)" required="required" value="<?=$details->C5?>" ></td>
                           <td align="right" > <input type="text"  name="C5tot" id="C5tot"   value="<?=number_format($details->C5*5,2)?>" class="denomiform_md"    readonly="readonly" ><input type="hidden"  name="V5totv" id="C5totv" value="<?=$details->C5*5?>"></td>
                          </tr>
                           <tr><td>2</td>
                          <td align="right"> <input type="text"  name="C2" id="C2"   class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('C2','2',this.value)" required="required" value="<?=$details->C2?>" ></td>
                           <td align="right" > <input type="text"  name="C2tot" id="C2tot"   value="<?=number_format($details->C2*2,2)?>" class="denomiform_md"    readonly="readonly" ><input type="hidden"  name="V2totv" id="C2totv" value="<?=$details->C2*2?>"></td>
                          </tr>
                           <tr><td>1</td>
                          <td align="right"> <input type="text"  name="C1" id="C1"   class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('C1','1',this.value)" required="required" value="<?=$details->C1?>" ></td>
                           <td align="right" > <input type="text"  name="C1tot" id="C1tot"   value="<?=number_format($details->C1*1,2)?>" class="denomiform_md"    readonly="readonly" ><input type="hidden"  name="C1totv" id="C1totv" value="<?=$details->C1*1?>" ></td>
                          </tr>
                          <tr><td>0.50</td>
                          <td align="right"> <input type="text"  name="CC50" id="CC50"   class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('CC50','0.50',this.value)" required="required" value="<?=$details->CC50?>" ></td>
                           <td align="right" > <input type="text"  name="CC50tot" id="CC50tot"   value="<?=number_format($details->CC50*0.5,2)?>" class="denomiform_md"    readonly="readonly" ><input type="hidden"  name="CC50totv" id="CC50totv" value="<?=$details->CC50*0.5?>"></td>
                          </tr>
                          <tr><td>0.25</td>
                          <td align="right"> <input type="text"  name="CC25" id="CC25"   class="denomiform_sm"  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('CC25','0.25',this.value)" required="required" value="<?=$details->CC25?>" ></td>
                           <td align="right" > <input type="text"  name="CC25tot" id="CC25tot"   value="<?=number_format($details->CC25*0.25,2)?>" class="denomiform_md"    readonly="readonly" ><input type="hidden"  name="CC25totv" id="CC25totv" value="<?=$details->CC25*0.25?>" ></td>
                          </tr>
                          <tr><td>Bankbal</td>
                          <td align="right"> <input type="text"  name="bankbal" id="bankbal"   class="denomiform_sm"  style="width:70px;"
                  pattern="[0-9]+([\.][0-9]{0,2})?"  onblur="calculate_total('bankbal','1',this.value)" required="required" value="<?=$details->bankbal?>" ></td>
                           <td align="right" > <input type="text"  name="bankbaltot" id="bankbaltot"   value="<?=number_format($details->bankbal,2)?>" class="denomiform_md"    readonly="readonly" ><input type="hidden"  name="bankbaltotv" id="bankbaltotv" value="<?=$details->bankbal?>" ></td>
                          </tr>
                          <tr><td>Total</td>
                          <td align="right"></td>
                           <td align="right" > <input type="text"  name="total" id="total"   value="<?=number_format($physicalbal,2)?>" class="denomiform_md"    readonly="readonly" ><input type="hidden"  name="totalv" id="totalv" ></td>
                          </tr>
                          <tr>
                           <td colspan="3" align="right" ><div id="paymentdateid"><button type="submit" class="btn btn-primary disabled" >Update</button></div></td>
                          </tr>
                           
                          </table></form>
                          
                          </div>
                        
                        
                                 </div>
                                 
                                 </div>