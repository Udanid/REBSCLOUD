<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{
font-size:12px;
}
.row{
	font-size:12px;
}
.table{
	font-size:12px;
}

.descCol{
    width:30%;
}

.colorRow{
    background-color: #EAEAEA;
    border-bottom: 1px solid #D6D5D5;
    }
    .center {
  margin-left: auto;
  margin-right: auto;
}
</style>
<script type="text/javascript">

function print_function()
{
	window.print();
	setTimeout(function(){
		window.close();
	},100);
}

</script>
<body onLoad="print_function()">
<div class="row center">
	<div class="widget-shadow" data-example-id="basic-forms">
    <div class="row">
        <div class="  widget-shadow" data-example-id="basic-forms">
            <div class="form-title" style="text-align:center; font-weight: bolder;">
                <h5><b>Market Survey Report - <?php echo(@$land_details->property_name); ?></b></h5>
            </div>
        </div>
    </div>
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


    <table id="printIndentTable" class="table table-bordered table-hover " cellpadding="0" cellspacing="0">
        <tr class="show-on-print colorRow"><th colspan="6">Basic Information</th></tr>
        <tr>
          <td class="descCol">Introducer 1 </td>
          <td colspan="5"> <?php echo($name1);?></td>
        </tr>
        <tr>
          <td class="descCol">Introducer 2 </td>
          <td colspan="5"> <?php if(isset($name2)){echo($name2);}?></td>
        </tr>
        <tr>
          <td class="descCol">Introduced Date  </td>
          <td colspan="5"> <?php echo($land_details->intro_date); ?></td>
        </tr>
        <!-- <tr>
          <td colspan="4">&nbsp; </td>
        </tr> -->
        <tr class="show-on-print colorRow"><th colspan="6">Land Details</th></tr>



        <tr>
          <td>Land Exptend Per Perch  </td>
          <td colspan="5"> <?php echo(@$project_details->land_extend); ?> </td>
        </tr>
        <tr>
          <td>Perch Price   </td>
          <td colspan="5"><?php echo(@$project_details->purchase_price); ?></td>
        </tr>
        <tr>
          <td>Environment data   </td>
          <td colspan="5"> <?php echo(@$land_details->envirronment_data); ?></td>
        </tr>
        <tr>
          <td>Total Price  </td>
          <td colspan="5"> <?php echo(number_format((@$project_details->purchase_price) * (@$project_details->land_extend), 2)); ?></td>
        </tr>
        <tr>
          <td>Recommended Sale Price  </td>
          <td colspan="5"> <?php echo(number_format($market_servay_data[0]->recommended_sale_price, 2)); ?></td>
        </tr>

        <tr class="show-on-print colorRow"><th colspan="6">Owner Information</th></tr>

        <tr>
          <td  colspan="2"><strong>Owner Name</strong> 	 	</td>
          <td  colspan="2"><strong>Address</strong></td>
          <td  colspan="2"><strong>NIC</strong></td>
        </tr>
        <tr>
          <td colspan="2"><?php echo($land_owner_details[0]->owner_name); ?></td>
          <td colspan="2"><?php echo($land_owner_details[0]->address); ?><br /></td>
          <td colspan="2"><?php echo($land_owner_details[0]->nic); ?></td>
        </tr>

        <tr class="show-on-print colorRow"><th colspan="6">Location Details </th></tr>


        <tr>
          <td><strong>District</strong>    </td>
          <td> <?php echo($land_details->district); ?></td>
          <td><strong>Provincial Council</strong>    </td>
          <td><?php echo($land_details->procouncil); ?></td>
          <td><strong>Town</strong> </td>
          <td><?php echo($land_details->town); ?></td>
        </tr>
        <tr>
          <td>Address</td>
          <td colspan="5">
            <?php echo($land_details->address1); ?> <br/>
            <?php echo($land_details->address2); ?> <br/>
            <?php echo($land_details->address3); ?> <br/>
        </td>
        </tr>

        <tr class="show-on-print colorRow"><th colspan="6">Availably of Water  </th></tr>

        <tr>
          <td colspan="2">Land Exptend Per Perch  </td>
          <td colspan="4"> <?php echo($market_servay_data[0]->pipe_born_water); ?>  </td>
        </tr>

        <tr>
          <td colspan="2">Distance to Main line (meters) </td>
          <td colspan="4"><?php echo($market_servay_data[0]->distance_to_main_pipe_line); ?> </td>
        </tr>

        <tr>
          <td colspan="2">Do you need a water Supply Project Provide by the company ? </td>
          <td colspan="4"> <?php echo($market_servay_data[0]->water_source_informarion); ?> </td>
        </tr>

        <tr>
          <td colspan="2">Of well water to be used water level type of the well and problem may occur ?</td>
          <td colspan="4"> <?php echo($market_servay_data[0]->used_water_level_type); ?> </td>
        </tr>

        <tr class="show-on-print colorRow"><th colspan="6">Soil Condition  </th></tr>

        <tr>
          <td colspan="2">Need to the fill ? Soil Condition, Water Level, Under Neath Formation of Rock, if Available. </td>
          <td colspan="4"> <?php echo(@$market_servay_data[0]->soil_condition); ?> </td>
        </tr>

        <tr class="show-on-print colorRow"><th colspan="6">Electricity  </th></tr>

        <tr>
          <td colspan="2">Distance to the 3 phase electricity post (meters) </td>
          <td colspan="4"> <?php echo(@$market_servay_data[0]->distance_electricity_post); ?> </td>
        </tr>
        <tr>
          <td colspan="2">Distance to the Transformer (meters) </td>
          <td colspan="4"> <?php echo(@$market_servay_data[0]->distance_to_transformer); ?> </td>
        </tr>

        <tr class="show-on-print colorRow"><th colspan="6">Detail of the population lives closer to Land ( Race, Religion, Cast)    </th></tr>
        <tr><td colspan="6"><?php echo(@$market_servay_data[0]->population_data); ?></td></tr>

        <tr class="show-on-print colorRow"><th colspan="6">Location of the Land / Marketability   </th></tr>


        <?php

        $market_servay_data_arr = json_decode($market_servay_data[0]->marketability_descriptions, true);
        $market_servay_val_arr = json_decode($market_servay_data[0]->marketability_values, true);

        foreach(array_combine($market_servay_data_arr,$market_servay_val_arr) as $key=>$value) {
            ?>

                    <tr><td><label><?php echo(@$key); ?> (meters)  </label></td> <td colspan="5"><?php echo(@$value); ?>  </td>  </tr>

                <br/>
            <?php
        }
        ?>


        <tr class="show-on-print colorRow"><th colspan="6"> Positive Factors of The Land  </th></tr>
        <tr><td colspan="6"><?php echo($market_servay_data[0]->land_factors_positive); ?>  </td></tr>

        <tr class="show-on-print colorRow"><th colspan="6"> Negative Factors of The Land   </th></tr>
        <tr><td colspan="6"><?php echo(@$market_servay_data[0]->land_factors_negative); ?></td></tr>


    </table>
    <br><br>
    <table cellpadding="0" cellspacing="0" class="table">
    	<tr>
        	<td colspan="2" width="300" align="center">.................................<br>Officer Signature</td>
            <td>&nbsp;</td>
            <td colspan="2" width="300" align="center">.................................<br>Asst. Manager	</td>
            <td>&nbsp;</td>
            <td colspan="2" width="300" align="center">.............................................<br>Senior Branch Manager</td>
        </tr>
    </table>
    <br><br>
    <table cellpadding="0" cellspacing="0"  class="table">
        <tr>
        	<td colspan="2" width="300"  align="center">.................................................<br>G.M - ( Admin & Operation)</td>
            <td>&nbsp;</td>
            <td colspan="2" width="300"  align="center">.................................<br>Managing Direector</td>
            <td>&nbsp;</td>
            <td colspan="2" width="300" ></td>
        </tr>
    </table>


</div>
