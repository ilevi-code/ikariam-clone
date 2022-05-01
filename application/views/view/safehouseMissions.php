<?$spy = $this->Player_Model->spyes[$this->Player_Model->town_id][$param1]?>
<div id="mainview">
    <div class="buildingDescription">
        <h1>Missions</h1>
        <p>Give a task to a spy</p>
    </div>
    <div class="contentBox01h">
        <h3 class="header"><span class="textLabel">Select a mission for the spy in<?=$this->Data_Model->temp_towns_db[$spy->to]->name?></span></h3>
        <div class="content" style="position:relative">
            <div class="percentage"><?=$spy->risk?>%</div>
            <h4><span class="textLabel">Current detection risk:</span></h4>
            <div class="missionText">
                <div title="Exposure risk: <?=$spy->risk?>%" class="statusBar">
                    <div style="width: <?=$spy->risk?>%;" class="bar"></div>
                </div>
            </div>
            <ul id="missionlist">
<?
    $town = $this->Data_Model->temp_towns_db[$spy->to];
    $to_position = $this->Data_Model->get_position(14, $town);
    $to_text = 'pos'.$to_position.'_level';
    $to_level = ($to_position > 0) ? $town->$to_text : 0;
    $risk = (5*$town->spyes)+(2*$to_level)-(2*$town->pos0_level)-(2*$this->Player_Model->levels[$this->Player_Model->town_id][14]);
    $risk = ($risk < 0) ? 0 : $risk;
    $risk = $risk + $spy->risk + $this->Data_Model->spy_risk_by_mission(3);
?>
                <li class="gold">
                    <div title="Mission name" class="missionType">Treasury espionage</div>
                    <div title="Mission Description" class="missionDesc">It will not be an easy task to infiltrate the city treasury. But we can find out the amount of gold stored there.</div>
                    <div title="The cost of this mission" class="missionCosts"><strong>Price:</strong>
                    	<span class="textLabel">Gold: </span><span class="gold">45</span>
                    </div>
                    <div title="The risk of this mission" class="missionRisk"><strong>risk:</strong> <?=$risk?>%</div>
                    <div title="3" class="missionStart">
                        <div class="centerButton">
                            <a class="button" href="<?=$this->config->item('base_url')?>actions/espionage/<?=$spy->from?>/<?=$spy->id?>/3/">Start a task</a>
                        </div>
                    </div>
                </li>
<?
    $risk = (5*$town->spyes)+(2*$to_level)-(2*$town->pos0_level)-(2*$this->Player_Model->levels[$this->Player_Model->town_id][14]);
    $risk = ($risk < 0) ? 0 : $risk;
    $risk = $risk + $spy->risk + $this->Data_Model->spy_risk_by_mission(4);
?>
            	<li class="resources">
                    <div title="Mission name" class="missionType">Inspect the warehouse</div>
                    <div title="Mission Description" class="missionDesc">We can find out how many resources are in the city warehouses. Then it will become clear how much the attack will pay off.</div>
                    <div title="The cost of this mission" class="missionCosts"><strong>Price</strong>
 	                	<span class="textLabel">Gold: </span><span class="gold">75</span>
                    </div>
                    <div title="The risk of this mission" class="missionRisk"><strong>risk:</strong><?=$risk?>%</div>
                    <div title="4" class="missionStart">
                        <div class="centerButton">
                            <a class="button" href="<?=$this->config->item('base_url')?>actions/espionage/<?=$spy->from?>/<?=$spy->id?>/4/">Start a task</a>
                        </div>
                    </div>
                </li>
<?
    $risk = (5*$town->spyes)+(2*$to_level)-(2*$town->pos0_level)-(2*$this->Player_Model->levels[$this->Player_Model->town_id][14]);
    $risk = ($risk < 0) ? 0 : $risk;
    $risk = $risk + $spy->risk + $this->Data_Model->spy_risk_by_mission(5);
?>

                <li class="research">
                    <div title="Mission name" class="missionType">Spying on research</div>
                    <div title="Mission Description" class="missionDesc">Our spy is smart enough to pass for a scientist. This will allow him to collect information about the current level of research in the city.</div>
                    <div title="The cost of this mission" class="missionCosts"><strong>Price:</strong>
                    	<span class="textLabel">Gold: </span><span class="gold">90</span>
                    </div>
                    <div title="The risk of this mission" class="missionRisk"><strong>risk:</strong> <?=$risk?>%</div>
                    <div title="5" class="missionStart">
                        <div class="centerButton">
                            <a class="button" href="<?=$this->config->item('base_url')?>actions/espionage/<?=$spy->from?>/<?=$spy->id?>/5/">Start a task</a>
                        </div>
                    </div>
                </li>
<?
    $risk = (5*$town->spyes)+(2*$to_level)-(2*$town->pos0_level)-(2*$this->Player_Model->levels[$this->Player_Model->town_id][14]);
    $risk = ($risk < 0) ? 0 : $risk;
    $risk = $risk + $spy->risk + $this->Data_Model->spy_risk_by_mission(6);
