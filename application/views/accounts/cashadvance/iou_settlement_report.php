<!-- Ticket No-2800 | Added By Uvini -->
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_customer");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">

     $( function() {
    $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
jQuery(document).ready(function() {

$("#officer_id").chosen({
    allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select an Option"
    });

$("#prj_id").chosen({
    allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select an Option"
    });
	$("#task_id").chosen({
    allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select an Option"
    });


});

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
function load_projectdata(code)
{
	if(code=='03')
	{
		$('#projectdata').delay(1).fadeOut(600);
	}
	else
	$('#projectdata').delay(1).fadeIn(600);
}


</script>

<script type="text/javascript">
  $(document).ready(function() {
var tableToExcel = (function() {
	var uri = 'data:application/vnd.ms-excel;base64,'
	, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
	, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
	, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	return function(table, name, fileName) {
	if (!table.nodeType) table = document.getElementById(table)
	var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}

	var link = document.createElement("A");
	link.href = uri + base64(format(template, ctx));
	link.download = fileName || 'Workbook.xls';
	link.target = '_blank';
	document.body.appendChild(link);
	link.click();
	document.body.removeChild(link);
	}
})();

$('#create_excel').click(function(){
	tableToExcel('cash_advance', 'IOU  Settlement', 'IOU_Settlement<?=$todate?>.xls');
	// util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
});
});
function hide_other(val)
{	if(val=='03')
	{
	
	$('#fromdate_div').delay(1).fadeOut(600);
	$('#todate_div').delay(1).fadeOut(600);
	$('#amount_div').delay(1).fadeOut(600);
	$('#project_div').delay(1).fadeOut(600);
	$('#task_div').delay(1).fadeOut(600);
	$('#book_div').delay(1).fadeOut(600);
	$('#book_div1').delay(1).fadeIn(600);
	}
	else if(val=='05')
	{
		$('#book_div').delay(1).fadeIn(600);
		$('#fromdate_div').delay(1).fadeIn(600);
	$('#todate_div').delay(1).fadeIn(600);
	$('#amount_div').delay(1).fadeIn(600);
	$('#project_div').delay(1).fadeIn(600);
	$('#task_div').delay(1).fadeIn(600);
	$('#book_div1').delay(1).fadeOut(600);
		
	}
	else
	{
		
	$('#fromdate_div').delay(1).fadeIn(600);
	$('#todate_div').delay(1).fadeIn(600);
	$('#amount_div').delay(1).fadeIn(600);
	$('#project_div').delay(1).fadeIn(600);
	$('#task_div').delay(1).fadeIn(600);
	$('#book_div').delay(1).fadeOut(600);
	$('#book_div1').delay(1).fadeOut(600);
	
	}
	
	
}
</script>
<style type="text/css">

</style>
 <?
    $heading2=' IOU Settlement Report  ';



 ?>
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Cash Advance Report</h3>
     			<br>
      <div class="widget-shadow">
            <div class="row">
       <div class="row-one">
                 	  <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashadvance/full_report"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
									<div class="form-group" id="reportnames_div">
										<select name="reportnames" id="" class="form-control"required="required"    onChange="hide_other(this.value)"  >
											<option value=""> Select Report Type</option>
 <!-- Ticket No-2800 | Added By Uvini -->
                                     
                                    <!-- Ticket No-2800 | Added By Uvini -->
                                    <option value="01">Cash Advance Report</option>
                                    <option value="04">IOU Report</option>
                                      <option value="05">IOU Settlement Report</option>
                                	<!--  <option value="02">Unsettled Cash Advance Report</option> -->
                                  	<option value="03">Time Exceed Unsettled List</option>								 </select>
								</div>

             					    <div class="form-group" id="book_div" style="display:none">
                                                <select name="book_id" id="book_id" class="form-control"required="required"  onChange="hide_other1(this.value)" >
                                    <?    foreach($booklist as $row){ if($row->pay_type=='CSH'){?>
                                    <option value="<?=$row->id?>"><?=$row->type_name?> <?=$row->name?></option>
                                    <? }}?>
                             
                                    </select> 
                                     </div>

                                        <div class="form-group" id="book_div1" style="display:none">
                                <select name="book_id1" id="book_id1" class="form-control" >
                                     <option value="all">Select Book Type</option>
                                     <option value="all">All</option>
				                    <?    foreach($booklist as $row){ ?>
				                    <option value="<?=$row->id?>"><?=$row->type_name?> <?=$row->name?></option>
				                    <? }?>
				             
				                    </select> 
				                                
				                            </div>

                                      <div class="form-group" id="branch">
                                <select name="branch" id="branch" class="form-control" >
                                     <option value="all">Select Branch</option>
                                     <option value="all">All</option>
                    <?    foreach($branchlist as $row){ ?>
                    <option value="<?=$row->branch_code?>"><?=$row->branch_name?></option>
                    <? }?>
             
                    </select> 
                                
                            </div>

										<div class="form-group" >
										<div class="col-sm-3 "><select name="officer_id" id="officer_id" class="form-control"required="required"  >
										 <option value="All">All</option>
										 <? if($emplist){
																foreach($emplist as $dataraw)
																{
																		?>
																<option value="<?=$dataraw->id?>" ><?=$dataraw->emp_no?> -<?=$dataraw->initial?> <?=$dataraw->surname?></option>
																 <? }}?>
																 </select>
										 </div>
										 </div>
                                     <div class="form-group" id="fromdate_div">
                                        <input type="text" name="fromdate" id="fromdate" placeholder="From Date"  class="form-control" >
                                    </div>
                                   <div class="form-group" id="todate_div">
                                        <input type="text" name="todate" id="todate" placeholder="To Date"  class="form-control" >
                                    </div>
                                    <div class="form-group" id="amount_div"  >
                                      <input type="text" name="amount" id="amount" placeholder="Amount"  class="form-control" >
                                    </div> <div class="form-group"  id="project_div" ><select name="prj_id" id="prj_id" class="form-control"  >
                                     <option value="All">Select Project</option>
                                 <? if($prjlist){
                                                        foreach($prjlist as $dataraw)
                                                        {
                                                                ?>
                                                        <option value="<?=$dataraw->prj_id?>" ><?=$dataraw->project_name?> </option>
                                                         <? }}?>
                                                         </select>
                                 </div>
                                  <div class="form-group"  id="task_div" ><select name="task_id" id="task_id" class="form-control"  >
                                     <option value="All">Select Task</option>
                                 <? if($tasklist){
                                                        foreach($tasklist as $dataraw)
                                                        {
                                                                ?>
                                                        <option value="<?=$dataraw->task_id?>" ><?=$dataraw->task_name?> </option>
                                                         <? }}?>
                                                         </select>
                                 </div>


                    <div class="form-group">
                        <button type="submit"   id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>

        </div>


    </div>
</form>   <div class="clearfix"> </div><br><div id="fulldata" style="min-height:100px;">
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?>
			<span style="float:right"><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></span>
	</h4>
	</div>
     <div class="table-responsive bs-example widget-shadow" id="cash_advance"  style="max-height:400px; overflow:scroll" >
      <table class="table table-bordered">
 
   <tr>  <th >IOU/Advance No</th> <th >	Request Date</th>
   		  <th >Settle date</th>
   		 <th >Settlement Date</th>
		 <th >Date Variance</th>
		 <th>Branch name</th>
		 <th >Requested Name</th>
		 <th>Request Amount</th>
		 <th>Total Expence Amount</th>
		 <th>Excess Amount</th>
		 <th>Description</th>
		 <th>Settled Rct Amount	</th>
		 <th>Rct Number</th>
		  <th>Rct Date</th>
		  <th>V : Nu</th>
		 <th>JE Number</th>
		 <th>Checked By </th>
		 <th>Confirm By</th>
          <th>Approved By</th>
            <th>Remars</th>
		
			
		</tr>


       <? $fulltot=0;$fulltot2=0;$fulltot3=0;?>


        <?  if($settledata){

			?>

            <?
			foreach($settledata as $raw){
				
				 $date1=date_create($raw->promiss_date);
					  $date2=date_create($raw->settled_date);
					  $diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
				//print_r($arrearspay[$raw->res_code]);

				?>

      	<tr>
        <td><?=$raw->serial_number?></td>
        <td><?=$raw->apply_date?></td>
        	<td><?=$raw->promiss_date?></td>
		  	<td ><?=$raw->settled_date?></td>
            	<td ><?=$dates?></td>
            <td><?=get_branch_name($raw->branch)?></td>

         <td align="right"><?=$raw->initial?> <?=$raw->surname?></td>
            <td align="right"><?=number_format($raw->amount,2)?></td>
						<td><?=number_format($raw->settled_amount,2)?></td>
			            <td align="right"><?=number_format($pyments[$raw->adv_id]['amount'],2)?></td>
                        <td ><?=$raw->description?></td>
                        
						<td align="right"><?=number_format($raw->refund_amount,2)?></td>
						<td><?=$raw->refund_rctnumber?></td>
						<td><?=$raw->refund_date?></td>
						<td><?=$pyments[$raw->adv_id]['je']?></td>
						<td><?=$settlemet[$raw->adv_id]['je']?></td>
                           <td><?=get_user_fullname_id($raw->set_check)?></td>
                              <td><?=get_user_fullname_id($raw->set_confirm)?></td>
                                 <td><?=get_user_fullname_id($raw->set_approve)?></td>
                                 
                                  <td></td>
                        
                            
						</td>
						
              





            </tr>
	<?
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>






      <?
	//  $fulltot=$fulltot+$prjexp;


	  ?>
    
         </table>




         </div>
    </div>

    </div>

</div>

</div>    <br />
<br /><br /><br /><br /><br /><br /><br /><br /><br /></p>

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
<input name="deletedate" id="deletedate" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>re/customer/delete/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>accounts/cashadvance/confirm_report/"+document.deletekeyform.deletekey.value+'/'+document.deletekeyform.deletedate.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
						$(document).ready(function(){
							$('#officers').hide();

							$('#reportnames').change(function(){
								var report=$('#reportnames').val();
								//alert(report)
								if(report=="01"){
									$('#fromdate_div').show();
									$('#todate_div').show();
									$('#officers').hide();
								}else if(report=="02"){
									$('#fromdate_div').hide();
									$('#todate_div').show();
									$('#officers').show();
								}
							})
						})
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
