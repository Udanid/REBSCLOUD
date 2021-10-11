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
            <h3 class="title1">View Journal - Entry No <?php echo full_entry_number($entry_type_id, $cur_entry->number); ?></h3>
            <?php $this->load->view("includes/flashmessage");?>
            <div class="widget-shadow">
                <div class="  widget-shadow" data-example-id="basic-forms">
                    <div class="row">
                        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
                            <div class="form-body">
                                <div class="form-inline">
                                    <strong>Journal Details</strong><hr/>
                                    <table class="entry-table" style="width:100%">
                                        <tr>
                                            <td>
                                                <div class="form-group col-md-12">Entry Number<br/>
                                                    <div class="col-sm-12 has-feedback">
                                                        <?php echo full_entry_number($entry_type_id, $cur_entry->number); ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group col-md-12">Entry Date<br/>
                                                    <div class="col-sm-12 has-feedback">
                                                        <?php echo $cur_entry->date; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                            <? if($project){?>
                                                <div class="form-group col-md-12">Project<br/>
                                                    <div class="col-sm-12 has-feedback">
                                                        <?php echo $project->project_name; ?>
                                                    </div>
                                                </div>
                                            <? }?>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="clearfix"> </div><br/><br/>
                                    <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll">
                                        <table class="entry-table table simple-table entry-view-table">
                                            <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Ledger Account</th>
                                                <th>Dr Amount</th>
                                                <th>Cr Amount</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            $odd_even = "odd";
                                            foreach ($cur_entry_ac_ledgers->result() as $row)
                                            {
                                                echo "<tr class=\"tr-" . $odd_even . "\">";
                                                echo "<td>" . convert_dc($row->dc) . "</td>";
                                                echo "<td>" .$row->ledger_id." - ". $this->Ledger_model->get_name($row->ledger_id) . "</td>";
                                                if ($row->dc == "D")
                                                {
                                                    echo "<td>Dr " . number_format($row->amount,2). "</td>";
                                                    echo "<td></td>";
                                                } else {
                                                    echo "<td></td>";
                                                    echo "<td>Cr " . number_format($row->amount,2) . "</td>";
                                                }
                                                echo "</tr>";
                                                $odd_even = ($odd_even == "odd") ? "even" : "odd";
                                            }
                                            ?>
                                            <tr class="entry-total" style="background-color: #FAF5AB;"><td colspan=2><strong>Total</strong></td><td id=dr-total>Dr <?php echo  number_format($cur_entry->dr_total,2); ?></td><td id=cr-total">Cr <?php echo  number_format($cur_entry->cr_total,2); ?></td></tr>
                                            <?php
                                            if ($cur_entry->dr_total != $cur_entry->cr_total)
                                            {
                                                $difference = $cur_entry->dr_total - $cur_entry->cr_total;
                                                if ($difference < 0)
                                                    echo "<tr class=\"entry-difference\"><td colspan=2><strong>Difference</strong></td><td id=\"dr-diff\"></td><td id=\"cr-diff\">" . $cur_entry->cr_total . "</td></tr>";
                                                else
                                                    echo "<tr class=\"entry-difference\"><td colspan=2><strong>Difference</strong></td><td id=\"dr-diff\">" .  $cur_entry->dr_total .  "</td><td id=\"cr-diff\"></td></tr>";
                                            }
                                            ?>

                                        </table>
                                    </div>
                                    <p>Narration :<br />
                                        <span class="bold"><?php echo $cur_entry->narration; ?></span>
                                    </p>
                                    <p>
                                        Tag :
                                        <?php
                                        $cur_entry_tag = $this->Tag_model->show_entry_tag($cur_entry->tag_id);
                                        if ($cur_entry_tag == "")
                                            echo "(None)";
                                        else
                                            echo $cur_entry_tag;
                                        ?>

                                    </p>
                                    <a class="btn btn-primary " style="width: 10%;" href=<?echo base_url().'accounts/entry/show/'.$current_entry_type['label'];?>>Back</a>

                                </div>
                            </div>
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






