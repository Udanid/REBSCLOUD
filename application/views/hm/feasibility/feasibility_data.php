
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
            data: {table: 'hm_projectms', id: id,fieldname:'prj_id' },
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
            data: {table: 'hm_landms', id: id,fieldname:'land_code' },
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
            data: {table: 'hm_projectms', id: id,fieldname:'prj_id' },
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
            data: {table: 'hm_projectms', id: id,fieldname:'prj_id' },
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
            data: {table: 'hm_projectms', id: id,fieldname:'prj_id' },
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

<script>

(function ($) {
    $.fn.formNavigation = function () {
        $(this).each(function () {
            $(this).find('input').on('keyup', function(e) {
                switch (e.which) {
                    case 39:
                        $(this).closest('td').next().find('input').focus(); break;
                    case 37:
                        $(this).closest('td').prev().find('input').focus(); break;
                    case 40:
                        $(this).closest('tr').next().children().eq($(this).closest('td').index()).find('input').focus(); break;
                    case 38:
                        $(this).closest('tr').prev().children().eq($(this).closest('td').index()).find('input').focus(); break;
                }
            });
        });
    };
})(jQuery);

</script>
<script>
	$(document).ready(function () {
		$('.gridexample').formNavigation();
	});
	</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Project Details</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <li role="presentation"  <? if(!$this->session->flashdata('tab')){?> class="active"<? }?>>
           <a href="#home" role="tab" id="home-tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Project Details</a></li>

 						<li role="presentation" <? if($this->session->flashdata('tab')=='design'){?> class="active"<? }?>>
           <a href="#design" id="design-tab" role="tab" data-toggle="tab" aria-controls="design" aria-expanded="false">Design Type</a></li>

					 <? if($details->owenership_type!="client_property"){?>
					<li role="presentation" <? if($this->session->flashdata('tab')=='value'){ ?> class="active"<? }?>>
          <a href="#value" id="value-tab" role="tab" data-toggle="tab" aria-controls="value" aria-expanded="false">Value Items</a></li>
				<? }?>
				<? if($details->owenership_type!="client_property"){?>
					 <li role="presentation" <? if($this->session->flashdata('tab')=='budget'){?> class="active"<? }?>>
          <a href="#budget" id="budget-tab" role="tab" data-toggle="tab" aria-controls="budget" aria-expanded="false">Common Budget</a></li>
					<? }?>
					<li role="presentation" <? if($this->session->flashdata('tab')=='boqlist'){?> class="active"<? }?>>
				<a href="#boqlist" id="sales-tab" role="tab" data-toggle="tab" aria-controls="boqlist" aria-expanded="false">BOQ Budget</a></li>

					<? if($details->owenership_type!="client_property"){?>
					 <li role="presentation" <? if($this->session->flashdata('tab')=='market'){?> class="active"<? }?>>
          <a href="#market" id="market-tab" role="tab" data-toggle="tab" aria-controls="market" aria-expanded="false">Marketing Data</a></li>
					<? }?>
					<li role="presentation" <? if($this->session->flashdata('tab')=='price'){?> class="active"<? }?>>
          <a href="#price" id="price-tab" role="tab" data-toggle="tab" aria-controls="price" aria-expanded="false">Unit Prices</a></li>

					<? if($details->owenership_type!="client_property"){?>
					  <li role="presentation" <? if($this->session->flashdata('tab')=='time'){?> class="active"<? }?>>
          <a href="#time" id="time-tab" role="tab" data-toggle="tab" aria-controls="time" aria-expanded="false">Development Time</a></li>
					<? }?>
					<? if($details->owenership_type!="client_property"){?>
						<li role="presentation" <? if($this->session->flashdata('tab')=='sales'){?> class="active"<? }?>>
          <a href="#sales" id="sales-tab" role="tab" data-toggle="tab" aria-controls="sales" aria-expanded="false">Sales Time</a></li>
					<? }?>

				</ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
						<? if($fsbstatus && $details->status=='PENDING' && $details->owenership_type=="client_property"){?> </br>
					<div style="float:right"><h2>
				  <a href="<?=base_url()?>hm/feasibility/confirm/<?=$this->encryption->encode($prj_id)?>" class="label label-success">Confirm Projectt</a>
				<a href="<?=base_url()?>hm/feasibility/delete/<?=$this->encryption->encode($prj_id)?>"><span class="label label-danger">Delete</span></a>


			 </h2>
		 </div></br></br><? }?>
             <div role="tabpanel" class="tab-pane fade <? if(!$this->session->flashdata('tab')){?> active in<? }?>" id="home" aria-labelledby="home-tab">
                    <p>	  <? $this->load->view("hm/feasibility/project_details");?> </p>
                </div>
               <div role="tabpanel" class="tab-pane fade <? if($this->session->flashdata('tab')=='value'){?> active in<? }?>" id="value" aria-labelledby="value-tab" >
                 <? $this->load->view("hm/feasibility/value_items");?>
                 </div>


                  <div role="tabpanel" class="tab-pane fade<? if($this->session->flashdata('tab')=='budget'){?> active in<? }?>" id="budget" aria-labelledby="budget-tab">
                    <p>	 <? $this->load->view("hm/feasibility/project_budjet");?> </p>
                </div>
                 <div role="tabpanel" class="tab-pane fade <? if($this->session->flashdata('tab')=='market'){?> active in<? }?>" id="market" aria-labelledby="market-tab">
                    <p>	 <? $this->load->view("hm/feasibility/marketing_data");?> </p>
                </div>
                <div role="tabpanel" class="tab-pane fade <? if($this->session->flashdata('tab')=='price'){?> active in<? }?>" id="price" aria-labelledby="price-tab">
                    <p>	 <? $this->load->view("hm/feasibility/perch_price");?> </p>
                </div>
                 <div role="tabpanel" class="tab-pane fade <? if($this->session->flashdata('tab')=='time'){?> active in<? }?>" id="time" aria-labelledby="time-tab">
                    <p>	 <? $this->load->view("hm/feasibility/development_time");?> </p>
                </div>
                 <div role="tabpanel" class="tab-pane fade <? if($this->session->flashdata('tab')=='sales'){?> active in<? }?>" id="sales" aria-labelledby="sales-tab">
                    <p>	 <? $this->load->view("hm/feasibility/sales_time");?> </p>
                </div>
								<div role="tabpanel" class="tab-pane fade <? if($this->session->flashdata('tab')=='boq'){?> active in<? }?>" id="boq" aria-labelledby="boq-tab">
									 <p>	 <? $this->load->view("hm/feasibility/boq_budjet");?> </p>
							 </div>
								<div role="tabpanel" class="tab-pane fade <? if($this->session->flashdata('tab')=='boqlist'){?> active in<? }?>" id="boqlist" aria-labelledby="boqlist-tab">
									 <p>	 <? $this->load->view("hm/feasibility/boq_list");?> </p>
							 </div>

							 <div role="tabpanel" class="tab-pane fade <? if($this->session->flashdata('tab')=='design'){?> active in<? }?>" id="design" aria-labelledby="design-tab">
									<p>	 <? $this->load->view("hm/feasibility/unit_design");?> </p>
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
