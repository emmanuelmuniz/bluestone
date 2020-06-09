<?php
session_start();

if(!isset($_SESSION['idUser']))
    header("Location: ../index.php");
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
    <link rel="stylesheet" href="../css/register-login.css?v=<?php echo time(); ?>" title="registercss">
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>
<body>
<header>
        <div class="container-fluid">
            <div class="row menu" >
                <div class="logo col-12 col-md-4">
                    <a class="marca "href="index.php">BlueStone</a>
                </div>

                <div class="navegacion col-12 col-md-4">
                    <a href="index.php">Home</a>
                    <a href="index.php?do=borrarBusqueda">Publicaciones</a>
                    <a href="#">Contacto</a>
                </div>        
                
                <?php if(!isset($_SESSION['idUser'])):?>
                <div class="buttons col-12 col-md-4">
                    <a href="login.php">Iniciar sesión</a>
                    <a href="registro.php">Registrarse</a>                    
                </div>

                <?php else: ?>
                <div class="menu-usuario col-12 col-md-4">
                    <div class="nav-item dropdown nav-perfil">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['userName']?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="subida.php">Crear publicación</a>
                            <a class="dropdown-item" href="../logout.php">Cerrar sesión</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <div class="container">
        <form action="validacionpublicacion.php" class="form-horizontal mx-auto" role="form" method="POST" enctype="multipart/form-data">   
            <div class="titulo col-sm-12">
                <h2>Sube tu CV...</h2>
            </div>
            <?php if(isset($_SESSION['messageSignup'])){ 
                if(is_array($_SESSION['messageSignup'])){ ?>
                    <div class="bg-danger text-white alert">
                    <p><?php foreach($_SESSION['messageSignup'] as $mensaje)
                        echo "* ".$mensaje."<br>";          
                        ?>
                    </p>
                </div>
                <?php } else{ ?>
                    <div class="bg-danger text-white alert">
                    <p><?php echo "* ".$_SESSION['messageSignup'];?></p>
                    </div>
                <?php }
                } ?>
            <div class="form-group">
                <label for="Title" class="control-label col-sm-12">Título</label>
                <div class="col-sm-12">
                    <input type="text" name="title"  class="form-control" value="" autofocus required>
                </div>
            </div>
            <div class="form-group">
                <label for="Description" class="col-sm-12 control-label">Breve Descripción</label>
                <div class="col-sm-12">
                <textarea class="form-control" name="description" rows="3" value="" autofocus required></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                <select class="form-control" id="selectcat" name="categories">
                    <option hidden selected>Elige una Categoría</option>
                    <option value='Marketing'>Marketing</option>
                    <option value='Enseñanza'>Enseñanza</option>
                    <option value='Recursos Humanos'>Recursos Humanos</option>
                    <option value='Industrial'>Industrial</option>
                    <option value='Tecnología'>Tecnología</option>
                    <option value='Diseño'>Diseño</option>
                    <option value='Legales'>Legales</option>
                </select>
                </div>
            </div>
            <div class="form-group">
                <label for="filecv" class="col-sm-12 control-label">Cargar CV</label>
                <div class="col-sm-12">
                    <input name="uploadedfilecv" type="file"  required />
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Subir">
            </div>
            
        </form> <!-- /form -->
    </div> <!-- ./container -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>