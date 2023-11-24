<?  $level_text = 'pos'.$position.'_level';
    $level = $this->Player_Model->now_town->$level_text;
    $speed = $this->Data_Model->speed_by_port_level($level);
?>
<div id="mainview">
<?include_once('building_description.php')?>
    <div class="contentBox01h">
        <h3 class="header"><span class="textLabel">Buy a merchant ship</span></h3>
        <div class="content">
            <ul id="units">
                <li class="unit">
                    <div class="unitinfo">
                        <h4>Cargo ship</h4>
                        <a title="Learn more about Bulk Cargo..." href="<?=$this->config->item('base_url')?>game/shipDescription/23/">
                            <img src="<?=$this->config->item('style_url')?>skin/characters/fleet/120x100/ship_transport_r_120x100.gif">
                        </a>
                        <div class="unitcount"><span class="textLabel">Available: </span><?=$this->Player_Model->all_transports?></div>
                        <p>Trade ships are the most important support for your island empire. No matter whether they have to transport good, units or news: your seaman will make sure, that everything arrives at its destination quick and safely</p>
                    </div>
                    <label for="textfield_">Buy a merchant ship:</label>

                    <div class="forminput">Maximum: 160<br>
<?if($this->Player_Model->user->gold >= $this->Data_Model->transport_cost_by_count($this->Player_Model->all_transports)){?>
                        <div class="leftButton">
                          <form action="/<?=$this->config->item('base_url')?>actions/transporter" method="post">
                            <input class="button bigButton" type="submit" value="Buy a merchant ship">
                          </form>
                        </div>
<?}else{?>
Not enough resources
<?}?>
                    </div>
                    <div class="costs">
                        <ul class="resources">
<?if($this->Data_Model->transport_cost_by_count($this->Player_Model->all_transports) > 0){?>
                            <li class="gold"><span class="textLabel">Gold: </span><?=number_format($this->Data_Model->transport_cost_by_count($this->Player_Model->all_transports))?></li>
<?}?>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="footer"></div>
    </div>

    <div class="contentBox01h">
        <h3 class="header"><span class="textLabel">Send a merchant ship</span></h3>
        <div class="content">
            <ul class="cities">
<?foreach($this->Player_Model->towns as $town)?>
<?if($town->id != $this->Player_Model->town_id){?>
<li><a title="Transport in<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/transport/<?=$town->island?>/<?=$town->id?>/">(<?=$this->Player_Model->islands[$town->island]->x?>:<?=$this->Player_Model->islands[$town->island]->y?>) <?=$town->name?></a></li>
<?}?>
            </ul>
        </div>
        <div class="footer"></div>
    </div>
    <div class="contentBox01h" style="z-index:100">
        <h3 class="header"><span class="textLabel">Fleets on load</span></h3>
        <div class="content master">
            <div class="tcap">My merchant ships</div>
<?$m_id = 0?>
<?if($this->Player_Model->missions_loading > 0){?>
<?foreach($this->Player_Model->missions as $mission){
if ($mission->mission_start == 0){?>
<?
    $wood = $mission->wood;
    $marble = $mission->marble;
    $wine = $mission->wine;
    $crystal = $mission->crystal;
    $sulfur = $mission->sulfur;
    $peoples = $mission->peoples;
    $all_resources = $wood + $marble + $wine + $crystal + $sulfur + $peoples;
    $per_sec = $speed / 60;
    $all_time = ($all_resources/$per_sec);
    $elapsed = (time() - $mission->loading_from_start);
    if($all_time <= $elapsed){ $time = 0; } else { $time = $all_time - $elapsed; }
?>
            <table cellpadding="0" cellspacing="0" class="table01">
                <thead>
                    <tr>
                        <th class="origin">Destination</th>
                        <th>Quantity</th>
                        <th>Mission</th>
                        <th>Status
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
<tr>            
    <td>Policy</td>
    <td>
        <div class="tooltip" style="position:absolute;width:100px;overflow:show;">
            <table border='0' cellspacing='0' class='stuff'>
                <tr><th colspan='2'>Goods on board</th></tr>
<?if($wood > 0){?>
                <tr><td class='unit'><img src='<?=$this->config->item('style_url')?>skin/resources/icon_wood.gif'></td><td class='count'><?=number_format($wood)?></td></tr>
<?}?>
<?if($wine > 0){?>
                <tr><td class='unit'><img src='<?=$this->config->item('style_url')?>skin/resources/icon_wine.gif'></td><td class='count'><?=number_format($wine)?></td></tr>
<?}?>
<?if($marble > 0){?>
                <tr><td class='unit'><img src='<?=$this->config->item('style_url')?>skin/resources/icon_marble.gif'></td><td class='count'><?=number_format($marble)?></td></tr>
<?}?>
<?if($crystal > 0){?>
                <tr><td class='unit'><img src='<?=$this->config->item('style_url')?>skin/resources/icon_glass.gif'></td><td class='count'><?=number_format($crystal)?></td></tr>
<?}?>
<?if($sulfur > 0){?>
                <tr><td class='unit'><img src='<?=$this->config->item('style_url')?>skin/resources/icon_sulfur.gif'></td><td class='count'><?=number_format($sulfur)?></td></tr>
<?}?>
<?if($peoples > 0){?>
                <tr><td class='unit'><img src='<?=$this->config->item('style_url')?>skin/resources/icon_citizen.gif'></td><td class='count'><?=number_format($peoples)?></td></tr>
<?}?>
            </table>
        </div><?=$mission->ship_transport?>
    </td>
    <td><?=$this->Data_Model->mission_name_by_type($mission->mission_type)?></td>
    <td>
<?if($m_id == 0){?>
        <div class="time" id="outgoingOwnCountDown"><?=format_time($time)?></div>
        <div class="progressBar"><div class="bar" id="outgoingOwnProgress"></div>
        </div>

        <script type="text/javascript">
            Event.onDOMReady(function() {
                getCountdown({
                    enddate: <?=time()+$time?>,
                    currentdate: <?=time()?>,
                    el: "outgoingOwnCountDown"
                }, 2, " ", "", true, true);
                var tmppbar = getProgressBar({
                    startdate: <?=$mission->loading_from_start?>,
                    enddate: <?=time()+$time?>,
                    currentdate: <?=time()?>,
                    bar: "outgoingOwnProgress"
                });
                tmppbar.subscribe("update", function(){
                    this.barEl.title=this.progress+"%";
                });
                tmppbar.subscribe("finished", function(){
                    this.barEl.title="100%";
                });
            });
	</script>
        Loading</td><td>
        <a title="Recall the fleet!" href="<?=$this->config->item('base_url')?>actions/abortFleet/<?=$mission->id?>/<?=$position?>/">
            <img src="<?=$this->config->item('style_url')?>skin/advisors/military/icon-back.gif" title="Recall the fleet!">
        </a>
<?}else{?>
Expectation
<?}?>
    </td>
</tr>
                </tbody>
            </table>
<?$m_id++;?>
<?}?>
<?}}?>
<?if($m_id == 0){?>
            <p>No registered ships in the port</p>
<?}?>
            <div class="tcap">foreign ships</div>
            <p>No registered ships in the port</p>
        </div>
        <div class="footer"></div>
    </div>

    <div class="contentBox01h" style="z-index:50;">
        <h3 class="header"><span class="textLabel">Incoming merchants</span></h3>
        <div class="content master"><p>No registered ships in the port</p></div>
        <div class="footer"></div>
    </div> 
</div>
