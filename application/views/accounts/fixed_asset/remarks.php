<h4>Asset:  <?=$remarks->asset_name?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$remarks->id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <div class="widget-shadow remarks">
    <?
    $remarklist=$remarks->remarks;
    $commaList = explode(',', $remarklist);
    foreach ($commaList as $tag) {
    echo $tag.'</br>';
  }
    ?>
</div></div>
<br /><br /><br /><br /></div>
