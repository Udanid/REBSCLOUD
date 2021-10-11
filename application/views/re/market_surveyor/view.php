
<h4>Market Survey Report - <?php echo($land_details->property_name); ?>
    <span style="float:right; color:#FFF">
        <a href="javascript:close_edit('<?=@$land_details->land_code?>')"><i class="fa fa-times-circle "></i></a></span>
</h4>
<div class="table widget-shadow">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6" data-example-id="basic-forms">
                    <div class="widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h5 style="background-color:none;">Availability of Water</h5>
                        </div>
                        <div class="form-body">
                            <div class="form-inline">
                                <div class="form-group">
                                    <strong>Pipe Borne Water: </strong>
                                    <?php echo($market_servay_data[0]->pipe_born_water); ?>
                                </div>
                                <div class="clearfix"> </div>
                                <div class="form-group">
                                    <strong>Distance to the Main Line: </strong>
                                    <?php echo($market_servay_data[0]->distance_to_main_pipe_line); ?> M
                                </div>
                                <div class="clearfix"> </div>
                                <div class="form-group">
                                    <strong>Do You Need a Water Supply Project Provide by the Company? </strong>
                                    <?php echo($market_servay_data[0]->water_source_informarion); ?>
                                </div>
                            </div>
                            <div class="clearfix"> </div>

                            <div class="form-group has-feedback"><strong>If Well Water to be Used, Water Level Type of the Well and Problem may Occur? </strong>
                            <?php echo($market_servay_data[0]->used_water_level_type); ?>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6" data-example-id="basic-forms">
                    <div class="widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h5 style="background-color:none;">Soil Condition</h5>
                        </div>
                        <div class="form-body">
                            <div class="form-inline">
                                <div class="form-group">
                                    <strong>Need to the Fill? Soil Condition, Water Level, Under Neath Formation of Rock, if Available. </strong>
                                    <?php echo(@$market_servay_data[0]->soil_condition); ?>
                                </div>                                
                            </div>
                            <div class="clearfix"> </div>                            
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                    <div class="widget-shadow" data-example-id="basic-forms" style="margin-top:10px;">
                        <div class="form-title">
                            <h5 style="background-color:none;">Electricity</h5>
                        </div>
                        <div class="form-body">
                            <div class="form-inline">
                                <div class="form-group">
                                    <strong>Distance to the 3 phase electricity post: </strong>
                                    <?php echo(@$market_servay_data[0]->distance_electricity_post); ?> m
                                </div>                                
                            </div>
                            <div class="clearfix"> </div>  
                            <div class="form-inline">
                                <div class="form-group">
                                    <strong>Distance to the Transformer :</strong>  <?php echo(@$market_servay_data[0]->distance_to_transformer); ?> m
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>    
            <div class="col-md-12" data-example-id="basic-forms"  style="padding:10px;">
                <div class="widget-shadow" data-example-id="basic-forms">
                    <div class="form-title">
                        <h5 style="background-color:none;">Detail of the population lives closer to Land ( Race, Religion, Cast) </h5>
                    </div>
                    <div class="form-body">
                        <div class="form-inline">
                            <div class="form-group">
                                <strong>Information : </strong>
                                <?php echo(@$market_servay_data[0]->population_data); ?>
                            </div>                                
                        </div>
                        <div class="clearfix"> </div>                            
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>     
             
            <div class="col-md-12" data-example-id="basic-forms"  style="padding:10px;">
                <div class="widget-shadow" data-example-id="basic-forms">
                    <div class="form-title">
                        <h5 style="background-color:none;">Location of the Land / Marketability</h5>
                    </div>
                    <div class="form-body">
                        <div class="form-inline">
                    <?php

                    $market_servay_data_arr = json_decode($market_servay_data[0]->marketability_descriptions, true);
                    $market_servay_val_arr = json_decode($market_servay_data[0]->marketability_values, true);

                    foreach(array_combine($market_servay_data_arr,$market_servay_val_arr) as $key=>$value) {
                        
                        ?>
                            <div class="form-group">
                                <strong><?php echo(@$key); ?> : </strong> <?php echo(@$value); ?> m                         
                            </div> 
                            <br/>
                        <?php
                    }                   
                    ?>
                    </div>
                        <div class="clearfix"> </div>                            
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>     


            <div class="row">
                <div class="col-md-6" data-example-id="basic-forms">
                    <div class="widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h5 style="background-color:none;">Positive factors of The Land </h5>
                        </div>
                        <div class="form-body">
                            <div class="form-inline">
                                <div class="form-group">                                   
                                    <?php echo($market_servay_data[0]->land_factors_positive); ?>                                                                     
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6" data-example-id="basic-forms">
                    <div class="widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h5 style="background-color:none;">Negative factors of The Land  :</h5>
                        </div>
                        <div class="form-body">
                            <div class="form-inline">
                                <div class="form-group">
                                    <?php echo(@$market_servay_data[0]->land_factors_negative); ?>
                                </div>                                
                            </div>                                               
                        </div>
                    </div>                  
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="col-md-6" data-example-id="basic-forms">
                    <div class="widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h5 style="background-color:none;">Basic Information</h5>
                        </div>
                        <div class="form-body">
                            <?php 
                            if(is_array($introduceerlist))
                            {
                                if(count($introduceerlist))
                                {					
                                    foreach($introduceerlist as $intro)
                                    {
                                        
                                        if($land_details->intro_code == $intro->intro_code)
                                        {
                                            $name1 = $intro->first_name . " " . $intro->last_name;													
                                        }						
                                        
                                    }				
                                }
                            }
                            ?>
                            
                            <?php 
                            if(is_array($introduceerlist))
                            {
                                if(count($introduceerlist))
                                {					
                                    foreach($introduceerlist as $intro)	
                                    {						
                                        if($land_details->intro_code2 == $intro->intro_code)
                                        {
                                            $name2 = $intro->first_name . " " . $intro->last_name;													
                                        }						
                                        
                                    }				
                                }
                            }
                            ?>
                            
                            
                            <div class="form-inline">
                                <div class="form-group">
                                    <strong>1st Introducer Name : </strong>
                                    <?php echo($name1); ?>
                                </div>
                                <div class="clearfix"> </div>
                                <div class="form-group">
                                    <strong>2nd Introducer Name : </strong>
                                    <?php echo($name2); ?>
                                </div>
                                <div class="clearfix"> </div>
                                <div class="form-group">
                                    <strong>Introduced Date : </strong>
                                    <?php echo($land_details->intro_date); ?>
                                </div>
                            </div>
                            <div class="clearfix"> </div>

                            <div class="form-group has-feedback"><strong>Land Name : </strong>
                                <?php echo(@$land_details->property_name); ?>
                            </div>
                            <div class="form-group has-feedback"><strong>Remarks : </strong>
                                <?php echo(@$land_details->remarks); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h5>Land Details</h5>
                        </div>
                        <div class="form-body">

                            <div class="form-group has-feedback"><strong>Land Exptend Per Perch : </strong>
                                <?php echo(@$project_details->land_extend); ?>
                            </div>
                            <!-- <div class="form-group has-feedback">
                            <strong>Land Exptend Arc : : </strong>
                            <?php //echo($project_details->land_extend); ?>
                            </div> -->

                            <div class="form-group has-feedback"><strong>Perch Price : </strong>
                                <?php echo(@$project_details->purchase_price); ?>
                            </div>
                            <div class="form-group has-feedback">
                                <strong>Total Price : </strong>
                                <?php echo(number_format((@$project_details->purchase_price) * (@$project_details->land_extend), 2)); ?>
                            </div>
                            <div class="form-group has-feedback">
                                <strong>Recommended Sale Price : </strong>
                                <?php echo(number_format($market_servay_data[0]->recommended_sale_price, 2)); ?>
                            </div>
                            <div class="form-group has-feedback"><strong>Environment data : </strong>
                                <?php echo(@$land_details->envirronment_data); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"> </div><br />

                <div class="col-md-12 ">
                    <div class="widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h5>Owner List</h5>
                        </div>
                        <table class="table">
                            <tr>
                                <th>Owner Name</th>
                                <th>Address</th>
                                <th>NIC</th>
                            </tr>
                            <tbody>
                                <tr>
                                    <td><?php echo($land_owner_details[0]->owner_name); ?></td>
                                    <td>
                                        <?php echo($land_owner_details[0]->address); ?><br />
                                    </td>
                                    <td><?php echo($land_owner_details[0]->nic); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="clearfix"> </div><br />
                <div class="col-md-12 ">
                    <div class="widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h5>Location Details</h5>
                        </div>
                        <table class="table">
                            <tr>
                                <td>
                                    <div class="form-group"><strong>District : </strong>
                                        <?php echo($land_details->district); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group"><strong>Provincial Council : </strong>
                                        <?php echo($land_details->procouncil); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group has-feedback"><strong>Town : </strong>
                                        <?php echo($land_details->town); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group has-feedback"><strong>Address Line 1 : </strong>
                                        <?php echo($land_details->address1); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group has-feedback"><strong>Address Line 2 : </strong>
                                        <?php echo($land_details->address2); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group has-feedback"><strong>City : </strong>
                                        <?php echo($land_details->address3); ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
                <div class="bottom ">
                    <div class="form-group"></div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </div>