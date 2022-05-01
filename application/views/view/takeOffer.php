<?
    $this->Data_Model->Load_Town($param1);
    $town = $this->Data_Model->temp_towns_db[$param1];
    $this->Data_Model->Load_User($town->user);
    $this->Data_Model->Load_Island($town->island);
    $user = $this->Data_Model->temp_users_db[$town->user];
    $island = $this->Data_Model->temp_islands_db[$town->island];
    $type = $param2;
    $cost = $this->Data_Model->army_cost_by_type(23, $this->Player_Model->research, $this->Player_Model->levels[$this->Player_Model->town_id]);
    $time = $this->Data_Model->time_by_coords($this->Player_Model->now_island->x,$island->x,$this->Player_Model->now_island->y,$island->y,$cost['speed']);
?>

<div id="mainview">
	<?if($type == 0){?><h1>Accept a bet</h1><?}else{?><h1>To accept the offer</h1><?}?>
	<?if($type == 1){?>
        <p>Choose here which products you want to buy from<?=$user->login?>. Also enter how much gold you are willing to pay for them.</p>
	<?}else{?>
        <p>You can send your ships to<strong>sales</strong> goods to the city<?=$town->name?>. The trade deal will take place at the moment when your ships reach the goal. Keep in mind that<strong>who first brought the goods - he was the first to sell</strong>. Therefore, you can install<strong>minimum cost</strong> for his product, if the buyer reduces the price of it during this time.</p>
        <?}?>
        <form action="<?=$this->config->item('base_url')?>actions/trade/<?=$town->id?>/<?=$type?>/" method="post">
	<div class="contentBox">
            <h3 class="header"><?if($type == 1){?>Buy<?}else{?>Sell<?}?> products<?if($type == 1){?>from<?}else{?>in<?}?> <?=$town->name?></h3>
            <div class="content">
                <table cellpadding="0" cellspacing="0" border="0" class="table">
                    <thead>
                        <tr>
                            <th class="icon">Resource</th>
                            <th class="amount">Quantity</th>
                            <th class="costs">Price</th>
                            <th class="priceTolerance"><?if($type==0){?>Min. price<?}else{?>Max. price<?}?></th>
                            <th class="input">Buy</th>
                        </tr>
                    </thead>
                    <tbody>
