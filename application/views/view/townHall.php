<?
    $level_text = 'pos'.$position.'_level';
    $type_text = 'pos'.$position.'_type';
    $level = $this->Player_Model->now_town->$level_text;
    $class = $this->Player_Model->now_town->$type_text;
?>
<div id="mainview">
    <h1 style="text-align:center"><?=$this->Data_Model->building_name_by_type($class)?></h1>

<?if ($this->Player_Model->now_town->build_line != '' and $this->Player_Model->build_line[$this->Player_Model->town_id][0]['position'] == $position){?>
<?
    $cost = $this->Data_Model->building_cost($class, $level, $this->Player_Model->research, $this->Player_Model->levels[$this->Player_Model->town_id]);
    $end_date = $this->Player_Model->now_town->build_start + $cost['time'];
    $ostalos = $end_date - time();
    $one_percent = ($cost['time']/100);
    $percent = 100 - floor($ostalos/$one_percent);
?>

    <div id="upgradeInProgress">
        <div class="isUpgrading">In the process of improvement!</div>
        <div class="buildingLevel"><span class="textLabel">Level</span><?=$level?></div>
        <div class="nextLevel"><span class="textLabel">track. level</span><?=$level+1?></div>
        <div class="progressBar">
            <div class="bar" id="upgradeProgress" title="<?=$percent?>%" style="width:<?=$percent?>%;"></div>
            <a class="cancelUpgrade" href="<?=$this->config->item('base_url')?>game/demolition/<?=$position?>/" title="Cancel"><span class="textLabel">Cancel</span></a>
        </div>

                                <script type="text/javascript">
				Event.onDOMReady(function() {
					var tmppbar = getProgressBar({
						startdate: <?=$this->Player_Model->now_town->build_start?>,
						enddate: <?=$end_date?>,
						currentdate: <?=time()?>,
						bar: "upgradeProgress"
						});
					tmppbar.subscribe("update", function(){
						this.barEl.title=this.progress+"%";
						});
					tmppbar.subscribe("finished", function(){
						this.barEl.title="100%";
						});
				});
				</script>


        <div class="time" id="upgradeCountDown"><?=format_time($ostalos)?></div>

                                <script type="text/javascript">
				Event.onDOMReady(function() {
					var tmpCnt = getCountdown({
						enddate: <?=$end_date?>,
						currentdate: <?=time()?>,
						el: "upgradeCountDown"
						}, 2, " ", "", true, true);
					tmpCnt.subscribe("finished", function() {
						setTimeout(function() {
							location.href="<?=$this->config->item('base_url')?>game/<?=$this->Data_Model->building_class_by_type($class)?>/<?=$position?>/";
							},2000);
						});
					});
				</script>

    </div>
<?}?>

<? $city_type = ($this->Player_Model->capital_id == $this->Player_Model->town_id) ? 'The capital' : 'Colony'?>
    
    <div id="CityOverview" class="contentBox">
        <h3 class="header"><?=$city_type?> "<?=$this->Player_Model->now_town->name?>"
            <a href="<?=$this->config->item('base_url')?>game/renameCity/" title="Rename city">Rename</a>
        </h3>

        <div class="content">
            <img class="citizen" src="<?=$this->config->item('style_url')?>skin/characters/y100_citizen_faceright.gif" width="42" height="100" title="" alt="">
            <ul class="stats">
                <li class="space">
                    <span class="textLabel">Living space: </span>
                    <span class="value occupied"><?=number_format(floor($this->Player_Model->peoples[$this->Player_Model->town_id]))?></span>/
                    <span class="value total"><?=number_format(floor($this->Player_Model->max_peoples[$this->Player_Model->town_id]))?></span>
                </li>
                <li class="growth growth_positive">
                    <span class="textLabel">Growth: </span>
                    <span class="value"><?=number_format($this->Player_Model->good[$this->Player_Model->town_id]/50, 2, '.', '')?> per hour</span>
                </li>
                <li class="actions"><span class="textLabel">Action Points: </span>3/3</li>
                <li class="incomegold incomegold_<?if($this->Player_Model->saldo[$this->Player_Model->town_id] > 0){?>positive<?}else{?>negative<?}?>">
                    <span class="textLabel">Gold balance: </span>
                    <span class="value"><?=number_format($this->Player_Model->saldo[$this->Player_Model->town_id])?></span>
                </li>

                <li class="garrisonLimit"><span class="textLabel">Garrison limit: </span><span class="value occupied"><?=number_format($this->Player_Model->garisson_limit[$this->Player_Model->town_id])?></span></li>
                <li class="corruption">
                    <span class="textLabel">decline: </span>
                    <span class="value positive">
                        <span title="decline: situation at the moment"><?=number_format($this->Player_Model->corruption[$this->Player_Model->town_id]*100)?>%</span>
                    </span>
                </li>
                <li class="happiness happiness_<?=$this->Data_Model->good_name_by_count($this->Player_Model->good[$this->Player_Model->town_id])?>">
                    <span class="textLabel">Level of satisfaction with life: </span><?=$this->Data_Model->good_name_by_count($this->Player_Model->good[$this->Player_Model->town_id])?>
                </li>
            </ul>
            
