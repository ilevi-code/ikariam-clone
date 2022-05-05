<div id="mainview">
    <h1>Building overview</h1>
    <div class="yui-navset">
        <ul class="yui-nav">
            <li <?if($param1=='resources'){?>class="selected"<?}?>><a href="<?=$this->config->item('base_url')?>game/premiumTradeAdvisor/resources/" title="Resources"><em>Resources</em></a></li>
            <li <?if($param1=='population'){?>class="selected"<?}?>><a href="<?=$this->config->item('base_url')?>game/premiumTradeAdvisor/population/" title="citizens"><em>citizens</em></a></li>
            <li <?if($param1=='buildings'){?>class="selected"<?}?>><a href="<?=$this->config->item('base_url')?>game/premiumTradeAdvisor/buildings/" title="Building"><em>Building</em></a></li>
        </ul>
    </div>
<?if($param1=='population'){?>
    <div id="populationOverview" class="contentBox">
        <h3 class="header"><span class="textLabel">An overview of the empire</span></h3>
        <div class="content">
            <table cellpadding="0" cellspacing="0" class="overview">
                <tr>
                    <th title="City"><img src="<?=$this->config->item('style_url')?>skin/layout/city.gif" alt="City" title="City"></th>
                    <th title="Population"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_population.gif" alt="Population" title="Population"></th>
                    <th title="Population"><img src="<?=$this->config->item('style_url')?>skin/icons/growth_positive.gif"></th>
                    <th title="citizens"><img src="<?=$this->config->item('style_url')?>skin/characters/40h/citizen_r.gif" alt="citizens" title="citizens"></th>
                    <th title="Workers at the logging site"><img src="<?=$this->config->item('style_url')?>skin/characters/40h/woodworker_r.gif" alt="Workers at the logging site" title="Workers at the logging site"></th>
                    <th title="Workers for goods"><img src="<?=$this->config->item('style_url')?>skin/characters/40h/luxuryworker_r.gif" alt="Workers for goods" title="Workers for goods"></th>
                    <th title="Scientists"><img src="<?=$this->config->item('style_url')?>skin/characters/40h/scientist_r.gif" alt="Scientists" title="Scientists"></th>
                    <th title="Level of satisfaction with life"><img src="<?=$this->config->item('style_url')?>skin/smilies/happy_x32.gif" alt="Level of satisfaction with life" title="Level of satisfaction with life"></th>
                </tr>
<?$town_id = 0?>
<?foreach($this->Player_Model->towns as $town){?>
                <tr class='<?if (($town_id % 2) == 0){?>normal<?}else{?>alt<?}?>'>
                    <td class="city"><a title="To city overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></td>
                    <td class="citizens text"><?=number_format($this->Player_Model->peoples[$town->id])?> / <?=number_format($this->Player_Model->max_peoples[$town->id])?></td>
                    <td class="citizens text"><?=number_format($this->Player_Model->good[$town->id]/50, 2, '.', '')?></td>
                    <td class="citizens text"><?=number_format($town->peoples)?></td>
<?
    $wood = $this->Data_Model->island_cost(0, $this->Player_Model->islands[$town->island]->wood_level);
    $trade = $this->Data_Model->island_cost(1, $this->Player_Model->islands[$town->island]->trade_level);
?>
                    <td class="worker1 text"><?=number_format($town->workers)?> / <?=number_format($wood['workers'])?></td>
                    <td class="worker2 text"><?=number_format($town->tradegood)?> / <?=number_format($trade['workers'])?></td>
                    <td class="scientists text"><?=number_format($town->scientists)?> / <?=number_format($this->Data_Model->scientists_by_level($this->Player_Model->levels[$town->id][3]))?></td>
                    <td class="satisfaction"><img src="<?=$this->config->item('style_url')?>skin/smilies/<?=$this->Data_Model->good_name_by_count($this->Player_Model->good[$town->id])?>_x25.gif" alt="<?=$this->Data_Model->good_name_by_count($this->Player_Model->good[$town->id])?>" title="<?=$this->Data_Model->good_name_by_count($this->Player_Model->good[$town->id])?>" /></td>
                </tr>
<?$town_id++?>
<?}?>
            </table>
        </div>
        <div class="footer"></div>
    </div>
<?}?>


