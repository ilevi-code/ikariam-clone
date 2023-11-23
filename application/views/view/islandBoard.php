<?
$island_id = $param1;
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$offset = $page * 5;
$messages = $this->Data_Model->Load_Agora($island_id, $offset);
$count = $this->Data_Model->count_message_in_agora($island_id);
$page_count = ceil($count / 5.0);
?>
<div id="mainview">
    <div class="buildingDescription">
        <h1>Agora</h1>
    </div>
    <div class="contentBoxMessage">
        <a class="button" href="/game/newAgoraPost/<?=$island_id?>">New message</a><br/><br/>
<? if (count($messages) == 0) { ?>
        <p class="warning">There are no messages here yet. By creating a new message you can get in touch with neighbors on your island.</p>
        <br/>
<? } else {
    foreach ($messages as $message) {
?>
    		<div class="contentBox01h">
            <h3 class="header"><span class="textLabel"><?=$message->login?> wrote on <?=date("Y-m-d H:i:s", $message->post_date)?></span></h3>
            <div class="content"><p><b><?=$message->subject?></b></p><p><?=$message->message?></p></div>
            <div class="footer"></div>
            </div>
<? } ?>
    <br/>
    <div class="pageBrowser">
<? if ($page > 0) { ?>
        <a href='?page=<?=$page - 1?>'>
            <img src='<?php echo base_url('design/skin/img/resource/btn_min.png');?>'>
        </a>
<? } ?>
<?
        for ($i = 1; $i <= $page_count ; $i++) {
            if ($i - 1 == $page) {
?>
        <span class="currentPage"><?=$i?></span>
<? } else { ?>
        <a class="pageLink" href='?page=<?=$i - 1?>'><?=$i?></a>
<?
            }
        }
?>
<? if ($page + 1 < $page_count) { ?>
        <a href='?page=<?=$page + 1?>'>
            <img src='<?php echo base_url('design/skin/img/resource/btn_max.png');?>'>
        </a>
<? } ?>
    </div>
<? } ?>
    </div>
</div>
