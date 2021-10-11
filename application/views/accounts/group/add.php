<!--<!DOCTYPE HTML>-->
<!--<html>-->
<!--<head>-->
<!---->
<!---->
<!--    --><?//
//    $this->load->view("includes/header_".$this->session->userdata('usermodule'));
//    $this->load->view("includes/topbar_accounts");
//    ?>


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

<!--    <div id="page-wrapper">-->
<!--        <div class="main-page">-->
<!--            <div class="table">-->
<!--                <h3 class="title1">Add Group</h3>-->
<!--                --><?php //$this->load->view("includes/flashmessage");?>
<!--                <div class="widget-shadow">-->
<!--                    <div class="  widget-shadow" data-example-id="basic-forms">-->
                        <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/group/add"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #ffffff;">
                                    <div class="form-body">
                                        <div class="form-inline">
                                            <div class="form-group col-md-4" >Group name
                                                <? echo form_input($group_name); ?>
                                            </div>
                                            <div class="form-group col-md-4">Parent Group
                                                <? echo form_dropdown('group_parent', $group_parent, $group_parent_active, "class = \"group-parent\""); ?>
                                            </div>
                                            <?
                                            echo "<p class=\"affects-gross\">";
                                            echo "<span id=\"tooltip-target-1\">";
                                            echo form_checkbox('affects_gross', 1, $affects_gross) . " Affects Gross Profit/Loss Calculations";
                                            echo "</span>";
                                            echo "<span id=\"tooltip-content-1\">If selected the Group account will affect Gross Profit and Loss calculations, otherwise it will affect only Net Profit and Loss calculations.</span>";
                                            echo "</p>";
                                            ?>
                                            <div class="clearfix"> </div><br>
                                            <div class="form-group col-md-4" style="width: 15%;">
                                                <button  type="submit" class="btn btn-primary ">Create</button>
                                            </div>
                                            <div class="clearfix"> </div><br>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
<!--                    </div>-->
<!--                    <div class="row calender widget-shadow"  style="display:none">-->
<!--                        <h4 class="title">Calender</h4>-->
<!--                        <div class="cal1"></div>-->
<!--                    </div>-->
<!--                    <div class="clearfix"> </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?//
//$this->load->view("includes/footer");
//?>