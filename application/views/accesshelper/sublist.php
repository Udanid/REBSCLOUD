 
<script type="text/javascript">

function update_oreder_key_sub(key,mainid)
{
	
	 // alert(mainid)
	  if(key!='' &  mainid!=''){
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accesshelper/accesshelper/update_order_key_sub';?>',
            data: {main_id: mainid,  key:key },
            success: function(data) {
                if (data) {
				//	 alert(data);
					//alert("<?=base_url()?>accesshelper/accesshelper/mainmenulist/")

					 	$( "#contollerlist" ).load( "<?=base_url()?>accesshelper/accesshelper/load_controller/"+main_id);
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				
            }
        });
	
	  }
	  else
	  {
		  document.getElementById("checkflagmessage").innerHTML='Please Fill The name and module'; 
					 $('#flagchertbtn').click();
	  }
}
</script> <table class="table"> <thead> <tr>  <th>ID</th><th>Menu</th><th>Url</th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->sub_id ?></th> <td><?=$row->sub_name ?></td> <td><?=$row->url ?></td>
                        <td><input type="number" value="<?=$row->order_key?>"  name="orderkeysub<?=$row->sub_id?>" id="orderkeysub<?=$row->sub_id?>" onChange="update_oreder_key_sub(this.value,'<?=$row->sub_id?>')"></td>
                        <td align="right"><div id="checherflag">
                        
                        <a  href="javascript:call_delete_submenu('<?=$row->sub_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                  
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table> 