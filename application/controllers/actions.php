<?php

require_once "game.php";
require_once "application/libraries/mission_data.php";
require_once "application/libraries/buildings.php";

/**
 * Контроллер действий
 */

class Actions extends CI_Controller
{	
	function __construct()
    {
        parent::__construct();

        $this->load->model('Player_Model');
        $this->load->model('Action_Model');
        if (!$this->session->userdata('login'))
        {
            $this->Player_Model->Error($this->lang->line('error_session'));
        }
        else
        {
            // Загружаем пользователя
            $this->Player_Model->Load_Player($this->session->userdata('id'));

            $this->Player_Model->Load_New_Town_Messages();
            $this->Player_Model->Load_New_User_To_Messages();

            $this->load->model('View_Model');
        }

		// Load language
		if ($this->session->userdata('language'))
        {
            $this->lang->load('game', $this->session->userdata('language'));
        }
        else
        {
            $this->lang->load('game');
        }
        //$this->game = new Game;
    }

    function show($location, $param1 = 0, $param2 = 0, $param3 = 0)
    {
        $this->load->view('game_index',array('page' => $location, 'param1' => $param1, 'param2' => $param2, 'param3' => $param3));
    }


    /**
     * Переход на страницу ошибок
     * @param <string> $error
     */
    function Error($error = '')
    {
        $format = "";
        foreach(debug_backtrace() as $trace) {
            $format .= sprintf("\n%s:%d: %s()", $trace['file'], $trace['line'], $trace['function']);
        }
        error_log($format);
        error_log($error);
        $this->show('error', $error);
        http_response_code(400);
    }

    function get_param($param_name)
    {
        if (!array_key_exists($param_name, $_POST)) {
            error_log(print_r($_POST, true));
            error_log("Missing request parameter: ".$param_name);
            $this->Error("Bad request");
            die;
        }
        return $_POST[$param_name];
    }
    /**
     * Обучение: Переход к следующему обучению
     * @param <string> $action
     */
    function tutorials($action, $id = 0)
    {
        $id = floor($id);
        switch($action)
        {
            // следующий этап обучения
            case 'next':
                //$this->Player_Model->user->tutorial = $this->Player_Model->user->tutorial + 1;
                $this->db->query('UPDATE `'.$this->session->userdata('universe').'_users'.'` SET `tutorial`=`tutorial`+1 WHERE `id`="'.$this->session->userdata('id').'"');
            break;
            // установка этапа
            case 'set':
                //$this->Player_Model->user->tutorial = $id;
                $this->db->query('UPDATE `'.$this->session->userdata('universe').'_users'.'` SET `tutorial`='.$id.' WHERE `id`="'.$this->session->userdata('id').'"');
            break;
        }
    }

    function upgrade()
    {
        $position = floor($this->get_param('position'));
        $level_text = 'pos'.$position.'_level';
        $type_text = 'pos'.$position.'_type';
        if ($this->Player_Model->now_town->$level_text > 0){
            $this->build($position, $this->Player_Model->now_town->$type_text, $this->Data_Model->building_class_by_type($this->Player_Model->now_town->$type_text));
        }
	    else
        {
            $this->Error('No building here to imporove');
        }
    }

    function demolish()
    {
        $position = floor($this->get_param('position'));

        if ($position == 0) {
            $this->Error('Demolising town hall is not possible.');
            return;
        }

        if ($this->Action_Model->is_under_construction($this->Player_Model->now_town->id, $position)) {
            $this->Error('Cant demolish when building is queued for construction');
            return;
        }

        $level_text = 'pos'.$position.'_level';
        $type_text = 'pos'.$position.'_type';

        $level = $this->Player_Model->now_town->$level_text;
        $type = $this->Player_Model->now_town->$type_text;
        if ($level <= 0) {
            return;
        }

        $level -= 1;
        $cost = $this->Data_Model->building_cost($type,$level,$this->Player_Model->research,$this->Player_Model->levels[$this->Player_Model->town->id]);

        //If this is an academy, reset the scientists
        if ($type == 3 and $level == 0)
        {
            $scientists_to_remove = $this->Data_Model->scientists_by_level($level) - $this->Player_Model->now_town->scientists;
            if ($scientists_to_remove > 0) {
                $this->Player_Model->now_town->peoples += $scientists_to_remove;
                $this->Player_Model->now_town->scientists -= $scientists_to_remove;
                $this->db->set('peoples', $this->Player_Model->now_town->peoples);
                $this->db->set('scientists', $this->Player_Model->now_town->scientists);
            }
        }

        $wood = $this->Player_Model->now_town->wood + ($cost['wood']*0.9);
        $wine = $this->Player_Model->now_town->wine + ($cost['wine']*0.9);
        $marble = $this->Player_Model->now_town->marble + ($cost['marble']*0.9);
        $crystal = $this->Player_Model->now_town->crystal + ($cost['crystal']*0.9);
        $sulfur = $this->Player_Model->now_town->sulfur + ($cost['sulfur']*0.9);
        $points = ($cost['wood'] + $cost['wine'] + $cost['marble'] + $cost['crystal'] + $cost['sulfur'])*0.7;

        if ($level == 0){
            $this->Player_Model->now_town->$type_text = 0;
        }

        $level_text = 'pos'.$position.'_level';
        $this->Player_Model->now_town->$level_text = $level;
        $this->Player_Model->now_town->wood = $wood;
        $this->Player_Model->now_town->wine = $wine;
        $this->Player_Model->now_town->marble = $marble;
        $this->Player_Model->now_town->crystal = $crystal;
        $this->Player_Model->now_town->sulfur = $sulfur;

        $this->db->set($level_text, $level);
        $this->db->set($type_text, $this->Player_Model->now_town->$type_text);
        $this->db->set('wood', $wood);
        $this->db->set('wine', $wine);
        $this->db->set('marble', $marble);
        $this->db->set('crystal', $crystal);
        $this->db->set('sulfur', $sulfur);
        $this->db->where(array('id' => $this->Player_Model->town_id));
        $this->db->update($this->session->userdata('universe').'_towns');

        $this->Player_Model->user->points_buildings = $this->Player_Model->user->points_buildings - $points;
        $this->Player_Model->user->points_levels = $this->Player_Model->user->points_levels - 1;

        $this->db->set('points_buildings', $this->Player_Model->user->points_buildings);
        $this->db->set('points_levels', $this->Player_Model->user->points_levels);
        $this->db->where(array('id' => $this->Player_Model->user->id));
        $this->db->update($this->session->userdata('universe').'_users');

        $this->Player_Model->correct_buildings();
        header('Location: /game/city/');
    }

    /**
     * Постройка здания
     * @param <int> $position
     * @param <int> $id
     * @param <bool> $redirect
     */
    function build($position, $id, $redirect = 'city')
    {
        $id = floor($id);
        $position = floor($position);
        $redirect = strip_tags($redirect);
        $level_text = 'pos'.$position.'_level';
        $type_text = 'pos'.$position.'_type';
        $level = $this->Player_Model->now_town->$level_text;
        $type = $this->Player_Model->now_town->$type_text;
        $class = $this->Data_Model->building_class_by_type($id);
        $already_position = $this->Data_Model->get_position($id, $this->Player_Model->now_town);
        if ((($already_position == 0 or $already_position == $position) or $id == 6) and
            $class != 'buildingGround' and
            ($id != 4 or ($id == 4 and $this->Player_Model->armys[$this->Player_Model->town_id]->ships_line == '')) and
            ($id != 5 or ($id == 5 and $this->Player_Model->armys[$this->Player_Model->town_id]->army_line == '')) and
            ($id != 13 or $this->Player_Model->research->res2_13 > 0) and
            ($id != 14 or ($id == 14 and $this->Player_Model->now_town->spyes_start == 0)) and
            ($type == 0 or $type == $id) and
            (SizeOf($this->Player_Model->build_line[$this->Player_Model->town_id]) <= getConfig('town_queue_size')) and (SizeOf($this->Player_Model->build_line[$this->Player_Model->town_id]) > 0 and $this->Player_Model->user->premium_account > 0) or SizeOf($this->Player_Model->build_line[$this->Player_Model->town_id]) == 0)
        {
            // Получаем цены
            $cost = $this->Data_Model->building_cost($id, $level, $this->Player_Model->research, $this->Player_Model->levels[$this->Player_Model->town_id]);
            // Подсчитываем остаток
            $wood = $this->Player_Model->now_town->wood - $cost['wood'];
            $wine = $this->Player_Model->now_town->wine - $cost['wine'];
            $marble = $this->Player_Model->now_town->marble - $cost['marble'];
            $crystal = $this->Player_Model->now_town->crystal - $cost['crystal'];
            $sulfur = $this->Player_Model->now_town->sulfur - $cost['sulfur'];

            // Если остаток приемлемый
            if ($wood >= 0 and $wine >= 0 and $marble >= 0 and $crystal >= 0 and $sulfur >= 0)
            {
                if ($this->Player_Model->now_town->build_line == '')
                {
                    // Обновляем ресурсы в базе и в модели
                    $this->Player_Model->now_town->wood = $wood;
                    $this->Player_Model->now_town->wine = $wine;
                    $this->Player_Model->now_town->marble = $marble;
                    $this->Player_Model->now_town->crystal = $crystal;
                    $this->Player_Model->now_town->sulfur = $sulfur;
                    
                    $this->db->set('wood', $wood); 
                    $this->db->set('wine', $wine);
                    $this->db->set('marble', $marble);
                    $this->db->set('crystal', $crystal);
                    $this->db->set('sulfur', $sulfur);
                }
                // Строка текста прямо как в базе
                if ($this->Player_Model->now_town->build_line != '')
                {
                    $this->db->set('build_line', $this->Player_Model->now_town->build_line.';'.$position.','.$id);
                    $this->Player_Model->now_town->build_line = $this->Player_Model->now_town->build_line.';'.$position.','.$id;
                    
				}
                else
                {
                    $this->db->set('build_line', $position.','.$id);
                    $this->Player_Model->now_town->build_line = $position.','.$id;
                }
                // Устанавливаем время старта если его нету
                if ($this->Player_Model->now_town->build_start == 0)
                {
                    $this->db->set('build_start', time());
                    $this->Player_Model->now_town->build_start = time();
                }
                $this->db->where(array('id' => $this->Player_Model->town_id));
                $this->db->update($this->session->userdata('universe').'_towns');
                
               if($id ==  11){
			           $this->db->set('punti_diplo', $level + 3);
                       $this->db->where(array('id' => $this->Player_Model->user->id));
                       $this->db->update($this->session->userdata('universe').'_users');
		                }
				// Здание добавлено в очередь
                // Обновляем обучения если есть
                        if ($id == 3 and $this->Player_Model->user->tutorial <= 4)
                        {
                            // Построили академию
                            $this->tutorials('set', 5);
                        }
                        if ($id == 5 and $this->Player_Model->user->tutorial <= 8)
                        {
                            // Построили казарму
                            $this->tutorials('set', 9);
                        }
                        if ($id == 7 and $this->Player_Model->user->tutorial <= 11)
                        {
                            // Построили стену
                            $this->tutorials('set', 12);
                        }
                        if ($id == 2 and $this->Player_Model->user->tutorial <= 13)
                        {
                            // Построили порт
                            $this->tutorials('set', 14);
                        }
                        if ($level > 0 and  $this->Player_Model->user->tutorial <= 15)
                        {
                            // Апгрейдили здание
                            $this->tutorials('set', 16);
                        }

					   
                        $this->Player_Model->correct_buildings();
                        $this->show($redirect, $position);
                        
			}
            else
            {
                $this->Error('Для постройки здания не хватает ресурсов!');
            }
        }
        
        
		else
		{
		    $this->show($redirect, $position);
		}
		
    }

    /**
     * Переименовать город
     */
    function rename()
    {
        if (isset($_POST['name']) and strip_tags($_POST['name']) != '')
        {
           $this->Player_Model->now_town->name = strip_tags($_POST['name']);
           $this->db->set('name', strip_tags($_POST['name']));
           $this->db->where(array('id' => $this->Player_Model->town_id));
           $this->db->update($this->session->userdata('universe').'_towns');
           $this->show('townHall', 0);
        }
    }

