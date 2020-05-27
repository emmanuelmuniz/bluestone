<?php

session_start();


if(isset($_SESSION['idUser']))
    header("Location: panel.php");

if(isset($_SESSION['message']))
    unset($_SESSION['message']);

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['submit'])){
    require "conexion.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuario WHERE email = '$email'";

    $result = mysqli_query($conn, $query);

    // Verifico que exista un usuario con el email ingresado
    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        // Verifico que la contraseña ingresada sea la correcta 
        // if(password_verify($password, $row['password'])){ (uso esa funcion si la contraseña esta encriptada en la base de datos)
        //     $_SESSION['message'] = "Sesion iniciada";
        //     $_SESSION['idUser'] = $row['idUsuario'];
        //     echo"Hola";
        //     Header("Location: panel.php");  
        // }

        if($password == $row['password']){
            $_SESSION['message'] = "Sesion iniciada";
            $_SESSION['idUser'] = $row['idUsuario'];
            $_SESSION['userName'] = $row['nombre'];
            Header("Location: panel.php"); 
            $_SESSION['message'] = "Email correcto y contraseña correcta";
        }
        else {
            $_SESSION['message'] = "Contraseña incorrecta, intente nuevamente";
        }  
    }
    else {
        $_SESSION['message'] = "Email incorrecto, intente nuevamente";
    } 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Piedra&display=swap" rel="stylesheet"> 
    <!--Css-->
    <link rel="stylesheet" href="css/register-login.css?v=<?php echo time(); ?>" title="registercss">
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <title>BlueStone - Iniciar sesión</title>
</head>
<body>
    <header>
        <div class="container-fluid">
            <div class="row menu" >
                <div class="logo col-12 col-md-4">
                    <a href="index.php">BlueStone</a>
                </div>

                <div class="navegacion col-12 col-md-4">
                    <a href="index.php">Home</a>
                    <a href="#">Acerca de</a>
                    <a href="#">Contacto</a>
                </div>

                <div class="buttons col-12 col-md-4">
                    <a href="registro.php">Registrate</a>
                </div>
            </div>
    </header>

    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="login.php">
            <div class="titulo col-sm-12">
                <h2>Iniciar sesión</h2>
            </div>
            <div class="form-group">
                <label for="Emaillogin" class="col-sm-12 control-label">Email</label>
                <div class="col-sm-12">
                    <input type="text" name="email" id="Emaillogin" placeholder="Ingrese el Email" class="form-control" autofocus required>
                </div>
            </div>
            <div class="form-group">
                <label for="paswordlogin" class="col-sm-12 control-label">Contraseña</label>
                <div class="col-sm-12">
                    <input type="password" name="password" id="passwordlogin" placeholder="Ingrese su contraseña" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Iniciar sesión" class="btn btn-primary btn-block"></input>
            </div>
            <?php if(isset($_SESSION['message'])): ?>
            <div class="bg-danger text-white alert">
                <p><?php echo $_SESSION['message']?></p>
            </div>
            <?php endif; ?>
        </form> <!-- form -->
    </div> <!-- container -->
</body>
</html>