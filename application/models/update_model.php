<?php
/**
 * Модель обновления
 */
class Update_Model extends CI_Model
{
	
    /**
     * Инициализация
     */
    function __construct()
    {
        parent::__construct();
        include_once('application/libraries/town_message.php');
        $this->Update_Player($this->session->userdata('id'));
    }

    /**
     * Обновление игрока
     * @param <int> $id
     */
    function Update_Player($id)
    {
       // Получаем данные игрока
       $this->Player_Model->Load_Player($id);

       if(isset($id) and ($id > 0))
       {
           // Обнуляем очки
           $this->Player_Model->user->points_peoples = 0;
           
           $this->Update_Towns();
           $this->Update_Islands();
           $this->Update_Missions();
           $this->Update_Trade_Routes();
           $this->Update_Missions();
          
           
           // Последнее посещение
           $this->db->set('last_visit', time());
           // Обновляем золото
           if ($this->Player_Model->user->gold < 0) { $this->Player_Model->user->gold = 0; }
           $this->db->set('gold', $this->Player_Model->user->gold);
           // Обновляем сухогрузы
           $this->db->set('transports', $this->Player_Model->user->transports);
           // Обновляем премиумы
           if ($this->Player_Model->user->premium_account < time()){ $this->Player_Model->user->premium_account = 0; }
           if ($this->Player_Model->user->premium_wood < time()){ $this->Player_Model->user->premium_wood = 0; }
           if ($this->Player_Model->user->premium_wine < time()){ $this->Player_Model->user->premium_wine = 0; }
           if ($this->Player_Model->user->premium_marble < time()){ $this->Player_Model->user->premium_marble = 0; }
           if ($this->Player_Model->user->premium_crystal < time()){ $this->Player_Model->user->premium_crystal = 0; }
           if ($this->Player_Model->user->premium_sulfur < time()){ $this->Player_Model->user->premium_sulfur = 0; }
           if ($this->Player_Model->user->premium_capacity < time()){ $this->Player_Model->user->premium_capacity = 0; }
           $this->db->set('premium_account', $this->Player_Model->user->premium_account);
           $this->db->set('premium_wood', $this->Player_Model->user->premium_wood);
           $this->db->set('premium_wine', $this->Player_Model->user->premium_wine);
           $this->db->set('premium_marble', $this->Player_Model->user->premium_marble);
           $this->db->set('premium_crystal', $this->Player_Model->user->premium_crystal);
           $this->db->set('premium_sulfur', $this->Player_Model->user->premium_sulfur);
           $this->db->set('premium_capacity', $this->Player_Model->user->premium_capacity);
           //  Обучение
           $this->db->set('tutorial', $this->Player_Model->user->tutorial);
           // Очки
           $this->Player_Model->user->points_gold = $this->Player_Model->user->gold;
           $this->db->set('points', $this->Player_Model->user->points_buildings + $this->Player_Model->user->points_peoples + ($this->Player_Model->user->points_research*6) + $this->Player_Model->user->points_army + $this->Player_Model->user->points_transports);
           $this->db->set('points_buildings', $this->Player_Model->user->points_buildings);
           $this->db->set('points_levels', $this->Player_Model->user->points_levels);
           $this->db->set('points_peoples', $this->Player_Model->user->points_peoples);
           $this->db->set('points_army', $this->Player_Model->user->points_army);
           $this->db->set('points_gold', $this->Player_Model->user->points_gold);

           $this->db->where(array('id' => $id));
           $this->db->update($this->session->userdata('universe').'_users');
           
		   // Обновляем баллы науки
           $this->db->set('points', $this->Player_Model->research->points);
           $this->db->where(array('user' => $id));
           $this->db->update($this->session->userdata('universe').'_research');

           $this->Player_Model->now_town = $this->Player_Model->towns[$this->Player_Model->town_id];
           $this->Player_Model->now_island = $this->Player_Model->islands[$this->Player_Model->island_id];
       }
    }

