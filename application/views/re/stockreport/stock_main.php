<!DOCTYPE HTML>
<html>
<head>

    <script src="<?=base_url()?>media/js/dist/Chart.bundle.js"></script>
    <script src="<?=base_url()?>media/js/utils.js"></script>

<?

	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script type="text/javascript">
jQuery(document).ready(function() {
  $('#monthlist').hide();
 	  $("#prj_id").chosen({
     allow_single_deselect : true
    });




});

 $( function() {
    $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
function load_currentchart(id)
{
	var list=document.getElementById('projectlist').value;
	var res = list.split(",");
	//alert(document.getElementById('estimate'+id).value)

			//$('#canvas'+res[i]).delay(1).fadeIn(1000);
			 document.getElementById("chartset").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';

			$( "#chartset" ).load( "<?=base_url()?>re/home/mychart/"+id );
			$( "#chartset2" ).load( "<?=base_url()?>re/home/mychart/"+id );

}
function load_fulldetails()
{
	 var prj_id= document.getElementById("prj_id").value;
	 var type=document.getElementById("type").value;
	  var branchid=document.getElementById("branch_code").value;
	   var todate=document.getElementById("todate").value;
	   if(prj_id=="") prj_id='ALL';
	 if(type!='')
	 {

     if(type=='03')
     {
        var todate=document.getElementById("month").value;
         var year=document.getElementById("year").value;
       $('#fulldata').delay(1).fadeIn(600);
    		  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
			 $( "#fulldata").load( "<?=base_url()?>re/stockreport/get_stock_monthly/"+prj_id+'/'+type+'/'+todate+'/'+branchid+'/'+year);
     }else{
       $('#fulldata').delay(1).fadeIn(600);
    		  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
			 $( "#fulldata").load( "<?=base_url()?>re/stockreport/get_stock/"+prj_id+'/'+type+'/'+todate+'/'+branchid);
     }


	 }
	 else
	 {
		    document.getElementById("checkflagmessage").innerHTML='Please Select Report Type to generate report';
		  				 $('#flagchertbtn').click();
	 }


}
function load_branchproject(id)
{
			 document.getElementById("prjlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
			  $( "#prjlist").load( "<?=base_url()?>re/report/get_branch_projectlist/"+id);



}
function month_or_date(retype)
{
  var retype=$('#type').val();
  if(retype=="03")
  {
    $('#monthlist').show();
    $('#datelist').hide();
  }else{
    $('#monthlist').hide();
    $('#datelist').show();
  }
}


</script>

<style type="text/css">

@media(max-width:1920px){
	.topup{
	margin-top:0px;
}
}
@media(max-width:360px){
	.topup{
	margin-top:0px;
}
}
@media(max-width:790px){
	.topup{
	margin-top:100px;
}
}
@media(max-width:768px){
	.topup{
	margin-top:-10px;
}
}
</style>

   <div id="page-wrapper"  >
			<div class="main-page  topup" >
				<div class="row-one">
                 	  <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/income/search"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                 <div class="form-group" id="blocklist">
                        <select  name="type" id="type" class="form-control" onChange="month_or_date(this)">
                         <option value="">Report Type</option>
                        <option value="01">Available Stock Report</option>
                        <option value="02">Advanced Stock Report</option>
                         <!-- <option value="06">Project Vise Summery Report</option>
                       -->
                       <option value="03">Monthy Stock Report</option>
                        </select>
                    </div>
                 <div class="form-group">
                        <select class="form-control" placeholder="Qick Search.."    id="branch_code" name="branch_code" onChange="load_branchproject(this.value)">
                  <? if(check_access('all_branch')){?>
                    <option value="ALL">All Branch</option>
                     <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>" <? ?>><?=$row->branch_name?> </option>
                    <? }?>
                    <? } else {?>
                    <?    foreach($branchlist as $row){if($this->session->userdata('branchid')==$row->branch_code){?>
                    <option value="<?=$row->branch_code?>" <? ?>><?=$row->branch_name?> </option>
                    <? }} }?>

					</select>  </div>
                    <div class="form-group" id="prjlist">
                        <select class="form-control" placeholder="Qick Search.."    id="prj_id" name="prj_id" >
                    <option value="">Project Name</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?> - <?=$row->town?></option>
                    <? }?>

					</select>  </div>
                   <div class="form-group" id="datelist">
                      <input type="text" name="todate" id="todate" placeholder="" value="<?=date('Y-m-d')?>"  class="form-control" >
                    </div>
                    <div class="form-group" id="monthlist">
                    <div class="form-group">
                        <select  name="month" id="month" class="form-control" >
                         <option value="">Select Month</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                        </select>
                    </div>
                    <div class="form-group" >
                      <input type="text" name="year" id="year" placeholder="" value="<?=date('Y')?>"  class="form-control" >
                    </div>
                  </div>
                  <!--  <div class="form-group" id="blocklist">
                        <select  name="quarter" id="quarter" class="form-control" >
                         <option value="">Select Quarter</option>
                        <option value="01">1st Quarter</option>
                        <option value="02">2nd Quarter</option>
                        <option value="03">3rd Quarter</option>
                        <option value="04">4th Quarter</option>

                        </select>
                    </div>-->

                    <div class="form-group">
                        <button type="button" onclick="load_fulldetails()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>

        </div>


    </div>
</form>   <div class="clearfix"> </div><br><div id="fulldata" style="min-height:100px;"></div>    <br />
<br /><br /><br /><br /><br /><br /><br /><br /><br /></p>

				</div>

               <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">??</span></button>
										<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
									</div>
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>



				<div class="row calender widget-shadow" style="display:none">
					<h4 class="title">Calender</h4>
					<div class="cal1" >

					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>
