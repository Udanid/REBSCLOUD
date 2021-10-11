
<div class="row">

	<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
		<div class="form-title">
			<h4 style="background-color:none;">Owner and Location Details :</h4>
		</div>
		<div class="form-body">
			<div class="form-group">
				<label class="control-label" for="inputSuccess1">Land Name : <?=@$details->property_name?>  </label>
			</div>

			
			<?php 
			if(is_array($introduceerlist))
			{
				if(count($introduceerlist))
				{					
					foreach($introduceerlist as $intro)
					{
						
						if($details->intro_code == $intro->intro_code)
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
						if($details->intro_code2 == $intro->intro_code)
						{
							$name2 = $intro->first_name . " " . $intro->last_name;													
						}						
						
					}				
				}
			}
			?>			

			<div class="form-group">
				<label class="control-label" for="inputSuccess1">Introducer 1 : <?=@$name1?></label>
			</div>	
			<div class="form-group">
				<label class="control-label" for="inputSuccess1">Introducer 2 : <?=@$name2?></label>
			</div>
			
			
			<div class="form-group has-feedback">
				<label class="control-label" for="inputSuccess1">
				Land Owner : <?=@$details->owner_name?>
				</label>
				<?//=$details->town?>
			</div>
			<div class="form-group has-feedback"> 
				<label class="control-label" for="inputSuccess1">Site Address: <br/></label>
				
				<?=@$details->address1?>, 
				<?=@$details->address2?>, 
				<?=@$details->address3?>.

			</div>

			<div class="form-group"> 				
				District : <?=@$details->district?> <br />				
			</div>	
			<div class="form-group"> 
				Provincial Council : <?=@$details->procouncil?> <br />
			</div>
			<div class="form-group"> 
				Town : <?=@$details->town?> <br />
			</div>
			
		</div>
				
	</div>
	<div class="col-md-6 validation-grids validation-grids-right">
		<div class="widget-shadow" data-example-id="basic-forms">
			<div class="form-title">
				<h4>Price Details :</h4>
			</div>
			<div class="form-body">

				<div class="form-group has-feedback">
					<label class="control-label">Purchase  : <?=@$details->perch_price?></label>
				</div>
				<div class="form-group has-feedback">
					<label class="control-label">Owner Expected Price : <?=@$details->perch_price?></label>
				</div>

			</div>
			<br/>
			
		</div>


		<div class="widget-shadow" data-example-id="basic-forms">
			<div class="form-title">
				<h4>Land Features :</h4>
			</div>
			<div class="form-body">

				<div class="form-group"> 
					Envirronment data : <?=@$details->envirronment_data?> <br />
				</div>

				<div class="form-group"> 
					Remarks : <?=@$details->remarks?> <br />
				</div>
				
			</div>
			<br/>
			
		</div>


		
	</div>
</div>
