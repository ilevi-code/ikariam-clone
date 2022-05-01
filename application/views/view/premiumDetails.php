<div id="mainview">
    <h1>Ikariam Plus</h1>
    <div id="premiumAccountDetail" class="contentBox01h">
        <h3 class="header">Ikariam PLUS</h3>
        <div class="content">
            <p>Not every leader can boast of having up-to-date information about all incidents within their own empire and full control over all subjects. With Ikariam PLUS you can easily solve these problems!</p>
            <h4>construction queue</h4>

            <div>
                <a class="enlarge" href="<?=$this->config->item('style_url')?>skin/premium/overview_constructionlist.gif" title="click to enlarge!">
                    <img src="<?=$this->config->item('style_url')?>skin/premium/thumb_overview_constructionlist.gif" width="274" height="139" alt=""><br/>click to enlarge!
                </a>
                <p>The building list allows you to add buildings to be added to the construction queue. All buildings will be completed according to the order in the list. You can see the list in the left game window when looking at your colony.</p>
            </div>
            <h4>Building overview</h4>
            <div><a class="enlarge" href="<?=$this->config->item('style_url')?>skin/premium/overview_population.jpg" title="click to enlarge!">
                    <img src="<?=$this->config->item('style_url')?>skin/premium/thumb_overview_population.gif" width="300" height="139" alt="">click to enlarge!
                </a>
                <a class="enlarge" href="<?=$this->config->item('style_url')?>skin/premium/overview_resources.jpg" title="click to enlarge!">
                    <img src="<?=$this->config->item('style_url')?>skin/premium/thumb_overview_resources.gif" width="300" height="139" alt="">click to enlarge!
                </a>
                <p>Cities overview<strong>new city councilor</strong> gives you three separate overviews of the economy of your entire empire.</p>
                <ul><li><strong>Compact overview</strong> all working citizens</li><li>Level<strong>contentment in all cities</strong> on one screen</li><li>Review<strong>warehouse stock</strong> in all cities and levels of mineral deposits</li><li><strong>Direct links</strong> to all cities</strong> and mineral deposits</li><li>Review<strong>levels of all important buildings</strong> (e.g. town hall) in all your cities!</li></ul>
            </div>
            <h4>Troop overview</h4>

            <div>
                <a class="enlarge" href="<?=$this->config->item('style_url')?>skin/premium/overview_military.jpg" title="click to enlarge!">
                    <img src="<?=$this->config->item('style_url')?>skin/premium/thumb_overview_military.gif" width="300" height="230" alt="">click to enlarge!
                </a>
                <p>As<strong>commander in chief</strong> You will get an overview of all armies and navies, as well as an overview of their maintenance costs.</p>
                <ul><li><strong>Your entire army in one overview</strong> - what troops are currently available and how many of them you can send on a campaign!</li><li> All cost<strong>hourly maintenance</strong>, general and for each combat unit!</li><li> Control and optimize your military spending! </li><li>Statistics<strong>for all available ground forces and ships!</strong></li></ul>
            </div>
            <h4>Review of studies</h4>
            <div><a class="enlarge" href="<?=$this->config->item('style_url')?>skin/premium/overview_research.jpg" title="click to enlarge!">
                    <img src="<?=$this->config->item('style_url')?>skin/premium/thumb_overview_research.gif" width="300" height="131" alt="">click to enlarge!
                </a>
                <p>By using the Research Brief, you can turn<strong>knowledge into real power!</strong> A complete overview of all your expenses!</p>
                <ul><li>Review<strong>levels of academies and scientists employed in them</strong> in all cities! </li><li><strong>Expenses</strong> for all researchers!</li><li><strong>Direct links</strong> to all academies!</li></ul>
            </div>
            <h4>Diplomacy Overview</h4>
            <div>
                <a class="enlarge" href="<?=$this->config->item('style_url')?>skin/premium/overview_espionage.jpg" title="click to enlarge!">
                    <img src="<?=$this->config->item('style_url')?>skin/premium/thumb_overview_espionage.gif" width="300" height="140" alt="">click to enlarge!
                </a>
                <p>Both diplomats and generals need<strong>accurate intelligence information</strong>, which is the basis of any well-thought-out decision. You will find all the information you need in this brief overview.!</p>
                <ul><li><strong>All active spies</strong> in all cities in one brief overview!</li><li> Information about the last mission,<strong> about the whereabouts of the spies</strong>, as well as the end time of their missions!</li><li><strong> Current exposure risk</strong>all your spies! </li><li><strong> Direct links to home cities of spies</strong> for quick assignment of missions!</li></ul>
            </div>
            <div id="premiumOffers">

                <table class="TableHoriMax Account" style="clear:both;">
                    <tr>
                        <th class="feature">PLUS Features</th>
                        <th class="duration">Time</th>
                        <th class="cost">Price</th>
                        <th class="buy">&nbsp;</th>
                    </tr>
                    <tr class="account">
                        <td class="feature" rowspan="2">
                            <h4>Premium account</h4>
                            <p>Get the listed features all at once!</p>
                        </td>
                        <td class="duration">7&nbsp;e.</td>
                        <td class="cost">10&nbsp;<img src="<?=$this->config->item('style_url')?>skin/premium/ambrosia_icon.gif" width="24" height="20" alt="Ambrosia"></td>
                        <td class="buy">
<?if($this->Player_Model->user->ambrosy >= 10){?>
        <div class="centerButton">
            <a href="<?=$this->config->item('base_url')?>actions/premium/account/" class="button" title="Buy">Buy</a>
        </div>
<?}else{?>
                      <a class="notenough" href="<?=$this->config->item('base_url')?>game/premiumPayment/">Lacks10 ed. ragweed!<br><span class="buyNow">Buy!</span></a>
<?}?>
                        </td>
                    </tr>
                    <tr>
<?if($this->Player_Model->user->premium_account > 0){?>
                    <td class="active" colspan="3"><br>Left<?=premium_time($this->Player_Model->user->premium_account-time())?></td>
<?}else{?>
                    <td class="inactive" colspan="3">Not active</td>
<?}?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>