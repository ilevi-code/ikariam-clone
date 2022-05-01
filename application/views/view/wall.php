<div id="mainview">
<?include_once('building_description.php')?>
<?$wall_data = $this->Data_Model->wall_data_by_level($this->Player_Model->now_town->pos14_level)?>
    <div class="contentBox01h">
        <h3 class="header">Information</h3>
        <div class="content">
        	<div class="bgWall">
        		<div id="wallInfoBox">
		        	<div class="infoBoxHeader"></div>
		        	<div class="infoBoxContent">
			        	<div class="weapon">
				        	<div class="weaponName">terrain attack</div>
				        	<span class="textLabel">Damage</span><b>12</b>
				        	<span class="textLabel">Accuracy</span>
				        	<div class="damageFocusContainer" title="30%">
				        		<div class="damageFocus" style="width: 30%;"></div>
				        	</div>
			        	</div>
			        	<span class="textLabel">Health</span><b><?=$wall_data['health']?></b><br/>
			        	<span class="textLabel">Armor</span><b><?=$wall_data['reservation']?></b><br/>

			        	<span class="textLabel">Garrison limit</span><b><?=number_format($this->Player_Model->garisson_limit[$this->Player_Model->town_id])?></b><br/>
		        	</div>
		        	<div class="infoBoxFooter"></div>
	        	</div>
	        </div>
	    </div>
        <div class="footer"></div>
    </div>
</div>
