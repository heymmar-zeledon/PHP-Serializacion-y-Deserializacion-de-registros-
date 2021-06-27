<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="Estilos.css">
    <title>Actualizar</title>
</head>
<body>
<?php
    $Indice = $_POST["indice"];
    require_once "ClaseEstudiante.php";
    $FicheroDest = "Ficheros/Registro.txt";
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
    

    $s = file_get_contents($FicheroDest);
    $RegistroEst = unserialize($s);

    $Elements = count($RegistroEst);
    //Variable Temp
    $EstudTemp = $RegistroEst[$Indice];

    unset($RegistroEst[$Indice]);
    $s1 = serialize($RegistroEst);
    file_put_contents($FicheroDest,$s1);

    if($Elements == 1)
    {
        //Archivo Actualizado 
        $EstudTemp->correo = $correo;
        $EstudTemp->nombre = $nombre;
        $EstudTemp->carnet = $carnet;
        $EstudTemp->edad = $Edad;
        $EstudTemp->curso = $Curso;
        
        //Cambio de foto
        $LocImg = $EstudTemp->foto;
        unlink($LocImg);
        $EstudTemp->foto = $rutaDest;
        move_uploaded_file($rutaTemp,$rutaDest);
            
        echo "<table class='table'>";
        echo "<tr></tr>";
        echo "<tr><th colspan='2'>
        <div class='alert alert-success'>
        <strong>Success!</strong> Archivo Actualizado.</div>
        </th></tr>";
        echo "<tr><th>Foto</th><th>Informacion</th>";
        echo "<tr>";
        echo "<td class='border border-info warning' align='center'>";
        $Img = $EstudTemp->Getfoto();
        echo "<img src= '$Img' id='ImagenPreview'>";
        echo "</td>";
        echo "<td class='border border-info' align='left'>";
        $EstudTemp->imprimir();
        echo "</tr>";
        echo "</table>";
        $s2 = file_get_contents($FicheroDest);
        $Registro = unserialize($s2);
        $RegistroTemp = $Registro;
        array_push($Registro,$EstudTemp);
        $Serializar = serialize($Registro);
        file_put_contents($FicheroDest,$Serializar);    
        echo "</fieldset>";
        echo "</div>";
    }
    else
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
            $s2 = file_get_contents($FicheroDest);
            $Registro = unserialize($s2);
            array_push($Registro,$EstudTemp);
            $Registro = array_values($Registro);
            $Serializar = serialize($Registro);
            file_put_contents($FicheroDest,$Serializar);

            echo "<div class='alert alert-danger'>";
            echo "<strong>Warning!</strong>El nombre del alumno ya existe elija otro nombre diferente.</div>";
            echo "<div class='container-fluid text-center' ><img src= 'tenor.gif' id='GifError'></div>";
            echo "<div class='boton col-auto text-center'>
            <a href= 'editar.php' onclick='window.close()' 
            type= 'button' class= 'btn btn-danger' style= width:50%;>Cambiar nombre</a></div>";
        }
        else if($Validar == false)
        {   
            //Archivo Actualizado 
            $EstudTemp->correo = $correo;
            $EstudTemp->nombre = $nombre;
            $EstudTemp->carnet = $carnet;
            $EstudTemp->edad = $Edad;
            $EstudTemp->curso = $Curso;
            
            //Cambio de foto
            $LocImg = $EstudTemp->foto;
            unlink($LocImg);
            $EstudTemp->foto = $rutaDest;
            move_uploaded_file($rutaTemp,$rutaDest);
                
            echo "<table class='table'>";
            echo "<tr></tr>";
                echo "<tr><th colspan='2'>
                <div class='alert alert-success'>
                    <strong>Success!</strong> Archivo Actualizado.</div>
                    </th></tr>";
                    echo "<tr><th>Foto</th><th>Informacion</th>";
                    echo "<tr>";
                    echo "<td class='border border-info warning' align='center'>";
                    $Img = $EstudTemp->Getfoto();
                    echo "<img src= '$Img' id='ImagenPreview'>";
                    echo "</td>";
                    echo "<td class='border border-info' align='left'>";
                    $EstudTemp->imprimir();
                    echo "</tr>";
                    echo "</table>";
                    $s2 = file_get_contents($FicheroDest);
                    $Registro = unserialize($s2);
                    array_push($Registro,$EstudTemp);
                    $Registro = array_values($Registro);
                    $Serializar = serialize($Registro);
                    file_put_contents($FicheroDest,$Serializar);    
                echo "</fieldset>";
            echo "</div>";
        }   
    }
    echo "<br>";
    echo "<div class='boton col-auto text-center'>";
    echo "<a href= 'Formulario.php' type= 'button' class= 'btn btn-secondary' style= width:25%; >Pagina principal</a>";
    echo "</div>";
?>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
