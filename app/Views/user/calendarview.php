<?php echo csrf_field(); ?>
<div class="w3-container">
    <h2 class="w3-center">Appuntamenti Donazione Sangue</h2>

    <?php if(!empty($appuntamenti)): ?>
    <div class="w3-row-padding">
        <?php foreach ($appuntamenti as $appuntamento): ?>
        <div class="w3-col s12 m4 l3 xl2 xxl1 w3-margin-bottom">
            <div class="w3-card-4">
                <header class="w3-container w3-light-grey">
                    <h3><?=$appuntamento->day.' '.$appuntamento->date; // Giorno della settimana ?></h3>
                </header>
                <div class="w3-container">


                    <p><strong>Luogo:</strong> <?= $appuntamento->place; ?></p>
                </div>
                <footer class="w3-container w3-light-grey">
                    <button class="w3-button w3-block w3-red"
                        onclick="showform('<?php echo $appuntamento->date; ?>', '<?php echo $appuntamento->day; ?>', '<?php echo $appuntamento->type; ?>')">Prenota</button>
                </footer>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p class="w3-center">Non ci sono appuntamenti disponibili.</p>
    <?php endif; ?>
    <div id="formbooknodal" class="w3-modal">
        <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-blue">
                <span onclick="document.getElementById('formbooknodal').style.display='none'"
                    class="w3-button w3-display-topright">&times;</span>
                <h2> <?php echo lang('Auth.bookdonation'); ?></h2>

            </header>
            <div class="w3-row w3-container">
                <h6>
                    <span><?php echo lang('Auth.bookdonation'); ?></span>
                    <span id="dateofappointment"></span>
                </h6>

            </div>
            <input type="text" name="day" id="day" hidden>
            <input type="text" name="type" id="type" hidden>
            <input type="text" name="dateday" id="dateday" hidden>

            <div class="w3-row">
                <label for="timeslot"><?php echo lang('Auth.timeSlot');?></label>
                <select class="w3-select w3-border w3-round-xlarge" id="timeslot" onchange="resetselect()">
                </select>

                <label for="exsamselector"><?php echo lang('Auth.donationTypeLabel');?></label>
                <select class="w3-select w3-border w3-round-xlarge" id="exsamselector" onchange="showhours()">
                </select>

                <label for="timeexsam"><?php echo lang('Auth.choosetime'); ?></label>
                <select class="w3-select w3-border w3-round-xlarge" id="timeexsam" onchange="showButton()">
                </select>
          <div class="w3-row">
                <label for="textesam"><?php echo lang('Auth.userNote');?></label>
                <textarea name="note" id="note" class="w3-input w3-border w3-round-xlarge" rows="4" cols="50" placeholder="<?php echo lang('Auth.noteDonationFomrplaceholder');?>"></textarea>
            </div>



            </div>
            <div class="w3-row id=" saverowbotton">
                <button class="w3-btn w3-xxlarge" id="saveappointment" style="float: right;" disabled><i
                        class="fa fa-save" aria-hidden="true"></i></button>
            </div>

            <footer class="w3-container w3-blue">
                <p><?php echo lang('Auth.footerprenota'); ?></p>
            </footer>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#saveappointment').click(function (e) { 
        e.preventDefault();
        let exam_type = document.querySelector('#exsamselector').value;
        let timeRange = document.querySelector('#timeslot').value;
        let timeexsam = document.querySelector('#timeexsam').value
        let note = $('#note').val();
        let day = $('#dateday').val()
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('saveappointment'); ?>",
            data: {
                 exam_type : exam_type,
                 timeexsam : timeexsam,
                      day  : day,
                      note : note,
                 [csrfName]: csrfHash,
            },
            dataType: "json",
            success: function (response) {
                 $('input[name="csrf_token"]').val(response.token);
                 if(response.msg=='fail'){
                    alert(response.listerror);
                 }
                 if (response.msg==200){
                    alert(response.okmsg);
                    document.getElementById('formbooknodal').style.display = 'none';
                 }
                 }               
        });

        
    });
});
        function resetselect() {
            $('#exsamselector').val('0');
              $('#timeexsam').val('0');
        }

        function showhours() {
          let exam_type = document.querySelector('#exsamselector').value;
          let timeRange = document.querySelector('#timeslot').value;
          let day = $('#dateday').val()
          $('#timeexsam').val('0');
          var csrfName = 'csrf_token'; // CSRF Token name
          var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash
            $.ajax({
                url: "<?php echo site_url('showtime'); ?>",
                type: 'post',
                dataType: "json",
                data: {
                    'exam_type': exam_type,
                    'date': day,
                    'timeRange': timeRange,
                    [csrfName]: csrfHash, // CSRF Token
                },
                success: function(response) {
                    console.log(response);
                    $('input[name="csrf_token"]').val(response.token);
                    // Dati per la select 'timeslot'
                    var timeexsamval = response; // Array di fasce orarie
                    var timeexsam = $('#timeexsam');
                    timeexsam.empty(); // Svuota la select esistente
                    timeexsam.append('<option value="0"> scegli-- </option>');
                    $.each(timeexsamval.time, function(index, value) {
                        timeexsam.append('<option value="' + value + '">' + value + '</option>');
                    });
                    
                },
                error: function(xhr, status, error) {
                  //  $('input[name="csrf_token"]').val(response.token);
                    console.error(xhr.responseText);
                    alert('Errore durante il caricamento dei dati.');
                }



            });

        }

        function showButton() {
         $('#saveappointment').removeAttr('disabled');
        }

        function showform(daydate, day, type) {
            document.getElementById('formbooknodal').style.display = 'block';
            $('#dateofappointment').html(daydate);
            $('#dateday').val(daydate);
            $('#day').val(day);
            $('#type').val(type);
            console.log(day+''+type);
            var csrfName = 'csrf_token'; // CSRF Token name
            var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash
            $.ajax({
                url: "<?php echo site_url('slot_time'); ?>", //  l'URL  endpoint 
                type: 'POST',
                data: {
                    'type': type,
                    'day': day,
                    [csrfName]: csrfHash, // CSRF Token
                },
                success: function(response) {
                    $('input[name="csrf_token"]').val(response.token);
                    // Dati per la select 'timeslot'
                    var timeslots = response.timeslots; // Array di fasce orarie
                    var timeslotSelect = $('#timeslot');
                    timeslotSelect.empty(); // Svuota la select esistente
                    timeslotSelect.append('<option value="100"> scegli-- </option>');
                    $.each(timeslots, function(index, value) {
                        if (value !== 0 && value !== null && value !== '')  {
                            timeslotSelect.append('<option value="' + value + '">' + index + '  orario ' +
                                value + '</option>');
                        }
                    });

                    // Dati per la select 'exsamselector'
                    var exams = response.exams; // Array di tipi di esame
                    var examSelect = $('#exsamselector');
                    examSelect.empty(); // Svuota la select esistente
                    examSelect.append('<option value="0"> scegli-- </option>');
                    $.each(exams, function(index, data) {
                        // Uso l'etichetta tradotta ricevuta dal backend
                        examSelect.append('<option value="' + index + '">' + data.label + '</option>');
                    });

                },
                error: function(xhr, status, error) {
                    $('input[name="csrf_token"]').val(data.token);
                    console.error(xhr.responseText);
                    alert('Errore durante il caricamento dei dati.');
            }
        });



        }

</script>