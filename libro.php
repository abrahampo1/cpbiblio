<?php
if (!isset($_GET["libro"])) {
    header("location: /");
}
?>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    }

    nav img {
        height: 50px;
    }
</style>


<body  onload="buscar('<?php echo $_GET['libro']; ?>')">
<nav>
    <a href="./"><img style="display: inline;" src="logo.png" height="100%" alt=""></a>
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
            },
            error: function() {}
        });
    }
</script>