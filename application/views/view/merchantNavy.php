<?$this->CI =& get_instance()?>
<div id="mainview">
    <div class="buildingDescription">
        <h1><?=$this->lang->line('trade_fleet')?></h1>
        <p><?=$this->lang->line('trade_fleet_text')?></p>
    </div>

    <div class="contentBox">
        <h3 class="header"><?=$this->lang->line('goods_transports')?></h3>
        <div class="content">
<?if(SizeOf($this->Player_Model->missions) > 0){?>

            <table cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th class="transports"><img src="<?=$this->config->item('style_url')?>skin/characters/fleet/40x40/ship_transport_r_40x40.gif" width="40" height="40" title="<?=$this->lang->line('number_ships')?>" alt="<?=$this->lang->line('quantity')?>"></th>
                    <th class="mission"><?=$this->lang->line('mission')?></th>
                    <th class="source"><?=$this->lang->line('start')?></th>
                    <th class="arrow"></th>
                    <th class="target"><?=$this->lang->line('target')?></th>
                    <th class="arrival"><?=$this->lang->line('arrival')?></th>
                    <th class="actions"><?=$this->lang->line('actions')?></th>
                </tr>
                </thead>
<?php
require_once(APPPATH.'libraries/mission_data.php');
foreach ($this->Player_Model->missions as $mission) {
    $mission = new Mission($this, (array)$mission);
    if ($this->Action_Model->get_mission_owner($mission) == $this->Player_Model->user->id) {
        $all_resources = $mission->wood+$mission->wine+$mission->marble+$mission->crystal+$mission->sulfur+$mission->peoples;
        $mission_state_class = $mission->is_returning() ? "returning" : "gotoown";
        $mission_type_class = strtolower(MissionType::from($mission->type)->name);
        $state_name = MissionState::from($mission->state)->display_name();
?>
                <tr>
                    <td class="transports"><?=$mission->ships?></td>
                    <td class="mission" title="<?=MissionType::from($mission->type)->display_name()?> (<?=$state_name?>)">
                    <div class="mission_icon <?=$mission_type_class?>"></div>
                    </td>
                    <td class="source"><a href="<?=$this->config->item('base_url')?>game/island/<?=$this->Player_Model->towns[$mission->from]->island?>/<?=$this->Player_Model->towns[$mission->from]->id?>/"><?=$this->Player_Model->towns[$mission->from]->name?></a>
                    </td>
                    <td class=" <?=$mission_state_class?>"></td>
                    <td class="target"><a href="<?=$this->config->item('base_url')?>game/island/<?=$this->Data_Model->temp_towns_db[$mission->to]->island?>/<?=$this->Data_Model->temp_towns_db[$mission->to]->id?>/"><?=$this->Data_Model->temp_towns_db[$mission->to]->name?> <?if($this->Data_Model->temp_towns_db[$mission->to]->user != $this->Player_Model->user->id){?>(<?=$this->Data_Model->temp_users_db[$this->Data_Model->temp_towns_db[$mission->to]->user]->login?>)<?}?>&nbsp;</a></td>

                    <td id="arrival<?=$mission->id?>" class="arrival"></td>
                    <td class="actions">
<?if(true){?>
                        <a title="<?=$this->lang->line('withdraw')?>" href="<?=$this->config->item('base_url')?>actions/abortFleet/<?=$mission->id?>/0/merchantNavy/">
                            <img src="<?=$this->config->item('style_url')?>skin/advisors/military/icon-back.gif" title="<?=$this->lang->line('withdraw')?>">
                        </a>
<?}else{?>
                        -
<?}?>
                    </td>
                    </tr>
                    <tr>
                        <td class="pulldown" colspan="7">
                            <div class="pulldown">
                                <div class="content">
                                    <table cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td>
                                                <div class="payload">

                                                    <span class="textLabel"><?=$this->lang->line('cargo')?>:</span>
<?
    $one_percent = ($all_resources > 0) ? 30/$all_resources : 0;
    $wood_icons = ($mission->wood > 0) ? $mission->wood*$one_percent : 0;
    $wine_icons = ($mission->wine > 0) ? $mission->wine*$one_percent : 0;
    $marble_icons = ($mission->marble > 0) ? $mission->marble*$one_percent : 0;
    $crystal_icons = ($mission->crystal > 0) ? $mission->crystal*$one_percent : 0;
    $sulfur_icons = ($mission->sulfur > 0) ? $mission->sulfur*$one_percent : 0;
    $peoples_icons = ($mission->peoples > 0) ? $mission->peoples*$one_percent : 0;
?>
<?if($all_resources == 0){?><?=$this->lang->line('holds_empty')?><?}else{?>
<img src="<?=$this->config->item('style_url')?>skin/img/blank.gif" width="25" height="20">
<?}?>
<?if($wood_icons > 0){?>
<?for ($i = 0; $i < $wood_icons; $i++){?>
<img src="<?=$this->config->item('style_url')?>skin/resources/icon_wood.gif" width="25" height="20" title="<?=number_format($mission->wood)?> <?=$this->lang->line('wood')?>" alt=""  style="margin-left:-17px" >
<?}}?>
<?if($wine_icons > 0){?>
<?for ($i = 0; $i < $wine_icons; $i++){?>
<img src="<?=$this->config->item('style_url')?>skin/resources/icon_wine.gif" width="25" height="20" title="<?=number_format($mission->wine)?> <?=$this->lang->line('wine')?>" alt=""  style="margin-left:-17px" >
<?}}?>
<?if($marble_icons > 0){?>
<?for ($i = 0; $i < $marble_icons; $i++){?>
<img src="<?=$this->config->item('style_url')?>skin/resources/icon_marble.gif" width="25" height="20" title="<?=number_format($mission->marble)?> <?=$this->lang->line('narble')?>" alt=""  style="margin-left:-17px" >
<?}}?>
<?if($crystal_icons > 0){?>
<?for ($i = 0; $i < $crystal_icons; $i++){?>
<img src="<?=$this->config->item('style_url')?>skin/resources/icon_glass.gif" width="25" height="20" title="<?=number_format($mission->crystal)?> <?=$this->lang->line('crystal')?>" alt=""  style="margin-left:-17px" >
<?}}?>
<?if($sulfur_icons > 0){?>
<?for ($i = 0; $i < $sulfur_icons; $i++){?>
<img src="<?=$this->config->item('style_url')?>skin/resources/icon_sulfur.gif" width="25" height="20" title="<?=number_format($mission->sulfur)?> <?=$this->lang->line('sulfur')?>" alt=""  style="margin-left:-17px" >
<?}}?>
<?if($peoples_icons > 0){?>
<?for ($i = 0; $i < $peoples_icons; $i++){?>
<img src="<?=$this->config->item('style_url')?>skin/resources/icon_citizen.gif" width="19" height="20" title="<?=number_format($mission->peoples)?> <?=$this->lang->line('peoples')?>" alt=""  style="margin-left:-17px" >
<?}}?>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="space">
                                                    <img src="<?=$this->config->item('style_url')?>skin/layout/crate.gif" width="22" height="22" alt="<?=$this->lang->line('cargo_space')?>" title="<?=$this->lang->line('cargo_space')?>">
                                                </div><?=number_format($all_resources)?> / <?=number_format($mission->ships * getConfig('transport_capacity'))?>
                                                </td></tr>
                                    </table>
                                </div>
                                <div class="btn"></div>
                            </div>
                        </td>
                    </tr>
            <script type="text/javascript">
                    getCountdown({
                        enddate: <?=$mission->next_stage_time?>,
                        currentdate: <?=time()?>,
                        el: "arrival<?=$mission->id?>",
                        suffix: "</br>(<?=$state_name?>)",
                    });
            </script>
<?}}?>
            </table>
<?}else{?>
<p align="center"><?=$this->lang->line('no_ships_way')?></p>
<?}?>
        </div>
        <div class="footer"></div>
    </div>
</div>

<script>
Event.onDOMReady( function() {
    var pulldowns = Dom.getElementsByClassName("pulldown", 'div', "mainview");
    for(i=0; i<pulldowns.length; i++) {
				var children = Dom.getChildren(pulldowns[i]);
				children[0].contentHeight=children[0].offsetHeight;
				children[0].style.height='0px';
				children[0].style.position="relative";
				children[0].style.overflow="hidden";
        children[1].onmouseover=function(e) {
					this.style.background="url(<?=$this->config->item('style_url')?>skin/interface/pulldown_contentbox_hover.gif)";
				};
        children[1].onmouseout=function(e) {
					this.style.background="url(<?=$this->config->item('style_url')?>skin/interface/pulldown_contentbox.gif)";
				};
        children[1].onclick=function(e) {
					var pulldown = Dom.getChildren(this.parentNode)[0];
					if(pulldown.offsetHeight>0) pulldown.style.height="0px";
					else pulldown.style.height=pulldown.contentHeight+'px';
				};
    }
});
</script>