    function Update_Towns()
    {
           $towns_messages = array();
           $new_town_messages = array();
           // Пробегаемся по городам
           foreach($this->Player_Model->towns as $town)
           {
               $i = $town->id;
               $elapsed = time() - $this->Player_Model->towns[$i]->last_update;
               $this->db->set('last_update', time());
               
			   // Вычитаем виноград за вино
               $wine_need = $this->Data_Model->wine_by_tavern_level($this->Player_Model->towns[$i]->tavern_wine);
               $this->Player_Model->towns[$i]->wine = $this->Player_Model->towns[$i]->wine - (($wine_need/3600)*$elapsed);
               if ($this->Player_Model->towns[$i]->wine < 0){ $this->Player_Model->towns[$i]->wine = 0; $this->Player_Model->towns[$i]->tavern_wine = 0; }
               
			   // Прирост жителей
               if ($this->Player_Model->peoples[$i] < $this->Player_Model->max_peoples[$i])
               {
                   $this->Player_Model->towns[$i]->peoples = $this->Player_Model->towns[$i]->peoples + ((($this->Player_Model->good[$i]/50)/3600)*$elapsed);
                   $this->Player_Model->peoples[$i] = $this->Player_Model->towns[$i]->peoples + $this->Player_Model->towns[$i]->scientists + $this->Player_Model->towns[$i]->workers + $this->Player_Model->towns[$i]->tradegood;
               }
               $this->Player_Model->user->points_peoples = $this->Player_Model->user->points_peoples + floor($this->Player_Model->towns[$i]->peoples + $this->Player_Model->towns[$i]->workers + $this->Player_Model->towns[$i]->tradegood + $this->Player_Model->towns[$i]->scientists);
               if ($this->Player_Model->towns[$i]->peoples < 0){ $this->Player_Model->towns[$i]->peoples = 0; }
               if ($this->Player_Model->peoples[$i] > $this->Player_Model->max_peoples[$i])
               {
                   $this->Player_Model->towns[$i]->peoples = $this->Player_Model->max_peoples[$i] - ($this->Player_Model->peoples[$i] - $this->Player_Model->towns[$i]->peoples);
                   $this->Player_Model->peoples[$i] = $this->Player_Model->towns[$i]->peoples + $this->Player_Model->towns[$i]->scientists + $this->Player_Model->towns[$i]->workers + $this->Player_Model->towns[$i]->tradegood;
               }
               // Прирост золота
               $this->Player_Model->user->gold = $this->Player_Model->user->gold + (($this->Player_Model->saldo[$i]/3600)*$elapsed);
               // Прирост дерева
               $resource_add = ($this->Player_Model->resource_production_bonus[$this->Player_Model->towns[$i]->id]*$elapsed);
               // Хижина лесничего
               if ($this->Player_Model->levels[$this->Player_Model->towns[$i]->id][16] > 0)
               {
                   $resource_add = $resource_add + ($resource_add/100)*$this->Player_Model->levels[$this->Player_Model->towns[$i]->id][16]*2;
               }
               $this->Player_Model->towns[$i]->wood = $this->Player_Model->towns[$i]->wood + $resource_add;
               
               // Прирост другого ресурса
               $tradegood_add = ($this->Player_Model->tradegood_production_bonus[$this->Player_Model->towns[$i]->id]*$elapsed);
               switch($this->Player_Model->islands[$town->island]->trade_resource)
               {
                   case 1:
                       if ($this->Player_Model->levels[$this->Player_Model->towns[$i]->id][19] > 0)
                       {
                           $tradegood_add = $tradegood_add + ($tradegood_add/100)*$this->Player_Model->levels[$this->Player_Model->towns[$i]->id][19]*2;
                       }
                       $this->Player_Model->towns[$i]->wine = $this->Player_Model->towns[$i]->wine + $tradegood_add*(1-$this->Player_Model->corruption[$i])*($this->Player_Model->plus_wine);
                    break;
                    case 2:
                        if ($this->Player_Model->levels[$this->Player_Model->towns[$i]->id][17] > 0)
                        {
                            $tradegood_add = $tradegood_add + ($tradegood_add/100)*$this->Player_Model->levels[$this->Player_Model->towns[$i]->id][17]*2;
                        }
                        $this->Player_Model->towns[$i]->marble = $this->Player_Model->towns[$i]->marble + $tradegood_add*(1-$this->Player_Model->corruption[$i])*($this->Player_Model->plus_marble);
                    break;
                    case 3:
                        if ($this->Player_Model->levels[$this->Player_Model->towns[$i]->id][18] > 0)
                        {
                            $tradegood_add = $tradegood_add + ($tradegood_add/100)*$this->Player_Model->levels[$this->Player_Model->towns[$i]->id][18]*2;
                        }
                        $this->Player_Model->towns[$i]->crystal = $this->Player_Model->towns[$i]->crystal + $tradegood_add*(1-$this->Player_Model->corruption[$i])*($this->Player_Model->plus_crystal);
                    break;
                    case 4:
                        if ($this->Player_Model->levels[$this->Player_Model->towns[$i]->id][20] > 0)
                        {
                            $tradegood_add = $tradegood_add + ($tradegood_add/100)*$this->Player_Model->levels[$this->Player_Model->towns[$i]->id][20]*2;
                        }
                        $this->Player_Model->towns[$i]->sulfur = $this->Player_Model->towns[$i]->sulfur + $tradegood_add*(1-$this->Player_Model->corruption[$i])*($this->Player_Model->plus_sulfur);
                    break;
                }
               // Проверяем не вышли ли мы за пределы вместимости
               if ($this->Player_Model->towns[$i]->wood > $this->Player_Model->capacity[$i]) {$this->Player_Model->towns[$i]->wood = $this->Player_Model->capacity[$i];}
               if ($this->Player_Model->towns[$i]->wine > $this->Player_Model->capacity[$i]) {$this->Player_Model->towns[$i]->wine = $this->Player_Model->capacity[$i];}
               if ($this->Player_Model->towns[$i]->marble > $this->Player_Model->capacity[$i]) {$this->Player_Model->towns[$i]->marble = $this->Player_Model->capacity[$i];}
               if ($this->Player_Model->towns[$i]->crystal > $this->Player_Model->capacity[$i]) {$this->Player_Model->towns[$i]->crystal = $this->Player_Model->capacity[$i];}
               if ($this->Player_Model->towns[$i]->sulfur > $this->Player_Model->capacity[$i]) {$this->Player_Model->towns[$i]->sulfur = $this->Player_Model->capacity[$i];}
               
			   // Update the research points
               $add_points = $this->Player_Model->towns[$i]->scientists * $this->Player_Model->plus_research;
			   $this->Player_Model->research->points = $this->Player_Model->research->points + (($add_points/3600) * $elapsed * getConfig('research_rate')); //Use research points rate
               
			   // Строим здания в городах
               if ($this->Player_Model->towns[$i]->build_line != '')
               {
                   // Псевдо постройки
                   $buildings = $this->Data_Model->load_build_line($this->Player_Model->towns[$i]->build_line);
                   // Псевдо очередь
                   $while_line = $this->Player_Model->towns[$i]->build_line;
                   // Счетчик цикла
                   $step = 0;
                   while (SizeOf($buildings) > 0)
                   {
                       // Переменные
                       $level_text = 'pos'.floor($buildings[0]['position']).'_level';
                       $type_text = 'pos'.floor($buildings[0]['position']).'_type';
                       $level = $this->Player_Model->towns[$i]->$level_text;
                       $type = $this->Player_Model->towns[$i]->$type_text;
                       $cost = $this->Data_Model->building_cost($buildings[0]['type'], $level, $this->Player_Model->research, $this->Player_Model->levels[$i]);
                       $cost['time'] = floor($cost['time'] / getConfig('game_speed'));
					   if (SizeOf($buildings) > 1)
                       {
                           $new_cost = $this->Data_Model->building_cost($buildings[1]['type'], $level, $this->Player_Model->research, $this->Player_Model->levels[$i]);
                           // Стоимость постройки
                           $wood = $this->Player_Model->towns[$i]->wood - $new_cost['wood'];
                           $wine = $this->Player_Model->towns[$i]->wine - $new_cost['wine'];
                           $marble = $this->Player_Model->towns[$i]->marble - $new_cost['marble'];
                           $crystal = $this->Player_Model->towns[$i]->crystal - $new_cost['crystal'];
                           $sulfur = $this->Player_Model->towns[$i]->sulfur - $new_cost['sulfur'];
                       }

                       if (($this->Player_Model->towns[$i]->build_start + $cost['time']) <= time())
                       {
                           if (($step == 0) or ($step > 0 and $wood >= 0 and $marble >= 0 and $wine >= 0 and $crystal >= 0 and $sulfur >= 0))
                           {
                                    $points = ($cost['wood'] + $cost['wine'] + $cost['marble'] + $cost['crystal'] + $cost['sulfur'])*0.01;
                                    $this->Player_Model->user->points_buildings = $this->Player_Model->user->points_buildings + $points;
                                    $this->Player_Model->user->points_levels = $this->Player_Model->user->points_levels + 1;
                                    // Увеличиваем уровень
                                    $this->Player_Model->towns[$i]->$level_text = $this->Player_Model->towns[$i]->$level_text + 1;
                                    $this->Player_Model->towns[$i]->$type_text = $buildings[0]['type'];
                                    // пишем в БД
                                    $this->db->set($level_text, $this->Player_Model->towns[$i]->$level_text);
                                    $this->db->set($type_text, $this->Player_Model->towns[$i]->$type_text);
                                    // Отправляем сообщение
                                    $town_message = array(
                                        'user_id' => $this->Player_Model->user->id,
                                        'town_id' => $i,
                                        'date' => $this->Player_Model->towns[$i]->build_start + $cost['time'],
                                        'type' => TownMessageType::BUILDING_EXPANDED->value,
                                        'data' => json_encode(array(
                                            'type' => $buildings[0]['type'],
                                            'pos' => $buildings[0]['position'],
                                            'level' => $this->Player_Model->towns[$i]->$level_text
                                        )),
                                    );
                                    $new_town_messages[] = $town_message;

                                    // Если не первое здание в очереди
                                    if ($step > 0 and SizeOf($buildings) > 1 and ($cost['wood'] > 0 or $cost['wine'] > 0 or $cost['marble'] > 0 or $cost['crystal'] > 0 or $cost['sulfur'] > 0))
                                    {
                                        $this->Player_Model->towns[$i]->wood = $wood;
                                        $this->Player_Model->towns[$i]->wine = $wine;
                                        $this->Player_Model->towns[$i]->marble = $marble;
                                        $this->Player_Model->towns[$i]->crystal = $crystal;
                                        $this->Player_Model->towns[$i]->sulfur = $sulfur;
                                    }
                                    // Если есть очередь
                                    if (SizeOf($buildings) > 1)
                                    {
                                        // уменьшаем настоящую очередь
                                        if ($buildings[0]['position'] < 10)
                                        {
                                            $this->Player_Model->towns[$i]->build_line = ($buildings[0]['type'] < 10) ? substr($this->Player_Model->towns[$i]->build_line, 4) : substr($this->Player_Model->towns[$i]->build_line, 5);
                                        }
                                        else
                                        {
                                            $this->Player_Model->towns[$i]->build_line = ($buildings[0]['type'] < 10) ? substr($this->Player_Model->towns[$i]->build_line, 5) : substr($this->Player_Model->towns[$i]->build_line, 6);
                                        }
                                        $this->Player_Model->towns[$i]->build_start = $this->Player_Model->towns[$i]->build_start + $cost['time'];
                                        if ($step > 0)
                                        {
                                            // и псевдо очередь
                                            if ($buildings[0]['position'] < 10)
                                            {
                                                $while_line = ($buildings[0]['type'] < 10) ? substr($while_line, 4) : substr($while_line, 5);
                                            }
                                            else
                                            {
                                                $while_line = ($buildings[0]['type'] < 10) ? substr($while_line, 5) : substr($while_line, 6);
                                            }
                                            $buildings = $this->Data_Model->load_build_line($this->Player_Model->towns[$i]->build_line);
                                        }
                                    }
                                    else
                                    {
                                        // Обнуляем очередь
                                        $this->Player_Model->towns[$i]->build_line = '';
                                        $this->Player_Model->towns[$i]->build_start = 0;
                                        $buildings = array();
                                        break;
                                    }
                           }
                           else
                           {
                               // Если ресурсов не хватает уменьшаем настоящую и псевдо очереди
                               if ($buildings[0]['position'] < 10)
                               {
                                   $this->Player_Model->towns[$i]->build_line = ($buildings[0]['type'] < 10) ? substr($this->Player_Model->towns[$i]->build_line, 4) : substr($this->Player_Model->towns[$i]->build_line, 5);
                                   $while_line = ($buildings[0]['type'] < 10) ? substr($while_line, 4) : substr($while_line, 5);
                               }
                               else
                               {
                                   $this->Player_Model->towns[$i]->build_line = ($buildings[0]['type'] < 10) ? substr($this->Player_Model->towns[$i]->build_line, 5) : substr($this->Player_Model->towns[$i]->build_line, 6);
                                   $while_line = ($buildings[0]['type'] < 10) ? substr($while_line, 5) : substr($while_line, 6);
                               }
                           }
                       }
                       else
                       {
                           // Если еще не время строить уменьшаем псевдо очередь построек
                           if ($buildings[0]['position'] < 10)
                           {
                               $while_line = ($buildings[0]['type'] < 10) ? substr($while_line, 4) : substr($while_line, 5);
                           }
                           else
                           {
                               $while_line = ($buildings[0]['type'] < 10) ? substr($while_line, 5) : substr($while_line, 6);
                           }
                           $buildings = $this->Data_Model->load_build_line($while_line);
                           break;
                       }
                       // Снова загружаем псевдо постройки
                       $buildings = $this->Data_Model->load_build_line($while_line);
                       // Счетчик цикла
                       $step++;

                   }
                        // Проверка данных, чтобы не писать в БД лишнего
                        if (strlen($this->Player_Model->towns[$i]->build_line) < 3){ $this->Player_Model->towns[$i]->build_line = ''; }
                        if ($this->Player_Model->towns[$i]->build_line == ''){ $this->Player_Model->towns[$i]->build_start = 0; }
                        $this->Player_Model->build_line[$i] = $this->Data_Model->load_build_line($this->Player_Model->towns[$i]->build_line);
                        // Пишем в БД очередь
                        $this->db->set('build_line', $this->Player_Model->towns[$i]->build_line);
                        $this->db->set('build_start', $this->Player_Model->towns[$i]->build_start);
               }
               // Баллы действий
               $actions = $this->Data_Model->action_points_by_level($this->Player_Model->towns[$i]->pos0_level) - $this->Player_Model->my_fleets[$i];
               $this->db->set('actions', $actions);
               // Обновляем в БД ресурсы города
               $this->db->set('peoples', $this->Player_Model->towns[$i]->peoples);
               $this->db->set('wood', $this->Player_Model->towns[$i]->wood);
               $this->db->set('wine', $this->Player_Model->towns[$i]->wine);
               $this->db->set('marble', $this->Player_Model->towns[$i]->marble);
               $this->db->set('crystal', $this->Player_Model->towns[$i]->crystal);
               $this->db->set('sulfur', $this->Player_Model->towns[$i]->sulfur);
               // Вино в таверне
               $this->db->set('tavern_wine', $this->Player_Model->towns[$i]->tavern_wine);

               $this->db->where(array('id' => $i));
               $this->db->update($this->session->userdata('universe').'_towns');

               // Строим армию в городах
               for ($army_type = 0; $army_type < 2; $army_type++)
               {
                   $army_type_line = ($army_type == 0) ? 'army_line' : 'ships_line';
                   $army_type_start = ($army_type == 0) ? 'army_start' : 'ships_start';

                   if ($this->Player_Model->armys[$i]->$army_type_line != '')
                   {
                       // Загружаем очередь армии
                       $army_line = $this->Player_Model->armys[$i]->$army_type_line;
                       $army = $this->Data_Model->load_army_line($this->Player_Model->armys[$i]->$army_type_line);
                       $army_start = $this->Player_Model->armys[$i]->$army_type_start;

                       while (SizeOf($army) > 0)
                       {

                           // Переменные
                           $cost = $this->Data_Model->army_cost_by_type($army[0]['type'], $this->Player_Model->research, $this->Player_Model->levels[$i]);
                           $cost['time'] = floor($cost['time'] / getConfig('game_speed'));
						   $ELAPSED_ARMY = time() - $army_start;
                           $count = floor($ELAPSED_ARMY/$cost['time']);
                           $class = $this->Data_Model->army_class_by_type($army[0]['type']);
                           // Если построен хотя бы один
                           if ($count >= $army[0]['count'])
                           {
                               // Если построены все
                               $this->Player_Model->armys[$i]->$class = $this->Player_Model->armys[$i]->$class + $army[0]['count'];
                               if($army[0]['count'] < 10)
                               {
                                   $army_line = ($army[0]['type'] < 10) ? substr($army_line, 4) : substr($army_line, 5);
                               }
                               else
                               {
                                   $army_line = ($army[0]['type'] < 10) ? substr($army_line, 5) : substr($army_line, 6);
                               }
                               $army = $this->Data_Model->load_army_line($army_line);
                               if (sizeof(($army)) > 0) {
                                   $army_start = $army_start + ($army[0]['count']*$cost['time']);
                               }
                           }
                           else
                           {
                               // Если построена часть
                               $this->Player_Model->armys[$i]->$class = $this->Player_Model->armys[$i]->$class + $count;
                               $army[0]['count'] = $army[0]['count'] - $count;
                               if($army[0]['count'] < 10)
                               {
                                   $army_line = ($army[0]['type'] < 10) ? substr($army_line, 4) : substr($army_line, 5);
                               }
                               else
                               {
                                   $army_line = ($army[0]['type'] < 10) ? substr($army_line, 5) : substr($army_line, 6);
                               }
                               $army_line = ($army_line != '') ? $army[0]['type'].','.$army[0]['count'].';'.$army_line : $army[0]['type'].','.$army[0]['count'] ;
                               $army_start = $army_start + ($count*$cost['time']);
                               break;
                           }
                           // Проверка данных, чтобы не писать в БД лишнего
                           if ($army_line == ''){ $army_start = 0; }
                           if ($army_line == 0){ $army_line = ''; }
                       }
                            // Обновляем армию в базу
                            for ($a = 1; $a <= 14; $a++)
                            {
                                $class = $this->Data_Model->army_class_by_type($a);
                                $this->db->set($class, $this->Player_Model->armys[$i]->$class);
                            }
                            // Обновляем армию в базу
                            for ($a = 16; $a <= 22; $a++)
                            {
                                $class = $this->Data_Model->army_class_by_type($a);
                                $this->db->set($class, $this->Player_Model->armys[$i]->$class);
                            }
                            // Обновляем очередь армии
                            $this->Player_Model->armys[$i]->$army_type_line = $army_line;
                            $this->Player_Model->armys[$i]->$army_type_start = $army_start;
                            $this->db->set($army_type_line, $army_line);
                            $this->db->set($army_type_start, $army_start);

                            $this->db->where(array('city' => $i));
                            $this->db->update($this->session->userdata('universe').'_army');
                   }
               }
               // Тренируем шпионов
               if($this->Player_Model->towns[$i]->spyes_start > 0)
               {
                   $safehouse_position = $this->Data_Model->get_position(14, $this->Player_Model->towns[$i]);
                   $safehouse_text = 'pos'.$safehouse_position.'_level';
                   $safehouse_level = $this->Player_Model->towns[$i]->$safehouse_text;
                   $spy_time = $this->Data_Model->spyes_time_by_level($safehouse_level);
                   if (time() >= ($this->Player_Model->towns[$i]->spyes_start+$spy_time))
                   {
                       $this->Player_Model->towns[$i]->spyes++;
                       $this->Player_Model->towns[$i]->spyes_start = 0;
                       $this->db->set('spyes', $this->Player_Model->towns[$i]->spyes);
                       $this->db->set('spyes_start', 0);
                       $this->db->where(array('id' => $i));
                       $this->db->update($this->session->userdata('universe').'_towns');
                   }
               }
               // Вычисляем золото за армию
               $ARMY_GOLD = 0;
               for ($a = 1; $a <= 22; $a ++)
               {
                   $class = $this->Data_Model->army_class_by_type($a);
                   $cost = $this->Data_Model->army_cost_by_type($a, $this->Player_Model->research, $this->Player_Model->levels[$i]);
                   $ARMY_GOLD = $ARMY_GOLD + ((($cost['gold'] * $this->Player_Model->armys[$i]->$class)/3600)*$elapsed);
               }
               $this->Player_Model->user->gold = $this->Player_Model->user->gold - $ARMY_GOLD;

               $this->Update_Spyes($town->id);
           }
           $this->store_new_messages($new_town_messages);
           $this->Send_Messages($towns_messages);
    }

