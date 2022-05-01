<div id="mainview">
    <div class="buildingDescription">
        <h1>Mayor</h1>
        <p>Greetings! As your city councilor, I will let you know if anything special happens in any of your cities.</p>
    </div>

    <div class="yui-navset">
        <ul class="yui-nav"  >
            <li  ><a
                href="<?=$this->config->item('base_url')?>game/tradeAdvisor/"
                title="City News"><em>City News</em></a></li>
            <li class="selected"><a
                href="<?=$this->config->item('base_url')?>game/tradeAdvisorTradeRoute/"
                title="trade routes"><em>trade routes</em></a></li>
        </ul>
    </div>
    <div class="contentBox01h">
        <h3 class="header">Edit trade routes</h3>
        <div class="content">
            <p>A trade route consists of sending vehicles between two cities in your empire on a regular basis. This way you can, for example, automatically supply your settlements with wine. One trade route is available by default and you can add more with Ambrosia.<br/><br/>Please make sure that there are enough goods and bulk carriers available, and that there are no obstacles on the route, such as enemy fleets.</p>

            <table >
                <tr>
                    <th colspan=3 style="width:446px;">trade route:</th>
                    <th style="text-align:left;width:42px;">Duration:</th>
                    <th style="text-align:left;width:47px;">Price:</th>
                    <th style="width:107px;"></th>
                </tr>
            </table>

<?if(SizeOf($this->Player_Model->trade_routes) > 0){?>
<?foreach($this->Player_Model->trade_routes as $trade){?>
            
            <form action="<?=$this->config->item('base_url')?>actions/tradeRoute/" method="post" id="tradeRouteForm0">
                <input type="hidden" name="renew" value="0" id="renew0">
                <input type="hidden" name="route" value="<?=$trade->id?>">
                <ul class="tradeRoute"  style="z-index:100">
                    <li class="startCity" style="position:relative;z-index:100">
                        <select id="tradeRouteStart<?=$trade->id?>" class="dropdown size175 smallFont" name="city1Id" onchange="this.focus();">
                            <option>Select source city</option>
<?foreach($this->Player_Model->towns as $town){?>
<?$island = $this->Player_Model->islands[$town->island]?>
<?$selected = ($town->id == $trade->from) ? 'selected="selected"' : ''?>
                            <option class="coords" value="<?=$town->id?>" <?=$selected?> title="Trade: <?=$this->Data_Model->resource_name_by_type($island->trade_resource)?>" ><p>[<?=$island->x?>:<?=$island->y?>]&nbsp;<?=$town->name?></p></option>
<?}?>
                        </select>
                    </li>
                    <li class="endCity">
                        <select id="tradeRouteEnd<?=$trade->id?>" class="dropdown size175 smallFont" name="city2Id" >
                            <option>Select destination city</option>
<?foreach($this->Player_Model->towns as $town){?>
<?$island = $this->Player_Model->islands[$town->island]?>
<?$selected = ($town->id == $trade->to) ? 'selected="selected"' : ''?>
                            <option class="coords" value="<?=$town->id?>" <?=$selected?> title="Trade: <?=$this->Data_Model->resource_name_by_type($island->trade_resource)?>" ><p>[<?=$island->x?>:<?=$island->y?>]&nbsp;<?=$town->name?></p></option>
<?}?>
                        </select>
                    </li>
                    <li class="premiumDuration"><?=format_time($this->config->item('trade_route_time'))?></li>
                    <li class="premiumCost">&nbsp; -</li>
                    <li class="renew"></li>
                </ul>
                <ul class="tradeRoute2"  style="z-index:99">
                    <li class="number">
                        <input type="text" name="number"  value="<?=$trade->send_count?>" style="width:50px">
                    </li>
<?  $selected_wood = ($trade->send_resource == 0) ? 'selected' : '';
    $selected_wine = ($trade->send_resource == 1) ? 'selected' : '';
    $selected_marble = ($trade->send_resource == 2) ? 'selected' : '';
    $selected_crystal = ($trade->send_resource == 3) ? 'selected' : '';
    $selected_sulfur = ($trade->send_resource == 4) ? 'selected' : '';?>
                    <li class="tradegood">
                        <select name="tradegood" id="tradegood<?=$trade->id?>" class="dropdown size68 smallFont">
                            <option class="resource" value="0"  title="building materials" <?=$selected_wood?>></option>
                            <option class="tradegood1" value="1"  title="Grape" <?=$selected_wine?>></option>
                            <option class="tradegood2" value="2"  title="Marble" <?=$selected_marble?>></option>
                            <option class="tradegood3" value="3"  title="Crystal" <?=$selected_crystal?>></option>
                            <option class="tradegood4" value="4"  title="Sulfur" <?=$selected_sulfur?>></option>
                        </select>
                    </li>
                    <li class="time">
                        <select name="time" id="time<?=$trade->id?>" class="dropdown size115 smallFont">
<?
for ($i = 0; $i <= 23; $i++)
{
        $selected = ($i == $trade->send_time) ? 'selected' : '';
?>
                            <option value="<?=$i?>" <?=$selected?>>daily at<?=$i?>:00</option>
<?
}
?>
                        </select>
                    </li>
                    <li class="save">
                        <input id="colonizeBtn" name="save" type="submit" value="" title="Save Changes"><br>
                    </li>
                    <li class="status">
                        <span style="font-size:16px;font-weight:bold;color:green;">Left<?=premium_time($this->config->item('trade_route_time')-(time()-$trade->start_time))?></span>
                    </li>
                    <li class="delete">
                        <a  href="<?=$this->config->item('base_url')?>actions/tradeRoute/<?=$trade->id?>/" title="Delete"></a>
                    </li>
                </ul>
            </form>
            <div class="listFooter"></div><br>
<?}?>
<?}?>

