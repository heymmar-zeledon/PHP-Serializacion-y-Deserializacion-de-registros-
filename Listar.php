<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="Estilos2.css">
    <title>Resultados</title>
</head>
<body>
    <style>
        html,body{ margin: 0;}
    </style>
    <div id="ContenedorPrincipal" class="m-0 row">
        <div class="col-md-9 container border">
            <?php
            $FicheroDest = "Ficheros/Registro.txt";
            if(file_exists($FicheroDest)==true)
            {
                require_once "ClaseEstudiante.php";
                $FicheroImg = "Imagenes/";
                $Regist = file_get_contents($FicheroDest);
                $RegistroEst = unserialize($Regist);
                $NumElem = count($RegistroEst);
                echo "<div class='container pt-3'>";
                    echo "<fieldset>";
                        echo "<div class='container'>";   
                            echo "<table class='table table-bordered'>";
                                echo "<tr></tr>";
                                echo "<tr><th class='border border-info warning' 
                                colspan='2'><p><h6>Resultados</h6><h4>Listado de Alumnos</h4></p></th></tr>";
                                echo "<tr><th class='border border-info warning'>Foto</th>
                                <th class='border border-info warning'>Información</th></tr>";
                                for($i = 0; $i < $NumElem; $i++)
                                {
                                    echo "<tr>";
                                    echo "<td class='border border-info warning' align='center'>";
                                    $Img = $RegistroEst[$i]->foto;
                                    echo "<img src= '$Img' id='ImgView'>";
                                    echo "</td>";
                                    echo "<td class='border border-info' align='left'>";
                                    $RegistroEst[$i]->imprimir();
                                    echo "<a href='Editar.php?Edit=$i'>Editar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='Borrar.php?N=$i'>Eliminar</a></td>";
                                    echo "</tr>";
                                }
                                echo "<tr>
                                <td colspan='2' class='border border-info warning' align='center'>
                                <a href= 'Formulario.php' onclick='window.close()'>Ir a la pagina principal</a></td></tr>";
                            echo "</table>";
                        echo "</div>";
                    echo "</fieldset>";
                echo "</div>";
            }
            else
            {
                    echo "<br>";
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Warning!</strong>No existe ningun registro actualmente.</div>";
                    echo "<div class='container-fluid text-center' ><img src= 'xd.gif' id='GifError'></div>";
                    echo "<div class='boton col-auto text-center'>";
                    echo "<br> <a href= 'Formulario.php' onclick='window.close()' 
                    type= 'button' class= 'btn btn-secondary' style= width:50%;>Regresar</a></div>";
            }
            ?>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>