	 <script type="text/javascript">
  $( function() {
	 $( "#drown_date_upload" ).datepicker({dateFormat: 'yy-mm-dd'});
  } );
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
  function calculate_salestot_upload(i)
  {
	  var salevalue=parseFloat(document.getElementById('perches_count'+i).value)*parseFloat(document.getElementById('price'+i).value);
	  document.getElementById('subtotprice'+i).value=salevalue;

	   oldcount=document.getElementById("oldblockcount").value;

	   //alert(oldcount);
	    if(oldcount==0)
	   {
		    count=parseFloat(document.getElementById("blockout_count").value);
	  		 j=1;
	   }
	   else
	   {
		    j=oldcount;
			 count=parseFloat(document.getElementById("blockout_count").value)+parseFloat(oldcount-1);


	   }
	  var netotal=0;
	  var netpurch=0

	  for(t=1; t<=count; t++)
		{
		 if(!document.getElementById('isselect'+t).checked)
		 {
			if( document.getElementById('subtotprice'+t).value!="")
			netotal=netotal+parseFloat(document.getElementById('subtotprice'+t).value)
			if( document.getElementById('perches_count'+t).value!="")
			netpurch=netpurch+parseFloat(document.getElementById('perches_count'+t).value)
		 }

		}
		//alert(netotal);
	   document.getElementById('netpurch').value=netpurch;
	   document.getElementById('nettotal').value=netotal;
  }
 

function loadcurrent_block_upload(id)
{

 if(id!=""){
     $.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'re/lotdata/check_pending_lots/';?>',
            data: {id: id},
            success: function(data) {
                if (data) {
					if(data.trim() == '0'){
						// alert(data);
						$('#plandata_upload').delay(1).fadeIn(600);
						$('#error_upload').css('display','none');
						//return true;
					}
					else{
						// alert(data);
						 $('#plandata_upload').delay(1).fadeOut(600);
						$('#error_upload').show();
						//return false;
					}
                }
				else
				{
					 $('#plandata_upload').delay(1).fadeOut(600);
					 //return false;
				}
            }
        });
 }
 else
 {
	 $('#lotinfomation_upload').delay(1).fadeOut(600);
	 $('#plandata_upload').delay(1).fadeOut(600);
 }
}

function check_alreadyplans(id){
	$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'re/lotdata/check_pending_lots/';?>',
            data: {id: id},
            success: function(data) {
                if (data) {
					if(data.trim() == '0'){
						// alert(data);
						// $('#plandata_upload').delay(1).fadeIn(600);
						// $('#error_upload').css('display','none');
						return true;
					}
					else{
						// alert(data);
						//  $('#plandata_upload').delay(1).fadeOut(600);
						// $('#error_upload').show();
						return false;
					}
                }
				else
				{
					 // $('#plandata_upload').delay(1).fadeOut(600);
					 return false;
				}
            }
        });
}
 
  function disable(){
  	//$('#submit_btn').css('display','none');
  	document.getElementById("submit_btn").disabled = true;
  }

 </script>


<form data-toggle="validator"  method="post" action="<?=base_url()?>re/lotdata/import_blockout" enctype="multipart/form-data" onSubmit="disable()">
                       <input type="hidden" name="product_code" id="product_code" value="<?=$product_code?>">
                       <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:300px;">

<div id='error_upload' class="alert alert-danger" style="display:none;">Please delete current block out plan and try again</div>
							<div class="form-body form-horizontal">
                          <div class="form-group"><label class="col-sm-3 control-label">Select Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."  onchange="loadcurrent_block_upload(this.value)" id="prj_id_upload" name="prj_id_upload" >
                    <option value=""></option>
                    <?   foreach($searchdata as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>

					</select> </div>
                          </div></div>
                          <div id="plandata_upload" style="display:none">
                            <div class="form-title">
								<h4>Plan Details (Perch) :</h4>
							</div>
							<div class="form-body form-horizontal" >
                                    <div class="form-group"><label class="col-sm-3 control-label">Plan No</label>
										<div class="col-sm-3 "><input type="text" class="form-control"   id="plan_no"  value="" name="plan_no"  required>
                                       </div>

                                       </div>

                                     <div class="form-group"><label class="col-sm-3 control-label">Drawn By</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="drown_by"  value=""name="drown_by"    data-error=""  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-sm-3 control-label">Drawn Date</label>
										<div class="col-sm-3 has-feedback"><input  type="text" autocomplete="off" class="form-control" id="drown_date_upload"    name="drown_date_upload"     data-error=""   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                                       <div class="form-group">
									<label class="col-sm-3 control-label"><!--Finance Cost--></label>
                                    <div class="col-sm-3 has-feedback"><div id="laodfinancost"><input  type="hidden" step="0.01" class="form-control" id="finance_cost"    name="finance_cost"     data-error=""   ></div>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
										<div class="col-sm-3 validation-grids">
 									</div>
									</div>


							</div>
							
							<div style="display: none">
								<table class="table" id="table">
									<tr>
										<th>Lot Number</th>
										<th>Lot Extent</th>
										<th>Perch Price</th>
										<th>Sale Price</th>
									</tr>
								</table>
							</div>
								

				<div id="blocks_upload">
  							<div class="form-title">
								<h5>Upload Block Out Plan :Download Excel Format <a href="../../uploads/blockout_plan/excel_format/sample.xlsx"><i class="fa fa-file-excel-o nav_icon"></i></a></h5>
							</div>
								<div class="form-body form-horizontal" >
									<div class="form-group"><label class="col-sm-3 control-label">Select Block Out Plan File</label>
										<div class="col-sm-3 has-feedback"><input type="file" class="form-control" id="block_file" name="block_file"  accept=".csv,.xls,.xlsx"  data-error="" required="yes" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
										
									</div>
									</div>
							</div>

                            <div class="bottom validation-grids validation-grids-right ">

											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled" id='submit_btn' >Upload</button>
											</div>
											<div class="clearfix"> </div>
										</div>
									
                            
                           


</div>
</div>
 </div>


</form>

<script type="text/javascript">
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
  tableToExcel('table', 'Block Out Plan', 'block_out_plan_format.xls');
 });    
</script>
		

	
					