    /**
     * Обновляем рабочих
     * @param <string> $type
     * @param <int> $id
     */
    function workers($type = 'resource', $id = 0)
    {
        // Обучение - найм рабочих на лесопилку
        if ($type == 'resource' and $this->Player_Model->user->tutorial <= 2)
        {
            $this->tutorials('set', 3);
        }    
        if ($type == 'academy' and $this->Player_Model->user->tutorial <= 6)
        {
            $this->tutorials('set', 7);
        }
        // Рабочие
        if (isset($_POST['rw']))
        {
            $level = $this->Player_Model->now_island->wood_level;
            $cost = $this->Data_Model->island_cost(0, $level);
            if ($this->Player_Model->research->res2_5 > 0)
            {
                $cost['workers'] = $cost['workers']*1.5;
            }
            if ($cost['workers'] >= $_POST['rw'])
            {
                $all = $this->Player_Model->now_town->workers + $this->Player_Model->now_town->peoples;

                if ($all >= $_POST['rw'])
                {
                    $this->Player_Model->now_town->workers = floor($_POST['rw']);
                    $this->Player_Model->now_town->peoples = $all - floor($_POST['rw']);
                    $this->db->set('workers', $this->Player_Model->now_town->workers);
                    $this->db->set('peoples', $this->Player_Model->now_town->peoples);
                    $this->db->where(array('id' => $this->Player_Model->town_id));
                    $this->db->update($this->session->userdata('universe').'_towns');
                }
            }
        }
        // Рабочие 2
        if (isset($_POST['tw']))
        {
            $level = $this->Player_Model->now_island->trade_level;
            $cost = $this->Data_Model->island_cost(1, $level);
            if ($this->Player_Model->research->res2_5 > 0)
            {
                $cost['workers'] = $cost['workers']*1.5;
            }
            if ($cost['workers'] >= $_POST['tw'])
            {
                $all = $this->Player_Model->now_town->tradegood + $this->Player_Model->now_town->peoples;
                if ($all >= $_POST['tw'])
                {
                    $this->Player_Model->now_town->tradegood = floor($_POST['tw']);
                    $this->Player_Model->now_town->peoples = $all - floor($_POST['tw']);
                    $this->db->set('tradegood', $this->Player_Model->now_town->tradegood);
                    $this->db->set('peoples', $this->Player_Model->now_town->peoples);
                    $this->db->where(array('id' => $this->Player_Model->town_id));
                    $this->db->update($this->session->userdata('universe').'_towns');
                }
            }
        }
        // Ученые
        if (isset($_POST['s']) and $id > 0 and $this->Player_Model->already_build[$this->Player_Model->town_id][3])
        {
            $level_text = 'pos'.$id.'_level';
            $type_text = 'pos'.$id.'_type';
            $level = $this->Player_Model->now_town->$level_text;
            $max_scientists = $this->Data_Model->scientists_by_level($level);
            if ($max_scientists >= $_POST['s'])
            {
                $all = $this->Player_Model->now_town->scientists + $this->Player_Model->now_town->peoples;
                if ($all >= $_POST['s'] )
                {
                    $this->Player_Model->now_town->scientists = floor($_POST['s']);
                    $this->Player_Model->now_town->peoples = $all - floor($_POST['s']);
                    $this->db->set('scientists', $this->Player_Model->now_town->scientists);
                    $this->db->set('peoples', $this->Player_Model->now_town->peoples);
                    $this->db->where(array('id' => $this->Player_Model->town_id));
                    $this->db->update($this->session->userdata('universe').'_towns');
                }
            }
        }
        if (isset($_POST['rw']) or isset($_POST['tw']))
        {
            $this->Player_Model->Load_Production();
            $this->load->model('Island_Model');
            $this->Island_Model->Load_Island($id);
        }
        $this->show($type, $id);
    }

    function resources($type = 'resource', $id = 0)
    {
        $count = isset($_POST['donation']) ? floor($_POST['donation']) : 0;
        if($this->Player_Model->now_town->wood >= $count and $count > 0 and $this->Player_Model->island_id == $id)
		{
            // Обновляем город
            if ($type == 'resource')
            {
                $this->Player_Model->now_town->workers_wood = $this->Player_Model->now_town->workers_wood + $count;
                $this->db->set('workers_wood', $this->Player_Model->now_town->workers_wood);
            }
            else
            {
                $this->Player_Model->now_town->tradegood_wood = $this->Player_Model->now_town->tradegood_wood + $count;
                $this->db->set('tradegood_wood', $this->Player_Model->now_town->tradegood_wood + $count);
            }
            $this->Player_Model->now_town->wood = $this->Player_Model->now_town->wood - $count;
            $this->db->set('wood', $this->Player_Model->now_town->wood);
            $this->db->where(array('id' => $this->Player_Model->town_id));
            $this->db->update($this->session->userdata('universe').'_towns');
            // Обновляем остров
            if ($type == 'resource')
            {
                $this->db->query('UPDATE `'.$this->session->userdata('universe').'_islands'.'` SET `wood_count`=`wood_count`+'.$count.' WHERE `id`="'.$id.'"');
               	redirect($this->config->item('base_url').'game/resource/', 'refresh');
			}
            else
            {
                $this->db->query('UPDATE `'.$this->session->userdata('universe').'_islands'.'` SET `trade_count`=`trade_count`+'.$count.' WHERE `id`="'.$id.'"');
                redirect($this->config->item('base_url').'game/tradegood/', 'refresh');
			}
        }
        $this->load->model('Island_Model');
        $this->Island_Model->Load_Island($id);
        $this->show($type, $id);
    }

    function doResearch($way = 0, $id = 0)
    {
        $way = floor($way);
        $id = floor($id);
        if($way > 0 and $way <= 4)
        {
            $parametr = 'res'.$way.'_'.$id;
            $data = $this->Data_Model->get_research($way, $id, $this->Player_Model->research);
            if ($this->Player_Model->research->points >= $data['points'])
            {
                $this->Player_Model->research->points = $this->Player_Model->research->points - $data['points'];
                $way_text = 'way'.$way.'_checked';
                $this->Player_Model->research->$way_text = 0;
                $this->db->set('points', $this->Player_Model->research->points);
                $this->db->set('way'.$way.'_checked', 0);
                $this->Player_Model->research->$parametr = $this->Player_Model->research->$parametr + 1;
                $this->db->set($parametr, $this->Player_Model->research->$parametr);
                $this->db->where(array('user' => $this->Player_Model->user->id));
                $this->db->update($this->session->userdata('universe').'_research');
                
                $this->Player_Model->user->points_research = $this->Player_Model->user->points_research + $data['points']*0.2;
                $this->Player_Model->user->points_complete = $this->Player_Model->user->points_complete + 15;
                $this->db->set('points_research', $this->Player_Model->user->points_research);
                $this->db->set('points_complete', $this->Player_Model->user->points_complete);

                $this->db->where(array('id' => $this->Player_Model->user->id));
                $this->db->update($this->session->userdata('universe').'_users');

                // Благосостояние
                if($way == 2 and $id == 3)
                {
                    $this->Player_Model->now_town->wood = $this->Player_Model->now_town->wood + 250;
                    $this->Player_Model->now_town->marble = $this->Player_Model->now_town->marble + 150;
                    $this->Player_Model->now_town->wine = $this->Player_Model->now_town->wine + 150;
                    $this->Player_Model->now_town->crystal = $this->Player_Model->now_town->crystal + 150;
                    $this->Player_Model->now_town->sulfur = $this->Player_Model->now_town->sulfur + 150;
                    
                    $this->db->set('wood', $this->Player_Model->now_town->wood);
                    $this->db->set('marble', $this->Player_Model->now_town->marble);
                    $this->db->set('wine', $this->Player_Model->now_town->wine);
                    $this->db->set('crystal', $this->Player_Model->now_town->crystal);
                    $this->db->set('sulfur', $this->Player_Model->now_town->sulfur);
                    $this->db->where(array('id' => $this->Player_Model->town_id));
                    $this->db->update($this->session->userdata('universe').'_towns');
                }
            }
        }
        $this->Player_Model->Load_Ways();
        $this->show('researchAdvisor');
    }

    /**
     * Конкретный остров
     * @param <int> $x
     * @param <int> $y
     */
    function getJSONIsland($x = 0, $y = 0)
    {
        $x = floor($x);
        $y = floor($y);

        echo '{"request":{"x":'.$x.',"y":'.$y.'},"data":[]}';
    }

    /**
     * Все острова
     * @param <int> $xmin
     * @param <int> $xmax
     * @param <int> $ymin
     * @param <int> $ymax
     */
    function getJSONArea($xmin = 0, $xmax = 15, $ymin = 0, $ymax = 15)
    {
        $data = '{"request":{"x_min":'.$xmin.',"x_max":'.$xmax.',"y_min":'.$ymin.',"y_max":'.$ymax.'},"data":{';

        for ($i = $xmin; $i <= $xmax; $i++)
        {
            $query_x = $this->db->query('SELECT * FROM '.$this->session->userdata('universe').'_islands WHERE x='.$i.' and y>'.$ymin.' and y<'.$ymax);
                $data .= '"'.$i.'":{';
                $j = 1;
                foreach ($query_x->result() as $island)
                {
                    $towns = 0;
                    for ($p = 0; $p <= 15; $p++)
                    {
                        $parametr = 'city'.$p;
                        if ($island->$parametr > 0){ $towns = $towns + 1; }
                    }
                    $data .= '"'.$island->y.'":["'.$island->id.'","'.$island->name.'","'.$island->trade_resource.'","'.$island->wonder.'","0","'.$island->type.'","0","'.$towns.'"]';
                    $data .= ($j == $query_x->num_rows) ? '' : ',' ;
                    $j = $j + 1;
                }
                $data .= ($i == $xmax) ? '}' : '},' ;
        }
        $data .= '}}';
        echo $data;
    }

    function army($id = 0)
    {
        $position = $this->Data_Model->get_position(5, $this->Player_Model->now_town);
        if (($this->Player_Model->now_town->build_line == '' or $this->Player_Model->build_line[$this->Player_Model->town_id][0]['type'] != 5) and
           (strlen($this->Player_Model->armys[$this->Player_Model->town_id]->army_line) <= getConfig('army_queue_size') * 4))
        {
            if ($position > 0 and $position == $id)
            {
                $all_cost['wood'] = 0;
                $all_cost['wine'] = 0;
                $all_cost['crystal'] = 0;
                $all_cost['sulfur'] = 0;
                $all_cost['peoples'] = 0;
                //$all_cost['gold'] = 0;
                $army_line = $this->Player_Model->armys[$this->Player_Model->town_id]->army_line;
                $army_start = ($this->Player_Model->armys[$this->Player_Model->town_id]->army_start > 0) ? $this->Player_Model->armys[$this->Player_Model->town_id]->army_start : time();
                // Обрабатываем данные
                for ($i = 1; $i <= 14; $i++)
                {
                    $class = $this->Data_Model->army_class_by_type($i);
                    $$class = (isset($_POST[$i])) ? floor($_POST[$i]) : 0 ;
                    $cost = $this->Data_Model->army_cost_by_type($i, $this->Player_Model->research, $this->Player_Model->levels[$this->Player_Model->town_id]);
                    $all_cost['wood'] = $all_cost['wood'] + $cost['wood']*$$class;
                    $all_cost['wine'] = $all_cost['wine'] + $cost['wine']*$$class;
                    $all_cost['crystal'] = $all_cost['crystal'] + $cost['crystal']*$$class;
                    $all_cost['sulfur'] = $all_cost['sulfur'] + $cost['sulfur']*$$class;
                    $all_cost['peoples'] = $all_cost['peoples'] + $cost['peoples']*$$class;
                    if ($$class > 0)
                    {
                        if ($army_line != '')
                        {
                            $army_line .= ';';
                        }
                        $army_line .= $i.','.$$class;
                    }
                }
                // Вычисляем остаток
                $wood = $this->Player_Model->now_town->wood - $all_cost['wood'];
                $wine = $this->Player_Model->now_town->wine - $all_cost['wine'];
                $crystal = $this->Player_Model->now_town->crystal - $all_cost['crystal'];
                $sulfur = $this->Player_Model->now_town->sulfur - $all_cost['sulfur'];
                $peoples = $this->Player_Model->now_town->peoples - $all_cost['peoples'];
                // Если хватает ресурсов
                if ($wood >= 0 and $wine >= 0 and $crystal >= 0 and $sulfur >= 0 and $peoples >= 0)
                {
                    // обновляем город
                    $this->Player_Model->now_town->wood = $wood;
                    $this->Player_Model->now_town->wine = $wine;
                    $this->Player_Model->now_town->crystal = $crystal;
                    $this->Player_Model->now_town->sulfur = $sulfur;
                    $this->Player_Model->now_town->peoples = $peoples;

                        $this->db->set('wood', $wood);
                        $this->db->set('wine', $wine);
                        $this->db->set('crystal', $crystal);
                        $this->db->set('sulfur', $sulfur);
                        $this->db->set('peoples', $peoples);
                        $this->db->where(array('id' => $this->Player_Model->town_id));
                        $this->db->update($this->session->userdata('universe').'_towns');
                    // обновляем армию
                    $this->Player_Model->armys[$this->Player_Model->town_id]->army_line = $army_line;
                    $this->Player_Model->armys[$this->Player_Model->town_id]->army_start = $army_start;
                    $this->Player_Model->army_line[$this->Player_Model->town_id] = $this->Data_Model->load_army_line($this->Player_Model->armys[$this->Player_Model->town_id]->army_line);

                        $this->db->set('army_line', $army_line);
                        $this->db->set('army_start', $army_start);
                        $this->db->where(array('city' => $this->Player_Model->town_id));
                        $this->db->update($this->session->userdata('universe').'_army');
                    // Обучение - найм копейщиков
                    if ($this->Player_Model->user->tutorial <= 10)
                    {
                        $this->tutorials('set', 11);
                    }
                }
            }
        }
        $this->show('barracks',$id);
    }

