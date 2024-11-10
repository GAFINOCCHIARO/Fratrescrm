<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<script link="./assets/jq/jquery-3.7.1.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue.css">

<body>
  <div class="w3-container
  ">
    <?php echo csrf_field(); ?>
    <nav class="w3-sidebar w3-bar-block w3-card" id="mySidebar" style="display:none">
      <div class="w3-container w3-theme-d2">
        <span onclick="closeSidebar()" class="w3-button w3-display-topright w3-large">X</span>
        <br>
        <div class="w3-padding w3-center" onclick="document.getElementById('avatarnodale').style.display='block'">
          <img class="w3-circle" src="<?php echo $list['avatar']; ?>" alt="avatar" id="avatar" style="width:75%">
        </div>
      </div>
      <a class="w3-bar-item w3-button" onclick="calendarview();"><?php echo lang('Auth.prenotadonazione'); ?></a>
      <a class="w3-bar-item w3-button" href="#"><?php echo lang('Auth.userMessage'); ?></a>
      <!--<a class="w3-bar-item w3-button" href="#">Note</a>-->
      <a class="w3-bar-item w3-button" href="<?php echo site_url('/logout'); ?>">Esci</a>
    </nav>

    <header class="w3-top w3-bar w3-theme">
      <button class="w3-bar-item w3-button w3-xxxlarge w3-hover-theme" onclick="openSidebar()">&#9776;</button>
      <h1 class="w3-bar-item">Area riservata</h1>
    </header>
    <div class="w3-container" style="margin-top:90px">
      <hr>
      <div class="w3-cell-row">
        <div class="w3-cell" style="width:30%">
          <img class="w3-circle" id="avatarreferto" src="<?php echo $list['avatar']; ?>" style="width: 80px;">
        </div>
        <div class=" w3-cell w3-container">
          <h3>Referti</h3>
          <div>
            <h5> <?php echo esc($list['showreport']); ?> </h5>
          </div>
          <div class="w3-container custom-overflow">
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
            <?php  } ?>
          </div>
        </div>
      </div>
      <hr>
      <div class="w3-container" id="userdesk">

      </div>
      <hr>
    </div>

    <footer class="w3-container w3-bottom w3-theme w3-margin-top">
      <h3><?php echo lang('Auth.associazione'); ?></h3>
    </footer>


    <!-- Finestra nodale per avatar-->
    <div id="avatarnodale" class="w3-modal">
      <div class="w3-modal-content w3-card-4">
        <header class="w3-container w3-blue">
          <span onclick="document.getElementById('avatarnodale').style.display='none'" class="w3-button w3-display-topright">&times;</span>
          <h2> <?php echo lang('Auth.scegli_avatar'); ?></h2>
        </header>
        <div class="w3-row">
          <?php foreach ($list['pathavatar'] as $pathavatar) { ?>
            <div class="w3-col m4 l3 s3" onclick="changeavatar('/assets/avatar/<?php echo $pathavatar; ?>')">
              <img class="w3-circle w3-padding" src="/assets/avatar/<?php echo $pathavatar; ?>" alt="avatar" style="width:80%">
            </div>
          <?php } ?>
        </div>
        <footer class="w3-container w3-blue">
          <p><?php echo lang('Auth.associazione'); ?></p>
        </footer>
      </div>
    </div>
    <div id="loading" class="w3-modal w3-white w3-opacity" style="display:none">
      <!--  begin  loading gif-->
      <img class="w3-padding w3-display-middle" src="/assets/imgwait/loading.gif" alt="wait...." />
    </div> <!-- end loading gif-->
  </div>
  <script>
    function calendarview() {
      $('#loading').show();
      var csrfName = 'csrf_token'; // CSRF Token name
      var csrfHash = $('input[name="csrf_token"]').val(); // CSRF hash 
      $.ajax({
        type: "post",
        url: "<?php echo site_url('Userappointment'); ?>",
        data: {
          [csrfName]: csrfHash,
        },
        dataType: "html",
        success: function(data) {
          $('#loading').hide();
          $('#mySidebar').hide();
          $('#userdesk').html(data)
        }
      });
    }

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
          $("#avatarreferto").attr("src", data.data[0].newavatar);
          $("#avatarcalendario").attr("src", data.data[0].newavatar);
          $("#avatarnote").attr("src", data.data[0].newavatar);

        }
      });
    }

    function openSidebar() {
      document.getElementById("mySidebar").style.display = "block";
    }

    function closeSidebar() {
      document.getElementById("mySidebar").style.display = "none";
    }
  </script>

</body>