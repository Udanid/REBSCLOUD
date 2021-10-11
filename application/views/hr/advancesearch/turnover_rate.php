
<!DOCTYPE HTML>
<html>
<head>

<?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
function load_lotinquary(id,prj_id)
{
   if(id!="")
   {
    // var prj_id= document.getElementById("prj_id").value
  //  alert("<?=base_url()?>re/lotdata/get_fulldata/"+id+"/"+prj_id)
     $('#popupform').delay(1).fadeIn(600);
         $( "#popupform").load( "<?=base_url()?>re/lotdata/get_fulldata_popup/"+id+"/"+prj_id );
   }
}
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
    <h4>Employee Turnover
       <div class="form-group" style="margin-left: 100%;">
            <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
         </div>
</span></h4>
  </div>
               <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab" >
               <br>
                
              <BR>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                
                        <table class="table" id="table"> <thead> <tr> <th>Emp No</th><th>Name</th><th>Designation</th><th>Branch</th> <th>Division</th><th>Mobile No</th></tr> </thead>
                          <?$count=0;if($searchpanel_searchdata){
                          foreach($searchpanel_searchdata as $row){?>

                            <?     

                                        /*<!-- ticket no:2892 -->*/
                                    $fullname=$row->initials_full;
                                   $disname=$row->display_name;


                                 if($disname!="")
                                 {
                                    $data =$disname;
                                 }
                                 else
                                 {
                                  $data=$fullname;
                                 }





                                  ?>
 
                        <tbody>
                        <tr>
                          <td><?=$row->epf_no;?></td>
                           <td><?echo $data?></td>
                           <td><?=$row->designation;?></td>
                           <td><?=$row->branch_name;?></td>
                           <td><?=$row->division_name;?></td>
                           <td><?=$row->tel_mob;?></td>
                        </tr>
                        <?
                          $count = $count+1;}}?>
                        <tr>
                          <th colspan="6" style="background-color: #99ff99;">Total:<?=$count;?> </th>
                        </tr>
                          </tbody></table>  
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
  tableToExcel('table', 'Turnover report', 'turnover_report.xls');
 });    
</script>