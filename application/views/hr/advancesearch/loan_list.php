
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

                 
 
      <h3 class="title1">Loan Data</h3>
     			
      <div class="widget-shadow">
        <div class="form-title">
		<h4>Loan Search List
       <span style="float:right"> <a href="javascript:expoet_excel()"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
               <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab" >
               <br>
             	  <form data-toggle="validator" id="myexportform" method="post" action="<?=base_url()?>advancesarch/loanlist_excel"  enctype="multipart/form-data">
                  <input type="hidden" name="lastq" id="lastq" value="<?=$lastq?>">
                  
                  </form>
              <BR>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                
                        <table class="table"> <thead> <tr> <th>Reservation Code</th><th>Branch Name</th><th>Project Name</th><th>Lot Number</th> <th>Customer Name </th><th>Reserve Date</th><th>Sale Value</th><th>Paid Amount</th><th>Finance Amount</th><th width="130">Loan Type</th></tr> </thead>
                      <?  $prjes=0;$prjdis=0;$prjsale=0; $prjmdp=0;$prjpaid=0;$prjbmdp=0;
					  $brnes=0;$brndis=0;$brnsale=0; $brnmdp=0;$brnpaid=0;$brnbmdp=0;
					  $prj_id=''; $brid='';
					  if($searchpanel_searchdata){$c=0;
                          foreach($searchpanel_searchdata as $row){
							 ?>  <tbody>
                      <? if($prj_id!='' & $prj_id!=$row->prj_id){?>
                       <tr class="info" style="font-weight:bold"> 
                        <td scope="row" colspan="6">Project Total</td>
                          <td><?=number_format($prjsale,2)?></td>
                       
                         <td align="right"><?=number_format($prjpaid,2)?></td>
                        <td align="right"><?=number_format($prjbmdp,2)?></td>
                         </tr> 
                         
                      <? $prjes=0;$prjdis=0;$prjsale=0; $prjmdp=0;$prjpaid=0;$prjbmdp=0;
					   }?>
                        <? if($brid!='' & $brid!=$row->branch_code){?>
                       <tr class="yellow" style="font-weight:bold"> 
                        <td scope="row" colspan="6">Branch Total</td>
                           <td><?=number_format($brnsale,2)?></td>
                       
                        <td align="right"><?=number_format($brnpaid,2)?></td>
                        <td align="right"><?=number_format($brnbmdp,2)?></td>
                         </tr> 
                         
                      <?  $brnes=0;$brndis=0;$brnsale=0; $brnmdp=0;$brnpaid=0;$brnbmdp=0;
					   }?>
                       <tr > 
                        <td scope="row"><?=$row->loan_code?></td><td scope="row"><?=get_branch_name($row->branch_code)?></td><td> <?=$row->project_name ?></td><td> <a href="javascript:load_lotinquary('<?=$row->lot_id?>','<?=$row->prj_id?>')" ><?=$row->lot_number ?>-<?=$row->plan_sqid ?></a></td> <td><?=$row->first_name ?> <?=$row->last_name ?></td> <td><?=$row->res_date?></td>
                        <td><?=number_format($row->discounted_price,2)?></td>
                       
                        <td align="right"><?=number_format($row->down_payment,2)?></td>
                        <td align="right"><?=number_format($row->loan_amount,2)?></td>
                           <td ><?=$row->loan_type ?></td>
                      </tr> 
                        
                                <?
								$prjes=$prjes+$row->seling_price;
								$prjdis=$prjdis+$row->discount;
								$prjsale=$prjsale+$row->discounted_price;
								$prjmdp=$prjmdp+$row->min_down;
								$prjpaid=$prjpaid+$row->down_payment;
								$prjbmdp=$prjbmdp+($row->loan_amount);
								$prj_id=$row->prj_id;
								$brnes=$brnes+$row->seling_price;
								$brndis=$brndis+$row->discount;
								$brnsale=$brnsale+$row->discounted_price;
								$brnmdp=$brnmdp+$row->min_down;
								$brnpaid=$brnpaid+$row->down_payment;
								$brnbmdp=$brnbmdp+($row->loan_amount);
								$brid=$row->branch_code;
								
								
								
								  }} ?>
                                     <tr class="info" style="font-weight:bold"> 
                        <td scope="row" colspan="6">Project Total</td>
                          <td><?=number_format($prjsale,2)?></td>
                       
                         <td align="right"><?=number_format($prjpaid,2)?></td>
                        <td align="right"><?=number_format($prjbmdp,2)?></td>
                         </tr> 
                         
                          <tr class="yellow" style="font-weight:bold"> 
                        <td scope="row" colspan="6">Branch Total</td>
                         <td><?=number_format($brnsale,2)?></td>
                       
                         <td align="right"><?=number_format($brnpaid,2)?></td>
                        <td align="right"><?=number_format($brnbmdp,2)?></td>
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