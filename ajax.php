<?php
include("librosjson.php");
if(isset($_POST["buscar"])){
    $libros = json_decode(buscar($_POST["buscar"], 8));
        for ($i = 0; $i != count($libros->libros); $i++) {
            echo '<div class="libro"><a href="libro?libro=' . utf8_decode($libros->libros[$i]->nombre) . '">';
            echo "<img src='" . $libros->libros[$i]->imagen . "'><br>";
            echo utf8_decode($libros->libros[$i]->nombre);
            echo '</a></div>';
        }
}
if(isset($_POST["libro"])){
    $datos = json_decode(info($_POST["libro"]), true);
    for ($i = 1; $i != count($datos) + 1; $i++) {
    ?>
        <div class="libro">
            <div class="imagen">
                <img class="imag" src="<?php echo $datos[$i]["imagen"] ?>" alt="">
            </div>
            <div class="datos">
                <h1 class="titulo">
                    <?php echo $datos[$i]["nombre"] ?>
                </h1>
                <h2>
                    <?php echo $datos[$i]["autor"] ?>
                </h2>
                <h3 style="<?php
                            if (str_replace(" ", "", $datos[$i]["disponible"]) == "Dispoñible") {
                                echo 'color: green; !important';
                            }else{
                                echo 'color: red; !important';
                            }
                            ?>">
                    <?php echo $datos[$i]["disponible"] ?>
                </h3>
                <h3>
                    <img src="<?php echo googlelogo($datos[$i]["editorial"]) ?>" alt="">
                </h3>

            </div>
        </div>
    <?php
    }
}
?>