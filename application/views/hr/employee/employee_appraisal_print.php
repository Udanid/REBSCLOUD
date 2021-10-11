<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Leave Application </title>
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
.bordertable {
  border: 1px solid black;
}
.colored-head{
  background-color: #52ccf4;
}
table {
  border-collapse: collapse;
}
td{
  padding: 12px;
}
.sign{
  padding: 60px;
}
</style>

<body onload="printfunction()">
  <table style="width:100%;" >

    <tr>
      <td colspan="2"><center><h2>EMPLOYEE APPRAISAL FORM</h2></center></td>
    </tr>
    <tr>
      <td >Reviewing Date: </td><td><?=$appraisal_data->review_date;?></td>
    </tr><tr>
      <td >Employee Name: </td><td><?=$emp_data['initial']." ".$emp_data['surname']?></td>
    </tr><tr>
      <td >Employee ID #: </td><td><?=$emp_data['emp_no']?></td>
    </tr><tr>
      <td >Position: </td><td><?=$designation['designation']?></td>
    </tr><tr>
      <td >Current Salary: </td><td><?=$emp_data['basic_salary']?></td>
    </tr>

    <td >Date of Next Review:</td><td><?=$appraisal_data->next_review_date;?></td>
  </td>
</tr>

<tr >
  <td colspan="2">
    <table style="width:100%;">
      <tr class="colored-head">
        <th>Performance Category</th>
        <th>Scores</th>
        <th>Remarks</th>
      </tr>
      <? if($appraisal_categorydata){
        foreach ($appraisal_categorydata as $key => $value) {?>
          <tr>
            <td ><?=$value->performance_category?></td>
            <td ><?=$value->score?></td>
            <td ><?=$value->remarks?></td>
          </tr>
        <?  }  }?>


      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2">Future Goals Discussed: : <?=$appraisal_data->future_goals;?></td>
  </tr>

  <tr rowspan="3">
    <td colspan="2">Supervisor / Appraiser Comments: <?=$appraisal_data->supervise_comment;?>

    </td>
  </tr>
  <tr rowspan="3">
    <td colspan="2">Employee Comments:  <?=$appraisal_data->employee_comment;?>

    </td>
  </tr>
  <tr rowspan="3">
    <td colspan="2"><span class="sign">Supervisor/ Appraiser Signatures: __________________________________
    </span>
  </td>
</tr>
<tr rowspan="3">
  <td colspan="2"><span class="sign">Employee Signatures: ________________________________________
  </span>
</td>
</tr>

</table>
</body>
</html>
