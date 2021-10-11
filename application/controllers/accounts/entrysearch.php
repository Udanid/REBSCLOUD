<?php
//modications done by Udani - Function :-add() Edit()  Date : 11-09-2013

class Entrysearch extends CI_Controller {

	function Entrysearch()
	{
		 parent::__construct();
		$this->load->model('Entrysearch_model');
		$this->load->model('Ledger_model');
		$this->load->model('Tag_model');
		$this->load->model('project_model');
		$this->is_logged_in();
		return;
	}

	function entry_search_main()
	{	
		$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['ledger_id'] = '';
		$this->load->view('accounts/entry/entrysearch_main',$data);
	}

	function search_entries(){
		 $fromdate= $this->uri->segment('4');
	  	 $todate= $this->uri->segment('5');
	     $ledger= $this->uri->segment('6');
	     $amount= $this->uri->segment('7');
         $discription= $this->uri->segment('8');
         $prj_id= $this->uri->segment('9');
         $lot_id= $this->uri->segment('10');

         $data['entries'] = $this->Entrysearch_model->get_entries($fromdate,$todate,$ledger,$amount,$discription,$prj_id,$lot_id);
         // // if($data['entries']){
         // // 	foreach( $data['entries'] as $row){
         // // 		echo $row->id.'-'.$row->date.'-'.$row->dr_total.'-'.$row->prj_id.'-'.$row->lot_id.'-'.$row->narration.'<br>';
         // // 	}
         // // }

         $this->load->view('accounts/entry/entrysearch_view',$data);
     }
}
?>