<script>
 function check_this_price()
 {
 var selable=document.getElementById('selable_area').value;
	//alert(selable);
	var selabletot=0;
	for(i=1; i<= 10; i++)
	{
		selabletot=parseFloat(selabletot)+parseFloat(document.getElementById('perches_count'+i).value);
	}

	if(selabletot!=selable)
	{
		document.getElementById('totalpurch').value=selabletot;
		//return false;
	}
	else
	{
		document.getElementById('totalpurch').value=selabletot;
		return true
	}
 }
 function calculate_salestot(i)
 {
	 subtot=parseFloat(document.getElementById('perches_count'+i).value)*parseFloat(document.getElementById('price'+i).value);
	 var mytot=0;
	  document.getElementById('tot'+i).value=subtot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	 for(t=1; t<= 10; t++)
	{
		 subtot=parseFloat(document.getElementById('perches_count'+t).value)*parseFloat(document.getElementById('price'+t).value);
		mytot=parseFloat(mytot)+parseFloat(subtot);
	}

	document.getElementById('totalsales').value=mytot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  var budget=parseFloat(document.getElementById('prj_budget').value);
  var margin_profit1=30;parseFloat(document.getElementById('profit_magin').value);
  budget=budget;
  if(parseFloat(budget)>0){
	 // alert(mytot)
    var magin_profit=parseFloat(mytot-budget)/parseFloat(budget)*100;
	if(magin_profit<0)
	{
	document.getElementById("bar").className = "bar red";
    document.getElementById("bar").style.width ='0'+"%";
	}
	else if(magin_profit> 0 & magin_profit< 20)
	{
		document.getElementById("bar").className = "bar red";
   		 document.getElementById("bar").style.width =magin_profit+"%";
	}
	else if(magin_profit>= 20 & magin_profit < parseFloat(margin_profit1))
	{
		document.getElementById("bar").className = "bar yellow";
   		 document.getElementById("bar").style.width =magin_profit+"%";
	}
	else
	{
		document.getElementById("bar").className = "bar green";
   		 document.getElementById("bar").style.width =magin_profit+"%";
	}
	magin_profit=magin_profit.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	 document.getElementById("presentval").innerHTML=magin_profit+"%";

  }


 }

</script>
 <? $this->load->view("includes/flashmessage");?>
<form data-toggle="validator"  method="post" action="<?=base_url()?>re/feasibility/add_price" enctype="multipart/form-data">
                       <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                       <input type="hidden" name="prj_budget" id="prj_budget" value="<?=$tot_budget?>">
                       <input type="hidden" name="profit_magin" id="profit_magin" value="<?=get_rate('profit margin')?>">


                        <div class="row">
						  <div class="  widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h4>Perch Price</h4>
							</div>
					              <div class="form-body">
                          <h4>Profit Magin</h4>
                          <?
                          $margin=0;
                          $margin_budget=$tot_budget+($tot_budget*get_rate('profit margin')/100);
                          $sales_tot=0;
						  $profmargin=get_rate('profit margin');
                          if($perch_price){
           foreach($perch_price as $raw) {
             $sales_tot=$sales_tot+$raw->perches_count*$raw->price;
           }}
           $margin=($sales_tot-$tot_budget)/$tot_budget*100;
		   $class='';
		   if($margin<0)
			{
				$class= "bar red";

			}
			else if($margin> 0 & $margin< 20)
			{
				$class= "bar red";

			}
			else if($margin>= 20 & $margin < $profmargin)
			{
				$class= "bar yellow";

			}
			else
			{
				$class= "bar green";

			}
                          ?>
                          	<div class="task-info">
									<span class="task-desc"></span><span class="percentage" id="presentval"><?=number_format($margin,2)?>%</span>
 									   <div class="clearfix"></div>
									</div>
                          <div class="progress progress-striped active">
        										 <div class="<?=$class?>" style="width:<?=$margin?>%;" id="bar"></div>
        									</div>

                                   <table class="table gridexample"> <thead> <tr> <th >ID</th> <th >Extend Perch</th>  <th >Perch Price</th><th width="30%">Sales Value </th></tr> </thead>
                                   <? $count=1; $tot=0; if($perch_price){
									  foreach($perch_price as $raw) {
										  $tot=$tot+$raw->perches_count*$raw->price;
									   ?>
                                  <tr> <td><?=$count?></td>
                                   <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="perches_count<?=$count?>" id="perches_count<?=$count?>" pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$raw->perches_count?>"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                    <td> <div class="form-group has-feedback" ><input type="text"  class="form-control number-separator" name="price<?=$count?>"  id="price<?=$count?>" pattern="[0-9]+([\.][0-9]{0,3})?" value="<?=$raw->price?>" onblur="calculate_salestot('<?=$count?>')" ><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="tot<?=$count?>" id="tot<?=$count?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=number_format($raw->perches_count*$raw->price,2)?>" readonly="readonly"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td></tr>
                                   <?  $count++; }
								   if($count<10){
									    for($i=$count; $i<=10; $i++){?>
                                  <tr> <td><?=$i?></td>
                                   <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="perches_count<?=$i?>" id="perches_count<?=$i?>" value="0"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                    <td> <div class="form-group has-feedback" ><input type="text"  class="form-control number-separator" name="price<?=$i?>"  id="price<?=$i?>" pattern="[0-9]+([\.][0-9]{0,3})?" value="0"  onblur="calculate_salestot('<?=$i?>')"><span class="glyphicon form-control-feedback"   aria-hidden="true"></span>
										
									</div></td>
                                     <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="tot<?=$i?>" id="tot<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0"  readonly="readonly"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td></tr>
                                   <? }

								   }

								    } else{ for($i=1; $i<=10; $i++){?>
                                 <tr> <td><?=$i?></td>
                                   <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="perches_count<?=$i?>" id="perches_count<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                    <td> <div class="form-group has-feedback" ><input type="text"  class="form-control number-separator" name="price<?=$i?>"  id="price<?=$i?>" pattern="[0-9]+([\.][0-9]{0,3})?" value="0"  onblur="calculate_salestot('<?=$i?>')"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="tot<?=$i?>" id="tot<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0"  readonly="readonly"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>

									</div></td></tr>
                                   <? }} ?>

                                   <tr> <td><strong>Total</strong></td>
                                   <td><div class="form-group has-feedback" ><input type="text"    class="form-control" name="totalpurch" id="totalpurch"   pattern="[0-9]+([\.][0-9]{0,2})?"  value="<?=$details->selable_area?>"   required="required" data-error="This total Must be equal to selable extend"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span></div></td><td></td>
                                    <td> <div class="form-group has-feedback" ><input type="text"    class="form-control" name="totalsales" id="totalsales"   pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=number_format($tot,2)?>"  data-error="Total Ep rates Must euql to 100" readonly="readonly"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                    </tr></table>

								  <br />
                                   <? if($details->status=='PENDING'){?>
                                    <div class="bottom ">

											<div class="form-group validation-grids" style="float:right">
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_price()">Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
                                        <? }?>

						</div>

                        </div>
                        <div class="clearfix"> </div></div>



					</form>
