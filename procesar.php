<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="Estilos.css">
    <title>Procesando Archivos</title>
</head>
<body>
<?php
    if(isset($_POST['correo']) && isset($_POST['nombre']) && isset($_POST['CodeCarnet']) 
    && isset($_POST['Age']) && isset($_POST['Curse']) && isset($_FILES['photo']))
    {
        echo "<div class='alert alert-success'>";
        echo "<strong>Success!</strong> !Formulario Validado correctamente .</div>";
        $correo = $_POST["correo"];
        $nombre = $_POST["nombre"];
        $carnet = $_POST["CodeCarnet"];
        $Edad = $_POST["Age"];
        $Curso = $_POST["Curse"];
        $foto = $_FILES["photo"];

        $NombreArchivo = $foto["name"];
        $rutaTemp = $_FILES["photo"]["tmp_name"];
        $rutaServidor = "Imagenes/";
        $extension = pathinfo($NombreArchivo,PATHINFO_EXTENSION);
        $nombreImagen = $_FILES["photo"]["name"] = $nombre.".".$extension;
        $rutaDest = $rutaServidor.$nombreImagen;

        require_once "ClaseEstudiante.php";
        $Estudiantes = array();
        $Estudiante = new Alumno($correo,$nombre,$carnet,$Edad,$Curso,$rutaDest);
        $FicheroDest = "Ficheros/Registro.txt";

        if(file_exists($FicheroDest)==true)
        {
            $s = file_get_contents($FicheroDest);
            $RegistroEst = unserialize($s);
            foreach($RegistroEst as $Est)
            {
                if($Est->Getnombre() == $nombre)
                {
                    $Validar = true;
                    break;
                }
                else
                {
                    $Validar = false;
                }
            }
            if($Validar == true)
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong>Warning!</strong>El nombre del alumno ya existe introduzca otro nombre.</div>";
                echo "<div class='container-fluid text-center' ><img src= 'tenor.gif' id='GifError'></div>";
                echo "<div class='boton col-auto text-center'>
                <a href= 'Formulario.php' onclick='window.close()' 
                type= 'button' class= 'btn btn-danger' style= width:50%;>Cambiar nombre</a></div>";
            }
            else if ($Validar == false)
            {
                array_push($RegistroEst,$Estudiante);
                move_uploaded_file($rutaTemp,$rutaDest);

                echo "<div class='alert alert-success'>";
                echo "<strong>Success!</strong> Guardado Correctamente.</div>";
                echo "<div class='container pt-3'>";
                    echo "<fieldset>";
                        echo "<div class='container text-center' style='padding-top: 25px'>";   
                            echo "<table class='table'>";
                            echo "<tr></tr>";
                            echo "<tr><th colspan='2'>Archivo Guardado</th></tr>";
                            echo "<tr><th>Foto</th><th>Informacion</th>";
                            echo "<tr>";
                            echo "<td class='border border-info warning' align='center'>";
                            echo "<img src= '$rutaDest' id='ImagenPreview'>";
                            echo "</td>";
                            echo "<td class='border border-info' align='left'>";
                            $Estudiante->imprimir();
                            echo "</tr>";
                            echo "</table>";
                        echo "</div>";
                    echo "</fieldset>";
                echo "</div>";
                echo "<div class='boton col-auto text-center'><a href= 'Formulario.php' onclick='window.close ()' type= 'button' class= 'btn btn-info' style= width:50%;>Regresar</a></div>";
            }    
            $serializar = serialize($RegistroEst);
            file_put_contents($FicheroDest,$serializar);        
        }
        else if(file_exists($FicheroDest)== false)
        {
            echo "<div class='alert alert-success'>";
            echo "<strong>Success!</strong> Guardado Correctamente.</div>";
            array_push($Estudiantes,$Estudiante);
            $serializar = serialize($Estudiantes);
            file_put_contents($FicheroDest,$serializar);
            move_uploaded_file($rutaTemp,$rutaDest);
            echo "<div class='container pt-3'>";
                echo "<fieldset>";
                    echo "<div class='container text-center' style='padding-top: 25px'>";   
                        echo "<table class='table'>";
                        echo "<tr></tr>";
                        echo "<tr><th colspan='2'>Archivo Guardado</th></tr>";
                        echo "<tr><th>Foto</th><th>Informacion</th>";
                        echo "<tr>";
                        echo "<td class='border border-info warning' align='center'>";
                        echo "<img src= '$rutaDest' id='ImagenPreview'>";
                        echo "</td>";
                        echo "<td class='border border-info' align='left'>";
                        $Estudiante->imprimir();
                        echo "</tr>";
                        echo "</table>";
                    echo "</div>";
                echo "</fieldset>";
            echo "</div>";
            echo "<div class='boton col-auto text-center'><a href= 'Formulario.php' onclick='window.close()' type= 'button' class= 'btn btn-info' style= width:50%;>Regresar</a></div>";
        }     
    }
    else
    {
        echo "<script>window.close()</script>";
    }
?>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
