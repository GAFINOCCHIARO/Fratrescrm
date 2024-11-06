<!DOCTYPE html>
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
    <div class=" w3-section w3-animate-right">
        <div class="w3-container w3-section w3-margin-top">
            <!-- begin comand menu edit user-->
            <div class="w3-bar w3-dark-grey w3-large w3-margin">
                <a href="<?php echo site_url('/AdminHome'); ?>" class=" w3-xxlarge w3-left" title="<?php echo lang('Auth.goadminmenu'); ?>" style="margin-left:25px; margin-top:8px;" onclick="$('#loading').show();">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </a>
            </div> <!-- end menu edit user-->
            <div id="datauser" class="w3-container w3-border tabuser">
                <form id="formuser">
                    <input type="hidden" name="avatar" id="avatarimg" value="/assets/avatar/avatar_default.jpg">
                    <input type="hidden" name="idassociation" id="id" value="<?php echo $association; ?>">
                    <fieldset>
                        <a href="" id="save" class=" w3-xxlarge w3-right" title="<?php echo lang('Auth.updateuser'); ?>" style="margin-left:15px;margin-top:8px;">
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </a>
                        <!-- begin row Username  e name form input-->
                        <div class="w3-row">
                            <div class="w3-half w3-container">
                                <!-- Username -->
                                <label for="first_name"><?php echo lang('Auth.first_name'); ?></label>
                                <input type="text" class="w3-input w3-border w3-round-xlarge" id="first_name" name="first_name" inputmode="text" autocomplete="first_name" placeholder="<?php echo lang('Auth.first_name'); ?>" value="" required />
                                <p id="errorfirst_name" class="w3-text-red"> </p>
                            </div> <!-- end username-->
                            <div class="w3-half w3-container">
                                <!-- surname-->
                                <label for="surname"><?php echo lang('Auth.surname'); ?></label>
                                <input type="text" class="w3-input w3-border w3-round-xlarge" id="surname" name="surname" inputmode="text" autocomplete="surname" placeholder="<?php echo lang('Auth.surnameplacehoder'); ?>" value="" required />
                                <p id="errorsurname" class="w3-text-red"> </p>
                            </div> <!-- end surname-->
                        </div>
                        <!-- end Username  e name form input-->
                        <!-- Begin group blod  row-->
                        <div class="w3-container w3-padding w3-margin-top"">
                        <fieldset>
                          <legend><?php echo lang('Auth.bloodfiledset'); ?></legend>
                          <div class=" w3-row">
                            <div class="w3-quarter w3-container">
                                <label for="birth_place"><?php echo lang('Auth.group_type'); ?></label>
                                <input type="text" class="w3-input w3-border w3-round-xlarge" id="group_type" name="group_type" inputmode="group_type" autocomplete="group_type" placeholder="<?php echo lang('Auth.group_type'); ?>" value="" required />
                                <p id="errorgroup_type" class="w3-text-red"> </p>
                            </div>
                            <div class="w3-quarter w3-container">
                                <label for="birth_place"><?php echo lang('Auth.rh_factor'); ?></label>
                                <input type="text" class="w3-input w3-border w3-round-xlarge" id="rh_factor" name="rh_factor" inputmode="birth_place" autocomplete="rh_factor" placeholder="<?php echo lang('Auth.rh_factor'); ?>" value="" required />
                                <p id="errorrh_factor" class="w3-text-red"> </p>
                            </div>
                            <div class="w3-quarter w3-container">
                                <label for="birth_place"><?php echo lang('Auth.phenotype'); ?></label>
                                <input type="text" class="w3-input w3-border w3-round-xlarge" id="phenotype" name="phenotype" inputmode="phenotype" autocomplete="phenotype" placeholder="<?php echo lang('Auth.phenotype'); ?>" value="" required />
                                <p id="errorphenotype" class="w3-text-red"> </p>
                            </div>
                            <div class="w3-quarter w3-container">
                                <label for="birth_place"><?php echo lang('Auth.kell'); ?></label>
                                <input type="text" class="w3-input w3-border w3-round-xlarge" id="kell" name="kell" inputmode="kell" autocomplete="kell" placeholder="<?php echo lang('Auth.kell'); ?>" value="" required />
                                <p id="errorkell" class="w3-text-red"> </p>
                            </div>
                        </div>
                    </fieldset>
            </div>
            <!-- End group blod  row-->
            <!-- Begin row ' birth_place County_of_birth zip_codebirth  date_of_birth birth_status document type tax number '   ,form input  -->
            <div class="w3-container w3-padding w3-margin-top" id="daticliente">
                <fieldset>
                    <legend>Dati Anadrafici:</legend>
                    <div class="w3-row  ">
                        <!-- birth_place  citta di nascita-->
                        <div class="w3-fifth w3-container">
                            <label for="birth_place"><?php echo lang('Auth.birth_place'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="birth_place" name="birth_place" inputmode="birth_place" autocomplete="birth_place" placeholder="<?php echo lang('Auth.birth_place'); ?>" value="" required />
                            <p id="errorbirth_place" class="w3-text-red"> </p>
                        </div>
                        <!-- County_of_birth  paese di nascita-->
                        <div class="w3-fifth w3-container">
                            <label for="County_of_birth"><?php echo lang('Auth.County_of_birth'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="County_of_birth" name="County_of_birth" inputmode="County_of_birth" autocomplete="County_of_birth" placeholder="<?php echo lang('Auth.County_of_birth'); ?>" value="" required />
                            <p id="errorCounty_of_birth" class="w3-text-red"> </p>
                        </div>
                        <!-- zip code birth-->
                        <div class="w3-fifth w3-container">
                            <label for="zip_codebirth"><?php echo lang('Auth.zip_codebirth'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="zip_codebirth" name="zip_codebirth" inputmode="text" autocomplete="zip_codebirth" placeholder="<?php echo lang('Auth.zip_codebirth'); ?>" value="" required />
                            <p id="errorzip_codebirth" class="w3-text-red"> </p>
                        </div>
                        <!-- birth_status nazione di nascita-->
                        <div class="w3-fifth w3-container">
                            <label for="birth_status"><?php echo lang('Auth.birth_status'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="birth_status" name="birth_status" inputmode="birth_status" autocomplete="birth_status" placeholder="<?php echo lang('Auth.birth_status'); ?>" value="" required />
                            <p id="errorbirth_status" class="w3-text-red"> </p>
                        </div>
                        <!--gender  type -->
                        <div class="w3-fifth w3-container">
                            <label for="gender"><?php echo lang('Auth.gender'); ?></label>
                            <select name="gender" id="gender" class="w3-select w3-border w3-round-xlarge">
                                <option value="0"><?php echo lang('Auth.select'); ?></option>
                                <option value="M"> <?php echo lang('Auth.maschio'); ?> </option>
                                <option value="F"><?php echo lang('Auth.femmina'); ?> </option>
                            </select>
                            <p id="errorgender" class="w3-text-red"> </p>
                        </div>
                    </div>
                    <div class="w3-row w3-margin-bottom">
                        <div class="w3-quarter w3-container">
                            <!-- date_of_birth -->
                            <label for="date_of_birth"><?php echo lang('Auth.date_of_birth'); ?></label>
                            <input type="date" class="w3-input w3-border w3-round-xlarge" id="date_of_birth" name="date_of_birth" inputmode="date_of_birth" autocomplete="date_of_birth" placeholder="<?php echo lang('Auth.date_of_birth'); ?>" value="" required />
                            <p id="errordate_of_birth" class="w3-text-red"> </p>
                        </div>
                        <div class="w3-quarter w3-container">
                            <!-- document type select-->
                            <label for="document_type"><?php echo lang('Auth.document_type'); ?></label>
                            <select name="document_type" id="document_type" class="w3-select w3-border w3-round-xlarge">
                                <option value="0">Scegli----</option>
                                <option value="Carta identità">Carta d'identità</option>
                                <option value="Patente"> Patente</option>
                                <option value="Passaporto"> Passaporto</option>
                            </select>
                            <p id="errordocument_type" class="w3-text-red"> </p>
                        </div>
                        <div class="w3-quarter w3-container">
                            <!--document number -->
                            <label for="document_number"><?php echo lang('Auth.document_number'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="document_number" name="document_number" inputmode="text" autocomplete="document_number" placeholder="<?php echo lang('Auth.document_number'); ?>" value="" required />
                            <p id="errordocument_number" class="w3-text-red"> </p>
                        </div>
                        <div class="w3-quarter w3-container">
                            <!--tax number -->
                            <label for="Tax_code"><?php echo lang('Auth.Tax_code'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="Tax_code" name="Tax_code" inputmode="text" autocomplete="Tax_code" placeholder="<?php echo lang('Auth.Tax_code'); ?>" value="" required />
                            <p id="errorTax_code" class="w3-text-red"> </p>
                        </div>
                    </div>
                </fieldset>
            </div>
            <!-- end row ' birth_place County_of_birth zip_codebirth  date_of_birth birth_status document type tax number ' ,form input  -->

            <div class="w3-row w3-padding w3-margin-top">
                <!-- Begin row form input 'address''City_of_residence','Province_of_residence', 'zip_code' -->
                <fieldset>
                    <legend>Dati residenza</legend>
                    <div class="w3-fifth w3-container">
                        <!-- City_of_residence-->
                        <label for="City_of_residence"><?php echo lang('Auth.City_of_residence'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="City_of_residence" name="City_of_residence" inputmode="text" autocomplete="City_of_residence" placeholder="<?php echo lang('Auth.City_of_residence'); ?>" value="" required />
                        <p id="errorCity_of_residence" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-fifth w3-container">
                        <!-- Province_of_residence-->
                        <label for="Province_of_residence"><?php echo lang('Auth.Province_of_residence'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="Province_of_residence" name="Province_of_residence" inputmode="text" autocomplete="Province_of_residence" placeholder="<?php echo lang('Auth.Province_of_residence'); ?>" value="" required />
                        <p id="errorProvince_of_residence" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-fifth w3-container">
                        <!-- zip code-->
                        <label for="zip_code"><?php echo lang('Auth.zip_code'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="zip_code" name="zip_code" inputmode="text" autocomplete="zip_code" placeholder="<?php echo lang('Auth.zip_code'); ?>" value="" required />
                        <p id="errorzip_code" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-fifth w3-container">
                        <!--  state_of_residence-->
                        <label for="state_of_residence"><?php echo lang('Auth.state_of_residence'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="state_of_residence" name="state_of_residence" inputmode="text" autocomplete="state_of_residence" placeholder="<?php echo lang('Auth.state_of_residence'); ?>" value="" required />
                        <p id="errorstate_of_residence" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-fifth w3-container">
                        <!-- addres-->
                        <label for="address"><?php echo lang('Auth.address'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="address" name="address" inputmode="text" autocomplete="address" placeholder="<?php echo lang('Auth.address'); ?>" value="" required />
                        <p id="erroraddress" class="w3-text-red"> </p>
                    </div>
                </fieldset>
            </div> <!--  end row form input 'address''City_of_residence','Province_of_residence','zip_code' -->

            <!-- Begin row 'phone_number', email,form input  -->
            <div class="w3-row">
                <div class="w3-half w3-container">
                    <!-- email -->
                    <label for="mail"><?php echo lang('Auth.email'); ?></label>
                    <input type="email" class="w3-input w3-border w3-round-xlarge" id="mail" name="email" inputmode="email" autocomplete="email" placeholder="<?php echo lang('Auth.email'); ?>" value="" required />
                    <p id="errormail" class="w3-text-red"> </p>
                </div>
                <div class="w3-half w3-container">
                    <!-- phone_number -->
                    <label for="phone_number"><?php echo lang('Auth.phone_number'); ?></label>
                    <input type="tel" class="w3-input w3-border w3-round-xlarge" id="phone_number" name="phone_number" inputmode="phone_number" autocomplete="phone_number" placeholder="<?php echo lang('Auth.phone_number'); ?>" value="" required />
                    <p id="errorphone_number" class="w3-text-red"> </p>
                </div>
            </div>
            </form>
        </div> <!-- end menu edid user -->
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#save').click(function(e) {
            e.preventDefault();
            $('#loading').show();
            var avatar = $('#avatarimg').val();
            var id = $('#id').val();
            var first_name = $('#first_name').val();
            var surname = $('#surname').val();
            var birth_place = $('#birth_place').val();
            var County_of_birth = $('#County_of_birth').val();
            var zip_codebirth = $('#zip_codebirth').val();
            var birth_status = $('#birth_status').val();
            var date_of_birth = $('#date_of_birth').val();
            var gender = $('#gender').val();
            var document_type = $('#document_type').val();
            var document_number = $('#document_number').val();
            var Tax_code = $('#Tax_code').val();
            var city_of_residence = $('#City_of_residence').val();
            var Province_of_residence = $('#Province_of_residence').val();
            var zip_code = $('#zip_code').val();
            var state_of_residence = $('#state_of_residence').val();
            var address = $('#address').val();
            var email = $('#mail').val();
            var oldmail = $('#oldmail').val();
            var phone_number = $('#phone_number').val();
            var rh_factor = $('#rh_factor').val();
            var phenotype = $('#phenotype').val();
            var kell = $('#kell').val();
            var group_type = $('#group_type').val();

            var csrfName = 'csrf_token'; // CSRF Token name
            var csrfHash = $('input[name="csrf_token"]').val()
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('SaveNewUser'); ?>",
                data: {
                    avatar: avatar,
                    id: id,
                    first_name: first_name,
                    surname: surname,
                    birth_place: birth_place,
                    County_of_birth: County_of_birth,
                    zip_codebirth: zip_codebirth,
                    birth_status: birth_status,
                    date_of_birth: date_of_birth,
                    gender: gender,
                    document_type: document_type,
                    document_number: document_number,
                    Tax_code: Tax_code,
                    city_of_residence: city_of_residence,
                    Province_of_residence: Province_of_residence,
                    zip_code: zip_code,
                    state_of_residence: state_of_residence,
                    address: address,
                    email: email,
                    oldmail: oldmail,
                    phone_number: phone_number,
                    rh_factor: rh_factor,
                    phenotype: phenotype,
                    kell: kell,
                    group_type: group_type,
                    [csrfName]: csrfHash,
                },
                dataType: "JSON",
                success: function(data) {
                    $('#loading').hide();
                    // var datae=JSON.parse(data.aer)
                    // Gestisci la risposta dal server
                    if (data.msg == 'fail') {
                        clearscreen();
                        for (const key in data.aer) {               
                            $("#error" + key).html(data.aer[key]);
                            $("#" + key).addClass("w3-border-red");
                            // Accedi al valore della proprietà
                        }
                        $('input[name="csrf_token"]').val(data.token);
                    }
                    if (data.msg == 'success') {
                        clearscreen();
                        $('input[name="csrf_token"]').val(data.token);
                        window.location.href = `${window.location.origin}/AdminHome`;


                    }
                },
            });

        });
    });

    function clearscreen() {
        console.log("clerscreen");
        $("#errorfirst_name").html("  ");
        $("#errorsurname").html("  ");
        $("#errorbirth_place").html("  ");
        $("#errorCounty_of_birth").html("  ");
        $("#errorzip_codebirth").html("  ");
        $("#errorbirth_status").html("  ");
        $("#errorgender").html("  ");
        $("#errordate_of_birth").html("  ");
        $("#errordocument_type").html("  ");
        $("#errordocument_number").html("  ");
        $("#errorTax_code").html("  ");
        $("#errorCity_of_residence").html("  ");
        $("#errorProvince_of_residence").html("  ");
        $("#errorzip_code").html("  ");
        $("#errorstate_of_residence").html("  ");
        $("#erroraddress").html("  ");
        $("#errormail").html("  ");
        $("#errorrh_factor").html("  ");
        $("#errorphenotype").html("  ");
        $("#errorkell").html("  ");
        $("#errorgroup_type").html("  ");
        $("#errorphone_number").html("  ");
        $("#first_name").removeClass("w3-border-red");
        $("#surname").removeClass("w3-border-red");
        $("#birth_place").removeClass("w3-border-red");
        $("#County_of_birth").removeClass("w3-border-red");
        $("#gender").removeClass("w3-border-red");
        $("#zip_codebirth").removeClass("w3-border-red");
        $("#errorbirth_status").removeClass("w3-border-red");
        $("#date_of_birth").removeClass("w3-border-red");
        $("#document_type").removeClass("w3-border-red");
        $("#document_number").removeClass("w3-border-red");
        $("#Tax_code").removeClass("w3-border-red");
        $("#City_of_residence").removeClass("w3-border-red");
        $("#Province_of_residence").removeClass("w3-border-red");
        $("#zip_code").removeClass("w3-border-red");
        $("#state_of_residence").removeClass("w3-border-red");
        $("#address").removeClass("w3-border-red");
        $("#mail").removeClass("w3-border-red");
        $("#phone_number").removeClass("w3-border-red");
        $("#rh_factor").removeClass("w3-border-red");
        $("#phenotype").removeClass("w3-border-red");
        $("#kell").removeClass("w3-border-red");
        $("#group_type").removeClass("w3-border-red");
    }
</script>