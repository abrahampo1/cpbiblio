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
        width: 19, 9%;
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
    header("Content-Type: text/html; charset=utf-8");

    use Symfony\Component\HttpClient\HttpClient;

    mb_http_output('UTF-8');
    mb_internal_encoding('UTF-8');
    include("googleapi.php");
    if (isset($_POST["libro"])) {
        $cantidad_libros = 5;
        $biblioteca = "PED039";
        $libro = $_POST["libro"];
        require('vendor/autoload.php');
        $url_xunta = "http://www.opacmeiga.rbgalicia.org/ResultadoBusqueda.aspx?TipoBusqueda=D&TipoValor=T&Valor=$libro&x=17&y=14&CodigoBiblioteca=$biblioteca";
        $httpClient = HttpClient::create();
        $response = $httpClient->request('POST', $url_xunta);
        error_reporting(E_ERROR | E_PARSE);
        $content = $response->getContent();
        //echo $content;
        $libros = explode("<td>", $content);
        for ($i = 0; $i != $cantidad_libros; $i++) {
            $dom = new DOMDocument();
            $dom->loadHTML($libros[120 + $i]);
            $nombre_libro = utf8_decode($dom->getElementsByTagName("a")->item(0)->textContent);
            $nombre_libro = str_replace("													", "", $nombre_libro);
            $nombre_libro = str_replace("												", "", $nombre_libro);
            $nombre_libro = chop($nombre_libro);
            $nombre_libro = str_replace(["\n", "\r"], "", $nombre_libro);
            echo "<div class='libro'><img src='" . googleimage($nombre_libro) . "'>";
            echo "<br>";
            $nombre_libro = utf8_encode($nombre_libro);
            echo "<p class='titulo-libro' id='titulo-libro'>" . utf8_decode($nombre_libro) . "</p>";
            echo "</div>";
        }
    }
    ?>
</div>