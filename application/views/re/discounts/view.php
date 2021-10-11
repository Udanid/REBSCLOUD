<h4>Project Discount Scheme - <?=$project->project_name?><span  style="float:right; color:#FFF" ><a href="javascript:close_view()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 	<div class="row">
           <?
		   	$periods = array();
			$levels = array();
           	foreach($project_discount as $row){
				if($row->days){
					if (!in_array($row->days, $periods)) {
						array_push($periods,$row->days);
					}
				}
				if($row->payrate){
					if (!in_array($row->payrate, $levels)) {
						array_push($levels,$row->payrate);
					}
				}	
			}
			echo '<table class="table table-bordered">';
			echo '<tr><th>Payment</th>';
			foreach($levels as $data2){
				echo '<th style="text-align:center">'.$data2.' %</th>';
			}
			echo '</tr>';
			$c = 0;
			foreach($periods as $data1){
				?>
                <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <?
					echo '<td>Payment within '.$data1.' days</td>';
					foreach($levels as $data2){
						echo '<td align="center">';
							foreach($project_discount as $row){
								if($row->payrate == $data2 && $row->days == $data1){
									if($row->discount == 0){
										echo '-';
									}else{
										echo $row->discount.' %';	
									}
								}	
							}
						echo '</td>';
					}
				echo '</tr>';
			
			}
			echo '</table>';
		   ?>          
 	</div>
</div> 