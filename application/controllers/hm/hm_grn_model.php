<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//model create by terance perera
//date:2019-12-02

class Hm_grn_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_not_processed_po(){
    	$this->db->where('status','CONFIRMED');
    	$query=$this->db->get('hm_pomain');
          if(count($query->result())>0){
          return $query->result();  
          }else{
              return false;
          }
    	
    }

    function get_po_items($id,$prjid,$lotid){
    	$this->db->select('*');
    	$this->db->from('hm_podata as hmpd');
    	$this->db->join('hm_config_material as hmcm','hmpd.mat_id=hmcm.mat_id');
    	$this->db->join('hm_config_messuretype as hmcmt','hmcm.mt_id=hmcmt.mt_id');
    	$this->db->where('hmpd.po_id',$id);

        if($prjid){
           $this->db->where('hmpd.prj_id',$prjid);
        }

        if($lotid){
           $this->db->where('hmpd.lot_id',$lotid);
        }

    	$query=$this->db->get();
        if(count($query->result())>0){
    	return $query->result();
        }else{
         return false;   
        }
    }

    /*function upd_podata($updarrqty,$pitm){
        $this->db->where('po_itemid',$pitm);
        return $this->db->update('hm_podata',$updarrqty);
    }*/



    function upd_pomain_tbl($updpomainarr,$poid){
        $this->db->where('poid',$poid);
        $this->db->update('hm_pomain',$updpomainarr);
        if ($this->db->affected_rows() > 0) {
          return true;
        }else{
          return false;  
        }    
    }

    function get_pending_podatacount($poid){
        $this->db->select('count(po_itemid) as pendingcount');
        $this->db->from('hm_podata as hmpd');
        $this->db->where('po_id',$poid);
        $this->db->where('status','PENDING');

        $query=$this->db->get();
        if(count($query->result())>0){
           return $query->row(); 
       }else{
           return false;
       }
        
    }

    function insert_grnmain_data($grnmainarr){
        $this->db->insert('hm_grnmain',$grnmainarr);
        if ($this->db->affected_rows() > 0) {
          return $this->db->insert_id();
        }else{
          return false;    
        }
    }

    function insert_stockbatch_data($stockbatcharr){
        $this->db->insert('hm_stockbatch',$stockbatcharr);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

   /* function get_grn_list($pagination_counter,$page_count,$stts){
        $this->db->select('*');
        $this->db->from('hm_grnmain');
        if($stts!==""){
          $this->db->where('status','PENDING');
        }
        $this->db->limit($pagination_counter, $page_count);
        $query=$this->db->get();
        return $query->result();
    } */

    function get_grn_list($pagination_counter,$page_count,$stts){
        $this->db->select('*,hm_grnmain.status as grnstts,hm_po_request.prj_id as prjid,hm_po_request.request_by as po_requestby,hm_po_request.confirmed_date as poconfirmdate,hm_po_request.confirm_by as poconfirmby,hm_po_request.poid as prpoid,hm_stockbatch.qty as grnqty,hm_pomain.create_date pocreatedate,hm_pomain.create_by as pocreateby,hm_pomain.confirmed_by as poconfirmuser,cm_supplierms.first_name,cm_supplierms.last_name,hm_projectms.project_name,
          poreq.initial as poreqiniby,poreq.surname as poreqsurby,
          poconf.initial as poconfiniby,poconf.surname as poconfsurby,
          grnrec.initial as grnreqiniby,grnrec.surname as grnreqsurby,
          grnconf.initial as grnconfiniby,grnconf.surname as grnconfsurby
          ');
        $this->db->from('hm_grnmain');
        $this->db->join('hm_stockbatch','hm_grnmain.grn_id=hm_stockbatch.grn_id');
        $this->db->join('hm_podata','hm_stockbatch.po_itemid=hm_podata.po_itemid');
        $this->db->join('hm_pomain','hm_podata.po_id=hm_pomain.poid');
        $this->db->join('hm_po_request','hm_pomain.poid=hm_po_request.poid');
        $this->db->join('cm_supplierms','hm_pomain.sup_id=cm_supplierms.sup_code');
        $this->db->join('hm_projectms','hm_podata.prj_id=hm_projectms.prj_id');
        $this->db->join('hr_empmastr as poreq','hm_po_request.request_by=poreq.id');
        $this->db->join('hr_empmastr as poconf','hm_po_request.confirm_by=poconf.id');
        $this->db->join('hr_empmastr as grnrec','hm_grnmain.recieved_by=grnrec.id','left');
        $this->db->join('hr_empmastr as grnconf','hm_grnmain.confirmed_by=grnconf.id','left');
        if($stts!==""){
          $this->db->where('hm_grnmain.status','PENDING');
        }
        $this->db->group_by('hm_grnmain.grn_id');
        $this->db->order_by('hm_grnmain.grn_id','DESC');
        $this->db->limit($pagination_counter, $page_count);
        $query=$this->db->get();
        if(count($query->result())>0){
            return $query->result();
        }else{
            return false;
        }
        
    }

    function get_grn_items($id){
       $this->db->select('*,hmpd.qty as podataqty,hmsb.qty as stockbthqty');
       $this->db->from('hm_stockbatch as hmsb');
       $this->db->join('hm_podata as hmpd','hmsb.po_itemid=hmpd.po_itemid');
       $this->db->join('hm_config_material as hmcm','hmpd.mat_id=hmcm.mat_id');
       $this->db->where('hmsb.grn_id',$id);

       $query = $this->db->get();
       if(count($query->result())>0){
        return $query->result();
       }else{
        return false;
       }
       
    }

    function upd_batch_stock($batchstockupdarr,$batchid){
       $this->db->where('batch_id',$batchid);
       $this->db->update('hm_stockbatch',$batchstockupdarr);
       if ($this->db->affected_rows() > 0) {
         return true;
       }else{
         return false;
       }
    }

    function upd_podata($podataupdarr,$poitemid){
       $this->db->where('po_itemid',$poitemid);
       $this->db->update('hm_podata',$podataupdarr);
       if ($this->db->affected_rows() > 0) {
        return true;
       }else{
        return false;
       }
    }

    function upd_pomain($pomainarr,$poid){
       $this->db->where('poids',$poid);
       $this->db->update('hm_pomain',$pomainarr);
       if ($this->db->affected_rows() > 0) {
        return true;
       }else{
        return false;
       }
    }

    function update_grn_main($updgrnmainarr,$id){
       $this->db->where('grn_id',$id);
       $this->db->update('hm_grnmain',$updgrnmainarr);
       if ($this->db->affected_rows() > 0) {
        return true;
       }else{
        return false;
       }
    }

    /*function get_grn_data($id){
        $this->db->select('*,hm_podata.rec_qty as podatareq_qty,hm_stockbatch.qty as batchqty,hm_podata.po_itemid as podata_itemid,hm_podata.mat_id as pomatid');
        $this->db->from('hm_grnmain');
        $this->db->join('hm_stockbatch','hm_grnmain.grn_id=hm_stockbatch.grn_id');
        $this->db->join('hm_podata','hm_stockbatch.po_itemid=hm_podata.po_itemid');
        $this->db->join('hm_po_request','hm_podata.po_id=hm_po_request.poid');
        $this->db->where('hm_grnmain.grn_id',$id);
        $this->db->group_by('hm_stockbatch.batch_id');

        $query=$this->db->get();
        return $query->result();

    } */

    function get_grn_data($id){
        $this->db->select('*,hm_podata.rec_qty as podatareq_qty,hm_stockbatch.qty as batchqty,hm_podata.po_itemid as podata_itemid,hm_podata.mat_id as pomatid,hm_grnmain.lot_id as grnlotid,hm_grnmain.prj_id as grnprjid,hm_podata.po_id as p_order_id');
        $this->db->from('hm_grnmain');
        $this->db->join('hm_stockbatch','hm_grnmain.grn_id=hm_stockbatch.grn_id');
        $this->db->join('hm_podata','hm_stockbatch.po_itemid=hm_podata.po_itemid');
        $this->db->where('hm_grnmain.grn_id',$id);
        $this->db->group_by('hm_stockbatch.batch_id');

        $query=$this->db->get();
        if(count($query->result())>0){
            return $query->result();
        }else{
            return false;
        }
        
    }

    function insert_mainstock($insertstockmainarr){
        $this->db->insert('hm_mainstock',$insertstockmainarr);
        if ($this->db->affected_rows() > 0) {
         return $this->db->insert_id();
        }else{
        return false;
        }
    }

    function insert_site_stock($sitestockarr){
        $this->db->insert('hm_sitestock',$sitestockarr);
        if ($this->db->affected_rows() > 0) {
        return true;
        }else{
        return false;
        }
    }

    function get_last_batchid(){
        $this->db->select('batch_code');
        $this->db->from('hm_stockbatch');
        $this->db->order_by('batch_id','desc');
        $this->db->limit(1);

        $query=$this->db->get();
        if(count($query->result())>0){
          return $query->row();  
        }else{
          return false;
        }
        

    }

    /*function get_project_list_all(){
        $this->db->select('prj_id,project_name,project_code');
        $this->db->where('status <> ','COMPLETE');
        $query=$this->db->get('hm_projectms');
        return $query->result();

    } */

    function get_project_list_all(){
        $this->db->select('prj_id,project_name,project_code');
        $this->db->where('status','CONFIRMED');
        $query=$this->db->get('hm_projectms');
        if(count($query->result())>0){
        return $query->result();
        }else{
        return false;    
        }
    }

    function get_meterial_list_for_transfer($whr,$prjid){
        $this->db->select('hm_config_material.mat_id,hm_config_material.mat_name,sum(hm_sitestock.rcv_qty-hm_sitestock.ussed_qty) as transferbalqty');
        $this->db->from('hm_sitestock');
        $this->db->join('hm_config_material','hm_sitestock.mat_id=hm_config_material.mat_id');
        $this->db->group_by('hm_sitestock.mat_id');

        if($whr){
         $this->db->where('hm_sitestock.mat_id',$whr);
        }

        if($prjid){
         $this->db->where('hm_sitestock.prj_id',$prjid);
        }

        $this->db->where('(hm_sitestock.rcv_qty-hm_sitestock.ussed_qty)>',0);

        $query = $this->db->get();
        if(count($query->result())>0){
        return $query->result();
        }else{
        return false;    
        }
    }

    function get_met_rel_sitestocks($prjid,$metid){

      $where = "SELECT *,((hm_sitestock.rcv_qty-hm_sitestock.ussed_qty)-hm_sitestock.trans_qty) as balqty,hm_sitestock.site_stockid,hm_sitestock.price as sitestockunitprice FROM
hm_sitestock,hm_mainstock,hm_stockbatch,hm_grnmain
WHERE
hm_sitestock.stock_id=hm_mainstock.stock_id AND hm_mainstock.batch_id=hm_stockbatch.batch_id AND hm_stockbatch.grn_id=hm_grnmain.grn_id AND hm_sitestock.mat_id='$metid' AND hm_sitestock.prj_id='$prjid' AND ((hm_sitestock.rcv_qty-hm_sitestock.ussed_qty)-hm_sitestock.trans_qty)>0";



    $query = $this->db->query($where);
    //$query = $this->db->get();
    
    return $query->result();
   

    }

    function update_sitestock($transupdsitestock,$sitestock_id){
        $this->db->where('site_stockid',$sitestock_id);
        $this->db->update('hm_sitestock',$transupdsitestock);
        if ($this->db->affected_rows() > 0) {
           return TRUE;
        }else{
            return false;
        }
    }

    function insert_transfer_stock($insertstktransarr){
        $this->db->insert('hm_stockransfer',$insertstktransarr);
        if ($this->db->affected_rows() > 0) {
           return TRUE;
        }else{
            return false;
        }
    }

    /*function get_transfered_stocks($pagination_counter,$page_count,$stts){
        $this->db->select('*,hmpms1.project_name as fromprj,hmpms2.project_name as toprj,hmst.status as transtts');
        $this->db->from('hm_stockransfer as hmst');
        $this->db->join('hm_sitestock as hmss','hmst.site_stockid=hmss.site_stockid');
        $this->db->join('hm_mainstock as hmms','hmss.stock_id=hmms.stock_id');
        $this->db->join('hm_stockbatch as hmsb','hmms.batch_id=hmsb.batch_id');
        $this->db->join('hm_grnmain as hmgm','hmsb.grn_id=hmgm.grn_id');
        $this->db->join('hm_projectms as hmpms1','hmst.from_prj_id=hmpms1.prj_id');
        $this->db->join('hm_projectms as hmpms2','hmst.to_prj_id=hmpms2.prj_id');

        $this->db->limit($pagination_counter, $page_count);

        $query = $this->db->get();
        return $query->result();
    } */

    function get_transfered_stocks($pagination_counter,$page_count,$stts){
      $this->db->select('frmprj.project_name as frmprjname,toprj.project_name as toprjname,hm_config_material.mat_name,hm_sitestock.trans_qty,hm_stockransfer.transfer_id,hm_stockransfer.trn_qty,hm_stockransfer.status,hm_stockransfer.from_prj_id,hm_stockransfer.to_prj_id,hm_stockransfer.site_stockid,hm_stockbatch.grn_id,hm_stockransfer.confirm_date as transconfdate,hm_stockransfer.confrim_by as transconfby,hr_empmastr.initial,hr_empmastr.surname');
      $this->db->from('hm_stockransfer');
      $this->db->join('hm_sitestock','hm_stockransfer.site_stockid=hm_sitestock.site_stockid');
      $this->db->join('hm_mainstock','hm_sitestock.stock_id=hm_mainstock.stock_id');
      $this->db->join('hm_stockbatch','hm_mainstock.batch_id=hm_stockbatch.batch_id');
      $this->db->join('hm_config_material','hm_sitestock.mat_id=hm_config_material.mat_id');  
      $this->db->join('hm_projectms as frmprj','hm_stockransfer.from_prj_id=frmprj.prj_id');
      $this->db->join('hm_projectms as toprj','hm_stockransfer.to_prj_id=toprj.prj_id');
      $this->db->join('hr_empmastr','hm_stockransfer.confrim_by=hr_empmastr.id');

      $this->db->where('hm_stockransfer.from_prj_id <>',0);
      if($stts==1){
        $this->db->where('hm_stockransfer.status','PENDING');
      }  
      $this->db->limit($pagination_counter, $page_count);
      $query = $this->db->get();
      if(count($query->result())>0){
      return $query->result();
      }else{
        return false;
      }
    }

    function upd_stocktrans_tbl($transstts,$trnid){
        $this->db->where('transfer_id',$trnid);
        $this->db->update('hm_stockransfer',$transstts);
        if ($this->db->affected_rows() > 0) {
           return TRUE;
        }else{
            return false;
        }
    }

    function upd_site_stock_qty($updsitestocktransstock,$sitestockid){
        $this->db->where('site_stockid',$sitestockid);
        $this->db->update('hm_sitestock',$updsitestocktransstock);
        if ($this->db->affected_rows() > 0) {
           return TRUE;
        }else{
            return false;
        }
    }

    function get_project_rel_lot($prjid){
        $this->db->select('*');
        $this->db->from('hm_prjaclotdata');
        $this->db->where('prj_id',$prjid);
        $query = $this->db->get();
        if(count($query->result())>0){
            return $query->result();
        }else{
            return false;
        }
    }

     function get_po_list($prjid,$lotid){
        $this->db->where('hm_pomain.status','CONFIRMED');
        if($prjid){
           $this->db->where('hm_podata.prj_id',$prjid);
        }

        if($lotid){
           $this->db->where('hm_podata.lot_id',$lotid);
        }

        $this->db->join('hm_podata','hm_pomain.poid=hm_podata.po_id');
        $this->db->group_by('hm_podata.po_id');
        $query=$this->db->get('hm_pomain');
        if(count($query->result())>0){
            return $query->result();
        }else{
            return false;
        }
    }

   /* function get_main_stock(){
        $this->db->select('*,sum(rcv_qty) as recqtytotal,sum(ussed_qty) as usdqtytotal');
        $this->db->from('hm_mainstock');
        $this->db->group_by('mat_id');
        $query = $this->db->get();
        return $query->result();
    } */

    function get_batch_rel_stock($mat,$pagination_counter,$page_count,$stts){
        $this->db->select('*,hm_podata.buying_price as buyprice,(hm_mainstock.rcv_qty-hm_mainstock.ussed_qty) as balmainstockqty,hm_mainstock.ussed_qty as ussedmainstock,hm_stockbatch.qty as stbatchqty,hm_config_messuretype.mt_name');
        $this->db->from('hm_stockbatch');
        $this->db->join('hm_mainstock','hm_stockbatch.batch_id=hm_mainstock.batch_id');
        $this->db->join('hm_podata','hm_stockbatch.po_itemid=hm_podata.po_itemid');
        $this->db->join('hm_config_material','hm_podata.mat_id=hm_config_material.mat_id');
        $this->db->join('hm_grnmain','hm_stockbatch.grn_id=hm_grnmain.grn_id');
        $this->db->join('hm_config_messuretype','hm_config_material.mt_id=hm_config_messuretype.mt_id');
        $this->db->where('hm_grnmain.status','CONFIRMED');
        if($mat){
          $this->db->where('hm_podata.mat_id',$mat);  
        }
        if($stts==2){
          $this->db->where('(hm_mainstock.rcv_qty-hm_mainstock.ussed_qty) <>',0);
        }
        
        $this->db->limit($pagination_counter, $page_count); 
        
        $query = $this->db->get();
        if(count($query->result())>0){
            return $query->result();
        }else{
            return false;
        }
        
    }

    function get_batch_rel_stock2($mat,$prjstts){
      $this->db->select('*,hm_podata.buying_price as buyprice,(hm_mainstock.rcv_qty-hm_mainstock.ussed_qty) as balmainstockqty,hm_mainstock.ussed_qty as ussedmainstock,hm_stockbatch.qty as stbatchqty,hm_config_messuretype.mt_name');
      $this->db->from('hm_stockbatch');
      $this->db->join('hm_mainstock','hm_stockbatch.batch_id=hm_mainstock.batch_id');
      $this->db->join('hm_podata','hm_stockbatch.po_itemid=hm_podata.po_itemid');
      $this->db->join('hm_config_material','hm_podata.mat_id=hm_config_material.mat_id');
      $this->db->join('hm_grnmain','hm_stockbatch.grn_id=hm_grnmain.grn_id');
      $this->db->join('hm_config_messuretype','hm_config_material.mt_id=hm_config_messuretype.mt_id');
      $this->db->where('hm_grnmain.status','CONFIRMED');
      $this->db->where('hm_podata.mat_id',$mat);
      if($prjstts=='allbatch'){

      }else if($prjstts=='balqtyall'){
        $this->db->where('(hm_mainstock.rcv_qty-hm_mainstock.ussed_qty) <>',0);
      }else{
        
      }
      
          
      $query = $this->db->get();
      if(count($query->result())>0){
      return $query->result();
      }else{
        return false;
      }
  }

   function get_batch_rel_project_materials($mat,$prj){
      $this->db->select('*,rcv_qty as recqtytotal,ussed_qty as usdqtytotal');
      $this->db->from('hm_sitestock');
      $this->db->where('hm_sitestock.mat_id',$mat);
      $this->db->where('hm_sitestock.prj_id',$prj);
          
      $query = $this->db->get();
      if(count($query->result())>0){
        return $query->result();
      }else{
        return false;
      }
   }

    function get_site_stock($prjid){
        $this->db->select('*,sum(rcv_qty) as recqtytotal,sum(ussed_qty) as usdqtytotal');
        $this->db->from('hm_sitestock');
        $this->db->where('prj_id',$prjid);
        $this->db->group_by('mat_id');
        $query = $this->db->get();
        if(count($query->result())>0){
            return $query->result();
        }else{
            return false;
        }
    }

     function project_material_full($matid,$prjid){
        $this->db->select('*');
        $this->db->from('hm_sitestock');
        $this->db->join('hm_stockransfer','hm_sitestock.site_stockid=hm_stockransfer.site_stockid','left');

        if($prjid){
          $this->db->where('prj_id',$prjid);
        }

        $this->db->where('mat_id',$matid);

        $query = $this->db->get();
        if(count($query->result())>0){
        return $query->result();
        }else{
        return false;    
        }
    } 

    /* function project_material_full($matid,$batchid){
        $sql = "SELECT * FROM hm_stockbatch,hm_podata,hm_po_request WHERE hm_stockbatch.po_itemid=hm_podata.po_itemid AND hm_podata.po_id=hm_po_request.poid AND hm_stockbatch.batch_id='$batchid' AND hm_podata.mat_id='$matid'";
        $query = $this->db->query($sql);
        return $query->result();
    } */

    function get_po_request_data($poitemid,$poid){
        $this->db->select('*');
        $this->db->from('hm_po_request');
        $this->db->where('poid',$poid);
        $this->db->where('po_itemid',$poitemid);
        $query=$this->db->get();
        if(count($query->result())>0){
          return $query->row();
        }else{
          return false;
        }

    }

    function updte_po_request_tbl($porequestupdarr,$poitemid,$poid){
        $this->db->where('poid',$poid);
        $this->db->where('po_itemid',$poitemid);
        $this->db->update('hm_po_request',$porequestupdarr);
        if ($this->db->affected_rows() > 0) {
           return TRUE;
        }else{
            return false;
        }
    }

    /*function get_met_related_porequest($id){
        $this->db->select('*');
        $this->db->from('hm_po_request');
        $this->db->where('mat_id',$id);
        // $inarr = array('GRN MAIN',"");
        // $inarr2 = array('DISPATCHED','APPROVED','USED');
        // $this->db->where_in('processType',$inarr);
        // $this->db->where_in('status',$inarr2);
        $this->db->where('(qty-dispatched_qty)>',0);
        $inarr2 = array('USED');
        $this->db->where_in('status',$inarr2);
        $query = $this->db->get();
        return $query->result();
    } */
    
    function get_met_related_porequest($matid,$batchqty){
        //$sql = "SELECT * FROM hm_stockbatch,hm_podata,hm_po_request WHERE hm_stockbatch.po_itemid=hm_podata.po_itemid AND hm_podata.po_id=hm_po_request.poid AND hm_podata.mat_id='$matid' AND hm_po_request.`status`='APPROVED'";

        $sql = "SELECT * FROM hm_po_request WHERE `status`='APPROVED' AND mat_id='$matid' AND qty <= '$batchqty' AND prj_id <> 0";
        $query = $this->db->query($sql);
        return $query->result();
        
    }

/* 2019-12-23 added by terance */

   function add_transfer_stock($stocktransarr){
     $this->db->insert('hm_stockransfer',$stocktransarr);
     if($this->db->affected_rows() > 0){
      return $this->db->insert_id();
     }else{
      return false;   
     }
   }    

/*2019-1219 added by nadee*/
    function add_dispatch($data,$stock_id,$amount,$dispachedqty)
    {
      $this->db->insert('hm_sitestock',$data);
      if($this->db->affected_rows() > 0){
        return $this->db->insert_id();
      }else{
        return false;
      }
      
    }


    function upd_mainstock($stock_id,$amount,$dispachedqty){
            
        $newusedqty = $dispachedqty+$amount;
        $update_data = array('ussed_qty' =>$newusedqty );
        $this->db->where('stock_id',$stock_id);
        $update=$this->db->update('hm_mainstock',$update_data);
        if($this->db->affected_rows() > 0)
        {
          return true;
        }else{
          return false;
        }
      
    }

    function request_update($req_id,$amount,$type,$stktransferid)
    {
      $req_data=$this->get_all_pending_purchaserequestby_id($req_id);
      $new_dispatch=$req_data->dispatched_qty+$amount;
      $new_statues=$req_data->status;
      if($new_dispatch==$req_data->qty){
        $new_statues="DISPATCHED";
      }
      $data = array('dispatched_qty' =>$new_dispatch ,
        'dispatch_date'=>date('Y-m-d'),
        'status'=>$new_statues,
        'processType'=>$type,
        'poid' => $stktransferid
       );
      $this->db->where('req_id',$req_id);
      $update=$this->db->update('hm_po_request',$data);
      if($this->db->affected_rows() > 0)
      {
        return true;
      }else{
        return false;
      }
    }

    function get_all_pending_purchaserequestby_id($req_id)
    {
      $this->db->select('*');
      $this->db->where('req_id',$req_id);
      $query=$this->db->get('hm_po_request');
      if(count($query->result())>0)
      {
        return $query->row();
      }else{
        return false;
      }
    }

    function get_all_pending_purchaserequest($prj_id,$lot_id)
    {
      $this->db->select('*');
      $this->db->where('prj_id',$prj_id);
      if($lot_id)
      {
        $this->db->where('lot_id',$lot_id);
      }
      $this->db->where('status','APPROVED');
      $query=$this->db->get('hm_po_request');
      if(count($query->result())>0)
      {
        return $query->result();
      }else{
        return false;
      }
    }
/*2019-12-19 added by nadee*/

    function get_site_stock_bybatch($id){
        $sql = "SELECT hm_sitestock.prj_id,hm_sitestock.rcv_qty,hm_sitestock.ussed_qty,hm_sitestock.trans_qty,hm_sitestock.transfer FROM hm_sitestock ,hm_mainstock, hm_stockbatch 
WHERE hm_sitestock.stock_id=hm_mainstock.stock_id AND hm_mainstock.batch_id=hm_stockbatch.batch_id AND hm_stockbatch.batch_id='$id'";
        $query = $this->db->query($sql);
        
         return $query->result(); 
      
        
    }

    //2019-12-27 added by terance.
    function get_po_request_by_project($prjid){
      $this->db->select('*');
      $this->db->from('hm_po_request');
      $this->db->where('status','APPROVED');
      if($prjid){
        $this->db->where('prj_id',$prjid);
      }
      $query = $this->db->get();
      if(count($query->result())>0){
        return $query->result();
      }else{
        return false;
      }
    }

    function get_site_stock_available_qtys($matid,$prjid,$recqty){
     $sql = "SELECT hm_projectms.project_name,hm_sitestock.trans_qty,hm_sitestock.site_stockid,hm_sitestock.price as siteprice,hm_sitestock.stock_id,hm_sitestock.mat_id,hm_sitestock.prj_id,(hm_sitestock.rcv_qty-(hm_sitestock.ussed_qty+hm_sitestock.trans_qty)) as balanceqty,hm_stockbatch.batch_code 
      FROM hm_sitestock,hm_mainstock,hm_stockbatch,hm_projectms
      WHERE  hm_sitestock.stock_id=hm_mainstock.stock_id AND hm_sitestock.prj_id=hm_projectms.prj_id AND hm_mainstock.batch_id=hm_stockbatch.batch_id AND (hm_sitestock.rcv_qty-(hm_sitestock.ussed_qty+hm_sitestock.trans_qty))>='$recqty' AND hm_sitestock.prj_id NOT IN ($prjid) AND hm_sitestock.mat_id='$matid'";
      

     /* $sql = "SELECT hm_sitestock.site_stockid,hm_sitestock.stock_id,hm_sitestock.mat_id,hm_sitestock.prj_id,sum((hm_sitestock.rcv_qty-(hm_sitestock.ussed_qty+hm_sitestock.trans_qty))) as balanceqty,hm_stockbatch.batch_code 
      FROM hm_sitestock,hm_mainstock,hm_stockbatch
      WHERE  hm_sitestock.stock_id=hm_mainstock.stock_id AND hm_mainstock.batch_id=hm_stockbatch.batch_id AND hm_sitestock.prj_id NOT IN ($prjid) AND hm_sitestock.mat_id='$matid' GROUP BY batch_code,prj_id,mat_id HAVING SUM((hm_sitestock.rcv_qty-(hm_sitestock.ussed_qty+hm_sitestock.trans_qty))> '$recqty')";
     */
      $query = $this->db->query($sql);
      if(count($query->result())>0){
      return $query->result();
      }else{
        return false;
      }
      
     }

     function insert_transfer_record($newtransstokarr,$tblname){
       $this->db->insert($tblname,$newtransstokarr);
       if ($this->db->affected_rows() > 0) {
       return $this->db->insert_id();
       }else{
        return false;
       }
     }

     function update_transfer_records($data_arr,$ids,$fieldname,$table){
       $this->db->where($fieldname,$ids);
       $this->db->update($table,$data_arr);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else{
            return false;
        }
     }

     // added by terance perera 2020-1-6 
     function get_last_grn_nmbr(){
        $this->db->select('grn_code');
        $this->db->from('hm_grnmain');
        $this->db->order_by('grn_id','DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        if(count($query->result())>0){
            return $query->row();
        }else{
            return false;
        }
        
     }

    // created by terance 2020-1-9 .
     function get_searchkey_related_data($keyvalue,$stts){
       $this->db->select('*,hm_grnmain.status as grnstts,hm_po_request.prj_id as prjid,hm_po_request.request_by as po_requestby,hm_po_request.confirmed_date as poconfirmdate,hm_po_request.confirm_by as poconfirmby,hm_po_request.poid as prpoid,hm_stockbatch.qty as grnqty,hm_pomain.create_date pocreatedate,hm_pomain.create_by as pocreateby,hm_pomain.confirmed_by as poconfirmuser,cm_supplierms.first_name,cm_supplierms.last_name,hm_projectms.project_name,
          poreq.initial as poreqiniby,poreq.surname as poreqsurby,
          poconf.initial as poconfiniby,poconf.surname as poconfsurby,
          grnrec.initial as grnreqiniby,grnrec.surname as grnreqsurby,
          grnconf.initial as grnconfiniby,grnconf.surname as grnconfsurby
          ');
        $this->db->from('hm_grnmain');
        $this->db->join('hm_stockbatch','hm_grnmain.grn_id=hm_stockbatch.grn_id');
        $this->db->join('hm_podata','hm_stockbatch.po_itemid=hm_podata.po_itemid');
        $this->db->join('hm_pomain','hm_podata.po_id=hm_pomain.poid');
        $this->db->join('hm_po_request','hm_pomain.poid=hm_po_request.poid');
        $this->db->join('cm_supplierms','hm_pomain.sup_id=cm_supplierms.sup_code');
        $this->db->join('hm_projectms','hm_podata.prj_id=hm_projectms.prj_id');
        $this->db->join('hr_empmastr as poreq','hm_po_request.request_by=poreq.id');
        $this->db->join('hr_empmastr as poconf','hm_po_request.confirm_by=poconf.id');
        $this->db->join('hr_empmastr as grnrec','hm_grnmain.recieved_by=grnrec.id','left');
        $this->db->join('hr_empmastr as grnconf','hm_grnmain.confirmed_by=grnconf.id','left');
        if($stts==1){
          $this->db->where('hm_grnmain.status','PENDING');
          $this->db->like("hm_grnmain.grn_code",$keyvalue);
          $this->db->or_like("hm_grnmain.gr_date",$keyvalue);
          $this->db->or_like("cm_supplierms.first_name",$keyvalue);
          $this->db->or_like("hm_projectms.project_name",$keyvalue);
          $this->db->or_like("hm_po_request.poid",$keyvalue);
          
        }else{
          $this->db->like("hm_grnmain.grn_code",$keyvalue);
          $this->db->or_like("hm_grnmain.gr_date",$keyvalue);
          $this->db->or_like("cm_supplierms.first_name",$keyvalue);
          $this->db->or_like("hm_projectms.project_name",$keyvalue);
          $this->db->or_like("hm_po_request.poid",$keyvalue);
        }

        
        $this->db->group_by('hm_grnmain.grn_id');
        $this->db->order_by('hm_grnmain.grn_id','DESC');
        //$this->db->limit($pagination_counter, $page_count);
        $query=$this->db->get();
        //return $this->db->last_query();
        if(count($query->result())>0){
            return $query->result();
        }else{
            return false;
        }
     }
}
