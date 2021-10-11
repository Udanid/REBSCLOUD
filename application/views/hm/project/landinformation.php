 <script>


 $( function() {
    $( "#date_prjcompletion" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#date_proposal" ).datepicker({dateFormat: 'yy-mm-dd'});
	  $( "#date_purchase" ).datepicker({dateFormat: 'yy-mm-dd'});
	    $( "#date_prjcommence" ).datepicker({dateFormat: 'yy-mm-dd'});
		  $( "#date_slscommence" ).datepicker({dateFormat: 'yy-mm-dd'});
		   $( "#date_dvpcompletion" ).datepicker({dateFormat: 'yy-mm-dd'});
  } );
 function check_this()
 {
	// alert("ssss");

	 var date1 = new Date(document.getElementById('date_prjcommence').value);
	var date2 = new Date(document.getElementById('date_prjcompletion').value);
	var timeDiff = date2.getTime() - date1.getTime();
	if(timeDiff<0)
	{
		document.getElementById('date_prjcompletion').value="";
		alert("End Date Should be greater than the start Date");
	}
	else
	{
		timeDiff = Math.abs(date2.getTime() - date1.getTime());
		var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24*30));

		  var dptime=parseFloat(document.getElementById('devmonth').value)
	   var saletime=parseFloat(document.getElementById('selmonth').value)
		document.getElementById('period').value=parseFloat(dptime)+parseFloat(saletime);
 	}
 }
  function padDigits(number, digits) {
    return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number;
}
 function calculate_periods()
 {
 //date_proposal,date_purchase,date_prjcommence,,date_dvpcompletion,date_slscommence,date_prjcompletion,selmonth,selmonth
       var date1 = new Date(document.getElementById('date_prjcommence').value);
	   var dptime=parseFloat(document.getElementById('devmonth').value)*1000 * 3600 * 24*30
	   var saletime=parseFloat(document.getElementById('selmonth').value)*1000 * 3600 * 24*30
	   var starttime=date1.getTime();
	   var dpcomplete=   parseFloat(starttime)+ parseFloat(dptime)  ;
	   var date_dvpcompletion=new Date(dpcomplete);
	  // alert(date_dvpcompletion)
	   var day = date_dvpcompletion.getDate();
 		var monthIndex = date_dvpcompletion.getMonth()+1;
		monthIndex= padDigits(monthIndex,2);
		  var year = date_dvpcompletion.getFullYear();
		  day = padDigits(day,2);
		  document.getElementById('date_purchase').value=document.getElementById('date_proposal').value;
		   document.getElementById('date_dvpcompletion').value=year+'-'+monthIndex+'-'+day;
		    document.getElementById('date_slscommence').value=year+'-'+monthIndex+'-'+day;
			  var date1 = new Date(document.getElementById('date_slscommence').value);
			   starttime=date1.getTime();
			   dpcomplete=   parseFloat(starttime)+ parseFloat(saletime)  ;
			     var date_prjcompletion=new Date(dpcomplete);
				  var day = date_prjcompletion.getDate();
 		var monthIndex = date_prjcompletion.getMonth()+1;
		monthIndex= padDigits(monthIndex,2);
		day = padDigits(day,2);
		  var year = date_prjcompletion.getFullYear();
		  document.getElementById('date_prjcompletion').value=year+'-'+monthIndex+'-'+day;
	//   date_dvpcompletion=format_date(date_dvpcompletion)
	   //alert(monthIndex)
 }
 function calculate_totP(obj)
 {
	 var val= document.getElementById('checkthisprs').value;
	// alert(val)
	 if( document.getElementById('checkthisprs').checked)
	 {
	 var totres=parseFloat(document.getElementById('tot_resprecentage').value);
	 if(totres>0)
	 {
		 var roadp=parseFloat(document.getElementById('road_waysP').value);
		 var openp=parseFloat(document.getElementById('open_spaceP').value);
		 var otherp=parseFloat(document.getElementById('other_resP').value);
		 document.getElementById('other_res').value=(totres*otherp/100).toFixed(2);;
		  document.getElementById('open_space').value=(totres*openp/100).toFixed(2);;
		   document.getElementById('road_ways').value=(totres*roadp/100).toFixed(2);;
		    document.getElementById('unselable_area').value=parseFloat(document.getElementById('tot_resprecentage').value);
			val =parseFloat(document.getElementById('land_extend').value)-parseFloat(document.getElementById('tot_resprecentage').value);

			document.getElementById('selable_area').value=(parseFloat(document.getElementById('land_extend').value)-parseFloat(document.getElementById('tot_resprecentage').value)).toFixed(2)	;



	 }
	 }
 }
 </script>
                        <div class="row">


    					     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h4 style="background-color:none;">Owner and Location Details :</h4>
							</div>
							<div class="form-body">
								 <div class="form-group">
                                         <label class="control-label" for="inputSuccess1">Project Name</label>
										 <input type="text"  class="form-control" name="project_name"  id="project_name"value="<?=$details->property_name?>"  required>


									</div>
                  <div class="form-group"><label class="control-label">Project Type</label>
                    <select name="prj_type" id="prj_type" class="form-control">
                      <? if($prj_type){

                        foreach ($prj_type as $key => $value) {?>
                          <option value="<?=$value->prjtype_id?>" ><?=$value->short_code?> - <?=$value->prjtype_name?></option>
                    <?    }
                      }?>

                    </select>
                  </div>
                  <? $owenership_type="Company Own Property";
                  if($details->owenership_type=="client_property"){
                    $owenership_type="Client Property";
                  }?>
                  <div class="form-group"><label class="control-label">Land Ownership</label>
                    <input type="hidden" name="ownership_type" id="ownership_type" value="<?=$details->owenership_type?>">
                  <textarea name="ownership" id="ownership" class="form-control"><?=$owenership_type?></textarea>
                  </div>

                  <? if($details->owenership_type!="client_property"){?>
									<div class="form-group">

                                    <label class="control-label" for="inputSuccess1">Introducer</label>
                                    <input type="text" readonly class="form-control" name="introducer" value="<?=$details->first_name?>  <?=$details->last_name?>">

										</div>
                  <? }?>
									<div class="form-group has-feedback"><label class="control-label" for="inputSuccess1">Land Owner</label>
										<input type="text" class="form-control"name="owner_name"  readonly value="<?=$details->owner_name?>" id="owner_name"   placeholder="Land Owner Name" data-error=""  required>
										<input   type="hidden" class="form-control"name="town"  readonly value="<?=$details->town?>" id="town"   placeholder="Land Owner Name" data-error=""  required>
									</div>
                                    	<div class="form-group has-feedback"> <label class="control-label" for="inputSuccess1">Site Address</label>
										<textarea type="text" class="form-control"name="Address"   id="Address"   placeholder="Property Name" data-error=""   readonly="readonly"><?=$details->address1?>, <?=$details->address2?>, <?=$details->address3?>.</textarea>

									</div>



                                    </div>
                                   <div class="form-title">
								<h4>Project Details  : </h4>
							</div>
							<div class="form-body form-horizontal">
                           <!-- <div class="form-group"><label class="col-sm-3 control-label">Percentage</label>
										<div class="col-sm-3"><input type="checkbox"  class="form-control" name="checkthisprs" id="checkthisprs"  value="YES"/></div>
                                      </div> -->
                                    <div class="form-group"><label class="col-sm-3 control-label">Land Extend (Perch)</label>
										<div class="col-sm-3"><input type="text" class="form-control"   id="land_extend"  value="<?=$details->extendperch?>" name="land_extend" pattern="[0-9]+([\.][0-9]{0,2})?"    readonly="readonly"  required></div>
                                        <!-- <label class="col-sm-3 control-label" >Road ways</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="road_ways" onBlur="calculate_tot(this.value)"   value="0" name="road_ways"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div> -->
                  </div>
