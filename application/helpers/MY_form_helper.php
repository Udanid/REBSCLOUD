<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//modications done by Udani - Function :-form_input_ledger  Date : 11-09-2013
if ( ! function_exists('form_dropdown_dc'))
{
	function form_dropdown_dc($name, $selected = NULL, $extra = '')
	{
		$options = array("D" => "Dr", "C" => "Cr");

		// If no selected state was submitted we will attempt to set it automatically
		if ( ! ($selected == "D" || $selected == "C"))
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = $_POST[$name];
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$form = '<select name="'.$name.'"'.$extra.' class="dc-dropdown" >';

		foreach ($options as $key => $val)
		{
			$key = (string) $key;
			$sel = ($key == $selected) ? ' selected="selected"' : '';
			$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
		}

		$form .= '</select>';

		return $form;
	}
}

if ( ! function_exists('form_input_date'))
{
	function form_input_date($data = '', $value = '', $extra = '')
	{
		$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra." class=\"datepicker\"/>";
	}
}

if ( ! function_exists('form_input_date_restrict'))
{
	function form_input_date_restrict($data = '', $value = '', $extra = '')
	{
		$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra."  class=\"datepicker-restrict form-control\"/>";
	}
}

if ( ! function_exists('form_input_date_restrict_month'))
{
	function form_input_date_restrict_month($data = '', $value = '', $extra = '')
	{
		$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra." class=\"datepicker-restrict-month\"/>";
	}
}

if ( ! function_exists('form_input_ledger'))
{
	function form_input_ledger($name, $selected = NULL, $extra = '', $type = 'all')
	{
		$CI =& get_instance();
		$CI->load->model('Ledger_model');

		if ($type == 'bankcash')
			$options = $CI->Ledger_model->get_all_ac_ledgers_bankcash();
		else if ($type == 'nobankcash')
			$options = $CI->Ledger_model->get_all_ac_ledgers_nobankcash();
		else if ($type == 'bankcharge')
			$options = $CI->Ledger_model->get_all_ac_ledgers_bankcharge();
		else if ($type == 'reconciliation')
			$options = $CI->Ledger_model->get_all_ac_ledgers_reconciliation();
		else
			$options = $CI->Ledger_model->get_all_ac_ledgers();

		// If no selected state was submitted we will attempt to set it automatically
		if ( ! ($selected))
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = $_POST[$name];
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$form = '<select id="'.$name.'" name="'.$name.'"'.$extra.' data-placeholder="Select Ledger Account" class="ledger-dropdown">';
		
			$option="";
			$selected = (string)$selected;// modification done by udani
										//reason to avoid blank ledger entry submition
										//(string) $selected; remove srting part becouse of error in new server. 2016-11-11
			foreach ($options as $key => $val)
			{
			if($key!='0')
			{
				$dataarr=explode('#',$val);
				//print_r($dataarr);
				if($option!=$dataarr[1])
				{
					$option=$dataarr[1];
				$form .= '<optgroup label="'.$dataarr[1].'">';
				}
				$value= (string)$dataarr[0];
			}
			else
			{
			$value= (string) $val;
			}
				//$key = (string) $key;
				//echo  $key;
				$sel = ($key == $selected) ? ' selected="selected"' : '';
				//$sel='';
				$form .= '<option value="'.$key.'"'.$sel.'>'.$value."</option>\n";
			}
			$form .= '</optgroup>';
		
		$form .= '</select>';

		return $form;
	}
	function form_input_ledger_advance($name, $selected = NULL, $extra = '', $type = 'all',$list)
	{
		
		$CI =& get_instance();
		$CI->load->model('Ledger_model');

		$options = $CI->Ledger_model->get_all_Advance_ac_ledgers($list);

		// If no selected state was submitted we will attempt to set it automatically
		if ( ! ($selected))
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = $_POST[$name];
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$form = '<select name="'.$name.'"'.$extra.' data-placeholder="Select Ledger Account" class="ledger-dropdown">';
		
			$option="";
			$selected = (string) $selected;// modification done by udani
										//reason to avoid blank ledger entry submition
			foreach ($options as $key => $val)
			{
			if($key!='0')
			{
				$dataarr=explode('.',$val);
				//print_r($dataarr);
				if($option!=$dataarr[1])
				{
					$option=$dataarr[1];
				$form .= '<optgroup label="'.$dataarr[1].'">';
				}
				$value= (string)$dataarr[0];
			}
			else
			{
			$value= (string) $val;
			}
				//$key = (string) $key;
				//echo  $key;
				$sel = ($key == $selected) ? ' selected="selected"' : '';
				//$sel='';
				$form .= '<option value="'.$key.'"'.$sel.'>'.$value."</option>\n";
			}
			$form .= '</optgroup>';
		
		$form .= '</select>';

		return $form;
	}
}

/* End of file MY_form_helper.php */
/* Location: ./system/application/helpers/MY_form_helper.php */
