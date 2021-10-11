
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<!--For webcam capture-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<style type="text/css">
    #results { padding:10px; border:1px solid #CCC; background:#fff; }
</style>
<!--//for webcam capture-->
<script type="text/javascript">
$( function() {
    $( "#cus_dob_search" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
jQuery(document).ready(function() {
	
	$('#create_excel').click(function(){ 
	  		var date = '';
           $(".table2excel").table2excel({
					exclude: ".noExl",
					name: "customer  Report " +date,
					filename: "customer_Reprot.xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
           
      });  
	
	
	document.getElementById('confirm-but').disabled = true;
	//validate all fields
  	$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
	$("#cus_id_search").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Search"
    });
	$("#prj_id_search").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Search"
    });

	//set validation options
    $("#customerform").validate({
        rules: {
            title: {
						required: true
					 },
			id_number: {
						required: false
					 },
			idtype: {
						required: false
					 },
			first_name: {
						required: false
					 },
			last_name: {
						required: false
					 },
			full_name: {
						required: false
					 },

			occupation: {
						required: false
					 },
			raddress_duration: {
						required: false
					 },
			raddress1: {
						required: false
					 },
			raddress2: {
						required: false
					 },
			occupation: {
						required: false
					 },
			employer: {
						required: false
					 },
			raddress3: {
						required: false
					 },
			address1: {
						required: false
					 },
			address2: {
						required: false
					 },
			address3: {
						required: false
					 },
			mobile: {
						required: false
					 },
			business_name: {
						required: false
					 }

        },
        messages: {
            title: "Required",
			gender: "Required",
			civil_status: "Required",
			id_number:""

        }
    });

	$("#seach").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width:'25%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Search"
    });
	$("#otheraddress4").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select Country"
    });
	

});

function activatechosen(){
	setTimeout(function(){
		$("#title").chosen({
		 allow_single_deselect : true
		});
		$("#gender").chosen({
		 allow_single_deselect : true
		});
		$("#bank1").chosen({
		 allow_single_deselect : true
		});
		$("#branch1").chosen({
		 allow_single_deselect : true
		});
		$("#bank2").chosen({
		 allow_single_deselect : true
		});
		$("#branch2").chosen({
		 allow_single_deselect : true
		});

		$("#citizenship").chosen({
		 allow_single_deselect : true
		});
		$("#raddress_ownership").chosen({
		 allow_single_deselect : true
		});
		$("#civil_status").chosen({
		 allow_single_deselect : true
		});
		$( "#dob" ).datepicker({
				dateFormat : 'yy-mm-dd',
				changeMonth : true,
				changeYear : true,
				yearRange: '-100y:c+nn',
				maxDate: '-1d'
			});
		$( "#id_doi" ).datepicker({
				dateFormat : 'yy-mm-dd',
				changeMonth : true,
				changeYear : true,
				yearRange: '-100y:c+nn',
				maxDate: '-1d'
			});
  	}, 800);

}
function check_is_exsit()
{
	var src = document.getElementById("id_number");
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
				else if (id.length == 10)
				{
       				//alert(' Please enter a valid NIC.\n');
					 if (id.match(pattern) == null)
						code='Invalid NIC';


				}
                else if (id.length == 12)
				{
       				//alert(' Please enter a valid NIC.\n');
					code="";

				}
				else
				{
					code='Invalid NIC';
				}



      			// document.getElementById("myerrorcode").innerHTML=code;

                if (code!="") {
				//	 alert(data);

					document.getElementById("id_number").focus();
					document.getElementById("id_number").setAttribute("placeholder", code);
					document.getElementById("id_number").setAttribute("error", code);
					src.value="";
					document.getElementById("id_type").value=val;

					document.getElementById("short_description").focus();
                }


	}
	var number = src.value;
	$.ajax({
		cache: false,
		type: 'POST',
		url: '<?php echo base_url().'cm/customer/check_id_number';?>',
		data: {id_number: number, id_type:val },
		success: function(data) {
			if (data) {
				document.getElementById("id_number").focus();
				document.getElementById("id_number").setAttribute("placeholder", data);
				document.getElementById("id_number").setAttribute("error", data);
				src.value="";
				document.getElementById("id_type").value=val;

				document.getElementById("short_description").focus();
			}
			else
			{
				//alert('Unable to check customer ID. Please search on top search field');
			}
		}
	});
}
function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
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
					$( "#popupform" ).load( "<?=base_url()?>cm/customer/edit/"+id );
				}
            }
        });
}

function viewCustomer(cus_code){

	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>cm/customer/view/"+cus_code );

}

function close_view(){
	$('#popupform').delay(1).fadeOut(800);
}

