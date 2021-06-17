<?php

use Symfony\Component\HttpClient\HttpClient;

function buscar($libro, $cantidad_libros = 5)
{
    include("googleapi.php");
    $biblioteca = "PED039";
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
        $nombre_libro_google = $nombre_libro . " libro portada";
        if (file_exists("img/portadas/" . $nombre_libro_google . ".png")) {
            $path_libro = "img/portadas/" . $nombre_libro_google . ".png";
        } else {
            $path_libro = googleimage($nombre_libro_google);
        }
        $nombre_libro = utf8_encode($nombre_libro);
        $resultado_busqueda_libros->libros[$i]->nombre = $nombre_libro;
        $resultado_busqueda_libros->libros[$i]->imagen = $path_libro;
    }
    return json_encode($resultado_busqueda_libros);
}
function info($libro)
{
    include("googleapi.php");
    $biblioteca = "PED039";
    require('vendor/autoload.php');
    $imagen_libro = $libro;
    $paxina = 1;
    $libro = urlencode($libro);
    $haypag = true;
    while ($haypag == true) {
        $url_xunta = "http://www.opacmeiga.rbgalicia.org/ResultadoBusqueda.aspx?CodigoBiblioteca=$biblioteca&Valores=DT$libro&Paxina=$paxina";
        $paxina++;
        $httpClient = HttpClient::create();
        $response = $httpClient->request('POST', $url_xunta);
        error_reporting(E_ERROR | E_PARSE);
        $content = $response->getContent();
        $datosraw = explode("<td>", $content);
        $datos = explode("<p>", $datosraw[120]);
        if ($datos[0] == null || $datos[0] == "") {
            $haypag = false;
            break;
        }
        $dom = new DOMDocument();
        $dom->loadHTML($datos[0]);
        $ultimo = false;
        $array = 1;
        $intento = 0;
        for ($int = 120; $int != count($datosraw); $int++) {
            $datos = explode("<p>", $datosraw[$int]);
            $dom = new DOMDocument();
            $dom->loadHTML($datos[0]);
            for ($i = 0; $i != $dom->getElementsByTagName("a")->length; $i++) {
                $name = utf8_decode($dom->getElementsByTagName("a")->item(0)->textContent);
                if ($name == utf8_decode($dom->getElementsByTagName("a")->item($i)->textContent)) {
                    $id_libro = $id_libro[0];
                    $dom = new DOMDocument();
                    $dom->loadHTML($datos[0]);
                    $t = 0;
                    $titulo = utf8_decode($dom->getElementsByTagName("a")->item($t)->textContent);
                    $t++;
                    $autor = utf8_decode($dom->getElementsByTagName("a")->item($t)->textContent);
                    $t++;
                    $editorial = utf8_decode($dom->getElementsByTagName("a")->item($t)->textContent);
                    $disponible = explode("Estado:", $datos[0]);
                    $disponible = explode("Rexistro", $disponible[1]);
                    $disponible = utf8_encode($disponible[0]);
                    $disponible = utf8_decode($disponible);
                    $disp = new DOMDocument();
                    $disp->loadHTML($disponible);
                    $disponible = $disp->getElementsByTagName("font")->item(0)->textContent;
                    $disponible = utf8_decode($disponible);
                    $editorial = explode("Editorial:", $datos[0]);
                    $editorial = utf8_encode($editorial[1]);
                    $editorial = utf8_decode($editorial);
                    $disp = new DOMDocument();
                    $disp->loadHTML($editorial);
                    $editorial = $disp->getElementsByTagName("a")->item(0)->textContent;
                    $editorial = utf8_decode($editorial);
                    $etiqueta = explode("Localicación:", "", utf8_decode($datos[0]));
                    $etiqueta = explode("Estado:", $etiqueta[1]);
                    $librojson[$array]->nombre = $titulo;
                    $librojson[$array]->autor = $autor;
                    $librojson[$array]->editorial = $editorial;
                    $librojson[$array]->disponible = $disponible;
                    $librojson[$array]->etiqueta = $etiqueta;
                    if (file_exists("img/portadas/" . $titulo . ".png")) {
                        $path_libro = "img/portadas/" . $titulo . ".png";
                    } else {
                        $path_libro = googleimage($titulo);
                    }
                    $librojson[$array]->imagen = $path_libro;
                    $array++;
                }
            }
        }
    }
    return json_encode($librojson);
}
