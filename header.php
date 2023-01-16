<?php

if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
    ?>

    <script>
    /* ESTA FUNCIÓN NOS PERMITE CAMBIAR LA POSITION DEL NAV PARA QUE NO DESCUADRE EL ESTILO DE LA PÁGINA*/
        function position_nav(){
            if (document.getElementById("check").checked == true){
                document.getElementById("menu").style.position = 'fixed';
            }else{
                document.getElementById("menu").style.position = "static";
            }
        }
    </script>

    <!--<header id="nav_container" class="nav_container">-->
    <header class="header" id="inicio">
        <nav id="menu">
        <div id="nav" class="nav">        
        <a href="index.php" class="enlace">
            <img src="logo2.png"  class="logo" alt="logo">
        </a>      
        <div id="nav_menu" class="nav_menu">
            <div id="nav_main_menu" class="nav_main_menu">
        <input type="checkbox" id="check" onclick="position_nav()">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
                <ul id="nav_ul" class="nav_ul">
                    <li id="nav_li" class="nav_li">
                        <a id="nav_a" class="nav_a" href="index.php">Home</a>
                    </li>

                    <li id="nav_li" class="nav_li">

                        <a id="nav_a" class="nav_a" href="index.php">Categorías</a>               
                        <ul id="nav_ul_ul">
                            <?php 
                            //QUERY DE LAS CATEGORÍAS ACTIVAS
                            $query = "SELECT * FROM genero ORDER BY genero ASC";
                            $resultado = mysqli_query($con,$query);
                            if(mysqli_num_rows($resultado)!=0){
                                while($fila=mysqli_fetch_array($resultado)){                 
                                    $generoid = $fila['id'];
                                    $genero = $fila['genero'];
                                        echo
                                        '<li id="nav_li_li" class"=nav_li">
                                        <a id="nav_a" class="nav_a" href="peliculas_categoria.php?cat='.$generoid.'">'.$genero.'</a> 
                                        </li>';
                                } 
                            }
                            ?>
                            </ul>
                    </li>

                        <li id="nav_li" class="nav_li">
                            <a id="nav_a" class="nav_a" href="sesion_cerrar.php">Cerrar sesión</a>
                        </li>
                          
                    </ul>                       
                </div>
            </div>
        </nav>
    </header>
    <?php }else{ ?>
    
    <header class="header" id="inicio">
    <nav id="menu">
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <a href="index.php" class="enlace">
            <img src="logo2.png" class="logo" alt="logo">
        </a>      
        <ul class="nav_ul" id="nav_ul">
            <li class="nav_li" id="nav_li"><a class="nav_a" id="nav_a" href="index.php">Home</a></li>
            <li class="nav_li" id="nav_li"><a class="nav_a" id="nav_a" href="login.php">Iniciar sesión</a></li>
            <li class="nav_li" id="nav_li"><a class="nav_a" id="nav_a" href="register.php">Crear usuario</a></li>
        </ul>
    </nav>
    </header>
    <?php }  ?>