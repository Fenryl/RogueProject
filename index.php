<?php
    session_start();
require_once('header_footer.php') ;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Rogue Project</title>
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/global.css">
    <link rel="stylesheet" href="CSS/index.css">
    <script type="text/javascript" src="//cdn.jsdelivr.net/phaser/2.2.2/phaser.min.js"></script>
    <script type="text/javascript" src="game/arena.js"></script>
</head>
<body>

<?php headerHTML("index"); ?>
<div id="content" class="center">
    <div id="game"></div>
</div>
<?php footerHTML(); ?>

</body>
</html>