    function fleet($id = 0)
    {
        $position = $this->Data_Model->get_position(4, $this->Player_Model->now_town);
        if (($this->Player_Model->now_town->build_line == '' or $this->Player_Model->build_line[$this->Player_Model->town_id][0]['type'] != 4) and
           (strlen($this->Player_Model->armys[$this->Player_Model->town_id]->ships_line) <= getConfig('army_queue_size') * 4))
        {
            if ($position > 0 and $position == $id)
            {
                $all_cost['wood'] = 0;
                $all_cost['wine'] = 0;
                $all_cost['crystal'] = 0;
                $all_cost['sulfur'] = 0;
                $all_cost['peoples'] = 0;
                //$all_cost['gold'] = 0;
                $army_line = $this->Player_Model->armys[$this->Player_Model->town_id]->ships_line;
                $army_start = ($this->Player_Model->armys[$this->Player_Model->town_id]->ships_start > 0) ? $this->Player_Model->armys[$this->Player_Model->town_id]->ships_start : time();
                // Обрабатываем данные
                for ($i = 16; $i <= 22; $i++)
                {
                    $class = $this->Data_Model->army_class_by_type($i);
                    $$class = (isset($_POST[$i])) ? floor($_POST[$i]) : 0 ;
                    $cost = $this->Data_Model->army_cost_by_type($i, $this->Player_Model->research, $this->Player_Model->levels[$this->Player_Model->town_id]);
                    $all_cost['wood'] = $all_cost['wood'] + $cost['wood']*$$class;
                    $all_cost['wine'] = $all_cost['wine'] + $cost['wine']*$$class;
                    $all_cost['crystal'] = $all_cost['crystal'] + $cost['crystal']*$$class;
                    $all_cost['sulfur'] = $all_cost['sulfur'] + $cost['sulfur']*$$class;
                    $all_cost['peoples'] = $all_cost['peoples'] + $cost['peoples']*$$class;
                    if ($$class > 0)
                    {
                        if ($army_line != '')
                        {
                            $army_line .= ';';
                        }
                        $army_line .= $i.','.$$class;
                    }
                }
                // Вычисляем остаток
                $wood = $this->Player_Model->now_town->wood - $all_cost['wood'];
                $wine = $this->Player_Model->now_town->wine - $all_cost['wine'];
                $crystal = $this->Player_Model->now_town->crystal - $all_cost['crystal'];
                $sulfur = $this->Player_Model->now_town->sulfur - $all_cost['sulfur'];
                $peoples = $this->Player_Model->now_town->peoples - $all_cost['peoples'];
                // Если хватает ресурсов
                if ($wood >= 0 and $wine >= 0 and $crystal >= 0 and $sulfur >= 0 and $peoples >= 0)
                {
                    // обновляем город
                    $this->Player_Model->now_town->wood = $wood;
                    $this->Player_Model->now_town->wine = $wine;
                    $this->Player_Model->now_town->crystal = $crystal;
                    $this->Player_Model->now_town->sulfur = $sulfur;
                    $this->Player_Model->now_town->peoples = $peoples;

                        $this->db->set('wood', $wood);
                        $this->db->set('wine', $wine);
                        $this->db->set('crystal', $crystal);
                        $this->db->set('sulfur', $sulfur);
                        $this->db->set('peoples', $peoples);
                        $this->db->where(array('id' => $this->Player_Model->town_id));
                        $this->db->update($this->session->userdata('universe').'_towns');
                    // обновляем армию
                    $this->Player_Model->armys[$this->Player_Model->town_id]->ships_line = $army_line;
                    $this->Player_Model->armys[$this->Player_Model->town_id]->ships_start = $army_start;
                    $this->Player_Model->ships_line[$this->Player_Model->town_id] = $this->Data_Model->load_army_line($this->Player_Model->armys[$this->Player_Model->town_id]->ships_line);

                        $this->db->set('ships_line', $army_line);
                        $this->db->set('ships_start', $army_start);
                        $this->db->where(array('city' => $this->Player_Model->town_id));
                        $this->db->update($this->session->userdata('universe').'_army');
                }
            }
        }
        $this->show('shipyard',$id);
    }

    function armyEdit($type = '')
    {
        $peoples_army = 0;
        for ($i = 1; $i <= 22; $i++)
        {
                $class = $this->Data_Model->army_class_by_type($i);
                $$class = (isset($_POST[$i])) ? floor($_POST[$i]) : 0 ;
                $cost = $this->Data_Model->army_cost_by_type($i, $this->Player_Model->research, $this->Player_Model->levels[$this->Player_Model->town_id]);
                if ($this->Player_Model->armys[$this->Player_Model->town_id]->$class >= $$class)
                {
                    $peoples_army = $peoples_army + ($$class*$cost['peoples']);
                    $this->Player_Model->armys[$this->Player_Model->town_id]->$class = $this->Player_Model->armys[$this->Player_Model->town_id]->$class - $$class;
                }
                $this->db->set($class, $this->Player_Model->armys[$this->Player_Model->town_id]->$class);
        }
        $this->db->where(array('city' => $this->Player_Model->town_id));
        $this->db->update($this->session->userdata('universe').'_army');
        $this->Player_Model->now_town->peoples  = $this->Player_Model->now_town->peoples + $peoples_army;
        // Обновляем жителей
        $this->db->set('peoples', $this->Player_Model->now_town->peoples);
        $this->db->where(array('id' => $this->Player_Model->town_id));
        $this->db->update($this->session->userdata('universe').'_towns');
        $this->show($type);
    }

    function abortUnits($position = 0)
    {
        if($this->Player_Model->armys[$this->Player_Model->town_id]->army_line != '')
        {
                // обновляем армию
                $this->Player_Model->armys[$this->Player_Model->town_id]->army_line = '';
                $this->Player_Model->armys[$this->Player_Model->town_id]->army_start = 0;
                $this->Player_Model->army_line[$this->Player_Model->town_id] = $this->Data_Model->load_army_line($this->Player_Model->armys[$this->Player_Model->town_id]->army_line);
                $this->db->set('army_line', '');
                $this->db->set('army_start', 0);
                $this->db->where(array('city' => $this->Player_Model->town_id));
                $this->db->update($this->session->userdata('universe').'_army');
        }
        $this->show('barracks', $position);
    }

    function abortShips($position = 0)
    {
        if($this->Player_Model->armys[$this->Player_Model->town_id]->ships_line != '')
        {
                // обновляем армию
                $this->Player_Model->armys[$this->Player_Model->town_id]->ships_line = '';
                $this->Player_Model->armys[$this->Player_Model->town_id]->ships_start = 0;
                $this->Player_Model->ships_line[$this->Player_Model->town_id] = $this->Data_Model->load_army_line($this->Player_Model->armys[$this->Player_Model->town_id]->army_line);
                $this->db->set('ships_line', '');
                $this->db->set('ships_start', 0);
                $this->db->where(array('city' => $this->Player_Model->town_id));
                $this->db->update($this->session->userdata('universe').'_army');
        }
        $this->show('shipyard', $position);
    }

    function abortBuildings($town = 0)
    {
        $id = -1;
        for ($i = 0; $i < SizeOf($this->Player_Model->towns); $i++)
        {
            if ($this->Player_Model->towns[$i]->id == $town) { $id = $i; }
        }
        if($id >= 0 and $this->Player_Model->towns[$id]->build_line != '')
        {
                $this->Player_Model->now_town->build_line = '';
                $this->Player_Model->now_town->build_start = 0;
                $this->db->set('build_line', '');
                $this->db->set('build_start', 0);
                $this->db->where(array('id' => $this->Player_Model->town_id));
                $this->db->update($this->session->userdata('universe').'_towns');
        }
        $this->show('city', $town);
    }

    function premium($type = '')
    {
        $cost = $this->Data_Model->premium_cost($type);
        if ($this->Player_Model->user->ambrosy >= $cost)
        {
            switch($type)
            {
                case 'account': if($this->Player_Model->user->premium_account > 0){ $this->Player_Model->user->premium_account = $this->Player_Model->user->premium_account+604800; } else { $this->Player_Model->user->premium_account = time()+604800; } break;
                case 'wood': if($this->Player_Model->user->premium_wood > 0){ $this->Player_Model->user->premium_wood = $this->Player_Model->user->premium_wood+604800; } else { $this->Player_Model->user->premium_wood = time()+604800; } break;
                case 'wine': if($this->Player_Model->user->premium_wine > 0){ $this->Player_Model->user->premium_wine = $this->Player_Model->user->premium_wine+604800; } else { $this->Player_Model->user->premium_wine = time()+604800; } break;
                case 'marble': if($this->Player_Model->user->premium_marble > 0){ $this->Player_Model->user->premium_marble = $this->Player_Model->user->premium_marble+604800; } else { $this->Player_Model->user->premium_marble = time()+604800; } break;
                case 'crystal': if($this->Player_Model->user->premium_crystal > 0){ $this->Player_Model->user->premium_crystal = $this->Player_Model->user->premium_crystal+604800; } else { $this->Player_Model->user->premium_crystal = time()+604800; } break;
                case 'sulfur': if($this->Player_Model->user->premium_sulfur > 0){ $this->Player_Model->user->premium_sulfur = $this->Player_Model->user->premium_sulfur+604800; } else { $this->Player_Model->user->premium_sulfur = time()+604800; } break;
                case 'capacity': if($this->Player_Model->user->premium_capacity > 0){ $this->Player_Model->user->premium_capacity = $this->Player_Model->user->premium_capacity+604800; } else { $this->Player_Model->user->premium_capacity = time()+604800; } break;
            }
            $this->Player_Model->user->ambrosy = $this->Player_Model->user->ambrosy - $cost;
            $this->db->set('premium_account', $this->Player_Model->user->premium_account);
            $this->db->set('premium_wood', $this->Player_Model->user->premium_wood);
            $this->db->set('premium_wine', $this->Player_Model->user->premium_wine);
            $this->db->set('premium_marble', $this->Player_Model->user->premium_marble);
            $this->db->set('premium_crystal', $this->Player_Model->user->premium_crystal);
            $this->db->set('premium_sulfur', $this->Player_Model->user->premium_sulfur);
            $this->db->set('premium_capacity', $this->Player_Model->user->premium_capacity);
            $this->db->set('ambrosy', $this->Player_Model->user->ambrosy);
            $this->db->where(array('id' => $this->Player_Model->user->id));
            $this->db->update($this->session->userdata('universe').'_users');
        }
        $this->show('premium');
    }

