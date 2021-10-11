
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
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

                 
 
      <h3 class="title1">Early Settlement Data</h3>
     			
      <div class="widget-shadow">
        <div class="form-title">
		<h4>Early Settlement Search List
       <span style="float:right"> <a href="javascript:expoet_excel()"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
               <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab" >
               <br>
             	  <form data-toggle="validator" id="myexportform" method="post" action="<?=base_url()?>advancesarch/rebatelist_excel"  enctype="multipart/form-data">
                  <input type="hidden" name="lastq" id="lastq" value="<?=$lastq?>">
                  
                  </form>
              <BR>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                 <div class="tableFixHead">
                        <table class="table"> <thead> <tr  class="active"> <th>Loan Code</th><th>Branch Name</th><th>Project Name</th><th>Lot Number</th> <th>Customer Name </th><th>Rebate Date</th><th>Balance Capital</th><th>Balance Int</th><th>Release Int rate </th><th>Paid Int</th><th>Payment Status </th></tr> </thead><tbody>
                      <?  $prjes=0;$prjdis=0;$prjsale=0; $prjmdp=0;$prjpaid=0;$prjbmdp=0;
					  $brnes=0;$brndis=0;$brnsale=0; $brnmdp=0;$brnpaid=0;$brnbmdp=0;
					  $prj_id=''; $brid='';
					  if($searchpanel_searchdata){$c=0;
                          foreach($searchpanel_searchdata as $row){
							 ?>  
                      <? if($prj_id!='' & $prj_id!=$row->prj_id){?>
                       <tr class="info" style="font-weight:bold"> 
                        <td scope="row" colspan="6">Project Total</td>
                         <td><?=number_format($prjes,2)?></td>
                           <td><?=number_format($prjdis,2)?></td>
                        <td></td>
                         <td><?=number_format($prjmdp,2)?></td>
                       <td></td>
                            </tr> 
                         
                      <? $prjes=0;$prjdis=0;$prjsale=0; $prjmdp=0;$prjpaid=0;$prjbmdp=0;
					   }?>
                        <? if($brid!='' & $brid!=$row->branch_code){?>
                       <tr class="yellow" style="font-weight:bold"> 
                        <td scope="row" colspan="6">Branch Total</td>
                         <td><?=number_format($brnes,2)?></td>
                           <td><?=number_format($brndis,2)?></td>
                        <td></td>
                        <td><?=number_format($brnmdp,2)?></td>
                       <td></td>
                               </tr> 
                         
                      <?  $brnes=0;$brndis=0;$brnsale=0; $brnmdp=0;$brnpaid=0;$brnbmdp=0;
					   }?>
                       <tr > 
                        <td scope="row"><?=$row->loan_code?></td><td scope="row"><?=get_branch_name($row->branch_code)?></td><td> <?=$row->project_name ?></td><td> <a href="javascript:load_lotinquary('<?=$row->lot_id?>','<?=$row->prj_id?>')" ><?=$row->lot_number ?>-<?=$row->plan_sqid ?></a></td> <td><?=$row->first_name ?> <?=$row->last_name ?></td> <td><?=$row->apply_date?></td>
                         <td><?=number_format($row->balance_capital,2)?></td>
                           <td><?=number_format($row->balance_int,2)?></td>
                        <td><?=number_format($row->int_paidrate,2)?></td>
                         <td><?=number_format($row->int_paidamount,2)?></td>
                       
                        <td align="right"><?=$row->pay_status?></td> 
                           </tr> 
                        
                                <?
								$prjes=$prjes+$row->balance_capital;
								$prjdis=$prjdis+($row->balance_int);
								$prjsale=$prjsale+$row->int_paidrate;
								$prjmdp=$prjmdp+$row->int_paidamount;
										$prj_id=$row->prj_id;
								$brnes=$brnes+$row->balance_capital;
								$brndis=$brndis+($row->balance_int);
								$brnsale=$brnsale+$row->int_paidrate;
								$brnmdp=$brnmdp+$row->int_paidamount;
									$brid=$row->branch_code;
								
								
								
								  }} ?>
                                    <tr class="info" style="font-weight:bold"> 
                        <td scope="row" colspan="6">Project Total</td>
                         <td><?=number_format($prjes,2)?></td>
                           <td><?=number_format($prjdis,2)?></td>
                        <td></td>
                         <td><?=number_format($prjmdp,2)?></td>
                       <td></td>
                            </tr> 
                         
                         
                         <tr class="yellow" style="font-weight:bold"> 
                        <td scope="row" colspan="6">Branch Total</td>
                         <td><?=number_format($brnes,2)?></td>
                           <td><?=number_format($brndis,2)?></td>
                        <td></td>
                        <td><?=number_format($brnmdp,2)?></td>
                       <td></td>
                               </tr> 
                         
                          </tbody></table>  </div>
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