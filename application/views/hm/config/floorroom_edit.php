<?
 if($floorroomslist){
 	foreach($floorroomslist as $frl){
 		?>
 		<h4>Floor Room Details of <?=$frl->roomtype_name?> >> <?=$frl->floor_name?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$frl->room_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
  <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/floorrooms_update" id="floorroom_upd_form">
						<div class="col-md-8 validation-grids widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h5  style="color:#000">Floor Room Information :</h5>
							</div>

							
							<div class="form-body">
								    <input type="hidden" name="eflrroomid" id="eflrroomid" value="<?=$frl->room_id?>">
								    <label>Room Type</label>
                    <div class="form-group">
                    <select id="froomtypes" name="froomtypes" class="form-control" required>
                      <option value="">Select Room Type</option>
                      <?
                      if($roomtypelist)
                      {
                       foreach($roomtypelist as $rtyp){
                       	if($rtyp->roomtype_id==$frl->roomtype_id){
                        ?>
                         <option value="<?=$rtyp->roomtype_id;?>" selected><?=$rtyp->roomtype_name;?></option>
                       <?
                       	}else{
                       ?>
                         <option value="<?=$rtyp->roomtype_id;?>"><?=$rtyp->roomtype_name;?></option>
                       <?
                        }
                       }
                      } 
                      ?>
                      
                    </select>
                    </div>

                    <label>Floor Type</label>
                    <div class="form-group">
                    <select id="fflortype" name="fflortype" class="form-control" required>
                      <option value="">Select Floor Type</option>
                      <?
                      if($floorlist)
                      {
                       foreach($floorlist as $flrlst){
                       	if($flrlst->floor_id==$frl->floor_id){
                       	?>
                         <option value="<?=$flrlst->floor_id;?>" selected><?=$flrlst->floor_name;?></option>
                       <?
                       	}else{
                       ?>
                         <option value="<?=$flrlst->floor_id;?>"><?=$flrlst->floor_name;?></option>
                       <?
                        }
                       }
                      } 
                      ?>
                      
                    </select>
                    </div>

                    <label>Width</label>
                    <div class="form-group">
                    <input type="text" name="fwidth" id="fwidth" class="form-control" value="<?=$frl->width?>" required>
                    </div>

                    <label>Height</label>
                    <div class="form-group">
                    <input type="text" name="fheight" id="fheight" class="form-control" value="<?=$frl->height?>" required>
                    </div>

                    <label>Length</label>
                    <div class="form-group">
                    <input type="text" name="flenght" id="flenght" class="form-control" value="<?=$frl->length?>" required>
                    </div>

                    <label>Total Extend</label>
                    <div class="form-group">
                    <input type="text" name="ftotext" id="ftotext" class="form-control" value="<?=$frl->tot_extent?>" required>
                    </div>
                    
                    <label>Doors</label>
                    <div class="form-group">
                    <input type="text" name="fdoors" id="fdoors" class="form-control" value="<?=$frl->doors?>" required>
                    </div>

                    <label>Windows</label>
                    <div class="form-group">
                    <input type="text" name="fwindows" id="fwindows" class="form-control" value="<?=$frl->windows?>" required>
                    </div>

                    <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                    </div>
							 
							</div>
						</div>
					</form></div>
<br /><br /><br /><br /></div>
 		<?
 	}
 }
 ?>
 
<script src="<?=base_url()?>media/js/jquery-1.11.1.min.js"></script>
<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(function(){
		//validate all fields
      $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
      $("#floorroom_upd_form").validate({
            rules: {
        froomtypes: {
              required: true
           },
        fflortype: {
              required: true
           },
        fwidth: {
              required: true,
              number: true
            },
        fheight: {
             required: true,
             number: true
            },
        flenght: {
             required: true,
             number: true
            },   
       ftotext: {
             required: true,
             number: true
            },
        fdoors: {
             required: true,
             number: true
            },    
        fwindows: {
             required: true,
             number: true
            }         
      },
        messages: {
            froomtypes:{
            	required: "Required",
            }, 
            fflortype: {
            	required: "Required",
            }, 

            fwidth: {
            	required: "Required",
            	
            }, 
            fheight: {
            	required: "Required",
            	
            }, 

            flenght: {
            	required: "Required",
            	
            } ,
            ftotext: {
              required: "Required",
              
            }, 
            fdoors: {
              required: "Required",
              
            }, 
            fwindows: {
              required: "Required",
              
            } 

        }
});
	});
</script>