<?
// We build a strip of residents by percentage
    $all_px = 620;   // total pixels
    $min_px = 60;    // minimum size
    $ostalos_px = $all_px - (60*5); // left
    $one_px = $ostalos_px/100;
    $all_plus = $this->Player_Model->peoples[$this->Player_Model->town_id];
    $free_px = floor((($this->Player_Model->now_town->peoples/$all_plus)*100)*$one_px+60);
    $workers_px = floor((($this->Player_Model->now_town->workers/$all_plus)*100)*$one_px+60);
    $special_px = floor((($this->Player_Model->now_town->tradegood/$all_plus)*100)*$one_px+60);
    $research_px = floor((($this->Player_Model->now_town->scientists/$all_plus)*100)*$one_px+60);
    $templer_px = floor((($this->Player_Model->now_town->templer/$all_plus)*100)*$one_px+60);
?>

            <div id="PopulationGraph">			
                <h4>Population and production:</h4>	
                <div class="citizens" style="left:20px;width:<?=$free_px?>px">
                    <span class="type">
                        <span class="count"><?=floor($this->Player_Model->now_town->peoples)?></span>
                        <img src="<?=$this->config->item('style_url')?>skin/characters/40h/citizen_r.gif" title="citizens" alt="citizens">
                    </span> 
                    <span class="production">
                        <span class="textLabel">Production</span>
<?$scientists_gold_need = ($this->Player_Model->research->res3_13 > 0) ? 3 : 6?>
                        <img src="<?=$this->config->item('style_url')?>skin/resources/icon_gold.gif" alt="Gold"> <?if($this->Player_Model->saldo[$this->Player_Model->town_id] > 0){?>+<?}?><?=floor($this->Player_Model->saldo[$this->Player_Model->town_id])?>
                    </span>
                </div>
				
                <div class="woodworkers" style="left:<?=$free_px+20?>px;width:<?=$workers_px?>px">
                    <span class="type">
                        <span class="count"><?=$this->Player_Model->now_town->workers?></span>
                        <img src="<?=$this->config->item('style_url')?>skin/characters/40h/woodworker_r.gif" title="Workers" alt="Workers">
                    </span> 
                    <span class="production">
                        <span class="textLabel">Production</span>
                        <img src="<?=$this->config->item('style_url')?>skin/resources/icon_wood.gif" alt="building materials"> +<?=number_format($this->Player_Model->now_town->workers*(1-$this->Player_Model->corruption[$this->Player_Model->town_id])*$this->Player_Model->plus_wood)?>
                    </span>
                </div>
								
                <div class="specialworkers" style="left:<?=$free_px+$workers_px+20?>px;width:<?=$special_px?>px">
                    <span class="type">
                        <span class="count"><?=$this->Player_Model->now_town->tradegood?></span>
                        <img src="<?=$this->config->item('style_url')?>skin/characters/40h/luxuryworker_r.gif" title="Workers" alt="Workers">
                    </span>       
                    <span class="production">
                        <span class="textLabel">Production</span>
