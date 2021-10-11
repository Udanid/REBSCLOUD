<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_meterial_site'))
{
	function get_meterial_site($matid,$prjid)
	{
		$CI =& get_instance();
		$CI->load->model('hm_helper_model');
		$status = $CI->hm_helper_model->get_meterial_site($matid,$prjid);
		return $status;

	}
}

if ( ! function_exists('get_meterial_boq'))
{
function get_meterial_boq($matid,$prjid)
    {
        $CI =& get_instance();
        $CI->load->model('hm_helper_model');
        $status = $CI->hm_helper_model->get_meterial_boq($matid,$prjid);
        return $status;

    }
}

if ( ! function_exists('get_unitname'))
{
function get_unitname($id)
    {
        $CI =& get_instance();
        $CI->load->model('hm_feasibility_model');
        $status = $CI->hm_feasibility_model->get_unitname($id);
        return $status;

    }
}

if ( ! function_exists('get_prjname'))
{
function get_prjname($id)
    {
        $CI =& get_instance();
        $CI->load->model('hm_config_model');
        $status = $CI->hm_config_model->get_prjname($id);
        return $status;

    }
}

if ( ! function_exists('get_meterials_all'))
{
function get_meterials_all($id)
    {
        $CI =& get_instance();
        $CI->load->model('hm_config_model');
        $status = $CI->hm_config_model->get_meterials_byid($id);
        return $status;

    }
}

if ( ! function_exists('get_sitestockbymatid'))
{
function get_sitestockbymatid($id){
        $prjid = "";
        $CI =& get_instance();
        $CI->load->model('hm_grn_model');
        $status = $CI->hm_grn_model->project_material_full($id,$prjid);
        return $status;
}
}

if ( ! function_exists('get_sitestockbybatch'))
{
function get_sitestockbybatch($id){
        $prjid = "";
        $CI =& get_instance();
        $CI->load->model('hm_grn_model');
        $status = $CI->hm_grn_model->get_site_stock_bybatch($id);
        return $status;
}
}

if( ! function_exists('get_po_requests')){
    function get_po_requests($matid,$batchqty){
        $batchid = "";
        $CI =& get_instance();
        $CI->load->model('hm_grn_model');
        $status = $CI->hm_grn_model->get_met_related_porequest($matid,$batchqty);
        return $status;
    }
}

if( ! function_exists('get_available_sitestocks')){
    function get_available_sitestocks($matid,$prjid,$recqty){
        $CI =& get_instance();
        $CI->load->model('hm_grn_model');
        $status = $CI->hm_grn_model->get_site_stock_available_qtys($matid,$prjid,$recqty);
        return $status;
    }
}
