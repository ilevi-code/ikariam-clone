<div id="mainview">
    <h1 style="text-align:center">Town Hall</h1>

    <form action="<?=$this->config->item('base_url')?>actions/rename/"  method="POST">
        <div id="renameCity" class="contentBox01h">
            <h3 class="header">Rename city</h3>
            <div class="content">
                <div class="oldCityName"><span class="textLabel">Former city name: </span><?=$this->Player_Model->now_town->name?></div>
                <div class="newCityName"><label for="newCityName">New city name: </label>
                    <input type="text" class="textfield" id="newCityName" name="name" size="30" maxlength="15">
                    <input type="submit" class="button" value="Accept title">
                </div>
            </div>
            <div class="footer"></div>
        </div>
    </form>
</div>