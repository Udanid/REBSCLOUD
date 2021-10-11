
<!DOCTYPE HTML>
<html>
<head>


<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));

$this->load->view("includes/topbar_normal_encript");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {


	$("#land_code").chosen({
     allow_single_deselect : true
    });

	$("#bank2").chosen({
     allow_single_deselect : true
    });
	$("#branch2").chosen({
     allow_single_deselect : true
    });



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
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
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
					$( "#popupform" ).load( "<?=base_url()?>hm/project/edit/"+id );
				}
            }
        });
}
function loadlandadata(id)
{

 if(id!=""){
	 $('#landinfomation').delay(1).fadeIn(600);
        document.getElementById("landinfomation").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
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

			 		 $('#landinfomation').delay(1).fadeOut(600);
					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{

					$( "#landinfomation" ).load( "<?=base_url()?>hm/project/landinformation/"+id );
				}
            }
        });
 }
 else
 {
	 $('#landinfomation').delay(1).fadeOut(600);
 }
}
function call_comment(id)
{
	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>hm/project/comments/"+id );
}
function close_edit(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
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
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
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
            data: {table: 're_projectms', id: id,fieldname:'prj_id' },
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



function  calculate_arc(val)
{
	if(val>0)
	{
		var arc=val/160;
		document.getElementById('project_arc').value=arc;
	}
	else
	document.getElementById('project_arc').value=0.00;
}
function  calculate_tot(val)
{

	var unselabletot=parseFloat(document.getElementById('road_ways').value)+parseFloat(document.getElementById('other_res').value)+parseFloat(document.getElementById('open_space').value)+parseFloat(document.getElementById('unselable_area').value);
		var seleble=parseFloat(document.getElementById('land_extend').value)-unselabletot;
		document.getElementById('selable_area').value=seleble;
		//alert(seleble);


}

</script>
	<script type="text/javascript">

function load_printscrean1(id)
{
			window.open( "<?=base_url()?>hm/feasibility/print_report/"+id);

}
function load_pdf(id)
{
			window.open( "<?=base_url()?>hm/feasibility/load_pdf/"+id);

}
function load_excel(id)
{
			window.open( "<?=base_url()?>hm/feasibility/load_excel/"+id);

}
</script>
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Project Report </h3>

      <div class="widget-shadow">

        <div class="  widget-shadow" data-example-id="basic-forms">
		<div class="form-title col-md-12 ">
		<h4 class="mytopic"> Project Name : <?=$details->project_name?>
        	<span  class="myright"><?=$details->branch_code?> - <?=$details->branch_name?></span>

             <span style="float:right"> <a href="javascript:load_printscrean1('<?=$this->encryption->encode($details->prj_id)?>')"> </a>
           <a href="javascript:load_excel('<?=$this->encryption->encode($details->prj_id)?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>

</span> </h4>
	 	</div>
        </div>
        <div class="clearfix"> </div>

          <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <li role="presentation"   class="active" >
           <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Evaluation</a></li>
           <li role="presentation"  >
           <a href="#home" role="tab" id="home-tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Project  Expenses</a></li>
          <li role="presentation">
          <a href="#value" id="value-tab" role="tab" data-toggle="tab" aria-controls="value" aria-expanded="false">Rental Computation</a></li>
           <li role="presentation">
          <a href="#budget" id="budget-tab" role="tab" data-toggle="tab" aria-controls="budget" aria-expanded="false">Monthly Cash Flow</a></li>
           <li role="presentation" >
          <a href="#market" id="market-tab" role="tab" data-toggle="tab" aria-controls="market" aria-expanded="false">Yearly Summery</a></li>
          <li role="presentation">
          <a href="#price" id="price-tab" role="tab" data-toggle="tab" aria-controls="price" aria-expanded="false">Report</a></li>

        </ul>

           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
            <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                    <p>	<? $this->load->view("hm/feasibility/evereport_main");?> </p>
                </div>
             <div role="tabpanel" class="tab-pane fade " id="home" aria-labelledby="home-tab">
                    <p>	<? $this->load->view("hm/feasibility/evereport_dvcost");?> </p>
                </div>
               <div role="tabpanel" class="tab-pane fade " id="value" aria-labelledby="value-tab" >
                 <?  $this->load->view("hm/feasibility/evereport_rental");?>
                 </div>


                  <div role="tabpanel" class="tab-pane fade" id="budget" aria-labelledby="budget-tab">
                    <p>	 <? $this->load->view("hm/feasibility/evereport_monthlycashflow");?> </p>
                </div>
                 <div role="tabpanel" class="tab-pane fade " id="market" aria-labelledby="market-tab">
                    <p>	 <?  $this->load->view("hm/feasibility/evereport_yeardata");?> </p>
                </div>
                <div role="tabpanel" class="tab-pane fade " id="price" aria-labelledby="price-tab">
                    <p>	 <? $this->load->view("hm/feasibility/evereport_summreport");?> </p>
                </div>
                 <div role="tabpanel" class="tab-pane fade " id="time" aria-labelledby="time-tab">
                    <p>	 <? //$this->load->view("hm/feasibility/development_time");?> </p>
                </div>
                 <div role="tabpanel" class="tab-pane fade " id="sales" aria-labelledby="sales-tab">
                    <p>	 <? //$this->load->view("hm/feasibility/sales_time");?> </p>
                </div>

               </div>
            </div>
         </div>
      </div>






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
