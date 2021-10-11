<!DOCTYPE html>
<html>
<head>
	<title>Baca Excell</title>
</head>
<body>

<h1>Baca Excell</h1>


<table  border="1">
<?php

	foreach ($data_excell as $key => $value) {
		# code...
		echo "\t<tr>\n";

		foreach ($value as $dt) {
			echo "\t\t<td>$dt</td>\n";
		}
		echo "\t</tr>\n";
	}
 ?>
 </table>
 <table  border="1">
 <?
 if($data_excell[1]){
	 foreach ($data_excell as $key => $value) {
		 $date=date("Y-m-d",(strtotime ( '-1 day' ,strtotime(str_replace('/','-',$value[5])))));
		 echo "\t<tr>\n";
		 echo "<td>".$loan_name."</td>";
		echo "<td>".$value[1]."</td>";
		echo "<td>".$value[2]."</td>";
		echo "<td>".$value[3]."</td>";
		echo "<td>".$value[4]."</td>";
		echo "<td>".$date."</td>";
		echo "<td>".$value[6]."</td>";
		 echo "\t</tr>\n";
	 }
 }

 ?>

 </table>

 </table>
</body>
</html>
