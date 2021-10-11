<?
$b='';
$b=$b.'

                         <table class="table "   border="1"> 
                       <tr  bgcolor="#caf5f7"><th colspan="6"><h2>Customer Details</h2></th></tr><thead> <tr  bgcolor="#cfd0d0"> <th>Customer Code</th> <th>Name</th><th>ID Number</th> <th>Mobile </th> <th>Project</th> <th>Lot Number</th></tr> </thead>';
                       if($datalist){$c=0;
                          foreach($datalist as $row){
                      
                        $b=$b.'<tbody> <tr > ';
                        $b=$b.'<th scope="row">'.$row->cus_code.'</th> <td>'.$row->first_name.' '.$row->last_name.'</td> <td>'.$row->id_number.'</td>';
                       $b=$b.' <td>'.$row->mobile.'</td>'; 
                        $b=$b.'<td>'.$row->project_name.'</td>'; 
                        $b=$b.' <td>'.$row->lot_number .'</td>
                       
                         </tr> ';
                        
                                }}
                            $b=$b.' </tbody></table>  ';
                         
                         
                          header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Customer_list.xls");
	echo $b;