function close_edit(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
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
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
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
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
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
function loadbranchlist(itemcode,caller)
{
var code=itemcode.split("-")[0];
//alert("<?=base_url().$searchpath?>/"+code)
if(code!=''){
	//alert(code)
	//$('#popupform').delay(1).fadeIn(600);
	$( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}

}
function load_printscrean2()
{

			window.open( "<?=base_url()?>cm/customer/excel_cusdata/");

}

function copyAbove(){
	var checkBox = document.getElementById("same");

	// If the checkbox is checked, copy from residential address
	if (checkBox.checked == true){
	  	address1 = document.getElementById("raddress1").value;
		address2 = document.getElementById("raddress2").value;
		address3 = document.getElementById("raddress3").value;
		rpostal_code = document.getElementById("rpostal_code").value;
		document.getElementById("address1").value = address1;
		document.getElementById("address2").value = address2;
		document.getElementById("address3").value = address3;
		document.getElementById("postal_code").value = rpostal_code;
	} else {
	  	document.getElementById("address1").value = '';
		document.getElementById("address2").value = '';
		document.getElementById("address3").value = '';
		document.getElementById("postal_code").value = '';
	}
}


function showSpouse(){
	var spouse = document.getElementById("spouse");
	var civilstatus = document.getElementById("civil_status").value;

	if (civilstatus=='single'){
		//spouse.style.display = "none";
		$('#spouse').fadeOut('slow');
		document.getElementById("spouse_name").value = '';
		document.getElementById("spouse_employer").value = '';
		document.getElementById("spouse_designation").value = '';
		document.getElementById("spouse_income").value = '';
		document.getElementById("dependent").value = '';
	}else if(civilstatus=='married'){
		//spouse.style.display = "block";
		$('#spouse').fadeIn('slow');
	}
}

function changeCustomer(obj){
	if(obj.value=='individual'){
		$('#title').prop('disabled', false).trigger("chosen:updated");
		$('#gender').prop('disabled', false).trigger("chosen:updated");
		$('#civil_status').prop('disabled', false).trigger("chosen:updated");
		business.style.display = "none";
		$('#employment').fadeIn('slow');
		$('#personal').fadeIn('slow');
		//$('#documentback').fadeIn('slow');
		$('#residential').fadeIn('slow');
		$('#sameas').fadeIn('slow');
		document.getElementById("brn").disabled = true;
		document.getElementById("nic").disabled = false;
		document.getElementById("passport").disabled = false;
		document.getElementById("workphone").disabled = false;
		document.getElementById("brn").checked = false;

	}else if(obj.value=='business'){
		$('#title').prop('disabled', true).trigger("chosen:updated");
		$('#gender').prop('disabled', true).trigger("chosen:updated");
		$('#civil_status').prop('disabled', true).trigger("chosen:updated");

		$('#employment').fadeOut('slow');
		$('#business').fadeIn('slow');
		personal.style.display = "none";
		//$('#documentback').fadeOut('slow');
		$('#residential').fadeOut('slow');
		$('#sameas').fadeOut('slow');
		document.getElementById("nic").disabled = true;
		document.getElementById("passport").disabled = true;
		document.getElementById("brn").disabled = false;
		document.getElementById("brn").checked = true;
		document.getElementById("workphone").disabled = true;

	}
}
function getCustomerbyID(cus_code){
	$.ajax({
		cache: false,
		type: 'POST',
		url: '<?php echo base_url().'cm/customer/getCustomerbyID/';?>',
		data: {cus_code:cus_code },
		success: function(data) {
			if (data) {
				$('#custtable').html('');
				$('#custtable').hide().html(data).fadeIn('slow');
			}
			else
			{
				alert('Unable to find loan information!');
			}
		}
	});
}
function addTopblock(){
	//$('#topblock').fadeIn('slow');
	$("#custsearch").css("visibility","visible").animate({opacity: 1}, 300);
	Webcam.reset();
}
function removeTopblock(){
	//$('#topblock').fadeOut('slow');
	$("#custsearch").css("visibility","hidden").animate({opacity: 0}, 300);
	Webcam.set({
        width: 300,
        height: 300,
		dest_width: 480,
    	dest_height: 480,
		//dest_width: 600,
    	//dest_height: 600,
        image_format: 'jpeg',
        jpeg_quality: 100
    });

    Webcam.attach( '#my_camera' );
}
</script>
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Customer Data</h3>
      <!--search-box-->
      <div class="search-box-cust" id="custsearch">
          <form class="input">
          <select class="sb-search-input input__field--madoka" placeholder="Qick Search.."  id="seach" name="seach"   onChange="getCustomerbyID(this.value)">
          <option value=""></option>

          <?=$searchlist?>
          </select>

           <button type="submit"  class="search-box_submit">SEARCH</button>

          </form>

      </div><!--//end-search-box-->
      <br>

      <div class="widget-shadow">

          <ul id="myTabs" class="nav nav-tabs" role="tablist">

           <li role="presentation" class="active">
          	<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" onClick="addTopblock();" aria-expanded="false">Customer List</a></li>
           <? if(check_access('add_customer')){?> <li role="presentation"><a href="#profile" onClick="activatechosen();removeTopblock();" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add New customer</a></li>
          <? }?>
        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">

               <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
               <br>
              <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>




              <div class="form-title">
								<h4>Search Customers<span style="float:right"> <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span>
								</h4></div>
                                <br>
                                	  <form data-toggle="validator" method="post" action="<?=base_url()?>cm/customer/search_report"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">
            
            
            <div class="form-body">
                <div class="form-inline">
                
                    <div class="form-group col-sm-3"> 
                        <select class="form-control" placeholder="Qick Search.."    id="prj_id_search" name="prj_id_search" >
                    <option value="">All Projects </option>
                    <?    foreach($re_prjlist as $row){?>
                    <option value="re,<?=$row->prj_id?>"><?=$row->project_name?> </option>
                    <? }?>
              <?    foreach($hm_prjlist as $row){?>
                    <option value="hm,<?=$row->prj_id?>"><?=$row->project_name?> </option>
                    <? }?>
					</select>  </div>
                   
                      <div class="form-group col-sm-3" >
                       <select class="form-control" placeholder="Qick Search.."    id="cus_id_search" name="cus_id_search" >
                    <option value="">Customer </option>
                    <?    foreach($searchdata as $row){?>
                    <option value="<?=$row->cus_code?>"><?=strtoupper($row->first_name)?>  <?=strtoupper($row->last_name)?>  <?=strtoupper($row->id_number)?> <?=strtoupper($row->mobile)?></option>
                    <? }?>
             
					</select>  </div>
                     <div class="form-group col-sm-3" id="blocklist">
                      <input type="text" name="cus_dob_search" id="cus_dob_search" placeholder="DOB"  class="form-control" >
                    </div>
                    <div class="form-group col-sm-3">
                        <button type="submit"   id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>
            
        </div>
           
  
    </div>
</form> 
                                
                                
                   <div class=" widget-shadow bs-example" id="custtable" data-example-id="contextual-table" >

                        <table class="table  table2excel"> <thead> <tr> <th>Customer Code</th><th>Customer Name</th> <th>Reservation Code</th><th>Project</th> 
                        <th>Lot Number </th>
                        <th>Discounted Price</th>
                        <th>Paid Amount </th>
                         <th>Paid % </th>
                         <th>Address1 </th>
                         <th>Address2 </th>
                         <th>Address3 </th>
                         <th>Mobile </th>
                          <th>Phone Number </th>
                         <th>E mail</th> <th>Date of birth</th><th></th></tr> </thead>
                      <? if($datalist_re){$c=0;
                          foreach($datalist_re as $row){
							  $loanpayment=get_loan_paid_cap_amount_customerseach('re',$row->res_code);
							  $fullpayment=$row->down_payment+$loanpayment;
							  $rate=($fullpayment/$row->discounted_price)*100
							  ?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->cus_code?></th> 
                        <td><?=strtoupper($row->first_name) ?> <?=strtoupper($row->last_name) ?></td>
                         <td><?=$row->res_code?></td>
                        <td><?=$row->project_name?></td>
                        <td><?=$row->lot_number ?></td>
                         <td><?=number_format($row->discounted_price,2) ?></td>
                          <td><?=number_format($fullpayment,2) ?></td>
                          <td><?=number_format($rate,2)?></td>
                            <td><?=$row->address1 ?></td>
                              <td><?=$row->address2 ?></td>
                                <td><?=$row->address3 ?></td>
                                  <td><?=$row->mobile ?></td>
                                   <td><?=$row->landphone ?></td>
                                   <td><?=$row->email ?></td>
                                    <td><?=$row->dob ?></td>
                        <td align="right"></td>
                         </tr>

                                <? }} ?>
                                  <? if($datalist_hm){$c=0;
                          foreach($datalist_hm as $row){
							  $loanpayment=get_loan_paid_cap_amount_customerseach('hm',$row->res_code);
							  $fullpayment=$row->down_payment+$loanpayment;
							  $rate=($fullpayment/$row->discounted_price)*100
							
							  ?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->cus_code?></th> 
                        <td><?=strtoupper($row->first_name) ?> <?=strtoupper($row->last_name) ?></td>
                         <td><?=$row->res_code?></td>
                        <td><?=$row->project_name?></td>
                        <td><?=$row->lot_number ?></td>
                         <td><?=number_format($row->discounted_price,2) ?></td>
                          <td><?=number_format($fullpayment,2) ?></td>
                          <td><?=number_format($rate,2)?></td>
                            <td><?=$row->address1 ?></td>
                              <td><?=$row->address2 ?></td>
                                <td><?=$row->address3 ?></td>
                                  <td><?=$row->mobile ?></td>
                                   <td><?=$row->landphone ?></td>
                                   <td><?=$row->email ?></td>
                                    <td><?=$row->dob ?></td>
                        <td align="right"></td>
                         </tr>

                                <? }} ?>
                          </tbody></table>
                     </div>
                </div>
               <? if(check_access('add_customer')){?>
                <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                    <p>	  <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>

                       <form data-toggle="validator" id="customerform" method="post" action="<?=base_url()?>cm/customer/add" enctype="multipart/form-data">
                        <div class="row">
						     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
                             <div class="form-body">
                             	<div class="radio">
                                    <label>
                                      <input type="radio" name="custtype" value="individual" onChange="changeCustomer(this);" checked="checked">
                                      Personal
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                      <input type="radio" name="custtype" value="business" onChange="changeCustomer(this);">
                                      Business
                                    </label>
                                </div>
                            </div>
                            <div class="form-body">
                                    <div class="form-group">

                                    <h5><strong>Identification Document Type</strong></h5>
										<div class="radio">
											<label>
											  <input type="radio" name="idtype" id="nic" value="NIC" onClick="check_is_exsit();" required>
											  NIC
											</label>
										</div>
										<div class="radio">
											<label>
											<input type="radio"  name="idtype" id="passport" value="Passport" onClick="check_is_exsit();" required>
											Passport
											</label>
										</div>
                                        <div class="radio">
											<label>
											<input type="radio"  name="idtype" id="brn" value="BRN" onClick="check_is_exsit();" disabled required>
											BRN
											</label>
										</div>
									</div>
                                    <div class="form-inline">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="id_number" id="id_number"  autocomplete="off"  placeholder="Document Number"   value="<?=$this->session->flashdata('cusnic')?>"	 data-error="Please Enter Valid NIC/Passport/BR Number" onChange="check_is_exsit();" required>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" id="myerrorcode"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="id_doi" id="id_doi" autocomplete="off"   placeholder="Date of Issue" >
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" id="myerrorcode"></span>
                                        </div>
                                    </div>
                                    <br>

									<div class="form-group">
                                    	<h5><strong>Upload NIC/BR/Passport Front Side <i style="color:#CC3300;">(required)</i></strong></h5>
                                        <span id="addfile" class="btn btn-success fileinput-button" style="width:25%;">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Add file</span>
                                            <!-- The file input field used as target for the file upload widget -->
                                            <input id="fileupload" type="file" name="files" required>
                                            <input type="hidden" name="id_copy_front" id="id_copy_front">
                                            <div id="upfiles" class="upfiles"></div>
                                        </span>

                                        <!-- The global progress bar -->
                                        <div id="progress" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <!-- The container for the uploaded files -->
                                        <div id="files" class="files" style="width:25%;"></div>
                                        <br>
                                        <span id="documentback">
                                            <h5><strong>Upload NIC/BR Back Side</strong></h5>
                                            <span id="addfile2" class="btn btn-success fileinput-button" style="width:25%;">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Add file</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input id="fileupload2" type="file" name="files">
                                                <input type="hidden" name="id_copy_back" id="id_copy_back">
                                                <div id="upfiles2" class="upfiles2"></div>
                                            </span>

                                            <!-- The global progress bar -->
                                            <div id="progress2" class="progress">
                                                <div class="progress-bar progress-bar-success"></div>
                                            </div>
                                            <!-- The container for the uploaded files -->
                                            <div id="files2" class="files" style="width:25%;"></div>
                                    	</span>

									 </div>
								</div>
                            <!--start Business block-->
                            <div id="business" style="display:none;">
                                <div class="form-title">
                                    <h4>Business Information :</h4>
                                </div>
                                <div class="form-body">
                                	<div class="form-group has-feedback">
                                          <input type="text" class="form-control" id="business_name" name="business_name" autocomplete="off"  placeholder="Business Name" data-error="" required>
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                          <input type="text" class="form-control" id="business_type" name="business_type" autocomplete="off"  placeholder="Type of Business" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="unicode_bname" id="unicode_bname" autocomplete="off"   placeholder="Business Name in Sinhala Unicode" data-error="">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" id="tin" name="tin"  autocomplete="off" placeholder="Tax Identification Number (TIN)" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" id="vat" name="vat"  autocomplete="off" placeholder="VAT Registration Number" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="number" class="form-control" id="monthly_bincome" name="monthly_bincome"  autocomplete="off" placeholder="Monthly Income" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" id="bincome_source" name="bincome_source"  autocomplete="off" placeholder="Principal Source of Income" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="number" class="form-control" id="monthly_bexpence" name="monthly_bexpence"  autocomplete="off" placeholder="Monthly Expenses" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="number" class="form-control" id="bsavings" name="bsavings"  autocomplete="off" placeholder="Savings" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <textarea class="form-control" id="moveable_bproperty" name="moveable_bproperty" placeholder="Movable Properties" data-error=""></textarea>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <textarea class="form-control" id="imovable_bproperty" name="imovable_bproperty" placeholder="Immovable Properties" data-error=""></textarea>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                </div>
                            </div>
                            <!--ends business block-->
                            <!--start personal block-->
                            <div id="personal">
                                <div class="form-title">
                                    <h4>Personal Information :</h4>
                                </div>
                                <div class="form-body">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="title" id="title" style="width:150%;" class="form-control chosen-select" placeholder="Title" required>
                                                <option value="">Title</option>
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Ms">Ms</option>
                                                <option value="Dr">Dr</option>
                                                <option value="Rev">Rev</option>

                                            </select>
                                            <input type="hidden" name="id_type" id="id_type" value="">
                                        </div>&nbsp;
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="first_name" id="first_name" autocomplete="off" placeholder="Name with Initials" data-error="Required" value="<?=$this->session->flashdata('customername')?>"	 required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="last_name" id="last_name" autocomplete="off" placeholder="Last Name" data-error="Required" value="<?=$this->session->flashdata('customername')?>"	 required>
                                        </div>

                                     </div>
                                         <div class="clearfix"> </div><br>

                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="full_name" id="full_name"  autocomplete="off"  placeholder="Full Name According to Identification Document" data-error=""  required>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                         <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="other_names" id="other_names" autocomplete="off"   placeholder="Other Names (Maiden Name)" data-error="">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="unicode_name" id="unicode_name" autocomplete="off"   placeholder="Name in Sinhala Unicode" data-error="">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                        <div class="form-group">
                                            <select name="citizenship" id="citizenship" class="form-control" placeholder="Citizenship">
                                            	<option value="">Are You a Citizen of Sri Lanka?</option>
                                                <option value="no">No</option>
                                                <option value="descent">Yes/by Descent</option>
                                                <option value="registration">Yes/by Registration</option>
                                            </select>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" ></span>
                                        </div>
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <select name="gender" id="gender" class="form-control chosen-select" placeholder="Gender">
                                                    <option value="">Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>&nbsp;
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="dob" id="dob" data-error="" autocomplete="off" placeholder="Date of Birth">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="pob" id="pob" autocomplete="off" placeholder="Place of Birth">
                                            </div>
                                            <div class="form-group">
                                                <select name="civil_status" id="civil_status" style="width:120%;" onChange="showSpouse();" class="form-control chosen-select" placeholder="Marital Status">
                                                    <option value="">Marital Status</option>
                                                    <option value="single">Single</option>
                                                    <option value="married">Married</option>
                                                </select>
                                            </div>

                                        </div>
                                        <!--starts spouse block-->
                                        <div id="spouse" style="display:none;">
                                            <br>
                                            <br>
                                            <h5><strong>Family Information</strong></h5>
                                            <br>
                                            <div class="form-group has-feedback">
                                                <input type="text" class="form-control" name="spouse_name" id="spouse_name" autocomplete="off" placeholder="Name of the Spouse" data-error="">
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <span class="help-block with-errors"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="spouse_employer" id="spouse_employer" autocomplete="off" placeholder="Employer of the Spouse">
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <span class="help-block with-errors"></span>
                                            </div>
                                            <div class="form-inline">


                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="spouse_designation" id="spouse_designation" autocomplete="off" placeholder="Designation">
                                                </div>
                                                <div class="form-group">
                                                    <input type="number" class="form-control" name="spouse_income" id="spouse_income" autocomplete="off" placeholder="Income">
                                                </div>
                                                <div class="form-group">
                                                    <input type="number" class="form-control" name="dependent" id="dependent" autocomplete="off" placeholder="No of Dependents">
                                                </div>


                                            </div>
                                        </div>
                                        <!--ends spouse block-->
                                        <div class="form-group">
                                        	<br><br>
                                            <div class="row" style="margin-top:5px;">
                                                <div class="col-sm-6">
                                                        <h5><strong>Customer Photo (Webcam)</strong></h5>
                                                        <div id="my_camera"></div>
                                                        <input type=button value="Take Snapshot" class="btn btn-info" onClick="take_snapshot()">
                                                        <input type="hidden" name="webcamimage" id="webcamimage" class="image-tag">
                                                </div>
                                                <div class="col-sm-6">
                                                		<div class="col-md-6">
                                                        	<br><br>
                                                            <span id="results_span"><a id="results_anchor" href="#"><div id="results">Captured image will appear here...</div></a></span>
                                                        </div>
                                                        <div class="col-md-12 text-center">
                                                            <br/>
                                                            <button class="btn btn-success" id="confirm-but">Confirm</button>
                                                        </div>
												</div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        	<br><br>
                                            <div class="row" style="margin-top:5px;">
                                                <div class="col-sm-6">
                                                        <h5><strong>Customer Photo (Manual Upload)</strong></h5>

                                                        <span id="addfile3" class="btn btn-success fileinput-button" style="width:25%;">
                                                            <i class="glyphicon glyphicon-plus"></i>
                                                            <span>Add</span>
                                                            <!-- The file input field used as target for the file upload widget -->
                                                            <input id="fileupload3" type="file" name="files">
                                                            <input type="hidden" name="customer_photo" id="customer_photo">
                                                            <div id="upfiles3" class="upfiles3"></div>
                                                        </span>

                                                        <!-- The global progress bar -->
                                                        <div id="progress3" class="progress">
                                                            <div class="progress-bar progress-bar-success"></div>
                                                        </div>
                                                        <!-- The container for the uploaded files -->
                                                        <div id="files3" class="files" style="width:25%;"></div>
                                                </div>
                                                <div class="col-sm-6">
                                                		<h5><strong>Signature</strong></h5>
                                                        <span id="addfile4" class="btn btn-success fileinput-button" style="width:25%;">
                                                            <i class="glyphicon glyphicon-plus"></i>
                                                            <span>Add</span>
                                                            <!-- The file input field used as target for the file upload widget -->
                                                            <input id="fileupload4" type="file" name="files">
                                                            <input type="hidden" name="signature" id="signature">
                                                            <div id="upfiles4" class="upfiles4"></div>
                                                        </span>

                                                        <!-- The global progress bar -->
                                                        <div id="progress4" class="progress">
                                                            <div class="progress-bar progress-bar-success"></div>
                                                        </div>
                                                        <!-- The container for the uploaded files -->
                                                        <div id="files4" class="files" style="width:25%;"></div>
												</div>
                                            </div>
                                        </div>
                                 </div>
                           </div>
                           <!--End of personal block-->

                            <!--starts employment block-->
                            <div id="employment">
                                <div class="form-title">
                                    <h4>Employment Information :</h4>
                                </div>
                                <div class="form-body">
                                      <div class="form-group has-feedback">
                                          <input type="text" class="form-control" id="occupation" name="occupation" autocomplete="off"  placeholder="Occupation/Profession" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback">
                                          <input type="text" class="form-control" id="employer" name="employer" autocomplete="off"  placeholder="Name of the Employer" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback">
                                            <textarea class="form-control" id="employer_address" name="employer_address" autocomplete="off" placeholder="Address of the Employer" ></textarea>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" ></span>
                                        </div>
                                      <div class="form-group has-feedback">
                                          <input type="text" class="form-control" id="employer_phone" name="employer_phone"  autocomplete="off" placeholder="Employer Phone" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback">
                                          <input type="number" class="form-control" id="monthly_income" name="monthly_income"  autocomplete="off" placeholder="Monthly Income" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback">
                                          <input type="text" class="form-control" id="income_source" name="income_source"  autocomplete="off" placeholder="Principal Source of Income" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback">
                                          <input type="number" class="form-control" id="monthly_expence" name="monthly_expence"  autocomplete="off" placeholder="Monthly Expenses" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback">
                                          <input type="number" class="form-control" id="savings" name="savings"  autocomplete="off" placeholder="Savings" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback">
                                          <textarea class="form-control" id="moveable_property" name="moveable_property" placeholder="Movable Properties" data-error=""></textarea>
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback">
                                          <textarea class="form-control" id="imovable_property" name="imovable_property" placeholder="Immovable Properties" data-error=""></textarea>
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>

                                </div>
                            </div>
                           <!--ends emploment block-->

						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
								<div class="form-title">
									<h4>Contact Information :</h4>
								</div>
								<div class="form-body">
                                	<!--starts residential block-->
									<div id="residential">
                                        <h4 class="h4red">Residential Address</h4><br>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="raddress1" name="raddress1"  autocomplete="off" placeholder="Address Line 1" data-error=""  required>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" ></span>
                                        </div>
                                         <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="raddress2" name="raddress2"  autocomplete="off" placeholder="Address Line 2" data-error="" required>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" ></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="raddress3" id="raddress3" autocomplete="off" placeholder="City" required>

                                            <span class="help-block with-errors" ></span>
                                        </div>
																				<div class="form-group has-feedback"><!-- ticket number 656 -->
                                            <input type="text" class="form-control" name="rpostal_code" id="rpostal_code" autocomplete="off" placeholder="Postal Code" data-error="">

                                            <span class="help-block with-errors" ></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="raddress_duration" name="raddress_duration"  autocomplete="off" placeholder="How Long Resident at Above Address?" data-error="">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" ></span>
                                        </div>
                                        <div class="form-group">
                                            <select name="raddress_ownership" id="raddress_ownership" class="form-control" placeholder="Ownership of the Residency">
                                            	<option value="">Ownership of the Residency</option>
                                                <option value="owner">Owner</option>
                                                <option value="tenant">Tenant</option>
                                                <option value="boarder">Boarder</option>
                                            </select>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" ></span>
                                        </div>
                                        <br>
                                    </div>
                                    <!--ends residential block-->
                                    <h4 class="h4red">Postal Address </h4><span id="sameas"><p><input type="checkbox" name="same" id="same" onClick="copyAbove();">  Same as Above</p></span><br>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" id="address1" name="address1"  autocomplete="off" placeholder="Address Line 1" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<input type="text" class="form-control" id="address2" name="address2"  autocomplete="off" placeholder="Address Line 2" data-error="" required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" name="address3" id="address3" autocomplete="off" placeholder="City" required>

										<span class="help-block with-errors" ></span>
									</div>
									<div class="form-group has-feedback"><!-- ticket number 656 -->
											<input type="text" class="form-control" name="postal_code" id="postal_code" autocomplete="off" placeholder="Postal Code" data-error="">

											<span class="help-block with-errors" ></span>
									</div>

                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" name="gsword" id="gsword" autocomplete="off" placeholder="Grama Sewa Ward">

										<span class="help-block with-errors" ></span>
									</div>
                                    <br>
                                    <h4 class="h4red">Overseas/Other Address </h4><br>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" id="otheraddress1" name="otheraddress1"  autocomplete="off" placeholder="Address Line 1" data-error="" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<input type="text" class="form-control" id="otheraddress2" name="otheraddress2"  autocomplete="off" placeholder="Address Line 2" data-error="">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" name="otheraddress3" id="otheraddress3" autocomplete="off" placeholder="City">
										<span class="glyphicon form-control-feedback" aria-hidden="true"
										<span class="help-block with-errors" ></span>
									</div>
									<div class="form-group has-feedback"><!-- ticket number 656 -->
											<input type="text" class="form-control" name="otherpostal_code" id="otherpostal_code" autocomplete="off" placeholder="Postal Code" data-error="">

											<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
                                        <select name="otheraddress4" id="otheraddress4" class="form-control" placeholder="Country">
                                            <option value=""></option>
                                            <?
                                            $countries = get_countries(); //this function is in customer helper
											foreach($countries as $data){
												echo '<option value="'.$data.'">'.$data.'</option>';
											}
											?>
                                        </select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"
										<span class="help-block with-errors" ></span>
									</div>
                                    <br>
                                    <h4 class="h4red">Other Details</h4><br>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" id="landphone" name="landphone" pattern="[0-9]{10}" autocomplete="off" placeholder="Land Phone" data-error="Invalid number">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" id="workphone" name="workphone" autocomplete="off" placeholder="Work Phone" data-error="Invalid number">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" id="mobile" name="mobile" pattern="[0-9]{10}"  autocomplete="off" placeholder="Mobile Phone" data-error="Invalid number">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" id="fax" name="fax" pattern="[0-9]{10}" autocomplete="off" placeholder="Fax Number" data-error="Invalid number">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<input type="email" class="form-control" id="email" name="email" autocomplete="off" placeholder="Email" data-error="That email address is invalid">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>



								</div>
                                <div class="form-title">
                                    <h4>Bank Account Details</h4>
                                </div>
                                <div class="form-body">
                                    <div class="form-inline">
                                        <div class="form-group">
                                        <select name="bank1" id="bank1" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'1')" >
                                        <option value="">Bank</option>
                                         <? foreach ($banklist as $raw){?>
                        <option value="<?=$raw->BANKCODE?>" ><?=$raw->BANKNAME?></option>
                        <? }?>

                                        </select>
                                            </div>&nbsp;<div class="form-group" id="branch-1">
                                             <select name="branch1" id="branch1" class="form-control" placeholder="Bank" >
                                        <option value="">Branch</option>


                                        </select>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control"name="acc1" id="acc1" autocomplete="off"   placeholder="Account Number" data-error="" >

                                        </div>
                                        </div>
                                         <br>

                                            <div class="form-inline">
                                        <div class="form-group">
                                        <select name="bank2" id="bank2" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'2')">
                                        <option value="">Bank</option>
                                         <? foreach ($banklist as $raw){?>
                        <option value="<?=$raw->BANKCODE?>" ><?=$raw->BANKNAME?></option>
                        <? }?>

                                        </select>
                                            </div>&nbsp;<div class="form-group"  id="branch-2">
                                             <select name="branch2" id="branch2" class="form-control" placeholder="Bank" >
                                        <option value="">Branch</option>


                                        </select>
                                        </div>
                                        <div class="form-group has-feedback" >
                                            <input type="text" class="form-control"name="acc2" id="acc2" autocomplete="off"   placeholder="Account Number" data-error=""  >

                                        </div>
                                        </div>
                                       <br>


                                        <div class="bottom validation-grids">

                                                <div class="form-group">
                                                    <button type="submit" style="width:50%;" class="btn btn-primary disabled">Submit</button>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>


                                </div>
							</div>
						</div>
                        </div>
                        <div class="clearfix"> </div>
					</form></p>
                </div>
                <? }?>
            </div>
         </div>
      </div>
      <!-- The blueimp Gallery widget -->
      <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
          <div class="slides"></div>
          <h3 class="title"></h3>
          <a class="prev">‹</a>
          <a class="next">›</a>
          <a class="close">×</a>
          <a class="play-pause"></a>
          <ol class="indicator"></ol>
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