<?if($param1=='resources'){?>
    <div id="resourceOverview" class="contentBox">
        <h3 class="header"><span class="textLabel">An overview of the empire</span></h3>
        <div class="content">
            <table cellpadding="0" cellspacing="0" class="overview">
                <tr>
                    <th class="image"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_wood.gif" alt="building materials" title="building materials"></th>
                    <th class="text">In stock</th>
                    <th class="text">Level</th>
                    <th class="text">Workers</th>
                    <th class="text">Production</th>
                    <th class="text">Warehouse capacity limit</th>
                    <th class="text"></th>
                    <th class="text"></th>
                </tr>
<?
    $town_id = 0;
    $all_wood = 0;
    $all_wine = 0;
    $all_marble = 0;
    $all_crystal = 0;
    $all_sulfur = 0;
    $all_workers = 0;
    $all_add = 0;
?>
<?foreach($this->Player_Model->towns as $town){?>
<?
    $wood = $this->Data_Model->island_cost(0, $this->Player_Model->islands[$town->island]->wood_level);
    $all_wood = $all_wood + $town->wood;
    $all_workers = $all_workers + $town->workers;
    $all_add = $all_add + $town->workers*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_wood;
?>
                <tr class='<?if (($town_id % 2) == 0){?>normal<?}else{?>alt<?}?>'>
                    <td class="city"><a title="Back to overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></td>
                    <td class=""><?=number_format($town->wood)?></td>
                    <td class="wine">
                        <a title="Link to building materials" href="<?=$this->config->item('base_url')?>game/resource/<?=$town->island?>/"><?=$this->Player_Model->islands[$town->island]->wood_level?></a>
                    </td>
                    <td><?=number_format($town->workers)?>/<?=number_format($wood['workers'])?></td>
                    <td><?=number_format($town->workers*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_wood)?> per hour</td>
                    <td><?if($town->workers>0){?><?=format_time((($this->Player_Model->capacity[$town->id]-$town->wood)/($town->workers*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_wood))*3600)?><?}else{?>-<?}?></td>
                    <td>-</td>
                    <td>-</td>
                </tr>
<?$town_id++?>
<?}?>
                <tr>
                    <td class="total city">Total</td>
                    <td class="total stock"><?=number_format($all_wood)?></td>
                    <td>-</td>
                    <td class="total stock"><?=number_format($all_workers)?></td>
                    <td class="total stock"><?=number_format($all_add)?> per hour</td>
                    <td>-</td>
                    <td class="total stock">-</td>
                    <td>-</td>
                </tr>
                <tr>
                    <th class="image"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_wine.gif" alt="Grape" title="Grape"></th>
                    <th class="text">In stock</th>
                    <th class="text">Level</th>
                    <th class="text">Workers</th>
                    <th class="text">Production</th>
                    <th class="text">Warehouse capacity limit</th>
                    <th class="text">Consumption</th>
                    <th class="text">Time left</th>
                </tr>
<?
    $all_workers = 0;
    $all_add = 0;
    $all_remove = 0;
?>
<?foreach($this->Player_Model->towns as $town){?>
<?
    $trade = $this->Data_Model->island_cost(1, $this->Player_Model->islands[$town->island]->trade_level);
    $all_wine = $all_wine + $town->wine;
    if($this->Player_Model->islands[$town->island]->trade_resource == 1)
    {
        $all_workers = $all_workers + $town->tradegood;
        $all_add = $all_add + $town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_crystal;
    }
    $all_remove = $all_remove + $this->Data_Model->wine_by_tavern_level($this->Player_Model->towns[$town->id]->tavern_wine);
?>
<?if($this->Player_Model->islands[$town->island]->trade_resource == 1){?>
                <tr class='<?if (($town_id % 2) == 0){?>normal<?}else{?>alt<?}?>'>
                    <td class="city"><a title="Back to overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></td>
                    <td class=""><?=number_format($town->wine)?></td>
                    <td class="wine">
                        <a title="Link to grapes" href="<?=$this->config->item('base_url')?>game/tradegood/<?=$town->island?>/"><?=$this->Player_Model->islands[$town->island]->trade_level?></a>
                    </td>
                    <td><?=number_format($town->tradegood)?>/<?=number_format($trade['workers'])?></td>
                    <td><?=number_format($town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_wine)?> per hour</td>
                    <td><?if($town->tradegood>0){?><?=format_time((($this->Player_Model->capacity[$town->id]-$town->wine)/($town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_wine))*3600)?><?}else{?>-<?}?></td>
                    <td><?=$this->Data_Model->wine_by_tavern_level($this->Player_Model->towns[$town->id]->tavern_wine)?> per hour</td>
                    <td><?if($town->wine > 0 and $this->Player_Model->levels[$town->id][8] > 0){?><?=format_time(($town->wine/$this->Data_Model->wine_by_tavern_level($this->Player_Model->levels[$town->id][8]))*3600)?><?}else{?>-<?}?></td>
                </tr>
<?}else{?>
                <tr class='<?if (($town_id % 2) == 0){?>normal<?}else{?>alt<?}?>'>
                    <td class="city"><a title="Back to overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></td>
                    <td class=""><?=number_format($town->wine)?></td>
                    <td class="wine">-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td><?=$this->Data_Model->wine_by_tavern_level($this->Player_Model->levels[$town->id][8])?> per hour</td>
                    <td><?if($this->Data_Model->wine_by_tavern_level($this->Player_Model->levels[$town->id][8]) > 0){?><?=format_time(($town->wine/$this->Data_Model->wine_by_tavern_level($this->Player_Model->levels[$town->id][8]))*3600)?><?}else{?>-<?}?></td>
                </tr>
<?}?>
<?$town_id++?>
<?}?>
                <tr>
                    <td class="total city">Total</td>
                    <td class="total stock"><?=number_format($all_wine)?></td>
                    <td>-</td>
                    <td class="total stock"><?=number_format($all_workers)?></td>
                    <td class="total stock"><?=number_format($all_add)?> per hour</td>
                    <td>-</td>
                    <td class="total stock"><?=number_format($all_remove)?> per hour</td>
                    <td>-</td>
                </tr>
                <tr>
                    <th class="image"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_marble.gif" alt="Marble" title="Marble"></th>
                    <th class="text">In stock</th>
                    <th class="text">Level</th>
                    <th class="text">Workers</th>
                    <th class="text">Production</th>
                    <th class="text">Warehouse capacity limit</th>
                    <th class="text"></th>
                    <th class="text"></th>
                </tr>
<?
    $all_workers = 0;
    $all_add = 0;
?>
<?foreach($this->Player_Model->towns as $town){?>
<?
    $trade = $this->Data_Model->island_cost(1, $this->Player_Model->islands[$town->island]->trade_level);
    $all_marble = $all_marble + $town->marble;
    if($this->Player_Model->islands[$town->island]->trade_resource == 2)
    {
        $all_workers = $all_workers + $town->tradegood;
        $all_add = $all_add + $town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_crystal;
    }
?>
<?if($this->Player_Model->islands[$town->island]->trade_resource == 2){?>
                <tr class='<?if (($town_id % 2) == 0){?>normal<?}else{?>alt<?}?>'>
                    <td class="city"><a title="Back to overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></td>
                    <td class=""><?=number_format($town->marble)?></td>
                    <td class="marble">
                        <a title="Link to grapes" href="<?=$this->config->item('base_url')?>game/tradegood/<?=$town->island?>/"><?=$this->Player_Model->islands[$town->island]->trade_level?></a>
                    </td>
                    <td><?=number_format($town->tradegood)?>/<?=number_format($trade['workers'])?></td>
                    <td><?=number_format($town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_marble)?> per hour</td>
                    <td><?if($town->tradegood>0){?><?=format_time((($this->Player_Model->capacity[$town->id]-$town->marble)/($town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_marble))*3600)?><?}else{?>-<?}?></td>
                    <td>-</td>
                    <td>-</td>
                </tr>
<?}else{?>
                <tr class='<?if (($town_id % 2) == 0){?>normal<?}else{?>alt<?}?>'>
                    <td class="city"><a title="Back to overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></td>
                    <td class=""><?=number_format($town->marble)?></td>
                    <td class="marble">-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
<?}?>
<?$town_id++?>
<?}?>
                <tr>
                    <td class="total city">Total</td>
                    <td class="total stock"><?=number_format($all_marble)?></td>
                    <td>-</td>
                    <td class="total stock"><?=number_format($all_workers)?></td>
                    <td class="total stock"><?=number_format($all_add)?> per hour</td>
                    <td>-</td>
                    <td class="total stock">-</td>
                    <td>-</td>
                </tr>
                <tr>
                    <th class="image"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_glass.gif" alt="Crystal" title="Crystal"></th>
                    <th class="text">In stock</th>
                    <th class="text">Level</th>
                    <th class="text">Workers</th>
                    <th class="text">Production</th>
                    <th class="text">Warehouse capacity limit</th>
                    <th class="text"></th>
                    <th class="text"></th>
                </tr>
<?
    $all_workers = 0;
    $all_add = 0;
?>
<?foreach($this->Player_Model->towns as $town){?>
<?
    $trade = $this->Data_Model->island_cost(1, $this->Player_Model->islands[$town->island]->trade_level);
    $all_crystal = $all_crystal + $town->crystal;
    if($this->Player_Model->islands[$town->island]->trade_resource == 3)
    {
        $all_workers = $all_workers + $town->tradegood;
        $all_add = $all_add + $town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_crystal;
    }
?>
<?if($this->Player_Model->islands[$town->island]->trade_resource == 3){?>
                <tr class='<?if (($town_id % 2) == 0){?>normal<?}else{?>alt<?}?>'>
                    <td class="city"><a title="Back to overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></td>
                    <td class=""><?=number_format($town->crystal)?></td>
                    <td class="crystal">
                        <a title="Link to grapes" href="<?=$this->config->item('base_url')?>game/tradegood/<?=$town->island?>/"><?=$this->Player_Model->islands[$town->island]->trade_level?></a>
                    </td>
                    <td><?=number_format($town->tradegood)?>/<?=number_format($trade['workers'])?></td>
                    <td><?=number_format($town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_crystal)?> per hour</td>
                    <td><?if($town->tradegood>0){?><?=format_time((($this->Player_Model->capacity[$town->id]-$town->crystal)/($town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_crystal))*3600)?><?}else{?>-<?}?></td>
                    <td>-</td>
                    <td>-</td>
                </tr>
<?}else{?>
                <tr class='<?if (($town_id % 2) == 0){?>normal<?}else{?>alt<?}?>'>
                    <td class="city"><a title="Back to overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></td>
                    <td class=""><?=number_format($town->crystal)?></td>
                    <td class="crystal">-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
<?}?>
<?$town_id++?>
<?}?>
                <tr>
                    <td class="total city">Total</td>
                    <td class="total stock"><?=number_format($all_crystal)?></td>
                    <td>-</td>
                    <td class="total stock"><?=number_format($all_workers)?></td>
                    <td class="total stock"><?=number_format($all_add)?> per hour</td>
                    <td>-</td>
                    <td class="total stock">-</td>
                    <td>-</td>
                </tr>
                <tr>
                    <th class="image"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_sulfur.gif" alt="Sulfur" title="Sulfur"></th>
                    <th class="text">In stock</th>
                    <th class="text">Level</th>
                    <th class="text">Workers</th>
                    <th class="text">Production</th>
                    <th class="text">Warehouse capacity limit</th>
                    <th class="text"></th>
                    <th class="text"></th>
                </tr>
<?
    $all_workers = 0;
    $all_add = 0;
?>
<?foreach($this->Player_Model->towns as $town){?>
<?
    $trade = $this->Data_Model->island_cost(1, $this->Player_Model->islands[$town->island]->trade_level);
    $all_sulfur = $all_sulfur + $town->sulfur;
    if($this->Player_Model->islands[$town->island]->trade_resource == 4)
    {
        $all_workers = $all_workers + $town->tradegood;
        $all_add = $all_add + $town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_sulfur;
    }
?>
<?if($this->Player_Model->islands[$town->island]->trade_resource == 4){?>
                <tr class='<?if (($town_id % 2) == 0){?>normal<?}else{?>alt<?}?>'>
                    <td class="city"><a title="Back to overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></td>
                    <td class=""><?=number_format($town->sulfur)?></td>
                    <td class="sulfur">
                        <a title="Link to grapes" href="<?=$this->config->item('base_url')?>game/tradegood/<?=$town->island?>/"><?=$this->Player_Model->islands[$town->island]->trade_level?></a>
                    </td>
                    <td><?=number_format($town->tradegood)?>/<?=number_format($trade['workers'])?></td>
                    <td><?=number_format($town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_sulfur)?> per hour</td>
                    <td><?if($town->tradegood>0){?><?=format_time((($this->Player_Model->capacity[$town->id]-$town->sulfur)/($town->tradegood*(1-$this->Player_Model->corruption[$town->id])*$this->Player_Model->plus_sulfur))*3600)?><?}else{?>-<?}?></td>
                    <td>-</td>
                    <td>-</td>
                </tr>
<?}else{?>
                <tr class='<?if (($town_id % 2) == 0){?>normal<?}else{?>alt<?}?>'>
                    <td class="city"><a title="Back to overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></td>
                    <td class=""><?=number_format($town->sulfur)?></td>
                    <td class="sulfur">-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
<?}?>
<?$town_id++?>
<?}?>
                <tr>
                    <td class="total city">Total</td>
                    <td class="total stock"><?=number_format($all_sulfur)?></td>
                    <td>-</td>
                    <td class="total stock"><?=number_format($all_workers)?></td>
                    <td class="total stock"><?=number_format($all_add)?> per hour</td>
                    <td>-</td>
                    <td class="total stock">-</td>
                    <td>-</td>
                </tr>
            </table>
        </div>
        <div class="footer"></div>
    </div>
<?}?>

