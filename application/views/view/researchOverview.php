<div id="mainview">
    <div class="buildingDescription">
        <h1>Previous scientific achievements</h1>
        <p>All your previous scientific achievements are placed in the library archive. If necessary, each visitor will be able to get acquainted with them.</p>
    </div>

    <div class="contentBox01h">
        <h3 class="header"><span class="textLabel">Previously explored achievements</span></h3>
        <div class="content">
            <h4>Seafaring</h4>
            <ul>
<?for($i = 1; $i <= 14; $i++){?>
<?$research = $this->Data_Model->get_research(1, $i, $this->Player_Model->research)?>
<?$res_text = 'res1_'.$i?>
                <li class="<?if($this->Player_Model->research->$res_text == 0){?>un<?}?>explored">
                    <a href="<?=$this->config->item('base_url')?>game/researchDetail/1/<?=$i?>/" title="<?=$research['name']?>"><?=$research['name']?></a>
                </li>
<?}?>
            </ul>
            <br><hr>
            <h4>Economics</h4>
            <ul>
<?for($i = 1; $i <= 15; $i++){?>
<?$research = $this->Data_Model->get_research(2, $i, $this->Player_Model->research)?>
<?$res_text = 'res2_'.$i?>
                <li class="<?if($this->Player_Model->research->$res_text == 0){?>un<?}?>explored">
                    <a href="<?=$this->config->item('base_url')?>game/researchDetail/2/<?=$i?>/" title="<?=$research['name']?>"><?=$research['name']?></a>
                </li>
<?}?>
            </ul>
            <br><hr>
            <h4>Science</h4>
            <ul>
<?for($i = 1; $i <= 16; $i++){?>
<?$research = $this->Data_Model->get_research(3, $i, $this->Player_Model->research)?>
<?$res_text = 'res3_'.$i?>
                <li class="<?if($this->Player_Model->research->$res_text == 0){?>un<?}?>explored">
                    <a href="<?=$this->config->item('base_url')?>game/researchDetail/3/<?=$i?>/" title="<?=$research['name']?>"><?=$research['name']?></a>
                </li>
<?}?>
            </ul>
            <br><hr>
            <h4>Militarism</h4>
            <ul>
<?for($i = 1; $i <= 14; $i++){?>
<?$research = $this->Data_Model->get_research(4, $i, $this->Player_Model->research)?>
<?$res_text = 'res4_'.$i?>
                <li class="<?if($this->Player_Model->research->$res_text == 0){?>un<?}?>explored">
                    <a href="<?=$this->config->item('base_url')?>game/researchDetail/4/<?=$i?>/" title="<?=$research['name']?>"><?=$research['name']?></a>
                </li>
<?}?>
            </ul>
						
        </div>
        <div class="footer"></div>
    </div>
</div>