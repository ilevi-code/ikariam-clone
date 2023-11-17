<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action_Model extends CI_Model {
	public function __construct()
	{
	    parent::__construct();
	}

    public function building_position_to_class($building_position)
    {
        $type_text = 'pos'.$building_position.'_type';
        $building_class = $this->Player_Model->now_town->$type_text;
        return $building_class;
    }

    public function count_queue_upgrades($building_position)
    {
        $queued_upgrades = 0;
        for ($i = 0; $i < SizeOf($this->Player_Model->build_line[$this->Player_Model->town_id]); $i++)
        {
            if ($building_class == $this->Player_Model->build_line[$this->Player_Model->town_id][$i]['type'])
            {
                $queued_upgrades++;
            }
        }

        return $queued_upgrades;
    }

    public function engouh_resource_for_upgrade($building_class, $after_construction_level)
    {
        $cost = $this->Data_Model->building_cost($building_class, $after_construction_level, $this->Player_Model->research, $this->Player_Model->levels[$this->Player_Model->town_id]);

        $wood_left = $this->Player_Model->now_town->wood - $cost['wood'];
        $wine_left = $this->Player_Model->now_town->wine - $cost['wine'];
        $marble_left = $this->Player_Model->now_town->marble - $cost['marble'];
        $crystal_left = $this->Player_Model->now_town->crystal - $cost['crystal'];
        $sulfur_left = $this->Player_Model->now_town->sulfur - $cost['sulfur'];

        return ($wood_left >= 0 and $wine_left >= 0 and $marble_left >= 0 and $crystal_left >= 0 and $sulfur_left >= 0);
    }

    public function enough_resource_for_upgrade_position($building_position)
    {
        $level_text = 'pos'.$building_position.'_level';
        $building_level = $this->Player_Model->now_town->$level_text;
        $building_level += $this->count_queue_upgrades($building_position);
        $building_class = $this->building_position_to_class($building_position);

        return $this->engouh_resource_for_upgrade($building_class, $building_level);
    }
}

