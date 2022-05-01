<div id="mainview">

  <div class="buildingDescription">
    <h1>Settings</h1>
    <p>Here you can change the player's name, password and email address. The email address can only be changed once a week and only numbers, letters and spaces can be used.</p>
  </div><!-- ende .buildingDescription -->

<?if($this->Player_Model->user->register_complete == 0 and $this->config->item('game_email')){?>
  <div class="contentBox01h" id="emailInvalidWarning">
    <h3 class="header"><span class="textLabel">Your addresse-mail has not been confirmed!</span></h3>
    <div class="content">
      <p>Your addresse-mail has not been confirmed. Until you confirm it, you will not be able to fully play. The addresse-mail can be confirmed by clicking on the link in the email. If you have not received such a letter, you can request it again here.</p>
      <div class="centerButton">
          <a class="button" href="<?=$this->config->item('base_url')?>actions/options/validationEmail/">Send confirmation email</a>
      </div>
    </div>
    <div class="footer"></div>
  </div>
<?}?>

<?if($this->session->flashdata('options_error')){?>
<div class="contentBox01h">
    <h3 class="header"><span class="textLabel">Error message</span></h3>
    <div class="content">
        <ul class="errors">
<?if($this->session->flashdata('options_error_login')){?>
            <li><?=$this->session->flashdata('options_error_login')?></li>
<?}?>
        </ul>
    </div>
    <div class="footer"></div>
</div>
<?}?>

  <div class="contentBox01h">
    <h3 class="header"><span class="textLabel">Settings</span></h3>
    <div class="content">
      <form  action="<?=$this->config->item('base_url')?>actions/options/user/" method="POST">
      
      <div id="options_userData">
        <table cellpadding="0" cellspacing="0">
          <tr>
            <th>Rename player</th>
            <td><input class="textfield" type="text" name="name" size="15" value="<?=$this->Player_Model->user->login?>"></td>
          </tr>

        </table>
      </div>

      <div id="options_changePass">
        <h3>Change password</h3>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <th>Former password</th>
            <td><input type="password" class="textfield" name="oldPassword" size="20"></td>
          </tr>
          <tr>
            <th>New Password</th>
            <td><input type="password" class="textfield" name="newPassword" size="20"></td>
          </tr>
          <tr>
            <th>New password confirmation</th>
            <td><input type="password" class="textfield" name="newPasswordConfirm" size="20"></td>
          </tr>
        </table>
      </div>

    <div>
    <h3>Miscellaneous</h3>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th>Show additional information in city selection</th>
            <td>
                <select name="citySelectOptions" size="1">
                    <option value="0" <?if($this->Player_Model->user->options_select == 0){?>selected="selected"<?}?>>Not</option>
                    <option value="1" <?if($this->Player_Model->user->options_select == 1){?>selected="selected"<?}?>>Show coordinates in city overview</option>
                    <option value="2" <?if($this->Player_Model->user->options_select == 2){?>selected="selected"<?}?>>Products</option>
                    </select>
                </td>
            </tr>
<?if($this->Player_Model->user->tutorial < 999){?>
        <tr>
            <th>Training</th>
            <td>
                <select name="tutorialOptions" size="1">
                    <option value="2"selected>Turn on</option>
                    <option value="-2">Disable</option>
                    </select>
                </td>
        </tr>
<?}?>
        </table>
    </div>

      <div id="options_debug">
      <h3>Debugdata</h3>
      <table cellpadding="0" cellspacing="0">
        <tr>
          <th>Player-ID:</th>
          <td> <?=$this->Player_Model->user->id?></td>
        </tr>
        <tr>
          <th>Current City-ID: </th>
          <td><?=$this->Player_Model->user->town?></td>
        </tr>
      </table>
      </div>


      <div class="centerButton">
        <input type="submit" class="button" value="Save">
      </div>
      </form>
      </div>
      <div class="footer"></div>
    </div>



    <div class="contentBox01h">
    <h3 class="header"><span class="textLabel">Changee-mail</span></h3>
    <div class="content">
      <form  action="<?=$this->config->item('base_url')?>actions/options/email/" method="POST">
      <table cellpadding="0" cellspacing="0">

      <tr>
            <th>Changee-mail</th>
            <td>
                                <input class="textfield" type="text" name="email" size="30" value="<?=$this->Player_Model->user->email?>">
                                (<?=$this->Player_Model->user->email?>)
            </td>
          </tr>

           <tr>
          	<th>enter a password to confirm the new addresse-mail</th>
          	<td><input type="password" class="textfield" name="emailPassword" size="20"/></td>
          </tr>
      </table>
      <div class="centerButton">
          <input type="submit" class="button" value="Changee-mail">
      </div>
      </form>
      </div>
      <div class="footer"></div>
    </div>

      <div class="contentBox01h" id="vacationMode">
        <h3 class="header"><span class="textLabel">Enable Vacation Mode</span></h3>
        <div class="content">
          <p>Here you can activate holiday mode. This means that your game account will not be deleted due to inactivity and your cities will not be attacked during this time. Your workers and scientists will stop their work. You can enter the holiday mode for at least48 hours. You cannot play Ikariam during this time. After these two days, your vacation will automatically end as soon as you log into the game.</p>
          <p class="warningFont">Attention! Fleets and armies leaving your cities will be reorganized and brought back as soon as you enter vacation mode! Goods on board will be lost!</p>
            <div class="centerButton">
                <a class="button" href="<?=$this->config->item('base_url')?>game/options_umod_confirm/">Enable Vacation Mode</a>
            </div>
        </div>
        <div class="footer"></div>
      </div>


      <div class="contentBox01h" id="deletionMode">
        <h3 class="header"><span class="textLabel">Account deleting</span></h3>
        <div class="content">
          <p>If you no longer want to play, you can delete your account here. It will be deleted after seven days.</p>
          <br>
          <div class="centerButton">
            <a class="button" href="<?=$this->config->item('base_url')?>game/options_deletion_confirm/">Delete account!</a>
          </div>
          <br>
        </div>
        <div class="footer"></div>
      </div>



</div> 