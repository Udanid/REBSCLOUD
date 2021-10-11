<!DOCTYPE HTML>
<html>
<head>

    <?
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));
    $this->load->view("includes/topbar_accounts");
    $this->load->model('Ledger_model');
    ?>

    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Accounts</h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <?
//                        if(! $print_preview ) {
//                            ?>
<!--                            <form data-toggle="validator" method="post" action="--><?//= base_url() ?><!--accounts/report/ac_config_ledgerst/"--><?// echo $ledger_id?><!-- enctype="multipart/form-data">-->
<!--                                --><?//  //echo form_open('report/ac_config_ledgerst/' . $ledger_id);?>
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms"-->
<!--                                         style="width: 100%; background-color: #eaeaea;">-->
<!--                                        <div class="form-body">-->
<!--                                            <div class="form-inline">-->
<!--                                                <div class="form-group">-->
<!--                                                    --><?// echo form_input_ledger('ledger_id', $ledger_id); ?>
<!--                                                </div>-->
<!--                                                <div class="form-group">-->
<!--                                                    <button type="submit" class="btn btn-primary "-->
<!--                                                            style="margin-bottom: 20px;margin-left: 5px;">Show-->
<!--                                                    </button>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </form>-->
<!--                            --><?//
//                        }
                        ?>

                        <div class="row">
                            <?
                            if ( ! $print_preview)
                            {
                                $pagination_counter = $this->config->item('row_count');
                                $page_count = (int)$this->uri->segment(4);
                                //$page_count = $this->input->xss_clean($page_count);
                                if ( ! $page_count)
                                    $page_count = "0";
                                $config['base_url'] = site_url('accounts/report/ac_config_ledgerst/' . $ledger_id);
                                $config['num_links'] = 10;
                                $config['per_page'] = $pagination_counter;
                                $config['uri_segment'] = 4;
                                $config['total_rows'] = (int)$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->count_all_results();
                                $config['full_tag_open'] = '<ul id="pagination-flickr">';
                                $config['full_close_open'] = '</ul>';
                                $config['num_tag_open'] = '<li>';
                                $config['num_tag_close'] = '</li>';
                                $config['cur_tag_open'] = '<li class="active">';
                                $config['cur_tag_close'] = '</li>';
                                $config['next_link'] = 'Next &#187;';
                                $config['next_tag_open'] = '<li class="next">';
                                $config['next_tag_close'] = '</li>';
                                $config['prev_link'] = '&#171; Previous';
                                $config['prev_tag_open'] = '<li class="previous">';
                                $config['prev_tag_close'] = '</li>';
                                $config['first_link'] = 'First';
                                $config['first_tag_open'] = '<li class="first">';
                                $config['first_tag_close'] = '</li>';
                                $config['last_link'] = 'Last';
                                $config['last_tag_open'] = '<li class="last">';
                                $config['last_tag_close'] = '</li>';
                                $this->pagination->initialize($config);
                            }

                            if ($ledger_id != "")
                            {
                                list ($opbalance, $optype) = $this->Ledger_model->get_config_op_balance($ledger_id); /* Opening Balance */
                                $clbalance = $this->Ledger_model->get_ledger_config_balance($ledger_id); /* Final Closing Balance */
                            ?>

                            <div  class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">

                                <div class="col-md-6">
                                    <div class="clearfix"> </div><br/>

                                <table class="table ledger-summary" style="background-color: #fcf89f;">
                                    <!--  /* Ledger Summary */ -->
                                    <tr>
                                        <td><b>Opening Balance</b></td>
                                        <td><? echo convert_opening($opbalance, $optype);?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Closing Balance</b></td>
                                        <td><? echo convert_amount_dc($clbalance);;?></td>
                                    </tr>
                                </table>
                                </div>
                            </div>
                            <div class="clearfix"> </div>
                                <div  class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
                                    <?
                                if ( ! $print_preview) {
                                    $this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc,ac_chqprint.CHQNO ,ac_recieptdata.RCTNO');
                                    $this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc')->limit($pagination_counter, $page_count);
                                    $ac_ledgerst_q = $this->db->get();
                                } else {
                                    $page_count = 0;
                                    $this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc,ac_chqprint.CHQNO ,ac_recieptdata.RCTNO');
                                    $this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
                                    $ac_ledgerst_q = $this->db->get();
                                }
                                    ?>
                                    <table class="table ledger-summary">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>No.</th>
                                            <th>Ledger Name</th>
                                            <th>Type</th>
                                            <th>RCT/CHEQUE NO</th>
                                            <th>Dr Amount</th>
                                            <th>Cr Amount</th>
                                            <th>Balance</th>
                                        </tr>
                                        </thead>
                                    <?
                               $odd_even = "odd";

                                $cur_balance = 0;

                                if ($page_count <= 0)
                                {
                                    /* Opening balance */
                                    if ($optype == "D")
                                    {
                                        echo "<tr class=\"tr-balance\"><td colspan=7>Opening Balance</td><td>" . convert_opening($opbalance, $optype) . "</td></tr>";
                                        $cur_balance = float_ops($cur_balance, $opbalance, '+');
                                    } else {
                                        echo "<tr class=\"tr-balance\"><td colspan=7>Opening Balance</td><td>" . convert_opening($opbalance, $optype) . "</td></tr>";
                                        $cur_balance = float_ops($cur_balance, $opbalance, '-');
                                    }
                                } else {
                                    /* Opening balance */
                                    if ($optype == "D")
                                    {
                                        $cur_balance = float_ops($cur_balance, $opbalance, '+');
                                    } else {
                                        $cur_balance = float_ops($cur_balance, $opbalance, '-');
                                    }

                                    /* Calculating previous balance */
                                    $this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc');
                                    $this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc')->limit($page_count, 0);
                                    $prevbal_q = $this->db->get();
                                    foreach ($prevbal_q->result() as $row )
                                    {
                                        if ($row->ac_entry_items_dc == "D")
                                            $cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
                                        else
                                            $cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
                                    }

                                    /* Show new current total */
                                    echo "<tr class=\"tr-balance\"><td colspan=7>Opening</td><td>" . convert_amount_dc($cur_balance) . "</td></tr>";
                                }
                                echo $cur_balance;
                                foreach ($ac_ledgerst_q->result() as $row)
                                {
                                    $current_entry_type = entry_type_info($row->ac_entries_entry_type);

                                    echo "<tr class=\"tr-" . $odd_even . "\">";
                                    echo "<td>";
                                    echo $row->ac_entries_date;
                                    echo "</td>";
                                    echo "<td>";
                                    echo anchor('entry/view/' . $current_entry_type['label'] . '/' . $row->ac_entries_id, full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number), array('title' => 'View ' . ' Entry', 'class' => 'anchor-link-a'));
                                    echo "</td>";

                                    /* Getting opposite Ledger name */
                                    echo "<td>";
                                    echo $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'html');
                                    if ($row->ac_entries_narration)
                                        echo "<div class=\"small-font\">" . character_limiter($row->ac_entries_narration, 50) . "</div>";
                                    echo "</td>";

                                    echo "<td>";
                                    echo $current_entry_type['name'];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row->CHQNO .$row->RCTNO;
                                    echo "</td>";
                                    if ($row->ac_entry_items_dc == "D")
                                    {
                                        $cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
                                        echo "<td>";
                                        echo convert_dc($row->ac_entry_items_dc);
                                        echo " ";
                                        echo $row->ac_entry_items_amount;
                                        echo "</td>";
                                        echo "<td></td>";
                                    } else {
                                        $cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
                                        echo "<td></td>";
                                        echo "<td>";
                                        echo convert_dc($row->ac_entry_items_dc);
                                        echo " ";
                                        echo $row->ac_entry_items_amount;
                                        echo "</td>";
                                    }
                                    echo "<td>";
                                    echo convert_amount_dc($cur_balance);
                                    echo "</td>";
                                    echo "</tr>";
                                    $odd_even = ($odd_even == "odd") ? "even" : "odd";
                                }

                                /* Current Page Closing Balance */
                                echo "<tr class=\"tr-balance\"><td colspan=7>Closing</td><td>" .  convert_amount_dc($cur_balance) . "</td></tr>";
                                echo "</table>";
                                ?>
                                    </table>
                                    </div>
                                    <?
                            }
                            ?>
                            <?php if ( ! $print_preview) { ?>
                                <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                            <?php } ?>

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
<?php

//if ( ! $print_preview)
//{
//    echo form_open('report/ac_config_ledgerst/' . $ledger_id);
//    echo "<p>";
//    echo form_input_ledger('ledger_id', $ledger_id);
//    echo " ";
//    echo form_submit('submit', 'Show');
//    echo "</p>";
//    echo form_close();
//}

/* Pagination configuration */





//$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
//  echo "<a href='$url'>Back</a>";
?>
