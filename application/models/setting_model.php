<?php

class Setting_model extends CI_Model {

    function Setting_model()
    {
        parent::__construct();
    }

    function get_current()
    {
        $this->db->from('ac_settings')->where('id', 1);
        $account_q = $this->db->get();
        return $account_q->row();
    }

    function add_stock_item(){
        $data = array(
            'type' => $this->input->post('type'),
            'remark' => $this->input->post('remark'),
            'category_id' => $this->input->post('category'),
        );
        $this->db->insert('ac_stock_items',$data);
    }

    function add_stock_category(){
        $data = array(
            'category' => $this->input->post('category'),
        );
        $this->db->insert('ac_stock_categories',$data);
    }

    function add_equipment_category(){
        $data = array(
            'category' => $this->input->post('category'),
        );
        $this->db->insert('equipment_categories',$data);
    }

    function update_stock_category($id){
        $data = array(
            'category' => $this->input->post('category'),
        );
        $this->db->where('id',$id);
        $this->db->update('ac_stock_categories',$data);
    }

    function update_equipment_category($id){
        $data = array(
            'category' => $this->input->post('category'),
        );
        $this->db->where('id',$id);
        $this->db->update('equipment_categories',$data);
    }

    function delete_equipment_category($id){
        //get type
        $this->db->select('category')->where('id',$id);
        $query = $this->db->get('equipment_categories');

        //delete
        $this->db->where('id',$id);
        $this->db->delete('equipment_categories');
        //return type to controller
        return $query->row();
    }

    function delete_stock_category($id){
        //get type
        $this->db->select('category')->where('id',$id);
        $query = $this->db->get('ac_stock_categories');

        //delete
        $this->db->where('id',$id);
        $this->db->delete('ac_stock_categories');
        //return type to controller
        return $query->row();
    }

    function update_stock_item($id){
        $data = array(
            'type' => $this->input->post('type'),
            'remark' => $this->input->post('remark'),
            'category_id' => $this->input->post('category'),
        );
        $this->db->where('id',$id);
        $this->db->update('ac_stock_items',$data);
    }

    function delete_stock_item($id){
        //get type
        $this->db->select('type')->where('id',$id);
        $query = $this->db->get('ac_stock_items');

        //delete
        $this->db->where('id',$id);
        $this->db->delete('ac_stock_items');
        //return type to controller
        return $query->row();
    }

    function stock_item_categories(){
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_stock_categories')->order_by('category', 'asc');
        $ac_stock_categories = $this->db->get();
        foreach ($ac_stock_categories->result() as $row)
        {
            $options[$row->id] = $row->category;
        }
        return $options;
    }

    function amortization_categories(){
        $options = array();
        $options[''] = "(Please Select)";
        $this->db->from('amortization_categories')->order_by('category', 'asc');
        $amortization_categories = $this->db->get();
        foreach ($amortization_categories->result() as $row)
        {
            $options[$row->id] = $row->category;
        }
        return $options;
    }

    function fixed_asset_categories(){
        $options = array();
        $options[''] = "(Please Select)";
        $this->db->from('asset_categories')->order_by('category', 'asc');
        $asset_categories = $this->db->get();
        foreach ($asset_categories->result() as $row)
        {
            $options[$row->id] = $row->category;
        }
        return $options;
    }

    function equipment_categories(){
        $options = array();
        $options[''] = "(Please Select)";
        $this->db->from('equipment_categories')->order_by('category', 'asc');
        $equipment_categories = $this->db->get();
        foreach ($equipment_categories->result() as $row)
        {
            $options[$row->id] = $row->category;
        }
        return $options;
    }

