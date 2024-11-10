<html>

<body>



    <div class="w3-container w3-section w3-margin-top">
        <div class="w3-bar w3-dark-grey w3-large w3-margin">
            <a href="<?php echo site_url('/AdminHome'); ?>" class=" w3-xxlarge w3-left"
                title="<?php echo lang('Auth.goadminmenu'); ?>" style="margin-left:25px; margin-top:8px;"
                onclick="$('#loading').show();">
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <h2 class="w3-center"> Privacy policy</h2>
   
    <div class="w3-row w3-container">
        <textarea name="privacytext" id="privacytext" cols="120" rows="10"
            class="w3-inputw3 w3-border w3-round-xlarge" placeholder="<?php echo lang('Auth.textareaprovacypolicyplaceholder'); ?>"></textarea>

        <button class="w3-button w3-block w3-section w3-green w3-ripple w3-padding"
            id="saveprivacypolicy"><?php echo lang('Auth.btnsave'); ?></button>
    </div>
</body>

</html>
<script type="text/javascript">
    $('#saveprivacypolicy').click(function(e) {
        e.preventDefault();
        $('#loading').show();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('saveprivacypolicy'); ?>",
            data: {
                privacytext: $('#privacytext').val(),
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