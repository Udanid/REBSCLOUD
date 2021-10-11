
  <script type="text/javascript">
  function checked_item_mainmenu(obj,menu_id)
{

	var userid=document.getElementById("user_type").value;
	if(obj.checked){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/add_user_controller';?>',
            data: {menu_id: menu_id, userid:userid, type:'mainmenu'},
            success: function(data) {
                if (data) {
					// alert(data);
					  var elem = document.getElementById("mainmenu"+menu_id)
						elem.style.color = "#3498db"
					 /// document.getElementById("checkflagmessage").innerHTML=data;
					 //$('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }

            }
        });
	}
	else{
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/delete_user_controller';?>',
            data: {menu_id: menu_id, userid:userid, type:'mainmenu'},
            success: function(data) {
                if (data) {
					  var elem = document.getElementById("mainmenu"+menu_id)
						elem.style.color = ""

                }

            }
        });
	}
}
  function checked_item_submenu(obj,menu_id)
{

	var userid=document.getElementById("user_type").value;
	if(obj.checked){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/add_user_controller';?>',
            data: {menu_id: menu_id, userid:userid, type:'submenu'},
            success: function(data) {
                if (data) {
					// alert(data);
					  var elem = document.getElementById("submenu"+menu_id)
						elem.style.color = "#3498db"
					 /// document.getElementById("checkflagmessage").innerHTML=data;
					 //$('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }

            }
        });
	}
	else{
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/delete_user_controller';?>',
            data: {menu_id: menu_id, userid:userid, type:'submenu'},
            success: function(data) {
                if (data) {
					  var elem = document.getElementById("submenu"+menu_id)
						elem.style.color = ""

                }

            }
        });
	}
}
  function checked_item_controller(obj,menu_id)
{

	var userid=document.getElementById("user_type").value;
	if(obj.checked){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/add_user_controller';?>',
            data: {menu_id: menu_id, userid:userid, type:'controller'},
            success: function(data) {
                if (data) {
					// alert(data);
					  var elem = document.getElementById("controller"+menu_id)
						elem.style.color = "#3498db"
					 /// document.getElementById("checkflagmessage").innerHTML=data;
					 //$('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }

            }
        });
	}
	else{
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/delete_user_controller';?>',
            data: {menu_id: menu_id, userid:userid, type:'controller'},
            success: function(data) {
                if (data) {
					  var elem = document.getElementById("controller"+menu_id)
						elem.style.color = ""

                }

            }
        });
	}
}

  </script>

  <input type="hidden" name="user_type" id="user_type"  value="<?=$user_type?>"/><table class="table">
                      <? if($mainmenu){$c=0;
                          foreach($mainmenu as $row){?>

                        <thead><tr class="info" id="mainmenu<?=$row->main_id?>">
                        <th scope="row" colspan="4"><?=$row->menu_name ?></th> <th> <input type="checkbox" <? if($mainactive[$row->main_id]){?> checked<? }?>  onClick="checked_item_mainmenu(this,'<?=$row->main_id?>')" value="YES" name="main_mcheck<?=$row->main_id?>" id="main_mcheck<?=$row->main_id?>"></th>

                         </tr>  </thead>

                         <? if($maincontroller[$row->main_id]){?>
                          <tr><td> <table><tr >
						<?	 foreach($maincontroller[$row->main_id] as $mcontraw){
							 ?>
                        <td id="controller<?=$mcontraw->controle_id?>"><?=$mcontraw->controller_name?>
                        &nbsp;&nbsp; <input type="checkbox"  onClick="checked_item_controller(this,'<?=$mcontraw->controle_id?>')"  <? if(get_controller_active($mcontraw->controle_id,$user_type)){?> checked<? }?>

                         value="YES" name="controlercheck<?=$mcontraw->controle_id?>" id="controlercheck<?=$mcontraw->controle_id?>">
                        </td>
                         <? } ?>
                         </tr></table></td></tr>
                         <? }?>
                         <? if($sublist[$row->main_id]){?>
                          <tr><td> <table class="table table-bordered"  >
						<?	 foreach($sublist[$row->main_id] as $subraw){
							 ?>
                       <tr class="active"  id="submenu<?=$subraw->sub_id?>"> <td><?=$subraw->sub_name?></td>
                       <td width="50"><input type="checkbox" <? if($subactive[$subraw->sub_id]){?> checked<? }?>  onClick="checked_item_submenu(this,'<?=$subraw->sub_id?>')" value="YES" name="main_scheck<?=$subraw->sub_id?>" id="main_scheck<?=$subraw->sub_id?>"></td></tr>

                        <? if($subcontroller[$subraw->sub_id]){?>
                          <tr><td> <table  class="table table-bordered"><tr>
						<?
            $i=0;
             foreach($subcontroller[$subraw->sub_id] as $smcontraw){
               $i++;
               if($i==6){
                 echo "</tr><tr>";
               }
							 ?>
                        <td id="controller<?=$smcontraw->controle_id?>"><?=$smcontraw->controller_name?>
                        &nbsp;&nbsp; <input type="checkbox"  onClick="checked_item_controller(this,'<?=$smcontraw->controle_id?>')" value="YES" name="controlercheck<?=$smcontraw->controle_id?>" <? if(get_controller_active($smcontraw->controle_id,$user_type)){?> checked<? }?> id="controlercheck<?=$smcontraw->controle_id?>">

                        </td>
                         <? } ?>
                         </tr></table></td></tr>
                         <? }?>


                         <? } ?>
                         </table></td></tr>
                         <? }?>

                                <? }} ?>
                        </table>