    function options($type = '')
    {
        switch($type)
        {
            case 'user':
                if (isset($_POST['name']))
                {
                    $login = strip_tags($_POST['name']);
                    if ($login != $this->Player_Model->user->login)
                    {
                        $query = $this->db->get_where($this->session->userdata('universe').'_users', array('login' => $login));
                        // Если такого игрока нету
                        if ($query->num_rows == 0)
                        {
                            $this->Player_Model->user->login = $login;
                            $this->db->set('login', $login);
                            $this->db->where(array('id' => $this->Player_Model->user->id));
                            $this->db->update($this->session->userdata('universe').'_users');
                        }
                        else
                        {
                            $this->session->set_flashdata(array('options_error' => 'Ошибка!'));
                            $this->session->set_flashdata(array('options_error_login' => 'Имя '.$login.' уже занято.'));
                        }
                    }
                }
                if (isset($_POST['oldPassword']) and isset($_POST['newPassword']) and isset($_POST['newPasswordConfirm']))
                {
                    $old = md5(strip_tags($_POST['oldPassword']));
                    $new = md5(strip_tags($_POST['newPassword']));
                    $new2 = md5(strip_tags($_POST['newPasswordConfirm']));
                    if ($old != $new and $old != '' and $new != '')
                    {
                        if ($this->Player_Model->user->password == $old)
                        {
                            if ($new == $new2)
                            {
                                $this->Player_Model->user->password = $new;
                                $this->db->set('password', $new);
                                $this->db->where(array('id' => $this->Player_Model->user->id));
                                $this->db->update($this->session->userdata('universe').'_users');
                            }
                            else
                            {
                                $this->session->set_flashdata(array('options_error' => 'Ошибка!'));
                                $this->session->set_flashdata(array('options_error_login' => 'Неверный пароль!'));
                            }
                        }
                        else
                        {
                            $this->session->set_flashdata(array('options_error' => 'Ошибка!'));
                            $this->session->set_flashdata(array('options_error_login' => 'Неверное имя или пароль.'));
                        }
                    }
                }
                if (isset($_POST['citySelectOptions']))
                {
                    $city_select = floor($_POST['citySelectOptions']);
                    if ($city_select != $this->Player_Model->user->options_select and $city_select >=0 and $city_select <= 2)
                    {
                        $this->Player_Model->user->options_select = $city_select;
                        $this->db->set('options_select', $city_select);
                        $this->db->where(array('id' => $this->Player_Model->user->id));
                        $this->db->update($this->session->userdata('universe').'_users');
                    }
                }
                if (isset($_POST['tutorialOptions']))
                {
                    if ($this->Player_Model->user->tutorial < 999 and $_POST['tutorialOptions'] == -2)
                    {
                        $this->Player_Model->user->tutorial = 999;
                        $this->db->set('tutorial', 999);
                        $this->db->where(array('id' => $this->Player_Model->user->id));
                        $this->db->update($this->session->userdata('universe').'_users');
                    }
                }
            break;
            case 'validationEmail':
                $this->load->library('email');
                $this->load->helper('email');
                $config['mailtype'] = 'html';               // Тип письма text или html
                $this->email->initialize($config);
                if ($this->config->item('game_email'))
                {
                                        $message = '
                                            <html>
                                            <body>
                                             <p>Привет '.$this->Player_Model->user->login.', <br>
                                             <br>Вы решили создать империю в мире Икариам '.$this->session->userdata('universe').'!<br>
                                             <br>Нажмите на ссылку, чтобы подтвердить Ваш аккаунт:<br>
                                             <br><a href="'.$this->config->item('base_url').'main/validate/'.$this->session->userdata('universe').'/'.$this->Player_Model->user->register_key.'/" target="_blank">'.$this->config->item('base_url').'main/validate/'.$this->session->userdata('universe').'/'.$this->Player_Model->user->register_key.'</a><br>
                                             <br>Ваша информация для доступа:
                                             <br>Имя игрока: '.$this->Player_Model->user->login.'<br>Пароль: ***
                                             <br>Сервер: '.$this->session->userdata('universe').'<br>
                                             <br>Если Вам понадобится помощь, то Вы сможете найти ее на форуме Икариам ('.$this->config->item('forum_url').').<br><br>Удачи в игре,<br>Ваша команда Икариам.</p>
                                            </body>
                                            </html>';
                    $this->email->from(getConfig('admin_email'), 'Гермес');
                    $this->email->to($this->Player_Model->user->email);
                    $this->email->subject('Ваша активация для Икариам!');
                    $this->email->message($message);
                    $this->email->send();
                 }
            break;
        }
        $this->show('options');
    }

    function tavern($position = 0)
    {
        $position = floor($position);
        if(isset($_POST['amount']))
        {
            $type_text = 'pos'.$position.'_type';
            $level_text = 'pos'.$position.'_level';
            if ($this->Player_Model->now_town->$type_text == 8 and $this->Player_Model->now_town->$level_text >= floor($_POST['amount']))
            {
                $this->Player_Model->now_town->tavern_wine = floor($_POST['amount']);
                $this->db->set('tavern_wine', $this->Player_Model->now_town->tavern_wine);
                $this->db->where(array('id' => $this->Player_Model->town_id));
                $this->db->update($this->session->userdata('universe').'_towns');
            }
        }
        $this->show('tavern', $position);
    }

    function transporter()
    {
        $cost = $this->Data_Model->transport_cost_by_count($this->Player_Model->all_transports);
        if ($cost > 0 and $this->Player_Model->user->gold >= $cost)
        {
            $this->Player_Model->user->gold = $this->Player_Model->user->gold - $cost;
            $this->Player_Model->user->points_transports = $this->Player_Model->user->points_transports + $cost/15;
            $this->Player_Model->user->transports++;
            $this->Player_Model->all_transports++;
            $this->db->set('gold', $this->Player_Model->user->gold);
            $this->db->set('transports', $this->Player_Model->user->transports);
            $this->db->set('points_transports', $this->Player_Model->user->points_transports);
            $this->db->where(array('id' => $this->Player_Model->user->id));
            $this->db->update($this->session->userdata('universe').'_users');
        }
        header('Location: /game/port/'.$this->Player_Model->now_town->id);
    }

    function saveAvatarNotes()
    {
        $notes = strip_tags($_POST['notes']);
        if (strlen($notes <= getConfig('notes_default')) or (strlen($notes <= getConfig('notes_premium') and $this->Player_Model->user->premium_account > 0)))
        {
            $this->db->set('text', $notes);
            $this->db->where(array('user' => $this->Player_Model->user->id));
            $this->db->update($this->session->userdata('universe').'_notes');
        }
    }

    function transport($island = 0, $town = 0)
    {
        $town_id = intval($this->get_param('town_id'));
        if ($town_id <= 0)
        {
            $this->Error('bad town id');
            return;
        }

        if ($this->Player_Model->now_town->actions == 0)
        {
            $this->Error('no actions points available');
            return;
        }

        $town = $this->Data_Model->Load_Town($town);

        $resources = array();
        foreach ($this->Data_Model->user_sendable_resources() as $resource) {
            $count = intval($this->get_param($resource));
            if ($count < 0) {
                $this->Error("Cant send negative amount of resources");
                return;
            }
            $resources[$resource] = $count;
        }
        if (!$this->Action_Model->does_town_have_spare($this->Player_Model->now_town->id, $resources)) {
            $this->Error("Not enough resources");
            return;
        }

        $total_count = $this->Action_Model->count_resources($resources);
        if ($total_count == 0) {
            $this->Error("You cant send your ships empty");
            return;
        }

        $ship_count = $this->Action_Model->calc_ships($total_count);
        if ($this->Action_Model->count_available_ships($this->Player_Model->user->id) < $ship_count) {
            $this->Error("Not enough ships");
            return;
        }

        $town = $this->Data_Model->Load_Town($town_id);
        $this->remove_resources_from_town($this->Player_Model->now_town->id, $resources);

        $ports_levels = $this->Action_Model->levels_of_building_type($this->Player_Model->now_town->id, BUILDING::PORT);
        $mission_values = array_merge($resources, array(
            'from' => $this->Player_Model->now_town->id,
            'to' => $town->id,
            'state' => MissionState::LOADING->value,
            'type' => MissionType::TRANSPORT->value,
            'prev_stage_time' => time(),
            'next_stage_time' => time() + $this->Action_Model->calc_load_time($ports_levels, $total_count),
            'ships' => $ship_count,
        ));
        $this->db->insert($this->session->userdata('universe').'_missions', $mission_values);
        header('Location: /game/port');
    }

    /**
	 * Con questa funzione ricevo i dati dal form per attaccare
	 * TODO: add support for barbarian village.
	 */
	function attack($island = 0, $id = 0, $level = null)
	{
	    $island = floor($island);
        $id = floor($id);
        $transporters = isset($_POST['transporter']) ? $_POST['transporter'] : 0;
		$transports = $this->Player_Model->user->transports - $transporters;

		if (($this->Player_Model->user->transports >= $transporters) and ($transporters > 0) and ($transports >= 0) and ($this->Player_Model->now_town->actions > 0))
        {
            // Settiamo la destinazione
			$this->load->model('Island_Model');
            $this->Island_Model->Load_Island($island);
			
			$this->load->model('Battle_Model');
            $this->Player_Model->now_town->actions = $this->Player_Model->now_town->actions - 1;
            $this->db->set('actions', $this->Player_Model->now_town->actions);
			$this->Player_Model->user->transports = $transports;
			$this->db->where(array('id' => $this->Player_Model->user->town));
			$this->db->update($this->session->userdata('universe').'_towns');

            $this->db->set('transports', $transports);
            $this->db->where(array('id' => $this->Player_Model->user->id));
            $this->db->update($this->session->userdata('universe').'_users');
			
			if($id == 'barbarian_village')
			    $id = 'barbarian_village,'.$level.','.$island;
			$mission_array = array('user' => $this->Player_Model->user->id, 'from' => $this->Player_Model->now_town->id, 'to' => $id, 'loading_from_start' => time(), 'mission_type' => 5, 'wood' => 0, 'wine' => 0, 'marble' => 0, 'crystal' => 0, 'sulfur' => 0, 'ship_transport' => $transporters);
			
			$this->Data_Model->Load_Army($this->Player_Model->now_town->id);
			/* Set the attacker troops. */
            for($i = 1; $i <= 15; $i++)
			{
			    if(isset($_POST['cargo_army_'.$i]))
				{
					// Leviamo i soldati dalla città
	    			$class = $this->Data_Model->army_class_by_type($i);
					$this->db->set($this->Data_Model->army_class_by_type($i), $this->Player_Model->armys[$this->Player_Model->user->town]->$class - $_POST['cargo_army_'.$i]);
					$mission_array += array($this->Data_Model->army_class_by_type($i) => $_POST['cargo_army_'.$i]);
					
				}
				else 
				{
                    $mission_array += array($this->Data_Model->army_class_by_type($i) => 0);	
				}
			
			}
			$this->db->where(array('city' => $this->Player_Model->user->town));
            $this->db->update($this->session->userdata('universe').'_army');
			
			// add a mission
            $this->db->insert($this->session->userdata('universe').'_missions', $mission_array);
            
			if ($this->Player_Model->user->tutorial <= 9)
                $this->tutorials('set', 10);
            
			// Bring the player to the port
            $this->show('port');
			
		}
		else
        {
            $this->Error($this->lang->line('enough_action_points'));
        }
	}

    function remove_resources_from_town($town_id, $resources)
    {
        $town = $this->Data_Model->Load_Town($town_id);
        foreach ($resources as $resource => $count) {
            $town->$resource -= $count;
            $this->db->set($resource, $town->$resource);
        }
        $this->db->where(array('id' => $town->id));
        $this->db->update($this->session->userdata('universe').'_towns');
    }

    function remove_resources_from_user($user_id, $resources)
    {
        $user = $this->Data_Model->Load_User($user_id);
        foreach ($resources as $resource => $count) {
            $user->$resource -= $count;
            $this->db->set($resource, $user->$resource);
        }
        $this->db->where(array('id' => $user->id));
        $this->db->update($this->session->userdata('universe').'_users');
    }

    function borrow_ships($user_id, $ship_count)
    {
        $user = $this->Data_Model->Load_User($user_id);
        $user->transports -= $ship_count;
        $this->db->set('transports', $user->transports);
        $this->db->where(array('id' => $user->id));
        $this->db->update($this->session->userdata('universe').'_users');
    }

    function colonize_position($island_id, $position, $user_id)
    {
        $town_values = array(
            'user' => $user_id,
            'island' => $island_id,
            'position' => $position,
            'last_update' => time(),
            'pos0_level' => 0,
        );
        $this->db->insert($this->session->userdata('universe').'_towns', $town_values);

        $town_query = $this->db->get_where($this->session->userdata('universe').'_towns', array('island' => $island_id, 'position' => $position));
        $town = $town_query->row();

        $city_text = 'city'.$position;
        $this->db->set('city'.$position, $town->id);
        $this->db->where(array('id' => $island_id));
        $this->db->update($this->session->userdata('universe').'_islands');
        return $town;
    }

    function relocate()
    {
        $new_island = $this->Data_Model->Load_Island($this->get_param('island_id'));
        $old_island = $this->Data_Model->Load_Island($this->Player_Model->now_town->island);
        $position = $this->get_param('island_position');

        $current_town = $this->Player_Model->now_town;
        $current_user = $this->Player_Model->user;

        if ($current_user->ambrosy < 200) {
            $this->Error("Not enoguh ambrosy");
            return;
        }

        $old_position = -1;
        for ($i = 0; $i <= 15; $i++)
        {
            $city_now = 'city'.$i;
            if ($old_island->$city_now == $current_town->id)
            {
                $old_position = $i;
                break;
            }
        }
        if ($old_position == -1) {
            error_log("Failed to get current city position");
            $this-Error("Internal error");
            return;
        }

        $new_position = 'city'.$position;
        error_log($new_position);
        if($new_island->$new_position != 0)
        {
            $this->Error("This position is already occupied");
            return;
        }

        $this->db->set('city'.$old_position, 0);
        $this->db->where(array('id' => $old_island->id));
        $this->db->update($this->session->userdata('universe').'_islands');

        $this->db->set($new_position, $current_town->id);
        $this->db->where(array('id' => $new_island->id));
        $this->db->update($this->session->userdata('universe').'_islands');

        $this->db->set('island', $new_island->id);
        $this->db->set('position', $position);
        $this->db->where(array('id' => $current_town->id));
        $this->db->update($this->session->userdata('universe').'_towns');

        $current_user->ambrosy = $current_user->ambrosy - 200;
        $this->db->set('ambrosy', $current_user->ambrosy);
        $this->db->where(array('id' => $current_user->id));
        $this->db->update($this->session->userdata('universe').'_users');

        header('Location: /game/island/'.$island_id);
    }