<?if($town->branch_trade_wood_type == $type and $town->branch_trade_wood_count > 0){?>
                        <tr>
                            <td class="icon"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_wood.gif" alt="building materials" title="building materials"></td>
                            <td class="amount"><?=$town->branch_trade_wood_count?></td>
                            <td class="costs"><?=$town->branch_trade_wood_cost?> <img src="<?=$this->config->item('style_url')?>skin/resources/icon_gold.gif" alt="Gold"> for ed.</td>
                            <td class="priceTolerance">
                                <div class="increaseInput">
                                    <input id="price_resource" type="text" size="2" name="resourcePrice" value="<?=$town->branch_trade_wood_cost?>">
                                    <a class="increase" href="#more" id="increaseresource" title="offer more"><span class="textLabel">more</span></a>
                                    <a class="decrease" href="#less" id="decreaseresource"  title="offer less" ><span class="textLabel">smaller</span></a>
                                </div>
                            </td>
                            <td class="input"><input type="text" size="6" name="cargo_resource" id="textfield_resource" value="0"> <a id="resourceMax" href="#setmax" title="Buy the maximum possible" >max.</a></td>
                        </tr>
<?}?>
<?if($town->branch_trade_wine_type == $type and $town->branch_trade_wine_count > 0){?>
                        <tr>
                            <td class="icon"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_wine.gif" alt="Grape" title="Grape"></td>
                            <td class="amount"><?=$town->branch_trade_wine_count?></td>
                            <td class="costs"><?=$town->branch_trade_wine_cost?> <img src="<?=$this->config->item('style_url')?>skin/resources/icon_gold.gif" alt="Gold"> for ed.</td>
                            <td class="priceTolerance">
                                <div class="increaseInput">
                                    <input id="price_tradegood1" type="text" size="2" name="tradegood1Price" value="<?=$town->branch_trade_wine_cost?>">
                                    <a class="increase" href="#more" id="increasetradegood1" title="offer more"><span class="textLabel">more</span></a>
                                    <a class="decrease" href="#less" id="decreasetradegood1"  title="offer less" ><span class="textLabel">smaller</span></a>
                                </div>
                            </td>
                            <td class="input"><input type="text" size="6" name="cargo_tradegood1" id="textfield_tradegood1" value="0"> <a id="tradegood1Max" href="#setmax" title="Buy the maximum possible" >max.</a></td>
                        </tr>
<?}?>
<?if($town->branch_trade_marble_type == $type and $town->branch_trade_marble_count > 0){?>
                        <tr>
                            <td class="icon"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_marble.gif" alt="Marble" title="Marble"></td>
                            <td class="amount"><?=$town->branch_trade_marble_count?></td>
                            <td class="costs"><?=$town->branch_trade_marble_cost?> <img src="<?=$this->config->item('style_url')?>skin/resources/icon_gold.gif" alt="Gold"> for ed.</td>
                            <td class="priceTolerance">
                                <div class="increaseInput">
                                    <input id="price_tradegood2" type="text" size="2" name="tradegood2Price" value="<?=$town->branch_trade_marble_cost?>">
                                    <a class="increase" href="#more" id="increasetradegood2" title="offer more"><span class="textLabel">more</span></a>
                                    <a class="decrease" href="#less" id="decreasetradegood2"  title="offer less" ><span class="textLabel">smaller</span></a>
                                </div>
                            </td>
                            <td class="input"><input type="text" size="6" name="cargo_tradegood2" id="textfield_tradegood2" value="0"> <a id="tradegood2Max" href="#setmax" title="Buy the maximum possible" >max.</a></td>
                        </tr>
<?}?>
<?if($town->branch_trade_crystal_type == $type and $town->branch_trade_crystal_count > 0){?>
                        <tr>
                            <td class="icon"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_glass.gif" alt="Crystal" title="Crystal"></td>
                            <td class="amount"><?=$town->branch_trade_crystal_count?></td>
                            <td class="costs"><?=$town->branch_trade_crystal_cost?> <img src="<?=$this->config->item('style_url')?>skin/resources/icon_gold.gif" alt="Gold"> for ed.</td>
                            <td class="priceTolerance">
                                <div class="increaseInput">
                                    <input id="price_tradegood3" type="text" size="2" name="tradegood3Price" value="<?=$town->branch_trade_crystal_cost?>">
                                    <a class="increase" href="#more" id="increasetradegood3" title="offer more"><span class="textLabel">more</span></a>
                                    <a class="decrease" href="#less" id="decreasetradegood3"  title="offer less" ><span class="textLabel">smaller</span></a>
                                </div>
                            </td>
                            <td class="input"><input type="text" size="6" name="cargo_tradegood3" id="textfield_tradegood3" value="0"> <a id="tradegood3Max" href="#setmax" title="Buy the maximum possible" >max.</a></td>
                        </tr>
<?}?>
<?if($town->branch_trade_sulfur_type == $type and $town->branch_trade_sulfur_count > 0){?>
                        <tr>
                            <td class="icon"><img src="<?=$this->config->item('style_url')?>skin/resources/icon_sulfur.gif" alt="Sulfur" title="Sulfur"></td>
                            <td class="amount"><?=$town->branch_trade_sulfur_count?></td>
                            <td class="costs"><?=$town->branch_trade_sulfur_cost?> <img src="<?=$this->config->item('style_url')?>skin/resources/icon_gold.gif" alt="Gold"> for ed.</td>
                            <td class="priceTolerance">
                                <div class="increaseInput">
                                    <input id="price_tradegood4" type="text" size="2" name="tradegood4Price" value="<?=$town->branch_trade_sulfur_cost?>">
                                    <a class="increase" href="#more" id="increasetradegood4" title="offer more"><span class="textLabel">more</span></a>
                                    <a class="decrease" href="#less" id="decreasetradegood4"  title="offer less" ><span class="textLabel">smaller</span></a>
                                </div>
                            </td>
                            <td class="input"><input type="text" size="6" name="cargo_tradegood4" id="textfield_tradegood4" value="0"> <a id="tradegood4Max" href="#setmax" title="Buy the maximum possible" >max.</a></td>
                        </tr>
<?}?>
                    </tbody>
                </table>

                <hr>

                <div id="missionSummary">
                    <div class="costs">
                        <div class="estMissionCosts"><span class="textLabel"><?if($type==0){?>Possible income<?}else{?>Estimated total cost<?}?>: </span><span id="goldSaldo">0</span></div>
                    </div>
                    <div class="common">
                        <div class="journeyTarget"><span class="textLabel">Target</span><?=$town->name?></div>
                        <div class="journeyTime"><span class="textLabel">Travel time</span><?=format_time($time)?></div>
                    </div>
                    <div class="transporters">
                        <span class="textLabel">merchant ships:</span>
                        <span><input id="transporterCount" name="transporters" size="3" maxlength="3" readonly="readonly" value="0"> / <?=$this->Player_Model->user->transports?></span>
                    </div>
                    <div class="centerButton">
                        <input class="button" type="submit" value="<?if($type==0){?>Sell goods!<?}else{?>Buy goods!<?}?>">
                    </div>
                </div>
            </div>
            <div class="footer"></div>
        </div>
        </form>

