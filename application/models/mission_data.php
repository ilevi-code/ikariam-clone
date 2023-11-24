<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

enum MissionState : int {
    case LOADING = 0;
    case EN_ROUTE = 1;
    case IN_BATTLE = 2;
    case RETURNING = 3;
    case DISPERSED = 4;
    case FINISHED = 5;
}

enum MissionType : int {
{
    case TRANSPORT = 0;
    case STATION_TROOPS = 1;
    case STATION_FLEET = 2;
    case DEFEND_TWON = 3;
    case DEFEND_PORT = 4;
    case PLUNDER = 5;
    case PLUNDER_BARBARIANS = 6;
    case OCCUPY_TOWN = 7;
    case OCCUPY_PORT = 8;
    case COLONIZE = 9;
}


class Mission
{
    public $ctx = null;
    public $from = 0;
    public $to = 0;
    public $state = 0;
    public $type = 0;
    public $next_stage_time = 0;
    public $wood = 0;
    public $wine = 0;
    public $marble = 0;
    public $crystal = 0;
    public $sulfur = 0;
    public $gold = 0;
    public $peoples = 0;

    public function __construct($ctx, Array $properties=array()){
        $this->ctx = ctx;
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
    }

    public function get_resources() {
        return array(
            'wood' => $this->wood,
            'wine' => $this->wine,
            'marble' => $this->marble,
            'crystal' => $this->crystal,
            'sulfur' => $this->sulfur,
            'peoples' => $this->peoples,
    }

    public function get_travel_time() {
        return $ctx->Action_Model->get_city_travel_time($this->from, $this->to);
    }
}