    function Update_Islands()
    {
		$towns_messages = array();
           // Пробегаемся по островам
           foreach ($this->Player_Model->islands as $island)
           {
               for ($is = 0; $is <= 1; $is++)
               {
                   $res_level = ($is == 0) ? 'wood_level' : 'trade_level';
                   $res_count = ($is == 0) ? 'wood_count' : 'trade_count';
                   $res_start = ($is == 0) ? 'wood_start' : 'trade_start';
                   $res_name = ($is == 0) ? 'Sawmill' : $this->Data_Model->island_building_by_resource($island->trade_resource);
                   
				   // Цены для улучшения леса
                   $cost = $this->Data_Model->island_cost($is,$island->$res_level);
                   $cost['time'] = floor($cost['time'] / getConfig('game_speed'));
				   $need_wood = $cost['wood'] - $island->$res_count;
                   $need_wood = ($need_wood < 0) ? 0 : $need_wood;
                   if ($island->$res_start > 0)
                   {
                       $time_start = $island->$res_start;
                       $elapsed_wood = time() - $island->$res_start;
                       if ($elapsed_wood >= $cost['time'])
                       {
                           $this->Player_Model->islands[$island->id]->$res_level = $island->$res_level + 1;
                           $this->Player_Model->islands[$island->id]->$res_start = 0;
                           $this->db->set($res_level, $this->Player_Model->islands[$island->id]->$res_level);
                           $this->db->set($res_start, 0);
                           $this->db->where(array('id' => $this->Player_Model->islands[$island->id]->id));
                           $this->db->update($this->session->userdata('universe').'_islands');
                           $users_sended = array();
                           $text = '<b>'.$res_name.'</b> was expanded on the island <a href="'.$this->config->item('base_url').'game/island/'.$island->id.'/">'.$island->name.' ('.$island->x.':'.$island->y.')</a>!';
                           for ($i = 0; $i <= 15; $i++)
                           {
                               $town_text = 'city'.$i;
                               if ($this->Player_Model->islands[$island->id]->$town_text > 0)
                               {
                                   $this->Data_Model->Load_Town($this->Player_Model->islands[$island->id]->$town_text);
                                   $town = $this->Data_Model->temp_towns_db[$this->Player_Model->islands[$island->id]->$town_text];
                                   if(isset($town->user) and !isset($users_sended[$town->user]))
                                   {
                                       $users_sended[$town->user] = TRUE;
                                       $town_message = array(
                                           'user' => $town->user,
                                           'town' => $town->id,
                                           'date' => ($time_start + $cost['time']),
                                           'text' => $text
                                       );
                                       $towns_messages[] = $town_message;
                                   }
                               }
                           }
                       }
                   }else{
                       // Если дерева достаточно
                       if ($need_wood == 0)
                       {
                           $this->Player_Model->islands[$island->id]->$res_start = time();
                           $this->Player_Model->islands[$island->id]->$res_count = $island->$res_count - $cost['wood'];
                           $this->db->set($res_start, $this->Player_Model->islands[$island->id]->$res_start);
                           $this->db->set($res_count, $this->Player_Model->islands[$island->id]->$res_count);
                           $this->db->where(array('id' => $this->Player_Model->islands[$island->id]->id));
                           $this->db->update($this->session->userdata('universe').'_islands');
                       }
                   }
               }
           }
           $this->Send_Messages($towns_messages);
    }

