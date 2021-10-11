<? 
$b='Serial No,Invoice Date,Tax Invoice Number,Suppliers TIN,Name of the Supplier,Description,Value of purchase,VAT Amount,Disallowed VAT Amount'."\r\n";
        $fulltot=0;
 	   $vat=$epsdata->rate/100;
	   $tot_sale=0;
	   $count=0;
	  if($reserv)
			{
				foreach($reserv as $prjraw){
		 $count++;		
	$b=$b.$count.',';
       $b=$b.$prjraw->date.',';
        $b=$b.$prjraw->inv_no.' ,';
        $b=$b.$prjraw->sup_tin.' ,';
       $b=$b.$prjraw->first_name.' '.$prjraw->last_name.',';
       $b=$b.$prjraw->note.',';
       $b=$b.$prjraw->total.',';
            
         $b=$b.$prjraw->vat_amount.' ,';
		  $b=$b.number_format(0,2).' ,';
           $b=$b."\r\n";
	  $tot_sale=$tot_sale+$prjraw->vat_amount;
		  }}
	       	 header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=INPUT-VAT-Report.csv");
	echo $b;
      