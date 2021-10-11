<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DBcheck extends CI_Controller {

	 function __construct() {
        parent::__construct();
		$this->load->model("dbcheck_model");
		//if (!isset($_SERVER['FOOVAR']))
  		//die('No browser access.');
    }

	function index()
	{
		$errors = '';
		$databases = $this->dbcheck_model->get_all_databases();	
		if($databases){
			foreach($databases as $row){
				$current_count = $this->dbcheck_model->get_table_count($row->table);
				$difference = $current_count - $row->current_size;
				if($difference < -20){
					$errors .= $row->table.' - '.abs($difference).'<br>';
				}
				$this->dbcheck_model->update_record_count($row->id,$current_count,$row->current_size,$difference);
				
			}
			if($errors != ''){
				$head = 'Missing Data Home Lands<br>';
				$errors = $head.$errors;
				$user = "94773670896";
				$password = "4028";
				$text = urlencode($errors);
				$to = "0773670896";
				 
				$baseurl ="http://www.textit.biz/sendmsg";
				$url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
				$ret = file($url);
				 
				$res= explode(":",$ret[0]);
				 
				if (trim($res[0])=="OK")
				{
				echo "Message Sent - ID : ".$res[1];
				}
				else
				{
				echo "Sent Failed - Error : ".$res[1];
				}
			}
		}
	}

}