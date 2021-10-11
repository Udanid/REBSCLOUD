<span class="red">**</span> Only 'gif | jpg | png | pdf ' types are allowed.</br>
             <? foreach($doctypes as $docraw){?>

<div class="form-group has-feedback" ><label for="exampleInputName2"><b><?=$docraw->document_name?></b></label>

  <? if(isset($submitted_doc_list[$docraw->doctype_id]->document)){?>
  <table class="table"><tr><td>
    <a href="<?=base_url()?>/uploads/customer_docs/<?=$submitted_doc_list[$docraw->doctype_id]->document?>" target="_blank"><?=$submitted_doc_list[$docraw->doctype_id]->document?></a>
  </td>
  <td>
    <?if(check_access('delete_cus_docs')){?>
    <a  href="javascript:call_delete('<?=$submitted_doc_list[$docraw->doctype_id]->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
    <?}?>
    <a href="<?=base_url()?>/uploads/customer_docs/<?=$submitted_doc_list[$docraw->doctype_id]->document?>" target="_blank" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>
    <a href="javascript:view_print('<?=base_url()?>/uploads/customer_docs/<?=$submitted_doc_list[$docraw->doctype_id]->document?>')"><i class="fa fa-print nav_icon icon_green"></i></a>
  </td></tr></table>
</div>

  <? }else{?>
           <input type="file" class="form-control" id="document<?=$docraw->doctype_id?>" name="document<?=$docraw->doctype_id?>"   value="" placeholder="Project Commence on"   ><span class="glyphicon form-control-feedback" aria-hidden="true"></span>


</div>
<? }}?>
