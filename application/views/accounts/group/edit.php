<!DOCTYPE HTML>
<html>
<head>


    <?
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));
    $this->load->view("includes/topbar_accounts");
    ?>

<script type="text/javascript">
    $(document).ready(function() {
        /* Show and Hide affects_gross */
        $('.group-parent').change(function() {
            if ($(this).val() == "3" || $(this).val() == "4") {
                $('.affects-gross').show();
            } else {
                $('.affects-gross').hide();
            }
        });
        $('.group-parent').trigger('change');
    });
</script>

    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Edit Account</h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/group/edit/<?=$group_id?>"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
                                    <div class="form-body">
                                        <div class="form-inline">
                                            <table>
                                                <tr>
                                            <div class="form-group">Group Name
                                                <? echo form_input($group_name);?>
                                            </div>
                                            <div class="form-group">Parent Group
                                                <? echo form_dropdown('group_parent', $group_parent, $group_parent_active, "class = \"group-parent\"");?>
                                            </div>
                                                </tr>
                                                <tr>
                                                    <?
                                                    echo "<p class=\"affects-gross\">";
                                                    echo "<span id=\"tooltip-target-1\">";
                                                    echo form_checkbox('affects_gross', 1, $affects_gross) . " Affects Gross Profit/Loss Calculations";
                                                    echo "</span>";
                                                    echo "<span id=\"tooltip-content-1\">If selected the Group account will affect Gross Profit and Loss calculations, otherwise it will affect only Net Profit and Loss calculations.</span>";
                                                    echo "</p>";

                                                    echo "<p>";
                                                    echo form_hidden('group_id', $group_id);
                                                    ?>
                                                    <div class="col-md-12">
                                                        <div class="col-md-3" style="width: 15%;">
                                                            <button type="submit"  id="create" class="btn btn-primary " style="width: 70px;">Update</button>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-3" style="width: 15%;">
                                                            <a class="btn btn-back "  href=<?echo base_url().'accounts/group/';?>><i
                                                            class="fa fa-chevron-left nav_icon icon_white"></i>Back</a>
                                                        </div>
                                                    <div class="clearfix"> </div><br/>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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



