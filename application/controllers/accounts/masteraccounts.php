<?php

class Masteraccounts extends CI_Controller {

    function Masteraccounts()
    {
        parent::__construct();
        $this->load->model('Ledger_model');
      $this->load->model('common_model');
		$this->is_logged_in();
    }

    function index()
    {
        $data=NULL;
        if ( ! check_access('edit recieptboundle'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/project/');
            return;
        }
        //$this->template->set('page_title', 'Chart Of Accounts');
        //$this->template->set('nav_links', array('group/add' => 'Add Group', 'ledger/add' => 'Add Ledger', 'account/print_stmt' => 'Print', 'account/print_xls' => 'Print Excel'));

        /* Calculating difference in Opening Balance */
        $total_op = $this->Ledger_model->get_diff_op_balance();
        if ($total_op > 0)
        {
            //$this->messages->add('Difference in Opening Balance is Dr ' . number_format(convert_cur($total_op), 2, '.', ',') . '.', 'error');
            $this->session->set_flashdata('error', 'Difference in opening balance is Dr'.number_format(convert_cur($total_op), 2, '.', ',').'.');
        } else if ($total_op < 0) {
            //$this->messages->add('Difference in Opening Balance is Cr ' . number_format(convert_cur(-$total_op), 2, '.', ',') . '.', 'error');
            $this->session->set_flashdata('error', 'Difference in opening balance is Cr'.number_format(convert_cur($total_op), 2, '.', ',').'.');
        }

        //$this->template->load('template', 'accounts/account/index');
        $this->load->view('accounts/masteraccounts/index',$data);
        return;
    }

//    function print_xls(){
//
//        $this->template->set('page_title', 'Chart Of Accounts');
//        $this->template->set('nav_links', array('group/add' => 'Add Group', 'ledger/add' => 'Add Ledger', 'account/print_stmt' => 'Print', 'account/print_xls' => 'Print Excel'));
//
//        /* Calculating difference in Opening Balance */
//        $total_op = $this->Ledger_model->get_diff_op_balance();
//        if ($total_op > 0)
//        {
//            $this->messages->add('Difference in Opening Balance is Dr ' . number_format(convert_cur($total_op), 2, '.', ',') . '.', 'error');
//        } else if ($total_op < 0) {
//            $this->messages->add('Difference in Opening Balance is Cr ' . number_format(convert_cur(-$total_op), 2, '.', ',') . '.', 'error');
//        }
//
//        $this->load->view( 'account/print_xl');
//        return;
//    }
//
//    function print_stmt(){
//        header("Content-type: application/vnd.ms-excel");
//        header("Content-Disposition: attachment;Filename=Chart_of_Accounts.xls");
//        echo "<html>";
//        echo "<style>
//			#datatb td{ border-left:1px solid #000000; border-bottom:1px solid #000000; font-size:12px;}
//			#datatb th{ border-left:1px solid #000000; border-bottom:1px solid #000000; font-size:14px;  border-top:1px solid #000000;}
//			</style>";
//        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
//        echo "<body>";
//        echo "<div align=center id=\"statement\">";
//        echo "<h3>Chart Of Accounts</h3>";
//        echo "<h3>DISASTER MANAGEMENT CENTRE</h3>";
//        echo "<br>";
//        $this->load->library('accountlist');
//        echo "<table>";
//        echo "<tr valign=\"top\">";
//        $asset = new Accountlist();
//        echo "<td>";
//        $asset->init(0);
//        echo "<table id=datatb border=0 cellpadding=5 cellspacing=0 class=\"simple-table account-table\">";
//        echo "<thead><tr><th>GL Code</th><th>Account Name</th><th style=\"border-right:1px solid #000000;\">Balance</th></tr></thead>";
//        $asset->account_st_print(-1);
//        echo "</table>";
//        echo "</td>";
//        echo "</tr>";
//        echo "</table>";
//        echo "</div>";
//        echo "</body>";
//        echo "</html>";
//
//    }
}

/* End of file account.php */
/* Location: ./system/application/controllers/account.php */
