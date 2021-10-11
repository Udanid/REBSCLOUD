
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
 function format_date(mydate)
 {

  var newdate=year+"-"+monthIndex+"-"+day;
 }
 </script>

 <? $this->load->view("includes/flashmessage");?>

                       <form data-toggle="validator"  method="post" action="<?=base_url()?>re/feasibility/edit_project" enctype="multipart/form-data">
                       <input type="hidden" name="product_code" id="product_code" value="<?=$product_code?>">
                        <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                        <div class="row">
						  <div class="  widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h4>Master Information :</h4>
							</div>





                            <div class="form-body">
								<div class="form-inline">
									<div class="form-group">

                                         <label class="control-label" for="inputSuccess1">Branch</label>
										   <select class="form-control" placeholder="Qick Search.."  <? if(! check_access('all_branch')){?> disabled <? }?>  id="branch_code" name="branch_code" >
                    <option value="">Search here..</option>
                    <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>" <? if($row->branch_code==$details->branch_code){?> selected<? }?>><?=$row->branch_name?></option>
                    <? }?>
					</select>



                                         <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;Project Officer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
										 <select name="officer_code" id="officer_code" class="form-control" placeholder="Introducer" required>
                                    <option value="">Project Officer</option>

                                     <? if($officerlist) {foreach ($officerlist as $raw){?>
                    <option value="<?=$raw->id?>" <? if($details->officer_code==$raw->id){?> selected="selected"<? }?> ><?=$raw->initial?>&nbsp; <?=$raw->surname?></option>
                    <? }}?>

                                    </select>
                                    <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;CR Officer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
										 <select name="officer_code2" id="officer_code2" class="form-control" placeholder="Introducer" required>
                                    <option value="">CR Officer</option>

                                     <? if($officerlist) {foreach ($officerlist as $raw){?>
                    <option value="<?=$raw->id?>" <? if($details->officer_code2==$raw->id){?> selected="selected"<? }?> ><?=$raw->initial?>&nbsp; <?=$raw->surname?></option>
                    <? }}?>

                                    </select></div>

                                  </div>



						</div>

                        </div>
                        <div class="clearfix"> </div></div>

                        <div class="row">


    					     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h4 style="background-color:none;">Owner and Location Details :</h4>
							</div>
							<div class="form-body">
                             <div class="form-group">
                                         <label class="control-label" for="inputSuccess1">Project Code</label>
										 <input type="number"  class="form-control" name="project_code"  id="project_code"value="<?=$details->project_code?>"  required>


									</div>
								 <div class="form-group">
                                         <label class="control-label" for="inputSuccess1">Project Name</label>
										 <input type="text"  class="form-control" name="project_name"  id="project_name"value="<?=$details->project_name?>"  required>


									</div>

									<div class="form-group has-feedback"><label class="control-label" for="inputSuccess1">Land Owner</label>
										<input type="text" class="form-control"name="owner_name"  readonly value="<?=$details->owner_name?>" id="owner_name"   placeholder="Land Owner Name" data-error=""  required>

									</div>




                                    </div>
                                   <div class="form-title">
								<h4>Land Details (Perch) :</h4>
							</div>
							<div class="form-body form-horizontal">

                                    <div class="form-group"><label class="col-sm-3 control-label">Land Extent</label>
										<div class="col-sm-3"><input type="text" class="form-control"   id="land_extend"  value="<?=$details->land_extend?>" name="land_extend" pattern="[0-9]+([\.][0-9]{0,2})?"      required></div>
                                        <label class="col-sm-3 control-label" >Road ways</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="road_ways" onBlur="calculate_tot(this.value)"   value="<?=$details->road_ways?>" name="road_ways"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>

                                     <div class="form-group"><label class="col-sm-3 control-label">Other Reservation</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="other_res"  value="<?=$details->other_res?>" onBlur="calculate_tot(this.value)" name="other_res"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-sm-3 control-label">Open Area</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="open_space"  value="<?=$details->open_space?>"  onBlur="calculate_tot(this.value)"name="open_space"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                                       <div class="form-group"><label class="col-sm-3 control-label">Unsalable Area</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="unselable_area"  value="<?=$details->unselable_area?>" onBlur="calculate_tot(this.value)" name="unselable_area"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-sm-3 control-label">Salable Area</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="selable_area"  value="<?=$details->selable_area?>"  name="selable_area"      data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>


							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
								<div class="form-title">
									<h4>Price Details :</h4>
								</div>
								<div class="form-body">

									<div class="form-group has-feedback" ><label class="control-label">Purchase Price (Per Perch)</label>
                                   <input type="text" class="form-control number-separator" id="purchase_price"  value="<?=$details->purchase_price?>" name="purchase_price" pattern="[0-9]+([\.][0-9]{0,2})?" placeholder="Land Estend In purch"   onBlur="calculate_arc(this.value)"  required>
										</div><div class="form-group has-feedback" >
										<label class="control-label">Owner Expected Price</label>
										<input type="text" class="form-control number-separator" name="expect_price"  value="<?=$details->expect_price?>" id="expect_price" pattern="[0-9]+([\.][0-9]{0,2})?"   placeholder="Land Extend In Arc" required>
                                        
									</div>

									<div class="form-group has-feedback" ><label class="control-label">Market  Price</label>
                                   <input  type="text"  pattern="[0-9]+([\.][0-9]{0,2})?"   value="<?=$details->market_price?>" class="form-control number-separator"  onBlur="calculate_tot(this.value)"  id="market_price" name="market_price"  placeholder="Perch Price"   required>
										  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										</div>
									</div>
									<br>

								<?php
