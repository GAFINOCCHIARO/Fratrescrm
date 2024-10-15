
<html>
<body>
    <?php if (session('error') !== null) { ?>
                <div class="w3-panel w3-pale-red w3-leftbar w3-border-red" role="alert"><?php echo session('error'); ?></div>
            <?php } elseif (session('errors') !== null) { ?>
                <div class="w3-panel w3-pale-red w3-leftbar w3-border-red" role="alert">
                    <?php if (is_array(session('errors'))) { ?>
                        <?php foreach (session('errors') as $error) { ?>
                            <?php echo $error; ?>
                            <br>
                        <?php } ?>
                    <?php } else { ?>
                        <?php echo session('errors'); ?>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (session('message') !== null) { ?>
                <div class="alert alert-success" role="alert"><?php echo session('message'); ?></div>
            <?php } ?>

<form action="<?php echo url_to('SaveNewPassword'); ?>" method="post" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
<h2 class="w3-center">Reset Password</h2>
 
<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-key"></i></div>
    <div class="w3-rest">
    <input type="password" class="w3-input w3-round-large"  name="password" inputmode="text" autocomplete="new-password"
            placeholder="<?php echo lang('Auth.passwordnew'); ?>" required />
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-key"></i></div>
  <div class="w3-rest">
      
  <input type="password" class="w3-input w3-round-large" name="password_confirm" inputmode="text"
                autocomplete="new-password" placeholder="<?php echo lang('Auth.newpasswordConfirm'); ?>" required />
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-unlock-alt"></i></div>
    <div class="w3-rest">
     <input type="password" class="w3-input w3-round-large" name="old_password" inputmode="text" autocomplete="current-password"
            placeholder="<?php echo lang('Auth.OldPassword'); ?>" required />
    </div>
</div>
<button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding"><?php echo lang('Auth.btnsave'); ?></button>

</form>

</body>
</html> 

















