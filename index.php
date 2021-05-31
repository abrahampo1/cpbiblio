<?php
include("librosjson.php");
?>

<style>
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
        width: 20% !important;
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
            height: 60px;
            text-align: center;
            background-color: white;
            margin-bottom: 20px;
        }
        nav img{
            height: 50px;
        }
</style>

<head>
    <meta charset="UTF-8">
</head>
<nav>
<a href="./"><img style="display: inline;" src="logo.png" height="100%" alt=""></a>
</nav>
<div class="buscador">
    <input type="text" id="libro" name="libro">
    <br>
    <button type="button" onclick="buscar()">Buscar</button>
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