<?php

session_start();

if(isset($_SESSION['idUser']))
    header("Location: index.php");

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['submit'])){
    require "conexion.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuario WHERE email = '$email'";

    $result = mysqli_query($conn, $query);

    // Verifico que exista un usuario con el email ingresado
    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);

        // Verifico que la contraseña ingresada sea la correcta 
        if(password_verify($password, $row['password'])){
            $_SESSION['idUser'] = $row['idUsuario'];
            $_SESSION['userName'] = $row['nombre'];
            $_SESSION['rol'] = $row['tipoUsuario'];
            Header("Location: publicaciones/index.php");
        }
        else {
            $error = "Contraseña incorrecta, intente nuevamente";
        }  
        mysqli_close($conn);
    }
    else {
        $error = "Email incorrecto, intente nuevamente";
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
    <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="marca "href="index.php">BlueStone</a>

                <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto linksMedio">
                        <li class="nav-item linkMedio">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item linkMedio">
                            <a class="nav-link" href="publicaciones">Publicaciones</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto acciones">
                        <?php if(!isset($_SESSION['idUser'])):?>
                            <li class="nav-item">
                                <a class="nav-link accion" href="login.php">Iniciar sesión</a>   
                            </li>     
                            <li class="nav-item">
                                <a class="nav-link accion" href="registro.php">Registrarse</a>   
                            </li>              
                        <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-user dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['userName']?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="publicaciones/subida.php">Crear publicación</a>
                                <a class="dropdown-item" href="publicaciones/misPublicaciones.php">Mis Publicaciones</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
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
            <?php if(isset($error)): ?>
            <div class="bg-danger text-white alert">
                <p><?php echo $error?></p>
            </div>
            <?php endif; ?>
        </form> <!-- form -->
    </div> <!-- container -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>