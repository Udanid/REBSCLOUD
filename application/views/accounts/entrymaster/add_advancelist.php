
											<table class="tables">
												<thead>
												<tr>
													<th>Type</th>
													<th>Ledger Account</th>
													<th>Dr Amount</th>
													<th>Cr Amount</th>
													<th colspan=2></th>
													<th colspan=2>Cur Balance</th>
												</tr>
												</thead>
												<?php
												$counter=0;
												foreach ($ledger_dc as $i => $ledger)
												{
												$dr_amount_item = array(
													'name' => 'dr_amount[' . $i . ']',
													'id' => 'dr_amount[' . $i . ']',
													'maxlength' => '15',
													'size' => '15',
													'value' => isset($dr_amount[$i]) ? $dr_amount[$i] : "",
													'class' => 'dr-item',
												);
												$cr_amount_item = array(
													'name' => 'cr_amount[' . $i . ']',
													'id' => 'cr_amount[' . $i . ']',
													'maxlength' => '15',
													'size' => '15',
													'value' => isset($cr_amount[$i]) ? $cr_amount[$i] : "",
													'class' => 'cr-item',
												);
												?>
												<tr>
													<?php
													echo "<td>" . form_dropdown_dc('ledger_dc[' . $i . ']', isset($ledger_dc[$i]) ? $ledger_dc[$i] : "D") . "</td>";
													if($counter==0)
														echo "<td style=\"font-size:10px\"> ". form_input_ledger('ledger_id[' . $i . ']', isset($ledger_id[$i]) ? $ledger_id[$i] : 0, '', $type = 'bankcash') . "</td>";

													else
														echo "<td>" . form_input_ledger('ledger_id[' . $i . ']', isset($ledger_id[$i]) ? $ledger_id[$i] : 0, '', '') . "</td>";

													echo "<td>" . form_input($dr_amount_item) . "</td>";
													echo "<td>" . form_input($cr_amount_item) . "</td>";

													echo "<td>" . img(array('src' => asset_url() . "images/icons/add.png", 'border' => '0', 'alt' => 'Add Ledger', 'class' => 'addrow')) . "</td>";
													echo "<td>" . img(array('src' => asset_url() . "images/icons/delete.png", 'border' => '0', 'alt' => 'Remove Ledger', 'class' => 'deleterow')) . "</td>";

													echo "<td class=\"ledger-balance\"><div></div></td>";
													?>
												</tr>
												<?php
													$counter++;
												}
												?>
												<tr><td colspan="7"></td></tr>
												<?php
												echo "<tr id=\"entry-total\"><td colspan=2><strong>Total</strong></td><td id=\"dr-total\">0</td><td id=\"cr-total\">0</td><td>" . img(array('src' => asset_url() . "images/icons/gear.png", 'border' => '0', 'alt' => 'Recalculate Total', 'class' => 'recalculate', 'title' => 'Recalculate Total')) . "</td><td></td><td></td></tr>";
												echo "<tr id=\"entry-difference\"><td colspan=2><strong>Difference</strong></td><td id=\"dr-diff\"></td><td id=\"cr-diff\"></td><td></td><td></td><td></td></tr>";
												?>
											</table>
										