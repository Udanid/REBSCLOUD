<!--//Ticket No:2385-->
 <style>
 	.plc-class::placeholder{
    	color: #F33;
	}
 </style>
<html>
<head>
 <script type="text/javascript">
 	$( function() {
    $( "#agreementdate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );

 	$( function() {
    $( "#date" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
 </script>
</head>
<body>
	<div class="container">

	<select class="form-control" placeholder="Qick Search.." onchange="" id="lan_code" name="res_code" style="width:20%;margin-left: 30%;">
     	<option value="">Select Land</option>
     	<?foreach($alllands as $row){?>
        <option value="<?=$row['land_code']?> - <?=$row['property_name']?>"><?=$row['land_code']?> - <?=$row['property_name']?></option><?}?>
        </select>
         <br><br>
	         <div class="alert alert-danger" id="error" role="alert" style="display: none;">
	         	<b><p id="error_msg"></p></b>
	         </div>
        <div id='data' style="display:none;">
        	<form action="<?php echo base_url('index.php/re/landpayment_agreement/addpaymentplan');?>" method='POST'>
        		<div class="row">
        			<div class="col-md-3" style="width:200px;">
			        	<h5 style="display:inline"><b>Land Code: <span id='l'></span></b></h5>
			   		</div>
			   		<div class="col-md-3">
			       		<h5 style="display:inline">Property Name: <span id='p'></span></h5>
			       	</div>
			       	<div class="col-md-3">
			        	<h5 style="display:inline">Total Value: <span id='t'></span></h5>
			        </div>
			        <div class="col-md-3">
			        	<h5 style="display:inline">Available Amount: <span id='a'></span></h5>
			        </div>
		   		</div>
		        <hr>
		        <div class="row">

		        	<div class="col-md-4">
                <label >Agreement Date</label>
		        		<input type="text" class="form-control" name="agreementdate" id="agreementdate" placeholder="Agreement Date" required="yes" autocomplete="off" placeholder="Agreement Date" onchange="enableInsedit()" style="width:55%;height:34px;">
		   			 </div>

		        	<div class="col-md-4">
                <label >Agreement No</label>
		        		<input type="text" class="form-control" name="agreementno" id="agreementno" placeholder="Agreement No" style="width:55%;height:34px; " required="yes">
		       		</div>

		       		<div class="col-md-4">
                <label >Repayment Period</label>
		        		<input type="text" class="form-control" name="periods" id="periods" placeholder="Repayment Period" style="width:55%;height:34px; " onchange="enableInsedit()" required="yes">
		        	</div>
		  		</div>
		    <hr>
		    <table id="installements"  width="50%">

		    </table>
		    <table width="50%" id="amountshowtb" style="display:none;">
		    	<tr>
		    		<th width="10%">Total Amount</th>
		    		<td width="20%"><input type="text" id="amountshow" readonly class="form-control"></td>
		    		<td width="35%"></td>
		    	</tr>
		    </table>
		    <input type="hidden" name="temp_landcode" id="temp_landcode">
		    <input type="hidden" name="temp_amount" id="temp_amount">
		    <input type="submit" class="btn btn-primary" id="submitbtn" name="sumbit" value="Submit" onclick="return check()">
		</form>
    </div>
    </div>
</body>
<script type="text/javascript">
 $(document).ready(function(){


	$('#lan_code').change(function(){
		$('#agreementdate').val("");
		$('#agreementno').val("");
		$('#periods').val("");
		$('#installements').html("");

		var land_code = $(this).val();
		$.ajax({
           url: '<?php echo base_url().'re/landpayment_agreement/getspecificland';?>',
           type: 'POST',
           data: {land_code: land_code},
           error: function() {
              alert('Something is wrong');
           },
           success: function(data) {

           		var land = data.split('-');
           		if(land.length == 1)
           		{
           			$('#data').css('display','none')
           			$('#error_msg').text(land[0]);
           			$('#error').show();

           		}
           		else
           		{if(land.length == 2)
           			{
           				$('#data').css('display','none')
	           			$('#error_msg').text(land[0]);
	           			$('#error').show();

           			}
           			else
           			{
           				$('#error').css('display','none');
	           			$('#l').text(land[0]);
		           		$('#temp_landcode').val(land[0]);
		           		$('#temp_amount').val(land[3]);
		                $('#p').text(land[1]);
		                $('#t').text(land[2].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		                $('#a').text(land[3].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		                $('#data').show()
           			}
           		}
           			 //alert(land[2]);
           }
        });
		//$('#data').show()
	});

	// $('#periods').change(function(){
	// 	if($('#agreementdate').val()=="")
	// 	{
	// 		//$('#agreementdate').css('border','1px solid red');
	// 		$("#agreementdate").attr("placeholder", "Please pick agreement date.");
	// 		$('#agreementdate').addClass('plc-class');
	// 		$('#periods').val("");
	// 	}
	// 	else
	// 	{
	// 		$('#agreementdate').css('border','1px solid green');
	// 		var periods = $(this).val();
	// 		for(i = 0 ; i<periods ; i++)
	// 		{

	// 				$('#installements').append('<tr><td width="15%">installement '+(i+1)+' '+'</td><td width="35%"><input type="text" step="0.01" name="installement[]" id="installment'+i+'"onfocusout="calamount()" placeholder="Installement Amount" class="form-control number-separator" style="height:30px;"></td><td width="35%"><input type="text" name="date[]" id="date'+i+'" placeholder="Date" onchange="activateNextdate(this.id)" class="form-control" requierd autocomplete="off" ></td><td></td><tr><br>');

	//      // $("#date"+i).datepicker({dateFormat: 'yy-mm-dd'});
	// 			      $("#date"+i ).datepicker({dateFormat: 'yy-mm-dd',
	// 								minDate: $('#agreementdate').val(),
	// 							setDate :new Date()});
	// 							$("#cheque_date").datepicker('setDate', new Date());
	// 							$("#date"+i ).keypress(function(e) {
	// 								e.preventDefault();
	// 							});
 //    		}

 //    $('#amountshowtb').show();
	// 	}



	// });


	// $('#update').click(function(){
	// 	alert('x');
	// });

 });
</script>
<script type="text/javascript">

	$('#agreementno').change(function(){
		$('#agreementno').css('border','1px solid green');
	});

	$('#agreementdate').change(function(){
		$('#agreementdate').css('border','1px solid green');
	});

</script>

<script type="text/javascript">

	function getLastinst(val){
	var count = $('#periods').val();	//no of installments
	var total_loan = parseInt($('#temp_amount').val());
	//alert(total_loan);
	//var total_loan = total_loan.replace(/\,/g,'');
	//alert(total_loan);
	if(val == 'installment'+count){
		var i;
		var value = 0;
		for (i = 1; i <= count; i++) {

			if($('#installment'+i).val()){
				value = value + parseFloat($('#installment'+i).val().replace(/\,/g,''));
			}

		}
		if(value != total_loan){
			var balance = total_loan - (value - parseFloat($('#installment'+count).val()));

			if(balance > 0){
				alert('Total loan amount incorrect. Last instalment should be '+balance);
				$('#installment'+count).val(balance);
			}else{
				alert('Invalid Amount for Last Instalment '+balance+'. Please re-enter.');
				enableInsedit();
			}
		}
	}
}

	// function check()
	// {
	// 	if($('#agreementno').val()=="")
	// 	{
	// 		 $('#agreementno').css('border','1px solid red');
	// 	}
	// 	else
	// 	{
	// 			var sum = 0;
	// 			var totalamount = 0;
	// 			var values = $("input[name='installement[]']").map(function(){return $(this).val();}).get();
	// 			var length = values.length;
	// 			for(i = 0 ; i<(length-1);i++)
	// 			{
	// 				sum += parseInt(values[i]);

	// 			}

	// 			for(i = 0 ; i<length;i++)
	// 			{
	// 				totalamount += parseInt(values[i]);

	// 			}
	// 			// values.forEach(calSum);
	// 			var totalvalue = parseInt($('#a').text());
	// 			if(totalamount == totalvalue)
	// 			{
	// 				var agreementdate = $('#agreementdate').val();
	// 			 	var values = $("input[name='date[]']").map(function(){return $(this).val();}).get();
	// 			 	var length = values.length;
	// 			 	//alert(length);
	// 			 	if(agreementdate > values[0])
	// 			 	{
	// 			 		alert("Installement date must be greater than agreement date");
	// 			 		return false;
	// 			 	}
	// 			 	else
	// 			 	{
	// 			 		return true;
	// 			 	}


	// 				sum = 0;
	// 			}
	// 			else
	// 			{
	// 				var diff = totalvalue - sum;
	// 				//alert('You are last installment amount must be '+diff);
	// 				$('#amountshow').val(sum);
	// 				sum = 0;
	// 				return false;
	// 			}



	// 		function calSum(item)
	// 		{
	// 			if(item == '')
	// 			{
	// 				item = '0';
	// 			}
	// 			sum += parseInt(item);

	// 		}

	// 	}

	// }

	//  $("#date").change(function(){
	// // 	var agreementdate = $('#agreementdate').val();
	//  	var values = $("input[name='date[]']").map(function(){return $(this).val();}).get();
	//  	var length = values.length;
	//  	//alert(length);
	//  	if(agreementdate > values[0])
	//  	{
	//  		alert("Not");
	//  	}
	//  	else
	//  	{
	//  		alert('Ok');
	//  	}
	//  });
	function calamount()
	{
		var sum = 0;
		var totalamount = 0;
		var values = $("input[name='installement[]']").map(function(){return $(this).val();}).get();
		var length = values.length;
		for(i = 0 ; i<(length);i++)
		{
			if(values[i] == "")
			{
				values[i] = 0;
			}
			sum += parseInt(values[i]);

		}

		$('#amountshow').val(sum);
		sum = 0;


	}

function activateNextdate(id){
	var number = parseInt(id.replace ( /[^\d.]/g, '' )); //get the last character
	var next_number = parseFloat(number)+1;
	$('#date'+next_number).prop('disabled', false); //enable next date
	//$('#instdate'+next_number).prop('readonly', 'readonly');
	$('#date'+number).datepicker("destroy"); //remove datepicker to avoid user picking date later
	$('#date'+number).prop('readonly', 'readonly');
	//set date restrictions
	var datepick = $('#date'+number).val();
	date = new Date(datepick); //get date
	date.setDate(date.getDate() + 1);  //add a day
	var dateEnd = date.getFullYear() + '-' + ("0" + (date.getMonth()+1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2);
	$('#date'+next_number).datepicker("destroy");
	$('#date'+next_number).datepicker({dateFormat: 'yy-mm-dd',
		minDate: dateEnd,
	});
	$('#date'+next_number).datepicker("refresh");
}

function activateNextamount(id){
	//var number = name.substr(name.length - 1); //get the last character
	var number = parseInt(id.replace ( /[^\d.]/g, '' ))
	var next_number = parseFloat(number)+1;
	$('#installment'+number).prop('readonly', 'readonly');
	$('#installment'+next_number).prop('disabled', false); //enable next instalment
}
</script>
<script type="text/javascript">
	function enableInsedit(){

		$("#installements").html("");

		var count = $('#periods').val();	//no of installments
		var i;
		//add custom text boxes for installments
		if(count){
			for (i = 1; i <= count; i++) {
				//addning new fields for installements and dates
				var agreemtndate = $('#agreementdate').val();
				if(agreemtndate == ""){
				//we see whether the agreement date is empty. if it's empty we won't allow any fields
				$('#installements').append('<tr><td width="15%">installement '+(i)+' '+'</td><td width="35%"><input type="text" name="date[]" id="date'+i+'" placeholder="Date" onchange="activateNextdate(this.id)" class="form-control" readonly requierd autocomplete="off" ></td><td width="35%"><input type="text" step="0.01" name="installement[]" readonly id="installment'+i+'"onfocusout="calamount()" onchange="activateNextamount(this.id)" placeholder="Installement Amount" class="form-control number-separator" style="height:30px;"></td><td></td><tr><br>');

					$("#agreementdate").attr("placeholder", "Please pick agreement date.");
					$('#agreementdate').addClass('plc-class');

				}else if(i==1){

					$('#installements').append('<tr><td width="15%">installement '+(i)+' '+'</td><td width="35%"><input type="text" name="date[]" id="date'+i+'" placeholder="Date" onchange="activateNextdate(this.id)" class="form-control" requierd autocomplete="off" ></td><td width="35%"><input type="text" step="0.01" name="installement[]" id="installment'+i+'"onfocusout="calamount()" onchange="activateNextamount(this.id);getLastinst(this.id)" placeholder="Installement Amount" class="form-control number-separator" style="height:30px;"></td><td></td><tr><br>');
				}else{

					$('#installements').append('<tr><td width="15%">installement '+(i)+' '+'</td><td width="35%"><input type="text" name="date[]" id="date'+i+'" placeholder="Date" disabled onchange="activateNextdate(this.id)" class="form-control" requierd autocomplete="off" ></td><td width="35%"><input type="text" step="0.01" name="installement[]" disabled id="installment'+i+'"onfocusout="calamount()" onchange="activateNextamount(this.id);getLastinst(this.id)" placeholder="Installement Amount" class="form-control number-separator" style="height:30px;"></td><td></td><tr><br>');
				}

				//add date pickers
				 $("#date"+i ).datepicker({dateFormat: 'yy-mm-dd',
									minDate: $('#agreementdate').val(),
								setDate :new Date()});
								$("#cheque_date").datepicker('setDate', new Date());
								$("#date"+i ).keypress(function(e) {
									e.preventDefault();
								});

			}

			$('#amountshowtb').show();
		}

	}

</script>
</html>