<?if($param1=='buildings'){?>
    <div id="buildingsOverview" class="contentBox">
        <h3 class="header"><span class="textLabel">An overview of the empire</span></h3>
        <div class="content">
            <table cellpadding="0" cellspacing="0">
                <tr class="headingrow">
                    <th class="city" title="City"><img src="<?=$this->config->item('style_url')?>skin/layout/city.gif" alt="City" title="City"></th>
                    <th class="building" title="Town Hall"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_townHall.gif" alt="Town Hall" title="Town Hall"></th>
                    <th class="building" title="Academy"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_academy.gif" alt="Academy" title="Academy"></th>
                    <th class="building" title="Composition"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_warehouse.gif" alt="Composition" title="Composition"></th>
                    <th class="building" title="Tavern"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_tavern.gif" alt="Tavern" title="Tavern"></th>
                    <th class="building" title="The palace"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_palace.gif" alt="The palace" title="The palace"></th>
                </tr>
<?$town_id = 0?>
<?foreach($this->Player_Model->towns as $town){?>
                <tr<?if (($town_id % 2) != 0){?> class="alt"<?}?>>
                    <th class="city"><a title="To city overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></th>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][1]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/townHall/" title="To City Hall"><?=$this->Player_Model->levels[$town->id][1]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][3]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/academy/" title="To the Academy"><?=$this->Player_Model->levels[$town->id][3]?></a><?}else{?>-<?}?></td>
                    <td class="building">
                        <?if($this->Player_Model->warehouses[$town->id] > 0){?>
                        <?for($i = 3; $i <= 13; $i++){?>
                        <?$type_text = 'pos'.$i.'_type'?>
                        <?$level_text = 'pos'.$i.'_level'?>
                        <?if($town->$type_text == 6){?>
                        <a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/warehouse/<?=$i?>/" title="K Warehouse"><?=$town->$level_text?></a>&nbsp;&nbsp;
                        <?}}?>
                        <?}else{?>-<?}?>
                    </td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][8]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/tavern/" title="K Tavern"><?=$this->Player_Model->levels[$town->id][8]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][10]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/palace/" title="K Palace"><?=$this->Player_Model->levels[$town->id][10]?></a><?}else{?>-<?}?></td>
                </tr>
