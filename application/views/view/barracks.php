<div id="mainview">
<?include_once('building_description.php')?>
    <form id="buildForm"  action="<?=$this->config->item('base_url')?>actions/army/<?=$position?>" method="POST">
        <input type=hidden name="action" value="buildUnits">
        <div class="contentBox01h">
            <h3 class="header"><?=$this->lang->line('recruit_units')?></h3>
            <div class="content">
                <ul id="units">
<?for($i = 1; $i <= 14; $i++){
    $researched = true;

    $cost = $this->Data_Model->army_cost_by_type($i, $this->Player_Model->research, $this->Player_Model->levels[$this->Player_Model->town_id]);
    $cost_research = $cost['required_research'];
    if (!is_null($cost_research)) {
        [$category, $research_num] = $cost_research;
        $researched = $this->Action_Model->have_researched($category, $research_num);
    }

    if ($researched) {
    $max_wood = 0;
    $max_sulfur = 0;
    $max_wine = 0;
    $max_crystal = 0;
    $max_peoples = 0;
    $class = $this->Data_Model->army_class_by_type($i);
    if ($cost['wood'] > 0){ $max_wood = floor($this->Player_Model->now_town->wood/$cost['wood']);}
    if ($cost['sulfur'] > 0){ $max_sulfur = floor($this->Player_Model->now_town->sulfur/$cost['sulfur']); }
    if ($cost['wine'] > 0){ $max_wine = floor($this->Player_Model->now_town->wine/$cost['wine']); }
    if ($cost['crystal'] > 0){ $max_crystal = floor($this->Player_Model->now_town->crystal/$cost['crystal']); }
    if ($cost['peoples'] > 0){ $max_peoples = floor($this->Player_Model->now_town->peoples/$cost['peoples']); }
    $max = 999999;
    if ($cost['wood'] > 0){ $max = ($max_wood > $max) ? $max : $max_wood; }
    if ($cost['sulfur'] > 0){ $max = ($max_sulfur > $max) ? $max : $max_sulfur; }
    if ($cost['wine'] > 0){ $max = ($max_wine > $max) ? $max : $max_wine; }
    if ($cost['crystal'] > 0){ $max = ($max_crystal > $max) ? $max : $max_crystal; }
    if ($cost['peoples'] > 0){ $max = ($max_peoples > $max) ? $max : $max_peoples; }
?>
                    <li class="unit <?=$class?>">
                        <div class="unitinfo">
                            <h4><?=$this->Data_Model->army_name_by_type($i)?></h4>
                            <a title="<?=$this->lang->line('to_description')?> <?=$this->Data_Model->army_name_by_type($i)?>" href="<?=$this->config->item('base_url')?>game/unitDescription/<?=$i?>">
                                <img src="<?=$this->config->item('style_url')?>skin/characters/military/120x100/<?=$class?>_r_120x100.gif">
                            </a>
                            <div class="unitcount"><span class="textLabel"><?=$this->lang->line('available')?>: </span><?=$this->Player_Model->armys[$this->Player_Model->town_id]->$class?></div>
                            <p><?=$this->Data_Model->army_desc_by_type($i)?></p>
                        </div>
                        <label for="textfield_<?=$class?>"><?=$this->lang->line('recruit')?> <?=$this->Data_Model->army_name_by_type($i)?></label>
                        <div class="sliderinput">
                            <div class="sliderbg" id="sliderbg_<?=$class?>">
                                <div class="actualValue" id="actualValue_<?=$class?>"></div>
                                <div class="sliderthumb" id="sliderthumb_<?=$class?>"></div>
                            </div>
<script type="text/javascript">
    create_slider({
        dir : 'ltr',
        id : "slider_<?=$class?>",
        maxValue : <?=$max?>,
        overcharge : 0,
        iniValue : 0,
        bg : "sliderbg_<?=$class?>",
        thumb : "sliderthumb_<?=$class?>",
        topConstraint: -10,
        bottomConstraint: 326,
        bg_value : "actualValue_<?=$class?>",
        textfield:"textfield_<?=$class?>"
    });
    var slider = sliders["default"];
</script>
                            <a class="setMin" href="#reset" onClick="sliders['slider_<?=$this->Data_Model->army_class_by_type($i)?>'].setActualValue(0); return false;" title="<?=$this->lang->line('reset_entry')?>"><span class="textLabel"><?=$this->lang->line('min')?></span></a>
                            <a class="setMax" href="#max" onClick="sliders['slider_<?=$this->Data_Model->army_class_by_type($i)?>'].setActualValue(<?=$max?>); return false;" title="<?=$this->lang->line('recruit_max')?>"><span class="textLabel"><?=$this->lang->line('max')?></span></a>
			</div>
<?if ($this->Player_Model->now_town->build_line != '' and $this->Player_Model->build_line[$this->Player_Model->town_id][0]['position'] == $position){?>
                        <div class="forminput">
                            <?=$this->lang->line('is_upgrading')?>
                        </div>
<?}else{?>
<?if ($cost['required_level'] > $level) {?>
                        <div class="forminput"><?=$this->lang->line('building_low')?></div>
<?}else{?>
                        <div class="forminput">
                            <input class="textfield" id="textfield_<?=$this->Data_Model->army_class_by_type($i)?>" type="text" name="<?=$i?>"  value="0" size="4" maxlength="4">
                            <a class="setMax" href="#max" onClick="sliders['slider_<?=$this->Data_Model->army_class_by_type($i)?>'].setActualValue(<?=$max?>); return false;" title="<?=$this->lang->line('recruit_max')?>">
                                <span class="textLabel"><?=$this->lang->line('max')?></span>
                            </a>
                            <input class="button" type=submit value="<?=$this->lang->line('recruit')?>!">
                        </div>
<?}}?>

                        <div class="costs">
                            <h5>Price:</h5>
                            <ul class="resources">
<?if($cost['peoples'] > 0){?>
                                <li class="citizens" title="<?=$this->lang->line('peoples')?>"><span class="textLabel"><?=$this->lang->line('peoples')?>: </span><?=$cost['peoples']?></li>
<?}?>
<?if($cost['wood'] > 0){?>
                                <li class="wood" title="<?=$this->lang->line('wood')?>"><span class="textLabel"><?=$this->lang->line('wood')?>: </span><?=number_format($cost['wood'])?></li>
<?}?>
<?if($cost['sulfur'] > 0){?>
                                <li class="sulfur" title="<?=$this->lang->line('sulfur')?>"><span class="textLabel"><?=$this->lang->line('sulfur')?>: </span><?=number_format($cost['sulfur'])?></li>
<?}?>
<?if($cost['wine'] > 0){?>
                                <li class="wine" title="<?=$this->lang->line('wine')?>"><span class="textLabel"><?=$this->lang->line('wine')?>: </span><?=number_format($cost['wine'])?></li>
<?}?>
<?if($cost['crystal'] > 0){?>
                                <li class="glass" title="<?=$this->lang->line('crystal')?>"><span class="textLabel"><?=$this->lang->line('crystal')?>: </span><?=number_format($cost['crystal'])?></li>
<?}?>
<?if($cost['gold'] > 0){?>
                                <li class="upkeep" title="<?=$this->lang->line('upkeep_hour')?>"><span class="textLabel"><?=$this->lang->line('upkeep_hour')?>: </span><?=number_format($cost['gold'])?></li>
<?}?>
<?if($cost['time'] > 0){?>
                                <li class="time" title="<?=$this->lang->line('build_time')?>"><span class="textLabel"><?=$this->lang->line('build_time')?>: </span><?=format_time($cost['time'])?></li>
<?}?>
                            </ul>
                        </div>
                    </li>
<?}?>
<?}?>
				</ul>
			</div>
			<div class="footer"></div>
		</div>
		</form>
	</div>
