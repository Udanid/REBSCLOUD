<div class="table widget-shadow">
<div class="title-details">
<h3>Design Type <?=$details->short_code?> - <?=$details->design_name?></h3>
<div class="row">
  <div class="col-md-6 image-main">
    <?

         if($designtypeimgs){

            foreach($designtypeimgs as $dtimg){
                ?>

            <div> <img class="img-fluid" src="<?=base_url()?>uploads/design_type/<?=$dtimg->designtype_image?>" ></div><br />

                <?
                break;
            }
         }else{
            $imgnames = '';
         }
         ?>
  </div>
  <div class="col-md-6">
<table class="table">
  <tr>
    <td >Project Type </td>
    <td >&nbsp;&nbsp;:</td>
    <td ><?=$details->short_code?> - <?=$details->prjtype_name?></td>
  </tr>
  <tr>
    <td >Number of floors</td>
    <td >&nbsp;&nbsp;:</td>
    <td ><?=$details->num_of_floors?></td>
  </tr>
  <tr>
    <td >Total Extend </td>
    <td >&nbsp;&nbsp;:</td>
    <td ><?=$details->tot_ext?>(ft&#178;)</td>
  </tr>
  <tr>
    <td >Description </td>
    <td >&nbsp;&nbsp;:</td>
    <td ><?=$details->description?></td>

  </tr>
</table>

</div>
</div>
<div class="allimg">
<center>
<?
     $nmbr = 1;
     if($designtypeimgs){
        ?>
        <input type="hidden" name="imgcount" id="imgcount" value="<?=sizeof($designtypeimgs)?>">
        <?

        $prvsimgnamearr = array();
        $imgnames = '';
        $i=1;
        foreach($designtypeimgs as $dtimg){
            ?>

         <span id="oldfiles<?=$i?>"><a href="<?=base_url()?>uploads/design_type/<?=$dtimg->designtype_image?>"><img src="<?=base_url()?>uploads/design_type/<?=$dtimg->designtype_image?>" ></a>

            <?
            $nmbr =$nmbr+1;
            $imgnames = $imgnames.",".$dtimg->designtype_image;
            array_push($prvsimgnamearr,$dtimg->designtype_image);

            $i++;
        }
     }else{
        $imgnames = '';
     }
     ?>
   </center>
 </div>
</div>
<br /><br />
<div id="floordata">
  <? if($floors){?>

  <?  $divid=0;
    foreach ($floors as $key => $fl) {?>
      <div class="eachfloor">
      <h4><?=ucwords($fl->floor_name)?> - &nbsp;&nbsp;:&nbsp;&nbsp; Total Floor Extend : <?=$fl->tot_ext?>(ft&#178;)</h4>
      <table class="table floortable">
        <tr>
          <th><center><i class="fa fa-bed roomicon" aria-hidden="true"></i></center></th>
          <th><center><i class="fa fa-bath roomicon" aria-hidden="true"></i></center></th>

        </tr>
        <tr>
          <th><center>Number of Bedrooms</center></th>
          <th><center>Number of Bathrooms</center></th>
        <tr>
          <tr>
            <th><center><?=$fl->num_of_bedrooms?></center></th>
            <th><center><?=$fl->num_of_bathrooms?></center></th>
          <tr>
            <!--floor rooms data --->


      </table>


            <div class="floorroomsdiv">
                    <? if($rooms[$fl->floor_id]){?>
                      <table class="table">
                        <tr class="success">
                          <th>Room type</th>
                          <th>Room Width(ft)</th>
                          <th>Room Height(ft)</th>
                          <th>Room Length(ft)</th>
                          <th>Total Extent (ft&#178;)</th>
                          <th>Doors</th>
                          <th>Windows</th>
                        </tr>
                        <?
                      foreach ($rooms[$fl->floor_id] as $key => $roomdata) {?>


                            <th ><h5><?=$roomdata->roomtype_name?></h5></th>

                            <td><?=$roomdata->width?></td>
                            <td><?=$roomdata->height?></td>
                            <td><?=$roomdata->length?></td>
                            <td><?=$roomdata->tot_extent?></td>
                            <td><?=$roomdata->doors?></td>
                            <td><?=$roomdata->windows?></td>
                          </tr>


                    <?  }?>
                    </table>
                    <?
                    }?>
            </div>

            <div class="floorimgrow">
              <center>

                              <?
                                   $nmbr = 1;
                                   if($floorimages[$fl->floor_id]){
                                      ?>
                                      <input type="hidden" name="flimgcount" id="flimgcount" value="<?=sizeof($floorimages[$fl->floor_id])?>">
                                      <?

                                      $flimgnamearr = array();
                                      $flimgnames = '';
                                      $i=1;
                                      foreach($floorimages[$fl->floor_id] as $flimg){
                                          ?>

                                       <span id="floldfiles<?=$i?>"><a href="<?=base_url()?>uploads/floor_img/<?=$flimg->floor_image?>"><img src="<?=base_url()?>uploads/floor_img/<?=$flimg->floor_image?>"  ></a>

                                          <?
                                          $nmbr =$nmbr+1;
                                          $imgnames = $flimgnames.",".$flimg->floor_image;
                                          array_push($flimgnamearr,$flimg->floor_image);

                                          $i++;
                                      }
                                   }else{
                                      $flimgnames = '';
                                   }
                                   ?>
                    </center>
                  </div>
                  </div>
  <?  $divid=$divid+1;}
    }?>
</div>
</div>
<script>
var imagescount = $('#imgcount').val();
    console.log(imagescount)
    console.log(parseInt(imagescount)+1)
    var newcount = parseInt(imagescount)+1;

    for (i = 1; i < newcount; i++) {
        console.log('oldfiles'+i)
        document.getElementById('oldfiles'+i).onclick = function(event){
        event = event || window.event;
        var target = event.target || event.srcElement,
            link = target.src ? target.parentNode : target,
            options = {index: link, event: event},
            links = this.getElementsByTagName('a');
        blueimp.Gallery(links, options);
        };
    }

var flimagescount = $('#flimgcount').val();
        console.log(flimagescount)
        console.log(parseInt(flimagescount)+1)
        var flnewcount = parseInt(flimagescount)+1;

        for (i = 1; i < flnewcount; i++) {
            console.log('floldfiles'+i)
            document.getElementById('floldfiles'+i).onclick = function(event){
            event = event || window.event;
            var target = event.target || event.srcElement,
                link = target.src ? target.parentNode : target,
                options = {index: link, event: event},
                links = this.getElementsByTagName('a');
            blueimp.Gallery(links, options);
            };
        }


</script>