<?$town_id++?>
<?}?>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr class="headingrow">
                    <th class="city" title="City">&nbsp;</th>
                    <th class="building" title="Governor's Residence"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_palaceColony.gif" alt="Governor's Residence" title="Governor's Residence"></th>
                    <th class="building" title="Trade port"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_port.gif" alt="Trade port" title="Trade port"></th>
                    <th class="building" title="Shipyard"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_shipyard.gif" alt="Shipyard" title="Shipyard"></th>
                    <th class="building" title="Barracks"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_barracks.gif" alt="Barracks" title="Barracks"></th>
                    <th class="building" title="city wall"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_wall.gif" alt="city wall" title="city wall"></th>
                </tr>
<?foreach($this->Player_Model->towns as $town){?>
                <tr<?if (($town_id % 2) != 0){?> class="alt"<?}?>>
                    <th class="city"><a title="To city overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></th>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][15]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/palaceColony/" title="K Governor's Residence"><?=$this->Player_Model->levels[$town->id][15]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][2]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/port/" title="K Trading port"><?=$this->Player_Model->levels[$town->id][2]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][4]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/shipyard/" title="K Shipyard"><?=$this->Player_Model->levels[$town->id][4]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][5]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/barracks/" title="To Barracks"><?=$this->Player_Model->levels[$town->id][5]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][7]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/wall/" title="K City wall"><?=$this->Player_Model->levels[$town->id][7]?></a><?}else{?>-<?}?></td>
                </tr>
