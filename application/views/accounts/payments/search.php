
<!DOCTYPE HTML>
<html>
<head>


    <?
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));

    $this->load->view("includes/topbar_accounts");
    ?>
    <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
    <script type="text/javascript">
       

        
        function check_activeflag1(id)
        {

            // var vendor_no = src.value;
      alert(id);
 			 document.getElementById("checkflagmessage").innerHTML='ssss';
                        $('#flagchertbtn').click();
           
        }
        function call_comment(id)
        {
            $('#popupform').delay(1).fadeIn(600);
            $( "#popupform" ).load( "<?=base_url()?>re/project/comments/"+id );
        }
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
function call_delete_voucher(id)
{
    //alert('ok');
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_payvoucherdata', id: id,fieldname:'voucherid' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm_voucher').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}

function call_confirm_voucher(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_payvoucherdata', id: id,fieldname:'voucherid' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm_confirm_voucher').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}

  $(window).load(function(){
     $("#prj_id").chosen({
            allow_single_deselect : true,
            search_contains: true,
            no_results_text: "Oops, nothing found!",
            placeholder_text_single: "Project Name"
        });
    });


    </script>

    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Approvals </h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <div class="clearfix"> </div>
                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                            <li role="presentation"   <? if(!$this->session->flashdata('tab')){?> class="active"<? }?> >
                                <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Payment Approval</a></li>
                               <li role="presentation"  <? if($this->session->flashdata('tab')=='voucher'){?> class="active"<? }?>>
                                <a href="#budget" id="budget-tab" role="tab" data-toggle="tab" aria-controls="budget" aria-expanded="false">Payment Voucher Status</a></li>
                        </ul>

                        <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
                            <div role="tabpanel" class="tab-pane fade <? if(!$this->session->flashdata('tab')){?> active in<? }?>" id="main" aria-labelledby="main-tab">
                                <p> <div class="widget-shadow">
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
                                               <select class="form-control" placeholder="Qick Search.." id="prj_id" name="prj_id" >
                                                    <option value=""></option>
                                                    <?    foreach($prj_list as $row){?>
                                                        <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                                                     <? }?>
                                                 </select>
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
                                         <th>Payee Name</th>
                                         <th>Project Name</th>
                                        <th>Narration</th>
                                         <th>Bank</th>
                                        <th>Cheque No</th>
                                          <th>Voucher No</th>
                                        <th>Amount</th>
                                         <th>Confirmed By</th>
                                        <th>Cheque Status</th>
                                        
                                        <th colspan="3"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                    $c=0;
                                    foreach ($entry_data->result() as $row)
                                    {
                                        $current_entry_type = entry_type_info($row->entry_type);
                                    ?>
                                        <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                            <td><? echo $row->date; ?></td>
                                            <? echo "<td>" . anchor('accounts/payments/view/' . $current_entry_type['label'] . "/" . $row->id, full_entry_number($row->entry_type, $row->number), array('title' => 'View ' . $current_entry_type['name'] . ' Entry', 'class' => 'anchor-link-a')) . "</td>";
                                            echo "<td>";
                                             echo $row->CHQNAME;
                                              echo "</td><td>";
											echo get_voucher_by_entry($row->id);
 											echo "</td><td>";
                                                
                                                   echo $this->Tag_model->show_entry_tag($row->tag_id);
                                        
                                            echo  $row->narration;
                                            echo "</td>";
                                            echo "<td>";
                                         echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
                                        echo "</td>";
                                            ?>
                                            <td><? echo $row->CHQNO; ?></td>
                                                 <td><? echo get_voucher_ncode($row->id); ?></td>
                 
                                            <td align=right><? echo number_format($row->dr_total, 2, '.', ','); ?></td>
                                             <td align=right><? echo get_user_fullname_id($row->confirm_by); ?></td>
                        
                                            <?
                                            echo "<td align='center'>" ;if($row->CHQSTATUS)echo $row->CHQSTATUS; else echo $row->status ;echo "</td>";
                                            if( $row->CHQSTATUS=="QUEUE" || $row->status=="PENDING") {
                                                ?>
                                                <td>
                                                    <a href="<?= base_url() ?>accounts/payments/edit/<? echo $row->id ?>">
                                                        <i class="fa fa-edit nav_icon icon_blue"></i>
                                                    </a>
                        <!--                            <a onclick="return confirm('Are you sure you want to delete this Payment Entry?');" href="--><?//= base_url() ?><!--accounts/payments/delete/--><?// echo $row->id ?><!--"-->
                        <!--                               class="confirmClick">-->
                        <!--                                <i class="fa fa-trash-o nav_icon icon_blue"></i>-->
                        <!--                            </a>-->
                                                    <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i></a>
                        <!--                            <a onclick="return confirm('Are you sure you want to confirm this Payment Entry?');" href="--><?//= base_url() ?><!--accounts/payments/confirm/--><?// echo $row->id ?><!--"-->
                        <!--                               class="confirmClick">-->
                        <!--                                <i class="fa fa-check-square-o nav_icon icon_blue"></i>-->
                        <!--                            </a>-->
                                     <? if ( check_access('confirm payment'))
		
                    {  ?>
                                                    <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check-square-o nav_icon icon_blue"></i></a>
                                            <? }?>
                                                </td>
                                            <?
                                            }
                                            if( $row->CHQSTATUS=="PRINT"){
                                                ?>
                                                <td>
                        <!--                            <a onclick="return confirm('Are you sure you want to cancel this Payment Entry?');" title="Cancel" href="--><?//= base_url() ?><!--accounts/payments/cancelation/--><?// echo $row->id ?><!--">-->
                        <!--                                <i class="fa fa-times nav_icon icon_red"></i>-->
                        <!--                            </a>-->
                                                    <a  href="javascript:call_cancel('<?=$row->id?>')" title="Cancel Payment"><i class="fa fa-times nav_icon icon_red"></i></a>
                                                    <a  href="javascript:call_cancel_cheque('<?=$row->id?>')" title="Cancel Cheque"><i class="fa fa-times nav_icon icon_blue"></i></a>
                        <!--                            <a onclick="return confirm('Are you sure you want to cancel cheque?');" title="Cancel Cheque" href="--><?//= base_url() ?><!--accounts/payments/cancelation_cheque/--><?// echo $row->id ?><!--">-->
                        <!--                                <i class="fa fa-times nav_icon icon_blue"></i>-->
                        <!--                            </a>-->
                                                    <?
                                                //    echo "" . anchor('accounts/payments/printpreview/'. $row->id , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Re Print ' . $current_entry_type['name'] . ' Entry')), array('title' => 'Reprint  Cheque ' . $row->CHQNO, 'target' => '_blank')) ;
                                                    ?>
                        
                                                </td>
                                            <?
                                                }
                                            if($this->session->userdata('user_role')=='manager' & $row->CHQSTATUS=="CONFIRM")
                                            {
                                                ?>
                                                <td>
                                                    <a href="<?= base_url() ?>accounts/payments/edit/<? echo $row->id ?>">
                                                        <i class="fa fa-edit nav_icon icon_red"></i>
                                                    </a>
                                                </td>
                                            <?
                                            }
                                            ?>
                                        </tr>
                                    <?
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <div id="seachlocator"></div>
                            </div>
                        </div> </div> </div></p>
                            </div>
                      
                            <div role="tabpanel" class="tab-pane fade  <? if($this->session->flashdata('tab')=='voucher'){?>active in<? }?> " id="budget" aria-labelledby="budget-tab">
                                <p>	 
								<?  // $this->load->view("accounts/paymentvouchers/get_payments");?>
								<? // $this->load->view("accounts/payments/printqueue");?> </p>
                            </div>
                           

                        </div>
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
                            <div class="modal-body" id="checkflagmessage">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_cancel" name="complexConfirm_cancel"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_cancelCheque" name="complexConfirm_cancelCheque"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_voucher" name="complexConfirm_voucher"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_voucher" name="complexConfirm_confirm_voucher"  value="DELETE"></button>
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
				
				
				 $("#complexConfirm_voucher").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
                headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                    var code=1
                    window.location="<?=base_url()?>accounts/paymentvouchers/delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                    // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

            $("#complexConfirm_confirm_voucher").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
                headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                    var code=1

                    window.location="<?=base_url()?>accounts/paymentvouchers/confirm/"+document.deletekeyform.deletekey.value;
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
                <div class="cal1">

                </div>
            </div>



            <div class="clearfix"> </div>
        </div>
    </div>
    <!--footer-->
<?

$this->load->view("includes/footer");
?>