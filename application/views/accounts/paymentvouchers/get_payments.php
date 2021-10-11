
<script type="text/javascript">

    $(document).ready(function() {

        $("#empsearch").chosen({
            allow_single_deselect : true
        });

    });


    function delete_payment(id)
    {
        var r=confirm("Are you sure you want to delete this payment voucher?")
        if (r==true)
        {
            $.ajax({
                cache: false,
                type: 'POST',
                url: '<?php echo base_url().'accounts/paymentvouchers/delete';?>',
                data: {id: id },
                success: function(data) {
                    if (data) {
                        alert(data);
                        location.reload();
                        alert("delete success");
                    }
                    else
                    {
                        alert("delete failed");
                    }
                }
            });
        }
    }

    function confirm_payment(id) {
        var r=confirm("Are you sure you want to confirm this payment voucher?")
        if (r==true)
        {
            $.ajax({
                cache: false,
                type: 'POST',
                url: '<?php echo base_url().'accounts/paymentvouchers/confirm';?>',
                data: {id: id },
                success: function(data) {
                    if (data) {
                        alert(data);
                        location.reload();
                        alert("confirm success");
                    }
                    else
                    {
                        alert("confirm failed");
                    }
                }
            });
        }
    }

    function check_activeflag(id)
    {
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_payvoucherdata', id: id,fieldname:'voucherid' },
            success: function(data) {
                if (data) {
                    // alert(data);
                    document.getElementById("checkflagmessage").innerHTML=data;
                    $('#mylistkkk').click();

                    //document.getElementById('mylistkkk').style.display='block';
                }
                else
                {
                    $('#popupform').delay(1).fadeIn(600);
                    $( "#popupform" ).load( "<?=base_url()?>accounts/paymentvouchers/edit/"+id );
                }
            }
        });
    }

    function close_edit(id)
    {
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'ac_payvoucherdata', id: id,fieldname:'voucherid' },
            success: function(data) {
                if (data) {
                    $('#popupform').delay(1).fadeOut(800);

                    //document.getElementById('mylistkkk').style.display='block';
                }
                else
                {
                    document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
                    $('#mylistkkk').click();

                }
            }
        });
    }

</script>
<form data-toggle="validator" method="post" action="<?=base_url()?>accounts/paymentvouchers/search" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                    <div class="form-group">
                    <input type="hidden" name="empsearch"    id="empsearch"   value="" />              
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" id="search" placeholder="Voucher Number">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="amountsearch" id="amountsearch" placeholder="Amount">
                    </div>
                    <div class="form-group">
                        <button  type="submit" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
        <table class="table">
            <thead>
                <tr>
                    <th>Voucher Number</th>
                    <th>Invoice /Document No</th>
                    <th>Payee Name</th>
                    <th>Payment Type</th>
                    <th>Amount</th>
                    <th>Apply Date</th>
                    <th>Status</th>
                    <th colspan="3"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                if ($ac_projects){
                    $c=0;
                    foreach($ac_projects as $rowdata){
                ?>

                <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                    <th scope="row"><?=$rowdata->voucherid?></th>
                    <td align="center"><?=$rowdata->refnumber ?></td>
                    <td> <?=$rowdata->payeename ?></td>
                    <td> <?=$rowdata->typename ?></td>
                    <td align=right ><?=$rowdata->amount?></td>
                    <td> <?=$rowdata->applydate ?></td>
                    <td> <?=$rowdata->status ?></td>

                    <?php
                  
                        if ($rowdata->status == "PENDING") {
                            ?>
                            <td>
                            <?  if($rowdata->typeid!='6') {?>
                                <div id="checher_flag">
                                    <a href="javascript:check_activeflag('<? echo $rowdata->voucherid; ?>')"><i
                                            class="fa fa-edit nav_icon icon_blue"></i></a>
                                </div>
                                <? }?>
                            </td>

                            <td><?  if($rowdata->typeid!='6') {?>
                        <?  if ( check_access('confirm vouchers'))
		
                    {  ?>
<!--                                <a href="javascript:delete_payment('--><?// echo $rowdata->voucherid; ?><!--')"><i-->
<!--                                        class="fa fa-trash-o nav_icon icon_blue"></i></a>-->
                                <a  href="javascript:call_delete_voucher('<?=$rowdata->voucherid?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i>
                                </a>
								<? }?>
								<? }?>
                            </td>
                            <td>
                                <a href="javascript:call_confirm_voucher('<? echo $rowdata->voucherid; ?>')"><i
                                        class="fa fa-check-square-o nav_icon icon_blue"></i></a>
                            </td>
                            <?php
                        }
                        if ($rowdata->status == "CONFIRMED") {
				  if ( delete_payvoucher_check($rowdata->voucherid))
				  {
                            ?>
                           
                            <td>
                                <a href="javascript:call_delete_voucher('<? echo $rowdata->voucherid; ?>')"><i
                                        class="fa fa-trash-o nav_icon icon_blue"></i></a>
                            </td>
                            <?php
						}
                        }
                   
                    ?>
                </tr>
                <?
                }}
                ?>
            </tbody>
        </table>
    </div>
</div>
<!--<div id="get_paymentvoucherdata" ></div>-->

  