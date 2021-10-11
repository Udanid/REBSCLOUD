 <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Entry ID</th>
                <th>Bank</th>
                <th>Narration</th>
                <th>Transfer Amount</th>
                <th>Transfer  Date</th>
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
                   <td> <?=$rowdata->narration ?></td>
                <td align=right ><?=number_format($rowdata->amount, 2, '.', ',')?></td>
                <td> <?=$rowdata->date ?></td>
         
                        <td>
                             <div id="checher_flag">
                                   <a  href="javascript:check_activeflag('<?=$rowdata->trn_entryid?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                      
                            </div>
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
