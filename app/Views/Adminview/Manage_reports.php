<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/assets/css/style.css">
        <!-- jQuery UI -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <title>Anagrafica Utente</title>
    </head>

    <body>
        <?php echo csrf_field(); ?>

        <!--   <div class=" w3-col s12 m6 l4>-->
        <div class=" w3-section w3-animate-right">
            <div class="w3-container w3-section w3-margin-top">
                <div class="w3-bar w3-dark-grey w3-large w3-margin">
                    <a href="<?php echo site_url('/AdminHome'); ?>" class=" w3-xxlarge w3-left"
                        title="<?php echo lang('Auth.goadminmenu'); ?>" style="margin-left:25px; margin-top:8px;"
                        onclick="$('#loading').show();">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </a>
                </div>

            </div>
            <div class="w3-container">
                <h2>Report </h2>
                <ul class="w3-ul w3-hoverable">

                    <?php foreach ($reports['filecontenuti']['listfile'] as $file) { ?>
                    <li>
                        <?php echo esc($file); ?> 
                        <button class="w3-button w3-margin-left" onclick="showfile('<?php echo $file; ?>')" title="Apri file">
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                       </button>   
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div id="loading" class="w3-modal w3-white w3-opacity" style="display:none">
            <img class="w3-padding w3-display-middle" src="/assets/imgwait/loading.gif" alt="wait...." />
        </div>
    </body>

</html>
<script>
    function showfile(file) {
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('EditReport'); ?>",
            data: {
                file: file,
                [csrfName]: csrfHash,
            },
            dataType: "html",
            success: function(data) {
        
                $('#main').html(data)
            }
        });

    }

</script>