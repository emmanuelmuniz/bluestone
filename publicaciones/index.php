<?php 
session_start();

// En el caso que haya un mensaje del registro, lo borro
if(isset($_SESSION['messageSignup']))
    unset($_SESSION['messageSignup']);

if(!isset($_GET['categoria']) || !isset($_GET['page'])){
    header("Location: index.php?categoria=todas&page=0");
}

$categoria = $_GET['categoria'];
$paginaActual = $_GET['page'];

// Selecciono todas las publicaciones de la categoria seleccionada para calcular
// cantidad de paginas y la paginacion

if(isset($_POST['busqueda'])){
    $_SESSION['busqueda'] = $_POST['busqueda'];
}

if(isset($_SESSION['busqueda'])){
    if(isset($_GET['do']) && $_GET['do'] == 'borrarBusqueda'){
        echo"weqwe";
        unset($_POST['busqueda']);
        unset($_SESSION['busqueda']);
        header("Location: index.php?categoria=todas&page=0");
    }
}

$orden=1;
include "consultasPublicaciones.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!-- CSS -->
    <link rel="stylesheet" href="../css/publicaciones.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">

    <title>BlueStone</title>
</head>
<body>
    <!-- Menú -->
    <header>
        <div class="container-fluid">
            <div class="row menu" >
                <div class="logo col-12 col-md-4">
                    <a class="marca "href="../index.php">BlueStone</a>
                </div>

                <div class="navegacion col-12 col-md-4">
                    <a href="../index.php">Home</a>
                    <a href="index.php?do=borrarBusqueda">Publicaciones</a>
                    <a href="#">Contacto</a>
                </div>        
                
                <?php if(!isset($_SESSION['idUser'])):?>
                <div class="buttons col-12 col-md-4">
                    <a href="../login.php">Iniciar sesión</a>
                    <a href="../registro.php">Registrarse</a>                    
                </div>

                <?php else: ?>
                <div class="menu-usuario col-12 col-md-4">
                    <div class="nav-item dropdown nav-perfil">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['userName']?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="">Perfil</a>
                            <a class="dropdown-item" href="../logout.php">Cerrar sesión</a>
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
            <div class="row">
                <div class="col-12 menu-buscador">
                    <form class="form-inline my-2 my-lg-0 form-buscador" action="index.php?categoria=<?php echo $categoria ?>&page=0    " method="POST">
                        <input class="form-control mr-sm-2" type="search" placeholder="Buscar" value="<?php echo isset($_SESSION['busqueda']) ? $_SESSION['busqueda'] : ''?>" name="busqueda" id="busqueda" aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">Buscar</button>
                    </form>
                </div>
            </div>

            <div class="row main">
                <div class="col-md-7 order-2 order-sm-12">      
                    <div class="public-y-paginacion">        
                        <?php if(isset($_SESSION['busqueda']) && $_SESSION['busqueda'] != '' ): ?>
                            <a href="index.php?categoria=todas&page=0&do=borrarBusqueda">       
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    Quitar filtro de búsqueda y categoría
                                    <button onclick="window.location='index.php?categoria=todas&page=0&do=borrarBusqueda'" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div> 
                            </a>
                        <?php endif; ?>       
                        

                        <h1>Publicaciones de candidatos</h1>  
                        <?php     

                        if (isset($cantPublicaciones) && mysqli_num_rows($publicaciones) > 0){

                            $desde = $paginaActual*$publicacionesPorPagina;
                            $desde = (string)$desde;

                            $publicacionesPorPagina = (string)$publicacionesPorPagina;

                            // Traigo las publicaciones corrependientes a la pagina segun el numero
                            // de publicaciones por pagina que tenga
                            $orden=2;
                            include "consultasPublicaciones.php";       

                            if (mysqli_query($conn, $query)){          
                                $result = mysqli_query($conn, $query);

                                echo "<div class='publicaciones'>";

                                while($publicacion = mysqli_fetch_assoc($result)): ?>
                                    <a href="publicacion.php">
                                        <div class="publicacion">
                                            <div class="info" onclick="publicacion.php">
                                                <?php echo "<h4>".$publicacion['titulo']. "</h4><br>"; ?>
                                                <?php echo "<p>".$publicacion['descripcion']. "...</p><br>"; ?>
                                                <?php echo "<p>".$publicacion['categoria']. "</p><br>"; ?>
                                                <?php echo "<p>".$publicacion['fechaPublicacion']. "</p><br>"; ?>
                                            </div>
                                        </div>
                                    </a>
                                    <hr>
                                <?php endwhile; ?>
                                
                                </div>

                                <nav aria-label='Page navigation example'>
                                    <ul class="pagination">
                                        <li class="page-item <?php echo $paginaActual==0 ? ' disabled' : '' ?>"><a class="page-link" href="index.php?categoria=<?php echo ($categoria)?>&page= <?php echo ($paginaActual-1)?>">Anterior</a></li>

                                        <?php for($i=0; $i<$paginas; $i++): ?>

                                            <li class="page-item 
                                            <?php echo $i == $paginaActual ? ' active' : ''?>">
                                                <a class="page-link" href="index.php?categoria=<?php echo ($categoria)?>&page=<?php echo $i ?>"><?php echo ($i+1)?></a>
                                            </li>
                                            
                                        <?php endfor; ?>
                                
                                        <li class="page-item <?php echo $paginaActual==$paginas-1 ? ' disabled' : '' ?>"><a class="page-link" href="index.php?categoria=<?php echo ($categoria)?>&page= <?php echo ($paginaActual+1)?>">Siguiente</a></li>
                                    </ul>
                                </nav>
                            <?php }
                            else{
                                echo "Error updating record: " . mysqli_error($conn);
                            }     
                        }
                        else{
                            if(isset($_SESSION['busqueda']) && $categoria == "todas")
                                echo "No hay publicaciones que coincidan con el término " . $busqueda;
                            else if(isset($_SESSION['busqueda']))
                                echo "No hay publicaciones de la categoria " . $categoria . " que coincidan con el término " . $busqueda;
                            else
                                echo "No hay publicaciones de la categoria " . $categoria;
                        }      
                        ?>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 order-1 order-sm-12 categorias">
                    <?php
                    $categorias = array("Sistemas", "Administración", "Marketing", "Legales", "Diseño");
                    ?>
                    <ul class="list-group">
                        <li class="list-group-item text-light" id="tituloCat">Categorias</li>
                        <?php
                        if($categoria=="todas")
                            echo "<a class='list-group-item active' href=index.php?categoria=todas&page=0>Todas</a>";
                        else
                            echo "<a class='list-group-item' href=index.php?categoria=todas&page=0>Todas</a>";

                        foreach ($categorias as $area){
                            $query = "SELECT * FROM publicacion WHERE categoria = '$area'";
                            $resultado = mysqli_query($conn, $query);

                            if(mysqli_num_rows($resultado) > 0){
                                if($categoria==$area){
                                    echo "<a class='list-group-item active' href=index.php?categoria=".$area."&page=0>".$area."</a>";
                                }
                                else
                                    echo "<a class='list-group-item' href=index.php?categoria=".$area."&page=0>".$area."</a>";   
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