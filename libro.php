<?php
if (isset($_GET["libro"])) {
    include("librosjson.php");
    $datos = json_decode(info($_GET["libro"]));
}
?>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
</head>
<style>
    * {
        font-family: 'Ubuntu', sans-serif;
    }

    .imagen {
        text-align: center;
    }

    .datos {
        text-align: center;
    }

    .imagen img {
        border-radius: 10px;
        width: 150px;
        -webkit-box-shadow: 0px 0px 35px -8px #000000;
        box-shadow: 0px 0px 35px -8px #000000;
    }
</style>

<body>
    <div class="imagen">
        <img src="<?php echo $datos->imagen ?>" alt="">
    </div>
    <div class="datos">
        <h1 class="titulo">
            <?php echo $datos->nombre ?>
        </h1>
        <h2>
            <?php echo $datos->autor ?>
        </h2>
        <h3>
            <?php echo $datos->disponible ?>
        </h3>
        <h3>
            <img src="<?php echo googlelogo($datos->editorial) ?>" alt="">
        </h3>
        
    </div>

</body>