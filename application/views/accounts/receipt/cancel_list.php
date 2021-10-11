

<div class="row">
    <div id="loader" class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
        <table class="table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Entry No</th>
                <th>Receipt Number</th>
                <th>Reason for Cancellation</th>
                <th>Receipt Amount</th>
                <th colspan="3"></th>
            </tr>
            </thead>

            <?php
            $c=0;
			if($cancellist){
            foreach ($cancellist as $row)
            {if($row->RCTREFNO==NULL){
             ?>
            <tbody>
                <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">

            <?php
                
                echo "<td>" . $row->CNDATE. "</td>";
                echo "<td>" . $row->number . "</td>";

            

                echo "<td>" . $row->RCTNO . "</td>";
                echo "<td>" . $row->CNRES . "</td>";
                echo "<td align=right>" . number_format($row->cr_total, 2, '.', ',') . "</td>";
                
          
               
              
               

                echo "</tr>";
			}}}
            ?>
            </tbody>


        </table>
        </div>
</div>

  