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

$( function() {
    $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
jQuery(document).ready(function() {
 	  $("#prj_id").chosen({
     allow_single_deselect : true
    });
	

 
	
});
function load_branchproject(id)
{
			 document.getElementById("prjlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
			  $( "#prjlist").load( "<?=base_url()?>re/report/get_branch_projectlist/"+id);
	
		
		
}
function load_fulldetails()
{
	 var prj_id= document.getElementById("prj_id").value;
	    var todate=document.getElementById("todate").value;
	//  alert('block_val')
	 
		  
	 		 $('#fulldata').delay(1).fadeIn(600);
    		  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
			          window.location="<?=base_url()?>re/ledgerbalance_report/index/";
          
	
	 
}

function call_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;
	 

					$('#complexConfirm_confirm').click();
					alert(id)
				
	
	
//alert(document.testform.deletekey.value);
	
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
                 
                    <div class="form-group" id="prjlist">
                        <select class="form-control" placeholder="Qick Search.."    id="prj_id" name="prj_id" >
                    <option value="ALL">All projects</option>
                    <? //    foreach($prjlist as $row){?>
                 <!--   <option value="< ?=$row->prj_id?>">< ?=$row->project_name?> - < ?=$row->town?></option>
                 -->   <? // }?>
             
					</select>  </div>
                    
                  
                  <!--  <div class="form-group" id="blocklist">
                        <select  name="quarter" id="quarter" class="form-control" >
                         <option value="">Select Quarter</option>
                        <option value="01">1st Quarter</option>
                        <option value="02">2nd Quarter</option>
                        <option value="03">3rd Quarter</option>
                        <option value="04">4th Quarter</option>
                       
                        </select>
                    </div>-->
                      
                      <div class="form-group" id="blocklist">
                      <input type="text" name="todate" id="todate" placeholder="To Date"  class="form-control" >
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="load_fulldetails()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>
            
        </div>
           
  
    </div>
</form>   <div class="clearfix"> </div><br><div id="fulldata" style="min-height:100px;">


<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>Migration Ledger report<span style="float:right"> 
        <? if($flag){?>
        	<a href="<?=base_url()?>re/ledgerbalance_report/update_migration_entry/"><span class="label label-success">Update Migration Entry</span></a>
            <? }?>
</span> 
       </h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
        <? $totsale=0;$unsale=0;$uncost=0;$totcost=0;
		
	$prjcounter=1;
		?>	
        
        	            
      <table class="table table-bordered">
      <tr><th  rowspan="2">Ledger Account</th>
      <?  foreach($prjlist as $raw){
		  $prjcounter++;
		  $totals[$raw->prj_id]['DR']=0;
		   $totals[$raw->prj_id]['CR']=0;
		  ?>
		  <th colspan="2"><?=$raw->project_name?></th>
		  <?
	  }?>
      </tr>
      <tr>
       <?
	     $prjcounter++;
		 $prjcounter++;
	    foreach($prjlist as $raw){
		  ?>
		  <th>Dr</th><th>Cr</th>
		  <?
	  }?>
      </tr>
       <tr><th colspan="<?=$prjcounter?>" class="info">Cash In Hande</th></tr>
       <tr><td>Cash In Hand</td>
       <? 
	    $rowtot=0; foreach($prjlist as $raw){
		 
		   $cashinhand=$data_set['Income'][$raw->prj_id]-$data_set['Expence'][$raw->prj_id];
		              $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$cashinhand;
					    $rowtot=$rowtot+$cashinhand;
		  ?>
		  <td align="right"><?=number_format($cashinhand,2)?></th><th></th>
		  <?
	  }?>
      </tr>
      
      <tr><th colspan="<?=$prjcounter?>" class="info">Stock Accounts</th></tr>
      <tr><td>Available to Sale Stock</td>
       <?  foreach($prjlist as $raw){
		   $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Available to Sale Stock'][$raw->prj_id];
		   $totals[$raw->prj_id]['CR']=0;
		  ?>
		  <td align="right"><?=number_format($data_set['Available to Sale Stock'][$raw->prj_id],2)?></th><th></th>
		  <?
	  }?>
      </tr>
       <tr><td>Construction Stock - Houses</td>
       <?  foreach($prjlist as $raw){
		     $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Construction Stock - Houses'][$raw->prj_id];
		   $totals[$raw->prj_id]['CR']=0;
		  ?>
		  <td align="right"><?=number_format($data_set['Construction Stock - Houses'][$raw->prj_id],2)?></th><th></th>
		  <?
	  }?>
      </tr>
      <tr><td>Advanced Stock</td>
       <?  foreach($prjlist as $raw){
		    $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Advanced Stock'][$raw->prj_id];
		   $totals[$raw->prj_id]['CR']=0;
		  ?>
		  <td align="right"><?=number_format($data_set['Advanced Stock'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
       <tr><th colspan="<?=$prjcounter?>" class="info">Trade Debtors</th></tr>
        <tr><td>Trade Debtor</td>
       <?  foreach($prjlist as $raw){
		      $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Trade Debtor'][$raw->prj_id];
	
		  ?>
		  <td align="right"><?=number_format($data_set['Trade Debtor'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
       <tr><td>Trade Debtor EP</td>
       <?  foreach($prjlist as $raw){
		    $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Trade Debtor EP'][$raw->prj_id];
	
		  ?>
		  <td align="right"><?=number_format($data_set['Trade Debtor EP'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
        <tr><td>Trade Debtor ZEP</td>
       <?  foreach($prjlist as $raw){
		   $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Trade Debtor ZEP'][$raw->prj_id];
		  
		  ?>
		  <td align="right"><?=number_format($data_set['Trade Debtor ZEP'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
        <tr><td>Trade Debtor EPB</td>
       <?  foreach($prjlist as $raw){
		     $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Trade Debtor EPB'][$raw->prj_id];
		  
		
		  ?>
		  <td align="right"><?=number_format($data_set['Trade Debtor EPB'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
         <tr><th colspan="<?=$prjcounter?>" class="info">Trade Recievables</th></tr>
          <tr><td>Trade Receivable EP</td>
           <?  foreach($prjlist as $raw){
               $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Trade Receivable EP'][$raw->prj_id];
               ?>
              <td align="right"><?=number_format($data_set['Trade Receivable EP'][$raw->prj_id],2)?></td><td></td>
              <?
          }?>
          </tr>
          
          
            <tr><td>Trade Receivable ZEP</td>
       <?  foreach($prjlist as $raw){
		    $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Trade Receivable ZEP'][$raw->prj_id];
		  
		  ?>
		  <td align="right"><?=number_format($data_set['Trade Receivable ZEP'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
      
      <tr><th colspan="<?=$prjcounter?>" class="info">EP Unrealized Interest</th></tr>
     <tr><td>Unrealized EP Interest Lands</td>
       <?  foreach($prjlist as $raw){
		    $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Unrealized EP Interest Lands'][$raw->prj_id];
		  ?>
		  <td align="right"><?=number_format($data_set['Unrealized EP Interest Lands'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
      <tr><td>EP Interest In Suspense Lands</td>
       <?  foreach($prjlist as $raw){
			   $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['EP Interest In Suspense Lands'][$raw->prj_id];
		  ?>
		  <td align="right"></td><td align="right"><?=number_format($data_set['EP Interest In Suspense Lands'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
       <tr><th colspan="<?=$prjcounter?>" class="info">Unralized Profit Lands</th></tr>
       
        <tr><td>Unrealized Sale Land</td>
       <?  foreach($prjlist as $raw){
		  $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['Unrealized Sale Land'][$raw->prj_id];
		
		  ?>
		  <td align="right"></td><td align="right"><?=number_format($data_set['Unrealized Sale Land'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
      <tr><td>Unrealized Cost Lands</td>
       <?  foreach($prjlist as $raw){
		    $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Unrealized Cost Lands'][$raw->prj_id];
		
		  ?>
		  <td align="right"><?=number_format($data_set['Unrealized Cost Lands'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
     <tr><th colspan="<?=$prjcounter?>" class="info">Unralized Profit Housing</th></tr>
     <tr><td>Unrealized Sale House</td>
       <?  foreach($prjlist as $raw){
			  $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['Unrealized Sale House'][$raw->prj_id];
		
		  ?>
		  <td align="right"></td><td align="right"><?=number_format($data_set['Unrealized Sale House'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
      <tr><td>Unrealized Cost House</td>
       <?  foreach($prjlist as $raw){
		       $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Unrealized Cost House'][$raw->prj_id];
		
		  ?>
		  <td align="right" align="right"><?=number_format($data_set['Unrealized Cost House'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
      
         <tr><th colspan="<?=$prjcounter?>" class="info">Operational Income</th></tr>
 
        <tr><td>Land Sale Income</td>
       <?  foreach($prjlist as $raw){
			 $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['Land Sale Income'][$raw->prj_id];
		
		  ?>
		  <td align="right"></td><td align="right"><?=number_format($data_set['Land Sale Income'][$raw->prj_id],2)?></td>
		  <?
	  }?>
        </tr>
       <tr><td>House Sale Income</td>
       <?  foreach($prjlist as $raw){
		 $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['House Sale Income'][$raw->prj_id];
		
		  ?>
		  <td align="right">-</td><td align="right"><?=number_format($data_set['House Sale Income'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
      <tr><th colspan="<?=$prjcounter?>" class="info">None Operational Income</th></tr>
 
       <tr><td>EP Interest Income Lands</td>
       <?  foreach($prjlist as $raw){
		 $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['EP Interest Income Lands'][$raw->prj_id];
		
		  ?>
		  <td align="right">-</td><td align="right"><?=number_format($data_set['EP Interest Income Lands'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
      
      
           <tr><td>Legal Fee</td>
       <?  foreach($prjlist as $raw){
		   
		 $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['Legal Fee'][$raw->prj_id];
		
		  ?>
		  <td align="right">-</td><td align="right"><?=number_format($data_set['Legal Fee'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
       <tr><td>P/R Fee</td>
       <?  foreach($prjlist as $raw){
		 $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['P/R Fee'][$raw->prj_id];
		
		  ?>
		  <td align="right">-</td><td align="right"><?=number_format($data_set['P/R Fee'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
       <tr><td>Plan Fee</td>
       <?  foreach($prjlist as $raw){
		   
		 $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['Plan Fee'][$raw->prj_id];
		
		  ?>
		  <td align="right">-</td><td align="right"><?=number_format($data_set['Plan Fee'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
       <tr><td>Stamp Duty</td>
       <?  foreach($prjlist as $raw){
			 $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['Stamp Duty'][$raw->prj_id];
		
		  ?>
		  <td align="right">-</td><td align="right"><?=number_format($data_set['Stamp Duty'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
       <tr><td>Draft Checking Fee</td>
       <?  foreach($prjlist as $raw){
		 $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['Draft Checking Fee'][$raw->prj_id];
		
		  ?>
		  <td align="right">-</td><td align="right"><?=number_format($data_set['Draft Checking Fee'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
      <tr><th colspan="<?=$prjcounter?>" class="info">Cost Of sale</th></tr>
       <tr><td>Cost of Lands</td>
       <?  foreach($prjlist as $raw){
		           $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Cost of Lands'][$raw->prj_id];
		  ?>
		  <td align="right"><?=number_format($data_set['Cost of Lands'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
     
      <tr><td>Cost of Housing</td>
       <?  foreach($prjlist as $raw){
		              $totals[$raw->prj_id]['DR']=$totals[$raw->prj_id]['DR']+$data_set['Cost of House'][$raw->prj_id];
		
		  ?>
		  <td align="right"><?=number_format($data_set['Cost of House'][$raw->prj_id],2)?></td><td></td>
		  <?
	  }?>
      </tr>
  <tr><th colspan="<?=$prjcounter?>" class="info">Customer Payable</th></tr>
      <tr><td>Advance Received from Customers for Lands</td>
       <?  foreach($prjlist as $raw){
		   $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set['Advance Received from Customers for Lands'][$raw->prj_id];
		  ?>
		  <td align="right"></td><td align="right"><?=number_format($data_set['Advance Received from Customers for Lands'][$raw->prj_id],2)?></td>
		  <?
	  }?>
      </tr>
     
       <tr><th colspan="<?=$prjcounter?>" class="info">Real Estate Project Payable</th></tr>
     
     
    
        <?
		
	  if($task_list)
				{
					foreach($task_list as $raw3)
					{?> <tr> <td><?=$raw3->task_name?></td><?
						foreach($prjlist as $raw){
						 $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set[$raw3->task_name][$raw->prj_id];
		
						?>
                       
                          <td align="right">-</td><td align="right"><?=number_format($data_set[$raw3->task_name][$raw->prj_id],2)?></td>
		
					<?
						}
						?></tr><?
						}
				}
				
      
      
      ?>
     
     
    <tr><th colspan="<?=$prjcounter?>" class="info">Housing Project Payable</th></tr>
    
     <?
	  if($task_list_hm)
				{
					foreach($task_list_hm as $raw4)
					{
						 $totals[$raw->prj_id]['CR']=$totals[$raw->prj_id]['CR']+$data_set[$raw4->task_name][$raw->prj_id];
		
						?>
                         <tr><td><?=$raw4->task_name?></td>
                          <td align="right">-</td><td align="right"><?=number_format($data_set[$raw4->task_name][$raw->prj_id],2)?></td></tr>
		
					<?
                    }
				}
				
      
      
      ?>
      
     
      
      
      
   
     
    <tr style="font-weight:bold"><td>Total</td>
       <?  foreach($prjlist as $raw){
			  ?>
		  <td align="right"><?=number_format($totals[$raw->prj_id]['DR'],2)?></td><td align="right"><?=number_format($totals[$raw->prj_id]['CR'],2)?></th>
		  <?
	  }?>
      </tr>
     </table>
					
                 </div><br />             </div>



    </div> 
    
</div>

</div>  </p> 
				
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
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this  Project" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>re/feasibility/delete/"+document.deletekeyform.deletekey.value;
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
                text: "Are You sure you want to confirm this  Project ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					alert('sssss')
                    window.location="<?=base_url()?>re/ledgerbalance_report/update_migration_entry/";
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            </script> 
  
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
   