<?$plus_text = 'plus_'.$this->Data_Model->resource_class_by_type($this->Player_Model->now_island->trade_resource)?>
        <img src="<?=$this->config->item('style_url')?>skin/resources/icon_<?=resource_icon($this->Player_Model->now_island->trade_resource)?>.gif">
+<?=number_format($this->Player_Model->now_town->tradegood*(1-$this->Player_Model->corruption[$this->Player_Model->town_id])*$this->Player_Model->$plus_text)?>
                    </span> 
                </div>
								
                <div class="scientists" style="left:<?=$free_px+$workers_px+$special_px+20?>px;width:<?=$research_px?>px">
                    <span class="type">
                        <span class="count"><?=$this->Player_Model->now_town->scientists?></span>
                        <img src="<?=$this->config->item('style_url')?>skin/characters/40h/scientist_r.gif" title="Scientists" alt="Scientists">
                    </span> 
                    <span class="production">
                        <span class="textLabel">Production</span>
                        <img src="<?=$this->config->item('style_url')?>skin/resources/icon_research.gif" alt="Science points"> +<?=$this->Player_Model->now_town->scientists?>
                    </span>
                </div>
								
                <div class="priests" style="left:<?=$free_px+$workers_px+$special_px+$research_px+20?>px;width:<?=$templer_px?>px">
                    <span class="type">
                        <span class="count"><?=$this->Player_Model->now_town->templer?></span>
                        <img src="<?=$this->config->item('style_url')?>skin/characters/40h/templer_r.gif" title="Priests" alt="Priests">
                    </span> 
                </div>				
            </div>
				
            <div id="notices">			
                <h4>Notes:</h4>
<?if($this->Player_Model->corruption[$this->Player_Model->town_id] > 0){?>
                <div class="warning">
                    <h5>Colony in decline!</h5>
                    <p>The level of productivity and the level of satisfaction with life in this city are falling! The governor's residence should be improved - while the number of levels should correspond to the number of colonies!</p>
                </div>
<?}else{?>
                <p>No incidents! Congratulations, the development of the city is going in the best way!</p>
<?}?>
            </div>			
        </div>
						
        <div class="footer"></div>	
    </div>
					
    <div class="contentBox">				
        <h3 class="header">Level of satisfaction with life</h3>			
        <div class="content">			
            <p>The level of satisfaction of the population in the city is determined by many factors. This image will help clarify problems and show opportunities for development.</p>
            <div id="SatisfactionOverview">
                <div class="positives">
                    <h4>Bonuses</h4>
                    <div class="cat basic">
                        <h5>Main bonuses</h5>
<?
// We build a strip of pluses by percentage
    $all_px = 400;   // total pixels
    $min_px = 60;    // minimum size
    $base_px = $min_px;
    $research_px = $min_px;
    $capital_px = $min_px;
    $ostalos_px = $all_px - $base_px - $research_px - $capital_px; // left
    $one_px = $ostalos_px/100;
    $all_plus = $this->Player_Model->plus[$this->Player_Model->town_id]['base'] + $this->Player_Model->plus[$this->Player_Model->town_id]['research'] + $this->Player_Model->plus[$this->Player_Model->town_id]['capital'];
    $base_percent = ($this->Player_Model->plus[$this->Player_Model->town_id]['base']/$all_plus)*100;
    $research_percent = ($this->Player_Model->plus[$this->Player_Model->town_id]['research']/$all_plus)*100;
    $capital_percent = ($this->Player_Model->plus[$this->Player_Model->town_id]['capital']/$all_plus)*100;
