<?php
use Config\Encryption;
$encryption = service('encrypter');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .custom-overflow {
            max-height: 10%;
            max-width: 50%;
            overflow-y: auto;
        }

        .custom-button {
            background: none;
            border: none;
            color: inherit;
            font: inherit;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .custom-button .fa-file-pdf-o {
            margin-right: 5px;
            color: red;
        }

        html,
        body,
        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: "Raleway", sans-serif
        }

        #tabuser_wrapper .dt-buttons button {
            margin-right: 5px;
            padding: 8px 16px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #4CAF50;
            /* Colore di sfondo */
            color: white;
            /* Colore del testo */
            transition: background-color 0.3s;
        }

        /* Stile al passaggio del mouse sui pulsanti */
        #tabuser_wrapper .dt-buttons button:hover {
            background-color: #45a049;
            /* Cambio colore al passaggio del mouse */
        }
    </style>
    <link rel="stylesheet" href="/assets/datatable/datatables.min.css" />
    <script src="/assets/datatable/datatables.js"></script>
</head>

<body class="w3-light-grey">

    <!-- Top container -->
    <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
        <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey"
            onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
        <img class="w3-bar-item w3-right" src="<?php echo base_url(); ?>/assets/image/logo.png" alt="Logo"
            style="max-height: 50px; max-width:10%;">
    </div>
    <!-- Sidebar/menu -->
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
        <div class="w3-container w3-row">
            <div class="w3-col s4" onclick="document.getElementById('avatarnodale').style.display='block'">
                <img src="<?php base_url(); ?><?php echo $list['avatar']; ?>" id="avatar"
                    class="w3-circle w3-margin-right" style="width:46px">
            </div>
            <div class="w3-col s8 w3-bar">
                <span>Welcome, <strong><?php echo auth()->user()->first_name; ?></strong></span><br>
            </div>
        </div>
        <hr>
        <div class="w3-container">
            <h5>Dashboard</h5>
        </div>
        <div class="w3-bar-block">
            <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black"
                onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu
            </a>

            <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i> 
                <?php echo lang('Auth.overview'); ?>
            </a>

            <a href="#" class="w3-bar-item w3-button w3-padding" onclick="Createagenda()"><i
                    class="fa fa-calendar fa-fw"></i> 
                <?php echo lang('Auth.calendar'); ?>
            </a>

            <a href="#" class="w3-bar-item w3-button w3-padding" onclick=" $('#ShowUploadFileForm').show();"><i
                    class="fa fa-cloud-upload fa-fw"></i>  <?php echo lang('Auth.newReport'); ?>
            </a>

            <a href="#" class="w3-bar-item w3-button w3-padding" onclick="menagereport();">
                <i class="fa fa-list-ol"></i> 
                <?php echo lang('Auth.workReport'); ?>
            </a>

            <a href="#" class="w3-bar-item w3-button w3-padding" onclick="resetpassword();"><i
                    class="fa fa-key"></i> 
                <?php echo lang('Auth.changepassword'); ?>
            </a>

            <a href="#" class="w3-bar-item w3-button w3-padding" onclick="editcompany()"><i
                    class="fa fa-building"></i> 
                <?php echo lang('Auth.editcompany'); ?>
            </a>

            <a href="#" class="w3-bar-item w3-button w3-padding" onclick="newuser();">
                <i class="fa fa-user"></i> 
                <?php echo lang('Auth.newUser'); ?>
            </a>


            <a href="#" class="w3-bar-item w3-button w3-padding" onclick="InsertPrivacyPolicy();"><i
                    class="fa fa-key"></i> 
                <?php echo lang('Auth.InsertPrivacyPolicy'); ?>
            </a>



            <a href="<?php echo site_url('/logout'); ?>" class="w3-bar-item w3-button w3-padding"><i
                    class="fa fa-sign-out fa-fw"></i>  <?php echo lang('Auth.esci'); ?></a>
        </div>
    </nav>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer"
        title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main w3-animate-left" id="main" style="margin-left:300px;margin-top:43px;">
        <?php echo csrf_field(); ?>
        <!-- Header -->
        <header class="w3-container" style="padding-top:22px">
            <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
        </header>
        <h3><?php echo $list['registration']; ?></h3>
        <!-- begin show reoprt if exsit-->
        <div class="w3-container">
            <div>
                <h5> <?php echo esc($list['showreport']); ?> </h5>
            </div>
            <div class="w3-responsive w3-container custom-overflow">
                <?php foreach ($list['listfile'] as $file) { ?>
                    <div class="w3-col m4 l3 s3 w3-white ">
                        <form method="post" action="/DownloadReportAdmimarea">
                            <input type="hidden" name="idexsam" value="<?php echo esc($file['idexsam']); ?>">
                            <input type="hidden" name="filename" value="<?php echo esc($file['filename']); ?>">
                            <input type="hidden" name="timestamp" value="<?php echo esc($file['timestamp']); ?>">
                            <button type="submit" class="custom-button w3-tiny">
                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                <p class="w3-margin-left"><?php echo esc($file['display_name']); ?> </p>
                            </button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- end show reoprt if exsit-->
        <!-- begin appointment request-->
        <div class="w3-responsive w3-margin w3-container w3-card-4">
            <h5><?php echo $list['showappointment']; ?> </h5>
            <table class="w3-table w3-striped w3-white w3-border-black"
                style=" max-height: 300px; overflow:scroll " id="RequestAppointmentTable">
                <thead>
                    <th><?php echo lang('Auth.Cognome'); ?></th>
                    <th><?php echo lang('Auth.Nome'); ?></th>
                    <th><?php echo lang('Auth.Indirizzo'); ?></th>
                    <th> <?php echo lang('Auth.Citta'); ?></th>
                    <th><?php echo lang('Auth.telefono'); ?></th>
                    <th><?php echo lang('Auth.group_name'); ?></th>
                    <th><?php echo lang('Auth.Donationdate'); ?></th>
                    <th><?php echo lang('Auth.Grupposanguigno'); ?></th>
                    <th><?php echo lang('Auth.rh'); ?></th>
                    <th></th>
                </thead>
                <tbody>
                    <?php

                    foreach ($list['appointmentpending']  as $appointment) {
                    ?>
                        <tr id="rowpendig<?php echo $appointment->id_appointment; ?>">
                            <td> <?php echo esc($appointment->surname); ?> </td>
                            <td> <?php echo esc($appointment->first_name); ?> </td>
                            <td> <?php echo esc($appointment->address); ?> </td>
                            <td> <?php echo esc($appointment->City_of_residence); ?> </td>
                            <td> <?php echo esc($appointment->phone_number); ?> </td>
                            <td> <?php echo esc($appointment->company_name); ?> </td>
                            <td> <?php echo esc($appointment->appointmentdate); ?> </td>
                            <td> <?php echo esc($appointment->group_type); ?> </td>
                            <td> <?php echo esc($appointment->rh_factor); ?> </td>
                            <td> <button class="w3-button w3-xlarge w3-green editappoint"
                                    title="<?php echo lang('Auth.editandconfirm'); ?>" id="editappoint"
                                    data-id="<?php echo $appointment->id_appointment; ?>"><i class="fa fa-check-square"
                                        aria-hidden="true"></i>
                                </button>
                            </td>
                            <td> <button class="w3-button w3-xlarge w3-green delappoint"
                                    title="<?php echo lang('Auth.editandconfirm'); ?>" id="delappoint"
                                    data-id="<?php echo $appointment->id_appointment; ?>"><i class="fa fa-trash"
                                        aria-hidden="true"></i>
                                </button>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
        <!-- end appointment request-->
        <!-- begin appointment of the day table-->
        <div class="w3-responsive w3-container w3-card-4 w3-margin">
            <h5><?php echo  $list['showconfirmedappointment']; ?> </h5>
            <table class="w3-table w3-striped w3-white w3-border-black" id="AppointmentoOfDay">
                <thead>
                    <th><?php echo lang('Auth.Cognome'); ?></th>
                    <th><?php echo lang('Auth.Nome'); ?></th>
                    <th><?php echo lang('Auth.Indirizzo'); ?></th>
                    <th> <?php echo lang('Auth.Citta'); ?></th>
                    <th><?php echo lang('Auth.telefono'); ?></th>
                    <th><?php echo lang('Auth.group_name'); ?></th>
                    <th><?php echo lang('Auth.Donationdate'); ?></th>
                    <th><?php echo lang('Auth.Grupposanguigno'); ?></th>
                    <th><?php echo lang('Auth.rh'); ?></th>
                    <th></th>
                </thead>
                <tbody>
                    <?php
                    $con = 1;
                    foreach ($list['todayappointment']  as $appointmentc) {
                    ?>
                        <tr id="<?php echo $con; ?>">
                            <td> <?php echo esc($appointmentc->surname); ?> </td>
                            <td> <?php echo esc($appointmentc->first_name); ?> </td>
                            <td> <?php echo esc($appointmentc->address); ?> </td>
                            <td> <?php echo esc($appointmentc->City_of_residence); ?> </td>
                            <td> <?php echo esc($appointmentc->phone_number); ?> </td>
                            <td> <?php echo esc($appointmentc->company_name); ?> </td>
                            <td> <?php echo esc($appointmentc->appointmentdate); ?> </td>
                            <td> <?php echo esc($appointmentc->group_type); ?> </td>
                            <td> <?php echo esc($appointmentc->rh_factor); ?> </td>
                            <td> <button>ok!</button> </td>
                        </tr>
                    <?php ++$con;
                    }
                    ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
        <!-- end appointment of the day table-->
        <!-- begin table new user -->
        <div class="w3-responsive w3-container w3-card-4 w3-margin">
            <h5><?php echo lang('Auth.tabellanuoviutenti'); ?> </h5>
            <table class="w3-table w3-striped w3-white w3-border-black" id="AppointmentoOfDay">
                <thead>
                    <th></th>
                    <th><?php echo lang('Auth.Cognome'); ?></th>
                    <th><?php echo lang('Auth.Nome'); ?></th>
                    <th><?php echo lang('Auth.Indirizzo'); ?></th>
                    <th> <?php echo lang('Auth.Citta'); ?></th>
                    <th><?php echo lang('Auth.zip_code'); ?></th>
                    <th><?php echo lang('Auth.Province_of_residence'); ?></th>
                    <th><?php echo lang('Auth.telefono'); ?></th>
                    <th><?php echo lang('Auth.Tipoutente'); ?></th>
                </thead>
                <tbody>
                    <?php foreach ($list['pending'] as $pending) { ?>
                        <tr class="w3-padding-16" id="lista<?php echo esc($pending['id']); ?>">
                            <td> <img src="<?php base_url(); ?><?php echo $pending['avatar']; ?>"
                                    class="w3-left w3-circle w3-margin-right" style="width:35px"></td>
                            <td><?php echo esc($pending['surname']); ?></td>
                            <td><?php echo esc($pending['first_name']); ?></td>
                            <td><?php echo esc($pending['address']); ?></td>
                            <td><?php echo esc($pending['City_of_residence']); ?></td>
                            <td><?php echo esc($pending['zip_code']); ?></td>
                            <td><?php echo esc($pending['Province_of_residence']); ?></td>
                            <td><?php echo esc($pending['phone_number']); ?></td>
                            <td><?php echo esc($pending['user_type']); ?></td>
                            <td><button class="w3-btn w3-white w3-border w3-border-green w3-round-large"
                                    onclick="activeuser(<?php echo esc($pending['id']); ?>)"
                                    data-val="<?php echo esc($pending['id']); ?>"><?= lang('Auth.btnattivautente'); ?></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- end table new user -->
        </div>
        <div class="w3-responsive  w3-container w3-card-4 w3-margin">
            <h5><?= lang('Auth.tabellautenti'); ?></h5>

            <table class="w3-table w3-striped w3-white" id="tabuser">
                <thead>
                    <tr>
                        <th></th>
                        <th><?= lang('Auth.Cognome'); ?></th>
                        <th><?= lang('Auth.Nome'); ?></th>
                        <th><?= lang('Auth.Citta'); ?></th>
                        <th><?= lang('Auth.telefono'); ?></th>
                        <th><?= lang('Auth.Tipoutente'); ?></th>
                        <th><?= lang('Auth.stato'); ?></th>
                        <th><?= lang('Auth.Grupposanguigno'); ?></th>
                        <th><?= lang('Auth.rh'); ?></th>
                        <th><?= lang('Auth.Fenotipo'); ?></th>
                        <th><?= lang('Auth.kell'); ?></th>
                        <th><?= lang('Auth.DonazioneSangue'); ?></th>
                        <th><?= lang('Auth.DonazionePlasma'); ?></th>
                        <th><?= lang('Auth.DonazionePiastrine'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $con = 0;
                    foreach ($list['alluser'] as $singleuser): ?>
                        <?php
                        // Verifica lo stato dell'utente
                        $isRed = ($singleuser['sangueisok'] == 'red' || $singleuser['plasmaisok'] == 'red' || $singleuser['piastrineisok'] == 'red');
                        $rowClass = $isRed ? 'w3-red' : '';
                        ?>
                        <tr class="<?= $rowClass; ?>">
                            <td>
                                <div class="w3-dropdown-click">
                                    <button onclick="openmenu(<?= esc($con); ?>)" class="w3-button w3-hover-white"
                                        id="<?= esc($con); ?>">
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                    </button>
                                    <div id="Demo<?= esc($con); ?>" class="w3-dropdown-content w3-bar-block w3-border">
                                        <a href="#" class="w3-bar-item w3-button"
                                            onclick="EditUser(<?= esc($singleuser['id']); ?>)"><?= lang('Auth.btneditutente'); ?></a>
                                        <a href="#" class="w3-bar-item w3-button"
                                            onclick="EditUserexsam(<?= esc($singleuser['id']); ?>)"><?= lang('Auth.btnEditUtenteExsam'); ?></a>
                                        <a href="#" class="w3-bar-item w3-button"
                                            onclick="sendmsg(<?= esc($singleuser['id']); ?>, 'donazione_sangue')">msg
                                            Invito donazione sangue</a>
                                        <a href="#" class="w3-bar-item w3-button"
                                            onclick="sendmsg(<?= esc($singleuser['id']); ?>, 'donazione_piastrine')">msg
                                            Invito donazione piastrine</a>
                                        <a href="#" class="w3-bar-item w3-button"
                                            onclick="sendmsg(<?= esc($singleuser['id']); ?>, 'donazione_plasma')">msg
                                            Invito donazione plasma</a>
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($singleuser['surname']); ?></td>
                            <td><?= esc($singleuser['first_name']); ?></td>
                            <td><?= esc($singleuser['City_of_residence']); ?></td>
                            <td><?= esc($singleuser['phone_number']); ?></td>
                            <td><?= esc($singleuser['user_type']); ?></td>
                            <td><?= esc($singleuser['stato']); ?></td>
                            <td><?= esc($singleuser['group_type']); ?></td>
                            <td><?= esc($singleuser['rh_factor']); ?></td>
                            <td><?= esc($singleuser['phenotype']); ?></td>
                            <td><?= esc($singleuser['kell']); ?></td>
                            <td><?= $isRed ? lang('Auth.utentesospeso') : esc($singleuser['sangueisok']); ?></td>
                            <td><?= $isRed ? lang('Auth.utentesospeso') : esc($singleuser['plasmaisok']); ?></td>
                            <td><?= $isRed ? lang('Auth.utentesospeso') : esc($singleuser['piastrineisok']); ?></td>
                        </tr>
                        <?php $con++; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th><?= lang('Auth.Cognome'); ?></th>
                        <th><?= lang('Auth.Nome'); ?></th>
                        <th><?= lang('Auth.Citta'); ?></th>
                        <th><?= lang('Auth.telefono'); ?></th>
                        <th><?= lang('Auth.Tipoutente'); ?></th>
                        <th><?= lang('Auth.stato'); ?></th>
                        <th><?= lang('Auth.Grupposanguigno'); ?></th>
                        <th><?= lang('Auth.rh'); ?></th>
                        <th><?= lang('Auth.Fenotipo'); ?></th>
                        <th><?= lang('Auth.kell'); ?></th>
                        <th><?= lang('Auth.DonazioneSangue'); ?></th>
                        <th><?= lang('Auth.DonazionePlasma'); ?></th>
                        <th><?= lang('Auth.DonazionePiastrine'); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- begin window avatar -->
        <div id="avatarnodale" class="w3-modal">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-blue">
                    <span onclick="document.getElementById('avatarnodale').style.display='none'"
                        class="w3-button w3-display-topright">&times;</span>
                    <h2> <?php echo lang('Auth.scegli_avatar'); ?></h2>
                </header>
                <div class="w3-row">
                    <?php foreach ($list['pathavatar'] as $pathavatar) { ?>
                        <div class="w3-col m4 l3 s3"
                            onclick="changeavatar('/assets/avatar/<?php echo $pathavatar; ?>')">
                            <img class="w3-circle w3-padding" src="/assets/avatar/<?php echo $pathavatar; ?>"
                                alt="avatar" style="width:80px">
                        </div>
                    <?php } ?>
                </div>
                <footer class="w3-container w3-blue">
                    <p><?php echo lang('Auth.associazione'); ?></p>
                </footer>
            </div>
        </div>
        <!-- end window avatar-->


    </div>
    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
        <h4><?php echo lang('Auth.associazione'); ?></h4>
    </footer>

    <!-- End page content -->
    </div>
    <!-- begin loading gif-->
    <div id="loading" class="w3-modal w3-white w3-opacity" style="display:none">
        <!--  begin  loading gif-->
        <img class="w3-padding w3-display-middle" src="/assets/imgwait/loading.gif" alt="wait...." />
    </div> <!-- end loading gif-->
    <!-- begin upload window-->
    <div id="ShowUploadFileForm" class="w3-modal">
        <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-grey">
                <span onclick="document.getElementById('ShowUploadFileForm').style.display='none'"
                    class="w3-button w3-display-topright">&times;</span>
                <h2> <?php echo lang('Auth.upload'); ?></h2>
            </header>
            <div class="w3-container" id="responseMsg"></div>
            <div class="w3-row">
                <form method="post" action="<?php echo site_url('uploadreferti'); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="w3-half">
                        <label for="files">File:</label>
                        <input type="file" class="w3-input" id="files" name="files[]" multiple />
                    </div>
                    <div class="w3-half">
                        <input type="button" class="btn btn-success" id="submit" value="Upload">
                    </div>
                </form>
            </div>
            <footer class="w3-container w3-gray">
                <p><?php echo lang('Auth.associazione'); ?></p>
            </footer>
        </div>
    </div> <!-- end upload window-->
    <!-- start window exsamlis -->
    <div id="examlisedit"></div>
    <!-- end window exsamlis -->
    <!-- begin window form appointment-->
    <div id="formbooknodal" class="w3-modal">
        <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-grey">
                <span onclick="document.getElementById('formbooknodal').style.display='none'"
                    class="w3-button w3-display-topright">&times;</span>
                <h2> <?php echo lang('Auth.bookdonation'); ?></h2>

            </header>
            <div class="w3-row">
                <h6>
                    <span><?php echo lang('Auth.bookdonation'); ?></span>
                    <input type="date" id="dayinput" name="dayinput" class="w3-input w3-border w3-round-xlarge" onchange="showform()">
                </h6>

            </div>
            <input type="text" name="day" id="day" hidden>
            <input type="text" name="type" id="type" hidden>
            <input type="text" name="dateday" id="dateday" hidden>
            <input type="text" name="iduser" id="iduser" hidden>
            <input type="text" name="idappointment" id="idappointment" hidden>


            <div class="w3-row">

                <label for="timeslot"><?php echo lang('Auth.timeSlot'); ?></label>
                <select class="w3-select w3-border w3-round-xlarge" id="timeslot" onchange="resetselect()">
                </select>

                <label for="exsamselector"><?php echo lang('Auth.donationTypeLabel'); ?></label>
                <select class="w3-select w3-border w3-round-xlarge" id="exsamselector" onchange="showhours()">
                </select>

                <label for="timeexsam"><?php echo lang('Auth.choosetime'); ?></label>
                <select class="w3-select w3-border w3-round-xlarge" id="timeexsam" onchange="showButton()">
                </select>
                <div class="w3-row">
                    <label for="textesam"><?php echo lang('Auth.userNote'); ?></label>
                    <textarea name="note" id="note" class="w3-input w3-border w3-round-xlarge" rows="4" cols="50" placeholder="<?php echo lang('Auth.noteDonationFomrplaceholder'); ?>"></textarea>
                </div>



            </div>
            <div class="w3-row id=" saverowbotton">
                <button class="w3-btn w3-xxlarge" id="modifyappointment" style="float: right;" disabled><i
                        class="fa fa-save" aria-hidden="true"></i></button>
                <button class="w3-btn w3-xxlarge" id="acceptappointment" style="float: right;">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </button>

            </div>


            <footer class="w3-container w3-grey">
                <p><?php echo lang('Auth.footerprenota'); ?></p>
            </footer>
        </div>
    </div>
    <!-- end window form appointment-->
</body>

<script>
    function sendmsg(id, type) {
        $('#loading').show();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('sendmsg'); ?>",
            data: {
                id: id,
                type: type,
                [csrfName]: csrfHash,
            },
            dataType: "json",
            success: function(data) {
                $('#loading').hide();
                $('input[name="csrf_token"]').val(data.token);

            }
        });
    }
    // change avatar
    function changeavatar(avatar) {
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash
        $.ajax({
            url: "<?php echo site_url('UpdateAvatarImage'); ?>",
            type: 'post',
            dataType: "json",
            data: {
                avatar: avatar,
                [csrfName]: csrfHash, // CSRF Token
            },
            success: function(data) {
                console.log(data.token);
                // Update CSRF Token
                $('input[name="csrf_token"]').val(data.token);
                document.getElementById('avatarnodale').style.display = 'none';
                $("#avatar").attr("src", data.data[0].newavatar);
            }
        });
    }

    // Get the Sidebar
    var mySidebar = document.getElementById("mySidebar");

    // Get the DIV with overlay effect
    var overlayBg = document.getElementById("myOverlay");

    // Toggle between showing and hiding the sidebar, and add overlay effect
    function w3_open() {
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
            overlayBg.style.display = "none";
        } else {
            mySidebar.style.display = 'block';
            overlayBg.style.display = "block";
        }
    }

    // Close the sidebar with the close button
    function w3_close() {
        mySidebar.style.display = "none";
        overlayBg.style.display = "none";
    }


    function editcompany() {
        $('#loading').show();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('editcompany'); ?>",
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

    function activeuser(dataId) {
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('ActivateUser'); ?>",
            data: {
                id: dataId,
                [csrfName]: csrfHash,
            },
            dataType: "json",
            success: function(data) {
                $('input[name="csrf_token"]').val(data.token);
                $("#lista" + data.id).remove();
            }
        });

    }

    function openmenu(id) {
        var x = document.getElementById("Demo" + id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }



    function Createagenda() {
        $('#loading').show();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('ManageCalendar'); ?>",
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

    function newuser() {
        $('#loading').show();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('NewUserView'); ?>",
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

    function menagereport() {
        $('#loading').show();
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

    function resetpassword() {
        $('#loading').show();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('Newpassword'); ?>",
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

    function InsertPrivacyPolicy() {
        $('#loading').show();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('InsertPrivacyPolicy'); ?>",
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

    function EditUserexsam(dataId) {
        $('#examlisedit').show();
        $('#loading').show();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('EditUserexsam'); ?>",
            data: {
                id: dataId,
                [csrfName]: csrfHash,
            },
            dataType: "html",
            success: function(data) {
                $('input[name="csrf_token"]').val(data.token);
                $('#loading').hide();
                $('#examlisedit').html(data)
            }
        });

    }

    function EditUser(dataId) {
        $('#loading').show();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
        $.ajax({
            type: "post",
            url: "<?php echo site_url('EditUser'); ?>",
            data: {
                id: dataId,
                [csrfName]: csrfHash,
            },
            dataType: "html",
            success: function(data) {
                $('#loading').hide();

                $('#main').html(data)
            }
        });

    }
    $(document).ready(function() {
        $('#submit').click(function() {
            var csrfName = 'csrf_token'; // CSRF Token name
            var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
            var files = $('#files')[0].files;
            var fd = new FormData();
            //console.log(files);
            if (files.length > 0) {
                for (var x = 0; x < files.length; x++) {
                    fd.append('files[]', files[x]);
                }
                fd.append([csrfName], csrfHash);

                // Hide alert 
                $('#responseMsg').hide();

                // AJAX request 
                $.ajax({
                    url: "<?php echo site_url('uploadreferti'); ?>",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        $('input[name="csrf_token"]').val(data.token);
                        if (data.msg === true && Array.isArray(data.listerror)) {
                            var errorstring = '';
                            data.listerror.forEach(function(errorObj) {
                                errorstring += errorObj.list + ' ';
                            });
                            alert(errorstring);
                        } else {
                            $('#ShowUploadFileForm').hide();
                            alert("Tutti i file sono stati caricati correttamente!");
                        }
                    },
                    error: function(data) {

                    }
                });
            } else {
                alert("Please select a file.");
            }

        });

        $('#tabuser').DataTable({
            dom: 'Bftip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    let column = this;
                    let title = column.header().textContent;
                    if (title !== '') {
                        // Crea un campo input per la ricerca con larghezza del 100%
                        let input = document.createElement('input');
                        input.placeholder = title;
                        input.style.width = '100%'; // Imposta la larghezza al 100%
                        input.style.boxSizing =
                            'border-box'; // Assicurati che il padding sia incluso nella larghezza
                        input.classList.add('w3-input', 'w3-round-xlarge', 'w3-border');

                        // Verifica che il footer esista e inserisci il campo input
                        let footer = column.footer();
                        if (footer) {
                            footer.replaceChildren(input);

                            // Aggiungi listener per la ricerca
                            input.addEventListener('keyup', function() {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                        }
                    }
                });
            }
        });
        $(document).on('click', '.editappoint', function(e) {
            e.preventDefault();
            var csrfName = 'csrf_token'; // CSRF Token name
            var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
            let id = $(this).data('id');
            $('#loading').show();
            $.ajax({
                type: "post",
                url: "<?php echo site_url('appointmentdettail'); ?>",
                data: {
                    id: id,
                    [csrfName]: csrfHash,
                },
                dataType: "json",
                success: function(response) {
                    $('#loading').hide();
                    $('#formbooknodal').show();
                    if (response.msg === 'ok') {
                        console.log(response.appointmentdettail[0].appointmentdate);
                        newdate = response.appointmentdettail[0].appointmentdate.split("-").reverse().join("-");
                        $('#dayinput').val(newdate);
                        $("#timeslot").append('<option value=' + response.appointmentdettail[0].appointmentHour + '>' + response.appointmentdettail[0].appointmentHour + '</option>');
                        $("#exsamselector").append('<option value=' + response.appointmentdettail[0].exsamtype + '>' + response.appointmentdettail[0].exsamtype + '</option>');
                        $("#timeexsam").append('<option value=' + response.appointmentdettail[0].appointmentHour + '>' + response.appointmentdettail[0].appointmentHour + '</option>');
                        $('#note').val(response.appointmentdettail[0].userNote);
                        $('#iduser').val(response.appointmentdettail[0].id_user);
                        $('#idappointment').val(response.appointmentdettail[0].id_appointment)
                    }


                }
            });
        });
        $('#acceptappointment').click(function(e) {
            var id = $('#idappointment').val();
            var iduser = $('#iduser').val();
            var csrfName = 'csrf_token'; // CSRF Token name
            var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
            $.ajax({
                type: "post",
                url: "<?php echo site_url('appointmentconfirm'); ?> ",
                data: {
                    [csrfName]: csrfHash,
                    id: id,
                    iduser: iduser
                },
                dataType: "json",
                success: function(response) {
                    if (response.msg === 'ok') {
                        $('#formbooknodal').hide();
                        $('#rowpendig' + id).remove();


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
        $('#modifyappointment').removeAttr('disabled');
    }

    function showform() {
        var day = $('#dayinput').val();

        const dayweek = new Date(day);
        console.log(dayweek);

        const dayname = dayweek.getDay(); // Gets the day of the week (0-6)
        const dayNames = ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"];

        //console.log(dayNames[dayname]); //       

        var type = $('#exsamselector').val();
        var csrfName = 'csrf_token'; // CSRF Token name
        var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash
        $.ajax({
            url: "<?php echo site_url('slot_time'); ?>", //  l'URL  endpoint 
            type: 'POST',
            data: {
                'type': 'cyclical',
                'day': dayNames[dayname],
                [csrfName]: csrfHash, // CSRF Token
            },
            success: function(response) {
                $('#acceptappointment').attr('disabled', true);
                $('input[name="csrf_token"]').val(response.token);
                // Dati per la select 'timeslot'
                var timeslots = response.timeslots; // Array di fasce orarie
                var timeslotSelect = $('#timeslot');
                timeslotSelect.empty(); // Svuota la select esistente
                timeslotSelect.append('<option value="100"> scegli-- </option>');
                $.each(timeslots, function(index, value) {
                    if (value !== 0 && value !== null && value !== '') {
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

</html>