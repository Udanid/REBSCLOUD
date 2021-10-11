
<!---->
<!--<form data-toggle="validator" method="post" action="--><?//=base_url()?><!--accounts/group/search"  enctype="multipart/form-data">-->
<!--    <div class="row">-->
<!--        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">-->
<!--            <div class="form-body">-->
<!--                <div class="form-inline">-->
<!--                    <div class="form-group">-->
<!--                        <input type="text" class="form-control" name="voucher_no" id="voucher_no" placeholder="Voucher Number">-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <input type="text" class="form-control" name="amountsearch" id="amountsearch" placeholder="Amount">-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <button type="submit"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</form>-->

<div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Parent ID</th>
                <th>Name</th>
                <th>Affect Gross</th>
                <th colspan="3"></th>
            </tr>
            </thead>
            <?php

            if ($entry_data){
            $c=0;
            foreach($entry_data as $rowdata){
            ?>
            <tbody>
            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <th scope="row"><?=$rowdata->id?></th>
                <td align="center"><?=$rowdata->parent_id ?></td>
                <td> <?=$rowdata->name ?></td>
                <td> <?=$rowdata->affects_gross ?></td>

                <td>
                    <div id="checher_flag">
                        <a  href="javascript:call_delete('<?=$rowdata->id?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i></a>
<!--                        <a onclick="return confirm('Are you sure you want to delete this Group?');" href="--><?//= base_url() ?><!--accounts/group/delete_group/--><?// echo $rowdata->id ?><!--">-->
<!--                            <i class="fa fa-trash-o nav_icon icon_blue"></i>-->
<!--                        </a>-->
                    </div>
                </td>
            </tr>
            <?
            }}
            ?>
            </tbody>
        </table>

    </div>
</div>

<div class="col-md-4 modal-grids">
    <button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
    <div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
                </div>
                <div class="modal-body" id="checkflagmessage"> Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
                </div>
            </div>
        </div>
    </div>
</div>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>