<button type="button" style="display:none; visibility:hidden;" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none; visibility:hidden;" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>cm/customer/delete/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>cm/customer/confirm/"+document.deletekeyform.deletekey.value;
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
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?=base_url()?>media/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?=base_url()?>media/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-validate.js"></script>
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '<?=base_url()?>uploads/temp/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });

    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i,
        maxFileSize: 999000,
		//maxNumberOfFiles: 5,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true,
		done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                //.text('Upload')
				.hide()
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
		$("#addfile").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
				$("#id_copy_front").val(file.name);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

	$('#fileupload2').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i,
        maxFileSize: 999000,
		//maxNumberOfFiles: 5,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true,
		done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files2');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files2');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .hide()
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress2 .progress-bar').css(
            'width',
            progress + '%'
        );
		$("#addfile2").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);

                $(data.context.children()[index])
                    .wrap(link);
				$("#id_copy_back").val(file.name);

            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
		//end file upload 2
	$('#fileupload3').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i,
        maxFileSize: 999000,
		//maxNumberOfFiles: 5,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true,
		done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files3');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files3');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .hide()
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress3 .progress-bar').css(
            'width',
            progress + '%'
        );
		$("#addfile3").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);

                $(data.context.children()[index])
                    .wrap(link);
				$("#customer_photo").val(file.name);
				$("#webcamimage").val('');

            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
		//end file upload 3
	$('#fileupload4').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i,
        maxFileSize: 999000,
		//maxNumberOfFiles: 5,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true,
		done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files4');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files4');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .hide()
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress4 .progress-bar').css(
            'width',
            progress + '%'
        );
		$("#addfile4").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);

                $(data.context.children()[index])
                    .wrap(link);
				$("#signature").val(file.name);

            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
	//end file upload 4

		//remove file when click delete
	  $('#files').on('click', 'a.delete', function (e) {
		  e.preventDefault();

		  var $link = $(this);

		  var req = $.ajax({
			dataType: 'json',
			url: $link.data('url'),
			type: 'DELETE'
		  });

		  req.success(function () {
			$link.closet('p').remove();
		  });
		 $("#addfile").show();
		 $("#files").html('');
		 $('#progress .progress-bar').css(
            'width',
            0 + '%'
        );
	  });

	  $('#files2').on('click', 'a.delete', function (e) {
		  e.preventDefault();

		  var $link = $(this);

		  var req = $.ajax({
			dataType: 'json',
			url: $link.data('url'),
			type: 'DELETE'
		  });

		  req.success(function () {
			$link.closet('p').remove();
		  });
		 $("#addfile2").show();
		 $("#files2").html('');
		 $('#progress2 .progress-bar').css(
            'width',
            0 + '%'
        );
	  });

	  $('#files3').on('click', 'a.delete', function (e) {
		  e.preventDefault();

		  var $link = $(this);

		  var req = $.ajax({
			dataType: 'json',
			url: $link.data('url'),
			type: 'DELETE'
		  });

		  req.success(function () {
			$link.closet('p').remove();
		  });
		 $("#addfile3").show();
		 $("#files3").html('');
		 $('#progress3 .progress-bar').css(
            'width',
            0 + '%'
        );
	  });

	  $('#files4').on('click', 'a.delete', function (e) {
		  e.preventDefault();

		  var $link = $(this);

		  var req = $.ajax({
			dataType: 'json',
			url: $link.data('url'),
			type: 'DELETE'
		  });

		  req.success(function () {
			$link.closet('p').remove();
		  });
		 $("#addfile4").show();
		 $("#files4").html('');
		 $('#progress4 .progress-bar').css(
            'width',
            0 + '%'
        );
	  });

