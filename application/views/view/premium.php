<div id="mainview">
    <h1>Ikariam Plus</h1>
    <div id="premiumOffers" class="contentBox01h">
        <h3 class="header">Ikariam PLUS</h3>
        <div class="content">
            <p>Ikariam PLUS will give you the opportunity to lead your empire along the path of wealth and prosperity. Get some ambrosia, and then your advisors and employees will pleasantly surprise you with the quality of their work.!
    You can choose from the following bonuses:</p>
            <table class="TableHoriMax Account">
                <tr>
                    <th class="feature">PLUS Features</th>
                    <th class="duration">Time</th>
                    <th class="cost">Price</th>
                    <th class="buy">&nbsp;</th>
                </tr>
                <tr class="account">
                    <td class="feature" rowspan="2">
                      <h4>Premium account</h4>
                      <p>With Ikariam PLUS you will get improved views and full control over your island empire.</p>
                      <a href="<?=$this->config->item('base_url')?>game/premiumDetails/">More about Ikariam PLUS</a>
                    </td>
                    <td class="duration">7&nbsp;e.</td>
                    <td class="cost">10&nbsp;<img src="<?=$this->config->item('style_url')?>skin/premium/ambrosia_icon.gif" width="24" height="20" alt="Ambrosia" /></td>
                    <td class="buy" rowspan="2">
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

            <table class="TableHoriMax">
                <tr>
                    <th class="feature">PLUS bonuses</th>
                    <th class="duration">Time</th>
                    <th class="cost">Price</th>
                    <th class="buy">&nbsp;</th>
                </tr>

                <tr class="woodbonus">
                    <td class="feature" rowspan="2">
                      <h4>20% more building materials</h4>
                      <p>During the bonus, all your islands will be mined on20% more building materials!</p>
                    </td>
                    <td class="duration">7&nbsp;e.</td>
                    <td class="cost">10&nbsp;<img src="<?=$this->config->item('style_url')?>skin/premium/ambrosia_icon.gif" width="24" height="20" alt="Ambrosia" /></td>
                    <td class="buy"  rowspan="2">
<?if($this->Player_Model->user->ambrosy >= 10){?>
        <div class="centerButton">
            <a href="<?=$this->config->item('base_url')?>actions/premium/wood/" class="button" title="Buy">Buy</a>
        </div>
<?}else{?>
                      <a class="notenough" href="<?=$this->config->item('base_url')?>game/premiumPayment/">Lacks10 ed. ragweed!<br><span class="buyNow">Buy!</span></a>
<?}?>
                    </td>
                </tr>

                <tr>
<?if($this->Player_Model->user->premium_wood > 0){?>
                    <td class="active" colspan="3"><br>Left<?=premium_time($this->Player_Model->user->premium_wood-time())?></td>
<?}else{?>
                    <td class="inactive" colspan="3">Not active</td>
<?}?>
                </tr>

                <tr style="background-image:url(<?=$this->config->item('style_url')?>skin/premium/table_border_2.gif); background-repeat:no-repeat; background-position:center;">
                    <td colspan=4></td>
                </tr>

                <tr class="marblebonus">
                    <td class="feature" rowspan="2">
                      <h4>20% more marble</h4>
                      <p>During the bonus, all your islands will be mined on20% more marble!</p>
                    </td>
                    <td class="duration">7&nbsp;e.</td>
                    <td class="cost">8&nbsp;<img src="<?=$this->config->item('style_url')?>skin/premium/ambrosia_icon.gif" width="24" height="20" alt="Ambrosia" /></td>
                    <td class="buy"  rowspan="2">
<?if($this->Player_Model->user->ambrosy >= 8){?>
        <div class="centerButton">
            <a href="<?=$this->config->item('base_url')?>actions/premium/marble/" class="button" title="Buy">Buy</a>
        </div>
<?}else{?>
                      <a class="notenough" href="<?=$this->config->item('base_url')?>game/premiumPayment/">Lacks8 ed. ragweed!<br><span class="buyNow">Buy!</span></a>
<?}?>
                    </td>
                </tr>

                <tr>
<?if($this->Player_Model->user->premium_marble > 0){?>
                    <td class="active" colspan="3"><br>Left<?=premium_time($this->Player_Model->user->premium_marble-time())?></td>
<?}else{?>
                    <td class="inactive" colspan="3">Not active</td>
<?}?>
                </tr>

                <tr style="background-image:url(<?=$this->config->item('style_url')?>skin/premium/table_border_2.gif); background-repeat:no-repeat; background-position:center;">
                    <td colspan=4></td>
                </tr>

                <tr class="sulfurbonus">
                    <td class="feature" rowspan="2">
                      <h4>20% more sulfur</h4>
                      <p>During the bonus, all your islands will be mined on20% more sulfur!</p>
                    </td>
                    <td class="duration">7&nbsp;e.</td>
                    <td class="cost">3&nbsp;<img src="<?=$this->config->item('style_url')?>skin/premium/ambrosia_icon.gif" width="24" height="20" alt="Ambrosia" /></td>
                    <td class="buy"  rowspan="2">
