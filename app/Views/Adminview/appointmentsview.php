<!DOCTYPE html>
<html lang="en">

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
        <fieldset>
            <legend><?php echo lang('Auth.appointments_fieldset'); ?></legend>

            <div class="w3-bar w3-black w3-hide-small">
                <!-- start tabs in screnn-->
                <button class="w3-bar-item w3-button tablink w3-red"
                    onclick="openTab(event,'confrimappoint')"><?php echo lang('Auth.listofappointment'); ?></button>
                <button class="w3-bar-item w3-button tablink"
                    onclick="openTab(event,'repetitiveday')"><?php echo lang('Auth.repetitivedate'); ?></button>
                <button class="w3-bar-item w3-button tablink"
                    onclick="openTab(event,'dayappointment')"><?php echo lang('Auth.insertdateappointiment'); ?></button>
            </div><!-- end tabs in screnn-->
            <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium"
                onclick="w3_opentabmenu()"><i class="fa fa-bars"></i> </a>
            <!-- Sidebar on small screens when clicking the menu icon -->
            <nav class="w3-sidebar w3-bar-block w3-black w3-card w3-animate-left w3-hide-medium w3-hide-large"
                style="display:none" id="mySidebar">
                <a href="javascript:void(0)" onclick="closetab()"
                    class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>
                <a href="" onclick="openTab(event,'confrimappoint')"
                    class="w3-bar-item w3-button"><?php echo lang('Auth.Datauser'); ?></a>
                <a href="" onclick="openTab(event,'repetitiveday')"
                    class="w3-bar-item w3-button"><?php echo lang('Auth.UserExsam'); ?></a>
                <a href="" onclick="openTab(event,'dayappointment')"
                    class="w3-bar-item w3-button"><?php echo lang('Auth.userNote'); ?></a>
            </nav>

            <div class="w3-row-padding w3-container tabuser" id="confrimappoint">
            </div>
            <div class="w3-row-padding w3-container tabuser" id="repetitiveday" style="display:none">
                <div id="buttonpannel" class="w3-row-paddingw3-conntainer">
                    <button class="w3-btn w3-xxlarge" id="repetitiveDays" style="float: right;"><i
                            class="fa fa-save" aria-hidden="true"></i></button>
                    <h3>
                        <p id="status" class="w3-text-red"> </p>
                    </h3>
                </div>
                <!-- begin row business_name  e group_name form input-->
                <div class="w3-row-padding w3-container">
                    <div class="w3-half  ">
                        <!--  row business_name-->
                        <label for="company_name"><?php echo lang('Auth.business_name'); ?></label>
                        <p class="w3-input w3-border w3-round-xlarge" id="company_name">
                            <?php echo esc($companydata->company_name); ?>
                        </p>
                    </div>
                    <div class="w3-half">
                        <!-- group_name form -->
                        <label for="group_name"><?php echo lang('Auth.group_name'); ?></label>
                        <p class="w3-input w3-border w3-round-xlarge" id="group_name">
                            <?php echo esc($companydata->company_group); ?></p>
                    </div>
                </div>
                <div class="w3-row-padding w3-container">
                    <!-- begin row company_address   e company_city form input-->
                    <div class="w3-half">
                        <!-- company_address -->
                        <label for="company_address"><?php echo lang('Auth.business_address'); ?></label>
                        <p class="w3-input w3-border  w3-round-xlarge" id="company_address">
                            <?php echo esc($companydata->company_address); ?>"
                        </p>
                    </div>
                    <div class="w3-half">
                        <!-- company_city -->
                        <label for="company_city"><?php echo lang('Auth.company_city'); ?></label>
                        <p class="w3-input w3-border  w3-round-xlarge" id="company_city">
                            <?php echo esc($companydata->company_city); ?>
                        </p>
                    </div>
                </div> <!-- end   row company_address   e company_city form input-->
                <!-- end   row business_name  e group_name form input-->
                <table class="w3-table w3-bordered">
                    <thead>
                        <tr>
                            <th><?php echo lang('Auth.weekday'); ?></th>
                            <th><?php echo lang('Auth.strattime'); ?></th>
                            <th><?php echo lang('Auth.endtime'); ?></th>
                            <th><?php echo lang('Auth.strattime'); ?></th>
                            <th><?php echo lang('Auth.endtime'); ?></th>
                            <th><?php echo lang('Auth.checkdonationday'); ?></th>
                            <th><?php echo lang('Auth.visibility'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataWorkingHours as $bh) {
                            $day = trim($bh->day_of_week);
                            // Inizializzazione dei valori di default
                            $morning_open_time = $bh->open_time1;
                            $morning_close_time = $bh->close_time1;
                            $isdonationday = '';
                            $isvisible = '';
                            $morning_seat = $companydata->number_armchairs;

                            $afternoon_open_time = $bh->open_time2;
                            $afternoon_close_time = $bh->close_time2;
                            $afternoon_check = '';
                            $afternoon_seat = $companydata->number_armchairs;

                            // Cerca dati ripetitivi per il giorno corrente
                            foreach ($repetitiveappoint as $rep) {
                                if (trim($rep->day_of_week_appointment) == $day) {
                                    // Dati per la sessione mattutina
                                    if (!empty($rep->morning_open_time)) {
                                        $morning_open_time =  $rep->morning_open_time;
                                        $morning_close_time = $rep->morning_close_time;
                                        $isdonationday = 'checked';
                                    } else {
                                        $morning_open_time =  '';
                                        $morning_close_time = '';
                                        $isdonationday = 'checked';
                                    }
                                    // Dati per la sessione pomeridiana
                                    if (!empty($rep->afternoon_open_time)) {
                                        $afternoon_open_time = $rep->afternoon_open_time;
                                        $afternoon_close_time = $rep->afternoon_close_time;
                                        $isdonationday = 'checked';
                                    } else {
                                        $afternoon_open_time = '';
                                        $afternoon_close_time = '';
                                        $isdonationday = 'checked';
                                    }
                                    if (($rep->company_agenda_code != 0) || ($rep->company_agenda_code !== '0')) {
                                        $isvisible = 'checked';
                                    }
                                    break; // Interrompe il ciclo una volta trovati i dati per il giorno corrente
                                }
                            }
                        ?>
                            <tr>
                                <td><?php echo esc($bh->day_of_week); ?></td>
                                <td>
                                    <input type="time" class="w3-input w3-border w3-round-xlarge"
                                        name="open_time1[<?php echo esc($bh->day_of_week); ?>]"
                                        value="<?php echo esc($morning_open_time); ?>">
                                </td>
                                <td>
                                    <input type="time" class="w3-input w3-border w3-round-xlarge"
                                        name="close_time1[<?php echo esc($bh->day_of_week); ?>]"
                                        value="<?php echo esc($morning_close_time); ?>">
                                </td>
                                <td>
                                    <input type="time" class="w3-input w3-border w3-round-xlarge"
                                        name="open_time2[<?php echo esc($bh->day_of_week); ?>]"
                                        value="<?php echo esc($afternoon_open_time); ?>">
                                </td>
                                <td>
                                    <input type="time" class="w3-input w3-border w3-round-xlarge"
                                        name="close_time2[<?php echo esc($bh->day_of_week); ?>]"
                                        value="<?php echo esc($afternoon_close_time); ?>">
                                </td>
                                <td>
                                    <input type="checkbox"
                                        name="CheckIfISadaonationday[<?php echo esc($bh->day_of_week); ?>]"
                                        id="CheckIfISadaonationday<?php echo esc($bh->day_of_week); ?>" class="w3-check"
                                        <?php echo $isdonationday; ?>>
                                </td>
                                <td>
                                    <input type="checkbox" name="visibility[<?php echo esc($bh->day_of_week); ?>]"
                                        id="visibility<?php echo esc($bh->day_of_week); ?>" class="w3-check"
                                        <?php echo $isvisible; ?>>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="w3-row-padding w3-container tabuser" id="dayappointment" style="display:none">
                <div id="container_table" class="w3-container"
                    style="height: 300px; width:auto; overflow-y: scroll;">
                    <table class="w3-table w3-bordered" id="listappointment">
                        <thead>
                            <tr>
                                <th><?php echo lang('Auth.EventDate'); ?></th>
                                <th><?php echo lang('Auth.StartTime'); ?></th>
                                <th><?php echo lang('Auth.EndTime'); ?></th>
                                <th><?php echo lang('Auth.EventPlace'); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($eventlist as $event) { ?>
                                <tr id='row<?php echo $event->id_eventcalendar; ?>'>
                                    <td><?php echo esc($event->day_event); ?></td>
                                    <td><?php echo esc($event->start_time); ?></td>
                                    <td><?php echo esc($event->end_time); ?></td>
                                    <td><?php echo esc($event->place_event); ?></td>
                                    <td><button onclick="delvent(<?php echo($event->id_eventcalendar); ?>)" class="w3-btn"> <i class="fa fa-trash" aria-hidden="true"></i></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="w3-container" id="forminput">
                    <div class="w3-row">
                        <div class="w3-quarter">
                            <label for="DateEvent"><?php echo lang('Auth.EventDate'); ?></label>
                            <input type="date" name="DateEvent" id="DateEvent"
                                class="w3-input w3-border w3-round-xlarge">
                        </div>
                        <div class="w3-quarter ">
                            <label for="StartTime"><?php echo lang('Auth.StartTime'); ?></label>
                            <input type="time" name="StartTime" id="StartTime"
                                class="w3-input w3-border w3-round-xlarge">
                        </div>
                        <div class="w3-quarter  ">
                            <label for="EndTime"><?php echo lang('Auth.EndTime'); ?></label>
                            <input type="time" name="EndTime" id="EndTime"
                                class="w3-input w3-border w3-round-xlarge">
                        </div>
                    </div>
                    <div>
                        <div class="w3-half">
                            <label for="PlaceEvent"><?php echo lang('Auth.EventPlace'); ?></label>
                            <input type="text" name="PlaceEvent" id="PlaceEvent"
                                class="w3-input w3-border w3-round-xlarge">
                        </div>
                        <div class="w3-half" style="float: right; margin-top: 15px;">
                            <button class="w3-btn w3-xxlarge" id="addeventday">
                                <i class="fa fa-save" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</body>

</html>


<script>
    function openTab(evt, Name) {
        var i, x, tablinks;
        x = document.getElementsByClassName("tabuser");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
        }
        document.getElementById(Name).style.display = "block";
        evt.currentTarget.className += " w3-red";
    }

    var mySidebar = document.getElementById("mySidebar");

    function w3_opentabmenu() {
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
        } else {
            mySidebar.style.display = 'block';
        }
    }

    // Close the sidebar with the close button
    function closetab() {
        mySidebar.style.display = "none";
    }

    function delvent(id) {
        var csrfName = 'csrf_token'; // Nome del token CSRF
        var csrfHash = $('input[name="csrf_token"]').val();
        $('#loading').show();
        $.ajax({
            type: "post",
            url: "<?php echo site_url('delevent'); ?>",
            data: {
                [csrfName]: csrfHash,
                'id': id,
            },
            dataType: "json",
            success: function(response) {
                $('#loading').hide();
                 $('input[name="csrf_token"]').val(response.token);
                if(response.msg=='ok'){
                $('#row'+ response.id).remove();
                }
                if(response.msg=='fail'){
                    alert('errore del');
                }
            }
        });
    }

    function formatDateToItalian(dateString) {
        var date = new Date(dateString);
        var day = ('0' + date.getDate()).slice(-2);
        var month = ('0' + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();
        return day + '/' + month + '/' + year; // Formatta come d/m/Y
    }

    $(document).ready(function() {
        $('#repetitiveDays').click(function(e) {
            e.preventDefault();
            $("#status").html("");
            $('#loading').show();
            var csrfName = 'csrf_token'; // Nome del token CSRF
            var csrfHash = $('input[name="csrf_token"]').val();
            var data = {}; // Inizializza l'oggetto data per raccogliere le informazioni

            // Itera su ciascun checkbox per verificare i giorni selezionati
            $('input[type="checkbox"]').each(function() {
                var day = $(this).attr('name').match(/\[(.*?)\]/)[
                    1]; // Estrae il giorno della settimana dalla chiave
                var checkboxType = $(this).attr('name').split('[')[
                    0]; // Estrae il tipo di checkbox (es. CheckIfISadaonationday, visibility)

                // Inizializza l'oggetto per il giorno se non è già presente
                if (!data[day]) {
                    data[day] = {};
                }

                // Se la checkbox è selezionata
                if ($(this).is(":checked")) {
                    // Se è il giorno di donazione
                    if (checkboxType === 'CheckIfISadaonationday') {
                        // Flag giorno di donazione
                        data[day][checkboxType] = true;

                        const isValidTimePair = (openTime, closeTime) => {
                            // Se uno è null e l'altro no, o se sono uguali ma non entrambi null, errore
                            return !((openTime === null) !== (closeTime === null) || (openTime !== null && openTime === closeTime));
                        };



                        // Recupera gli orari e il numero di sedili se il giorno è di donazione
                        data[day]['open_time1'] = $('input[name="open_time1[' + day + ']"]')
                            .val() || null;
                        data[day]['close_time1'] = $('input[name="close_time1[' + day + ']"]')
                            .val() || null;
                        // Verifica se gli orari del mattino sono validi
                        if (!isValidTimePair(data[day]['open_time1'], data[day]['close_time1'])) {
                            alert(`Errore: Orari del mattino non validi per il giorno ${day}`);
                            $('#loading').hide();
                            return; // Interrompe il ciclo in caso di errore
                        }


                        data[day]['open_time2'] = $('input[name="open_time2[' + day + ']"]')
                            .val() || null;
                        data[day]['close_time2'] = $('input[name="close_time2[' + day + ']"]')
                            .val() || null;
                        // Verifica se gli orari del pomeriggio sono validi
                        if (!isValidTimePair(data[day]['open_time2'], data[day]['close_time2'])) {
                            alert(`Errore: Orari del pomeriggio non validi per il giorno ${day}`);
                            $('#loading').hide();
                            return; // Interrompe il ciclo in caso di errore
                        }
                        data[day]['isadaonationday'] = 1;
                        // Se anche il checkbox "visibility" è selezionato, salviamo la visibilità
                        data[day]['visibility'] = $('input[name="visibility[' + day + ']"]').is(
                            ':checked');
                    }
                }
            });
            $.ajax({
                type: "post",
                url: "<?php echo site_url('insertRepetitiveDays'); ?>",
                data: {
                    [csrfName]: csrfHash,
                    'data': data,
                },
                dataType: "json",
                success: function(data) {
                    if (data.msg == 'ok') {
                        $('#loading').hide();
                        $('input[name="csrf_token"]').val(data.token);
                        $("#status").html(data.status);
                    }
                }
            });
        });
        $('#addeventday').click(function(e) {
            e.preventDefault();
            var csrfName = 'csrf_token'; // Nome del token CSRF
            var csrfHash = $('input[name="csrf_token"]').val();
            $.ajax({
                type: "post",
                url: "<?php echo site_url('addevent'); ?>",
                data: {
                    [csrfName]: csrfHash,
                    'eventdata': $('#DateEvent').val(),
                    'timestart': $('#StartTime').val(),
                    'timeend': $('#EndTime').val(),
                    'placeevent': $('#PlaceEvent').val(),
                },
                dataType: "json",
                success: function(response) {
                    $('input[name="csrf_token"]').val(response.token);
                    $('#listappointment > tbody:last-child').append(
                        '<tr>' +
                        '<td>' + formatDateToItalian(response.record.day_event) + '</td>' +
                        '<td>' + response.record.start_time + '</td>' +
                        '<td>' + response.record.end_time + '</td>' +
                        '<td>' + response.record.place_event + '</td>' +
                        '<td> <button class="w3-btn"><i class="fa fa-trash" aria-hidden="true"></i></button> </td> </tr>'
                    );
                    $('#DateEvent').val('');
                    $('#StartTime').val('');
                    $('#EndTime').val('');
                    $('#PlaceEvent').val('');
                }
            });

        });
    });
</script>