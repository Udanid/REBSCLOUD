 <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Temp Code</th>
                <th>Income Type</th>
                <th>Amount</th>
                <th>Income Date</th>
                <th>Status</th>
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
                <th scope="row"><?=$rowdata->id?></th>
                <td align="center"><?=$rowdata->temp_code ?></td>
                <td> <?=$rowdata->income_type ?></td>
                <td align=right ><?=number_format($rowdata->amount, 2, '.', ',')?></td>
                <td> <?=$rowdata->income_date ?></td>
                <td> <?=$rowdata->pay_status ?></td>

                        <td>
                            <div id="checher_flag">
                                <a href="<?= base_url() ?>hm/income/add/<? echo $rowdata->id ?>">
                                    <i class="fa fa-plus-square-o nav_icon icon_blue"></i>
                                </a>
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
           
              if ($ac_incomes2){
            $c=0;
            foreach($ac_incomes2 as $rowdata){
            ?>
            <tbody>
            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <th scope="row"><?=$rowdata->id?></th>
                <td align="center"><?=$rowdata->temp_code ?></td>
                <td> <?=$rowdata->income_type ?></td>
                <td align=right ><?=number_format($rowdata->amount, 2, '.', ',')?></td>
                <td> <?=$rowdata->income_date ?></td>
                <td> <?=$rowdata->pay_status ?></td>

                        <td>
                            <div id="checher_flag">
                                <a href="<?= base_url() ?>accounts/income/add/<? echo $rowdata->id ?>">
                                    <i class="fa fa-plus-square-o nav_icon icon_blue"></i>
                                </a>
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