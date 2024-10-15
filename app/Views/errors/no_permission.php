<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Accesso Negato</h1>
    <p><?php echo session('error'); ?></p>
    <form>
        <?= csrf_field() ?>
        <button type="button" onclick="window.history.back();">Torna Indietro</button>
    </form>
</body>
</html>