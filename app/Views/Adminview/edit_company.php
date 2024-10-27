<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <div class="w3-container">
        <?php echo csrf_field(); ?>
        <div class="w3-bar w3-dark-grey w3-large w3-margin-bottom w3-margin-top">
            <a href="<?php echo site_url('/AdminHome'); ?>" class=" w3-xxlarge w3-left"
                title="<?php echo lang('Auth.goadminmenu'); ?>" style="margin-left:25px; margin-top:8px;"
                onclick="$('#loading').show();">
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>
        </div>
        <?php echo csrf_field(); ?>
        <fieldset>
            <fieldset>
                <legend><?php echo lang('Auth.companyEditi_fieldset'); ?></legend>
                <div id="buttonpannel" class="w3-row-paddingw3-conntainer">
                    <button class="w3-btn w3-xxlarge" id="savedata" style="float: right;"><i class="fa fa-save"
                            aria-hidden="true"></i></button>
                    <h3>
                        <p id="status" class="w3-text-red"> </p>
                    </h3>
                </div>
                <div class="w3-row-paddinf w3-container">
                    <div class="w3-half">
                        <label for="company_agendacode"><?php echo lang('Auth.company_agendacode'); ?> </label>
                        <input class="w3-input w3-border w3-round-xlarge" type="text" id="company_agendacode"
                            name="company_agendacode" inputmode="text" autocomplete="company_agendacode"
                            value="<?php echo esc($companydata->agenda_code); ?>" readonly>
                    </div>
                    <div class="w3-half">
                        <label
                            for="idcompany_agendacoderefer"><?php echo lang('Auth.company_agendacoderefer'); ?></label>
                        <input type="text" name="idcompany_agendacoderefer" id="idcompany_agendacoderefer"
                            class="w3-input w3-border w3-round-xlarge"  value="<?php echo esc($companydata->agendacoderefer); ?>" >
                    </div>
                </div>
                <div class="w3-row-padding w3-container">
                    <!-- begin row business_name  e group_name form input-->
                    <div class="w3-half  ">
                        <!--  row business_name-->
                        <label for="company_name"><?php echo lang('Auth.business_name'); ?>
                        </label>
                        <input class="w3-input w3-border w3-round-xlarge" type="text" id="company_name"
                            name="company_name" inputmode="text" autocomplete="company_name"
                            placeholder="<?php echo lang('Auth.business_nameplaceholder'); ?>"
                            value="<?php echo esc($companydata->company_name); ?>">
                        <p id="errorcompany_name" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-half">
                        <!-- group_name form input-->
                        <label for="group_name"><?php echo lang('Auth.group_name'); ?></label>
                        <input class="w3-input w3-border w3-round-xlarge" name="group_name" id="group_name"
                            type="text" autocomplete="group_name"
                            placeholder="<?php echo lang('Auth.company_nameplaceholder'); ?>"
                            value="<?php echo esc($companydata->company_group); ?>">
                        <p id="errorgroup_name" class="w3-text-red"> </p>

                    </div>
                </div> <!-- end   row business_name  e group_name form input-->

                <div class="w3-row-padding w3-container">
                    <!-- begin row company_address   e company_city form input-->
                    <div class="w3-half">
                        <!-- company_address -->
                        <label for="company_address"><?php echo lang('Auth.business_address'); ?></label>
                        <input class="w3-input w3-border  w3-round-xlarge" name="company_address"
                            id="company_address" type="text"
                            value="<?php echo esc($companydata->company_address); ?>"
                            placeholder="<?php echo lang('Auth.business_addressplaceholder'); ?>">
                        <p id="errorcompany_address" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-half">
                        <!-- company_city -->
                        <label for="company_city"><?php echo lang('Auth.company_city'); ?></label>
                        <input class="w3-input w3-border  w3-round-xlarge" name="company_city" id="company_city"
                            type="text" value="<?php echo esc($companydata->company_city); ?>"
                            placeholder="<?php echo lang('Auth.company_cityplaceholder'); ?>">
                        <p id="errorcompany_city" class="w3-text-red"> </p>
                    </div>
                </div> <!-- end   row company_address   e company_city form input-->

                <div class="w3-row-padding w3-container">
                    <!-- begin row company phone number    e company_vat form input-->
                    <div class="w3-half">
                        <!--  row company phone number -->
                        <label for="company_phone"><?php echo lang('auth.company_phone'); ?> </label>
                        <input class="w3-input w3-border w3-round-xlarge" name="company_phone" id="company_phone"
                            type="text" value="<?php echo esc($companydata->company_phone); ?>"
                            placeholder="<?php echo lang('Auth.company_phoneplaceholder'); ?>">
                        <p id="errorcompany_phone" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-half">
                        <!--   row company_vat form input-->
                        <label for="company_vat"><?php echo lang('Auth.company_vat'); ?></label>
                        <input class="w3-input w3-border  w3-round-xlarge" name="company_vat" id="company_vat"
                            type="text" value="<?php echo esc($companydata->company_vat); ?>"
                            placeholder="<?php echo lang('Auth.company_vatplaceholder'); ?>">
                        <p id="errorcompany_vat" class="w3-text-red"> </p>
                    </div>
                </div> <!-- end   row company phone number   e  company_vat form input-->

                <div class="w3-row-padding w3-container">
                    <!-- begin row company mail form input-->
                    <div class="w3-quarter">
                        <!--   company mail form input-->
                        <label for="companyemail"><?php echo lang('Auth.companyemail'); ?></label>
                        <input class="w3-input w3-border  w3-round-xlarge" type="email" name="companyemail"
                            id="companyemail" autocomplete="e-mail"
                            value="<?php echo esc($companydata->company_email); ?>"
                            placeholder="<?php echo lang('Auth.companyemailplaceholder'); ?>" />
                        <p id="errorcompanyemail" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-quarter">
                        <label for="president_name"><?php echo lang('Auth.companypresidentname'); ?></label>
                        <input class="w3-input w3-round-xlarge w3-border" type="text" name="president_name"
                            id="president_name" value="<?php echo esc($companydata->president_name); ?>"
                            placeholder="<?php echo lang('Auth.companypresidentnameplacheholder'); ?>">
                    </div>
                    <div class="w3-quarter">
                        <label for="siteurl"><?php echo lang('Auth.siteurl'); ?></label>
                        <input class="w3-input w3-round-xlarge w3-border" type="url" name="siteurl" id="siteurl"
                            value="<?php echo esc($companydata->company_site_url); ?>"
                            placeholder="<?php echo lang('Auth.siteurlplacheholder'); ?>" />
                        <p id="errorsiteurl" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-quarter">
                        <label for="siteurl"><?php echo lang('Auth.number_armchairs'); ?></label>
                        <input class="w3-input w3-round-xlarge w3-border" type="url" name="number_armchairs"
                            id="number_armchairs" value="<?php echo esc($companydata->number_armchairs); ?>"
                            placeholder="<?php echo lang('Auth.number_armchairsplacheholder'); ?>" />
                        <p id="errornumber_armchairs" class="w3-text-red"> </p>
                    </div>
                </div> <!-- end   row company mail form input-->
                <div class="w3-row-padding w3-container">
                    <div class="w3-third">
                        <label for="dplasma"><?php echo lang('Auth.dplasma'); ?></label>
                        <input type="checkbox" name="dplasma" id="dplasma" class="w3-check"
                            <?= ($companydata->dplasma == 0) ? '' :  'checked'; ?> value="1">
                    </div>
                    <div class="w3-third"><?php echo lang('Auth.dpiastrine'); ?></label>
                        <input type="checkbox" name="dpiastrine" id="dpiastrine" class="w3-check"
                            <?= ($companydata->dpiastrine == 0) ? '' :  'checked'; ?> value="1">
                    </div>
                    <div class="w3-third">
                        <label for="dsangue"><?php echo lang('Auth.dsangue'); ?></label>
                        <input type="checkbox" name="dsangue" id="dsangue" class="w3-check"
                            <?= ($companydata->dsangue == 0) ? '' :  'checked'; ?> value="1">
                    </div>
                </div>

                <table class="w3-table w3-bordered">
                    <thead>
                        <tr>
                            <th>Giorno della Settimana</th>
                            <th>Prima Apertura</th>
                            <th>Prima Chiusura</th>
                            <th>Seconda Apertura</th>
                            <th>Seconda Chiusura</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataWorkingHours as $bh): ?>
                            <tr>
                                <td><?= esc($bh->day_of_week) ?></td>
                                <td>
                                    <input type="time" class="w3-input w3-border w3-round-xlarge"
                                        name="open_time1[<?= esc($bh->day_of_week) ?>]"
                                        value="<?= !empty($bh->open_time1) ? esc($bh->open_time1) : '' ?>">
                                </td>
                                <td>
                                    <input type="time" class="w3-input w3-border w3-round-xlarge"
                                        name="close_time1[<?= esc($bh->day_of_week) ?>]"
                                        value="<?= !empty($bh->close_time1) ? esc($bh->close_time1) : '' ?>">
                                </td>
                                <td>
                                    <input type="time" class="w3-input w3-border w3-round-xlarge"
                                        name="open_time2[<?= esc($bh->day_of_week) ?>]"
                                        value="<?= !empty($bh->open_time2) ? esc($bh->open_time2) : '' ?>">
                                </td>
                                <td>
                                    <input type="time" class="w3-input w3-border w3-round-xlarge"
                                        name="close_time2[<?= esc($bh->day_of_week) ?>]"
                                        value="<?= !empty($bh->close_time2) ? esc($bh->close_time2) : '' ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </fieldset>

        </fieldset>

    </div>
