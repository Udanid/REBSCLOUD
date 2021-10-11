<!DOCTYPE HTML>
<html>
<head>


<?
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_accounts");
?>
    <script>
        function load_search_data(obj)
        {

            var value1 =obj


            if(value1!="" ){

                value=value1;
                document.getElementById("seachlocator").style.display='block';

                popupdetails("accounts/payments/preview",value,'seachlocator')
            }
            else
            {
                document.getElementById("seachlocator").style.display='none';
            }


        }
        function closewindow()
        {
            document.getElementById("seachlocator").style.display='none';
        }

    </script>

    <script type="text/javascript">

        function close_edit(id)
        {

            // var vendor_no = src.value;
//alert(id);

            $.ajax({
                cache: false,
                type: 'GET',
                url: '<?php echo base_url().'common/delete_activflag/';?>',
                data: {table: 're_projectms', id: id,fieldname:'prj_id' },
                success: function(data) {
                    if (data) {
                        $('#popupform').delay(1).fadeOut(800);

                        //document.getElementById('mylistkkk').style.display='block';
                    }
                    else
                    {
                        document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
                        $('#flagchertbtn').click();

                    }
                }
            });
        }
        var deleteid="";
        function call_delete(id)
        {
            alert(id);
            document.deletekeyform.deletekey.value=id;
            $.ajax({
                cache: false,
                type: 'GET',
                url: '<?php echo base_url().'common/activeflag_cheker/';?>',
                data: {table: 'ac_entries', id: id,fieldname:'id' },
                success: function(data) {
                    if (data) {
                        // alert(data);
                        document.getElementById("checkflagmessage").innerHTML=data;
                        $('#flagchertbtn').click();

                        //document.getElementById('mylistkkk').style.display='block';
                    }
                    else
                    {
                        $('#complexConfirm').click();
                    }
                }
            });


//alert(document.testform.deletekey.value);

        }

        function call_confirm(id)
        {
            document.deletekeyform.deletekey.value=id;
            $.ajax({
                cache: false,
                type: 'GET',
                url: '<?php echo base_url().'common/activeflag_cheker/';?>',
                data: {table: 'ac_entries', id: id,fieldname:'id' },
                success: function(data) {
                    if (data) {
                        // alert(data);
                        document.getElementById("checkflagmessage").innerHTML=data;
                        $('#flagchertbtn').click();

                        //document.getElementById('mylistkkk').style.display='block';
                    }
                    else
                    {
                        $('#complexConfirm_confirm').click();
                    }
                }
            });
        }

        function call_cancel(id)
        {

            document.deletekeyform.deletekey.value=id;
            $.ajax({
                cache: false,
                type: 'GET',
                url: '<?php echo base_url().'common/activeflag_cheker/';?>',
                data: {table: 'ac_entries', id: id,fieldname:'id' },
                success: function(data) {
                    if (data) {
                        // alert(data);
                        document.getElementById("checkflagmessage").innerHTML=data;
                        $('#flagchertbtn').click();

                        //document.getElementById('mylistkkk').style.display='block';
                    }
                    else
                    {
                        $('#complexConfirm_cancel').click();
                    }
                }
            });
        }
        function call_cancel_cheque(id)
        {

            document.deletekeyform.deletekey.value=id;
            $.ajax({
                cache: false,
                type: 'GET',
                url: '<?php echo base_url().'common/activeflag_cheker/';?>',
                data: {table: 'ac_entries', id: id,fieldname:'id' },
                success: function(data) {
                    if (data) {
                        // alert(data);
                        document.getElementById("checkflagmessage").innerHTML=data;
                        $('#flagchertbtn').click();

                        //document.getElementById('mylistkkk').style.display='block';
                    }
                    else
                    {
                        $('#complexConfirm_cancelCheque').click();
                    }
                }
            });
        }



    </script>

    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Receipt Entry</h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/payments/search"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
                                    <div class="form-body">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Payee Name">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="entry_no" id="entry_no" placeholder="Entry Number">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="amountsearch" id="amountsearch" placeholder="Amount">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="cheque_no" id="cheque_no" placeholder="Cheque No">
                                            </div>
                                            <div class="form-group">
                                                <button  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
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
                                        <th>Date</th>
                                        <th>No</th>
                                        <th>Ledger Account</th>
                                        <th>Cheque No</th>
                                        <th>Amount</th>
                                        <th>Cheque Status</th>
                                        <th colspan="3"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $c=0;
                                    foreach ($entry_data->result() as $row)
                                    {
                                        if($row->CHQSTATUS 	!="CANCEL"){
                                            if($row->id!=""){	$current_entry_type = entry_type_info($row->entry_type);
                                            }
                                            ?>

                                            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                                <td> <? echo $row->date; ?></td>
                                            <?

                                            if($row->id!=""){echo "<td>" . anchor('accounts/payments/view/payment/' . $row->id, full_entry_number($row->entry_type, $row->number), array('title' => 'View Payment Entry', 'class' => 'anchor-link-a')) . "</td>";}
                                            else echo "<td></td>";
                                            echo "<td>";
                                            if($row->id!=""){	echo  $this->Ledger_model->get_entry_name($row->id, $row->entry_type);}
                                            echo "</td>";

                                            echo "<td>" . $row->CHQNO . "</td>";
                                            echo "<td align=right>" . number_format($row->dr_total, 2, '.', ',') . "</td>";
                                            echo "<td>" . $row->CHQSTATUS . "</td>";
                                            echo "<td>";
                                            //print_r($voucherlist[$row->CHQNO]->result());
                                            if($row->id!=""){
                                                foreach($voucherlist[$row->CHQNO]->result() as $rownew)
                                                {
                                                    //echo $rownew->voucherid.' , ';
//                                                    ?><!-- <a href="javascript:load_search_data('--><?//=$rownew->voucherid?><!--')">--><?//=$rownew->voucherid?><!--</a> ,--><?//

                                                }}
                                            echo "</td>";
                                            if( $row->CHQSTATUS=="QUEUE"){
                                                ?>
                                                <td>
                                                <a href="<?= base_url() ?>accounts/payments/edit/<? echo $row->id ?>">
                                                    <i class="fa fa-edit nav_icon icon_blue"></i>
                                                </a>
<!--                                                    <a onclick="return confirm('Are you sure you want to delete this Payment Entry?');" href="--><?//= base_url() ?><!--accounts/payments/delete/--><?// echo $row->id ?><!--"-->
<!--                                                       class="confirmClick">-->
<!--                                                        <i class="fa fa-trash-o nav_icon icon_blue"></i>-->
<!--                                                    </a>-->
                                                    <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i></a>
<!--                                                    <a onclick="return confirm('Are you sure you want to confirm this Payment Entry?');" href="--><?//= base_url() ?><!--accounts/payments/confirm/--><?// echo $row->id ?><!--"-->
<!--                                                       class="confirmClick">-->
<!--                                                        <i class="fa fa-check-square-o nav_icon icon_blue"></i>-->
<!--                                                    </a>-->
                                                    <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check-square-o nav_icon icon_blue"></i></a>
                                                </td>
                                                <?

                                            }
                                            
                                            if( $row->CHQSTATUS=="PRINT"){
                                                
                                                ?>
                                                <td>
<!--                                                    <a onclick="return confirm('Are you sure you want to cancel this payment Entry?');" title="Cancel" href="--><?//= base_url() ?><!--accounts/payments/cancelation/--><?// echo $row->id ?><!--">-->
<!--                                                        <i class="fa fa-times nav_icon icon_red"></i>-->
<!--                                                    </a>-->
                                                    <a  href="javascript:call_cancel('<?=$row->id?>')" title="Cancel Receipt"><i class="fa fa-times nav_icon icon_red"></i></a>
<!--                                                    <a onclick="return confirm('Are you sure you want to cancel cheque?');" title="Cancel Cheque" href="--><?//= base_url() ?><!--accounts/payments/cancelation_cheque/--><?// echo $row->id ?><!--">-->
<!--                                                        <i class="fa fa-times nav_icon icon_blue"></i>-->
<!--                                                    </a>-->
                                                    <a  href="javascript:call_cancel_cheque('<?=$row->id?>')" title="Cancel Cheque"><i class="fa fa-times nav_icon icon_blue"></i></a>
                                                    <?
                                                    echo "" . anchor('accounts/payments/printpreview/'. $row->id , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Re Print ' . $current_entry_type['name'] . ' Entry')), array('title' => 'Reprint  Cheque ' . $row->CHQNO, 'target' => '_blank')) ;
                                                    ?>

                                                </td>
                                                <?
                                             }
                                            if($this->session->userdata('user_role')=='manager' & $row->CHQSTATUS=="CONFIRM")
                                            {
                                                ?>
                                                <a href="<?= base_url() ?>accounts/payments/edit/<? echo $row->id ?>">
                                                    <i class="fa fa-edit nav_icon icon_blue"></i>
                                                </a>
                                                <?

                                            }
                                                
                                            echo "</tr>";}

                                        else{
                                            echo "<tr>";

                                            echo "<td>" . $row->CRDATE . "</td>";
                                            echo "<td colspan=\"2\"> Reason for cancelation " . $row->CNRES . "</td>";
                                            echo "<td>" . $row->CHQNO . "</td>";
                                            echo "<td> </td>";
                                            echo "<td>" . $row->CHQSTATUS . "</td>";

                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <div id="seachlocator"></div>
                            </div>
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
                    <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
                    <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_cancel" name="complexConfirm_cancel"  value="DELETE"></button>
                    <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_cancelCheque" name="complexConfirm_cancelCheque"  value="DELETE"></button>
                    <form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
                    </form>
                    <script>
                        $("#complexConfirm").confirm({
                            title:"Delete confirmation",
                            text: "Are You sure you want to delete this ?" ,
                            headerClass:"modal-header",
                            confirm: function(button) {
                                button.fadeOut(2000).fadeIn(2000);
                                var code=1
                                window.location="<?=base_url()?>accounts/payments/delete/"+document.deletekeyform.deletekey.value;
                            },
                            cancel: function(button) {
                                button.fadeOut(2000).fadeIn(2000);
                                // alert("You aborted the operation.");
                            },
                            confirmButton: "Yes I am",
                            cancelButton: "No"
                        });

                        $("#complexConfirm_confirm").confirm({
                            title:"Record confirmation",
                            text: "Are You sure you want to confirm this ?" ,
                            headerClass:"modal-header confirmbox_green",
                            confirm: function(button) {
                                button.fadeOut(2000).fadeIn(2000);
                                var code=1

                                window.location="<?=base_url()?>accounts/payments/confirm/"+document.deletekeyform.deletekey.value;
                            },
                            cancel: function(button) {
                                button.fadeOut(2000).fadeIn(2000);
                                // alert("You aborted the operation.");
                            },
                            confirmButton: "Yes I am",
                            cancelButton: "No"
                        });
                        $("#complexConfirm_cancel").confirm({
                            title:"Record confirmation",
                            text: "Are You sure you want to cancel this ?" ,
                            headerClass:"modal-header",
                            confirm: function(button) {
                                button.fadeOut(2000).fadeIn(2000);
                                var code=1

                                window.location="<?=base_url()?>accounts/payments/cancelation/"+document.deletekeyform.deletekey.value;
                            },
                            cancel: function(button) {
                                button.fadeOut(2000).fadeIn(2000);
                                // alert("You aborted the operation.");
                            },
                            confirmButton: "Yes I am",
                            cancelButton: "No"
                        });
                        $("#complexConfirm_cancelCheque").confirm({
                            title:"Record confirmation",
                            text: "Are You sure you want to cancel this ?" ,
                            headerClass:"modal-header",
                            confirm: function(button) {
                                button.fadeOut(2000).fadeIn(2000);
                                var code=1

                                window.location="<?=base_url()?>accounts/payments/cancelation_cheque/"+document.deletekeyform.deletekey.value;
                            },
                            cancel: function(button) {
                                button.fadeOut(2000).fadeIn(2000);
                                // alert("You aborted the operation.");
                            },
                            confirmButton: "Yes I am",
                            cancelButton: "No"
                        });
                    </script>

                    <div class="row calender widget-shadow"  style="display:none">
                        <h4 class="title">Calender</h4>
                        <div class="cal1"></div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </div>
<?
$this->load->view("includes/footer");
?>