<div id="mainview">
<?include_once('building_description.php')?>
    <div class="contentBox01h">
        <h3 class="header"><span class="textLabel">Cities of your empire</span></h3>
        <div class="content">
            <table cellpadding="0" cellspacing="0" class="table01">
                <thead>
                    <tr>
                        <th class="crown"></th>
                        <th>City</th>
                        <th>Level</th>
                        <th>The palace</th>
                        <th>Island</th>
                        <th>Resource</th>
                    </tr>
                </thead>
                <tbody>
<?foreach($this->Player_Model->towns as $town){?>
<?
    // palace level
    $level = 0;
    for($i = 3; $i <= 13; $i++)
    {
        $type_text = 'pos'.$i.'_type';
        $level_text = 'pos'.$i.'_level';
        if ($town->$type_text == 10){ $level = $town->$level_text; }
    }
?>
                    <tr>
                        <td><?if($town->id == $this->Player_Model->capital_id){?><img src="<?=$this->config->item('style_url')?>skin/layout/crown.gif" width="20" height="20" alt="The capital" title="The capital"><?}?></td>
                        <td><?=$town->name?></td>
                        <td><?=$town->pos0_level?></td>
                        <td><?=$level?></td>
                        <td><?=$this->Player_Model->islands[$town->island]->name?> [<?=$this->Player_Model->islands[$town->island]->x?>:<?=$this->Player_Model->islands[$town->island]->y?>]</td>
                        <td><img src="<?=$this->config->item('style_url')?>skin/resources/icon_<?=resource_icon($this->Player_Model->islands[$town->island]->trade_resource)?>.gif"  title="<?=$this->Data_Model->island_building_by_resource($this->Player_Model->islands[$town->island]->trade_resource)?>" alt="<?=$this->Data_Model->island_building_by_resource($this->Player_Model->islands[$town->island]->trade_resource)?>"></td>
                    </tr>
<?}?>
                </tbody>
            </table>
        </div>
	<div class="footer"></div>
    </div>
<?if($param2 == 'upgrade'){?>
<div class="contentBox01h" id="moveCapitalConfirmation">
    <h3 class="header"><span class="textLabel">Confirm</span></h3>
    <div class="content">
        <p>Do you really want to do<?=$this->Player_Model->now_town->name?> capital? Keep in mind: <ul><li> the governor's residence will become a new palace.</li><li>Palace level<?=$this->Player_Model->levels[$this->Player_Model->capital_id][10]?> in the old capital<?=$this->Player_Model->towns[$this->Player_Model->capital_id]->name?> will<strong>completely destroyed</strong>! You<strong>don't get resources</strong>! Construction costs will be lost!</li><ul></p>
            <div class="centerButton">
                <a href="<?=$this->config->item('base_url')?>actions/changeCapital/<?=$this->Player_Model->now_town->id?>/" class="button">Confirmation</a>
            </div>
    </div>
    <div class="footer"></div>
</div>
<?}else{?>
<div class="contentBox01h" id="moveCapital">
    <h3 class="header"><span class="textLabel">Move capital</span></h3>
    <div class="content">
        <p>You can make this colony<strong>capital</strong>. Governor's Residence<strong>will become a palace of the same level</strong> and the city would become the capital of the empire. But keep in mind that the palace in your former capital<strong>will be destroyed</strong> - need to build a new governor's residence!</p>
        <div class="centerButton">
            <a href="<?=$this->config->item('base_url')?>game/palaceColony/upgrade/" class="button">Make this city the capital</a>
        </div>
    </div>
    <div class="footer"></div>
</div>
<?}?>
</div>
