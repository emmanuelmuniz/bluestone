<?php 
session_start();

// En el caso que haya un mensaje del registro, lo borro
if(isset($_SESSION['messageSignup']))
    unset($_SESSION['messageSignup']);

if(!isset($_GET['categoria']) || !isset($_GET['page'])){
    header("Location: panel.php?categoria=todas&page=0");
}

include 'conexion.php';

$categoria = $_GET['categoria'];
$paginaActual = $_GET['page'];


// Selecciono todas las publicaciones de la categoria seleccionada para calcular
// cantidad de paginas y la paginacion

if($categoria=="todas")
    $query = "SELECT * FROM publicacion";
else{
    $query = "SELECT * FROM publicacion WHERE categoria = '$categoria'";
}

if (mysqli_query($conn, $query)) {
    $publicaciones = mysqli_query($conn, $query);

    if(mysqli_num_rows($publicaciones) > 0){
        $cantPublicaciones = mysqli_num_rows($publicaciones);
        $publicacionesPorPagina = 2;
        
        $paginas = $cantPublicaciones/$publicacionesPorPagina;
        $paginas = ceil($paginas);
    }
} else {
echo "Error updating record: " . mysqli_error($conn);
}

if(mysqli_num_rows($publicaciones) > 0){
    if($paginaActual > $paginas)
        header("Location: panel.php?categoria=".$categoria."&page=".($paginas-1));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/panel.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">

    <title>BlueStone</title>
</head>
<body>
    <!-- Menú -->
    <header>
        <div class="container-fluid">
            <div class="row menu" >
                <div class="logo col-12 col-md-4">
                    <a class="marca "href="index.php">BlueStone</a>
                </div>

                <div class="navegacion col-12 col-md-4">
                    <a href="index.php">Home</a>
                    <a href="#">Acerca de</a>
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
                            <a class="dropdown-item" href="">Perfil</a>
                            <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Publicaciones -->
    <section>
        <div class="container-fluid">
            <div class="row main">
                <div class="col-md-7 order-2 order-sm-12">      
                    <div class="public-y-paginacion">
                        <h1>Publicaciones de candidatos</h1>  
                        <?php     

                        if (isset($cantPublicaciones) && mysqli_num_rows($publicaciones) > 0){

                            $desde = $paginaActual*$publicacionesPorPagina;
                            $desde = (string)$desde;

                            $publicacionesPorPagina = (string)$publicacionesPorPagina;

                            if($categoria=="todas")
                                $query = "SELECT idPublicacion, titulo, SUBSTRING(descripcion, 1, 50) AS descripcion, categoria FROM publicacion LIMIT $desde, $publicacionesPorPagina";
                            else{
                                $query = "SELECT idPublicacion, titulo, SUBSTRING(descripcion, 1, 50) AS descripcion, categoria FROM publicacion WHERE categoria = '$categoria' LIMIT $desde, $publicacionesPorPagina ";
                            }

                            if (mysqli_query($conn, $query)){          
                                $result = mysqli_query($conn, $query);

                                echo "<div class='publicaciones'>";

                                while($publicacion = mysqli_fetch_assoc($result)): ?>
                                    <a href="publicacion.php">
                                        <div class="publicacion">
                                            <div style="cursor: pointer;" onclick="publicacion.php">
                                                <?php echo "<h4>".$publicacion['titulo']. "</h4><br>"; ?>
                                                <?php echo "<p>".$publicacion['descripcion']. "...</p><br>"; ?>
                                                <?php echo $publicacion['categoria']. "<br>"; ?>
                                            </div>
                                        </div>
                                    </a>
                                    <hr>
                                <?php endwhile; ?>

                                </div>

                                <nav aria-label='Page navigation example'>
                                    <ul class="pagination">
                                        <li class="page-item <?php echo $paginaActual==0 ? ' disabled' : '' ?>"><a class="page-link" href="panel.php?categoria=<?php echo ($categoria)?>&page= <?php echo ($paginaActual-1)?>">Anterior</a></li>

                                        <?php for($i=0; $i<$paginas; $i++): ?>
                                        <li class="page-item 
                                        <?php echo $i == $paginaActual ? ' active' : ''?>">
                                            <a class="page-link" href="panel.php?categoria=<?php echo ($categoria)?>&page=<?php echo $i ?>"><?php echo ($i+1)?></a>
                                        </li>
                                        <?php endfor; ?>
                                
                                        <li class="page-item <?php echo $paginaActual==$paginas-1 ? ' disabled' : '' ?>"><a class="page-link" href="panel.php?categoria=<?php echo ($categoria)?>&page= <?php echo ($paginaActual+1)?>">Siguiente</a></li>
                                    </ul>
                                </nav>
                            <?php }
                            else{
                                echo "Error updating record: " . mysqli_error($conn);
                            }     
                        }
                        else{
                            echo "No hay publicaciones de la categoria " . $categoria;
                        }

                        
                        ?>
                    </div>
                </div>

                <div class="col-md-3 order-1 order-sm-12 categorias">
                    <?php
                    $categorias = array("Sistemas", "Administración", "Marketing", "Legales", "Diseño");
                    ?>
                    <ul class="list-group">
                        <li class="list-group-item text-light" id="tituloCat">Categorias</li>
                        <?php
                        if($categoria=="todas")
                            echo "<a class='list-group-item active' href=panel.php?categoria=todas&page=0>Todas</a>";
                        else
                            echo "<a class='list-group-item' href=panel.php?categoria=todas&page=0>Todas</a>";

                        foreach ($categorias as $area){
                            $query = "SELECT * FROM publicacion WHERE categoria = '$area'";
                            $resultado = mysqli_query($conn, $query);

                            if(mysqli_num_rows($resultado) > 0){
                                if($categoria==$area){
                                    echo "<a class='list-group-item active' href=panel.php?categoria=".$area."&page=0>".$area."</a>";
                                }
                                else
                                    echo "<a class='list-group-item' href=panel.php?categoria=".$area."&page=0>".$area."</a>";   
                            }
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </div>

        <?php mysqli_close($conn); ?>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>