<!--
                                     <div class="form-group"><label class="col-sm-3 control-label">Other Reservation</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="other_res"  value="0" onBlur="calculate_tot(this.value)" name="other_res"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-sm-3 control-label">Open Area</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="open_space"  value="0"  onBlur="calculate_tot(this.value)"name="open_space"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                                       <div class="form-group"><label class="col-sm-3 control-label">Unsalable Area</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="unselable_area"  value="0" onBlur="calculate_tot(this.value)" name="unselable_area"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-sm-3 control-label">Salable Area</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="selable_area"  value="0"  name="selable_area"   pattern="[0-9]+([\.][0-9]{0,2})?"  readonly="readonly" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>


							</div>
                            <div class="form-body form-horizontal">
                                    <div class="form-group"><label class="col-sm-3 control-label">Total Reservation</label>
										<div class="col-sm-3"><input type="text" class="form-control"   id="tot_resprecentage"  value="0" name="tot_resprecentage" pattern="[0-9]+([\.][0-9]{0,2})?"      required></div>
                                        <label class="col-sm-3 control-label" >Road ways %</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="road_waysP" onBlur="calculate_totP(this.value)"   value="0" name="road_waysP"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>

                                     <div class="form-group"><label class="col-sm-3 control-label">Other Reservation %</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="other_resP"  value="0" onBlur="calculate_totP(this.value)" name="other_resP"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-sm-3 control-label">Open Area %</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="open_spaceP"  value="0"  onBlur="calculate_totP(this.value)"name="open_spaceP"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div> -->

                  <div class="form-group"><label class="col-sm-3 control-label">Number Of Units</label>
                  <div class="col-sm-3">
                    <input type="number" step="1" name="units" id="units" class="form-control" required>
                    </div>
                  </div>


							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
                <? if($details->owenership_type!="client_property"){?>
								<div class="form-title">
									<h4>Price Details :</h4>
								</div>
								<div class="form-body">

									<div class="form-group has-feedback" ><label class="control-label">Purchase Price</label>
                                   <input type="text" class="form-control" id="purchase_price"  value="<?=$details->perch_price?>" name="purchase_price" pattern="[0-9]+([\.][0-9]{0,2})?" placeholder="Land Estend In purch"   onBlur="calculate_arc(this.value)"  required>
										</div><div class="form-group has-feedback" >
										<label class="control-label">Owner Expected Price</label>
										<input type="text" class="form-control" name="expect_price"  value="<?=$details->perch_price?>" id="expect_price" pattern="[0-9]+([\.][0-9]{0,2})?"   placeholder="Land Extend In Arc" data-error="Invalid number" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>

									<div class="form-group has-feedback" ><label class="control-label">Market  Price</label>
                                   <input  type="text"  pattern="[0-9]+([\.][0-9]{0,2})?"   value="" class="form-control"  onBlur="calculate_tot(this.value)"  id="market_price" name="market_price"  placeholder="Perch Price"   required>
										  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										</div>
									</div>
									<br>
                <? }else{?>
                  <div class="form-title">
  									<h4>Price Details :</h4>
  								</div>
  								<div class="form-body">

  									<div class="form-group has-feedback" ><label class="control-label">Purchase Price</label>
                                     <input type="text" class="form-control" id="purchase_price"  value="0.00" name="purchase_price" pattern="[0-9]+([\.][0-9]{0,2})?" placeholder="Land Estend In purch"   onBlur="calculate_arc(this.value)"  readonly>
  										</div><div class="form-group has-feedback" >
  										<label class="control-label">Owner Expected Price</label>
  										<input type="text" class="form-control" name="expect_price"  value="0.00" id="expect_price" pattern="[0-9]+([\.][0-9]{0,2})?"   placeholder="Land Extend In Arc" data-error="Invalid number" readonly>
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
  										<span class="help-block with-errors" ></span>
  									</div>

  									<div class="form-group has-feedback" ><label class="control-label">Market  Price</label>
                                     <input  type="text"  pattern="[0-9]+([\.][0-9]{0,2})?"   value="0.00" class="form-control"  onBlur="calculate_tot(this.value)"  id="market_price" name="market_price"  placeholder="Perch Price"   readonly>
  										  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
  										</div>
  									</div>
  									<br>
                <?}?>


                                   <div class="form-title">
								<h4>Project Timeframe :</h4>
							</div>

							<div class="form-body">
                <div class="form-group"><label class="control-label">Development Type</label>
                  <select name="dev_type" id="dev_type" class="form-control">
                    <? if($development_type){

                      foreach ($development_type as $key => $value) {?>
                        <option value="<?=$value->dp_typeid?>" ><?=$value->dp_typename?></option>
                  <?    }
                    }?>

                  </select>
                </div>
                             <div class="form-inline">
                                      <div class="form-group has-feedback" >
                                <input type="number" class="form-control" id="devmonth" name="devmonth"  value=""  placeholder="Development Months"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>


										<input type="number" class="form-control" name="selmonth" id="selmonth"  value=""   placeholder="Selling Months" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										</div>
									</div><br>
                                    <div class="form-inline">


									<div class="form-group has-feedback" >
                                   <input type="text" class="form-control" id="date_proposal" name="date_proposal"  value=""  placeholder="Proposed Date"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>


										<input type="text" class="form-control" name="date_purchase" id="date_purchase"  value=""   placeholder="Purchase Date" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div></div><br>
                                         <div class="form-inline">
									<div class="form-group has-feedback" >
                                   <input type="text" class="form-control" id="date_prjcommence" name="date_prjcommence"  onblur="calculate_periods()"    value="" placeholder="Project Commence on"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

										 <input type="text" class="form-control" id="date_dvpcompletion" name="date_dvpcompletion"   value="" placeholder="Development Completion on"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>


									</div></div><br>
                                         <div class="form-inline">
									<div class="form-group has-feedback" >
                                    <input type="text" class="form-control" name="date_slscommence" id="date_slscommence"  value=""   placeholder="Sales Commence on" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>



										<input type="text" class="form-control" name="date_prjcompletion" id="date_prjcompletion"  value=""   placeholder="Project Completion" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div></div><br>


									<div class="form-group has-feedback" ><label>Project Period</label>
                                 	<input type="text" class="form-control" name="period" id="period" readonly="readonly"   placeholder="Attest Date" data-error="" ><span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>





								</div>
							</div>
						</div>
                        </div>

                        <div class="row">
                         <div class="widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h4 style="background-color:none;">Project Documents</h4>
							</div>
							<div class="form-body">
								     <div class="form-inline">
                                     <? foreach($doctypes as $docraw){?>
									    <div class="form-group has-feedback" ><label for="exampleInputName2"><?=$docraw->document_name?></label>
                                   <input type="file" class="form-control" id="document<?=$docraw->doctype_id?>" name="document<?=$docraw->doctype_id?>"   value="" placeholder="Project Commence on"   ><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										</div>
                                        <? }?>
                                      </div>
                                      <br />
                                      <div class="bottom">

											<div class="form-group  validation-grids"  style="float:right">
												<button type="submit" class="btn btn-primary disabled" onclick="check_this()" >Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
								</div>
                              </div>
                    		</div>
                        </div>
                        <br>