    function update_mission_en_route(Mission $mission)
    {
        $travel_time = $mission->get_travel_time();
        $mission->next_stage_time += $travel_time;
        $mission->state = MissionState::EN_ROUTE;

        $this->db->set('next_stage_time', $mission->next_stage_time);
        $this->db->set('state', $mission->state->value);
        $this->db->where(array('id' => $mission->id));
        $this->db->update($this->session->userdata('universe').'_users');
    }

    function update_missoin_arrived(Mission $mission)
    {
        $dest_town = $this->Data_Model->Load_Town($mission->to);
        $resources = $mission->get_resources();

        $update_values = array();
        foreach ($resources as $resource => $cout)
        {
            $dest_town[$resource] += $count;
            array_push($update_values, '`'.$resource.'` = `'.$resource.' + '.$count.' ');
        }

        $dest_user = $this->Data_Model->Load_User($dest_town->user);
        $$dest_user['gold'] += $mission->gold;
        $this->db->query('UPDATE '.$this->session->userdata('universe').'_towns SET '.implode(',',$update_values).' WHERE `id`='.$dest_town);
        $this->db->query('UPDATE '.$this->session->userdata('universe').'_users SET `gold`=`gold`+'.$mission->gold.' WHERE `id`='.$dest_user->id);
        $mission->state = MissionState::FINISHED;
    }