</body>

</html>
<script>
    function clearscreen() {
        $("#errorcompany_name").html("  ");
        $("#company_name").removeClass("w3-border-red");
        $("#errorgroup_name").html("  ");
        $("#group_name").removeClass("w3-border-red");
        $("#errorcompany_address").html("  ");
        $("#company_address").removeClass("w3-border-red");
        $("#errorcompany_city").html("  ");
        $("#company_city").removeClass("w3-border-red");
        $("#errorcompany_vat").html("  ");
        $("#company_vat").removeClass("w3-border-red");
        $("#errorcompany_phone").html("  ");
        $("#company_phone").removeClass("w3-border-red");
        $("#errorcompanyemail").html("  ");
        $("#companyemail").removeClass("w3-border-red");
        $("#errorsiteurl").html("  ");
        $("#siteurl").removeClass("w3-border-red");
        $("#number_armchairs").html("  ");
        $("#number_armchairs").removeClass("w3-border-red");

    }
    $(document).ready(function() {
        $('#savedata').click(function(e) {
            e.preventDefault();
            $("#status").html("  ");
            $('#loading').show();
            var csrfName = 'csrf_token'; // CSRF Token name
            var csrfHash = $('input[name="csrf_token"]').val();
            var data = {};
            $('input[type="time"]').each(function() {
                var day = $(this).attr('name').match(/\[(.*?)\]/)[
                    1]; // Estrae il giorno della settimana dalla chiave
                if (!data[day]) data[day] = {};
                var name = $(this).attr('name').split('[')[0];
                data[day][name] = $(this).val();
            });

            var dpiastrine = $("#dpiastrine").is(":checked") ? 1 : 0;
            var dplasma = $('#dplasma').is(":checked") ? 1 : 0;
            var dsangue = $('#dsangue').is(":checked") ? 1 : 0;




            $.ajax({
                type: "post",
                url: "<?php echo site_url('UpdateCompanydata'); ?>",
                data: {
                    [csrfName]: csrfHash,
                    'company_name': $('#company_name').val(),
                    'group_name': $('#group_name').val(),
                    'company_address': $('#company_address').val(),
                    'company_city': $('#company_city').val(),
                    'company_phone': $('#company_phone').val(),
                    'company_vat': $('#company_vat').val(),
                    'companyemail': $('#companyemail').val(),
                    'president_name': $('#president_name').val(),
                    'siteurl': $('#siteurl').val(),
                    'number_armchairs': $("#number_armchairs").val(),
                    'agenda_code': $('#company_agendacode').val(),
                    'data': data,
                    'dplasma': dplasma,
                    'dpiastrine': dpiastrine,
                    'dsangue': dsangue,
                    'agendacoderefer': $('#idcompany_agendacoderefer').val(),
                },
                dataType: "JSON",
                success: function(data) {
                    $('#loading').hide();
                    if (data.msg == 'fail') {
                        clearscreen();
                        for (const key in data.aer) {
                            $("#error" + key).html(data.aer[key]);
                            $("#" + key).addClass("w3-border-red");
                            // Accedi al valore della proprietà
                        }
                        $('input[name="csrf_token"]').val(data.token);
                    }
                    if (data.msg == 'ok') {
                        $('#loading').hide();
                        clearscreen();
                        $('input[name="csrf_token"]').val(data.token);
                        $("#status").html(data.status);
                        $("#company_agendacode").val(data.agendacode);
                    }

                }
            });

        });
    });
</script>