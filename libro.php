<?php
if (!isset($_GET["libro"])) {
    header("location: /");
}
?>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="iconos/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="cpbiblioui.css">
    <title>Cargando Libro...</title>
</head>


<body onload="buscar('<?php echo $_GET['libro']; ?>')">
    <nav>
        <a href="./"><img style="display: inline;" src="logo.png" height="100%" alt=""></a>
        <form class="admin" method="post" action="/">
            <button class="media off" value=""><i class="fas fa-arrow-left"></i></button>
        </form>
    </nav>
    <div id="libros" class="holder-libros">
    </div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function buscar(libro) {
        document.getElementById("libros").innerHTML = "<img class='centered' src='loading.gif' >";
        $.ajax({

            type: 'post',
            url: 'ajax.php',
            data: {
                libro: libro,
            },
            success: function(response) {
                document.getElementById("libros").innerHTML = response;
                document.title = document.getElementById("title").innerHTML;
            },
            error: function() {}
        });
    }
</script>