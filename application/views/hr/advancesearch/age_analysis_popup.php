<h4>Age Category <?=$category?><span style="float:right; color:#FFF" > <a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a><a href="javascript:close_edit()"><i class="fa fa-times-circle"></i></a> 
</span></h4>
<div class="table widget-shadow">
  <div class="row">
    <table class="table table-bordered" id="table2">
    	<thead>
    		<th>Branch</th>
    		<th>EMP No</th>
    		<th>Name</th>
    		<th>Mobile No</th>
    		<th>DOB</th>
    		<th>Division</th>
    	</thead>
    	<tbody>
    	<?if($branch_list){
    		foreach($branch_list as $branch){
    			$count = 0;
    			// echo 'OK';
    			// 	exit;
    			if($searchpanel_searchdata){
    				$emp_list = array();
    				$i = 0;
                    foreach($searchpanel_searchdata as $row){
                         if($row->branch == $branch->branch_code){
                         	 $age = cal_age($row->dob);//hr/employee_helper
                         	 if($category == '18-30')
                         	 {
	                         	 if($age<=30 && $age>=18){
	                         	 	$count = $count + 1;
	                         	 	$emp_list[$i] = $row->id;

	                         	 }
                         	}

                         	if($category == '31-40')
                         	 {
	                         	 if($age<=40 && $age>=31){
	                         	 	$count = $count + 1;
	                         	 	$emp_list[$i] = $row->id;

	                         	 }
                         	}

                         	if($category == '41-50')
                         	 {
	                         	 if($age<=50 && $age>=41){
	                         	 	$count = $count + 1;
	                         	 	$emp_list[$i] = $row->id;

	                         	 }
                         	}

                         	if($category == '51-Above')
                         	 {
	                         	 if($age>50){
	                         	 	$count = $count + 1;
	                         	 	$emp_list[$i] = $row->id;

	                         	 }
                         	}

                         	$i = $i + 1;
    				}
    			}
    		}
    		$firstrow = True;
    		foreach ($emp_list as $emp) {
    			?>
    			
    				<?$data = get_employee_info_by_id($emp);?>
    				<?if($firstrow){?>
    					<tr>


    						  <!-- ticket no:2892 -->

                               <? $fullname=$data->initials_full;
                                $disname=$data->display_name;


                                 if($disname!="")
                                 {
                                    $value =$disname;
                                 }
                                 else
                                 {
                                  $value=$fullname;
                                 }?>
	    					<td rowspan="<?=$count?>"><?=$branch->branch_name?></td>
	    					<td><?=$data->epf_no;?></td>
	    					<td><?echo $value?></td>
	    					<td><?=$data->tel_mob;?></td>
	    					<td><?=$data->dob;?></td>
	    					<td><?=$data->division_name;?></td>
    					</tr>
    					<?$firstrow = False;}else{?>
    					<tr>


    						  <!-- ticket no:2892 -->

                               <? $fullname=$data->initials_full;
                                $disname=$data->display_name;


                                 if($disname!="")
                                 {
                                    $value =$disname;
                                 }
                                 else
                                 {
                                  $value=$fullname;
                                 }?>
	    					<td><?=$data->epf_no;?></td>
	    					<td><?echo $value?></td>
	    					<td><?=$data->tel_mob;?></td>
	    					<td><?=$data->dob;?></td>
	    					<td><?=$data->division_name;?></td>
    					</tr>
    			
    		<?}}
    		}}
    		?>
    	</tbody>
    </table>
  </div>
</div>
<script type="text/javascript">
  var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(table, name, fileName) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    
    var link = document.createElement("A");
    link.href = uri + base64(format(template, ctx));
    link.download = fileName || 'Workbook.xls';
    link.target = '_blank';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    }
  })();

   $('#create_excel').click(function(){
  tableToExcel('table2', 'Age Analysis Report', 'age_analysis_details_<?=date('Y-m-d');?>.xls');
 });    
</script>