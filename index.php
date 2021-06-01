<?php
include("librosjson.php");
?>

<style>
    * {
        font-family: 'Ubuntu', sans-serif;
    }

    .holder-libros img {
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
        width: 20%;
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

    a {
        text-decoration: none;
        background: none;
        color: black;
    }

    .buscador {
        text-align: center;
    }

    button {
        background: none;
        text-decoration: none;
        border: none;
        font-size: 25px;
        border: 4px solid black;
        border-radius: 10px;
        margin: 20px;
    }

    input {
        font-size: 25px;
        border-radius: 20px;
        padding: 10px;

    }

    input:focus,
    select:focus,
    textarea:focus,
    button:focus {
        outline: none;
    }

    .centered {
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    nav {
        height: 100px;
        text-align: center;
        background-color: white;
        margin-bottom: 20px;
    }

    nav img {
        height: 80px;
    }

    .admin {
        position: fixed;
        left: 0;
        top: 10;
    }

    .fade-in-bottom {
        -webkit-animation: fade-in-bottom .6s cubic-bezier(.39, .575, .565, 1.000) both;
        animation: fade-in-bottom .6s cubic-bezier(.39, .575, .565, 1.000) both
    }

    @-webkit-keyframes fade-in-bottom {
        0% {
            -webkit-transform: translateY(50px);
            transform: translateY(50px);
            opacity: 0
        }

        100% {
            -webkit-transform: translateY(0);
            transform: translateY(0);
            opacity: 1
        }
    }

    @keyframes fade-in-bottom {
        0% {
            -webkit-transform: translateY(50px);
            transform: translateY(50px);
            opacity: 0
        }

        100% {
            -webkit-transform: translateY(0);
            transform: translateY(0);
            opacity: 1
        }
    }

    .puff-in-center {
        -webkit-animation: puff-in-center .7s cubic-bezier(.47, 0.000, .745, .715) both;
        animation: puff-in-center .7s cubic-bezier(.47, 0.000, .745, .715) both
    }

    @-webkit-keyframes puff-in-center {
        0% {
            -webkit-transform: scale(2);
            transform: scale(2);
            -webkit-filter: blur(4px);
            filter: blur(4px);
            opacity: 0
        }

        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-filter: blur(0);
            filter: blur(0);
            opacity: 1
        }
    }

    @keyframes puff-in-center {
        0% {
            -webkit-transform: scale(2);
            transform: scale(2);
            -webkit-filter: blur(4px);
            filter: blur(4px);
            opacity: 0
        }

        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-filter: blur(0);
            filter: blur(0);
            opacity: 1
        }
    }

    .media {
        margin-left: -5px;
        margin-right: -5px;
        font-size: 25px;
        margin: 10px;
        padding: 5px;
    }

    .media.off {
        border-radius: 25px 0px 0px 25px;
        margin-right: 0px !important;
        font-size: 50px;

    }
</style>

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="iconos/css/all.css" rel="stylesheet">
    <title>Biblioteca Asorey</title>
</head>
<nav>
    <a href="./"><img style="display: inline;" src="logo.png" height="100%" alt=""></a>
    <form class="admin" method="post" action="https://musica.asorey.net">
        <button class="media off" value=""><i class="fas fa-music"></i></button>
    </form>
</nav>
<div class="buscador">
    <input type="text" id="libro" name="libro" placeholder="Busca o libro..." <?php if(isset($_POST["libro"])){echo "value='".$_POST["libro"]."' onload='buscar()'";} ?>>
    <br>
    <button type="button" id="search" onclick="buscar()">Buscar</button>
</div>

<div id="libros" class="holder-libros">

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
<script>
    function buscar() {
        document.getElementById("libros").innerHTML = "<img class='centered' src='loading.gif' >";
        var libro = document.getElementById("libro").value;
        $.ajax({

            type: 'post',
            url: 'ajax.php',
            data: {
                buscar: libro,
            },
            success: function(response) {
                document.getElementById("libros").innerHTML = response;
            },
            error: function() {}
        });
    }
</script>
<script>
    var input = document.getElementById("libro");

    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
</script>