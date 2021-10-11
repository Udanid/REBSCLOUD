
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
	//	alert("<?=base_url()?>re/lotdata/get_fulldata/"+id+"/"+prj_id)
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
		<h4><?=$title;?>
       <span style="float:right"> <a href="javascript:expoet_excel()"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
               <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab" >
               <br>
             	  <form data-toggle="validator" id="myexportform" method="post" action="<?=base_url()?>hr/advancesarch/employee_search_excel"  enctype="multipart/form-data">
                  <input type="hidden" name="lastq" id="lastq" value="<?=$lastq?>">

                  </form>
              <BR>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                        <table class="table"> <thead> <tr> <th>Emp No</th><th>Name</th><th>Designation</th><th>Branch</th> <th>Division</th><th>Mobile No</th></tr> </thead>
                          <?if($searchpanel_searchdata){
                          foreach($searchpanel_searchdata as $row){?>


                              <!-- ticket no:2892 -->

                             <?
                                 $fullname=$row->initials_full;
                                $disname=$row->display_name;


                                 if($disname!="")
                                 {
                                    $value =$disname;
                                 }
                                 else
                                 {
                                  $value=$fullname;
                                 }





                                  ?>







                        <tbody>
                        <tr>


                          <td><?=$row->epf_no;?></td>
                           <td><?echo $value?></td>
                           <td><?=$row->designation;?></td>
                           <td><?=$row->branch_name;?></td>
                           <td><?=$row->division_name;?></td>
                           <td><?=$row->office_mobile;?></td>
                        </tr>
                        <?}}?>
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
