
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

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
   $("#bank2").focus(function() {
	$("#bank2").chosen({
     allow_single_deselect : true
    });
   });
    $("#branch2").focus(function() {
	$("#branch2").chosen({
     allow_single_deselect : true
    });
	});
	$("#town").focus(function() {
	$("#town").chosen({
     allow_single_deselect : true
    });
  });
  var ol_max_subjects = 10; //maximum input boxes allowed
  var ol_wrapper = $(".ol_input_fields_wrap"); //Fields wrapper
  var ol_add_button = $(".add_ol_subject_button"); //Add button ID

  var olCount = 1; //initlal text box count
  $(ol_add_button).click(function(e){ //on add input button click
    e.preventDefault();
    if(olCount < ol_max_subjects){
      $(ol_wrapper).append('  <div class="clearfix"> </div><br><div class="emp_rows col-xs-12"><hr>\
       <div class="form-group">\
		      <input type="text" class="form-control" name="ordinary_level['+olCount+'][name]" placeholder="Owner name" />\
      </div>\
      <div class="form-group">\
      <input type="text" class="form-control" name="ordinary_level['+olCount+'][address]" placeholder="Address" />\
      </div>\
	   <div class="col-xs-6">\
        <input type="text" class="form-control" name="ordinary_level['+olCount+'][nic]" placeholder="NIC" />\
      </div>\
	    <div class="col-xs-4">\
      <a href="#" class="remove_field btn btn-danger">Remove</a>\
      </div>\
	   </div>'); //add input box
      olCount++; //text box increment
    }
  });

  $(ol_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault();
    $(this).parent('div').parent('div').remove(); olCount--;
  })
	  var al_max_subjects = 5; //maximum input boxes allowed
  var al_wrapper = $(".al_input_fields_wrap"); //Fields wrapper
  var al_add_button = $(".add_al_subject_button"); //Add button ID
  var alCount = 1; //initlal text box count

  $(al_add_button).click(function(e){ //on add input button click
    e.preventDefault();
    if(alCount < al_max_subjects){
      alCount++; //text box increment
      $(al_wrapper).append('<div class="emp_rows col-xs-12"><hr>\
      <div class="col-xs-6">\
      <input type="text" class="form-control" name="advance_level['+alCount+'][plan_no]" placeholder="Plan Number" />\
      </div>\
      <div class="col-xs-6">\
      <input type="text" class="form-control" name="advance_level['+alCount+'][deed_no]" placeholder="Deed Number" />\
      </div>\
	  <div class="clearfix"> </div><br>\
	   <div class="col-xs-6">\
      <input type="text" class="form-control" name="advance_level['+alCount+'][drawn_by]" placeholder="Drawn By" />\
      </div>\
      <div class="col-xs-6">\
      <input type="text" class="form-control" name="advance_level['+alCount+'][drawn_date]" placeholder="Drawn Date" />\
      </div>\
	  <div class="clearfix"> </div><br>\
	   <div class="col-xs-6">\
      <input type="text" class="form-control" name="advance_level['+alCount+'][attest_by]" placeholder="Attest By" />\
      </div>\
      <div class="col-xs-6">\
      <input type="text" class="form-control" name="advance_level['+alCount+'][attest_date]" placeholder="Attest Date" />\
      </div>\
	   <div class="clearfix"> </div><br>\
	   <div class="col-xs-6">\
      <input type="file" class="form-control" name="plan_copy'+alCount+'" placeholder="Attest By" />\
      </div>\
      <div class="col-xs-6">\
      <input type="file" class="form-control" name="deed_copy'+alCount+'" placeholder="Attest Date" />\
      </div>\
	    <div class="clearfix"> </div><br>\
      <div class="col-xs-4">\
      <a href="#" class="remove_field btn btn-danger">Remove</a>\
      </div>\
      </div>'); //add input box
    }
  });

  $(al_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault();
    $(this).parent('div').parent('div').remove(); alCount--;
  })

});
function check_is_exsit(src)
{
	var number=src.value.length;
	val=$('input[name=idtype]:checked').val();
	//alert(val);
	document.getElementById("id_type").value=val;
	if(val=='NIC')
	{

	 var pattern = /\d\d\d\d\d\d\d\d\d\V|X|Z|v|x|z/;
                var id=src.value;
				 var code="";

                if ((id.length == 0))
				{
                code='NIC Cannot be Blank';
				 //obj.focus();
				}
                else if ((id.match(pattern) == null) || (id.length != 10))
				{
       				//alert(' Please enter a valid NIC.\n');
					code='Invalid NIC';

				}

      			// document.getElementById("myerrorcode").innerHTML=code;

                if (code!="") {
				//	 alert(data);

					document.getElementById("id_number").focus();
					document.getElementById("id_number").setAttribute("placeholder", data);
					document.getElementById("id_number").setAttribute("error", data);
					src.value="";
					document.getElementById("id_type").value=val;

					document.getElementById("short_description").focus();
                }


	}
}
function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_landms', id: id,fieldname:'land_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>hm/land/edit/"+id );
				}
            }
        });
}
function call_comment(id)
{
	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>hm/land/comments/"+id );
}
function close_edit(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'hm_landms', id: id,fieldname:'land_code' },
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
var deleteid="";
function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_landms', id: id,fieldname:'land_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}