    function update_transport(Mission $mission)
    {
        switch ($mission->state)
        {
        case MissionState::LOADING:
            // TODO insert the town and colony entry
            $this->update_mission_en_route($mission);
            break;
        case MissionState::EN_ROUTE:
            array(
                'user' => $this->Player_Model->user->id,
                'from' => $this->Player_Model->now_town->id,
                'to' => $town->id, 'loading_from_start' => time(),
                'mission_type' => 1,
                'wood' => $sendresource+1250,
                'wine' => $sendwine,
                'marble' => $sendmarble,
                'crystal' => $sendcrystal,
                'sulfur' => $sendsulfur,
                'gold' => 9000,
                'peoples' => 40,
                'ship_transport' => $transporters
            );
            $this->db->insert($this->session->userdata('universe').'_missions', values);
            $this->update_mission_arrived($misison);
            break;
        }
    }

    function update_colonization(Mission $mission)
    {
        switch ($mission->state)
        {
        case MissionState::LOADING:
            $this->update_mission_en_route($mission);
            break;
        case MissionState::EN_ROUTE:
            $this->load->model('Island_Model');
            $island = $this->Island_Model->Load_Island($id);
            $this->update_missoin_arrived($mission);
            break;
        }
    }

    function update_mission(Mission $mission)
    {
        while ($mission->state != MissionState::FINISHED and $mission->next_stage_time < time()) {
            switch ($mission->type)
            {
            case MissionType::TRANSPORT:
                $this->update_transport($mission);
                return;
            }
        }
    }