    function colonize()
    {
        $new_island = $this->Data_Model->Load_Island($this->get_param('island_id'));
        $position = floor($this->get_param('island_position'));
        $old_island = $this->Data_Model->Load_Island($this->Player_Model->now_town->island);

        if ($this->Player_Model->now_town->actions == 0)
        {
            $this->Error('No action points!');
            return;
        }
        if ($this->Action_Model->is_town_occupied($new_island->id, $position))
        {
            $this->Error('This position is already occupied');
            return;
        }

        $ports_levels = $this->Action_Model->levels_of_building_type($this->Player_Model->now_town->id, BUILDING::PORT);
        if (count($ports_levels) == 0) {
            $this->Error('No ports in current city');
            return;
        }

        if(SizeOf($this->Player_Model->towns) - 1 >= $this->Player_Model->levels[$this->Player_Model->capital_id][10])
        {
            $this->Error('Maximum amount of colonies for current palace level');
            return;
        }

        if ($this->Player_Model->now_town->actions == 0)
        {
            $this->Error('no actions points available');
            return;
        }

        // TODO negative amount validation
        $resources = array(
            'wood' => floor($this->get_param('sendresource')) + 1250,
            'wine' => floor($this->get_param('sendwine')),
            'marble' => floor($this->get_param('sendmarble')),
            'crystal' => floor($this->get_param('sendcrystal')),
            'sulfur' => floor($this->get_param('sendsulfur')),
            'peoples' => 40,
        );
        $resource_count = $this->Action_Model->count_resources($resources);

        $ship_count = $this->Action_Model->calc_ships($resource_count);
        if ($this->Action_Model->count_available_ships($this->Player_Model->user->id) < $ship_count) {
            $this->Error("Not enough ships");
            return;
        }

        $user_resources = array(
            'gold' => 9000
        );

        if (!$this->Action_Model->does_town_have_spare($this->Player_Model->now_town->id, $resources) or
            !$this->Action_Model->does_user_have_spare($this->Player_Model->user->id, $user_resources))
        {
            $this->Error("Not enough resources");
            return;
        }
        $town = $this->colonize_position($new_island->id, $position, $this->Player_Model->user->id);
        $this->remove_resources_from_town($this->Player_Model->now_town->id, $resources);
        $this->remove_resources_from_user($this->Player_Model->user->id, $user_resources);

        unset($resources['actions']);
        $mission_values = array_merge($resources, array(
            'from' => $this->Player_Model->now_town->id,
            'to' => $town->id,
            'state' => MissionState::LOADING->value,
            'type' => MissionType::COLONIZE->value,
            'prev_stage_time' => time(),
            'next_stage_time' => time() + $this->Action_Model->calc_load_time($ports_levels, $resource_count),
            'ships' => $ship_count,
        ));
        $this->db->insert($this->session->userdata('universe').'_missions', $mission_values);
        header('Location: /game/island/'.$id);
    }

    function abortFleet($mission = 0, $position = 0, $redirect = 'port')
    {
        if (isset($this->Player_Model->missions[$mission]))
        {
            if ($this->Player_Model->missions[$mission]->mission_start == 0)
            {
                // Colonization
                // If not loaded yet, delete the city and return the resources
                if($this->Player_Model->missions[$mission]->mission_type == 1)
                {
                    // Delete the city
                    $town_query = $this->db->get_where($this->session->userdata('universe').'_towns', array('id' => $this->Player_Model->missions[$mission]->to));
                    $town = $town_query->row();
                    $this->db->set('city'.$town->position, 0);
                    $this->db->where(array('id' => $town->island));
                    $this->db->update($this->session->userdata('universe').'_islands');
                    $this->db->query('DELETE FROM '.$this->session->userdata('universe').'_towns where `id`="'.$this->Player_Model->missions[$mission]->to.'"');
                }
                    // return resources
                    $this->db->set('wood', $this->Player_Model->towns[$this->Player_Model->missions[$mission]->from]->wood + $this->Player_Model->missions[$mission]->wood);
                    $this->db->set('wine', $this->Player_Model->towns[$this->Player_Model->missions[$mission]->from]->wine + $this->Player_Model->missions[$mission]->wine);
                    $this->db->set('marble', $this->Player_Model->towns[$this->Player_Model->missions[$mission]->from]->marble + $this->Player_Model->missions[$mission]->marble);
                    $this->db->set('crystal', $this->Player_Model->towns[$this->Player_Model->missions[$mission]->from]->crystal + $this->Player_Model->missions[$mission]->crystal);
                    $this->db->set('sulfur', $this->Player_Model->towns[$this->Player_Model->missions[$mission]->from]->sulfur + $this->Player_Model->missions[$mission]->sulfur);
                    $this->db->set('peoples', $this->Player_Model->towns[$this->Player_Model->missions[$mission]->from]->peoples + $this->Player_Model->missions[$mission]->peoples);
                    $this->db->where(array('id' => $this->Player_Model->missions[$mission]->from));
                    $this->db->update($this->session->userdata('universe').'_towns');
                    $this->db->set('gold', $this->Player_Model->user->gold + $this->Player_Model->missions[$mission]->gold);
                    $this->db->set('transports', $this->Player_Model->user->transports + $this->Player_Model->missions[$mission]->ship_transport);
                    $this->db->where(array('id' => $this->Player_Model->user->id));
                    $this->db->update($this->session->userdata('universe').'_users');
                    $this->db->query('DELETE FROM '.$this->session->userdata('universe').'_missions where `id`="'.$this->Player_Model->missions[$mission]->id.'"');
            }
            else
            {
                // Если погрузили просто разворачиваем
                if($this->Player_Model->missions[$mission]->return_start == 0)
                {
                    $cost = $this->Data_Model->army_cost_by_type(23, $this->Player_Model->research, $this->Player_Model->levels[$this->Player_Model->town_id]);
                    $x1 = $this->Data_Model->temp_islands_db[$this->Data_Model->temp_towns_db[$this->Player_Model->missions[$mission]->from]->island]->x;
                    $x2 = $this->Data_Model->temp_islands_db[$this->Data_Model->temp_towns_db[$this->Player_Model->missions[$mission]->to]->island]->x;
                    $y1 = $this->Data_Model->temp_islands_db[$this->Data_Model->temp_towns_db[$this->Player_Model->missions[$mission]->from]->island]->y;
                    $y2 = $this->Data_Model->temp_islands_db[$this->Data_Model->temp_towns_db[$this->Player_Model->missions[$mission]->to]->island]->y;
                    $time = $this->Data_Model->time_by_coords($x1,$x2,$y1,$y2,$cost['speed']);
                    $elapsed = time() - $this->Player_Model->missions[$mission]->mission_start;
                    $ostalos = ($time - $elapsed >= 0) ? $time - $elapsed : 0;
                    $return_time = $time - $elapsed;
                    $this->Player_Model->missions[$mission]->percent = 1 - $return_time/$time;
                    $this->db->set('percent', $this->Player_Model->missions[$mission]->percent);
                    $this->db->set('return_start', time());
                    $this->db->where(array('id' => $this->Player_Model->missions[$mission]->id));
                    $this->db->update($this->session->userdata('universe').'_missions');
                }
            }
        }
        redirect($this->config->item('base_url').'game/'.$redirect.'/'.$position.'/', 'refresh');
    }

    function leaveConstructionList($id = 1)
    {
        if(isset($this->Player_Model->build_line[$this->Player_Model->town_id][$id]) and $id > 0)
        {
            if (SizeOf($this->Player_Model->build_line[$this->Player_Model->town_id]) > 1)
            for ($i = 0; $i < SizeOf($this->Player_Model->build_line[$this->Player_Model->town_id]); $i++)
            {
                if ($i != $id)
                {
                    $building = array($this->Player_Model->build_line[$this->Player_Model->town_id][$i]['position'], $this->Player_Model->build_line[$this->Player_Model->town_id][$i]['type']);
                    $building_line[] = implode(",", $building);
                }
            }
            $buildings_line = implode(";", $building_line);
            $this->Player_Model->now_town->build_line = $buildings_line;
            $this->db->set('build_line', $buildings_line);
            $this->db->where(array('id' => $this->Player_Model->town_id));
            $this->db->update($this->session->userdata('universe').'_towns');
        }
        $this->show('city');
    }

    function branchOffice($position)
    {
        if (isset($_POST['type']) and isset($_POST['searchResource']))
        {
            $type = ($_POST['type'] <= 1) ? floor($_POST['type']) : 0;
            switch($_POST['searchResource'])
            {
                case 1: $resource = 1; break;
                case 2: $resource = 2; break;
                case 3: $resource = 3; break;
                case 4: $resource = 4; break;
                default: $resource = 0; break;
            }
            $this->Player_Model->now_town->branch_search_type = $type;
            $this->Player_Model->now_town->branch_search_resource = $resource;
            $this->Player_Model->now_town->branch_search_radius = floor($_POST['range']);
            $this->db->set('branch_search_type', $type);
            $this->db->set('branch_search_resource', $resource);
            $this->db->set('branch_search_radius', floor($_POST['range']));
            $this->db->where(array('id' => $this->Player_Model->town_id));
            $this->db->update($this->session->userdata('universe').'_towns');
        }
        if(isset($_POST['resource']) and isset($_POST['tradegood1']) and isset($_POST['tradegood2']) and isset($_POST['tradegood3']) and isset($_POST['tradegood4']))
        {
            $wood_count = floor($_POST['resource']);
            $wine_count = floor($_POST['tradegood1']);
            $marble_count = floor($_POST['tradegood2']);
            $crystal_count = floor($_POST['tradegood3']);
            $sulfur_count = floor($_POST['tradegood4']);
            $gold_wood = floor($_POST['resourcePrice']);
            $gold_wine = floor($_POST['tradegood1Price']);
            $gold_marble = floor($_POST['tradegood2Price']);
            $gold_crystal = floor($_POST['tradegood3Price']);
            $gold_sulfur = floor($_POST['tradegood4Price']);
            $capacity = $this->Data_Model->branchOffice_capacity_by_level($this->Player_Model->levels[$this->Player_Model->town_id][12]);
            $all_trade_resources = 0;
            if($_POST['resourceTradeType'] == 1){ $all_trade_resources = $all_trade_resources + $wood_count; }
            if($_POST['tradegood1TradeType'] == 1){ $all_trade_resources = $all_trade_resources + $wine_count; }
            if($_POST['tradegood2TradeType'] == 1){ $all_trade_resources = $all_trade_resources + $marble_count; }
            if($_POST['tradegood3TradeType'] == 1){ $all_trade_resources = $all_trade_resources + $crystal_count; }
            if($_POST['tradegood4TradeType'] == 1){ $all_trade_resources = $all_trade_resources + $sulfur_count; }
            for($i = 0; $i <= 4; $i++)
            {
                $resource_name = $this->Data_Model->resource_class_by_type($i);
                $branch_type = 'branch_trade_'.$resource_name.'_type';
                $branch_count = 'branch_trade_'.$resource_name.'_count';
                $branch_cost = 'branch_trade_'.$resource_name.'_cost';
                switch($i)
                {
                    case 1: $post_name = 'tradegood1'; $count = $wine_count; $gold = $gold_wine; break;
                    case 2: $post_name = 'tradegood2'; $count = $marble_count; $gold = $gold_marble; break;
                    case 3: $post_name = 'tradegood3'; $count = $crystal_count; $gold = $gold_crystal; break;
                    case 4: $post_name = 'tradegood4'; $count = $sulfur_count; $gold = $gold_sulfur; break;
                    default: $post_name = 'resource'; $count = $wood_count; $gold = $gold_wood; break;
                }
                if ($count == 0){ $gold = 0; }
                if ($gold == 0){ $count = 0; }
                if ($_POST[$post_name.'TradeType'] == 1 and $all_trade_resources <= $capacity)
                {
                    if($this->Player_Model->now_town->$branch_type == 1){
                        $this->Player_Model->now_town->$resource_name = $this->Player_Model->now_town->$resource_name + $this->Player_Model->now_town->$branch_count - $count;
                    }else{
                        $this->Player_Model->user->gold = $this->Player_Model->user->gold + ($this->Player_Model->now_town->$branch_count*$this->Player_Model->now_town->$branch_cost);
                        $this->Player_Model->now_town->$resource_name = $this->Player_Model->now_town->$resource_name  - $count;
                    }
                    $this->Player_Model->now_town->$branch_type = floor($_POST[$post_name.'TradeType']);
                    $this->Player_Model->now_town->$branch_count = $count;
                    $this->Player_Model->now_town->$branch_cost = $gold;
                }
                elseif ($_POST[$post_name.'TradeType'] == 0)
                {
                    if($this->Player_Model->now_town->$branch_type == 0){
                        $this->Player_Model->user->gold = $this->Player_Model->user->gold + ($this->Player_Model->now_town->$branch_count*$this->Player_Model->now_town->$branch_cost) - ($gold*$count);
                    }
                    else
                    {
                        $this->Player_Model->now_town->$resource_name = $this->Player_Model->now_town->$resource_name + $this->Player_Model->now_town->$branch_count;
                        $this->Player_Model->user->gold = $this->Player_Model->user->gold - ($gold*$count);
                    }
                    $this->Player_Model->now_town->$branch_type = floor($_POST[$post_name.'TradeType']);
                    $this->Player_Model->now_town->$branch_count = $count;
                    $this->Player_Model->now_town->$branch_cost = $gold;
                }
            }
            if($this->Player_Model->user->gold >= 0 and
               $this->Player_Model->now_town->wood >= 0 and
               $this->Player_Model->now_town->wine >= 0 and
               $this->Player_Model->now_town->marble >= 0 and
               $this->Player_Model->now_town->crystal >= 0 and
               $this->Player_Model->now_town->sulfur >= 0)
            {
                for($i = 0; $i <= 4; $i++)
                {
                    $resource_name = $this->Data_Model->resource_class_by_type($i);
                    $branch_type = 'branch_trade_'.$resource_name.'_type';
                    $branch_count = 'branch_trade_'.$resource_name.'_count';
                    $branch_cost = 'branch_trade_'.$resource_name.'_cost';

                    $this->db->set($resource_name, $this->Player_Model->now_town->$resource_name);
                    $this->db->set($branch_type, $this->Player_Model->now_town->$branch_type);
                    $this->db->set($branch_count, $this->Player_Model->now_town->$branch_count);
                    $this->db->set($branch_cost, $this->Player_Model->now_town->$branch_cost);
                }
                $this->db->where(array('id' => $this->Player_Model->town_id));
                $this->db->update($this->session->userdata('universe').'_towns');
                $this->db->set('gold', $this->Player_Model->user->gold);
                $this->db->where(array('id' => $this->Player_Model->user->id));
                $this->db->update($this->session->userdata('universe').'_users');
            }
        }
        $this->show('branchOffice', $position);
    }