?>

                        <div class="base" style="left:100px;width:<?=floor($base_percent*$one_px)+$base_px?>px"><span class="value">+<?=$this->Player_Model->plus[$this->Player_Model->town_id]['base']?></span> <img src="<?=$this->config->item('style_url')?>skin/icons/city_30x30.gif" width="30" height="30" title="Main bonus" alt="Main bonus"></div>
                        <div class="research1" style="left:<?=floor($base_percent*$one_px)+$base_px+100?>px;width:<?=floor($research_percent*$one_px)+$research_px?>px"><span class="value">+<?=$this->Player_Model->plus[$this->Player_Model->town_id]['research']?></span> <img src="<?=$this->config->item('style_url')?>skin/icons/researchbonus_30x30.gif" width="30" height="30" title="Through research" alt="Through research"></div>
                        <div class="capital" style="left:<?=floor($base_percent*$one_px)+$base_px+floor($research_percent*$one_px)+$research_px+100?>px;width:<?=floor($capital_percent*$one_px)+$capital_px?>px"><span class="value">+<?=$this->Player_Model->plus[$this->Player_Model->town_id]['capital']?></span> <img src="<?=$this->config->item('style_url')?>skin/layout/crown.gif" width="20" height="20" title="Capital Bonus" alt="Capital Bonus"></div>
                    </div>
                    <div class="cat wine">
                        <h5>Wine</h5>
<?$tavern_position = $this->Data_Model->get_position(8, $this->Player_Model->now_town)?>
<?if($this->Player_Model->levels[$this->Player_Model->town_id][8] > 0 and $tavern_position > 0){

// We build a strip of pluses by percentage
    $all_px = 400;   // total pixels
    $min_px = 60;    // minimum size
    $tavern_px = $min_px;
    $serving_px = $min_px;
    $ostalos_px = $all_px - $tavern_px - $serving_px; // left
    $one_px = $ostalos_px/100;
    $all_plus = ($this->Player_Model->levels[$this->Player_Model->town_id][8]*12) + ($this->Player_Model->now_town->tavern_wine*60);
    $tavern_percent = (($this->Player_Model->levels[$this->Player_Model->town_id][8]*12)/$all_plus)*100;
    $serving_percent = (($this->Player_Model->now_town->tavern_wine*60)/$all_plus)*100;
?>
                        <div class="tavern" style="left:100px;width:<?=floor($tavern_percent*$one_px)+$tavern_px?>px"><span class="value">+<?=$this->Player_Model->levels[$this->Player_Model->town_id][8]*12?></span> <img src="<?=$this->config->item('style_url')?>skin/buildings/tavern_30x30.gif" width="30" height="30" title="Tavern level" alt="Tavern level"></div>
                        <div class="serving" style="left:<?=floor($tavern_percent*$one_px)+$base_px+100?>px;width:<?=floor($serving_percent*$one_px)+$serving_px?>px"><span class="value">+<?=$this->Player_Model->now_town->tavern_wine*60?></span> <img src="<?=$this->config->item('style_url')?>skin/resources/icon_wine.gif" width="30" height="30" title="Making wine" alt="Making wine"></div>
<?}else{?>
                        <p>There is no tavern in the city!</p>
<?}?>
                    </div>
                    <div class="cat culture">
                        <h5>Culture</h5>
                        <p>There is no museum in the city!</p>
                    </div>
                </div>

                <div class="negatives">
                    <h4>Deductions</h4>
                    <div class="cat overpopulation" >
                        <h5>Population:</h5>
<?
    $peoples_percent = ($this->Player_Model->peoples[$this->Player_Model->town_id]/$this->Player_Model->max_peoples[$this->Player_Model->town_id])*$all_px;
?>
                        <div class="bar" style="left:100px;width:<?=floor($peoples_percent)?>px;"><span class="value">-<?=number_format($this->Player_Model->peoples[$this->Player_Model->town_id])?></span></div>
                    </div>
                </div>

								
                <div class="happiness happiness_<?=$this->Data_Model->good_name_by_count($this->Player_Model->good[$this->Player_Model->town_id])?>">
                    <h4>General level of satisfaction:</h4>		
                    <div class="value"><?=number_format($this->Player_Model->good[$this->Player_Model->town_id])?></div>
                    <div class="text"><?=$this->Data_Model->good_name_by_count($this->Player_Model->good[$this->Player_Model->town_id])?></div>
                </div>
            </div>
						
        </div>
						
        <div class="footer"></div>				
    </div>
</div>