<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_accountlist
{
    var $id = 0;
    var $name = "";
    var $total = 0;
    var $optype = "";
    var $opbalance = 0;
    var $children_ac_groups = array();
    var $children_ac_ledgers = array();
    var $counter = 0;
    public static $temp_max = 0;
    public static $max_depth = 0;
    public static $csv_data = array();
    public static $csv_row = 0;

    function Master_accountlist()
    {
        return;
    }

    function init($id)
    {
        $CI =& get_instance();
        if ($id == 0)
        {
            $this->id = 0;
            $this->name = "None";
            $this->total = 0;

        } else {
            $CI->db->from('ac_groups')->where('id', $id)->limit(1);
            $group_q = $CI->db->get();
            $group = $group_q->row();
            $this->id = $group->id;
            $this->name = $group->name;
            $this->total = 0;
        }
        $this->add_sub_ac_ledgers();
        $this->add_sub_ac_groups();
    }

    function add_sub_ac_groups()
    {
        $CI =& get_instance();
        $CI->db->from('ac_groups')->where('parent_id', $this->id);
        $child_group_q = $CI->db->get();
        $counter = 0;
        foreach ($child_group_q->result() as $row)
        {
            $this->children_ac_groups[$counter] = new Master_accountlist();
            $this->children_ac_groups[$counter]->init($row->id);
            $this->total = float_ops($this->total, $this->children_ac_groups[$counter]->total, '+');
            $counter++;
        }
    }
    function add_sub_ac_ledgers()
    {
        $CI =& get_instance();
        $CI->load->model('Ledger_model');
        $CI->db->from('ac_config_ledgers')->where('group_id', $this->id);
        $child_ledger_q = $CI->db->get();
        $counter = 0;
        foreach ($child_ledger_q->result() as $row)
        {
            $this->children_ac_ledgers[$counter]['id'] = $row->id;
            $this->children_ac_ledgers[$counter]['name'] = $row->name;
            $this->children_ac_ledgers[$counter]['status'] = $row->status;
            $this->children_ac_ledgers[$counter]['total'] = $CI->Ledger_model->get_ledger_config_balance($row->id);
            list ($this->children_ac_ledgers[$counter]['opbalance'], $this->children_ac_ledgers[$counter]['optype']) = $CI->Ledger_model->get_config_op_balance($row->id);
            $this->total = float_ops($this->total, $this->children_ac_ledgers[$counter]['total'], '+');
            $counter++;
        }
    }

    /* Display Account list in Balance sheet and Profit and Loss st */
    function account_st_short($c = 0)
    {
        $this->counter = $c;
        if ($this->id != 0)
        {
            echo "<tr class=\"tr-group\">";
            echo "<td class=\"td-ledger\">";
            echo "</td>";
            echo "<td class=\"td-group\">";
            echo $this->print_space($this->counter);
            echo "&nbsp;" .  $this->name;
            echo "</td>";
            echo "<td align=\"right\">" . convert_amount_dc($this->total) . $this->print_space($this->counter) . "</td>";
            echo "</tr>";
        }
        foreach ($this->children_ac_groups as $id => $data)
        {
            $this->counter++;
            $data->account_st_short($this->counter);
            $this->counter--;
        }
        if (count($this->children_ac_ledgers) > 0)
        {
            $this->counter++;
            foreach ($this->children_ac_ledgers as $id => $data)
            {
                echo "<tr class=\"tr-ledger\">";
                echo "<td class=\"td-ledger\" style=\"font-size:10px; font-weight:bold;\">";
                //Modified code to set there uniformity
                $code = substr($data['id'], 0, 2) .'-'.
                    substr($data['id'], 2, 4) .'-'.
                    substr($data['id'], 6, 2) .'-'.
                    substr($data['id'], 8, 2);
                echo $code;
                echo "</td>";
                echo "<td class=\"td-ledger\">";
                echo $this->print_space($this->counter);
                echo "&nbsp;" . anchor('accounts/report/ac_config_ledgerst/' . $data['id'], $data['name'], array('title' => $data['name'] . ' Ledger Statement', 'style' => 'color:#000000'));
                echo "</td>";
                echo "<td align=\"right\">" . convert_amount_dc($data['total']) . $this->print_space($this->counter) . "</td>";
                echo "</tr>";
            }
            $this->counter--;
        }
    }

    /* Display chart of accounts view */
    function account_st_main($c = 0)
    {
        $this->counter = $c;
        if ($this->id != 0)
        {
            echo "<tr class=\"tr-group\">";
            echo "<td class=\"td-ledger\">";
            echo "</td>";
            echo "<td class=\"td-group\">";
            echo $this->print_space($this->counter);
            if ($this->id <= 4)
                echo "&nbsp;<strong>" .  $this->name. "</strong>";
            else
                echo "&nbsp;" .  $this->name;
            echo "</td>";
            echo "<td>Group Account</td>";
            echo "<td>-</td>";
            echo "<td>-</td>";

            if ($this->id <= 4)
            {
                echo "<td class=\"td-actions\"></tr>";
            } else {
                ?>
                <td>
<!--                    <a href="--><?//= base_url() ?><!--accounts/group/edit/--><?// echo $this->id ?><!--">-->
<!--                        <i class="fa fa-edit nav_icon icon_blue"></i>-->
<!--                    </a>-->
<!--                    <a  href="--><?//= base_url() ?><!--accounts/ledger/confirm/--><?// echo $this->id?><!--"><i class="fa fa-check-square-o nav_icon icon_blue"></i></a>-->

                </td>
                <td>
<!--                    <a onclick="return confirm('Are you sure you want to delete this Account?');" href="--><?//= base_url() ?><!--accounts/group/delete/--><?// echo $this->id ?><!--"-->
<!--                       class="confirmClick">-->
<!--                        <i class="fa fa-trash-o nav_icon icon_blue"></i>-->
<!--                    </a>-->
                </td>
                <?
            }
            echo "</tr>";
        }
        foreach ($this->children_ac_groups as $id => $data)
        {
            $this->counter++;
            $data->account_st_main($this->counter);
            $this->counter--;
        }
        if (count($this->children_ac_ledgers) > 0)
        {
            $this->counter++;
            $c1=0;
            foreach ($this->children_ac_ledgers as $id => $data)
            {
                //echo "<tr class=\"tr-ledger\">";
                ?>
            <tr class="<? echo ($c1<0) ? 0 : ($c1++ % 2 == 1) ? 'info' : ''; ?>">
                <?
                echo "<td class=\"td-ledger\">";
                //Modified code to set there uniformity
                $code = substr($data['id'], 0, 2) .'-'.
                    substr($data['id'], 2, 4) .'-'.
                    substr($data['id'], 6, 2) .'-'.
                    substr($data['id'], 8, 2);
                echo $code;
                echo "</td>";
                echo "<td class=\"td-ledger\">";
                echo $this->print_space($this->counter);
                echo "&nbsp;" . anchor('accounts/report/ac_config_ledgerst/' . $data['id'], $data['name'], array('title' => $data['name'] . ' Ledger Statement', 'style' => 'color:#000000'));
                echo "</td>";
                echo "<td>Ledger Account</td>";
                echo "<td align=right>" . convert_opening($data['opbalance'], $data['optype']) . "</td>";
                echo "<td align=right>" . convert_amount_dc($data['total']) . "</td>";
                //echo "<td class=\"td-actions\">" . anchor('accounts/ledger/edit/' . $data['id'], 'Edit', array('title' => "Edit Ledger", 'class' => 'red-link'));
                if($data['status'] == 'CONFIRMED')
                {
                    echo "<td class=\"td-actions\">";
                    echo "</td>";
                }
                else{


                ?>
                <td class="td-actions">
                <a onclick="return confirm('Are you sure you want to confirm this Account?');"  href="<?= base_url() ?>accounts/ledger/confirm/<? echo $data['id'] ?>"><i class="fa fa-check-square-o nav_icon icon_blue"></i></a>

                </td>
                <td>
                 <a onclick="return confirm('Are you sure you want to delete this Account?');" href="<?= base_url() ?>accounts/ledger/delete/<? echo $data['id'] ?>"
                       class="confirmClick">
                        <i class="fa fa-trash-o nav_icon icon_blue"></i>
                    </a>
                </td>
            <?
            }
               // echo " &nbsp;" . anchor('accounts/ledger/delete/' . $data['id'], img(array('src' => asset_url() . "images/icons/delete.png", 'border' => '0', 'alt' => 'Delete Ledger')), array('class' => "confirmClick", 'title' => "Delete Ledger")) . "</td>";
                echo "</tr>";
            }
            $this->counter--;
        }
    }

    function print_space($count)
    {
        $html = "";
        for ($i = 1; $i <= $count; $i++)
        {
            $html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        return $html;
    }

    /* Build a array of ac_groups and ac_ledgers */
    function build_array()
    {
        $item = array(
            'id' => $this->id,
            'name' => $this->name,
            'type' => "G",
            'total' => $this->total,
            'child_ac_groups' => array(),
            'child_ac_ledgers' => array(),
            'depth' => self::$temp_max,
        );
        $local_counter = 0;
        if (count($this->children_ac_groups) > 0)
        {
            self::$temp_max++;
            if (self::$temp_max > self::$max_depth)
                self::$max_depth = self::$temp_max;
            foreach ($this->children_ac_groups as $id => $data)
            {
                $item['child_ac_groups'][$local_counter] = $data->build_array();
                $local_counter++;
            }
            self::$temp_max--;
        }
        $local_counter = 0;
        if (count($this->children_ac_ledgers) > 0)
        {
            self::$temp_max++;
            foreach ($this->children_ac_ledgers as $id => $data)
            {
                $item['child_ac_ledgers'][$local_counter] = array(
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'type' => "L",
                    'total' => $data['total'],
                    'child_ac_groups' => array(),
                    'child_ac_ledgers' => array(),
                    'depth' => self::$temp_max,
                );
                $local_counter++;
            }
            self::$temp_max--;
        }
        return $item;
    }

    /* Show array of ac_groups and ac_ledgers as created by build_array() method */
    function show_array($data)
    {
        echo "<tr>";
        echo "<td>";
        echo $this->print_space($data['depth']);
        echo $data['depth'] . "-";
        echo $data['id'];
        echo $data['name'];
        echo $data['type'];
        echo $data['total'];
        if ($data['child_ac_ledgers'])
        {
            foreach ($data['child_ac_ledgers'] as $id => $ledger_data)
            {
                $this->show_array($ledger_data);
            }
        }
        if ($data['child_ac_groups'])
        {
            foreach ($data['child_ac_groups'] as $id => $group_data)
            {
                $this->show_array($group_data);
            }
        }
        echo "</td>";
        echo "</tr>";
    }

    function to_csv($data)
    {
        $counter = 0;
        while ($counter < $data['depth'])
        {
            self::$csv_data[self::$csv_row][$counter] = "";
            $counter++;
        }

        self::$csv_data[self::$csv_row][$counter] = $data['name'];
        $counter++;

        while ($counter < self::$max_depth + 3)
        {
            self::$csv_data[self::$csv_row][$counter] = "";
            $counter++;
        }
        self::$csv_data[self::$csv_row][$counter] = $data['type'];
        $counter++;

        if ($data['total'] == 0)
        {
            self::$csv_data[self::$csv_row][$counter] = "";
            $counter++;
            self::$csv_data[self::$csv_row][$counter] = "";
        } else if ($data['total'] < 0) {
            self::$csv_data[self::$csv_row][$counter] = "Cr";
            $counter++;
            self::$csv_data[self::$csv_row][$counter] = -$data['total'];
        } else {
            self::$csv_data[self::$csv_row][$counter] = "Dr";
            $counter++;
            self::$csv_data[self::$csv_row][$counter] = $data['total'];
        }

        if ($data['child_ac_ledgers'])
        {
            foreach ($data['child_ac_ledgers'] as $id => $ledger_data)
            {
                self::$csv_row++;
                $this->to_csv($ledger_data);
            }
        }
        if ($data['child_ac_groups'])
        {
            foreach ($data['child_ac_groups'] as $id => $group_data)
            {
                self::$csv_row++;
                $this->to_csv($group_data);
            }
        }
    }

    public static function get_csv()
    {
        return self::$csv_data;
    }

    public static function add_blank_csv()
    {
        self::$csv_row++;
        self::$csv_data[self::$csv_row] = array("", "");
        self::$csv_row++;
        self::$csv_data[self::$csv_row] = array("", "");
        return;
    }

    public static function add_row_csv($row = array(""))
    {
        self::$csv_row++;
        self::$csv_data[self::$csv_row] = $row;
        return;
    }

    public static function reset_max_depth()
    {
        self::$max_depth = 0;
        self::$temp_max = 0;
    }

    /*
     * Return a array of sub ac_ledgers with the object
     * Used in CF ac_ledgers of type Assets and Liabilities
    */
    function get_ledger_ids()
    {
        $ac_ledgers = array();
        if (count($this->children_ac_ledgers) > 0)
        {
            foreach ($this->children_ac_ledgers as $id => $data)
            {
                $ac_ledgers[] = $data['id'];
            }
        }
        if (count($this->children_ac_groups) > 0)
        {
            foreach ($this->children_ac_groups as $id => $data)
            {
                foreach ($data->get_ledger_ids() as $row)
                    $ac_ledgers[] = $row;
            }
        }
        return $ac_ledgers;
    }
}

