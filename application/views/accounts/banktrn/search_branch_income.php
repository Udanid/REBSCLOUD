 <script type="text/javascript">
   function checkAll(obj)
    {


        var rawmatcount=document.getElementById("rawmatcount").value;
        if(obj.checked){
            for(i=1; i<=rawmatcount; i++)
            {

                totobj=eval("document.myform.isselect"+i);
                totobj.checked=true;

            }
        }
        else{
            for(i=1; i<=rawmatcount; i++)
            {
//alert("ss")
                totobj=eval("document.myform.isselect"+i);
                totobj.checked=false;
//alert(units+avbunits);
            }
        }
        calculatetot();
    }

function validate_currentval(i)
{
	
	
	
	var amount=document.getElementById("trnamount"+i).value;
	var balance=document.getElementById("balance"+i).value;
	amount=amount.replace(/\,/g,'');
	
	if(parseFloat(amount)>parseFloat(balance))
	{
		
	 document.getElementById("checkflagmessage").innerHTML='Pay Amount exseed Balance Amount'; 
					 $('#flagchertbtn').click();
					 document.getElementById("trnamount"+i).value=balance;
	}
	calculatetot();
}
    function calculatetot()
    {

        var tot=0;

        var rawmatcount=document.myform.rawmatcount.value;
		
      
        for(i=1; i<=rawmatcount; i++)
        {

            totobj=eval("document.myform.isselect"+i);

            amount=eval("document.myform.trnamount"+i);
			amount=amount.value;
			//alert(amount);
			amount=amount.replace(/\,/g,'');
			document.getElementById("trnamount_val"+i).value=parseFloat(amount);
			document.getElementById("trnamount"+i).value=parseFloat(amount).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
            if(totobj.checked)
            {

                tot=parseFloat(tot)+parseFloat(amount);

            }

        }
        if(tot!=0)
        {
            document.myform.total.value=parseFloat(tot).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
			document.myform.total_val.value=tot
        }
        else
        {
            document.myform.total.value="";
			document.myform.total_val.value="";
        }
    }
	function check_beforsubmit()
	{
	
		var bank=document.getElementById('banks').value;
		var total=document.getElementById('total_val').value;
		var totaln=document.getElementById('total').value;
		if(bank=="")
		{
		
			 document.getElementById("checkflagmessage").innerHTML='Select Bank Account'; 
					 $('#flagchertbtn').click();
					 document.getElementById("banks").value="";
		}
		if(total=="")
		{
			 document.getElementById("checkflagmessage").innerHTML='Total Amount couldnt be Zero'; 
					 $('#flagchertbtn').click();
					  document.getElementById("total").value="";
		}
		if(parseFloat(totaln)==0)
		{
			 document.getElementById("checkflagmessage").innerHTML='Total Amount couldnt be Zero'; 
					 $('#flagchertbtn').click();
					  document.getElementById("total").value="";
		}
	}
 </script>
   <div class="tableFixHead"> 
 <table class="table">
            <thead>
            <tr class="active">
                <th>ID</th>
                <th>Temp Code</th>
                <th>Income Type</th>
                <th>Amount</th>
                <th>Income Date</th>
                <th>Receipt Number</th>
                 <th>Transfer Amount</th>
                  <th>Balance  Amount</th>
                  <th>Current Transfer  Amount</th>
                <th colspan="3"><input class="form-control" type="checkbox" value="Yes" name="selectall" onclick="checkAll(this)" /></th>
            </tr>
            </thead><tbody>
            <?php
$counter=0;
            if ($ac_incomes){
            $c=0;
            foreach($ac_incomes as $rowdata){ $counter++;
            ?>
            
            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <th scope="row"><?=$rowdata->id?></th>
                <td align="center"><?=$rowdata->temp_code ?></td>
                <td> <?=$rowdata->income_type ?></td>
                <td align=right ><?=number_format($rowdata->amount, 2, '.', ',')?></td>
                <td> <?=$rowdata->income_date ?></td>
                <td> <?=$rowdata->rct_no ?></td>
                <td> <?=$rowdata->trn_amount ?></td>
                <td> <?=$rowdata->amount-$rowdata->trn_amount ?></td>
                <? $balance=$rowdata->amount-$rowdata->trn_amount;?>
                 <td><input style="width: 100%;" class="form-control" type="text" step="0.01" name="trnamount<?=$counter?>" id="trnamount<?=$counter?>"  value="<?=$balance ?>"  onblur="validate_currentval('<?=$counter?>')"/>
                 <input style="width: 100%;" class="form-control" type="hidden" name="trnamount_val<?=$counter?>" id="trnamount_val<?=$counter?>"  value="<?=$balance ?>" />
                  <input style="width: 100%;" class="form-control" type="hidden" name="balance<?=$counter?>" id="balance<?=$counter?>"  value="<?=$balance ?>" />
                        <input style="width: 100%;" class="form-control" type="hidden" name="transferd<?=$counter?>" id="transferd<?=$counter?>"  value="<?=$rowdata->trn_amount ?>" />
              <input style="width: 100%;" class="form-control" type="hidden" name="fullamount<?=$counter?>" id="fullamount<?=$counter?>"  value="<?=$rowdata->amount ?>" />
             
                   <input style="width: 100%;" class="form-control" type="hidden" name="pay_id<?=$counter?>" id="pay_id<?=$counter?>"  value="<?=$rowdata->id ?>" /></td>
              

                        <td>
                            <input class="form-control" type="checkbox" value="Yes" name="isselect<?=$counter?>" id="isselect<?=$counter?>"  onclick="calculatetot()"/>
                        </td>

<!--                        <td>-->
<!--                            <a href="javascript:delete_payment('--><?// echo $rowdata->id; ?><!--')"><i-->
<!--                                    class="fa fa-trash-o nav_icon icon_blue"></i></a>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <a href="javascript:confirm_payment('--><?// echo $rowdata->id; ?><!--')"><i-->
<!--                                    class="fa fa-check-square-o nav_icon icon_blue"></i></a>-->
<!--                        </td>-->

            </tr>
            <?
            }}
            ?>
            </tbody>
             <tr class="tr-group" style="background-color:#FFFFE6;">
            <td colspan="4 ">Total</td>
            <td><input style="width: 100%;" class="form-control" type="text" step="0.00" name="total" id="total"  value="0"  required="required" />
            <input style="width: 100%;" class="form-control" type="hidden" name="total_val" id="total_val"  value="0" /><input type="hidden" name="rawmatcount" id="rawmatcount" value="<?=$counter?>" /></td>
        </tr>
        </table></div>
         <div class="form-group">
                    <button type="submit" class="btn btn-primary " onclick="check_beforsubmit()">Transfer Cash</button>
                </div>