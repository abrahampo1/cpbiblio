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
    <title>Cargando Libro...</title>
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

    .libro {
        border-radius: 10px;
        -webkit-box-shadow: 0px 0px 5px -8px #000000;
        box-shadow: 0px 0px 5px -8px #000000;
        margin: 20px;
        margin-left: 20%;
        margin-right: 20%;
        padding: 25px;
    }

    .titulo {
        font-family: 'Pacifico', cursive;
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
    }

    nav img {
        height: 60px;
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

    .admin {
        position: fixed;
        left: 0;
        top: 10;
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


<body onload="buscar('<?php echo $_GET['libro']; ?>')">
    <nav>
        <a href="./"><img style="display: inline;" src="logo.png" height="100%" alt=""></a>
        <form class="admin" method="post" action="/">
            <button class="media off" value=""><i class="fas fa-arrow-left"></i></button>
        </form>
    </nav>
    <div id="libros">
    </div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
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