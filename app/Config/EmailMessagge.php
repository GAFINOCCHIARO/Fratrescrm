<?php

namespace App\Config;

class EmailMessagge
{
    public static $messages = [
        'welcome' => [
            'subject' => 'Benvenuto nella nostra Associazione!',
            'body' => "Caro/a {nome} {Cognome},<br>

                Siamo lieti di darti il benvenuto nella nostra Associazione! La tua decisione di unirti a noi dimostra il tuo impegno e la tua generosità nel voler aiutare chi è in difficoltà.
                Grazie a persone come te, possiamo fare la differenza nella nostra comunità.
                <br>
                Cosa aspettarsi:
                <br>
                Ti terremo aggiornato sui prossimi eventi e iniziative attraverso la nostra newsletter.
                <br>
                Supporto: Il nostro team è sempre disponibile per rispondere a qualsiasi domanda tu possa avere. Non esitare a contattarci 
                via email a {mailassoc} o telefonicamente al {telefonoassociazione} .
                Prossimi Passi:
                <br>
                Accesso all' area riservata:<br>
                Per accedere all' area riservata del nostro sito {sitoreferti}, utilizza la email da te fornita durante la registrazione e il tuo codice fiscale. 
                Al primo accesso ti verrà richiesto di cambiare la password per garantire la sicurezza del tuo account.<br>
                Partecipa agli eventi: <br>
                Consulta il nostro calendario degli eventi per trovare una sessione di volontariato vicino a te. 
                La tua prima esperienza è un momento speciale e saremo felici di accoglierti e guidarti .
                Coinvolgi i tuoi amici: Invita amici e familiari a unirsi alla nostra causa. Ogni nuovo volontario può fare la differenza.
                <br>
                Risorse Utili: <br>
                Visita il nostro sito web: {linksitoassociazione}  <br>
                Accedi alla tua area riservata: {sitoreferti}  <br>
                Grazie ancora per aver scelto di fare la differenza. Il tuo contributo è prezioso e insieme possiamo salvare molte vite.  <br>  <br>

                Con gratitudine,  <br>

                {nomeassociazione}  <br>
                {indirizzoassociazione}  <br>
                {cittaassociazione}  <br>
                {mailassoc}  <br>
                {telefonoassociazione}  <br>
                {linksitoassociazione}",
        ],
        'donazione_sangue' => [
            'subject' => 'Invito alla Donazione di Sangue',
            'body' => 'Caro/a {nome} {Cognome},<br><br>
            Siamo lieti di informarti che sei idoneo per donare il sangue!<br><br>
            La tua generosità può fare una grande differenza nella vita di molti. Ti invitiamo ad accedere alla tua area riservata del nostro sito {sitoreferti} 
            per consultare il nostro calendario delle donazioni e prenotare una sessione presso il nostro centro.<br><br>
            Grazie di cuore per il tuo contributo,<br><br>
            {nomeassociazione}<br>
            {indirizzoassociazione} <br>
            {cittaassociazione}<br>
            {mailassoc}<br>
            {telefonoassociazione}<br>
            {linksitoassociazione}',
        ],
        'donazione_piastrine' => [
            'subject' => 'Invito alla Donazione di Piastrine',
            'body' => 'Caro/a {nome} {Cognome},<br><br>
            Siamo lieti di informarti che sei idoneo per donare le piastrine!<br><br>
            Le tue piastrine possono aiutare molti pazienti a combattere gravi malattie. 
            Ti invitiamo ad accedere alla tua area riservata del nostro sito {sitoreferti} per  consultare il nostro calendario delle donazioni e 
            prenotare una sessione presso il nostro centro.<br><br>
            Grazie di cuore per il tuo contributo,<br><br>
            {nomeassociazione}<br>
            {indirizzoassociazione}<br>
            {cittaassociazione}<br>
            {mailassociazione}<br>
            {telefonoassociazione}<br>
            {linksitoassociazione}',
        ],
        'donazione_plasma' => [
            'subject' => 'Invito alla Donazione di Plasma',
            'body' => 'Caro/a {nome} {Cognome},<br><br>
            Siamo lieti di informarti che sei idoneo per donare il plasma!<br><br>
            Il tuo plasma è essenziale per trattare molte condizioni mediche. Ti invitiamo ad accedere alla tua area riservata del nostro sito {sitoreferti} per  consultare il nostro calendario delle donazioni e 
            prenotare una sessione presso il nostro centro.<br><br>
            Grazie di cuore per il tuo contributo,<br><br>
            {nomeassociazione}<br>
            {indirizzoassociazione}<br>
            {cittaassociazione}<br>
            {mailassoc}<br>
            {telefonoassociazione}<br>
            {linksitoassociazione}',
        ],
        'New_exsam' => [
            'subject' => 'Nuovo Referto Disponibile',
            'body' => 'Caro/a {nome} {Cognome},<br><br>
                Siamo lieti di informarti che un nuovo referto è stato pubblicato nella tua area riservata!<br><br>
                Ti invitiamo ad accedere alla tua area riservata del nostro sito {sitoreferti} per visualizzare il referto e ottenere ulteriori dettagli.<br><br>
                Grazie per la tua fiducia e collaborazione,<br><br>
                {nomeassociazione}<br>
                {indirizzoassociazione}<br>
                {cittaassociazione}<br>
                {mailassoc}<br>
                {telefonoassociazione}<br>
                {linksitoassociazione}',
        ],
        'exsamconfirm' => [
            'subject' => 'Conferma Appuntamento',
            'body' => 'Caro/a {nome} {Cognome},<br><br>
             Ti confermiamo che il tuo appuntamento è stato correttamente registrato.<br><br>
             Data e ora dell\'appuntamento: {data_appuntamento} alle {ora_appuntamento}<br>
            Luogo {luogo_appuntamento}<br><br>
            Ti ricordiamo di presentarti puntuale con un documento d\'identità valido.<br><br>
            Per qualsiasi dubbio o necessità, non esitare a contattarci.<br><br>
            Grazie per la tua collaborazione.<br><br>
            {nomeassociazione}<br>
            {indirizzoassociazione}<br>
            {cittaassociazione}<br>
            {mailassoc}<br>
            {telefonoassociazione}<br>
             {linksitoassociazione}'

        ], 
    ]; // fine array msg

    public static function getMessage($type)
    {
        return self::$messages[$type] ?? null;
    }
}
