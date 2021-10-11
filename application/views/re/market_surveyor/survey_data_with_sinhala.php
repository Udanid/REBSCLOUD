<!DOCTYPE HTML>
<html>

<head>

    
    <?php

        $this->load->view("includes/header_" . $this->session->userdata('usermodule'));
        $this->load->view("includes/topbar_notsearch");
        
    ?>
    

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
        <div class="main-page">
            <h3 class="title1">Market Surveyor Reports</h3>

            <div class="main-page">

                <div class="table">


                    <div class="widget-shadow">
                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#profile" role="tab" id="profile-tab"
                                    data-toggle="tab" aria-controls="profile" aria-expanded="true">Add New Survey Detail</a></li>

                            <li role="presentation">
                                <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home"
                                    aria-expanded="false">Survey  List</a></li>
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
                                                <th>District </th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr class="">
                                                <th scope="row">LND0002</th>
                                                <td>Colombo</td>
                                                <td> ABC Lotus Wattha</td>
                                                <td>Colombo</td>
                                                <td>Approved</td>
                                                <td align="right">
                                                    <div id="checherflag">
                                                        <a href="javascript:view_confirm('LND0002')" title="View"><i
                                                                class="fa fa-eye nav_icon icon_blue"></i></a>

                                                        <a href="javascript:call_comment('LND0002')"><i
                                                                class="fa fa-comments-o nav_icon icon_green"></i></a>
                                                    </div>
                                                </td>
                                            </tr>


                                        </tbody>
                                        <tbody>
                                            <tr class="info">
                                                <th scope="row">LND0001</th>
                                                <td>Nakkawatta</td>
                                                <td>Nakkawatta Land </td>
                                                <td>Kurunegala</td>
                                                <td>Assigned</td>
                                                <td align="right">
                                                    <div id="checherflag">

                                                        <a href="" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>

                                                        <a href="javascript:call_comment('LND0001')"><i class="fa fa-comments-o nav_icon icon_green"></i></a>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <div id="pagination-container"></div>
                                </div>
                            </div>



                            <div role="tabpanel" class="tab-pane fade  active in " id="profile"  aria-labelledby="profile-tab">

                                <form data-toggle="validator" method="post" action="http://localhost/homelands/re/land/add" enctype="multipart/form-data" novalidate="true">
                                    <input type="hidden" name="product_code" id="product_code" value="LNS">
                                    <input type="hidden" name="branch_code" id="branch_code" value="0001">
                                    <div class="row">
                                        <div class="col-md-6 validation-grids widget-shadow"
                                            data-example-id="basic-forms">
                                            <div class="form-title">
                                                <h4>Basic Information :</h4>
                                            </div>
                                            <div class="form-body">

                                                <div class="form-inline">
                                                    <span>Property (ඉඩම් ව්‍යාපෘතිය ) </span>
                                                    <br/>                                                       

                                                    <select name="land_code" id="land_code" class="form-control" placeholder="Property Project"  onChange="loadlandadata1(this.value)" required  style="width:100%;">
                                                    <option value=""></option>
                                                    <?php
                                                        foreach ($land_list as $raw)
                                                        {
                                                    ?>
                                                            <option value="<?=$raw->land_code?>">
                                                            <?=$raw->property_name?>-<?=$raw->district?>
                                                            </option>
                                                    <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="clearfix"> </div><br>
                                                

                                                <div class="form-inline">
                                                        <span>Branch (ශාඛාව) </span>
                                                        <br/>
                                                        <select class="form-control" placeholder="Qick Search.."  <? if(! check_access('all_branch')){?> disabled <? }?>  id="branch_code" name="branch_code" style="width:100%;" >
                                                        <option value="">Search here..</option>
                                                        <?php
                                                            foreach($branchlist as $row)
                                                            {
                                                        ?>
                                                            <option value="<?=$row->branch_code?>" <? if($row->branch_code==$this->session->userdata('branchid')){?> selected<? }?>><?=$row->branch_name?></option>
                                                        <?php 
                                                            }
                                                        ?> 
                                                        </select>
                                                </div>

                                                

                                                <div class="form-inline">
                                                    <span>Officer Name 	නිලධාරියාගේ නම </span>
                                                    <select name="officer_code" id="officer_code" class="form-control" placeholder="Introducer" required style="width:100%;">
                                                        <option value="">Project Officer</option>
                                                        <?php 
                                                        if($officerlist) 
                                                        {
                                                            foreach ($officerlist as $raw)
                                                            {
                                                        ?>
                                                            <option value="<?=$raw->id?>" ><?=$raw->initial?>&nbsp; <?=$raw->surname?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                        </select>    
                                                        
                                                    </select>
                                                </div>

                                                <div class="clearfix"> </div><br>

                                                
                                                <div class="clearfix"> </div><br>



                                            </div>


                                            <div class="form-title">
                                                <h4>Location Details :</h4>
                                            </div>
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <select name="district" id="district" class="form-control"  data-error=""  required>
                                                    <option value="">District</option>
                                                        <? foreach ($district_list as $raw){?>
                                                            <option value="<?=$raw->name?>" > <?=$raw->name?></option>
                                                        <? }?>
                                                    </select>

                                                </div>
                                                <div class="form-group">

                                                    <select name="procouncil" id="procouncil" class="form-control"   data-error="" required>
                                                    <option value="">Provincial Council</option>
                                                        <? foreach ($council_list as $raw){?>
                                                            <option value="<?=$raw->name?>" > <?=$raw->name?></option>
                                                    <? }?>
                                                    </select>


                                                </div>
                                                <div class="form-group">

                                                    <select name="town" id="town" class="form-control"   data-error="" required>
                                                        <option value="">Town </option>
                                                        <? foreach ($town_list as $raw){?>
                                                            <option value="<?=$raw->town?>" > <?=$raw->town?> - <?=$raw->district?> District</option>
                                                        <? }?>
                                                    </select>

                                                </div>
                                                <div class="form-group has-feedback">
                                                    <!-- <input type="text" class="form-control" id="company_code"
                                                        name="company_code" placeholder="Postal Code" data-error=""
                                                        required="">
                                                    <span class="glyphicon form-control-feedback"
                                                        aria-hidden="true"></span>
                                                    <span class="help-block with-errors"></span> -->
                                                    &nbsp;
                                                </div>
                                            </div>
                                        
                                        
                                            <div class="form-title">
                                                <h4>Availably Of Water (පවතින ජල පහසුකම්)</h4>
                                            </div>
                                        
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <div class="form-inline">
                                                            <span>Pipe born water නලජලය</span>
                                                            <textarea type="text" class="form-control" id="pipe_born_water" name="pipe_born_water" placeholder="Pipe born water" required="" style="width:100%;"></textarea>
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="form-inline">
                                                            <span>If so distance to Main line (නල ජල පද්ධතිය ඇඳීමට ඇති දුර)</span>
                                                            <textarea type="text" class="form-control" id="distance_to_main_pipe_line" name="distance_to_main_pipe_line" placeholder="Distance to Main Pipe Line" required="" style="width:100%;"></textarea>
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-inline">
                                                            <span>Do you need a water Supply Project Provide by the company ? <br/> (ආයතනය මඟින් සපයනනල ජල ව්‍යාපෘතියක් අවශ්‍යයද?) </span>
                                                            <textarea type="text" class="form-control" id="water_supply_project_necessity" name="water_supply_project_necessity" placeholder="Do you need a water Supply Project Provide by the company" required="" style="width:100%;"></textarea>
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-inline">
                                                            <span>Of well water to be used water level type of the well and problem may occur ? <br/> (ළිං ජලය භාවිතා කරන්නේ නම් ළිදේ ගැඹුර සහ ළිංවල ස්වරූපය - ළිඳක් කැපිමේදි ඇති විය හැකි ගැටළු) </span>
                                                            <textarea type="text" class="form-control" id="water_supply_project_necessity" name="water_supply_project_necessity" placeholder="Of well water to be used water level type of the well and problem may occur" required="" style="width:100%;"></textarea>
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>
                                                </div>                                       

                                            </div>

                                            <div class="form-title">
                                                <h4> Soil Condition (පසේ ස්භාවය)</h4>
                                            </div>
                                                                                 
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <div class="form-inline">
                                                            <span>
                                                                Need to the Fill ? Condition Soil, Water Level, under neath formation of rock, if available. </span> 
                                                                <br/>
                                                            පිරවිය යුතුද , කදු සහිතද, පොළවේ ජලමට්ටම, පසෙහි ස්වභාවය, ගල් සහිතද</span>
                                                            <textarea type="text" class="form-control" id="soil_condition" name="soil_condition" placeholder="Soil Condition" required="" style="width:100%;"></textarea>
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                            </div> 
                                            
                                            <div class="form-title">
                                                <h4> 
                                                    Recommended sale price per perch - <br/> (ඉඩම විකිණිම සඳහා අනුමත මිළ ගණන)
                                                </h4>
                                            </div>
                                                                                 
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <div class="form-inline">
                                                        <textarea type="text" class="form-control" id="sale_price_per_perch" name="sale_price_per_perch" placeholder="Recommended size of the block" required="" style="width:100%;"></textarea>
                                                    </div>
                                                </div>
                                            </div> 

                                        
                                        
                                        </div>
                                        <div class="col-md-6 validation-grids validation-grids-right">
                                            <div class="widget-shadow" data-example-id="basic-forms">
                                                <div class="form-title">
                                                    <h4>Land Details :</h4>
                                                </div>
                                                <div class="form-body">
                                                    <div class="form-group   has-feedback">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Acs</td>
                                                                    <td>Rds</td>
                                                                    <td>Pcs</td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <input type="number" step="0.01" name="arc"
                                                                            id="arc" value="0"
                                                                            onchange="calculate_totpurch()"
                                                                            placeholder="Arc"
                                                                            data-error="Invalid number" required="">
                                                                    </td>
                                                                    <td> <input type="number" step="0.01" name="rds"
                                                                            id="rds" value="0"
                                                                            onchange="calculate_totpurch()"
                                                                            placeholder="Arc"
                                                                            data-error="Invalid number" required="">
                                                                    </td>
                                                                    <td> <input type="number" step="0.01" name="pcs"
                                                                            id="pcs" value="0"
                                                                            onchange="calculate_totpurch()"
                                                                            placeholder="Arc"
                                                                            data-error="Invalid number" required="">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="form-inline">
                                                        <div class="form-group   has-feedback">
                                                            <input type="number" style="max-width:150px" step="0.01" class="form-control" id="extendperch" name="extendperch" pattern="[0-9]+([\.][0-9]{0,2})?" placeholder="Land Extent In Perch" onblur="calculate_arc(this.value)" required="">
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                            <input type="text" class="form-control" name="land_arc" id="land_arc" pattern="[0-9]+([\.][0-9]{0,10})?" placeholder="Land Extent In Arc" data-error="Invalid number" required=""> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"> </div>

                                                    <br>


                                                </div>
                                                <div class="form-title">
                                                    <h4>Location Of the Land / Marketability <br/> (ඉඩම පිහිටි ස්ථානය / ඉඩම විකිණිමට ඇති හැකියාව) </h4>

                                                </div>
                                                <div class="form-body">
                                                    <div class="form-group">

                                                    <div class="form-inline"  style="padding:10px;">
                                                        අවටඇතිඅනෙකුත්ඉඩම්ව්‍යාපෘති සහ විකිණිමට ඇති
                                                        පෞද්ගලික හිමි කරුවන්ගේ ඉඩම්වල දත්ත සහ එම ඉඩම්වලට අපගේ ඉඩමේ සිට ඇති
                                                        දුර සහ එම ඉඩම්වල සිට ප්‍රධාන මාර්ගවලට ඇති දුර
                                                        ( අවට ඇති ඉඩම්වල විකුණුන කොටස් ගනණ සහ ඉතිරිව ඇති කොටස් ගණන සහ ඒවායේ
                                                        මිලගණන් හා දුරකථන අංක
                                                    </div>

                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <lable>Distance to main roads, Schools, Hospital And Government & Privet Institutes</label>
                                                        </div>
                                                    </div>

                                                    <div class="form-inline">
                                                            <textarea type="text" class="form-control" id="institutes_info" name="institutes_info" placeholder="Marketability" required="" style="width:100%;"></textarea>
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>

                                                    <div class="form-inline" style="padding:10px;">
                                                        <label>Attachment 1</label><br/>
                                                        <input type="file" class="form-control" id="attachment1" name="attachment1" placeholder="Attachment 1" required="">
                                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>
                                                    </div>

                                                    <div class="form-inline">
                                                            <textarea type="text" class="form-control" id="attachment2" name="attachment1" placeholder="Attachment 2" required="" style="width:100%;"></textarea>
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>

                                                    <div class="form-inline">
                                                        <label>Attachment 1</label><br/>
                                                        <input type="file" class="form-control" id="plan_copy" name="plan_copy" placeholder="Marketability" required="">
                                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>
                                                    </div>


                                                    <div class="form-inline" style="padding:10px;">
                                                        Detail of the population lives closer to Land ( Race, Religion, Cast)    <br/>
                                                        අපට ජීවත්වන ජන ගහනය පිළිබඳ තොරතුරු ( ආගම / කුලය )
                                                    </div>

                                                    <div class="form-inline" style="padding:10px;">
                                                            <textarea type="text" class="form-control" id="population_data" name="population_data" placeholder="Detail of the population lives closer to Land" required="" style="width:100%;"></textarea>
                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                    </div>
                                                  
                                                    <br/>

                                                    <div class="form-title">
                                                        <h4>Electricity (විදුලිය පහසුකම්)</h4>
                                                    </div>

                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            
                                                            <div class="form-inline">
                                                                Distance to the 3 phase electricity post (තෙකලා විදුලිය සහිත කණුවට ඇති දුර)   
                                                            </div>

                                                            <div class="form-inline">
                                                                    <textarea type="text" class="form-control" id="population_data" name="population_data" placeholder="Distance to the 3 phase electricity post" required="" style="width:100%;"></textarea>
                                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                            </div>
                                                            <br/>

                                                            <div class="form-inline">
                                                                Distance to the Transformer (ට්‍රාන්ස්ෆෝමර් එකට ඇති දුර) 
                                                            </div>

                                                            <div class="form-inline">
                                                                    <textarea type="text" class="form-control" id="population_data" name="population_data" placeholder="Distance to the Transformer" required="" style="width:100%;"></textarea>
                                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                            </div>
                                                            
                                                        </div>

                                                        
                                                    </div>

                                                    <br/>

                                                    <div class="form-title">
                                                        <h4>Positive and Negative factors of The Land <br/> (ඉඩම සම්බන්ධව ධනාත්මක හා ඍණාත්මක ආකල්ප)</h4>
                                                    </div>

                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            
                                                            <div class="form-inline">
                                                                Positive factors of The Land. - (ඉඩම සම්බන්ධව ධනාත්මක ආකල්ප)
                                                            </div>

                                                            <div class="form-inline">
                                                                    <textarea type="text" class="form-control" id="land_positive_factor" name="land_positive_factor" placeholder="Positive factors of The Land" required="" style="width:100%;"></textarea>
                                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                            </div>
                                                            <br/>

                                                            <div class="form-inline">
                                                                Negative factors of The Land - (ඉඩම සම්බන්ධව ඍණාත්මක ආකල්ප)
                                                            </div>

                                                            <div class="form-inline">
                                                                    <textarea class="form-control" id="land_negative_factor" name="land_negative_factor" placeholder="Negative factors of The Land " required="" style="width:100%;"></textarea>
                                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                            </div>

                                                            <br/>

                                                            <div class="form-inline">
                                                                If Suitable for blackout, recommended size of the block - (මෙම ඉඩම කොටස්කර විකිණිමට සුදුසු නම් එම ඉඩම කොටස්කල යුතු කැබැල්ලක ප්‍රමාණය (Block Size))
                                                            </div>

                                                            <div class="form-inline">
                                                                    <input type="text" class="form-control" id="land_negative_factor" name="land_negative_factor" placeholder="Negative factors of The Land " required="" style="width:100%;"/>
                                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                            </div>
                                                            
                                                        </div>                                                        
                                                    </div>
                                                    
                                                </div>

                                                
                                                <div class="bottom">
                                                        <div class="form-group" style="padding-top:20px;">
                                                            <button type="submit" class="btn btn-primary disabled">Sumbit</button>
                                                        </div>
                                                        <div class="clearfix"> </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"> </div>
                                    <br />

                                </form>
                                <p></p>
                            </div>

                        </div>
                    </div>
                </div>



                <div class="col-md-4 modal-grids">
                    <button type="button" style="display:none" class="btn btn-primary" id="flagchertbtn"
                        data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
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

                <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm"
                    name="complexConfirm" value="DELETE"></button>
                <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm"
                    name="complexConfirm_confirm" value="DELETE"></button>
                <form name="deletekeyform"> <input name="deletekey" id="deletekey" value="0" type="hidden">
                </form>
                              



                <div class="clearfix"> </div>
            </div>

        </div>
    </div>





    <!--footer-->

<script src="<?=base_url()?>media/js/dist/Chart.js"></script>
<script src="<?=base_url()?>media/js/utils.js"></script>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
$(document).ready(function()
{

    $("#prj_id").chosen({
            allow_single_deselect: true
    });

    setTimeout(function(){ 
        $("#land_code").chosen({
            allow_single_deselect : true,
            search_contains: true,
            no_results_text: "Oops, nothing found!",
            placeholder_text_single: "Select a Land"
        });
    });

    $("#district").focus(function() {
        $("#district").chosen({
            allow_single_deselect : true
        });
    });

    $("#procouncil").focus(function() {
        $("#procouncil").chosen({
        allow_single_deselect : true
        });
    });
  
	$("#town").focus(function() {
        $("#town").chosen({
            allow_single_deselect : true
        });
    });
    
});

</script>

<?
    $this->load->view("includes/footer");
?>