?>

                <li class="online">
                    <div title="Mission name" class="missionType">Online status</div>
                    <div title="Mission Description" class="missionDesc">With luck, we will be able to find out how the leader is aware of the mood among his own inhabitants.</div>
                    <div title="The cost of this mission" class="missionCosts"><strong>Price:</strong>
                    	<span class="textLabel">Gold: </span><span class="gold">240</span>
                    </div>
                    <div title="The risk of this mission" class="missionRisk"><strong>risk:</strong> <?=$risk?>%</div>
                    <div title="6" class="missionStart">
                        <div class="centerButton">
                            <a class="button" href="<?=$this->config->item('base_url')?>actions/espionage/<?=$spy->from?>/<?=$spy->id?>/6/">Start a task</a>
                        </div>
                    </div>
                </li>
<?
    $risk = (5*$town->spyes)+(2*$to_level)-(2*$town->pos0_level)-(2*$this->Player_Model->levels[$this->Player_Model->town_id][14]);
    $risk = ($risk < 0) ? 0 : $risk;
    $risk = $risk + $spy->risk + $this->Data_Model->spy_risk_by_mission(7);
?>

            	<li class="garrison">
                    <div title="Mission name" class="missionType">Spying in the garrison</div>
                    <div title="Mission Description" class="missionDesc">If we hide in the right place during the morning roll call, we can find out the number of soldiers in this garrison. With this information, an attack can be planned more accurately.!                    </div>
                    <div title="The cost of this mission" class="missionCosts"><strong>Price:</strong>
                    	<span class="textLabel">Gold: </span><span class="gold">150</span>
                    </div>
                    <div title="The risk of this mission" class="missionRisk"><strong>risk:</strong> <?=$risk?>%</div>
                    <div title="7" class="missionStart">
                        <div class="centerButton">
                            <a class="button" href="<?=$this->config->item('base_url')?>actions/espionage/<?=$spy->from?>/<?=$spy->id?>/7/">Start a task</a>
                        </div>
                    </div>
                </li>
<?
    $risk = (5*$town->spyes)+(2*$to_level)-(2*$town->pos0_level)-(2*$this->Player_Model->levels[$this->Player_Model->town_id][14]);
    $risk = ($risk < 0) ? 0 : $risk;
    $risk = $risk + $spy->risk + $this->Data_Model->spy_risk_by_mission(8);
?>

            	<li class="fleet">
                    <div title="Mission name" class="missionType">Monitoring the movement of troops and fleets</div>
                    <div title="Mission Description" class="missionDesc">If we focus on the city gates and the port building, we can certainly get useful information about the inhabitants of this city. For example, who they trade with or who they are at war with.</div>
                    <div title="The cost of this mission" class="missionCosts"><strong>Price:</strong>
                    	<span class="textLabel">Gold: </span><span class="gold">750</span>
                    </div>
                    <div title="The risk of this mission" class="missionRisk"><strong>risk:</strong> <?=$risk?>%</div>
                    <div title="8" class="missionStart">
                        <div class="centerButton">
                            <a class="button" href="<?=$this->config->item('base_url')?>actions/espionage/<?=$spy->from?>/<?=$spy->id?>/8/">Start a task</a>
                        </div>
                    </div>
                </li>
<?
    $risk = (5*$town->spyes)+(2*$to_level)-(2*$town->pos0_level)-(2*$this->Player_Model->levels[$this->Player_Model->town_id][14]);
    $risk = ($risk < 0) ? 0 : $risk;
    $risk = $risk + $spy->risk + $this->Data_Model->spy_risk_by_mission(9);
?>

                <li class="message">
                    <div title="Mission name" class="missionType">Spying on messaging</div>
                    <div title="Mission Description" class="missionDesc">If our spy works as a courier, he will be able to provide information about who our common target is in contact with and with whom she has contracts.</div>
                    <div title="The cost of this mission" class="missionCosts"><strong>Price:</strong>
                    	<span class="textLabel">Gold: </span><span class="gold">360</span>
                    </div>
                    <div title="The risk of this mission" class="missionRisk"><strong>risk:</strong> <?=$risk?>%</div>
                    <div title="9" class="missionStart">
                        <div class="centerButton">
                            <a class="button" href="<?=$this->config->item('base_url')?>actions/espionage/<?=$spy->from?>/<?=$spy->id?>/9/">Start a task</a>
                        </div>
                    </div>
                </li>

                <li class="retreat">
                    <div title="Mission name" class="missionType">Recall Spy</div>
                    <div title="Mission Description" class="missionDesc">We can recall the spy at any time. His return will remain imperceptible to the inhabitants of the city.</div>
                    <div title="The cost of this mission" class="missionCosts"><strong>Price:</strong>
                    	<span class="textLabel">Gold: </span><span class="gold">0</span>
                    </div>
                    <div title="The risk of this mission" class="missionRisk"><strong>risk:</strong> 0%</div>
                    <div title="10" class="missionStart">
                        <div class="centerButton">
                            <a class="button" href="<?=$this->config->item('base_url')?>actions/espionage/<?=$spy->from?>/<?=$spy->id?>/10/">Start a task</a>
                        </div>
                    </div>
                </li>
            </ul>
    </div>     	<div class="footer"></div>
  </div></div>