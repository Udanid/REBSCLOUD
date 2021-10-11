
<!DOCTYPE HTML>
<html>
<head>

<?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">



function expoet_excel()
{


    document.getElementById("myexportform").submit();
        //window.open( "<?=base_url()?>advancesarch/reservationlist_excel/"+qua);
}
</script>

    <!-- //header-ends -->
    <!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
  <div class="table">



      <h3 class="title1">Employee search list</h3>

      <div class="widget-shadow">
        <div class="form-title">
    <h4>Age Analysis Report
       <div class="form-group" style="margin-left: 100%;">
            <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
         </div>
</span></h4>
  </div>
               <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab" >
               <br>

              <BR>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                       <table class="table table-bordered" id="table">
                        <tr>
                          <th rowspan=3 style="text-align:center;">No</th>
                          <th rowspan=3 style="text-align:center;">Branch</th>
                          <th colspan=8 style="text-align:center;">Age</th>
                        </tr>
                        <tr>
                          <th colspan="2"><a href="javascript:load_details('1','<?=$branch;?>')" title="View">18-30</a></th>
                          <th colspan="2"><a href="javascript:load_details('2','<?=$branch;?>')" title="View">31-40</a></th>
                          <th colspan="2"><a href="javascript:load_details('3','<?=$branch;?>')" title="View">41-50</a></th>
                          <th colspan="2"><a href="javascript:load_details('4','<?=$branch;?>')" title="View">51-Above</a></th>

                        </tr>
                        <tr>
                          <th>Count</th>
                          <th>Avegrage %</th>
                          <th>Count</th>
                          <th>Avegrage %</th>
                          <th>Count</th>
                          <th>Avegrage %</th>
                          <th>Count</th>
                          <th>Avegrage %</th>

                        </tr>
                        <?
                          if($branch_list){
                              $tot_cat1 = 0;
                              $tot_cat2 = 0;
                              $tot_cat3 = 0;
                              $tot_cat4 = 0;
                              $count = 0;
                              $branch_count = 0;
                              $tot_branch_count = 0;
                          foreach($branch_list as $branch){
                            $cat_1=$cat_2=$cat_3=$cat_4=$branch_count=0;
                            if($searchpanel_searchdata){
                            foreach($searchpanel_searchdata as $row){
                              if($row->branch == $branch->branch_code){
                                $branch_count = $branch_count + 1;
                                $age = cal_age($row->dob);//hr/employee_helper
                                if($age>50)
                                  $cat_4 = $cat_4 + 1;
                                elseif($age>40)
                                  $cat_3 = $cat_3 + 1;
                                elseif($age>30)
                                  $cat_2 = $cat_2 + 1;
                                elseif($age>=18)
                                  $cat_1 = $cat_1 + 1;

                            }}}?>

                            <?
                            $tot_cat1 = $tot_cat1 + $cat_1;
                            $tot_cat2 = $tot_cat2 + $cat_2;
                            $tot_cat3 = $tot_cat3 + $cat_3;
                            $tot_cat4 = $tot_cat4 + $cat_4;
                            $tot_branch_count = $tot_branch_count + $branch_count;

                            if($cat_1 !=0 || $cat_2 !=0 || $cat_3 !=0 || $cat_4 != 0){
                              $count +=1;?>
                            <tr>
                              <td align="right"><?=$count;?></td>
                              <td><?=$branch->branch_name?></td>
                              <td align="right"><?=$cat_1;?></td>
                              <td align="right" style="background-color: #99ffcc;"><?=number_format((($cat_1/$branch_count)*100),2);?>%</td>

                              <td align="right"><?=$cat_2;?></td>
                              <td align="right" style="background-color: #99ffcc;"><?=number_format((($cat_2/$branch_count)*100),2);?>%</td>

                              <td align="right"><?=$cat_3;?></td>
                              <td align="right" style="background-color: #99ffcc;"><?=number_format((($cat_3/$branch_count)*100),2);?>%</td>

                              <td align="right"><?=$cat_4;?></td>
                              <td align="right" style="background-color: #99ffcc;"><?=number_format((($cat_4/$branch_count)*100),2);?>%</td>

                            </tr>


                            <?}}}?>
                            <tr>
                              <th colspan="2" style="background-color: #99ff99;">Total</th>
                              <td align="right" style="background-color: #99ff99;"><strong><?=$tot_cat1;?></strong></td>
                              <td align="right" style="background-color: #99ccff;"><?=number_format((($tot_cat1/$tot_branch_count)*100),2);?>%</td>

                              <td align="right" style="background-color: #99ff99;"><strong><?=$tot_cat2;?></strong></td>
                              <td align="right" style="background-color: #99ccff;"><?=number_format((($tot_cat2/$tot_branch_count)*100),2);?>%</td>

                              <td align="right" style="background-color: #99ff99;"><strong><?=$tot_cat3;?></strong></td>
                              <td align="right" style="background-color: #99ccff;"><?=number_format((($tot_cat3/$tot_branch_count)*100),2);?>%</td>

                              <td align="right" style="background-color: #99ff99;"><strong><?=$tot_cat4;?></strong></td>
                              <td align="right" style="background-color: #99ccff;"><?=number_format((($tot_cat4/$tot_branch_count)*100),2);?>%</td>

                            </tr>

                        </tbody>
                      </table>
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

<script type="text/javascript">

/*Ticket No:2863 Added By Madushan 2021.05.21*/
function load_details(category,branch)
{

  // $('#branch').trigger('chosen:updated');
  // var x = $('#branch').val();
  // //alert(x);

   if(branch == '')
   {
    branch = 'ALL';
   }
    // var prj_id= document.getElementById("prj_id").value
  //  alert("<?=base_url()?>re/lotdata/get_fulldata/"+id+"/"+prj_id)
     $('#popupform').delay(1).fadeIn(600);
         $( "#popupform").load( "<?=base_url()?>hr/advancesarch/get_age_analysis_popup/"+category+'/'+branch);

}

/*Ticket No:2863 Added By Madushan 2021.05.21*/
function close_edit(){
    $('#popupform').delay(1).fadeOut(800);
  }


</script>

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
  tableToExcel('table', 'Age Analysis Report', 'age_analysis_report_<?=date('Y-m-d');?>.xls');
 });
</script>
