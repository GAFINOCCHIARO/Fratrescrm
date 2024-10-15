<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- jQuery UI -->
       <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        
        <title>Registrazione Utente</title>
    </head>



    <?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>



    <div class="w3-container w3-section">
   <!--   <div class=" w3-col s12 m6 l4>-->
        <div class="w3-content w3-section">
            <h5 class="w3-panel w3-leftbar w3-border-amber w3-pale-yellow w3-padding-16"><?= lang('Auth.register') ?>  </h5>
            <?php if (session('error') !== null) : ?>
            <div class="w3-panel w3-alert w3-red" role="alert"><?= session('error') ?></div>
            <?php elseif (session('errors') !== null) : ?>
            <div class="w3-panel w3-alert" role="alert">
                <?php if (is_array(session('errors'))) : ?>
                <?php foreach (session('errors') as $error) : ?>
                <?= $error ?>
                <br>
                <?php endforeach ?>
                <?php else : ?>
                <?= session('errors') ?>
                <?php endif ?> 
             </div>
            <?php endif ?>

            <form action="<?= url_to('register') ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="avatar" id="avatar" value="/assets/avatar/avatar_default.jpg">
               <input type="hidden" name="unique_code" id="unique_code" value="0000">
                <input type="hidden" name="authorized" id="authorized" value="0">
                <input type="hidden" name="id_association" id="id_association" value="0" >
              <fieldset> 
                <legend> <?= lang('Auth.labelform'); ?> </legend>
                <!-- begin row user type-->
                <div class="w3-row w3-container">
                    <label>
                        <?= lang('Auth.label_tipo_iscrizione'); ?> <br>
                        <input type="radio" class="w3-radio" name="user_type" id="user_type" value="donatore" required />
                        <?= lang('Auth.donatore'); ?>
                    </label>
                    <label>
                        <input type="radio" class="w3-radio" name="user_type" id="user_type" value="pre donazione" />
                        <?= lang('Auth.predonatore'); ?>
                    </label>
                </div>
                <!-- end row usertype-->
                <!-- begin row Username  e name form input-->
                <div class="w3-row">
                    <div class="w3-half w3-container">
                        <!-- Username -->
                        <label for="floatingfirst_nameInput"><?= lang('Auth.first_name') ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="floatingfirst_nameInput"
                            name="first_name" inputmode="text" autocomplete="first_name"
                            placeholder="<?= lang('Auth.first_name') ?>" value="<?= old('first_name') ?>" required />
                    </div>
                    <div class="w3-half w3-container">
                        <!-- surname-->
                        <label for="surname"><?= lang('Auth.surname') ?></label>
                        <input type="text" class="w3-input w3-border w3-round-xlarge" id="surname" name="surname"
                            inputmode="text" autocomplete="surname" placeholder="<?= lang('Auth.surname') ?>"
                            value="<?= old('surname') ?>" required />
                    </div>
                </div>
                <!-- end Username  e name form input-->
                <!-- Begin row ' birth_place County_of_birth zip_codebirth  date_of_birth birth_status document type tax number '   ,form input  -->
                <div class="w3-container w3-padding w3-margin-top" id="daticliente">
                  <fieldset>
                        <legend>Dati Anadrafici:</legend>
                  <div class="w3-row  ">
                     <div class="w3-quarter w3-container"> <!-- birth_place  citta di nascita-->
                            <label for="birth_place"><?= lang('Auth.birth_place') ?></label>
                               <input type="text" class="w3-input w3-border w3-round-xlarge" id="birth_place"
                                     name="birth_place" inputmode="birth_place" autocomplete="birth_place"
                                     placeholder="<?= lang('Auth.birth_place') ?>" value="<?= old('birth_place') ?>"
                                    required />
                     </div>
                      <div class="w3-quarter w3-container">   <!-- County_of_birth  paese di nascita-->
                        <label for="County_of_birth"><?= lang('Auth.County_of_birth') ?></label>
                              <input type="text" class="w3-input w3-border w3-round-xlarge" id="County_of_birth"
                                     name="County_of_birth" inputmode="County_of_birth" autocomplete="County_of_birth"
                                     placeholder="<?= lang('Auth.County_of_birth') ?>" value="<?= old('County_of_birth') ?>"
                                    required />
                    </div>                   
                    <div class="w3-quarter w3-container"><!-- zip code birth-->
                         <label for="zip_codebirth"><?= lang('Auth.zip_codebirth') ?></label>
                             <input type="text" class="w3-input w3-border w3-round-xlarge" id="zip_codebirth" name="zip_codebirth"
                                    inputmode="text" autocomplete="zip_codebirth" placeholder="<?= lang('Auth.zip_codebirth') ?>"
                                    value="<?= old('zip_codebirth') ?>" required />
                    </div>
                    <div class="w3-quarter w3-container"> <!-- birth_status nazione di nascita--> 
                        <label for="birth_status"><?= lang('Auth.birth_status') ?></label>
                            <input type="text" class="w3-input w3-border w3-round-xlarge" id="birth_status"
                                    name="birth_status" inputmode="birth_status" autocomplete="birth_status"
                                    placeholder="<?= lang('Auth.birth_status') ?>" value="<?= old('birth_status') ?>"
                                    required />
                    </div>
                  </div>
                  <div class="w3-row w3-margin-bottom">
                    <div class="w3-fifth w3-container"> <!-- date_of_birth -->
                        <label for="date_of_birth"><?= lang('Auth.date_of_birth') ?></label>
                            <input type="date" class="w3-input w3-border w3-round-xlarge" id="date_of_birth"
                                    name="date_of_birth" inputmode="date_of_birth" autocomplete="date_of_birth"
                                   placeholder="<?= lang('Auth.date_of_birth') ?>" value="<?= old('date_of_birth') ?>"
                                   required />
                    </div>
                    <div class="w3-fifth w3-container"> <!-- document type select-->
                           <label for="document_type"><?= lang('Auth.document_type') ?></label>
                           <select name="document_type" id="document_type" class="w3-select w3-border w3-round-xlarge">
                            <option value="0">Scegli----</option>
                            <option value="Carta identità">Carta d'identità</option>
                            <option value="Patente">Patente</option>
                            <option value="Passaporto">Passaporto</option>
                           </select>                          
                    </div>
                    <div class="w3-fifth w3-container">  <!--document number -->
                          <label for="document_number"><?= lang('Auth.document_number') ?></label>
                             <input type="text" class="w3-input w3-border w3-round-xlarge" id="document_number"
                                   name="document_number" inputmode="text" autocomplete="document_number"
                                   placeholder="<?= lang('Auth.document_number') ?>" value="<?= old('document_number') ?>" required />
                    </div>
                    <div class="w3-fifth w3-container"> <!--tax number -->
                        <label for="Tax_code"><?= lang('Auth.Tax_code') ?></label>
                             <input type="text" class="w3-input w3-border w3-round-xlarge" id="Tax_code" name="Tax_code"
                                  inputmode="text" autocomplete="Tax_code" placeholder="<?= lang('Auth.Tax_code') ?>"
                                   value="<?= old('Tax_code') ?>" required />
                    </div>  
                     <div class="w3-fifth w3-container"> <!--gender  tyoe -->
                        <label for="gender"><?= lang('Auth.gender') ?></label>
                          <select name="document_type" id="document_type" class="w3-select w3-border w3-round-xlarge">
                            <option value="0">Scegli----</option>
                            <option value="M">Maschio</option>
                            <option value="F">Femmina</option>
                           </select>                            
                    </div>  
                  </div>  
                  </fieldset>      
                </div>
                 <!-- end row ' birth_place County_of_birth zip_codebirth  date_of_birth birth_status document type tax number ' ,form input  -->
                <!-- Begin row form input 'address''City_of_residence','Province_of_residence', 'zip_code' -->
                <div class="w3-row w3-padding w3-margin-top">
                 <fieldset>
                 <legend>Dati residenza</legend>
                 <div class="w3-fifth w3-container"> <!-- City_of_residence-->
                  <label for="City_of_residence"><?= lang('Auth.City_of_residence') ?></label>
                  <input type="text" class="w3-input w3-border w3-round-xlarge" id="City_of_residence"
                    name="City_of_residence" inputmode="text" autocomplete="City_of_residence"
                    placeholder="<?= lang('Auth.City_of_residence') ?>" value="<?= old('City_of_residence')?>"
                    required />
                  </div>
                 <div class="w3-fifth w3-container"> <!-- Province_of_residence-->
                   <label for="Province_of_residence"><?= lang('Auth.Province_of_residence') ?></label>
                   <input type="text" class="w3-input w3-border w3-round-xlarge" id="Province_of_residence"
                    name="Province_of_residence" inputmode="text" autocomplete="Province_of_residence"
                    placeholder="<?= lang('Auth.Province_of_residence') ?>" value="<?= old('Province_of_residence') ?>"
                    required />
                </div>
               <div class="w3-fifth w3-container"> <!-- zip code-->
                <label for="zip_code"><?= lang('Auth.zip_code') ?></label>
                <input type="text" class="w3-input w3-border w3-round-xlarge" id="zip_code" name="zip_code"
                    inputmode="text" autocomplete="zip_code" placeholder="<?= lang('Auth.zip_code') ?>"
                    value="<?= old('zip_code') ?>" required />
               </div>
               <div class="w3-fifth w3-container">  <!--  state_of_residence-->
                <label for="state_of_residence"><?= lang('Auth.state_of_residence') ?></label>
                <input type="text" class="w3-input w3-border w3-round-xlarge" id="state_of_residence"
                    name="state_of_residence" inputmode="text" autocomplete="state_of_residence"
                    placeholder="<?= lang('Auth.state_of_residence') ?>" value="<?= old('state_of_residence') ?>"
                    required />
               </div>
               <div class="w3-fifth w3-container"> <!-- addres-->
                <label for="address"><?= lang('Auth.address') ?></label>
                <input type="text" class="w3-input w3-border w3-round-xlarge" id="address" name="address"
                    inputmode="text" autocomplete="address" placeholder="<?= lang('Auth.address') ?>"
                    value="<?= old('address') ?>" required />
               </div>
               </fieldset>
              </div>
              <!--  end row form input 'address''City_of_residence','Province_of_residence','zip_code' -->
                <!-- Begin row 'phone_number', email,form input  -->
                <div class="w3-row">
                <div class="w3-half w3-container">   <!-- email -->
                <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                <input type="email" class="w3-input w3-border w3-round-xlarge" id="floatingEmailInput" name="email"
                    inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                    value="<?= old('email') ?>" required />
                </div>
                <div class="w3-half w3-container"> <!-- phone_number -->
                <label for="phone_number"><?= lang('Auth.phone_number') ?></label>
                <input type="tel" class="w3-input w3-border w3-round-xlarge" id="phone_number" name="phone_number"
                    inputmode="phone_number" autocomplete="phone_number" placeholder="<?= lang('Auth.phone_number') ?>"
                    value="<?= old('phone_number') ?>" required />
                </div>
              </div>
              <!-- end row 'phone_number', email',form input  -->
               <!-- Begin row Password e repeat password form input -->
               <div class="w3-row">
                <div class="w3-half w3-container">  <!-- Password -->
                 <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                 <input type="password" class="w3-input w3-border w3-round-xlarge" id="floatingPasswordInput"
                    name="password" inputmode="text" autocomplete="new-password"
                    placeholder="<?= lang('Auth.password') ?>" required />
                </div>
                <div class="w3-half w3-container"> <!-- Password (Again) -->
                 <label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
                 <input type="password" class="w3-input w3-border w3-round-xlarge" id="floatingPasswordConfirmInput"
                    name="password_confirm" inputmode="text" autocomplete="new-password"
                    placeholder="<?= lang('Auth.passwordConfirm') ?>" required />
                </div>
               </div>
               <!-- end password e confimr passowrd row -->
               
               <div class="w3-row w3-container w3-padding">
                <textarea name="aut" id="aut" 
                      class="w3-input w3-border w3-round-xlarge w3-left-align" cols="80" rows="5">Con la presente dichiarazione, confermo di aver fornito il mio consenso al trattamento dei dati personali da parte dell'Associazione di donazione sangue per le seguenti finalità:
