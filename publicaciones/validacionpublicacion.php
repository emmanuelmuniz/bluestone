<?php
session_start();
if(isset($_SESSION['messageSignup']))
unset($_SESSION['messageSignup']);

$bandera=0;
if( isset($_POST['title']) ) {
    $titulo=$_POST['title'];
    }
    if( isset($_POST['description']) ) {
    $descripcion=$_POST['description'];
    }
    if( isset($_POST['categories']) ) {
    $categoria=$_POST['categories'];
    }
    //id usuario//
    $idusuario= $_SESSION['idUser'];
    //restricciones archivo//
    $permitidos=array("application/pdf");
    $limite_kb=100000;

    $_SESSION['messageSignup'] = array();
    //titulo//
    if(trim($titulo)==''){
        $bandera=1;
        array_push($_SESSION['messageSignup'], "Ingrese un Titulo Correcto");
    }else{
        if( (ctype_alpha ( $titulo )) == true){ //validacion de solo letras//
        }else{
            $bandera=1;
            array_push($_SESSION['messageSignup'], "Ingrese solo letras en el Titulo");
        }

    }

    //Descripcion//
    if(trim($descripcion)==''){
        $bandera=1;
        array_push($_SESSION['messageSignup'], "Ingrese una Descripción valida");
    }
    //Archivo//
    if(in_array($_FILES['uploadedfilecv']['type'],$permitidos) && $_FILES['uploadedfilecv']['size']<=$limite_kb*1024){    //1024 porque size toma los datos en bits//
        $archivo = $_FILES['uploadedfilecv']['tmp_name'];
        $archContenido = addslashes(file_get_contents($archivo));
        require "../conexion.php";
        $sql="SELECT * from publicacion order by idPublicacion desc limit 1";

        $result=mysqli_query($conn,$sql);
        $id=1;
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($publicacion);
            $id = ($row['idPublicacion']+1);
        }
        $ruta= "archivos/".$id.".pdf";
        mysqli_close($conn);
        move_uploaded_file($_FILES['uploadedfilecv']['tmp_name'],$ruta);
    }else {
        $bandera=1;   
        array_push($_SESSION['messageSignup'], "Error al subir el archivo.");
    }
    
    if($bandera==0){
        require "../conexion.php";
        $sql="INSERT INTO publicacion (titulo, descripcion, categoria, curriculum,fechaPublicacion, tipoPublicacion, idUsuario) VALUES ('$titulo', '$descripcion', '$categoria', '$ruta', now(),'Normal', '$idusuario')";
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
      } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
      mysqli_close($conn);
      header('Location: index.php?categoria=todas&page=0&do=borrarBusqueda');
    }else{
      header('Location: subida.php');
    }                    
?>