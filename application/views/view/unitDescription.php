<?
$unit_type = $_GET['unit'] ?? 1;
$unit_name = $this->lang->line('army'.$unit_type.'_name');
$dummy_levels = array_fill(0, 22, 0);
$cost = $this->Data_Model->army_cost_by_type($unit_type, null, $dummy_levels, FALSE);
$tradegoods = array('sulfur', 'wine', 'crystal');
$cost_tradegood = 0;
foreach ($tradegoods as &$tradegood) {
    if ($cost[$tradegood] != 0) {
        $cost_tradegood = $cost[$tradegood];
        $cost_tradegood_name = $tradegood;
    }
}
$cost_research = $cost['required_research'];
if (is_null($cost_research)) {
    $researched = false;
    $research_name = null;
} else {
    [$category, $research_num] = $cost_research;
    $researched = $this->Action_Model->have_researched($category, $research_num);
    $research_language_tag = 'research'. $category . "_" . $research_num . '_name';
    $research_name = $this->lang->line($research_language_tag);
}
?>
<script>
function mouse_over(e) {
    e.target.style.backgroundPositionY = '-36px';
}
function mouse_out(e) {
    e.target.style.backgroundPositionY = '0';
}
document.addEventListener("DOMContentLoaded", (event) => {
for (let unit_button of document.getElementsByClassName("button_landunits")) {
    unit_button.addEventListener("mouseover", mouse_over);
    unit_button.addEventListener("mouseout", mouse_out);
}
});
</script>

<div id="mainview">
  <div class="breadcrump_padding" style="padding: 0; margin: 50px 0px 0px 0px"></div>
  <table class="troops">
          <tbody>
            <tr>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_slinger"
                    class="button_landunits dummy_armybutton slinger"
                    title="Slinger"
                    href="?unit=5"
                  ></aa
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_archer"
                    class="button_landunits dummy_armybutton archer"
                    title="Archer"
                    href="?unit=6"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_marksman"
                    class="button_landunits dummy_armybutton marksman"
                    title="Sulphur Carabineer"
                    href="?unit=7"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_spearman"
                    class="button_landunits dummy_armybutton spearman"
                    title="Spearman"
                    href="?unit=3"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_swordsman"
                    class="button_landunits dummy_armybutton swordsman"
                    title="Swordsman"
                    href="?unit=4"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_phalanx"
                    class="button_landunits dummy_armybutton phalanx"
                    title="Hoplite"
                    href="?unit=1"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_steamgiant"
                    class="button_landunits dummy_armybutton steamgiant"
                    title="Steam Giant"
                    href="?unit=2"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_gyrocopter"
                    class="button_landunits dummy_armybutton gyrocopter"
                    title="Gyrocopter"
                    href="?unit=11"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_bombardier"
                    class="button_landunits dummy_armybutton bombardier"
                    title="Balloon-Bombardier"
                    href="?unit=12"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_ram"
                    class="button_landunits dummy_armybutton ram"
                    title="Battering Ram"
                    href="?unit=8"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_catapult"
                    class="button_landunits dummy_armybutton catapult"
                    title="Catapult"
                    hra="?unit=9"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_mortar"
                    class="button_landunits dummy_armybutton mortar"
                    title="Mortar"
                    href="?unit=10"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_medic"
                    class="button_landunits dummy_armybutton medic"
                    title="Doctor"
                    href="?unit=14"
                  ></a>
                </div>
              </td>
              <td>
                <div class="unit_wrapper">
                  <a
                    id="button_cook"
                    class="button_landunits dummy_armybutton cook"
                    title="Cook"
                    href="?unit=13"
                  ></a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
  <div class="contentBox01h">
    <div class="content">
        <div class="contentBox01h">
        <h3 class="header"><?=$unit_name?></h3>
          <div class="content">
            <div id="unit" class="s<?=$unit_type?>">
              <div id="unitRes">
                <ul class="resources">
                  <li class="wood firstpos" title="Building material">
                  <span class="accesshint">'Building material': </span><?=$cost['wood']?>
                  </li>
<?if ($cost_tradegood != 0) {?>
<li class="<?=$cost_tradegood_name?> thirdpos" title="<?=ucfirst($cost_tradegood_name)?>">
                    <span class="accesshint">'<?=ucfirst($cost_tradegood_name)?>': </span><?=$cost_tradegood?>
                  </li>
<?}?>
                  <li class="citizens fourthpos" title="Citizens">
                  <span class="accesshint">'Citizens': </span><?=$cost['peoples']?>
                  </li>
                  <li class="upkeep eighthpos" title="Upkeep">
                    <span class="accesshint">'Upkeep': </span><?=$cost['gold']?>
                  </li>
                  <li class="weight fifthpos" title="Transport weight">
                    <span class="accesshint">'Transport weight': </span><?=$cost['capacity']?>
                  </li>
                  <li class="building_level sixthpos" title="Level">
                  <span class="accesshint">'Level': </span><?=$cost['required_level']?>
                  </li>
                  <li class="completionTime seventhpos" title="Building time">
                    <span class="accesshint">'Building time': </span><?=format_time($cost['time'])?>
                 </li>
                </ul>
              </div>
            </div>
            <!-- TODO pull this from battle plugin -->
            <div id="infoBox">
              <div class="infoBoxHeader"></div>
              <div class="infoBoxContent">
                <h3>Long-Range Fighter, Human</h3>
                <div class="floatleft width_150">
                  <span class="textLabel">Hit points :</span><b>8</b><br />
                  <span class="textLabel">Armour:</span><b>-</b><br />
                  <span class="textLabel">Speed:</span>
                  60 <br />
                  <span class="textLabel">Size :</span>1<br />
                </div>
                <div class="clearfloat"></div>

                <div class="weapon">
                  <div class="weaponName">Dagger</div>
                  <span class="textLabel">Damage :</span>2<br />
                  <span class="textLabel">Accuracy:</span>
                  <div class="damageFocusContainer">
                    <div class="damageFocus" style="width: 60%"></div>
                  </div>
                </div>
                <div class="weapon">
                  <div class="weaponName">Sling</div>
                  <span class="textLabel">Damage :</span>3<br />
                  <span class="textLabel">Accuracy:</span>
                  <div class="damageFocusContainer">
                    <div class="damageFocus" style="width: 20%"></div>
                  </div>
                  <span class="textLabel">Munition:</span>
                  5
                </div>
                <span class="req">Requirement(s)</span>
                <span class="available">* <a href="/game/buildingDetail/5/">Barracks ( <?=$cost['required_level']?> )</a></span>
<? if (!is_null($cost_research)) { ?>
    <span class="available <?=$researched ? "red" : ''?>">* <a href="/game/researchDetail/<?=$category?>/<?=$research_num?>"><?=$research_name?></a></span>
<? } ?>
              </div>
              <div class="infoBoxFooter"></div>
            </div>
            <div class="shortdesc">
              <h4
                style="font-weight: bold; padding-bottom: 10px; color: #b03937"
              >
                Slinger
              </h4>
              Slings are light and cheap weapons. They cannot inflict much
              damage on well-armed opponents, but at least their munition is
              readily available.
            </div>
            <div>
              <a
                class="ikipedia_prev_btn bold clearfloat"
                href="/game/researchDetail/"
                title="Learn more about Research..."
              >
                Research
              </a>
              <a
                class="ikipedia_next_btn bold"
                href="/game/shipDescription/"
                title="Learn more about Ships..."
              >
                Ships
              </a>
            </div>
            <div class="footer"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer"></div>
  </div>