    function trade($town = 0, $type = 0)
    {
        if ($this->Player_Model->now_town->actions > 0)
        {
            if ($town > 0)
            {
                // Читаем данные
                $wood_count = (isset($_POST['cargo_resource']) and floor($_POST['cargo_resource']) > 0) ? floor($_POST['cargo_resource']) : 0;
                $wine_count = (isset($_POST['cargo_tradegood1']) and floor($_POST['cargo_tradegood1']) > 0) ? floor($_POST['cargo_tradegood1']) : 0;
                $marble_count = (isset($_POST['cargo_tradegood2']) and floor($_POST['cargo_tradegood2']) > 0) ? floor($_POST['cargo_tradegood2']) : 0;
                $crystal_count = (isset($_POST['cargo_tradegood3']) and floor($_POST['cargo_tradegood3']) > 0) ? floor($_POST['cargo_tradegood3']) : 0;
                $sulfur_count = (isset($_POST['cargo_tradegood4']) and floor($_POST['cargo_tradegood4']) > 0) ? floor($_POST['cargo_tradegood4']) : 0;
                $wood_cost = (isset($_POST['resourcePrice']) and floor($_POST['resourcePrice']) > 0) ? floor($_POST['resourcePrice']) : 0;
                $wine_cost = (isset($_POST['tradegood1Price']) and floor($_POST['tradegood1Price']) > 0) ? floor($_POST['tradegood1Price']) : 0;
                $marble_cost = (isset($_POST['tradegood2Price']) and floor($_POST['tradegood2Price']) > 0) ? floor($_POST['tradegood2Price']) : 0;
                $crystal_cost = (isset($_POST['tradegood3Price']) and floor($_POST['tradegood3Price']) > 0) ? floor($_POST['tradegood3Price']) : 0;
                $sulfur_cost = (isset($_POST['tradegood4Price']) and floor($_POST['tradegood4Price']) > 0) ? floor($_POST['tradegood4Price']) : 0;
                $gold_need = floor(($wood_count*$wood_cost) + ($wine_count*$wine_cost) + ($marble_count*$marble_cost) + ($crystal_count*$crystal_cost) + ($sulfur_count*$sulfur_cost));
                $transporters = floor($_POST['transporters']);

                $transports = $this->Player_Model->user->transports - $transporters;

                $this->Data_Model->Load_Town($town);
                if(isset($this->Data_Model->temp_towns_db[$town]))
                {
                    if ($this->Player_Model->user->gold > 0 and $transports > 0)
                    {
                        if ($type == 1)
                        {
                            $this->Player_Model->user->gold = $this->Player_Model->user->gold - $gold_need;
                            if ($this->Player_Model->user->gold > 0)
                            {
                                $trade_town = $this->Data_Model->temp_towns_db[$town];
                                $this->Player_Model->user->transports = $transports;
                                $this->db->set('gold', $this->Player_Model->user->gold);
                                $this->db->set('transports', $transports);
                                $this->db->where(array('id' => $this->Player_Model->user->id));
                                $this->db->update($this->session->userdata('universe').'_users');
                                $this->db->insert($this->session->userdata('universe').'_missions', array('user' => $this->Player_Model->user->id, 'from' => $this->Player_Model->now_town->id, 'to' => $town, 'loading_from_start' => time(), 'mission_start' => time(), 'mission_type' => 3, 'trade_wood_count' => $wood_count, 'trade_wine_count' => $wine_count, 'trade_marble_count' => $marble_count, 'trade_crystal_count' => $crystal_count, 'trade_sulfur_count' => $sulfur_count, 'gold' => $gold_need, 'trade_wood_cost' => $wood_cost, 'trade_wine_cost' => $wine_cost, 'trade_marble_cost' => $marble_cost, 'trade_crystal_cost' => $crystal_cost, 'trade_sulfur_cost' => $sulfur_cost, 'ship_transport' => $transporters));
                                $this->Player_Model->now_town->actions = $this->Player_Model->now_town->actions - 1;
                                $this->db->set('actions', $this->Player_Model->now_town->actions);
                                $this->db->where(array('id' => $this->Player_Model->now_town->id));
                                $this->db->update($this->session->userdata('universe').'_towns');
                            }
                        }
                        if($type == 0)
                        {
                            $trade_town = $this->Data_Model->temp_towns_db[$town];
                            // Вычитаем остаток
                            $wood = $this->Player_Model->now_town->wood - $wood_count;
                            $wine = $this->Player_Model->now_town->wine - $wine_count;
                            $marble = $this->Player_Model->now_town->marble - $marble_count;
                            $crystal = $this->Player_Model->now_town->crystal - $crystal_count;
                            $sulfur = $this->Player_Model->now_town->sulfur - $sulfur_count;
                            if ($wood >= 0 and $wine >=0 and $marble >= 0 and $crystal >= 0 and $sulfur >=0)
                            {
                                $this->Player_Model->user->transports = $transports;
                                $this->db->set('transports', $transports);
                                $this->db->where(array('id' => $this->Player_Model->user->id));
                                $this->db->update($this->session->userdata('universe').'_users');
                                $this->db->insert($this->session->userdata('universe').'_missions', array('user' => $this->Player_Model->user->id, 'from' => $this->Player_Model->now_town->id, 'to' => $town, 'loading_from_start' => time(), 'mission_type' => 4, 'wood' => $wood_count, 'wine' => $wine_count, 'marble' => $marble_count, 'crystal' => $crystal_count, 'sulfur' => $sulfur_count, 'trade_wood_cost' => $wood_cost, 'trade_wine_cost' => $wine_cost, 'trade_marble_cost' => $marble_cost, 'trade_crystal_cost' => $crystal_cost, 'trade_sulfur_cost' => $sulfur_cost, 'ship_transport' => $transporters));
                                $this->Player_Model->now_town->wood = $wood;
                                $this->Player_Model->now_town->wine = $wine;
                                $this->Player_Model->now_town->marble = $marble;
                                $this->Player_Model->now_town->crystal = $crystal;
                                $this->Player_Model->now_town->sulfur = $sulfur;
                                $this->Player_Model->now_town->aactions = $this->Player_Model->now_town->actions - 1;
                                $this->db->set('wood', $wood);
                                $this->db->set('wine', $wine);
                                $this->db->set('marble', $marble);
                                $this->db->set('crystal', $crystal);
                                $this->db->set('sulfur', $sulfur);
                                $this->db->set('actions', $this->Player_Model->now_town->actions);
                                $this->db->where(array('id' => $this->Player_Model->now_town->id));
                                $this->db->update($this->session->userdata('universe').'_towns');
                            }
                        }
                    }
                }
            }
            $this->show('branchOffice');
        }
        else
        {
            $this->Error('Недостаточно баллов действий!');
        }
    }

    function tradeRoute($delete_id = 0)
    {
        if ($delete_id > 0)
        {
            if (isset($this->Player_Model->trade_routes[$delete_id]))
            {
                $this->db->delete($this->session->userdata('universe').'_trade_routes', array('id' => $delete_id));
            }
        }
        else
        {
            if (isset($_POST['city1Id']) and isset($_POST['city2Id']) and $_POST['city1Id'] > 0 and $_POST['city2Id'] > 0 and $_POST['city1Id'] != $_POST['city2Id'])
            {
                $from = floor($_POST['city1Id']);
                $to = floor($_POST['city2Id']);
                $tradegood = floor($_POST['tradegood']);
                $time = floor($_POST['time']);
                $number = floor($_POST['number']);
                $update_time = route_time(time(), $time);

                if ($from > 0 and $to > 0 and $tradegood >= 0 and $tradegood <= 4 and $time >= 0 and $time <= 24 and $number > 0)
                {
                    if(!isset($_POST['save']))
                    {
                        if (SizeOf($this->Player_Model->trade_routes) == 0)
                        {
                            $this->db->insert($this->session->userdata('universe').'_trade_routes', array('user' => $this->Player_Model->user->id, 'from' => $from, 'to' => $to, 'start_time' => time(), 'update_time' => $update_time, 'send_resource' => $tradegood, 'send_time' => $time, 'send_count' => $number));
                        }
                        else
                        {
                            if($this->Player_Model->user->ambrosy >= 10)
                            {
                                $this->db->insert($this->session->userdata('universe').'_trade_routes', array('user' => $this->Player_Model->user->id, 'from' => $from, 'to' => $to, 'start_time' => time(), 'update_time' => $update_time, 'send_resource' => $tradegood, 'send_time' => $time, 'send_count' => $number));
                                $this->db->set('ambrosy', $this->Player_Model->user->ambrosy - 10);
                                $this->db->where(array('id' => $this->Player_Model->user->id));
                                $this->db->update($this->session->userdata('universe').'_users');
                            }
                        }
                    }
                    else
                    {
                        if (isset($_POST['route']) and isset($this->Player_Model->trade_routes[floor($_POST['route'])]))
                        {
                            $this->db->set('from', $from);
                            $this->db->set('to', $to);
                            $this->db->set('update_time', $update_time);
                            $this->db->set('send_resource', $tradegood);
                            $this->db->set('send_time', $time);
                            $this->db->set('send_count', $number);
                            $this->db->where(array('id' => floor($_POST['route'])));
                            $this->db->update($this->session->userdata('universe').'_trade_routes');
                        }
                    }
                }
            }
            else
            {
                $this->Error('Выберите город!');
            }
        }
        redirect($this->config->item('base_url').'game/tradeAdvisorTradeRoute/', 'refresh');
    }

    function spyes($action = 'buy', $island = 0, $town = 0)
    {
        $all_spyes = SizeOf($this->Player_Model->spyes[$this->Player_Model->town_id])+$this->Player_Model->now_town->spyes;
        if ($action == 'buy' and $this->Player_Model->user->gold >= 150 and $this->Player_Model->now_town->crystal >= 80 and $this->Player_Model->now_town->spyes_start == 0 and ($this->Player_Model->levels[$this->Player_Model->town_id][14]-$all_spyes) > 0)
        {
            $this->db->set('gold', $this->Player_Model->user->gold - 150);
            $this->db->where(array('id' => $this->Player_Model->user->id));
            $this->db->update($this->session->userdata('universe').'_users');
            $this->db->set('crystal', $this->Player_Model->now_town->crystal - 80);
            $this->db->set('spyes_start', time());
            $this->db->where(array('id' => $this->Player_Model->now_town->id));
            $this->db->update($this->session->userdata('universe').'_towns');
        }
        if ($action == 'send' and $this->Player_Model->user->gold >= 30 and $this->Player_Model->now_town->spyes > 0)
        {
            if ($island == 0)
            {
                $island = $this->Player_Model->island_id;
            }
            $this->load->model('Island_Model');
            $this->Island_Model->Load_Island($island);
            $this->Data_Model->Load_Town($town);
            if(isset($this->Data_Model->temp_towns_db[$town]) and $this->Data_Model->temp_towns_db[$town]->island == $this->Island_Model->island->id)
            {
                $this->db->insert($this->session->userdata('universe').'_spyes', array('user' => $this->Player_Model->user->id, 'from' => $this->Player_Model->now_town->id, 'to' => $town, 'mission_type' => 1, 'mission_start' => time()));
                $this->db->set('spyes', $this->Player_Model->now_town->spyes-1);
                $this->db->where(array('id' => $this->Player_Model->now_town->id));
                $this->db->update($this->session->userdata('universe').'_towns');
                $this->db->set('gold', $this->Player_Model->user->gold-30);
                $this->db->where(array('id' => $this->Player_Model->user->id));
                $this->db->update($this->session->userdata('universe').'_users');
            }
        }
        if ($action == 'return' and isset($this->Player_Model->spyes[$town][$island]))
        {
            $this->db->set('mission_type', 2);
            $this->db->set('mission_start', time());
            $this->db->where(array('id' => $island));
            $this->db->update($this->session->userdata('universe').'_spyes');
        }
        redirect($this->config->item('base_url').'game/safehouse/', 'refresh');
    }

