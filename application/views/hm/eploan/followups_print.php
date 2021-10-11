
<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:70%;
font-size:90%;
}
.row{
	font-size:80%;
}
.table{
	font-size:100%;
}
</style>
<script type="text/javascript">

function print_function()
{
	window.print() ;
	window.close();
}
</script>
<body onload="print_function()">

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
 
  
  
        
          
         <? if($followlist){?>
           <table class="table">
       <tr>
     <th colspan="4" class="info">Followup Details</th></tr>
     <tr><td colspan="4" height="10"></td></tr>
          <tbody style="font-size:12px">
   <tr class="active"><th>Date</th><th>Action</th><th>Customer Feedback</th><th>Agreement Code</th><th>Arrears</th><th>Sales Person</th></tr>
     <? foreach($followlist as $raw){?>
     <tr>
     <td><?=$raw->follow_date ?></td>
      <td><?=$raw->sales_feedback  ?></td>
       <td><?=$raw->cus_feedback  ?></td>
       <td><?=$raw->loan_code  ?></td>
         <td><?=$raw->todate_arreas  ?></td>
          <td><?=$raw->initial  ?> <?=$raw->surname  ?></td>
     </tr>
     
         <? }?>
         
         </tbody></table>
         <?
		 
		 
		 }?>
       

    </div> 
		</div></body></html>