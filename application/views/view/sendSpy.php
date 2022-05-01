<div id="mainview">		
    <div class="buildingDescription">
        <h1>Send a spy</h1>
        <p>Send spies to the cities of other players to get intelligence information. As soon as the spy has entered the city, you can give him tasks.<br /><br />Please note that<strong>always</strong> there is a certain risk of exposing a spy! Your spy's reports are archived at<strong>diplomatic adviser</strong>.</p>
    </div>
<?
    $x1 = $this->Player_Model->now_island->x;
    $x2 = $this->Island_Model->island->x;
    $y1 = $this->Player_Model->now_island->y;
    $y2 = $this->Island_Model->island->y;
    $time = $this->Data_Model->spy_time_by_coords($x1,$x2,$y1,$y2);

    $to_position = $this->Data_Model->get_position(14, $this->Data_Model->temp_towns_db[$param1]);
    $to_text = 'pos'.$to_position.'_level';
    $to_level = ($to_position > 0) ? $this->Data_Model->temp_towns_db[$param1]->$to_text : 0;
    $risk = $this->Data_Model->spy_risk_by_mission(1)+(5*$this->Data_Model->temp_towns_db[$param1]->spyes)+(2*$to_level)-(2*$this->Data_Model->temp_towns_db[$param1]->pos0_level)-(2*$this->Player_Model->levels[$this->Player_Model->town_id][14]);
    $risk = ($risk < 5) ? 5 : $risk;
?>
    
    <form  action="<?=$this->config->item('base_url')?>actions/spyes/send/<?=$this->Island_Model->island->id?>/<?=$param1?>/"  method="POST">
        <div class="contentBox01h" id="sendSpy">
            <h3 class="header">Send a spy</h3>
            <div class="content">
                <p class="desc">Your spy will try to infiltrate<?=$this->Data_Model->temp_towns_db[$param1]->name?>. <?=$this->Data_Model->temp_towns_db[$param1]->name?> has level dimensions3. The easiest way for spies to get lost among the population of large cities.							</p>
		<div class="costs"><span class="textLabel">Price: </span>30</div>
                <div class="risk"><span class="textLabel">Exposure risk:</span>
                    <div title="Exposure risk<?=$risk?>%" class="statusBar">
                        <div style="width: <?=$risk?>%" class="bar"></div>
                    </div>
                    <div class="percentage"><?=$risk?>%</div>
                </div>
                <hr>
                <div id="missionSummary">
                    <div class="common">
                        <div class="journeyTarget" title="City"><span class="textLabel">City: </span><?=$this->Data_Model->temp_towns_db[$param1]->name?></div>
                        <div class="journeyTime" title="Travel time"><span class="textLabel">Travel time: </span><?=format_time($time)?></div>
                    </div>
                </div>
                <div class="centerButton">
                    <input id="submit" class="button" type="submit" value="Send a spy">
                </div>
            </div>
            <div class="footer"></div>
        </div>
    </form>
</div>