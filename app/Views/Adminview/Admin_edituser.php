<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- jQuery UI -->

   
    <title>Anagrafica Utente</title>
</head>

<?php echo csrf_field(); ?>

<div class=" w3-section w3-animate-right">

    <div class="w3-container w3-section w3-margin-top">
        <!-- begin comand menu edit user-->
        <div class="w3-bar w3-dark-grey w3-large w3-margin">
            <a href="<?php echo site_url('/AdminHome'); ?>" class=" w3-xxlarge w3-left w3-btn" title="<?php echo lang('Auth.goadminmenu'); ?>"
                style="margin-left:25px; margin-top:8px;" onclick="$('#loading').show();">
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>

            <a href="" id="getuniquecodei" class=" w3-xxlarge w3-left w3-btn" title="<?php echo lang('Auth.getuniquecode'); ?>"
                style="margin-left:15px;margin-top:8px;">
                <i class="fa fa-id-card" aria-hidden="true" id="getuniquecode"></i>
            </a>

            <a href="" id="getrole" class=" w3-xxlarge w3-left w3-btn" title="<?php echo lang('Auth.updateuserlevelauth'); ?>"
                style="margin-left:15px;margin-top:8px;"><i class="fa fa-level-up" aria-hidden="true"></i>
            </a>

            <a href="" id="forceresetpw" class=" w3-xxlarge w3-left w3-btn" title="<?php echo lang('Auth.userinblacklist'); ?>"
                style="margin-left:15px;margin-top:8px;"><i class="fa fa-unlock" aria-hidden="true"></i>
            </a>

            <form action="<?php echo site_url('UserDelete'); ?>" method="post" style="display:inline;">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo esc($useredit['user']['id']); ?>"
                    title="<?php echo lang('Auth.deleteUser'); ?>">
                <button class="w3-btn  w3-xxlarge w3-left" style="margin-left: 15px;"
                    onclick=" $('#loading').show();">
                    <i class="fa fa-trash" aria-hidden="true" title="<?php echo lang('Auth.deleteUser'); ?>">
                    </i>
                </button>
            </form>
        </div> <!-- end menu edit user-->
        <div class="w3-col s4">
            <img src="<?php base_url(); ?><?php echo esc($useredit['user']['avatar']); ?>" id="avatar"
                class="w3-circle w3-margin-right w3-left" style="width: 80px;">
            <?php echo esc($useredit['user']['first_name']); ?>
            <?php echo esc($useredit['user']['surname']); ?>
        </div>
        <div class="w3-bar w3-black w3-hide-small">
            <!-- start tabs in screnn-->
            <button class="w3-bar-item w3-button tablink w3-red"
                onclick="openTab(event,'datauser')"><?php echo lang('Auth.Datauser'); ?></button>
            <button class="w3-bar-item w3-button tablink"
                onclick="openTab(event,'userExsam')"><?php echo lang('Auth.UserExsam'); ?></button>
            <button class="w3-bar-item w3-button tablink"
                onclick="openTab(event,'userNote')"><?php echo lang('Auth.userNote'); ?></button>
            <button class="w3-bar-item w3-button tablink"
                onclick="openTab(event,'userMessage')"><?php echo lang('Auth.userMessage'); ?></button>
        </div><!-- end tabs in screnn-->
        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium"
            onclick="w3_opentabmenu()"><i class="fa fa-bars"></i> </a>
        <!-- Sidebar on small screens when clicking the menu icon -->
        <nav class="w3-sidebar w3-bar-block w3-black w3-card w3-animate-left w3-hide-medium w3-hide-large"
            style="display:none" id="mySidebar">
            <a href="javascript:void(0)" onclick="closetab()"
                class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>
            <a href="" onclick="openTab(event,'datauser')"
                class="w3-bar-item w3-button"><?php echo lang('Auth.Datauser'); ?></a>
            <a href="#team" onclick="openTab(event,'userExsam')"
                class="w3-bar-item w3-button"><?php echo lang('Auth.UserExsam'); ?></a>
            <a href="" onclick="openTab(event,'userNote')"
                class="w3-bar-item w3-button"><?php echo lang('Auth.userNote'); ?></a>
            <a href="" onclick="openTab(event,'userMessage')"
                class="w3-bar-item w3-button"><?php echo lang('Auth.userMessage'); ?></a>
        </nav>
        <div id="datauser" class="w3-container w3-border tabuser">
            <form id="formuser">
                <input type="hidden" name="avatar" id="avatarimg" value="<?php echo esc($useredit['user']['avatar']); ?>">
                <input type="hidden" name="id" id="id" value="<?php echo esc($useredit['user']['id']); ?>">
                <input type="hidden" name="oldmail" id="oldmail" value="<?php echo esc($useredit['user']['email']); ?>">
                <fieldset>
                    <a href="" id="updatebotton" class=" w3-xxlarge w3-right" title="<?php echo lang('Auth.updateuser'); ?>"
                        style="margin-left:15px;margin-top:8px;">
                        <i class="fa fa-save" aria-hidden="true"></i>
                    </a>
                    <div class="w3-row">
                        <!-- begin row Username  e name form input-->
                        <div class="w3-half w3-container">
                            <!-- Username -->
                            <label for="first_name"><?php echo lang('Auth.first_name'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="first_name"
                                name="first_name" inputmode="text" autocomplete="first_name"
                                placeholder="<?php echo lang('Auth.first_name'); ?>"
                                value="<?php echo esc($useredit['user']['first_name']); ?>" required />
                            <p id="errorfirst_name" class="w3-text-red"> </p>
                        </div> <!-- end username-->
                        <div class="w3-half w3-container">
                            <!-- surname-->
                            <label for="surname"><?php echo lang('Auth.surname'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="surname"
                                name="surname" inputmode="text" autocomplete="surname"
                                placeholder="<?php echo lang('Auth.surnameplacehoder'); ?>"
                                value="<?php echo esc($useredit['user']['surname']); ?>" required />
                            <p id="errorsurname" class="w3-text-red"> </p>
                        </div> <!-- end surname-->
                    </div> <!-- end Username  e name form input-->

                    <div class="w3-container w3-padding w3-margin-top""><!-- Begin group blod  row-->
                         <fieldset>
                          <legend><?php echo lang('Auth.bloodfiledset'); ?></legend>
                          <div class=" w3-row">
                        <div class="w3-quarter w3-container">
                            <label for="birth_place"><?php echo lang('Auth.group_type'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="group_type"
                                name="group_type" inputmode="group_type" autocomplete="group_type"
                                placeholder="<?php echo lang('Auth.group_type'); ?>"
                                value="<?php echo esc($useredit['user']['group_type']); ?>" required />
                            <p id="errorgroup_type" class="w3-text-red"> </p>
                        </div>
                        <div class="w3-quarter w3-container">
                            <label for="birth_place"><?php echo lang('Auth.rh_factor'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="rh_factor"
                                name="rh_factor" inputmode="birth_place" autocomplete="rh_factor"
                                placeholder="<?php echo lang('Auth.rh_factor'); ?>"
                                value="<?php echo esc($useredit['user']['rh_factor']); ?>" required />
                            <p id="errorrh_factor" class="w3-text-red"> </p>
                        </div>
                        <div class="w3-quarter w3-container">
                            <label for="birth_place"><?php echo lang('Auth.phenotype'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="phenotype"
                                name="phenotype" inputmode="phenotype" autocomplete="phenotype"
                                placeholder="<?php echo lang('Auth.phenotype'); ?>"
                                value="<?php echo esc($useredit['user']['phenotype']); ?>" required />
                            <p id="errorphenotype" class="w3-text-red"> </p>
                        </div>
                        <div class="w3-quarter w3-container">
                            <label for="birth_place"><?php echo lang('Auth.kell'); ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="kell" name="kell"
                                inputmode="kell" autocomplete="kell" placeholder="<?php echo lang('Auth.kell'); ?>"
                                value="<?php echo esc($useredit['user']['kell']); ?>" required />
                            <p id="errorkell" class="w3-text-red"> </p>
                        </div>
                    </div>
                </fieldset>
        </div> <!-- End group blod  row-->

        <div class="w3-container w3-padding w3-margin-top" id="daticliente">
            <!-- Begin row ' birth_place County_of_birth zip_codebirth  date_of_birth birth_status document type tax number '   ,form input  -->
            <fieldset>
                <legend>Dati Anadrafici:</legend>
                <div class="w3-row  ">
                    <div class="w3-fifth w3-container">
                        <!-- birth_place  citta di nascita-->
                        <label for="birth_place"><?php echo lang('Auth.birth_place'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="birth_place"
                            name="birth_place" inputmode="birth_place" autocomplete="birth_place"
                            placeholder="<?php echo lang('Auth.birth_place'); ?>"
                            value="<?php echo esc($useredit['user']['birth_place']); ?>" required />
                        <p id="errorbirth_place" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-fifth w3-container">
                        <!-- County_of_birth  paese di nascita-->
                        <label for="County_of_birth"><?php echo lang('Auth.County_of_birth'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="County_of_birth"
                            name="County_of_birth" inputmode="County_of_birth" autocomplete="County_of_birth"
                            placeholder="<?php echo lang('Auth.County_of_birth'); ?>"
                            value="<?php echo esc($useredit['user']['County_of_birth']); ?>" required />
                        <p id="errorCounty_of_birth" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-fifth w3-container">
                        <!-- zip code birth-->
                        <label for="zip_codebirth"><?php echo lang('Auth.zip_codebirth'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="zip_codebirth"
                            name="zip_codebirth" inputmode="text" autocomplete="zip_codebirth"
                            placeholder="<?php echo lang('Auth.zip_codebirth'); ?>"
                            value="<?php echo esc($useredit['user']['zip_codebirth']); ?>" required />
                        <p id="errorzip_codebirth" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-fifth w3-container">
                        <!-- birth_status nazione di nascita-->
                        <label for="birth_status"><?php echo lang('Auth.birth_status'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="birth_status"
                            name="birth_status" inputmode="birth_status" autocomplete="birth_status"
                            placeholder="<?php echo lang('Auth.birth_status'); ?>"
                            value="<?php echo esc($useredit['user']['birth_status']); ?>" required />
                        <p id="errorbirth_status" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-fifth w3-container">
                        <!--gender  tyoe -->
                        <label for="gender"><?php echo lang('Auth.gender'); ?></label>
                        <select name="gender" id="gender" class="w3-select w3-border w3-round-xlarge">
                            <option value="0"><?php echo lang('Auth.select'); ?></option>
                            <option value="M" <?php echo ($useredit['user']['gender'] == 'M') ? 'selected' : ''; ?>>
                                <?php echo lang('Auth.maschio'); ?> </option>
                            <option value="F" <?php echo ($useredit['user']['gender'] == 'F') ? 'selected' : ''; ?>>
                                <?php echo lang('Auth.femmina'); ?> </option>
                        </select>
                        <p id="errorgender" class="w3-text-red"> </p>
                    </div>
                </div>
                <div class="w3-row w3-margin-bottom">
                    <div class="w3-quarter w3-container">
                        <!-- date_of_birth -->
                        <label for="date_of_birth"><?php echo lang('Auth.date_of_birth'); ?></label>
                        <input type="date" class="w3-input w3-border w3-round-xlarge" id="date_of_birth"
                            name="date_of_birth" inputmode="date_of_birth" autocomplete="date_of_birth"
                            placeholder="<?php echo lang('Auth.date_of_birth'); ?>"
                            value="<?php echo esc($useredit['user']['date_of_birth']); ?>" required />
                        <p id="errordate_of_birth" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-quarter w3-container">
                        <!-- document type select-->
                        <label for="document_type"><?php echo lang('Auth.document_type'); ?></label>
                        <select name="document_type" id="document_type" class="w3-select w3-border w3-round-xlarge">
                            <option value="0">Scegli----</option>
                            <option value="Carta identità"
                                <?php echo ($useredit['user']['document_type'] == 'Carta identità') ? 'selected' : ''; ?>>
                                Carta d'identità</option>
                            <option value="Patente"
                                <?php echo ($useredit['user']['document_type'] == 'Patente') ? 'selected' : ''; ?>>
                                Patente</option>
                            <option value="Passaporto"
                                <?php echo ($useredit['user']['document_type'] == 'Passaporto') ? 'selected' : ''; ?>>
                                Passaporto</option>
                        </select>
                        <p id="errordocument_type" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-quarter w3-container">
                        <!--document number -->
                        <label for="document_number"><?php echo lang('Auth.document_number'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="document_number"
                            name="document_number" inputmode="text" autocomplete="document_number"
                            placeholder="<?php echo lang('Auth.document_number'); ?>"
                            value="<?php echo esc($useredit['user']['document_number']); ?>" required />
                        <p id="errordocument_number" class="w3-text-red"> </p>
                    </div>
                    <div class="w3-quarter w3-container">
                        <!--tax number -->
                        <label for="Tax_code"><?php echo lang('Auth.Tax_code'); ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="Tax_code" name="Tax_code"
                            inputmode="text" autocomplete="Tax_code" placeholder="<?php echo lang('Auth.Tax_code'); ?>"
                            value="<?php echo esc($useredit['user']['Tax_code']); ?>" required />
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
                    <input type="text" class="w3-input w3-border w3-round-xlarge" id="City_of_residence"
                        name="City_of_residence" inputmode="text" autocomplete="City_of_residence"
                        placeholder="<?php echo lang('Auth.City_of_residence'); ?>"
                        value="<?php echo esc($useredit['user']['City_of_residence']); ?>" required />
                    <p id="errorCity_of_residence" class="w3-text-red"> </p>
                </div>
                <div class="w3-fifth w3-container">
                    <!-- Province_of_residence-->
                    <label for="Province_of_residence"><?php echo lang('Auth.Province_of_residence'); ?></label>
                    <input type="text" class="w3-input w3-border w3-round-xlarge" id="Province_of_residence"
                        name="Province_of_residence" inputmode="text" autocomplete="Province_of_residence"
                        placeholder="<?php echo lang('Auth.Province_of_residence'); ?>"
                        value="<?php echo esc($useredit['user']['Province_of_residence']); ?>" required />
                    <p id="errorProvince_of_residence" class="w3-text-red"> </p>
                </div>
                <div class="w3-fifth w3-container">
                    <!-- zip code-->
                    <label for="zip_code"><?php echo lang('Auth.zip_code'); ?></label>
                    <input type="text" class="w3-input w3-border w3-round-xlarge" id="zip_code" name="zip_code"
                        inputmode="text" autocomplete="zip_code" placeholder="<?php echo lang('Auth.zip_code'); ?>"
                        value="<?php echo esc($useredit['user']['zip_code']); ?>" required />
                    <p id="errorzip_code" class="w3-text-red"> </p>
                </div>
                <div class="w3-fifth w3-container">
                    <!--  state_of_residence-->
                    <label for="state_of_residence"><?php echo lang('Auth.state_of_residence'); ?></label>
                    <input type="text" class="w3-input w3-border w3-round-xlarge" id="state_of_residence"
                        name="state_of_residence" inputmode="text" autocomplete="state_of_residence"
                        placeholder="<?php echo lang('Auth.state_of_residence'); ?>"
                        value="<?php echo esc($useredit['user']['state_of_residence']); ?>" required />
                    <p id="errorstate_of_residence" class="w3-text-red"> </p>
                </div>
                <div class="w3-fifth w3-container">
                    <!-- addres-->
                    <label for="address"><?php echo lang('Auth.address'); ?></label>
                    <input type="text" class="w3-input w3-border w3-round-xlarge" id="address" name="address"
                        inputmode="text" autocomplete="address" placeholder="<?php echo lang('Auth.address'); ?>"
                        value="<?php echo esc($useredit['user']['address']); ?>" required />
                    <p id="erroraddress" class="w3-text-red"> </p>
                </div>
            </fieldset>
        </div> <!--  end row form input 'address''City_of_residence','Province_of_residence','zip_code' -->

        <!-- Begin row 'phone_number', email,form input  -->
        <div class="w3-row">
            <div class="w3-half w3-container">
                <!-- email -->
                <label for="mail"><?php echo lang('Auth.email'); ?></label>
                <input type="email" class="w3-input w3-border w3-round-xlarge" id="mail" name="email"
                    inputmode="email" autocomplete="email" placeholder="<?php echo lang('Auth.email'); ?>"
                    value="<?php echo esc($useredit['user']['email']); ?>" required />
                <p id="errormail" class="w3-text-red"> </p>
            </div>
            <div class="w3-half w3-container">
                <!-- phone_number -->
                <label for="phone_number"><?php echo lang('Auth.phone_number'); ?></label>
                <input type="tel" class="w3-input w3-border w3-round-xlarge" id="phone_number" name="phone_number"
                    inputmode="phone_number" autocomplete="phone_number"
                    placeholder="<?php echo lang('Auth.phone_number'); ?>"
                    value="<?php echo esc($useredit['user']['phone_number']); ?>" required />
                <p id="errorphone_number" class="w3-text-red"> </p>
            </div>
            <!-- nodal fomr code unique-->
        </div>
        <!-- end row 'phone_number', email',form input  -->
        </fieldset>
        </form>
    </div> <!-- end menu edid user -->
</div>
<div id="userExsam" class="w3-container w3-border tabuser" style="display:none">
    <!-- begin exsamas-->
    <header class="w3-container w3-dark-grey">
        <h2> <?php echo lang('Auth.Exsamlist'); ?></h2>
    </header>
    <div class="w3-responsive" style=" width:auto; height:550px;">
        <table class="w3-table-all">
            <tr>
                <th><?php echo lang('Auth.donationTypeLabel'); ?></th>
                <th><?php echo lang('Auth.Donationdate'); ?></th>
                <th><?php echo lang('Auth.daystop'); ?></th>
                <th><?php echo lang('Auth.unlokdate'); ?></th>
                <th><?php echo lang('Auth.notestopLabel'); ?></th>
                <th><?php echo lang('Auth.textnoteinpdf'); ?></th>
                <th><?php echo lang('Auth.uploadfile'); ?></th>
                <th><?php echo lang('Auth.downloadfile'); ?></th>
                <th><?php echo lang('Auth.btncancell'); ?></th>
                <th><?php echo lang('Auth.btnmodify'); ?></th>
            </tr>
            <?php foreach ($useredit['exsam']['listexsam']['listall'] as $list) { ?>
                <?php if ($list['id'] !== '') : ?>
                    <tr id="row<?php echo esc($list['id']); ?>">
                        <td><?php echo esc($list['exam_type']); ?> </td>
                        <td> <?php echo esc($list['donation_date']); ?></td>
                        <td> <?php echo esc($list['day_stop']); ?></td>
                        <td> <?php echo esc($list['unlokdate']); ?></td>
                        <td> <?php echo esc($list['stop_notice']); ?></td>
                        <td> <?php echo esc($list['notedoctor']); ?></td>
                        <td> <?php echo esc($list['upload_date']); ?></td>
                        <td> <?php echo esc($list['download_date']); ?></td>
                        <td><button class="w3-button w3-red del-exam-btn" id="delexam" data-Exsamid="<?php echo esc($list['id']); ?>">
                                <?php echo lang('Auth.btncancell'); ?></button> </td>
                        <td><button class="w3-button w3-green"
                                onclick="ModifyExam(<?php echo esc($list['id']); ?>)"><?php echo lang('Auth.btnmodify'); ?></button>
                        </td>
                    </tr>
            <?php endif;
            } ?>
        </table>
    </div>
    <footer class="w3-container w3-dark-grey">
        <p><?php echo lang('Auth.Exsamlist'); ?></p>
    </footer>



</div> <!-- end exsamas-->
<div id="userNote" class="w3-container w3-border tabuser" style="display:none">

    <p>same note</p>

</div>
<div id="userMessage" class="w3-container w3-border tabuser" style="display:none">

    <p> same message</p>

</div>

<div id="usercode" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container w3-gray">
            <span onclick="document.getElementById('usercode').style.display='none'"
                class="w3-button w3-display-topright">&times;</span>
            <h2>Assegnazione codice CAI</h2>
        </header>
        <div class="w3-container">
            <div class="w3-row">
                <!-- Username -->
                <?php echo csrf_field(); ?>
                <label for="uniquecode"><?php echo lang('Auth.uniquecode'); ?></label>
                <input type="text" class="w3-input w3-border w3-round-xlarge" id="uniquecode" name="uniquecode"
                    inputmode="text" autocomplete="uniquecode" placeholder="<?php echo lang('Auth.uniquecode'); ?>"
                    value="<?php echo esc($useredit['user']['unique_code']); ?>" required />
                <button class="w3-button w3-green w3" id="saveuniquecode"
                    style="margin-top:25px"><?php echo lang('Auth.confirm'); ?></button>
            </div>
            <p id="erroruniquecode" class="w3-text-red"> </p>
        </div>
    </div>
</div>
</div>
<div id="loading" class="w3-modal w3-white w3-opacity" style="display:none">
    <img class="w3-padding w3-display-middle" src="/assets/imgwait/loading.gif" alt="wait...." />
</div>
<div id="levelup"></div>
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
    $(document).ready(function() {
        $('#getuniquecode').click(function(e) {
            e.preventDefault();
            $('#usercode').show();
        });
        $('#saveuniquecode').click(function(e) {
            e.preventDefault();
            var id = $('#id').val();
            var taxcode = $('#Tax_code').val();
            var uniquecode = $('#uniquecode').val();
            var csrfName = 'csrf_token'; // CSRF Token name
            var csrfHash = $('input[name="csrf_token"]').val();
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('UpdateUserUniqueCode'); ?>",
                data: {
                    id: id,
                    uniquecode: uniquecode,
                    taxcode: taxcode,
                    [csrfName]: csrfHash,
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.msg == 'fail') {
                        $('#loading').hide();
                        for (const key in data.aer) {
                            $("#error" + key).html(data.aer[key]);
                            $("#" + key).addClass("w3-border-red");
                            // Accedi al valore della proprietà
                        }
                        $('input[name="csrf_token"]').val(data.token);
                    }
                    if (data.msg == 'ok') {
                        $('input[name="csrf_token"]').val(data.token);
                        $('#loading').hide();
                        alert("Aggiornamento effettuato");
                        $('#usercode').hide();
                    }
                },
            });

        });
        $('#updatebotton').click(function(e) {
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
                url: "<?php echo site_url('UpdateUser'); ?>",
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
                        console.log(data.aer);
                        for (const key in data.aer) {
                            console.log(data);
                            $("#error" + key).html(data.aer[key]);
                            $("#" + key).addClass("w3-border-red");
                            // Accedi al valore della proprietà
                        }
                        $('input[name="csrf_token"]').val(data.token);
                    }
                    if (data.msg == 'ok') {
                        clearscreen();
                        $('input[name="csrf_token"]').val(data.token);
                    }
                },
            });

        });
        $('.del-exam-btn').click(function(e) {
            e.preventDefault();
            $('#loading').show();
            var examId = $(this).attr("data-exsamid");
            console.log(examId);
            $.ajax({
                type: "post",
                url: "<?php echo site_url('DelExsam'); ?>",
                data: {
                    idexam: examId,
                },
                dataType: "json",
                success: function(data) {
                    $('#loading').hide();
                    $('input[name="csrf_token"]').val(data.token);
                    $("#row" + examId).remove();


                }
            });

        });

        $('#getrole').click(function(e) {
            e.preventDefault();
            $('#loading').show();
            var csrfName = 'csrf_token'; // CSRF Token name
            var csrfHash = $('input[name="csrf_token"]').val()
            var id = $('#id').val();
            $.ajax({
                type: "post",
                url: "<?php echo site_url('show-update-level-view'); ?>",
                data: {
                    [csrfName]: csrfHash,
                    id: id,
                },
                dataType: "html",
                success: function(data) {
                    $('#loading').hide();
                    $('input[name="csrf_token"]').val(data.token);
                    $('#loading').hide();
                    $('#levelup').html(data)
                }
            });


        });
    });

    function formatDate(dateString) {
        if (dateString != '') {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear().toString();
            return `${day}/${month}/${year}`;
        } else {
            return null;
        }
    }

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