    function Update_Missions()
    {
        $towns_messages = array();
        $next_loading = 0;
     	$this->load->model('Battle_Model');
        foreach($this->Player_Model->missions as $mission_data)
        {
            $this->update_mission(new Mission($this, $mission_data));
        }
        foreach($this->Player_Model->missions as $mission)
        {
            $mission = new Mission($mission_data);
            if ($mission->state == MissionState::FINISHED) {
                unset($this->Player_Model->missions[$mission->id]);
                $this->db->query('DELETE FROM '.$this->session->userdata('universe').'_missions where `id`="'.$mission->id.'"');
            }
        }
    }

    function Send_Messages($towns_messages)
    {
           // Отправляем сообщения
           if (SizeOf($towns_messages) > 0)
           foreach($towns_messages as $message_data)
           {
               $this->db->insert($this->session->userdata('universe').'_town_messages', $message_data);
           }
    }

    function store_new_messages($messages)
    {
       foreach($messages as $message_data)
       {
           $this->db->insert($this->session->userdata('universe').'_town_messages_new', $message_data);
       }
    }

    function Send_Spyes_Messages($spyes_messages)
    {
           // Отправляем сообщения
           if (SizeOf($spyes_messages) > 0)
           foreach($spyes_messages as $message_data)
           {
               $this->db->insert($this->session->userdata('universe').'_spy_messages', $message_data);
           }
    }