Fornire i risultati delle analisi della donazione di sangue I dati personali che verranno raccolti sono:
Nome e cognome del donatore
Codice fiscale del donatore
Data di nascita del donatore
Dati relativi alla donazione di sangue, come ad esempio la data della donazione, il tipo di sangue donato e i risultati delle analisi
Il consenso fornito è valido per un periodo di tempo illimitato.
L'utente può revocare il consenso in qualsiasi momento, contattando l'Associazione di donazione sangue all'indirizzo [indirizzo email] o al numero [numero di telefono].
L'Associazione di donazione sangue si impegna a trattare i dati personali degli utenti in modo sicuro e conforme alla legge.
L'Associazione di donazione sangue si riserva il diritto di modificare la presente dichiarazione di consenso in qualsiasi momento. 
                </textarea>
                <label for="">acconsento al trattamento dei dati</label>
                <input type="checkbox" name="acconsento" id="acconsento" class="w3-check w3-border w3-round-xlarge" onchange='handleChange(this);'>
               </div>
               <!-- Begin row button form input -->
              <div class="w3-container w3-col w3-mobile w3-center">
                <button type="submit" id="savebotton" class="w3-button w3-green w3- w3-margin-top" disabled><?= lang('Auth.register') ?></button>
                <p class="w3-text w3-center"><?= lang('Auth.haveAccount') ?> <a
                    href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a></p>
               </div>
             </fieldset>
            </form>
        <!--</div> -->
       </div>
    </div>

    <script>
 $(document).ready(function(){
     // Initialize
  
      $("#City_of_residence" ).autocomplete({
        source: function( request, response ) {
           // CSRF Hash
           var csrfName = 'csrf_token'; // CSRF Token name
           var csrfHash =  $('input[name="csrf_token"]').val(); // CSRF hash
          //  console.log(csrfHash);
           // Fetch data
           $.ajax({
              url: "<?=site_url('Comuni/getComuni')?>",
              type: 'post',
              dataType: "json",
              data: {
                 search: request.term,
                 [csrfName]: csrfHash, // CSRF Token
                 type:'1'
              },
              success: function( data ) {
                console.log(data.token);
                 // Update CSRF Token
                 $('input[name="csrf_token"]').val(data.token);

                 response( data.data );
              }
           });
        },
        select: function (event, ui) {
           // Set selection
           // display the selected text 
           $("#City_of_residence").val(ui.item.nome_comune);
           $("#Province_of_residence").val(ui.item.citta); 
           $("#zip_code").val( ui.item.cap );
           $("#state_of_residence").val( ui.item.nazione );   
           return false;
        },
        focus: function(event, ui){
          $("#City_of_residence").val(ui.item.nome_comune);
          return false;
        },
      });
    $("#birth_place" ).autocomplete({
        source: function( request, response ) {
           // CSRF Hash
           var csrfName = 'csrf_token'; // CSRF Token name
           var csrfHash =  $('input[name="csrf_token"]').val(); // CSRF hash
           // console.log(csrfHash);
           // Fetch data
           $.ajax({
              url: "<?=site_url('Comuni/getComuni')?>",
              type: 'post',
              dataType: "json",
              data: {
                 search: request.term,
                 [csrfName]: csrfHash, // CSRF Token
                 type:'1'
              },
              success: function( data ) {
                console.log(data.token);
                 // Update CSRF Token
                 $('input[name="csrf_token"]').val(data.token);

                 response(data.data );
              }
           });
        },
        select: function (event, ui) {
           // Set selection // display the selected text
           $('#birth_place').val(ui.item.nome_comune); 
           $( "#County_of_birth" ).val( ui.item.citta );
           $( "#zip_codebirth" ).val( ui.item.cap );
           $( "#birth_status" ).val( ui.item.nazione );
           return false;
        },
        focus: function(event, ui){
          $( "#birth_place" ).val( ui.item.value );
           
          //$( "#userid" ).val( ui.item.value );
          return false;
        },
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
    function handleChange(checkbox) {
    if(checkbox.checked == true){
        document.getElementById("savebotton").removeAttribute("disabled");
    }else{
        document.getElementById("savebotton").setAttribute("disabled", "disabled");
   }
}

</script>

    