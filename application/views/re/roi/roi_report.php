<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">


$(document).ready(function(){  
      $('#create_excel').click(function(){ 
	  		var date =  document.getElementById('rptdate').value;
           $(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Sales Realization Report " +date,
					filename: "Sales_Realization_" + date + ".xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
           
      });  
 });
</script>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>ROI
       <span style="float:right"><a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
               <input type="hidden" id="rptdate" value="<?=$todate?>">
                     <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                
                        <table class="table table-bordered table2excel"> <thead>
                        <tr>
                        <th  class="active" colspan="3"><?=$details->project_name?></th>
                        </tr> 
                        <tr>
                        <th  class="active" colspan="3">Return of Investment as at <?=$todate?></th>
                        </tr> 
                      </thead>
                         <tbody>
                         <? $costval=0;
						 $saleval=0;
						 if($sale){
							 $saleval=$sale->selstot;
							  $costval=$sale->costtot;
							 
						 }?>
                     <tr>
                        <td scope="row">Actual Sale</td>
                        <td align="right"><?=number_format($saleval,2)?></td>
                        <td align="right"><strong>ROI</strong></td>
                        </tr>
                         <tr>
                         <td scope="row">(-) Actual Cost</td>
                        <td align="right"><?=number_format($costval,2)?></td>
                        <td></td>
                        </tr>
                         <tr  style="font-weight:bold">
                         <td scope="row" >Income</td>
                        <td align="right"><?=number_format($saleval-$costval,2)?></td>
                        <? $persentage=0;
						if(($costval)>0){
							$persentage=(($saleval-$costval)/$costval)*100;
						}?>
                        <td align="right"><?=number_format($persentage,2)?>%</td>
                        </tr>
                         <tr  style="font-weight:bold">
                         <td scope="row" ></td>
                        <td align="right"></td>
                        <td></td>
                        </tr>
                        <? $income=$saleval-$costval+$epincome-$intpay?>
                        <tr  >
                        
                         <td scope="row" >EP Income</td>
                        <td align="right"><?=number_format($epincome,2)?></td>
                        <td></td>
                        </tr>
                         <tr  >
                        
                         <td scope="row" >(-) Loan Interest</td>
                        <td align="right"><?=number_format($intpay,2)?></td>
                        <td></td>
                        </tr>
                        </tr>
                         <tr  style="font-weight:bold">
                         <td scope="row" ></td>
                        <td align="right"></td>
                        <td></td>
                        </tr>
                         <tr  style="font-weight:bold">
                         <td scope="row" >Income</td>
                        <td align="right"><?=number_format($income,2)?></td>
                         <? $persentage=0;
						if(($costval+$intpay)>0){
							$persentage=($income/($costval+$intpay))*100;
						}?>
                        <td align="right"><?=number_format($persentage,2)?>%</td>
                        </tr>
                         <tr  style="font-weight:bold">
                         <td scope="row" ></td>
                        <td align="right"></td>
                        <td></td>
                        </tr>
                         <tr  >
                         <? $income=$income+$budgetbal?>
                         <td scope="row" >Project Payable Balance</td>
                        <td align="right"><?=number_format($budgetbal,2)?></td>
                        <td></td>
                        </tr>
                        </tr>
                         <tr  style="font-weight:bold">
                         <td scope="row" >Income</td>
                        <td align="right"><?=number_format($income,2)?></td>
                        <? $persentage=0;
						if(($costval+$intpay)>0){
							$persentage=($income/($costval+$intpay))*100;
						}?>
                        <td align="right"><?=number_format($persentage,2)?>%</td>
                        </tr>
                          </tbody></table>  
                     </div>  </div></div>
               