    function Update_Trade_Routes()
    {
        $towns_messages = array();
        foreach($this->Player_Model->trade_routes as $route)
        {
            while(time() >= $route->update_time)
            {
                $resource_name = $this->Data_Model->resource_class_by_type($route->send_resource);
                if ($this->Player_Model->towns[$route->from]->$resource_name >= $route->send_count)
                {
                    $transports = ceil($route->send_count / getConfig('transport_capacity'));
                    if ($this->Player_Model->user->transports >= $transports and $this->Player_Model->towns[$route->from]->actions > 0)
                    {
                        // Вычитаем ресурсы и баллы
                        $this->Player_Model->towns[$route->from]->$resource_name = $this->Player_Model->towns[$route->from]->$resource_name - $route->send_count;
                         $this->Player_Model->towns[$route->from]->actions =  $this->Player_Model->towns[$route->from]->actions - 1;
                        $this->db->set($resource_name, $this->Player_Model->towns[$route->from]->$resource_name);
                        $this->db->set('actions', $this->Player_Model->towns[$route->from]->actions);
                        $this->db->where(array('id' => $route->from));
                        $this->db->update($this->session->userdata('universe').'_towns');
                        // Вычитаем сухогрузы
                        $this->Player_Model->user->transports = $this->Player_Model->user->transports - $transports;
                        $this->db->set('transports', $this->Player_Model->user->transports);
                        $this->db->where(array('id' => $this->Player_Model->user->id));
                        $this->db->update($this->session->userdata('universe').'_users');
                        // Добавляем миссию
                        $this->db->insert($this->session->userdata('universe').'_missions', array('user' => $route->user, 'from' => $route->from, 'to' => $route->to, 'loading_from_start' => $route->update_time, 'mission_type' => 2, $resource_name => $route->send_count, 'ship_transport' => $transports));
                        $text = 'Стартовала торговая миссия по маршруту до '.$this->Player_Model->towns[$route->from]->name.'.';
                        $town_message = array(
                                   'user' => $route->user,
                                   'town' => $route->from,
                                   'date' => $route->update_time,
                                   'text' => $text
                               );
                        $towns_messages[] = $town_message;
                    }
                }
                $route->update_time = $route->update_time + 86400;
            }
            
            $this->db->set('update_time', $route->update_time);
            $this->db->where(array('id' => $route->id));
            $this->db->update($this->session->userdata('universe').'_trade_routes');
        }
        $this->Send_Messages($towns_messages);
    }

