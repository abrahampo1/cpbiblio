<?php
include("librosjson.php");
?>

<style>
    img {
        margin: 10px;
        border-radius: 10px;
        -webkit-box-shadow: 0px 0px 35px -8px #000000;
        box-shadow: 0px 0px 35px -8px #000000;
    }

    .titulo-libro {}

    .holder-libros {
        display: flex;
        flex-flow: wrap;
        justify-content: space-between;
        padding-left: 10%;
        padding-right: 10%;
    }

    .libro {
        text-align: center;
        margin: 20px;
        width: 19%;
    }

    @media only screen and (max-width: 600px) {
        .holder-libros {
            display: block;
        }

        .libro {
            text-align: center;
            margin: 20px;
            width: 90%;
        }
    }
</style>
<head>
    <meta charset="UTF-8">
</head>
<form action="" method="POST">
    <input type="text" name="libro">
    <button>Enviar</button>
</form>
<div class="holder-libros">
<?php
    if(isset($_POST["libro"])){
        $libros = json_decode(buscar($_POST["libro"], 16));
        for($i = 0; $i != count($libros->libros); $i++){
            echo '<div class="libro">';
            echo "<img src='".$libros->libros[$i]->imagen."'><br>";
            echo utf8_decode($libros->libros[$i]->nombre);
            echo '</div>';
        }
    }
?>
</div>