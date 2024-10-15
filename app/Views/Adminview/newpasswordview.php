<html>

    <body>

        
              
        <div class="w3-container w3-section w3-margin-top">
            <div class="w3-bar w3-dark-grey w3-large w3-margin">
                <a href="<?php echo site_url('/AdimnHome'); ?>" class=" w3-xxlarge w3-left"
                    title="<?php echo lang('Auth.goadminmenu'); ?>" style="margin-left:25px; margin-top:8px;"
                    onclick="$('#loading').show();">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="w3-container w3-section">
            <div class="w3-panel w3-pale-red w3-leftbar w3-border-red" role="alert">
            <p id="error"></p>
        </div>
            <form class="w3-card w3-half">
                <h2 class="w3-center">Reset Password</h2>
                <?php echo csrf_field(); ?>
                <div class="w3-row w3-section">
                    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-key"></i></div>
                    <div class="w3-rest">
                        <input type="password" class="w3-input w3-round-large" name="password" id="password" inputmode="text"
                            autocomplete="new-password" placeholder="<?php echo lang('Auth.passwordnew'); ?>"
                            required />
                    </div>
                </div>

                <div class="w3-row w3-section">
                    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-key"></i></div>
                    <div class="w3-rest">
                        <input type="password" class="w3-input w3-round-large" name="password_confirm" id="password_confirm"
                              inputmode="text" autocomplete="new-password" placeholder="<?php echo lang('Auth.newpasswordConfirm'); ?>"
                            required />
                    </div>
                </div>

                <div class="w3-row w3-section">
                    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-unlock-alt"></i></div>
                    <div class="w3-rest">
                        <input type="password" class="w3-input w3-round-large" name="old_password" inputmode="text"
                            autocomplete="current-password" placeholder="<?php echo lang('Auth.OldPassword'); ?>"
                           id="old_password" required />
                    </div>
                </div>
                <button class="w3-button w3-block w3-section w3-green w3-ripple w3-padding" id="changepassword"><?php echo lang('Auth.btnsave'); ?></button>

            </form>
        </div>
    </body>

</html>
<script type="text/javascript">
    $('#changepassword').click(function (e) { 
        e.preventDefault();
         $('#loading').show();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('UpdatePassword'); ?>",
            data: {
                password: $('#password').val(),
                password_confirm:$('#password_confirm').val(),
                old_password:$('#old_password').val(),
                [csrfName]: csrfHash,
            },
            dataType: "json",
            success: function(data) {
                $('#loading').hide();
                 $('input[name="csrf_token"]').val(data.token);
                $('#error').html(data.error);


            }
        });
        
    });

</script>