<?$town_id++?>
<?}?>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr class="headingrow"><th class="city" title="City">&nbsp;</th>
                    <th class="building" title="Embassy"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_embassy.gif" alt="Embassy" title="Embassy"></th>
                    <th class="building" title="Market"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_branchOffice.gif" alt="Market" title="Market"></th>
                    <th class="building" title="Workshop"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_workshop.gif" alt="Workshop" title="Workshop"></th>
                    <th class="building" title="Shelter"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_safehouse.gif" alt="Shelter" title="Shelter"></th>
                    <th class="building" title="Forester's Hut"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_forester.gif" alt="Forester's Hut" title="Forester's Hut"></th>
                </tr>
<?foreach($this->Player_Model->towns as $town){?>
                <tr<?if (($town_id % 2) != 0){?> class="alt"<?}?>>
                    <th class="city"><a title="To city overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></th>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][11]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/embassy/" title="K Embassy"><?=$this->Player_Model->levels[$town->id][11]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][12]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/branchOffice/" title="K Market"><?=$this->Player_Model->levels[$town->id][12]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][13]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/workshop/" title="K workshop"><?=$this->Player_Model->levels[$town->id][13]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][14]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/safehouse/" title="To Shelter"><?=$this->Player_Model->levels[$town->id][14]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][16]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/forester/" title="To the Forester's Hut"><?=$this->Player_Model->levels[$town->id][16]?></a><?}else{?>-<?}?></td>
                </tr>