    function add_asset_category(){
        //Ledger code for assets
        $this->db->select_max('ledger_id');
        $ac_suppliers_data = $this->db->get('asset_categories');
        if ($ac_suppliers_data->num_rows > 0){
            $gl_code = $ac_suppliers_data->row();
            if ($gl_code->ledger_id == NULL){
                $code = 'BA01010000';
            }else{
                $max_code = substr($gl_code->ledger_id, 3, -4);
                $code = $max_code+1;
                $code = 'BA0'.$code.'0000';
            }
        }

        //Create Ledger account
        $data = array(
            'id' 			=> $code,
            'group_id'		=> '5',
            'name' 			=> $this->input->post('category'),
            'op_balance_dc' => 'D',
        );
        $this->db->insert('ac_ledgers',$data);

        //Ledger code for depreciation
        $this->db->select_max('id');
        $this->db->where('group_id','76');
        $dep_data = $this->db->get('ac_ledgers');
        if ($dep_data->num_rows > 0){
            $gl_code = $dep_data->row();
            if ($gl_code->id == NULL){
                $code2 = 'PE50090100';
            }else{
                $max_code = substr($gl_code->id, 2, -2);
                $code2 = $max_code+1;
                $code2 = 'PE'.$code2.'00';
            }
        }

        //Create Ledger account
        $data = array(
            'id' 			=> $code2,
            'group_id'		=> '76',
            'name' 			=> $this->input->post('category'),
            'op_balance_dc' => 'D',
        );
        $this->db->insert('ac_ledgers',$data);


        //Ledger code for provision
        $this->db->select_max('id');
        $this->db->where('group_id','61');
        $dep_data = $this->db->get('ac_ledgers');
        if ($dep_data->num_rows > 0){
            $gl_code = $dep_data->row();
            if ($gl_code->id == NULL){
                $code3 = 'BL31010100';
            }else{
                $max_code = substr($gl_code->id, 2, -2);
                $code3 = $max_code+1;
                $code3 = 'BL'.$code3.'00';
            }
        }

        //Create Ledger account
        $data = array(
            'id' 			=> $code3,
            'group_id'		=> '61',
            'name' 			=> $this->input->post('category'),
            'op_balance_dc' => 'C',
        );
        $this->db->insert('ac_ledgers',$data);

        //Ledger code for disposal
        $this->db->select_max('id');
        $this->db->where('group_id','81');
        $dep_data = $this->db->get('ac_ledgers');
        if ($dep_data->num_rows > 0){
            $gl_code = $dep_data->row();
            if ($gl_code->id == NULL){
                $code4 = 'BA02010000';
            }else{
                $max_code = substr($gl_code->id, 3, -4);
                $code4 = $max_code+1;
                $code4 = 'BA0'.$code4.'0000';
            }
        }

        //Create Ledger account
        $data = array(
            'id' 			=> $code4,
            'group_id'		=> '81',
            'name' 			=> $this->input->post('category'),
            'op_balance_dc' => 'C',
        );
        $this->db->insert('ac_ledgers',$data);

        //Create Asset category
        $data = array(
            'category' => $this->input->post('category'),
            'dep_per' => $this->input->post('dep_per'),
            'ledger_id' => $code,
            'depreciation' => $code2,
            'provision' => $code3,
            'disposal' => $code4,
        );
        $this->db->insert('asset_categories',$data);

    }

    function update_asset_category($id){
        $data = array(
            'category' => $this->input->post('category'),
            'dep_per' => $this->input->post('dep_per'),
        );
        $this->db->where('id',$id);
        $this->db->update('asset_categories',$data);

        //Update GL account name

        //get GL code
        $this->db->select('ledger_id,depreciation,provision,disposal')->where('id',$id);
        $query = $this->db->get('asset_categories');
        $gl = $query->row();

        $data = array(
            'name' => $this->input->post('category'),
        );
        $accounts = array($gl->ledger_id, $gl->depreciation, $gl->provision,$gl->disposal);
        $this->db->where_in('id', $accounts);
        $this->db->update('ac_ledgers',$data);
    }

    function add_amortization_category(){
        //Create Amortization category
        $data = array(
            'category' => $this->input->post('category'),
        );
        $this->db->insert('amortization_categories',$data);
    }

