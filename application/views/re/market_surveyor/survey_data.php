<!DOCTYPE HTML>
<html>
<head>

<?php

$this->load->view("includes/header_" . $this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script type="text/javascript">
function setDistancerequired(val){
	if(val == 'Yes'){
		$('#distance_to_main_pipe_line').attr("required", "true");
	}
	else{
		$('#distance_to_main_pipe_line').removeAttr('required');
	}
}
</script>


    <style type="text/css">
        @media(max-width:1920px) {
            .topup {
                margin-top: 0px;
            }
        }

        @media(max-width:360px) {
            .topup {
                margin-top: 0px;
            }
        }

        @media(max-width:790px) {
            .topup {
                margin-top: 100px;
            }
        }

        @media(max-width:768px) {
            .topup {
                margin-top: -10px;
            }
        }
    </style>

    <div id="page-wrapper">

            <h3 class="title1">Market Survey Report</h3>

            <? if($this->session->flashdata('msg')){?>
            <div class="alert alert-success" role="alert" id="msg" onload="setTimeout('msg')">
            <?=$this->session->flashdata('msg')?>
            </div><? }?>
            <? if($this->session->flashdata('error')){?>
            <div class="alert alert-danger" role="alert" id="error" onload="setTimeout('error')">
            <?=$this->session->flashdata('error')?>
            </div>
            <? }?>


            <div class="main-page">

                <div class="table">


                    <div class="widget-shadow">
                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#profile" role="tab" id="profile-tab"
                                    data-toggle="tab" aria-controls="profile" aria-expanded="true">New Market Survey</a></li>

                            <li role="presentation">
                                <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home"
                                    aria-expanded="false">Market Survey List</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content scrollbar1"
                            style="padding: 5px; overflow: hidden; outline: currentcolor none medium;" tabindex="5000">

                            <div role="tabpanel" class="tab-pane fade  " id="home" aria-labelledby="home-tab">
                                <br>

                                <div class=" widget-shadow bs-example" data-example-id="contextual-table">

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Land Code</th>
                                                <th>Land Location</th>
                                                <th>Property Name</th>
                                                <th>Recommended sale price </th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        if(count($market_servay_data) > 0)
                                        {

                                           foreach($market_servay_data as $mkt_row)
                                           {
                                        ?>
                                            <tr class="">
                                                <th scope="row"><?php echo($mkt_row->land_code);?></th>
                                                <td><?php echo($mkt_row->district);?></td>
                                                <td><?php echo($mkt_row->property_name);?></td>
                                                <td><?php echo($mkt_row->recommended_sale_price);?></td>
                                                <td><?php echo($mkt_row->status);?></td>
                                                <td align="right">
                                                    <div id="checherflag">

                                                            <a href="javascript:check_activeflag('<?php echo($mkt_row->market_survey_code);?>')" title="Edit">
                                                                <i class="fa fa-edit nav_icon icon_blue"></i>
                                                            </a>
                                                            <a href="javascript:view_confirm('<?php echo($mkt_row->market_survey_code);?>')" title="View">
                                                                <i class="fa fa-eye nav_icon icon_blue"></i>
                                                            </a>
                                                            <a href="javascript:call_comment('<?php echo($mkt_row->market_survey_code);?>')" title="Comment">
                                                                <i class="fa fa-comments-o nav_icon icon_green"></i>
                                                            </a>
                                                        <?php
                                                        if($mkt_row->status != 'CONFIRMED')
                                                        {

                                                            ?>
                                                            <a href="javascript:call_confirm('<?php echo($mkt_row->market_survey_code);?>')" title="Confirm">
                                                                <i class="fa fa-check nav_icon icon_green"></i>
                                                            </a>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if($mkt_row->status == 'PENDING')
                                                        {
                                                        ?>
                                                            <a  href="javascript:call_delete('<?php echo($mkt_row->market_survey_code);?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                                                        <?php
                                                        }
                                                        ?>
                                                            <a  href="javascript:print_survey_report('<?php echo($mkt_row->market_survey_code);?>')" title="Print"><i class="fa fa-print nav_icon icon_red"></i></a>


                                                    </div>
                                                </td>
                                            </tr>

                                        <?php
                                           }
                                        }else{
                                        ?>
                                            <tr><td colspan="6"> No market survey data available </td></tr>
                                        <?php

                                        }
                                        ?>
                                        </tbody>

                                    </table>
                                    <div id="pagination-container"></div>
                                </div>
                            </div>


                            <div role="tabpanel" class="tab-pane fade  active in " id="profile"
                                aria-labelledby="profile-tab">

                                <form data-toggle="validator" method="post"
                                    action="<?=base_url()?>re/marketsurveyor/add_action" enctype="multipart/form-data"
                                    novalidate="true">
                                    <input type="hidden" name="product_code" id="product_code" value="LNS">
                                    <input type="hidden" name="branch_code" id="branch_code" value="0001">
                                    <div class="row">
                                        <div class="form-title">
                                            <h4>Master Information :</h4>
                                        </div>
                                        <div class="form-group" style="margin-top:10px;">
                                            <div class="col-md-6" data-example-id="basic-forms">
                                                <div class="form-inline">
                                                    <label class="control-label" for="all_branch">Branch </label>
                                                    <select class="form-control" id="all_branch" placeholder="Qick Search.." <? if
                                                        (!check_access('all_branch')) {?> disabled
                                                        <?}?> id="branch_code" name="branch_code" style="width:100%; margin-bottom:10px;">
                                                        <option value="">Search here..</option>
                                                        <? foreach ($branchlist as $row) {?>
                                                        <option value="<?=$row->branch_code?>" <? if ($row->branch_code ==
                                                            $this->session->userdata('branchid')) {?> selected
                                                            <?}?>><?=$row->branch_name?></option>
                                                        <?}?>
                                                    </select>
                                                </div>

                                                <div class="form-inline">
                                                    <label class="control-label" for="inputSuccess1">Land</label>

                                                    <select name="land_code" id="land_code" class="form-control"
                                                        placeholder="Introducer" onChange="load_servay_data(this.value)"
                                                        required style="width:100%; margin-bottom:10px;">
                                                        <option value=""></option>
                                                        <?php
                                                          if(count($land_list) > 0 ){
                                                                foreach ($land_list as $raw)
                                                                {
                                                                ?>
                                                                    <option value="<?=$raw->land_code?>"> <?=$raw->property_name?>-<?=$raw->district?>  </option>
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
                                    <hr/>
                                    <div class="clearfix"> </div>


                                        <div id="landinfomation" style="display:none"><img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif"> <br></div>



                                    <div class="row">
                                        <div class="col-md-6 validation-grids widget-shadow"
                                            data-example-id="basic-forms">


                                            <div class="form-title">
                                                <h4>Availability of Water</h4>
                                            </div>

                                            <div class="form-body">
                                                <div class="form-group">
                                                    <div class="form-inline">
                                                        <span>Pipe Borne Water</span>

                                                        <select name="pipe_born_water" id="pipe_born_water" onChange="setDistancerequired(this.value);" class="form-control"
                                                        placeholder="Pipe born water" required style="width:100%; margin-bottom:10px;">
                                                            <option value="">Select Availability</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-inline">
                                                            <span>Distance to Main Line (meters)</span>
                                                            <input type="number" step="any" class="form-control" id="distance_to_main_pipe_line" name="distance_to_main_pipe_line" placeholder="Distance in Meters"  style="width:100%;">
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-inline">
                                                            <span>Do you need a water supply project provide by the company? </span>
                                                            <textarea type="text" class="form-control" id="water_supply_project_necessity" name="water_supply_project_necessity" placeholder="" required style="width:100%;"></textarea>
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-inline">
                                                            <span>If well water to be used, water level type of the well and problem may occur?  </span>
                                                            <textarea type="text" class="form-control" id="used_water_level_type" name="used_water_level_type" placeholder="" required style="width:100%;"></textarea>
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>
                                                </div>




                                            </div>

                                            <div class="form-title">
                                                <h4> Soil Condition</h4>
                                            </div>

                                            <div class="form-body">
                                                <div class="form-group">
                                                    <div class="form-inline">
                                                        <span>
                                                            Need to the fill? soil condition, water level, under neath
                                                            formation of rock, if available.</span>

                                                        </span>
                                                        <textarea type="text" class="form-control" id="soil_condition"
                                                            name="soil_condition" placeholder="" required style="width:100%;"></textarea>
                                                        <span class="glyphicon form-control-feedback"
                                                            aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-title">
                                                <h4>
                                                	Detail of the population lives close to the land (Race, Religion, Cast)
                                                </h4>
                                            </div>

                                            <div class="form-body">
                                                <div class="form-group">
                                                    <div class="form-inline">
                                                        <input type="text" step="any" class="form-control"
                                                            id="population_factor" name="population_factor"
                                                            placeholder="" required style="width:100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-6 validation-grids validation-grids-right">
                                            <div class="widget-shadow" data-example-id="basic-forms">

                                                <div class="form-title">
                                                    <h4>Location of the Land / Marketability : <span
                                                            style="float:right">
                                                            <button class="btn btn-success" id="add_marketability"
                                                                style="margin-top:-10px;">(+) Add </button></span></h4>
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
                                                            <div class="form-group has-feedback">
                                                                <input type="text" class="form-control"
                                                                    id="marketability_item_0_desc"
                                                                    name="marketability_item_desc[0]"
                                                                    placeholder="Description" required>
                                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                                <input type="number" step="any" placeholder="Distance in meters" class="form-control"
                                                                    name="marketability_item_value[0]"
                                                                    id="marketability_item_0_value" placeholder=""
                                                                    data-error="" required>
                                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-title">
                                                    <h4>Electricity</h4>
                                                </div>

                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <div class="form-inline">
                                                            Distance to the 3 phase electricity post (meters)
                                                        </div>

                                                        <div class="form-inline">
                                                            <input type="number" step="any" class="form-control"
                                                                id="distance_electricity" name="distance_electricity"
                                                                placeholder="Distance in meters"
                                                                required="" style="width:100%;">
                                                            <span class="glyphicon form-control-feedback"
                                                                aria-hidden="true"></span>
                                                        </div>
                                                        <br />

                                                        <div class="form-inline">
                                                            Distance to the Transformer (meters)
                                                        </div>

                                                        <div class="form-inline">
                                                            <input type="number" step="any" class="form-control"
                                                                id="distance_transformer" name="distance_transformer"
                                                                placeholder="Distance in meters" required
                                                                style="width:100%;">
                                                            <span class="glyphicon form-control-feedback"
                                                                aria-hidden="true"></span>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="form-title">
                                                    <h4>Positive and Negative Factors of the Land</h4>
                                                </div>

                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <div class="form-inline">
                                                            Positive factors of the land.
                                                        </div>
                                                    </div>

                                                    <div class="form-inline">
                                                        <textarea type="text" class="form-control"
                                                            id="land_positive_factor" name="land_positive_factor"
                                                            placeholder="" required
                                                            style="width:100%;"></textarea>
                                                        <span class="glyphicon form-control-feedback"
                                                            aria-hidden="true"></span>
                                                    </div>
                                                    <br />

                                                    <div class="form-inline">
                                                        Negative factors of the land
                                                    </div>

                                                    <div class="form-inline">
                                                        <textarea class="form-control" id="land_negative_factor"
                                                            name="land_negative_factor" placeholder=""
                                                            required="" style="width:100%;"></textarea>
                                                        <span class="glyphicon form-control-feedback"
                                                            aria-hidden="true"></span>
                                                    </div>
                                                    <br />

                                                </div>

                                                <div class="form-title">
                                                    <h4>
                                                        Recommended sale price per perch
                                                    </h4>
                                                </div>

                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <div class="form-inline">
                                                            <input type="text" step="any" class="form-control number-separator"
                                                                id="sale_price_per_perch" name="sale_price_per_perch"
                                                                placeholder="" required
                                                                style="width:100%;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="bottom">
                                                    <div class="form-group" style="padding-top:20px;">
                                                        <button type="submit" class="btn btn-primary disabled">Submit</button>
                                                    </div>
                                                    <div class="clearfix"> </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="clearfix"> </div>
                                    <br />

                                </form>
                            </div> <!-- ----->


                            <p></p>
                        </div>

                    </div>
                </div>
            </div>



            <div class="col-md-4 modal-grids">
                <button type="button" style="display:none" class="btn btn-primary" id="flagchertbtn" data-toggle="modal"
                    data-target=".bs-example-modal-sm">Small modal</button>
                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
                    aria-labelledby="mySmallModalLabel">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="mySmallModalLabel"><i
                                        class="fa fa-info-circle nav_icon"></i> Alert</h4>
                            </div>
                            <div class="modal-body" id="checkflagmessage">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"
                value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm"
                name="complexConfirm_confirm" value="DELETE"></button>
            <form name="deletekeyform"> <input name="deletekey" id="deletekey" value="0" type="hidden">
            </form>

            <div class="clearfix"> </div>


    </div>
    <!-- <div id="popupform" style="display:none"></div> -->






    <!--footer-->

    <script src="<?=base_url()?>media/js/dist/Chart.js"></script>
    <script src="<?=base_url()?>media/js/utils.js"></script>
    <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

    <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {


            $("#prj_id").chosen({
                allow_single_deselect: true
            });

            setTimeout(function () {
                $("#land_code").chosen({
                    allow_single_deselect: true,
                    search_contains: true,
                    no_results_text: "Oops, nothing found!",
                    placeholder_text_single: "Select a Land"
                });
            });

            $("#district").focus(function () {
                $("#district").chosen({
                    allow_single_deselect: true
                });
            });

            $("#procouncil").focus(function () {
                $("#procouncil").chosen({
                    allow_single_deselect: true
                });
            });

            $("#town").focus(function () {
                $("#town").chosen({
                    allow_single_deselect: true
                });
            });



            var add_marketability_option = $("#add_marketability"); //Add button
            var add_marketability_max_subjects = 10; //maximum input boxes allowed
            var marketability_wrapper = $(".marketability_wrapper"); //Fields wrapper

            var mkCount = 1; //initlal text box count

            $(add_marketability_option).click(function (e) { //on add input button click
                // alert("Bingo");
                e.preventDefault();
                if (mkCount < add_marketability_max_subjects) {
                    $(marketability_wrapper).append('<div class="clearfix" id='+ mkCount +'><br/>\
                    <div class="form-group has-feedback">\
                    <input type="text" class="form-control" id="marketability_item_desc['+ mkCount + ']" name="marketability_item_desc[' + mkCount + ']" value="" placeholder=""  required>\
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>\
                    <input type="number" class="form-control" id=""marketability_item_value[' + mkCount + ']" name="marketability_item_value['+ mkCount + ']" value="" placeholder="" data-error="" required>\
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>\
                    </div><a href="javascript:void(0)" class="remove_add_mark btn btn-danger" onClick="removeMKT('+ mkCount +');"> Remove </a></div>');
                    mkCount++; //text box increment
                }

            });



        });



    function removeMKT(appendId){
        var wrapObj = document.getElementById(appendId);
        wrapObj.remove();
    }

    function view_confirm(survey_id){
        // alert("<?//=base_url()?>re/marketsurveyor/view/"+survey_id);
	    $('#popupform').delay(1).fadeIn(600);
	    $("#popupform").load("<?=base_url()?>re/marketsurveyor/view/"+survey_id );
    }

    function call_comment(survey_id)
    {
        $('#popupform').delay(1).fadeIn(600);
        $("#popupform").load("<?=base_url()?>re/marketsurveyor/comments/"+survey_id);
    }

    function print_survey_report(survey_id)
    {

        // alert(survey_id);
        window.open( "<?=base_url()?>re/marketsurveyor/print_report/"+survey_id);
    }



function load_servay_data(id)
{
    if(id!=""){

        $('#landinfomation').delay(1).fadeIn(600);
            document.getElementById("landinfomation").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
            $.ajax({
                cache: false,
                type: 'GET',
                url: '<?php echo base_url() . 'common/activeflag_cheker/'; ?>',
                data: {table: 're_landms', id: id,fieldname:'land_code' },
                success: function(data) {
                    if (data) {
                        // alert(data);
                        document.getElementById("checkflagmessage").innerHTML=data;
                        $('#flagchertbtn').click();

                        $('#landinfomation').delay(1).fadeOut(600);
                        //document.getElementById('mylistkkk').style.display='block';
                    }
                    else
                    {
                        $( "#landinfomation" ).load( "<?=base_url()?>re/marketsurveyor/landinformationdata/"+id );
                    }
                }
            });
    }
    else
    {
        $('#landinfomation').delay(1).fadeOut(600);
    }
}


function close_edit(id)
{

    $.ajax({
        cache: false,
        type: 'GET',
        url: '<?php echo base_url().'common/delete_activflag/';?>',
        data: {table: 're_landms', id: id,fieldname:'land_code' },
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


function check_activeflag(id)
{
    // var vendor_no = src.value;
    //alert(id);
    // return false;

    $.ajax({
        cache: false,
        type: 'GET',
        url: '<?php echo base_url().'common/activeflag_cheker/';?>',
        data: {table: 're_landms', id: id,fieldname:'land_code' },
        success: function(data) {
            if (data) {
                //alert(data);

                document.getElementById("checkflagmessage").innerHTML=data;
                $('#flagchertbtn').click();
                //document.getElementById('mylistkkk').style.display='block';
            }
            else
            {
                //alert("Bingo 0000000000" + "<?//=base_url()?>re/marketsurveyor/edit/"+id);
                $('#popupform').delay(1).fadeIn(600);
                $( "#popupform" ).load("<?=base_url()?>re/marketsurveyor/edit/"+id );

            }
        }
    });
}


function call_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;

    $.ajax({
        cache: false,
        type: 'GET',
        url: '<?php echo base_url().'common/activeflag_cheker/';?>',
        data: {table: 're_landms', id: id,fieldname:'land_code' },
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

    //alert(document.testform.deletekey.value);

}


var deleteid="";
function call_delete(id)
{

    //alert("Bingo" + id);
    // return false;
	document.deletekeyform.deletekey.value=id;

    $.ajax({
        cache: false,
        type: 'GET',
        url: '<?php echo base_url().'common/activeflag_cheker/';?>',
        data: {table: 're_landms', id: id,fieldname:'land_code' },
        success: function(data) {
            if (data) {
                // alert(data);
                    document.getElementById("checkflagmessage").innerHTML=data;
                    $('#flagchertbtn').click();

                //document.getElementById('mylistkkk').style.display='block';
            }
            else
            {
                // alert("Bingo cccc");
                $('#complexConfirm').click();
            }
        }
    });

    //alert(document.testform.deletekey.value);

}



setTimeout(function(divLoaded) {
    $('#error').fadeOut('slow');
    $('#msg').fadeOut('slow');
}, 1000); // <-- time in milliseconds


</script>

<script>
    $("#complexConfirm").confirm({
        title:"Delete confirmation",
        text: "Are You sure you want to delete this ? ......." ,
        headerClass:"modal-header",
        confirm: function(button) {
            button.fadeOut(2000).fadeIn(2000);
            var code=1
            window.location="<?=base_url()?>re/marketsurveyor/delete/"+document.deletekeyform.deletekey.value;
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

            window.location="<?=base_url()?>re/marketsurveyor/confirm/"+document.deletekeyform.deletekey.value;
        },
        cancel: function(button) {
            button.fadeOut(2000).fadeIn(2000);
            // alert("You aborted the operation.");
        },
        confirmButton: "Yes I am",
        cancelButton: "No"
});
</script>

<?
    $this->load->view("includes/footer");
?>
