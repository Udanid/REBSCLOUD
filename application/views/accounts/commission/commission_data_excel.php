
 <?
$b='';
  $b=$b.' <table width="100%" border="1"> <thead> <tr  bgcolor="#98e5f3"> <th>Project Name</th> <th>Lot Id</th><th>Perch Price</th><th>Discount</th><th>Block Price</th>
    <th>Sold Date</th> <th>Finalized Date</th> <th>Finalized Type</th><th>Commission</th></tr> </thead>';
                     $prj_tot=0;$prjid='';$tot=0;$ids=''; if($commisiondata){$c=0;
                          foreach($commisiondata as $row){
							  if($prjid!='' & $prjid!=$row->project_name){
							 
                             $b=$b.'  <tr bgcolor="#CCCCCC"style="font-weight:bold"> 
                        <th scope="row" >'.$prjid.' Total &nbsp; &nbsp; &nbsp;</th><td colspan="7">
                      
 
                        </td>';
                       
                            $b=$b.' <td  align="right"><strong>'.number_format(trim($prj_tot),2) .'</strong> </td>
                         </tr> ';
                               $prj_tot=0; }
							  $prjid=$row->project_name;
							 $prj_tot=$prj_tot+$row->commission;
							 $tot=$tot+$row->commission;
							 $ids=$row->project_id;
							  
                          
                      
                       $b=$b.'  <tbody> <tr > ';
                        $b=$b.' <td scope="row">'.$row->project_name.'</td>';
                        $b=$b.' <td>'.$row->lot_number .'</td>';
                       $b=$b.'  <td align="right">'.number_format(trim($row->price_perch),2).'</td>';
                         $b=$b.'<td  align="right">'.number_format(trim($row->discount),2) .'</td>';
                        $b=$b.'  <td  align="right">'.number_format(trim($row->discounted_price),2).'</td>';
                        $b=$b.' <td align="right">'.$row->res_date.'</td>';
                        $b=$b.'  <td align="right">'.$row->finalizedate.'</td>';
                        $b=$b.'  <td align="right">'.number_format(trim($row->persentage),2).'</td>';
                        $b=$b.'     <td  align="right">'.number_format(trim($row->commission),2) .'</td>';
                        $b=$b.'  </tr> ';
                        
                                 }} 
                     $b=$b.'       
                     <tr bgcolor="#CCCCCC"style="font-weight:bold"> 
                        <th scope="row" >'.$prjid.' Total</td>';
                         $b=$b.' <td colspan="7">
                      
                        </td>
                            <td  align="right"><strong>'.number_format(trim($prj_tot),2).'</strong> </td>
                         </tr> 
                          <tr class="active"> ';
                       $b=$b.'    <th scope="row" colspan="8"> Total</td>
                       
                            <td  align="right"><strong>'.number_format(trim($tot),2).'</strong> </td>
                         </tr> 
                     </tbody></table>';
                      
                  	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=commission_details-Report_".$year."_".$month.".xls");
	echo $b;