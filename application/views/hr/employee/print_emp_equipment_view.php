

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
	<title>Print -Entry Number</title>
	<link type="text/css" rel="stylesheet" href="<?php echo asset_url(); ?>css/printentry.css">
  </head>
  <script>
    function printfunction(){
	window.print() ;
	 window.close();
    }
  </script>
  <style>
	#receipt{
	
	}
	.address{
		font-size:10px;
	}
  </style>

  <body onload="printfunction()">
    <?php
	?>
          
        <div id="receipt" style="width:900px;height:650px;text-align:center;">
         <div  style="padding-left: 150px;"><p style="font-size: 18px;">
	        <img   valign="middle"  align="left"   src="<?=base_url()?>media/images/logo.png"   width="220"/><strong><br>MASTER LAND AND CONSTRUCTION (PVT.) LIMITED<br><span style="font-size:14px; ">No.95/1/1,Coppara Junction, Colombo Road, Negombo.<br>Tel : +94 71 315 44 44 / +94 11 3 62 62 62</span></span></strong></p>
		</div>
		<hr>
   	 <div  style="padding-left: 50px;"><p style="font-size: 18px;">
	    EQUIPMENT ISSUE NOTE</strong></p>
		</div>
              
     	 
			<table width="100%" align="right">
            <tr>
            <td>Name</td><td> <?=$employee_details['initial']?> <?=$employee_details['surname']?></td>
             <td>NIC</td><td>  <?=$employee_details['nic_no']?></td>
              
            </tr>
            <tr>
            <td>Equipment Category</td><td> 
			
			 <?php
				foreach($equipment_categories as $equipment_category){ ?>
					 <?php if($equipment_category->id == $details['equipment_category']){ echo  $equipment_category->equipment_category; }?>
				<?php
				} ?></td>
             <td>Brand</td><td>  <?=$details['brand']?></td>
             
            </tr>
            <tr>
           	 <td>Value</td>
             <td><?=number_format($details['value'],2)?></td>
              <td>Issue Date</td>
               <td><?=$details['from_date']?></td>
            </tr>
             <tr>
           	 <td>Equipment Name</td>
             <td><?=$details['equipment_name']?></td>
              <td>Serial Number</td>
               <td><?=$details['serial_number']?></td>
            </tr>
            </table>
      
			  
	  <div class="col-xs-12"><hr></div>
      
      
              
	  
          <br/> <br/>
          <table width="80%" style="font-weight:bold" align="center">
            <tr>
              <td align="left" colspan="3"></td>
              <td align="left"></td>
              <td align="left" colspan="3"></td>
            </tr>
            <tr height="30">
              <td align="left">Generate By</td>
              <td width="10">:</td>
              <td align="left"><? echo ucfirst($this->session->userdata('username')); ?></td>
              <td align="left" width="10%"></td>
              <td align="left">Recieved By</td>
              <td width="10">:</td>
              <td align="left">.............................................</td>
            </tr>
            <tr height="30">
              <td align="left">Checked By</td>
              <td width="10">:</td>
              <td align="left">.............................................</td>
              <td align="left" width="10%"></td>
			  <td align="left">NIC No</td>
              <td width="10">:</td>
              <td align="left">.............................................</td>
            </tr>
            <tr height="30">
              <td align="left">Approved By</td>
              <td width="10">:</td>
              <td align="left">.............................................</td>
              <td align="left" width="10%"></td>
			  <td align="left">Signature</td>
              <td width="10">:</td>
              <td align="left">.............................................</td>
            </tr>
          </table>
        </div>
    <?
	 ?>
	
  </body>
</html>

