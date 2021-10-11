<!DOCTYPE HTML>
<html>
<head>


    <?
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));
    $this->load->view("includes/topbar_accounts");
    ?>
    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Receipt Entry</h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/income/search"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
                                    <div class="form-body">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="voucher_no" id="voucher_no" placeholder="Voucher No">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="amountsearch" id="amountsearch" placeholder="Amount">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div  class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
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
                                    $c=0;
                                    foreach ($entry_data->result() as $rowdata)
                                    {
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

                                    </tr>
                                    <?
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                            </div>
                        </div>
                    </div>
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