<?if($this->Player_Model->user->ambrosy >= 3){?>
        <div class="centerButton">
            <a href="<?=$this->config->item('base_url')?>actions/premium/sulfur/" class="button" title="Buy">Buy</a>
        </div>
<?}else{?>
                      <a class="notenough" href="<?=$this->config->item('base_url')?>game/premiumPayment/">Lacks3 ed. ragweed!<br><span class="buyNow">Buy!</span></a>
<?}?>
                    </td>
                </tr>

                <tr>
<?if($this->Player_Model->user->premium_sulfur > 0){?>
                    <td class="active" colspan="3"><br>Left<?=premium_time($this->Player_Model->user->premium_sulfur-time())?></td>
<?}else{?>
                    <td class="inactive" colspan="3">Not active</td>
<?}?>
                </tr>

                <tr style="background-image:url(<?=$this->config->item('style_url')?>skin/premium/table_border_2.gif); background-repeat:no-repeat; background-position:center;">
                    <td colspan=4></td>
                </tr>

                <tr class="crystalbonus">
                    <td class="feature" rowspan="2">
                      <h4>20% more crystal</h4>
                      <p>During the bonus, all your islands will be mined on20% more crystal!</p>
                    </td>
                    <td class="duration">7&nbsp;e.</td>
                    <td class="cost">5&nbsp;<img src="<?=$this->config->item('style_url')?>skin/premium/ambrosia_icon.gif" width="24" height="20" alt="Ambrosia" /></td>
                    <td class="buy"  rowspan="2">
<?if($this->Player_Model->user->ambrosy >= 5){?>
        <div class="centerButton">
            <a href="<?=$this->config->item('base_url')?>actions/premium/crystal/" class="button" title="Buy">Buy</a>
        </div>
<?}else{?>
                      <a class="notenough" href="<?=$this->config->item('base_url')?>game/premiumPayment/">Lacks5 ed. ragweed!<br><span class="buyNow">Buy!</span></a>
<?}?>
                    </td>
                </tr>

                <tr>
<?if($this->Player_Model->user->premium_crystal > 0){?>
                    <td class="active" colspan="3"><br>Left<?=premium_time($this->Player_Model->user->premium_crystal-time())?></td>
<?}else{?>
                    <td class="inactive" colspan="3">Not active</td>
<?}?>
                </tr>

                <tr style="background-image:url(<?=$this->config->item('style_url')?>skin/premium/table_border_2.gif); background-repeat:no-repeat; background-position:center;">
                    <td colspan=4></td>
                </tr>

                <tr class="winebonus">
                    <td class="feature" rowspan="2">
                      <h4>20% more grapes</h4>
                      <p>During the bonus, all your islands will be mined on20% more grapes!</p>
                    </td>
                    <td class="duration">7&nbsp;e.</td>
                    <td class="cost">3&nbsp;<img src="<?=$this->config->item('style_url')?>skin/premium/ambrosia_icon.gif" width="24" height="20" alt="Ambrosia" /></td>
                    <td class="buy"  rowspan="2">
<?if($this->Player_Model->user->ambrosy >= 3){?>
        <div class="centerButton">
            <a href="<?=$this->config->item('base_url')?>actions/premium/wine/" class="button" title="Buy">Buy</a>
        </div>
<?}else{?>
                      <a class="notenough" href="<?=$this->config->item('base_url')?>game/premiumPayment/">Lacks3 ed. ragweed!<br><span class="buyNow">Buy!</span></a>
<?}?>
                    </td>
                </tr>

                <tr>
<?if($this->Player_Model->user->premium_wine > 0){?>
                    <td class="active" colspan="3"><br>Left<?=premium_time($this->Player_Model->user->premium_wine-time())?></td>
<?}else{?>
                    <td class="inactive" colspan="3">Not active</td>
<?}?>
                </tr>

                <tr style="background-image:url(<?=$this->config->item('style_url')?>skin/premium/table_border_2.gif); background-repeat:no-repeat; background-position:center;">
                    <td colspan=4></td>
                </tr>

                <tr class="savecapacityBonus">
                    <td class="feature" rowspan="2">
                      <h4>Increases the size of the secret vault in warehouses by100%.</h4>
                      <p>You get an additional bonus to the reserved resources in warehouses in the amount of100%.</p>
                    </td>
                    <td class="duration">7&nbsp;e.</td>
                    <td class="cost">14&nbsp;<img src="<?=$this->config->item('style_url')?>skin/premium/ambrosia_icon.gif" width="24" height="20" alt="Ambrosia" /></td>
                    <td class="buy"  rowspan="2">
<?if($this->Player_Model->user->ambrosy >= 14){?>
        <div class="centerButton">
            <a href="<?=$this->config->item('base_url')?>actions/premium/capacity/" class="button" title="Buy">Buy</a>
        </div>
<?}else{?>
                      <a class="notenough" href="<?=$this->config->item('base_url')?>game/premiumPayment/">Lacks14 ed. ragweed!<br><span class="buyNow">Buy!</span></a>
<?}?>
                    </td>
                </tr>

                <tr>
<?if($this->Player_Model->user->premium_capacity > 0){?>
                    <td class="active" colspan="3"><br>Left<?=premium_time($this->Player_Model->user->premium_capacity-time())?></td>
<?}else{?>
                    <td class="inactive" colspan="3">Not active</td>
<?}?>
                </tr>

            </table>
        </div>
        <div class="footer"></div>
    </div>
</div>