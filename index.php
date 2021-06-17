<?php
include("librosjson.php");
?>

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="iconos/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="cpbiblioui.css">
    <title>Biblioteca Asorey</title>
</head>
<nav>
    <a href="./"><img style="display: inline;" src="logo.png" height="100%" alt=""></a>
</nav>
<div class="buscador">
    <input type="text" id="libro" name="libro" placeholder="Busca o libro na biblioteca...">
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