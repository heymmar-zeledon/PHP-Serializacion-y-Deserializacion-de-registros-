<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="Estilos2.css">
    <title>Document</title>
</head>
<body>
<?php
    $NumArchivo = $_GET['N'];
    if(isset($_POST["Borrado"]))
    {
        require_once "ClaseEstudiante.php";
        $FicheroDest = "Ficheros/Registro.txt";
        $Regist2 = file_get_contents($FicheroDest);
        $Registro2 = unserialize($Regist2);
        $Numelem = count($Registro2);
        $s1 = serialize($Registro2);
        file_put_contents($FicheroDest,$s1);
        if($Numelem == 1)
        {
            $Regis = file_get_contents($FicheroDest);
            $R4 = unserialize($Regis);
            $files = glob('Imagenes/*'); 
            foreach($files as $file)
            {
                if(is_file($file))
                    unlink($file);
            }
            unlink($FicheroDest);
        }
        else
        {
            $R3 = file_get_contents($FicheroDest);
            $Registro3 = unserialize($R3);
            for($i = 0; $i < $Numelem; $i++)
            {            
                if($i == $NumArchivo)
                {
                    $FicheroImg = $Registro3[$i]->Getfoto();
                    unlink($FicheroImg);
                    unset($Registro3[$i]);
                    break;
                }
            }
            $s2 = serialize($Registro3);
            file_put_contents($FicheroDest,$s2);
        }
        header('Location: Formulario.php');
    }
    else
    {
        require_once "ClaseEstudiante.php";
        $FicheroDest = "Ficheros/Registro.txt";
        $Regist = file_get_contents($FicheroDest);
        $RegistroEst = unserialize($Regist);
        $NumEstudent = 0;
        foreach($RegistroEst as $Estudent)
        {
            if($NumEstudent == $NumArchivo)
            {
                echo "<div class='container pt-3'>";
                echo "<fieldset>";
                    echo "<div class='container'>";   
                        echo "<table class='table table-bordered'>";
                            echo "<tr></tr>";
                            echo "<tr><th class='border border-danger warning' 
                            colspan='2'><div class='alert alert-danger'>
                            <strong>Esta seguro de eliminar este archivo? </strong> Pulse eliminar 
                            </div>
                            </th></tr>";
                            echo "<tr><th class='border border-info warning'>Foto</th>
                            <th class='border border-info warning'>Información</th></tr>";               
                            echo "<tr>";
                            echo "<td class='border border-info warning' align='center'>";
                            $Img = $Estudent->Getfoto();                       
                            echo "<img src= '$Img' id='ImgView'>";
                            echo "</td>";
                            echo "<td class='border border-info' align='left'>";
                            $Estudent->imprimir();
                            echo "Imagen: ".$Img;
                            echo "</tr>";
                            echo "<tr>";
                            echo "</table>";
                            echo "<div class='boton col-auto text-center'><form method='post'>
                            <input type='submit' class='form-control btn btn-danger' id='Borrado' value='Eliminar' name='Borrado' style= width:40%;>   
                            <a href= 'Formulario.php' onclick='window.close()' type= 'button' class= 'btn btn-secondary' style= width:25%;>Pagina principal</a> 
                            </form></div>";
                        echo "</div>";
                    echo "</fieldset>";
                echo "</div>";
                break;
            }
            $NumEstudent++;
        }
        $s = serialize($RegistroEst);
        file_put_contents($FicheroDest,$s);
    }
?>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
