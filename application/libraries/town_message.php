<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
TODO
saw mill expanded] [island]
tradegood expanded [island]
unit production has been completed [units, town]
spies reached [town]
fleet returned [town, goods]
plunder returned [town/barbarian, goods]
diplomacy [cultural contract]
*/

enum TownMessageType : int
{
    case BUILDING_EXPANDED = 0;
    case ISLAND_EXPANDED = 1;
    case UNITS_PRODUCED = 2;
    case SPY_RECHED = 3;
    case SHIPMENT_ARRIVED = 4;
    case PLUDNER_RETURNED = 5;
    case CULTURAL_CONTRACT = 6;
    case MERCHANT_FLEET = 7;
}

class TownMessage
{
    public $ctx = null;
    public $data = null;
    public $user_id = null;
    public $town_id = null;

    public function __construct($ctx, $user_id, $town_id, $data = null) {
        $this->ctx = $ctx;
        $this->user_id = $user_id;
        $this->town_id = $town_id;
        $this->data = $data;
    }

    public function format() {
        error_log("missing formatter for town message of type ".$this->type);
        return "";
    }
}

class ShipmentArrivedMessage extends TownMessage
{
    public function format() {
        $this->ctx->Data_Model->Load_Town($this->data->from);
        $source_town = $this->ctx->Data_Model->temp_towns_db[$this->data->from];
        $fleet_source_link = $this->config->item('base_url').'game/island/'.$source_town->island.'/'.$mission->from.'/';
        $text = 'The merchant fleet from <a href="'.$source_town->name.'">'.$source_town->name.'</a> returned';
        $goods = (array)$this->data->goods;
        if (count((array)$goods))
        {
            $text .= 'and unloaded the following goods: <ul class="resources">';
            foreach ($goods as $resource => $count) {
                $text .= sprintf('<li class="%s"><span class="textLabel">%s: </span>%d</li>', $resource, $resource, $count);
            }
            $text .= '</ul>';
        } else {
            $text .= '.';
        }
        return $text;
    }
}

class BuildingExpandedMessage extends TownMessage
{
    public function format() {
        $building_class_name = $this->ctx->Data_Model->building_class_by_type($this->data->type);
        $building_link = $this->ctx->config->item('base_url').'game/city/'.$this->town_id.'/'.$building_class_name.'/'.$this->data->pos.'/';
        $building_locale_name = $this->ctx->Data_Model->building_name_by_type($this->data->type);
        $building_level = $this->data->level;

        if ($building_level == 1) {
            return 'Construction "<a href="'.$building_link.'">'.$building_locale_name.'</a>" completed!';
        } else {
            return 'The level of the building "<a href="'.$building_link.'">'.$building_locale_name.'</a>" increased to '.$building_level.'!';
        }
    }
}

function create_town_message($ctx, $type, $user_id, $town_id, $data) {
    $type = TownMessageType::from($type);
    $data = json_decode($data);
    switch ($type) {
    case TownMessageType::SHIPMENT_ARRIVED:
        return new ShipmentArrivedMessage($ctx, $user_id, $town_id, $data);
    case TownMessageType::BUILDING_EXPANDED:
        return new BuildingExpandedMessage($ctx, $user_id, $town_id, $data);
    default:
        return new TownMessage($ctx, $user_id, $town_id, $data);
    }
}
