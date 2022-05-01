<div id="mainview">
    <div class="buildingDescription">
        <h1>Research Advisor</h1>
        <p></p>
    </div>
    <div class="contentBox01h" id="currentResearch">
        <h3 class="header"><span class="textLabel">Current research</span></h3>
        <div class="content">
            <ul class="researchTypes">
<?for ($way = 1; $way <= 4; $way++){?>
                <li class="researchType ">
                    <div class="researchInfo" style="width:100px; min-height:120px;">
                        <h4><a href="<?=$this->config->item('base_url')?>game/researchDetail/1/<?=$this->Player_Model->ways[$way]['id']?>/"><?=$this->Player_Model->ways[$way]['name']?></a></h4>
                        <div class="leftBranch">
<?switch($way){?>
<?case 1:?>
<img src="<?=$this->config->item('style_url')?>skin/layout/changeResearchSeafaring.jpg">
<?break;?>
<?case 2:?>
<img src="<?=$this->config->item('style_url')?>skin/layout/changeResearchEconomy.jpg">
<?break;?>
<?case 3:?>
<img src="<?=$this->config->item('style_url')?>skin/layout/changeResearchKnowledge.jpg">
<?break;?>
<?case 4:?>
<img src="<?=$this->config->item('style_url')?>skin/layout/changeResearchMilitary.jpg">
<?break;?>
<?}?>
                            <div class="researchTypeLabel">
                                <div class="unitcount">
                                    <span class="textLabel">
                                        <span class="before"></span>
<?switch($way){?>
<?case 1:?>
Seafaring
<?break;?>
<?case 2:?>
Economics
<?break;?>
<?case 3:?>
Science
<?break;?>
<?case 4:?>
Militarism
<?break;?>
<?}?>
                                        <span class="after"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p><?=$this->Player_Model->ways[$way]['desc']?></p>
<?if ($this->Player_Model->ways[$way]['need_id'] > 0){?>
<?$need = $this->Data_Model->get_research($this->Player_Model->ways[$way]['need_way'],$this->Player_Model->ways[$way]['need_id'],$this->Player_Model->research)?>
                        <div class="researchButton2">
                        At least one of the required studies has not been studied(Next Required: <a href="<?=$this->config->item('base_url')?>game/researchDetail/<?=$this->Player_Model->ways[$way]['need_way']?>/<?=$this->Player_Model->ways[$way]['need_id']?>/"><?=$need['name']?></a>)
                        </div>
<?}else{?>
<?if($this->Player_Model->ways[$way]['points'] > $this->Player_Model->research->points){?>
<?
    $this->db->set('way'.$way.'_checked', 0);
    $this->db->where(array('user' => $this->Player_Model->user->id));
    $this->db->update($this->session->userdata('universe').'_research');
?>
                        <div class="researchButton2">
                        Not enough research credits.
                        </div>
                        <div class="costs">
                            <h5>Price:</h5>
                            <ul class="resources">
                                <li class="researchPoints"><?=number_format($this->Player_Model->ways[$way]['points'])?></li>
                            </ul>
                        </div>
<?}else{?>
<?
    $this->db->set('way'.$way.'_checked', time());
    $this->db->where(array('user' => $this->Player_Model->user->id));
    $this->db->update($this->session->userdata('universe').'_research');
?>
                        <div class="researchButton">
                            <a class="button build" style="padding-left:3px;padding-right:3px;"  href="<?=$this->config->item('base_url')?>actions/doResearch/<?=$way?>/<?=$this->Player_Model->ways[$way]['id']?>/">
                                <span class="textLabel">Research</span>
                            </a>			
                        </div>			
                        <div class="costs">		
                            <h5>Price:</h5>		
                            <ul class="resources">		
                                <li class="researchPoints"><?=number_format($this->Player_Model->ways[$way]['points'])?></li>
                            </ul>			
                        </div>
<?}?>
<?}?>
                    </div>
                </li>
<?}?>
			</ul>
        </div>
		<div class="footer"></div>
	</div>
</div>