    function add_amortization_item(){
        //Create Amortization item
        $data = array(
            'amort_cat_id' => $this->input->post('category'),
            'asset_cat_id' => $this->input->post('asset_caterogy'),
        );
        $this->db->insert('amortization',$data);
    }

    function update_amortization_category($id){
        $data = array(
            'category' => $this->input->post('category'),
        );
        $this->db->where('id',$id);
        $this->db->update('amortization_categories',$data);
    }

    function update_amortization_item($id){
        $data = array(
            'amort_cat_id' => $this->input->post('category'),
            'asset_cat_id' => $this->input->post('asset_caterogy'),
        );
        $this->db->where('id',$id);
        $this->db->update('amortization',$data);
    }

    function add_asset_item(){
        $data = array(
            'type' => $this->input->post('type'),
            'remark' => $this->input->post('remark'),
            'category_id' => $this->input->post('category'),
        );
        $this->db->insert('asset_items',$data);
    }

    function add_eqipment_item(){
        $data = array(
            'type' => $this->input->post('type'),
            'remark' => $this->input->post('remark'),
            'category_id' => $this->input->post('category'),
        );
        $this->db->insert('equipment_items',$data);
    }

    function update_asset_item($id){
        $data = array(
            'type' => $this->input->post('type'),
            'remark' => $this->input->post('remark'),
            'category_id' => $this->input->post('category'),
        );
        $this->db->where('id',$id);
        $this->db->update('asset_items',$data);
    }

    function update_equipment_item($id){
        $data = array(
            'type' => $this->input->post('type'),
            'remark' => $this->input->post('remark'),
            'category_id' => $this->input->post('category'),
        );
        $this->db->where('id',$id);
        $this->db->update('equipment_items',$data);
    }

    function delete_asset_item($id){

        //get name
        $this->db->select('type')->where('id',$id);
        $query = $this->db->get('asset_items');

        //delete supplier
        $this->db->where('id',$id);
        $this->db->delete('asset_items');

        //return name to controller
        return $query->row();
    }

    function delete_equipment_item($id){

        //get name
        $this->db->select('type')->where('id',$id);
        $query = $this->db->get('equipment_items');

        //delete supplier
        $this->db->where('id',$id);
        $this->db->delete('equipment_items');

        //return name to controller
        return $query->row();
    }

    function delete_asset_category($id){

        //delete ledger account
        $this->db->select('ledger_id,depreciation,provision,disposal')->from('asset_categories')->where('id',$id);
        $asset_data = $this->db->get();
        $data = $asset_data->row();
        $accounts = array($data->ledger_id, $data->depreciation, $data->provision, $data->disposal);
        $this->db->where_in('id', $accounts);
        $this->db->delete('ac_ledgers');

        //get category
        $this->db->select('category')->where('id',$id);
        $query = $this->db->get('asset_categories');

        //delete Asset category
        $this->db->where('id',$id);
        $this->db->delete('asset_categories');

        //return name to controller
        return $query->row();
    }

    function delete_amortization_category($id){
        //get category
        $this->db->select('category')->where('id',$id);
        $query = $this->db->get('amortization_categories');

        //delete amortization category
        $this->db->where('id',$id);
        $this->db->delete('amortization_categories');

        //return name to controller
        return $query->row();
    }

    function delete_amortization_item($id){
        //delete amortization item
        $this->db->where('id',$id);
        $this->db->delete('amortization');
    }

    function get_glcode($id){
        $this->db->select('ledger_id,category')->where('id',$id);
        $category_data = $this->db->get('asset_categories');
        $data = $category_data->row();
        return $data;
    }

    function get_asset_glcode($id){
        $this->db->select('asset_items.type,asset_categories.category,asset_categories.ledger_id')->join('asset_categories','asset_categories.id = asset_items.category_id')->where('asset_items.id',$id);
        $category_data = $this->db->get('asset_items');
        $data = $category_data->row();
        return $data;
    }

}