    function abolishColony()
    {
        if($this->Player_Model->town_id != $this->Player_Model->capital_id and SizeOf($this->Player_Model->missions) == 0)
        {
            $this->db->delete($this->session->userdata('universe').'_towns', array('id' => $this->Player_Model->town_id));
            $this->db->delete($this->session->userdata('universe').'_army', array('city' => $this->Player_Model->town_id));
            $this->db->delete($this->session->userdata('universe').'_town_messages', array('town' => $this->Player_Model->town_id));
            $this->db->delete($this->session->userdata('universe').'_town_messages', array('town' => $this->Player_Model->town_id));
            $this->db->set('city'.$this->Player_Model->now_town->position, 0);
            $this->db->where(array('id' => $this->Player_Model->now_town->island));
            $this->db->update($this->session->userdata('universe').'_islands');
            $this->db->query('UPDATE '.$this->session->userdata('universe').'_trade_routes SET `from`=0, `send_count`=0, `send_resource`=0, `send_time`=0 WHERE `from`='.$this->Player_Model->town_id);
            $this->db->query('UPDATE '.$this->session->userdata('universe').'_trade_routes SET `to`=0, `send_count`=0, `send_resource`=0, `send_time`=0 WHERE `to`='.$this->Player_Model->town_id);
            $this->db->set('town', $this->Player_Model->capital_id);
            $this->db->where(array('id' => $this->Player_Model->user->id));
            $this->db->update($this->session->userdata('universe').'_users');
        }
        else
        {
            $this->Error('Не возможно сейчас покинуть колонию!');
        }
        redirect($this->config->item('base_url').'game/city/', 'refresh');
    }

    function changeCapital($town = 0)
    {
        if($town > 0 and isset($this->Player_Model->towns[$town]) and $town != $this->Player_Model->capital_id)
        {
            $palace_position = $this->Data_Model->get_position(10, $this->Player_Model->towns[$this->Player_Model->capital_id]);
            $colony_position = $this->Data_Model->get_position(15, $this->Player_Model->towns[$town]);
            if ($palace_position > 0 and $colony_position > 0)
            {
                $building_line = array();
                if (SizeOf($this->Player_Model->build_line[$town]) > 1)
                    for ($i = 0; $i < SizeOf($this->Player_Model->build_line[$town]); $i++)
                    {
                        if ($this->Player_Model->build_line[$town][$i]['type'] != 10)
                        {
                            $building = array($this->Player_Model->build_line[$town][$i]['position'], $this->Player_Model->build_line[$town][$i]['type']);
                            $building_line[] = implode(",", $building);
                        }
                    }
                $buildings_line = implode(";", $building_line);
                $this->db->set('build_line', $buildings_line);
                $this->db->set('pos'.$colony_position.'_type', 10);
                $this->db->where(array('id' => $town));
                $this->db->update($this->session->userdata('universe').'_towns');
                $this->db->set('pos'.$palace_position.'_type', 0);
                $this->db->set('pos'.$palace_position.'_level', 0);
                $this->db->where(array('id' => $this->Player_Model->capital_id));
                $this->db->update($this->session->userdata('universe').'_towns');
                $this->db->set('capital', $town);
                $this->db->where(array('id' => $this->Player_Model->user->id));
                $this->db->update($this->session->userdata('universe').'_users');
                redirect($this->config->item('base_url').'game/palace/', 'refresh');
            }
            else
            {
                redirect($this->config->item('base_url').'game/palaceColony/', 'refresh');
            }
        }
        else
        {
            redirect($this->config->item('base_url').'game/palaceColony/', 'refresh');
        }
    }
    
    function espionage($town = 0, $spy = 0, $mission = 0)
    {
        $msg_id = 0;
        $town = floor($town);
        $spy = floor($spy);
        $mission = floor($mission);
        if (isset($this->Player_Model->spyes[$town][$spy]) and $mission >= 3 and $mission <= 10)
        {
            if($this->Player_Model->user->gold >= $this->Data_Model->spy_gold_by_mission($mission))
            {
                $this->Data_Model->Load_Town($this->Player_Model->spyes[$town][$spy]->to);
                $spy = $this->Player_Model->spyes[$town][$spy];
                $town = $this->Data_Model->temp_towns_db[$spy->to];
                $to_position = $this->Data_Model->get_position(14, $town);
                $to_text = 'pos'.$to_position.'_level';
                $to_level = ($to_position > 0) ? $town->$to_text : 0;
                $risk = (5*$town->spyes)+(2*$to_level)-(2*$town->pos0_level)-(2*$this->Player_Model->levels[$this->Player_Model->town_id][14]);
                if ($risk < 0){ $risk = 0; }
                $risk = $risk + $this->Data_Model->spy_risk_by_mission($spy->mission_type) + $spy->risk;
                $chance = rand(0, 100);
                if ($chance >= $risk)
                {
                    $time = time();
                    $text = '';
                    switch($mission)
                    {
                        case 3:
                            $this->Data_Model->Load_User($town->user);
                            $user = $this->Data_Model->temp_users_db[$town->user];
                            $text = 'Available in this city: '.number_format($user->gold).' <img alt="gold" src="'.$this->config->item('style_url').'skin/resources/icon_gold.gif">';
                        break;
                        case 4:
                            $text = '<table cellpadding="0" cellspacing="0" class="reportTable" id="resources"><tr><th class="unitname">Resource</th><th class="count">Qty</th></tr><tr><td class="unitname"><img src="'.$this->config->item('style_url').'skin/resources/icon_wood.gif" alt="Construction materials" title="Construction materials"></td><td class="count">'.number_format($town->wood).'</td></tr><tr><td class="unitname"><img src="'.$this->config->item('style_url').'skin/resources/icon_wine.gif" alt="Wine" title="Wine"></td><td class="count">'.number_format($town->wine).'</td></tr><tr><td class="unitname"><img src="'.$this->config->item('style_url').'skin/resources/icon_marble.gif" alt="Marble" title="Marble"></td><td class="count">'.number_format($town->marble).'</td></tr><tr><td class="unitname"><img src="'.$this->config->item('style_url').'skin/resources/icon_glass.gif" alt="Crystal" title="Crystal"></td><td class="count">'.number_format($town->crystal).'</td></tr><tr><td class="unitname"><img src="'.$this->config->item('style_url').'skin/resources/icon_sulfur.gif" alt="Sulfur" title="Sulfur"></td><td class="count">'.number_format($town->sulfur).'</td></tr></table>';
                        break;
                        case 5:
                            $this->Data_Model->Load_Research($town->user);
                            $this->research = $this->Data_Model->temp_research_db[$town->user];
                            for($i = 1; $i < 14; $i++){
                                $parametr = 'res1_'.$i;
                                if ($this->research->$parametr == 0){$this->ways[1] = $this->Data_Model->get_research(1,$i,$this->research);break;}}
                            if ($this->research->res1_14 > 0){$this->ways[1] = $this->Data_Model->get_research(1,14,$this->research);}
                            if(isset($this->ways[1]) and $this->ways[1]['points'] <= $this->research->points and $this->research->way1_checked == 0){$this->research_advisor = true;}
                            for($i = 1; $i < 15; $i++){
                                $parametr = 'res2_'.$i;
                                if ($this->research->$parametr == 0){$this->ways[2] = $this->Data_Model->get_research(2,$i,$this->research);break;}}
                            if ($this->research->res2_15 > 0){$this->ways[2] = $this->Data_Model->get_research(2,15,$this->research);}
                            if(isset($this->ways[2]) and $this->ways[2]['points'] <= $this->research->points and $this->research->way2_checked == 0){$this->research_advisor = true;}
                            for($i = 1; $i < 16; $i++){
                                $parametr = 'res3_'.$i;
                                if ($this->research->$parametr == 0){$this->ways[3] = $this->Data_Model->get_research(3,$i,$this->research);break;}}
                            if ($this->research->res3_16 > 0){$this->ways[3] = $this->Data_Model->get_research(3,16,$this->research);}
                            if(isset($this->ways[3]) and $this->ways[3]['points'] <= $this->research->points and $this->research->way3_checked == 0){$this->research_advisor = true;}
                            for($i = 1; $i < 14; $i++){
                                $parametr = 'res4_'.$i;
                                if ($this->research->$parametr == 0){$this->ways[4] = $this->Data_Model->get_research(4,$i,$this->research);break;}}
                            if ($this->research->res4_14 > 0){$this->ways[4] = $this->Data_Model->get_research(4,14,$this->research);}
                            if(isset($this->ways[4]) and $this->ways[4]['points'] <= $this->research->points and $this->research->way4_checked == 0){$this->research_advisor = true;}
                            $ways = array();
                            for ($i = 1; $i <= 4; $i++)
                            if ($this->ways[$i]['need_id'] > 0)
                            {
                                $need = $this->Data_Model->get_research($this->ways[$i]['need_way'],$this->ways[$i]['need_id'],$this->research);
                                $ways_names[$i] = $need['name'];
                            }
                            else
                            {
                                $ways_names[$i] = $this->ways[$i]['name'];
                            }
                            $text = '<table cellpadding="0" cellspacing="0" class="reportTable"><tr><th class="unitname">Reseaches/th><th class="count">Current research</th></tr><tr><td class="unitname">Seafaring</td><td class="count">'.$ways_names[1].'</td></tr><tr><td class="unitname">Economy</td><td class="count">'.$ways_names[2].'</td></tr><tr><td class="unitname">Science</td><td class="count">'.$ways_names[3].'</td></tr><tr><td class="unitname">Militarism</td><td class="count">'.$ways_names[4].'</td></tr></table>';
                        break;
                        case 6:
                            $this->Data_Model->Load_User($town->user);
                            $user = $this->Data_Model->temp_users_db[$town->user];
                            $text = ((time() - $user->last_visit) <= 300) ? 'The leader is online' : 'The leader is offline, so he will not be able to take any measures to repel our attack!';
                        break;
                        case 7:
                            $this->Data_Model->Load_Army($town->id);
                            $army = $this->Data_Model->temp_army_db[$town->id];
                            $army_names = '';
                            $army_counts = '';
                            $ship_names = '';
                            $ship_counts = '';
                            $text = 'Войска в '.$town->name.'<table cellpadding="0" cellspacing="0" class="reportTable"><tr><th class="unitname">Единица</th><th class="count">Кол-во</th></tr><tr>';

                            for ($i = 1; $i <= 14; $i++)
                            {
                                $class = $this->Data_Model->army_class_by_type($i);
                                if ($army->$class > 0)
                                {
                                    $army_names .= '<p>'.$this->Data_Model->army_name_by_type($i).'</p>';
                                    $army_counts .= '<p>'.$army->$class.'</p>';
                                }
                            }
                            for ($i = 16; $i <= 22; $i++)
                            {
                                $class = $this->Data_Model->army_class_by_type($i);
                                if ($army->$class > 0)
                                {
                                    $ship_names .= '<p>'.$this->Data_Model->army_name_by_type($i).'</p>';
                                    $ship_counts .= '<p>'.$army->$class.'</p>';
                                }
                            }
                            if ($army_names == '')
                            {
                                $text .= '<td class="unitname">Нет войск.</td>';
                                $text .= '<td class="count"></td>';
                            }
                            else
                            {
                                $text .= '<td class="unitname">'.$army_names.'</td>';
                                $text .= '<td class="count">'.$army_counts.'</td>';
                            }
                            $text .= '</tr></table><tr><td></td><td></td></tr></td></tr><tr><td></td><td class="report">Флоты в '.$town->name.'<table cellpadding="0" cellspacing="0" class="reportTable"><tr><th class="unitname">Корабль</th><th class="count">Кол-во</th></tr><tr>';
                            if ($ship_names == '')
                            {
                                $text .= '<td class="unitname">Нет войск.</td>';
                                $text .= '<td class="count"></td>';
                            }
                            else
                            {
                                $text .= '<td class="unitname">'.$ship_names.'</td>';
                                $text .= '<td class="count">'.$ship_counts.'</td>';
                            }
                            $text .= '</tr></table><tr><td></td><td class="report">Блокирующий флот в '.$town->name.'<table cellpadding="0" cellspacing="0" class="reportTable"><tr><th class="unitname">Корабль</th><th class="count">Кол-во</th></tr><tr><td class="unitname">Нет войск.</td><td class="count"></td></tr></table> ';
                        break;
                        case 8:
                            $text = '<table cellpadding="0" cellspacing="0" class="reportTable"><tr><th>Нет перемещений флотов!</th></tr></table>';
                        break;
                        case 9:
                            $text = '<table cellpadding="0" cellspacing="0" class="reportTable" width="100%"><tr><th class="unitname"><strong>Отправитель:</strong></th><th class="unitname"><strong>Тема:</strong></th><th class="unitname"><strong>Дата:</strong></th><th class="unitname"><strong>Получатель:</strong></th></tr>';
                            $text .= '<tr><td>Нет сообщений.</td><td></td><td></td><td></td></tr> ';
                            $text .= '</table>';
                        break;
                        case 10:
                            $this->db->set('mission_start', time());
                            $this->db->set('mission_type', 2);
                            $this->db->where(array('id' => $spy->id));
                            $this->db->update($this->session->userdata('universe').'_spyes');
                        break;
                    }
                    if ($mission < 10)
                    {
                        $desc = $this->Data_Model->spy_mission_name_by_type($mission);
                        if ($mission == 6) { $desc .= ' '.$town->name; }
                        $spy_message= array(
                            'user' => $spy->user,
                            'spy' => $spy->id,
                            'from' => $spy->from,
                            'to' => $spy->to,
                            'mission' => $mission,
                            'date' => $time,
                            'desc' => $desc,
                            'text' => $text
                        );
                        $this->db->insert($this->session->userdata('universe').'_spy_messages', $spy_message);
                    }
                    $this->db->set('risk', $risk);
                    $this->db->where(array('id' => $spy->id));
                    $this->db->update($this->session->userdata('universe').'_spyes');
                    $spy_query = $this->db->get_where($this->session->userdata('universe').'_spy_messages', array('spy' => $spy->id, 'date' => $time));
                    if ($spy_query->num_rows == 1)
                    {
                        $spy_msg = $spy_query->row();
                        $msg_id = $spy_msg->id;
                    }
                }
                else
                {
                        $chance = rand(0, 1);
                        if($chance)
                        {
                            $chance = (100-$risk) < 0 ? 0 : 100-$risk;
                            $spy_message= array(
                                'user' => $spy->user,
                                'spy' => $spy->id,
                                'from' => $spy->from,
                                'to' => $spy->to,
                                'mission' => 0,
                                'date' => time(),
                                'desc' => 'Ваш шпион не выходит на связь.',
                                'text' => 'Ваш шпион не выходит на связь. Возможно, его раскрыли. Шанс на удачу: '.$chance.' %.'
                            );
                            $this->db->insert($this->session->userdata('universe').'_spy_messages', $spy_message);
                            $this->db->delete($this->session->userdata('universe').'_spyes', array('id' => $spy->id));
                            unset($this->Player_Model->spyes[$this->Player_Model->town_id][$spy->id]);
                        }
                        else
                        {
                            $spy_message = array(
                                'user' => $spy->user,
                                'spy' => $spy->id,
                                'from' => $spy->from,
                                'to' => $spy->to,
                                'mission' => 0,
                                'date' => time(),
                                'desc' => 'Задание отменено...',
                                'text' => 'Шпион был обнаружен, но сумел вовремя скрыться. Он возвращается домой...'
                                );
                            $this->db->insert($this->session->userdata('universe').'_spy_messages', $spy_message);
                                $this->Player_Model->spyes[$this->Player_Model->town_id][$spy->id]->mission_type = 2;
                                $this->db->set('mission_start', time());
                                $this->db->set('mission_type', 2);
                                $this->db->where(array('id' => $spy->id));
                                $this->db->update($this->session->userdata('universe').'_spyes');
                        }
                }
                $this->db->set('gold', $this->Player_Model->user->gold - $this->Data_Model->spy_gold_by_mission($mission));
                $this->db->where(array('id' => $this->Player_Model->user->id));
                $this->db->update($this->session->userdata('universe').'_users');
            }
        }
        if ($msg_id > 0)
        {
            redirect($this->config->item('base_url').'game/safehouseReports/'.$msg_id.'/', 'refresh');

        }
        else
        {
            redirect($this->config->item('base_url').'game/safehouse/', 'refresh');
        }
    }