function call_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_landms', id: id,fieldname:'land_code' },
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
function view_confirm(id){
	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>hm/land/view/"+id );
}
function loadbranchlist(itemcode,caller)
{
var code=itemcode.split("-")[0];
//alert("<?=base_url().$searchpath?>/"+code)
if(code!=''){
	//alert(code)
	//$('#popupform').delay(1).fadeIn(600);
	$( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}

}

  $( function() {
    $( "#intro_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#drawn_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	  $( "#attest_date" ).datepicker({dateFormat: 'yy-mm-dd'});
  } );


function  calculate_arc(val)
{
	if(val>0)
	{
		var arc=val/160;
		document.getElementById('land_arc').value=arc.toFixed(2);
	}
	else
	document.getElementById('land_arc').value=0.00;
}
function  calculate_tot(val)
{
	if(val>0)
	{
		var arc=document.getElementById('extendperch').value*val;
		document.getElementById('total_price').value=arc.toFixed(2);
	}
	else
	document.getElementById('total_price').value=''	;
}
function calculate_totpurch()
{//arc,rds,pcs,extendperch\
var extend=0;
var totarc=0;
	var arc=parseFloat(document.getElementById('arc').value);
	 var rds=parseFloat(document.getElementById('rds').value);
	 var pcs=parseFloat(document.getElementById('pcs').value);
	 extend=parseFloat(arc*160)+parseFloat(rds*40)+parseFloat(pcs);
	 totarc=extend/160;
	 document.getElementById('extendperch').value=extend;
	  document.getElementById('land_arc').value=totarc.toFixed(2);

}

function loadlandadatalist(type)
{
	if(type=="client_property")
	{
		$( "#land_intro" ).hide();
		$( "#land_data" ).hide();
		$("#plan_no").prop('required',false);
		$("#deed_no").prop('required',false);
		$("#drawn_by").prop('required',false);
		$("#drawn_date").prop('required',false);
		$("#attest_by").prop('required',false);
		$("#attest_date").prop('required',false);
		$("#plan_copy").prop('required',false);
		$("#deed_copy").prop('required',false);

	}else{
		$( "#land_intro" ).show();
		$( "#land_data" ).show();
		$("#plan_no").prop('required',true);
		$("#deed_no").prop('required',true);
		$("#drawn_by").prop('required',true);
		$("#drawn_date").prop('required',true);
		$("#attest_by").prop('required',true);
		$("#attest_date").prop('required',true);
		$("#plan_copy").prop('required',true);
		$("#deed_copy").prop('required',true);

	}
}
</script>
<script>
  $( function() {
    var availableTags = [
	  <?
	  foreach($landnames as $data){
		  echo '"'.$data->property_name.'",';
	  }
	  ?>
    ];
    $( "#property_name" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Land Details</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation"    <? if($tab==''){?> class="active" <? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add New land</a></li>

          <li role="presentation"  <? if($tab=='list'){?> class="active" <? }?>>
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Land List</a></li>
             </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">

               <div role="tabpanel" class="tab-pane fade <? if($tab=='list'){?> active in <? }?> " id="home" aria-labelledby="home-tab" >
               <br>
              <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>

                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                        <table class="table"> <thead> <tr> <th>Land Code</th> <th>Owner Name</th>  <th>Property Name</th><th>District </th> <th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->land_code?></th> <td><?=$row->owner_name ?></td> <td> <?=$row->property_name ?></td>
                        <td><?=$row->district?></td>
                        <td><?=$row->status ?></td>
                        <td align="right"><div id="checherflag">
													<a  href="javascript:view_confirm('<?=$row->land_code?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>

                           <a  href="javascript:call_comment('<?=$row->land_code?>')"><i class="fa fa-comments-o nav_icon icon_green"></i></a>
                        <? if($row->status=='PENDING' ){?>

                        <a  href="javascript:check_activeflag('<?=$row->land_code?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>

                             <a  href="javascript:call_confirm('<?=$row->land_code?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>

                             <a  href="javascript:call_delete('<?=$row->land_code?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr>

                                <? }} ?>
                          </tbody></table>
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade <? if($tab==''){?> active in <? }?>" id="profile" aria-labelledby="profile-tab">
                    <p>	  <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>

                       <form data-toggle="validator" method="post" action="<?=base_url()?>hm/land/add" enctype="multipart/form-data">
                       <input type="hidden" name="product_code" id="product_code" value="<?=$product_code?>">
                       <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
                        <div class="row">
						     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h4>Basic Information :</h4>
							</div>
							<div class="form-body">
								<div class="form-inline">
									<div class="form-group">
										<label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;Land Ownership&nbsp;&nbsp;&nbsp;&nbsp;</label>

									<select name="property_ownership" id="property_ownership" class="form-control"  onChange="loadlandadatalist(this.value)" required>
									<option value="Own_property">Own Property</option>
									<option value="client_property">Client Property</option>
								</select></div></div></br>
								<div class="form-inline" id="land_intro">
									<div class="form-group">
                                    <select name="intro_code" id="intro_code" class="form-control" placeholder="Introducer" required>
                                    <option value="">Land Introducer</option>
                                     <? foreach ($introduceerlist as $raw){?>
                    <option value="<?=$raw->intro_code?>" ><?=$raw->first_name?> <?=$raw->last_name?></option>
                    <? }?>

                                    </select>
										</div>&nbsp;<div class="form-group">
										<input type="text" class="form-control" name="intro_date" id="intro_date" placeholder="Introduced Date" required>
									</div></div> <div class="clearfix"> </div><br>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control"name="property_name" id="property_name"   placeholder="Property Name as per Deed" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    <div class="form-group has-feedback">
										<textarea class="form-control" id="remarks" name="remarks"  placeholder="Land Remarks" ></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    </div>
                                  <div class="form-title">
								<h4>Land Owner Details:
                                <span  style="float:right">
                    <button class="add_ol_subject_button btn btn-success" style="margin-top:-10px;">(+) Add </button></span>

                                </h4>
							</div>  	<div class="form-body">

                     		<div class="form-group ol_input_fields_wrap">


               					 <div class="emp_rows col-xs-12">
               							 <div class="form-group">
										<input type="text" class="form-control"name="owner_name" id="owner_name"   placeholder="Land Owner Name" data-error=""  required>
													</div>
                 						 <div class="form-group">
										<input type="text" class="form-control"name="owner_address" id="owner_address"   placeholder="Land Owner Adderss" data-error=""  >
													</div>
                                                    <div class="form-group">
                                                    <div class="col-md-6">
										<input type="text" class="form-control"name="owner_nic" id="owner_nic"   placeholder="Land Owner NIC" data-error=""  >
													 </div>
                                                    </div>
                					</div>

              				</div>


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
										<input type="text" class="form-control" id="address1" name="address1"  placeholder="Address Line 1" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<input type="text" class="form-control" id="address2" name="address2"  placeholder="Address Line 2" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" name="address3" id="address3" placeholder="City" >

										<span class="help-block with-errors" ></span>
									</div>

							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
								<div class="form-title">
									<h4>Land Details :</h4>
								</div>
								<div class="form-body">
                                	<div class="form-group   has-feedback"  >
                                  <table ><tr><td>Acs</td><td>Rds</td><td>Pcs</td></tr>
                                <tr><td>	<input type="number" step="0.01"  name="arc" id="arc" value="0"  onChange="calculate_totpurch()"  placeholder="Arc" data-error="Invalid number" required></td>
                                <td>	<input type="number" step="0.01" name="rds" id="rds"  value="0"   onChange="calculate_totpurch()"placeholder="Arc" data-error="Invalid number" required></td>
                                <td>	<input type="number" step="0.01" name="pcs" id="pcs"   value="0" onChange="calculate_totpurch()" placeholder="Arc" data-error="Invalid number" required></td>
                                </tr></table></div>
								<div class="form-inline">
									<div class="form-group   has-feedback"  >
                                   <input  type="number"  style="max-width:150px" step="0.01" class="form-control" id="extendperch" name="extendperch" pattern="[0-9]+([\.][0-9]{0,2})?" placeholder="Land Extent In Perch"   onBlur="calculate_arc(this.value)"  required>
                                   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>

										<input type="text" class="form-control" name="land_arc" id="land_arc" pattern="[0-9]+([\.][0-9]{0,10})?"   placeholder="Land Extent In Arc" data-error="Invalid number" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div></div>
                                    <div class="clearfix"> </div><div class="clearfix"> </div><br>
                                    	<div class="form-inline" id="land_data">
									<div class="form-group has-feedback" >
                                   <input  type="text"  pattern="[0-9]+([\.][0-9]{0,2})?"  class="form-control"  onBlur="calculate_tot(this.value)"  id="perch_price" name="perch_price"  placeholder="Perch Price"   required>
										  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>

										<input type="text" class="form-control" pattern="[0-9]+([\.][0-9]{0,2})?"  name="total_price" id="total_price"   placeholder="Total Price" data-error="" required>

										  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									</div></div>
									<br>

									<div class="form-group has-feedback">
										<textarea class="form-control" id="envirronment_data" name="envirronment_data"  placeholder="Environment Data" ></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    </div>
                                   <div class="form-title">
								<h4>Document Details :    <span  style="float:right">
                    <button class="add_al_subject_button btn btn-success" style="margin-top:-10px;">(+) Add </button></span></h4>
							</div>
							<div class="form-body">

                                    <div class="form-inline">
									<div class="form-group has-feedback" >
                                   <input type="text" class="form-control" id="plan_no" name="plan_no"  placeholder="Plan Number"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>


										<input type="text" class="form-control" name="deed_no" id="deed_no"   placeholder="Deed Number" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div></div><br>
                                         <div class="form-inline">
									<div class="form-group has-feedback" >
                                   <input type="text" class="form-control" id="drawn_by" name="drawn_by"  placeholder="Drawn By"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>


										<input type="text" class="form-control" name="drawn_date" id="drawn_date"   placeholder="Drawn Date" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div></div><br>
                                       <div class="form-inline">
									<div class="form-group has-feedback" >
                                   <input type="text" class="form-control" id="attest_by" name="attest_by"  placeholder="Attest By"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>


										<input type="text" class="form-control" name="attest_date" id="attest_date"   placeholder="Attest Date" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div></div><br>

									<div class="form-group has-feedback" ><label>Plan Copy</label>
                                   <input type="file" class="form-control" id="plan_copy" name="plan_copy"  placeholder="Attest By"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>
										<div class="form-group has-feedback" >
										<label>Deed Copy</label>
										<input type="file" class="form-control" name="deed_copy" id="deed_copy"   placeholder="Attest Date" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div>

                                <div class="form-group al_input_fields_wrap"></div>

												<div class="clearfix"> </div><br>
								<div class="bottom ">

											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled">Sumbit</button>
											</div>
											<div class="clearfix"> </div>
										</div>
								</div>
							</div>





						</div>



            </div>

                        <div class="clearfix"> </div>
                        <br>





					</form></p>
                </div>

            </div>
         </div>
      </div>



         <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
									</div>
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>

<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>hm/land/delete/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>hm/land/confirm/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            </script>



        <div class="row calender widget-shadow"  style="display:none">
            <h4 class="title">Calender</h4>
            <div class="cal1">

            </div>
        </div>



        <div class="clearfix"> </div>
    </div>
</div>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>