document.getElementById('files2').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('files').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('files3').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('files4').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};


});

</script>
<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
			document.getElementById('confirm-but').disabled = false;
			$('#confirm-but').html('Confirm');
        } );
    }

</script>
 <script>
 	$('#confirm-but').on("click", function(e){
		e.preventDefault();
		processWebcam();
	});
	//webcam form action
	function processWebcam(){
		 // event.preventDefault();
		  document.getElementById('confirm-but').disabled = true;
		  $('#confirm-but').html('Please Wait');
		  var webcam_image = document.getElementById("webcamimage").value;
		  $.ajax({
			  cache: false,
			  type: 'POST',
			  url: '<?php echo base_url().'cm/customer/webcam_image';?>',
			  data: {webcam_image:webcam_image},
			  success: function(data) {
				  if (data) {
					  $('#confirm-but').html('Uploaded');
					  document.getElementById("webcamimage").value = data;
					  document.getElementById("customer_photo").value = '';
					  var newURL = '<?php echo base_url()?>uploads/temp/' + data;
					  document.getElementById('results_anchor').href = newURL;
					  document.getElementById('results_span').onclick = function (event) {
						  event = event || window.event;
						  var target = event.target || event.srcElement,
							  link = target.src ? target.parentNode : target,
							  options = {index: link, event: event},
							  links = this.getElementsByTagName('a');
						  blueimp.Gallery(links, options);
					  };
				  }
				  else
				  {
					  alert('Unable to upload the image. Please use manual upload option!');
				  }
			  }
		  });
	}

</script>
<!--footer-->
<?
	$this->load->view("includes/footer");
?>