    function Update_Spyes($town_id)
    {
        $spyes_messages = array();
        foreach($this->Player_Model->spyes[$town_id] as $spy)
        {
            if($spy->mission_type > 0)
            {
                $this->Data_Model->Load_Town($spy->to);
                $town = $this->Data_Model->temp_towns_db[$spy->to];
                $this->Data_Model->Load_Island($town->island);
                $island = $this->Data_Model->temp_islands_db[$town->island];
                $x1 = $this->Player_Model->islands[$this->Player_Model->towns[$town_id]->island]->x;
                $x2 = $island->x;
                $y1 = $this->Player_Model->islands[$this->Player_Model->towns[$town_id]->island]->y;
                $y2 = $island->y;
                $time = $this->Data_Model->spy_time_by_coords($x1,$x2,$y1,$y2);
                $to_position = $this->Data_Model->get_position(14, $town);
                $to_text = 'pos'.$to_position.'_level';
                $to_level = ($to_position > 0) ? $town->$to_text : 0;
                $risk = ($spy->mission_type == 2) ? 0 :$this->Data_Model->spy_risk_by_mission($spy->mission_type)+$spy->risk+(5*$town->spyes)+(2*$to_level)-(2*$town->pos0_level)-(2*$this->Player_Model->levels[$town_id][14]);
                if ($spy->mission_type == 1)
                {
                    $risk = ($risk < 5) ? 5 : $risk;
                }
                else
                {
                    $risk = ($risk < 0) ? 0 : $risk;
                }
                if (($time+$spy->mission_start) <= time())
                {
                    $chance = rand(0, 100);
                    if ($chance >= $risk)
                    {
                        switch($spy->mission_type)
                        {
                            case 1:
                                $spyes_messages[] = array(
                                    'user' => $spy->user,
                                    'spy' => $spy->id,
                                    'from' => $spy->from,
                                    'to' => $spy->to,
                                    'mission' => $spy->mission_type,
                                    'date' => $spy->mission_start + $time,
                                    'desc' => 'Your spy has arrived to '.$town->name.'.',
                                    'text' => 'Your spy has arrived to '.$town->name.'.'
                                );
                                $this->Player_Model->spyes[$town_id][$spy->id]->mission_type = 0;
                                $this->Player_Model->spyes[$town_id][$spy->id]->mission_start = 0;
                                $this->Player_Model->spyes[$town_id][$spy->id]->risk = $risk;
                                $this->db->set('mission_type', $this->Player_Model->spyes[$town_id][$spy->id]->mission_type);
                                $this->db->set('mission_start', $this->Player_Model->spyes[$town_id][$spy->id]->mission_start);
                                $this->db->set('risk', $this->Player_Model->spyes[$town_id][$spy->id]->risk);
                                $this->db->where(array('id' => $spy->id));
                                $this->db->update($this->session->userdata('universe').'_spyes');
                            break;
                            case 2:
                                $spyes_messages[] = array(
                                    'user' => $spy->user,
                                    'spy' => $spy->id,
                                    'from' => $spy->from,
                                    'to' => $spy->to,
                                    'mission' => $spy->mission_type,
                                    'date' => $spy->mission_start + $time,
                                    'desc' => 'Доклад о возвращении из '.$town->name.'.',
                                    'text' => 'Шпион вернулся.'
                                );
                                $this->Player_Model->towns[$town_id]->spyes++;
                                $this->db->set('spyes', $this->Player_Model->towns[$town_id]->spyes);
                                $this->db->where(array('id' => $town_id));
                                $this->db->update($this->session->userdata('universe').'_towns');
                                $this->db->delete($this->session->userdata('universe').'_spyes', array('id' => $spy->id));
                                unset($this->Player_Model->spyes[$town_id][$spy->id]);
                            break;
                        }
                    }
                    else
                    {
                        $chance = rand(0, 2);
                        if($chance == 0)
                        {
                            $chance = (100-$risk) < 0 ? 0 : 100-$risk;
                            $spyes_messages[] = array(
                                'user' => $spy->user,
                                'spy' => $spy->id,
                                'from' => $spy->from,
                                'to' => $spy->to,
                                'mission' => 0,
                                'date' => $spy->mission_start + $time,
                                'desc' => 'Ваш шпион не выходит на связь.',
                                'text' => 'Ваш шпион не выходит на связь. Возможно, его раскрыли. Шанс на удачу: '.$chance.' %.'
                            );
                            $this->db->delete($this->session->userdata('universe').'_spyes', array('id' => $spy->id));
                            unset($this->Player_Model->spyes[$town_id][$spy->id]);
                        }
                        else
                        {
                            $spyes_messages[] = array(
                                'user' => $spy->user,
                                'spy' => $spy->id,
                                'from' => $spy->from,
                                'to' => $spy->to,
                                'mission' => 0,
                                'date' => $spy->mission_start + $time,
                                'desc' => 'Задание отменено...',
                                'text' => 'Шпион был обнаружен, но сумел вовремя скрыться. Он возвращается домой...'
                                );
                                $this->Player_Model->spyes[$town_id][$spy->id]->mission_type = 2;
                                $this->db->set('mission_type', $this->Player_Model->spyes[$town_id][$spy->id]->mission_type);
                                $this->db->set('mission_start', $spy->mission_start + $time);
                                $this->db->where(array('id' => $spy->id));
                                $this->db->update($this->session->userdata('universe').'_spyes');
                        }
                    }
                }
            }
        }
        $this->Send_Spyes_Messages($spyes_messages);
    }
}

/* End of file update_model.php */
/* Location: ./system/application/models/update_model.php */
