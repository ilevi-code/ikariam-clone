<?
        $config['base_url'] = $this->config->item('base_url').'game/tradeAdvisor/';
        $config['total_rows'] = SizeOf($this->Player_Model->towns_messages);
        $config['per_page'] = '10';
        $config['num_links'] = 3;
g       $config['next_link'] = '<img src="'.$this->config->item('style_url').'skin/img/resource/btn_max.png" title="Next">';
        $config['last_link'] = '<img src="'.$this->config->item('style_url').'skin/img/resource/btn_max.png" title="Last">';
        $config['prev_link'] = '<img src="'.$this->config->item('style_url').'skin/img/resource/btn_min.png" title="Previous">';
        $config['first_link'] = '<img src="'.$this->config->item('style_url').'skin/img/resource/btn_min.png" title="First">';
        $this->pagination->initialize($config);
        $msg_id = $param1;
?>
<div id="mainview">
    <div class="buildingDescription">
        <h1>Mayor</h1>
        <p></p>
    </div>
    <div class="yui-navset">
        <ul class="yui-nav"  >
            <li  class="selected"><a
                href="<?=$this->config->item('base_url')?>game/tradeAdvisor/"
                title="City News"><em>City News</em></a></li>
            <li ><a
                href="<?=$this->config->item('base_url')?>game/tradeAdvisorTradeRoute/"
                title="trade routes"><em>trade routes</em></a></li>
        </ul>
    </div>
    <div class="contentBox01h">
        <h3 class="header">Current events(<?=SizeOf($this->Player_Model->towns_messages)?>)</h3>
        <div class="content">
            <table cellpadding="0" cellspacing="0" class="table01" id="inboxCity">
                <thead>
                    <tr>
                        <th></th>
                        <th colspan="2">Location</th>
                        <th>Date</th>
                        <th>Theme</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
<?$message_id = 0?>
<?foreach($this->Player_Model->towns_messages as $message){?>
<?if($message_id >= $msg_id and $message_id < ($msg_id + $config['per_page']) ){?>
                    <tr class="<?if (($message_id % 2) == 0){?>alt<?}else{?>empty<?}?>">
                        <td class="<?if ($message->checked == 0){?>wichtig<?}else{?>empty<?}?>"></td>
                        <td class="city"></td>
                        <td style="white-space:nowrap;">
                            <a title="Jump into the city<?=$this->Data_Model->temp_towns_db[$message->town]->name?>" href="/game/city/<?=$message->town?>/"><?=$this->Data_Model->temp_towns_db[$message->town]->name?></a>
                        </td>
                        <td class="date"><?=date("d.m.Y G:i",$message->date)?></td>
                        <td class="subject"><?=$message->text?></td>
                        <td class="empty"></td>
                    </tr>
<?}?>
<?$message_id++?>
<?}?>
                    <tr class="pgnt">
                        <td class="empty"></td>
                        <td></td>
                        <td></td>
                        <td colspan="i" class="paginator">
                            <?=$this->pagination->create_links()?>
                        </td>
                        <td></td>
                        <td class="empty"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer"></div>
    </div>
</div>
<script type="text/javascript">
<!--
 /* IE RTL dirty fix for invisible content foooooooooooo */
   Dom.get("mainview").style.display="block";
//-->
</script>
<?
    $this->db->set('checked', 1);
    $this->db->where(array('user' => $this->Player_Model->user->id));
    $this->db->update($this->session->userdata('universe').'_town_messages');
?>
