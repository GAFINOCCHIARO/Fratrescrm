<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- Chiusura del tag corretta qui -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div id="levelnodal" class="w3-modal" style="display: block;">
        <!-- begin window group level -->
        <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-dark-grey">
                <span onclick="document.getElementById('levelnodal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <h2><?php echo lang('Auth.autlevel'); ?></h2>
            </header>
            <div class="w3-responsive">
                <?php echo csrf_field(); ?>
                <div class="w3-row">
                    <?php
                  //  dd($user);
                foreach ($availablegroups as $keyavailablegroups => $descriptiongroup) { ?>
                        <input type="radio" name="group" class="w3-radio" id="group" value="<?php echo $keyavailablegroups; ?>" <?php echo($user->inGroup($keyavailablegroups)) ? 'checked' : ''; ?> />
                        <label for="group"><?php echo $descriptiongroup['title']; ?></label>
                    <?php } ?>
                </div>
                <div id="leveldescription" class="w3-content w3-margin-top">
                    <?php
                $i = 1;
                foreach ($permissions as $key => $description) { ?>
                        <div class="w3-col s3 m3 l4">
                            <input type="checkbox" name="permision<?php echo $i; ?>" class="ios8-switch" id="permision<?php echo $i; ?>" value="<?php echo $key; ?>" <?php echo($user->can($key)) ? 'checked' : ''; ?> />
                            <label for="permision<?php echo $i; ?>"><?php echo $description; ?></label>
                            <?php ++$i; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="w3-container">
                <button class="w3-btn w3-xxlarge" style="float:right;" id="savechange"><i class="fa fa-save" aria-hidden="true"></i></button>
            </div>
            <footer class="w3-container w3-dark-grey">
                <p><?php echo lang('Auth.autlevel'); ?></p>
            </footer>
        </div>
    </div>

    <script type="text/javascript">
        (function() {
            // Verifica se initialCheckboxStates è già stato dichiarato
            if (typeof window.initialCheckboxStates === 'undefined') {
                window.initialCheckboxStates = {};
            }

            function saveInitialCheckboxStates() {
                $('input[type="checkbox"][name^="permision"]').each(function() {
                    window.initialCheckboxStates[this.id] = $(this).prop('checked');
                });
            }

            function deselectActiveCheckboxes() {
                $('input[type="checkbox"][name^="permision"]').each(function() {
                    $(this).prop('checked', false);
                    $(this).prop('disabled', true);
                });
            }

            function restoreInitialCheckboxStates() {
                $('input[type="checkbox"][name^="permision"]').each(function() {
                    $(this).prop('checked', window.initialCheckboxStates[this.id]);
                    $(this).prop('disabled', false);
                });
            }

            $(document).ready(function() {
                saveInitialCheckboxStates();

                $('input[name="group"]').change(function() {
                    if ($(this).val() === 'user') {
                        deselectActiveCheckboxes();
                    } else if ($(this).val() === 'admin') {
                        restoreInitialCheckboxStates();
                    }
                });

                $('#savechange').click(function(e) {
                    e.preventDefault();
                    var Permissions = $('input[type="checkbox"][name^="permision"]:checked').map(function() {
                        return $(this).val(); // Ottiene il valore di ciascuna checkbox selezionata
                    }).get();
                    var id = $('#id').val();
                    var userType = $('input[name="group"]:checked').val();
                    var csrfName = 'csrf_token'; // CSRF Token name
                    var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
                    $('#loading').show();
                    $.ajax({
                        type: "post",
                        url: "<?php echo site_url('SaveLevelandGroup'); ?>",
                        data: {
                            userType: userType,
                            id: id,
                            [csrfName]: csrfHash,
                            permissions: Permissions,
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#loading').hide();
                            $('input[name="csrf_token"]').val(response.token);
                            saveInitialCheckboxStates();
                        }
                    });
                });
            });
        })();
    </script>
</body>

</html>