<?$town_id++?>
<?}?>
            </table>
            <table cellpadding="0" cellspacing="0"><tr class="headingrow">
                    <th class="city" title="City">&nbsp;</th>
                    <th class="building" title="Glass Blowing Workshop"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_glassblowing.gif" alt="Glass Blowing Workshop" title="Glass Blowing Workshop"></th>
                    <th class="building" title="Tower of the Alchemist"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_alchemist.gif" alt="Tower of the Alchemist" title="Tower of the Alchemist"></th>
                    <th class="building" title="winery"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_winegrower.gif" alt="winery" title="winery"></th>
                    <th class="building" title="Quarry"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_stonemason.gif" alt="Quarry" title="Quarry"></th>
                    <th class="building" title="carpentry workshop"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_carpentering.gif" alt="carpentry workshop" title="carpentry workshop"></th>
                </tr>
<?foreach($this->Player_Model->towns as $town){?>
                <tr<?if (($town_id % 2) != 0){?> class="alt"<?}?>>
                    <th class="city"><a title="To city overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></th>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][18]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/glassblowing/" title="K Glassblowing Workshop"><?=$this->Player_Model->levels[$town->id][18]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][20]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/alchemist/" title="To the Alchemist's Tower"><?=$this->Player_Model->levels[$town->id][20]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][19]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/winegrower/" title="K Winery"><?=$this->Player_Model->levels[$town->id][19]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][17]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/stonemason/" title="K Quarry"><?=$this->Player_Model->levels[$town->id][17]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][21]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/carpentering/" title="K Carpentry workshop"><?=$this->Player_Model->levels[$town->id][21]?></a><?}else{?>-<?}?></td>
                </tr>