	// agora
	function postAgora()
	{
        // TODO verify that the user indeed has a town in this island
	    if (isset($_POST['subject']) && isset($_POST['message']))
	    {
            $data = array(
                    'author' => $this->Player_Model->user->id,
                    'message' => strip_tags($_POST['message']),
                    'subject' => strip_tags($_POST['subject']),
                    'island_id' => $this->Player_Model->island_id,
                    'post_date' => time(),
       		);

            $this->db->insert($this->session->userdata('universe').'_agora', $data);
            redirect($this->config->item('base_url').'game/islandBoard/'.$this->Player_Model->island_id, 'refresh');
		}
        else
		{
            $this->show('error');
		}
	}
	
	function embassy($action = '', $alliance_id = 0)
	{
	    switch($action)
		{
	      case 'createally':
		             if (!empty($_POST['ally_tag']) and !empty($_POST['ally_name']))
	                  {
					 $tag = $_POST['ally_tag'];
                      $alliance = $_POST['ally_name'];
					 $data = array(
                          'ally_name' => $alliance ,
                          'ally_tag' => $tag ,
                          'ally_created' => time() ,
						  'ally_founder' =>	$this->Player_Model->user->login
						);
                     $this->db->insert($this->session->userdata('universe').'_alliance', $data);
				     $utenti = $this->db->get_where($this->session->userdata('universe').'_alliance', array('ally_name' => $alliance));
   					 foreach ($utenti->result() as $row)
                     {
					 $founder = 'Founder';
					 $utente = array(
                          'user_id' => $this->Player_Model->user->id ,
                          'ally_id' => $row->ally_id , 
                          'user_rank' => $founder
					 );
                     $this->db->insert($this->session->userdata('universe').'_alliance_users', $utente);
                     }
					 redirect($this->config->item('base_url').'game', 'refresh');
					}
		  break;
          case 'esci':
		  	  $this->db->select('ally_id');
			  $this->db->where('user_id', $this->Player_Model->user->id);
			  $select = $this->db->get($this->session->userdata('universe').'_alliance_users');
 			  $row = $select->row();
              $this->db->where('ally_id', $row->ally_id);
			  $this->db->delete($this->session->userdata('universe').'_alliance_users'); 	  
  	      redirect($this->config->item('base_url').'game', 'refresh');
		  break;
		  case 'deletally':
	          $this->db->select('ally_id');
			  $this->db->where('user_id', $this->Player_Model->user->id);
			  $select1 = $this->db->get($this->session->userdata('universe').'_alliance_users');
 			  $row = $select1->row();
              $this->db->where('ally_id', $row->ally_id);
			  $this->db->delete($this->session->userdata('universe').'_alliance'); 
			   $this->db->where('ally_id', $row->ally_id);
			   $this->db->delete($this->session->userdata('universe').'_alliance_users'); 
	         		  
  	      redirect($this->config->item('base_url').'game', 'refresh');
		  break;
		  case 'searchally':
		    if (!empty($_POST['ally_tag']) and !empty($_POST['ally_name']))
	                  {   
			   $tag = $_POST['ally_tag'];
               $alliance = $_POST['ally_name'];
		       $ricerca = $this->db->get_where($this->session->userdata('universe').'_alliance', array('ally_name' => $alliance, 'ally_tag' => $tag));
			   $this->ricerca = $ricerca->row();
			   if($this->ricerca == TRUE) {
			   foreach ($ricerca->result() as $row)
                     {
			   $adesione = array(
                          'user_id' => $this->Player_Model->user->id ,
                          'ally_id' => $row->ally_id 
                     );
					 }
    		   $this->db->insert($this->session->userdata('universe').'_alliance_users', $adesione);			   
			   $this->show('embassy');
               } 
			   else
               {
               $this->show('not_found_ally', 'Non esiste un alliance con questi dati');
               }			  
                  }		   
		  redirect($this->config->item('base_url').'game', 'refresh');
		  break;
		  case 'editextpage':
           $testo = $_POST['editextpage'];
           $this->db->set('ally_ext_page', $testo);
		   $this->db->where(array('ally_id' => $alliance_id));
           $this->db->update($this->session->userdata('universe').'_alliance');      
		   redirect($this->config->item('base_url').'game', 'refresh');
		   break;
		  case 'editintpage':
           $testo = $_POST['editintpage'];
           $this->db->set('ally_int_page', $testo);
		   $this->db->where(array('ally_id' => $alliance_id));
           $this->db->update($this->session->userdata('universe').'_alliance');      
		   redirect($this->config->item('base_url').'game', 'refresh');
		   break;
		  case 'editdati':
           $nome = $_POST['name'];
           $tag =  $_POST['tag'];
		   $descrizione = $_POST['descrizione'];
		   $this->db->set('ally_name', $nome);
		   $this->db->set('ally_tag', $tag);
		   $this->db->set('ally_description', $descrizione);
		   $this->db->where(array('ally_id' => $alliance_id));
           $this->db->update($this->session->userdata('universe').'_alliance');      
		   redirect($this->config->item('base_url').'game', 'refresh');
		   break;
		   case 'sendAllyMex':
		    if (isset($_POST['msgType']) and isset($_POST['content']))
                {
                    $this->db->select('user_id');
			        $this->db->where('ally_id', $alliance_id);
			        $select = $this->db->get($this->session->userdata('universe').'_alliance_users');
 			        $row = $select->row(); 
			      
				  $msg_type = floor($_POST['msgType']);
                  $content = strip_tags($_POST['content']);
                  $this->Data_Model->Load_User($id);
                  $this->db->insert($this->session->userdata('universe').'_user_messages', array('from' => $this->Player_Model->user->id, 'to' => $row->user_id, 'type' => $msg_type, 'date' => time(), 'text' => $content));
                    
                }
		} 

		}
	
	// ambrosia pagata
	function doAmbrosia()
	{
	    echo 'grazie della tua donazione';
        echo 'Contatta un GO per farti accreditare l\'ambrosia';
	}
	
	
	function messages($id_alliance, $action = '', $id = 0, $relocation = 'diplomacyAdvisor')
    {
        $this->Player_Model->Load_User_Messages();
        switch($action)
        {
           case 'send':
                if (isset($_POST['msgType']) and isset($_POST['content']))
                {
                    $msg_type = floor($_POST['msgType']);
                    $content = strip_tags($_POST['content']);
                    $this->Data_Model->Load_User($id);
                    if ($msg_type > 0 and $msg_type <= 1 and isset($this->Data_Model->temp_users_db[$id]))
                    {
                        $this->db->insert($this->session->userdata('universe').'_user_messages', array('from' => $this->Player_Model->user->id, 'to' => $id, 'type' => $msg_type, 'date' => time(), 'text' => $content));
                    }
                }
           break;
           
		   case 'delete':
                if (isset($this->Player_Model->to_user_messages[$id]))
                {
                    $this->db->set('deleted_to', time());
                    $this->db->where(array('id' => $id));
                    $this->db->update($this->session->userdata('universe').'_user_messages');
                }
                else
                {
                    if(isset($_POST['deleteId']))
                    {
                        foreach($this->Player_Model->from_user_messages as $message)
                        {
                            if (($message->from = $this->Player_Model->user->id) and
                           (isset($_POST['deleteId'][$message->id]) and $_POST['deleteId'][$message->id] == 1))
                            {
                                $this->db->set('deleted_from', time());
                                $this->db->where(array('id' => $message->id));
                                $this->db->update($this->session->userdata('universe').'_user_messages');
                            }
                        }
                        foreach($this->Player_Model->to_user_messages as $message)
                        {
                            if (($message->to = $this->Player_Model->user->id) and
                            (isset($_POST['deleteId'][$message->id]) and $_POST['deleteId'][$message->id] == 'read'))
                            {
                                $this->db->set('deleted_to', time());
                                $this->db->where(array('id' => $message->id));
                                $this->db->update($this->session->userdata('universe').'_user_messages');
                            }
                        }
                    }
                }
           break;
           case 'read':
                if (isset($this->Player_Model->to_user_messages[$id]))
                {
                    $this->db->set('checked_to', time());
                    $this->db->where(array('id' => $id));
                    $this->db->update($this->session->userdata('universe').'_user_messages');
                }

           break;
        }
        redirect($this->config->item('base_url').'game/'.$relocation.'/', 'refresh');
    }
}

/* End of file actions.php */
/* Location: ./system/application/controllers/actions.php */
