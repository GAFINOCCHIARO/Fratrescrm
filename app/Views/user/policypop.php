<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php echo csrf_field(); ?>
<div class="w3-container">
    <div id="privacypopup" class="w3-modal" style="display:block">
        <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-teal">
                <h2><?= esc(lang('Auth.Privacyaceptheader')); ?></h2>
            </header>
            <div class="w3-container">
                <div class="w3-row w3-container">
                    <div class="w3-row w3-margin-top">
                        <input type="hidden" name="" id="idprivacy" value="<?= esc($id); ?>">
                        <textarea name="privacytext" id="privacytext" cols="90" rows="10"
                            class="w3-input  w3-border w3-round-xlarge"><?= esc($text); ?>
                    </textarea>
                    </div>
                    <div class="w3-row">
                        <div class="w3-row w3-half">
                            <button class="w3-button w3-block w3-section w3-green w3-ripple w3-padding"
                                id="acceptprivacypolicy"><?php echo lang('Auth.privacyaccept'); ?></button>
                        </div>
                        <div class="w3-row w3-half ">
                            <button class="w3-button w3-block w3-section w3-red w3-ripple w3-padding"
                                id="rejectprivacypolicy"><?php echo lang('Auth.privacyreject'); ?></button>
                        </div>
                    </div>
                </div>
                <footer class="w3-container w3-teal">
                    <p><?= esc(lang('Auth.Privacyaceptfooter')); ?></p>
                </footer>
            </div>
        </div>
    </div>
</div>
<script>
    $('#acceptprivacypolicy').click(function(e) {
        e.preventDefault();
        var csrfName = 'csrf_token'
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash
        $.ajax({
            type: "post",
            url: "<?php echo site_url('privacyaccept') ?>",
            data: {
                [csrfHash]: csrfHash,
                id: $('#idprivacy').val(),
            },
            dataType: "json",
            success: function(response) {
                $('input[name="csrf_token"]').val(response.token);
                $('#privacypopup').hide();
            }
        });

    });
</script>