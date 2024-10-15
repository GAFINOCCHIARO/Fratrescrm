<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <title>Registrazione Nuova azienda</title>
</head>



<body>
    <div class="w3-container">
        <h5 class="w3-panel w3-leftbar w3-border-amber w3-pale-yellow w3-padding-16">
            <?php echo lang('Auth.registernewcompany'); ?> </h5>
        <form class="w3-container  w3-white" action="<?php echo url_to('registercompany'); ?>" method="post">
            <input type="hidden" name="avatar" id="avatar" value="/assets/avatar/avatar_default.jpg" />
            <input type="hidden" name="unique_code" id="unique_code" value="0000">
            <input type="hidden" name="authorized" id="authorized" value="1" />
            <input type="hidden" name="user_type" id="user_type" value="donatore" />
            <input type="hidden" name="number_armchairs" id="number_armchairs" value="1">
            <input type="hidden" name="siteurl" id="siteurl" value="">
            <?php echo csrf_field(); ?>
            <fieldset>
                <fieldset>
                    <legend><?php echo lang('Auth.company_fieldset'); ?></legend>
                    <div class="w3-row-padding w3-container"><!-- begin row business_name  e group_name form input-->
                        <div class="w3-half  "><!--  row business_name-->
                            <label for="company_name"><?php echo lang('Auth.business_name'); ?>
                            </label>
                            <input class="w3-input w3-border w3-round-xlarge" type="text" id="company_name"
                                name="company_name" inputmode="text" autocomplete="company_name"
                                placeholder="<?php echo lang('Auth.business_nameplaceholder'); ?>"
                                value="<?php echo old('company_name'); ?>">
                            <?php if (isset(session('errors')['company_name'])) {
                                echo '<p class="w3-text-red">' . session('errors')['company_name'] . '</p>';
                            } ?>
                        </div>
                        <div class="w3-half"><!-- group_name form input-->
                            <label for="group_name"><?php echo lang('Auth.company_name'); ?></label>
                            <input class="w3-input w3-border w3-round-xlarge" name="group_name" id="group_name"
                                type="text" autocomplete="group_name"
                                placeholder="<?php echo lang('Auth.company_nameplaceholder'); ?>"
                                value="<?php echo old('group_name'); ?>">
                            <?php if (isset(session('errors')['group_name'])) {
                                echo '<p class="w3-text-red">' . session('errors')['group_name'] . '</p>';
                            } ?>

                        </div>
                    </div> <!-- end   row business_name  e group_name form input-->

                    <div class="w3-row-padding w3-container"><!-- begin row company_address   e company_city form input-->
                        <div class="w3-half"><!-- company_address -->
                            <label for="company_address"><?php echo lang('Auth.business_address'); ?></label>
                            <input class="w3-input w3-border  w3-round-xlarge" name="company_address" id="company_address"
                                type="text" value="<?php echo old('company_address'); ?>"
                                placeholder="<?php echo lang('Auth.business_addressplaceholder'); ?>">
                            <?php if (isset(session('errors')['company_address'])) {
                                echo '<p class="w3-text-red">' . session('errors')['company_address'] . '</p>';
                            } ?>
                        </div>
                        <div class="w3-half"><!-- company_city -->
                            <label for="company_city"><?php echo lang('Auth.company_city'); ?></label>
                            <input class="w3-input w3-border  w3-round-xlarge" name="company_city" id="company_city"
                                type="text" value="<?php echo old('company_city'); ?>"
                                placeholder="<?php echo lang('Auth.company_cityplaceholder'); ?>">
                            <?php if (isset(session('errors')['company_city'])) {
                                echo '<p class="w3-text-red">' . session('errors')['company_city'] . '</p>';
                            } ?>
                        </div>
                    </div> <!-- end   row company_address   e company_city form input-->

                    <div class="w3-row-padding w3-container"><!-- begin row company phone number    e company_vat form input-->
                        <div class="w3-half"><!--  row company phone number -->
                            <label for="company_phone"><?php echo lang('auth.company_phone'); ?> </label>
                            <input class="w3-input w3-border w3-round-xlarge" name="company_phone" id="company_phone"
                                type="text" value="<?php echo old('company_phone'); ?>"
                                placeholder="<?php echo lang('Auth.company_phoneplaceholder'); ?>">
                            <?php if (isset(session('errors')['company_phone'])) {
                                echo '<p class="w3-text-red">' . session('errors')['company_phone'] . '</p>';
                            } ?>
                        </div>
                        <div class="w3-half"><!--   row company_vat form input-->
                            <label for="company_vat"><?php echo lang('Auth.company_vat'); ?></label>
                            <input class="w3-input w3-border  w3-round-xlarge" name="company_vat"
                                id="company_vat" type="text" value="<?php echo old('company_vat'); ?>"
                                placeholder="<?php echo lang('Auth.company_vatplaceholder'); ?>">
                            <?php if (isset(session('errors')['company_vat'])) {
                                echo '<p class="w3-text-red">' . session('errors')['company_vat'] . '</p>';
                            } ?>
                        </div>
                    </div> <!-- end   row company phone number   e  company_vat form input-->

                    <div class="w3-row-padding w3-container"><!-- begin row company mail form input-->
                        <div class="w3-row-padding"><!--   company mail form input-->
                            <label for="companyemail"><?php echo lang('Auth.companyemail'); ?></label>
                            <input class="w3-input w3-border  w3-round-xlarge" type="email" name="companyemail"
                                id="companyemail" autocomplete="e-mail" value="<?php echo old('email'); ?>"
                                placeholder="<?php echo lang('Auth.companyemailplaceholder'); ?>">
                            <?php if (isset(session('errors')['companyemail'])) {
                                echo '<p class="w3-text-red">' . session('errors')['companyemail'] . '</p>';
                            } ?>
                        </div>
                    </div> <!-- end   row company mail form input-->

                </fieldset>
                <fieldset>
                    <legend><?php echo lang('Auth.user_fieldset'); ?></legend>

                    <div class="w3-row-padding w3-container"> <!-- begin row Username  e name form input-->
                        <div class="w3-half"> <!-- user name -->
                            <label for="floatingfirst_nameInput"><?php echo lang('Auth.first_name'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="floatingfirst_nameInput"
                                name="first_name" inputmode="text" autocomplete="first_name"
                                placeholder="<?php echo lang('Auth.first_name'); ?>"
                                value="<?php echo old('first_name'); ?>" />
                            <?php if (isset(session('errors')['first_name'])) {
                                echo '<p class="w3-text-red">' . session('errors')['first_name'] . '</p>';
                            } ?>
                        </div>
                        <div class="w3-half"><!-- user surname -->
                            <label for="surname"><?php echo lang('Auth.surname'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="surname" name="surname"
                                inputmode="text" autocomplete="surname"
                                placeholder="<?php echo lang('Auth.surname'); ?>" value="<?php echo old('surname'); ?>" />
                            <?php if (isset(session('errors')['surname'])) {
                                echo '<p class="w3-text-red">' . session('errors')['surname'] . '</p>';
                            } ?>
                        </div>
                    </div> <!-- end Username  e name form input-->

                    <div class="w3-row-padding w3-container" id="daticliente"><!-- Begin row ' birth_place County_of_birth zip_codebirth  date_of_birth birth_status document type tax number '   ,form input  -->
                        <div class="w3-quarter"><!-- birth_place  citta di nascita-->
                            <label for="birth_place"><?php echo lang('Auth.birth_place'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="birth_place"
                                name="birth_place" inputmode="birth_place" autocomplete="birth_place"
                                placeholder="<?php echo lang('Auth.birth_place'); ?>"
                                value="<?php echo old('birth_place'); ?>" />
                            <?php if (isset(session('errors')['birth_place'])) {
                                echo '<p class="w3-text-red">' . session('errors')['birth_place'] . '</p>';
                            } ?>
                        </div>
                        <div class="w3-quarter"> <!-- County_of_birth  paese di nascita-->
                            <label for="County_of_birth"><?php echo lang('Auth.County_of_birth'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="County_of_birth"
                                name="County_of_birth" inputmode="County_of_birth" autocomplete="County_of_birth"
                                placeholder="<?php echo lang('Auth.County_of_birth'); ?>"
                                value="<?php echo old('County_of_birth'); ?>" />
                            <?php if (isset(session('errors')['County_of_birth'])) {
                                echo '<p class="w3-text-red">' . session('errors')['County_of_birth'] . '</p>';
                            } ?>
                        </div>
                        <div class="w3-quarter"> <!-- zip code birth-->
                            <label for="zip_codebirth"><?php echo lang('Auth.zip_codebirth'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="zip_codebirth"
                                name="zip_codebirth" inputmode="text" autocomplete="zip_codebirth"
                                placeholder="<?php echo lang('Auth.zip_codebirth'); ?>"
                                value="<?php echo old('zip_codebirth'); ?>" />
                            <?php if (isset(session('errors')['zip_codebirth'])) {
                                echo '<p class="w3-text-red">' . session('errors')['zip_codebirth'] . '</p>';
                            } ?>
                        </div>
                        <div class="w3-quarter"><!-- birth_status nazione di nascita-->
                            <label for="birth_status"><?php echo lang('Auth.birth_status'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="birth_status"
                                name="birth_status" inputmode="birth_status" autocomplete="birth_status"
                                placeholder="<?php echo lang('Auth.birth_status'); ?>"
                                value="<?php echo old('birth_status'); ?>" />
                            <?php if (isset(session('errors')['birth_status'])) {
                                echo '<p class="w3-text-red">' . session('errors')['birth_status'] . '</p>';
                            } ?>
                        </div>
                    </div> <!-- end   row ' birth_place County_of_birth zip_codebirth  date_of_birth birth_status document type tax number '   ,form input  -->

                    <div class="w3-row-padding w3-container" "> <!-- Begin row date_of_birth  document type select document number   tax number '   form input  -->
                      <div class=" w3-quarter"> <!-- date_of_birth -->
                        <label for="date_of_birth"><?php echo lang('Auth.date_of_birth'); ?></label>
                        <input type="date" class="w3-input w3-border w3-round-xlarge" id="date_of_birth"
                            name="date_of_birth" inputmode="date_of_birth" autocomplete="date_of_birth"
                            placeholder="<?php echo lang('Auth.date_of_birth'); ?>"
                            value="<?php echo old('date_of_birth'); ?>" />
                        <?php if (isset(session('errors')['date_of_birth'])) {
                            echo '<p class="w3-text-red">' . session('errors')['date_of_birth'] . '</p>';
                        } ?>

                    </div>
                    <div class="w3-quarter"><!-- document type select-->
                        <label for="document_type"><?php echo lang('Auth.document_type'); ?></label>
                        <select name="document_type" id="document_type"
                            class="w3-select w3-border w3-round-xlarge">
                            <option value="0">Scegli----</option>
                            <option value="Carta identità"
                                <?php if (old('document_type') === 'Carta identità') {
                                    echo 'selected';
                                } ?>>Carta d'identità</option>
                            <option value="Patente"
                                <?php if (old('document_type') === 'Patente') {
                                    echo 'selected';
                                } ?>>Patente</option>
                            <option value="Passaporto"
                                <?php if (old('document_type') === 'Passaporto') {
                                    echo 'selected';
                                } ?>>Passaporto</option>
                        </select>
                        <?php if (isset(session('errors')['document_type'])) {
                            echo '<p class="w3-text-red">' . session('errors')['document_type'] . '</p>';
                        } ?>
                    </div>
                    <div class="w3-quarter"> <!--document number -->
                        <label for="document_number"><?php echo lang('Auth.document_number'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="document_number"
                            name="document_number" inputmode="text" autocomplete="document_number"
                            placeholder="<?php echo lang('Auth.document_number'); ?>"
                            value="<?php echo old('document_number'); ?>" />
                        <?php if (isset(session('errors')['document_number'])) {
                            echo '<p class="w3-text-red">' . session('errors')['document_number'] . '</p>';
                        } ?>
                    </div>
                    <div class="w3-quarter"><!--tax number -->
                        <label for="Tax_code"><?php echo lang('Auth.Tax_code'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="Tax_code"
                            name="Tax_code" inputmode="text" autocomplete="Tax_code"
                            placeholder="<?php echo lang('Auth.Tax_code'); ?>"
                            value="<?php echo old('Tax_code'); ?>" />
                        <?php if (isset(session('errors')['Tax_code'])) {
                            echo '<p class="w3-text-red">' . session('errors')['Tax_code'] . '</p>';
                        } ?>
                    </div>
    </div> <!-- end   row date_of_birth  document type select document number   tax number '   form input  -->

    <div class="w3-row-padding w3-container"> <!--  begin row form input 'address''City_of_residence','Province_of_residence','zip_code' -->
        <div class="w3-fifth w3-dropdown-hover "> <!-- City_of_residence-->
            <label for="city_of_residence"><?php echo lang('Auth.City_of_residence'); ?></label>
            <input type="text" class="w3-input w3-border w3-round-xlarge" id="city_of_residence"
                name="city_of_residence" inputmode="text" autocomplete="city_of_residence"
                placeholder="<?php echo lang('Auth.City_of_residence'); ?>"
                value="<?php echo old('city_of_residence'); ?>" />
            <?php if (isset(session('errors')['city_of_residence'])) {
                echo '<p class="w3-text-red">' . session('errors')['city_of_residence'] . '</p>';
            } ?>
            <div class="w3-dropdown-content w3-bar-block w3-border">
            </div>
        </div>
        <div class="w3-fifth"><!-- Province_of_residence-->
            <label for="Province_of_residence"><?php echo lang('Auth.Province_of_residence'); ?></label>
            <input type="text" class="w3-input w3-border w3-round-xlarge" id="Province_of_residence"
                name="Province_of_residence" inputmode="text" autocomplete="Province_of_residence"
                placeholder="<?php echo lang('Auth.Province_of_residence'); ?>"
                value="<?php echo old('Province_of_residence'); ?>" />
            <?php if (isset(session('errors')['Province_of_residence'])) {
                echo '<p class="w3-text-red">' . session('errors')['Province_of_residence'] . '</p>';
            } ?>
        </div>
        <div class="w3-fifth"><!-- zip code-->
            <label for="zip_code"><?php echo lang('Auth.zip_code'); ?></label>
            <input type="text" class="w3-input w3-border w3-round-xlarge" id="zip_code" name="zip_code"
                inputmode="text" autocomplete="zip_code" placeholder="<?php echo lang('Auth.zip_code'); ?>"
                value="<?php echo old('zip_code'); ?>" />
            <?php if (isset(session('errors')['zip_code'])) {
                echo '<p class="w3-text-red">' . session('errors')['zip_code'] . '</p>';
            } ?>
        </div>
        <div class="w3-fifth"> <!--  state_of_residence-->
            <label for="state_of_residence"><?php echo lang('Auth.state_of_residence'); ?></label>
            <input type="text" class="w3-input w3-border w3-round-xlarge" id="state_of_residence"
                name="state_of_residence" inputmode="text" autocomplete="state_of_residence"
                placeholder="<?php echo lang('Auth.state_of_residence'); ?>"
                value="<?php echo old('state_of_residence'); ?>" />
            <?php if (isset(session('errors')['state_of_residence'])) {
                echo '<p class="w3-text-red">' . session('errors')['state_of_residence'] . '</p>';
            } ?>
        </div>
        <div class="w3-fifth"> <!-- addres-->
            <label for="address"><?php echo lang('Auth.address'); ?></label>
            <input type="text" class="w3-input w3-border w3-round-xlarge" id="address" name="address"
                inputmode="text" autocomplete="address" placeholder="<?php echo lang('Auth.address'); ?>"
                value="<?php echo old('address'); ?>" />
            <?php if (isset(session('errors')['address'])) {
                echo '<p class="w3-text-red">' . session('errors')['address'] . '</p>';
            } ?>
        </div>
    </div> <!--  end   row form input 'address''City_of_residence','Province_of_residence','zip_code' -->
    <div class="w3-row-padding w3-container"> <!-- Begin row 'phone_number', email,form input  -->
        <div class="w3-half w3-container"> <!-- email -->
            <label for="floatingEmailInput"><?php echo lang('Auth.email'); ?></label>
            <input type="email" class="w3-input w3-border w3-round-xlarge" id="floatingEmailInput" name="email"
                inputmode="email" autocomplete="email" placeholder="<?php echo lang('Auth.email'); ?>"
                value="<?php echo old('email'); ?>" />
            <?php if (isset(session('errors')['email'])) {
                echo '<p class="w3-text-red">' . session('errors')['email'] . '</p>';
            } ?>
        </div>
        <div class="w3-half w3-container"><!-- phone_number -->
            <label for="phone_number"><?php echo lang('Auth.phone_number'); ?></label>
            <input type="tel" class="w3-input w3-border w3-round-xlarge" id="phone_number" name="phone_number"
                inputmode="phone_number" autocomplete="phone_number"
                placeholder="<?php echo lang('Auth.phone_number'); ?>" value="<?php echo old('phone_number'); ?>" />
            <?php if (isset(session('errors')['phone_number'])) {
                echo '<p class="w3-text-red">' . session('errors')['phone_number'] . '</p>';
            } ?>

        </div>
    </div> <!-- end   row 'phone_number', email',form input  -->

    <div class="w3-row-padding w3-container"> <!-- Begin row Password e repeat password form input -->
        <div class="w3-half w3-container"><!-- Password -->
            <label for="passwordInput"><?php echo lang('Auth.password'); ?></label>
            <input type="password" class="w3-input w3-border w3-round-xlarge" id="passwordInput" name="passwordInput"
                inputmode="text" placeholder="<?php echo lang('Auth.password'); ?>" />
            <?php if (isset(session('errors')['passwordInput'])) {
                echo '<p class="w3-text-red">' . session('errors')['passwordInput'] . '</p>';
            } ?>

        </div>
        <div class="w3-half w3-container"><!-- Password (Again) -->
            <label for="passwordConfirm"><?php echo lang('Auth.passwordConfirm'); ?></label>
            <input type="password" class="w3-input w3-border w3-round-xlarge" id="passwordConfirm"
                name="passwordConfirm" inputmode="text" placeholder="<?php echo lang('Auth.passwordConfirm'); ?>" />
            <?php if (isset(session('errors')['passwordConfirm'])) {
                echo '<p class="w3-text-red">' . session('errors')['passwordConfirm'] . '</p>';
            } ?>
        </div>
    </div> <!-- end   row Password e repeat password form input -->

    </fieldset>

    <div class="w3-container w3-col w3-mobile w3-center"><!-- Begin submit form input -->
        <button type="submit" id="savebotton" class="w3-button w3-green w3- w3-margin-top"><?php echo lang('Auth.register'); ?></button>
        <p class="w3-text w3-center"><?php echo lang('Auth.haveAccount'); ?> <a
                href="<?php echo url_to('login'); ?>"><?php echo lang('Auth.login'); ?></a></p>
    </div> <!-- end submit form input -->

    </fieldset>
    </form>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#city_of_residence').keyup(function() {
            var value = $('#city_of_residence').val();
            if (value.length > 2) {
                // var csrfName = 'csrf_test_name'; // CSRF Token name
                //var csrfHash = $('input[name="csrf_test_name"]').val(); // CSRF hash
                //console.log(csrfHash);
                // Fetch data
                $.ajax({
                    url: "<?= site_url('Comuni/getComuni') ?>",
                    type: 'post',
                    dataType: "json",
                    data: {
                        // [csrfName]: csrfHash, // CSRF Token
                        search: value,
                        type: '1'
                    },
                    success: function(data) {
                        // console.log(data.token);
                        //$('input[name="csrf_test_name"]').val(data.token);
                        console.log(data);
                    }
                });

            }
        });

    });
</script>