$datetime1 = date_create($details->date_prjcommence);
$datetime2 = date_create($details->date_dvpcompletion);
$interval = date_diff($datetime1, $datetime2);
$dpmonths= $interval->format('%m')+1;
$datetime1 = date_create($details->date_dvpcompletion);
$datetime2 = date_create($details->date_prjcompletion);
$interval = date_diff($datetime1, $datetime2);
$salemonths= $details->period-$dpmonths;
?>

                                   <div class="form-title">
								<h4>Project Timeframe :</h4>
							</div>
							<div class="form-body form-horizontal">
                                    <div class="form-group" ><label class="col-sm-3 control-label">Development Months</label>
                                   <div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="devmonth" name="devmonth"  value="<?=$dpmonths?>"  placeholder="Development Months"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>

									<label class="col-sm-3 control-label">Selling Months</label>
									<div class="col-sm-3 has-feedback">	<input type="text" class="form-control" name="selmonth" id="selmonth"  value="<?=$salemonths?>"   placeholder="Selling Months" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										</div>
									</div>

									<div class="form-group" ><label class="col-sm-3 control-label">Date Proposed</label>
                                   <div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="date_proposal" name="date_proposal"  value="<?=$details->date_proposal?>"  placeholder="Proposed Date"    required><span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>

									<label class="col-sm-3 control-label">Purchase Date</label>
									<div class="col-sm-3 has-feedback">	<input type="text" class="form-control" name="date_purchase" id="date_purchase"  value="<?=$details->date_purchase?>"   placeholder="Purchase Date" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group" ><label class="col-sm-3 control-label">Project Commence on</label>
                                  <div class="col-sm-3 has-feedback"> <input type="text" class="form-control" id="date_prjcommence" name="date_prjcommence"   value="<?=$details->date_prjcommence?>" placeholder="Project Commence on" onblur="calculate_periods()"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  </div><label class="col-sm-3 control-label">Development Completion on</label>
                                  <div class="col-sm-3 has-feedback">
										 <input type="text" class="form-control" id="date_dvpcompletion" name="date_dvpcompletion"   value="<?=$details->date_dvpcompletion?>" placeholder="Development Completion on"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

										 </div></div>


									<div class="form-group" ><label class="col-sm-3 control-label">Sales Commence on</label>
                                  <div class="col-sm-3 has-feedback">
                                    <input type="text" class="form-control" name="date_slscommence" id="date_slscommence"  value="<?=$details->date_slscommence?>"   placeholder="Sales Commence on" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>


										<label class="col-sm-3 control-label">Project Completion</label>
                                  <div class="col-sm-3 has-feedback">
										<input type="text" class="form-control" name="date_prjcompletion" id="date_prjcompletion"  value="<?=$details->date_prjcompletion?>"   placeholder="Project Completion" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>

									</div>


									<div class="form-group has-feedback" ><label class="col-sm-3 control-label">Project Period</label>
                                 <div class="col-sm-3 has-feedback">	<input type="text" class="form-control" name="period" id="period" readonly="readonly"   placeholder="Attest Date" data-error="" value="<?=$details->period?>" ><span class="glyphicon form-control-feedback" aria-hidden="true"></span></div></div>




								<div class="bottom ">

											<div class="form-group">

 <? if($details->status=='PENDING'){?>
 												<button type="submit" class="btn btn-primary disabled"  onclick="check_this()" >Update</button>
                                                <?  }if($fsbstatus){?>
                                            <a href="<?=base_url()?>re/feasibility/generete_evereport/<?=$this->encryption->encode($prj_id)?>" class="btn btn-success">Generate Evaluation Reports</a>

                                            <? }?>
											</div>

											<div class="clearfix"> </div>
										</div>
								</div>
							</div>
						</div>
                        </div>
                        <div class="clearfix"> </div>
                        <br>

                        <br> <br> <br><br> <br> <br>

					</form>
