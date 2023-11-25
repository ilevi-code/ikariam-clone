<?if ($this->Player_Model->research->res2_3 == 0){?>
<div id="mainview">

<?if($this->Island_Model->island->trade_resource == 1){?>
    <div class="buildingDescription"  style="background:url(skin/img/island/resource_wine.gif) no-repeat right 10px; min-height:180px;">
<?}elseif($this->Island_Model->island->trade_resource == 2){?>
    <div class="buildingDescription"  style="background:url(skin/img/island/resource_marble.gif) no-repeat right 10px; min-height:180px;">
<?}elseif($this->Island_Model->island->trade_resource == 3){?>
    <div class="buildingDescription"  style="background:url(skin/img/island/resource_glass.gif) no-repeat right 10px; min-height:180px;">
<?}elseif($this->Island_Model->island->trade_resource == 4){?>
    <div class="buildingDescription"  style="background:url(skin/img/island/resource_sulfur.gif) no-repeat right 10px; min-height:180px;">
<?}?>
        <h1><?=$this->Data_Model->island_building_by_resource($this->Island_Model->island->trade_resource)?></h1>
        <p>To obtain this resource, you need to research Welfare!</p>
    </div>
</div>
<?}else{?>
<?
    $plus_text = 'plus_'.$this->Data_Model->resource_class_by_type($this->Island_Model->island->trade_resource);
    $cost = $this->Data_Model->island_cost($this->Island_Model->island->trade_resource, $this->Island_Model->island->trade_level);
    $peoples = floor($this->Player_Model->now_town->peoples);
    $all = $this->Player_Model->now_town->peoples + $this->Player_Model->now_town->tradegood;
    $max = ($cost['workers'] < $all) ? $cost['workers'] : $all;
    $max = floor($max);
    $over_max = $max;
    if ($this->Player_Model->research->res2_5 > 0 and $all >= $max)
    {
        $over_max = $max + $cost['workers']*0.5;
        $over_max = ($over_max < $all) ? $over_max : $all;
        $over_max = floor($over_max);
    }
    $production = $this->Player_Model->tradegood_production[$this->Player_Model->town_id]*3600;
?>

<div id="mainview">
    <div class="buildingDescription">
        <h1><?=$this->Data_Model->island_building_by_resource($this->Island_Model->island->trade_resource)?></h1>
        <p></p>
    </div>

    <form id="setWorkers" action="<?=$this->config->item('base_url')?>actions/workers/tradegood/<?=$this->Island_Model->island->id?>"  method="POST">
        <div id="setWorkersBox" class="contentBox">
            <h3 class="header"><span class="textLabel">Assign workers</span></h3>
            <div class="content">
                <ul>
                    <li class="citizens"><span class="textLabel">citizens: </span><span class="value" id="valueCitizens"><?=$peoples?></span></li>
                    <li class="workers"><span class="textLabel">Workers: </span><span class="value" id="valueWorkers"><?=number_format($this->Player_Model->now_town->tradegood)?></span></li>
                    <li class="gain" title="Production:<?=number_format($production)?>" alt="Production:<?=number_format($production)?>">
                        <span class="textLabel">Capacity: </span>
                        <div id="gainPoints">
                            <div id="resiconcontainer">
        <img id="resicon" src="<?=$this->config->item('style_url')?>skin/resources/icon_<?=resource_icon($this->Island_Model->island->trade_resource)?>.gif" width="25" height="20">
                            </div>
                        </div>
                        <div class="gainPerHour">
                            <span id="valueResource" >+<?=number_format($production)?></span> <span class="timeUnit">per hour</span>
                        </div>
                    </li>
                    <li class="costs">
                        <span class="textLabel">City income: </span>
                        <span id="valueWorkCosts" class="negative"><?=floor($this->Player_Model->saldo[$this->Player_Model->town_id])?></span>
                        <img src="<?=$this->config->item('style_url')?>skin/resources/icon_gold.gif" title="Gold" alt="Gold">
                        <span class="timeUnit"> per hour</span>
                    </li>
                </ul>
                <div id="overchargeMsg" class="status nooc ocready oced">Overload!</div>
                <div class="slider" id="sliderbg">
                    <div class="actualValue" id="actualValue"></div>
                    <div class="overcharge" id="overcharge"></div>
                    <div id="sliderthumb"></div>
                </div>
                <a class="setMin" href="#reset" onClick="sliders['default'].setActualValue(0); return false;" title="no workers"><span class="textLabel">i</span></a>
                <a class="setMax" href="#max" onClick="sliders['default'].setActualValue(<?=$max?>); return false;" title="Max. number of workers"><span class="textLabel">max.</span></a>

                <input class="textfield" id="inputWorkers" type="text" name="tw" maxlength="4" autocomplete="off">
                <input class="button" id="inputWorkersSubmit" type="submit" value="Confirmation">
            </div>
            <div class="footer"></div>
        </div>
    </form>

    <div id="resourceUsers" class="contentBox">
        <h3 class="header"><span class="textLabel">Other players on this island</span></h3>
        <div class="content">
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th>Player</th>
                        <th>City</th>
                        <th>Level</th>
                        <th>Workers</th>
                        <th>Donated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

<? for ($i = 0; $i <= 15; $i++){?>
<?if (isset($this->Island_Model->towns[$i])){?>
    <?if($this->Player_Model->user->id != $this->Island_Model->users[$i]->id){?>
    <tr class="alt avatar ">
    <?}else{?>
    <tr class="alt own avatar ">
    <?}?>
        <td class="ownerName"><?=$this->Island_Model->users[$i]->login?></td>
        <td class="cityName"><?=$this->Island_Model->towns[$i]->name?></td>
        <td class="cityLevel">Level<?=$this->Island_Model->towns[$i]->pos0_level?></td>
        <td class="cityWorkers"><?=$this->Island_Model->towns[$i]->tradegood?> Workers</td>
        <td class="ownerDonation"><?=$this->Island_Model->towns[$i]->tradegood_wood?> <img src="<?=$this->config->item('style_url')?>skin/resources/icon_wood.gif" width="25" height="20" alt="building materials" /></td>
        <?if($this->Player_Model->user->id != $this->Island_Model->users[$i]->id){?>
        <td class="actions"><a href="<?=$this->config->item('base_url')?>game/sendIKMessage/<?=$this->Island_Model->towns[$i]->user?>/"><img src="<?=$this->config->item('style_url')?>skin/interface/icon_message_write.gif" alt="Create message" /></a></td>
        <?}?>
    </tr>
<?}?>
<?}?>

                </tbody>
            </table>
        </div>
        <div class="footer"></div>
    </div>
</div>

<script type="text/javascript">
    create_slider({
        dir : 'ltr',
        id : "default",
        maxValue : <?=floor($max)?>,
        overcharge : <?=$over_max-$max?>,
        iniValue : <?=floor($this->Player_Model->now_town->tradegood)?>,
        bg : "sliderbg",
        thumb : "sliderthumb",
        topConstraint: -10,
        bottomConstraint: 344,
        bg_value : "actualValue",
        bg_overcharge : "overcharge",
        textfield:"inputWorkers"
    });
    Event.onDOMReady(function() {
	var slider = sliders["default"];
        var res = new resourceStack({
            container : "resiconcontainer",
            resourceicon : "resicon",
            width : 140
        });
        res.setIcons(Math.floor(slider.actualValue/(1+0.05*slider.actualValue)));
        slider.subscribe("valueChange", function() {
            res.setIcons(Math.floor(slider.actualValue/(1+0.05*slider.actualValue)));
        });
        var startSlider = slider.actualValue;
        var valueWorkers = Dom.get("valueWorkers");
        var valueCitizens = Dom.get("valueCitizens");
        var valueResource = Dom.get("valueResource");
        var valueWorkCosts = Dom.get("valueWorkCosts");
        var inputWorkersSubmit = Dom.get("inputWorkersSubmit");
        slider.flagSliderMoved =0;
        slider.subscribe("valueChange", function() {
            var startCitizens = <?=floor($this->Player_Model->now_town->peoples)?>;
            var startResourceWorkers = <?=floor($this->Player_Model->now_town->tradegood)?>;
            var startIncomePerTimeUnit = <?=floor($this->Player_Model->saldo[$this->Player_Model->town_id])?>;
            this.flagSliderMoved = 1;
            valueWorkers.innerHTML = locaNumberFormat(slider.actualValue);
            valueCitizens.innerHTML = locaNumberFormat(startCitizens+startResourceWorkers - slider.actualValue);
            var valRes = <?=($this->Player_Model->$plus_text)?> * <?=(1-$this->Player_Model->corruption[$this->Player_Model->town_id])?> * (Math.min(<?=$cost['workers']?>, slider.actualValue) + Math.max(0, 0.25 * (slider.actualValue-<?=$cost['workers']?>)));
            valueResource.innerHTML = '+' + Math.floor(valRes);
            valueWorkCosts.innerHTML = startIncomePerTimeUnit  - 3*(slider.actualValue-startSlider);
        });
        slider.subscribe("slideEnd", function() {
            if (this.flagSliderMoved) {
                inputWorkersSubmit.className = 'buttonChanged';
            }
        });
    });
</script>
<?}?>
