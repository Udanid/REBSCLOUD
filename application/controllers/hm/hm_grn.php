<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hm_grn extends CI_Controller {

	/**
	 * Index Page for this controller.land
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct() {
        parent::__construct();

		$this->load->model("hm_land_model");
		$this->load->model("common_model");
		$this->load->model("hm_introducer_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_feasibility_model");
		$this->load->model("hm_producttasks_model");
		$this->load->model("hm_dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("hm_config_model");
		$this->load->model("hm_inventry_model");
		$this->load->model("hm_grn_model");

		$this->is_logged_in();

    }

	public function index(){
       $data=NULL;
		if ( ! check_access('grn_process'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/Hm_grn/showall');
	}

    public function showall(){
       $data['polist'] = $this->hm_grn_model->get_not_processed_po();
       $data['prjlist'] = $this->hm_grn_model->get_project_list_all();
       
       /* new code (GRN no Generator) added 2019-12-24 by terance perera.. */
           /* get last GRN number */
           $lastgrnnmbr=$this->hm_grn_model->get_last_grn_nmbr();
           
           if(sizeof($lastgrnnmbr)>0){
            $lastgrn = $lastgrnnmbr->grn_code;
            $fill = 4;
            $newnmbr = $lastgrn+1;
            $newgrnnmbr=str_pad($newnmbr, $fill, '0', STR_PAD_LEFT);
       }else{
            $newgrnnmbr = "0001";
           }

           $data['newgrnnumber'] = $newgrnnmbr;
           
    /* new code added 2019-12-24 by terance perera.. */
     

      $this->load->view('hm/grn/grn_view',$data);
    }

    function grn_pending_list(){
         // pagination..
       $pagination_counter = $page_count = "";
        $pagination_counter =RAW_COUNT;
      $page_count = (int)$this->uri->segment(4);
        if ( !$page_count){
          $page_count = 0;
        }

       $data['grnlist'] = $this->hm_grn_model->get_grn_list($pagination_counter,$page_count,1);
      // $data['grnlist2'] = $this->hm_grn_model->get_grn_list($pagination_counter,$page_count,"");
      $siteurl='hm/hm_grn/showall';
      $tablename='hm_grnmain';
      $data['tab']='';

      if($page_count){
        $data['tab']='home';
      }
      $this->pagination($page_count,$siteurl,$tablename);
      // end pagination..
      $this->load->view('hm/grn/grn_pending_list_view',$data);
    }

    function grn_full_list(){
         // pagination..
       $pagination_counter = $page_count = "";
        $pagination_counter =RAW_COUNT;
      $page_count = (int)$this->uri->segment(4);
        if ( !$page_count){
          $page_count = 0;
        }

       //$data['grnlist'] = $this->hm_grn_model->get_grn_list($pagination_counter,$page_count,1);
       $data['grnlist2'] = $this->hm_grn_model->get_grn_list($pagination_counter,$page_count,"");
      $siteurl='hm/hm_grn/showall';
      $tablename='hm_grnmain';
      $data['tab']='';

      if($page_count){
        $data['tab']='home';
      }
      $this->pagination($page_count,$siteurl,$tablename);
      // end pagination..
      $this->load->view('hm/grn/grn_full_list_view',$data);
    }

    /* added 2019-12-12 */
    public function get_project_rel_lots(){
      $prjid = $this->uri->segment(4);
      $data['lotlist'] = $this->hm_grn_model->get_project_rel_lot($prjid);
      $this->load->view('hm/grn/load_lots',$data);
    }

    public function get_project_rel_po(){
      $lotid = $this->uri->segment(5);
      $prjid = $this->uri->segment(4);
      $data['polistitem'] = $this->hm_grn_model->get_po_list($prjid,$lotid);
      $this->load->view('hm/grn/load_polist',$data);
    }
    /* added 2019-12-12 */

    public function get_poid_rel_data(){
      $data['batchid'] = "";
    	$id = $data['ids'] = $this->uri->segment(4);
      $prjid = $this->uri->segment(5);
      $lotid = $this->uri->segment(6);
      $btcid = $this->hm_grn_model->get_last_batchid();

      if(count($btcid)>0){
        $data['batchid'] = $btcid->batch_code+1;
      }else{
        $data['batchid'] = 1;
      }
    	$data['listpoitems'] = $this->hm_grn_model->get_po_items($id,$prjid,$lotid);
    	$this->load->view('hm/grn/po_item_list',$data);
    }

    public function add_grn(){
      $podatastts = '';
      $pomainstts = '';
      $receivedqty = '';
      $updstatus = '';

      $prjid = $this->input->post('prjid');
      $lotid = $this->input->post('lotid');

      if($prjid=="all"){
        $prjid = "";
      }

      $poid = $this->input->post('poid');
      $grnnumber = $this->input->post('grnnumber');
      $grndate = $this->input->post('grndate');
      $poitemid = $this->input->post('grns');

       //1. hm_grnmain insert data..
        $grnmainarr = array(
          'grn_code' => $grnnumber,
          'gr_date' => $grndate,
          'status' => 'PENDING',
          'recieved_by' => $this->session->userdata('userid'),
          'prj_id' => $prjid,
          'lot_id' => $lotid
        );

        $grnmaininsertid = $this->hm_grn_model->insert_grnmain_data($grnmainarr);

      //loop all checked records..
      foreach($poitemid as $pitm){
      	// get only checked row qty and received qty..
      	$expqty = $this->input->post('qty'.$pitm);
      	$prvqty = $this->input->post('qty2'.$pitm);
      	$reqqty = $this->input->post('reqqty'.$pitm);
        $batchcode = $this->input->post('batchcode'.$pitm);

      	//check balance is available or not..
      	$balqty = $expqty-$reqqty;
        $receivedqty = $reqqty+$prvqty;
      	if($balqty>0){
      		$podatastts = "PENDING";
        }else{
      		$podatastts = "CONFIRMED";

      	}

      	//update process "hm_podata" table.
      	$updarrqty = array(
           'rec_qty' => $receivedqty,
           'status' => $podatastts
      	);

      	$updstatus=$this->hm_grn_model->upd_podata($updarrqty,$pitm);

        //2. hm_stockbatch insert data..
        $stockbatcharr = array(
          'batch_code' => $batchcode,
          'grn_id' => $grnmaininsertid,
          'po_itemid' => $pitm,
          'qty' => $reqqty,
        );

        $stockbatchinsert = $this->hm_grn_model->insert_stockbatch_data($stockbatcharr);

      }

      if($updstatus){
      	$this->upd_pomain_status($poid);
        //success msg..
        $this->session->set_flashdata('msg', 'GRN Succesfully Added');
        redirect('hm/hm_grn/showall');
        return;

      }else{
        $this->session->set_flashdata('error', 'Error Adding GRN');
        redirect('hm/hm_grn/showall');
        return;
      }

       
    }

    function get_grn_related_data(){
      $id = $data['ids'] = $this->uri->segment(4);
      $data['typ'] = $this->uri->segment(5);
      $data['stts'] = $this->uri->segment(6);
      $data['listgrnitems'] = $this->hm_grn_model->get_grn_items($id);
      $this->load->view('hm/grn/grn_edit_view',$data);
    }

    function update_grn_qty(){
      $grnid = $this->input->post('grnid');
      /* 1. get grn related po_itemid */
      $grnlist=$this->hm_grn_model->get_grn_items($grnid);
      foreach($grnlist as $grnlst){
        $batchid = $grnlst->batch_id;
        /* 2. get hm_podata table qty and rec_qty for check balance is available. */
          $podataqty=$grnlst->podataqty;
          $podatarecqty=$grnlst->rec_qty;
          $stockbatchqty = $grnlst->stockbthqty;
          $poid = $grnlst->po_id;

          $newupdateqty = $this->input->post('recquantity'.$batchid);
          $poitemid = $this->input->post('poitemid'.$batchid);

           /* check balance qty is available .*/
           if(($podataqty-$podatarecqty)==0){

            // $podataqty-$podatarecqty) = no quantity balance in "hm_podata table"..
             if($podataqty>$newupdateqty){

              //cal new rec_qty value for update
              $newrecqty=($podataqty-$stockbatchqty)+$newupdateqty;

              //entered quantity less than previous quantity.
              $stts = 'PENDING';
               //update new batchstock "qty".
               $batchstockupdarr = array(
                 'qty' => $newupdateqty
               );

               $updbatchstock = $this->hm_grn_model->upd_batch_stock($batchstockupdarr,$batchid);

               //update podata "rec_qty"..
               $podataupdarr = array(
                 'rec_qty' => $newrecqty,
                 'status' => $stts
               );

               $updpodata = $this->hm_grn_model->upd_podata($podataupdarr,$poitemid);

               // update po_main table "status"
               $pomainarr = array(
                 'status' => $stts
               );

               $updpomain = $this->hm_grn_model->upd_pomain($pomainarr,$poid);

             }
           }else{
            //have quantity balance in "hm_podata table"..
             //cal new rec_qty value for update
             $newrecqty=($podatarecqty-$stockbatchqty)+$newupdateqty;

             if($podataqty==$newrecqty){
              //New total Received quantity and podata quantity equal.
              $stts = 'CONFIRMED';
               //update new batchstock "qty".
               $batchstockupdarr = array(
                 'qty' => $newupdateqty
               );

               $updbatchstock = $this->hm_grn_model->upd_batch_stock($batchstockupdarr,$batchid);

               //update podata "rec_qty"..
               $podataupdarr = array(
                 'rec_qty' => $newrecqty,
                 'status' => $stts
               );

               $updpodata = $this->hm_grn_model->upd_podata($podataupdarr,$poitemid);
              }
              else{
              //New total Received quantity and podata quantity Not Equal.

              $stts = 'PENDING';
               //update new batchstock "qty".
               $batchstockupdarr = array(
                 'qty' => $newupdateqty
               );

               $updbatchstock = $this->hm_grn_model->upd_batch_stock($batchstockupdarr,$batchid);

               //update podata "rec_qty"..
               $podataupdarr = array(
                 'rec_qty' => $newrecqty,
                 'status' => $stts
               );

               $updpodata = $this->hm_grn_model->upd_podata($podataupdarr,$poitemid);
              }
           }

           /* check po_iems all complete or not. */


            if($updbatchstock && $updpodata){
              $this->upd_pomain_status($poid);
              $this->session->set_flashdata('msg', 'GRN Succesfully Updated');
              redirect('hm/hm_grn/showall');
              return;
            }else{
              $this->session->set_flashdata('error', 'Error Updating GRN');
              redirect('hm/hm_grn/showall');
              return;
            }
       }
    }

    function upd_pomain_status($poid){
      $countpendings = $this->hm_grn_model->get_pending_podatacount($poid);
           $countval = $countpendings->pendingcount;
            if($countval==0){
              $updpomainarr = array(
                  'status' => 'SEND'
              );

              $this->hm_grn_model->upd_pomain_tbl($updpomainarr,$poid);
            }
    }

		function grn_approve_disapprove_process(){



       $id = $this->input->get('id');
       $stts = $this->input->get('stts');
       $today = date("Y-m-d");
       if($stts==1){
        /* GRN approve process
           1. hit hm_mainstock and hm_sitestock tables.
           2. update hm_grnmain status to CONFIRMED
           3. hit accounts tables.
        */
           //get grn id related data all..
           $getgrndata = $this->hm_grn_model->get_grn_data($id);
           foreach($getgrndata as $grndt){
            //insert "hm_mainstock" table..
            $matid = $grndt->pomatid;
            $batchid = $grndt->batch_id;
            $rec_qty = $grndt->batchqty;
            $prjid = $grndt->grnprjid;
            $lotid = $grndt->grnlotid;
            $totalprice = $rec_qty*$grndt->buying_price;
            $grncode = $grndt->grn_code;

            $poitemid = $grndt->podata_itemid;
            $poid = $grndt->p_order_id;

/* ..........................................ledger account hit process.......................................... */
            $ledgerset=hm_get_account_set('GRN Process');
            $crlist[0]['ledgerid']=$ledgerset['Cr_account'];
            $crlist[0]['amount']=$crtot=$totalprice;
            $drlist[0]['ledgerid']=$ledgerset['Dr_account'];
            $drlist[0]['amount']=$drtot=$totalprice;
            $narration = 'GRN '.$grncode.' Process'  ;
            $int_entry=hm_jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$prjid,$lotid);
/* ..........................................ledger account hit process...........................................*/

/* .......................get po_request table data for check quantity balance with rec qty....................... */
             $getporequestdata = $this->hm_grn_model->get_po_request_data($poitemid,$poid);

             $requestedqty = $getporequestdata->qty;
             $dispachedqty = $getporequestdata->dispatched_qty;

             $qtybalance_requested_and_dispatched = $requestedqty-$dispachedqty;

             //check grn qty is equal to balance quantity.


/* .............................get po_request table data for check quantity balance with rec qty.............. */

              if($prjid==0){
              /////////////////////////////////////////////////////////////
                    $insertstockmainarr = array(
                    'mat_id' => $matid,
                    'batch_id' => $batchid,
                    'rcv_qty' => $rec_qty,
                    'price' => $grndt->buying_price
                    );
                    // insert process hm_mainstock
                    $stock_id = $this->hm_grn_model->insert_mainstock($insertstockmainarr);

                    /*.................................................*/
                     if($qtybalance_requested_and_dispatched==$rec_qty){
                        // no balance quantity after entering this
                        //update dispached qty+ new quantity.
                        //update dispached status to = Dispached
                        $new_dispached_qty = $dispachedqty+$rec_qty;
                        $stts = "DISPATCHED";
                        $prosstts = "GRN MAIN";
                        $porequestupdarr = array(
                          'status' => $stts,
                          //'dispatched_qty' => $new_dispached_qty,
                          'dispatch_date' => $today,
                          'processType' => $prosstts
                        );
                        $this->hm_grn_model->updte_po_request_tbl($porequestupdarr,$poitemid,$poid);

                      }else{

                        $new_dispached_qty = $dispachedqty+$rec_qty;
                        $stts = "USED";
                        $prosstts = "GRN MAIN";
                        $poupdarr = array(
                          'status' => $stts,
                          //'dispatched_qty' => $new_dispached_qty,
                          'dispatch_date' => $today,
                          'processType' => $prosstts
                        );
                        $this->hm_grn_model->updte_po_request_tbl($poupdarr,$poitemid,$poid);
                      }
                    /* ...................................................*/
              /////////////////////////////////////////////////////////////
              }else{
              /////////////////////////////////////////////////////////////
                  // create main stock array for insert..
                  $insertstockmainarr = array(
                    'mat_id' => $matid,
                    'batch_id' => $batchid,
                    'rcv_qty' => $rec_qty,
                    'ussed_qty' => $rec_qty,
                    'price' => $grndt->buying_price
                  );
                  // insert process hm_mainstock
                  $stock_id = $this->hm_grn_model->insert_mainstock($insertstockmainarr);

                  //create site stock array for insert..
                  $sitestockarr = array(
                    'prj_id' => $prjid,
                    'lot_id' => $lotid,
                    'mat_id' => $matid,
                    'stock_id' => $stock_id,
                    'rcv_qty' => $rec_qty,
                    'price' => $grndt->buying_price,
                    'rcv_date' => $today,
                    'dispatch_date' => $today,
                    'status' => 'RECEIVED'

                  );
                  // insert process hm_sitestock
                  $insertsitestock = $this->hm_grn_model->insert_site_stock($sitestockarr);

                  /*.................................................*/
                     if($qtybalance_requested_and_dispatched==$rec_qty){
                        // no balance quantity after entering this
                        //update dispached qty+ new quantity.
                        //update dispached status to = Dispached
                        $new_dispached_qty = $dispachedqty+$rec_qty;
                        $stts = "DISPATCHED";
                        $prosstts = "GRN SITE";
                        $porequestupdarr = array(
                          'status' => $stts,
                          'dispatched_qty' => $new_dispached_qty,
                          'dispatch_date' => $today,
                          'processType' => $prosstts
                        );
                        $this->hm_grn_model->updte_po_request_tbl($porequestupdarr,$poitemid,$poid);

                      }else{

                        $new_dispached_qty = $dispachedqty+$rec_qty;
                        $stts = "USED";
                        $prosstts = "GRN SITE";
                        $poupdarr = array(
                          'status' => $stts,
                          'dispatched_qty' => $new_dispached_qty,
                          'dispatch_date' => $today,
                          'processType' => $prosstts
                        );
                        $this->hm_grn_model->updte_po_request_tbl($poupdarr,$poitemid,$poid);
                      }
                    /* ...................................................*/
              /////////////////////////////////////////////////////////////
              }
           }

           $sttsname = "CONFIRMED";
           $updgrnmainarr = array(
             'status' => $sttsname,
             'confirmed_by' => $this->session->userdata('userid'),
             'confirmed_date' => $today
           );
           $updgrnmainmsg = $this->hm_grn_model->update_grn_main($updgrnmainarr,$id);

       }else{
        /* GRN cancel process
           1. update hm_grnmain status to CANCEL
           2. reduce cancel quantity from hm_podata table.also update its status to "PENDING"
        */
           $getgrndata = $this->hm_grn_model->get_grn_data($id);
           foreach($getgrndata as $grndt){
             $poitemid = $grndt->podata_itemid;
             $deductqty = $grndt->batchqty;
             $rec_qty = $grndt->podatareq_qty;
             $bal_qty = $rec_qty-$deductqty;

             $poid = $grndt->po_id;

             $podataupdarr = array(
               'rec_qty' => $bal_qty,
               'status' => 'PENDING'
             );
             $this->hm_grn_model->upd_podata($podataupdarr,$poitemid);
           }

           //grn main update process
           $sttsname = "CANCELLED";
           $updgrnmainarr = array(
             'status' => $sttsname,
             'confirmed_by' => $this->session->userdata('userid'),
             'confirmed_date' => $today
           );
           $updgrnmainmsg = $this->hm_grn_model->update_grn_main($updgrnmainarr,$id);

           // "hm_pomain" table update process.
           $updpomainarr = array(
                  'status' => 'PENDING'
           );
           $this->hm_grn_model->upd_pomain_tbl($updpomainarr,$poid);
       }
    }


    function view_stock(){
      $data=NULL;
      $finarr2 = array();
        if ( ! check_access('stock_view'))
        {
          $this->session->set_flashdata('error', 'Permission Denied');
          redirect('user');
          return;
        }
        /////////////////////////////////////////////////////////////////////////////////
          $pagination_counter =RAW_COUNT;
          $page_count = (int)$this->uri->segment(4);
            if ( !$page_count){
              $page_count = 0;
            }
          $mat = "";  
          //get batch data where balance quantity is not equeal to zero.
          $data['stocklistall'] = $stocklistall = $this->hm_grn_model->get_batch_rel_stock($mat,$pagination_counter,$page_count,2);
          foreach($stocklistall as $sla){
             $finarr= array(
                'mat_id'       => $sla->mat_id,
                'batch_code'   => $sla->batch_code,
                'meterial'     => $sla->mat_name." ".$sla->mt_name,
                'batchno'      => "GRN ".$sla->grn_code."(".$sla->batch_code.")",
                'quantity'     => $sla->stbatchqty." ".$sla->mt_name,
                'balquantity'  => $sla->balmainstockqty." ".$sla->mt_name,
                'price'        => $sla->buyprice,
                'confirmdate'  => $sla->confirmed_date,
                'ussedmainstock' => $sla->ussedmainstock,
                'stock_id'     => $sla->stock_id,
                'buyprice'     => $sla->buyprice,
                'stockdispach' => $this->hm_grn_model->get_site_stock_bybatch($sla->batch_id),
                'porequests'   => $this->hm_grn_model->get_met_related_porequest($sla->mat_id,$sla->balmainstockqty)
             );

             $finarr2[] = $finarr;
          }
          $data['finarr'] = $finarr2;
          //get batch data where balance quantity is not equeal to zero.

          $siteurl='hm/hm_grn/view_stock';
          $tablename='hm_stockbatch';
          $data['tab']='';

            if($page_count){
              $data['tab']='home';
            }
          $this->pagination($page_count,$siteurl,$tablename);
        /////////////////////////////////////////////////////////////////////////////////
        $data['meterial']=$this->hm_config_model->get_meterials_all('','','');
        $data['prjlist'] = $this->hm_grn_model->get_project_list_all();
        //$data['metlistfrommainstock'] = $this->hm_grn_model->get_met_list_from_mainstock();
        $this->load->view('hm/grn/stock_view',$data);
    }

    function stock_transfer_process(){
       $data=NULL;
       $finarr2 = array();
        if ( ! check_access('stock_transfer'))
        {
          $this->session->set_flashdata('error', 'Permission Denied');
          redirect('user');
          return;
        }

        $data['prjlist1'] = $data['prjlist2'] = $this->hm_grn_model->get_project_list_all();

         // pagination..
           $pagination_counter = $page_count = "";
            $pagination_counter =RAW_COUNT;
          $page_count = (int)$this->uri->segment(4);
            if ( !$page_count){
              $page_count = 0;
            }
           $prjid="";
           $data['trans_stock'] = $this->hm_grn_model->get_transfered_stocks($pagination_counter,$page_count,1);
           $data['trans_stock_all'] = $this->hm_grn_model->get_transfered_stocks($pagination_counter,$page_count,2);

           //stock transfer request array..
           $data['reqmeterial'] = $reqmeterial = $this->hm_grn_model->get_po_request_by_project($prjid,$pagination_counter,$page_count);
           
           foreach($reqmeterial as $reqmet){
              $mat=get_meterials_all($reqmet->mat_id);
              

             $finarr= array(
              'mat_id'   => $reqmet->mat_id,
              'prj_id'   => $reqmet->prj_id,
              'req_id'   => $reqmet->req_id,
              'project'  => get_prjname($reqmet->prj_id),
              'meterial' => $mat->mat_name." ".$mat->mt_name,
              'req_qty'  => $reqmet->qty,
              'batches'  => $this->hm_grn_model->get_site_stock_available_qtys($reqmet->mat_id,$reqmet->prj_id,$reqmet->qty)
             );

             $finarr2[] = $finarr;
          }
          $data['finarr'] = $finarr2;
           //stock transfer request array..

          $siteurl='hm/hm_grn/stock_transfer_process';
          $tablename='hm_stockransfer';
          $data['tab']='';

          if($page_count){
            $data['tab']='home';
          }
          $this->pagination($page_count,$siteurl,$tablename);
          // end pagination..


        //print_r($data);
       $this->load->view("hm/grn/stock_transfer_view",$data);
    }

    function get_meterials_byprjkt(){
       // $whr = "";
       // $prjid = $data['ids'] = $this->uri->segment(4);
       // $data['metlist'] = $this->hm_grn_model->get_meterial_list_for_transfer($whr,$prjid);
			 $whr = "";
       $prjid = $data['ids'] = $this->uri->segment(4);
			 $toprjid = $data['toids'] = $this->uri->segment(5);
			 $lotid = $data['lot'] = $this->uri->segment(6);
       //$data['metlist'] = $this->hm_grn_model->get_meterial_list_for_transfer($whr,$prjid);
			 $data['all_request']=$all_request=$this->hm_grn_model->get_all_pending_purchaserequest($toprjid,$lotid);
	 		$stock_batch=Null;
	 		if($all_request){
	 			foreach ($all_request as $key => $value) {
	 				$stock_batch[$value->req_id]=$this->hm_grn_model->get_meterial_list_for_transfer_bystoke($value->mat_id,$prjid);
	 			}
	 		}
			$data['metlist']=$stock_batch;
       //$this->load->view('hm/grn/load_meterials',$data);
       $this->load->view('hm/grn/load_meterials',$data);
    }

    function get_meterialsid_rel_sitestocks(){
      $metid = $this->uri->segment(4);
      $prjid = $this->uri->segment(5);
      $data['sitestocklist'] = $this->hm_grn_model->get_met_rel_sitestocks($prjid,$metid);
      $this->load->view('hm/grn/load_sitestocks',$data);
    }


     function transfer_stock(){
     $data=NULL;
        if ( ! check_access('stock_transfer'))
        {
          $this->session->set_flashdata('error', 'Permission Denied');
          redirect('user');
          return;
        }

        /*
         1. update "hm_sitestock table" fields "trans_qty"=enter qty and "status"= Transfer
         2. insert "hm_stocktransfer" table with "site_stockid,from_project,to_project"
        */

         $fromprjid = $this->input->post('prj1');
         $toprjid = $this->input->post('prj2');
         $sitestock_id = $this->input->post('rtnqtysiteid');
         $transqty = $this->input->post('transqty');
         $prevtransqty = $this->input->post('prevtransqty');
         $unitprice = $this->input->post('unitprice');

         $newtransqty = $prevtransqty+$transqty;
         $totalprice = $transqty*$unitprice;

         // site stock update array.new requested quentity was added to the current trans_qty..
         $sitestockupdarr = array(
             'trans_qty' => $newtransqty,
         );

         $transupdsitestock = $this->hm_grn_model->update_sitestock($sitestockupdarr,$sitestock_id);

         $insertstktransarr = array(
           'from_prj_id' => $fromprjid,
           'to_prj_id' => $toprjid,
           'site_stockid' => $sitestock_id,
           'trn_qty' => $transqty,
           'tot_price' => $totalprice
         );

         $inserttransqty = $this->hm_grn_model->insert_transfer_stock($insertstktransarr);

         /*
          google firebase notification code must enter here with firebase_token and firebase_api
          1. firebase_token.
          2. firebase_api.
          3. title
          4. message body(in here it shows stock transfer one project to another by this quantity)

          create another function in this class and call to it(sendnotification(token,api,title,messagebody))
         */

          //use helper function to get from project and to project name.

         $title = "Stock Transfer Request";
         $body = get_prjname($fromprjid)." Transfered".$transqty." to ".get_prjname($toprjid).".Please Accept or Reject It";
         $activityname = "Android manifest activity name";
         $this->sendnotification($body,$title,$activityname);


         if($transupdsitestock && $inserttransqty){
           $this->session->set_flashdata('msg', 'Stock Transfered Successfully');
           redirect('hm/hm_grn/stock_transfer_process');
         }else{
           $this->session->set_flashdata('error', 'Failed to Transfer Stock');
           redirect('hm/hm_grn/stock_transfer_process');
         }
    }

    function confirm_or_reject_stock_transfer(){
      $trnid = $this->input->post('id');
      $sitestockid = $this->input->post('sitestockid');
      $stts = $this->input->post('stts');
      $rtnqty = $this->input->post('rtnqty');
      $totalrtnqty = $this->input->post('totalrtnqty');


      if($stts=="CONFIRMED"){
       // just update status..
        $transstts = array(
         'status' => $stts,
         'confirm_date' => date("Y-m-d"),
         'confrim_by' => $this->session->userdata('userid')
        );
        $updstts1=$this->hm_grn_model->upd_stocktrans_tbl($transstts,$trnid);
        if($updstts1){
          echo json_encode("CONFIRMED");
        }

      }else{
       // removed transfer qty from total transfer qty and change status.
        $removedqty = $totalrtnqty-$rtnqty;
        $transstts = array(
         'status' => $stts,
         'confirm_date' => date("Y-m-d"),
         'confrim_by' => $this->session->userdata('userid')
        );
        $updstts1=$this->hm_grn_model->upd_stocktrans_tbl($transstts,$trnid);

        $updsitestocktransstock = array(
         'trans_qty' => $removedqty
        );
        $updstts2=$this->hm_grn_model->upd_site_stock_qty($updsitestocktransstock,$sitestockid);

        if($updstts1 && $updstts2){
          echo json_encode("CANCELLED");
        }
      }

    }

    function get_current_stock(){
       $data['stocklistall']="";
       $data['stocklist']="";
       $prjid = $data['prjid'] = $this->uri->segment(4);
       if($prjid=='allbatch'){
           $mat="";
        /////////////////////////////////////////////////////////////////////////////////
          $pagination_counter =RAW_COUNT;
          $page_count = (int)$this->uri->segment(4);
            if ( !$page_count){
              $page_count = 0;
            }
          $mat = "";  
         // $data['stocklistall'] = $this->hm_grn_model->get_batch_rel_stock($mat,$pagination_counter,$page_count); 
          //get batch data where balance quantity is not equeal to zero.
          $data['stocklistall'] = $stocklistall = $this->hm_grn_model->get_batch_rel_stock($mat,$pagination_counter,$page_count,1);
          foreach($stocklistall as $sla){
             $finarr= array(
                'mat_id'       => $sla->mat_id,
                'batch_code'   => $sla->batch_code,
                'meterial'     => $sla->mat_name." ".$sla->mt_name,
                'batchno'      => "GRN ".$sla->grn_code."(".$sla->batch_code.")",
                'quantity'     => $sla->stbatchqty." ".$sla->mt_name,
                'balquantity'  => $sla->balmainstockqty." ".$sla->mt_name,
                'price'        => $sla->buyprice,
                'confirmdate'  => $sla->confirmed_date,
                'ussedmainstock' => $sla->ussedmainstock,
                'stock_id'     => $sla->stock_id,
                'buyprice'     => $sla->buyprice,
                'stockdispach' => $this->hm_grn_model->get_site_stock_bybatch($sla->batch_id),
                'porequests'   => $this->hm_grn_model->get_met_related_porequest($sla->mat_id,$sla->balmainstockqty)
             );

             $finarr2[] = $finarr;
          }
          $data['finarr'] = $finarr2;
          //get batch data where balance quantity is not equeal to zero. 
          
          $siteurl='hm/hm_grn/view_stock';
          $tablename='hm_stockbatch';
          $data['tab']='';

            if($page_count){
              $data['tab']='home';
            }
          $this->pagination($page_count,$siteurl,$tablename);
        /////////////////////////////////////////////////////////////////////////////////
       }
       else if($prjid=='balqtyall'){
        $mat="";
        /////////////////////////////////////////////////////////////////////////////////
          $pagination_counter =RAW_COUNT;
          $page_count = (int)$this->uri->segment(4);
            if ( !$page_count){
              $page_count = 0;
            }
          $mat = "";  
         // $data['stocklistall'] = $this->hm_grn_model->get_batch_rel_stock($mat,$pagination_counter,$page_count); 
          //get batch data where balance quantity is not equeal to zero.
          $data['stocklistall'] = $stocklistall = $this->hm_grn_model->get_batch_rel_stock($mat,$pagination_counter,$page_count,2);
          foreach($stocklistall as $sla){
             $finarr= array(
                'mat_id'       => $sla->mat_id,
                'batch_code'   => $sla->batch_code,
                'meterial'     => $sla->mat_name." ".$sla->mt_name,
                'batchno'      => "GRN ".$sla->grn_code."(".$sla->batch_code.")",
                'quantity'     => $sla->stbatchqty." ".$sla->mt_name,
                'balquantity'  => $sla->balmainstockqty." ".$sla->mt_name,
                'price'        => $sla->buyprice,
                'confirmdate'  => $sla->confirmed_date,
                'ussedmainstock' => $sla->ussedmainstock,
                'stock_id'     => $sla->stock_id,
                'buyprice'     => $sla->buyprice,
                'stockdispach' => $this->hm_grn_model->get_site_stock_bybatch($sla->batch_id),
                'porequests'   => $this->hm_grn_model->get_met_related_porequest($sla->mat_id,$sla->balmainstockqty)
             );

             $finarr2[] = $finarr;
          }
          $data['finarr'] = $finarr2;
          //get batch data where balance quantity is not equeal to zero. 
          
          $siteurl='hm/hm_grn/view_stock';
          $tablename='hm_stockbatch';
          $data['tab']='';

            if($page_count){
              $data['tab']='home';
            }
          $this->pagination($page_count,$siteurl,$tablename);
        /////////////////////////////////////////////////////////////////////////////////
       }else{
         $data['stocklist'] = $this->hm_grn_model->get_site_stock($prjid);
       }

       $this->load->view('hm/grn/stocktable_view',$data);
    }

    function get_materialvise_stock(){
       $data['stocklistall']="";
       $data['stocklist']="";
       $mat = $this->uri->segment(4);
       $prj = $this->uri->segment(5);
       

       $data['stocklistall'] = $stocklistall = $this->hm_grn_model->get_batch_rel_stock2($mat,$prj);
       if(!empty($stocklistall)){
       foreach($stocklistall as $sla){
             $finarr= array(
                'mat_id'       => $sla->mat_id,
                'batch_code'   => $sla->batch_code,
                'meterial'     => $sla->mat_name." ".$sla->mt_name,
                'batchno'      => "GRN ".$sla->grn_code."(".$sla->batch_code.")",
                'quantity'     => $sla->stbatchqty." ".$sla->mt_name,
                'balquantity'  => $sla->balmainstockqty." ".$sla->mt_name,
                'price'        => $sla->buyprice,
                'confirmdate'  => $sla->confirmed_date,
                'ussedmainstock' => $sla->ussedmainstock,
                'stock_id'     => $sla->stock_id,
                'buyprice'     => $sla->buyprice,
                'stockdispach' => $this->hm_grn_model->get_site_stock_bybatch($sla->batch_id),
                'porequests'   => $this->hm_grn_model->get_met_related_porequest($sla->mat_id,$sla->balmainstockqty)
             );

             $finarr2[] = $finarr;
          }
          $data['finarr'] = $finarr2;
        }
       $this->load->view('hm/grn/stocktable_view',$data);
    }
    // created 2020-1-3 by terance
    function get_materialvise_stock_by_project(){
      $data['stocklistall']="";
      $mat = $this->uri->segment(4);
      $prj = $this->uri->segment(5);
      $data['stocklist'] = $this->hm_grn_model->get_batch_rel_project_materials($mat,$prj);
      $this->load->view('hm/grn/stocktable_view',$data);
    }

    function view_full_project_materials(){
      $matid = $data['matid'] = $this->uri->segment(4);
      $prjid = $data['prjid'] = $this->uri->segment(5);
      $data['prjmatfull'] = $this->hm_grn_model->project_material_full($matid,$prjid);
      $this->load->view('hm/grn/lot_material_list',$data);
    }

    public function totalgrnlist(){
      $pagination_counter = $page_count = "";
      $pagination_counter =RAW_COUNT;
      $data['grnlist2'] = $this->hm_grn_model->get_grn_list($pagination_counter,$page_count,"");
      $this->load->view('hm/grn/total_grn_list_view',$data);
    }

    function get_Project_lists(){
      $data['prjid'] = $this->uri->segment(4);
      $data['prjlist2'] = $this->hm_grn_model->get_project_list_all();
      $this->load->view('hm/grn/to_project_list',$data);
    }
		/*2019-12-18 nadee*/
		function add_dispatch()
		{
			$prj_id=$this->input->post('prj_id');
			$lot_id=$this->input->post('lot_id');
			$newqty=$this->input->post('req_qty');
      $dispachedqty = $this->input->post('ussed_qty');
      $price = $this->input->post('price');
			$data = array('prj_id'=>$prj_id,
				'lot_id' =>$lot_id,
				'mat_id'=>$this->input->post('mat_id'),
				'stock_id'=>$this->input->post('stock_id'),
				'rcv_qty'=>$newqty,
				'price'=>$price,
				'rcv_date'=>date('Y-m-d H:i:s'),
        //'dispatch_date'=>date('Y-m-d H:i:s'),
        //'status'=>"RECEIVED",
        'status'=>"PENDING");

				$amount=$newqty;
				$req_id=$this->input->post('req_id');
				$sitestock_id=$this->hm_grn_model->add_dispatch($data,$this->input->post('stock_id'),$amount,$dispachedqty);
				if($sitestock_id)
				{
          // create stock transfer array.
          $stocktransarr = array(
          'to_prj_id' => $prj_id,
          'site_stockid' => $sitestock_id,
          'trn_qty' => $newqty,
          'tot_price' => $price*$newqty,
          'confirm_date' => date("Y-m-d"),
          'status' => 'CONFIRMED',
          'confrim_by' => $this->session->userdata('userid')
          );
          // by inserting stock transfer get its last inserted id.
          $stktransferid = $this->hm_grn_model->add_transfer_stock($stocktransarr);
          //update po_request table poid field by transfer id.
          $req_update=$this->hm_grn_model->request_update($req_id,$newqty,'DISPACHED',$stktransferid);
          // update main stock used quantity.
          $this->hm_grn_model->upd_mainstock($this->input->post('stock_id'),$amount,$dispachedqty);
					$this->session->set_flashdata('msg', 'Stock Dispatched');
					redirect('hm/hm_grn/view_stock');
					return;
				}

    }
    

    /*2019-12-18 nadee*/
    

    /* 2019-12-27 terance */

    function get_project_related_poreq_materials(){
      $prjid = $this->uri->segment(4);
      $data['reqmeterial'] = $this->hm_grn_model->get_po_request_by_project($prjid);
      $this->load->view('hm/grn/po_request_list',$data);
    }

    function transfer_stock_process(){

      $fromprj      = $this->input->post('fromprj');
      $toprj        = $this->input->post('toprj');
      $transferqty  = $this->input->post('transferqty');
      $materialid   = $this->input->post('materialid');
      $stockid      = $this->input->post('stockid');
      $price        = $this->input->post('price');
      $sitestockid  = $this->input->post('sitestockid');
      $porequestid  = $this->input->post('porequestid');
      $transqty     = $this->input->post('transqty');

      /*1. insert new transfered stock into site_stock table */
        $newtransstokarr = array(
          'prj_id'   => $toprj,
          'lot_id'   => 0,
          'mat_id'   => $materialid,
          'stock_id' => $sitestockid,
          'rcv_qty'  => $transferqty,
          'price'    => $price,
          'rcv_date' => date("Y-m-d"),
          'status'   => 'PENDING',
          'transfer' => 'SITE STOCK TRANSFER'
        );
        $stock_id = $amount = $dispachedqty = "";
        $insertvalue = $this->hm_grn_model->insert_transfer_record($newtransstokarr,'hm_sitestock');

      /*2. insert stock_transfer table record. */
       $sitestockupdarr = array(
         'from_prj_id' => $fromprj,
         'to_prj_id'   => $toprj,
         'site_stockid' => $sitestockid,
         'trn_qty' => $transferqty,
         'tot_price' => $transferqty*$price
       );
       $inserttransval = $this->hm_grn_model->insert_transfer_record($sitestockupdarr,'hm_stockransfer');
      /*3. update transfer stock trans_qty */
       $updtransqtyarr = array(
         'trans_qty' => $transqty+$transferqty
       );
       $updsitestock = $this->hm_grn_model->update_transfer_records($updtransqtyarr,$sitestockid,'site_stockid','hm_sitestock');

      /*4. update po_request table transfer_id in po_id,status="dispached",processType="Transfer" */
      $updporequestarr = array(
        'poid' => $inserttransval,
        'status' => 'DISPATCHED',
        'dispatched_qty' => $transferqty,
        'dispatch_date' => date("Y-m-d"),
        'entered_date' => date("Y-m-d"),
        'confirmed_date' => date("Y-m-d"),
        'processType' => 'TRANSFER'
      );
      $updporequest = $this->hm_grn_model->update_transfer_records($updporequestarr,$porequestid,'req_id','hm_po_request');

      if($insertvalue && $updsitestock && $updporequest){
        $this->session->set_flashdata('msg', 'Succesfully Transfered');
        redirect('hm/hm_grn/stock_transfer_process');
        return;
      }else{
        $this->session->set_flashdata('error', 'Error In Transfering');
        redirect('hm/hm_grn/stock_transfer_process');
        return;
      }

    }

    /* 2019-12-27 terance */

    function sendnotification($body,$title,$activityname){

      // API access key from Google API's Console
      /* api key define in config/constants.php - line no 52.*/
      $registrationIds = array(REGISTRATION_ID);
      // prep the bundle
      $msg = array
      (
        'body'  => $body, // message body.
        'title'   => $title, // message title.
        'click_action' => $activityname, // android manifest file,"activity name" comes here.
        'vibrate' => 1, // vibration enabled
        'sound'   => 1, // sound enabled
      );
      $fields = array
      (
        'registration_ids'  => $registrationIds,
        'notification'      => $msg
      );

      $headers = array
      (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
      );

      $ch = curl_init();
      curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
      curl_setopt( $ch,CURLOPT_POST, true );
      curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
      curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
      $result = curl_exec($ch );
      curl_close( $ch );
      echo $result;

    }

  
    //created by terance 2020-1-9.
    function get_data_by_keyword(){
      $keyvalue = $this->uri->segment(4);
      $status = $this->uri->segment(5);
      
      if($status==1)
      {
        $data['grnlist2'] = ""; 
        $data['grnlist'] = $grnlist = $this->hm_grn_model->get_searchkey_related_data($keyvalue,1);
        //echo $grnlist;
      }else{
        $data['grnlist'] = ""; 
        $data['grnlist2'] = $this->hm_grn_model->get_searchkey_related_data($keyvalue,2);
      }

      $this->load->view('hm/grn/load_grn_by_search_keyword_view',$data);
    }

}
