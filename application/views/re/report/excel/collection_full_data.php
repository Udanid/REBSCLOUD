

 <?

   $heading2=' Collection Details Report from '.$fromdate.' to '.$todate;

 $b='';
$b=$b.'
      <table  border="1"  width="100%"><tr bgcolor="#dad1cb"><th >Project Name</th><th  >Lot Number</th>
      <th  >Reciept No</th>  <th  >Payment Date</th>
        <th > Advance Payment </th><th >Loan Capital (NEP)</th><th >Loan Capital (ZEP)</th><th >Loan Capital (EPB)</th><th >LoanInterest </th>
      <th >Delay Interest</th><th>Stamp Fee</th><th>Legal Fees</th><th>Draft Checking Fee</th><th>Plan Copy Fees</th><th>PR Fees</th><th >Total</th>
        </tr>
        </tr>';



	$current_name='';
$prj_adv=0;$prj_cap_nep=$prj_cap_zep=$prj_cap_epb=0;$prj_int=0;$prj_di=0; $prj_other=0;$prj_nra=0;$prj_line_tot=0;
	$full_adv=0;$full_cap_nep=$full_cap_zep=$full_cap_epb=0;$full_int=0;$full_di=0; $full_other=0;$full_nra=0;$full_line_tot=0;
	$adv=0;$cap=0;$int=0;$di=0; $other=0;$nra=0;$line_tot=0;
	$stamp_fee=0;$legal_fees=0;$draft_fees=0;$plan_copy_fees=0;$pr_fees=0; //Madushan
	$prj_stamp_fee=0;$prj_legal_fees=0;$prj_draft_fees=0;$prj_plan_copy_fees=0;$prj_pr_fees=0; //Madushan
	$full_stamp_fee=0;$full_legal_fees=0;$full_draft_fees=0;$full_plan_copy_fees=0;$full_pr_fees=0; //Madushan
	if($dataset){

		foreach($dataset as $prjraw){
			$adv=0;$cap=0;$int=0;$di=0; $other=0;$nra=0;$cap_nep=0;$cap_zep=0;$cap_epb=0;
			$stamp_fee=0;$legal_fees=0;$draft_fees=0;$plan_copy_fees=0;$pr_fees=0; //Madushan
			if($prjraw->income_type=='Advance Payment')
			{
				//  $intid=get_first_advance($prjraw->temp_code);// this function is in reaccount_helper
				// if($intid==$prjraw->id)
				// $nra=$prjraw->pay_amount;
				// else
				$adv=$prjraw->pay_amount;
			}
			//rental Payments
			if($prjraw->sum_cap)
			{
				if($prjraw->loan_type=='NEP') $cap_nep=$prjraw->sum_cap;
				if($prjraw->loan_type=='ZEP') $cap_zep=$prjraw->sum_cap;
				if($prjraw->loan_type=='EPB') $cap_epb=$prjraw->sum_cap;
			}
			if($prjraw->sum_int)
			$int=$prjraw->sum_int;
			if($prjraw->sum_di)
			$di=$prjraw->sum_di;
			// Ep Settlement
			if($prjraw->balance_capital)
			{
				if($prjraw->loan_type=='NEP') $cap_nep=$prjraw->sum_cap;
				if($prjraw->loan_type=='ZEP') $cap_zep=$prjraw->sum_cap;
				if($prjraw->loan_type=='EPB') $cap_epb=$prjraw->sum_cap;
			}
			if($prjraw->int_paidamount)
			$int=$prjraw->int_paidamount;
			// Advance Di
			if($prjraw->advance_di)
			$di=$prjraw->advance_di;
			if($prjraw->income_type!='Advance Payment' & $prjraw->income_type!='Rental Payment' & $prjraw->income_type!='EP Settlement'){
				 // $other=$prjraw->amount; //Madushan
				$other_chargers = other_chargers_data($prjraw->id);//chagers_helper
	           if($other_chargers){
	           		foreach($other_chargers as $row)
	           		{
	           			if($row['chage_type'] == 'stamp_duty')
	           				$stamp_fee = $row['pay_amount'];
	           			elseif($row['chage_type'] == 'leagal_fee')
	           				$legal_fees = $row['pay_amount'];
	           			elseif($row['chage_type'] == 'other_charges')
	           				$plan_copy_fees = $row['pay_amount'];
	           			elseif($row['chage_type'] == 'other_charge2')
	           				$pr_fees = $row['pay_amount'];
	           			elseif($row['chage_type'] == 'document_fee')
	           				$draft_fees = $row['pay_amount'];
	           		}
	       		}
			}

			$line_tot=$adv+$cap+$int+$di+$other+$nra+$stamp_fee+$legal_fees+$draft_fees+$plan_copy_fees+$pr_fees+$cap_nep+$cap_zep+$cap_epb;
      //ticket 3307
			  if($current_name!='' & $current_name!=$prjraw->project_name){

			$b=$b.'  <tr  bgcolor="#fbd4ee"  style="font-weight:bold"><td>'.$current_name.'Total</td><td></td><td></td><td></td>';
       // $b=$b.'   <td align="right">'.number_format($prj_nra,2).'</td>';
         $b=$b.'   <td align="right">'.number_format($prj_adv,2).'</td>';
          $b=$b.'   <td align="right">'.number_format($prj_cap_nep,2).'</td>';
		   $b=$b.'   <td align="right">'.number_format($prj_cap_zep,2).'</td>';
		    $b=$b.'   <td align="right">'.number_format($prj_cap_epb,2).'</td>';
            $b=$b.'   <td align="right">'.number_format($prj_int,2).'</td>';
           $b=$b.'   <td align="right">'.number_format($prj_di,2).'</td>';
            $b=$b.'   <td align="right">'.number_format($prj_stamp_fee,2).'</td>';
           $b=$b.'<td align="right">'.number_format($prj_legal_fees,2).'</td>';
           $b=$b.'<td align="right">'.number_format($prj_draft_fees,2).'</td>';
           $b=$b.'<td align="right">'.number_format($prj_plan_copy_fees,2).'</td>';
           $b=$b.'<td align="right">'.number_format($prj_pr_fees,2).'</td>';
           $b=$b.'   <td align="right">'.number_format($prj_line_tot,2).'</td>';
        $b=$b.' </tr>';
					 $prj_adv=0;$prj_cap=0;$prj_int=0;$prj_di=0; $prj_other=0;$prj_nra=0;$prj_line_tot=0;
					 $prj_stamp_fee=0;$prj_legal_fees=0;$prj_draft_fees=0;$prj_plan_copy_fees=0;$prj_pr_fees=0; //Madushan
					 $prj_cap_nep=$prj_cap_zep=$prj_cap_epb=0;
					 }$current_name=$prjraw->project_name;


       $b=$b.'   <tr><td>'.$prjraw->project_name.'</td>';
       $b=$b.' <td>'.$prjraw->lot_number.'</td>';
         $b=$b.' <td>'.$prjraw->rct_no.'</td>';
          $b=$b.' <td>'.$prjraw->income_date.'</td>';
         // $b=$b.'   <td align="right">'.number_format($nra,2).'</td>';
         $b=$b.'   <td align="right">'.number_format($adv,2).'</td>';
          $b=$b.'   <td align="right">'.number_format($cap_nep,2).'</td>';
		      $b=$b.'   <td align="right">'.number_format($cap_zep,2).'</td>';
			      $b=$b.'   <td align="right">'.number_format($cap_epb,2).'</td>';
           $b=$b.'   <td align="right">'.number_format($int,2).'</td>';
             $b=$b.'   <td align="right">'.number_format($di,2).'</td>';
              $b=$b.'   <td align="right">'.number_format($stamp_fee,2).'</td>';
                $b=$b.'   <td align="right">'.number_format($legal_fees,2).'</td>';
                  $b=$b.'   <td align="right">'.number_format($draft_fees,2).'</td>';
                    $b=$b.'   <td align="right">'.number_format($plan_copy_fees,2).'</td>';
                      $b=$b.'   <td align="right">'.number_format($pr_fees,2).'</td>';
               $b=$b.'   <td align="right">'.number_format($line_tot,2).'</td></tr>';



		   // $prj_nra= $prj_nra+ $nra;
		    $prj_adv= $prj_adv+ $adv;
		  $prj_cap_zep=$prj_cap_zep+ $cap_zep;
		    $prj_cap_nep=$prj_cap_nep+ $cap_nep;
			 $prj_cap_epb=$prj_cap_epb+ $cap_epb;
		   $prj_int=$prj_int+ $int;
		   $prj_di=$prj_di+ $di;
		    $prj_stamp_fee=$prj_stamp_fee+ $stamp_fee;
		     $prj_legal_fees=$prj_legal_fees+ $legal_fees;
		      $prj_draft_fees=$prj_draft_fees+ $draft_fees;
		       $prj_plan_copy_fees=$prj_plan_copy_fees+ $plan_copy_fees;
		        $prj_pr_fees=$prj_pr_fees+ $pr_fees;
			 $prj_line_tot=$prj_line_tot+ $line_tot;

			 // $full_nra= $full_nra+ $nra;
			 $full_adv= $full_adv+ $adv;
		  $full_cap_zep=$full_cap_zep+ $cap_zep;
		    $full_cap_nep=$full_cap_nep+ $cap_nep;
			 $full_cap_epb=$full_cap_epb+ $cap_epb;
		   $full_int=$full_int+ $int;
		   $full_di=$full_di+ $di;
		   $full_stamp_fee=$full_stamp_fee+ $stamp_fee;
		    $full_legal_fees=$full_legal_fees+ $legal_fees;
		    $full_draft_fees=$full_draft_fees+ $draft_fees;
		    $full_plan_copy_fees=$full_plan_copy_fees+ $plan_copy_fees;
		    $full_pr_fees=$full_pr_fees+ $pr_fees;
			 $full_line_tot=$full_line_tot+ $line_tot;


	   }}
        $b=$b.' <tr  bgcolor="#fbd4ee"  style="font-weight:bold"><td>'.$current_name.' Total</td><td></td><td></td><td></td>';
        // $b=$b.'   <td align="right">'.number_format($prj_nra,2).'</td>';
          $b=$b.'   <td align="right">'.number_format($prj_adv,2).'</td>';
           $b=$b.'   <td align="right">'.number_format($prj_cap_nep,2).'</td>';
		   $b=$b.'   <td align="right">'.number_format($prj_cap_zep,2).'</td>';
		    $b=$b.'   <td align="right">'.number_format($prj_cap_epb,2).'</td>';
            $b=$b.'   <td align="right">'.number_format($prj_int,2).'</td>';
           $b=$b.'   <td align="right">'.number_format($prj_di,2).'</td>';
          $b=$b.'   <td align="right">'.number_format($prj_stamp_fee,2).'</td>';
           $b=$b.'<td align="right">'.number_format($prj_legal_fees,2).'</td>';
           $b=$b.'<td align="right">'.number_format($prj_draft_fees,2).'</td>';
           $b=$b.'<td align="right">'.number_format($prj_plan_copy_fees,2).'</td>';
           $b=$b.'<td align="right">'.number_format($prj_pr_fees,2).'</td>';
            $b=$b.'   <td align="right">'.number_format($prj_line_tot,2).'</td>';
         $b=$b.'</tr>';
      $b=$b.'  <tr  bgcolor="#c3c4be" style="font-weight:bold"><td></td><td></td><td></td><td></td>';
        // $b=$b.'   <td align="right">'.number_format($full_nra,2).'</td>';
         $b=$b.'   <td align="right">'.number_format($full_adv,2).'</td>';
         $b=$b.'   <td align="right">'.number_format($full_cap_nep,2).'</td>';
		  $b=$b.'   <td align="right">'.number_format($full_cap_zep,2).'</td>';
		   $b=$b.'   <td align="right">'.number_format($full_cap_epb,2).'</td>';

           $b=$b.'   <td align="right">'.number_format($full_int,2).'</td>';
           $b=$b.'   <td align="right">'.number_format($full_di,2).'</td>';
            $b=$b.'   <td align="right">'.number_format($full_stamp_fee,2).'</td>';
              $b=$b.'   <td align="right">'.number_format($full_legal_fees,2).'</td>';
                $b=$b.'   <td align="right">'.number_format($full_draft_fees,2).'</td>';
                  $b=$b.'   <td align="right">'.number_format($full_plan_copy_fees,2).'</td>';
                    $b=$b.'   <td align="right">'.number_format($full_pr_fees,2).'</td>';
           $b=$b.'   <td align="right">'.number_format($full_line_tot,2).'</td>';
       $b=$b.'  </tr>
         </table>';
		  	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Detail_Collection-Report.xls");
	echo $b;
