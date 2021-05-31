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
    $libro = urlencode($libro);
    $url_xunta = "http://www.opacmeiga.rbgalicia.org/ResultadoBusqueda.aspx?CodigoBiblioteca=$biblioteca&Valores=DT$libro";
    $httpClient = HttpClient::create();
    $response = $httpClient->request('POST', $url_xunta);
    error_reporting(E_ERROR | E_PARSE);
    $content = $response->getContent();
    $datos = explode("<td>", $content);
    $datos = explode("<p>", $datos[120]);
    $dom = new DOMDocument();
    $dom->loadHTML($datos[0]);
    $datos = utf8_decode($dom->getElementsByTagName("a")->item(0)->getAttribute('href'));
    $datos = explode("Rexistro=", $datos);
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
    if($titulo == "Ampliar imaxe"){
        $t++;
        $titulo = utf8_decode($dom->getElementsByTagName("font")->item($t)->textContent);
    }
    $t = 1;
    $autor = utf8_decode($dom->getElementsByTagName("a")->item($t)->textContent);
    if($autor == "Ampliar imaxe"){
        $t++;
        $autor = utf8_decode($dom->getElementsByTagName("a")->item($t)->textContent);
    }
    $editorial = utf8_decode($dom->getElementsByTagName("a")->item($t+1)->textContent);
    if($editorial == $autor){
        $t++;
        $editorial = utf8_decode($dom->getElementsByTagName("a")->item($t+1)->textContent);
    }
    $materia = utf8_decode($dom->getElementsByTagName("a")->item($t+2)->textContent);
    $texto_completo = $dom->getElementsByTagName("tr")->item(3)->textContent;
    $texto = explode(":", $texto_completo);
    $disponible = explode("Estado:", $texto_completo);
    $disponible = explode(":", $disponible[1]);
    $disponible = str_replace("Localización", "", utf8_decode($disponible[0]));
    $etiqueta = str_replace("Nº rexistro", "", utf8_decode($texto[10]));
    $idioma = utf8_decode($texto[5]);
    $titulo = explode("/", $titulo);
    $librojson->nombre = $titulo[0];
    $librojson->autor = $autor;
    $librojson->editorial = $editorial;
    $librojson->materia = $materia;
    $librojson->disponible = $disponible;
    $librojson->etiqueta = $etiqueta;
    $librojson->idioma = $idioma;
    if (file_exists("img/portadas/" . $imagen_libro . ".png")) {
        $path_libro = "img/portadas/" . $imagen_libro . ".png";
    } else {
        $path_libro = googleimage($imagen_libro);
    }
    $librojson->imagen = $path_libro;
    return json_encode($librojson);
}
