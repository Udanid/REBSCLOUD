
	<script type="text/javascript">

function load_printscrean1(id)
{
			window.open( "<?=base_url()?>accounts/cashier/print_entry/"+id);
	
}
function load_pdf(id)
{
			window.open( "<?=base_url()?>re/lotdata/load_pdf/"+id);
	
}
function load_excel(id)
{
			window.open( "<?=base_url()?>re/lotdata/load_excel/"+id);
	
}
</script>
 <h4>Bank Transfer List
 </h4>
<br />
<?
//echo project_expence($details->prj_id);

?>
 <div class="table-responsive bs-example widget-shadow"  >
 <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Entry ID</th>
                <th>Bank</th>
                <th>RCT No</th>
                <th>Transfer Amount</th>
                 <th>Balance Amount</th>
              
                <th>Transfer  Date</th>
                 <th>Transfer by</th>
                 <th colspan="3"></th>
            </tr>
            </thead>
            <?php

            if ($ac_incomes){
            $c=0;
            foreach($ac_incomes as $rowdata){
            ?>
            <tbody>
            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <th scope="row"><?=$c?></th>
                <td align="center"><?=$rowdata->trn_entryid ?></td>
                <td> <?=$rowdata->trn_bank ?></td>
                   <td> <?=$rowdata->rct_no ?></td>
                <td align=right ><?=number_format($rowdata->trn_amount, 2, '.', ',')?></td>
                 <td align=right ><?=number_format($rowdata->amount-$rowdata->fulltrn, 2, '.', ',')?></td>
                <td> <?=$rowdata->trn_date ?></td>
                 <td> <?=$rowdata->trn_by ?></td>
         
                        <td>
                           
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
        </table>
</div>

