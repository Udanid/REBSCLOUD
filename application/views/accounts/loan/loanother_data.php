<h4>Asset:  <?=$loandata->loan_number;?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$loandata->id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <div class="widget-shadow remarks">
  <?php
  if($loandata->asset_id)
  {
      if($loandata->sub_loan_type)
      {
        if($loandata->sub_loan_type=="inventory")
        {
          echo "Project Name:  ".$prjName[$loandata->asset_id]->project_name."</br>";
          echo "Project Code:  ".$prjName[$loandata->asset_id]->land_code."</br>";
          echo "Block Numbers:</br>";
          foreach ($prjlist[$loandata->asset_id] as $key => $value) {
            echo $value->lot_no."</br>";
          }

        }else if($loandata->sub_loan_type=="fixed_assets")
        {
            echo "Asset Name:".$fixed_assets[$loandata->asset_id]->asset_name;
            echo "</br>";
            echo "Asset code:".$fixed_assets[$loandata->asset_id]->asset_code;
            echo "</br>";
            echo "Asset Value:".$fixed_assets[$loandata->asset_id]->asset_value;
        }

      }else{
        echo "Asset Name:".$fixed_assets[$loandata->asset_id]->asset_name;
        echo "</br>";
        echo "Asset code:".$fixed_assets[$loandata->asset_id]->asset_code;
        echo "</br>";
        echo "Asset Value:".$fixed_assets[$loandata->asset_id]->asset_value;
      }
  }
  ?>
</div></div>
<br /><br /><br /><br /></div>
