<!DOCTYPE HTML>
<html>
<head>


    <?
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));

    $this->load->view("includes/topbar_accounts");
    ?>
    <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
    <script type="text/javascript">

     $( function() {
        $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
    	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});

      } );
      function load_fulldetails()
      {
      	 var todate= $( "#todate" ).val();
         var fromdate= $( "#fromdate" ).val();


      	 if(todate!="" && fromdate!="")
      	 {

      	 	 $('#datalist').delay(1).fadeIn(600);
          	  document.getElementById("datalist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
      		   $( "#datalist").load( "<?=base_url()?>accounts/payments/online_transaction_list_search/"+fromdate+"/"+todate);
      	 }

      }
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
      	tableToExcel('online_payment', 'Online Payments', 'online_payment.xls');
      	// util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
      });
      });
    </script>

    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
        <div class="main-page">

            <div class="table">
                <h3 class="title1">Online Transations</h3>

                <div class="widget-shadow">

                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <div class="clearfix"> </div>

                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                            <li role="presentation"   class="active" >
                                <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Online Transations</a></li>
                            </ul>

                        <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
                            <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                                <p>

                                  <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/income/search"  enctype="multipart/form-data">
                                      <div class="row">
                                          <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
                                              <div class="form-body">
                                                  <div class="form-inline">
                                                      <div class="form-group">
                                                        <input type="text" name="fromdate" id="fromdate" placeholder="From Date"  class="form-control" >

                                                         </div>
                                                         <div class="form-group">
                                                           <input type="text" name="todate" id="todate" placeholder="To Date"  class="form-control" >
                                                         </div>

                                                      <div class="form-group">
                                                          <button type="button" onclick="load_fulldetails()"  id="online_transactions" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </form>

                                  <div class="row">
                                      <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;" id="datalist">
                                        <div class="form-title">

                                        <h4>Online Payment Details of <?=$from_date?> To <?=$to_date?>
                                           <span style="float:right">
                                            	<a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>


                                            </span>
                                          </h4>
                                        </div>
                                          <table class="table" id="online_payment">
                                              <thead>

                                              <tr>
                                                  <th>ID</th>
                                                  <th>Bank</th>
                                                  <th>Transaction No</th>
                                                  <th>Amount</th>
                                                  <th>Drown To</th>
                                                  <th>Narration</th>
                                                  <th>Date</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <?php
                                              $total=0;
                                              if ($online_trans){
                                              $c=0;
                                              foreach($online_trans as $rowdata){
                                              ?>

                                              <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                                  <th scope="row"><?=$c?></th>
                                                  <td><?=$rowdata->name ?></td>
                                                  <td><?=$rowdata->CHQNO?></td>
                                                  <td align="right"><?=number_format($rowdata->dr_total,2)?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                  <td><?=$rowdata->CHQNAME ?></td>
                                                  <td><?=$rowdata->narration ?></td>
                                                  <td><?=$rowdata->date ?></td>

                                              </tr>
                                              <?
                                              $total=$total+$rowdata->dr_total;
                                            }?>
                                            <tr>
                                                <th scope="row">Total</th>
                                                <td></td>
                                                <td></td>
                                                <td align="right"><?=number_format($total,2)?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                          <?  }
                                              ?>
                                              </tbody>
                                          </table>

                                      </div>
                                  </div>
                                 </p>
                            </div>

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