<?if(SizeOf($this->Player_Model->trade_routes) == 0 or $param1 == 'new'){?>
            <form action="<?=$this->config->item('base_url')?>actions/tradeRoute/" method="post" id="tradeRouteForm0">
                <input type="hidden" name="renew" value="0" id="renew0">
                <input type="hidden" name="route" value="0">
                <ul class="tradeRoute"  style="z-index:100">
                    <li class="startCity" style="position:relative;z-index:100">
                        <select id="tradeRouteStart0" class="dropdown size175 smallFont" name="city1Id" onchange="this.focus();">
                            <option>Select source city</option>
<?foreach($this->Player_Model->towns as $town){?>
<?$island = $this->Player_Model->islands[$town->island]?>
<?$selected = ($this->Player_Model->town_id == $town->id) ? 'selected="selected"' : ''?>
                            <option class="coords" value="<?=$town->id?>" <?=$selected?> title="Trade: <?=$this->Data_Model->resource_name_by_type($island->trade_resource)?>" ><p>[<?=$island->x?>:<?=$island->y?>]&nbsp;<?=$town->name?></p></option>
<?}?>
                        </select>
                    </li>
                    <li class="endCity">
                        <select id="tradeRouteEnd0" class="dropdown size175 smallFont" name="city2Id" >
                            <option>Select destination city</option>
<?foreach($this->Player_Model->towns as $town){?>
<?$island = $this->Player_Model->islands[$town->island]?>
<?$selected = ''?>
                            <option class="coords" value="<?=$town->id?>" <?=$selected?> title="Trade: <?=$this->Data_Model->resource_name_by_type($island->trade_resource)?>" ><p>[<?=$island->x?>:<?=$island->y?>]&nbsp;<?=$town->name?></p></option>
<?}?>
                        </select>
                    </li>
                    <li class="premiumDuration"><?=format_time($this->config->item('trade_route_time'))?></li>
<?if(SizeOf($this->Player_Model->trade_routes) > 0){?>
                    <li class="premiumCost">10 <img height="20" width="24" alt="Ambrosia" src="<?=$this->config->item('style_url')?>skin/premium/ambrosia_icon.gif"></li>
<?if($this->Player_Model->user->ambrosy >= 10){?>
                    <li class="renew">
                        <a onclick="Dom.get('renew0').value=1;Dom.get('tradeRouteForm0').submit();" id="colonizeBtn" name="renew" style="margin:0px;" class="button">Activate</a><br>
                    </li>
<?}else{?>
                    <li class="renew">
                        <a class="notenough" href="<?=$this->config->item('base_url')?>game/premiumPayment/">Lacks<?=10 - $this->Player_Model->user->ambrosy?> ed. ragweed!<br><span class="buyNow">Buy!</span></a>
                    </li>
<?}?>
<?}else{?>
                    <li class="premiumCost">&nbsp; -</li>
                    <li class="renew">
                        <a onclick="Dom.get('renew0').value=1;Dom.get('tradeRouteForm0').submit();" id="colonizeBtn" name="renew" style="margin:0px;" class="button">Activate</a><br>
                    </li>
<?}?>

                </ul>
                <ul class="tradeRoute2"  style="z-index:99">
                    <li class="number">
                        <input type="text" name="number"  value="0" style="width:50px">
                    </li>
<?
    $selected_wood = '';
    $selected_wine = '';
    $selected_marble = '';
    $selected_crystal = '';
    $selected_sulfur = '';
?>
                    <li class="tradegood">
                        <select name="tradegood" id="tradegood0" class="dropdown size68 smallFont">
                            <option class="resource" value="0"  title="building materials" <?=$selected_wood?>></option>
                            <option class="tradegood1" value="1"  title="Grape" <?=$selected_wine?>></option>
                            <option class="tradegood2" value="2"  title="Marble" <?=$selected_marble?>></option>
                            <option class="tradegood3" value="3"  title="Crystal" <?=$selected_crystal?>></option>
                            <option class="tradegood4" value="4"  title="Sulfur" <?=$selected_sulfur?>></option>
                        </select>
                    </li>
                    <li class="time">
                        <select name="time" id="time0" class="dropdown size115 smallFont">
<?
for ($i = 0; $i <= 23; $i++)
{
    $selected = '';
?>
                            <option value="<?=$i?>" <?=$selected?>>daily at<?=$i?>:00</option>
<?
}
?>
                        </select>
                    </li>
                    <li class="save">
                        <input id="colonizeBtn" name="save" type="submit" value="" title="Save Changes"><br>
                    </li>
                    <li class="status">
                        <span style="font-size:16px;font-weight:bold;color:red;">Not active</span>
                    </li>
                    <li class="delete"></li>
                </ul>
            </form>
            <div class="listFooter"></div><br>
<?}else{?>
            <div class="addRoute">
                <a href="<?=$this->config->item('base_url')?>game/tradeAdvisorTradeRoute/new/" id="colonizeBtn" style="margin:0px;" class="button" >Create a new trade route</a><br>
            </div>
<?}?>
        </table>
        </div>
        <div class="footer"></div>
    </div>
</div>

<script type="text/javascript">
<!--
function testTradeRouteDelete() {
    return confirm('Are you sure you want to delete the active trade route? You will need to set the trade offer to0.');
}

Event.onDOMReady( function() {
<?if(SizeOf($this->Player_Model->trade_routes) > 0){?>
<?foreach($this->Player_Model->trade_routes as $trade){?>
    replaceSelect(Dom.get("tradeRouteStart<?=$trade->id?>"));
    replaceSelect(Dom.get("tradeRouteEnd<?=$trade->id?>"));
    replaceSelect(Dom.get("tradegood<?=$trade->id?>"));
    replaceSelect(Dom.get("time<?=$trade->id?>"));
<?}}?>
<?if(SizeOf($this->Player_Model->trade_routes) == 0 or $param1 == 'new'){?>
    replaceSelect(Dom.get("tradeRouteStart0"));
    replaceSelect(Dom.get("tradeRouteEnd0"));
    replaceSelect(Dom.get("tradegood0"));
    replaceSelect(Dom.get("time0"));
<?}?>
});
//-->
</script>
