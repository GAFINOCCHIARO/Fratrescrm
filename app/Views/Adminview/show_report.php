<!doctype html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- jQuery UI -->
    <title>Visualizza PDF</title>
    <script>
    </script>

</head>

<body>
    <?php
    echo csrf_field(); ?>
    <!--   <div class=" w3-col s12 m6 l4>-->
    <div class=" w3-section w3-animate-right">
        <div class="w3-container w3-section w3-margin-top">
            <div class="w3-bar w3-dark-grey w3-large w3-margin">
                <a href="<?php echo site_url('/AdminHome'); ?>" class=" w3-xxlarge w3-left" title="<?php echo lang('Auth.goadminmenu'); ?>" style="margin-left:25px; margin-top:8px;" onclick="$('#loading').show();">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="w3-container">

            <div class="w3-row-padding w3-margin"> <!-- inizio rigo input ricerca-->
                <div class="w3-half ">
                    <label for="clientcode"><?php echo lang('Auth.clientcode'); ?></label>
                    <input type="text" class="w3-input w3-border w3-round-xlarge" id="clientcode" name="clientcode" placeholder="<?php echo lang('Auth.clientcode'); ?>">
                </div>
                <div class="w3-half ">
                    <label for="taxcode"><?php echo lang('Auth.Tax_code'); ?></label>
                    <input type="text" class="w3-input  w3-border w3-round-xlarge" id="taxcode" name="taxcode" placeholder="<?php echo lang('Auth.Tax_code'); ?>">
                    <input type="hidden" id="taxcodefound" name="taxcodefound">
                    <input type="hidden" name="filename" id="filename" value="<?php echo esc($filename); ?>">
                    <input type="hidden" name="emailto" id="emailto" >
                </div>
            </div> <!-- fine rigo ricerca-->

            <div class="w3-row-padding w3-margin w3-half w3-leftbar w3-border-green"> <!--  inizio card risultato ricerca -->
                <ul class="w3-ul w3-card-4 w3-topbar w3-bottombar w3-border-blue" id="searchresult" style="display:none">
                    <span onclick="this.parentElement.style.display='none'" class="w3-bar-item w3-button w3-white w3-xlarge w3-right"> × </span>
                    <img src="" class="w3-bar-item w3-circle w3-hide-small" style="width:85px" id="avatarresult">
                    <!-- intestazione risultato dalla ricerca-->
                    <div class="w3-bar">
                        <span>
                            <p id="name_result"></p>
                            <p id="taxtcode_result"></p>
                            <p id="address_result"></p>
                            <p id="city_result"></p>
                            <p id="contact_result"></p>
                        </span>
                        <button class="w3-button w3-teal w3-round-large w3-hover-green" id="confirmed" onclick="$('#confirmedbox').show();"><?php echo lang('Auth.confirmedbox'); ?></button>
                        <button class="w3-button w3-teal w3-round-large w3-hover-yellow " id="sendamessagge"><?php echo lang('Auth.sendamessagge'); ?></button>
                        <button class="w3-button w3-teal w3-round-large w3-hover-amber" id="nextreport"><?php echo lang('Auth.nextreport'); ?></button>
                    </div>
                </ul>
            </div> <!-- fine    card risultato ricerca-->


            <!-- fine confirmed-->
            <!-- mostra report-->
              <iframe src="<?php echo $pdf; ?>" frameborder="0" width="100%" height="70%"></iframe>
           <!-- <embed src=>" type="application/pdf" width="100%" height="70%">-->
           
        </div>

        <div id="loading" class="w3-modal w3-white w3-opacity" style="display:none">
            <img class="w3-padding w3-display-middle" src="/assets/imgwait/loading.gif" alt="wait...." />
        </div>
        <div id="confirmedbox" class="w3-modal" style="display:none"><!-- box confirmed-->
            <div class="w3-modal-content">
                <header class="w3-container w3-dark-grey">
                    <span onclick="document.getElementById('confirmedbox').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <h2><?php echo lang('Auth.header_confirm_report'); ?></h2>
                </header>
                <div class="w3-container">
                    <div class="w3-row-padding ">
                        <label for="renamefile"><?php echo lang('Auth.rename_file'); ?></label>
                        <input type="text" name="renamefile" id="renamefile" class="w3-input w3-border w3-round-large" 
                               placeholder="<?php echo lang('Auth.help_rename_file'); ?>" title="<?php echo lang('Auth.explain_help_rename'); ?>">
                    </div>
                    <div class="w3-row-padding">
                        <label for="noteinpdf"><?php echo lang('Auth.textnoteinpdf'); ?></label>
                        <textarea name="noteinpdf" id="noteinpdf" class="w3-input w3-border w3-round-large"></textarea>
                         <p id="errornoteinpdf" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-row-padding">
                        <div class="w3-half">
                            <label for="donationdate"><?php echo lang('Auth.Donationdate'); ?></label>
                            <input type="date" name="donationdate" id="donationdate" class="w3-input w3-border w3-round-xlarge">
                             <p id="errordonationdate" class="w3-text-red"> </p>
                        </div>
                        <div class="w3-half">
                            <label for="danationtype"><?php echo lang('Auth.donationTypeLabel'); ?></label>
                            <select name="danationtype" id="danationtype" class="w3-select w3-border w3-round-xlarge">
                                <option value="0"><?php echo lang('Auth.select'); ?></option>
                                <option value="sangue"><?php echo lang('Auth.sangue');    ?></option>
                                <option value="plasma">   <?php echo lang('Auth.plasma');    ?></option>
                                <option value="piastrine"><?php echo lang('Auth.piastrine'); ?></option>
                            </select>
                            <p id="errordanationtype" class="w3-text-red"> </p>
                        </div>
                    </div>
                    <div class="w3-row-padding">
                        <div class="w3-half">
                            <label for="dresult"><?php echo lang('Auth.SelectEsito'); ?></label>
                            <select name="dresult" id="dresult" class="w3-select w3-border w3-round-xlarge" onchange='inputdaystop(this.value);'>
                                <option value="0"><?php echo lang('Auth.select'); ?></option>
                                <option value="ok"><?php echo lang('Auth.selectok'); ?></option>
                                <option value="ko"><?php echo lang('Auth.selectko'); ?></option>
                            </select>
                            <p id="errordresult" class="w3-text-red"> </p>
                        </div>
                        <div class="w3-half" id="daystopdiv" style="display: none;">
                            <label for="daystop"><?php echo lang('Auth.daystop'); ?></label>
                            <input type="number" name="daystop" id="daystop" class="w3-input w3-round-xlarge w3-border" placeholder="<?php echo lang('Auth.daystopPlaceholder'); ?>">
                            <p id="errordaystop" class="w3-text-red"></p>
                        </div>
                    </div>
                    <div class="w3-row-padding" id="stopnote" style="display: none;">
                    <label for="notestop"><?php echo lang('Auth.notestopLabel'); ?></label>
                     <input type="text" name="notestop" id="notestop" class="w3-input w3-round-xlarge w3-border" 
                                      placeholder="<?php echo lang('Auth.notestopPlaceholder'); ?>">
                       <p id="errornotestop" class="w3-text-red"> </p>
                    </div>
                    <button id="okreportisok" class="w3-green w3-round-large"><?php echo lang('Auth.okreportisok'); ?>
                    </button>
                </div>
                <footer class="w3-container w3-dark-grey">
                    <p><?php echo lang('Auth.footer_confirm_report'); ?></p>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    function clearscreen() {
        
        $("#errornoteinpdf").html("  ");
        $("#errordonationdate").html("  ");
        $("#errordanationtype").html("  ");
        $("#errordresult").html("  ");
        $("#errornotestop").html("  ");
        $("#errordaystop").html("  ");
       
        $("#noteinpdf").removeClass("w3-border-red");
        $("#donationdate").removeClass("w3-border-red");
        $("#danationtype").removeClass("w3-border-red");
        $("#dresult").removeClass("w3-border-red");
        $("#notestop").removeClass("w3-border-red");
        $("#daystop").removeClass("w3-border-red");
        
    }
    function inputdaystop(val) {
        if (val === 'ko') {
            $('#daystopdiv').show();
            $('#stopnote').show();
        } else {
            $('#daystop').val(0);
            $('#daystopdiv').hide();
            $('#stopnote').hide();
            clearscreen();
        }

    }
    $('#okreportisok').click(function(e) {
        e.preventDefault();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash
        var taxcodefound = $('#taxcodefound').val();
        var emailto = $('#emailto').val();
        var oldfilename = $('#filename').val();
        var renamefile = $('#renamefile').val();
        var noteinpdf = $('#noteinpdf').val();
        var donationdate = $('#donationdate').val();
        var danationtype = $('#danationtype').val();
        var dresult = $('#dresult').val();
        var daystop = $('#daystop').val();
         var notestop=$('#notestop').val();
        if ((renamefile === '') || (renamefile.length === 0) || (renamefile === null)) {
            var renamefile = oldfilename;
        }
       
       
        $.ajax({
            type: "post",
            url: "<?php echo site_url('movefile'); ?>",
            data: {
                newfile: renamefile,
                oldfilename: oldfilename,
                emailto: emailto,
                taxcodefound: taxcodefound,
                noteinpdf:noteinpdf,
                donationdate:donationdate,
                danationtype:danationtype,
                dresult:dresult,
                daystop:daystop,
                notestop: notestop,
                [csrfName]: csrfHash,
                typesearch: 2

            },
            dataType: "json",
            success: function(data) {
                $('input[name="csrf_token"]').val(data.token);
                 if (data.msg == 'fail') {
                    clearscreen();
                    for (const key in data.aer) {                          
                     $("#error" + key).html(data.aer[key]);
                      $("#" + key).addClass("w3-border-red");  // Accedo al valore della proprietà
                    }
                }else{
                     var csrfName = 'csrf_token'; // CSRF Token name
                      var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 

                      $.ajax({
                          type: "post",
                          url: "<?php echo site_url('Managereportview'); ?>",
                         data: {
                                [csrfName]: csrfHash,
                               },
                               dataType: "html",
                               success: function(data) {
                               $('#loading').hide();
                               $('#main').html(data)
                               }
                        });
                     }
        }

        });


    });
    $('#clientcode').keypress(function(e) {
        let clientcode = $('#clientcode').val();
        if (clientcode.length + 1 == 6) {
            var csrfName = 'csrf_token'; // CSRF Token name
            var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash
            $('#loading').show();
            $.ajax({
                type: "post",
                url: "<?php echo site_url('EditUser'); ?>",
                data: {
                    id: clientcode + e.key,
                    [csrfName]: csrfHash,
                    typesearch: 2
                },
                dataType: "json",
                success: function(data) {
                    $('#loading').hide();
                    $('#searchresult').show();
                    if (!data.useredit.user.isuserfind) {
                        $('#name_result').html(data.useredit.user.erromsg);
                    } else {
                        $('#name_result').html(data.useredit.user.first_name + ' ' + data.useredit
                            .user.surname + ' ' + data.useredit.user.Tax_code);
                    }
                    $('#taxcodefound').val(data.useredit.user.Tax_code);
                    $('#emailto').val(data.useredit.user.email);
                    $('#address_result').html(data.useredit.user.address);
                    $('#city_result').html(data.useredit.user.zip_code + ' ' + data.useredit
                        .user.City_of_residence);
                    $('#contact_result').html(data.useredit.user.phone_number + ' ' + data
                        .useredit.user.email);
                    $("#avatarresult").attr("src", data.useredit.user.avatar);
                    $('input[name="csrf_token"]').val(data.useredit.token);

                }
            });

        }

    });
</script>

</html>