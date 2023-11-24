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
        $building_class = $this->building_position_to_class($building_position);
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

    public function have_researched($category, $research_num)
    {
        $research_name = "res".$category."_".$research_num;
        return $this->Player_Model->research->$research_name > 0;
    }

    public function get_city_travel_time($src_town_id, $dst_town_id)
    {
        $this->load->model('Data_Model');
        $src_town = $this->Data_Model->Load_Town($src_town_id);
        $dst_town = $this->Data_Model->Load_Town($dst_town_id);
        return get_travel_time($src_town->island, $dest_town->island);

    }

    public function get_travel_time($src_island_id, $dst_island_id)
    {
        $src_island = $this->Data_Model->Load_Island($src_island_id);
        $dst_island = $this->Data_Model->Load_Island($dst_island_id);
        $cost = $this->Data_Model->army_cost_by_type(22, null, null);
        return $this->Data_Model->time_by_coords($src_island->x, $dst_island->x, $src_island->y, $src_island->y1, $cost['speed']);
    }

    public function does_town_have_spare($town_id, $resources)
    {
        $town = $this->Data_Model->Load_Town($town_id);
        foreach ($resources as $resource => $count) {
            if ($town->$resource < $count) {
                return false;
            }
        }
        return true;
    }

    public function does_user_have_spare($user_id, $resrouce)
    {
        $user = $this->Data_Model->Load_User($user_id);
        return $user->transports > $ship_count;
    }

    public function calc_ships($resources)
    {
        $total = 0.0;
        foreach ($resources as $resource => $count) {
            $total -= $count;
        }
        return ceil(($total) / getConfig('transport_capacity'));
    }

    public function is_town_occupied($island_id, $position)
    {
        $position_name = 'city'.$position;
        $island = $this->Data_Model->Load_Island($island_id);
        return $isalnd->$position_name == 0;
    }
}

