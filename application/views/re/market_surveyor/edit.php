<h4>Edit Market Survey Report - <?php echo(@$land_details->property_name); ?>
    <span style="float:right; color:#FFF">
        <a href="javascript:close_edit('<?=@$land_details->land_code?>')"><i class="fa fa-times-circle "></i></a></span>
</h4>

<div  class="table widget-shadow">
    <div class="row">
        <div class="col-md-12">
            <form data-toggle="validator" id="test" method="post" action="<?=base_url()?>re/marketsurveyor/edit_action"
            enctype="multipart/form-data" novalidate="true" style="h4{margin=0; padding:0; background-color:none !important;}">
                <input type="hidden" name="product_code" id="product_code" value="LNS">
                <input type="hidden" name="branch_code" id="branch_code" value="0001">
                <div class="row">
                    <div class="form-title">
                        <h5>Master Information :</h5>
                    </div>
                    <div class="form-group" style="margin-top:10px;">
                        <div class="col-md-6" data-example-id="basic-forms">
                            <div class="form-inline">
                                <label class="control-label" for="all_branch">Branch </label>
                                <select class="form-control" readonly="" id="all_branch" placeholder="Qick Search.." <? if
                                    (!check_access('all_branch')) {?> disabled
                                    <? } ?> id="branch_code" name="branch_code" style="width:100%; margin-bottom:10px;">
                                    <?
                                    foreach ($branchlist as $row) {
                                        if ($row->branch_code == $this->session->userdata('branchid')) {
                                        ?>
                                            <option value="<?=$row->branch_code?>" selected>
                                            <?=$row->branch_name?>
                                            </option>
                                        <?
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-inline">
                                <label class="control-label" for="inputSuccess1">Land Detail </label>
                                <select name="land_code" readonly id="land_code" class="form-control" placeholder="Introducer"
                                    onChange="loadlandadata(this.value)" required
                                    style="width:100%; margin-bottom:10px;">
                                    <?

                                    foreach ($land_list as $raw)
                                    {
                                        if($market_servay_data[0]->land_code == $raw->land_code)
                                        {
                                        ?>
                                            <option value="<?=$raw->land_code?>">
                                                <?=$raw->property_name?>-<?=$raw->district?>
                                            </option>
                                        <?php
                                        }
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" data-example-id="basic-forms">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <hr />
                <div class="clearfix"> </div>


                <div class="row">
                    <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">

                        <div class="form-title">
                            <h5>Availably Of Water</h5>
                        </div>

                        <div class="form-body">
                            <div class="form-group">
                                <div class="form-inline">
                                    <span>Pipe born water </span>
                                        <select name="pipe_born_water" id="pipe_born_water" class="form-control" placeholder="Pipe born water" required style="width:100%; margin-bottom:10px;">
                                        <option value="">Select your choice</option>
                                        <?php
                                        if(strtolower($market_servay_data[0]->pipe_born_water) == "yes"){
                                            $selectionYes = "selected=selected";
                                        }else{
                                            $selectionNo = "selected=selected";
                                        }
                                        ?>
                                        <option value="Yes" <?=@$selectionYes?>>Yes</option>
                                        <option value="No" <?=@$selectionNo?>>No</option>
                                        </select>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-inline">
                                    <span>If so distance to Main line</span>
                                    <input type="number" step="any" value="<?php echo($market_servay_data[0]->distance_to_main_pipe_line); ?>" class="form-control" id="distance_to_main_pipe_line"
                                        name="distance_to_main_pipe_line" placeholder="Distance to Main Pipe Line"
                                        required="" style="width:100%;">
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-inline">
                                    <span>Do you need a water Supply Project Provide by the company ? </span>
                                    <textarea type="text" class="form-control" id="water_supply_project_necessity"
                                        name="water_supply_project_necessity"
                                        placeholder=""
                                        required="" style="width:100%;"> <?php echo($market_servay_data[0]->water_source_informarion); ?></textarea>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-inline">
                                    <span>Of well water to be used water level type of the well and problem may occur ?
                                    </span>
                                    <textarea type="text" class="form-control" id="used_water_level_type"
                                        name="used_water_level_type"
                                        placeholder=""
                                        required="" style="width:100%;"><?php echo($market_servay_data[0]->used_water_level_type); ?></textarea>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>




                        </div>

                        <div class="form-title">
                            <h5> Soil Condition</h5>
                        </div>

                        <div class="form-body">
                            <div class="form-group">
                                <div class="form-inline">
                                    <span>
                                        Need to the Fill ? Condition Soil, Water Level, under neath
                                        formation of rock, if available. </span>

                                    </span>
                                    <textarea type="text" class="form-control" id="soil_condition" name="soil_condition"
                                        placeholder="" required="" style="width:100%;"><?php echo(@$market_servay_data[0]->soil_condition); ?></textarea>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-title">
                            <h5>
                                Detail of the population lives closer to Land ( Race, Religion, Cast)
                            </h5>
                        </div>

                        <div class="form-body">
                            <div class="form-group">
                                <div class="form-inline">
                                    <input type="text" step="any" value="<?php echo(@$market_servay_data[0]->population_data); ?>" class="form-control" id="population_factor"
                                        name="population_factor" placeholder="" required="" style="width:100%;" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 validation-grids validation-grids-right">
                        <div class="widget-shadow" data-example-id="basic-forms">

                            <div class="form-title">
                                <h5>Location Of the Land / Marketability : <span style="float:right">
                                        <button class="btn btn-success" id="add_marketability_edit"
                                            style="margin-top:-10px;">(+) Add </button></span>
                                        </h5>
                            </div>
                            <div class="form-body">
                                <div class="form-group">

                                    <div class="form-inline">
                                        <div class="form-group">
                                            <lable>Distance to main roads, Schools, Hospital And
                                                Government & Private Institutes</label>
                                        </div>
                                    </div>

                                    <div class="form-inline marketability_wrapper">

                                    <?php

                                    $market_servay_data_arr = json_decode($market_servay_data[0]->marketability_descriptions, true);
                                    $market_servay_val_arr = json_decode($market_servay_data[0]->marketability_values, true);
                                    $count = 0;

                                    foreach(array_combine($market_servay_data_arr,$market_servay_val_arr) as $key=>$value) {
                                        if($count == 0) {
                                    ?>
                                            <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="marketability_item_<?php echo(@$count); ?>_desc"
                                                name="marketability_item_desc[<?php echo(@$count); ?>]" value="<?php echo(@$key); ?>" placeholder="Your Description"
                                                required><span class="glyphicon form-control-feedback"
                                                aria-hidden="true"></span>
                                            <input type="number" step="any" class="form-control"
                                                name="marketability_item_value[<?php echo(@$count); ?>]" value="<?php echo(@$value); ?>" id="marketability_item_<?php echo(@$count); ?>_value"
                                                placeholder="Distance" data-error="" required><span
                                                class="glyphicon form-control-feedback" aria-hidden="true"></span>

                                            </div>
                                    <?php
                                        }else{
                                    ?>
                                            <div class="clearfix" id="<?php echo(@$count); ?>"><br>
                                                <div class="form-group has-feedback">
                                                    <input type="text" class="form-control" id="marketability_item_<?php echo(@$count); ?>_desc"
                                                    name="marketability_item_desc[<?php echo(@$count); ?>]" value="<?php echo(@$key); ?>" placeholder="Your Description"
                                                    required><span class="glyphicon form-control-feedback"
                                                    aria-hidden="true"></span>
                                                    <input type="number" step="any" class="form-control"
                                                    name="marketability_item_value[<?php echo(@$count); ?>]" value="<?php echo(@$value); ?>" id="marketability_item_<?php echo(@$count); ?>_value"
                                                    placeholder="Distance" data-error="" required><span
                                                    class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    <a href="javascript:void(0)" class="remove_add_mark btn btn-danger" onClick="removeMKT(<?php echo(@$count); ?>);"> Remove </a>
                                                </div>
                                            </div>

                                    <?php
                                        }
                                        $count++;
                                    }
                                    ?>
                                        <input type="hidden" value="<?php echo($count-1); ?>" id="counter" name="counter">


                                    </div>

                                </div>

                            </div>

                            <div class="form-title">
                                <h5>Electricity</h5>
                            </div>

                            <div class="form-body">
                                <div class="form-group">
                                    <div class="form-inline">
                                        Distance to the 3 phase electricity post
                                    </div>

                                    <div class="form-inline">
                                        <input type="number" step="any" value="<?php echo(@$market_servay_data[0]->distance_electricity_post); ?>" class="form-control" id="distance_electricity"
                                            name="distance_electricity"
                                            placeholder="" required=""
                                            style="width:100%;">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <br />

                                    <div class="form-inline">
                                        Distance to the Transformer
                                    </div>

                                    <div class="form-inline">
                                        <input type="number" step="any" value="<?php echo(@$market_servay_data[0]->distance_to_transformer); ?>" class="form-control" id="distance_transformer"
                                            name="distance_transformer" placeholder=""
                                            required="" style="width:100%;">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>


                                </div>
                            </div>

                            <div class="form-title">
                                <h5>Positive and Negative factors of The Land</h5>
                            </div>

                            <div class="form-body">
                                <div class="form-group">
                                    <div class="form-inline">
                                        Positive factors of The Land.
                                    </div>
                                </div>

                                <div class="form-inline">
                                    <textarea type="text" class="form-control" id="land_positive_factor"
                                        name="land_positive_factor" placeholder="" required=""
                                        style="width:100%;"><?php echo($market_servay_data[0]->land_factors_positive); ?>     </textarea>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <br />

                                <div class="form-inline">
                                    Negative factors of The Land
                                </div>

                                <div class="form-inline">
                                    <textarea class="form-control" id="land_negative_factor" name="land_negative_factor"
                                        placeholder="" required="" style="width:100%;"><?php echo(@$market_servay_data[0]->land_factors_negative); ?></textarea>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <br />

                            </div>

                            <div class="form-title">
                                <h5>
                                    Recommended sale price per perch
                                </h5>
                            </div>

                            <div class="form-body">
                                <div class="form-group">
                                    <div class="form-inline">
                                        <input type="text" step="any" value="<?php echo(@$market_servay_data[0]->recommended_sale_price); ?>" class="form-control number-separator" id="sale_price_per_perch"
                                            name="sale_price_per_perch" placeholder=""
                                            required="" style="width:100%;">
                                    </div>
                                </div>
                            </div>

                            <div class="bottom">
                                <div class="form-group" style="padding-top:20px;">
                                    <input type="hidden" value="<?php echo(@$market_servay_data[0]->market_survey_code); ?>"  name="market_survey_code" />
                                    <button type="submit" class="btn btn-primary disabled">Update</button>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="clearfix"> </div>
                <br />
            </form>

        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {

    var add_marketability_edit = $("#add_marketability_edit"); //Add button
    var add_marketability_max_subjects = 10; //maximum input boxes allowed
    var marketability_wrapper = $(".marketability_wrapper"); //Fields wrapper
    var mkCount = $('#counter').val(); //initlal text box count
    mkCount = parseInt(mkCount) + 1;
    $(add_marketability_edit).click(function (e) { //on add input button click
        // alert("Bingo Exit" + mkCount);
        e.preventDefault();
        if (mkCount < add_marketability_max_subjects) {
            $(marketability_wrapper).append('<div class="clearfix" id='+ mkCount +'><br/>\<div class="form-group has-feedback">\
            <input type="text" class="form-control" id="marketability_item_desc['+ mkCount + ']" name="marketability_item_desc[' + mkCount + ']" value="" placeholder="Your Description"  required>\
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>\
            <input type="text" class="form-control" id=""marketability_item_value[' + mkCount + ']" name="marketability_item_value['+ mkCount + ']" value="" placeholder="Distance" data-error="" required>\
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>\
            </div><a href="javascript:void(0)" class="btn btn-danger" onClick="removeMKTE('+ mkCount +');"> Remove </a></div>');
            mkCount++; //text box increment
            $('#counter').val(mkCount);
        }
    });

});

function removeMKTE(appendId){

    var mkCount = $('#counter').val();
    if(mkCount > 0){
        mkCount--;
        $('#counter').val(mkCount);
    }else{
        $('#counter').val(0);
    }
    var wrapObj = document.getElementById(appendId);
    wrapObj.remove();
}
</script>