<?$town_id++?>
<?}?>
            </table>
            <table cellpadding="0" cellspacing="0"><tr class="headingrow">
                    <th class="city" title="City">&nbsp;</th>
                    <th class="building" title="Museum"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_museum.gif" alt="Museum" title="Museum"></th>
                    <th class="building" title="Architect's Bureau"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_architect.gif" alt="Architect's Bureau" title="Architect's Bureau"></th>
                    <th class="building" title="Optics"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_optician.gif" alt="Optics" title="Optics"></th>
                    <th class="building" title="Wine Vault"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_vineyard.gif" alt="Wine Vault" title="Wine Vault"></th>
                    <th class="building" title="Polygon Pyrotechnics"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_fireworker.gif" alt="Polygon Pyrotechnics" title="Polygon Pyrotechnics"></th>
                </tr>
<?foreach($this->Player_Model->towns as $town){?>
                <tr<?if (($town_id % 2) != 0){?> class="alt"<?}?>>
                    <th class="city"><a title="To city overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></th>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][9]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/museum/" title="K Museum"><?=$this->Player_Model->levels[$town->id][9]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][22]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/architect/" title="To the Architect's Bureau"><?=$this->Player_Model->levels[$town->id][22]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][23]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/optician/" title="K Optics"><?=$this->Player_Model->levels[$town->id][23]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][24]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/vineyard/" title="To wine cellar"><?=$this->Player_Model->levels[$town->id][24]?></a><?}else{?>-<?}?></td>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][25]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/fireworker/" title="K Polygon Pyrotechnics"><?=$this->Player_Model->levels[$town->id][25]?></a><?}else{?>-<?}?></td>
                </tr>
<?$town_id++?>
<?}?>
            </table>

            <table cellpadding="0" cellspacing="0">
                <tr class="headingrow">
                    <th class="city" title="City">&nbsp;</th>
                    <th class="building" title="The temple"><img src="<?=$this->config->item('style_url')?>skin/buildings/y50/y50_temple.gif" alt="The temple" title="The temple"></th>
                    <th class="city">&nbsp;</th>
                    <th class="city">&nbsp;</th>
                    <th class="city">&nbsp;</th<th class="city">&nbsp;</th>
                    <th class="city">&nbsp;</th>
                </tr>
<?foreach($this->Player_Model->towns as $town){?>
                <tr<?if (($town_id % 2) != 0){?> class="alt"<?}?>>
                    <th class="city"><a title="To city overview<?=$town->name?>" href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/"><?=$town->name?></a></th>
                    <td class="building"><?if($this->Player_Model->levels[$town->id][26]>0){?><a href="<?=$this->config->item('base_url')?>game/city/<?=$town->id?>/temple/" title="To Temple"><?=$this->Player_Model->levels[$town->id][26]?></a><?}else{?>-<?}?></td>
                    <td class="building">&nbsp;</td>
                    <td class="building">&nbsp;</td>
                    <td class="building">&nbsp;</td>
                    <td class="building">&nbsp;</td>
                </tr>
<?$town_id++?>
<?}?>
            </table>
        </div>
        <div class="footer"></div>
    </div>
<?}?>
</div>