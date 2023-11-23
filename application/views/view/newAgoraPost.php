<div id="mainview">
    <div class="buildingDescription">
        <h1>Post on Agora</h1>
    </div>
    <div class="contentBoxMessage">
    </div>
    <div class="contentBox01h">
        <h3 class="header"> Create new post</h3>
        <div class="content" id="diplomacyIslandBoard">

            <form class="newMessage" method="post" action="/actions/postAgora">

                <div>You can write a new post for the Agora here, which all islanders will be able to read. </div>

                <div class="postMessage">
                    <label class="bold left" for="subject">Subject</label>
                    <div class="inputDiv"><input class="textfield" type="text" name="subject" value="" maxlength="50"></div>
                    <label class="bold left" for="message">Message</label>
                    <div class="inputDiv"><textarea name="message"></textarea></div>
                    <span class="chars bold tinyFont"><span>1000</span> Chars</span>
                    <div class="centerButton">
                        <input class="button" title="" type="submit" value="Create new post">
                        <a href="/game/islandBoard/<?=$param1?>" class="button">Back</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="footer"></div>
    </div>
</div>