</div>

<script type="text/javascript">
var transporterCount = new transportController({
	'availableTransporters' : <?=$this->Player_Model->user->transports?>,
	'capacityPerTransport' : <?=$this->config->item('transport_capacity')?>,
	'spaceReserved' : 0
});
transporterCount.subscribe('usedTransChanged', function(v) {
	Dom.get('transporterCount').value=v;
});
//TODO: Add another input element that does smooth increasing when mouse button held
valueInput.prototype.increase = function() {
	this.setValue(this.value+1);
	}
valueInput.prototype.decrease = function() {
	this.setValue(this.value-1);
	}
function inputPairMultiplier() {
	this.total = 0;
	this.inputs = [];
	this.createEvent("change");

	this.registerInputs = function(a, b) {
		this.inputs.push([a, b]);
		a.subscribe('change', function(v) {
			this.multiply();
		}, this, this);
		b.subscribe('change', function(v) {
			this.multiply();
		}, this, this);
		this.multiply();
	};
	this.multiply = function() {
		this.total = 0;
		for(var i=this.inputs.length-1;i>=0;i--) {
			this.total+=this.inputs[i][0].value*this.inputs[i][1].value;
		}
		this.fireEvent("change", this.total);
	};
}
YAHOO.augment(inputPairMultiplier, YAHOO.util.EventProvider);
var iPMultiplier = new inputPairMultiplier();
<?if($town->branch_trade_wood_type == $type and $town->branch_trade_wood_count > 0){?>
<?$count = $this->Player_Model->user->gold / $town->branch_trade_wood_cost?>
<?if($count > $town->branch_trade_wood_count){$count = $town->branch_trade_wood_count;}else{$count = floor($count);}?>
var iresource = new valueInput('textfield_resource', [0, <?=$town->branch_trade_wood_count?>]);
transporterCount.registerInput(iresource);
Event.on('resourceMax', 'click', function(e) {
	iresource.setValue(<?=$count?>);
	Event.preventDefault(e);
});
var presource = new valueInput('price_resource', [0, 100]);
Event.on('increaseresource', 'click', function(e) {
	presource.increase();
	Event.preventDefault(e);
});
Event.on('decreaseresource', 'click', function(e) {
	presource.decrease();
	Event.preventDefault(e);
});
iPMultiplier.registerInputs(iresource, presource);
var goldSaldoEl = Dom.get('goldSaldo');
iPMultiplier.subscribe('change', function(total) {
	goldSaldoEl.innerHTML=total;
});
<?}?>
<?if($town->branch_trade_wine_type == $type and $town->branch_trade_wine_count > 0){?>
<?$count = $this->Player_Model->user->gold / $town->branch_trade_wine_cost?>
<?if($count > $town->branch_trade_wine_count){$count = $town->branch_trade_wine_count;}else{$count = floor($count);}?>
var itradegood1 = new valueInput('textfield_tradegood1', [0, <?=$town->branch_trade_wine_count?>]);
transporterCount.registerInput(itradegood1);
Event.on('tradegood1Max', 'click', function(e) {
	itradegood1.setValue(<?=$count?>);
	Event.preventDefault(e);
});
var ptradegood1 = new valueInput('price_tradegood1', [0, 100]);
Event.on('increasetradegood1', 'click', function(e) {
	ptradegood1.increase();
	Event.preventDefault(e);
});
Event.on('decreasetradegood1', 'click', function(e) {
	ptradegood1.decrease();
	Event.preventDefault(e);
});
iPMultiplier.registerInputs(itradegood1, ptradegood1);
var goldSaldoEl = Dom.get('goldSaldo');
iPMultiplier.subscribe('change', function(total) {
	goldSaldoEl.innerHTML=total;
});
<?}?>
<?if($town->branch_trade_marble_type == $type and $town->branch_trade_marble_count > 0){?>
<?$count = $this->Player_Model->user->gold / $town->branch_trade_marble_cost?>
<?if($count > $town->branch_trade_marble_count){$count = $town->branch_trade_marble_count;}else{$count = floor($count);}?>
var itradegood2 = new valueInput('textfield_tradegood2', [0, <?=$town->branch_trade_marble_count?>]);
transporterCount.registerInput(itradegood2);
Event.on('tradegood2Max', 'click', function(e) {
	itradegood2.setValue(<?=$count?>);
	Event.preventDefault(e);
});
var ptradegood2 = new valueInput('price_tradegood2', [0, 100]);
Event.on('increasetradegood2', 'click', function(e) {
	ptradegood2.increase();
	Event.preventDefault(e);
});
Event.on('decreasetradegood2', 'click', function(e) {
	ptradegood2.decrease();
	Event.preventDefault(e);
});
iPMultiplier.registerInputs(itradegood2, ptradegood2);
var goldSaldoEl = Dom.get('goldSaldo');
iPMultiplier.subscribe('change', function(total) {
	goldSaldoEl.innerHTML=total;
});
<?}?>
<?if($town->branch_trade_crystal_type == $type and $town->branch_trade_crystal_count > 0){?>
<?$count = $this->Player_Model->user->gold / $town->branch_trade_crystal_cost?>
<?if($count > $town->branch_trade_crystal_count){$count = $town->branch_trade_crystal_count;}else{$count = floor($count);}?>
var itradegood3 = new valueInput('textfield_tradegood3', [0, <?=$town->branch_trade_crystal_count?>]);
transporterCount.registerInput(itradegood3);
Event.on('tradegood3Max', 'click', function(e) {
	itradegood3.setValue(<?=$count?>);
	Event.preventDefault(e);
});
var ptradegood3 = new valueInput('price_tradegood3', [0, 100]);
Event.on('increasetradegood3', 'click', function(e) {
	ptradegood3.increase();
	Event.preventDefault(e);
});
Event.on('decreasetradegood3', 'click', function(e) {
	ptradegood3.decrease();
	Event.preventDefault(e);
});
iPMultiplier.registerInputs(itradegood3, ptradegood3);
var goldSaldoEl = Dom.get('goldSaldo');
iPMultiplier.subscribe('change', function(total) {
	goldSaldoEl.innerHTML=total;
});
<?}?>
<?if($town->branch_trade_sulfur_type == $type and $town->branch_trade_sulfur_count > 0){?>
<?$count = $this->Player_Model->user->gold / $town->branch_trade_sulfur_cost?>
<?if($count > $town->branch_trade_sulfur_count){$count = $town->branch_trade_sulfur_count;}else{$count = floor($count);}?>
var itradegood4 = new valueInput('textfield_tradegood4', [0, <?=$town->branch_trade_sulfur_count?>]);
transporterCount.registerInput(itradegood4);
Event.on('tradegood4Max', 'click', function(e) {
	itradegood4.setValue(<?=$count?>);
	Event.preventDefault(e);
});
var ptradegood4 = new valueInput('price_tradegood4', [0, 100]);
Event.on('increasetradegood4', 'click', function(e) {
	ptradegood4.increase();
	Event.preventDefault(e);
});
Event.on('decreasetradegood4', 'click', function(e) {
	ptradegood4.decrease();
	Event.preventDefault(e);
});
iPMultiplier.registerInputs(itradegood4, ptradegood4);
var goldSaldoEl = Dom.get('goldSaldo');
iPMultiplier.subscribe('change', function(total) {
	goldSaldoEl.innerHTML=total;
});
<?}?>
</script>