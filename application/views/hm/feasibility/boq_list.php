<link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">
<script type="text/javascript">

   function view_boq_unit_budget(id){
      //alert(prjid+" "+lotid)
        var str = id;
		var temp = new Array();
		// this will return an array with strings "1", "2", etc.
		temp = str.split("_");


      $('#popupform').delay(1).fadeIn(600);
	  $( "#popupform" ).load( "<?=base_url()?>hm/feasibility/get_boq_unit_lists/"+temp[0]+"/"+temp[1]+"/"+temp[2]+"/1/"+temp[3]);
	  console.log("<?=base_url()?>hm/feasibility/get_boq_unit_lists/"+temp[0]+"/"+temp[1]+"/"+temp[2]+"/1/"+temp[3])
   }

   function update_boqunit(id){
   	  //alert(prjid+" "+lotid)
        var str = id;
		var temp = new Array();
		// this will return an array with strings "1", "2", etc.
		temp = str.split("_");


      $('#popupform').delay(1).fadeIn(600);
	  $( "#popupform" ).load( "<?=base_url()?>hm/feasibility/get_boq_unit_lists/"+temp[0]+"/"+temp[1]+"/"+temp[2]+"/2/"+temp[3]);
	  console.log("<?=base_url()?>hm/feasibility/get_boq_unit_lists/"+temp[0]+"/"+temp[1]+"/"+temp[2]+"/2/"+temp[3])
   }

   function update_material(id){
     //alert(prjid+" "+lotid)
       var str = id;
  var temp = new Array();
  // this will return an array with strings "1", "2", etc.
  temp = str.split("_");


     $('#popupform').delay(1).fadeIn(600);
  //$( "#popupform" ).load( "<?=base_url()?>hm/feasibility/get_boqunit_mat_popup/"+temp[0]+"/"+temp[1]+"/"+temp[2]+"/2/"+temp[3]);
  window.open( "<?=base_url()?>hm/feasibility/get_boq_unit_mat/"+temp[0]+"/"+temp[1]+"/"+temp[3],'_self');
  console.log("<?=base_url()?>hm/feasibility/get_boq_unit_mat/"+temp[0]+"/"+temp[1]+"/"+temp[2]+"/2/"+temp[3])

   }
function update_boq_items(id){
     //alert(prjid+" "+lotid)
       var str = id;
  var temp = new Array();
  // this will return an array with strings "1", "2", etc.
  temp = str.split("_");

//alert("<?=base_url()?>hm/feasibility/update_boq_items/"+temp[0]+"/"+temp[1]+"/"+temp[2]+"/2/"+temp[3])
     $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>hm/feasibility/update_boq_items/"+temp[0]+"/"+temp[1]+"/"+temp[2]+"/2/"+temp[3]);
 
   }
   
</script>

 <? $this->load->view("includes/flashmessage");?>
 <!-- upload process form -->
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                        <div class="row">
                          <form data-toggle="validator" method="post" action="<?=base_url()?>hm/feasibility/upload_unitboq_excel" id="mytestform" enctype="multipart/form-data">
                          <div class="form-title">
                            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">+</button>&nbsp;&nbsp; Upload BOQ
                          </div>
                        <div id="demo" class="collapse">
                          <div class="col-md-6 validation-grids " data-example-id="basic-forms">
              <div class="form-body">

                  <label>Unit / Lot</label>
                  <div class="form-group">
                    <select class="form-control" name="lotid" id="lotid" required="required">
                      <option value="">Select Lot</option>
                      <? if($boqnotdesignunits){
                       foreach ($boqnotdesignunits as $bntounit){?>
                      <option data-designid="<?=$bntounit->design_id?>" value="<?=$bntounit->lot_id?>"><?=$bntounit->lot_number?></option>
                      <? }
                        }
                      ?>
                    </select>

                  </div>
                  <input type="hidden" name="designids" id="designids">
                  <input type="hidden" name="prjid" value="<?=$prj_id?>">
                </div>
              </div>
              <div class="col-md-6 validation-grids " data-example-id="basic-forms">
                <div class="form-body">
                        <span id="addfiles" class="btn btn-success fileinput-button" style="width:25%;">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Select BOQ Excel</span>
                            <!-- The file input field used as target for the file upload widget -->
                            <input type="file" name="uploadFile" value="" required="required" />
                        </span>
                        <p id="filenems"></p>
                <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                        </div>
                      </div>
              </div>

            </div>
              </form>
                        </div>
                    </div>
            <!-- upload process form -->
<table class="table">
                          <thead>
                            <tr>
                              <th></th>
                              <th>Project</th>

                              <th></th>
                            </tr>
                          </thead>
                      <? if($boqlotlist){$c=0;
                          foreach($boqlotlist as $bll){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                            <th scope="row"><?=$c?></th>
                            <td><?=$bll->project_code ?> - <?=$bll->project_name ?>  -> Unit <?=$bll->lot_number?></td>
                            <?
                            $prj_name=$bll->project_name;?>

                            <td align="right"><div id="checherflag">
                            <a  href="javascript:update_material('<?=$bll->prj_id?>_<?=$bll->lot_id ?>_<?=$bll->numof_units ?>_<?=$bll->design_id ?>')" title="View Material"><i class="fa fa-cubes nav_icon icon_red"></i></a>

    				<a  href="javascript:update_boq_items('<?=$bll->prj_id?>_<?=$bll->lot_id ?>_<?=$bll->numof_units ?>_<?=$bll->design_id ?>')" title="Update_items"><i class="fa fa-connectdevelop nav_icon purple-a100"></i></a>

                        <a  href="javascript:view_boq_unit_budget('<?=$bll->prj_id?>_<?=$bll->lot_id ?>_<?=$bll->numof_units ?>_<?=$bll->design_id ?>')" title="Boq Unit View"><i class="fa fa-eye nav_icon icon_green"></i></a>
                        <a  href="javascript:update_boqunit('<?=$bll->prj_id?>_<?=$bll->lot_id ?>_<?=$bll->numof_units ?>_<?=$bll->design_id ?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a></td>
                         </tr>

                                <? }} ?>
                          </tbody></table>
<script type="text/javascript">
                    $(function(){

                      $('#lotid').change(function(){
                        $('#designids').val("");
                        var designid = $(this).find(':selected').data("designid");
                        $('#designids').val(designid);
                      });

                      $('input[type="file"]').change(function(e){
                        $('#filenems').html("");
                        var fileName = e.target.files[0].name;
                        $('#filenems').append(fileName);
                      });

                    });
</script>
