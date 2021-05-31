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
        if (file_exists("img/portadas/" . $nombre_libro . ".png")) {
            $path_libro = "img/portadas/" . $nombre_libro . ".png";
        } else {
            $path_libro = googleimage($nombre_libro);
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
        if($datos[0] == null || $datos[0] == ""){
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
                    $datosurl = utf8_decode($dom->getElementsByTagName("a")->item($i)->getAttribute('href'));
                    $datos = explode("Rexistro=", $datosurl);
                    $id_libro = explode("&", $datos[1]);
                    $id_libro = $id_libro[0];
                    $url_xunta = "http://www.opacmeiga.rbgalicia.org/DetalleRexistro.aspx?CodigoBiblioteca=$biblioteca&Rexistro=$id_libro&Formato=Etiquetas";
                    $httpClient = HttpClient::create();
                    $response = $httpClient->request('POST', $url_xunta);
                    error_reporting(E_ERROR | E_PARSE);
                    $content = $response->getContent();
                    $datos = explode("<td>", $content);
                    $datos = explode("<p>", $datos[118]);
                    $dom = new DOMDocument();
                    $dom->loadHTML($datos[0]);
                    $t = 1;
                    $titulo = utf8_decode($dom->getElementsByTagName("font")->item($t)->textContent);
                    if ($titulo == "Ampliar imaxe") {
                        $t++;
                        $titulo = utf8_decode($dom->getElementsByTagName("font")->item($t)->textContent);
                    }
                    $t = 1;
                    $autor = utf8_decode($dom->getElementsByTagName("a")->item($t)->textContent);
                    if ($autor == "Ampliar imaxe") {
                        $t++;
                        $autor = utf8_decode($dom->getElementsByTagName("a")->item($t)->textContent);
                    }
                    $materia = utf8_decode($dom->getElementsByTagName("a")->item($t + 2)->textContent);
                    $texto_completo = $dom->getElementsByTagName("tr")->item(3)->textContent;
                    $texto = explode(":", $texto_completo);
                    $editorial = explode("Publicación:", utf8_decode($texto_completo));
                    $editorial = explode(":", $editorial[1]);
                    $editorial = explode(",", $editorial[1]);
                    $editorial = $editorial[0];
                    $disponible = explode("Estado:", $texto_completo);
                    $disponible = explode(":", $disponible[1]);
                    $disponible = str_replace("Localización", "", utf8_decode($disponible[0]));
                    $etiqueta = str_replace("Nº rexistro", "", utf8_decode($texto[10]));
                    $idioma = utf8_decode($texto[5]);
                    $titulo = explode("/", $titulo);
                    $librojson[$array]->nombre = $titulo[0];
                    $librojson[$array]->autor = $autor;
                    $librojson[$array]->editorial = $editorial;
                    $librojson[$array]->materia = $materia;
                    $librojson[$array]->disponible = $disponible;
                    $librojson[$array]->etiqueta = $etiqueta;
                    $librojson[$array]->idioma = $idioma;
                    if (file_exists("img/portadas/" . $titulo[0] . ".png")) {
                        $path_libro = "img/portadas/" . $titulo[0] . ".png";
                    } else {
                        $path_libro = googleimage($titulo[0]);
                    }
                    $librojson[$array]->imagen = $path_libro;
                    $array++;
                }
            }
        }
    }
    return json_encode($librojson);
}
