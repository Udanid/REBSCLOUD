
 <?
  $a_date = $sartdate;
$date = new DateTime($a_date);
$date->modify('last day of this month');
$reportdata=$date->format('Y-m-d');
 if($month!=''){
  $heading2=$reName.' Report as at '.$reportdata;
 }
 elseif($enddate!=""){
   $heading2=$reName.' Report as at '.$enddate;
 }
  $b='';
  
  
  


    $b=$b.'  <table  border="1">

        <tr    bgcolor="#98e5f3" ><th> Project Name </th>
          <th  >Customer Name</th>
          <th  >Contract No</th>
   			
          <th  >LOT Number</th>
         
          <th >Date</th>
        <th ><center>Total Di</center></th>
   		 <th  ><center>Paid Di</center></th>
          <th ><center>Waive off</center></th>
   		
   	  	 </tr>';

     

       $fulltot=0;

        	  $paidpr=$this_collectionpr=$waivopr=0;
			$paidall=$this_collectionall=$waivoall=0;
   	
       if($prjlist){
        
         foreach($prjlist as $prjraw){
			

				 if ($transferlist[$prjraw->prj_id])
				 {
					  
    		 $b=$b.'  <tr class="active"><td colspan="26">'.$details[$prjraw->prj_id]->project_name.'</tr>';
				
      			 $paidpr=$this_collectionpr=$waivopr=0;
	           foreach($transferlist[$prjraw->prj_id] as $raw){
             	    $received_amtwithperiod=0;$debtordue=0;
				    $waivofftot=0; $paidtot=0; $currentdue=0;
		 			$debtorpaid=0; $currentpaid=0;
          
         	 			if($paid[$raw->res_code])
          				 {
          					  $paidtot=$paid[$raw->res_code]->totdi;
							 // echo $raw->old_code.'-'.$paid[$raw->res_code]->totdi.'<br>';
          				}
          				if($waivoff[$raw->res_code])
         				 {
        					   $waivofftot=$waivoff[$raw->res_code]->totdi;
       					 }
		 				 $this_collection= $paidtot+ $waivofftot;
	 					  
					
		
						
		
			//	echo 	 $this_collection;		
		
      
      $di_as_at=get_loan_date_di($raw->loan_code,$enddate);
	  $flag=true;
	  if($raw->loan_status=='SETTLED')
	  $flag=false;
	  if($this_collection>0)
	  $flag=true;
				if( $flag>0) {
         $b=$b.' <tr><td></td>';
          $b=$b.'<td>'.$raw->first_name.' '.$raw->last_name.'</td>';
           $b=$b.'<td>'.$raw->old_code.'</td>';
      
           $b=$b.'<td>'.$raw->lot_number.'</td>';
          
           $b=$b.' <td align="right"></td>';
            $b=$b.' <td align="right">'.number_format($this_collection,2).'</td>';
              $b=$b.'   <td  align="right">'.number_format($paidtot,2).'</td>';
        $b=$b.' <td  align="right">'.number_format($waivofftot,2).'</td>';
                  
       $b=$b.'  </tr>';
       		$this_collectionpr=$this_collectionpr+$this_collection;	
			$paidpr=$paidpr+$paidtot;	
			$waivopr=$waivopr+$waivofftot;	
			
			$this_collectionall=$this_collectionall+$this_collection;	
			$paidall=$paidall+$paidtot;	
			$waivoall=$waivoall+$waivofftot;		
			

   		}} 
     $b=$b.'  <tr style="font-weight:bold"bgcolor="#b8efff"><td colspan="3">Project Total</td>
  			
           <td></td>
           <td></td>';
           
           $b=$b.' <td align="right">'.number_format($this_collectionpr,2).'</td>';
               $b=$b.'   <td  align="right">'.number_format($paidpr,2).'</td>';
        $b=$b.'  <td  align="right">'.number_format($waivopr,2).'</td>';
           
           
        

  		 $b=$b.'</tr>';
   
  
  }}

  $b=$b.' <tr style="font-weight:bold" bgcolor="#CCCCCC"><td colspan="3">Total</td>
   
           <td></td>
           <td></td>';
           
          $b=$b.'<td align="right">'.number_format($this_collectionall,2).'</td>';
                $b=$b.'  <td  align="right">'.number_format($paidall,2).'</td>';
         $b=$b.' <td  align="right">'.number_format($waivoall,2).'</td>';
  $b=$b.' </tr>';
  
    }
				

         $b=$b.' </table>';
		 
		 	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Delayint-Report.xls");
	echo $b;